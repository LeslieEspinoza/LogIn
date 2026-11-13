<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Materia extends Model
{
    use HasFactory;

    protected $table = 'materias';

    protected $fillable = [
        'codigo',
        'nombre',
        'carrera_id',
        'uv',
    ];

    protected $casts = [
        'semestre_nivel' => 'integer'
    ];

    private static function validaciones($id = null): array
    {
        return [
            'codigo' => ['required', 'string', 'max:15', 'unique:materias,codigo,' . $id],
            'nombre' => ['required', 'string', 'max:150'],
            'semestre_nivel' => ['required', 'integer', 'min:1', 'max:10'],
            'creditos' => ['required', 'integer', 'min:1', 'max:5']
        ];
    }

    public static function validar(array $datos, $id = null): array
    {
        return Validator::make($datos, static::validaciones($id))->validate();
    }

    public function secciones()
    {
        return $this->hasMany(Seccion::class, 'materia_id');
    }

    public function prerequisitos()
    {
        return $this->hasMany(MateriaPrerequisito::class, 'materia_id');
    }
}
