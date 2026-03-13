<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\CatPuesto;
use App\Models\AsignacionPermiso;
use App\Models\AsignacionCredencial;
use App\Models\Employee;
use App\Services\PermisoService;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear rol de administrador
        $adminRole = Role::firstOrCreate(
            ['name' => 'Administrador'],
            [
                'description' => 'Acceso total al sistema',
                'permissions' => PermisoService::getAdminPermisos(),
            ]
        );

        // 2. Crear puesto en catálogo
        $catPuesto = CatPuesto::firstOrCreate(
            ['nombre_puesto' => 'Administrador del Sistema'],
            [
                'descripcion' => 'Puesto con permisos de administrador',
                'activo' => true,
            ]
        );

        // 3. Asignar rol al puesto
        AsignacionPermiso::firstOrCreate(
            [
                'cat_puesto_id' => $catPuesto->id,
                'role_id' => $adminRole->id,
            ],
            [
                'observaciones' => 'Asignación automática por seeder',
            ]
        );

        // 4. Crear empleado (opcional, si lo necesitas después del login)
        $employee = Employee::firstOrCreate(
            ['nombres' => 'Administrador'],
            [
                'apellido_paterno' => 'Sistema',
                'apellido_materno' => 'Root',
                'fecha_nacimiento' => '2000-01-01',
                'telefono' => '0000000000',
                'rfc' => 'ADMIN000101XXX',
                'curp' => 'ADMIN000101XXXXXX00',
            ]
        );

        // 5. Crear credencial de acceso (¡esta es la clave del login!)
        AsignacionCredencial::firstOrCreate(
            ['correo_electronico' => 'admin@sistema.com'],
            [
                'id_empleado' => $employee->id,
                'id_puesto' => $catPuesto->id,
                'llave_acceso' => Hash::make('admin123'),
            ]
        );

        $this->command->info('✅ Usuario administrador creado 
correctamente');
        $this->command->info('📧 Email: admin@sistema.com');
        $this->command->info('🔑 Contraseña: admin123');
    }
}
