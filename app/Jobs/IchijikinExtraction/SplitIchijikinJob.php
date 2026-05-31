<?php

namespace App\Jobs\IchijikinExtraction;

use App\Enums\Gensen\GensenAttachmenStatus;
use App\Enums\Gensen\GensenAttachmentType;
use App\Events\ConvertPdfToIMageFinished;
use App\Jobs\GensenExtractJob\ExtractionDocumentJob;
use App\Models\Ai\AiJob;
use App\Models\GensenForm\GensenForm;
use App\Models\Ichijikin\IchijikinExtractionFile;
use App\Repositories\GensenForm\GensenFormAttachmentRepository;
use App\Repositories\IchijikinExtraction\IchijikinExtractionFileRepository;
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

class SplitIchijikinJob implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    public function __construct(
        public $model = null,

    ) {}

    public function handle(): void
    {
        // logger(['Split Ichijikin Job']);

        $attachment = $this->model;
        $tmpDir = "ichijikin/{$attachment->batch_name}";
        $tmpPdfPath = $tmpDir . '/' . basename($attachment->path);
        $local_path = $tmpPdfPath;
        $extension = strtolower(pathinfo($local_path, PATHINFO_EXTENSION));

        if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
            return;
        }
        $this->convertToImage($attachment);
        // event(new ConvertPdfToIMageFinished($this->model->id, $this->model->type->value));
    }

    private function convertToImage($attachment)
    {
        $disk = $attachment->disk;
        $store_disk = env('DEFAULT_STORE_CONVERT', 'private');

        $storage = Storage::disk($disk);

        if (!$storage->exists($attachment->path)) {
            throw new Exception("File missing: {$attachment->path}");
        }


        // $tmpDir = "ichijikin/{$attachment->batch_name}/resource";
        // logger([
        //     'tmp dir 63',
        //     $tmpDir
        // ]);

        // if (!Storage::disk($store_disk)->exists($tmpDir)) {
        //     Storage::disk($store_disk)->makeDirectory($tmpDir);
        // }


        // logger([
        //     'tmp pdf path 75',
        //     $tmpPdfPath
        // ]);
        /*
                |--------------------------------------------------------------------------
                | STREAM DOWNLOAD (Supabase → Local)
                |--------------------------------------------------------------------------
                */
        // $readStream = $storage->readStream($attachment->path);
        // logger([
        //     'content stream att',
        //     stream_get_contents($readStream)
        // ]);

        // if ($readStream === false) {
        //     throw new Exception("Failed to read remote file");
        // }
        // $localPdfPath = storage_path(
        //     'app/' . $store_disk . '/' . $tmpPdfPath
        // );

        // $localDir = dirname($localPdfPath);

        // if (!is_dir($localDir)) {

        //     mkdir(
        //         $localDir,
        //         0755,
        //         true
        //     );
        // }
        // $writeStream = fopen($localPdfPath, 'w');

        // stream_copy_to_stream($readStream, $writeStream);

        // fclose($readStream);
        // fclose($writeStream);
        // $local_path = $tmpPdfPath;

        // $extension = strtolower(pathinfo($local_path, PATHINFO_EXTENSION));

        /*
                |--------------------------------------------------------------------------
                | STEP 4 — Ghostscript Convert
                |--------------------------------------------------------------------------
                */

        $dir = "ichijikin/{$attachment->batch_name}/converted";


        // logger([
        //     'dir convert',
        //     $dir
        // ]);

        if (!Storage::disk($store_disk)->exists($dir)) {
            Storage::disk($store_disk)->makeDirectory($dir);
        }

        $outputDir = storage_path("app/{$store_disk}/{$dir}");

        // $storedName = pathinfo($attachment->stored_name, PATHINFO_FILENAME);
        $outputPattern = storage_path("app/{$store_disk}/{$dir}/%04d.jpg");
        // logger([
        //     'stored output dir 97',
        //     $outputPattern
        // ]);

        // $process = new Process([
        //     // '/usr/local/bin/gs',
        //     'gs',
        //     '-sDEVICE=jpeg',
        //     '-r150',                // 200 DPI is the "Golden Ratio" for OCR/LLM vision
        //     '-dNOPAUSE',
        //     '-dBATCH',
        //     '-dSAFER',
        //     '-dINTERPOLATE',        // Smoother scaling
        //     '-dJPEGQ=80',           // Q=100 is wasteful; 85 is indistinguishable for AI
        //     '-sColorConversionStrategy=Gray', // Strategy: Grayscale (Reduces tokens/noise)
        //     "-sOutputFile={$outputPattern}",
        //     storage_path('app/' . $store_disk . '/' . $tmpPdfPath),
        // ]);
        $tmpPdfPath = $attachment->path;
        $process = new Process([
            'gs',
            '-sDEVICE=jpeggray',
            '-r150',                            // Perfect resolution match (~1240x1754 A4 size)
            '-dNOPAUSE',
            '-dBATCH',
            '-dSAFER',
            '-dINTERPOLATE',                    // High-quality image scaling
            '-dTextAlphaBits=4',                // CRITICAL: Max anti-aliasing for readable fonts/Kanji
            '-dGraphicsAlphaBits=4',            // Max anti-aliasing for clear document lines
            '-dJPEGQ=85',                       // Sweet spot for OCR text retention without compression artifacts
            "-sOutputFile={$outputPattern}",
            storage_path('app/' . $store_disk . '/' . $tmpPdfPath),
        ]);
        // '-dFirstPage=1',        // Secure: Process only what you need

        $process->run();
        // logger([
        //     'successful' => $process->isSuccessful(),
        //     'exit_code' => $process->getExitCode(),
        //     'output' => $process->getOutput(),
        //     'error_output' => $process->getErrorOutput(),
        // ]);

        // logger($process->getCommandLine());

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
            "{$outputDir}/*.jpg"
        );

        logger([
            'get generated file',
            $generatedFiles
        ]);

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

            // logger([
            //     'stored_name',
            //     $storedName,
            // ]);

            // $targetPath = storage_path("app/{$store_disk}/{$dir}/{$storedName}");
            $targetPath = "{$dir}/{$storedName}";

            // =====================================================
            // IMAGE OPTIMIZATION
            // =====================================================
            // logger([
            //     'exists_before_save' => file_exists($file),
            //     'filesize_before_save' => file_exists($file)
            //         ? filesize($file)
            //         : null,
            // ]);
            // try {
            // Image::load($file)

            //     // huge filesize reduction here
            //     // ->width(1240)

            //     // sweet spot for OCR
            //     ->quality(80)

            //     ->optimize()

            //     ->save($file);
            //     if (!file_exists($file)) {

            //         throw new Exception(
            //             "Optimized image missing: {$file}"
            //         );
            //     }
            // } catch (\Throwable $e) {

            //     logger([
            //         'image_optimize_error' => $e->getMessage(),
            //         'file' => $file,
            //     ]);

            //     throw $e;
            // }
            // logger([
            //     'exists_after_save' => file_exists($file),
            //     'filesize_after_save' => file_exists($file)
            //         ? filesize($file)
            //         : null,
            // ]);
            // =====================================================
            // STREAM UPLOAD
            // Best for memory usage
            // =====================================================

            $stream = fopen($file, 'rb');

            // logger([
            //     'final store',
            //     'stream_valid' => is_resource($stream),
            // ]);

            // =====================================================
            // FILESIZE AFTER OPTIMIZATION
            // =====================================================

            $fileSize = filesize($file);

            // =====================================================
            // CREATE DATABASE RECORD
            // =====================================================

            // IchijikinExtractionFileRepository::create([
            //     'ichijikin_extraction_id' => $attachment->id,
            //     'file_stored_name' => $storedName,

            //     'disk' => $store_disk,
            //     'path' => $targetPath,
            //     'extension' => 'jpg',
            //     'mime_type' => 'image/jpeg',
            //     'file_size' => $fileSize,
            // ]);
            IchijikinExtractionFile::firstOrCreate([
                'ichijikin_extraction_id' => $attachment->id,
            ], [
                'ichijikin_extraction_id' => $attachment->id,
                'file_stored_name' => $storedName,

                'disk' => $store_disk,
                'path' => $targetPath,
                'extension' => 'jpg',
                'mime_type' => 'image/jpeg',
                'file_size' => $fileSize,
            ]);

            // logger([
            //     'exists_last_save' => file_exists($file),
            //     'filesize_last_save' => file_exists($file)
            //         ? filesize($file)
            //         : null,
            // ]);
            if (is_resource($stream)) {
                fclose($stream);
            }
        }
    }
}
