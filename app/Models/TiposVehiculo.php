<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TiposVehiculo extends Model
{
    protected $table = 'pCFETipos';
    protected $fillable = [
        'id',
        'tipo',
    ];
    function concepto(){
        return $this->hasMany(ConceptosPresupuestos::class,'pCFETipos_id','id');
    }
}
