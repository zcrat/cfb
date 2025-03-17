<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\RecepcionGeneralModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class NivelesCombustibleModel extends Model
{
    use SoftDeletes;
    protected $table = 'nivelescombustible';
    protected $fillable = [
      'nombre'
    ];
    function RecepcionGeneralSalida(){
        return $this->hasmany(RecepcionGeneralModel::class,'GasolinaSalida_id','id');
    }
    function RecepcionGeneralEntrada(){
        return $this->hasmany(RecepcionGeneralModel::class,'GasolinaEntrada_id','id');
    }
}
