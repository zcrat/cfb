<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\pConceptos2023;
use DB;
use App\pCarrito2023;
use App\pCategorias2023;
use App\pTipos2023;
use App\Imports\pConceptosImport;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class pConceptos2023Controller extends Controller
{
    public function index(Request $request){

        $categoria = pCategorias2023::orderBy('titulo', 'asc')->get();
        $tipos = pTipos2023::orderBy('tipo', 'asc')->get();
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($request->categoria_id == 0){

            if ($request->tipo_id == 0){
                 
                if($buscar == null){
                    $categorias = pConceptos2023::join('pCategorias2023','pConceptos2023.pCategorias_id','=','pCategorias2023.id')
                    ->join('pTipos2023','pConceptos2023.pTipos_id','=','pTipos2023.id')
                    ->select('pCategorias2023.id as pCategorias_id','pTipos2023.id as pTipos_id','pCategorias2023.titulo as categoria','pTipos2023.tipo',
                    'pConceptos2023.id','pConceptos2023.num','pConceptos2023.descripcion','pConceptos2023.p_refaccion','pConceptos2023.tiempo','pConceptos2023.p_mo','pConceptos2023.pnuevo','pConceptos2023.p_total','pConceptos2023.codigo_sat','pConceptos2023.codigo_unidad','pConceptos2023.unidad_text')
                    ->orderBy('pCategorias2023.id', 'asc')->paginate(20);
                } else {

                    $categorias = pConceptos2023::join('pCategorias2023','pConceptos2023.pCategorias_id','=','pCategorias2023.id')
                    ->join('pTipos2023','pConceptos2023.pTipos_id','=','pTipos2023.id')
                    ->select('pCategorias2023.id as pCategorias_id','pTipos2023.id as pTipos_id','pCategorias2023.titulo as categoria','pTipos2023.tipo',
                    'pConceptos2023.id','pConceptos2023.num','pConceptos2023.descripcion','pConceptos2023.p_refaccion','pConceptos2023.tiempo','pConceptos2023.p_mo','pConceptos2023.pnuevo','pConceptos2023.p_total','pConceptos2023.codigo_sat','pConceptos2023.codigo_unidad','pConceptos2023.unidad_text')
                    ->where('pConceptos2023.descripcion', 'like', '%'. $buscar . '%')
                    ->orderBy('pCategorias2023.id', 'asc')->paginate(20);

                }



            } else {

                if($buscar == null){
                    $categorias = pConceptos2023::join('pCategorias2023','pConceptos2023.pCategorias_id','=','pCategorias2023.id')
                    ->join('pTipos2023','pConceptos2023.pTipos_id','=','pTipos2023.id')
                    ->select('pCategorias2023.id as pCategorias_id','pTipos2023.id as pTipos_id','pCategorias2023.titulo as categoria','pTipos2023.tipo',
                    'pConceptos2023.id','pConceptos2023.num','pConceptos2023.descripcion','pConceptos2023.p_refaccion','pConceptos2023.tiempo','pConceptos2023.p_mo','pConceptos2023.pnuevo','pConceptos2023.p_total','pConceptos2023.codigo_sat','pConceptos2023.codigo_unidad','pConceptos2023.unidad_text')
                    ->where('pConceptos2023.pTipos_id', '=', $request->tipo_id)
                     ->orderBy('pCategorias2023.id', 'asc')->paginate(20);
                } else {

                    $categorias = pConceptos2023::join('pCategorias2023','pConceptos2023.pCategorias_id','=','pCategorias2023.id')
                    ->join('pTipos2023','pConceptos2023.pTipos_id','=','pTipos2023.id')
                    ->select('pCategorias2023.id as pCategorias_id','pTipos2023.id as pTipos_id','pCategorias2023.titulo as categoria','pTipos2023.tipo',
                    'pConceptos2023.id','pConceptos2023.num','pConceptos2023.descripcion','pConceptos2023.p_refaccion','pConceptos2023.tiempo','pConceptos2023.p_mo','pConceptos2023.pnuevo','pConceptos2023.p_total','pConceptos2023.codigo_sat','pConceptos2023.codigo_unidad','pConceptos2023.unidad_text')
                    ->where('pConceptos2023.pTipos_id', '=', $request->tipo_id)
                    ->where('pConceptos2023.descripcion', 'like', '%'. $buscar . '%')
                    ->orderBy('pCategorias2023.id', 'asc')->paginate(20);


                }


                
            }
           
        } else {


            if ($request->tipo_id == 0){
                if($buscar == null){
                    $categorias = pConceptos2023::join('pCategorias2023','pConceptos2023.pCategorias_id','=','pCategorias2023.id')
                    ->join('pTipos2023','pConceptos2023.pTipos_id','=','pTipos2023.id')
                    ->select('pCategorias2023.id as pCategorias_id','pTipos2023.id as pTipos_id','pCategorias2023.titulo as categoria','pTipos2023.tipo',
                    'pConceptos2023.id','pConceptos2023.num','pConceptos2023.descripcion','pConceptos2023.p_refaccion','pConceptos2023.tiempo','pConceptos2023.p_mo','pConceptos2023.pnuevo','pConceptos2023.p_total','pConceptos2023.codigo_sat','pConceptos2023.codigo_unidad','pConceptos2023.unidad_text')
                    ->where('pConceptos2023.pCategorias_id', '=', $request->categoria_id)
                     ->orderBy('pCategorias2023.id', 'asc')->paginate(20);
                } else {

                    $categorias = pConceptos2023::join('pCategorias2023','pConceptos2023.pCategorias_id','=','pCategorias2023.id')
                    ->join('pTipos2023','pConceptos2023.pTipos_id','=','pTipos2023.id')
                    ->select('pCategorias2023.id as pCategorias_id','pTipos2023.id as pTipos_id','pCategorias2023.titulo as categoria','pTipos2023.tipo',
                    'pConceptos2023.id','pConceptos2023.num','pConceptos2023.descripcion','pConceptos2023.p_refaccion','pConceptos2023.tiempo','pConceptos2023.p_mo','pConceptos2023.pnuevo','pConceptos2023.p_total','pConceptos2023.codigo_sat','pConceptos2023.codigo_unidad','pConceptos2023.unidad_text')
                    ->where('pConceptos2023.pCategorias_id', '=', $request->categoria_id)
                     ->where('pConceptos2023.descripcion', 'like', '%'. $buscar . '%')
                     ->orderBy('pCategorias2023.id', 'asc')->paginate(20);


                }
            } else {
                if($buscar == null){
                    $categorias = pConceptos2023::join('pCategorias2023','pConceptos2023.pCategorias_id','=','pCategorias2023.id')
                    ->join('pTipos2023','pConceptos2023.pTipos_id','=','pTipos2023.id')
                    ->select('pCategorias2023.id as pCategorias_id','pTipos2023.id as pTipos_id','pCategorias2023.titulo as categoria','pTipos2023.tipo',
                    'pConceptos2023.id','pConceptos2023.num','pConceptos2023.descripcion','pConceptos2023.p_refaccion','pConceptos2023.tiempo','pConceptos2023.p_mo','pConceptos2023.pnuevo','pConceptos2023.p_total','pConceptos2023.codigo_sat','pConceptos2023.codigo_unidad','pConceptos2023.unidad_text')
                    ->where('pConceptos2023.pCategorias_id', '=', $request->categoria_id)
                    ->where('pConceptos2023.pTipos_id', '=', $request->tipo_id)
                     ->orderBy('pCategorias2023.id', 'asc')->paginate(20);
                } else {
                    $categorias = pConceptos2023::join('pCategorias2023','pConceptos2023.pCategorias_id','=','pCategorias2023.id')
                    ->join('pTipos2023','pConceptos2023.pTipos_id','=','pTipos2023.id')
                    ->select('pCategorias2023.id as pCategorias_id','pTipos2023.id as pTipos_id','pCategorias2023.titulo as categoria','pTipos2023.tipo',
                    'pConceptos2023.id','pConceptos2023.num','pConceptos2023.descripcion','pConceptos2023.p_refaccion','pConceptos2023.tiempo','pConceptos2023.p_mo','pConceptos2023.pnuevo','pConceptos2023.p_total','pConceptos2023.codigo_sat','pConceptos2023.codigo_unidad','pConceptos2023.unidad_text')
                    ->where('pConceptos2023.pCategorias_id', '=', $request->categoria_id)
                    ->where('pConceptos2023.pTipos_id', '=', $request->tipo_id)
                    ->where('pConceptos2023.descripcion', 'like', '%'. $buscar . '%')
                    ->orderBy('pCategorias2023.id', 'asc')->paginate(20);


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


            $vehiculo = new pConceptos2023();
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
            $vehiculo = pConceptos2023::findOrFail($request->id);
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
        $categorias = pConceptos2023::select('id','num','descripcion','p_total')
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
          
            $detalles = pConceptos2023::select('id','num','descripcion','p_total')
            ->where('id','=',$det['id'])->get();
    

            //$preciov = $det['pnuevo']*1.82;
            $preciov = $detalles[0]['p_total'];

            $vehiculo = new pCarrito2023();
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
        
    
 
        $sucursal = pConceptos2023::findOrFail($request->id);
        $sucursal->delete();

        $estado = true;
        return collect(['estado' => $estado]);
    
}

public function exel(Request $request){



    $conceptos = pConceptos2023::orderBy('pConceptos2023.id', 'desc')->get();


    return \View::make('pdf.exelExportConceptos')->with('conceptos',$conceptos);

}

public function exelimport(Request $request){


   try{
    if(!$request->hasFile('file')){
        return 'file does not exist';
    }
    $file = $request->file;
    Excel::import(new pConceptosImport, $file);
   } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
        $failures = $e->failures();
        foreach($failures as $failure){
            $failure->row();
            $failure->attribute();
            $failure->errors();
            $failure->values();
        }
   }

}
}
