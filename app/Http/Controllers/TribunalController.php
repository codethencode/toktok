<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Tribunal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TribunalController extends Controller
{
    //
    public function enterTribunal() {
        $directory = session('directory');
        
        $dossier = Tribunal::find($directory);

        

        // Extraire les 11 derniers caractères de la chaîne
        $order_id = substr($directory, -11);
        // Rechercher l'enregistrement en base de données
        $tribunal = Tribunal::where('order_id', $order_id)->first();

        //     dd($tribunal);


        $checkTypeEnvoi = Basket::where('order_id', $order_id)->first();

        $typeTribunal = $checkTypeEnvoi->JuriType;

        // dd($typeTribunal);

        if (!$dossier) {
            //On test s'il ya desja un enregistrement de compagnie pour cet user
            $tribunal = Tribunal::where('order_id', $order_id)->first();
            if(!$tribunal)
            {
                $dossier = new Tribunal();
            }
            // Si aucun dossier n'est trouvé, créer une nouvelle instance ou gérer l'erreur

        }

        return view('account.enterTribunal', compact('dossier', 'tribunal', 'typeTribunal', 'directory'));


        $directory = session('directory');
        return view('account.enterTribunal', compact('directory'));
    }
}
