<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeePhotoController extends Controller
{
    /**
     * Mostrar formulario para subir foto (opcional)
     */
    public function edit(Employee $employee)
    {
        return view('employees.photo', compact('employee'));
    }

    /**
     * Subir o actualizar foto
     */
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Eliminar foto anterior si existe
        if ($employee->foto) {
            Storage::disk('public')->delete('fotos/' . $employee->foto);
        }

        // Guardar nueva foto
        $path = $request->file('foto')->store('fotos', 'public');
        $employee->foto = basename($path);
        $employee->save();

        return redirect()->back()->with('success', 'Foto actualizada 
correctamente.');
    }

    /**
     * Eliminar foto
     */
    public function destroy(Employee $employee)
    {
        if ($employee->foto) {
            Storage::disk('public')->delete('fotos/' . $employee->foto);
            $employee->foto = null;
            $employee->save();
        }

        return redirect()->back()->with('success', 'Foto eliminada 
correctamente.');
    }
}
