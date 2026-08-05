<?php

namespace App\Mail\Admin;

use App\Helpers\AppLog;
use App\Models\GensenForm\GensenForm;
use App\Models\Service\SendEmailLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ClientAttachmentUploaded extends Mailable
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
        $data = json_decode($this->log->data, true);
        $attachments = $this->log->subject->attachments->where('upload_batch_id', $data['upload_batch_id']);
        AppLog::info(
            'Success Create Email',
            'mail_client_attachment_uploaded',
            [],
            [
                'subject_id' => $this->log->subject_id,
                'subject_type' => $this->log->subject_type,
                'subject' => $this->log->subject_line,
            ],
        );
        return new Content(
            view: 'app.gensen.emails.admin.client_attachment_uploaded',
            with: [
                'form' => $this->log->subject,
                'attachments' => $attachments,
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
