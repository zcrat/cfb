<?php

namespace App;
use App\Empresa;
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
}
