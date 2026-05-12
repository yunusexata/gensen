<?php

namespace App\Mail;

use App\Models\GensenForm\GensenForm;
use App\Models\Service\SendEmailLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GensenFormStatusGensenCairMail extends Mailable
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
        logger('mail created cair');
        return new Content(
            view: 'app.gensen.emails.status_gensen_cair',
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
