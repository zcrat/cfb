<?php

namespace App\Models;

use App\Models\RecepcionGeneralModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JefeProcesosModel extends Model

{
    use SoftDeletes;
    protected $table = 'jefesproceso';
    protected $fillable = [
      'nombre'
    ];

    function RecepcionGeneral(){
      return $this->hasMany(RecepcionGeneralModel::class, 'JefeProceso_id','id'); 
  }
}
