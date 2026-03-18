@php
    $empleado = $empleado ?? null;
    $fotoUrl = $empleado && $empleado->foto ? 
Storage::url($empleado->foto) : null;
@endphp

<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Contenedor -->
<div id="foto-empleado-container-{{ $empleado->id }}"></div>

<!-- Cargar JS -->
<script src="{{ asset('js/foto-empleado.js') }}"></script>

<script>
    (function() {
        function iniciar() {
            if (typeof window.initFotoEmpleado === 'function') {
                console.log('🔄 Iniciando foto para empleado {{ 
$empleado->id }}');
                window.initFotoEmpleado({{ $empleado->id }}, {{ $fotoUrl ? 
'"' . $fotoUrl . '"' : 'null' }});
            } else {
                console.log('⏳ Esperando JS...');
                setTimeout(iniciar, 100);
            }
        }
        iniciar();
    })();
</script>
