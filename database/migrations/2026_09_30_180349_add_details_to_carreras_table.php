<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('carreras', function (Blueprint $table) {

            $table->enum('modalidad', ['presencial', 'hibrida', 'online'])->default('presencial');
            $table->enum('turno', ['manana', 'tarde', 'noche'])->default('manana');
            $table->string('plan_estudio_pdf')->nullable();
            $table->decimal('costo_matricula', 10, 2)->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carreras', function (Blueprint $table) {
            //
        });
    }
};
