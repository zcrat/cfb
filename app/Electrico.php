<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Electrico extends Model
{
    protected $table = 'electrico';
    protected $fillable = [
        'sistema_carga_bateria',
        'cables_conexiones_fusibles',
        'faros',
        'faro_izquierda',
        'faro_derecha',
        'cuartos',
        'cuarto_izquierda',
        'cuarto_derecha',
        'reversa_frenos',
        'direccionales',
        'direccionales_izquierda_delantera',
        'direccionales_derecha_delantera',
        'direccionales_izquierda_trasera',
        'direccionales_derecha_trasera',
        'intermitentes'
    ];
}
