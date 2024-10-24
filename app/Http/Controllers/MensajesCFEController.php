<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MensajesCFE;
use DB;

class MensajesCFEController extends Controller
{
    public function index(Request $request)
    {
       
        $id = $request->id;
        $mensajes = MensajesCFE::join('users','mensajes_cfe.user_id','=','users.id')->select('mensajes_cfe.mensaje','mensajes_cfe.created_at as fecha','users.name as nombre')
        ->where('presupuestoCFE_id','=',$id)->orderBy('presupuestoCFE_id', 'desc')->get();
        return ['mensajes'=> $mensajes];
    }

    public function store(Request $request)
    {
        
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();

            $mensaje = new MensajesCFE();
            $mensaje->user_id = \Auth::user()->id;
            $mensaje->presupuestoCFE_id = $request->id;
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
