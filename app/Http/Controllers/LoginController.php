<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Climate\Order;

class LoginController extends Controller
{
    //
    public function create(Request $request)
    {

        $credentials = [
            'email' => $request['login-email'],
            'password' => $request['login-password'],
        ];

        if (Auth::attempt($credentials)) {

            if($request->action==='account') {
                return redirect()->action([OrderSummary::class, 'index'])->with('success', 'Vous êtes connecté');
            }
            return redirect('/order-init')->with('success', 'Vous êtes connecté');
        }

         return redirect()->back()->with('success', 'your message here');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/'); // Redirigez vers la page d'accueil ou une autre page après la déconnexion
    }
}
