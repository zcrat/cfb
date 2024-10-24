<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bandas extends Model
{
    protected $table = 'bandas';
    protected $fillable = [
        'accesorios',
        'bandas_direccion_hidraulica',
        'alternador_aire_acondicionado'
    ];
}
