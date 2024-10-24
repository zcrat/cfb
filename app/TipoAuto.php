<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoAuto extends Model
{
    protected $table = 'tipo_auto';
    protected $fillable = [
        'nombre'
    ];

    function vehiculos(){
        return $this->hasMany(Vehiculo::class);
    }
}
