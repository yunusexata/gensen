<?php

namespace App\Jobs\GensenExtractJob;

use App\Enums\Gensen\JobStatus;
use App\Events\ExportStatusUpdated;
use App\Exports\CollectionExport;
use App\Helpers\ExportHelper;
use App\Models\Gensen\GensenExportImportHistory;
use App\Services\ExportService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class ValidationDocumentJob implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    protected $historyId;

    public function __construct($historyId)
    {
        $this->historyId = $historyId;
    }
    public function handle(AiManager $ai)
    {
        $job = AiJob::find($this->aiJobId);

        $job->update([
            'status' => 'processing',
        ]);

        $result = $ai->extract($job->subject);

        AiResult::create([
            'ai_job_id' => $job->id,
            'result' => $result,
        ]);

        $job->update([
            'status' => 'success',
            'finished_at' => now(),
        ]);
    }
    public function failed(?Throwable $exception): void
    {
        // Send user notification of failure, etc...
    }
}
