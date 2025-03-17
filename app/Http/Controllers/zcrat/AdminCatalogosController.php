<?php

namespace App\Http\Controllers\zcrat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ConceptosPresupuestos;
use App\Models\CategoriasPresupuesto;
use App\Models\TiposVehiculo;
use App\Models\UnidadSatModel;
use App\Models\AnioCorrespondiente;
use App\pCFEConceptos;

use Illuminate\Support\Facades\DB;

use App\CodigoSat;
class AdminCatalogosController extends Controller
{
    public function VistaConceptosPresupuestos(Request $request){
        $elementostotales = ConceptosPresupuestos::where("id_anio_correspondiente",'=',3)->count();
        $unidades=UnidadSatModel::get();
        $anios=AnioCorrespondiente::get();
        return view('administracion.catalogos.conceptos',compact('elementostotales','unidades','anios'));
    }
    public function ObteneConceptosPresupuestos(Request $request){
        $Conceptos = ConceptosPresupuestos::where("id_anio_correspondiente",'=',3)->with('categoria','tipoVehiculo','contrato','modulo','anio')->get();
        return response()->json([
            'Conceptos' => $Conceptos
        ]);
    }
    public function ObteneConceptoPresupuestos(Request $request){
        $request->validate([
            'id' => 'required|exists:pcfeconceptos,id',
        ], [
            'id.required' => 'El Concepto es obligatorio.',
            'id.exists' => 'El Concepto seleccionado no es válido.',
        ]);
        try {
            // Crear un nuevo registro en el modelo Vehiculo
            $concepto = ConceptosPresupuestos::findorfail($request->id);
            $id_unidad = UnidadSatModel::where("clave",'LIKE',"%".$concepto->codigo_unidad."%")->first();
            $categoria = CategoriasPresupuesto::where("id",$concepto->pCFECategorias_id)->first();
            $vehiculo = TiposVehiculo::where("id",$concepto->pCFETipos_id)->first();
            $tipoconcepto = CodigoSat::where("code",'LIKE',"%".$concepto->codigo_sat."%")->first();
            $concepto->id_unidad = $id_unidad->id;
            $concepto->categoria = $categoria->titulo;
            $concepto->vehiculo = $vehiculo->tipo;
            $concepto->tipoconcepto = $tipoconcepto->id;
            $concepto->tipoconceptodescripcion = $tipoconcepto->descripcion;

            return response()->json(['success' => $concepto,]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener el conceptos'.$e], 500);
        }
    }
       
    public function deleteConceptosPresupuestos(Request $request){
        $request->validate([
            'id' => 'required|exists:tipo_auto,id',
        ], [
            'id.required' => 'El Concepto es obligatorio.',
            'id.exists' => 'El Concepto seleccionado no es válido.',
        ]);
        $existe= pCFEConceptos::find($request->id);
        $carrito = pCFECarrito::where("pCFEConcepto_id",$request->id)->get();
        
        if($carrito->isNotEmpty()){
            return response()->json(['error' => 'El Concepto Esta Agregado A un Presupuesto'], 499);
        }
        $existe->delete();
        return response()->json(['success' => 'Eliminado Correctamente'], 200);  
    
    }
    public function createconcepto(Request $request){
        $validatedData = $request->validate([ 
            'Conceptos_Select2' => 'required|exists:codigo_sat,id', 
            'Categoriaconceptos_Select2' => 'required|exists:pcfecategorias,id', 
            'Tiposconceptos_Select2' => 'required|exists:pcfetipos,id', 
            'descripcionconcepto' => 'required|string|max:255', 
            'cod' => 'required|string|max:15', 
            'tiempo' => 'required|string|max:15', 
            'prefaccion' => 'required|numeric|min:0', 
            'pmo' => 'required|numeric|min:0', 
            'modulo' => 'required|exists:modulos,id',
            'contrato' => 'required|exists:sucursales,id',
            'unidadconcepto' => 'required|exists:unidades,id', 
            'anioconcepto' => 'required|exists:anio_correspondiente,id',
        ], 
        [ 
            'Conceptos_Select2.required' => 'El concepto es obligatorio.', 
            'Conceptos_Select2.exists' => 'El concepto seleccionado no es válido.', 
            'Categoriaconceptos_Select2.required' => 'La categoría es obligatoria.', 
            'Categoriaconceptos_Select2.exists' => 'La categoría seleccionada no es válida.', 
            'Tiposconceptos_Select2.required' => 'El tipo de concepto es obligatorio.', 
            'Tiposconceptos_Select2.exists' => 'El tipo de concepto seleccionado no es válido.', 
            'descripcionconcepto.required' => 'La descripción es obligatoria.', 
            'descripcionconcepto.string' => 'La descripción debe ser una cadena de texto.', 
            'descripcionconcepto.max' => 'La descripción no debe superar los 255 caracteres.', 
            'cod.required' => 'El código es obligatorio.',
            'cod.string' => 'El código debe ser una cadena de texto.',
            'cod.max' => 'El código no debe superar los 15 caracteres.',
            'tiempo.required' => 'El tiempo es obligatorio.',
            'tiempo.string' => 'El tiempo debe ser una cadena de texto.',
            'tiempo.max' => 'El tiempo no debe superar los 15 caracteres.',
            'prefaccion.required' => 'El precio de refacción es obligatorio.', 
            'prefaccion.numeric' => 'El precio de refacción debe ser un número.', 
            'prefaccion.min' => 'El precio de refacción no puede ser negativo.', 
            'pmo.required' => 'El precio de mano de obra es obligatorio.', 
            'pmo.numeric' => 'El precio de mano de obra debe ser un número.', 
            'pmo.min' => 'El precio de mano de obra no puede ser negativo.', 
            'modulo.required' => 'El módulo es obligatorio.', 
            'modulo.exists' => 'El módulo seleccionado no es válido.',
            'contrato.required' => 'El contrato es obligatorio.',
            'contrato.exists' => 'El contrato seleccionado no es válido.',
            'unidadconcepto.required' => 'La unidad del concepto es obligatoria.',
            'unidadconcepto.exists' => 'La unidad del concepto seleccionada no es válida.',
            'anioconcepto.required' => 'El año del concepto es obligatorio.',
            'anioconcepto.exists' => 'El año del concepto seleccionado no es válido.',
        ]);

        try{
            DB::beginTransaction();
            $data = CodigoSat::findorfail($request->input("Conceptos_Select2"));
            $unidad = UnidadSatModel::find($request->input('unidadconcepto'));
            $concepto = new pCFEConceptos();
            $concepto->pCFECategorias_id = $request->input('Categoriaconceptos_Select2');
            $concepto->pCFETipos_id = $request->Tiposconceptos_Select2;
            $concepto->num =$request->input('cod');
            $concepto->descripcion = $request->input('descripcionconcepto');
            $concepto->p_refaccion = $request->input('prefaccion');
            $concepto->tiempo = $request->input('tiempo');
            $concepto->p_mo = $request->input('pmo');
            $concepto->p_total = $request->input('prefaccion') + $request->input('pmo');
            $concepto->codigo_sat = $data->code;
            $concepto->codigo_unidad = $unidad->clave;
            $concepto->unidad_text = $unidad->nombre;
            $concepto->id_anio_correspondiente =  $request->input('anioconcepto');
            $concepto->contrato_id = $request->input('contrato');
            $concepto->CFE_id = $request->input('modulo');
            $concepto->save();             
          
           
            DB::commit();
            return response()->json(['success' => "Se Guardo Correctamente"], 200);
        
        } catch (Exception $e){
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
        
    }
    public function updateconcepto(Request $request){
        $validatedData = $request->validate([ 
            'id' => 'required|exists:pcfeconceptos,id', 
            'Conceptos_Select2' => 'required|exists:codigo_sat,id', 
            'Categoriaconceptos_Select2' => 'required|exists:pcfecategorias,id', 
            'Tiposconceptos_Select2' => 'required|exists:pcfetipos,id', 
            'descripcionconcepto' => 'required|string|max:255', 
            'cod' => 'required|string|max:15', 
            'tiempo' => 'required|string|max:15', 
            'prefaccion' => 'required|numeric|min:0', 
            'pmo' => 'required|numeric|min:0', 
            'modulo' => 'required|exists:modulos,id',
            'contrato' => 'required|exists:sucursales,id',
            'unidadconcepto' => 'required|exists:unidades,id',
            'anioconcepto' => 'required|exists:anio_correspondiente,id',
        ], 
        [ 
            'id.required' => 'El ID es obligatorio.',
            'id.exists' => 'El ID seleccionado no es válido.',
            'Conceptos_Select2.required' => 'El concepto es obligatorio.', 
            'Conceptos_Select2.exists' => 'El concepto seleccionado no es válido.', 
            'Categoriaconceptos_Select2.required' => 'La categoría es obligatoria.', 
            'Categoriaconceptos_Select2.exists' => 'La categoría seleccionada no es válida.', 
            'Tiposconceptos_Select2.required' => 'El tipo de concepto es obligatorio.', 
            'Tiposconceptos_Select2.exists' => 'El tipo de concepto seleccionado no es válido.', 
            'descripcionconcepto.required' => 'La descripción es obligatoria.', 
            'descripcionconcepto.string' => 'La descripción debe ser una cadena de texto.', 
            'descripcionconcepto.max' => 'La descripción no debe superar los 255 caracteres.', 
            'cod.required' => 'El código es obligatorio.',
            'cod.string' => 'El código debe ser una cadena de texto.',
            'cod.max' => 'El código no debe superar los 15 caracteres.',
            'tiempo.required' => 'El tiempo es obligatorio.',
            'tiempo.string' => 'El tiempo debe ser una cadena de texto.',
            'tiempo.max' => 'El tiempo no debe superar los 15 caracteres.',
            'prefaccion.required' => 'El precio de refacción es obligatorio.', 
            'prefaccion.numeric' => 'El precio de refacción debe ser un número.', 
            'prefaccion.min' => 'El precio de refacción no puede ser negativo.', 
            'pmo.required' => 'El precio de mano de obra es obligatorio.', 
            'pmo.numeric' => 'El precio de mano de obra debe ser un número.', 
            'pmo.min' => 'El precio de mano de obra no puede ser negativo.', 
            'modulo.required' => 'El módulo es obligatorio.', 
            'modulo.exists' => 'El módulo seleccionado no es válido.',
            'contrato.required' => 'El contrato es obligatorio.',
            'contrato.exists' => 'El contrato seleccionado no es válido.',
            'unidadconcepto.required' => 'La unidad del concepto es obligatoria.',
            'unidadconcepto.exists' => 'La unidad del concepto seleccionada no es válida.',
            'anioconcepto.required' => 'El año del concepto es obligatorio.',
            'anioconcepto.exists' => 'El año del concepto seleccionado no es válido.',
        ]);
        
        try{
            DB::beginTransaction();
            $data = CodigoSat::findorfail($request->input("Conceptos_Select2"));
            $unidad = UnidadSatModel::find($request->input('unidadconcepto'));
            $concepto =pCFEConceptos::find($request->input('id'));
            $concepto->pCFECategorias_id = $request->input('Categoriaconceptos_Select2');
            $concepto->pCFETipos_id = $request->Tiposconceptos_Select2;
            $concepto->num =$request->input('cod');
            $concepto->descripcion = $request->input('descripcionconcepto');
            $concepto->p_refaccion = $request->input('prefaccion');
            $concepto->tiempo = $request->input('tiempo');
            $concepto->p_mo = $request->input('pmo');
            $concepto->p_total = $request->input('prefaccion') + $request->input('pmo');
            $concepto->codigo_sat = $data->code;
            $concepto->codigo_unidad = $unidad->clave;
            $concepto->unidad_text = $unidad->nombre;
            $concepto->id_anio_correspondiente =  $request->input('anioconcepto');
            $concepto->contrato_id = $request->input('contrato');
            $concepto->CFE_id = $request->input('modulo');
            $concepto->save();             
          
           
            DB::commit();
            return response()->json(['success' => 'Se Actualizo Correctamente'], 200);
        
        } catch (Exception $e){
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    
}
 }