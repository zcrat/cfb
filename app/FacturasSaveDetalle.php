<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacturasSaveDetalle extends Model
{
    protected $table = 'facturas_save_detalle';
    protected $fillable = [
        'id', 
        'facturas_save_id',
        'contrato',
        'presupuesto_id',
        'economico',
        'placas',
        'kilometraje',
        'NSolicitud',
        'descripcionMO',
        'importep'
     ];
}
