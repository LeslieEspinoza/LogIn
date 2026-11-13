<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
class Seccion extends Model
{
    protected $table = 'secciones';

    protected $fillable = [
        'materia_id',
        'periodo_academico_id',
        'carrera_id',
        'profesor_id',
        'aula',
        'cupo_maximo',
        'cupo_disponible',
        'horario',
    ];

    protected $casts = [
        'materia_id' => 'integer',
        'profesor_id' => 'integer',
        'periodo_academico_id'=>'integer',
        'cupo_disponible'=> 'integer',
        'cupo_maximo' => 'integer'
    ];

    private static function validaciones($id = null): array
    {
        return [
            'materia_id' => ['required', 'exists:materias,id'],
            'profesor_id' => ['required', 'exists:profesores,id'],
            'periodo_academico_id' => ['required', 'exists:periodos_academicos,id'],
            'cupo_maximo' => ['required', 'integer', 'min:1', 'max:100'],
            'cupo_disponible' => ['required', 'integer', 'min:1', 'max:100'],
            'aula' => ['required', 'string'],
            'horario' => [ 'nullable', 'json'],

        ];
    }

    public static function validar(array $datos, $id = null): array
    {
        return Validator::make($datos, static::validaciones($id))->validate();
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }

    public function profesor()
    {
        return $this->belongsTo(Profesor::class, 'profesor_id');
    }

    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class, 'seccion_id');
    }
}
