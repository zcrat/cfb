<?php

namespace App\Models;

use App\Models\TipoAuto;
use App\Models\Marca;
use App\Models\Modelo;
use App\Models\Color;
use App\Models\Recepcionvehicular;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    protected $table = 'vehiculos';
    
    protected $with = ['tipo', 'marca','modelo','color'];
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
        return $this->belongsTo(TipoAuto::class,'tipo_id','id');
    }

    function marca(){
        return $this->belongsTo(Marca::class,'marca_id','id');
    }

    function modelo(){
        return $this->belongsTo(Modelo::class,'modelo_id','id');
    }
    function color(){
        return $this->belongsTo(Color::class,'color_id','id');
    }
    function recepcionvehicular(){
        
        return $this->hasMany(RecepcionVehicular::class, 'vehiculo_id','id'); 
    }
}
