@php
    use App\Services\PermisoService;
    $modulos = PermisoService::getModulos();
    $permisos = PermisoService::getDefaultPermisos();
@endphp

<h1 style="font-family: sans-serif;">🧪 Prueba de Matriz de Permisos</h1>

<h3>📦 Módulos detectados ({{ count($modulos) }}):</h3>
<ul>
@foreach($modulos as $modulo)
    <li>{{ $modulo['label'] }} ({{ $modulo['modelo'] }})</li>
@endforeach
</ul>

<h3>📊 Estructura de permisos por defecto:</h3>
<pre style="background:#f4f4f4; padding:10px;">
{{ json_encode($permisos, JSON_PRETTY_PRINT) }}
</pre>

<hr>

<h2>🖥️ Matriz visual:</h2>
@include('filament.forms.components.tabla-permisos', [
    'getState' => fn() => $permisos
])
