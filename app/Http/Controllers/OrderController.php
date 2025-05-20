<?php

namespace App\Http\Controllers;

use App\Models\Plaidoirie;
use App\Models\TypeExpedition;
use App\Models\TypeImpression;
use App\Models\TypeReliure;
use App\Models\Subscription;
use App\Models\User;
use App\Models\ZoneGeo;
use App\Models\BaseFee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use Stripe\Subscription;

class OrderController extends Controller
{
    //
    public function index(){

        //GET PRICES
        $typeImpressions = TypeImpression::all();
        $typeReliures   = TypeReliure::all();
        $typeExpeditions = TypeExpedition::all();
        $typePlaidoiries = Plaidoirie::take(6)->get();
        $typeJuridictions = Plaidoirie::skip(6)->take(3)->get();
        $zone_geos = ZoneGeo::all();
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


        //dd($baseAboPrice);
        //$baseFeePrice = $baseFees->first()->price;
        //dd($typePlaidoiries);

        return view('/order-init', [
            'typeImpressions' => $typeImpressions,
            'typeReliures'   => $typeReliures,
            'typeExpeditions' => $typeExpeditions,
            'typePlaidoiries'   => $typePlaidoiries,
            'typeJuridictions'   => $typeJuridictions,
            'zone_geos'   => $zone_geos,
            'baseFeePrice'   => $baseFeePrice,
            'baseFeeDesc'   => $baseFeeDesc,
            'baseAboPrice'   => $baseAboPrice,
            'baseAboDesc' => $baseAboDesc,
            'baseUrgentPrice'   => $baseUrgentPrice,
            'baseUrgentDesc' => $baseUrgentDesc,
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


    public function cancelSubscription(Request $request)
    {

        return redirect()->back()->with('status', 'Votre abonnement mensuel est désormais annulé.');


        // Suppose que vous avez l'ID de l'utilisateur passé dans la requête ou obtenu autrement
        $userId = $request->user_id;

        // Récupérez l'utilisateur
        $user = User::findOrFail($userId);

        // Annuler l'abonnement
        if ($user->subscribed('default')) {
            $user->subscription('default')->cancel();

            $order = Subscription::where('user_id', $request->user_id)->first();
            if ($order) {
                $order->stripe_status = 'inactive';
                $order->save();
            }

        }


    }


}
