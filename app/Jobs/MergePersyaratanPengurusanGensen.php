<?php

namespace App\Jobs;

use App\Enums\Gensen\GensenAttachmentType;
use App\Enums\Gensen\JobStatus;
use App\Helpers\AppLog;
use App\Models\GensenForm\GensenForm;
use App\Models\GensenForm\PersyaratanGensenJob;
use App\Services\GensenAttachmentService;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;


class MergePersyaratanPengurusanGensen implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $processId;
    public $gensenFormId;
    /**
     * Create a new job instance.
     */
    public function __construct($processId, $gensenFormId)
    {
        $this->processId = $processId;
        $this->gensenFormId = $gensenFormId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $process = PersyaratanGensenJob::findOrFail($this->processId);

        $process->update([
            'status' => JobStatus::PROCESSING,
            'started_at' => now(),
        ]);
        try {
            $type = GensenAttachmentType::PERSYARATAN_PENGURUSAN_GENSEN->value;
            $relativePath =
                "gensen/{$this->gensenFormId}/{$type}/" . Str::uuid() . '.pdf';

            /*
            |--------------------------------------------------------------------------
            | 1️⃣ Create merged image FIRST
            |--------------------------------------------------------------------------
            */

            $fullPath = Storage::disk('private')->path($relativePath);

            // ensure directory exists
            if (!file_exists(dirname($fullPath))) {
                mkdir(dirname($fullPath), 0755, true);
            }

            $gensen = GensenForm::with([
                'attachments' => fn($q) =>
                $q->whereIn('type', [
                    GensenAttachmentType::ZAIRYOU_CARD_FRONT->value,
                    GensenAttachmentType::ZAIRYOU_CARD_BACK->value,
                    GensenAttachmentType::MY_NUMBER_FRONT->value,
                    GensenAttachmentType::MY_NUMBER_BACK->value,
                    GensenAttachmentType::REKENING_INDONESIA->value,
                ])
            ])->findOrFail($this->gensenFormId);

            $files = $gensen->attachments
                ->keyBy(fn($item) => $item->type->value);
            $this->merge(
                $this->attachmentPath($files, GensenAttachmentType::ZAIRYOU_CARD_FRONT),
                $this->attachmentPath($files, GensenAttachmentType::ZAIRYOU_CARD_BACK),
                $this->attachmentPath($files, GensenAttachmentType::MY_NUMBER_FRONT),
                $this->attachmentPath($files, GensenAttachmentType::MY_NUMBER_BACK),
                $this->attachmentPath($files, GensenAttachmentType::REKENING_INDONESIA),
                $fullPath
            );

            /*
        |--------------------------------------------------------------------------
        | 2️⃣ AFTER FILE EXISTS → save metadata
        |--------------------------------------------------------------------------
        */

            app(GensenAttachmentService::class)->storeGenerated(
                $this->gensenFormId,
                $relativePath,
                GensenAttachmentType::PERSYARATAN_PENGURUSAN_GENSEN
            );

            $process->update([
                'status' => JobStatus::DONE,
                'finished_at' => now(),
            ]);
            AppLog::info(
                'Success Merge Perssyaratan Gensen',
                'merge_persyaratan_gensen',
                [],
                [
                    'persyaratan_gensen_job_id' => $process->id,
                    'status' => JobStatus::DONE,
                ],
            );
            $gensen->handleMergeSeluruhBerkas();
        } catch (\Throwable $e) {
            AppLog::error(
                'Gagal Merge Persyaratan Gensen',
                'merge_persyaratan_gensen',
                [],
                [
                    'persyaratan_gensen_job_id' => $this->processId,
                ],
                $e,
                'document_validation'
            );
            $process->update([
                'status' => JobStatus::FAILED,
                'error_message' => $e->getMessage(),
            ]);

            throw $e; // allow queue retry
        }
    }

    public function failed(?Throwable $e): void
    {

        AppLog::error(
            'Gagal Merge Persyaratan Gensen',
            'merge_persyaratan_gensen',
            [],
            [
                'persyaratan_gensen_job_id' => $this->processId,
            ],
            $e,
            'document_validation'
        );
        $process = PersyaratanGensenJob::findOrFail($this->processId);
        $process->update([
            'status' => JobStatus::FAILED,
            'error_message' => $e->getMessage(),
        ]);
    }

    private function attachmentPath($files, GensenAttachmentType $type)
    {
        $attachment = $files->get($type->value);

        if (!$attachment) {
            AppLog::error(
                'Gagal melakukan Merge Persyaratan Gensen',
                'merge_persyaratan_gensen',
                [],
                [
                    'type' => $type->label(),
                    'cause' => 'Attachment not found'
                ],
                null,
                'document_validation' // <--- Parameter ke-6: Nama Channel
            );
            return false;
        }
        // }
        $disk = $attachment->disk ?? 'private';

        $storage = Storage::disk($disk);

        if (!$storage->exists($attachment->path)) {
            throw new Exception("File missing: {$attachment->path}");
        }

        $tmpDir = storage_path('app/tmp/merge_persyaratan');

        if (!is_dir($tmpDir)) {
            mkdir($tmpDir, 0777, true);
        }

        $tmpPath = $tmpDir . '/' . basename($attachment->path);

        /*
        |--------------------------------------------------------------------------
        | STREAM DOWNLOAD (Supabase → Local)
        |--------------------------------------------------------------------------
        */

        $readStream = $storage->readStream($attachment->path);

        if ($readStream === false) {
            throw new Exception("Failed to read remote file");
        }

        $writeStream = fopen($tmpPath, 'w');

        stream_copy_to_stream($readStream, $writeStream);

        fclose($readStream);
        fclose($writeStream);

        $path = $tmpPath;

        return $path;
    }

    public function merge(
        string $ktpFront,
        string $ktpBack,
        string $zaryouFront,
        string $zaryouBack,
        string $rekeningIndonesia,
        string $outputPath
    ) {
        /*
        |--------------------------------------------------------------------------
        | A4 Canvas (300 DPI)
        |--------------------------------------------------------------------------
        */
        $A4_WIDTH  = 2480;
        $A4_HEIGHT = 3508;
        // $A4_WIDTH  = 1240;
        // $A4_HEIGHT = 1754;

        $TOP_AREA_HEIGHT = $A4_HEIGHT / 2;

        /*
        |--------------------------------------------------------------------------
        | Create Canvas
        |--------------------------------------------------------------------------
        */
        $canvas = imagecreatetruecolor($A4_WIDTH, $A4_HEIGHT);

        $white = imagecolorallocate($canvas, 255, 255, 255);
        imagefill($canvas, 0, 0, $white);

        /*
        |--------------------------------------------------------------------------
        | Image Loader
        |--------------------------------------------------------------------------
        */
        $load = function ($path) {

            $mime = mime_content_type($path);

            return match ($mime) {
                'image/jpeg', 'image/jpg' => imagecreatefromjpeg($path),
                'image/png'               => imagecreatefrompng($path),
                default => throw new Exception("Unsupported image: {$path}")
            };
        };

        $img1 = $ktpFront ? $load($ktpFront) : null;
        $img2 = $ktpBack ? $load($ktpBack) : null;
        $img3 = $zaryouFront ? $load($zaryouFront) : null;
        $img4 = $zaryouBack ? $load($zaryouBack) : null;
        $img5 = $rekeningIndonesia ? $load($rekeningIndonesia) : null;

        /*
        |--------------------------------------------------------------------------
        | Slot Size (2x2 grid top area)
        |--------------------------------------------------------------------------
        */
        $slotWidth  = $A4_WIDTH / 2;
        $slotHeight = $TOP_AREA_HEIGHT / 2;

        /*
        |--------------------------------------------------------------------------
        | SMART PLACE (NO STRETCHING)
        |--------------------------------------------------------------------------
        */
        $place = function ($img, $x, $y, $slotW = null, $slotH = null)
        use ($canvas, $slotWidth, $slotHeight) {

            if (!$img) {
                return;
            }

            $slotW = $slotW ?? $slotWidth;
            $slotH = $slotH ?? $slotHeight;

            $imgW = imagesx($img);
            $imgH = imagesy($img);

            /*
        |--------------------------------------------------------------------------
        | Calculate proportional scale
        |--------------------------------------------------------------------------
        */
            $ratio = min(
                $slotW / $imgW,
                $slotH / $imgH
            );

            $newW = (int) ($imgW * $ratio);
            $newH = (int) ($imgH * $ratio);

            /*
        |--------------------------------------------------------------------------
        | Center inside slot
        |--------------------------------------------------------------------------
        */
            $dstX = (int) ($x + (($slotW - $newW) / 2));
            $dstY = (int) ($y + (($slotH - $newH) / 2));

            /*
        |--------------------------------------------------------------------------
        | Copy image proportionally
        |--------------------------------------------------------------------------
        */
            imagecopyresampled(
                $canvas,
                $img,
                $dstX,
                $dstY,
                0,
                0,
                $newW,
                $newH,
                $imgW,
                $imgH
            );
        };

        /*
        |--------------------------------------------------------------------------
        | Place Images
        |--------------------------------------------------------------------------
        */

        $place($img1, 0, 0);
        $place($img2, $slotWidth, 0);
        $place($img3, 0, $slotHeight);
        $place($img4, $slotWidth, $slotHeight);

        // Bottom full width area
        $place(
            $img5,
            0,
            $TOP_AREA_HEIGHT,
            $A4_WIDTH,
            $TOP_AREA_HEIGHT
        );

        /*
        |--------------------------------------------------------------------------
        | Create Temp Image
        |--------------------------------------------------------------------------
        */
        $tempImage = storage_path('app/tmp/' . uniqid() . '.jpg');

        if (!file_exists(dirname($tempImage))) {
            mkdir(dirname($tempImage), 0755, true);
        }

        imagejpeg($canvas, $tempImage, 95);

        /*
        |--------------------------------------------------------------------------
        | Generate PDF
        |--------------------------------------------------------------------------
        */
        $html = '
        <html>
            <head>
                <style>
                    body{margin:0;padding:0;}
                    img{width:100%;height:auto;}
                </style>
            </head>
            <body>
                <img src="' . $tempImage . '">
            </body>
        </html>';

        $pdf = Pdf::loadHTML($html)
            ->setPaper('a4', 'portrait');

        $dir = dirname($outputPath);

        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }

        file_put_contents($outputPath, $pdf->output());

        /*
        |--------------------------------------------------------------------------
        | Cleanup Memory
        |--------------------------------------------------------------------------
        */

        // unlink($ktpFront);
        // unlink($ktpBack);
        // unlink($zaryouFront);
        // unlink($zaryouBack);
        // unlink($rekeningIndonesia);
        // unlink($outputPath);

        unset($img1, $img2, $img3, $img4, $img5, $canvas);
        unlink($tempImage);

        gc_collect_cycles();

        return $outputPath;
    }
}
