<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\pCFEConceptos;
use DB;
use App\pCFECarrito;
use App\pCFECategorias;
use App\pCFETipos;
use Illuminate\Support\Carbon;

class pCFEO2023ConceptosController extends Controller
{
    public function index(Request $request){

        $categoria = pCFECategorias::where('CFE_id','=','3')->where('sucursal_id','=',\Auth::user()->sucursal_id)->get();
        $tipos = pCFETipos::where('CFE_id','=','3')->get();
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar==''){
            $categorias = pCFEConceptos::join('pCFECategorias','pCFEConceptos.pCFECategorias_id','=','pCFECategorias.id')
            ->join('pCFETipos','pCFEConceptos.pCFETipos_id','=','pCFETipos.cilindros')
            ->select('pCFECategorias.id as pCFECategorias_id','pCFETipos.id as pCFETipos_id','pCFECategorias.titulo as categoria','pCFETipos.tipo',
             'pCFEConceptos.id','pCFEConceptos.num','pCFEConceptos.descripcion','pCFEConceptos.p_refaccion','pCFEConceptos.tiempo','pCFEConceptos.p_mo','pCFEConceptos.pnuevo','pCFEConceptos.p_total','pCFEConceptos.codigo_sat','pCFEConceptos.codigo_unidad','pCFEConceptos.unidad_text')
             ->where('pCFEConceptos.CFE_id','=','3')
             ->orderBy('pCFECategorias.id', 'asc')->paginate(20);
        }
        else{
            $categorias = pCFEConceptos::join('pCFECategorias','pCFEConceptos.pCFECategorias_id','=','pCFECategorias.id')
            ->join('pCFETipos','pCFEConceptos.pCFETipos_id','=','pCFETipos.cilindros')
            ->select('pCFECategorias.id as pCFECategorias_id','pCFETipos.id as pCFETipos_id','pCFECategorias.titulo as categoria','pCFETipos.tipo',
             'pCFEConceptos.id','pCFEConceptos.num','pCFEConceptos.descripcion','pCFEConceptos.p_refaccion','pCFEConceptos.tiempo','pCFEConceptos.p_mo','pCFEConceptos.pnuevo','pCFEConceptos.p_total','pCFEConceptos.codigo_sat','pCFEConceptos.codigo_unidad','pCFEConceptos.unidad_text')
             ->where('pCFEConceptos.CFE_id','=','3')
             ->where($criterio, 'like', '%'. $buscar . '%')
             ->orderBy('pCFECategorias.id', 'asc')->paginate(20);
        }
     
        
        
        return [
            'pagination' => [
                'total'        => $categorias->total(),
                'current_page' => $categorias->currentPage(),
                'per_page'     => $categorias->perPage(),
                'last_page'    => $categorias->lastPage(),
                'from'         => $categorias->firstItem(),
                'to'           => $categorias->lastItem(),
            ],
            'conceptos' => $categorias,
            'categorias' => $categoria,
            'tipos' => $tipos
        ];
    }


    public function store(Request $request)
    {
  
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $mytime= Carbon::now('America/Lima');
            $fechita = Carbon::parse($request->fecha)->format('Y-m-d H:m');


            $vehiculo = new pCFEConceptos();
            $vehiculo->pCFECategorias_id = $request->pCFECategorias_id;
            $vehiculo->pCFETipos_id = $request->pCFETipos_id;
            $vehiculo->num = $request->num;
            $vehiculo->descripcion = $request->descripcion;
            $vehiculo->p_refaccion = $request->p_refaccion;
            $vehiculo->tiempo = $request->tiempo;
            $vehiculo->p_mo = $request->p_mo;
            $vehiculo->p_total = $request->p_total;
            $vehiculo->codigo_sat = $request->codigo_sat;
            $vehiculo->codigo_unidad = $request->codigo_unidad;
            $vehiculo->unidad_text = $request->unidad_text;
            $vehiculo->CFE_id = '3';
            $vehiculo->save();             
          
           
            DB::commit();
            return [
                'id'=> $vehiculo->id
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }


    public function selectConceptos(Request $request){
        $idc = $request->idc;
        $idt = $request->idt;
        $buscar = $request->buscar;
       

        if (!$request->ajax()) return redirect('/');
        $categorias = pCFEConceptos::select('id','num','descripcion','pnuevo','p_total')
        ->where('pCFECategorias_id','=',$idc)
        ->where('pCFETipos_id','=',$idt)
        ->where('descripcion', 'like', '%'. $buscar . '%')
        ->where('CFE_id','=','3')
        ->orderBy('id', 'asc')->paginate(20);
        
        return [
            'pagination' => [
                'total'        => $categorias->total(),
                'current_page' => $categorias->currentPage(),
                'per_page'     => $categorias->perPage(),
                'last_page'    => $categorias->lastPage(),
                'from'         => $categorias->firstItem(),
                'to'           => $categorias->lastItem(),
            ],
            'conceptos' => $categorias
        ];
    }
}
