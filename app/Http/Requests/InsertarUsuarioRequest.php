<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class InsertarUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return User::validaciones();
    }

    public function messages(): array
    {
        return [
            'rol_id.required'   => 'El rol de usuario es obligatorio.',
            'rol_id.exists'     => 'El rol seleccionado no es válido.',

            'name.required'     => 'El nombre completo es obligatorio.',
            'name.max'          => 'El nombre no debe exceder los 255 caracteres.',

            'email.required'    => 'El correo electrónico es obligatorio.',
            'email.email'       => 'Debes ingresar una dirección de correo válida.',
            'email.unique'      => 'Este correo electrónico ya está en uso.',

            'password.required' => 'La contraseña es obligatoria.',
            'password.min'      => 'La contraseña debe tener al menos 8 caracteres.',
        ];
    }
}
