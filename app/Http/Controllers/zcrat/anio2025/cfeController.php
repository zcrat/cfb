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
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
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

    public function vistarecepcioneco(){
        $Regimenes=$this->Regimenes;
        $empresas=Empresa::select('id','nombre')->get();
        $sucu = \Auth::user()->sucursal_id;
        $modulo = Modulo::where('descripcion', 'CFE ECO')->value('id');
        $anio = AnioCorrespondiente::where('descripcion', '2025')->value('id');;
        $elementostotales = RecepcionVehicular::where("sucursal_id",'=',$sucu)->where("modulo",$modulo)->where("id_anio_correspondiente",$anio)->count();
        return view('cfe.2025.recepcion',compact('elementostotales','modulo','anio','Regimenes','empresas'));
    }
    public function vistarecepcionbajio(){
        $Regimenes=$this->Regimenes;
        $empresas=Empresa::select('id','nombre')->get();
        $sucu = \Auth::user()->sucursal_id;
        $modulo = Modulo::where('descripcion', 'CFE BAJIO')->value('id');;
        $anio = AnioCorrespondiente::where('descripcion', '2025')->value('id');;
        $elementostotales = RecepcionVehicular::where("sucursal_id",'=',$sucu)->where("modulo",$modulo)->where("id_anio_correspondiente",$anio)->count();
        return view('cfe.2025.recepcion',compact('elementostotales','modulo','anio','Regimenes','empresas'));
    }
    public function vistarecepcionoccidente(){
        $Regimenes=$this->Regimenes;
        $empresas=Empresa::select('id','nombre')->get();
        $sucu = \Auth::user()->sucursal_id;
        $modulo = Modulo::where('descripcion', 'CFE OCCIDENTE')->value('id');;
        $anio = AnioCorrespondiente::where('descripcion', '2024')->value('id');;
        $elementostotales = RecepcionVehicular::where("sucursal_id",'=',$sucu)->where("modulo",$modulo)->where("id_anio_correspondiente",$anio)->count();
        return view('cfe.2025.recepcion',compact('elementostotales','modulo','anio','Regimenes','empresas'));
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
                    $origen='ECO';
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

            if($origen=='ECO'){
            $cotizacion->pVehiculos_id = $vehiculo1->id;
            $cotizacion->pGenerales_id = $generales1->id;
            $cotizacion->empresa_id = $recepcion->empresa_id;
            $cotizacion->eco_id ='1';
            }else if($origen=='OCCIDENTE'|| $origen=='BAJIO') {
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



}
