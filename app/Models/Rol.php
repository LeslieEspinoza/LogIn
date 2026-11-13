<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Rol extends Model
{
    use HasFactory;
    protected $table = 'roles';

    protected $fillable = [
        'nombre'
    ];

    private static function validaciones($id = null): array
    {
        return [
            'nombre' => ['required', 'string', 'max:50', 'unique:roles,nombre,' . $id],
        ];
    }

    public static function validar(array $datos, $id = null): array
    {
        return Validator::make($datos, static::validaciones($id))->validate();
    }

    public function users()
    {
        return $this->hasMany(User::class, 'rol_id');
    }
}
