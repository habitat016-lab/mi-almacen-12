<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Credencial;
use App\Models\User;
use App\Models\LoginAuditoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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

        // Buscar en credenciales
        $credencial = Credencial::where('email', $request->email)
            ->where('activo', true)
            ->first();

        if (!$credencial || !Hash::check($request->password, 
$credencial->password)) {
            return back()->withErrors([
                'email' => 'Credenciales incorrectas',
            ])->onlyInput('email');
        }

        // Registrar en auditoría
        $auditoria = LoginAuditoria::create([
            'credencial_id' => $credencial->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'device_fingerprint' => md5($request->ip() . 
$request->userAgent()),
            'login_at' => now(),
            'last_activity_at' => now()
        ]);

        // Crear o actualizar sesión activa en users
        $user = User::updateOrCreate(
            ['credencial_id' => $credencial->id],
            [
                'session_token' => Session::getId(),
                'last_activity' => now(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]
        );

        // Autenticar en Laravel
        auth()->login($user, $request->has('remember'));

        // Regenerar sesión por seguridad
        $request->session()->regenerate();

        // Redireccionar según el rol (puedes personalizar)
        return redirect()->intended('/dashboard');
    }

    public function logout(Request $request)
    {
        // Actualizar última actividad antes de salir
        if (auth()->check()) {
            $user = auth()->user();
            $user->update([
                'last_activity' => now()
            ]);
        }

        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
