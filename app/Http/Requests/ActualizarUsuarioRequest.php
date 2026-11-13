<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActualizarUsuarioRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        // Obtenemos el ID del usuario desde la ruta
        $userId = $this->route('id');

        return [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $userId],
            'password' => ['nullable', 'string', 'min:8'], // 'nullable' permite dejarlo vacío
        ];
    }

    public function messages()
    {
        return [
            'name.required'  => 'El nombre es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.unique'   => 'Este correo electrónico ya está registrado.',
            'password.min'   => 'La contraseña debe tener al menos 8 caracteres.',
        ];
    }
}
