<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\RecepcionVehiculardemo;
class Contratos extends Model
{
    protected $table = 'contratos';
    protected $fillable = [
      'nombre',  
      'numero',
      'monto'
    ];
    function RecepcionVehicular(){
      return $this->hasMany(RecepcionVehiculardemo::class,'contrato_id','id');
  }
}
