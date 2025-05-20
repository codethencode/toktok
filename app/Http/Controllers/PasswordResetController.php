<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;
use DB;

class PasswordResetController extends Controller
{
    public function showForgotForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Vérifiez si l'email existe dans la base de données
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Aucun utilisateur trouvé avec cette adresse e-mail.']);
        }
        else
        {
            if (DB::table('password_reset_tokens')->where('email', $request->email)->exists()) {
                DB::table('password_reset_tokens')
                    ->where('email', $request->email)
                    ->delete();
            }
        }

        // Créer un token de réinitialisation
        $token = Str::random(60);

        // Stocker le token dans la base de données
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        // Envoyer un email avec le lien de réinitialisation
        $resetLink = url('/password/reset/' . $token . '?email=' . urlencode($request->email));

        Mail::send('auth.emails.password', ['resetLink' => $resetLink], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Réinitialisation du mot de passe');
        });

        return back()->with('status', 'Nous vous avons envoyé un lien de réinitialisation de mot de passe par e-mail.');
    }

    public function showResetForm($token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
            'token' => 'required'
        ]);

        // Trouver l'entrée dans la table password_resets
        $passwordReset = DB::table('password_reset_tokens')->where([
            ['token', $request->token],
            ['email', $request->email]
        ])->first();

        if (!$passwordReset || Carbon::parse($passwordReset->created_at)->addMinutes(60)->isPast()) {
            return back()->withErrors(['email' => 'Le lien de réinitialisation est invalide ou a expiré.']);
        }

        // Réinitialiser le mot de passe
        $user = User::where('email', $request->email)->first();
        $user->password = bcrypt($request->password);
        $user->save();

        // Supprimer l'entrée dans la table password_resets
        DB::table('password_reset_tokens')->where(['email' => $request->email])->delete();

        // Rediriger ou authentifier l'utilisateur
        return redirect('/login')->with('status', 'Votre mot de passe a été réinitialisé avec succès.');
    }

}
