<?php

namespace App\Mail;

use App\Helpers\AppLog;
use App\Models\GensenForm\GensenForm;
use App\Models\Service\SendEmailLog;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GensenFormCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public SendEmailLog $log
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->log->subject_line,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        AppLog::info(
            'Success Create Email',
            'mail_gensen_form_created',
            [],
            [
                'subject_id' => $this->log->subject_id,
                'subject_type' => $this->log->subject_type,
                'subject' => $this->log->subject_line,
            ],
        );
        return new Content(
            view: 'app.gensen.emails.status_created',
            with: [
                'form' => $this->log->subject,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
