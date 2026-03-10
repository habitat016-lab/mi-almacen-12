<?php
// database/migrations/2026_03_09_xxxxxx_fix_puestos_columns_to_store_ids.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('puestos', function (Blueprint $table) {
            // Eliminar columnas de texto viejas (si existen)
            if (Schema::hasColumn('puestos', 'puesto')) {
                $table->dropColumn('puesto');
            }
            if (Schema::hasColumn('puestos', 'area')) {
                $table->dropColumn('area');
            }
            if (Schema::hasColumn('puestos', 'departamento')) {
                $table->dropColumn('departamento');
            }
            if (Schema::hasColumn('puestos', 'gerencia')) {
                $table->dropColumn('gerencia');
            }
            
            // Agregar columnas para IDs (si no existen)
            if (!Schema::hasColumn('puestos', 'cat_puesto_id')) {
                $table->foreignId('cat_puesto_id')->nullable()->constrained('cat_puestos');
            }
            if (!Schema::hasColumn('puestos', 'id_area')) {
                $table->foreignId('id_area')->nullable()->constrained('cat_areas');
            }
            if (!Schema::hasColumn('puestos', 'id_gerencia')) {
                $table->foreignId('id_gerencia')->nullable()->constrained('cat_gerencias');
            }
            if (!Schema::hasColumn('puestos', 'cat_departamento_id')) {
                $table->foreignId('cat_departamento_id')->nullable()->constrained('cat_departamentos');
            }
        });
    }

    public function down(): void
    {
        Schema::table('puestos', function (Blueprint $table) {
            // Restaurar columnas de texto (por si acaso)
            $table->string('puesto')->nullable();
            $table->string('area')->nullable();
            $table->string('departamento')->nullable();
            $table->string('gerencia')->nullable();
            
            // Eliminar columnas de ID
            $table->dropForeign(['cat_puesto_id']);
            $table->dropColumn('cat_puesto_id');
            $table->dropForeign(['id_area']);
            $table->dropColumn('id_area');
            $table->dropForeign(['id_gerencia']);
            $table->dropColumn('id_gerencia');
            $table->dropForeign(['cat_departamento_id']);
            $table->dropColumn('cat_departamento_id');
        });
    }
};