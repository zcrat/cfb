<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AfinacionMotor extends Model
{
    protected $table = 'afinacion_motor';
    protected $fillable = [
        'tapa_distribuidor_bujias_cables',
        'fuel_injection'
    ];
}
