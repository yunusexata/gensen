<?php

namespace App\Jobs\ResiGenerator;

use App\Enums\Gensen\JobStatus;
use App\Models\ResiGenerator\ResiGenerator;
use App\Services\ResiGenerator\ResiGeneratorService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Spatie\Browsershot\Browsershot;
use Throwable;

class GetEmailJob implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    /**
     * Tentukan agar Job ini otomatis membaca ulang model dari DB saat dieksekusi
     */

    public function __construct(
        public ResiGenerator $resi
    ) {}

    public function handle(): void
    {
        try {
            $this->resi->update([
                'status' => JobStatus::PROCESSING,
                'started_at' => now(),
            ]);
            app(ResiGeneratorService::class)
                ->getEmail($this->resi);

            $this->resi->update([
                'status' => JobStatus::DONE,
                'finished_at' => now(),
            ]);
        } catch (\Throwable $e) {

            $this->resi->update([
                'status' => JobStatus::FAILED,
                'finished_at' => now(),
                'error_message' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    public function failed(?Throwable $e): void
    {
        $this->resi->update([
            'status' => JobStatus::FAILED,
            'finished_at' => now(),
            'error_message' => $e->getMessage(),
        ]);
    }
}
