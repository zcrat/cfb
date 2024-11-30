<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Vehiculo;
class Marca extends Model
{
    protected $table = 'marcas';
    protected $fillable = [
      'nombre'
    ];

    function vehiculos(){
      return $this->hasMany(Vehiculo::class, 'marca_id','id'); 
  }
}
