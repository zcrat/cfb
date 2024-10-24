<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Trasladistas;
use App\TrasladistasArchivos;
use App\ReparacionesTrasladistas;
use Illuminate\Support\Carbon;

class TrasladistasController extends Controller
{
    public function index(Request $request)
    {
       
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        
        if ($buscar==''){
            $personas = Trasladistas::select('id','nombre')
            ->orderBy('id', 'desc')->paginate(20);
        }
        else{
            $personas = Trasladistas::select('nombre')
            ->where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(20);
        }
        
        return [
            'pagination' => [
                'total'        => $personas->total(),
                'current_page' => $personas->currentPage(),
                'per_page'     => $personas->perPage(),
                'last_page'    => $personas->lastPage(),
                'from'         => $personas->firstItem(),
                'to'           => $personas->lastItem(),
            ],
            'personas' => $personas 
        ];
    }
    public function reparaciones(Request $request)
    {
       
        if (!$request->ajax()) return redirect('/');

        $id = $request->id;
        $from = $request->from;
        $to = $request->to;

        $buscar = $request->buscar;
        $criterio = $request->criterio;

    
        if($from == ''){

            if ($buscar==''){

            $personas = ReparacionesTrasladistas::where('id_trasladista','=',$id)
            ->orderBy('id', 'desc')->paginate(20);
            } else {
            $personas = ReparacionesTrasladistas::where('id_trasladista','=',$id)
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('id', 'desc')->paginate(20);
            }

            $terminadas = ReparacionesTrasladistas::where('id_trasladista','=',$id)
            ->where('status','=','2')
            ->orderBy('id', 'desc')->count();
            $proceso = ReparacionesTrasladistas::where('id_trasladista','=',$id)
            ->where('status','=','1')
            ->orderBy('id', 'desc')->count();
            $asignadas = ReparacionesTrasladistas::where('id_trasladista','=',$id)
            ->where('status','=','0')
            ->orderBy('id', 'desc')->count();
        } else {

            if ($buscar==''){

            $personas = ReparacionesTrasladistas::where('id_trasladista','=',$id)
            ->whereBetween('fecha', [$request->from, $request->to])
            ->orderBy('id', 'desc')->paginate(20);
        }
        else {
            $personas = ReparacionesTrasladistas::where('id_trasladista','=',$id)
            ->whereBetween('fecha', [$request->from, $request->to])
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('id', 'desc')->paginate(20);

        }

            $terminadas = ReparacionesTrasladistas::where('id_trasladista','=',$id)
            ->whereBetween('fecha', [$request->from, $request->to])
            ->where('status','=','2')->count();
            $proceso = ReparacionesTrasladistas::where('id_trasladista','=',$id)
            ->whereBetween('fecha', [$request->from, $request->to])
            ->where('status','=','1')->count();
            $asignadas = ReparacionesTrasladistas::where('id_trasladista','=',$id)
            ->whereBetween('fecha', [$request->from, $request->to])
            ->where('status','=','0')->count();
        }
        

       
       
        
        return [
            'pagination' => [
                'total'        => $personas->total(),
                'current_page' => $personas->currentPage(),
                'per_page'     => $personas->perPage(),
                'last_page'    => $personas->lastPage(),
                'from'         => $personas->firstItem(),
                'to'           => $personas->lastItem(),
            ],
            'personas' => $personas ,
            'terminadas' => $terminadas,
            'proceso' => $proceso,
            'asignadas' => $asignadas
        ];
    }

    public function store(Request $request)
    {
       
        if (!$request->ajax()) return redirect('/');

        try{
            DB::beginTransaction();

        
         
            $user = new ReparacionesTrasladistas();
            $user->vehiculo_id = $request->vehiculo_id;
            $user->economico_placas = $request->economico;
            $user->empresa = $request->rr;
            $user->id_trasladista = $request->user_id;
            $user->fecha =  Carbon::parse($request->fecha_inicio)->format('Y-m-d H:m');    
            $user->fecha_entrega =  Carbon::parse($request->fecha_termino)->format('Y-m-d H:m');    
            $user->de = $request->de; 
            $user->a = $request->a;
            $user->recibio = $request->recibio; 
            $user->odometro_entrada = $request->odometro_entrada; 
            $user->odometro_salida = $request->odometro_salida; 
            $user->status = $request->status;    
            $user->save();
         


            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function store2(Request $request)
    {
       
        if (!$request->ajax()) return redirect('/');

        try{
            DB::beginTransaction();

        
         
            $user = new Trasladistas();  
            $user->nombre = $request->nombre;    
            $user->save();
         


            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        try{
            DB::beginTransaction();

            $user = ReparacionesTrasladistas::findOrFail($request->id);
            $user->vehiculo_id = $request->vehiculo_id;
            $user->economico_placas = $request->economico;
            $user->empresa = $request->rr;
            $user->fecha =  Carbon::parse($request->fecha_inicio)->format('Y-m-d H:m');    
            $user->fecha_entrega =  Carbon::parse($request->fecha_termino)->format('Y-m-d H:m');   
            $user->de = $request->de; 
            $user->a = $request->a;  
            $user->recibio = $request->recibio; 
            $user->odometro_entrada = $request->odometro_entrada; 
            $user->odometro_salida = $request->odometro_salida; 
            $user->status = $request->status;    
            $user->save();
           
            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }
    public function delete(Request $request){

 
        $sucursal = Trasladistas::findOrFail($request->id);
        $sucursal->delete();

        $estado = true;
        return collect(['estado' => $estado]);
    
    }
    public function delete2(Request $request){

 
        $sucursal = ReparacionesTrasladistas::findOrFail($request->id);
        $sucursal->delete();

        $estado = true;
        return collect(['estado' => $estado]);
    
    }
   

    public function eliminar(Request $request){

 
        $sucursal = TrasladistasArchivos::findOrFail($request->id);
        $sucursal->delete();

        $estado = true;
        return collect(['estado' => $estado]);
    
    }
    public function subir(Request $request)
    {
        

        if($request->hasFile('files')){
            $files = $request->file('files');
            foreach ($files as $file) {
                $filename = $file->getClientOriginalName();
                $extencion = $file->getClientOriginalExtension();
                $path = public_path().'/img/archivos/';
                $file->move($path, $filename);
                $user = new TrasladistasArchivos();
                $user->tareas_id = $request->id;
                $user->nombre = $filename;
                $user->tipo = $extencion;     
                $user->save();
                
            }
        }

        return count($files);
         

    }
    public function downloadFile($file){
        $pathtoFile = public_path().'/img/archivos/'.$file;
        return response()->download($pathtoFile);
      }
      public function indexarchivos(Request $request)
    {
       
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        
        
            $tareas = TrasladistasArchivos::select('id','tareas_id','nombre','tipo')
            ->where('tareas_id','=', $buscar)
            ->orderBy('id', 'desc')->paginate(20);

       
        
        return [
            'pagination' => [
                'total'        => $tareas->total(),
                'current_page' => $tareas->currentPage(),
                'per_page'     => $tareas->perPage(),
                'last_page'    => $tareas->lastPage(),
                'from'         => $tareas->firstItem(),
                'to'           => $tareas->lastItem(),
            ],
            'archivos' => $tareas
        ];
    }
}
