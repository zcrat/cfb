<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AFConceptos;
use DB;
use App\anexosFCarrito;
use App\anexosFCategorias;
use App\anexosFTipos;
use App\Imports\pConceptosImport;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class AFConceptosController extends Controller
{
        public function index(Request $request){

            $categoria = anexosFCategorias::orderBy('titulo', 'asc')->get();
            $tipos = anexosFTipos::orderBy('tipo', 'asc')->get();
            $buscar = $request->buscar;
            $criterio = $request->criterio;

            if ($request->categoria_id == 0){

                if ($request->tipo_id == 0){
                    
                    if($buscar == null){
                        $categorias = AFConceptos::join('anexosFCategorias','AFConceptos.pCategorias_id','=','anexosFCategorias.id')
                        ->join('anexosFTipos','AFConceptos.pTipos_id','=','anexosFTipos.id')
                        ->select('anexosFCategorias.id as pCategorias_id','anexosFTipos.id as pTipos_id','anexosFCategorias.titulo as categoria','anexosFTipos.tipo',
                        'AFConceptos.id','AFConceptos.num','AFConceptos.descripcion','AFConceptos.p_refaccion','AFConceptos.tiempo','AFConceptos.p_mo','AFConceptos.pnuevo','AFConceptos.p_total','AFConceptos.codigo_sat','AFConceptos.codigo_unidad','AFConceptos.unidad_text')
                        ->orderBy('anexosFCategorias.id', 'asc')->paginate(20);
                    } else {

                        $categorias = AFConceptos::join('anexosFCategorias','AFConceptos.pCategorias_id','=','anexosFCategorias.id')
                        ->join('anexosFTipos','AFConceptos.pTipos_id','=','anexosFTipos.id')
                        ->select('anexosFCategorias.id as pCategorias_id','anexosFTipos.id as pTipos_id','anexosFCategorias.titulo as categoria','anexosFTipos.tipo',
                        'AFConceptos.id','AFConceptos.num','AFConceptos.descripcion','AFConceptos.p_refaccion','AFConceptos.tiempo','AFConceptos.p_mo','AFConceptos.pnuevo','AFConceptos.p_total','AFConceptos.codigo_sat','AFConceptos.codigo_unidad','AFConceptos.unidad_text')
                        ->where('AFConceptos.descripcion', 'like', '%'. $buscar . '%')
                        ->orderBy('anexosFCategorias.id', 'asc')->paginate(20);

                    }



                } else {

                    if($buscar == null){
                        $categorias = AFConceptos::join('anexosFCategorias','AFConceptos.pCategorias_id','=','anexosFCategorias.id')
                        ->join('anexosFTipos','AFConceptos.pTipos_id','=','anexosFTipos.id')
                        ->select('anexosFCategorias.id as pCategorias_id','anexosFTipos.id as pTipos_id','anexosFCategorias.titulo as categoria','anexosFTipos.tipo',
                        'AFConceptos.id','AFConceptos.num','AFConceptos.descripcion','AFConceptos.p_refaccion','AFConceptos.tiempo','AFConceptos.p_mo','AFConceptos.pnuevo','AFConceptos.p_total','AFConceptos.codigo_sat','AFConceptos.codigo_unidad','AFConceptos.unidad_text')
                        ->where('AFConceptos.pTipos_id', '=', $request->tipo_id)
                        ->orderBy('anexosFCategorias.id', 'asc')->paginate(20);
                    } else {

                        $categorias = AFConceptos::join('anexosFCategorias','AFConceptos.pCategorias_id','=','anexosFCategorias.id')
                        ->join('anexosFTipos','AFConceptos.pTipos_id','=','anexosFTipos.id')
                        ->select('anexosFCategorias.id as pCategorias_id','anexosFTipos.id as pTipos_id','anexosFCategorias.titulo as categoria','anexosFTipos.tipo',
                        'AFConceptos.id','AFConceptos.num','AFConceptos.descripcion','AFConceptos.p_refaccion','AFConceptos.tiempo','AFConceptos.p_mo','AFConceptos.pnuevo','AFConceptos.p_total','AFConceptos.codigo_sat','AFConceptos.codigo_unidad','AFConceptos.unidad_text')
                        ->where('AFConceptos.pTipos_id', '=', $request->tipo_id)
                        ->where('AFConceptos.descripcion', 'like', '%'. $buscar . '%')
                        ->orderBy('anexosFCategorias.id', 'asc')->paginate(20);


                    }


                    
                }
            
            } else {


                if ($request->tipo_id == 0){
                    if($buscar == null){
                        $categorias = AFConceptos::join('anexosFCategorias','AFConceptos.pCategorias_id','=','anexosFCategorias.id')
                        ->join('anexosFTipos','AFConceptos.pTipos_id','=','anexosFTipos.id')
                        ->select('anexosFCategorias.id as pCategorias_id','anexosFTipos.id as pTipos_id','anexosFCategorias.titulo as categoria','anexosFTipos.tipo',
                        'AFConceptos.id','AFConceptos.num','AFConceptos.descripcion','AFConceptos.p_refaccion','AFConceptos.tiempo','AFConceptos.p_mo','AFConceptos.pnuevo','AFConceptos.p_total','AFConceptos.codigo_sat','AFConceptos.codigo_unidad','AFConceptos.unidad_text')
                        ->where('AFConceptos.pCategorias_id', '=', $request->categoria_id)
                        ->orderBy('anexosFCategorias.id', 'asc')->paginate(20);
                    } else {

                        $categorias = AFConceptos::join('anexosFCategorias','AFConceptos.pCategorias_id','=','anexosFCategorias.id')
                        ->join('anexosFTipos','AFConceptos.pTipos_id','=','anexosFTipos.id')
                        ->select('anexosFCategorias.id as pCategorias_id','anexosFTipos.id as pTipos_id','anexosFCategorias.titulo as categoria','anexosFTipos.tipo',
                        'AFConceptos.id','AFConceptos.num','AFConceptos.descripcion','AFConceptos.p_refaccion','AFConceptos.tiempo','AFConceptos.p_mo','AFConceptos.pnuevo','AFConceptos.p_total','AFConceptos.codigo_sat','AFConceptos.codigo_unidad','AFConceptos.unidad_text')
                        ->where('AFConceptos.pCategorias_id', '=', $request->categoria_id)
                        ->where('AFConceptos.descripcion', 'like', '%'. $buscar . '%')
                        ->orderBy('anexosFCategorias.id', 'asc')->paginate(20);


                    }
                } else {
                    if($buscar == null){
                        $categorias = AFConceptos::join('anexosFCategorias','AFConceptos.pCategorias_id','=','anexosFCategorias.id')
                        ->join('anexosFTipos','AFConceptos.pTipos_id','=','anexosFTipos.id')
                        ->select('anexosFCategorias.id as pCategorias_id','anexosFTipos.id as pTipos_id','anexosFCategorias.titulo as categoria','anexosFTipos.tipo',
                        'AFConceptos.id','AFConceptos.num','AFConceptos.descripcion','AFConceptos.p_refaccion','AFConceptos.tiempo','AFConceptos.p_mo','AFConceptos.pnuevo','AFConceptos.p_total','AFConceptos.codigo_sat','AFConceptos.codigo_unidad','AFConceptos.unidad_text')
                        ->where('AFConceptos.pCategorias_id', '=', $request->categoria_id)
                        ->where('AFConceptos.pTipos_id', '=', $request->tipo_id)
                        ->orderBy('anexosFCategorias.id', 'asc')->paginate(20);
                    } else {
                        $categorias = AFConceptos::join('anexosFCategorias','AFConceptos.pCategorias_id','=','anexosFCategorias.id')
                        ->join('anexosFTipos','AFConceptos.pTipos_id','=','anexosFTipos.id')
                        ->select('anexosFCategorias.id as pCategorias_id','anexosFTipos.id as pTipos_id','anexosFCategorias.titulo as categoria','anexosFTipos.tipo',
                        'AFConceptos.id','AFConceptos.num','AFConceptos.descripcion','AFConceptos.p_refaccion','AFConceptos.tiempo','AFConceptos.p_mo','AFConceptos.pnuevo','AFConceptos.p_total','AFConceptos.codigo_sat','AFConceptos.codigo_unidad','AFConceptos.unidad_text')
                        ->where('AFConceptos.pCategorias_id', '=', $request->categoria_id)
                        ->where('AFConceptos.pTipos_id', '=', $request->tipo_id)
                        ->where('AFConceptos.descripcion', 'like', '%'. $buscar . '%')
                        ->orderBy('anexosFCategorias.id', 'asc')->paginate(20);


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


                $vehiculo = new AFConceptos();
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
                $vehiculo = AFConceptos::findOrFail($request->id);
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
            $categorias = AFConceptos::select('id','num','descripcion','p_total')
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
            
                $detalles = AFConceptos::select('id','num','descripcion','p_total')
                ->where('id','=',$det['id'])->get();
        

                //$preciov = $det['pnuevo']*1.82;
                $preciov = $detalles[0]['p_total'];

                $vehiculo = new anexosFCarrito();
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
            
        
    
            $sucursal = AFConceptos::findOrFail($request->id);
            $sucursal->delete();

            $estado = true;
            return collect(['estado' => $estado]);
        
    }

    public function exel(Request $request){



        $conceptos = AFConceptos::orderBy('AFConceptos.id', 'desc')->get();


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
