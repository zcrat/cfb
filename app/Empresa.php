<?php

namespace App;
use App\Customer;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresas';
    protected $fillable = [
        'id',
        'nombre',
        'rfc',
        'logo',
        'email',
        'direccion',
        'ciudad',
        'estado',
        'cp',
        'tel_negocio',
        'tel_casa',
        'tel_celular',
    ];

    function customers(){
        return $this->hasMany(Customer::class, 'empresa_id','id'); 
    }
}
