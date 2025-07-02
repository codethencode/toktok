<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partenaire;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class PartenaireController extends Controller
{
    public function show()
{
    return view('partenaire');
}

public function submit(Request $request)
{
    $request->validate([
        'nom' => 'required|string|max:100',
        'statut' => 'required|string',
        'telephone' => 'required|string|max:30',
        'branche' => 'required|string|max:100',
        'zone' => 'required|string|max:100',
        'region' => 'required|string|max:100',
        'villes' => 'required|string',
        'message' => 'nullable|string|max:1000',
        'honeypot' => 'max:0',
    ]);

    $partenaire = Partenaire::create($request->except(['honeypot', '_token']));

    // Notify admin
    $admin = User::where('role', 'admin')->first();
    if ($admin) {
        Mail::raw(
            "Nouvelle demande de partenariat :\n\n" .
            "Nom : {$request->nom}\n" .
            "Statut : {$request->statut}\n" .
            "Site web : {$request->site}\n" .
            "Téléphone : {$request->telephone}\n" .
            "Branche : {$request->branche}\n" .
            "Zone : {$request->zone}\n" .
            "Région : {$request->region}\n" .
            "Villes : {$request->villes}\n\n" .
            "Message :\n" . ($request->message ?: 'Aucun'),
            function ($msg) use ($admin) {
                $msg->to($admin->email)
                    ->subject('[ToqueToque.net] Nouvelle demande de partenariat')
                    ->from('info@toquetoque.net', 'Formulaire partenaire');
            }
        );
    }

    return back()->with('success', 'Votre demande a bien été enregistrée.');
}
}
