<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ConceptosPresupuestos;
use App\Models\RecepcionVehiculardemo;
class Modulo extends Model
{
    protected $table = 'modulos';
    protected $fillable = ['descripcion',];

    function concepto(){
        return $this->hasMany(ConceptosPresupuestos::class,'CFE_id','id');
    }
    function RecepcionVehicular(){
        return $this->hasMany(RecepcionVehiculardemo::class,'modulo_id','id');
    }
}
