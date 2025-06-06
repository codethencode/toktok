<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Basket;

class DossierResetNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $user;

    public function __construct($user, Basket $order)
    {
        $this->user = $user;
        $this->order = $order;
    }

    public function build()
    {

        // dd($this->user, $this->order);
         $subject = '[ '.config('app.domain').' ] . Réinitialisation de votre dossier - Réf. ' .  strtoupper($this->order->order_name) . ' - cde. ' .$this->order->order_id;

        return $this->subject($subject)
                    ->view('emails.reset_dossier')
                    ->with([
                        'user' => $this->user,
                        'order' => $this->order,
                    ]);
        }
}
