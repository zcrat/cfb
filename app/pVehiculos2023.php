<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pVehiculos2023 extends Model
{
    protected $table = 'pVehiculos2023';
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
