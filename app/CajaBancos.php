<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CajaBancos extends Model
{
    protected $table = 'caja_bancos';
    protected $fillable = [
        'id',
        'fecha',
        'cuenta_id',
        'concepto',
        'ingreso',
        'egreso',
        'saldo',
    ];
    function facturas(){
        return $this->hasOne(FacturasCajaBancos::class,'id','caja_bancos_id');
    }
}
