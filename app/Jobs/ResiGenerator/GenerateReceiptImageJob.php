<?php

namespace App\Jobs\ResiGenerator;

use App\Enums\Gensen\JobStatus;
use App\Models\ResiGenerator\ResiGeneratorDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;
use Throwable;

class GenerateReceiptImageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Tentukan agar Job ini otomatis membaca ulang model dari DB saat dieksekusi
     */

    public function __construct(
        public ResiGeneratorDetail $resiDetail
    ) {}

    public function handle(): void
    {
        try {
            $this->resiDetail->update([
                'status' => JobStatus::PROCESSING,
                'started_at' => now(),
            ]);
            $gmailLogo = 'data:image/svg+xml;base64,' .
                base64_encode(
                    file_get_contents(
                        public_path('images/resi-generator/gmail_logo.svg')
                    )
                );
            $htmlContent = view('app.resi-generator.template.version1', [
                'data' => $this->resiDetail,
                'gmail_logo' => $gmailLogo
            ])->render();

            $cleanExcelRekening = preg_replace('/\D/', '', $this->resiDetail->rekening);
            $fileName =
                str_pad($this->resiDetail->jenis_pencairan . $this->resiDetail->no, 4, "0", STR_PAD_LEFT)
                . '_' .
                strtoupper($this->resiDetail->resi->bank)
                . '_' .
                strtoupper($this->resiDetail->nama)
                . '_' .
                $cleanExcelRekening . '.jpg';

            $relativePath = 'resi_generator/result/' .
                $this->resiDetail->resi->label .
                '/' .
                $fileName;

            $storageDisk = 'private';
            $disk = Storage::disk($storageDisk);

            // pastikan folder ada
            $disk->makeDirectory(
                'resi_generator/result/' . $this->resiDetail->resi->label
            );

            // absolute path untuk Browsershot
            $absolutePath = $disk->path($relativePath);

            Browsershot::html($htmlContent)
                ->noSandbox()
                ->addChromiumArguments([
                    '--disable-dev-shm-usage',
                    '--disable-setuid-sandbox',
                    '--no-first-run',
                    '--headless',
                ])
                ->setScreenshotType('jpeg', 90)
                ->windowSize(600, 800)
                ->fullPage()
                ->save($absolutePath);

            $this->resiDetail->update([
                'generated_image_disk' => $storageDisk,
                'generated_image_path' => $relativePath,
                'status' => JobStatus::DONE,
                'finished_at' => now(),
            ]);
        } catch (\Throwable $e) {

            $this->resiDetail->update([
                'status' => JobStatus::FAILED,
                'finished_at' => now(),
                'error_message' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    public function failed(?Throwable $e): void
    {
        $this->resiDetail->update([
            'status' => JobStatus::FAILED,
            'finished_at' => now(),
            'error_message' => $e->getMessage(),
        ]);
    }
}
