<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('asignacion_permisos', function (Blueprint $table) {
            $table->dropColumn('permisos');
        });
    }

    public function down(): void
    {
        Schema::table('asignacion_permisos', function (Blueprint $table) {
            $table->json('permisos')->nullable();
        });
    }
};