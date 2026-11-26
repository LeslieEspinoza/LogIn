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
        Schema::table('estudiantes', function (Blueprint $table) {
            // Usamos un booleano: false = Pendiente, true = Aprobado
            $table->boolean('expediente_aprobado')->default(false)->after('documento_identidad');
        });
    }

    public function down()
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            $table->dropColumn('expediente_aprobado');
        });
    }
};
