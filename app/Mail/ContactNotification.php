<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;

class ContactNotification extends Mailable
{
    public function __construct(public array $data)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[ ToqueToque.net ] - Nouvelle demande de contact',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact_notification',
        );
    }
}