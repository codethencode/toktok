<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{

    public function index()
    {

        Log::info('Webhook payload received', ['ooo'=>'aaa']);

        if(Auth::check()){
            return redirect('order-init');
        }
        else
        {
            return redirect('login');
        }
    }

    //
    public function store(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:155'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'password_confirmation' => ['required'],
            'phone' => ['required', 'min:8'],
        ]);



        $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'phone' => $request->phone,
        'role' => 'customer',
        ]);


        Auth::login($user);

        return redirect()->route('home')->with('success', 'Votre compte a bien été créé vous pouvez à présent commander une prestation.');
    }
}
