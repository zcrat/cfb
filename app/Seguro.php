<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seguro extends Model
{
    protected $table = 'seguros';
    protected $fillable = [
        'cia_seg',
        'tel_seg',
        'no_siniestro',
        'ajustador',
        'recepcion_vehicular_id'
    ];

    function recepcion_vehicular(){
        return $this->hasOne(RecepcionVehicular::class);
    }
}
