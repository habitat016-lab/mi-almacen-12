<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AsignacionCredencial;
use App\Models\LoginAuditoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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

        $credencial = AsignacionCredencial::where('correo_electronico', 
$request->correo)->first();

        if (!$credencial || !Hash::check($request->password, 
$credencial->llave_acceso)) {
            return back()->withErrors([
                'correo' => 'Credenciales incorrectas',
            ])->withInput($request->except('password'));
        }

        // ===== USAR AUTENTICACIÓN DE LARAVEL =====
        Auth::guard('web')->login($credencial);
        // ========================================

        // Guardar en auditoría
        $fingerprint = md5($request->ip() . $request->userAgent());
        
        LoginAuditoria::create([
            'credencial_id' => $credencial->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'device_fingerprint' => $fingerprint,
            'login_at' => now(),
            'last_activity_at' => now(),
        ]);

        return redirect()->intended('/admin');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
