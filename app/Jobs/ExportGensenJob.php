<?php

namespace App\Jobs;

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

class ExportGensenJob implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    protected $historyId;

    public function __construct($historyId)
    {
        $this->historyId = $historyId;
    }

    public function handle()
    {

        logger('START EXPORT');
        $history = GensenExportImportHistory::findOrFail($this->historyId);
        Log::info('Broadcasting event', [
            'id' => $history->id,
            'job_key' => $history->job_key,
        ]);
        try {
            $history->update(['status' => JobStatus::PROCESSING]);
            event(new ExportStatusUpdated($history));

            $filters = json_decode($history->filters, true);

            // ambil data sesuai role + filter
            $data = app(ExportService::class)
                ->handle($history->job_key, $filters);

            $fileName = 'export_' . time() . '.xlsx';
            $filePath = 'exports/' . $fileName;
            logger(['data export', $data]);

            // simpan file (pakai Laravel Excel atau manual)
            Excel::store(new CollectionExport(
                [
                    'title' => 'Data Gensen',
                    'type' => ExportHelper::TYPE_EXCEL,
                ],
                $data,
                'app.gensen.gensen-data.export',
            ), $filePath, 'private');

            $history->update([
                'status' => JobStatus::DONE,
                'file_name' => $fileName,
                'file_path' => $filePath,
                'amount' => $data?->count(),
            ]);
            event(new ExportStatusUpdated($history));
            Log::info('Broadcasting event', [
                'id' => $history->id,
                'job_key' => $history->job_key,
            ]);
        } catch (\Throwable $e) {
            $history->update([
                'status' => JobStatus::FAILED,
                'error_message' => $e->getMessage(),
            ]);
            event(new ExportStatusUpdated($history));
            Log::info('Broadcasting event', [
                'id' => $history->id,
                'job_key' => $history->job_key,
            ]);
        }
    }

    public function failed(?Throwable $exception): void
    {
        // Send user notification of failure, etc...
    }
}
