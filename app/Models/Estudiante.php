<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Estudiante extends Model
{
    use HasFactory;

    protected $table = 'estudiantes';

    protected $fillable = [
        'user_id',
        'nombres',
        'correo_institucional',
        'carrera_id',
        'estatus_financiero',
        'documento_identidad',
        'nivel_academico',
        'paso_actual',
        'completado',
    ];

    protected $casts = [
        'carrera_id' => 'integer',
        'user_id' => 'integer',
        'paso_actual' => 'integer',
        'estatus_financiero' => 'boolean',
        'completado' => 'boolean',
    ];

    private static function validaciones($id = null): array
    {
        return [
            'nombres' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'correo_institucional' => ['required', 'email'],
            'carrera_id' => ['nullable', 'exists:carreras,id'],
            'documento_identidad' => ['required', 'string', 'max:50'],
            'nivel_academico' => ['nullable', 'in:pregrado,posgrado,educacion_continua'],
        ];
    }

    public static function validar(array $datos, $id = null): array
    {
        return Validator::make($datos, static::validaciones($id))->validate();
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relación con la carrera / programa seleccionado
     */
    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'carrera_id');
    }
    public function secciones(): BelongsToMany
    {
        return $this->belongsToMany(Seccion::class, 'estudiante_seccion');
    }
}
