<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\ContactMessage;
use App\Models\User;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function submit(Request $request)
{
    $request->validate([
        'nom' => 'required|string|max:100',
        'email' => 'required|email',
        'telephone' => 'nullable|string|max:30',
        'message' => 'required|string|max:1000',
        'honeypot' => 'max:0',
    ]);

    ContactMessage::create([
        'nom' => $request->nom,
        'email' => $request->email,
        'telephone' => $request->telephone,
        'message' => $request->message,
    ]);

    $admin = User::where('role', 'admin')->first();

    if ($admin) {

    $message = 
    "Nom : {$request->nom}\n" .
    "Email : {$request->email}\n" .
    "Téléphone : " . ($request->telephone ?: 'Non renseigné') . "\n\n" .
    "Message :\n{$request->message}";

    Mail::raw($message, function ($msg) use ($request, $admin) {
    $msg->to($admin->email)
        ->subject('[TokTok] Nouveau message depuis le formulaire de contact')
        ->replyTo($request->email)
        ->from('noreply@tonsite.com', $request->nom);
    });
    }

    return redirect()->back()->with('success', 'Votre message a bien été envoyé.');
    }
}
