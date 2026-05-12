<?php

namespace App\Jobs;

use App\Mail\GensenFormCreatedMail;
use App\Models\GensenForm\GensenForm;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendGensenFormCreatedEmailJob implements ShouldQueue
{
    use Queueable;

    public function __construct(public GensenForm $form) {}

    public function handle(): void
    {
        Mail::to($this->form->email)
            ->send(new GensenFormCreatedMail($this->form));
    }
}
