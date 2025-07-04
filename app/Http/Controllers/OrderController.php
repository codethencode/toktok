<?php

namespace App\Http\Controllers;

use App\Models\Plaidoirie;
use App\Models\TypeExpedition;
use App\Models\TypeImpression;
use App\Models\TypeReliure;
use App\Models\Subscription;
use App\Models\User;
use App\Models\DossierCustomer;
use App\Models\ZoneGeo;
use App\Models\BaseFee;
use App\Models\OptionPrice;
use App\Models\Basket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Mail;
use App\Mail\ShippingConfirmedMail;
use Illuminate\Support\Facades\Storage;
//use Stripe\Subscription;
use App\Mail\DossierResetNotification;
use App\Mail\UnsubscribedConfirmation;

class OrderController extends Controller
{
    //
    public function index(){

        //GET PRICES
        // $typeImpressions = TypeImpression::all();
        // $typeReliures   = TypeReliure::all();
        // $typeExpeditions = TypeExpedition::all();
        // $typePlaidoiries = Plaidoirie::take(6)->get();
        // $typeJuridictions = Plaidoirie::skip(6)->take(3)->get();
        // $zone_geos = ZoneGeo::all();
        
        $baseFees = BaseFee::all();
        $aboStateQuery = Subscription::where('user_id', Auth::id())->first();

        if(!$aboStateQuery) { $aboState = "nothing"; }
        elseif ($aboStateQuery['stripe_status']=="active") { $aboState = "active"; }
        else { $aboState ="inactive"; }

        //dd($aboState);

        $baseFeePrice = $baseFees[0]->price;
        $baseFeeDesc = $baseFees[0]->description;

        $baseAboPrice = $baseFees[1]->price;
        $baseAboDesc = $baseFees[1]->description;

        $baseUrgentPrice = $baseFees[2]->price;
        $baseUrgentDesc = $baseFees[2]->description;



        //JE VIENS DE RASSEMBLER TTES LES OPTIONS DANS UNE SEULE TABLE : options_prices

        //RECUP PRICES
        $getOptions = OptionPrice::all();

        //dd($typeImpressions);
        //dd($getOptions);

        //dd($baseAboPrice);
        //$baseFeePrice = $baseFees->first()->price;
        //dd($typePlaidoiries);


        //$priceExpress = OptionPrice::where('code', 'extra_02')->value('price');
        //$descExpress = OptionPrice::where('code', 'extra_02')->value('price');
       
        //$priceFraisService = OptionPrice::where('code', 'extra_01')->value('price');
        //$descFraisService = OptionPrice::where('code', 'extra_02')->value('price');

        return view('/order-init', [
            //'typeImpressions' => $typeImpressions,
            'typeImpressions' => OptionPrice::where('categorie', 'type_impression')->get(),
            'typeReliures'   => OptionPrice::where('categorie', 'type_reliure')->get(),
            //'typeExpeditions' => $typeExpeditions,
            'typePlaidoiries'   => OptionPrice::where('categorie', 'type_plaidoirie')->orderBy('code', 'asc')->get(),
            'typeJuridictions'   => OptionPrice::where('categorie', 'type_juri')->get(),
            'zone_geos'   => OptionPrice::where('categorie', 'zone_geo')->where('price', 0.00)->get(),
           // 'baseFeePrice'   => $baseFeePrice,
           // 'baseFeeDesc'   => $baseFeeDesc,
            'baseAboPrice'   => $baseAboPrice,
            'baseAboDesc' => $baseAboDesc,
           // 'baseUrgentPrice'   => $baseUrgentPrice,
            //'baseUrgentDesc' => $baseUrgentDesc,
            'optionsExtra' => OptionPrice::where('categorie', 'type_extra')->get(), 
            'aboState' => $aboState,
        ]);
    }

    public function create(Request $request) {
        //dd($request->all());

        if(!Auth::check()){
            return redirect('register');
        }

        $printType = $request->input('printType');
        $reliureQuality = $request->input('reliureQuality');
        $expeType = $request->input('expeType');

        $getLibellePrint = TypeImpression::where('code', $printType)->first();
        $getLibelleReliure = TypeReliure::where('code', $reliureQuality)->first();
        $getLibelleExpe = TypeExpedition::where('code', $expeType)->first();

        return view('order-resume',[
           "getImpression" => $getLibellePrint['libelle'],
           "getReliure" => $getLibelleReliure['libelle'],
           "getExpe" => $getLibelleExpe['libelle'],
           "city" => $request->input('city'),
           "numberOfPages" => $request->input('numberOfPages'),

           "member" => $request->input('member'),
           "totalPrice" => $request->input('totalPrice'),

            "printType" => $printType,
            "reliureQuality" => $reliureQuality,
            "expeType" => $expeType,
        ]);
    }



