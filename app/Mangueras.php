<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mangueras extends Model
{
    protected $table = 'mangueras';
    protected $fillable = [
        'refrigerante',
        'direccion_aire_acondicionado',
        'calefaccion'
    ];
}
