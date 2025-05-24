<?php

use App\Http\Controllers\DiscountController;
use App\Http\Controllers\DossierCustomerController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderSummary;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\TemporaryFileController;
use App\Http\Controllers\TribunalController;
use App\Models\Company;
use App\Models\ConditionVente;
use App\Models\DossierCustomer;
use App\Models\tmpBasket;
use App\Models\Basket;
use App\Models\Tribunal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use Stripe\PaymentMethod;
use Stripe\Stripe;
use Stripe\SetupIntent;
use Stripe\PaymentIntent;
use App\Http\Controllers\PondUploadController;





//ENVOI ID DIRECTORY
Route::get('/uploadfile', function () { return redirect('account'); });



Route::get('/uploadfile/{directory}', function ($directory) { $isEditable = DossierCustomer::where('directory_id',$directory)->first();
    $canEdit = (!$isEditable) ? 'yes' : ($isEditable->validSend === 'validSent' ? 'no' : 'yes');



    return view('account.upload', ['directory'=> $directory, 'canEdit'=> $canEdit]); });

Route::post('/uploadfile', function (Request $request) {

    $isEditable = DossierCustomer::where('directory_id',$request->input('directory'))->first();
    $canEdit = (!$isEditable) ? 'yes' : ($isEditable->validSend === 'validSent' ? 'no' : 'yes');
    session(['directory' => $request->input('directory')]);
    $directory = session('directory');



    if(Auth::check() && Auth::user()->role === 'admin')
    {
        $isAdmin = "isAdmin";
    }
    else
    {
        $isAdmin = "isNotAdmin";
    }

    
    //dd($isAdmin);
        return view('account.upload', ['directory' => $directory, 'canEdit' => $canEdit, 'isAdmin' => $isAdmin, 'order_name'=> $request->input('order_name')]);

});

//TELECHARGER ARCHIVE DOSSIER CLIENT ZIP
Route::get('/download-files/{folder}', [FileController::class, 'downloadAllFiles'])->name('download.all.files');


//VOIR DETAIL DE LA COMMANDE
Route::get('/account/orders/{orderId}', [OrderSummary::class, 'show'])->name('account.orders.detail')->middleware('auth');
//VOIR PDF DE LA COMMANDE
Route::get('/account/orders/{orderId}/invoice', [OrderSummary::class, 'downloadInvoicePdf'])->name('account.orders.invoice')->middleware('auth');

//SUBMIT ADDRESS ET TRIBUNAL

//ADRESSE TRIBUNAL
Route::post('/submitTribunal', [DossierCustomerController::class, 'submitTribunal'])->name('submit.tribunal');
//ADRESSE COMPAGNIE
Route::post('/submitAddress', [DossierCustomerController::class, 'submitAddress'])->name('submit.address');
//VALIDATION ENVOI DES INFOS
Route::post('/validateInfos', [DossierCustomerController::class, 'validateInfos'])->name('validateInfos')->middleware('auth');

//Route::post('/validateInfos', function(Request $request) {
//    dd($request->all());
//})->name('validateInfos');

//Route::get('/validateInfos/{tribTxt}', function ($tribTxt) {
//    dd($tribTxt);
//})->name('validateInfos');

Route::get('/dossiersent', function () { return view('account.dossierSent'); })->name('account.dossierSent')->middleware('auth');

Route::get('/validateInfos/{tribTxt}', [DossierCustomerController::class, 'validateInfosTrib'])->name('validateInfosTrib')->middleware('auth');


Route::get('/enterTribunal', [TribunalController::class, 'enterTribunal'])
    ->name('account.enterTribunal')
    ->middleware('auth');


//POND
Route::post('/send/{directory}', [PondUploadController::class, 'store'])->name('send.store');
Route::get('/files/{directory}/{canEdit}', [PondUploadController::class, 'index'])->name('files.index');
Route::delete('/files/delete', [PondUploadController::class, 'delete'])->name('files.delete');
Route::delete('/revert', [PondUploadController::class, 'revert'])->name('revert');


