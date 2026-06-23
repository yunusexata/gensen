<?php

namespace App\Jobs\ResiGenerator;

use App\Enums\Gensen\JobStatus;
use App\Models\ResiGenerator\ResiGenerator;
use App\Services\ResiGenerator\ResiGeneratorService;
use App\Services\ResiGenerator\ResiMatcherService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Spatie\Browsershot\Browsershot;
use Throwable;

class ResiMatchingJob implements ShouldQueue
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
                'matching_status' => JobStatus::PROCESSING,
                'matching_started_at' => now(),
            ]);
            app(ResiMatcherService::class)
                ->matchByConfidenceScore($this->resi);

            $this->resi->update([
                'matching_status' => JobStatus::DONE,
                'matching_finished_at' => now(),
            ]);
        } catch (\Throwable $e) {

            $this->resi->update([
                'matching_status' => JobStatus::FAILED,
                'matching_finished_at' => now(),
                'matching_error_message' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    public function failed(?Throwable $e): void
    {
        $this->resi->update([
            'matching_status' => JobStatus::FAILED,
            'matching_finished_at' => now(),
            'matching_error_message' => $e->getMessage(),
        ]);
    }
}
