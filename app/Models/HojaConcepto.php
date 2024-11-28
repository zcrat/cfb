<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HojaConcepto extends Model
{
    protected $table = 'hoja_conceptos';
    protected $fillable = [
      'id_recepcion',
      'id_tecnico',
      'odes',
      'r_r',
      'fecha_hoja_concepto',
      'subtotal_partes',
      'subtotal_mano_obra',
      'subtotal_subcontratado',
      'subtotal_otros',
      'subtotal_subtotal_costos',
      'iva_subtotal_partes',
      'iva_subtotal_mano_obra',
      'iva_subtotal_subcontratado',
      'iva_subtotal_otros',
      'iva_subtotal_subtotal_costos',
      'total_partes',
      'total_mano_obra',
      'total_subcontratado',
      'total_otros',
      'total_subtotal_costos',
      'autorizacion'
    ];
}
