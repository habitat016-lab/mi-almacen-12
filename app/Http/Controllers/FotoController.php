<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Employee;

class FotoController extends Controller
{
    public function subir(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|max:2048',
            'empleado_id' => 'required|exists:employees,id'
        ]);

        $empleado = Employee::find($request->empleado_id);
        
        // Eliminar foto anterior si existe
        if ($empleado->foto) {
            Storage::disk('public')->delete($empleado->foto);
        }

        // Guardar nueva foto
        $path = $request->file('foto')->store('empleados', 'public');
        
        // Actualizar registro
        $empleado->foto = $path;
        $empleado->save();

        return response()->json([
            'success' => true,
            'path' => $path,
            'url' => Storage::url($path)
        ]);
    }

    public function eliminar(Request $request)
    {
        $request->validate([
            'empleado_id' => 'required|exists:employees,id'
        ]);

        $empleado = Employee::find($request->empleado_id);
        
        if ($empleado->foto) {
            Storage::disk('public')->delete($empleado->foto);
            $empleado->foto = null;
            $empleado->save();
        }

        return response()->json(['success' => true]);
    }
}