Route::get('/dossiers/form/', [DossierCustomerController::class, 'showForm'])->name('account.enterAddress')->middleware('auth');
Route::post('/dossiers/store', [DossierCustomerController::class, 'store'])->name('dossiers.store');
Route::post('/dossiers/validate/{id}', [DossierCustomerController::class, 'validateDossier'])->name('dossiers.validate');



Route::post('/enterAddress', [DossierCustomerController::class, 'hasValid'])->name('address');
Route::get('/enterAddress', function () {
    // Récupérer la chaîne de la session
    // Récupérer la chaîne de la session
    $directory = session('directory');

    // Extraire les 11 derniers caractères de la chaîne
    $order_id = substr($directory, -11);

    // Rechercher l'enregistrement en base de données
    $company = Company::where('order_id', $order_id)->first();


    // Afficher les données de $company pour débogage
    dd($company);

    // Rendre la vue avec les données de $company
    return view('account.enterAddress', compact('company'));
})->name('send.address');

Route::post('/enterInfoAddress', function (Request $request) { return view('account.enterAddress', ['directory'=>$request->input('directory')]); })->name('send.infoaddress');
//Route::post('/enterAddress', function (Request $request) {
//    return view('account.enterAddress', ['directory'=> $request->input('directory'), 'hasValid'=> $request->input('hasValid')]);
//});



//COMPTE CLIENT
Route::get('account', [\App\Http\Controllers\OrderSummary::class, 'index'])->name('account');


