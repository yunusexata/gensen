<?php

namespace App\Observers;

use App\Enums\Gensen\EmailLogStatus;
use App\Mail\Admin\ClientNewSubmission;
use App\Mail\GensenFormCreatedMail;
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
        SendEmailLogRepository::create(
            [
                'subject_type' => GensenForm::class,
                'subject_id' => $gensenForm->id,
                'email' => $gensenForm->getPicAttribute()->email,
                'mailable' => ClientNewSubmission::class,
                'subject_line' => "{$gensenForm->getPicAttribute()->name} Data Dibuat: {$gensenForm->nama_lengkap}",
                'status' => EmailLogStatus::PENDING,
                'queued_at' => now(),
            ]
        );
        SendEmailLogRepository::create(
            [
                'subject_type' => GensenForm::class,
                'subject_id' => $gensenForm->id,
                'email' => $gensenForm->email,
                'mailable' => GensenFormCreatedMail::class,
                'subject_line' => 'Data Gensen : Berkas Tersimpan',
                'status' => EmailLogStatus::PENDING,
                'queued_at' => now(),
            ]
        );
    }

    /**
     * Handle the GensenForm "updated" event.
     */
    public function updated(GensenForm $gensenForm): void
    {
        logger([
            'email katerogi',
            $gensenForm->status
        ]);
        match ($gensenForm->status) {
            GensenForm::STATUS_LENGKAP => SendEmailLogRepository::create(
                [
                    'subject_type' => GensenForm::class,
                    'subject_id' => $gensenForm->id,
                    'email' => $gensenForm->email,
                    'mailable' => GensenFormStatusLengkapMail::class,
                    'subject_line' => 'Update Gensen : Berkas Diterima',
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
                    'subject_line' => 'Update Gensen : Verifikasi Berhasil',
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
                    'subject_line' => 'Update Gensen : Berkas Dalam Pengajuan ke Kantor Pajak Jepang',
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
                    'subject_line' => 'Update Gensen : Proses Pengajuan Gensen di Cancel',
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
                    'subject_line' => 'Update Gensen : Uang Gensen Berhasil Cair',
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
                    'subject_line' => 'Update Gensen : Proses Pencairan gensen masuk kategori Honnin Kouza',
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
