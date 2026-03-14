@php
    $user = filament()->auth()->user();
    $nombreCompleto = $user?->name ?? 'Usuario';
    
    // Obtener la última asignación de puesto del empleado
    $puesto = null;
    if ($user && $user->empleado) {
        $ultimoPuesto = $user->empleado->puestos()->latest()->first();
        $puesto = $ultimoPuesto?->catPuesto?->nombre_puesto ?? 'Sin puesto 
asignado';
    } else {
        $puesto = 'Sin puesto asignado';
    }
@endphp

<div
    x-data="{ open: false }"
    @click.away="open = false"
    class="relative inline-block text-left"
>
    <!-- Contenedor principal - SIEMPRE VISIBLE (con clic) -->
    <button
        @click="open = !open"
        class="bg-gray-100 rounded-lg shadow-sm px-4 py-2 w-64 text-left 
hover:bg-gray-200 transition focus:outline-none"
    >
        <div class="text-xs text-gray-500 font-medium">BIENVENIDO:</div>
        <div class="font-bold text-gray-800">{{ $nombreCompleto }}</div>
        <div class="text-sm text-gray-600">{{ $puesto }}</div>
    </button>

    <!-- Menú desplegable - AL HACER CLIC -->
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 mt-2 w-64 overflow-hidden bg-white 
rounded-lg shadow-lg z-50 border border-gray-200"
    >
        <div class="py-1">
            <!-- Modo oscuro -->
            <button
                @click="toggleDarkMode"
                class="w-full text-left px-4 py-2 text-sm 
hover:bg-gray-100 transition flex items-center gap-2"
            >
                <span>🌓</span>
                <span>Modo oscuro</span>
            </button>

            <!-- Separador -->
            <div class="border-t border-gray-200 my-1"></div>

            <!-- Botón de salir -->
            <form method="POST" action="{{ route('logout') }}" 
class="block">
                @csrf
                <button type="submit"
                        class="w-full text-left px-4 py-2 text-sm 
hover:bg-gray-100 transition flex items-center gap-2"
                >
                    <span>🚪</span>
                    <span>Cerrar sesión</span>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleDarkMode() {
        if (document.documentElement.classList.contains('dark')) {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('darkMode', 'false');
        } else {
            document.documentElement.classList.add('dark');
            localStorage.setItem('darkMode', 'true');
        }
    }
</script>
