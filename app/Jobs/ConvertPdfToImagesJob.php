<?php

namespace App\Jobs;

use App\Enums\Gensen\GensenAttachmenStatus;
use App\Enums\Gensen\GensenAttachmentType;
use App\Jobs\GensenExtractJob\ExtractionDocumentJob;
use App\Models\Ai\AiJob;
use App\Models\GensenForm\GensenForm;
use App\Repositories\GensenForm\GensenFormAttachmentRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

class ConvertPdfToImagesJob implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    public function __construct(
        public AiJob $ai_job
    ) {}

    public function handle(): void
    {
        $attachments = $this->ai_job->subject->attachmentsToConvert;

        foreach ($attachments as $attachment) {

            /*
        |--------------------------------------------------------------------------
        | STEP 1 — Prepare LOCAL SOURCE FILE
        |--------------------------------------------------------------------------
        */

            $disk = $attachment->disk;
            $relativePath = $attachment->path;

            $storage = Storage::disk($disk);

            // temp working directory
            $workingDir = storage_path(
                'app/tmp/' . Str::uuid()
            );

            if (!is_dir($workingDir)) {
                mkdir($workingDir, 0777, true);
            }

            // local temporary file
            $localSourcePath = $workingDir . '/' . basename($relativePath);

            /**
             * LOCAL disk
             */
            if (method_exists($storage, 'path') && $storage->exists($relativePath)) {

                try {
                    $localSourcePath = $storage->path($relativePath);
                } catch (\Throwable $e) {

                    /**
                     * REMOTE DISK (Supabase S3)
                     */
                    file_put_contents(
                        $localSourcePath,
                        $storage->get($relativePath)
                    );
                }
            }

            logger([
                'source_file' => $localSourcePath,
                'disk' => $disk,
            ]);

            /*
        |--------------------------------------------------------------------------
        | STEP 2 — Prepare OUTPUT DIRECTORY
        |--------------------------------------------------------------------------
        */

            $dir = "gensen/{$this->ai_job->subject->id}/convert_{$attachment->type->value}/" . Str::random(6);

            $outputDir = storage_path("app/tmp/{$dir}");

            if (!is_dir($outputDir)) {
                mkdir($outputDir, 0777, true);
            }

            $storedName = pathinfo($attachment->stored_name, PATHINFO_FILENAME);

            $outputPattern = "{$outputDir}/{$storedName}_page-%03d.jpg";

            /*
        |--------------------------------------------------------------------------
        | STEP 3 — Skip if already image
        |--------------------------------------------------------------------------
        */

            $extension = strtolower(pathinfo($localSourcePath, PATHINFO_EXTENSION));

            if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
                continue;
            }

            /*
        |--------------------------------------------------------------------------
        | STEP 4 — Ghostscript Convert
        |--------------------------------------------------------------------------
        */
            $outputPattern = "{$outputDir}/{$storedName}_page-%03d.jpg";

            $process = new Process([
                'gs', // IMPORTANT
                '-sDEVICE=jpeg',
                '-r200',
                '-dNOPAUSE',
                '-dBATCH',
                '-dSAFER',
                '-dFirstPage=1',
                '-dINTERPOLATE',
                '-dJPEGQ=85',
                '-sColorConversionStrategy=Gray',
                '-sOutputFile',
                $outputPattern,
                $localSourcePath,
            ]);
            $process->run();

            logger($process->getCommandLine());

            if (!$process->isSuccessful()) {
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

            foreach ($generatedFiles as $file) {

                $info = pathinfo($file);
                $stored_name = $info['filename'] . '.' . $info['extension'];

                $targetPath = "{$dir}/{$stored_name}";

                /**
                 * Upload using SAME disk as original
                 */
                Storage::disk($disk)->put(
                    $targetPath,
                    fopen($file, 'r')
                );

                GensenFormAttachmentRepository::create([
                    'gensen_form_id' => $this->ai_job->subject->id,
                    'type' => $attachment->type,
                    'original_name' => $attachment->original_name,
                    'stored_name' => $stored_name,
                    'description' => $attachment->description,

                    'disk' => $disk,
                    'path' => $targetPath,

                    'checksum' => hash_file('sha256', $file),

                    'note' => $attachment->note,
                    'remittance_type' => $attachment->remittance_type,

                    'extension' => 'jpg',
                    'mime_type' => 'image/jpeg',
                    'file_size' => filesize($file),

                    'status' => GensenAttachmenStatus::STATUS_CONVERTED,
                    'convert_image' => true,
                ]);
            }

            /*
        |--------------------------------------------------------------------------
        | STEP 7 — CLEAN TEMP FILES (VERY IMPORTANT)
        |--------------------------------------------------------------------------
        */

            collect(glob("{$workingDir}/*"))->each(fn($f) => @unlink($f));
            @rmdir($workingDir);

            collect(glob("{$outputDir}/*"))->each(fn($f) => @unlink($f));
            @rmdir($outputDir);
        }

        /*
    |--------------------------------------------------------------------------
    | NEXT JOB
    |--------------------------------------------------------------------------
    */

        ExtractionDocumentJob::dispatch($this->ai_job);
    }
    public function handleOld(): void
    {
        $attachments = $this->ai_job->subject->attachmentsToConvert;
        $imagePaths = [];
        foreach ($attachments as $attachment) {

            $pdfPath = Storage::disk($attachment['disk'])->path($attachment['path']);

            $dir = "gensen/{$this->ai_job->subject->id}/convert_{$attachment->type->value}/" . Str::random(6);
            logger([
                'dir',
                $dir
            ]);
            $outputDir = storage_path(
                "app/private/" . $dir
            );

            if (!is_dir($outputDir)) {
                mkdir($outputDir, 0777, true);
            }

            $storedName = pathinfo($attachment->stored_name, PATHINFO_FILENAME);

            $outputPattern = "{$outputDir}/{$storedName}_page-%03d.jpg";
            logger([
                'dir pattern',
                $outputPattern
            ]);
            // 1. Cek ekstensi file input
            $extension = strtolower(pathinfo($pdfPath, PATHINFO_EXTENSION));

            // 2. Jika file sudah berupa gambar, langsung lewatkan proses konversi
            if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
                // Logika: Langsung gunakan file asli atau copy ke folder output pattern
                // Karena Gemini bisa membaca gambar langsung, Anda hemat resource server.
                continue;
            }
            $process = new Process([
                // '/usr/local/bin/gs',
                'gs',
                '-sDEVICE=jpeg',
                '-r200',                // 200 DPI is the "Golden Ratio" for OCR/LLM vision
                '-dNOPAUSE',
                '-dBATCH',
                '-dSAFER',
                '-dFirstPage=1',        // Secure: Process only what you need
                '-dINTERPOLATE',        // Smoother scaling
                '-dJPEGQ=85',           // Q=100 is wasteful; 85 is indistinguishable for AI
                '-sColorConversionStrategy=Gray', // Strategy: Grayscale (Reduces tokens/noise)
                "-sOutputFile={$outputPattern}",
                $pdfPath,
            ]);

            $process->run();
            logger($process->getCommandLine());

            if (!$process->isSuccessful()) {
                // throw new \Exception('PDF conversion failed');
                throw new \Exception('PDF conversion failed: ' . $process->getErrorOutput());
            }

            /*
            |--------------------------------------------------------------------------
            | IMPORTANT FIX
            |--------------------------------------------------------------------------
            | Only grab files generated by THIS attachment
            */

            $generatedFiles = glob(
                "{$outputDir}/{$storedName}_page-*.jpg"
            );

            if ($attachment->type !== GensenAttachmentType::REKAP_PENGIRIMAN_UANG) {
                GensenFormAttachmentRepository::update($attachment['id'], [
                    'convert_image' => true
                ]);
            }


            foreach ($generatedFiles as $file) {

                $info = pathinfo($file);

                $stored_name = $info['filename'] . '.' . $info['extension'];

                GensenFormAttachmentRepository::create([
                    'gensen_form_id' => $this->ai_job->subject->id,
                    'type' => $attachment['type'],
                    'original_name' => $attachment['original_name'],
                    'stored_name' => $stored_name,
                    'description' => $attachment['description'],

                    'disk' => 'private',
                    'path' => "{$dir}/{$stored_name}",

                    'checksum' => hash_file('sha256', $file),

                    'note' => $attachment['note'],
                    'remittance_type' => $attachment['remittance_type'],

                    'extension' => 'jpg',
                    'mime_type' => 'image/jpeg',
                    'file_size' => filesize($file),

                    'status' => GensenAttachmenStatus::STATUS_CONVERTED,
                    'convert_image' => true
                ]);
            }
        }

        /**
         * Save processed images into AiJob (or relation table)
         */
        // $this->gensen_form->update([
        //     'status' => 'converted',
        //     'meta' => [
        //         'image_paths' => $imagePaths,
        //     ],
        // ]);

        /**
         * NEXT STEP → extraction job
         */
        ExtractionDocumentJob::dispatch($this->ai_job);
    }
}
