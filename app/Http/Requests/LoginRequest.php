<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
   public function authorize()
   {
       return true;
   }

   public function rules(): array
   {
       return User :: loginRules();
   }

   public function messages() : array{
       return [
           'email.required'     => 'El correo es obligatorio.',
           'password.required' => 'La contraseña es obligatoria.'
       ];
   }
   public function attributes() : array{
       return [
           'email' => 'Correo Electronico',
           'password' => 'contraseña'
       ];
   }

}
