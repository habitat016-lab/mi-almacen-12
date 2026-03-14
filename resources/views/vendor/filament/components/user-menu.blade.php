@php
    use App\Models\Puesto;
    use App\Models\CatPuesto;

    $user = filament()->auth()->user();
    $nombreCompleto = $user->name ?? 'Usuario';
    $puestoNombre = 'Sin puesto asignado';

    if ($user && $user->empleado) {
        // Buscar directamente en la tabla 'puestos' usando employee_id
        $asignacionPuesto = Puesto::where('employee_id', 
$user->empleado->id)
            ->latest()
            ->first();

        if ($asignacionPuesto && $asignacionPuesto->cat_puesto_id) {
            $catPuesto = 
CatPuesto::find($asignacionPuesto->cat_puesto_id);
            $puestoNombre = $catPuesto->nombre_puesto ?? 'Sin puesto 
asignado';
        }
    }
@endphp

<div
    x-data="{ open: false }"
    @click.away="open = false"
    class="relative inline-block text-left"
>
    <!-- Contenedor principal -->
    <button
        @click="open = !open"
        class="bg-[#d1fae5] rounded-xl shadow-md px-5 py-3 w-72 text-left 
hover:bg-[#bbf7d0] transition focus:outline-none border border-green-200"
    >
        <div class="text-xs text-green-700 font-semibold 
tracking-wide">BIENVENIDO:</div>
        <div class="font-bold text-gray-800 text-lg">{{ $nombreCompleto 
}}</div>
        <div class="text-sm text-green-600 font-medium mt-0.5">{{ 
$puestoNombre }}</div>
    </button>

    <!-- Menú desplegable -->
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 mt-2 w-72 overflow-hidden bg-white 
rounded-xl shadow-lg z-50 border border-gray-200"
    >
        <div class="py-2">
            <button @click="setTheme('dark')" class="w-full text-left px-5 
py-3 text-sm hover:bg-gray-50 transition flex items-center gap-3">
                <span class="text-lg">🌓</span> <span 
class="font-medium">Modo oscuro</span>
            </button>
            <button @click="setTheme('light')" class="w-full text-left 
px-5 py-3 text-sm hover:bg-gray-50 transition flex items-center gap-3">
                <span class="text-lg">🌞</span> <span 
class="font-medium">Modo claro</span>
            </button>
            <button @click="setTheme('night')" class="w-full text-left 
px-5 py-3 text-sm hover:bg-gray-50 transition flex items-center gap-3">
                <span class="text-lg">🌙</span> <span 
class="font-medium">Modo nocturno</span>
            </button>
            <div class="border-t border-gray-100 my-1"></div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-5 py-3 
text-sm hover:bg-gray-50 transition flex items-center gap-3">
                    <span class="text-lg">🚪</span> <span 
class="font-medium">Cerrar sesión</span>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function setTheme(theme) {
        document.documentElement.classList.remove('dark', 'night');
        if (theme === 'dark') {
            document.documentElement.classList.add('dark');
        } else if (theme === 'night') {
            document.documentElement.classList.add('night');
        }
        localStorage.setItem('theme', theme);
    }

    (function() {
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            setTheme(savedTheme);
        }
    })();
</script>
