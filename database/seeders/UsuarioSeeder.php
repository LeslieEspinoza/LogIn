<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class UsuarioSeeder extends Seeder
{
   public function run() {
       User::updateOrCreate
       (

           [
               'name' => 'Empleado de Prueba',
               'rol_id' => 1,
               'email' => 'empleado1@inventario.uma.edu.sv',
               'password'  => Hash::make('123'),


           ]
       );
   }


}
