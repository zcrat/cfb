<?php

namespace App\Models;
use App\Models\Customer;
use App\Models\Factura;
use App\Models\Recepcionvehicular;
use App\Models\Recepcionvehiculardemo;
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
    function recepcionvehicular(){
        return $this->hasMany(Recepcionvehicular::class,'empresa_id','id');
    }
    function datosgenerales(){
        return $this->hasMany(Recepcionvehiculardemo::class,'empresa_id','id');
    }
    function prefactura(){
        return $this->hasMany(FacturasSave::class, 'user_id','id'); 
    }
}
