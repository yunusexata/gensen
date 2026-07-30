<?php

namespace App\Jobs;

use App\Enums\Gensen\GensenAttachmenStatus;
use App\Enums\Gensen\GensenAttachmentType;
use App\Enums\Gensen\JobStatus;
use App\Events\MergeAttachmentStatus;
use App\Models\GensenForm\GensenForm;
use App\Models\GensenForm\PersyaratanGensenJob;
use App\Models\GensenForm\SeluruhBerkasJob;
use App\Services\GensenAttachmentService;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use iio\libmergepdf\Merger;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use setasign\Fpdi\PdfParser\StreamReader;
use setasign\Fpdi\Tcpdf\Fpdi;
use Throwable;



class MergeSeluruhBerkas implements ShouldQueue
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

    /*
    |--------------------------------------------------------------------------
    | HANDLE JOB
    |--------------------------------------------------------------------------
    */

    public function handle(): void
    {
        $process = SeluruhBerkasJob::findOrFail($this->processId);

        $process->update([
            'status' => JobStatus::PROCESSING,
            'started_at' => now(),
        ]);

        logger('START MERGE PDF');

        try {

            /*
            |--------------------------------------------------------------------------
            | 1️⃣ Load Attachments
            |--------------------------------------------------------------------------
            */

            $files = $this->loadAttachments();
            logger([
                "MERGE SELURUH BERKAS FILES",
                $files->toArray()
            ]);

            if ($files->isEmpty()) {
                throw new Exception('No PDF files to merge.');
            }

            /*
            |--------------------------------------------------------------------------
            | 2️⃣ Prepare Output Path
            |--------------------------------------------------------------------------
            */

            $type = GensenAttachmentType::SELURUH_BERKAS;

            $relativePath =
                "gensen/{$this->gensenFormId}/{$type->value}/"
                . Str::uuid() . '.pdf';

            $fullPath = Storage::disk('private')->path($relativePath);

            $this->ensureDirectory($fullPath);

            /*
            |--------------------------------------------------------------------------
            | 3️⃣ Merge PDFs
            |--------------------------------------------------------------------------
            */

            $this->mergePdfFiles($files, $fullPath);

            /*
            |--------------------------------------------------------------------------
            | 4️⃣ Save Generated Attachment
            |--------------------------------------------------------------------------
            */

            app(GensenAttachmentService::class)->storeGenerated(
                $this->gensenFormId,
                $relativePath,
                $type
            );

            /*
            |--------------------------------------------------------------------------
            | 5️⃣ Finish Process
            |--------------------------------------------------------------------------
            */

            $process->update([
                'status' => JobStatus::DONE,
                'finished_at' => now(),
            ]);

            event(new MergeAttachmentStatus($this->gensenFormId));
            logger('MERGE PDF SUCCESS');
        } catch (\Throwable $e) {

            $process->update([
                'status' => JobStatus::FAILED,
                'error_message' => $e->getMessage(),
            ]);

            logger($e->getMessage());

            throw $e; // allow retry
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
    /*
    |--------------------------------------------------------------------------
    | LOAD ATTACHMENTS
    |--------------------------------------------------------------------------
    */

    private function loadAttachments()
    {
        /*
    |--------------------------------------------------------------------------
    | 1️⃣ Load Form + Attachments
    |--------------------------------------------------------------------------
    */

        $gensen = GensenForm::with([
            'attachments' => function ($q) {
                return $q->where('status', '!=', GensenAttachmenStatus::STATUS_CONVERTED);
            }
        ])
            ->findOrFail($this->gensenFormId);

        /*
    |--------------------------------------------------------------------------
    | 2️⃣ Keep only valid PDFs
    |--------------------------------------------------------------------------
    */

        $attachments = $gensen->attachments
            ->filter(
                fn($file) => ($file->mime_type === 'application/pdf' || $file->mime_type === 'image/jpeg' || $file->mime_type === 'image/png')
                    && !empty($file->path)
            );

        /*
    |--------------------------------------------------------------------------
    | 3️⃣ Group by attachment type
    |--------------------------------------------------------------------------
    */

        $grouped = $attachments->groupBy(
            fn($file) => $file->type->value
        );

        /*
    |--------------------------------------------------------------------------
    | 4️⃣ Reorder using Enum Business Order
    |--------------------------------------------------------------------------
    */

        return collect(GensenAttachmentType::mergeAllIdentity())
            ->flatMap(function ($type) use ($grouped) {
                return $grouped->get($type->value, collect());
            })
            ->values();
    }

    /*
    |--------------------------------------------------------------------------
    | MERGE PDF FILES (FPDI + TCPDF)
    |--------------------------------------------------------------------------
    */

    private function mergePdfFiles($files, string $outputPath): void
    {
        $pdf = new Fpdi();

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetAutoPageBreak(false);

        $tempFiles = []; // ⭐ track temp files for cleanup

        foreach ($files as $file) {

            $disk = $file->disk ?? 'private';
            logger($file);

            try {

                /**
                 * -----------------------------------------------------------------
                 * STEP 1: Resolve file into LOCAL PATH (Supabase-safe)
                 * -----------------------------------------------------------------
                 */
                if ($disk === 'supabase') {

                    $tmpDir = storage_path('app/tmp/merge');

                    if (!is_dir($tmpDir)) {
                        mkdir($tmpDir, 0755, true);
                    }

                    $tmpFileName = Str::random(40);

                    $extension = pathinfo($file->path, PATHINFO_EXTENSION) ?: 'pdf';

                    $tmpPath = $tmpDir . '/' . $tmpFileName . '.' . $extension;

                    /*
                    |--------------------------------------------------------------------------
                    | Download file dari Supabase
                    |--------------------------------------------------------------------------
                    */
                    $stream = Storage::disk('supabase')->readStream($file->path);

                    if (!$stream) {
                        throw new \Exception(
                            "Cannot read Supabase file: {$file->path}"
                        );
                    }

                    try {

                        $target = fopen($tmpPath, 'wb');

                        if (!$target) {
                            throw new \Exception(
                                "Cannot create local temp file: {$tmpPath}"
                            );
                        }

                        stream_copy_to_stream($stream, $target);
                    } finally {

                        if (is_resource($stream)) {
                            fclose($stream);
                        }

                        if (isset($target) && is_resource($target)) {
                            fclose($target);
                        }
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Validasi hasil download
                    |--------------------------------------------------------------------------
                    */
                    if (!file_exists($tmpPath)) {
                        throw new \Exception(
                            "Temp file not found after download: {$tmpPath}"
                        );
                    }

                    if (filesize($tmpPath) <= 0) {
                        throw new \Exception(
                            "Downloaded file is empty: {$tmpPath}"
                        );
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Debug ukuran file
                    |--------------------------------------------------------------------------
                    */
                    logger([
                        'supabase_file' => $file->path,
                        'supabase_size' => Storage::disk('supabase')->size($file->path),
                        'local_size'    => filesize($tmpPath),
                        'local_path'    => $tmpPath,
                    ]);

                    /*
                    |--------------------------------------------------------------------------
                    | Deteksi MIME
                    |--------------------------------------------------------------------------
                    */
                    $finfo = new \finfo(FILEINFO_MIME_TYPE);

                    $realMimeType = $finfo->file($tmpPath);

                    logger([
                        'mime_type' => $realMimeType,
                        'file' => $tmpPath,
                    ]);

                    /*
                    |--------------------------------------------------------------------------
                    | Jika image -> convert ke PDF
                    |--------------------------------------------------------------------------
                    */
                    if (str_contains($realMimeType, 'image')) {

                        $pdfPath = $tmpDir . '/' . Str::uuid() . '.pdf';

                        $img = new \Imagick($tmpPath);

                        $img->setImageFormat('pdf');

                        $img->writeImage($pdfPath);

                        $img->clear();
                        $img->destroy();

                        $fullPath = $pdfPath;

                        $tempFiles[] = $pdfPath;

                        logger([
                            'converted_image_to_pdf' => $pdfPath,
                        ]);
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Jika PDF -> repair pakai qpdf
                    |--------------------------------------------------------------------------
                    */ elseif ($realMimeType === 'application/pdf') {

                        $repairDir = storage_path('app/tmp/repair');

                        if (!is_dir($repairDir)) {
                            mkdir($repairDir, 0755, true);
                        }

                        $repairedPath = $repairDir . '/' . Str::uuid() . '.pdf';

                        exec(
                            sprintf(
                                'qpdf %s %s 2>&1',
                                escapeshellarg($tmpPath),
                                escapeshellarg($repairedPath)
                            ),
                            $output,
                            $result
                        );

                        logger([
                            'qpdf_result' => $result,
                            'qpdf_output' => $output,
                            'repaired_exists' => file_exists($repairedPath),
                        ]);

                        /*
                        |--------------------------------------------------------------------------
                        | qpdf berhasil membuat file
                        |--------------------------------------------------------------------------
                        */
                        if (file_exists($repairedPath) && filesize($repairedPath) > 0) {

                            $fullPath = $repairedPath;

                            $tempFiles[] = $repairedPath;

                            logger([
                                'using_repaired_pdf' => $repairedPath,
                            ]);
                        } else {

                            $fullPath = $tmpPath;

                            logger([
                                'using_original_pdf' => $tmpPath,
                            ]);
                        }
                    }
                    /*
|--------------------------------------------------------------------------
| Jika PDF -> repair & decrypt pakai qpdf
|--------------------------------------------------------------------------
*/ elseif ($realMimeType === 'application/pdf') {

                        $repairDir = storage_path('app/tmp/repair');

                        if (!is_dir($repairDir)) {
                            mkdir($repairDir, 0755, true);
                        }

                        $repairedPath = $repairDir . '/' . Str::uuid() . '.pdf';

                        // ✨ ADD THE --decrypt FLAG HERE
                        exec(
                            sprintf(
                                'qpdf --decrypt %s %s 2>&1',
                                escapeshellarg($tmpPath),
                                escapeshellarg($repairedPath)
                            ),
                            $output,
                            $result
                        );

                        logger([
                            'qpdf_result' => $result,
                            'qpdf_output' => $output,
                            'repaired_exists' => file_exists($repairedPath),
                        ]);

                        /*
    |--------------------------------------------------------------------------
    | qpdf berhasil membuat file
    |--------------------------------------------------------------------------
    */
                        if (file_exists($repairedPath) && filesize($repairedPath) > 0) {

                            $fullPath = $repairedPath;

                            $tempFiles[] = $repairedPath;

                            logger([
                                'using_repaired_pdf' => $repairedPath,
                            ]);
                        } else {

                            $fullPath = $tmpPath;

                            logger([
                                'using_original_pdf' => $tmpPath,
                            ]);
                        }
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | File bukan PDF dan bukan image
                    |--------------------------------------------------------------------------
                    */ else {

                        /**
                         * Local disk (fast path)
                         */
                        $fullPath = Storage::disk($disk)->path($file->path);
                    }
                } else {
                    /**
                     * Local disk (fast path)
                     */
                    $fullPath = Storage::disk($disk)->path($file->path);
                }

                if (!file_exists($fullPath)) {
                    logger()->warning("Missing file: {$fullPath}");
                    continue;
                }

                /**
                 * -----------------------------------------------------------------
                 * STEP 2: Prepare (PDF or image → PDF)
                 * -----------------------------------------------------------------
                 */
                $preparedPdf = $this->prepareFileForMerge($fullPath);

                /**
                 * -----------------------------------------------------------------
                 * STEP 3: Normalize PDF
                 * -----------------------------------------------------------------
                 */
                if ($file->type !== GensenAttachmentType::REKAP_PENGIRIMAN_UANG) {
                    logger('bukan remitance');
                    $portraitPath = $this->normalizePdf($preparedPdf);
                    // $portraitPath = $this->ensurePortraitPdf($normalizedPath);
                } else {
                    $portraitPath = $this->ensurePortraitPdf($preparedPdf);
                    logger('remitance');
                    // $portraitPath = $preparedPdf;
                }

                /**
                 * -----------------------------------------------------------------
                 * STEP 4: Import into FPDI
                 * -----------------------------------------------------------------
                 */
                $this->importPdf($pdf, $portraitPath);
            } catch (\Throwable $e) {

                logger()->error('PDF MERGE FAILED', [
                    'file' => $file->path,
                    'disk' => $disk,
                    'error' => $e->getMessage(),
                ]);

                continue;
            }
        }

        /**
         * ---------------------------------------------------------------------
         * OUTPUT FINAL PDF
         * ---------------------------------------------------------------------
         */
        $pdf->Output($outputPath, 'F');

        /**
         * ---------------------------------------------------------------------
         * CLEANUP TEMP FILES (Supabase staging)
         * ---------------------------------------------------------------------
         */
        foreach ($tempFiles as $tmp) {
            if (file_exists($tmp)) {
                @unlink($tmp);
            }
        }
    }
    private function prepareFileForMerge(string $path): string
    {
        $mime = mime_content_type($path);

        logger([
            'mime',
            $mime
        ]);
        return match (true) {
            str_contains($mime, 'pdf')
            => $path,

            str_contains($mime, 'image')
            => $this->convertImageToPdf($path),

            default => throw new Exception("Unsupported file type: {$mime}")
        };
    }
    private function convertImageToPdf(string $imagePath): string
    {
        $pdf = new \TCPDF();

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetAutoPageBreak(false);

        /*
    |--------------------------------------------------------------------------
    | Get image size
    |--------------------------------------------------------------------------
    */
        [$width, $height] = getimagesize($imagePath);

        /*
    |--------------------------------------------------------------------------
    | Convert px → mm (300 DPI assumption)
    |--------------------------------------------------------------------------
    */
        $mmWidth  = $width * 0.264583;
        $mmHeight = $height * 0.264583;

        /*
    |--------------------------------------------------------------------------
    | Orientation
    |--------------------------------------------------------------------------
    */
        $orientation = $mmWidth > $mmHeight ? 'L' : 'P';

        $pdf->AddPage($orientation, [$mmWidth, $mmHeight]);

        /*
    |--------------------------------------------------------------------------
    | Place image (NO stretch)
    |--------------------------------------------------------------------------
    */
        $pdf->Image(
            $imagePath,
            0,
            0,
            $mmWidth,
            $mmHeight,
            '',
            '',
            '',
            false,
            300,
            '',
            false,
            false,
            0,
            false,
            false,
            false
        );

        /*
    |--------------------------------------------------------------------------
    | Save temp PDF
    |--------------------------------------------------------------------------
    */
        $tempPdf = storage_path('app/tmp/' . uniqid() . '.pdf');

        if (!file_exists(dirname($tempPdf))) {
            mkdir(dirname($tempPdf), 0755, true);
        }

        $pdf->Output($tempPdf, 'F');

        return $tempPdf;
    }
    private function normalizePdf(string $input): string
    {
        $normalized = storage_path(
            'app/temp/' . Str::uuid() . '.pdf'
        );

        if (!file_exists(dirname($normalized))) {
            mkdir(dirname($normalized), 0777, true);
        }

        /*
        |--------------------------------------------------------------------------
        | FORCE ALL PAGES → A4
        |--------------------------------------------------------------------------
        */
        $command = sprintf(
            'gs -sDEVICE=pdfwrite ' .
                '-dCompatibilityLevel=1.4 ' .
                '-dNEWPDF=false ' .          // CRITICAL: Matikan engine baru yang merusak jarak huruf
                '-dEmbedAllFonts=true ' .    // Pertahankan font asli di dalam PDF
                '-dSubsetFonts=false ' .     // Jangan potong karakter font
                '-dNOPAUSE -dQUIET -dBATCH ' .
                '-dPDFFitPage ' .            // Skala otomatis ke halaman baru
                '-dFIXEDMEDIA ' .            // Kunci ukuran media
                '-dUseCropBox ' .
                '-sPAPERSIZE=a4 ' .          // Target A4
                '-dAutoRotatePages=/All ' .
                '-sOutputFile=%s %s',
            escapeshellarg($normalized),
            escapeshellarg($input)
        );

        exec($command, $output, $result);
        logger($command);

        if ($result !== 0 || !file_exists($normalized)) {
            throw new Exception("PDF normalization failed");
        }

        logger(['normalized', $normalized]);

        return $normalized;
    }
    // private function ensurePortraitPdf(string $input): string
    // {
    //     try {
    //         /*
    //         |--------------------------------------------------------------------------
    //         | 1. Validasi File
    //         |--------------------------------------------------------------------------
    //         */
    //         if (!file_exists($input)) {
    //             logger()->warning("File tidak ditemukan", ['file' => $input]);
    //             return $input;
    //         }

    //         $mime = (new \finfo(FILEINFO_MIME_TYPE))->file($input);

    //         if ($mime !== 'application/pdf') {
    //             logger()->warning("File bukan PDF", [
    //                 'file' => $input,
    //                 'mime' => $mime,
    //             ]);
    //             return $input;
    //         }

    //         /*
    //         |--------------------------------------------------------------------------
    //         | 2. Repair & Decrypt PDF dengan qpdf
    //         |--------------------------------------------------------------------------
    //         */
    //         $repairDir = storage_path('app/tmp/repair');

    //         if (!is_dir($repairDir)) {
    //             mkdir($repairDir, 0775, true);
    //         }

    //         $repaired = $repairDir . '/' . Str::uuid() . '.pdf';

    //         // ✨ PERBAIKAN: Tambahkan --decrypt di sini untuk menghapus enkripsi
    //         exec(
    //             sprintf(
    //                 'qpdf --decrypt --object-streams=disable %s %s 2>&1',
    //                 escapeshellarg($input),
    //                 escapeshellarg($repaired)
    //             ),
    //             $repairOutput,
    //             $repairResult
    //         );

    //         if (file_exists($repaired) && filesize($repaired) > 0) {
    //             // Gunakan file yang sudah bersih dari enkripsi untuk tahap selanjutnya
    //             $input = $repaired;
    //         } else {
    //             logger()->error('qpdf repair/decrypt gagal', [
    //                 'result' => $repairResult,
    //                 'output' => $repairOutput,
    //             ]);
    //         }

    //         /*
    //         |--------------------------------------------------------------------------
    //         | 3. Ambil Orientasi dengan pdfinfo
    //         |--------------------------------------------------------------------------
    //         */
    //         $pdfInfoOutput = [];

    //         exec(
    //             sprintf(
    //                 'pdfinfo %s 2>&1',
    //                 escapeshellarg($input)
    //             ),
    //             $pdfInfoOutput,
    //             $pdfInfoResult
    //         );

    //         if ($pdfInfoResult !== 0) {
    //             logger()->error('pdfinfo gagal', [
    //                 'file' => $input,
    //                 'output' => $pdfInfoOutput,
    //             ]);
    //             return $input;
    //         }

    //         $pageSizeLine = collect($pdfInfoOutput)
    //             ->first(fn($line) => str_contains($line, 'Page size'));

    //         if (!$pageSizeLine) {
    //             logger()->warning('Page size tidak ditemukan', ['file' => $input]);
    //             return $input;
    //         }

    //         /*
    //         |--------------------------------------------------------------------------
    //         | 4. Parse Width & Height
    //         |--------------------------------------------------------------------------
    //         */
    //         preg_match('/Page size:\s+([\d.]+)\s+x\s+([\d.]+)/i', $pageSizeLine, $matches);

    //         if (count($matches) < 3) {
    //             return $input;
    //         }

    //         $width = (float) $matches[1];
    //         $height = (float) $matches[2];

    //         $isLandscape = $width > $height;

    //         if (!$isLandscape) {
    //             // Sudah portrait, langsung kembalikan file hasil repair/decrypt
    //             return $input;
    //         }

    //         /*
    //         |--------------------------------------------------------------------------
    //         | 5. Rotate PDF (Hanya jika Landscape)
    //         |--------------------------------------------------------------------------
    //         */
    //         $mergeDir = storage_path('app/tmp/merge');

    //         if (!is_dir($mergeDir)) {
    //             mkdir($mergeDir, 0775, true);
    //         }

    //         $rotated = $mergeDir . '/' . Str::uuid() . '.pdf';

    //         // ✨ PERBAIKAN: Opsi --rotate berada SEBELUM file input
    //         exec(
    //             sprintf(
    //                 'qpdf --rotate=+90:1-z %s %s 2>&1',
    //                 escapeshellarg($input),
    //                 escapeshellarg($rotated)
    //             ),
    //             $rotateOutput,
    //             $rotateResult
    //         );

    //         if ($rotateResult === 0 && file_exists($rotated) && filesize($rotated) > 0) {
    //             return $rotated;
    //         }

    //         logger()->error('Rotate gagal', [
    //             'command' => sprintf('qpdf --rotate=+90:1-z %s %s', $input, $rotated),
    //             'result'  => $rotateResult,
    //             'output'  => implode("\n", $rotateOutput),
    //         ]);
    //     } catch (\Throwable $e) {
    //         logger()->error('Error kritis PDF', [
    //             'file' => $input,
    //             'message' => $e->getMessage(),
    //             'trace' => $e->getTraceAsString(),
    //         ]);
    //     }

    //     return $input;
    // }
    private function ensurePortraitPdf(string $input): string
    {
        try {

            /*
        |--------------------------------------------------------------------------
        | Validasi file
        |--------------------------------------------------------------------------
        */
            if (!file_exists($input)) {
                logger("File tidak ditemukan", [
                    'file' => $input,
                ]);

                return $input;
            }

            $mime = (new \finfo(FILEINFO_MIME_TYPE))->file($input);

            if ($mime !== 'application/pdf') {

                logger("File bukan PDF", [
                    'file' => $input,
                    'mime' => $mime,
                ]);

                return $input;
            }

            /*
        |--------------------------------------------------------------------------
        | Folder temp
        |--------------------------------------------------------------------------
        */
            $repairDir = storage_path('app/tmp/repair');

            if (!is_dir($repairDir)) {
                mkdir($repairDir, 0775, true);
            }

            /*
        |--------------------------------------------------------------------------
        | Repair PDF dengan qpdf
        |--------------------------------------------------------------------------
        */
            $repaired = $repairDir . '/' . Str::uuid() . '.pdf';

            exec(
                sprintf(
                    'qpdf --object-streams=disable %s %s 2>&1',
                    escapeshellarg($input),
                    escapeshellarg($repaired)
                ),
                $repairOutput,
                $repairResult
            );

            logger([
                'qpdf_result' => $repairResult,
                'repaired_exists' => file_exists($repaired),
            ]);

            if (
                file_exists($repaired)
                && filesize($repaired) > 0
            ) {
                $input = $repaired;
            }

            /*
        |--------------------------------------------------------------------------
        | Ambil orientasi dengan pdfinfo
        |--------------------------------------------------------------------------
        */
            $pdfInfoOutput = [];

            exec(
                sprintf(
                    'pdfinfo %s 2>&1',
                    escapeshellarg($input)
                ),
                $pdfInfoOutput,
                $pdfInfoResult
            );

            if ($pdfInfoResult !== 0) {

                logger('pdfinfo gagal', [
                    'file' => $input,
                    'output' => $pdfInfoOutput,
                ]);

                return $input;
            }
            logger($pdfInfoOutput);

            $pageSizeLine = collect($pdfInfoOutput)
                ->first(fn($line) => str_contains($line, 'Page size'));

            if (!$pageSizeLine) {

                logger('Page size tidak ditemukan', [
                    'file' => $input,
                ]);

                return $input;
            }

            /*
        |--------------------------------------------------------------------------
        | Parse width & height
        |--------------------------------------------------------------------------
        */
            preg_match(
                '/Page size:\s+([\d.]+)\s+x\s+([\d.]+)/i',
                $pageSizeLine,
                $matches
            );

            if (count($matches) < 3) {
                return $input;
            }

            $width = (float) $matches[1];
            $height = (float) $matches[2];

            $isLandscape = $width > $height;

            logger([
                'width' => $width,
                'height' => $height,
                'is_landscape' => $isLandscape,
            ]);

            if (!$isLandscape) {
                return $input;
            }

            /*
        |--------------------------------------------------------------------------
        | Rotate PDF
        |--------------------------------------------------------------------------
        */
            $mergeDir = storage_path('app/tmp/merge');

            if (!is_dir($mergeDir)) {
                mkdir($mergeDir, 0775, true);
            }

            $rotated = $mergeDir . '/' . Str::uuid() . '.pdf';

            exec(
                sprintf(
                    'qpdf %s --rotate=+90:1-z %s 2>&1',
                    escapeshellarg($input),
                    escapeshellarg($rotated)
                ),
                $rotateOutput,
                $rotateResult
            );

            if (
                $rotateResult === 0
                && file_exists($rotated)
                && filesize($rotated) > 0
            ) {
                return $rotated;
            }

            logger('Rotate gagal', [
                'result' => $rotateResult,
                'output' => $rotateOutput,
            ]);
            /*
            |--------------------------------------------------------------------------
            | Rotate PDF
            |--------------------------------------------------------------------------
            */
            // $mergeDir = storage_path('app/tmp/merge');

            // if (!is_dir($mergeDir)) {
            //     mkdir($mergeDir, 0775, true);
            // }

            // $rotated = $mergeDir . '/' . Str::uuid() . '.pdf';

            // // 🚀 PERBAIKAN DI SINI: Opsi --rotate harus berada SEBELUM file input
            // exec(
            //     sprintf(
            //         'qpdf --rotate=+90:1-z %s %s 2>&1',
            //         escapeshellarg($input),
            //         escapeshellarg($rotated)
            //     ),
            //     $rotateOutput,
            //     $rotateResult
            // );

            // if (
            //     $rotateResult === 0
            //     && file_exists($rotated)
            //     && filesize($rotated) > 0
            // ) {
            //     return $rotated;
            // }

            // // Tambahkan logger yang lebih spesifik untuk membantu debugging jika masih gagal
            // logger()->error('Rotate gagal', [
            //     'command' => sprintf('qpdf --rotate=+90:1-z %s %s', $input, $rotated),
            //     'result'  => $rotateResult,
            //     'output'  => implode("\n", $rotateOutput),
            // ]);
        } catch (\Throwable $e) {

            logger('Error kritis PDF', [
                'file' => $input,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }

        return $input;
    }
    // private function ensurePortraitPdf(string $input): string
    // {
    //     try {
    //         $fpdi = new Fpdi();
    //         $fpdi->setSourceFile($input);
    //         $templateId = $fpdi->importPage(1);
    //         $size = $fpdi->getTemplateSize($templateId);

    //         // Jika Landscape, kita rotasi
    //         $isLandscape = ($size['orientation'] === 'L') || ($size['width'] > $size['height']);

    //         logger([
    //             'ensure portrait',
    //             $size
    //         ]);
    //         if (!$isLandscape) {
    //             return $input;
    //         }

    //         $rotated = storage_path('app/tmp/merge/' . Str::uuid() . '.pdf');

    //         if (!file_exists(dirname($rotated))) {
    //             mkdir(dirname($rotated), 0777, true);
    //         }

    //         /**
    //          * QPDF --rotate=90
    //          * Ini akan memutar seluruh halaman termasuk kontennya.
    //          * Karena ini bukan 'rendering', maka tidak mungkin terjadi crop.
    //          * Semua objek, teks, dan gambar akan ikut berputar 90 derajat.
    //          */
    //         $command = sprintf(
    //             'qpdf --rotate=90 %s %s 2>&1',
    //             escapeshellarg($input),
    //             escapeshellarg($rotated)
    //         );

    //         exec($command, $output, $result);

    //         if ($result === 0 && file_exists($rotated)) {
    //             return $rotated;
    //         }

    //         logger("qpdf gagal merotasi PDF", ['result' => $result, 'output' => $output]);
    //     } catch (\Exception $e) {
    //         logger("Error FPDI: " . $e->getMessage());
    //     }

    //     return $input;
    // }
    /*
    |--------------------------------------------------------------------------
    | IMPORT SINGLE PDF
    |--------------------------------------------------------------------------
    */
    private function importPdf(Fpdi $pdf, string $path): void
    {
        $pageCount = $pdf->setSourceFile(
            StreamReader::createByFile($path)
        );

        for ($page = 1; $page <= $pageCount; $page++) {

            $tpl = $pdf->importPage($page);

            $size = $pdf->getTemplateSize($tpl);

            // ⭐ keep original size
            $pdf->AddPage(
                $size['orientation'],
                [$size['width'], $size['height']]
            );

            $pdf->useTemplate($tpl);
        }
    }

    private function importPdfOld(Fpdi $pdf, string $path): void
    {
        $pageCount = $pdf->setSourceFile($path);

        for ($page = 1; $page <= $pageCount; $page++) {

            $tpl = $pdf->importPage($page);
            // $template = $pdf->importPage($page);

            $size = $pdf->getTemplateSize($tpl);
            $pdf->AddPage('P', 'A4');

            $a4W = 210;
            $a4H = 297;

            $ratio = min(
                $a4W / $size['width'],
                $a4H / $size['height']
            );

            $w = $size['width'] * $ratio;
            $h = $size['height'] * $ratio;

            $x = ($a4W - $w) / 2;
            $y = ($a4H - $h) / 2;

            $pdf->useTemplate($tpl, $x, $y, $w, $h);
            /*
            ✅ IMPORTANT
            Fix different page sizes problem
            */

            // $pdf->AddPage(
            //     $size['orientation'],
            //     [$size['width'], $size['height']]
            // );

            // $pdf->useTemplate($tpl);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | ENSURE DIRECTORY EXISTS
    |--------------------------------------------------------------------------
    */

    private function ensureDirectory(string $path): void
    {
        $dir = dirname($path);

        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }
    }
    private function normalizePdfToA4(string $source, string $output)
    {
        $pdf = new Fpdi();

        $pageCount = $pdf->setSourceFile($source);

        for ($i = 1; $i <= $pageCount; $i++) {

            $tpl = $pdf->importPage($i);
            $size = $pdf->getTemplateSize($tpl);

            $pdf->AddPage('P', 'A4');

            $a4W = 210;
            $a4H = 297;

            $ratio = min(
                $a4W / $size['width'],
                $a4H / $size['height']
            );

            $w = $size['width'] * $ratio;
            $h = $size['height'] * $ratio;

            $x = ($a4W - $w) / 2;
            $y = ($a4H - $h) / 2;

            $pdf->useTemplate($tpl, $x, $y, $w, $h);
        }

        $pdf->Output($output, 'F');
    }
    private function imageToA4Pdf(string $image, string $output)
    {
        $pdf = new \FPDF('P', 'mm', 'A4');

        $pdf->AddPage();

        $pdf->Image(
            $image,
            0,
            0,
            210,
            297
        );

        $pdf->Output($output, 'F');
    }

    private function mergePdfFilesOld($files, string $outputPath): void
    {
        $pdf = new Fpdi();

        $pdf->SetMargins(0, 0, 0);
        $pdf->SetAutoPageBreak(false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        // logger('files all');
        // logger($files);
        foreach ($files as $file) {

            $fullPath = Storage::disk($file->disk)
                ->path($file->path);

            if (!file_exists($fullPath)) {
                logger("Missing file: {$fullPath}");
                continue;
            }

            $this->importPdf($pdf, $fullPath);
        }

        $pdf->Output($outputPath, 'F');
    }
}
