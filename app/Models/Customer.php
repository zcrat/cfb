<?php

namespace App\Models;
use App\Models\Empresa;
use App\Models\Recepcionvehicular;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';
    protected $fillable = [
        'id',
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
        return $this->belongsTo(Empresa::class,'empresa_id','id');
    }
    function recepcionvehicular(){
        return $this->hasMany(Recepcionvehicular::class,'customer_id','id');
    }
    function datosgenerales(){
        return $this->hasMany(Recepcionvehiculardemo::class,'customer_id','id');
    }
}
