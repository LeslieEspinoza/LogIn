<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudiante_id')->nullable()->constrained('estudiantes')->onDelete('cascade');
            $table->string('referencia')->nullable();
            $table->decimal('monto', 10, 2)->default(0.00);
            $table->string('metodo_pago')->nullable();
            $table->string('estado')->default('pendiente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
