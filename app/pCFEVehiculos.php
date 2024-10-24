<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pCFEVehiculos extends Model
{
    protected $table = 'pCFEVehiculos';
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
