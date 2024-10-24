<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Tecnicos;
use App\TecnicosArchivos;
use App\ReparacionesTecnicos;
use App\ReparacionesTrasladistas;
use App\OrdenTecnicos;
use Illuminate\Support\Carbon;

class TecnicosController extends Controller
{
    public function index(Request $request)
    {
       
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        
        if ($buscar==''){
            $personas = Tecnicos::select('id','nombre')
            ->orderBy('id', 'desc')->paginate(20);
        }
        else{
            $personas = Tecnicos::select('nombre')
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

            $personas = ReparacionesTecnicos::where('id_tecnico','=',$id)
            ->orderBy('id', 'desc')->paginate(20);
            }
            else {
                $personas = ReparacionesTecnicos::where('id_tecnico','=',$id)
                ->where($criterio, 'like', '%'. $buscar . '%')
                ->orderBy('id', 'desc')->paginate(20);

            }   

            $terminadas = ReparacionesTecnicos::where('id_tecnico','=',$id)
            ->where('status','=','2')
            ->orderBy('id', 'desc')->count();
            $proceso = ReparacionesTecnicos::where('id_tecnico','=',$id)
            ->where('status','=','1')
            ->orderBy('id', 'desc')->count();
            $asignadas = ReparacionesTecnicos::where('id_tecnico','=',$id)
            ->where('status','=','0')
            ->orderBy('id', 'desc')->count();
        } else {

            if ($buscar==''){
                
                $personas = ReparacionesTecnicos::where('id_tecnico','=',$id)
                ->whereBetween('fecha', [$request->from, $request->to])
                ->orderBy('id', 'desc')->paginate(20);
            }
            else {
                $personas = ReparacionesTecnicos::where('id_tecnico','=',$id)
                ->whereBetween('fecha', [$request->from, $request->to])
                ->where($criterio, 'like', '%'. $buscar . '%')
                ->orderBy('id', 'desc')->paginate(20);

            }   

          

            $terminadas = ReparacionesTecnicos::where('id_tecnico','=',$id)
            ->whereBetween('fecha', [$request->from, $request->to])
            ->where('status','=','2')->count();
            $proceso = ReparacionesTecnicos::where('id_tecnico','=',$id)
            ->whereBetween('fecha', [$request->from, $request->to])
            ->where('status','=','1')->count();
            $asignadas = ReparacionesTecnicos::where('id_tecnico','=',$id)
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

        
         
            $user = new ReparacionesTecnicos();
            $user->marca_modelo = $request->marca;
            $user->economico_placas = $request->economico;
            $user->r_r = $request->rr;
            $user->descripcion = $request->descripcion;
            $user->id_tecnico = $request->user_id;
            $user->fecha =  Carbon::parse($request->fecha_inicio)->format('Y-m-d H:m');    
            $user->trasladista_id = $request->trasladista_id; 
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

        
         
            $user = new Tecnicos();  
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

            $user = ReparacionesTecnicos::findOrFail($request->id);
            $user->marca_modelo = $request->marca;
            $user->id_tecnico = $request->tecnico_id;
            $user->economico_placas = $request->economico;
            $user->r_r = $request->rr;
            $user->descripcion = $request->descripcion;
            $user->fecha =  Carbon::parse($request->fecha_inicio)->format('Y-m-d H:m');    
            $user->fecha_entrega =  Carbon::parse($request->fecha_termino)->format('Y-m-d H:m');    
            $user->recibio = $request->recibio; 
            $user->entrego = $request->entrego; 
            $user->trasladista_id = $request->trasladista_id; 
            $user->odometro_entrada = $request->odometro_entrada; 
            $user->odometro_salida = $request->odometro_salida; 
            $user->status = $request->status;    
            $user->save();

            if($request->trasladista_id == 0){

            } else {

                $userw = new ReparacionesTrasladistas();
                $userw->vehiculo_id = 0;
                $userw->economico_placas = $request->economico;
                $userw->empresa = $request->rr;
                $userw->id_trasladista = $request->trasladista_id;
                $userw->fecha =  Carbon::parse($request->fecha_inicio)->format('Y-m-d H:m');    
                $userw->fecha_entrega =  Carbon::parse($request->fecha_termino)->format('Y-m-d H:m');    
                $userw->de ='de'; 
                $userw->a = 'a';
                $userw->recibio = 'nada'; 
                $userw->odometro_entrada = $request->odometro_entrada; 
                $userw->odometro_salida = $request->odometro_salida; 
                $userw->status = '2';    
                $userw->save();
            }
           
            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }
    public function delete(Request $request){

 
        $sucursal = Tecnicos::findOrFail($request->id);
        $sucursal->delete();

        $estado = true;
        return collect(['estado' => $estado]);
    
    }
    public function delete2(Request $request){

 
        $sucursal = ReparacionesTecnicos::findOrFail($request->id);
        $sucursal->delete();

        $estado = true;
        return collect(['estado' => $estado]);
    
    }
    public function updatearchivos(Request $request)
    {

        if($request->doc == null){
            $fileName = 'nada.doc';
           } else {
            $file = public_path().'/documentos/ordenes/'.$request->doc;
            $exists = is_file( $file );

            if ($exists == true){
                $fileName = $request->doc;
            }

            if ($exists == false){
            $exploded = explode(',', $request->doc);
    
            $decoded = base64_decode($exploded[1]);
    
            if(str_contains($exploded[0], 'pdf'))
                $extension = 'pdf';
            else 
                $extension = 'doc';
    
            $fileName = str_random().'.'.$extension;
    
            $path = public_path().'/documentos/ordenes/'.$fileName;
    
            file_put_contents($path, $decoded);
           }
           
           }


        return collect(['nombre' => $fileName]);
        
    }

    public function guardarOrden(Request $request)
    {
        
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $cotizacion = new OrdenTecnicos();
            $cotizacion->reparaciones_id = $request->id;
            $cotizacion->archivo = $request->archivo;
            $cotizacion->save();               
           
            DB::commit();
            return [
                'id'=> $cotizacion->id
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }
    public function verOrden(Request $request){

        $fotos = OrdenTecnicos::select('archivo')
            ->where('reparaciones_id','=',$request->id)
            ->orderBy('id', 'desc')->get();
      
        
        return $fotos[0]['archivo'];
    }
    public function eliminar(Request $request){

 
        $sucursal = TecnicosArchivos::findOrFail($request->id);
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
                $user = new TecnicosArchivos();
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
        
        
            $tareas = TecnicosArchivos::select('id','tareas_id','nombre','tipo')
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
