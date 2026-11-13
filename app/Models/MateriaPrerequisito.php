<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class MateriaPrerequisito extends Model
{
    protected $table = 'materia_prerequisitos';

    protected $fillable = [
        'materia_id', 'prerequisito_id'
    ];

    private static function validaciones($id = null): array
    {
        return [
            'materia_id' => ['required', 'exists:materias,id'],
            'prerequisito_id' => ['required', 'exists:materias,id', 'different:materia_id']
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


    public function prerequisito()
    {
        return $this->belongsTo(Materia::class, 'prerequisito_id');
    }
}
