<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CondicionesPintura extends Model
{
    protected $table = 'condiciones_pintura';
    protected $fillable = [
        'recepcion_vehicular_id',
        'decolorada',
        'emblemas_completos',
        'color_no_igual',
        'logos',
        'exeso_rayones',
        'exeso_rociado',
        'pequenias_grietas',
        'danios_granizado',
        'carroceria_golpes',
        'lluvia_acido',
    ];

    function recepcionVehicular(){
        return $this->hasOne(RecepcionVehicular::class);
    }
}
