<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function edit()
    {
      return view('account.editProfile');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|regex:/^\d{10}$/',
            'email' => 'required|email|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($user->registered_with_google && $user->email !== $validated['email']) {
            return back()->withErrors(['email' => 'Vous ne pouvez pas modifier votre email car votre compte est lié à Google.']);
        }

        $user->name = $validated['name'];
        $user->phone = $validated['phone'];

        if (!$user->registered_with_google) {
            $user->email = $validated['email'];
        }

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return back()->with('success', 'Profil mis à jour avec succès.');
    }

    public function updatePhone(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'regex:/^\d{10}$/'],
        ]);

        $user = Auth::user();
        $user->phone = $request->phone;
        $user->save();

        return back()->with('success', 'Numéro de téléphone mis à jour.');
    }
}
