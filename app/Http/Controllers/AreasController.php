<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Areas;
use DB;

class AreasController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        $ubicaciones = Areas::get();
         
        return [
            'ubicaciones' => $ubicaciones
        ];
    }
    
    public function store(Request $request)
    {
            
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $cotizacion = new Areas();
            $cotizacion->nombre = $request->nombre;
            $cotizacion->save();               
           
            DB::commit();
            return [
                'id'=> $cotizacion->id
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $categoria = Areas::findOrFail($request->id);
        $categoria->nombre = $request->nombre;
        $categoria->save();
    }
    public function desactivar(Request $request)
    {

        $cotizacion = Areas::findOrFail($request->id);
        $estado = $cotizacion->delete();
        return collect(['estado' => $estado]);
    }
}
