<?php

namespace App\Jobs;

use App\Enums\Gensen\GensenAttachmenStatus;
use App\Enums\Gensen\GensenAttachmentType;
use App\Events\ConvertPdfToIMageFinished;
use App\Helpers\AppLog;
use App\Jobs\GensenExtractJob\ExtractionDocumentJob;
use App\Models\Ai\AiJob;
use App\Repositories\GensenForm\GensenFormAttachmentRepository;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Spatie\Image\Image;
use Symfony\Component\Process\Process;

class ConvertPdfToImagesJob implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    public function __construct(
        public String $type,
        public $model = null,

    ) {}

    public function handle(): void
    {
        AppLog::info(
            'Convert to Image Job',
            'job_convert_pdf_to_image',
            [
                'id' => $this->model->id,
                'type' => $this->type,
            ],
            []
        );
        if ($this->type == AiJob::class) {

            $attachments = $this->model->subject->attachmentsToConvert;

            foreach ($attachments as $attachment) {
                $tmpDir = "gensen/{$this->model->subject->id}/convert_{$attachment->type->value}";
                $tmpPdfPath = $tmpDir . '/' . basename($attachment->path);
                $local_path = $tmpPdfPath;
                $extension = strtolower(pathinfo($local_path, PATHINFO_EXTENSION));

                if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
                    continue;
                }
                $this->convertToImage($attachment);
            }

            /*
            |--------------------------------------------------------------------------
            | NEXT JOB
            |--------------------------------------------------------------------------
            */

            ExtractionDocumentJob::dispatch($this->model);
        } else {
            $attachment = $this->model;
            $tmpDir = "gensen/{$attachment->gensen_form_id}/convert_{$attachment->type->value}";
            $tmpPdfPath = $tmpDir . '/' . basename($attachment->path);
            $local_path = $tmpPdfPath;
            $extension = strtolower(pathinfo($local_path, PATHINFO_EXTENSION));

            if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
                return;
            }
            $this->convertToImage($attachment);
            event(new ConvertPdfToIMageFinished($this->model->gensen_form_id, $this->model->type->value));
        }
    }

    private function convertToImage($attachment)
    {
        $disk = $attachment->disk;
        $store_disk = env('DEFAULT_STORE_CONVERT', 'private');

        $storage = Storage::disk($disk);

        if (!$storage->exists($attachment->path)) {
            throw new Exception("File missing: {$attachment->path}");
        }


        $tmpDir = $this->type == AiJob::class ? "gensen/{$this->model->subject->id}/convert_{$attachment->type->value}"
            : "gensen/{$attachment->gensen_form_id}/convert_{$attachment->type->value}";

        if (!Storage::disk($store_disk)->exists($tmpDir)) {
            Storage::disk($store_disk)->makeDirectory($tmpDir);
        }

        $tmpPdfPath = $tmpDir . '/' . basename($attachment->path);
        /*
        |--------------------------------------------------------------------------
        | STREAM DOWNLOAD (Supabase → Local)
        |--------------------------------------------------------------------------
        */
        $readStream = $storage->readStream($attachment->path);

        if ($readStream === false) {
            throw new Exception("Failed to read remote file");
        }
        $localPdfPath = storage_path(
            'app/' . $store_disk . '/' . $tmpPdfPath
        );

        $localDir = dirname($localPdfPath);

        if (!is_dir($localDir)) {

            mkdir(
                $localDir,
                0755,
                true
            );
        }
        $writeStream = fopen($localPdfPath, 'w');

        stream_copy_to_stream($readStream, $writeStream);

        fclose($readStream);
        fclose($writeStream);
        $local_path = $tmpPdfPath;

        $extension = strtolower(pathinfo($local_path, PATHINFO_EXTENSION));

        /*
        |--------------------------------------------------------------------------
        | STEP 4 — Ghostscript Convert
        |--------------------------------------------------------------------------
        */

        $dir = $this->type == AiJob::class ? "gensen/{$this->model->subject->id}/convert_{$attachment->type->value}"
            : "gensen/{$attachment->gensen_form_id}/convert_{$attachment->type->value}";

        if (!Storage::disk($store_disk)->exists($dir)) {
            Storage::disk($store_disk)->makeDirectory($dir);
        }

        $outputDir = storage_path("app/{$store_disk}/{$dir}");

        $storedName = pathinfo($attachment->stored_name, PATHINFO_FILENAME);
        $outputPattern = storage_path("app/{$store_disk}/{$dir}/{$storedName}_page-%03d.jpg");
        $process = new Process([
            'gs',
            '-sDEVICE=jpeg',
            '-r200',                  // 200 DPI is great
            '-dNOPAUSE',
            '-dBATCH',
            '-dSAFER',
            '-dTextAlphaBits=4',      // FORCED: Improves text rendering/anti-aliasing
            '-dGraphicsAlphaBits=4',  // FORCED: Smooths out vector graphics
            '-dJPEGQ=85',
            // REMOVED: -sColorConversionStrategy=Gray (This was dropping your text layer)
            "-sOutputFile={$outputPattern}",
            storage_path('app/' . $store_disk . '/' . $tmpPdfPath),
        ]);
        // '-dFirstPage=1',        // Secure: Process only what you need

        $process->run();

        AppLog::info(
            'Process Convert by Ghostscript',
            'job_convert_pdf_to_image',
            [],
            [
                'successful' => $process->isSuccessful(),
                'exit_code' => $process->getExitCode(),
                'output' => $process->getOutput(),
                'error_output' => $process->getErrorOutput()
            ],
            'validation_document' // <--- Parameter ke-6: Nama Channel
        );

        if (!$process->isSuccessful()) {
            AppLog::error(
                'Gagal melakukan Convert by Ghostscript',
                'job_convert_pdf_to_image',
                [],
                [
                    'error_message' => $process->getErrorOutput(),
                ],
                null,
            );
            throw new \Exception(
                'PDF conversion failed: ' . $process->getErrorOutput()
            );
        }

        /*
                |--------------------------------------------------------------------------
                | STEP 5 — Collect Generated Images
                |--------------------------------------------------------------------------
                */

        $generatedFiles = glob(
            "{$outputDir}/{$storedName}_page-*.jpg"
        );

        if ($attachment->type !== GensenAttachmentType::REKAP_PENGIRIMAN_UANG) {
            GensenFormAttachmentRepository::update($attachment->id, [
                'convert_image' => true
            ]);
        }

        /*
                |--------------------------------------------------------------------------
                | STEP 6 — Upload BACK to STORAGE (SUPABASE OR LOCAL)
                |--------------------------------------------------------------------------
                */

        sort($generatedFiles);
        // DB::beginTransaction();

        foreach ($generatedFiles as $index => $file) {

            // =====================================================
            // FILE INFO
            // =====================================================

            $info = pathinfo($file);

            // safer filename
            $storedName =
                $info['filename'] . '.jpg';

            // $targetPath = storage_path("app/{$store_disk}/{$dir}/{$storedName}");
            $targetPath = "{$dir}/{$storedName}";

            // =====================================================
            // IMAGE OPTIMIZATION
            // =====================================================

            try {
                Image::load($file)

                    // huge filesize reduction here
                    ->width(1600)

                    // sweet spot for OCR
                    ->quality(80)

                    ->optimize()

                    ->save($file);
                if (!file_exists($file)) {

                    throw new Exception(
                        "Optimized image missing: {$file}"
                    );
                }
            } catch (\Throwable $e) {

                AppLog::error(
                    'Gagal melakukan optimimasi Image',
                    'job_convert_pdf_to_image',
                    [],
                    [
                        'file' => $file
                    ],
                    $e,
                    'gemini' // <--- Parameter ke-6: Nama Channel
                );

                throw $e;
            }
            // =====================================================
            // STREAM UPLOAD
            // Best for memory usage
            // =====================================================

            $stream = fopen($file, 'rb');

            // =====================================================
            // FILESIZE AFTER OPTIMIZATION
            // =====================================================

            $fileSize = filesize($file);

            // =====================================================
            // CREATE DATABASE RECORD
            // =====================================================

            $gensen_form_id =
                $this->type === AiJob::class
                ? $this->model->subject->id
                : $attachment->gensen_form_id;

            GensenFormAttachmentRepository::create([

                'gensen_form_id' => $gensen_form_id,

                'type' => $attachment->type,

                'original_name' =>
                $attachment->original_name,

                'stored_name' => $storedName,

                'description' =>
                $attachment->description,

                'disk' => $store_disk,

                'path' => $targetPath,

                'checksum' =>
                hash_file('sha256', $file),

                'note' => $attachment->note,

                'remittance_type' =>
                $attachment->remittance_type,

                'extension' => 'jpg',

                'mime_type' => 'image/jpeg',

                'file_size' => $fileSize,

                'status' => $this->type === AiJob::class
                    ? GensenAttachmenStatus::STATUS_CONVERTED
                    : GensenAttachmenStatus::STATUS_STORED,

                'convert_image' => true,
            ]);

            AppLog::info(
                'Success Convert Pdf to Image by Ghostscript',
                'job_convert_pdf_to_image',
                [],
                [
                    'exists_lst_save' => file_exists($file),
                    'filesize_last_save' => file_exists($file) ? filesize($file) : null,
                ],
            );
            if (is_resource($stream)) {
                fclose($stream);
            }
        }
    }
}
