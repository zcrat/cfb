<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\pCFEConceptos;
use DB;
use App\pCFECarrito;
use App\pCFECategorias;
use App\pCFETipos;
use Illuminate\Support\Carbon;

class pCFEConceptosController extends Controller
{

    public function index(Request $request){


        $categoria = pCFECategorias::orderBy('titulo', 'asc')->get();
        $tipos = pCFETipos::orderBy('tipo', 'asc')->get();
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($request->categoria_id == 0){

            

            if($request->tipo_id == 0){

               

                if($buscar == null){

                    $categorias = pCFEConceptos::join('pCFECategorias','pCFEConceptos.pCFECategorias_id','=','pCFECategorias.id')
                    ->join('pCFETipos','pCFEConceptos.pCFETipos_id','=','pCFETipos.id')
                    ->select('pCFECategorias.id as pCFECategorias_id','pCFETipos.id as pCFETipos_id','pCFECategorias.titulo as categoria','pCFETipos.tipo',
                     'pCFEConceptos.id','pCFEConceptos.num','pCFEConceptos.descripcion','pCFEConceptos.p_refaccion','pCFEConceptos.tiempo','pCFEConceptos.p_mo','pCFEConceptos.pnuevo','pCFEConceptos.p_total','pCFEConceptos.codigo_sat','pCFEConceptos.codigo_unidad','pCFEConceptos.unidad_text')
                     ->orderBy('pCFECategorias.id', 'asc')->paginate(20);
                } else {
                    $categorias = pCFEConceptos::join('pCFECategorias','pCFEConceptos.pCFECategorias_id','=','pCFECategorias.id')
                    ->join('pCFETipos','pCFEConceptos.pCFETipos_id','=','pCFETipos.id')
                    ->select('pCFECategorias.id as pCFECategorias_id','pCFETipos.id as pCFETipos_id','pCFECategorias.titulo as categoria','pCFETipos.tipo',
                     'pCFEConceptos.id','pCFEConceptos.num','pCFEConceptos.descripcion','pCFEConceptos.p_refaccion','pCFEConceptos.tiempo','pCFEConceptos.p_mo','pCFEConceptos.pnuevo','pCFEConceptos.p_total','pCFEConceptos.codigo_sat','pCFEConceptos.codigo_unidad','pCFEConceptos.unidad_text')
                     ->where('pCFEConceptos.descripcion', 'like', '%'. $buscar . '%')
                     ->orderBy('pCFECategorias.id', 'asc')->paginate(20);

                }
 
            } else {

                if($buscar == null){
                    $categorias = pCFEConceptos::join('pCFECategorias','pCFEConceptos.pCFECategorias_id','=','pCFECategorias.id')
                    ->join('pCFETipos','pCFEConceptos.pCFETipos_id','=','pCFETipos.id')
                    ->select('pCFECategorias.id as pCFECategorias_id','pCFETipos.id as pCFETipos_id','pCFECategorias.titulo as categoria','pCFETipos.tipo',
                     'pCFEConceptos.id','pCFEConceptos.num','pCFEConceptos.descripcion','pCFEConceptos.p_refaccion','pCFEConceptos.tiempo','pCFEConceptos.p_mo','pCFEConceptos.pnuevo','pCFEConceptos.p_total','pCFEConceptos.codigo_sat','pCFEConceptos.codigo_unidad','pCFEConceptos.unidad_text')
                     ->where('pCFEConceptos.pCFETipos_id', '=', $request->tipo_id)
                     ->orderBy('pCFECategorias.id', 'asc')->paginate(20);
                    
                } else {
                    $categorias = pCFEConceptos::join('pCFECategorias','pCFEConceptos.pCFECategorias_id','=','pCFECategorias.id')
                    ->join('pCFETipos','pCFEConceptos.pCFETipos_id','=','pCFETipos.id')
                    ->select('pCFECategorias.id as pCFECategorias_id','pCFETipos.id as pCFETipos_id','pCFECategorias.titulo as categoria','pCFETipos.tipo',
                     'pCFEConceptos.id','pCFEConceptos.num','pCFEConceptos.descripcion','pCFEConceptos.p_refaccion','pCFEConceptos.tiempo','pCFEConceptos.p_mo','pCFEConceptos.pnuevo','pCFEConceptos.p_total','pCFEConceptos.codigo_sat','pCFEConceptos.codigo_unidad','pCFEConceptos.unidad_text')
                     ->where('pCFEConceptos.pCFETipos_id', '=', $request->tipo_id)
                     ->where('pCFEConceptos.descripcion', 'like', '%'. $buscar . '%')
                     ->orderBy('pCFECategorias.id', 'asc')->paginate(20);

                }

            }
               
            
           
        } else {

            if($request->tipo_id == 0){

               

                if($buscar == null){

                    $categorias = pCFEConceptos::join('pCFECategorias','pCFEConceptos.pCFECategorias_id','=','pCFECategorias.id')
                    ->join('pCFETipos','pCFEConceptos.pCFETipos_id','=','pCFETipos.id')
                    ->select('pCFECategorias.id as pCFECategorias_id','pCFETipos.id as pCFETipos_id','pCFECategorias.titulo as categoria','pCFETipos.tipo',
                    'pCFEConceptos.id','pCFEConceptos.num','pCFEConceptos.descripcion','pCFEConceptos.p_refaccion','pCFEConceptos.tiempo','pCFEConceptos.p_mo','pCFEConceptos.pnuevo','pCFEConceptos.p_total','pCFEConceptos.codigo_sat','pCFEConceptos.codigo_unidad','pCFEConceptos.unidad_text')
                    ->where('pCFEConceptos.pCFECategorias_id', '=', $request->categoria_id)
                    ->orderBy('pCFECategorias.id', 'asc')->paginate(20);
                } else {
                    $categorias = pCFEConceptos::join('pCFECategorias','pCFEConceptos.pCFECategorias_id','=','pCFECategorias.id')
                    ->join('pCFETipos','pCFEConceptos.pCFETipos_id','=','pCFETipos.id')
                    ->select('pCFECategorias.id as pCFECategorias_id','pCFETipos.id as pCFETipos_id','pCFECategorias.titulo as categoria','pCFETipos.tipo',
                    'pCFEConceptos.id','pCFEConceptos.num','pCFEConceptos.descripcion','pCFEConceptos.p_refaccion','pCFEConceptos.tiempo','pCFEConceptos.p_mo','pCFEConceptos.pnuevo','pCFEConceptos.p_total','pCFEConceptos.codigo_sat','pCFEConceptos.codigo_unidad','pCFEConceptos.unidad_text')
                    ->where('pCFEConceptos.pCFECategorias_id', '=', $request->categoria_id)
                    ->where('pCFEConceptos.descripcion', 'like', '%'. $buscar . '%')
                    ->orderBy('pCFECategorias.id', 'asc')->paginate(20);

                }

            } else {

                if($buscar == null){
                    $categorias = pCFEConceptos::join('pCFECategorias','pCFEConceptos.pCFECategorias_id','=','pCFECategorias.id')
                    ->join('pCFETipos','pCFEConceptos.pCFETipos_id','=','pCFETipos.id')
                    ->select('pCFECategorias.id as pCFECategorias_id','pCFETipos.id as pCFETipos_id','pCFECategorias.titulo as categoria','pCFETipos.tipo',
                     'pCFEConceptos.id','pCFEConceptos.num','pCFEConceptos.descripcion','pCFEConceptos.p_refaccion','pCFEConceptos.tiempo','pCFEConceptos.p_mo','pCFEConceptos.pnuevo','pCFEConceptos.p_total','pCFEConceptos.codigo_sat','pCFEConceptos.codigo_unidad','pCFEConceptos.unidad_text')
                     ->where('pCFEConceptos.pCFECategorias_id', '=', $request->categoria_id)
                     ->where('pCFEConceptos.pCFETipos_id', '=', $request->tipo_id)
                     ->orderBy('pCFECategorias.id', 'asc')->paginate(20);
                    
                } else {
                    $categorias = pCFEConceptos::join('pCFECategorias','pCFEConceptos.pCFECategorias_id','=','pCFECategorias.id')
                    ->join('pCFETipos','pCFEConceptos.pCFETipos_id','=','pCFETipos.id')
                    ->select('pCFECategorias.id as pCFECategorias_id','pCFETipos.id as pCFETipos_id','pCFECategorias.titulo as categoria','pCFETipos.tipo',
                     'pCFEConceptos.id','pCFEConceptos.num','pCFEConceptos.descripcion','pCFEConceptos.p_refaccion','pCFEConceptos.tiempo','pCFEConceptos.p_mo','pCFEConceptos.pnuevo','pCFEConceptos.p_total','pCFEConceptos.codigo_sat','pCFEConceptos.codigo_unidad','pCFEConceptos.unidad_text')
                     ->where('pCFEConceptos.pCFECategorias_id', '=', $request->categoria_id)
                     ->where('pCFEConceptos.pCFETipos_id', '=', $request->tipo_id)
                     ->where('pCFEConceptos.descripcion', 'like', '%'. $buscar . '%')
                     ->orderBy('pCFECategorias.id', 'asc')->paginate(20);

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
            $vehiculo->CFE_id = '1';
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
            $vehiculo = pCFEConceptos::findOrFail($request->id);
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
            $vehiculo->save();    
            
    }

    public function selectConceptos(Request $request){
        $idc = $request->idc;
        $idt = $request->idt;

       

        if (!$request->ajax()) return redirect('/');
        $categorias = pCFEConceptos::select('id','num','descripcion','pnuevo','p_total')
        ->where('pCFECategorias_id','=',$idc)
        ->where('pCFETipos_id','=',$idt)
        ->where('CFE_id','=','1')
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

    public function obtenerDetallesmulti(Request $request){

            
      

        if (!$request->ajax()) return redirect('/');
 

        $id = $request->ides;//Array de detalles
        //Recorro todos los elementos
      
        $pila = [];

    
        foreach($id as $ep=>$det)
        {
          
            $detalles = pCFEConceptos::select('id','num','descripcion','p_total')
            ->where('id','=',$det['id'])->get();

            $preciov = $detalles[0]['p_total'];

            $vehiculo = new pCFECarrito();
            $vehiculo->presupuestoCFE_id = $request->id;
            $vehiculo->pCFEConcepto_id = $detalles[0]['id'];
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
        
    
 
        $sucursal = pCFEConceptos::findOrFail($request->id);
        $sucursal->delete();

        $estado = true;
        return collect(['estado' => $estado]);
    
}

   

}
