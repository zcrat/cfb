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
        'regimen'
    ];

    function customers(){
        return $this->hasMany(Customer::class, 'empresa_id','id'); 
    }
    function facturas(){
        return $this->hasMany(Factura::class, 'empresa_id','id'); 
    }
}
