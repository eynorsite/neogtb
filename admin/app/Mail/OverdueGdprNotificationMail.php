<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class OverdueGdprNotificationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Collection $requests) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: '[NeoGTB] Demandes RGPD en retard - Action requise');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.overdue-gdpr', with: ['requests' => $this->requests]);
    }
}
