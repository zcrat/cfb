<?php

namespace App;
use App\Models\RecepcionVehicular;
use Illuminate\Database\Eloquent\Model;

class EquipoInventario extends Model
{
    protected $table = 'equipo_inventario';
    protected $fillable = [
        'recepcion_vehicular_id',
        'llanta',
        'cubreruedas',
        'cables_corriente',
        'candado_ruedas',
        'estuche_herramientas',
        'gato',
        'llave_tuercas',
        'tarjeta_circulacion',
        'triangulo_seguridad',
        'extinguidor',
        'placas',
    ];
    function recepcionVehicular(){
        return $this->hasMany(RecepcionVehicular::class ,'recepcion_vehicular_id');
    }
}
