<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->comment('Nombre del rol (ej: Administrador, Supervisor, etc)');
            $table->text('description')->nullable()->comment('Descripción del rol');
            $table->json('permissions')->nullable()->comment('Permisos en formato JSON');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};