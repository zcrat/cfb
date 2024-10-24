<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    protected $fillable =[
        'idcategoria','codigo_sat','unidad_sat','unidad','codigo','nombre','descripcion','precio_venta','stock','condicion'
    ];
    public function categoria(){
        return $this->belongsTo('App\Categoria');
    }
}
