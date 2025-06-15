<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        //dd(User::class);
        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'password' => bcrypt(Str::random(16)),
                'phone' => '00000',
                'registered_with_google' => true,
            ]
        );

        Auth::login($user);
        if ($user->wasRecentlyCreated) {
            // Nouvel utilisateur → redirige vers étape profil ou onboarding
            Mail::to($user->email)->send(new WelcomeMail($user->name));
        return redirect('/order-init');
        
        } else {
                // Utilisateur existant → redirige vers dashboard ou autre
        return redirect()->intended('/account');
        }
    }
}
