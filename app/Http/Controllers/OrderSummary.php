<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\DossierCustomer;
use App\Models\OptionPrice;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;



class OrderSummary extends Controller
{
    //


    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
    
        $checkAbo = Subscription::where('user_id', Auth::id())->first() ?? 'nonAbo';
        $paginate = 10;
        $search = $request->input('search');
    
        $query = Basket::with('user') // pour précharger les emails
            ->where('isPaid', 'ok');
    
        if (Auth::user()->role !== 'admin') {
            $query->where('user_id', Auth::id());
            $isAdmin = false;
        } else {
            $isAdmin = true;
        }
    
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('order_id', 'like', "%$search%")
                 ->orWhere('order_name', 'like', "%$search%")
                  ->orWhereHas('user', function ($sub) use ($search) {
                      $sub->where('email', 'like', "%$search%");
                  });
            });
        }
    
        $orderAlls = $query->orderByDesc('created_at')->paginate($paginate);
    
        foreach ($orderAlls as $orderAll) {
            $orderAll->step = DossierCustomer::where('order_id', $orderAll->order_id)->first();
            $orderAll->customer = $orderAll->user;
            $orderAll->validSend = optional($orderAll->step)->validSend;
            $orderAll->dateValidSend = optional($orderAll->step)->dateValidSend;
            $orderAll->company = Company::where('order_id', $orderAll->order_id)->first();
        
            $basket = Basket::where('order_id', $orderAll->order_id)->first();
            $orderAll->isUrgent = optional($basket)->isUrgent;
        
            // ✅ Calcul du délai restant uniquement si dossier validé ET urgent
            $now = Carbon::now();
            Carbon::setLocale('fr');
            
            // ✅ Corrigé : condition unique + bonne valeur 'validSend'
            if ($orderAll->isUrgent === 'true' && $orderAll->validSend === 'validSent' && $orderAll->dateValidSend) {
                $validationDate = Carbon::parse($orderAll->dateValidSend);
                $deadline = $validationDate->copy()->addWeekdays(1)->setHour(18)->setMinute(0);
            
                if ($now->lessThan($deadline)) {
                    $diff = $now->diff($deadline);
            
                    $heures = $diff->h + ($diff->days * 24);
                    $minutes = $diff->i;
            
                    $orderAll->remainingTime = "Il reste {$heures} heure" . ($heures !== 1 ? "s" : "") .
                                                " et {$minutes} minute" . ($minutes !== 1 ? "s" : "") . " pour traiter le dossier.";
                } else {
                    $diff = $deadline->diff($now);
                    $heures = $diff->h + ($diff->days * 24);
                    $minutes = $diff->i;
            
                    $orderAll->remainingTime = "Délai dépassé de {$heures} heure" . ($heures !== 1 ? "s" : "") .
                                            " et {$minutes} minute" . ($minutes !== 1 ? "s" : "") . ".";
                }
            } else {
                $orderAll->remainingTime = null;
            }
            

           
        }
    
        return view('account.index', [
            'orderAll' => $orderAlls,
            'checkAbo' => $checkAbo,
            'isAdmin' => $isAdmin
        ]);
    }
    
    


  /*
    public function index(){

        if(Auth::check()) {


            //dd(Auth::user()->id);

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
                $orderAll->company = Company::where('order_id', $orderAll->order_id)->first(); 
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
*/

    public function dossier($query){
        return view('account.action-step1', ['orderId'=>$query]);
    }

    public function show($orderId)
    {
      

        $user = Auth::user();
        $basket = Basket::where('order_id', $orderId)->firstOrFail();

    // Sécurité : seul l'admin ou le client propriétaire peut voir
    if ($user->role !== 'admin' && $basket->user_id !== $user->id) {
        abort(403, 'Accès refusé.');
    }

    $data = $this->getDetailOrderData($orderId);
    return view('account.orderDetail', $data);

    }

    public function downloadInvoicePdf($orderId)
    {
        $data = $this->getDetailOrderData($orderId);

       // dd($data);

        $pdf = Pdf::loadView('orders.invoice_pdf', $data);
        return $pdf->download("facture_commande_{$orderId}.pdf");
    }

    // 🧠 Cette méthode privée centralise toute la logique
    private function getDetailOrderData($orderId)
    {
        $basket = Basket::where('order_id', $orderId)->firstOrFail();
        $company = Company::where('order_id', $orderId)->first();

        //dd($basket);

        $typeImpression = OptionPrice::where('code', $basket->printType)->first();
        $typeReliure = OptionPrice::where('code', $basket->reliureType)->first();
        $plaidoirie = OptionPrice::where('code', $basket->plaideType)->first();
        $juridiction = OptionPrice::where('code', $basket->JuriType)->first();
        $zoneGeo = OptionPrice::where('code', $basket->cityCode)->first();
        //$urgence = OptionPrice::where('code', 'isUrgent')->first();

       

       // dd($basket->cityCode);

        $total = 
            $basket->baseFeePrice +
            ($basket->numberOfPages * ($typeImpression->price ?? 0)) +
            ($typeReliure->price ?? 0) +
            ($plaidoirie->price ?? 0) +
            ($juridiction->price ?? 0) +
            ($zoneGeo->cityPrice ?? 0) +
            ($basket->isUrgent ? ($basket->urgentPrice ?? 0) : 0);

        return [
            'nbPages' => $basket->numberOfPages,
            'basket' => $basket,
            'typeImpression' => $typeImpression,
            'typeReliure' => $typeReliure,
            'plaidoirie' => $plaidoirie,
            'juridiction' => $juridiction,
            'zoneGeo' => $zoneGeo,
            'urgence' => $basket->urgentPrice,
            'total' => $total,
            'isAbo' =>$basket->isAbo,
            'company' => $company
        ];
    }



}
