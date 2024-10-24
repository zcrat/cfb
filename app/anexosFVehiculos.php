<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class anexosFVehiculos extends Model
{
    protected $table = 'anexosFVehiculos';
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
