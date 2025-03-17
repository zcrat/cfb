<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\RecepcionVehiculardemo;
class AnioCorrespondiente extends Model
{
    protected $table = 'anio_Correspondiente';
    protected $fillable = ['descripcion',];

    function concepto(){
        return $this->hasMany(ConceptosPresupuestos::class,'id_anio_correspondiente','id');
    }
    function RecepcionVehicular(){
        return $this->hasMany(RecepcionVehiculardemo::class,'anio_id','id');
    }
}
