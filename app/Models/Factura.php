<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Empresa;
class Factura extends Model
{
    protected $table = 'facturas';
    protected $fillable = [
        'id', 
        'empresa_id',
        'emisor_id',
        'idusuario',
        'xml',
        'pdf',
        'estado',
        'movimiento',
        'n_movimiento'
     ];

    function empresa(){
        return $this->belongsTo(Empresa::class,'empresa_id','id');
    }


}
