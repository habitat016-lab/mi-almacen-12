<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CredencialLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.credencial-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('web')->attempt([
            'correo' => $request->correo,
            'password' => $request->password,
        ])) {
            return redirect()->intended('/admin');
        }

        return back()->withErrors([
            'correo' => 'Credenciales incorrectas',
        ])->withInput($request->except('password'));
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
