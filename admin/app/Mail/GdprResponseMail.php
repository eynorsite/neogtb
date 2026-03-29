<?php

namespace App\Mail;

use App\Models\GdprRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GdprResponseMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public GdprRequest $gdprRequest) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Réponse à votre demande RGPD — NeoGTB",
            replyTo: ['rgpd@neogtb.fr'],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.gdpr-response',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