//PASSWORD
Route::get('password/forgot', [PasswordResetController::class, 'showForgotForm'])->name('password.request');
Route::post('password/forgot', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
Route::get('password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [PasswordResetController::class, 'resetPassword'])->name('password.update');


Route::get('dossier/{id}', [\App\Http\Controllers\OrderSummary::class, 'dossier'] )->name('dossier');


Route::get('/login/{action?}', function ($action = null) {
    return view('register', compact('action'));
})->name('login');


Route::post('/cancelSubs', [OrderController::class, 'cancelSubscription'])->name('cancelSubs');
//Route::get('/stripe/webhook', [StripeWebhookController::class, 'index']);
Route::post('/stripe/webhook', [StripeWebhookController::class, 'webhook']);

Route::get('/', function () { return view('home'); })->name('home');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::get('/login', function () { return view('register'); })->name('login');
Route::post('/login',[\App\Http\Controllers\LoginController::class, 'create'])->name('login-check');

Route::post('/apply-discount', [DiscountController::class, 'applyDiscount']);

Route::get('/register', [\App\Http\Controllers\RegisterController::class, 'index'])->name('registerindex');
Route::post('/register', [\App\Http\Controllers\RegisterController::class, 'store'])->name('register');

Route::get('/order-init', [\App\Http\Controllers\OrderController::class, 'index'])->middleware('auth')->name('order-init');
Route::post('/order-resume', [\App\Http\Controllers\OrderController::class, 'create'])->middleware('auth')->name('order-resume');
Route::get('/order-resume', function () { return view('order-init'); })->middleware('auth')->name('order-init');

Route::get('/page-expired', function () {
    return view('home'); // Créez une vue personnalisée pour la page expirée
})->name('page.expired');


Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('ls', function () {
    return view('localstorage');
});

Route::post('/payment', function (Request $request) {


 

    $series1 = mt_rand(100, 999);
    $series2 = mt_rand(100, 999);
    $series3 = mt_rand(100, 999);

    $randomNumber = $series1 . '-' . $series2 . '-' . $series3;

    $selectedCity = $request->input('selected_city');

    list($cityCode, $cityCodePrice) = explode('@', $selectedCity);

   
    $date = new DateTime();

// Ajoute 3 mois à la date actuelle
    $date->modify('+3 months');

// Convertit la date modifiée en une chaîne de caractères (optionnel)
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
});

Route::get('/payment', function () {

    if (!isset($toPay)) {
        // Rediriger l'utilisateur vers une page d'erreur ou une autre page
        return redirect()->route('login')->with('error', 'Le montant à payer est indéfini.');
    }

    $user = auth()->user();

    // Configure Stripe
    Stripe::setApiKey(env('STRIPE_SECRET'));

    // Create Setup Intent
    $setupIntent = SetupIntent::create([
        'customer' => $user->stripe_id,
    ]);

    return view('payment', [
        'intent' => $setupIntent,

    ]);
})->name('payment');


Route::post('/subscribe', function (Request $request) {
    $user = $request->user();

    // Stripe setup
    Stripe::setApiKey(env('STRIPE_SECRET'));

    // Attach the PaymentMethod to the customer
    $paymentMethodId = $request->input('payment_method');

    $user->createOrGetStripeCustomer();
    $stripeCustomer = $user->asStripeCustomer();

   // $stripeCustomer->invoice_settings->default_payment_method = $paymentMethod;
   // $stripeCustomer->save();

    // Récupère la méthode de paiement et l'attache au client
    $paymentMethod = PaymentMethod::retrieve($paymentMethodId);
    $paymentMethod->attach(['customer' => $stripeCustomer->id]);

    // Définir la méthode de paiement par défaut pour les factures
    $stripeCustomer->invoice_settings = [
        'default_payment_method' => $paymentMethodId,
    ];
    $stripeCustomer->save();


    // Charge initial fee
    if($request->input('aboState')==='active')
    {
        $aboPrice = 0;
    }
    else
    {
        $aboPrice = $request->input('aboPrice');
    }
    $amount = $request->input('is_subscribed') === "abo"
        ? ($request->input('toPay') - $aboPrice)*100
        : $request->input('toPay') * 100;

    $paymentIntent = PaymentIntent::create([
        'amount' => $amount, // 5000 cents = $50
        'currency' => 'eur',
        'customer' => $user->stripe_id,
        'payment_method' => $paymentMethod,
        'off_session' => true,
        'confirm' => true,
        'return_url' => route('payment.callback'),
        'metadata' => [
            'order_number' => $request->input('order_id'), // Ajoutez ici votre numéro de commande
            'mail' => $request->input('mail'),
        ],
    ]);



    $basket = Basket::where('order_id', $request->input('order_id'))->first();
    $basket->stripe_customer_id = $user->stripe_id;
    $basket->save();

    // Redirect if action is required
    if ($paymentIntent->status == 'requires_action' || $paymentIntent->status == 'requires_source_action') {
        return redirect($paymentIntent->next_action->redirect_to_url->url);
    }

    // DEBUT ABO
    // Create subscription

    if(($request->input('is_subscribed') === "abo")&&($request->input('aboState') != 'active')) {

        $subscription = $user->newSubscription('default', 'price_1Pn4i8CgUDmDw905fa0JrzeK')
            ->create($paymentMethod, [
                'email' => $user->email,
                'return_url' => route('subscription.callback'),
            ]);

        // Redirect to the return URL to confirm the subscription
        if ($subscription->hasIncompletePayment()) {
            return redirect($subscription->latestPayment()->next_action->redirect_to_url->url);
        }
    }
    // FIN ABO

    return redirect('/thankyou')->with('success', 'Subscription successful!');
})->name('subscribe'); //this one

Route::get('/subscription/callback', function (Request $request) {
    // Handle the subscription callback
    return redirect('/home')->with('success', 'Subscription and initial fee payment successful!');
})->name('subscription.callback');

Route::get('/payment/callback', function (Request $request) {
    // Handle the payment callback
    // You can add your logic to confirm the payment and proceed with the subscription creation
    return redirect('/thankyou')->with('success', 'Initial fee payment successful!');
})->name('payment.callback');

Route::get('/thankyou', function () {
    return view('thankyou');
});
