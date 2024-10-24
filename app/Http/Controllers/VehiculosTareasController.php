<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\VehiculosTareas;
use Illuminate\Support\Carbon;

class VehiculosTareasController extends Controller
{
    public function index(Request $request)
    {
       
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        
        if ($buscar==''){
            $personas = VehiculosTareas::orderBy('id', 'desc')->paginate(20);
        }
        else{
            $personas = VehiculosTareas::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(20);
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

    public function store(Request $request)
    {
       
        if (!$request->ajax()) return redirect('/');

        try{
            DB::beginTransaction();

        
         
            $user = new VehiculosTareas();
            $user->economico = $request->economico;
            $user->odometro_entrada = $request->odometro_entrada; 
            $user->odometro_salida = $request->odometro_salida; 
            $user->placas = $request->placas;
            $user->serie = $request->serie;
            $user->cliente = $request->cliente;
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

            $user = VehiculosTareas::findOrFail($request->id);
            $user->economico = $request->economico;
            $user->odometro_entrada = $request->odometro_entrada; 
            $user->odometro_salida = $request->odometro_salida; 
            $user->placas = $request->placas;
            $user->serie = $request->serie;
            $user->cliente = $request->cliente;
            $user->save();
           
            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }
    public function delete(Request $request){

 
        $sucursal = VehiculosTareas::findOrFail($request->id);
        $sucursal->delete();

        $estado = true;
        return collect(['estado' => $estado]);
    
    }
}
