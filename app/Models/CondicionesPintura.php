<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CondicionesPintura extends Model
{
    protected $table = 'condicionespintura';
    protected $fillable = [
        'RecepcionVehicular_id',
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
