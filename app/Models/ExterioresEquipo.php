<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExterioresEquipo extends Model
{
    protected $table = 'exterioresequipo';
    protected $fillable = [
        'RecepcionVehicular_id',
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
        return $this->hasOne(RecepcionVehicular::class);
    }
}
