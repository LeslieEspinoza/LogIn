<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Inscripcion extends Model
{
    protected $table = 'inscripciones';

    protected $fillable = [
        'estudiante_id', 'seccion_id', 'estado', 'tipo_inscripcion'
    ];

    protected $casts = [

    ];

    private static function validaciones($id = null): array
    {
        return [
            'estudiante_id' => ['required', 'exists:estudiantes,id'],
            'seccion_id' => ['required', 'exists:secciones,id'],
            'estado' => ['required', 'string', 'in:activa,retirada,aprobada,reprobada'], // Validación de opciones permitidas
            'tipo_inscripcion' => ['required', 'string'],
        ];
    }

    public static function validar(array $datos, $id = null): array
    {
        return Validator::make($datos, static::validaciones($id))->validate();
    }

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id');
    }

    public function seccion()
    {
        return $this->belongsTo(Seccion::class, 'seccion_id');
    }
}
