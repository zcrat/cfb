<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pVehiculos extends Model
{
    protected $table = 'pVehiculos';
    protected $fillable = [
        'd',
        'identificador',
        'modelo',
        'vin',
        'placas',
        'ano',
        'kilometraje',
        'marca',
        'fecha'
    ];
}
