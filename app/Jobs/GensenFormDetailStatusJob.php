<?php

namespace App\Jobs;

use App\Enums\Gensen\GensenFormDetailStatus;
use App\Enums\Gensen\JobStatus;
use App\Helpers\AppLog;
use App\Models\GensenForm\GensenForm;
use App\Models\GensenForm\GensenFormDetailLog;
use App\Repositories\GensenForm\GensenFormDetailRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;
use Throwable;

class GensenFormDetailStatusJob implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;
    public function __construct(public GensenFormDetailLog $log) {}

    public function handle()
    {
        $this->log->update([
            'job_status' => JobStatus::PROCESSING,
            'started_at' => now(),
            'attempts' => $this->log->attempts + 1,
        ]);

        try {

            if ($this->log->status === GensenFormDetailStatus::ROLLBACK->value) {
                logger('masuk rollback');
                GensenFormDetailRepository::rollback($this->log->subject_id, GensenForm::STATUS_DALAM_PENGAJUAN);
            }

            AppLog::info(
                'Success Process Detail Status',
                'job_update_gensen_form_detail_status',
                [
                    'subject_id' => $this->log->subject_id,
                    'subject_type' => $this->log->subject_type,
                ],
                [
                    'gensen_form_detail_status_job_id' => $this->log->id,
                ],
            );
            $this->log->update([
                'job_status' => JobStatus::DONE,
                'finished_at' => now(),
            ]);
        } catch (\Throwable $e) {

            $this->log->update([
                'job_status' => JobStatus::FAILED,
                'error_message' => $e->getMessage(),
                'finished_at' => now(),
            ]);

            throw $e;
        }
    }


    public function failed(?Throwable $e): void
    {
        $this->log->update([
            'job_status' => JobStatus::FAILED,
            'finished_at' => now(),
            'error_message' => $e->getMessage(),
        ]);
    }
}
