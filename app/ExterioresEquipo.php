<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Models\RecepcionVehicular;
class ExterioresEquipo extends Model
{
    protected $table = 'exteriores_equipo';
    protected $fillable = [
        'recepcion_vehicular_id',
        'antena_radio',
        'antena_telefono',
        'antena_cb',
        'estribos',
        'espejos_laterales',
        'guardafangos',
        'parabrisas',
        'sistema_alarma',
        'limpia_parabrisas',
        'luces_exteriores',
    ];

    function recepcionVehicular(){
        return $this->hasOne(RecepcionVehicular::class,'recepcion_vehicular_id');
    }
}
