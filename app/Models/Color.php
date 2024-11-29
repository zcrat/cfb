<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Vehiculo;
class Color extends Model
{
    protected $table = 'colores';
    protected $fillable = [
      'nombre'
    ];
}
function color(){
  return $this->hasmany(Vehiculo::class,'color_id','id');
}