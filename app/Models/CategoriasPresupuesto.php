<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriasPresupuesto extends Model
{
    protected $table = 'pCFECategorias';
    protected $fillable = [
        'id',
        'num',
        'titulo',
    ];
    function concepto(){
        return $this->hasMany(ConceptosPresupuestos::class,'pCFECategorias_id','id');
    }
}
