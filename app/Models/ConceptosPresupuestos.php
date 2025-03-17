<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConceptosPresupuestos extends Model
{
    protected $table = 'pcfeconceptos';
    //protected $primaryKey = 'id';

    protected $fillable = ['pCFECategorias_id','pCFETipos_id','descripcion','p_refaccion','tiempo','p_mo','pnuevo','p_total','codigo_sat','codigo_unidad','unidad_text','contrato_id','CFE_id','id_anio_correspondiente'];


    function categoria(){
        return $this->belongsTo(CategoriasPresupuesto::class,'pCFECategorias_id','id');
    }
    function tipoVehiculo(){
        return $this->belongsTo(TiposVehiculo::class,'pCFETipos_id','id');
    }
    function contrato(){
        return $this->belongsTo(Sucursales::class,'contrato_id','id');
    }
    function modulo(){
        return $this->belongsTo(Modulo::class,'CFE_id','id');
    }
    function anio(){
        return $this->belongsTo(AnioCorrespondiente::class,'id_anio_correspondiente','id');
    }
}
