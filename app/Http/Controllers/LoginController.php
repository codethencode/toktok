<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Climate\Order;

class LoginController extends Controller
{
    
    public function create(Request $request)
    {
        // 💣 Vire les redirections automatiques Laravel
        $request->session()->forget('_previous');
        $request->session()->forget('url.intended');
    
        // ✅ Authentification
        $credentials = [
            'email' => $request['login-email'],
            'password' => $request['login-password'],
        ];
    
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
    
            // ✅ Redirection personnalisée selon action (si besoin)
            if ($request->input('action') === 'account') {
                return redirect('/account'); // ⚠️ Tu peux personnaliser ici si la route existe
            }
    
            return redirect('/order-init')->with('success', 'Vous êtes connecté');
        }
    
        // ❌ Si échec, ne redirige surtout pas vers la racine
        return redirect()->back()->with('error', 'Identifiants incorrects');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/'); // Redirigez vers la page d'accueil ou une autre page après la déconnexion
    }
}
