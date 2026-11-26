<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profesor extends Model
{
    use HasFactory;
    protected $table = 'profesores';

    protected $fillable = [
        'user_id',
        'nombres',
        'apellidos',
        'email',
        'telefono',
    ];

    private static function validaciones($id = null): array
    {
        return [
            'nombres' => ['required', 'string', 'max:100'],
            'apellidos' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'max:50']
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

    public function secciones()
    {
        return $this->hasMany(Seccion::class, 'profesor_id');
    }
}
