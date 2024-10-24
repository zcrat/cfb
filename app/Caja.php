<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    //
    protected $table = 'caja';
    protected $fillable = [
        'id',
        'fecha',
        'concepto',
        'ingreso',
        'egreso',
        'saldo',
    ];

    function facturas(){
        return $this->hasOne(FacturasCaja::class,'id','caja_id');
    }
}
