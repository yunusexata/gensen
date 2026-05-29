<?php

namespace App\Jobs;

use App\Enums\Gensen\GensenAttachmenStatus;
use App\Enums\Gensen\GensenAttachmentType;
use App\Events\ConvertPdfToIMageFinished;
use App\Jobs\GensenExtractJob\ExtractionDocumentJob;
use App\Models\Ai\AiJob;
use App\Models\GensenForm\GensenForm;
use App\Repositories\GensenForm\GensenFormAttachmentRepository;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\Image\Image;
use Spatie\ImageOptimizer\OptimizerChainFactory;
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
        logger(['convert to image Job', $this->type]);
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

        logger([
            'tmp dir 45',
            $tmpDir
        ]);

        if (!Storage::disk($store_disk)->exists($tmpDir)) {
            Storage::disk($store_disk)->makeDirectory($tmpDir);
        }

        $tmpPdfPath = $tmpDir . '/' . basename($attachment->path);


        logger([
            'tmp pdf path 56',
            $tmpPdfPath
        ]);
        /*
                |--------------------------------------------------------------------------
                | STREAM DOWNLOAD (Supabase → Local)
                |--------------------------------------------------------------------------
                */
        $readStream = $storage->readStream($attachment->path);
        // logger([
        //     'content stream att',
        //     stream_get_contents($readStream)
        // ]);

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


        logger([
            'dir convert',
            $dir
        ]);

        if (!Storage::disk($store_disk)->exists($dir)) {
            Storage::disk($store_disk)->makeDirectory($dir);
        }

        $outputDir = storage_path("app/{$store_disk}/{$dir}");

        $storedName = pathinfo($attachment->stored_name, PATHINFO_FILENAME);
        $outputPattern = storage_path("app/{$store_disk}/{$dir}/{$storedName}_page-%03d.jpg");

        logger([
            'stored name 97',
            $storedName
        ]);
        logger([
            'stored output dir 97',
            $outputPattern
        ]);

        $process = new Process([
            // '/usr/local/bin/gs',
            'gs',
            '-sDEVICE=jpeg',
            '-r200',                // 200 DPI is the "Golden Ratio" for OCR/LLM vision
            '-dNOPAUSE',
            '-dBATCH',
            '-dSAFER',
            '-dINTERPOLATE',        // Smoother scaling
            '-dJPEGQ=85',           // Q=100 is wasteful; 85 is indistinguishable for AI
            '-sColorConversionStrategy=Gray', // Strategy: Grayscale (Reduces tokens/noise)
            "-sOutputFile={$outputPattern}",
            storage_path('app/' . $store_disk . '/' . $tmpPdfPath),
        ]);
        // '-dFirstPage=1',        // Secure: Process only what you need

        $process->run();
        logger([
            'successful' => $process->isSuccessful(),
            'exit_code' => $process->getExitCode(),
            'output' => $process->getOutput(),
            'error_output' => $process->getErrorOutput(),
        ]);

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

        logger([
            'get generated file',
            $generatedFiles
        ]);

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

        // $optimizerChain = OptimizerChainFactory::create()
        //     ->setTimeout(60);


        // DB::beginTransaction();

        foreach ($generatedFiles as $index => $file) {

            // =====================================================
            // FILE INFO
            // =====================================================

            $info = pathinfo($file);

            // safer filename
            $storedName =
                $info['filename'] . '.jpg';

            logger([
                'stored_name',
                $storedName,
            ]);

            // $targetPath = storage_path("app/{$store_disk}/{$dir}/{$storedName}");
            $targetPath = "{$dir}/{$storedName}";

            // =====================================================
            // IMAGE OPTIMIZATION
            // =====================================================
            logger([
                'exists_before_save' => file_exists($file),
                'filesize_before_save' => file_exists($file)
                    ? filesize($file)
                    : null,
            ]);
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

                logger([
                    'image_optimize_error' => $e->getMessage(),
                    'file' => $file,
                ]);

                throw $e;
            }
            logger([
                'exists_after_save' => file_exists($file),
                'filesize_after_save' => file_exists($file)
                    ? filesize($file)
                    : null,
            ]);
            // =====================================================
            // SECOND PASS OPTIMIZATION
            // =====================================================
            // try {
            //     $optimizerChain->optimize($file);
            // } catch (\Throwable $e) {

            //     logger([
            //         'optimizer_chain_error' => $e->getMessage(),
            //         'file' => $file,
            //     ]);

            //     throw $e;
            // }
            // =====================================================
            // STREAM UPLOAD
            // Best for memory usage
            // =====================================================

            $stream = fopen($file, 'rb');

            logger([
                'final store',
                'stream_valid' => is_resource($stream),
            ]);
            $result = Storage::disk($store_disk)->put(
                $targetPath,
                $stream,
                [
                    'visibility' => 'public',
                    'ContentType' => 'image/jpeg',
                ]
            );
            logger([
                'upload_result' => $result,
                'exists_after_upload' => Storage::disk($store_disk)
                    ->exists($targetPath),
                'target_path' => $targetPath,
                'real_path' => Storage::disk($store_disk)
                    ->path($targetPath),
            ]);


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

                'status' =>
                GensenAttachmenStatus::STATUS_CONVERTED,

                'convert_image' => true,

                // useful for sorting later
                // 'page' => $index + 1,
            ]);

            if (is_resource($stream)) {
                fclose($stream);
            }
            // =====================================================
            // CLEANUP TEMP FILE
            // VERY IMPORTANT
            // =====================================================
        }

        // DB::commit();
        // foreach ($generatedFiles as $file) {

        //     $info = pathinfo($file);
        //     $stored_name = $info['filename'] . '.' . $info['extension'];


        //     logger([
        //         'stored name 155',
        //         $stored_name
        //     ]);
        //     $targetPath = "{$dir}/{$stored_name}";

        //     /**
        //      * Upload using SAME disk as original
        //      */
        //     // Storage::disk($disk)->put(
        //     //     $targetPath,
        //     //     fopen($file, 'r')
        //     // );

        //     // Storage::disk($disk)->putFileAs(
        //     //     dirname($targetPath),
        //     //     new File($file),
        //     //     basename($targetPath)
        //     // );
        //     // Storage::disk($disk)->put(
        //     //     $targetPath,
        //     //     fopen($file, 'r'),
        //     //     [
        //     //         'visibility' => 'private', // or 'public'
        //     //     ]
        //     // );

        //     $gensen_form_id = $this->type == AiJob::class ? $this->model->subject->id : $attachment->gensen_form_id;
        //     GensenFormAttachmentRepository::create([
        //         'gensen_form_id' => $gensen_form_id,
        //         'type' => $attachment->type,
        //         'original_name' => $attachment->original_name,
        //         'stored_name' => $stored_name,
        //         'description' => $attachment->description,

        //         'disk' => $store_disk,
        //         'path' => $targetPath,

        //         'checksum' => hash_file('sha256', $file),

        //         'note' => $attachment->note,
        //         'remittance_type' => $attachment->remittance_type,

        //         'extension' => 'jpg',
        //         'mime_type' => 'image/jpeg',
        //         'file_size' => filesize($file),

        //         'status' => GensenAttachmenStatus::STATUS_CONVERTED,
        //         'convert_image' => true,
        //     ]);
        // }
        // TemporaryFile::cleanup($tmpPdfPath);

        // public function handleOld(): void
        // {
        //     $attachments = $this->ai_job->subject->attachmentsToConvert;
        //     $imagePaths = [];
        //     foreach ($attachments as $attachment) {

        //         $pdfPath = Storage::disk($attachment['disk'])->path($attachment['path']);

        //         $dir = "gensen/{$this->ai_job->subject->id}/convert_{$attachment->type->value}/" . Str::random(6);
        //         logger([
        //             'dir',
        //             $dir
        //         ]);
        //         $outputDir = storage_path(
        //             "app/private/" . $dir
        //         );

        //         if (!is_dir($outputDir)) {
        //             mkdir($outputDir, 0777, true);
        //         }

        //         $storedName = pathinfo($attachment->stored_name, PATHINFO_FILENAME);

        //         $outputPattern = "{$outputDir}/{$storedName}_page-%03d.jpg";
        //         logger([
        //             'dir pattern',
        //             $outputPattern
        //         ]);
        //         // 1. Cek ekstensi file input
        //         $extension = strtolower(pathinfo($pdfPath, PATHINFO_EXTENSION));

        //         // 2. Jika file sudah berupa gambar, langsung lewatkan proses konversi
        //         if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
        //             // Logika: Langsung gunakan file asli atau copy ke folder output pattern
        //             // Karena Gemini bisa membaca gambar langsung, Anda hemat resource server.
        //             continue;
        //         }
        //         $process = new Process([
        //             // '/usr/local/bin/gs',
        //             'gs',
        //             '-sDEVICE=jpeg',
        //             '-r200',                // 200 DPI is the "Golden Ratio" for OCR/LLM vision
        //             '-dNOPAUSE',
        //             '-dBATCH',
        //             '-dSAFER',
        //             '-dFirstPage=1',        // Secure: Process only what you need
        //             '-dINTERPOLATE',        // Smoother scaling
        //             '-dJPEGQ=85',           // Q=100 is wasteful; 85 is indistinguishable for AI
        //             '-sColorConversionStrategy=Gray', // Strategy: Grayscale (Reduces tokens/noise)
        //             "-sOutputFile={$outputPattern}",
        //             $pdfPath,
        //         ]);

        //         $process->run();
        //         logger($process->getCommandLine());

        //         if (!$process->isSuccessful()) {
        //             // throw new \Exception('PDF conversion failed');
        //             throw new \Exception('PDF conversion failed: ' . $process->getErrorOutput());
        //         }

        //         /*
        //         |--------------------------------------------------------------------------
        //         | IMPORTANT FIX
        //         |--------------------------------------------------------------------------
        //         | Only grab files generated by THIS attachment
        //         */

        //         $generatedFiles = glob(
        //             "{$outputDir}/{$storedName}_page-*.jpg"
        //         );

        //         if ($attachment->type !== GensenAttachmentType::REKAP_PENGIRIMAN_UANG) {
        //             GensenFormAttachmentRepository::update($attachment['id'], [
        //                 'convert_image' => true
        //             ]);
        //         }


        //         foreach ($generatedFiles as $file) {

        //             $info = pathinfo($file);

        //             $stored_name = $info['filename'] . '.' . $info['extension'];

        //             GensenFormAttachmentRepository::create([
        //                 'gensen_form_id' => $this->ai_job->subject->id,
        //                 'type' => $attachment['type'],
        //                 'original_name' => $attachment['original_name'],
        //                 'stored_name' => $stored_name,
        //                 'description' => $attachment['description'],

        //                 'disk' => 'private',
        //                 'path' => "{$dir}/{$stored_name}",

        //                 'checksum' => hash_file('sha256', $file),

        //                 'note' => $attachment['note'],
        //                 'remittance_type' => $attachment['remittance_type'],

        //                 'extension' => 'jpg',
        //                 'mime_type' => 'image/jpeg',
        //                 'file_size' => filesize($file),

        //                 'status' => GensenAttachmenStatus::STATUS_CONVERTED,
        //                 'convert_image' => true
        //             ]);
        //         }
        //     }

        //     /**
        //      * Save processed images into AiJob (or relation table)
        //      */
        //     // $this->gensen_form->update([
        //     //     'status' => 'converted',
        //     //     'meta' => [
        //     //         'image_paths' => $imagePaths,
        //     //     ],
        //     // ]);

        //     /**
        //      * NEXT STEP → extraction job
        //      */
        //     ExtractionDocumentJob::dispatch($this->ai_job);
    }
}
