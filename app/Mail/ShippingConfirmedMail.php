<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;

class ShippingConfirmedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $basket;
    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct($basket, $data)
    {
        $this->basket = $basket;
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '['.config('app.domain').'] Votre dossier ref: ' . $this->basket->order_name . ' a été expédiée'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.shipping_confirmed', // ta vue
            with: [
                'basket' => $this->basket,
                'data' => $this->data,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        if (!empty($this->data['proof_path'])) {
            return [
                Attachment::fromPath(storage_path('app/public/' . $this->data['proof_path']))
                    ->as('preuve_depot.pdf'),
            ];
        }

        return [];
    }
}
