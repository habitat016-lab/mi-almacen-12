@php
    use App\Services\PermisoService;

    $modulos = PermisoService::getModulos();
    $permisos = $getState() ?? PermisoService::getDefaultPermisos();

    // Calcular nivel de permisos
    $esAdmin = true;
    $todosView = true;
    $totalPermisos = 0;
    $totalActivos = 0;

    foreach ($modulos as $modulo) {
        $modeloModulo = $modulo['modelo'];
        $p = $permisos[$modeloModulo] ?? ['view' => false, 'create' => false, 'update' => false, 'delete' => false];

        $totalPermisos += 4;
        $totalActivos += ($p['view'] ? 1 : 0) + ($p['create'] ? 1 : 0) + ($p['update'] ? 1 : 0) + ($p['delete'] ? 1 : 0);

        foreach (['view', 'create', 'update', 'delete'] as $accion) {
            if (!($p[$accion] ?? false)) {
                $esAdmin = false;
            }
        }

        if (!($p['view'] ?? false)) {
            $todosView = false;
        }
    }

    $porcentaje = $totalPermisos > 0 ? round(($totalActivos / $totalPermisos) * 100) : 0;
@endphp

<div class="p-4 bg-white rounded-lg shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="mb-4 flex items-center justify-between flex-wrap gap-2">
        <div class="flex items-center gap-2">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                Matriz de Permisos
            </h3>

            @if($esAdmin)
                <span class="px-3 py-1 bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200 rounded-full text-xs font-medium">
                    👑 ADMINISTRADOR - Acceso total
                </span>
            @elseif($todosView)
                <span class="px-3 py-1 bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 rounded-full text-xs font-medium">
                    👁️ CONSULTOR - Solo visualización
                </span>
            @else
                <span class="px-3 py-1 bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 rounded-full text-xs font-medium">
                    🔧 Rol personalizado ({{ $porcentaje }}% de permisos)
                </span>
            @endif
        </div>

        <div class="flex gap-2">
            <button type="button"
                    class="px-3 py-1 bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 rounded-md text-sm hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors"
                    onclick="selectAll()">
                ✅ Admin (Todo)
            </button>
            <button type="button"
                    class="px-3 py-1 bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 rounded-md text-sm hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors"
                    onclick="clearAll()">
                ❌ Limpiar
            </button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-700 dark:text-gray-300">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                <tr>
                    <th class="px-4 py-3 rounded-l-lg">Módulos / Catálogos</th>
                    <th class="px-4 py-3 text-center">
                        <div class="flex flex-col items-center">
                            <span>Ver</span>
                            <label class="inline-flex items-center mt-1 cursor-pointer">
                                <input type="checkbox"
                                       class="rounded border-gray-300 text-primary-600 shadow-sm focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-600"
                                       onclick="toggleColumn('view', this.checked)">
                                <span class="ml-1 text-xs text-gray-500 dark:text-gray-400">⬇️</span>
                            </label>
                        </div>
                    </th>
                    <th class="px-4 py-3 text-center">
                        <div class="flex flex-col items-center">
                            <span>Crear</span>
                            <label class="inline-flex items-center mt-1 cursor-pointer">
                                <input type="checkbox"
                                       class="rounded border-gray-300 text-primary-600 shadow-sm focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-600"
                                       onclick="toggleColumn('create', this.checked)">
                                <span class="ml-1 text-xs text-gray-500 dark:text-gray-400">⬇️</span>
                            </label>
                        </div>
                    </th>
                    <th class="px-4 py-3 text-center">
                        <div class="flex flex-col items-center">
                            <span>Editar</span>
                            <label class="inline-flex items-center mt-1 cursor-pointer">
                                <input type="checkbox"
                                       class="rounded border-gray-300 text-primary-600 shadow-sm focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-600"
                                       onclick="toggleColumn('update', this.checked)">
                                <span class="ml-1 text-xs text-gray-500 dark:text-gray-400">⬇️</span>
                            </label>
                        </div>
                    </th>
                    <th class="px-4 py-3 text-center rounded-r-lg">
                        <div class="flex flex-col items-center">
                            <span>Eliminar</span>
                            <label class="inline-flex items-center mt-1 cursor-pointer">
                                <input type="checkbox"
                                       class="rounded border-gray-300 text-primary-600 shadow-sm focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-600"
                                       onclick="toggleColumn('delete', this.checked)">
                                <span class="ml-1 text-xs text-gray-500 dark:text-gray-400">⬇️</span>
                            </label>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($modulos as $index => $modulo)
                    @php
                        $modeloModulo = $modulo['modelo'];
                        $p = $permisos[$modeloModulo] ?? ['view' => false, 'create' => false, 'update' => false, 'delete' => false];
                        $rowClass = $index % 2 === 0 ? 'bg-white dark:bg-gray-800' : 'bg-gray-50 dark:bg-gray-900';
                    @endphp
                    <tr class="{{ $rowClass }} hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <td class="px-4 py-3 font-medium">
                            {{ $modulo['label'] }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            <input type="checkbox"
                                   name="permisos[{{ $modeloModulo }}][view]"
                                   value="1"
                                   {{ $p['view'] ? 'checked' : '' }}
                                   class="permiso-checkbox view-checkbox rounded border-gray-300 text-primary-600"
                                   onchange="toggleRow(this, '{{ $modeloModulo }}')">
                        </td>
                        <td class="px-4 py-3 text-center">
                            <input type="checkbox"
                                   name="permisos[{{ $modeloModulo }}][create]"
                                   value="1"
                                   {{ $p['create'] ? 'checked' : '' }}
                                   class="permiso-checkbox create-checkbox rounded border-gray-300 text-primary-600"
                                   {{ !$p['view'] ? 'disabled' : '' }}
                                   onchange="updateCounters()">
                        </td>
                        <td class="px-4 py-3 text-center">
                            <input type="checkbox"
                                   name="permisos[{{ $modeloModulo }}][update]"
                                   value="1"
                                   {{ $p['update'] ? 'checked' : '' }}
                                   class="permiso-checkbox update-checkbox rounded border-gray-300 text-primary-600"
                                   {{ !$p['view'] ? 'disabled' : '' }}
                                   onchange="updateCounters()">
                        </td>
                        <td class="px-4 py-3 text-center">
                            <input type="checkbox"
                                   name="permisos[{{ $modeloModulo }}][delete]"
                                   value="1"
                                   {{ $p['delete'] ? 'checked' : '' }}
                                   class="permiso-checkbox delete-checkbox rounded border-gray-300 text-primary-600"
                                   {{ !$p['view'] ? 'disabled' : '' }}
                                   onchange="updateCounters()">
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                            No se encontraron módulos
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4 text-xs text-gray-500 dark:text-gray-400 flex items-center gap-4">
        <span>⚡ Módulos detectados automáticamente: {{ count($modulos) }}</span>
        <span>📊 Total: <span id="total-activos">{{ $totalActivos }}</span>/<span id="total-permisos">{{ $totalPermisos }}</span> permisos activos (<span id="porcentaje">{{ $porcentaje }}</span>%)</span>
    </div>
</div>

<script>
function toggleRow(checkbox, modelo) {
    let checked = checkbox.checked;
    let row = checkbox.closest('tr');
    row.querySelectorAll('.create-checkbox, .update-checkbox, .delete-checkbox').forEach(cb => {
        cb.disabled = !checked;
        if (!checked) {
            cb.checked = false;
        }
    });
    updateCounters();
}

function toggleColumn(column, checked) {
    document.querySelectorAll('.' + column + '-checkbox').forEach(cb => {
        cb.checked = checked;
        if (column === 'view') {
            let row = cb.closest('tr');
            row.querySelectorAll('.create-checkbox, .update-checkbox, .delete-checkbox').forEach(actionCb => {
                actionCb.disabled = !checked;
                if (!checked) actionCb.checked = false;
            });
        }
    });
    updateCounters();
}

function selectAll() {
    document.querySelectorAll('.permiso-checkbox').forEach(cb => {
        cb.checked = true;
        cb.disabled = false;
    });
    updateCounters();
}

function clearAll() {
    document.querySelectorAll('.permiso-checkbox').forEach(cb => {
        cb.checked = false;
        if (cb.classList.contains('create-checkbox') ||
            cb.classList.contains('update-checkbox') ||
            cb.classList.contains('delete-checkbox')) {
            cb.disabled = true;
        }
    });
    updateCounters();
}

function updateCounters() {
    let totalActivos = document.querySelectorAll('.permiso-checkbox:checked').length;
    let totalPermisos = {{ $totalPermisos }};
    let porcentaje = totalPermisos > 0 ? Math.round((totalActivos / totalPermisos) * 100) : 0;

    document.getElementById('total-activos').textContent = totalActivos;
    document.getElementById('porcentaje').textContent = porcentaje;
}
</script>