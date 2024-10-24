<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\pConceptos;
use DB;
use App\pCarrito;
use App\pCategorias;
use App\pTipos;
use Illuminate\Support\Carbon;

class pConceptosController extends Controller
{

    public function index(Request $request){

        $categoria = pCategorias::orderBy('titulo', 'asc')->get();
        $tipos = pTipos::orderBy('tipo', 'asc')->get();
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($request->categoria_id == 0){

            if ($request->tipo_id == 0){
                 
                if($buscar == null){
                    $categorias = pConceptos::join('pCategorias','pConceptos.pCategorias_id','=','pCategorias.id')
                    ->join('pTipos','pConceptos.pTipos_id','=','pTipos.id')
                    ->select('pCategorias.id as pCategorias_id','pTipos.id as pTipos_id','pCategorias.titulo as categoria','pTipos.tipo',
                    'pConceptos.id','pConceptos.num','pConceptos.descripcion','pConceptos.p_refaccion','pConceptos.tiempo','pConceptos.p_mo','pConceptos.pnuevo','pConceptos.p_total','pConceptos.codigo_sat','pConceptos.codigo_unidad','pConceptos.unidad_text')
                    ->orderBy('pCategorias.id', 'asc')->paginate(20);  
                } else {

                    $categorias = pConceptos::join('pCategorias','pConceptos.pCategorias_id','=','pCategorias.id')
                    ->join('pTipos','pConceptos.pTipos_id','=','pTipos.id')
                    ->select('pCategorias.id as pCategorias_id','pTipos.id as pTipos_id','pCategorias.titulo as categoria','pTipos.tipo',
                    'pConceptos.id','pConceptos.num','pConceptos.descripcion','pConceptos.p_refaccion','pConceptos.tiempo','pConceptos.p_mo','pConceptos.pnuevo','pConceptos.p_total','pConceptos.codigo_sat','pConceptos.codigo_unidad','pConceptos.unidad_text')
                     ->where('pConceptos.descripcion', 'like', '%'. $buscar . '%')
                     ->orderBy('pCategorias.id', 'asc')->paginate(20);


                }



            } else {

                if($buscar == null){
                    $categorias = pConceptos::join('pCategorias','pConceptos.pCategorias_id','=','pCategorias.id')
                    ->join('pTipos','pConceptos.pTipos_id','=','pTipos.id')
                    ->select('pCategorias.id as pCategorias_id','pTipos.id as pTipos_id','pCategorias.titulo as categoria','pTipos.tipo',
                    'pConceptos.id','pConceptos.num','pConceptos.descripcion','pConceptos.p_refaccion','pConceptos.tiempo','pConceptos.p_mo','pConceptos.pnuevo','pConceptos.p_total','pConceptos.codigo_sat','pConceptos.codigo_unidad','pConceptos.unidad_text')
                    ->where('pConceptos.pTipos_id', '=', $request->tipo_id)
                     ->orderBy('pCategorias.id', 'asc')->paginate(20);
                } else {

                    $categorias = pConceptos::join('pCategorias','pConceptos.pCategorias_id','=','pCategorias.id')
                    ->join('pTipos','pConceptos.pTipos_id','=','pTipos.id')
                    ->select('pCategorias.id as pCategorias_id','pTipos.id as pTipos_id','pCategorias.titulo as categoria','pTipos.tipo',
                    'pConceptos.id','pConceptos.num','pConceptos.descripcion','pConceptos.p_refaccion','pConceptos.tiempo','pConceptos.p_mo','pConceptos.pnuevo','pConceptos.p_total','pConceptos.codigo_sat','pConceptos.codigo_unidad','pConceptos.unidad_text')
                    ->where('pConceptos.pTipos_id', '=', $request->tipo_id)
                    ->where('pConceptos.descripcion', 'like', '%'. $buscar . '%')
                     ->orderBy('pCategorias.id', 'asc')->paginate(20);


                }


                
            }
           
        } else {


            if ($request->tipo_id == 0){
                if($buscar == null){
                    $categorias = pConceptos::join('pCategorias','pConceptos.pCategorias_id','=','pCategorias.id')
                    ->join('pTipos','pConceptos.pTipos_id','=','pTipos.id')
                    ->select('pCategorias.id as pCategorias_id','pTipos.id as pTipos_id','pCategorias.titulo as categoria','pTipos.tipo',
                    'pConceptos.id','pConceptos.num','pConceptos.descripcion','pConceptos.p_refaccion','pConceptos.tiempo','pConceptos.p_mo','pConceptos.pnuevo','pConceptos.p_total','pConceptos.codigo_sat','pConceptos.codigo_unidad','pConceptos.unidad_text')
                    ->where('pConceptos.pCategorias_id', '=', $request->categoria_id)
                     ->orderBy('pCategorias.id', 'asc')->paginate(20);
                } else {

                    $categorias = pConceptos::join('pCategorias','pConceptos.pCategorias_id','=','pCategorias.id')
                    ->join('pTipos','pConceptos.pTipos_id','=','pTipos.id')
                    ->select('pCategorias.id as pCategorias_id','pTipos.id as pTipos_id','pCategorias.titulo as categoria','pTipos.tipo',
                    'pConceptos.id','pConceptos.num','pConceptos.descripcion','pConceptos.p_refaccion','pConceptos.tiempo','pConceptos.p_mo','pConceptos.pnuevo','pConceptos.p_total','pConceptos.codigo_sat','pConceptos.codigo_unidad','pConceptos.unidad_text')
                    ->where('pConceptos.pCategorias_id', '=', $request->categoria_id)
                     ->where('pConceptos.descripcion', 'like', '%'. $buscar . '%')
                     ->orderBy('pCategorias.id', 'asc')->paginate(20);


                }
            } else {
                if($buscar == null){
                    $categorias = pConceptos::join('pCategorias','pConceptos.pCategorias_id','=','pCategorias.id')
                    ->join('pTipos','pConceptos.pTipos_id','=','pTipos.id')
                    ->select('pCategorias.id as pCategorias_id','pTipos.id as pTipos_id','pCategorias.titulo as categoria','pTipos.tipo',
                    'pConceptos.id','pConceptos.num','pConceptos.descripcion','pConceptos.p_refaccion','pConceptos.tiempo','pConceptos.p_mo','pConceptos.pnuevo','pConceptos.p_total','pConceptos.codigo_sat','pConceptos.codigo_unidad','pConceptos.unidad_text')
                    ->where('pConceptos.pCategorias_id', '=', $request->categoria_id)
                    ->where('pConceptos.pTipos_id', '=', $request->tipo_id)
                     ->orderBy('pCategorias.id', 'asc')->paginate(20);
                } else {

                    $categorias = pConceptos::join('pCategorias','pConceptos.pCategorias_id','=','pCategorias.id')
                    ->join('pTipos','pConceptos.pTipos_id','=','pTipos.id')
                    ->select('pCategorias.id as pCategorias_id','pTipos.id as pTipos_id','pCategorias.titulo as categoria','pTipos.tipo',
                    'pConceptos.id','pConceptos.num','pConceptos.descripcion','pConceptos.p_refaccion','pConceptos.tiempo','pConceptos.p_mo','pConceptos.pnuevo','pConceptos.p_total','pConceptos.codigo_sat','pConceptos.codigo_unidad','pConceptos.unidad_text')
                    ->where('pConceptos.pCategorias_id', '=', $request->categoria_id)
                    ->where('pConceptos.pTipos_id', '=', $request->tipo_id)
                    ->where('pConceptos.descripcion', 'like', '%'. $buscar . '%')
                     ->orderBy('pCategorias.id', 'asc')->paginate(20);


                }

            }



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


            $vehiculo = new pConceptos();
            $vehiculo->pCategorias_id = $request->pCFECategorias_id;
            $vehiculo->pTipos_id = $request->pCFETipos_id;
            $vehiculo->num = $request->num;
            $vehiculo->descripcion = $request->descripcion;
            $vehiculo->p_refaccion = $request->p_refaccion;
            $vehiculo->tiempo = $request->tiempo;
            $vehiculo->p_mo = $request->p_mo;
            $vehiculo->p_total = $request->p_total;
            $vehiculo->codigo_sat = $request->codigo_sat;
            $vehiculo->codigo_unidad = $request->codigo_unidad;
            $vehiculo->unidad_text = $request->unidad_text;
            $vehiculo->save();             
          
           
            DB::commit();
            return [
                'id'=> $vehiculo->id
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }
    public function update(Request $request)
    {
        
            if (!$request->ajax()) return redirect('/');
            $vehiculo = pConceptos::findOrFail($request->id);
            $vehiculo->pCategorias_id = $request->pCFECategorias_id;
            $vehiculo->pTipos_id = $request->pCFETipos_id;
            $vehiculo->num = $request->num;
            $vehiculo->descripcion = $request->descripcion;
            $vehiculo->p_refaccion = $request->p_refaccion;
            $vehiculo->tiempo = $request->tiempo;
            $vehiculo->p_mo = $request->p_mo;
            $vehiculo->p_total = $request->p_total;
            $vehiculo->codigo_sat = $request->codigo_sat;
            $vehiculo->codigo_unidad = $request->codigo_unidad;
            $vehiculo->unidad_text = $request->unidad_text;
            $vehiculo->save();    
            
    }
    public function selectConceptos(Request $request){

       
        $idc = $request->idc;
        $idt = $request->idt;
        $buscar = $request->buscar;

       

        if (!$request->ajax()) return redirect('/');
        $categorias = pConceptos::select('id','num','descripcion','p_total')
        ->where('pCategorias_id','=',$idc)
        ->where('pTipos_id','=',$idt)
        ->where('descripcion', 'like', '%'. $buscar . '%')
        ->orderBy('id', 'asc')->paginate(30);
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

    public function obtenerDetallesmulti(Request $request){

         
       
    
        

        if (!$request->ajax()) return redirect('/');
 

        $id = $request->ides;//Array de detalles
        //Recorro todos los elementos

        
      
        $pila = [];

    
        foreach($id as $ep=>$det)
        {
          
            $detalles = pConceptos::select('id','num','descripcion','p_total')
            ->where('id','=',$det['id'])->get();
    

            //$preciov = $det['pnuevo']*1.82;
            $preciov = $detalles[0]['p_total'];

            $vehiculo = new pCarrito();
            $vehiculo->presupuesto_id = $request->id;
            $vehiculo->pConcepto_id = $detalles[0]['id'];
            $vehiculo->cantidad = $det['cantidad'];
            $vehiculo->precio = $det['pnuevo'];
            $vehiculo->precio_v = $preciov;
            $vehiculo->usuario_id = \Auth::user()->id;
            $vehiculo->save();
        
            array_push($pila,$detalles[0]);  
        } 
         

        
       

        return [
           
             'detalles' => $pila
        ];
    }

    public function delete(Request $request){
        
    
 
        $sucursal = pConceptos::findOrFail($request->id);
        $sucursal->delete();

        $estado = true;
        return collect(['estado' => $estado]);
    
}

}
