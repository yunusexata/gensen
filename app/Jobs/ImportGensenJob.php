<?php

namespace App\Jobs;

use App\Enums\Gensen\JobStatus;
use App\Events\ExportImportStatusUpdated;
use App\Imports\ExcelImportBulkStatusGensen;
use App\Models\Gensen\GensenExportImportHistory;
use App\Models\GensenForm\GensenForm;
use App\Repositories\Gensen\GensenExportImportHistoryRepository;
use App\Repositories\GensenForm\GensenFormRepository;
use App\Services\ImportService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ImportGensenJob implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $historyId;

    public function __construct($historyId)
    {
        $this->historyId = $historyId;
    }
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::beginTransaction();

        logger('START IMPORT');
        $history = GensenExportImportHistory::findOrFail($this->historyId);

        try {

            $history->update([
                'started_at' => now(),
                'status' => JobStatus::PROCESSING
            ]);
            event(new ExportImportStatusUpdated($history));
            Log::info('Broadcasting event', [
                'id' => $history->id,
                'job_key' => $history->job_key->value,
            ]);
            $import = new ExcelImportBulkStatusGensen();

            Excel::import(
                $import,
                Storage::disk($history->disk)->path($history->file_path)
            );

            // ambil data sesuai role + filter
            $data = app(ImportService::class)
                ->handle($history->job_key, $import);

            GensenExportImportHistory::updateById(
                $this->historyId,
                [
                    'status' => JobStatus::DONE,
                    'amount' => $data['success_count'],
                    'error_message' => json_encode($data['errors']),
                    'finish_at' => now(),
                ]
            );

            event(new ExportImportStatusUpdated($history));

            DB::commit();
        } catch (\Throwable $e) {

            DB::rollBack();

            GensenExportImportHistory::updateById(
                $this->historyId,
                [
                    'status' => JobStatus::FAILED,
                    'finish_at' => now(),
                    'error_message' => $e->getMessage(),
                ]
            );

            event(new ExportImportStatusUpdated($history));
            Log::info('Broadcasting event', [
                'id' => $history->id,
                'job_key' => $history->job_key->value,
            ]);

            throw $e;
        }
    }
}