    public function resetDossier(Request $request)
    {

    

    $order_id = $request->order_id;

        
    $dossier = DossierCustomer::where('order_id', $order_id)->first();

        


    if (!$dossier) {
        return redirect()->route('account')->with('error', 'Dossier introuvable.');
    }

    $dossier->update([
        'validSend' => 'notSent',
        'step' => 'envoiFichier-01',
    ]);

    // Relations
    $user = $dossier->user;
    $order = Basket::where('order_id', $order_id)->first();


    
    if (!$user || !$order) {
        return redirect()->route('account')->with('error', 'Utilisateur ou commande introuvable.');
    }

    $clientEmail = $user->email;
    $adminEmails = User::where('role', 'admin')->pluck('email')->toArray();

    

    Mail::to($clientEmail)
        ->cc($adminEmails)
        ->send(new DossierResetNotification($user, $order));

    return redirect()->route('account')->with('success', 'Le dossier a bien été réinitialisé.');
    }


    public function cancelSubscription(Request $request)
    {



        // Suppose que vous avez l'ID de l'utilisateur passé dans la requête ou obtenu autrement
        $userId = $request->user_id;

        // Récupérez l'utilisateur
        $user = User::findOrFail($userId);

        // Annuler l'abonnement
        if ($user->subscribed('default')) {
            $user->subscription('default')->cancel();

            $order = Subscription::where('user_id', $request->user_id)->first();
            if ($order) {
                $order->stripe_status = 'canceled';
                $order->save();
            }

        }

        Mail::to($user->email)
         ->bcc(env('ADMIN_EMAIL'))
         ->send(new UnsubscribedConfirmation($user));

        //return redirect()->back()->with('status', 'Votre abonnement mensuel est désormais annulé.');
        return redirect()->back()->with([
                'status' => 'Votre abonnement mensuel est désormais annulé.',
                'checkAbo' => 'canceled',
            ]);
    }



    public function confirmShipping(Request $request, $orderId)
    {

    

    $data = $request->validate([
        'tracking_number' => 'nullable|string|max:255',
        'carrier' => 'nullable|string|max:255',
        'proof' => 'nullable|file|max:5120', // 5 Mo max
    ]);

    // ✅ On récupère le panier
    $basket = Basket::with('user')->where('order_id', $orderId)->firstOrFail();


    // ✅ On gère l'upload si nécessaire
    if ($request->hasFile('proof')) {
        $data['proof_path'] = $request->file('proof')->store('proofs', 'public');
    }

    // ✅ On met à jour le dossier client
    $dossier = DossierCustomer::where('order_id', $orderId)->first();
    $dossier->step = 'completed';
    $dossier->save();

    if ($dossier) {

        if ($request->has('manuel')) {
        // La checkbox est cochée
        $carrier='manuel';
        } else {
        // La checkbox n'était pas cochée
        $carrier=$data['carrier'];
        }

        $dossier->trackingShip = $data['tracking_number'] ?? 'n.c';
        $dossier->carrier = $carrier ?? null;
        $dossier->proof_path = $data['proof_path'] ?? null;
        $dossier->shipDate = Carbon::now();

        $info = [];
        if (!empty($data['carrier'])) {
            $info[] = "Transporteur : " . $carrier;
        }
        if (!empty($data['tracking_number'])) {
            $info[] = "N° suivi : " . $data['tracking_number'];
        }
        if (!empty($data['proof_path'])) {
            $info[] = "Preuve de dépôt fournie";
        }

        //dd($carrier);

        $dossier->infoDossier = !empty($info) ? implode(' | ', $info) : 'n.c';
        $dossier->save();
    }

    // ✅ On envoie l’email au client depuis la relation Basket → User
    $email = $basket->user->email;
    Mail::to($email)->send(new ShippingConfirmedMail($basket, $data));

    return back()->with('success', 'Expédition confirmée et mail envoyé au client.');
}

}
