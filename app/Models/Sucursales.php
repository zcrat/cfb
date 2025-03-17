<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\RecepcionVehiculardemo;
class Sucursales extends Model
{
    protected $table = 'sucursales';
    protected $fillable =[
        'clave',
        'folio',
        'numero',
        'nombre',
        'calle',
        'numero_ext',
        'numero_int',
        'colonia',
        'cp',
        'ciudad',
        'estado',
        'telefono',
        'email'
    ];
    function concepto(){
        return $this->hasMany(ConceptosPresupuestos::class,'contrato_id','id');
    }
    function RecepcionVehicular(){
        return $this->hasMany(RecepcionVehiculardemo::class,'zona_id','id');
    }
}
