<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Carrera extends Model
{
    protected $table = 'carreras';

    // app/Models/Carrera.php
    protected $fillable = [
        'nombre',
        'facultad',
        'codigo',
        'nivel',
    ];


    private static function validaciones($id = null): array
    {
        return [
            'codigo' => ['required', 'string', 'max:10', 'unique:carreras,codigo,' . $id],
            'nombre' => ['required', 'string', 'max:150']
        ];
    }

    public static function validar(array $datos, $id = null): array
    {
        return Validator::make($datos, static::validaciones($id))->validate();
    }

    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class, 'carrera_id');
    }

    public static function contarTodos(){
        return self::count();
    }

    public function materias()
    {
        return $this->hasMany(Materia::class);
    }

    public static function mostrarTodos() : array {
        return self::all();
    }
    public static function buscarPorId($id): Carrera {
        return self::find($id);
    }

    public static function buscarPorNombre($nombre) : Carrera {
        return self::where('nombre','like', "%($nombre)%")->get();
    }


}
