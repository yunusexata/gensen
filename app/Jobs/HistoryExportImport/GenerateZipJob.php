<?php

namespace App\Jobs\HistoryExportImport;

use App\Enums\Gensen\GensenAttachmentType;
use App\Enums\Gensen\JobStatus as GensenJobStatus;
use App\Enums\JobStatus;
use App\Events\SeluruhBerkasZipJobStatusUpdated;
use App\Models\GensenForm;
use App\Models\GensenForm\GensenFormAttachment;
use App\Repositories\Gensen\GensenSeluruhBerkasZipJobRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class GenerateZipJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $historyId;
    public $timeout = 3600; // Allow 1 hour for large zips

    public function __construct($historyId)
    {
        $this->historyId = $historyId;
    }

    public function handle()
    {
        $zipJob = GensenSeluruhBerkasZipJobRepository::findBy([
            ['gensen_export_import_history_id', $this->historyId]
        ]);
        if (!$zipJob) return;
        $zip_disk = 'supabase';
        $batchName = 'Berkas_Gensen_' . now()->format('Ymd_His');
        $tempLocalFolder = storage_path("app/temp/staging/{$batchName}");
        $localZipPath = storage_path("app/temp/zips/{$batchName}.zip");

        File::ensureDirectoryExists($tempLocalFolder, 0755, true);
        File::ensureDirectoryExists(dirname($localZipPath), 0755, true);

        try {
            // Update status to processing
            $zipJob->update(['status' => GensenJobStatus::PROCESSING]); // Adjust enum based on your code

            broadcast(
                new SeluruhBerkasZipJobStatusUpdated(
                    $zipJob
                )
            );
            $attachments = GensenFormAttachment::query()
                ->select([
                    'gensen_form_attachments.path',
                    'gensen_form_attachments.disk',
                    'gensen_form_attachments.extension',
                    'gensen_forms.id_customer',
                    'gensen_forms.no_input_jepang',
                    'gensen_forms.nama_lengkap',
                ])
                ->join('gensen_forms', function ($join) {
                    $join->on('gensen_forms.id', '=', 'gensen_form_attachments.gensen_form_id')
                        ->whereNull('gensen_forms.deleted_at');
                })
                ->whereIn('gensen_forms.id_customer', $zipJob->gensenExportImportHistory->customer_ids)
                ->where('gensen_form_attachments.type', GensenAttachmentType::SELURUH_BERKAS)
                ->whereNotNull('gensen_form_attachments.path')
                ->get();
            // 2. Download files to VPS (Streaming)
            foreach ($attachments as $attachment) {

                $disk = Storage::disk($attachment->disk);

                if (! $disk->exists($attachment->path)) {
                    continue;
                }

                $ext = pathinfo($attachment->path, PATHINFO_EXTENSION);

                $safeName = preg_replace(
                    '/[\/\\\\:*?"<>|]/',
                    '_',
                    "{$attachment->no_input_jepang}_{$attachment->nama_lengkap}"
                );

                $localFilePath = $tempLocalFolder . DIRECTORY_SEPARATOR .
                    $safeName . '.' . $ext;

                $read = $disk->readStream($attachment->path);

                $write = fopen($localFilePath, 'wb');

                stream_copy_to_stream($read, $write);

                fclose($read);
                fclose($write);
            }

            // 3. Zip using 7z
            $command = sprintf('7z a -tzip -mx=3 "%s" "%s/*"', $localZipPath, $tempLocalFolder);
            exec($command . ' 2>&1', $output, $result);
            logger([
                '7z_result' => $result,
                '7z_output' => $output,
                'zip_exists' => file_exists($localZipPath),
                'zip_size' => file_exists($localZipPath) ? filesize($localZipPath) : 0,
            ]);

            if ($result !== 0) {
                throw new \Exception("7z failed: " . implode("\n", $output));
            }

            // 4. Move to Supabase (Stream Upload)
            $s3Disk = Storage::disk($zip_disk);
            $s3Path = 'exports/seluruh_berkas_zips/' . basename($localZipPath);
            $zipStream = fopen($localZipPath, 'rb');
            $result = $s3Disk->writeStream($s3Path, $zipStream);
            logger([
                'write_result' => $result,
                'path' => $s3Path,
            ]);
            logger([
                'uploaded' => $s3Disk->exists($s3Path),
                'path' => $s3Path,
            ]);
            if (is_resource($zipStream)) fclose($zipStream);

            // 5. Update DB
            $zipJob->update(['status' => GensenJobStatus::DONE, 'zip_path' => $s3Path, 'zip_disk' => $zip_disk]);

            broadcast(
                new SeluruhBerkasZipJobStatusUpdated(
                    $zipJob
                )
            );
        } catch (\Exception $e) {
            $zipJob->update([
                'status' => GensenJobStatus::FAILED,
                'errors' => $e->getMessage() // Assuming you have an errors column
            ]);
            logger($e->getMessage());
            throw $e;
        } finally {
            // ALWAYS clean up local server files to prevent disk space issues
            if (isset($tempLocalFolder) && is_dir($tempLocalFolder)) {
                File::deleteDirectory($tempLocalFolder);
            }
            if (isset($localZipPath) && file_exists($localZipPath)) {
                unlink($localZipPath);
            }
        }
    }
}
