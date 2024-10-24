<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    protected $table = 'productos';
    protected $fillable = [
        'id',
        'idproveedor',
        'idcategoria',
        'idmarca_prod',
        'codigosat',
        'unidadsat',
        'unidad',
        'numfactura',
        'strdescripcion',
        'strcodigo',
        'strimagen',
        'cantidad',
        'intcosto',
        'intprecio1',
        'intprecio2',
        'intprecio3',
        'intprecio4',
        'intprecio',
        'idorden',
        'fechaingreso',
        'niveles'
    ];
}
