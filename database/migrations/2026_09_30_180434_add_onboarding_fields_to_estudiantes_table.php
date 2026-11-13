<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            // Relación con el usuario autenticado
            if (!Schema::hasColumn('estudiantes', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->onDelete('cascade');
            }

            // Campos del Onboarding
            if (!Schema::hasColumn('estudiantes', 'nivel_academico')) {
                $table->string('nivel_academico')->nullable()->after('documento_identidad');
            }
            if (!Schema::hasColumn('estudiantes', 'paso_actual')) {
                $table->integer('paso_actual')->default(1)->after('nivel_academico');
            }
            if (!Schema::hasColumn('estudiantes', 'completado')) {
                $table->boolean('completado')->default(false)->after('paso_actual');
            }
        });
    }

    public function down(): void
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'nivel_academico', 'paso_actual', 'completado']);
        });
    }
};
