<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';
    protected $fillable = [
        'nombre',
        'direccion',
        'ciudad',
        'estado',
        'cp',
        'tel_casa',
        'tel_oficina',
        'tel_celular',
        'email',
        'empresa_id'
    ];

    function empresa(){
        return $this->hasOne(Empresa::class);
    }
}
