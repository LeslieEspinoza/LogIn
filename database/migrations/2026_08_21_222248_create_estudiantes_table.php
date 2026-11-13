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
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id();

            // unique() evita que un mismo usuario tenga más de un perfil de estudiante
            $table->foreignId('user_id')
                ->nullable()
                ->unique()
                ->constrained('users')
                ->onDelete('cascade');

            // Datos personales del Onboarding
            $table->string('nombres')->nullable();
            $table->string('apellidos')->nullable();
            $table->string('documento_identidad')->nullable()->unique(); // Opcional: evita DUIs/Cédulas repetidas
            $table->string('telefono')->nullable();
            $table->string('direccion')->nullable();
            $table->date('fecha_nacimiento')->nullable();

            // Clave única para evitar duplicación de correos estudiantiles
            $table->string('correo_institucional')->unique();

            $table->string('nivel_academico')->nullable();
            $table->integer('paso_actual')->default(1);
            $table->boolean('completado')->default(false);
            $table->boolean('estatus_financiero')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudiantes');
    }
};
