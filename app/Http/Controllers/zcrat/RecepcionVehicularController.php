<?php

namespace App\Http\Controllers\zcrat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Vehiculo;
use App\Models\Empresa;
use App\Models\Contratos;
use App\Models\Modulo;
use App\Models\AnioCorrespondiente;
use App\Models\PresupuestosModel;
use App\Models\RecepcionGeneralModel;
use App\Models\Sucursales;
use App\Models\claves;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\LOG;
use Illuminate\Support\Facades\Storage;
use App\Models\AdministradorTransporte;
use App\Models\JefeDeProceso;
use App\Models\TecnicoTaller;
use App\Models\FotoRecepcionVehicular;
use App\Models\Presupuesto;
use App\Models\DetallesGenerales;
use App\Models\RecepcionesVehiculares;
use App\Models\JefesdeProcesos;
use App\Models\Trabajadores;
use App\Models\AdministradoresdeTrasporte;
use App\Models\TiposPresupuesto;
use App\Models\CondicionesPintura;
use App\Models\EquipoInventario;
use App\Models\ExterioresEquipo;
use App\Models\InterioresEquipo;
class RecepcionVehicularController extends Controller
{
    private $imagenesrecienguardadas=[];
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
    
    Public function newvehiculo(Request $request){
        $request->validate([
            'tiponewvehiculo' => 'required|exists:tipo_auto,id',
            'marcanewvehiculo' => 'required|exists:marcas,id',
            'modelonewvehiculo' => 'required|exists:modelos,id',
            'colornewvehiculo' => 'required|exists:colores,id',
            'anionewcar' => 'required|integer',
            'numeconomiconewcar' => 'required|integer',
            'vimnewcar' => 'required|string',
            'placasnewcar' => 'required|string',
        ], [
            'tiponewvehiculo.required' => 'Tipo de vehículo es obligatorio.',
            'tiponewvehiculo.exists' => 'Tipo de vehículo seleccionado no es válido.',
            'marcanewvehiculo.required' => 'Marca del vehículo es obligatorio.',
            'marcanewvehiculo.exists' => 'Marca seleccionada no es válida.',
            'modelonewvehiculo.required' => 'Modelo del vehículo es obligatorio.',
            'modelonewvehiculo.exists' => 'Modelo seleccionado no es válido.',
            'colornewvehiculo.required' => 'Color del vehículo es obligatorio.',
            'colornewvehiculo.exists' => 'Color seleccionado no es válido.',
            'anionewcar.required' => 'Año del vehículo es obligatorio.',
            'anionewcar.integer' => 'Año del vehículo debe ser un número entero.',
            'numeconomiconewcar.required' => 'Número económico es obligatorio.',
            'numeconomiconewcar.integer' => 'Número económico debe ser un número entero.',
            'vimnewcar.required' => 'VIN es obligatorio.',
            'vimnewcar.string' => 'VIN debe ser una cadena de caracteres.',
            'placasnewcar.required' => 'Placas es obligatorio.',
            'placasnewcar.string' => 'Placas debe ser una cadena de caracteres.',
        ]);
        try {
            // Crear un nuevo registro en el modelo Vehiculo
            $vehiculo = Vehiculo::create([
                'tipo_id' => $request->input('tiponewvehiculo'),
                'marca_id' => $request->input('marcanewvehiculo'),
                'modelo_id' => $request->input('modelonewvehiculo'),
                'color_id' => $request->input('colornewvehiculo'),
                'anio' => $request->input('anionewcar'),
                'no_economico' => $request->input('numeconomiconewcar'),
                'vim' => $request->input('vimnewcar'),
                'placas' => $request->input('placasnewcar'),
            ]);
            return response()->json(['success' => 'Vehículo creado con éxito', 'vehiculo' => $vehiculo], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear el vehículo', 'details' => $e->getMessage()], 500);
        }
    }
    private $fotosnuevas=[];
    private $fotosnoeliminar=[];
    private $fotos64=[];
    public function VistaRecepcionVehicular(Request $request){
        $Regimenes=$this->Regimenes;
        $contrato = $request->contrato;
        $modulo = $request->modulo;
        $zona = $request->zona;
        $mod = $modulo;
        $con = $contrato;
        $zon = $zona;
        $edit=false;
        $anio = $request->anio;
        $empresas=Empresa::select('id','nombre')->get();
        $contrato = Contratos::where('nombre', $contrato)->value('id');
        $modulo = Modulo::where('descripcion', $modulo)->value('id');
        $zona = Sucursales::where('nombre', $zona)->value('id');
        $ids = DetallesGenerales::where('modulo_id',$modulo)->where('zona_id',$zona)->where('contrato_id','=',$contrato)->where('anio','=',$anio)->orderBy('id','desc')->pluck('id');
        $elementostotales = RecepcionesVehiculares::whereIn('DetallesGenerales_id',$ids)->count();
        return view('zcrat.RecepcionVehicular',compact('elementostotales','modulo','anio','Regimenes','empresas','mod','con','zona','zon','contrato','edit'));
    }
    public function ObtenerRecepcionesVehiculares(Request $request){
        if (!$request->ajax()) {
            return redirect()->route('homevue');
        }
        $modulo = $request->modulo; // 'cfe, cfb etc'
        $contrato = $request->contrato;  // 'morelia deisel, morelia gasolina etc'
        $zona = $request->zona;
        $anio = $request->anio;     // '2024'

        $ids = DetallesGenerales::where('modulo_id',$modulo)->where('zona_id',$zona)->where('contrato_id','=',$contrato)->where('anio','=',$anio)->orderBy('id','desc')->pluck('id');
        $elements = RecepcionesVehiculares::with('detallesGenerales')->whereIn('DetallesGenerales_id',$ids)->get();
        return response()->json(['elements' => $elements]);
    }
    public function ObtenerRecepcionVehicular(Request $request){
        if (!$request->ajax()) {
            return redirect()->route('homevue');
        }
        $recepcion=RecepcionesVehiculares::with([
            'detallesGenerales',
            'detallesGenerales.Vehiculo',
            'detallesGenerales.User',
            'detallesGenerales.User_update',
            'detallesGenerales.Empresa',
            'detallesGenerales.Customer',
            'detallesGenerales.AdministradorTrasporte',
            'detallesGenerales.JefedeProceso',
            'detallesGenerales.Trabajador',
            'detallesGenerales.Vehiculo',
            'fotos',
            'pintura',
            'tecnico',
            'exteriores',
            'interiores',
            'inventario',
            ])
            ->where("id",$request->input('id'))->orderBy('id', 'desc')->first();
        if($recepcion){
            return response()->json([
                'recepcion' => $recepcion
            ]);
        }else{
            return response()->json(['error' => 'La Recepcion Vehicular No Existe'],500);
        }
    }
    public function DeleteRecepcionVehicular(Request $request){
        if (!$request->ajax()) {
            return redirect()->route('homevue');
        }
        $request->validate(['id'=>'required|exists:RecepcionesVehiculares,id'],['id.required'=>'La Recepcion Es Obligatoria','id.exists'=>'La Recepcion Vehicular Ya no esta Disponible, Recargue la pagina']);
        try {
            $id = $request->input('id');
            $recepcion = RecepcionesVehiculares::findOrFail($id);
            $recepcion->delete();
            return response()->json(['success' =>"Se Elimino Correctamente"], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' =>"Recepcion no encontrado"], 422);
        }    
    }
    public function ToggleFotosUpdate(Request $request){
        if (!$request->ajax()) {
            return redirect()->route('homevue');
        }
        $request->validate(['id'=>'required|exists:RecepcionesVehiculares,id'],['id.required'=>'La Recepcion Es Obligatoria','id.exists'=>'La Recepcion Vehicular Ya no esta Disponible, Recargue la pagina']);
        try {
            $id = $request->input('id');
            $recepcion = RecepcionesVehiculares::findOrFail($id);
            if($recepcion->Update_fotos==0){
                $recepcion->Update_fotos=1;
                $messages='Se Pueden Modificar Las fotos de Evidencia';
            }else{
                $recepcion->Update_fotos=0;
                $messages='Ya No Se Pueden Modificar Las fotos de Evidencia';
            }
            $recepcion->save();
            return response()->json(['success' =>$messages], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' =>"Recepcion no encontrado"], 422);
        }    
    }
    public function CreateRecepcionVehicular (Request $request){
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
        $validationselects = array_combine($selects, array_map(function ($field) {
            return 'required|in:1,2,3,4,5';
        }, $selects));
        $messageselects =array_reduce($selects, function ($carry, $field) {
            $carry["{$field}.required"] = "Este campo es obligatorio.";
            $carry["{$field}.in"] = "La opción no es válida";
            return $carry;
        }, []);
        $validationcheckbox = array_combine($checkbox, array_map(function ($field) {
            return 'nullable|boolean';
        }, $checkbox));
        $messagecheckbox =array_reduce($checkbox, function ($carry, $field) {
            $carry["{$field}.boolean"] = "La opción no es válida";
            return $carry;
        }, []);
        $messages = array_merge([
                'ord_seguimiento.max' => 'La Orden de seguimiento es muy larga.',
                'ord_seguimiento.min' => 'La Orden de seguimiento es muy corta.',
                'folio.max' => 'El Folio es muy largo.',
                'folio.min' => 'El Folio es muy corto.',
                'fecha.required' => 'La fecha de entrada es obligatoria.',
                'empresasrecepcion.required' => 'La Empresa es obligatoria.',
                'empresasrecepcion.exists' => 'La Empresa no existe.',
                'clientesrecepcion.required' => 'El cliente es obligatorio.',
                'clientesrecepcion.exists' => 'El cliente no existe.',
                'vehiculo.required' => 'El vehículo es obligatorio.',
                'vehiculo.exists' => 'El vehículo no existe.',
                'tipovehiculo.required' => 'El tipo de auto es obligatorio.',
                'tipovehiculo.exists' => 'El El tipo de auto no es válido.',
                'miCanvas.required' => 'Los Detalles Son obligatorio.',
                'canvasfirma.required' => 'La firma es obligatorio.',
                'kmentrada.required' => 'Este campo es obligatorio.',
                'kmentrada.min' => 'El kilometraje no es válido.',
                'kmentrada.numeric' => 'El kilometraje no es válido.',
                'kmsalida.required' => 'Este campo es obligatorio.',
                'kmsalida.min' => 'El kilometraje no es válido.',
                'kmsalida.numeric' => 'El kilometraje no es válido.',
                'gasentrada.required' => 'El nivel de gasolina es obligatorio.',
                'gasentrada.exists' => 'El nivel no es válido.',
                'gassalida.required' => 'El nivel de gasolina es obligatorio.',
                'gassalida.exists' => 'El nivel no es válido.',
                'Tecnico.required' => 'El Tecnico es obligatorio.',
                'Tecnico.exists' => 'El Tecnico no es válido.',
                'admintrasporte.required' => 'El Administrador de Trasporte es obligatorio.',
                'admintrasporte.exists' => 'El Administrador de Trasporte no es válido.',
                'jefedelproceso.required' => 'El jefe del proceso es obligatorio.',
                'jefedelproceso.exists' => 'El jefe del proceso no es válido.',
                'Trabajador.required' => 'El Trabajador es obligatorio.',
                'Trabajador.exists' => 'El Trabajador no es válido.',
                'fecha_esperada.required' => 'La fecha esperada es obligatoria.',
                'telefonorecepcion.required' => 'El Telefono es obligatoria.',
                'telefonorecepcion.digits' => 'El Telefono no es valido.',
                'notasadicionales.max' => 'Las notas adicionales son muy grandes.',
                'indicacionescliente.max' => 'Las indicaciones del cliente son muy largas.',
                ],$messagecheckbox,$messageselects);
        $rules=array_merge([
            'ord_seguimiento' => 'nullable|string|max:15|min:5',
            'folio' => 'nullable|string|max:15|min:3',
            'fecha' => 'required|date',
            'fechasalida' => 'nullable|date',
            'empresasrecepcion' => 'nullable|exists:empresas,id',
            'clientesrecepcion' => 'nullable|exists:customers,id',
            'vehiculo' => 'required|exists:vehiculos,id',
            'tipovehiculo' => 'required|exists:pcfetipos,id',
            'kmentrada' => 'required|numeric|min:0',
            'kmsalida' => 'nullable|numeric|min:0',
            'gasentrada' => 'required|exists:nivelescombustible,id',
            'gassalida' => 'nullable|exists:nivelescombustible,id',
            'admintrasporte' => 'required|exists:administradoresdetrasporte,id',
            'Tecnico' => 'required|exists:tecnicostaller,id',
            'jefedelproceso' => 'required|exists:jefesdeprocesos,id',
            'Trabajador' => 'required|exists:trabajadores,id',
            'fecha_esperada' => 'required|date',
            'telefonorecepcion' => 'required|digits:10',
            'notasadicionales' => 'nullable|string|max:500',
            'indicacionescliente' => 'nullable|string|max:500',
            'miCanvas' => 'required',
            'canvasfirma' => 'required',
            ],$validationcheckbox,$validationselects);

        $validator = \Validator::make($request->all(), $rules, $messages);

        $img = $request->miCanvas;
        log::info($request->canvasfirma);
        $img2 = $request->canvasfirma;
        $fileName='';
        $fileName2='';
        $fotosfile=[];
        $validator->after(function ($validator) use ($request ,$img,$img2,&$fileName,&$fileName2,&$fotosfile ) {
            try {
                $fileName = $this->guardarImagenBase64($img, 'carros');
            } catch (\Exception $e) {
                log::info($e);
                $validator->errors()->add('miCanvas', 'Los Detalles No se Pudieron Guardar');
            }
            try {
                $fileName2 = $this->guardarImagenBase64($img2, 'firmastaller');
            } catch (\Exception $e) {
                $validator->errors()->add('canvasfirma', 'La Firma No Se Pudo Guardar');
            }
           
            if($request->has('fotos')){
            $photos=$request->fotos;
            if (count($photos) < 6){
                $validator->errors()->add('Fotos Del Vehiculo', 'Las Fotos de Evidencia son muy pocas');
            }else{
            foreach($photos as $foto){
                try {
                    $fotosfile[] = $this->guardarImagenBase64($foto, 'evidenciasrecepcionvehicular');
                } catch (\Exception $e) {
                    $validator->errors()->add('Fotos Del Vehiculo', 'Las Fotos de Evidencia No Se Pudieron Guardar');
                    break;
                }
            }
        }}
        else{
            $validator->errors()->add('Fotos Del Vehiculo', 'Las Fotos de Evidencia Son Obligatorias');
        }
        });
        if ($validator->fails()) {
            //$this->eliminarImagenBase64();
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
            try {
                $idcontrato = $request->contrato;
                $idmodulo = $request->modulo;
                $idzona = $request->zona;
                $idanio = $request->anio;

                $ids = DetallesGenerales::where('modulo_id',$idmodulo)->where('zona_id',$idzona)->where('contrato_id','=',$idcontrato)->where('anio','=',$idanio)->orderBy('id','desc')->pluck('id');
                $num = RecepcionesVehiculares::whereIn('DetallesGenerales_id',$ids)->count();
                $clave=Claves::where('modulo_id',$idmodulo)->where('zona_id',$idzona)->value('clave');
                
                $numeroConCeros = str_pad($num, 5, "0", STR_PAD_LEFT);
                $clave = $clave.$numeroConCeros;

                $detalles = new DetallesGenerales();
                $detalles->OrdenServicio = $clave;
                $detalles->OrdenSeguimiento = $request->ord_seguimiento?$request->ord_seguimiento:$clave;
                $detalles->Folio = $request->folio?$request->folio:$clave;
                $detalles->Fecha_Esperada = $request->fecha_esperada;
                $detalles->Kilometraje_entrada = $request->kmentrada;
                $detalles->Gas_entrada = $request->gasentrada;
                $detalles->Fecha_entrada = $request->fecha;
                $detalles->Kilometraje_salida = $request->kmsalida;
                $detalles->Gas_salida = $request->gassalida;
                $detalles->Fecha_salida = $request->fechasalida;
                $detalles->Vehiculo_id = $request->vehiculo;
                $detalles->User_id = \Auth::user()->id;
                $detalles->User_update_id = \Auth::user()->id;
                $detalles->Empresa_id = $request->empresasrecepcion;
                $detalles->Customer_id = $request->clientesrecepcion;
                $detalles->AdministradorTrasporte_id = $request->admintrasporte;
                $detalles->JefedeProceso_id = $request->jefedelproceso;
                $detalles->Trabajador_id = $request->Trabajador;
                $detalles->Telefono = $request->telefonorecepcion;
                $detalles->contrato_id = $request->contrato;
                $detalles->Indicaciones_cliente = $request->indicacionescliente;
                $detalles->modulo_id = $request->modulo;
                $detalles->anio = $request->anio;
                $detalles->zona_id = $request->zona;
                $detalles->save();

                $recepcion = new RecepcionesVehiculares();
                $recepcion->DetallesGenerales_id = $detalles->id; // ID válido de DetallesGenerales
                $recepcion->Notas = $request->notasadicionales;
                $recepcion->Tecnico_id = $request->Tecnico;// ID válido de un técnico
                $recepcion->Firma = $fileName2; // Ruta de la firma
                $recepcion->Carro = $fileName;
                $recepcion->save();

                foreach($fotosfile as $fotofile){
                  $foto=new FotoRecepcionVehicular();
                  $foto->RecepcionVehicular_id=$recepcion->id;
                  $foto->Foto=$fotofile;
                  $foto->save();
                }
                $ExterioresEquipo = new ExterioresEquipo();
                $CondicionesPintura = new CondicionesPintura();
                $EquipoInventario = new EquipoInventario();
                $InterioresEquipo = new InterioresEquipo();

                $ExterioresEquipo->RecepcionVehicular_id= $recepcion->id;
                $CondicionesPintura->RecepcionVehicular_id= $recepcion->id;
                $EquipoInventario->RecepcionVehicular_id= $recepcion->id;
                $InterioresEquipo->RecepcionVehicular_id= $recepcion->id;

                $tipos=[1=>'P',2=>'C',3=>''];
                if($request->tipo_servicio_presupuesto!=4){
                    $presupuesto = new Presupuesto();
                    $presupuesto->DetallesGenerales_id = $detalles->id;
                    $presupuesto->OrdenServicio = $detalles->OrdenServicio.$tipos[$request->tipo_servicio_presupuesto];
                    $presupuesto->Observaciones = $request->notasadicionales;
                    $presupuesto->FechaDeVigencia = now();
                    $presupuesto->Factura_id = 0;
                    $presupuesto->Tipo_id = $detalles->tipo_servicio_presupuesto;
                    $presupuesto->Status_id = 0;
                    $presupuesto->save();
                }else{
                    $presupuesto = new Presupuesto();
                    $presupuesto->DetallesGenerales_id = $detalles->id;
                    $presupuesto->OrdenServicio = $detalles->OrdenServicio.$tipos[1];
                    $presupuesto->Observaciones = $request->notasadicionales;
                    $presupuesto->FechaDeVigencia = now();
                    $presupuesto->Factura_id = 0;
                    $presupuesto->Tipo_id = 1;
                    $presupuesto->Status_id = 0;
                    $presupuesto->save();

                    $presupuesto2 = new Presupuesto();
                    $presupuesto2->DetallesGenerales_id = $detalles->id;
                    $presupuesto->OrdenServicio = $detalles->OrdenServicio.$tipos[2];
                    $presupuesto2->Observaciones = $request->notasadicionales;
                    $presupuesto2->FechaDeVigencia = now();
                    $presupuesto2->Factura_id = 0;
                    $presupuesto2->Tipo_id = 2;
                    $presupuesto2->Status_id = 0;
                    $presupuesto2->save();
                }

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
                
                DB::commit();
                return "guardado";
            }catch (\Exception $e) {
                DB::rollBack();
                return abort(500, $e->getMessage());
            }
        
    }
    public function UpdateRecepcionVehicular (Request $request){

        if(!$request->has('id')){
            return response()->json(['error'=>'La Recepcion vehicular Es Necesaria'],420);
        }
        $recepcion=RecepcionesVehiculares::find($request->id);
        if(empty($recepcion )){
            return response()->json(['error'=>'La Recepcion vehicular No Existe'],420);
        }
        $editarfotos= $recepcion->Update_fotos;


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
        $validationselects = array_combine($selects, array_map(function ($field) {
            return 'required|in:1,2,3,4,5';
        }, $selects));
        $messageselects =array_reduce($selects, function ($carry, $field) {
            $carry["{$field}.required"] = "Este campo es obligatorio.";
            $carry["{$field}.in"] = "La opción no es válida";
            return $carry;
        }, []);
        $validationcheckbox = array_combine($checkbox, array_map(function ($field) {
            return 'nullable|boolean';
        }, $checkbox));
        $messagecheckbox =array_reduce($checkbox, function ($carry, $field) {
            $carry["{$field}.boolean"] = "La opción no es válida";
            return $carry;
        }, []);
        $messages = array_merge([
                'ord_seguimiento.max' => 'La Orden de seguimiento es muy larga.',
                'ord_seguimiento.min' => 'La Orden de seguimiento es muy corta.',
                'folio.max' => 'El Folio es muy largo.',
                'folio.min' => 'El Folio es muy corto.',
                'fecha.required' => 'La fecha de entrada es obligatoria.',
                'empresasrecepcion.required' => 'La Empresa es obligatoria.',
                'empresasrecepcion.exists' => 'La Empresa no existe.',
                'clientesrecepcion.required' => 'El cliente es obligatorio.',
                'clientesrecepcion.exists' => 'El cliente no existe.',
                'vehiculo.required' => 'El vehículo es obligatorio.',
                'vehiculo.exists' => 'El vehículo no existe.',
                'tipovehiculo.required' => 'El tipo de auto es obligatorio.',
                'tipovehiculo.exists' => 'El El tipo de auto no es válido.',
                'miCanvas.required' => 'Los Detalles Son obligatorio.',
                'canvasfirma.required' => 'La firma es obligatorio.',
                'kmentrada.required' => 'Este campo es obligatorio.',
                'kmentrada.min' => 'El kilometraje no es válido.',
                'kmentrada.numeric' => 'El kilometraje no es válido.',
                'kmsalida.required' => 'Este campo es obligatorio.',
                'kmsalida.min' => 'El kilometraje no es válido.',
                'kmsalida.numeric' => 'El kilometraje no es válido.',
                'gasentrada.required' => 'El nivel de gasolina es obligatorio.',
                'gasentrada.exists' => 'El nivel no es válido.',
                'gassalida.required' => 'El nivel de gasolina es obligatorio.',
                'gassalida.exists' => 'El nivel no es válido.',
                'Tecnico.required' => 'El Tecnico es obligatorio.',
                'Tecnico.exists' => 'El Tecnico no es válido.',
                'admintrasporte.required' => 'El Administrador de Trasporte es obligatorio.',
                'admintrasporte.exists' => 'El Administrador de Trasporte no es válido.',
                'jefedelproceso.required' => 'El jefe del proceso es obligatorio.',
                'jefedelproceso.exists' => 'El jefe del proceso no es válido.',
                'Trabajador.required' => 'El Trabajador es obligatorio.',
                'Trabajador.exists' => 'El Trabajador no es válido.',
                'fecha_esperada.required' => 'La fecha esperada es obligatoria.',
                'telefonorecepcion.required' => 'El Telefono es obligatoria.',
                'telefonorecepcion.digits' => 'El Telefono no es valido.',
                'notasadicionales.max' => 'Las notas adicionales son muy grandes.',
                'indicacionescliente.max' => 'Las indicaciones del cliente son muy largas.',
                ],$messagecheckbox,$messageselects);
        $rules=array_merge([
            'ord_seguimiento' => 'nullable|string|max:15|min:5',
            'folio' => 'nullable|string|max:15|min:3',
            'fecha' => 'required|date',
            'fechasalida' => 'nullable|date',
            'empresasrecepcion' => 'nullable|exists:empresas,id',
            'clientesrecepcion' => 'nullable|exists:customers,id',
            'vehiculo' => 'required|exists:vehiculos,id',
            'kmentrada' => 'required|numeric|min:0',
            'kmsalida' => 'nullable|numeric|min:0',
            'gasentrada' => 'required|exists:nivelescombustible,id',
            'gassalida' => 'nullable|exists:nivelescombustible,id',
            'admintrasporte' => 'required|exists:administradoresdetrasporte,id',
            'Tecnico' => 'required|exists:tecnicostaller,id',
            'jefedelproceso' => 'required|exists:jefesdeprocesos,id',
            'Trabajador' => 'required|exists:trabajadores,id',
            'fecha_esperada' => 'required|date',
            'telefonorecepcion' => 'required|digits:10',
            'notasadicionales' => 'nullable|string|max:500',
            'indicacionescliente' => 'nullable|string|max:500',
            'miCanvas' => 'required',
            'canvasfirma' => 'required',
            ],$validationcheckbox,$validationselects);

        $validator = \Validator::make($request->all(), $rules, $messages);

        $img = $request->miCanvas;
        $img2 = $request->canvasfirma;
        $fileName='';
        $fileName2='';
        $fotosnuevas=[];
        $validator->after(function ($validator) use ($request ,$img,$img2,&$fileName,&$fileName2,&$fotosnuevas,$editarfotos ) {
            try {
                $fileName = $this->guardarImagenBase64($img, 'carros');
            } catch (\Exception $e) {
                log::info($e);
                $validator->errors()->add('miCanvas', 'Los Detalles No se Pudieron Guardar');
            }
            try {
                $fileName2 = $this->guardarImagenBase64($img2, 'firmastaller');
            } catch (\Exception $e) {
                $validator->errors()->add('canvasfirma', 'La Firma No Se Pudo Guardar');
            }
            if($editarfotos == 1){
                if($request->has('fotos')){
                    $photos=$request->fotos;
                    if (count($photos) < 6){
                        $validator->errors()->add('Fotos Del Vehiculo', 'Las Fotos de Evidencia son muy pocas');
                    }else{
                        $fotos=FotoRecepcionVehicular::where('RecepcionVehicular_id',$request->id)->get();
                        $this->convertirbase54( $fotos);
                        
                    foreach($photos as $foto){
                        $idexistente=$this->verificarexistencia($foto);
                        if($idexistente){
                            $this->fotosnoeliminar[]=$idexistente;
                        }else{
                            try {
                                $fotosnuevas[] = $this->guardarImagenBase64($foto, 'evidenciasrecepcionvehicular');
                            } catch (\Exception $e) {
                                $validator->errors()->add('Fotos Del Vehiculo', 'Las Fotos de Evidencia No Se Pudieron Guardar');
                                break;
                            }
                        }
                    }

                    if((count($this->fotosnoeliminar) + count($fotosnuevas))<6){
                        $validator->errors()->add('Fotos Del Vehiculo', 'Las Fotos de Evidencia Son Muy Pocas Ya que Hay Repetidas');
                    }
                }}
                else{
                    $validator->errors()->add('Fotos Del Vehiculo', 'Las Fotos de Evidencia Son Obligatorias');
                }
               
            }

        });
        if ($validator->fails()) {
            //$this->eliminarImagenBase64();
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
            try {
                $recepcion=RecepcionesVehiculares::find($request->id);
                $recepcion->Notas = $request->notasadicionales;
                $recepcion->Tecnico_id = $request->Tecnico;// ID válido de un técnico
                $recepcion->Firma = $fileName2; // Ruta de la firma
                $recepcion->Carro = $fileName;
                $recepcion->save();

                $detalles =DetallesGenerales::find($recepcion->DetallesGenerales_id);
                $detalles->OrdenSeguimiento = $request->ord_seguimiento;
                $detalles->Folio = $request->folio;
                $detalles->Fecha_Esperada = $request->fecha_esperada;
                $detalles->Kilometraje_entrada = $request->kmentrada;
                $detalles->Gas_entrada = $request->gasentrada;
                $detalles->Fecha_entrada = $request->fecha;
                $detalles->Kilometraje_salida = $request->kmsalida;
                $detalles->Gas_salida = $request->gassalida;
                $detalles->Fecha_salida = $request->fechasalida;
                $detalles->Vehiculo_id = $request->vehiculo;
                $detalles->User_update_id = \Auth::user()->id;
                $detalles->Empresa_id = $request->empresasrecepcion;
                $detalles->Customer_id = $request->clientesrecepcion;
                $detalles->AdministradorTrasporte_id = $request->admintrasporte;
                $detalles->JefedeProceso_id = $request->jefedelproceso;
                $detalles->Trabajador_id = $request->Trabajador;
                $detalles->Telefono = $request->telefonorecepcion;
                $detalles->Indicaciones_cliente = $request->indicacionescliente;
                $detalles->save();
                

                if($editarfotos == 1){
                    FotoRecepcionVehicular::wherenotIn('id',$this->fotosnoeliminar)->where('RecepcionVehicular_id',$recepcion->id)->delete();

                    foreach($fotosnuevas as $fotofile){
                    $foto=new FotoRecepcionVehicular();
                    $foto->RecepcionVehicular_id=$recepcion->id;
                    $foto->Foto=$fotofile;
                    $foto->save();
                    }
                }
                $ExterioresEquipo = ExterioresEquipo::where('RecepcionVehicular_id',$recepcion->id)->first();
                $CondicionesPintura =CondicionesPintura::where('RecepcionVehicular_id',$recepcion->id)->first();
                $EquipoInventario = EquipoInventario::where('RecepcionVehicular_id',$recepcion->id)->first();
                $InterioresEquipo =InterioresEquipo::where('RecepcionVehicular_id',$recepcion->id)->first();



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
                
                DB::commit();
                return "guardado";
            }catch (\Exception $e) {
                DB::rollBack();
                return abort(500, $e->getMessage());
            }
        
    }
   
    public function CreateUserTaller(Request $request){
        
        $request->validate([
            'newusertaller'=>'required'
        ],[
            'tipousertaller.required'=>'el tipo de usuario de taller es obligatorio',
        ]);

        $tipo=$request->tipousertaller?:'nullo';
        switch($tipo){
            case 'Administrador de Trasportes':
                $usertaller=new AdministradorTransporte();
                break;
            case 'Jefe de Proceso':
                $usertaller=new JefeDeProceso();
                break;        
            case 'Tecnico':
                $usertaller=new TecnicoTaller();
                break;
            default:
                $usertaller=new Trabajador();
                break;
        };
        try {
            DB::beginTransaction();
            $usertaller->nombre=$request->newusertaller;
            $usertaller->save();
            DB::commit();
            return response()->json(['success'=>'Nuevo Usuario De Taller Creado']);
        } catch (\Exception $e) {
            return response()->json(['error'=>'Ocurrio Un Problema En La BD'.$e->getmessage() ],422);

        }
    }
    private function guardarImagenBase64($imagenBase64, $directorio){
        // Validar formato base64
        if (!preg_match('/^data:image\/(png|jpeg);base64,/', $imagenBase64)) {
            log::info('Formato de imagen no válido.');
        }
        // Decodificar la imagen
        $data = substr($imagenBase64, strpos($imagenBase64, ',') + 1);
        $data = base64_decode($data);
        if ($data === false) {
            log::info('Error al decodificar la imagen.');
        }
        $extension = 'png'; 
        $fileName = uniqid() . '.' . $extension;
        // Guardar la imagen en el almacenamiento
        Storage::put("public/$directorio/$fileName", $data);
        $this->imagenesrecienguardadas[]="public/$directorio/$fileName";
        return $fileName;
    }
    private function convertirbase54($fotosactuales){
        foreach ($fotosactuales as $foto) {
            $filePath = storage_path('app/public/evidenciasrecepcionvehicular/' . $foto->Foto);
        
            if (file_exists($filePath)) {
                $fileContent = file_get_contents($filePath); // Leer el contenido del archivo
                $data = base64_encode($fileContent); // Codificar el contenido en base64
        
                $this->fotos64[] = [
                    'foto' => $data,
                    'id' => $foto->id
                ];
            } else {
                // Manejar el caso en que el archivo no exista
                $this->fotos64[] = [
                    'foto' => null,
                    'id' => $foto->id
                ];
            }
        }
    }
    private function verificarexistencia($foto){
        $id=null;
        foreach ($this->fotos64 as $foto64) {
           if($foto64['foto'] == $foto){
               $id=$foto64['id'];
               break;
           }
        }
        return $id;
    }

    private function eliminarImagenBase64(){
        foreach($this->imagenesrecienguardadas as $filePath){
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            } 
        }
    }
}
