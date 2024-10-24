<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $fillable = [
        'nombre',
        'direccion',
        'ciudad',
        'estado',
        'cp',
        'tel_casa',
        'tel_oficina',
        'tel_celular',
        'orden_segumiento',
        'email',
        'fecha',
        'empresa_id'
    ];

    function empresa(){
        return $this->hasOne(Empresa::class);
    }
}
