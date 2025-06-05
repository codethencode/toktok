<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\{
    DiscountController,
    DossierCustomerController,
    FileController,
    LoginController,
    OrderController,
    OrderSummary,
    PasswordResetController,
    PondUploadController,
    StripeWebhookController,
    TribunalController,
    RegisterController,
    PaymentController,
    ContactController,
    AdminContactController,
    PartenaireController
};

use App\Models\{
    Basket,
    Company,
    ConditionVente,
    DossierCustomer,
    Tribunal
};

use Stripe\{PaymentIntent, PaymentMethod, SetupIntent, Stripe};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

// ================= HOME =================
Route::view('/', 'home')->name('home');
Route::view('/thankyou', 'thankyou');
Route::view('/page-expired', 'home')->name('page.expired');
Route::view('ls', 'localstorage');

// ================= AUTH & ACCOUNT =================
Route::get('/login/{action?}', fn($action = null) => view('register', compact('action')))->name('login');
Route::get('/register', [RegisterController::class, 'index'])->name('registerindex');
Route::post('/register', [RegisterController::class, 'store'])->name('register');
Route::post('/login', [LoginController::class, 'create'])->name('login-check');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/account', [OrderSummary::class, 'index'])->name('account');
Route::post('/account/orders/search', [OrderSummary::class, 'index'])->name('account.orders.search');
Route::get('/account/orders/{orderId}', [OrderSummary::class, 'show'])->name('account.orders.detail')->middleware('auth');
Route::get('/account/orders/{orderId}/invoice', [OrderSummary::class, 'downloadInvoicePdf'])->name('account.orders.invoice')->middleware('auth');
Route::get('/account/orders/search', function () {
    return redirect('/order-init'); // ou ce que tu veux
});
// =================== CGV MENTIONS ==========
Route::get('/cgv', function () { return view('cgv');
})->name('cgv');
Route::get('/mentions-legales', function () { return view('mentions-legales');
})->name('mentions-legales');

// ================== FORM CONTACT ===========
Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
Route::get('/admin/messages', [AdminContactController::class, 'index'])->name('admin.messages');

// ================== PARTENAIRE ===============
Route::get('/devenir-partenaire', [PartenaireController::class, 'show'])->name('partenaire.show');
Route::post('/devenir-partenaire', [PartenaireController::class, 'submit'])->name('partenaire.submit');

// ================= ARTICLES ==================
Route::get('/articles/avocat-suppleant', function () { return view('articles.avocat-suppleant');
})->name('articles.avocat-suppleant');

Route::get('articles/externaliser-depot-dossier', function () { return view('articles.externaliser-depot-dossier');
})->name('articles.externaliser-depot-dossier');

Route::get('articles/logistique-juridique', function () { return view('articles.logistique-juridique');
})->name('articles.logistique-juridique');

