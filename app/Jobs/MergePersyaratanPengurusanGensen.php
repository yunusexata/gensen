<?php

namespace App\Jobs;

use App\Enums\Gensen\GensenAttachmentType;
use App\Enums\Gensen\JobStatus;
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
        logger('construct merge persyaratan');
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

            $gensenFormId = $process->gensen_form_id;


            logger('start merger');

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

            logger([
                'files attachment line 89',
                $files
            ]);
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
            $gensen->handleMergeSeluruhBerkas();
            logger('end merger');
        } catch (\Throwable $e) {

            $process->update([
                'status' => JobStatus::FAILED,
                'error_message' => $e->getMessage(),
            ]);

            throw $e; // allow queue retry
        }
    }

    public function failed(?Throwable $e): void
    {

        $process = PersyaratanGensenJob::findOrFail($this->processId);
        $process->update([
            'status' => JobStatus::FAILED,
            'error_message' => $e->getMessage(),
        ]);
    }

    private function attachmentPath($files, GensenAttachmentType $type)
    {
        $attachment = $files->get($type->value);

        logger([
            'detail att line 145',
            $attachment
        ]);
        if (!$attachment) {
            logger("Attachment {$type->label()} not found");
            return false;
        }

        // $disk = $attachment->disk ?? 'private';

        // $path = Storage::disk($disk)->path($attachment->path);

        // if (!file_exists($path)) {
        //     throw new \Exception("File missing: {$path}");
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


        // $path = $tmpDir . '/' . basename($attachment->path);

        // // ⭐ STREAM COPY (VERY IMPORTANT)
        // $readStream = $disk->readStream($attachment->path);
        // $writeStream = fopen($path, 'w');

        // stream_copy_to_stream($readStream, $writeStream);

        // fclose($readStream);
        // fclose($writeStream);
        logger([
            'attachment path line 169',
            $path
        ]);
        return $path;
    }

    // public function merge(
    //     string $ktpFront,
    //     string $ktpBack,
    //     string $zaryouFront,
    //     string $zaryouBack,
    //     string $rekeningIndonesia,
    //     string $outputPath
    // ) 
    // {

    //     /*
    //     |--------------------------------------------------------------------------
    //     | A4 Canvas
    //     |--------------------------------------------------------------------------
    //     */
    //         $A4_WIDTH  = 2480;
    //         $A4_HEIGHT = 3508;

    //         $TOP_AREA_HEIGHT = $A4_HEIGHT / 2;

    //         /*
    //     |--------------------------------------------------------------------------
    //     | Create A4 canvas
    //     |--------------------------------------------------------------------------
    //     */
    //         $canvas = imagecreatetruecolor($A4_WIDTH, $A4_HEIGHT);

    //         $white = imagecolorallocate($canvas, 255, 255, 255);
    //         imagefill($canvas, 0, 0, $white);

    //         /*
    //     |--------------------------------------------------------------------------
    //     | Image loader
    //     |--------------------------------------------------------------------------
    //     */
    //         $load = function ($path) {
    //             $mime = mime_content_type($path);

    //             return match ($mime) {
    //                 'image/jpeg', 'image/jpg' => imagecreatefromjpeg($path),
    //                 'image/png' => imagecreatefrompng($path),
    //                 default => throw new Exception("Unsupported image: {$path}")
    //             };
    //         };
    //         if ($ktpFront) {
    //             $img1 = $load($ktpFront);
    //         }
    //         if ($ktpBack) {
    //             $img2 = $load($ktpBack);
    //         }
    //         if ($zaryouFront) {
    //             $img3 = $load($zaryouFront);
    //         }
    //         if ($zaryouBack) {
    //             $img4 = $load($zaryouBack);
    //         }
    //         if ($rekeningIndonesia) {
    //             $img5 = $load($rekeningIndonesia);
    //         }

    //         /*
    //     |--------------------------------------------------------------------------
    //     | Each image slot size (2x2 grid)
    //     |--------------------------------------------------------------------------
    //     */
    //         $slotWidth  = $A4_WIDTH / 2;
    //         $slotHeight = $TOP_AREA_HEIGHT / 2;

    //         /*
    //     |--------------------------------------------------------------------------
    //     | Helper placement
    //     |--------------------------------------------------------------------------
    //     */
    //         $place = function ($img, $x, $y, $customWidth = null, $customHeight = null) use ($canvas, $slotWidth, $slotHeight) {

    //             imagecopyresampled(
    //                 $canvas,
    //                 $img,
    //                 $x,
    //                 $y,
    //                 0,
    //                 0,
    //                 $customWidth ? $customWidth : $slotWidth,
    //                 $customHeight ? $customHeight : $slotHeight,
    //                 imagesx($img),
    //                 imagesy($img)
    //             );
    //         };

    //         /*
    //     |--------------------------------------------------------------------------
    //     | Place images (TOP HALF ONLY)
    //     |--------------------------------------------------------------------------
    //     */

    //         // Top Left
    //         if ($ktpFront) {
    //             $place($img1, 0, 0);
    //         }

    //         // Top Right
    //         if ($ktpBack) {
    //             $place($img2, $slotWidth, 0);
    //         }
    //         // Bottom Left (still inside top half)
    //         if ($zaryouFront) {
    //             $place($img3, 0, $slotHeight);
    //         }
    //         // Bottom Right
    //         if ($zaryouBack) {
    //             $place($img4, $slotWidth, $slotHeight);
    //         }
    //         // Bottom
    //         if ($rekeningIndonesia) {
    //             $place($img5, 0, $TOP_AREA_HEIGHT, $A4_WIDTH, $TOP_AREA_HEIGHT);
    //         }
    //         /*
    //     |--------------------------------------------------------------------------
    //     | Save
    //     |--------------------------------------------------------------------------
    //     */
    //         // RETURN AS IMAGE
    //         // $dir = dirname($outputPath);

    //         // if (!file_exists($dir)) {
    //         //     mkdir($dir, 0755, true);
    //         // }

    //         // imagejpeg($canvas, $outputPath, 95);

    //         /*
    //         |--------------------------------------------------------------------------
    //         | Free memory
    //         |--------------------------------------------------------------------------
    //         */
    //         unset(
    //             $img1,
    //             $img2,
    //             $img3,
    //             $img4,
    //             $img5,
    //         );
    //         /*
    //         |--------------------------------------------------------------------------
    //         | Create temp image
    //         |--------------------------------------------------------------------------
    //         */

    //         $tempImage = storage_path('app/tmp/' . uniqid() . '.jpg');

    //         if (!file_exists(dirname($tempImage))) {
    //             mkdir(dirname($tempImage), 0755, true);
    //         }
    //         imagejpeg($canvas, $tempImage, 95);


    //         /*
    //         |--------------------------------------------------------------------------
    //         | Generate PDF
    //         |--------------------------------------------------------------------------
    //         */

    //         $html = '
    //         <html>
    //             <head>
    //                 <style>
    //                     body {
    //                         margin:0;
    //                         padding:0;
    //                     }
    //                     img {
    //                         width:100%;
    //                         height:auto;
    //                     }
    //                 </style>
    //             </head>
    //             <body>
    //                 <img src="' . $tempImage . '">
    //             </body>
    //         </html>
    //         ';

    //         $pdf = Pdf::loadHTML($html)
    //             ->setPaper('a4', 'portrait');

    //         $dir = dirname($outputPath);

    //         if (!file_exists($dir)) {
    //             mkdir($dir, 0755, true);
    //         }

    //         file_put_contents($outputPath, $pdf->output());

    //         /*
    //         |--------------------------------------------------------------------------
    //         | Cleanup temp
    //         |--------------------------------------------------------------------------
    //         */

    //         unlink($tempImage);
    //         return $outputPath;
    // }
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
