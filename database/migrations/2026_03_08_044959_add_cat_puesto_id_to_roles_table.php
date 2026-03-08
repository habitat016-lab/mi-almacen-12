<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->foreignId('cat_puesto_id')
                ->nullable()
                ->after('id')
                ->constrained('cat_puestos')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropForeign(['cat_puesto_id']);
            $table->dropColumn('cat_puesto_id');
        });
    }
};
