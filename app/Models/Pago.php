<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $fillable = [
        'estudiante_id',
        'referencia',
        'monto',
        'metodo_pago',
        'estado',
    ];
}
