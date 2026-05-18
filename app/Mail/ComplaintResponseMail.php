<?php

namespace App\Mail;

use App\Models\Complaint;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ComplaintResponseMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly Complaint $complaint,
        public readonly string $responseText,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Respuesta a su denuncia — Folio #' . $this->complaint->id,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.complaint-response',
        );
    }
}
