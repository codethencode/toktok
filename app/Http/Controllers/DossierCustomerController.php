<?php

namespace App\Http\Controllers;

use App\Mail\DossierSent;
use App\Mail\DossierSentAdmin;
use App\Models\Basket;
use App\Models\Company;
use App\Models\DossierCustomer;
use App\Models\Tribunal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class DossierCustomerController extends Controller
{
    //

    public function hasValid(Request $request)
    {

        $dossier = DossierCustomer::where('directory_id', $request->input('directory'))->first();

        if ($dossier) {
            // Mettre à jour l'attribut
            $dossier->validSend = 'validSent';
            $dossier->step = 'envoiFichier-02';
            // Sauvegarder les modifications
            $dossier->save();
        }
//        return view('account.enterAddress',  [
//            'directory' => $request->input('directory'),
//
//        ]);

    }

    // Afficher le formulaire de création / mise à jour
    public function showForm(Request $request)
    {


        //dd($request->order_id);

        //$directory = session('directory');

        //$directory = "857-636-903";

        //dd($directory);

        $dossier_query = DossierCustomer::where('order_id', $request->order_id)->first();
        $dossier = $dossier_query->directory_id;

        session(['directory' => $dossier]);


        $order_id = $request->order_id;
       // $dossier = DossierCustomer::find($directory);
        // Extraire les 11 derniers caractères de la chaîne
        //$order_id = substr($directory, -11);
       
        // Rechercher l'enregistrement en base de données
        $company = Company::where('order_id', $request->order_id)->first();
        $ref = Basket::where('order_id', $request->order_id)->first();

        if(!$company)
        {
            if (!Auth::user()->isAdmin) {
                $company = Company::where('user_id', Auth::id())->first();
            }

            else {
                if ($request->input('uid') && is_numeric($request->input('uid'))) {
                    $company = Company::where('user_id', intval($request->input('uid')))->first();
                } else {
                    // Optionnel : renvoyer une erreur ou message clair
                    abort(400, 'ID utilisateur invalide ou manquant.');
                }
            }
        }
               
        $order_name = $ref->order_name;


        if (!$dossier) {
            //On test s'il ya desja un enregistrement de compagnie pour cet user
            $company = Company::where('order_id', $order_id)->first();

            if($company===null) { dd('nada'); }

            if(!$company)
            {
                $dossier = new DossierCustomer();
            }
            // Si aucun dossier n'est trouvé, créer une nouvelle instance ou gérer l'erreur

        }

        

        $isEditable = DossierCustomer::where('directory_id',$dossier)->first();

        //dd($dossier);

        $tribTxt = Basket::where('order_id', $order_id)->first();

        if($tribTxt->JuriTypePrice==='TribJcp') { $tribTxtName = 'Tribunal'; } else { $tribTxtName = 'Cabinet'; }

        if($isEditable->step==='envoiFichier-04')
        {
            return redirect('validateInfos/'.$tribTxtName);
        }
        else {

            $directory = $dossier;
            return view('account.enterAddress', compact('dossier', 'company', 'directory', 'order_name'));
        }
    }

    // Enregistrer les données du formulaire
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'shipAddress' => 'required|string|max:255',
            'contactTel' => 'required|string|max:255',
            'contactName' => 'required|string|max:255',
            'contactMail' => 'required|email|max:255',
            'infoDossier' => 'required|string',
        ]);

        $dossier = DossierCustomer::updateOrCreate(
            ['id' => $request->input('id')],
            $validatedData + ['isValidated' => false]
        );

        return redirect()->route('dossiers.show', $dossier->id)->with('success', 'Dossier enregistré avec succès!');
    }

    // Valider les informations (rendre le dossier non modifiable)
    public function validateDossier($id)
    {
        $dossier = DossierCustomer::findOrFail($id);
        $dossier->update(['isValidated' => true]);

        return redirect()->route('dossiers.show', $id)->with('success', 'Dossier validé et rendu non modifiable!');
    }



    public function submitAddress(Request $request){
        $directory = session('directory');
        $order_id = substr($directory, -11);


       


        $request->validate([
            'name' => ['required', 'string', 'max:250'],
            'adresse' => ['required', 'string', 'max:250'],
            'code_postal' => ['required', 'string', 'max:30'],
            'ville' => ['required', 'string', 'max:165'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'tel' => ['required', 'min:8', 'max:25'],
        ]);


        $verif = Company::where('order_id',$order_id)->first();

        //dd($verif);

        if(!$verif) {
            //dd($request->all());
            $company = Company::create([
                'user_id' => Auth::id(),
                'order_id' => $order_id,
                'name' => $request->name,
                'adresse' => $request->adresse,
                'code_postal' => $request->code_postal,
                'ville' => $request->ville,
                'email' => $request->email,
                'telephone' => $request->tel,
            ]);
        }
        else
        {

           // dd('je update');

            if($verif->isValid==0) {
                $verif->update([
                    'name' => $request->name,
                    'adresse' => $request->adresse,  // Correction du champ email
                    'code_postal' => $request->code_postal,
                    'ville' => $request->ville,  // Correction du champ email
                    'email' => $request->email,
                    'telephone' => $request->tel,
                ]);
            }
        }

        $update = DossierCustomer::where('order_id',$order_id)->first();
        $update->step = 'envoiFichier-03';
        $update->save();

        return redirect()->route('account.enterTribunal');
    }






    public function submitTribunal(Request $request) {

        $directory = session('directory');
        $order_id = substr($directory, -11);
        $tribTxt = $request->input('tribTxt');


        $request->validate([
            'name' => ['required', 'string', 'max:250'],
            'chambre' => ['required', 'string', 'max:250'],
            'service' => ['required', 'string', 'max:250'],
            'adresse' => ['required', 'string', 'max:250'],
            'code_postal' => ['required', 'string', 'max:30'],
            'ville' => ['required', 'string', 'max:165'],
            
        ]);


        $verif = Tribunal::where('order_id',$order_id)->first();

        if (empty($request->telephone)) {
            $telephone = 'n.c';
        } else {
            $telephone = $request->telephone;
        }

        if (empty($request->email)) {
            $email = 'n.c';
        } else {
            $email = $request->email;
        }
        

        if(!$verif) {
            //dd($request->all());
            $tribunal = Tribunal::create([
                'user_id' => Auth::id(),
                'order_id' => $order_id,
                'name' => $request->name,
                'chambre' => $request->chambre,
                'service' => $request->service,
                'adresse' => $request->adresse,
                'code_postal' => $request->code_postal,
                'ville' => $request->ville,
                'email' => $email,
                'telephone' => $telephone,
            ]);
        }
        else
        {
            if($verif->isValid==0) {
                $verif->update([
                    'name' => $request->name,
                    'chambre' => $request->chambre,
                    'service' => $request->service,
                    'adresse' => $request->adresse,  // Correction du champ email
                    'code_postal' => $request->code_postal,
                    'ville' => $request->ville,  // Correction du champ email
                    'email' => $email,
                    'telephone' => $telephone,
                ]);
            }
        }


        //$redirectUrl = route('validateInfos', compact('tribTxt'));
       // dd($redirectUrl);
        return redirect()->route('validateInfosTrib', compact('tribTxt'));


    }


    public function validateInfos(Request $request) {

       // dd("ici");

        $order_id = substr($request->directory, -11);

        $error = 0;

        $company = Company::where('order_id', $order_id)->first(); // Récupérer l'enregistrement avec order_id = $id
        $tribunal = Tribunal::where('order_id', $order_id)->first();

        if ($company) {
            $company->isValid = 'ok'; // Mettre à jour la colonne isValid
            $company->save(); // Sauvegarder la mise à jour dans la base de données
        } else {
            // Gestion de l'erreur si l'enregistrement n'existe pas
            $error++;
        }

        if ($tribunal ) {
            $tribunal ->isValid = 'ok'; // Mettre à jour la colonne isValid
            $tribunal ->save(); // Sauvegarder la mise à jour dans la base de données


            // App/Mail/DossierSent
            // App/Mail/DossierSentAdmin

            //dd($order_id);

            $customerMail = Auth::user()->email;
            // Envoyer l'e-mail de confirmation au client
            if ($customerMail) {
                Mail::to($customerMail)->send(new DossierSent($order_id));
            }

            // Envoyer l'e-mail à l'administrateur
            $adminEmail = config('mail.admin_email');
            Mail::to($adminEmail)->send(new DossierSentAdmin($order_id));

            $order = DossierCustomer::where('order_id', $order_id)->first();
            $order->dateValidSend = Carbon::now();
            $order->step = 'envoiFichier-04';

            $order->save();


//          $order->sendMail = 'ok';
//          $order->save();



            return redirect()->route('account.dossierSent');

        } else {
            // Gestion de l'erreur si l'enregistrement n'existe pas
            $error++;
            return redirect()->route('account.enterTribunal')->with('error', $error);
        }


    }


    public function validateInfosTrib($tribTxt) {

        $directory = session('directory');

        //dd($directory);

        $order_id = substr($directory, -11);

        $company = Company::where('order_id',$order_id)->first();
        $tribunal = Tribunal::where('order_id', $order_id)->first();

        $step = DossierCustomer::where('order_id', $order_id)->first();
        $etat = $step->step;

        return view('account.validateInfos',  compact('company', 'tribTxt', 'etat', 'tribunal', 'directory'));


}


}
