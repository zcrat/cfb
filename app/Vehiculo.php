<?php

namespace App;

use App\TipoAuto;
use App\Marca;
use App\Modelo;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    protected $table = 'vehiculos';
    protected $fillable = [
        'tipo_id',
        'marca_id',
        'modelo_id',
        'color_id',
        'placas',
        'anio',
        'no_economico',
        'vim',
    ];

    function tipo(){
        return $this->hasOne(TipoAuto::class,'id','tipo_id');
    }

    function marca(){
        return $this->hasOne(Marca::class,'id','marca_id');
    }

    function modelo(){
        return $this->hasOne(Modelo::class,'id','modelo_id');
    }
}
