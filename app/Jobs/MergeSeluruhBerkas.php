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

                    $tmpPath = $tmpDir . '/' . Str::random(40) . '.pdf';

                    $stream = Storage::disk('supabase')->readStream($file->path);

                    if ($stream === false) {
                        throw new \Exception("Cannot read Supabase file: {$file->path}");
                    }

                    $target = fopen($tmpPath, 'w');

                    stream_copy_to_stream($stream, $target);

                    fclose($stream);
                    fclose($target);

                    $fullPath = $tmpPath;

                    $tempFiles[] = $tmpPath; // ⭐ mark for cleanup

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
                $normalizedPath = $this->normalizePdf($preparedPdf);

                /**
                 * -----------------------------------------------------------------
                 * STEP 4: Import into FPDI
                 * -----------------------------------------------------------------
                 */
                $this->importPdf($pdf, $normalizedPath);
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
    private function mergePdfFilesOld($files, string $outputPath): void
    {
        $pdf = new Fpdi();

        $pdf->SetMargins(0, 0, 0);
        $pdf->SetAutoPageBreak(false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        logger('files all');
        logger($files);
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
                '-dNOPAUSE -dQUIET -dBATCH ' .
                '-dPDFFitPage ' .
                '-dFIXEDMEDIA ' .
                '-dUseCropBox ' .
                '-sPAPERSIZE=a4 ' .
                '-dAutoRotatePages=/All ' .
                '-sOutputFile=%s %s',
            escapeshellarg($normalized),
            escapeshellarg($input)
        );

        exec($command, $output, $result);

        if ($result !== 0 || !file_exists($normalized)) {
            throw new Exception("PDF normalization failed");
        }

        logger(['normalized', $normalized]);

        return $normalized;
    }

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
}
