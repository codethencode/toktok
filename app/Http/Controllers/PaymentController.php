<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{Basket, ConditionVente};
use Stripe\{Stripe, SetupIntent, PaymentIntent, PaymentMethod};

class PaymentController extends Controller
{
    public function create(Request $request)
    {
        $series1 = mt_rand(100, 999);
        $series2 = mt_rand(100, 999);
        $series3 = mt_rand(100, 999);
        $randomNumber = $series1 . '-' . $series2 . '-' . $series3;

        $selectedCity = $request->input('selected_city');
        list($cityCode, $cityCodePrice) = explode('@', $selectedCity);

        $date = new \DateTime();
        $date->modify('+3 months');
        $dateString = $date->format('Y-m-d H:i:s');

        $product = new Basket();

        $product->user_id = Auth::user()->id;
        $product->order_id = $randomNumber;
        $product->order_name = $request->input('orderName');
        $product->stripe_customer_id = '';
        $product->total_price = $request->input('total_price');
        $product->cityCode = $cityCode;
        $product->cityCodePrice = $cityCodePrice;
        $product->baseFeePrice = $request->input('baseFee');
        $product->numberOfPages = $request->input('number_of_pages');
        $product->printType = $request->input('print_type');
        $product->printTypePrice = $request->input('print_type_price');
        $product->reliureType = $request->input('reliure_type');
        $product->reliureTypePrice = $request->input('reliure_type_price');
        $product->isAbo = $request->input('is_subscribed');
        $product->aboPrice = $request->input('aboPrice');
        $product->plaideType = $request->input('selected_plaidoirie');
        $product->plaideTypePrice = $request->input('selected_plaidoirie_price');
        $product->juriType = $request->input('selected_juridiction');
        $product->juriTypePrice = $request->input('selected_juridiction_price');
        $product->isUrgent = $request->input('is_urgent');
        $product->urgentPrice = $request->input('urgencyPrice');
        $product->hasDiscount = $request->input('has_discount');
        $product->discountRebate = $request->input('codeRemisePercent');
        $product->dateEndAbo = $dateString;
        $product->isPaid = 'ko';
        $product->save();

        return view('payment', [
            'cgv' => ConditionVente::first(),
            'intent' => auth()->user()->createSetupIntent(),
            'toPay' => $request->input('total_price'),
            'is_subscribed' => $request->input('is_subscribed'),
            'aboPrice' => $request->input('aboPrice'),
            'aboState' => $request->input('aboState'),
            'order_id' => $randomNumber,
            'mail'=> Auth::user()->email,
        ]);
    }

    public function show()
    {
        if (!Auth::user()?->stripe_id) {
            return redirect()->route('login')->with('error', 'Le montant à payer est indéfini.');
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));
        $setupIntent = SetupIntent::create([
            'customer' => Auth::user()->stripe_id,
        ]);

        return view('payment', [
            'intent' => $setupIntent,
        ]);
    }

    public function subscribe(Request $request)
    {
        $user = $request->user();

        Stripe::setApiKey(env('STRIPE_SECRET'));
        $paymentMethodId = $request->input('payment_method');

        $user->createOrGetStripeCustomer();
        $stripeCustomer = $user->asStripeCustomer();

        $paymentMethod = PaymentMethod::retrieve($paymentMethodId);
        $paymentMethod->attach(['customer' => $stripeCustomer->id]);

        $stripeCustomer->invoice_settings = [
            'default_payment_method' => $paymentMethodId,
        ];
        $stripeCustomer->save();

        $aboPrice = $request->input('aboState') === 'active' ? 0 : $request->input('aboPrice');

        $amount = $request->input('is_subscribed') === "abo"
            ? ($request->input('toPay') - $aboPrice) * 100
            : $request->input('toPay') * 100;

        $paymentIntent = PaymentIntent::create([
            'amount' => $amount,
            'currency' => 'eur',
            'customer' => $user->stripe_id,
            'payment_method' => $paymentMethod,
            'off_session' => true,
            'confirm' => true,
            'return_url' => route('payment.callback'),
            'metadata' => [
                'order_number' => $request->input('order_id'),
                'mail' => $request->input('mail'),
            ],
        ]);

        $basket = Basket::where('order_id', $request->input('order_id'))->first();
        $basket->stripe_customer_id = $user->stripe_id;
        $basket->save();

        if (in_array($paymentIntent->status, ['requires_action', 'requires_source_action'])) {
            return redirect($paymentIntent->next_action->redirect_to_url->url);
        }

        if ($request->input('is_subscribed') === "abo" && $request->input('aboState') != 'active') {
            $subscription = $user->newSubscription('default', 'price_1Pn4i8CgUDmDw905fa0JrzeK')
                ->create($paymentMethod, [
                    'email' => $user->email,
                    'return_url' => route('subscription.callback'),
                ]);

            if ($subscription->hasIncompletePayment()) {
                return redirect($subscription->latestPayment()->next_action->redirect_to_url->url);
            }
        }

        return redirect('/thankyou')->with('success', 'Subscription successful!');
    }

    public function paymentCallback()
    {
        return redirect('/thankyou')->with('success', 'Initial fee payment successful!');
    }

    public function subscriptionCallback()
    {
        return redirect('/home')->with('success', 'Subscription and initial fee payment successful!');
    }
}