// ================= PASSWORD RESET =================
Route::get('password/forgot', [PasswordResetController::class, 'showForgotForm'])->name('password.request');
Route::post('password/forgot', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
Route::get('password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [PasswordResetController::class, 'resetPassword'])->name('password.update');

// ================= COMMANDES / BASKET =================
Route::get('/order-init', [OrderController::class, 'index'])->middleware('auth')->name('order-init');
Route::post('/order-resume', [OrderController::class, 'create'])->middleware('auth')->name('order-resume');
Route::get('/order-resume', fn() => view('order-init'))->middleware('auth')->name('order-init');
Route::post('/resetDossier/{order_id}', [OrderController::class, 'resetDossier'])->name('dossier.reset');
Route::post('/cancelSubs', [OrderController::class, 'cancelSubscription'])->name('cancelSubs');
Route::get('/dossier/{id}', [OrderSummary::class, 'dossier'])->name('dossier');
Route::post('/orders/{order_id}/confirm-shipping', [OrderController::class, 'confirmShipping'])->name('orders.confirmShipping');
Route::post('/apply-discount', [DiscountController::class, 'applyDiscount'])->name('apply.discount');


// ================= ABONNEMENTS & STRIPE =================
Route::controller(PaymentController::class)->group(function () {
    Route::post('/payment', 'create')->name('payment.create');
    Route::get('/payment', 'show')->name('payment');
    Route::post('/subscribe', 'subscribe')->name('subscribe');
    Route::get('/payment/callback', 'paymentCallback')->name('payment.callback');
    Route::get('/subscription/callback', 'subscriptionCallback')->name('subscription.callback');
});
Route::post('/stripe/webhook', [StripeWebhookController::class, 'webhook']);

// ================= UPLOAD / FICHIERS =================
Route::get('/uploadfile', fn() => redirect('account'));
Route::post('/uploadfile', function (Request $request) {
    $directory = $request->input('directory');
    $order_name = $request->input('order_name');
    $isEditable = DossierCustomer::where('directory_id', $directory)->first();
    $canEdit = (!$isEditable || $isEditable->validSend !== 'validSent') ? 'yes' : 'no';
    $isAdmin = Auth::check() && Auth::user()->role === 'admin' ? 'isAdmin' : 'isNotAdmin';

    return view('account.upload', compact('directory', 'canEdit', 'isAdmin', 'order_name'));
});

Route::get('/uploadfile/{directory}', function ($directory) {
    $isEditable = DossierCustomer::where('directory_id', $directory)->first();
    $order_id = substr($directory, -11);
    $order_name = Basket::where('order_id', $order_id)->value('order_name');
    $canEdit = (!$isEditable || $isEditable->validSend !== 'validSent') ? 'yes' : 'no';
    return view('account.upload', compact('directory', 'canEdit', 'order_name'));
});

Route::get('/download-files/{folder}', [FileController::class, 'downloadAllFiles'])->name('download.all.files');
Route::post('/send/{directory}', [PondUploadController::class, 'store'])->name('send.store');
Route::get('/files/{directory}/{canEdit}', [PondUploadController::class, 'index'])->name('files.index');
Route::delete('/files/delete', [PondUploadController::class, 'delete'])->name('files.delete');
Route::delete('/revert', [PondUploadController::class, 'revert'])->name('revert');

// ================= DOSSIER INFOS / TRIBUNAL =================
Route::get('/enterTribunal', [TribunalController::class, 'enterTribunal'])->name('account.enterTribunal')->middleware('auth');
Route::get('/dossiersent', fn() => view('account.dossierSent'))->name('account.dossierSent')->middleware('auth');
Route::post('/submitTribunal', [DossierCustomerController::class, 'submitTribunal'])->name('submit.tribunal');
Route::post('/submitAddress', [DossierCustomerController::class, 'submitAddress'])->name('submit.address');
Route::post('/validateInfos', [DossierCustomerController::class, 'validateInfos'])->name('validateInfos')->middleware('auth');
Route::get('/validateInfos/{tribTxt}', [DossierCustomerController::class, 'validateInfosTrib'])->name('validateInfosTrib')->middleware('auth');

Route::get('/enterAddress', function () {
    $directory = session('directory');
    $order_id = substr($directory, -11);
    $company = Company::where('order_id', $order_id)->first();
    return view('account.enterAddress', compact('company'));
})->name('send.address');

Route::post('/enterAddress', [DossierCustomerController::class, 'hasValid'])->name('address');
Route::post('/enterInfoAddress', fn(Request $request) => view('account.enterAddress', ['directory' => $request->input('directory')]))->name('send.infoaddress');
Route::get('/dossiers/form/', [DossierCustomerController::class, 'showForm'])->name('account.enterAddress')->middleware('auth');
Route::post('/dossiers/store', [DossierCustomerController::class, 'store'])->name('dossiers.store');
Route::post('/dossiers/validate/{id}', [DossierCustomerController::class, 'validateDossier'])->name('dossiers.validate');
