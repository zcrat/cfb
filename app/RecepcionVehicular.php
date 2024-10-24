<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

    function empresa(){
        return $this->hasOne(Empresa::class,'id','empresa_id');
    }

    function vehiculo(){
        return $this->hasOne(Vehiculo::class,'id','vehiculo_id');
    }
}
