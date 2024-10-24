<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mensajes;
use DB;

class MensajesController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->id;
        $mensajes = Mensajes::join('users','mensajes.user_id','=','users.id')->select('mensajes.mensaje','mensajes.created_at as fecha','users.name as nombre')
        ->where('presupuesto_id','=',$id)->orderBy('presupuesto_id', 'desc')->get();
        return ['mensajes'=> $mensajes];
    }

    public function store(Request $request)
    {
        
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();

            $mensaje = new Mensajes();
            $mensaje->user_id = \Auth::user()->id;
            $mensaje->presupuesto_id = $request->id;
            $mensaje->mensaje = $request->mensaje;
            $mensaje->save();
          
           
            DB::commit();
            return [
                'id'=> $mensaje->id
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }
    
}
