<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AsignacionCredencial;
use App\Models\AsignacionPermiso;
use App\Models\Role;
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
        // Validar entrada
        $request->validate([
            'correo' => 'required|email',
            'password' => 'required',
        ]);

        // Buscar credencial
        $credencial = AsignacionCredencial::where('correo_electronico', 
$request->correo)->first();

        // Verificar si existe y contraseña correcta
        if (!$credencial || !Hash::check($request->password, 
$credencial->llave_acceso)) {
            return back()->withErrors([
                'correo' => 'Credenciales incorrectas',
            ])->withInput($request->except('password'));
        }

        // Obtener el rol y permisos desde el puesto
        $asignacionPermiso = AsignacionPermiso::where('cat_puesto_id', 
$credencial->id_puesto)->first();
        $rol = $asignacionPermiso ? 
Role::find($asignacionPermiso->role_id) : null;

        // Guardar datos en sesión
        session([
            'credencial_id' => $credencial->id,
            'empleado_id' => $credencial->id_empleado,
            'puesto_id' => $credencial->id_puesto,
            'rol' => $rol ? $rol->name : null,
            'rol_id' => $rol ? $rol->id : null,
            'permisos' => $rol ? $rol->permissions : [],
            'correo' => $credencial->correo_electronico,
            'autenticado' => true,
        ]);

        // Redirigir al dashboard
        return redirect('/admin');
    }

    public function logout(Request $request)
    {
        // Limpiar toda la sesión
        session()->flush();
        
        // Invalidar la sesión actual
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }

    // Helper para verificar permisos
    public static function tienePermiso($modulo, $accion)
    {
        $permisos = session('permisos', []);
        return $permisos[$modulo][$accion] ?? false;
    }
}
