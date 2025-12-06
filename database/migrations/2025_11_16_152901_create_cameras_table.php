<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('cameras', function (Blueprint $table) {
            $table->id();
            $table->string('name');              // Ej: Cámara 1
            $table->string('ip');                // 192.168.0.20
            $table->string('location');          // Pasillo, Recepción…
            $table->boolean('status')->default(true);  // Activa / Inactiva
            $table->string('group')->nullable(); // Grupo: Ej. "Recepción", "Oficinas principales"
            $table->timestamps();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cameras');
    }
};
