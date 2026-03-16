@php
    use App\Models\Puesto;
    use App\Models\CatPuesto;
    
    $user = auth()->user();
    $nombreCompleto = $user->name ?? 'Usuario';
    $puestoNombre = 'Sin puesto asignado';
    
    if ($user && $user->empleado) {
        $ultimoPuesto = Puesto::where('employee_id', $user->empleado->id)
            ->latest()
            ->first();
        
        if ($ultimoPuesto && $ultimoPuesto->cat_puesto_id) {
            $catPuesto = CatPuesto::find($ultimoPuesto->cat_puesto_id);
            $puestoNombre = $catPuesto->nombre_puesto ?? 'Sin puesto 
asignado';
        }
    }
@endphp

<div
    x-data="{ open: false }"
    @click.away="open = false"
    class="relative"
    style="position: fixed; top: 8px; right: 25px; z-index: 9999;"
>
    <!-- Recuadro clickeable (verde) -->
    <button
        @click="open = !open"
        style="background-color: #d1fae5; padding: 4px 16px; 
border-radius: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); border: none; 
cursor: pointer; width: 100%; text-align: left;"
    >
        <div style="display: flex; align-items: baseline; gap: 8px;">
            <span style="font-size:11px; color:#047857; 
font-weight:600;">BIENVENIDO:</span>
            <span style="font-weight:600; color:#111827; 
font-size:13px;">{{ $nombreCompleto }}</span>
        </div>
        <div style="font-size:11px; color:#047857; font-weight:500; 
text-align: right;">{{ $puestoNombre }}</div>
    </button>

    <!-- Menú desplegable con iconos originales (sin modo nocturno) -->
    <div
        x-show="open"
        x-transition
        style="position: absolute; right: 0; margin-top: 8px; width: 
220px; background: white; border-radius: 8px; box-shadow: 0 4px 12px 
rgba(0,0,0,0.15); border: 1px solid #e5e7eb; overflow: hidden;"
    >
        <div style="padding: 8px 0;">
            <!-- Modo oscuro -->
            <button
                @click="setTheme('dark')"
                style="width: 100%; text-align: left; padding: 8px 16px; 
background: none; border: none; cursor: pointer; display: flex; 
align-items: center; gap: 12px; font-size: 14px;"
                onmouseover="this.style.backgroundColor='#f3f4f6'"
                onmouseout="this.style.backgroundColor='transparent'"
            >
                <svg width="20" height="20" viewBox="0 0 24 24" 
fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" 
d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 
008.354-5.646z" />
                </svg>
                Modo oscuro
            </button>
            
            <!-- Modo claro -->
            <button
                @click="setTheme('light')"
                style="width: 100%; text-align: left; padding: 8px 16px; 
background: none; border: none; cursor: pointer; display: flex; 
align-items: center; gap: 12px; font-size: 14px;"
                onmouseover="this.style.backgroundColor='#f3f4f6'"
                onmouseout="this.style.backgroundColor='transparent'"
            >
                <svg width="20" height="20" viewBox="0 0 24 24" 
fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" 
d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 
6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707" />
                </svg>
                Modo claro
            </button>
            
            <!-- Separador -->
            <div style="border-top: 1px solid #e5e7eb; margin: 8px 
0;"></div>
            
            <!-- Botón de salir -->
            <form method="POST" action="{{ route('logout') }}" 
style="margin:0;">
                @csrf
                <button type="submit"
                    style="width: 100%; text-align: left; padding: 8px 
16px; background: none; border: none; cursor: pointer; display: flex; 
align-items: center; gap: 12px; font-size: 14px;"
                    onmouseover="this.style.backgroundColor='#f3f4f6'"
                    onmouseout="this.style.backgroundColor='transparent'"
                >
                    <svg width="20" height="20" viewBox="0 0 24 24" 
fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" 
stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 
3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Cerrar sesión
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
