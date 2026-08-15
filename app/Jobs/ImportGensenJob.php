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
use Exception;
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
        // DB::beginTransaction();
        $history = GensenExportImportHistory::findOrFail($this->historyId);

        try {

            $history->update([
                'started_at' => now(),
                'status' => JobStatus::PROCESSING
            ]);
            $import = new ExcelImportBulkStatusGensen();
            $disk = Storage::disk($history->disk);
            $tmpDir = storage_path('app/private/imports/gensen');

            if (!is_dir($tmpDir)) {
                mkdir($tmpDir, 0777, true);
            }

            $fileName = $history->job_key->value . '_' . time() . '.xlsx';

            $tmpPath = $tmpDir . '/' . $fileName;
            $readStream = $disk->readStream($history->file_path);

            if (!is_resource($readStream)) {
                throw new Exception("Cannot read remote Excel file");
            }

            $writeStream = fopen($tmpPath, 'w');

            stream_copy_to_stream($readStream, $writeStream);

            fclose($readStream);
            fclose($writeStream);
            Excel::import($import, $tmpPath);

            // ambil data sesuai role + filter
            $data = app(ImportService::class)
                ->handle($history->job_key, $import);

            $history->update([
                'status' => JobStatus::DONE,
                'amount' => $data['success_count'],
                'error_message' => json_encode($data['errors']),
                'customer_ids' => $data['customer_ids'] ?? [],
                'finish_at' => now(),
            ]);
            // DB::commit();
            broadcast(
                new ExportImportStatusUpdated(
                    $history
                )
            );
        } catch (\Throwable $e) {

            // DB::rollBack();
            $history->update([
                'status' => JobStatus::FAILED,
                'error_message' => $e->getMessage(),
            ]);

            broadcast(new ExportImportStatusUpdated($history));
            throw $e;
        }
    }
}
