<?php

namespace App\Observers;

use App\Enums\Gensen\GensenFormDetailStatus;
use App\Enums\Gensen\JobStatus;
use App\Models\GensenForm\GensenFormDetail;
use App\Repositories\GensenForm\GensenFormDetailLogRepository;

class GensenFormDetailObserver
{
    /**
     * Handle the GensenFormDetail "created" event.
     */
    public function created(GensenFormDetail $gensenFormDetail): void {}

    /**
     * Handle the GensenFormDetail "updated" event.
     */
    public function updated(GensenFormDetail $gensenFormDetail): void
    {
        if (! $gensenFormDetail->wasChanged('status')) {
            return;
        }
        logger([
            'status gensen form detail tarik data',
            $gensenFormDetail->status
        ]);
        match ($gensenFormDetail->status) {
            GensenFormDetailStatus::CANCEL => GensenFormDetailLogRepository::create(
                [
                    'subject_type' => GensenFormDetail::class,
                    'subject_id' => $gensenFormDetail->id,
                    'status' => $gensenFormDetail->status->value,
                    'keterangan' => $gensenFormDetail->keterangan,
                    'job_status' => JobStatus::PENDING,

                ]
            ),
            GensenFormDetailStatus::ROLLBACK => GensenFormDetailLogRepository::create(
                [
                    'subject_type' => GensenFormDetail::class,
                    'subject_id' => $gensenFormDetail->id,
                    'status' => $gensenFormDetail->status->value,
                    'keterangan' => $gensenFormDetail->keterangan,
                    'job_status' => JobStatus::PENDING,

                ]
            ),
            default => null,
        };
    }

    /**
     * Handle the GensenFormDetail "deleted" event.
     */
    public function deleted(GensenFormDetail $gensenFormDetail): void
    {
        //
    }

    /**
     * Handle the GensenFormDetail "restored" event.
     */
    public function restored(GensenFormDetail $gensenFormDetail): void
    {
        //
    }

    /**
     * Handle the GensenFormDetail "force deleted" event.
     */
    public function forceDeleted(GensenFormDetail $gensenFormDetail): void
    {
        //
    }
}
