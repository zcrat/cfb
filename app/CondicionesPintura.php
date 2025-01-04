<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\RecepcionVehicular;
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
        return $this->hasMany(RecepcionVehicular::class,'recepcion_vehicular_id');
    }
}
