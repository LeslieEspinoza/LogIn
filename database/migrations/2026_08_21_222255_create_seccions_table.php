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
        Schema::create('secciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('materia_id')->constrained('materias')->onDelete('cascade');
            $table->foreignId('periodo_academico_id')->constrained('periodos_academicos')->onDelete('cascade');
            $table->foreignId('carrera_id')->nullable()->constrained('carreras')->onDelete('cascade'); // <-- Agrega esta línea
            $table->foreignId('profesor_id')->constrained('profesores')->onDelete('cascade');
            $table->string('aula');
            $table->integer('cupo_maximo');
            $table->integer('cupo_disponible');
            $table->json('horario')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('secciones');
    }
};
