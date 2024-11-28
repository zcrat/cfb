<?php

namespace App\Models;
use App\Models\Categoria;
use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    protected $table ='articulos';
    protected $fillable =[
        'idcategoria','codigo_sat','unidad_sat','unidad','codigo','nombre','descripcion','precio_venta','stock','condicion'
    ];
    public function categoria(){
        return $this->belongsTo(Categoria::class,'idcategoria','id');
    }
}
