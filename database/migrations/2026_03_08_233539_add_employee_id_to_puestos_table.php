<?php
// database/migrations/2026_03_08_235000_add_employee_id_to_puestos_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('puestos', function (Blueprint $table) {
            // Agregar employee_id después del id
            $table->foreignId('employee_id')
                  ->nullable()
                  ->after('id')
                  ->constrained('employees')
                  ->nullOnDelete()
                  ->comment('ID del empleado asignado');
        });
    }

    public function down(): void
    {
        Schema::table('puestos', function (Blueprint $table) {
            $table->dropForeign(['employee_id']);
            $table->dropColumn('employee_id');
        });
    }
};