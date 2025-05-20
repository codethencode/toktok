<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\DossierCustomer;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OrderSummary extends Controller
{
    //
    public function index(){

        if(Auth::check()) {




            $checkAbo = Subscription::where('user_id', Auth::user()->id)->first();

            if($checkAbo===null) { $checkAbo = 'nonAbo'; }

            $paginate = 10;

            if(Auth::user()->role === 'admin')
            {
                $orderAlls = Basket::where('isPaid', 'ok')
                    ->orderByDesc('created_at')
                    ->paginate($paginate);

                $isAdmin = true;
            }
            else
            {
                $orderAlls = Basket::where('user_id', Auth::user()->id)
                    ->where('isPaid', 'ok')
                    ->orderByDesc('created_at')
                    ->paginate($paginate);

                $isAdmin = false;
            }

            // Pour chaque abonnement, on fait une requête supplémentaire (par exemple, sur la table 'users')
            foreach ($orderAlls as $orderAll) {
                // Exemple d'une requête sur une autre table (par exemple, récupérer un utilisateur)
                $orderAll->step = DossierCustomer::where('order_id', $orderAll->order_id)->first();
                $orderAll->customer = User::where('id', $orderAll->user_id)->first();
             }

           // dd($orderAll->customer);


            return view('account.index',  [
                'orderAll' => $orderAlls,
                'checkAbo' => $checkAbo,
                'isAdmin' => $isAdmin

            ]);
        }
        else
        {
            return redirect('/login');
        }
    }


    public function dossier($query){
        return view('account.action-step1', ['orderId'=>$query]);
    }
}
