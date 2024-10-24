<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Carbon;
use App\Tareas;
use App\User;
use App\TareasArchivos;

class TareasController extends Controller
{
    public function index(Request $request)
    {

        $timestamp = Carbon::now()->toDateTimeString();

        //Tareas::where('fecha_termino','<',$timestamp)
        //->where('status','!=','2')
        //->update(['status'=>'3']);
       
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $tareas = Tareas::select('id','descripcion','fecha_inicio','fecha_termino','status','created_at')
            ->where('id_user','=',\Auth::user()->id)
            ->orderBy('id', 'desc')->paginate(20);
        }
        else{
            $tareas = Tareas::select('id','descripcion','fecha_inicio','fecha_termino','status','created_at')
            ->where('id_user','=',\Auth::user()->id)
            ->where('tareas.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('id', 'desc')
            ->paginate(20);
        }
        
        return [
            'pagination' => [
                'total'        => $tareas->total(),
                'current_page' => $tareas->currentPage(),
                'per_page'     => $tareas->perPage(),
                'last_page'    => $tareas->lastPage(),
                'from'         => $tareas->firstItem(),
                'to'           => $tareas->lastItem(),
            ],
            'tareas' => $tareas
        ];
    }

    public function indexadmin(Request $request)
    {
        $timestamp = Carbon::now()->toDateTimeString();
        $id = \Auth::user()->id;

        //Tareas::where('fecha_termino','<',$timestamp)
        //->where('status','!=','2')
        //->update(['status'=>'3']);

       
       
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $iduser = $request->nombretarea;



        
        if($id == 1){
            if ($buscar==''){
                $tareas = Tareas::join('users','tareas.id_user','=','users.id')
                ->select('tareas.id','tareas.descripcion','tareas.fecha_inicio','tareas.fecha_termino','tareas.status','tareas.created_at','users.name as nombre')
                ->orderBy('tareas.id', 'desc')->paginate(20);
            }
            else{
    
                if($criterio == 'id_user'){
                    $tareas = Tareas::join('users','tareas.id_user','=','users.id')
                    ->select('tareas.id','tareas.descripcion','tareas.fecha_inicio','tareas.fecha_termino','tareas.status','tareas.created_at','users.name as nombre')
                    ->where('tareas.'.$criterio,'=',$buscar)
                    ->orderBy('tareas.id', 'desc')
                    ->paginate(20);
                } else {
                    $tareas = Tareas::join('users','tareas.id_user','=','users.id')
                    ->select('tareas.id','tareas.descripcion','tareas.fecha_inicio','tareas.fecha_termino','tareas.status','tareas.created_at','users.name as nombre')
                    ->where('tareas.'.$criterio, 'like', '%'. $buscar . '%')
                    ->orderBy('tareas.id', 'desc')
                    ->paginate(20);
        
                }
    
               
            }
            
        } else {
            if ($buscar==''){
                $tareas = Tareas::join('users','tareas.id_user','=','users.id')
                ->select('tareas.id','tareas.descripcion','tareas.fecha_inicio','tareas.fecha_termino','tareas.status','tareas.created_at','users.name as nombre')
                ->where('tareas.levanta_id','=',$id)
                ->orderBy('tareas.id', 'desc')->paginate(20);
            }
            else{
    
                if($criterio == 'id_user'){
                    $tareas = Tareas::join('users','tareas.id_user','=','users.id')
                    ->select('tareas.id','tareas.descripcion','tareas.fecha_inicio','tareas.fecha_termino','tareas.status','tareas.created_at','users.name as nombre')
                    ->where('tareas.levanta_id','=',$id)
                    ->where('tareas.'.$criterio,'=',$buscar)
                    ->orderBy('tareas.id', 'desc')
                    ->paginate(20);
                } else {
                    $tareas = Tareas::join('users','tareas.id_user','=','users.id')
                    ->select('tareas.id','tareas.descripcion','tareas.fecha_inicio','tareas.fecha_termino','tareas.status','tareas.created_at','users.name as nombre')
                    ->where('tareas.levanta_id','=',$id)
                    ->where('tareas.'.$criterio, 'like', '%'. $buscar . '%')
                    ->orderBy('tareas.id', 'desc')
                    ->paginate(20);
        
                }
    
               
            }

        }
       
        
        return [
            'pagination' => [
                'total'        => $tareas->total(),
                'current_page' => $tareas->currentPage(),
                'per_page'     => $tareas->perPage(),
                'last_page'    => $tareas->lastPage(),
                'from'         => $tareas->firstItem(),
                'to'           => $tareas->lastItem(),
            ],
            'tareas' => $tareas
        ];
    }
    public function indexarchivos(Request $request)
    {
       
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        
        
            $tareas = TareasArchivos::select('id','tareas_id','nombre','tipo')
            ->where('tareas_id','=', $buscar)
            ->orderBy('id', 'desc')->paginate(30);

       
        
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
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        try{
            DB::beginTransaction();

            $user = Tareas::findOrFail($request->id);
            $user->descripcion = $request->descripcion;
            $user->status = $request->status;
            $user->save();
           
            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }
    public function updateadmin(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        try{
            DB::beginTransaction();

            $user = Tareas::findOrFail($request->id);
            $user->fecha_inicio =  Carbon::parse($request->fecha_inicio)->format('Y-m-d H:m');
            $user->fecha_termino = Carbon::parse($request->fecha_termino)->format('Y-m-d H:m');
            $user->descripcion = $request->descripcion;
            $user->status = $request->status;
            $user->save();
           
            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }
    public function store(Request $request)
    {
       
        if (!$request->ajax()) return redirect('/');

        try{
            DB::beginTransaction();

            $id = \Auth::user()->id;
         
            $user = new Tareas();
            $user->id_user = $request->user_id;
            $user->descripcion = $request->descripcion;
            $user->fecha_inicio =  Carbon::parse($request->fecha_inicio)->format('Y-m-d H:m');
            $user->fecha_termino = Carbon::parse($request->fecha_termino)->format('Y-m-d H:m');
            $user->status = '1';          
            $user->levanta_id = $id;
            $user->save();

            $personas = User::select('users.token')
            ->where('users.id','=',$request->user_id)->first();

            $token = $personas->token;
            $mensaje = "Tarea no. ".$user->id." - ".$user->descripcion;
            $curl = curl_init();
    
            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS =>"{\n    \"to\":\"$token\",\n    \"notification\":{\n        \"title\":\"CFB Tareas\",\n        \"body\":\"$mensaje\"\n         \"sound\" : \"default\", \n        \"mutable-content\": \"1\"\n    },\n    \"data\":{\n        \"comida\":\"$mensaje\"\n   \"compra_id\":\"1\"\n   }\n}",
              CURLOPT_HTTPHEADER => array(
                "Authorization: key=AAAAs6VPy6w:APA91bGBcxTd-cnmzDMXbyTO8p9cz6U_i0kFkxldy-4xMnxqL0R2KsVxfN3WDiOYUzegfsSIJWP1W-p9mx6KLSgiAHE95Hm4bnPkObfdOtDoV6z8yt0r6AoPyuzOPEkJR1IhmsHbqtoX",
                "Content-Type: application/json"
              ),
            ));
            
            $response = curl_exec($curl);
            
            curl_close($curl);
         


            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function desactivar(Request $request){

 
        $sucursal = Tareas::findOrFail($request->id);
        $sucursal->delete();

        $estado = true;
        return collect(['estado' => $estado]);
    
    }
    public function eliminar(Request $request){

 
        $sucursal = TareasArchivos::findOrFail($request->id);
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
                $user = new TareasArchivos();
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
}
