<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Presupuesto extends Model
{
    use  SoftDeletes;

    protected $table = 'PresupuestosNuevos';

    protected $fillable = [
        'DetallesGenerales_id', 'Observaciones', 'OrdenServicio','FechaDeVigencia', 
        'Factura_id', 'Tipo_id', 'Status_id'
    ];

    public function detallesGenerales()
    {
        return $this->belongsTo(DetallesGenerales::class, 'DetallesGenerales_id');
    }
}
