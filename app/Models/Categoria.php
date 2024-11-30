<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Articulo;
class Categoria extends Model
{
    protected $table = 'categorias';
    //protected $primaryKey = 'id';

    protected $fillable = ['nombre','descripcion','condicion'];

    public function articulos()
    {
        return $this->hasMany(Articulo::class,'idcategoria','id');
    }
}
