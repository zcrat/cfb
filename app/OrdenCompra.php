<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenCompra extends Model
{
    protected $table = 'orden_compra';
    protected $fillable = [
      'hoja_concepto_id',
      'folio',
      'hora_creada',
      'para',
      'asignada_mensajero_hora',
      'entrega_mensajero_hora',
      'clave',
      'cantidad',
      'descripcion',
      'precio',
      'monto',
      'fecha',
      'autorizado',
      'firma_recibido',
      'hora_firma'
    ];
}
