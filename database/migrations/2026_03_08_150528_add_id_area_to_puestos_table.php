<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('puestos', function (Blueprint $table) {
            // Agregar campo id_area
            $table->foreignId('id_area')
                ->nullable()
                ->after('cat_departamento_id')
                ->constrained('cat_areas')
                ->onDelete('set null');
            
            // Podemos eliminar el campo 'area' después de migrar datos
            // $table->dropColumn('area');
        });
    }

    public function down(): void
    {
        Schema::table('puestos', function (Blueprint $table) {
            $table->dropForeign(['id_area']);
            $table->dropColumn('id_area');
        });
    }
};