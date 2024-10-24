<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Llantas extends Model
{
    protected $table = 'llantas';
    protected $fillable = [
        'izquierda_delantera',
        'izquierda_delantera_presion',
        'izquierda_trasera',
        'izquierda_trasera_presion',
        'derecha_delantera',
        'derecha_delantera_presion',
        'derecha_trasera',
        'derecha_trasera_presion',
        'refaccion',
        'refaccion_presion',
        'alineacion_balanceo'
    ];

}
