<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Vehiculo;
use App\Models\Empresa;
use App\Models\Customer;
class RecepcionVehicular extends Model
{
    protected $table = 'recepcion_vehicular';
    protected $fillable = [
        'folioNum',
        'usuario_id',
        'empresa_id',
        'customer_id',
        'vehiculo_id',
        'orden_seguimiento',
        'folio',
        'notas_adicionales',
        'indicaciones_del_cliente',
        'km_entrada',
        'km_salida',
        'km_salida',
        'gas_entrada',
        'gas_salida',
        'fecha',
        'firma',
        'carro',
        'fecha_compromiso',
        'sucursal_id',
        'modulo',
        'administrador',
        'jefedeprocesos',
        'telefonojefe',
        'trabajador'

    ];

    protected $with = ['vehiculo', 'empresa'];
    function empresa(){
        return $this->belongsTo(Empresa::class,'empresa_id','id');
    }
    function vehiculo(){
        return $this->belongsTo(Vehiculo::class, 'vehiculo_id','id'); 
    
    }
    function customer(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
}
