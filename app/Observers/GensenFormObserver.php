<?php

namespace App\Observers;

use App\Enums\Gensen\EmailLogStatus;
use App\Jobs\SendEmailJob;
use App\Jobs\SendGensenFormCreatedEmailJob;
use App\Mail\GensenFormStatusCancelMail;
use App\Mail\GensenFormStatusDalamPengajuanMail;
use App\Mail\GensenFormStatusGensenCairMail;
use App\Mail\GensenFormStatusHonninMail;
use App\Mail\GensenFormStatusLengkapMail;
use App\Mail\GensenFormStatusVerifiedMail;
use App\Models\GensenForm\GensenForm;
use App\Repositories\Service\SendEmailLogRepository;

class GensenFormObserver
{
    /**
     * Handle the GensenForm "created" event.
     */
    public function created(GensenForm $gensenForm): void
    {
        if ($gensenForm->is_should_filled) {
            // SendEmailJob::dispatch($gensenForm);
        }
    }

    /**
     * Handle the GensenForm "updated" event.
     */
    public function updated(GensenForm $gensenForm): void
    {
        match ($gensenForm->status) {
            GensenForm::STATUS_LENGKAP => SendEmailLogRepository::create(
                [
                    'subject_type' => GensenForm::class,
                    'subject_id' => $gensenForm->id,
                    'email' => $gensenForm->email,
                    'mailable' => GensenFormStatusLengkapMail::class,
                    'subject_line' => 'Gensen Update : Berkas Diterima',
                    'status' => EmailLogStatus::PENDING,
                    'queued_at' => now(),
                ]
            ),
            GensenForm::STATUS_VERIFIED => SendEmailLogRepository::create(
                [
                    'subject_type' => GensenForm::class,
                    'subject_id' => $gensenForm->id,
                    'email' => $gensenForm->email,
                    'mailable' => GensenFormStatusVerifiedMail::class,
                    'subject_line' => 'Gensen Update : Verifikasi Berhasil',
                    'status' => EmailLogStatus::PENDING,
                    'queued_at' => now(),
                ]
            ),
            GensenForm::STATUS_DALAM_PENGAJUAN => SendEmailLogRepository::create(
                [
                    'subject_type' => GensenForm::class,
                    'subject_id' => $gensenForm->id,
                    'email' => $gensenForm->email,
                    'mailable' => GensenFormStatusDalamPengajuanMail::class,
                    'subject_line' => 'Gensen Update : Berkas Dalam Pengajuan ke Kantor Pajak Jepang',
                    'status' => EmailLogStatus::PENDING,
                    'queued_at' => now(),
                ]
            ),
            GensenForm::STATUS_CANCEL => SendEmailLogRepository::create(
                [
                    'subject_type' => GensenForm::class,
                    'subject_id' => $gensenForm->id,
                    'email' => $gensenForm->email,
                    'mailable' => GensenFormStatusCancelMail::class,
                    'subject_line' => 'Gensen Update : Proses Pengajuan Gensen di Cancel',
                    'status' => EmailLogStatus::PENDING,
                    'queued_at' => now(),
                ]
            ),
            GensenForm::STATUS_GENSEN_CAIR => SendEmailLogRepository::create(
                [
                    'subject_type' => GensenForm::class,
                    'subject_id' => $gensenForm->id,
                    'email' => $gensenForm->email,
                    'mailable' => GensenFormStatusGensenCairMail::class,
                    'subject_line' => 'Gensen Update : Uang Gensen Berhasil Cair!',
                    'status' => EmailLogStatus::PENDING,
                    'queued_at' => now(),
                ]
            ),
            GensenForm::STATUS_HONNIN => SendEmailLogRepository::create(
                [
                    'subject_type' => GensenForm::class,
                    'subject_id' => $gensenForm->id,
                    'email' => $gensenForm->email,
                    'mailable' => GensenFormStatusHonninMail::class,
                    'subject_line' => 'Gensen Update : Proses Pencairan gensen masuk kategori Honnin Kouza',
                    'status' => EmailLogStatus::PENDING,
                    'queued_at' => now(),
                ]
            ),
            default => null,
        };
    }

    /**
     * Handle the GensenForm "deleted" event.
     */
    public function deleted(GensenForm $gensenForm): void
    {
        //
    }

    /**
     * Handle the GensenForm "restored" event.
     */
    public function restored(GensenForm $gensenForm): void
    {
        //
    }

    /**
     * Handle the GensenForm "force deleted" event.
     */
    public function forceDeleted(GensenForm $gensenForm): void
    {
        //
    }
}
