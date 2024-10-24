<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Liquidos extends Model
{
    protected $table = 'liquidos';
    protected $fillable = [
        'aceite_motor',
        'aceite_motor_ok',
        'aceite_motor_lleno',
        'transmision',
        'transmision_ok',
        'transmision_lleno',
        'diferencial_frente_trasero',
        'diferencial_frente_trasero_ok',
        'diferencial_frente_trasero_lleno',
        'liquido_refrigerante',
        'refrigerante_ok',
        'refrigerante_lleno',
        'frenos',
        'frenos_ok',
        'frenos_lleno',
        'direccion_hidraulica',
        'direccion_hidraulica_ok',
        'direccion_hidraulica_lleno',
        'limpiaparabrisas',
        'limpiaparabrisas_ok',
        'limpiaparabrisas_lleno',
        'liquido_notas'
    ];
}
