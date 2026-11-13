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
        Schema::create('inscripciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudiante_id')->constrained('estudiantes');
            $table->foreignId('seccion_id')->constrained('secciones');
            $table->enum('estado', ['Inscrito', 'En lista de espera', 'Cancelado', 'Pendiente de pago'])->default('Pendiente de pago');
            $table->string('tipo_inscripcion')->default('Regular');
            $table->timestamps();
            $table->unique(['estudiante_id', 'seccion_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscripciones');
    }
};
