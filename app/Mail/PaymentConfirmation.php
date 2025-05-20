<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $amountPaid;
    public $orderId;
    /**
     * Create a new message instance.
     */
    public function __construct($amountPaid, $orderId)
    {
        $this->amountPaid = $amountPaid;
        $this->orderId = $orderId;

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[CoursierJuridique] - Confirmation du paiement de votre commande',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.payment_confirmation',
            with: [
              // 'amountPaid' => $this->amountPaid,
                'orderId' => $this->orderId,
               // 'messageMail' => $this->messageMail,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
