<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AutenticacionCredenciales
{
    public function handle(Request $request, Closure $next)
    {
        // Verificar si existe la variable de sesión 'autenticado'
        if (!$request->session()->has('autenticado')) {
            return redirect('/login')->withErrors([
                'auth' => 'Debes iniciar sesión para acceder',
            ]);
        }

        return $next($request);
    }
}
