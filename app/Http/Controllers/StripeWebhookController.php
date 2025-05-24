<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentConfirmation;
use App\Mail\AdminNotification;
use App\Mail\PaymentFailed;
use Stripe\Stripe;
use Stripe\Event;
use App\Models\Basket;  // Assurez-vous que ce modèle correspond à votre table pour les commandes
use App\Models\Subscription;  // Assurez-vous que ce modèle correspond à votre table pour les souscriptions
use Illuminate\Support\Facades\Log;
use Stripe\Webhook as StripeWebhook;
use Stripe\Exception\SignatureVerificationException;

class StripeWebhookController extends Controller
{

    private $stripeWebhookSecret;

    public function __construct()
    {
        $this->stripeWebhookSecret = config('services.stripe.webhook_secret');
    }



    public function webhook()
    {

        

        $endpoint_secret = $this->stripeWebhookSecret;
       // $endpoint_secret = 'whsec_1d3657a80cc26449372d4274f1d8cc09bc477d5869875b460238d1661129fa7e';

        $payload = @file_get_contents('php://input');
        $event = null;

        Log::info('🔔 Webhook Stripe reçu', [
            'raw_payload' => $payload,
        ]);

        try {
            $event = \Stripe\Event::constructFrom(
                json_decode($payload, true)
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            echo '⚠️  Webhook error while parsing basic request.';
            http_response_code(400);
            exit();
        }
        if ($endpoint_secret) {
            // Only verify the event if there is an endpoint secret defined
            // Otherwise use the basic decoded event
            $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
            try {
                $event = \Stripe\Webhook::constructEvent(
                    $payload, $sig_header, $endpoint_secret
                );
            } catch (\Stripe\Exception\SignatureVerificationException $e) {
                // Invalid signature
                echo '⚠️  Webhook error while validating signature.';
                http_response_code(400);
                exit();
            }
        }


      //  Log::info('stripeReceived', ['triggerOrder' => $event->type]);


        // Handle the event
        switch ($event->type) {
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object; // contains a \Stripe\PaymentIntent

                // Assurez-vous que metadata et order_number existent
                if (isset($paymentIntent->metadata->order_number)) {
                    $order = $paymentIntent->metadata->order_number;
                } else {
                    Log::warning('Order number not found in PaymentIntent metadata.');
                    break;
                }

                //QUery


                // Récupérer l'utilisateur basé sur l'order_number ou une autre logique si nécessaire
                if (isset($paymentIntent->metadata->mail)) {
                    $customerMail = $paymentIntent->metadata->mail;
                } else {
                    Log::warning('Mail not found in PaymentIntent metadata.');
                    break;
                }

                Log::info('Stripe Webhook Received:', ['triggerOrder' => $order]);

                //session(['stripe' => 'paid']);

                return $this->handlePaymentSucceeded($event);
                break;

            case 'invoice.payment_succeeded':
             
                Log::info('✅ Paiement d’abonnement réussi');
                 // Appelle un handler si tu veux en faire un
                 return response('OK', 200);    


            default:
                // Unexpected event type
                Log::warning('📦 Événement Stripe non géré reçu', ['type' => $event->type]);
                return response('OK', 200);
        }

        return  http_response_code(200);

    }


    protected function handlePaymentSucceeded($event)
{
    try {
        $invoice = $event->data->object;

        Log::info('▶️ handlePaymentSucceeded() appelé');

        $orderId = $invoice->metadata->order_number ?? null;
        $customerMail = $invoice->metadata->mail ?? null;
        $subscriptionId = $invoice->subscription ?? null;
        $amountPaid = $invoice->amount_received / 100;
        $customerEmail = $invoice->customer_email;

        Log::info('ℹ️ Données extraites', [
            'order_id' => $orderId,
            'mail' => $customerMail,
            'subscription_id' => $subscriptionId,
            'amount_paid' => $amountPaid
        ]);

        $order = Basket::where('order_id', $orderId)->first();
        if (!$order) {
            Log::warning("⚠️ Aucun panier trouvé pour order_id: $orderId");
            return response('OK', 200);
        }

        $order->isPaid = 'ok';
        $order->save();

        if ($subscriptionId) {
            $subscription = Subscription::where('stripe_subscription_id', $subscriptionId)->first();
            if ($subscription) {
                $subscription->isActive = 'active';
                $subscription->save();
            }
        }

        if ($order->sendMail === 'ko') {
            if ($customerMail) {
                Mail::to($customerMail)->send(new PaymentConfirmation($amountPaid, $orderId));
            }

            $adminEmail = config('mail.admin_email');
            Mail::to($adminEmail)->send(new AdminNotification($amountPaid, $orderId, $subscriptionId));

            $order->sendMail = 'ok';
            $order->save();
        }

        return response('OK', 200);

    } catch (\Throwable $e) {
        Log::error('💥 Erreur dans handlePaymentSucceeded : ' . $e->getMessage(), [
            'trace' => $e->getTraceAsString()
        ]);
        return response('Erreur webhook', 500);
    }
}



    /*
    protected function handlePaymentSucceeded($event)
    {
        //Log::info('Stripe Webhook Received:', ['triggerEvent' => $event]);
        $invoice = $event->data->object; // L'objet invoice

        

        if($invoice==='subscription')
        {
            Log::info('Stripe Webhook Received:', ['triggerEvent' => 'suscription']);
        }
        else
        {
            Log::info('Stripe Webhook Received:', ['triggerEvent' => 'intent']);
        }

        // Récupérer les metadata
        $orderId = $invoice->metadata->order_number ?? null;
        $customerMail = $invoice->metadata->mail ?? null;
        $subscriptionId = $invoice->subscription ?? null;


        Log::info('Stripe Webhook Received:', ['trigger' => $customerMail]);

        // Récupérer le montant payé
        $amountPaid = $invoice->amount_received / 100; // Stripe retourne les montants en cents
        Log::info('Stripe Webhook Received:', ['trigger' => $amountPaid]);

        // Récupérer l'e-mail du client
        $customerEmail = $invoice->customer_email;

        // Mise à jour de la table Order (ou autre nom de la table)
        $order = Basket::where('order_id', $orderId)->first();
        if ($order) {
            $order->isPaid = 'ok';
            $order->save();
        }

        // Mise à jour de la table Subscription (si subscriptionId est présent)
        if ($subscriptionId) {
            $subscription = Subscription::where('stripe_subscription_id', $subscriptionId)->first();
            if ($subscription) {
                $subscription->isActive = 'active';
                $subscription->save();
            }
        }

        if($order->sendMail==='ko') {

            // Envoyer l'e-mail de confirmation au client
            if ($customerMail) {
                Mail::to($customerMail)->send(new PaymentConfirmation($amountPaid, $orderId));
            }

            // Envoyer l'e-mail à l'administrateur
            $adminEmail = config('mail.admin_email');
            Mail::to($adminEmail)->send(new AdminNotification($amountPaid, $orderId, $subscriptionId));

            $order->sendMail = 'ok';
            $order->save();
        }
    }
*/
    protected function handlePaymentFailed($event)
    {
        $invoice = $event->data->object;
        $amountPaid = $invoice->amount_received / 100;

        // Récupérer les metadata
        $orderId = $invoice->metadata->order_number ?? null;

        // Récupérer l'e-mail du client
        $customerEmail = $invoice->customer_email;

        // Envoyer l'e-mail de notification d'échec au client
        if ($customerEmail) {
            Mail::to($customerEmail)->send(new PaymentFailed($amountPaid, $orderId));
        }

        // Vous pouvez également envoyer une notification à l'administrateur si nécessaire
        $adminEmail = config('mail.admin_email');
        Mail::to($adminEmail)->send(new AdminNotification(0, $orderId, null, 'failed'));
    }
}
