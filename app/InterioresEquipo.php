<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InterioresEquipo extends Model
{
    protected $table = 'interiores_equipo';
    protected $fillable = [
        'recepcion_vehicular_id',
        'puerta_interior_frontal',
        'puerta_interior_trasera',
        'puerta_delantera_frontal',
        'puerta_delantera_trasera',
        'asiento_interior_frontal',
        'asiento_interior_trasera',
        'asiento_delantera_frontal',
        'asiento_delantera_trasera',
        'consola_central',
        'claxon',
        'tablero',
        'quemacocos',
        'toldo',
        'elevadores_eletricos',
        'luces_interiores',
        'seguros_eletricos',
        'tapetes',
        'climatizador',
        'radio',
        'espejos_retrovizor',
    ];
    function recepcionVehicular(){
        return $this->hasOne(RecepcionVehicular::class);
    }
}
