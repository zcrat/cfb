<?php

namespace App\Http\Controllers\zcrat\anio2025;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RecepcionVehicular;
use App\Models\Modulo;
use App\Models\AnioCorrespondiente;
use App\Models\Empresa;
use App\Models\Color;
use App\Models\Marca;
use App\Models\Modelo;
use App\Models\Vehiculo;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\CondicionesPintura;
use App\EquipoInventario;
use App\ExterioresEquipo;
use App\InterioresEquipo;
use App\EntradasSalidas;
use App\OrdenesPagadas;
use App\pVehiculos2023;
use App\pGenerales2023;
use App\presupuestos2023;
use App\pCFEVehiculos;
use App\pCFEGenerales;
use App\presupuestosCFE;
use App\HojaConcepto;
use App\Sucursales;
use App\TipoServicioOrden2023;
use App\CorrectivosOrden2023;
use App\ServicioOrden2023;
use App\ServicioOrden;
use App\pCFETipos;
use App\pCFECategorias;
use App\pCFEConceptos;
use App\pCFECarrito;
use App\CodigoSat;
use App\contratos;
use App\FotosViejas;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\LOG;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class cfeController extends Controller
{
    public $Regimenes = [
        ['id' => '601', 'nombre' => '601 - General de Ley Personas Morales'],
        ['id' => '603', 'nombre' => '603 - Personas Morales con Fines no Lucrativos'],
        ['id' => '605', 'nombre' => '605 - Sueldos y Salarios e Ingresos Asimilados a Salarios'],
        ['id' => '606', 'nombre' => '606 - Arrendamiento'],
        ['id' => '607', 'nombre' => '607 - Régimen de Enajenación o Adquisición de Bienes'],
        ['id' => '608', 'nombre' => '608 - Demas Ingresos'],
        ['id' => '609', 'nombre' => '609 - Consolidación'],
        ['id' => '610', 'nombre' => '610 - Residentes en el Extranjero sin Establecimiento Permanente en México'],
        ['id' => '611', 'nombre' => '611 - Ingresos por Dividendos (Socios y Accionistas)'],
        ['id' => '612', 'nombre' => '612 - Personas Físicas con Actividades Empresariales y Profesionales'],
        ['id' => '614', 'nombre' => '614 - Ingresos por Intereses'],
        ['id' => '615', 'nombre' => '615 - Régimen de los ingresos por obtención de premios'],
        ['id' => '616', 'nombre' => '616 - Sin Obligaciones Fiscales'],
        ['id' => '620', 'nombre' => '620 - Sociedades Cooperativas de Producción que optan por diferir sus ingresos'],
        ['id' => '621', 'nombre' => '621 - Incorporación Fiscal'],
        ['id' => '622', 'nombre' => '622 - Actividades Agrícolas, Ganaderas, Silvícolas y Pesqueras'],
        ['id' => '623', 'nombre' => '623 - Opcional para Grupos de Sociedades'],
        ['id' => '624', 'nombre' => '624 - Coordinados'],
        ['id' => '625', 'nombre' => '625 - Régimen de las Actividades Empresariales con ingresos a través de Plataformas Tecnológicas'],
        ['id' => '626', 'nombre' => '626 - Régimen Simplificado de Confianza'],
        ['id' => '628', 'nombre' => '628 - Hidrocarburos'],
        ['id' => '629', 'nombre' => '629 - De los Regímenes Fiscales Preferentes y de las Empresas Multinacionales'],
        ['id' => '630', 'nombre' => '630 - Enajenación de acciones en bolsa de valores']
    ];
//VISTAS RECEPCION
    public function vistarecepcioneco(){
        $Regimenes=$this->Regimenes;
        $empresas=Empresa::select('id','nombre')->get();
        $sucu = \Auth::user()->sucursal_id;
        $modulo = Modulo::where('descripcion', 'CFE ECO')->value('id');
        $anio = AnioCorrespondiente::where('descripcion', '2025')->value('id');
        $elementostotales = RecepcionVehicular::where("sucursal_id",'=',$sucu)->where("modulo",$modulo)->where("id_anio_correspondiente",$anio)->count();
        return view('cfe.2025.recepcion',compact('elementostotales','modulo','anio','Regimenes','empresas'));
    }
    public function vistarecepcionbajio(){
        $Regimenes=$this->Regimenes;
        $empresas=Empresa::select('id','nombre')->get();
        $sucu = \Auth::user()->sucursal_id;
        $modulo = Modulo::where('descripcion', 'CFE BAJIO')->value('id');
        $anio = AnioCorrespondiente::where('descripcion', '2025')->value('id');
        $elementostotales = RecepcionVehicular::where("sucursal_id",'=',$sucu)->where("modulo",$modulo)->where("id_anio_correspondiente",$anio)->count();
        return view('cfe.2025.recepcion',compact('elementostotales','modulo','anio','Regimenes','empresas'));
    }
    public function vistarecepcionoccidente(){
        $Regimenes=$this->Regimenes;
        $empresas=Empresa::select('id','nombre')->get();
        $sucu = \Auth::user()->sucursal_id;
        $modulo = Modulo::where('descripcion', 'CFE OCCIDENTE')->value('id');
        $anio = AnioCorrespondiente::where('descripcion', '2025')->value('id');
        $elementostotales = RecepcionVehicular::where("sucursal_id",'=',$sucu)->where("modulo",$modulo)->where("id_anio_correspondiente",$anio)->count();
        return view('cfe.2025.recepcion',compact('elementostotales','modulo','anio','Regimenes','empresas'));
    }
    //VISTAS APROBACIONES
    public function vistaAprobacioneseco(){
        $Regimenes=$this->Regimenes;
        $empresas=Empresa::select('id','nombre')->get();
        $sucu = \Auth::user()->sucursal_id;
        $modulo = Modulo::where('descripcion', 'CFE ECO')->value('id');
        $anio = AnioCorrespondiente::where('descripcion', '2025')->value('id');
        $elementostotales = RecepcionVehicular::where("sucursal_id",'=',$sucu)->where("modulo",$modulo)->where("id_anio_correspondiente",$anio)->count();
        return view('cfe.2025.aprobaciones',compact('elementostotales','modulo','anio','Regimenes','empresas'));
    }
    public function vistaAprobacionesbajio(){
        $Regimenes=$this->Regimenes;
        $empresas=Empresa::select('id','nombre')->get();
        $sucu = \Auth::user()->sucursal_id;
        $modulo = Modulo::where('descripcion', 'CFE BAJIO')->value('id');
        $anio = AnioCorrespondiente::where('descripcion', '2025')->value('id');
        $elementostotales = RecepcionVehicular::where("sucursal_id",'=',$sucu)->where("modulo",$modulo)->where("id_anio_correspondiente",$anio)->count();
        return view('cfe.2025.aprobaciones',compact('elementostotales','modulo','anio','Regimenes','empresas'));
    }
    public function vistaAprobacionesoccidente(){
        $Regimenes=$this->Regimenes;
        $empresas=Empresa::select('id','nombre')->get();
        $sucu = \Auth::user()->sucursal_id;
        $modulo = Modulo::where('descripcion', 'CFE OCCIDENTE')->value('id');
        $anio = AnioCorrespondiente::where('descripcion', '2024')->value('id');
        $elementostotales = RecepcionVehicular::where("sucursal_id",'=',$sucu)->where("modulo",$modulo)->where("id_anio_correspondiente",$anio)->count();
        return view('cfe.2025.aprobaciones',compact('elementostotales','modulo','anio','Regimenes','empresas'));
    }
// VISTAS TALLERES
    public function vistaTallereseco(){
        $Regimenes=$this->Regimenes;
        $empresas=Empresa::select('id','nombre')->get();
        $sucu = \Auth::user()->sucursal_id;
        $modulo = Modulo::where('descripcion', 'CFE ECO')->value('id');
        $anio = AnioCorrespondiente::where('descripcion', '2025')->value('id');
        $elementostotales = presupuestosCFE::where("CFE_id",$modulo)->where('created_at', '>', '2024-12-30')->count();
        return view('cfe.2025.Talleres',compact('elementostotales','modulo','anio','Regimenes','empresas'));
    }
    public function vistaTalleresbajio(){
        $Regimenes=$this->Regimenes;
        $empresas=Empresa::select('id','nombre')->get();
        $sucu = \Auth::user()->sucursal_id;
        $modulo = Modulo::where('descripcion', 'CFE BAJIO')->value('id');
        $anio = AnioCorrespondiente::where('descripcion', '2025')->value('id');
        $elementostotales = presupuestosCFE::where("CFE_id",$modulo)->where('created_at', '>', '2024-12-30')->count();
        return view('cfe.2025.Talleres',compact('elementostotales','modulo','anio','Regimenes','empresas'));
    }
    public function vistaTalleresoccidente(){
        $Regimenes=$this->Regimenes;
        $empresas=Empresa::select('id','nombre')->get();
        $sucu = \Auth::user()->sucursal_id;
        $modulo = Modulo::where('descripcion', 'CFE OCCIDENTE')->value('id');
        $anio = AnioCorrespondiente::where('descripcion', '2024')->value('id');
        $elementostotales = presupuestosCFE::where("CFE_id",$modulo)->where('created_at', '>', '2024-12-30')->count();
        return view('cfe.2025.Talleres',compact('elementostotales','modulo','anio','Regimenes','empresas'));
    }


    public function Obtenertalleresexternos(Request $request){
       if($request->has('idservicio')){
        $recepcion = presupuestosCFE::join('pCFEVehiculos','presupuestosCFE.pCFEVehiculos_id','=','pCFEVehiculos.id')
            ->join('pCFEGenerales','presupuestosCFE.pCFEGenerales_id','=','pCFEGenerales.id')
            ->join('users','presupuestosCFE.user_id','=','users.id')
            ->join('sucursales','users.sucursal_id','=','sucursales.id')
            ->join('contratos','sucursales.contratos_id','=','contratos.id')
            ->select('presupuestosCFE.id','pCFEGenerales.NSolicitud','pCFEGenerales.FechaAlta','pCFEGenerales.OrdenServicio',
            'pCFEGenerales.KmDeIngreso','pCFEVehiculos.identificador','pCFEVehiculos.kilometraje','pCFEVehiculos.marca',
            'pCFEVehiculos.modelo','pCFEVehiculos.ano','pCFEVehiculos.placas','pCFEVehiculos.vin','pCFEGenerales.ClienteYRazonSocial',
            'pCFEGenerales.Mail','pCFEGenerales.Telefono','pCFEGenerales.Conductor','presupuestosCFE.created_at','presupuestosCFE.observaciones','presupuestosCFE.status','pCFEVehiculos.id as pCFEVehiculos_id','pCFEGenerales.id as pCFEGenerales_id'
            ,'presupuestosCFE.descripcionMO','presupuestosCFE.importe','presupuestosCFE.importep','presupuestosCFE.ubicacion','presupuestosCFE.tdeentrega','presupuestosCFE.area')
            ->where('presupuestosCFE.id',$request->input('idservicio'))->where('presupuestosCFE.created_at', '>', '2024-12-30')->first();
        $conceptos=pCFECarrito::with('concepto')->where('presupuestoCFE_id', $recepcion->id)->get();
        return response()->json(['recepcion' => $recepcion,'conceptos' => $conceptos]);
       }
       else{
        $id = \Auth::user()->id;
        $ids = \Auth::user()->sucursal_id;
        $modulo=$request->input('modulo');
        $m = Sucursales::join('contratos','sucursales.contratos_id','=','contratos.id')
        ->select('contratos.id','contratos.nombre','contratos.monto','contratos.numero')
        ->where('sucursales.id','=',$ids)->get();

        $idcontrato = $m[0]['id'];

        if (!$request->ajax()) return redirect('/');
        if(\Auth::user()->id == 1){
            $categorias = pCFECategorias::where('CFE_id',$modulo)->orderBy('titulo', 'asc')->get();
            $tipos = pCFETipos::where('CFE_id',$modulo)->orderBy('tipo', 'asc')->get();
        } else {
            $categorias = pCFECategorias::where('CFE_id',$modulo)->where('sucursal_id','=',\Auth::user()->sucursal_id)->orderBy('titulo', 'asc')->get();
            $tipos = pCFETipos::where('CFE_id',$modulo)->orderBy('tipo', 'asc')->get();
        }
        $productos = CodigoSat::get();
        $contratos = Contratos::get();
        $recepciones = presupuestosCFE::join('pCFEVehiculos','presupuestosCFE.pCFEVehiculos_id','=','pCFEVehiculos.id')
            ->join('pCFEGenerales','presupuestosCFE.pCFEGenerales_id','=','pCFEGenerales.id')
            ->join('users','presupuestosCFE.user_id','=','users.id')
            ->join('sucursales','users.sucursal_id','=','sucursales.id')
            ->join('contratos','sucursales.contratos_id','=','contratos.id')
            ->select('presupuestosCFE.id','pCFEGenerales.NSolicitud','pCFEGenerales.FechaAlta','pCFEGenerales.OrdenServicio',
            'pCFEGenerales.KmDeIngreso','pCFEVehiculos.identificador','pCFEVehiculos.kilometraje','pCFEVehiculos.marca',
            'pCFEVehiculos.modelo','pCFEVehiculos.ano','pCFEVehiculos.placas','pCFEVehiculos.vin','pCFEGenerales.ClienteYRazonSocial',
            'pCFEGenerales.Mail','pCFEGenerales.Telefono','pCFEGenerales.Conductor','presupuestosCFE.created_at','presupuestosCFE.observaciones','presupuestosCFE.status','pCFEVehiculos.id as pCFEVehiculos_id','pCFEGenerales.id as pCFEGenerales_id'
            ,'presupuestosCFE.descripcionMO','presupuestosCFE.importe','presupuestosCFE.importep','presupuestosCFE.ubicacion','presupuestosCFE.tdeentrega','presupuestosCFE.area')
            ->where('presupuestosCFE.CFE_id',$modulo)
            ->where('contratos.id','=',$idcontrato)
            ->where('presupuestosCFE.created_at', '>', '2024-12-30')
            ->orderBy('presupuestosCFE.id', 'desc')->get();
        return response()->json([
            'recepciones' => $recepciones
        ]);
       }
    }

    public function conceptospresupuesto(Request $request){
        $conceptos=pCFECarrito::with('concepto')->where('presupuestoCFE_id', $request->id)->get();
        return response()->json(['conceptos' => $conceptos]);
    }
    public function eliminarconceptopresupuesto(Request $request){
        $concepto=pCFECarrito::findorfail($request->input('id'));
        $concepto->delete();
        return "Eliminado";
    }
    public function obtenerdatosnuevosconcepto(Request $request){
        $data = CodigoSat::findorfail($request->input("id"));
        return response()->json([
            'data' => $data
        ]);
    }
    public function ObtenerRecepciones(Request $request){
        if($request->has('id','modulo')){
            $recepcion=RecepcionVehicular::where("modulo",$request->input('modulo'))->where("id",$request->input('id'))->orderBy('id', 'desc')->first();
            if($recepcion){
                return response()->json([
                    'recepcion' => $recepcion
                ]);
            }else{
                return "Numero de recepcion no encontrada";
            }
        }else{
        $sucu = \Auth::user()->sucursal_id;
        $modulo = $request->input('modulo'); // 'valor_modulo'
        $anio = $request->input('anio');     // '2024'
        $recepciones = RecepcionVehicular::where("sucursal_id",'=',$sucu)->where("modulo",$modulo)->where("id_anio_correspondiente",$anio)->orderBy('id', 'desc')->get();
        
        return response()->json([
            'recepciones' => $recepciones
        ]);}
    }
    public function Obtenerdatosservicio(Request $request){

        $res = RecepcionVehicular::where('folioNum','=',$request->input('orden'))->first();
        
        if($res){
            if($res->empresa_id){
                $ubi = Empresa::where('id','=', $res->empresa_id)->first();
                $data['ciudad'] = $ubi->ciudad;
            }
            $r = Vehiculo::where('id', '=', $res->vehiculo_id)->first();
            $modelo = $r->modelo_id;

            $marca = Marca::where('id','=',$r->marca_id)->first();
            $marca = $marca->nombre;

            $Modelo = Modelo::where('id','=',$modelo)->first();
            $modelo = $Modelo->nombre;

            $rcus = Customer::where('id','=',$res->customer_id)->first();
            $data['ubic acion'] = $rcus->nombre;
            $data['km'] = $res->km_entrada;
            $data['idRecepcion'] = $res->id;
            $data['folio'] = $res->folioNum;
            $data['administrador'] = $res->administrador;
            $data['jefedeprocesos'] = $res->jefedeprocesos;
            $data['telefonojefe'] = $res->telefonojefe;
            $data['trabajador'] = $res->trabajador;
            $data['notas'] = $res->notas_adicionales;
            $data['fecha'] = $res->fecha;
            $data['placas'] = $r->placas;
            $data['vin'] = $r->vim;
            $data['economico'] = $r->no_economico;
            $data['anio'] = $r->anio;
            $data['marca'] = $marca;
            $data['modelo'] = $modelo;
            $data['id'] =  $res->folio;


            return response()->json([
                'data' => $data
            ]);
        }else{
            return "No existe";
        }

       
    }
    public function guardarnuevocolor(Request $request){
        $request->validate([
            'newcolor' => 'required|max:255',
        ], [
            'newcolor.required' => 'El color es obligatorio.',
        ]);
            DB::beginTransaction();
            try {
            $color = new Color;
            $color->nombre= $request->input('newcolor');
            $color->save();
            DB::commit();
            return "guardado";
            }catch (\Exception $e) {
                DB::rollBack();
                return abort(500, $e->getMessage());
            }
                
    }
    public function nuevoconcepto(Request $request){
        $validatedData = $request->validate([ 
            'Conceptos_Select2' => 'required|exists:codigo_sat,id', 
            'Categoriaconceptos_Select2' => 'required|exists:pcfecategorias,id', 
            'Tiposconceptos_Select2' => 'required|exists:pcfetipos,id', 
            'descripcionconcepto' => 'required|string|max:255', 
            'prefaccion' => 'required|numeric|min:0', 
            'pmo' => 'required|numeric|min:0', 
            'modulo' => 'required|exists:modulos,id',], 
            [ 'Conceptos_Select2.required' => 'El concepto es obligatorio.', 
            'Conceptos_Select2.exists' => 'El concepto seleccionado no es válido.', 
            'Categoriaconceptos_Select2.required' => 'La categoría es obligatoria.', 
            'Categoriaconceptos_Select2.exists' => 'La categoría seleccionada no es válida.', 
            'Tiposconceptos_Select2.required' => 'El tipo de concepto es obligatorio.', 
            'Tiposconceptos_Select2.exists' => 'El tipo de concepto seleccionado no es válido.', 
            'descripcionconcepto.required' => 'La descripción es obligatoria.', 
            'descripcionconcepto.string' => 'La descripción debe ser una cadena de texto.', 
            'descripcionconcepto.max' => 'La descripción no debe superar los 255 caracteres.', 
            'prefaccion.required' => 'El precio de refacción es obligatorio.', 
            'prefaccion.numeric' => 'El precio de refacción debe ser un número.', 
            'prefaccion.min' => 'El precio de refacción no puede ser negativo.', 
            'pmo.required' => 'El precio de mano de obra es obligatorio.', 
            'pmo.numeric' => 'El precio de mano de obra debe ser un número.', 
            'pmo.min' => 'El precio de mano de obra no puede ser negativo.', 
            'modulo.required' => 'El módulo es obligatorio.', 
            'modulo.exists' => 'El módulo seleccionado no es válido.', ]);
        try{
            DB::beginTransaction();
            $data = CodigoSat::findorfail($request->input("Conceptos_Select2"));
            $cilindros=pCFETipos::findorfail($request->input("Tiposconceptos_Select2"));
            $concepto = new pCFEConceptos();
            $concepto->pCFECategorias_id = $request->input('Categoriaconceptos_Select2');
            $concepto->pCFETipos_id = ($cilindros->cilindros)*1000;
            $concepto->num ='FC';
            $concepto->descripcion = $request->input('descripcionconcepto');
            $concepto->p_refaccion = $request->input('prefaccion');
            $concepto->tiempo = ("1.0");
            $concepto->p_mo = $request->input('pmo');
            $concepto->p_total = $request->input('prefaccion') + $request->input('pmo');
            $concepto->codigo_sat = $data->code;
            $concepto->codigo_unidad = $data->unidad_sat;
            $concepto->unidad_text = $data->unidad;
            $concepto->id_anio_correspondiente = 3;
            // $concepto->CFE_id = $request->input('modulo');
            $concepto->save();             
          
           
            DB::commit();
            return "guardado";
        } catch (Exception $e){
            DB::rollBack();
        }
    }
    public function deleterecpcion(Request $request){
        
        try {
            $id = $request->input('id');
            $recepcion = RecepcionVehicular::findOrFail($id);
            $recepcion->delete();
            return "eliminado";
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' =>"usuario no encontrado"], 422);
        }
                
    }
    public function nuevarecepcionservicio (Request $request){
        
        try{
            DB::beginTransaction();
 
            $mytime= Carbon::now('America/Lima');
            $fechita = Carbon::parse($request->fecha)->format('Y-m-d H:m');

            if($request->input('modulo')== 7 ){
                $vehiculo = new pVehiculos2023();
                $generales = new pGenerales2023();
                $cotizacion = new presupuestos2023();
               
                $origen='PECO';
            }else if($request->input('modulo')== 2 ){
                $vehiculo = new pCFEVehiculos();
                $generales = new pCFEGenerales();
                $cotizacion = new presupuestosCFE();
                
                $origen='BAJIO';
            }else if($request->input('modulo')== 3 ){
                $vehiculo = new pCFEVehiculos();
                $generales = new pCFEGenerales();
                $cotizacion = new presupuestosCFE();
                $origen='OCCIDENTE';
            }else if($request->input('modulo')== 6 ){
                $vehiculo = new pCFEVehiculos();
                $generales = new pCFEGenerales();
                $cotizacion = new presupuestosCFE();
                $origen='ECO';}

            $vehiculo->identificador = $request->input('rsEconomico');
            $vehiculo->modelo = $request->input('rsmodelo');
            $vehiculo->vin = $request->input('rsvin');
            $vehiculo->placas = $request->input('rsplacas');
            $vehiculo->ano = $request->input('rsAño');
            $vehiculo->kilometraje = $request->input('rsKilometraje');
            $vehiculo->marca = $request->input('rsMarca');
            $vehiculo->fecha = $fechita;
            $vehiculo->save();

            $fechaAl =$request->input('rsFecha_Alta');

            $generales->NSolicitud = $request->input('rsFolio');
            $generales->FechaAlta = $fechaAl;
            $generales->OrdenServicio = $request->input('rsid');
            $generales->KmDeIngreso = $request->input('rsKm_De_Ingreso');
            $generales->ClienteYRazonSocial = $request->input('rsAdministrador_de_Transportes');
            $generales->Mail = $request->input('rsJefe_de_Proceso');
            $generales->Telefono = $request->input('rsTeléfono');
            $generales->Conductor = $request->input('rsTrabajador');
            $generales->Fecha = $fechita;
            $generales->save();

            if($origen=='PECO'){
                $cotizacion->pVehiculos_id = $vehiculo->id;
                $cotizacion->pGenerales_id = $generales->id;
                $cotizacion->empresa_id = $request->input('empresa_id');
                $cotizacion->eco_id ='1';
               
                }else if($origen=='OCCIDENTE'|| $origen=='BAJIO'|| $origen=='ECO' ) {
                $cotizacion->pCFEVehiculos_id = $vehiculo->id;
                $cotizacion->pCFEGenerales_id = $generales->id;
                $cotizacion->CFE_id=$request->input('modulo');
            }

            $cotizacion->descripcionMO = "";
            $cotizacion->fechaDeVigencia = $fechita;
            $cotizacion->tiempo = "12:00";
            // $cotizacion->importe ="";
            $cotizacion->observaciones =$request->input('rsObservaciones');
            $cotizacion->user_id = \Auth::user()->id;
            $cotizacion->ubicacion =$request->input('rsUbicación');
            $cotizacion->area =$request->input('rsArea');
            $cotizacion->save();
            
            if($origen=='PECO'){
                $coti = new ServicioOrden2023();
            $coti->presupuesto_id = $cotizacion->id;
            $coti->preocorr_id = $request->input('rsServicio');  
            $coti->ubicacion = $request->input('rsUbicacion2');
            $coti->area = $request->input('rsArea');
            $coti->save();
               
                }else if($origen=='OCCIDENTE'|| $origen=='BAJIO'|| $origen=='ECO') {
                    $coti = new ServicioOrden();
                    $coti->presupuestoCFE_id = $cotizacion->id;
                    $coti->preocorr_id = $request->input('rsServicio');  
                    $coti->ubicacion = $request->input('rsUbicacion2');
                    $coti->area = $request->input('rsArea');
                    $coti->save();
            }



            if($request->input('rsServicio') == "2"){

                $detalles = $request->input("rsCorrectivos");//Array de detalles
                foreach($detalles as $det)
                {
                    $detalle = new CorrectivosOrden2023();
                    $detalle->presupuesto_id = $cotizacion->id;
                    $detalle->correctivo_id = $det;      
                    $detalle->save();
                }     

            } 
            if($request->input('rsServicio') == "1"){
                $ser = new TipoServicioOrden2023();
                $ser->presupuesto_id = $cotizacion->id;
                $ser->tipo_servicio = $request->input('rsTipo_de_Servicio');
                $ser->kilometros = $request->input('rsKilometraje2');
                $ser->save();

            }

          
           
            DB::commit();
            return "guardado";
        } catch (Exception $e){
            DB::rollBack();
        }
    
    }
    public function nuevarecepcion (Request $request){
        $checkbox=[
            'llanta',
            'cubreruedas',
            'cables_corriente',
            'candado_ruedas',
            'estuche_herramientas',
            'gato',
            'llave_tuercas',
            'tarjeta_circulacion',
            'triangulo_seguridad',
            'extinguidor',
            'placas','decolorada',
            'emblemas_completos',
            'color_no_igual',
            'logos',
            'exeso_rayones',
            'exeso_rociado',
            'pequenias_grietas',
            'danios_granizado',
            'carroceria_golpes',
            'lluvia_acido'
        ];
        $selects=[
            'puerta_interior_frontal',
            'puerta_interior_trasera',
            'puerta_delantera_frontal',
            'puerta_delantera_trasera',
            'asiento_interior_frontal',
            'asiento_interior_trasera',
            'asiento_delantera_frontal',
            'asiento_delantera_trasera',
            'consola_central',
            'claxon',
            'tablero',
            'quemacocos',
            'toldo',
            'elevadores_eletricos',
            'luces_interiores',
            'seguros_eletricos',
            'tapetes',
            'climatizador',
            'radio',
            'espejos_retrovizor',
            'antena_radio',
            'antena_telefono',
            'antena_cb',
            'estribos',
            'espejos_laterales',
            'guardafangos',
            'parabrisas',
            'sistema_alarma',
            'limpia_parabrisas',
            'luces_exteriores',
        ];
        $messages = [
            'ord_seguimiento.required' => 'La Orden de seguimiento es obligatoria.',
            'ord_seguimiento.max'=>'La Orden de seguimineto es muy larga',
            'ord_seguimiento.min'=>'La Orden de seguimineto es muy corta',
            'folio.max'=>'El Folio es muy largo',
            'folio.min'=>'El Folio es muy corto',
            'fecha.required' => 'La fecha es obligatoria.',
            'empresasrecepcion.exists'=> 'La Empresa no existe',
            'clientesrecepcion.required'=> 'El cliente es obligatorio',
            'clientesrecepcion.exists'=> 'El cliente no existe',
            'vehiculo.required'=>'El vehiculo es obligatorio',
            'vehiculo.exists'=>'El vehiculo no existe',
            'kmentrada.required'=>'Este campo es obligatorio',
            'kmentrada.min'=>'El kilometraje no es valido',
            'kmentrada.numeric'=>'El kilometraje no es valido',
            'kmsalida.required'=>'Este campo es obligatorio',
            'kmsalida.min'=>'El kilometraje no es valido',
            'kmsalida.numeric'=>'El kilometraje no es valido',
            'gasentrada.required' => 'El nivel de gasolina es obligatorio.',
            'gasentrada.in'=>'El nivel no es valido',
            'gassalida.required' => 'El nivel de gasolina es obligatorio.',
            'gassalida.in'=>'El nivel no es valido',
            'tipo_auto.required' => 'El tipo de auto es obligatorio.',
            'tipo_auto.in'=>'El nivel no es valido',
            ...array_merge(
                array_map(fn($field) => [
                    "{$field}.required" => "El campo {$field} es obligatorio.",
                    "{$field}.in" => "La opción seleccionada para {$field} no es válida. Debe ser uno de los valores: 1, 2, 3, 4 o 5."],
                    $selects),
                array_map(fn($field) => ["{$field}.boolean" => "El campo no es valido."], $selects)),
            'fecha_esperada.required' => 'La fecha esperada es obligatoria.',
            'fecha_entrega.required' => 'La fecha de entrega es obligatoria.',
            'notasadicionales.max' => 'las notas adicionales son muy grandes.',
            'indicacionescliente.max' => 'las indicaciones del cliente son muy largas.',
            'admintrasporte.max' => 'la información de administración de transporte es muy larga.',
            'jefedelproceso.max' => 'el nombre del jefe de proceso es muy largo.',
        ];
        if($request->has('id')){
            $request->validate([
                'id'=>'exists:recepcion_vehicular,id',
                'ord_seguimiento' => 'required|string|max:15|min:5',
                'folio' => 'nullable|string|max:15|min:3',
                'fecha' => 'required|date',
                'empresasrecepcion' => 'nullable|exists:empresas,id',
                'clientesrecepcion' => 'required|exists:customers,id',
                'vehiculo' => 'required|exists:vehiculos,id',
                'kmentrada' => 'required|numeric|min:0',
                'kmsalida' => 'required|numeric|min:0',
                'gasentrada' => 'required|in:0,1,2,3',
                'gassalida' => 'required|in:0,1,2,3',
                'tecnico' => 'nullable|string|max:255',
                'tipo_auto' => 'nullable|in:1,2,3,4',
                'miCanvas' => 'nullable|string',
                'canvasfirma' => 'nullable|string',
                'fecha_esperada' => 'required|date',
                'fecha_entrega' => 'required|date',
                ...array_map(fn($field) => [ "{$field}"=> 'required|in:1,2,3,4,5'],$selects),
                ...array_map(fn($field) => [ "{$field}"=>'nullable|boolean'],$checkbox),
                'notasadicionales' => 'nullable|string|max:500',
                'indicacionescliente' => 'nullable|string|max:500',
                'admintrasporte' => 'nullable|string|max:255',
                'jefedelproceso' => 'nullable|string|max:255',
            ]);   
        }
        else{
        $request->validate([
            'ord_seguimiento' => 'required|string|max:15|min:5',
            'folio' => 'nullable|string|max:15|min:3',
            'fecha' => 'required|date',
            'empresasrecepcion' => 'nullable|exists:empresas,id',
            'clientesrecepcion' => 'required|exists:customers,id',
            'vehiculo' => 'required|exists:vehiculos,id',
            'kmentrada' => 'required|numeric|min:0',
            'kmsalida' => 'required|numeric|min:0',
            'gasentrada' => 'required|in:0,1,2,3',
            'gassalida' => 'required|in:0,1,2,3',
            'tecnico' => 'nullable|string|max:255',
            'tipo_auto' => 'required|in:1,2,3,4',
            'miCanvas' => 'nullable|string',
            'canvasfirma' => 'nullable|string',
            'fecha_esperada' => 'required|date',
            'fecha_entrega' => 'required|date',
            ...array_map(fn($field) => [ "{$field}"=> 'required|in:1,2,3,4,5'],$selects),
            ...array_map(fn($field) => [ "{$field}"=>'nullable|boolean'],$checkbox),
            'notasadicionales' => 'nullable|string|max:500',
            'indicacionescliente' => 'nullable|string|max:500',
            'admintrasporte' => 'nullable|string|max:255',
            'jefedelproceso' => 'nullable|string|max:255',
        ]);}
        $img = $request->input('miCanvas');
        $img2 = $request->input('canvasfirma');
        if (!$img) {
            return response()->json(['error' => 'Los detalles son obligatorios.'], 422);
        }
        try {
            $fileName = $this->guardarImagenBase64($img, 'carror');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al guardar la imagen miCanvas.'], 422);
        }
        if (!$img2) {
            return response()->json(['error' => 'La firma es obligatoria.'], 422);
        }
            try {
                $fileName2 = $this->guardarImagenBase64($img2, 'firmas');
            } catch (\Exception $e) {
                return response()->json(['error' => 'Error al guardar la imagen canvasfirma.'], 500);
            }
        
        DB::beginTransaction();
            try {
            if(!$request->has('id')){
            $recepcion = new RecepcionVehicular;
            $ExterioresEquipo = new ExterioresEquipo();
            $CondicionesPintura = new CondicionesPintura();
            $EquipoInventario = new EquipoInventario();
            $InterioresEquipo = new InterioresEquipo();
           
            $idsucursal = \Auth::user()->sucursal_id;
            $sucu = Sucursales::select('clave')->where('id',$idsucursal)->get();
            $num = RecepcionVehicular::where('sucursal_id','=',$idsucursal)->orderBy('id','desc')->get();
            $numreal = RecepcionVehicular::count();
            if($numreal == 0){
                $clave = $sucu[0]['clave'].'00001'; 
            } else {
                if($num[0]['id'] == 0){
                    $clave = $sucu[0]['clave'].'00001'; 
                } else {
                    $numeros = $num[0]['id'] + 1;
                    $numeroConCeros = str_pad($numeros, 5, "0", STR_PAD_LEFT);
                    $clave = $sucu[0]['clave'].$numeroConCeros;
                }
            }
            $recepcion->folioNum=$clave;
            $recepcion->usuario_id= \Auth::user()->id;
            $recepcion->sucursal_id=$idsucursal;
            $recepcion->status= 0;
            $recepcion->id_anio_correspondiente=3;
            }
            else{
                $recepcion=RecepcionVehicular::find($request->input('id'));
                $ExterioresEquipo =ExterioresEquipo::where('recepcion_vehicular_id',$recepcion->id)->first();
                $CondicionesPintura =CondicionesPintura::where('recepcion_vehicular_id',$recepcion->id)->first();
                $EquipoInventario =EquipoInventario::where('recepcion_vehicular_id',$recepcion->id)->first();
                $InterioresEquipo =InterioresEquipo::where('recepcion_vehicular_id',$recepcion->id)->first();
            }
            $HojaConcepto = new HojaConcepto();
            $EntradasSalidas = new EntradasSalidas();
            $OrdenesPagadas = new OrdenesPagadas();

            $recepcion->empresa_id= $request->input('empresasrecepcion');
            $recepcion->customer_id= $request->input('clientesrecepcion');
            $recepcion->vehiculo_id= $request->input('vehiculo');
            $recepcion->orden_seguimiento= $request->input('ord_seguimiento');
            $recepcion->folio= $request->input('folio');
            $recepcion->notas_adicionales= $request->input('notasadicionales');
            $recepcion->indicaciones_del_cliente= $request->input('indicacionescliente');
            $recepcion->km_entrada= $request->input('kmentrada');
            $recepcion->km_salida= $request->input('kmsalida');
            $recepcion->gas_entrada= $request->input('gasentrada');
            $recepcion->gas_salida= $request->input('gassalida');
            $recepcion->tecnico= $request->input('tecnico');
            $recepcion->fecha= $request->input('fecha');
            $recepcion->firma= $fileName2;
            $recepcion->carro= $fileName;
            $recepcion->fecha_compromiso= $request->input('fecha_esperada');
            $recepcion->fecha_entrega= $request->input('fecha_entrega');
            $recepcion->modulo= $request->input('modulo');
            $recepcion->administrador= $request->input('admintrasportes');
            $recepcion->jefedeprocesos= $request->input('jefedelproceso');
            $recepcion->telefonojefe= $request->input('telefonorecepcion');
            $recepcion->trabajador= $request->input('Trabajador');
            $recepcion->save();

            $ExterioresEquipo->recepcion_vehicular_id= $recepcion->id;
            $ExterioresEquipo->antena_radio = $request->input('antena_radio');
            $ExterioresEquipo->antena_telefono = $request->input('antena_telefono');
            $ExterioresEquipo->antena_cb = $request->input('antena_cb');
            $ExterioresEquipo->estribos = $request->input('estribos');
            $ExterioresEquipo->espejos_laterales = $request->input('espejos_laterales');
            $ExterioresEquipo->guardafangos = $request->input('guardafangos');
            $ExterioresEquipo->parabrisas = $request->input('parabrisas');
            $ExterioresEquipo->sistema_alarma = $request->input('sistema_alarma');
            $ExterioresEquipo->limpia_parabrisas = $request->input('limpia_parabrisas');
            $ExterioresEquipo->luces_exteriores = $request->input('luces_exteriores');
            $ExterioresEquipo->save();


            $EquipoInventario->recepcion_vehicular_id= $recepcion->id;
            $EquipoInventario->llanta = $request->input('llanta', 0);
            $EquipoInventario->cubreruedas = $request->input('cubreruedas', 0);
            $EquipoInventario->cables_corriente = $request->input('cables_corriente', 0);
            $EquipoInventario->candado_ruedas = $request->input('candado_ruedas', 0);
            $EquipoInventario->estuche_herramientas = $request->input('estuche_herramientas', 0);
            $EquipoInventario->gato = $request->input('gato', 0);
            $EquipoInventario->llave_tuercas = $request->input('llave_tuercas', 0);
            $EquipoInventario->tarjeta_circulacion = $request->input('tarjeta_circulacion', 0);
            $EquipoInventario->triangulo_seguridad = $request->input('triangulo_seguridad', 0);
            $EquipoInventario->extinguidor = $request->input('extinguidor', 0);
            $EquipoInventario->placas = $request->input('placas', 0);
            $EquipoInventario->save();


            $InterioresEquipo->recepcion_vehicular_id= $recepcion->id;
            $InterioresEquipo->puerta_interior_frontal = $request->input('puerta_interior_frontal');
            $InterioresEquipo->puerta_interior_trasera = $request->input('puerta_interior_trasera');
            $InterioresEquipo->puerta_delantera_frontal = $request->input('puerta_delantera_frontal');
            $InterioresEquipo->puerta_delantera_trasera = $request->input('puerta_delantera_trasera');
            $InterioresEquipo->asiento_interior_frontal = $request->input('asiento_interior_frontal');
            $InterioresEquipo->asiento_interior_trasera = $request->input('asiento_interior_trasera');
            $InterioresEquipo->asiento_delantera_frontal = $request->input('asiento_delantera_frontal');
            $InterioresEquipo->asiento_delantera_trasera = $request->input('asiento_delantera_trasera');
            $InterioresEquipo->consola_central = $request->input('consola_central');
            $InterioresEquipo->claxon = $request->input('claxon');
            $InterioresEquipo->tablero = $request->input('tablero');
            $InterioresEquipo->quemacocos = $request->input('quemacocos');
            $InterioresEquipo->toldo = $request->input('toldo');
            $InterioresEquipo->elevadores_eletricos = $request->input('elevadores_eletricos');
            $InterioresEquipo->luces_interiores = $request->input('luces_interiores');
            $InterioresEquipo->seguros_eletricos = $request->input('seguros_eletricos');
            $InterioresEquipo->tapetes = $request->input('tapetes');
            $InterioresEquipo->climatizador = $request->input('climatizador');
            $InterioresEquipo->radio = $request->input('radio');
            $InterioresEquipo->espejos_retrovizor = $request->input('espejos_retrovizor');
            $InterioresEquipo->save();

            $CondicionesPintura->recepcion_vehicular_id= $recepcion->id;
            $CondicionesPintura->decolorada=$request->input('decolorada', 0);
            $CondicionesPintura->emblemas_completos=$request->input('emblemas_completos', 0);
            $CondicionesPintura->color_no_igual=$request->input('color_no_igual', 0);
            $CondicionesPintura->logos=$request->input('logos', 0);
            $CondicionesPintura->exeso_rayones=$request->input('exeso_rayones', 0);
            $CondicionesPintura->exeso_rociado=$request->input('exeso_rociado', 0);
            $CondicionesPintura->pequenias_grietas=$request->input('pequenias_grietas', 0);
            $CondicionesPintura->danios_granizado=$request->input('danios_granizado', 0);
            $CondicionesPintura->carroceria_golpes=$request->input('carroceria_golpes', 0);
            $CondicionesPintura->lluvia_acido=$request->input('lluvia_acido', 0);
            $CondicionesPintura->save();

            $fechita = Carbon::parse($recepcion->fecha)->format('Y-m-d');
            $vehiculo = Vehiculo::where('id','=',$recepcion->vehiculo_id)->get();
            $empresa = Empresa::where('id','=',$recepcion->empresa_id)->get();
            $modelo = Modelo::where('id','=',$vehiculo[0]['modelo_id'])->get();
            $marca = Marca::where('id','=',$vehiculo[0]['marca_id'])->get();
            $date = Carbon::now();
            $hora = $date->toTimeString();
            $fecha123 = Carbon::parse($request->fecha)->format('Y-m-d H:m');
            
            $EntradasSalidas->empresa = $empresa[0]->nombre;
            $EntradasSalidas->n_orden = $recepcion->orden_seguimiento;
            $EntradasSalidas->hora_entrada = $hora;
            $EntradasSalidas->orden_servicio = $recepcion->orden_seguimiento;
            $EntradasSalidas->economico = $vehiculo[0]->no_economico;
            $EntradasSalidas->placas =  $vehiculo[0]->placas;    
            $EntradasSalidas->kms = $recepcion->km_entrada; 
            $EntradasSalidas->serie = $vehiculo[0]->vim;
            $EntradasSalidas->fecha_entrada = $fechita;  
            $EntradasSalidas->observaciones = $recepcion->indicaciones_del_cliente; 
            $EntradasSalidas->asignado = $recepcion->tecnico;
            $EntradasSalidas->save();

            $OrdenesPagadas->fecha =  $fechita;
            $OrdenesPagadas->orden = $recepcion->orden_seguimiento;
            $OrdenesPagadas->empresa = $empresa[0]->nombre;
            $OrdenesPagadas->placa = $vehiculo[0]->placas;    
            $OrdenesPagadas->serie = $vehiculo[0]->vim;
            $OrdenesPagadas->os =  $recepcion->orden_seguimiento;    
            $OrdenesPagadas->folio_sistema = $recepcion->folioNum;  
            $OrdenesPagadas->status = 0; 
            $OrdenesPagadas->save();
            
                if($request->input('modulo')== 7 ){
                    $vehiculo1 = new pVehiculos2023();
                    $generales1 = new pGenerales2023();
                    $cotizacion = new presupuestos2023();
                    $origen='PECO';
                }else if($request->input('modulo')== 2 ){
                    $vehiculo1 = new pCFEVehiculos();
                    $generales1 = new pCFEGenerales();
                    $cotizacion = new presupuestosCFE();
                    $origen='BAJIO';
                }else if($request->input('modulo')== 3 ){
                    $vehiculo1 = new pCFEVehiculos();
                    $generales1 = new pCFEGenerales();
                    $cotizacion = new presupuestosCFE();
                    $origen='OCCIDENTE';}
                else if($request->input('modulo')== 6 ){
                        $vehiculo1 = new pCFEVehiculos();
                        $generales1 = new pCFEGenerales();
                        $cotizacion = new presupuestosCFE();
                        $origen='ECO';}
            
            $vehiculo1->fecha = $fecha123;
            $vehiculo1->identificador = $vehiculo[0]->no_economico;
            $vehiculo1->modelo = $modelo[0]->nombre;
            $vehiculo1->vin =  $vehiculo[0]->vim;
            $vehiculo1->placas = $vehiculo[0]->placas;
            $vehiculo1->ano = $vehiculo[0]->anio;
            $vehiculo1->kilometraje = $recepcion->km_entrada;
            $vehiculo1->marca = $marca[0]->nombre;
            $vehiculo1->save();

            $generales1->FechaAlta = $fecha123;
            $generales1->Fecha = $fecha123;
            $generales1->Conductor = 'Conductor';
            $generales1->NSolicitud = $recepcion->folioNum;
            $generales1->OrdenServicio = $recepcion->orden_seguimiento;
            $generales1->KmDeIngreso = $recepcion->km_entrada;
            $generales1->ClienteYRazonSocial = $empresa[0]->nombre;
            $generales1->Mail = $empresa[0]->email;
            $generales1->Telefono = $empresa[0]->tel_negocio;
            $generales1->save();

            if($origen=='PECO'){
            $cotizacion->pVehiculos_id = $vehiculo1->id;
            $cotizacion->pGenerales_id = $generales1->id;
            $cotizacion->empresa_id = $recepcion->empresa_id;
            $cotizacion->eco_id ='1';
            }else if($origen=='OCCIDENTE'|| $origen=='BAJIO' || $origen=='ECO') {
            $cotizacion->pCFEVehiculos_id = $vehiculo1->id;
            $cotizacion->pCFEGenerales_id = $generales1->id;
            $cotizacion->CFE_id=$request->input('modulo');
            }

            $cotizacion->fechaDeVigencia = $fecha123;
            $cotizacion->tiempo = '1';
            $cotizacion->importe ='0';
            $cotizacion->user_id = \Auth::user()->id;
            $cotizacion->ubicacion = 'Ubicacion';
            $cotizacion->area = 'Area';
            $cotizacion->descripcionMO = $recepcion->indicaciones_del_cliente;
            $cotizacion->observaciones = $recepcion->indicaciones_del_cliente;
            $cotizacion->save();   

            $HojaConcepto->modulo                       = $request->input('modulo');
            $HojaConcepto->presupuesto_id               = $cotizacion->id;
            $HojaConcepto->id_recepcion                 = $recepcion->id;
            $HojaConcepto->fecha_hoja_concepto          = Carbon::parse($fecha123)->timezone('America/Mexico_City')->toDateTimeString();
            $HojaConcepto->subtotal_partes              = '0';
            $HojaConcepto->subtotal_mano_obra           = '0';
            $HojaConcepto->subtotal_subcontratado       = '0';
            $HojaConcepto->subtotal_otros               = '0';
            $HojaConcepto->subtotal_subtotal_costos     = '0';
            $HojaConcepto->iva_subtotal_partes          = '0';
            $HojaConcepto->iva_subtotal_mano_obra       = '0';
            $HojaConcepto->iva_subtotal_subcontratado   = '0';
            $HojaConcepto->iva_subtotal_otros           = '0';
            $HojaConcepto->iva_subtotal_subtotal_costos = '0';
            $HojaConcepto->total_partes                 = '0';
            $HojaConcepto->total_mano_obra              = '0';
            $HojaConcepto->total_subcontratado          = '0';
            $HojaConcepto->total_otros                  = '0';
            $HojaConcepto->total_subtotal_costos        = '0';
            $HojaConcepto->autorizacion                 = '';
            $HojaConcepto->id_tecnico                   = $recepcion->tecnico;
            $HojaConcepto->odes                         = $recepcion->folioNum;
            $HojaConcepto->r_r                          = $recepcion->orden_seguimiento;
            $HojaConcepto->save();
  
    
            DB::commit();
            return "guardado";
            }catch (\Exception $e) {
                DB::rollBack();
                return abort(500, $e->getMessage());
            }
        
    }
    public function obtenercatalogoproductosyservicios(Request $request){
       
        //$conceptos = pCFEConceptos::select('id','num','descripcion','pnuevo','p_total','pCFECategorias_id as categoria','pCFETipos_id as tipo')->where('CFE_id',$request->input('modulo'))->orderBy('id', 'asc')->get();
        $conceptos = pCFEConceptos::select('id','num','descripcion','pnuevo','p_total','pCFECategorias_id as categoria','pCFETipos_id as tipo')->where('id_anio_correspondiente',2)->orderBy('id', 'asc')->get();
        return response()->json([
            'conceptos' => $conceptos
        ]);
    }
    public function cilindrostipo(Request $request){
       
        $cilindros=pCFETipos::findorfail($request->input("id"));
        return response()->json($cilindros);
    }
    public function updatecotizacion(Request $request)
    {
            log::info($request->modulo);
        if($request->modulo == 2 ){
            $cotizacion =presupuestosCFE::find($request->id);
            $vehiculo =pCFEVehiculos::find($cotizacion->pCFEVehiculos_id);
            $generales =pCFEGenerales::find($cotizacion->pCFEGenerales_id);
            
            $origen='BAJIO';
        }else if($request->modulo == 3 ){
            $cotizacion =presupuestosCFE::find($request->id);
            $vehiculo =pCFEVehiculos::find($cotizacion->pCFEVehiculos_id);
            $generales =pCFEGenerales::find($cotizacion->pCFEGenerales_id);
            $origen='OCCIDENTE';
        }else if($request->modulo == 6 ){
            $cotizacion =presupuestosCFE::find($request->id);
            $vehiculo =pCFEVehiculos::find($cotizacion->pCFEVehiculos_id);
            $generales =pCFEGenerales::find($cotizacion->pCFEGenerales_id);
            $origen='ECO';}


        $vehiculo->identificador = $request->identificador;
        $vehiculo->modelo = $request->modelo;
        $vehiculo->vin = $request->vin;
        $vehiculo->placas = $request->placas;
        $vehiculo->ano = $request->ano;
        $vehiculo->kilometraje = $request->kilometraje;
        $vehiculo->marca = $request->marca;
        $vehiculo->save();

        $generales->NSolicitud = $request->NSolicitud;
        $generales->FechaAlta = $request->fecha_alta;
        $generales->OrdenServicio = $request->orden_servicio;
        $generales->KmDeIngreso = $request->kilometraje;
        $generales->ClienteYRazonSocial = $request->cliente_razon_social;
        $generales->Mail = $request->jefe_proceso;
        $generales->Telefono = $request->telefono;
        $generales->Conductor = $request->conductor;
        $generales->save();

        
        $cotizacion->descripcionMO = $request->observacionesmo;
        $cotizacion->importe =$request->importe;
        $cotizacion->ubicacion =$request->ubicacion;
        $cotizacion->observaciones =$request->observaciones;
        $cotizacion->tdeentrega =$request->tdentrega;
        $cotizacion->save(); 

        $conceptoslista=$request->conceptos;
        if($request->conceptos){
        foreach ($conceptoslista as $producto) {
            $concepto = pCFECarrito::find($producto['id']);
            $concepto->cantidad=$producto['cantidad'];
            $concepto->precio=$producto['precio'];
            $concepto->save();
        }}
        return "Actualizado";
    }

    function guardarcatalogoproductosyservicios(Request $request)
{
    $productos = $request->productos;
    $idPresupuesto = $request->input('idPresupuesto');

    // Validar los datos entrantes
    

    // Obtener los IDs de productos enviados
    $idsProductos = array_column($productos, 'id');

    // Obtener los productos ya relacionados con el presupuesto
    $productosExistentes = pCFECarrito::where('presupuestoCFE_id', $idPresupuesto)
        ->pluck('pCFEConcepto_id')
        ->toArray();

    // Identificar los nuevos productos
    $nuevosProductos = array_filter($productos, function ($producto) use ($productosExistentes) {
        return !in_array($producto['id'], $productosExistentes);
    });

    // Insertar los nuevos productos
    foreach ($nuevosProductos as $producto) {
        $preciov = pCFEConceptos::find($producto['id']);
        LOG::info($preciov);
        pCFECarrito::create([
            'presupuestoCFE_id' => $idPresupuesto,
            'pCFEConcepto_id' => $producto['id'],
            'cantidad' => $producto['cantidad'],
            'precio' => $producto['precio'],
            'precio_v' => $preciov->p_total,
            'usuario_id' => \Auth::id(),
        ]);
    }

    // Filtrar los productos que ya existían
    $productosRepetidos = array_filter($productos, function ($producto) use ($productosExistentes) {
        return in_array($producto['id'], $productosExistentes);
    });

    // Obtener los nombres de los productos que ya existían
    $nombresRepetidos = pCFEConceptos::whereIn('id', array_column($productosRepetidos, 'id'))
        ->pluck('descripcion')
        ->toArray();

    return response()->json([
        'existen' => $nombresRepetidos, // Productos que ya existían
    ]);
}


private function guardarImagenBase64($imagenBase64, $directorio)
{
    // Validar formato base64
    if (!preg_match('/^data:image\/(png|jpeg);base64,/', $imagenBase64)) {
        throw new \Exception('Formato de imagen no válido.');
    }

    // Decodificar la imagen
    $data = substr($imagenBase64, strpos($imagenBase64, ',') + 1);
    $data = base64_decode($data);
    if ($data === false) {
        throw new \Exception('Error al decodificar la imagen.');
    }
    $extension = 'png'; 
    $fileName = uniqid() . '.' . $extension;

    // Guardar la imagen en el almacenamiento
    Storage::put("public/$directorio/$fileName", $data);

    return $fileName;
}

public function agregararchivospresupuesto(Request $request){
    if ($request->hasFile('file')) {
        $archivo = $request->file('file');
        $nombreArchivo = time() . '_' . $archivo->getClientOriginalName();
        $origen=$request->origen;
        if($origen=="FotosViejas"){
        $ruta = public_path('/documentos/fotosviejas/');}
        else{
            $ruta = public_path('/documentos/otrosarchivos/');
        }
        if (!file_exists($ruta)) {
            mkdir($ruta, 0777, true); // Crea la carpeta si no existe
        }
        $archivo->move($ruta, $nombreArchivo);
        try{
            DB::beginTransaction();
            $cotizacion =FotosViejas::where('presupuestoCFE_id',$request->id)->first();
            if($cotizacion){
                $archivoExistente = $ruta . '/' . $cotizacion->archivo;
                if (file_exists($archivoExistente)) {
                    unlink($archivoExistente); // Eliminar el archivo existente
                }
            }else{
                $cotizacion =new FotosViejas();
                $cotizacion->presupuestoCFE_id = $request->id;
            }
            $cotizacion->archivo = $nombreArchivo;
            $cotizacion->save();               
            DB::commit();
            return response()->json(['success' => 'Se Guardo Correctamente el archivo'], 200);
        } catch (Exception $e){
            DB::rollBack();
            return response()->json(['error' => 'Ocurrió un error al guardar el archivo'], 500);
        }
    }
    
}
public function obtenerarchivo(Request $request){
    if($request->has('id')){ 
        $cotizacion =FotosViejas::where('presupuestoCFE_id',$request->id)->first();
        if($cotizacion){ 
        return response()->json(['id' => $cotizacion->archivo], 200);  
    }else {
        return response()->json(['error' => 'El Numero del Presupuesto Actualemente No Se Encuentra Activa'], 499);
    }
    }
    else { return response()->json(['error' => 'No Se Envio El Numero del  Presupuesto'], 499); }
}



 public function deletepresupuesto(Request $request){
    if($request->has('id')){ 
            $presupuesto = presupuestosCFE::find($request->id);
            if($presupuesto){
            $presupuesto->delete(); 
            return response()->json(['success' => 'Eliminado Correctamente'], 200);  
        }else {
            return response()->json(['error' => 'El Presupuesto Actualemente Ya No Se Encuentra Activo'], 499);
        }
    }
    else { return response()->json(['error' => 'No Se Envio El Identificador del Presupuesto'], 499); }

 }
 public function obteneridrecepcion(Request $request){
    if($request->has('folionum')){ 
        $recepcionv =RecepcionVehicular::where("folioNum",$request->folionum)->first();
        if($recepcionv){ 
        return response()->json(['id' => $recepcionv->id], 200);  
    }else {
        return response()->json(['error' => 'El Numero de Solictud de la Recepcion Vehicular Actualemente Ya No Se Encuentra Activa'], 499);
    }
    }
    else { return response()->json(['error' => 'No Se Envio El Numero de Solictud de la Recepcion Vehicular'], 499); }
 }

 public function reporte(Request $request,$id){
    $Recepcion = RecepcionVehicular::where('recepcion_vehicular.id','=',$id)
    ->select('recepcion_vehicular.customer_id')
        ->first();
   if($Recepcion->customer_id==null){
    $RecepcionVehicular = RecepcionVehicular::join('empresas','recepcion_vehicular.empresa_id','=','empresas.id')
    ->join('users','recepcion_vehicular.usuario_id','=','users.id')
    ->join('vehiculos','recepcion_vehicular.vehiculo_id','=','vehiculos.id')
    ->join('tipo_auto','vehiculos.tipo_id','=','tipo_auto.id')
    ->join('marcas','vehiculos.marca_id','=','marcas.id')
    ->join('modelos','vehiculos.modelo_id','=','modelos.id')
    ->join('colores','vehiculos.color_id','=','colores.id')
    ->select('recepcion_vehicular.id','recepcion_vehicular.orden_seguimiento','recepcion_vehicular.folio','recepcion_vehicular.notas_adicionales',
    'recepcion_vehicular.indicaciones_del_cliente','recepcion_vehicular.km_entrada','recepcion_vehicular.km_salida','recepcion_vehicular.gas_entrada',
    'recepcion_vehicular.gas_salida','recepcion_vehicular.fecha','recepcion_vehicular.firma','recepcion_vehicular.carro',
    'recepcion_vehicular.fecha_compromiso','empresas.nombre','empresas.direccion','empresas.ciudad','empresas.estado','empresas.cp',
    'empresas.tel_negocio','empresas.tel_casa','empresas.tel_celular','empresas.email',
    'tipo_auto.nombre as tipo_auto','marcas.nombre as marca','modelos.nombre as modelo','colores.nombre as color','vehiculos.placas','vehiculos.anio','vehiculos.no_economico','vehiculos.vim','users.name','recepcion_vehicular.tecnico','recepcion_vehicular.fecha_entrega','recepcion_vehicular.folioNum')
    ->where('recepcion_vehicular.id','=',$id)
    ->orderBy('recepcion_vehicular.id','desc')->take(1)->get();
   }
   else 
   {
    $RecepcionVehicular = RecepcionVehicular::join('empresas','recepcion_vehicular.empresa_id','=','empresas.id')
    ->join('users','recepcion_vehicular.usuario_id','=','users.id')
    ->join('customers','recepcion_vehicular.customer_id','=','customers.id')
    ->join('vehiculos','recepcion_vehicular.vehiculo_id','=','vehiculos.id')
    ->join('tipo_auto','vehiculos.tipo_id','=','tipo_auto.id')
    ->join('marcas','vehiculos.marca_id','=','marcas.id')
    ->join('modelos','vehiculos.modelo_id','=','modelos.id')
    ->join('colores','vehiculos.color_id','=','colores.id')
    ->select('recepcion_vehicular.id','recepcion_vehicular.orden_seguimiento','recepcion_vehicular.folio','recepcion_vehicular.notas_adicionales',
    'recepcion_vehicular.indicaciones_del_cliente','recepcion_vehicular.km_entrada','recepcion_vehicular.km_salida','recepcion_vehicular.gas_entrada',
    'recepcion_vehicular.gas_salida','recepcion_vehicular.fecha','recepcion_vehicular.firma','recepcion_vehicular.carro',
    'recepcion_vehicular.fecha_compromiso','empresas.nombre','empresas.direccion','empresas.ciudad','empresas.estado','empresas.cp','customers.nombre as usuario',
    'empresas.tel_negocio','empresas.tel_casa','empresas.tel_celular','empresas.email',
    'tipo_auto.nombre as tipo_auto','marcas.nombre as marca','modelos.nombre as modelo','colores.nombre as color','vehiculos.placas','vehiculos.anio','vehiculos.no_economico','vehiculos.vim','users.name','recepcion_vehicular.tecnico','recepcion_vehicular.fecha_entrega','recepcion_vehicular.folioNum')
    ->where('recepcion_vehicular.id','=',$id)
    ->orderBy('recepcion_vehicular.id','desc')->take(1)->get();

   }


  

    $InterioresEquipo = InterioresEquipo::where('interiores_equipo.recepcion_vehicular_id','=',$id)
    ->orderBy('interiores_equipo.id','desc')->take(1)->get();

    $ExterioresEquipo = ExterioresEquipo::where('exteriores_equipo.recepcion_vehicular_id','=',$id)
    ->orderBy('exteriores_equipo.id','desc')->take(1)->get();

    $EquipoInventario = EquipoInventario::where('equipo_inventario.recepcion_vehicular_id','=',$id)
    ->orderBy('equipo_inventario.id','desc')->take(1)->get();

    $condicionesPintura = CondicionesPintura::where('condiciones_pintura.recepcion_vehicular_id','=',$id)
    ->orderBy('condiciones_pintura.id','desc')->take(1)->get();
   
 return \View::make('reportes.recepcion_vehicular_storage', compact('RecepcionVehicular','InterioresEquipo','ExterioresEquipo',
 'EquipoInventario','condicionesPintura'))->render();
// $pdf  =  \App::make('dompdf.wrapper');
//$pdf->loadHTML('<h1>Test</h1>');
// $view =  \View::make('reportes.recepcion_vehicular', compact('cotizacion'))->render();
// $pdf->loadHTML($view);
// $pdf->stream();
//return $pdf->stream('invoice');
//  return $pdf->download('profile.pdf');

}


}
