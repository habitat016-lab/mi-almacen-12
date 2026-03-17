<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AsignacionCredencial;
use App\Models\User;
use App\Models\LoginAuditoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CredencialLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt(['correo_electronico' => $request->email, 
'password' => $request->password])) {
            
            $credencial = Auth::user();

            LoginAuditoria::create([
                'credencial_id' => $credencial->id,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'device_fingerprint' => md5($request->ip() . 
$request->userAgent()),
                'login_at' => now(),
                'last_activity_at' => now()
            ]);

            User::updateOrCreate(
                ['credencial_id' => $credencial->id],
                [
                    'session_token' => Session::getId(),
                    'last_activity' => now(),
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent()
                ]
            );

            $request->session()->regenerate();

            return redirect()->intended('/admin');
        }

        return back()->withErrors([
            'email' => 'Credenciales incorrectas',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
