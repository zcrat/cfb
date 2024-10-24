<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Support\Carbon;
use App\RevisionLucesEspias;
use App\Mangueras;
use App\Llantas;
use App\Liquidos;
use App\Bandas;
use App\Filtros;
use App\Seguridad;
use App\AfinacionMotor;
use App\Electrico;
use App\Frenos;
use App\TrenTransmision;
use App\SuspencionDireccion;
use App\Escape;
use App\InspeccionTecnicaVehiculo;
use App\RecepcionVehicular;
use App\Empresa;
use App\Cliente;
use App\Vehiculo;
use App\Marca;
use App\Modelo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class InspeccionTecnicaVehiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(InspeccionTecnicaVehiculo $InspeccionTecnicaVehiculo)
    {
       
        $insTecVe = $InspeccionTecnicaVehiculo->get();
        foreach ($insTecVe as $key => $value) {
            $RecepcionVehicular = new RecepcionVehicular;
            $Vehiculo = new Vehiculo;
            $Modelo = new Modelo;
            $Marca = new Marca;
            $RecepcionVehicular = $RecepcionVehicular->where('orden_seguimiento','=', $value->orden_seguimiento)->first();
            $Vehiculo = $Vehiculo->where('id',$RecepcionVehicular->vehiculo_id)->first();
            $Modelo = $Modelo->where('id',$Vehiculo->modelo_id)->first();
            $Marca = $Marca->where('id',$Vehiculo->marca_id)->first();

            $data[$key] = [
                'id' => $value->id,
                'orden_seguimiento' => $value->orden_seguimiento,
                'folio' => $RecepcionVehicular->folio,
                'placas' => $Vehiculo->placas,
                'fecha' => $value->fecha,
                'modnombre' => $Modelo->nombre,
                'marnombre' => $Marca->nombre

            ];
        }


        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response $Response
     * @param  \Exception  $exception
     */
    public function store(Request $request)
    {


        $RevisionLucesEspias = new RevisionLucesEspias;
        $Mangueras = new Mangueras;
        $Llantas = new Llantas;
        $Liquidos = new Liquidos;
        $Bandas = new Bandas;
        $Filtros = new Filtros;
        $Seguridad = new Seguridad;
        $AfinacionMotor = new AfinacionMotor;
        $Electrico = new Electrico;
        $Frenos = new Frenos;
        $TrenTransmision = new TrenTransmision;
        $SuspencionDireccion = new SuspencionDireccion;
        $Escape = new Escape;
        $InspeccionTecnicaVehiculo = new InspeccionTecnicaVehiculo;
        $exception = new Exception();


        $revisionLucesEspias = $request->revisionLucesEspias;
        $RevisionLucesEspias->codigo = $revisionLucesEspias['codigo'];

        $mangueras = $request->mangueras;
        $Mangueras -> refrigerante                 = $mangueras['mRefrigerante'];
        $Mangueras -> direccion_aire_acondicionado = $mangueras['direccionAireAcondic'];
        $Mangueras -> calefaccion                  = $mangueras['calefaccion'];

        $llantas = $request->llantas;
        $Llantas -> izquierda_delantera         = $llantas['dIDelantera'];
        $Llantas -> izquierda_delantera_presion = $llantas['pIDelantera'];
        $Llantas -> izquierda_trasera           = $llantas['dITrasera'];
        $Llantas -> izquierda_trasera_presion   = $llantas['pITrasera'];
        $Llantas -> derecha_delantera           = $llantas['dDDelantera'];
        $Llantas -> derecha_delantera_presion   = $llantas['pDDdelantera'];
        $Llantas -> derecha_trasera             = $llantas['dDTrasera'];
        $Llantas -> derecha_trasera_presion     = $llantas['pDTrasera'];
        $Llantas -> refaccion                   = $llantas['dRefaccion'];
        $Llantas -> refaccion_presion           = $llantas['pRefaccion'];
        $Llantas -> alineacion_balanceo         = $llantas['alineacionBalanceo'];

        $liquidos = $request->liquidos;
        $Liquidos -> aceite_motor                     = $liquidos['aceiteMotor'];
        $Liquidos -> transmision                      = $liquidos['transmision'];
        $Liquidos -> diferencial_frente_trasero       = $liquidos['diferencialft'];
        $Liquidos -> liquido_refrigerante             = $liquidos['lRefrigerante'];
        $Liquidos -> frenos                           = $liquidos['frenos'];
        $Liquidos -> direccion_hidraulica             = $liquidos['direccionHidraulica'];
        $Liquidos -> limpiaparabrisas                 = $liquidos['limpiaparabrisas'];
        $Liquidos -> aceite_motor_ok                  = $liquidos['aMOK'];
        $Liquidos -> aceite_motor_lleno               = $liquidos['aMLleno'];
        $Liquidos -> transmision_ok                   = $liquidos['tOK'];
        $Liquidos -> transmision_lleno                = $liquidos['tLleno'];
        $Liquidos -> diferencial_frente_trasero_ok    = $liquidos['dOK'];
        $Liquidos -> diferencial_frente_trasero_lleno = $liquidos['dLleno'];
        $Liquidos -> refrigerante_ok                  = $liquidos['reOK'];
        $Liquidos -> refrigerante_lleno               = $liquidos['reLleno'];
        $Liquidos -> frenos_ok                        = $liquidos['frOK'];
        $Liquidos -> frenos_lleno                     = $liquidos['frLleno'];
        $Liquidos -> direccion_hidraulica_ok          = $liquidos['dHOK'];
        $Liquidos -> direccion_hidraulica_lleno       = $liquidos['dHLleno'];
        $Liquidos -> limpiaparabrisas_ok              = $liquidos['liOK'];
        $Liquidos -> limpiaparabrisas_lleno           = $liquidos['liLleno'];
        $Liquidos -> liquido_notas                    = $liquidos['lNotas'];

        $bandas = $request->bandas;
        $Bandas -> accesorios                    = $bandas['accesorios'];
        $Bandas -> bandas_direccion_hidraulica   = $bandas['bDireccionHidraulica'];
        $Bandas -> alternador_aire_acondicionado = $bandas['alternadorAAcondic'];

        $filtros = $request->filtros;
        $Filtros -> aire        = $filtros['aire'];
        $Filtros -> combustible = $filtros['combustible'];
        $Filtros -> aceite      = $filtros['aceite'];
        $Filtros -> filtro_notas       = $filtros['fNotas'];

        $seguridad = $request->seguridad;
        $Seguridad -> frenos_emergencia                  = $seguridad['frenoEmergencia'];
        $Seguridad -> limpiaparabrisas_izquierdo_derecho = $seguridad['lpIzqDer'];
        $Seguridad -> limpiaparabrisas_trasero           = $seguridad['lpiTrasero'];
        $Seguridad -> seguridad_notas                    = $seguridad['lpNotas'];

        $afinacionMotor = $request->afinacionMotor;
        $AfinacionMotor -> tapa_distribuidor_bujias_cables = $afinacionMotor['tapadistribuidorBujíasCables'];
        $AfinacionMotor -> fuel_injection                  = $afinacionMotor['fuelInjection'];

        $electrico = $request-> electrico;
        $Electrico -> sistema_carga_bateria             = $electrico['sistemaCargaBateria'];
        $Electrico -> cables_conexiones_fusibles        = $electrico['cablesConexionesFusibles'];
        $Electrico -> faros                             = $electrico['faros'];
        $Electrico -> faro_izquierda                    = $electrico['faIzq'];
        $Electrico -> faro_derecha                      = $electrico['faDer'];
        $Electrico -> cuartos                           = $electrico['cuartos'];
        $Electrico -> cuarto_derecha                    = $electrico['cuDer'];
        $Electrico -> cuarto_izquierda                  = $electrico['cuIzq'];
        $Electrico -> reversa_frenos                    = $electrico['frenosReversa'];
        $Electrico -> direccionales                     = $electrico['direccionales'];
        $Electrico -> direccionales_izquierda_delantera = $electrico['diIF'];
        $Electrico -> direccionales_izquierda_trasera   = $electrico['diIT'];
        $Electrico -> direccionales_derecha_delantera   = $electrico['diDF'];
        $Electrico -> direccionales_derecha_trasera     = $electrico['diDT'];
        $Electrico -> intermitentes                     = $electrico['intermitentes'];

        $frenos = $request -> frenos;
        $Frenos -> pastillas_izquierda_delantera              = $frenos['pIzquierdoDelantero'];
        $Frenos -> rotores_izquierda_delantera                = $frenos['rIzquierdoDelantero'];
        $Frenos -> pastillas_derecha_delantera                = $frenos['pDerechaDelantero'];
        $Frenos -> rotores_derecha_delantera                  = $frenos['rDerechaDelantero'];
        $Frenos -> pastillas_izquierda_trasera                = $frenos['pIzquierdoTrasera'];
        $Frenos -> rotores_izquierda_trasera                  = $frenos['rIzquierdoTrasera'];
        $Frenos -> pastillas_derecha_trasera                  = $frenos['pDerechaTrasera'];
        $Frenos -> rotores_derecha_trasera                    = $frenos['rDerechaTrasera'];
        $Frenos -> pinzas_cilindros_rueda_izquierda_delantera = $frenos['pCRIzquierdaDelantera'];
        $Frenos -> pinzas_cilindros_rueda_derecha_delantera   = $frenos['pCRDerechaDelantera'];
        $Frenos -> pinzas_cilindros_rueda_izquierda_trasera   = $frenos['pCRIzquierdaTrasera'];
        $Frenos -> pinzas_cilindros_rueda_derecha_trasera     = $frenos['pCRDerechaTrasera'];

        $trenTransmision = $request-> trenTransmision;
        $TrenTransmision -> filtro_transmison                  = $trenTransmision['filtroTransmision'];
        $TrenTransmision -> union_transmision_clutch           = $trenTransmision['unionTransmisiónCluth'];
        $TrenTransmision -> eje_traccion_juntas_homocineticas  = $trenTransmision['ejeTracciónJuntasHomocinéticas'];
        $TrenTransmision -> eje_transmision_juntas_universales = $trenTransmision['ejeTransmisiónJuntasUniversales'];
        $TrenTransmision -> rodamientos_rueda                  = $trenTransmision['rodamientosRueda'];
        $TrenTransmision -> tren_transmision                   = $trenTransmision['tTransmision'];
        $TrenTransmision -> clutch                             = $trenTransmision['cluth'];
        $TrenTransmision -> tren_notas                         = $trenTransmision['tTNotas'];

        $suspencionDireccion = $request -> suspensionDireccion;
        $SuspencionDireccion -> amortiguadores_suspencion = $suspencionDireccion['amortiguadoresSuspension'];
        $SuspencionDireccion -> juntas_direccion_rotulas  = $suspencionDireccion['juntasDirecciónRotulas'];
        $SuspencionDireccion -> suspencion_notas          = $suspencionDireccion['sDNotas'];


        $escape = $request -> escape;
        $Escape -> mofle_convertidor_catlitico = $escape['mofleConvertidorCatlitico'];
        $Escape -> sensores_soporte_tubos      = $escape['sensoresSoportesTubos'];
        $Escape -> escape_notas                = $escape['eNotas'];


        $Escape                    -> save();
        $SuspencionDireccion       -> save();
        $TrenTransmision           -> save();
        $Electrico                 -> save();
        $AfinacionMotor            -> save();
        $Seguridad                 -> save();
        $Filtros                   -> save();
        $Liquidos                  -> save();
        $Llantas                   -> save();
        $Mangueras                 -> save();
        $RevisionLucesEspias       -> save();
        $Frenos                    -> save();
        $Bandas                    -> save();



        $inspeccionTecnicaVehiculo = $request -> inspeccionTecnicaVehiculo;
        $InspeccionTecnicaVehiculo -> orden_seguimiento   = (int)$inspeccionTecnicaVehiculo['orden_seguimiento'];
        $InspeccionTecnicaVehiculo -> id_llantas               = $Llantas->id;
        $InspeccionTecnicaVehiculo -> id_liquidos              = $Liquidos->id;
        $InspeccionTecnicaVehiculo -> id_bandas                = $Bandas->id;
        $InspeccionTecnicaVehiculo -> id_seguridad             = $Seguridad->id;
        $InspeccionTecnicaVehiculo -> id_filtros               = $Filtros->id;
        $InspeccionTecnicaVehiculo -> id_escape                = $Escape->id;
        $InspeccionTecnicaVehiculo -> id_suspencion_direccion  = $SuspencionDireccion->id;
        $InspeccionTecnicaVehiculo -> id_afinacion_motor       = $AfinacionMotor->id;
        $InspeccionTecnicaVehiculo -> id_tren_transmision      = $TrenTransmision->id;
        $InspeccionTecnicaVehiculo -> id_frenos                = $Frenos->id;
        $InspeccionTecnicaVehiculo -> id_electrico             = $Electrico->id;
        $InspeccionTecnicaVehiculo -> id_revision_luces_espias = $RevisionLucesEspias->id;
        $InspeccionTecnicaVehiculo -> id_mangueras             = $Mangueras->id;
        $InspeccionTecnicaVehiculo -> indicaciones_cliente     = $inspeccionTecnicaVehiculo['indicacionesCliente'];
        $InspeccionTecnicaVehiculo -> fecha                    = Carbon::parse($inspeccionTecnicaVehiculo['iFecha'])->timezone('America/Mexico_City')->toDateTimeString();

        //guardar imagen de firma
        $img = $inspeccionTecnicaVehiculo['anteFirma'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $nombreImagen = (int)$inspeccionTecnicaVehiculo['orden_seguimiento'] . '_' . date("YmdHis");
        file_put_contents(public_path().'/img/firmas/'.$nombreImagen . '.jpg',$data);
        $InspeccionTecnicaVehiculo['ante_firma'] = $nombreImagen . '.jpg';

        $InspeccionTecnicaVehiculo -> save();



        return '1';

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\InspeccionTecnicaVehiculo  $inspeccionTecnicaVehiculo
     * @return \Illuminate\Http\Response
     */
    public function show($getDatum)
    {
        $RecepcionVehicular = new RecepcionVehicular;
        $empresa = new Empresa;
        $cliente = new Cliente;
        $Vehiculo = new Vehiculo;
        $marca = new Marca;
        $modelo = new Modelo;

        $data = array(
            'orden_seguimiento' => $getDatum,
            "fecha" => "",
            "nombre"=> "",
            "telefono"=> "",
            "Vehic"=> "",
            "marca"=> "",
            "modelo"=> "",
            "anio"=> "",
            "placas"=> "",
            "kilometraje"=> "",
            "vin"=> "",
            "economico"=> ""
        );

        $res = $RecepcionVehicular->where('orden_seguimiento','=',$getDatum)->first();
        $time = new DateTime($res->fecha);
        $data['fecha'] = $time->format('Y-m-d\Th:i:s\Z');
        $data['kilometraje'] = $res->km_entrada;

        if($res->empresa_id){
            $r = $empresa->where('id','=', $res->empresa_id)->first();
            $data['nombre'] = $r->nombre;
            $data['telefono'] = $r->tel_negocio;
        }else{
            $r = $cliente->where('id', '=', $res->customer_id)->first();
            $data['cliente'] = $r->nombre;
            $data['telefono'] = $r->tel_celular;
        }

        $r = $Vehiculo->where('id', '=', $res->vehiculo_id)->first();
        $data['placas'] = $r->placas;
        $data['vin'] = $r->vim;
        $data['economico'] = $r->no_economico;
        $data['anio'] = $r->anio;
        $data['modelo'] = $r->modelo_id;

        $r = $marca->where('id','=',$r->marca_id)->first();
        $data['marca'] = $r->nombre;
        $r = $modelo->where('id','=',$data['modelo'])->first();
        $data['modelo'] = $r->nombre;
        $data['Vehic'] = $data['marca'].",".$data['modelo'].",".$data['anio'];

        return json_encode($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InspeccionTecnicaVehiculo  $inspeccionTecnicaVehiculo
     * @return \Illuminate\Http\Response
     */
    public function edit(InspeccionTecnicaVehiculo $InspeccionTecnicaVehiculo)
    {

        $id = $InspeccionTecnicaVehiculo->id;
        $inspeccionTecnicaVehiculo = $InspeccionTecnicaVehiculo
            ->join('recepcion_vehicular', 'inspeccion_tecnica_vehiculo.orden_seguimiento', 'recepcion_vehicular.orden_seguimiento')
            ->join('revision_luces_espias', 'inspeccion_tecnica_vehiculo.id_revision_luces_espias', 'revision_luces_espias.id')
            ->join('mangueras', 'inspeccion_tecnica_vehiculo.id_mangueras', 'mangueras.id')
            ->join('llantas', 'inspeccion_tecnica_vehiculo.id_llantas', 'llantas.id')
            ->join('liquidos', 'inspeccion_tecnica_vehiculo.id_liquidos', 'liquidos.id')
            ->join('bandas', 'inspeccion_tecnica_vehiculo.id_bandas', 'bandas.id')
            ->join('filtros', 'inspeccion_tecnica_vehiculo.id_filtros', 'filtros.id')
            ->join('seguridad', 'inspeccion_tecnica_vehiculo.id_seguridad', 'seguridad.id')
            ->join('afinacion_motor', 'inspeccion_tecnica_vehiculo.id_afinacion_motor', 'afinacion_motor.id')
            ->join('electrico', 'inspeccion_tecnica_vehiculo.id_electrico', 'electrico.id')
            ->join('frenos', 'inspeccion_tecnica_vehiculo.id_frenos', 'frenos.id')
            ->join('tren_transmision', 'inspeccion_tecnica_vehiculo.id_tren_transmision', 'tren_transmision.id')
            ->join('suspencion_direccion', 'inspeccion_tecnica_vehiculo.id_suspencion_direccion', 'suspencion_direccion.id')
            ->join('escape', 'inspeccion_tecnica_vehiculo.id_escape', 'escape.id')
            ->join('users', 'recepcion_vehicular.usuario_id','users.id')
            ->select('inspeccion_tecnica_vehiculo.*', 'inspeccion_tecnica_vehiculo.fecha','revision_luces_espias.*', 'mangueras.*', 'llantas.*', 'liquidos.*', 'bandas.*', 'filtros.*', 'seguridad.*', 'afinacion_motor.*', 'electrico.*', 'frenos.*', 'tren_transmision.*', 'suspencion_direccion.*', 'escape.*', 'users.*')
            ->get();
        $recepcion = json_decode(self::show($InspeccionTecnicaVehiculo->orden_seguimiento));

        $time = new DateTime($inspeccionTecnicaVehiculo[0]->fecha);

        $data = [
            "modeloInspeccion" => [
                "id" => $id,
                "rFecha" => $recepcion->fecha,
                "nombre" => $recepcion->nombre,
                "telefono" => $recepcion->telefono,
                "Vehic" => $recepcion->Vehic,
                "placas" => $recepcion->placas,
                "kilometraje" => $recepcion->kilometraje,
                "vin" => $recepcion->vin,
                "economico" => $recepcion->economico,
                "user" => $inspeccionTecnicaVehiculo[0]->name,
                "inspeccionTecnicaVehiculo" => [
                    "orden_seguimiento" => $recepcion->orden_seguimiento,
                    "indicacionesCliente" => $inspeccionTecnicaVehiculo[0]->indicaciones_cliente,
                    "anteFirma" => $inspeccionTecnicaVehiculo[0]->ante_firma,
                    "iFecha" => $time->format('Y-m-d\Th:i:s\Z')
                ],
                "revisionLucesEspias" => [
                    "codigo" => $inspeccionTecnicaVehiculo[0]->codigo
                ],
                "mangueras" => [
                    "mRefrigerante" => $inspeccionTecnicaVehiculo[0]->refrigerante,
                    "direccionAireAcondic" => $inspeccionTecnicaVehiculo[0]->direccion_aire_acondicionado,
                    "calefaccion" => $inspeccionTecnicaVehiculo[0]->calefaccion
                ],
                "llantas" => [
                    "dIDelantera" => $inspeccionTecnicaVehiculo[0]->izquierda_delantera,
                    "pIDelantera" => $inspeccionTecnicaVehiculo[0]->izquierda_delantera_presion,
                    "dITrasera" => $inspeccionTecnicaVehiculo[0]->izquierda_trasera,
                    "pITrasera" => $inspeccionTecnicaVehiculo[0]->izquierda_trasera_presion,
                    "dDDelantera" => $inspeccionTecnicaVehiculo[0]->derecha_delantera,
                    "pDDdelantera" => $inspeccionTecnicaVehiculo[0]->derecha_delantera_presion,
                    "dDTrasera" => $inspeccionTecnicaVehiculo[0]->derecha_trasera,
                    "pDTrasera" => $inspeccionTecnicaVehiculo[0]->derecha_trasera_presion,
                    "dRefaccion" => $inspeccionTecnicaVehiculo[0]->refaccion,
                    "pRefaccion" => $inspeccionTecnicaVehiculo[0]->refaccion_presion,
                    "alineacionBalanceo" => $inspeccionTecnicaVehiculo[0]->alineacion_balanceo
                ],
                "liquidos" => [
                    "aceiteMotor" => $inspeccionTecnicaVehiculo[0]->aceite_motor,
                    "transmision" => $inspeccionTecnicaVehiculo[0]->transmision,
                    "diferencialft" => $inspeccionTecnicaVehiculo[0]->diferencial_frente_trasero,
                    "lRefrigerante" => $inspeccionTecnicaVehiculo[0]->liquido_refrigerante,
                    "frenos" => $inspeccionTecnicaVehiculo[0]->frenos,
                    "direccionHidraulica" => $inspeccionTecnicaVehiculo[0]->direccion_hidraulica,
                    "limpiaparabrisas" => $inspeccionTecnicaVehiculo[0]->limpiaparabrisas,
                    "lNotas" => $inspeccionTecnicaVehiculo[0]->liquido_notas,
                    "aMOK" => $inspeccionTecnicaVehiculo[0]->aceite_motor_ok,
                    "aMLleno" => $inspeccionTecnicaVehiculo[0]->aceite_motor_lleno,
                    "tOK" => $inspeccionTecnicaVehiculo[0]->transmision_ok,
                    "tLleno" => $inspeccionTecnicaVehiculo[0]->transmision_lleno,
                    "dOK" => $inspeccionTecnicaVehiculo[0]->diferencial_frente_trasero_ok,
                    "dLleno" => $inspeccionTecnicaVehiculo[0]->diferencial_frente_trasero_lleno,
                    "reOK" => $inspeccionTecnicaVehiculo[0]->refrigerante_ok,
                    "reLleno" => $inspeccionTecnicaVehiculo[0]->refrigerante_lleno,
                    "frOK" => $inspeccionTecnicaVehiculo[0]->frenos_ok,
                    "frLleno" => $inspeccionTecnicaVehiculo[0]->frenos_lleno,
                    "dHOK" => $inspeccionTecnicaVehiculo[0]->direccion_hidraulica_ok,
                    "dHLleno" => $inspeccionTecnicaVehiculo[0]->direccion_hidraulica_lleno,
                    "liOK" => $inspeccionTecnicaVehiculo[0]->limpiaparabrisas_ok,
                    "liLleno" => $inspeccionTecnicaVehiculo[0]->limpiaparabrisas_lleno
                ],
                "bandas" => [
                    "accesorios" => $inspeccionTecnicaVehiculo[0]->accesorios,
                    "bDireccionHidraulica" => $inspeccionTecnicaVehiculo[0]->bandas_direccion_hidraulica,
                    "alternadorAAcondic" => $inspeccionTecnicaVehiculo[0]->alternador_aire_acondicionado,
                ],
                "filtros" => [
                    "aire" => $inspeccionTecnicaVehiculo[0]->aire,
                    "combustible" => $inspeccionTecnicaVehiculo[0]->combustible,
                    "aceite" => $inspeccionTecnicaVehiculo[0]->aceite,
                    "fNotas" => $inspeccionTecnicaVehiculo[0]->filtro_notas
                ],
                "seguridad" => [
                    "frenoEmergencia" => $inspeccionTecnicaVehiculo[0]->frenos_emergencia,
                    "lpIzqDer" => $inspeccionTecnicaVehiculo[0]->limpiaparabrisas_izquierdo_derecho,
                    "lpiTrasero" => $inspeccionTecnicaVehiculo[0]->limpiaparabrisas_trasero,
                    "lpNotas" => $inspeccionTecnicaVehiculo[0]->seguridad_notas,
                ],
                "afinacionMotor" => [
                    "tapadistribuidorBujíasCables" => $inspeccionTecnicaVehiculo[0]->tapa_distribuidor_bujias_cables,
                    "fuelInjection" => $inspeccionTecnicaVehiculo[0]->fuel_injection,
                ],
                "electrico" => [
                    "sistemaCargaBateria" => $inspeccionTecnicaVehiculo[0]->sistema_carga_bateria,
                    "cablesConexionesFusibles" => $inspeccionTecnicaVehiculo[0]->cables_conexiones_fusibles,
                    "faros" => $inspeccionTecnicaVehiculo[0]->faros,
                    "faIzq" => $inspeccionTecnicaVehiculo[0]->faro_izquierda,
                    "faDer" => $inspeccionTecnicaVehiculo[0]->faro_derecha,
                    "cuartos" => $inspeccionTecnicaVehiculo[0]->cuartos,
                    "cuDer" => $inspeccionTecnicaVehiculo[0]->cuarto_derecha,
                    "cuIzq" => $inspeccionTecnicaVehiculo[0]->cuarto_izquierda,
                    "frenosReversa" => $inspeccionTecnicaVehiculo[0]->reversa_frenos,
                    "direccionales" => $inspeccionTecnicaVehiculo[0]->direccionales,
                    "diIF" => $inspeccionTecnicaVehiculo[0]->direccionales_izquierda_delantera,
                    "diIT" => $inspeccionTecnicaVehiculo[0]->direccionales_izquierda_trasera,
                    "diDF" => $inspeccionTecnicaVehiculo[0]->direccionales_derecha_delantera,
                    "diDT" => $inspeccionTecnicaVehiculo[0]->direccionales_derecha_trasera,
                    "intermitentes" => $inspeccionTecnicaVehiculo[0]->intermitentes
                ],
                "frenos" => [
                    "pIzquierdoDelantero" => $inspeccionTecnicaVehiculo[0]->pastillas_izquierda_delantera,
                    "rIzquierdoDelantero" => $inspeccionTecnicaVehiculo[0]->rotores_izquierda_delantera,
                    "pDerechaDelantero" => $inspeccionTecnicaVehiculo[0]->pastillas_derecha_delantera,
                    "rDerechaDelantero" => $inspeccionTecnicaVehiculo[0]->rotores_derecha_delantera,
                    "pIzquierdoTrasera" => $inspeccionTecnicaVehiculo[0]->pastillas_izquierda_trasera,
                    "rIzquierdoTrasera" => $inspeccionTecnicaVehiculo[0]->rotores_izquierda_trasera,
                    "pDerechaTrasera" => $inspeccionTecnicaVehiculo[0]->pastillas_derecha_trasera,
                    "rDerechaTrasera" => $inspeccionTecnicaVehiculo[0]->rotores_derecha_trasera,
                    "pCRIzquierdaDelantera" => $inspeccionTecnicaVehiculo[0]->pinzas_cilindros_rueda_izquierda_delantera,
                    "pCRDerechaDelantera" => $inspeccionTecnicaVehiculo[0]->pinzas_cilindros_rueda_derecha_delantera,
                    "pCRIzquierdaTrasera" => $inspeccionTecnicaVehiculo[0]->pinzas_cilindros_rueda_izquierda_trasera,
                    "pCRDerechaTrasera" => $inspeccionTecnicaVehiculo[0]->pinzas_cilindros_rueda_derecha_trasera
                ],
                "trenTransmision" => [
                    "filtroTransmision" => $inspeccionTecnicaVehiculo[0]->filtro_transmison,
                    "unionTransmisiónCluth" => $inspeccionTecnicaVehiculo[0]->union_transmision_clutch,
                    "ejeTracciónJuntasHomocinéticas" => $inspeccionTecnicaVehiculo[0]->eje_traccion_juntas_homocineticas,
                    "ejeTransmisiónJuntasUniversales" => $inspeccionTecnicaVehiculo[0]->eje_transmision_juntas_universales,
                    "rodamientosRueda" => $inspeccionTecnicaVehiculo[0]->rodamientos_rueda,
                    "tTransmision" => $inspeccionTecnicaVehiculo[0]->tren_transmision,
                    "cluth" => $inspeccionTecnicaVehiculo[0]->clutch,
                    "tTNotas" => $inspeccionTecnicaVehiculo[0]->tren_notas
                ],
                "suspensionDireccion" => [
                    "amortiguadoresSuspension" => $inspeccionTecnicaVehiculo[0]->amortiguadores_suspencion,
                    "juntasDirecciónRotulas" => $inspeccionTecnicaVehiculo[0]->juntas_direccion_rotulas,
                    "sDNotas" => $inspeccionTecnicaVehiculo[0]->suspencion_notas
                ],
                "escape" => [
                    "mofleConvertidorCatlitico" => $inspeccionTecnicaVehiculo[0]->mofle_convertidor_catlitico,
                    "sensoresSoportesTubos" => $inspeccionTecnicaVehiculo[0]->sensores_soporte_tubos,
                    "eNotas" => $inspeccionTecnicaVehiculo[0]->escape_notas
                ]

            ]
        ];

        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InspeccionTecnicaVehiculo  $inspeccionTecnicaVehiculo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InspeccionTecnicaVehiculo $inspeccionTecnicaVehiculo)
    {
        $RevisionLucesEspias = new RevisionLucesEspias;
        $Mangueras = new Mangueras;
        $Llantas = new Llantas;
        $Liquidos = new Liquidos;
        $Bandas = new Bandas;
        $Filtros = new Filtros;
        $Seguridad = new Seguridad;
        $AfinacionMotor = new AfinacionMotor;
        $Electrico = new Electrico;
        $Frenos = new Frenos;
        $TrenTransmision = new TrenTransmision;
        $SuspencionDireccion = new SuspencionDireccion;
        $Escape = new Escape;
        $InspeccionTecnicaVehiculo = new InspeccionTecnicaVehiculo;

        $idInspeccion = $request->id;

        $res = $inspeccionTecnicaVehiculo->where('id',$idInspeccion)->first();
        
        $InspeccionTecnicaVehiculo = $res;

        if($request->modeloInspeccion['inspeccionTecnicaVehiculo']['anteFirma'] == ''){
            $InspeccionTecnicaVehiculo->ante_firma = '';
        }else{
            $InspeccionTecnicaVehiculo->ante_firma = $request->modeloInspeccion['inspeccionTecnicaVehiculo']['anteFirma'];
        }

        if($request->modeloInspeccion['inspeccionTecnicaVehiculo']['indicacionesCliente'] == ''){
            $InspeccionTecnicaVehiculo->indicaciones_cliente = '';
        }else{
            $InspeccionTecnicaVehiculo->indicaciones_cliente = $request->modeloInspeccion['inspeccionTecnicaVehiculo']['indicacionesCliente'];
        }
        
        $InspeccionTecnicaVehiculo->fecha	             = Carbon::parse($request->modeloInspeccion['inspeccionTecnicaVehiculo']['iFecha'])->timezone('America/Mexico_City')->toDateTimeString();
        $InspeccionTecnicaVehiculo->save();                

        if($request->revisionLucesEspias){
            $RevisionLucesEspias->id     = $res->id_revision_luces_espias;
            $RevisionLucesEspias->codigo = $request->modeloInspeccion['revisionLucesEspias']['codigo'];
            $RevisionLucesEspias->save();
        }

        if($request->modeloInspeccion['mangueras']){
            $Mangueras = $Mangueras->where('id',$res->id_mangueras)->first();
            $Mangueras->refrigerante                 = $request->modeloInspeccion['mangueras']['mRefrigerante'];
            $Mangueras->direccion_aire_acondicionado = $request->modeloInspeccion['mangueras']['direccionAireAcondic'];
            $Mangueras->calefaccion                  = $request->modeloInspeccion['mangueras']['calefaccion'];
            $Mangueras->save();
        }

        if($request->modeloInspeccion['llantas']){
            $Llantas = $Llantas->where('id',$res->id_llantas)->first();
            $Llantas->izquierda_delantera         = $request->modeloInspeccion['llantas']['dIDelantera'];
            $Llantas->izquierda_delantera_presion = $request->modeloInspeccion['llantas']['pIDelantera'];
            $Llantas->izquierda_trasera           = $request->modeloInspeccion['llantas']['dITrasera'];
            $Llantas->izquierda_trasera_presion   = $request->modeloInspeccion['llantas']['pITrasera'];
            $Llantas->derecha_delantera           = $request->modeloInspeccion['llantas']['dDDelantera'];
            $Llantas->derecha_delantera_presion   = $request->modeloInspeccion['llantas']['pDDdelantera'];
            $Llantas->derecha_trasera             = $request->modeloInspeccion['llantas']['dDTrasera'];
            $Llantas->derecha_trasera_presion     = $request->modeloInspeccion['llantas']['pDTrasera'];
            $Llantas->refaccion                   = $request->modeloInspeccion['llantas']['dRefaccion'];
            $Llantas->refaccion_presion           = $request->modeloInspeccion['llantas']['pRefaccion'];
            $Llantas->alineacion_balanceo         = $request->modeloInspeccion['llantas']['alineacionBalanceo'];
            $Llantas->save();
        }

        if($request->modeloInspeccion['liquidos']){
            $Liquidos = $Liquidos->where('id', $res->id_liquidos)->first();
            $Liquidos->aceite_motor                     = $request->modeloInspeccion['liquidos']['aceiteMotor'];
            $Liquidos->aceite_motor_ok                  = $request->modeloInspeccion['liquidos']['aMOK'];
            $Liquidos->aceite_motor_lleno               = $request->modeloInspeccion['liquidos']['aMLleno'];
            $Liquidos->transmision                      = $request->modeloInspeccion['liquidos']['transmision'];
            $Liquidos->transmision_ok                   = $request->modeloInspeccion['liquidos']['tOK'];
            $Liquidos->transmision_lleno                = $request->modeloInspeccion['liquidos']['tLleno'];
            $Liquidos->diferencial_frente_trasero       = $request->modeloInspeccion['liquidos']['diferencialft'];
            $Liquidos->diferencial_frente_trasero_ok    = $request->modeloInspeccion['liquidos']['dOK'];
            $Liquidos->diferencial_frente_trasero_lleno = $request->modeloInspeccion['liquidos']['dLleno'];
            $Liquidos->liquido_refrigerante             = $request->modeloInspeccion['liquidos']['lRefrigerante'];
            $Liquidos->refrigerante_ok                  = $request->modeloInspeccion['liquidos']['reOK'];
            $Liquidos->refrigerante_lleno               = $request->modeloInspeccion['liquidos']['reLleno'];
            $Liquidos->frenos                           = $request->modeloInspeccion['liquidos']['frenos'];
            $Liquidos->frenos_ok                        = $request->modeloInspeccion['liquidos']['frOK'];
            $Liquidos->frenos_lleno                     = $request->modeloInspeccion['liquidos']['frLleno'];
            $Liquidos->direccion_hidraulica             = $request->modeloInspeccion['liquidos']['direccionHidraulica'];
            $Liquidos->direccion_hidraulica_ok          = $request->modeloInspeccion['liquidos']['dHOK'];
            $Liquidos->direccion_hidraulica_lleno       = $request->modeloInspeccion['liquidos']['dHLleno'];
            $Liquidos->limpiaparabrisas                 = $request->modeloInspeccion['liquidos']['limpiaparabrisas'];
            $Liquidos->limpiaparabrisas_ok              = $request->modeloInspeccion['liquidos']['liOK'];
            $Liquidos->limpiaparabrisas_lleno           = $request->modeloInspeccion['liquidos']['liLleno'];
            $Liquidos->liquido_notas                    = $request->modeloInspeccion['liquidos']['lNotas'];
            $Liquidos->save();
        }

        if($request->modeloInspeccion['bandas']){
            $Bandas = $Bandas->where('id',$res->id_bandas)->first();
            $Bandas->accesorios                    = $request->modeloInspeccion['bandas']['accesorios'];
            $Bandas->bandas_direccion_hidraulica   = $request->modeloInspeccion['bandas']['bDireccionHidraulica'];
            $Bandas->alternador_aire_acondicionado = $request->modeloInspeccion['bandas']['alternadorAAcondic'];
            $Bandas->save();
        }

        if($request->modeloInspeccion['filtros']){
            $Filtros = $Filtros->where('id',$res->id_filtros)->first();
            $Filtros->aire         = $request->modeloInspeccion['filtros']['aire'];
            $Filtros->combustible  = $request->modeloInspeccion['filtros']['combustible'];
            $Filtros->aceite       = $request->modeloInspeccion['filtros']['aceite'];
            $Filtros->filtro_notas = $request->modeloInspeccion['filtros']['fNotas'];
            $Filtros->save();
        }

        if($request->modeloInspeccion['seguridad']){
            $Seguridad = $Seguridad->where('id',$res->id_seguridad)->first();
            $Seguridad->frenos_emergencia                  = $request->modeloInspeccion['seguridad']['frenoEmergencia'];
            $Seguridad->limpiaparabrisas_izquierdo_derecho = $request->modeloInspeccion['seguridad']['lpIzqDer'];
            $Seguridad->limpiaparabrisas_trasero           = $request->modeloInspeccion['seguridad']['lpiTrasero'];
            $Seguridad->seguridad_notas                    = $request->modeloInspeccion['seguridad']['lpNotas'];
            $Seguridad->save();
        }

        if($request->modeloInspeccion['afinacionMotor']){
            $AfinacionMotor = $AfinacionMotor->where('id', $res->id_afinacion_motor)->first();
            $AfinacionMotor->tapa_distribuidor_bujias_cables = $request->modeloInspeccion['afinacionMotor']['tapadistribuidorBujíasCables'];
            $AfinacionMotor->fuel_injection                  = $request->modeloInspeccion['afinacionMotor']['fuelInjection'];
            $AfinacionMotor->save();
        }

        if($request->modeloInspeccion['electrico']){
            $Electrico = $Electrico->where('id', $res->id_electrico)->first();
            $Electrico->sistema_carga_bateria             = $request->modeloInspeccion['electrico']['sistemaCargaBateria'];
            $Electrico->cables_conexiones_fusibles        = $request->modeloInspeccion['electrico']['cablesConexionesFusibles'];
            $Electrico->faros                             = $request->modeloInspeccion['electrico']['faros'];
            $Electrico->faro_izquierda                    = $request->modeloInspeccion['electrico']['faIzq'];
            $Electrico->faro_derecha                      = $request->modeloInspeccion['electrico']['faDer'];
            $Electrico->cuartos                           = $request->modeloInspeccion['electrico']['cuartos']; 
            $Electrico->cuarto_derecha                    = $request->modeloInspeccion['electrico']['cuDer'];    
            $Electrico->cuarto_izquierda                  = $request->modeloInspeccion['electrico']['cuIzq'];
            $Electrico->reversa_frenos                     = $request->modeloInspeccion['electrico']['frenosReversa'];
            $Electrico->direccionales                     = $request->modeloInspeccion['electrico']['direccionales'];
            $Electrico->direccionales_izquierda_delantera = $request->modeloInspeccion['electrico']['diIF'];
            $Electrico->direccionales_derecha_delantera   = $request->modeloInspeccion['electrico']['diDF'];
            $Electrico->direccionales_izquierda_trasera   = $request->modeloInspeccion['electrico']['diIT'];
            $Electrico->direccionales_derecha_trasera     = $request->modeloInspeccion['electrico']['diDT'];
            $Electrico->intermitentes                     = $request->modeloInspeccion['electrico']['intermitentes'];
            $Electrico->save();
        }

        if($request->modeloInspeccion['frenos']){
            $Frenos = $Frenos->where('id', $res->id_frenos)->first();
            $Frenos->pastillas_izquierda_delantera              = $request->modeloInspeccion['frenos']['pIzquierdoDelantero'];
            $Frenos->pastillas_izquierda_trasera                = $request->modeloInspeccion['frenos']['pIzquierdoTrasera'];
            $Frenos->pastillas_derecha_delantera                = $request->modeloInspeccion['frenos']['pDerechaDelantero'];
            $Frenos->pastillas_derecha_trasera                  = $request->modeloInspeccion['frenos']['pDerechaTrasera'];
            $Frenos->rotores_izquierda_delantera	            = $request->modeloInspeccion['frenos']['rIzquierdoDelantero'];
            $Frenos->rotores_izquierda_trasera                  = $request->modeloInspeccion['frenos']['rIzquierdoTrasera'];
            $Frenos->rotores_derecha_delantera                  = $request->modeloInspeccion['frenos']['rDerechaDelantero'];
            $Frenos->rotores_derecha_trasera                    = $request->modeloInspeccion['frenos']['rDerechaTrasera'];
            $Frenos->pinzas_cilindros_rueda_izquierda_delantera = $request->modeloInspeccion['frenos']['pCRIzquierdaDelantera'];
            $Frenos->pinzas_cilindros_rueda_izquierda_trasera   = $request->modeloInspeccion['frenos']['pCRIzquierdaTrasera'];
            $Frenos->pinzas_cilindros_rueda_derecha_delantera   = $request->modeloInspeccion['frenos']['pCRDerechaDelantera'];
            $Frenos->pinzas_cilindros_rueda_derecha_trasera     = $request->modeloInspeccion['frenos']['pCRDerechaTrasera'];
            $Frenos->save();
        }

        if($request->modeloInspeccion['trenTransmision']){
            $TrenTransmision = $TrenTransmision->where('id', $res->id_tren_transmision)->first();
            $TrenTransmision->filtro_transmison                  = $request->modeloInspeccion['trenTransmision']['filtroTransmision'];
            $TrenTransmision->union_transmision_clutch           = $request->modeloInspeccion['trenTransmision']['unionTransmisiónCluth'];
            $TrenTransmision->eje_traccion_juntas_homocineticas  = $request->modeloInspeccion['trenTransmision']['ejeTracciónJuntasHomocinéticas'];
            $TrenTransmision->eje_transmision_juntas_universales = $request->modeloInspeccion['trenTransmision']['ejeTransmisiónJuntasUniversales'];
            $TrenTransmision->rodamientos_rueda                  = $request->modeloInspeccion['trenTransmision']['rodamientosRueda'];
            $TrenTransmision->tren_transmision                   = $request->modeloInspeccion['trenTransmision']['tTransmision'];
            $TrenTransmision->clutch                             = $request->modeloInspeccion['trenTransmision']['cluth'];
            $TrenTransmision->tren_notas                         = $request->modeloInspeccion['trenTransmision']['tTNotas'];
            $TrenTransmision->save();
        }

        if($request->modeloInspeccion['suspensionDireccion']){
            $SuspencionDireccion = $SuspencionDireccion->where('id', $res->id_suspencion_direccion)->first();
            $SuspencionDireccion->amortiguadores_suspencion = $request->modeloInspeccion['suspensionDireccion']['amortiguadoresSuspension'];
            $SuspencionDireccion->juntas_direccion_rotulas  = $request->modeloInspeccion['suspensionDireccion']['juntasDirecciónRotulas'];
            $SuspencionDireccion->suspencion_notas          = $request->modeloInspeccion['suspensionDireccion']['sDNotas'];
            $SuspencionDireccion->save();
        }

        if($request->modeloInspeccion['escape']){
            $Escape = $Escape->where('id', $res->id_escape)->first();
            $Escape->mofle_convertidor_catlitico = $request->modeloInspeccion['escape']['mofleConvertidorCatlitico'];
            $Escape->sensores_soporte_tubos      = $request->modeloInspeccion['escape']['sensoresSoportesTubos'];
            $Escape->escape_notas                = $request->modeloInspeccion['escape']['eNotas'];
            $ok = $Escape->save();
        }
        if($ok){
            return ['estado'=>true];
        }
        return ['estado'=>false];
    }

    public function reporte(Request $request)
    {
        $InspeccionTecnicaVehiculo = new InspeccionTecnicaVehiculo();
        $inspeccionTecnicaVehiculo = $InspeccionTecnicaVehiculo->where('id','=',$request->id)->first();
        $reporte = self::edit($inspeccionTecnicaVehiculo);

        return View::make('reportes.inspeccionVehiculo') -> with('reporte', $reporte);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InspeccionTecnicaVehiculo  $inspeccionTecnicaVehiculo
     * @return \Illuminate\Http\Response
     */
    public function destroy(InspeccionTecnicaVehiculo $inspeccionTecnicaVehiculo)
    {
        //
    }
}
