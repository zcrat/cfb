<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\Empresa;
class FacturasSave extends Model
{
    protected $table = 'facturas_save';
    protected $fillable = [
        'id', 
        'empresa_id',
        'user_id',
        'fpago',
        'moneda',
        'mpago',
        'tipo_comprobante',
        'tipo_impuesto_local',
        'modulo_id',
        'contrato_id',
        'sucursal_id',
        'id_anio_correspondiente',
     ];
     function usuario(){
        return $this->belongsTo(User::class,'user_id','id');
    }
     function cliente(){
        return $this->belongsTo(Empresa::class,'empresa_id','id');
    }
}
