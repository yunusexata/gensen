<?php

namespace App\Jobs;

use App\Enums\Gensen\JobStatus;
use App\Events\ExportImportStatusUpdated;
use App\Exports\CollectionExport;
use App\Helpers\ExportHelper;
use App\Models\Gensen\GensenExportImportHistory;
use App\Services\ExportService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
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
        DB::beginTransaction();

        logger('START EXPORT');
        $history = GensenExportImportHistory::findOrFail($this->historyId);

        try {
            $history->update([
                'started_at' => now(),
                'status' => JobStatus::PROCESSING
            ]);

            DB::afterCommit(function () use ($history) {

                broadcast(
                    new ExportImportStatusUpdated(
                        $history->fresh()
                    )
                );
            });
            Log::info('Broadcasting event', [
                'id' => $history->id,
                'job_key' => $history->job_key->value,
            ]);

            $filters = json_decode($history->filters, true);

            // ambil data sesuai role + filter
            $data = app(ExportService::class)
                ->handle($history->job_key, $filters);

            $fileName = $history->job_key->value . '_' . time() . '.xlsx';
            $filePath = 'exports/' . $fileName;

            // simpan file (pakai Laravel Excel atau manual)
            $disk = 'private';
            Excel::store(new CollectionExport(
                [
                    'title' => 'Data Gensen',
                    'type' => ExportHelper::TYPE_EXCEL,
                ],
                $data,
                'app.gensen.gensen-data.export',
            ), $filePath, $disk);

            $history->update([
                'status' => JobStatus::DONE,
                'file_name' => $fileName,
                'file_path' => $filePath,
                'disk' => $disk,
                'amount' => $data?->count(),
                'finish_at' => now(),
            ]);

            Log::info('Broadcasting event', [
                'id' => $history->id,
                'job_key' => $history->job_key->value,
            ]);

            DB::commit();

            DB::afterCommit(function () use ($history) {

                broadcast(
                    new ExportImportStatusUpdated(
                        $history->fresh()
                    )
                );
            });
        } catch (\Throwable $e) {

            DB::rollBack();
            $history->update([
                'status' => JobStatus::FAILED,
                'error_message' => $e->getMessage(),
            ]);

            $history->refresh();

            broadcast(new ExportImportStatusUpdated($history));
            Log::info('Broadcasting event', [
                'id' => $history->id,
                'job_key' => $history->job_key->value,
            ]);
        }
    }

    public function failed(?Throwable $exception): void
    {
        // Send user notification of failure, etc...
    }
}
