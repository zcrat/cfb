<?php

namespace App\Models;

use App\Models\RecepcionGeneralModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatusModel extends Model

{
    use SoftDeletes;
    protected $table = 'status';
    protected $fillable = [
      'nombre',
      'descripcion'
    ];

    function Presupuestos(){
      return $this->hasMany(PresupuestosModel::class, 'status','id'); 
  }
}
