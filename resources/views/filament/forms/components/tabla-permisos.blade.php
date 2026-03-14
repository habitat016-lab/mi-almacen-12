@php
    use App\Services\PermisoService;

    $modulos = PermisoService::getModulos();
    $permisos = $getState() ?? PermisoService::getDefaultPermisos();
@endphp

<div class="p-4 bg-white rounded shadow">
    <h3 class="text-lg font-medium mb-4">Matriz de Permisos</h3>

    @if(empty($modulos))
        <p class="text-red-500">No se encontraron módulos</p>
    @else
        <table class="w-full text-sm">
            <thead>
                <tr>
                    <th class="text-left">Módulo</th>
                    <th class="text-center">Ver</th>
                    <th class="text-center">Crear</th>
                    <th class="text-center">Editar</th>
                    <th class="text-center">Eliminar</th>
                </tr>
            </thead>
            <tbody>
                @foreach($modulos as $modulo)
                    @php
                        $modelo = $modulo['modelo'];
                        $p = $permisos[$modelo] ?? ['view' => false, 
'create' => false, 'update' => false, 'delete' => false];
                    @endphp
                    <tr>
                        <td>{{ $modulo['label'] }}</td>
                        <td class="text-center">
                            <input type="checkbox"
                                   name="permissions[{{ $modelo }}][view]"
                                   value="1"
                                   {{ $p['view'] ? 'checked' : '' }}>
                        </td>
                        <td class="text-center">
                            <input type="checkbox"
                                   name="permissions[{{ $modelo 
}}][create]"
                                   value="1"
                                   {{ $p['create'] ? 'checked' : '' }}>
                        </td>
                        <td class="text-center">
                            <input type="checkbox"
                                   name="permissions[{{ $modelo 
}}][update]"
                                   value="1"
                                   {{ $p['update'] ? 'checked' : '' }}>
                        </td>
                        <td class="text-center">
                            <input type="checkbox"
                                   name="permissions[{{ $modelo 
}}][delete]"
                                   value="1"
                                   {{ $p['delete'] ? 'checked' : '' }}>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
