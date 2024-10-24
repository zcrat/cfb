<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductosGrupos extends Model
{
    protected $table = 'productos_grupos';
    protected $fillable = [
        'id',
        'productos_id',
        'grupos_id',
        'precio'
    ];
}
