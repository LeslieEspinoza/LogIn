<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class PeriodoAcademico extends Model
{
    protected $table = 'periodos_academicos';

    protected $fillable = [
        'codigo', 'fecha_inicio', 'fecha_fin', 'activo'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    private static function validaciones($id = null): array
    {
        return [
            'codigo' => ['required', 'string', 'max:5'],
            'fecha_inicio' => ['required', 'date'],
            'fecha_fin' => ['required', 'date', 'after:fecha_inicio'],
            'activo' => ['boolean']
        ];
    }

    public static function validar(array $datos, $id = null): array
    {
        return Validator::make($datos, static::validaciones($id))->validate();
    }

    public function secciones()
    {
        return $this->hasMany(Seccion::class, 'periodo_academico_id');
    }
}
