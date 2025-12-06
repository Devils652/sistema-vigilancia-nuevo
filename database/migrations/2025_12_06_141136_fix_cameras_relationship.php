<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cameras', function (Blueprint $table) {
            // 1. Eliminamos la columna antigua de texto propenso a errores
            $table->dropColumn('group');

            // 2. Agregamos la columna de relación (Clave Foránea)
            // Esto asegura que la cámara apunte a un ID real en la tabla camera_groups
            $table->foreignId('camera_group_id')
                  ->nullable()
                  ->constrained('camera_groups')
                  ->nullOnDelete(); // Si se borra el grupo, la cámara queda "Sin Grupo" en vez de romperse
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cameras', function (Blueprint $table) {
            $table->dropForeign(['camera_group_id']);
            $table->dropColumn('camera_group_id');
            $table->string('group')->nullable();
        });
    }
};