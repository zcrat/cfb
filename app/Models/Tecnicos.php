<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\RecepcionVehiculardemo;
use Illuminate\Database\Eloquent\SoftDeletes;
class Tecnicos extends Model
{
    use SoftDeletes;
    protected $table = 'Tecnicos1';
    protected $fillable = [
      'nombre'
    ];
    function RecepcionVehicular(){
        return $this->hasMany(RecepcionVehiculardemo::class,'tecnico_id','id');
    }
}
