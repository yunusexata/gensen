<?php

namespace App\Jobs\IchijikinExtraction;

use App\Enums\Gensen\GensenAttachmenStatus;
use App\Enums\Gensen\GensenAttachmentType;
use App\Events\ConvertPdfToIMageFinished;
use App\Jobs\GensenExtractJob\ExtractionDocumentJob;
use App\Models\Ai\AiJob;
use App\Models\GensenForm\GensenForm;
use App\Models\Ichijikin\IchijikinExtractionDetail;
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
        public IchijikinExtractionDetail $model,

    ) {}

    public function handle(): void
    {
        // logger(['Split Ichijikin Job']);

        $attachment = $this->model;

        if (in_array($attachment->mime_type, ['image/jpeg', 'image/png', 'image/gif', 'image/webp'])) {
            return;
        }
        $this->convertToImage($attachment);
        // event(new ConvertPdfToIMageFinished($this->model->id, $this->model->type->value));
    }

    private function convertToImage($attachment)
    {
        $disk = $attachment->disk;
        $store_disk = env('DEFAULT_STORE_CONVERT', 'public');

        $storage = Storage::disk($disk);

        if (!$storage->exists($attachment->path)) {
            throw new Exception("File missing: {$attachment->path}");
        }

        $dir = "ichijikin/{$attachment->ichijikin->batch_name}/{$attachment->stored_name}/converted";

        if (!Storage::disk($store_disk)->exists($dir)) {
            Storage::disk($store_disk)->makeDirectory($dir);
        }

        $outputDir = storage_path("app/{$store_disk}/{$dir}");

        // $storedName = pathinfo($attachment->stored_name, PATHINFO_FILENAME);
        $outputPattern = storage_path("app/{$store_disk}/{$dir}/{$attachment->stored_name}_%04d.jpg");

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
            "{$outputDir}/{$attachment->stored_name}_*.jpg"
        );

        /*
                |--------------------------------------------------------------------------
                | STEP 6 — Upload BACK to STORAGE (SUPABASE OR LOCAL)
                |--------------------------------------------------------------------------
                */

        sort($generatedFiles);

        foreach ($generatedFiles as $index => $file) {

            // =====================================================
            // FILE INFO
            // =====================================================

            $info = pathinfo($file);

            // safer filename
            $storedName =
                $info['filename'] . '.jpg';
            $targetPath = "{$dir}/{$storedName}";

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

            IchijikinExtractionFileRepository::create([
                'ichijikin_extraction_id' => $attachment->ichijikin_extraction_id,
                'ichijikin_extraction_detail_id' => $attachment->id,
                'file_stored_name' => $storedName,

                'disk' => $store_disk,
                'path' => $targetPath,
                'extension' => 'jpg',
                'mime_type' => 'image/jpeg',
                'file_size' => $fileSize,
            ]);

            if (is_resource($stream)) {
                fclose($stream);
            }
        }
    }
}
