<?php
// app/Http/Controllers/Auth/LoginController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            $request->session()->flash('welcome_toast', Auth::user()->name);

            return redirect()->intended(route('dashboard'));
        }

        throw ValidationException::withMessages([
            'email' => 'Les identifiants fournis ne correspondent pas.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        // Le flash doit être posé APRÈS invalidate() (qui vide déjà l'ancienne
        // session) mais AVANT regenerateToken(), sinon le message disparaît.
        $request->session()->flash('goodbye_toast', true);
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}