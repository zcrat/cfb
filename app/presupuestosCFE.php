<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\Mensajes;
class presupuestosCFE extends Model
{
    protected $table = 'presupuestosCFE';
    protected $fillable = [
        'd',
        'pCFEVehiculos_id',
        'pCFEGenerales_id',
        'descripcionMO',
        'fechaDeVigencia',
        'tiempo',
        'importe',
        'observaciones',
        'user_id',
        'factura_id',
        'listo',
        'status',
        'id_anio_correspondiente'
    ];
     function mensajes(){
        return $this->hasMany(Mensajes::class, 'presupuesto_id','id'); 
    }
}
