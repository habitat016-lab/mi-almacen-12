<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AsignacionCredencial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

        session([
            'credencial_id' => $credencial->id,
            'empleado_id' => $credencial->id_empleado,
            'correo' => $credencial->correo_electronico,
            'autenticado' => true,
        ]);

        // 👇 ESTA ES LA LÍNEA CLAVE PARA PROBAR
        return redirect()->to('/login')->with('mensaje', '¡Login 
funcionando! Redirección correcta.');
    }

    public function logout(Request $request)
    {
        session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
