<?php

namespace App\Jobs;

use App\Enums\Gensen\EmailLogStatus;
use App\Enums\Gensen\JobStatus;
use App\Helpers\AppLog;
use App\Mail\GensenFormCreatedMail;
use App\Models\GensenForm\GensenForm;
use App\Models\Service\SendEmailLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;
    public function __construct(public SendEmailLog $log) {}

    public function handle()
    {
        $this->log->update([
            'status' => EmailLogStatus::SENDING,
            'started_at' => now(),
            'attempts' => $this->log->attempts + 1,
        ]);

        try {
            Mail::to($this->log->email)->send(new $this->log->mailable($this->log));

            AppLog::info(
                'Success sent Email Job',
                'job_send_email',
                [],
                [
                    'send_email_log_id' => $this->log->id,
                    'mail_to' => $this->log->email,
                ],
            );
            $this->log->update([
                'status' => EmailLogStatus::SENT,
                'finished_at' => now(),
            ]);
        } catch (\Throwable $e) {

            $this->log->update([
                'status' => EmailLogStatus::FAILED,
                'error_message' => $e->getMessage(),
                'finished_at' => now(),
            ]);

            throw $e;
        }
    }


    public function failed(?Throwable $e): void
    {
        $this->log->update([
            'status' => EmailLogStatus::FAILED,
            'finished_at' => now(),
            'error_message' => $e->getMessage(),
        ]);
    }
}
