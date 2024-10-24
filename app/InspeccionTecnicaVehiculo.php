<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InspeccionTecnicaVehiculo extends Model
{
    protected $table = 'inspeccion_tecnica_vehiculo';
    protected $fillable = [
        'orden_seguimiento',
        'id_llantas',
        'id_liquidos',
        'id_bandas',
        'id_seguridad',
        'id_filtros',
        'id_escape',
        'id_suspencion_direccion',
        'id_afinacion_motor',
        'id_tren_transmision',
        'id_frenos',
        'id_electrico',
        'id_revision_luces_espias',
        'id_mangueras',
        'ante_firma',
        'indicaciones_cliente',
        'fecha',
    ];
}
