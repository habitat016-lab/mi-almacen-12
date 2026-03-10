@php
    use App\Services\PermisoService;
    $modulos = PermisoService::getModulos();
    $permisos = $getState() ?? PermisoService::getDefaultPermisos();
@endphp

<script defer 
src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<div
    x-data="{
        permisos: {{ json_encode($permisos) }},
        modulos: {{ json_encode($modulos) }},
        checkAll(columna) {
            this.modulos.forEach(modulo => {
                if (!this.permisos[modulo.modelo]) 
this.permisos[modulo.modelo] = {};
                this.permisos[modulo.modelo][columna] = true;
            });
        },
        selectAll() {
            this.modulos.forEach(modulo => {
                if (!this.permisos[modulo.modelo]) 
this.permisos[modulo.modelo] = {};
                this.permisos[modulo.modelo].view = true;
                this.permisos[modulo.modelo].create = true;
                this.permisos[modulo.modelo].update = true;
                this.permisos[modulo.modelo].delete = true;
            });
        },
        clearAll() {
            this.modulos.forEach(modulo => {
                if (!this.permisos[modulo.modelo]) 
this.permisos[modulo.modelo] = {};
                this.permisos[modulo.modelo].view = false;
                this.permisos[modulo.modelo].create = false;
                this.permisos[modulo.modelo].update = false;
                this.permisos[modulo.modelo].delete = false;
            });
        }
    }"
    class="p-4 bg-white rounded-lg shadow-sm border border-gray-200 
dark:bg-gray-800 dark:border-gray-700"
>
    <div class="mb-4 flex items-center justify-between">
        <h3 class="text-lg font-medium">Matriz de Permisos</h3>
        <div class="space-x-2">
            <button type="button" @click="selectAll" class="px-3 py-1 
bg-gray-100 rounded-md text-sm hover:bg-gray-200">✅ Todo</button>
            <button type="button" @click="clearAll" class="px-3 py-1 
bg-gray-100 rounded-md text-sm hover:bg-gray-200">❌ Limpiar</button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left">Módulo</th>
                    <th class="px-4 py-3 text-center">
                        Ver
                        <input type="checkbox" @click="checkAll('view')" 
class="ml-1">
                    </th>
                    <th class="px-4 py-3 text-center">
                        Crear
                        <input type="checkbox" @click="checkAll('create')" 
class="ml-1">
                    </th>
                    <th class="px-4 py-3 text-center">
                        Editar
                        <input type="checkbox" @click="checkAll('update')" 
class="ml-1">
                    </th>
                    <th class="px-4 py-3 text-center">
                        Eliminar
                        <input type="checkbox" @click="checkAll('delete')" 
class="ml-1">
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($modulos as $index => $modulo)
                    @php
                        $modelo = $modulo['modelo'];
                        $p = $permisos[$modelo] ?? ['view' => false, 
'create' => false, 'update' => false, 'delete' => false];
                    @endphp
                    <tr class="{{ $index % 2 === 0 ? 'bg-white 
dark:bg-gray-800' : 'bg-gray-50 dark:bg-gray-900' }}">
                        <td class="px-4 py-3 font-medium">{{ 
$modulo['label'] }}</td>
                        <td class="px-4 py-3 text-center">
                            <input type="checkbox" 
                                   name="permisos[{{ $modelo }}][view]"
                                   value="1"
                                   {{ $p['view'] ? 'checked' : '' }}
                                   x-model="permisos['{{ $modelo 
}}'].view"
                                   class="rounded border-gray-300 
text-primary-600">
                        </td>
                        <td class="px-4 py-3 text-center">
                            <input type="checkbox" 
                                   name="permisos[{{ $modelo }}][create]"
                                   value="1"
                                   {{ $p['create'] ? 'checked' : '' }}
                                   x-model="permisos['{{ $modelo 
}}'].create"
                                   class="rounded border-gray-300 
text-primary-600">
                        </td>
                        <td class="px-4 py-3 text-center">
                            <input type="checkbox" 
                                   name="permisos[{{ $modelo }}][update]"
                                   value="1"
                                   {{ $p['update'] ? 'checked' : '' }}
                                   x-model="permisos['{{ $modelo 
}}'].update"
                                   class="rounded border-gray-300 
text-primary-600">
                        </td>
                        <td class="px-4 py-3 text-center">
                            <input type="checkbox" 
                                   name="permisos[{{ $modelo }}][delete]"
                                   value="1"
                                   {{ $p['delete'] ? 'checked' : '' }}
                                   x-model="permisos['{{ $modelo 
}}'].delete"
                                   class="rounded border-gray-300 
text-primary-600">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
