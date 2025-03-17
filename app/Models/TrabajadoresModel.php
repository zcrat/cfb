<?php

namespace App\Models;

use App\Models\RecepcionGeneralModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrabajadoresModel extends Model

{
    use SoftDeletes;
    protected $table = 'trabajadores';
    protected $fillable = [
      'nombre'
    ];

    function RecepcionGeneral(){
      return $this->hasMany(RecepcionGeneralModel::class, 'Trabajador_id','id'); 
  }
}