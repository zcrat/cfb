<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrenTransmision extends Model
{
    protected $table = 'tren_transmision';
    protected $fillable = [
        'filtro_transmison',
        'union_transmision_clutch',
        'eje_traccion_juntas_homocineticas',
        'eje_transmision_juntas_universales',
        'rodamientos_rueda',
        'tren_transmision',
        'clutch',
        'tren_notas'
    ];
}
