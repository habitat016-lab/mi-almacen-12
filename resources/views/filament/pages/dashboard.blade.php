<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Encabezado -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                Bienvenido, {{ optional(Auth::user()->empleado)->nombre ?? 
'Usuario' }}
            </h2>
            <p class="text-gray-600 dark:text-gray-300 mt-2">
                Panel de control del sistema
            </p>
        </div>

        <!-- Tarjetas de estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Tarjeta: Empleados -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm 
p-4">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 
text-blue-600">
                        <x-heroicon-o-users class="w-6 h-6" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Empleados</p>
                        <p class="text-2xl font-bold">{{ 
\App\Models\Empleado::count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Tarjeta: Roles -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm 
p-4">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 
text-green-600">
                        <x-heroicon-o-shield-check class="w-6 h-6" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Roles</p>
                        <p class="text-2xl font-bold">{{ 
\App\Models\Role::count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Tarjeta: Puestos -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm 
p-4">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 
text-purple-600">
                        <x-heroicon-o-briefcase class="w-6 h-6" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Puestos</p>
                        <p class="text-2xl font-bold">{{ 
\App\Models\Puesto::count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Tarjeta: Accesos hoy -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm 
p-4">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 
text-yellow-600">
                        <x-heroicon-o-clock class="w-6 h-6" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Accesos hoy</p>
                        <p class="text-2xl font-bold">{{ 
\App\Models\LoginAuditoria::whereDate('login_at', today())->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Accesos recientes -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold mb-4">Accesos recientes</h3>
            <div class="space-y-3">
                @php
                    $accesosRecientes = 
\App\Models\LoginAuditoria::with('credencial.empleado')
                        ->latest()
                        ->take(5)
                        ->get();
                @endphp

                @forelse($accesosRecientes as $acceso)
                    <div class="flex items-center justify-between py-2 
border-b">
                        <div>
                            <p class="font-medium">{{ 
optional($acceso->credencial->empleado)->nombre ?? 'N/A' }}</p>
                            <p class="text-sm text-gray-500">{{ 
$acceso->ip_address }}</p>
                        </div>
                        <p class="text-sm text-gray-500">{{ 
$acceso->login_at->diffForHumans() }}</p>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No hay 
accesos recientes</p>
                @endforelse
            </div>
        </div>
    </div>
</x-filament-panels::page>
