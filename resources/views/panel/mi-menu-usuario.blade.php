@php
    use App\Models\Puesto;
    use App\Models\CatPuesto;
    use Filament\Facades\Filament;

    $user = Filament::auth()->user();
    $nombreCompleto = $user->name ?? 'Usuario';
    $puestoNombre = 'Sin puesto asignado';

    if ($user && $user->empleado) {
        // Buscar la asignación de puesto más reciente del empleado
        $asignacionPuesto = Puesto::where('employee_id', 
$user->empleado->id)
            ->latest()
            ->first();

        if ($asignacionPuesto && $asignacionPuesto->cat_puesto_id) {
            $catPuesto = CatPuesto::find($asopcionPuesto->cat_puesto_id);
            $puestoNombre = $catPuesto->nombre_puesto ?? 'Sin puesto 
asignado';
        }
    }
@endphp

<div class="flex items-center gap-4 px-4 py-2 bg-green-50 rounded-lg">
    <div class="text-right">
        <div class="text-xs text-green-700 
font-semibold">BIENVENIDO:</div>
        <div class="font-bold text-gray-800 text-sm">{{ $nombreCompleto 
}}</div>
        <div class="text-xs text-green-600">{{ $puestoNombre }}</div>
    </div>
    <form method="POST" action="{{ route('logout') }}" class="m-0">
        @csrf
        <button type="submit" class="text-gray-500 hover:text-gray-700" 
title="Cerrar sesión">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" 
fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" 
d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 
013-3h4a3 3 0 013 3v1" />
            </svg>
        </button>
    </form>
</div>
