<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReparacionesTecnicos extends Model
{
    protected $table = 'reparaciones_tecnicos';
    protected $fillable = [
        'id',
        'marca_modelo',
        'economico_placas',
        'r_r',
        'descripcion',
        'id_tecnico',
        'fecha'
}
