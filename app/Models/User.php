<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory;
    protected $table = 'users';

    protected $fillable = [
        'rol_id',
        'name',
        'email',
        'password',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];



    public static function validaciones($id = null): array
    {
        return [
            'rol_id'   => ['required', 'exists:roles,id'],
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
            'password' => $id ? ['nullable', 'string', 'min:8'] : ['required', 'string', 'min:8'],
        ];
    }

    public static function loginRules(): array{
        return [
            'email' => ['required', 'string'],
            'password' => ['required', 'string' ],
        ];
    }

    public static function ActualizarRules(): array{
        return [
            'email' => ['required', 'string'],
            'name' => ['required', 'string'],

        ];
    }

    public static function actualizar($id, array $datos)
    {
        $usuario = static::findOrFail($id);

        // Si 'password' está vacío o nulo, lo quitamos del arreglo para no sobreescribir la contraseña actual
        if (array_key_exists('password', $datos) && empty($datos['password'])) {
            unset($datos['password']);
        } elseif (!empty($datos['password'])) {
            // Si el usuario ingresó una nueva contraseña, la encriptamos
            $datos['password'] = Hash::make($datos['password']);
        }

        // Actualizamos los datos restantes (name, email, etc.)
        $usuario->update($datos);

        return $usuario;
    }

    public static function eliminar($id): bool{
        return User::find($id)->update(['activo' => false]);
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }


    public function estudiante()
    {
        return $this->hasOne(Estudiante::class, 'user_id');
    }

    public static function mostrarTodos(): Collection
    {
        return self::all();
    }

    public function tieneRol(string $rolName):
    bool
    {
        return $this->roles->contains('name', $rolName);
    }

    public function tieneAlgunRol(string $rolName):
    bool
    {
        return $this->roles->contains('name', $rolName);
    }






}
