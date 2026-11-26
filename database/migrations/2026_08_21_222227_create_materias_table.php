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
        Schema::create('materias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carrera_id')->constrained('carreras')->onDelete('cascade');
            $table->integer('correlativo'); // El número de la esquina superior izquierda
            $table->string('codigo'); // Ej: MAT I, ALG
            $table->string('nombre'); // Ej: Matemática I
            $table->string('ciclo'); // Ej: I, II, III, IV... X
            $table->integer('uv')->default(4); // Unidades valorativas
            $table->string('prerrequisito')->nullable(); // 'BACHILLER' o los correlativos ej: '13, 23'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materias');
    }
};
