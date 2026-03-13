<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('asignacion_credenciales', function (Blueprint $table) {
            $table->dropColumn('id_asignacion_puesto');
        });
    }

    public function down(): void
    {
        Schema::table('asignacion_credenciales', function (Blueprint $table) {
            $table->foreignId('id_asignacion_puesto')->nullable()->constrained('puestos');
        });
    }
};