<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cat_areas', function (Blueprint $table) {
            $table->string('nombre_area')->unique()->after('id');
            $table->text('descripcion')->nullable()->after('nombre_area');
        });
    }

    public function down(): void
    {
        Schema::table('cat_areas', function (Blueprint $table) {
            $table->dropColumn(['nombre_area', 'descripcion']);
        });
    }
};