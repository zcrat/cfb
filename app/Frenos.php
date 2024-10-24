<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Frenos extends Model
{
    protected $table = 'frenos';
    protected $fillable = [
        'pastillas_izquierda_delantera',
        'pastillas_izquierda_trasera',
        'pastillas_derecha_delantera',
        'pastillas_derecha_trasera',
        'rotores_izquierda_delantera',
        'rotores_izquierda_trasera',
        'rotores_derecha_delantera',
        'rotores_derecha_trasera',
        'pinzas_cilindros_rueda_izquierda_delantera',
        'pinzas_cilindros_rueda_izquierda_trasera',
        'pinzas_cilindros_rueda_derecha_delantera',
        'pinzas_cilindros_rueda_derecha_trasera'
    ];
}
