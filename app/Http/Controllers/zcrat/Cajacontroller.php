<?php

namespace App\Http\Controllers\zcrat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CajaModel;
use App\Models\usercajaModel;
use App\Models\archivoscaja;
use Illuminate\Support\Facades\DB;

class Cajacontroller extends Controller
{
   public function newmovimientocaja(Request $request){
    $request->validate([ 
        'tipogasto' => 'required|exists:tiposmovimiento,id',  
        'conceptomovimiento' => 'required', 
        'cantidadmovimiento' => 'required|numeric|min:0', 
        'Useridmovimineto' => 'required|exists:usuarioscaja,id', 
        'fechamovimiento' => 'required||date_format:Y-m-d\TH:i',], 
        [ 
        'tipogasto.required' => 'El Tipo de Movimiento es obligatorio.', 
        'tipogasto.exists' => 'El Tipo de Movimiento seleccionado no es válido.', 
        'Useridmovimineto.required' => 'La Usuario es obligatoria.', 
        'Useridmovimineto.exists' => 'La Usuario seleccionado no es válido.', 
        'conceptomovimiento' => 'El tipo de concepto es obligatorio.', 
        'cantidadmovimiento.required' => 'El Monto es obligatorio.', 
        'cantidadmovimiento.numeric' => 'El Monto de refacción debe ser un número.', 
        'cantidadmovimiento.min' => 'El Monto no puede ser negativo.', 
        'fechamovimiento.required' => 'La Fecha es obligatorio.', 
        'fechamovimiento.date_format' => 'La Fecha no es válida.', ]);

        DB::beginTransaction();
        try {
            $movimiento=CajaModel::create([
                'movimiento_id'=>$request->tipogasto,
                'descripcion'=>$request->conceptomovimiento,
                'cantidad'=>$request->cantidadmovimiento,
                'user_id'=>$request->Useridmovimineto,
                'fecha'=>$request->fechamovimiento,
            ]);
            if ($request->hasFile('nuevo_archivo')) {
        
            $archivo = $request->file('nuevo_archivo');
            $nombreArchivo = time() . '_' . $archivo->getClientOriginalName();
            $ruta = '/public/documentos/caja/movimientos/';
            $archivo->storeAs($ruta, $nombreArchivo);
            
            $cotizacion =archivoscaja::create([
                'movimiento_id'=>$movimiento->id,
                'archivo'=>$nombreArchivo,
            ]);        
            }      

            DB::commit();
            return "guardado";
        }catch (\Exception $e) {
            DB::rollBack();
            return abort(500, $e->getMessage());
        }
 }
   public function updatemovimientocaja(Request $request){
    $request->validate([ 
        'idmovimiento' => 'required|exists:cajaadmin,id',  
        'tipogasto' => 'required|exists:tiposmovimiento,id',  
        'conceptomovimiento' => 'required', 
        'cantidadmovimiento' => 'required|numeric|min:0', 
        'Useridmovimineto' => 'required|exists:usuarioscaja,id', 
        'fechamovimiento' => 'required||date_format:Y-m-d\TH:i',], 
        [ 
        'idmovimiento.required' => 'El Movimiento es obligatorio.', 
        'idmovimiento.exists' => 'El Movimiento seleccionado no es válido.', 
        'tipogasto.required' => 'El Tipo de Movimiento es obligatorio.', 
        'tipogasto.exists' => 'El Tipo de Movimiento seleccionado no es válido.', 
        'Useridmovimineto.required' => 'La Usuario es obligatoria.', 
        'Useridmovimineto.exists' => 'La Usuario seleccionado no es válido.', 
        'conceptomovimiento' => 'El tipo de concepto es obligatorio.', 
        'cantidadmovimiento.required' => 'El Monto es obligatorio.', 
        'cantidadmovimiento.numeric' => 'El Monto de refacción debe ser un número.', 
        'cantidadmovimiento.min' => 'El Monto no puede ser negativo.', 
        'fechamovimiento.required' => 'La Fecha es obligatorio.', 
        'fechamovimiento.date_format' => 'La Fecha no es válida.', ]);

        DB::beginTransaction();
        try {

            $cajamov=CajaModel::findorfail($request->idmovimiento);
            $cajamov->movimiento_id=$request->tipogasto;
            $cajamov->descripcion=$request->conceptomovimiento;
            $cajamov->cantidad=$request->cantidadmovimiento;
            $cajamov->user_id=$request->Useridmovimineto;
            $cajamov->fecha=$request->fechamovimiento;
            $cajamov->save();
            if ($request->hasFile('nuevo_archivo')) {
        
                $archivo = $request->file('nuevo_archivo');
                $nombreArchivo = time() . '_' . $archivo->getClientOriginalName();
                $ruta = '/public/documentos/caja/movimientos/';
                $archivo->storeAs($ruta, $nombreArchivo);
                
                $cotizacion =archivoscaja::create([
                    'movimiento_id'=>$cajamov->id,
                    'archivo'=>$nombreArchivo,
                ]) ;       
                }      
            DB::commit();
            return "actualizado";
        }catch (\Exception $e) {
            DB::rollBack();
            return abort(500, $e->getMessage());
        }
   }
   public function deletemovimientocaja(Request $request){
    $request->validate([ 
        'id' => 'required|exists:cajaadmin,id',], 
        [ 
            'id.required' => 'El Movimiento es obligatorio.', 
            'id.exists' => 'El Movimiento seleccionado no es esta disponible.', ]);
            $cajamov = CajaModel::find($request->id);
            $cajamov->delete();
            return "eliminado";
   }
   public function deletearchivomovimientocaja(Request $request){
    $request->validate([ 
        'id' => 'required|exists:archivoscaja,id',], 
        [ 
            'id.required' => 'El Movimiento es obligatorio.', 
            'id.exists' => 'El Movimiento seleccionado no es esta disponible.', ]);
            $cajamov = archivoscaja::find($request->id);
            $idmovimiento=$cajamov->movimiento_id;
            $cajamov->delete();
            return response()->json(['idmovimiento' => $idmovimiento]);
   }
   public function movimientocaja(Request $request){
    $elementostotales=CajaModel::count();
    return view('administracion.caja.movimientos',compact('elementostotales'));
   }
   public function obtenermovimientocaja(Request $request){
    if($request->has('id')){
        $data=CajaModel::find($request->id);
        if(!$data){return response()->json(['error' => 'El Movimiento No existe'], 422);}
        $usercaja=usercajaModel::select('id','name')->find($data->user_id);
        if(!$usercaja){return response()->json(['error' => 'El Usuario Del Movimiento No existe'], 422);}
        $archivos=archivoscaja::select('id','archivo')->where('movimiento_id',$request->id)->get();
        return response()->json(['data' => $data,'user'=>$usercaja,'archivos'=>$archivos]);
    }
    $movimientos=CajaModel::with('tipomovimiento','usuarios')->orderBy('id', 'desc')->get();
    return response()->json(['movimientos' => $movimientos]);
   }

   public function createusercaja(Request $request){
    DB::beginTransaction();

    try {
        $request->validate([
            'newusercaja' => 'required|unique:usuarioscaja,name',
        ], [
            'newusercaja.required' => 'El Nombre del Nuevo Usuario es obligatorio.',
            'newusercaja.exists' => 'Ya existe un usuario con ese nombre',
        ]);

        usercajaModel::create([
            'name' => $request->newusercaja
        ]);

        DB::commit();
        return "guardado";
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['error' => $e->getMessage()], 500);
    }
    }
    
}
