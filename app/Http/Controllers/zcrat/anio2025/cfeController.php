<?php

namespace App\Http\Controllers\zcrat\anio2025;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RecepcionVehicular;
use App\Models\Modulo;
use App\Models\AnioCorrespondiente;
use App\Models\Empresa;
use App\Models\Color;
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
use App\HojaConcepto;
use App\EntradasSalidas;
use App\OrdenesPagadas;


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
        $anio = AnioCorrespondiente::where('descripcion', '2024')->value('id');;
        $elementostotales = RecepcionVehicular::where("sucursal_id",'=',$sucu)->where("modulo",$modulo)->where("id_anio_correspondiente",$anio)->count();
        return view('cfe.2025.recepcion',compact('elementostotales','modulo','anio','Regimenes','empresas'));
    }
    public function vistarecepcionbajio(){
        $Regimenes=$this->Regimenes;
        $empresas=Empresa::select('id','nombre')->get();
        $sucu = \Auth::user()->sucursal_id;
        $modulo = Modulo::where('descripcion', 'CFE BAJIO')->value('id');;
        $anio = AnioCorrespondiente::where('descripcion', '2024')->value('id');;
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
        
        $sucu = \Auth::user()->sucursal_id;
        $modulo = $request->input('modulo'); // 'valor_modulo'
        $anio = $request->input('anio');     // '2024'
        $recepciones = RecepcionVehicular::where("sucursal_id",'=',$sucu)->where("modulo",$modulo)->where("id_anio_correspondiente",$anio)->orderBy('id', 'desc')->get();
        return response()->json([
            'recepciones' => $recepciones
        ]);
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

    public function nuevarecepcion (){
        $messages = [
            'ord_seguimiento.required' => 'La Orden de seguimiento es obligatoria.',
            'ord_seguimiento.max'=>'La Orden de seguimineto es muy larga',
            'ord_seguimiento.min'=>'La Orden de seguimineto es muy corta',
            'folio.max'=>'El Folio es muy largo',
            'folio.min'=>'El Folio es muy corto',
            'fecha.required' => 'La fecha es obligatoria.',
            'empresasrecepcion.exists'=> 'La Empresa no existe',
            'clientesrecepcion.required'=> 'El cliente es obligatorio',
            'clientesrecepcion'=> 'El cliente no existe',
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

            'fecha_esperada.required' => 'La fecha esperada es obligatoria.',
            'fecha_entrega.required' => 'La fecha de entrega es obligatoria.',
            // Mensajes personalizados para los campos de condición
            ...array_map(fn($field) => [
                "{$field}.required" => "El campo es obligatorio.",
                "{$field}.in" => "La opción seleccionada no es válida",
            ], [
                'pcondicion1', 'pcondicion2', 'pcondicion3', 'pcondicion4',
                'acondicion1', 'acondicion2', 'acondicion3', 'acondicion4',
                'condicion1', 'condicion2', 'condicion3', 'condicion4',
                'condicion5', 'condicion6', 'condicion7', 'condicion8',
                'condicion9', 'condicion10', 'condicion11', 'condicion12',
                'condicionext1', 'condicionext2', 'condicionext3', 'condicionext4',
                'condicionext5', 'condicionext6', 'condicionext7', 'condicionext8',
                'condicionext9', 'condicionext10'
            ]),
            
            // Mensajes para inventarios y pintura
            ...array_map(fn($i) => [
                "inventario{$i}.boolean" => "El campo  debe ser un valor booleano.",
                "conpintura{$i}.boolean" => "El campo  debe ser un valor booleano.",
            ], range(1, 12)),
        
            'notasadicionales.max' => 'las notas adicionales son muy grandes.',
            'indicacionescliente.max' => 'las indicaciones del cliente son muy largas.',
            'admintrasporte.max' => 'la información de administración de transporte es muy larga.',
            'jefedelproceso.max' => 'el nombre del jefe de proceso es muy largo.',
        ];
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
            'miCanvas' => 'nullable|mimes:png,jpg,jpeg',
            'canvasfirma' => 'nullable|mimes:png,jpg,jpeg',
            'fecha_esperada' => 'required|date',
            'fecha_entrega' => 'required|date',

            // Agrupar inventarios y pintura
            ...array_fill_keys(array_map(fn($i) => 'pcondicion' . $i, range(1, 4)), 'required|in:1,2,3,4,5'),
            ...array_fill_keys(array_map(fn($i) => 'acondicion' . $i, range(1, 4)), 'required|in:1,2,3,4,5'),
            ...array_fill_keys(array_map(fn($i) => 'condicion1' . $i, range(1, 12)), 'required|in:1,2,3,4,5'),
            ...array_fill_keys(array_map(fn($i) => 'condicionext' . $i, range(1, 10)), 'required|in:1,2,3,4,5'),
            ...array_fill_keys(array_map(fn($i) => 'inventario' . $i, range(1, 12)), 'nullable|boolean'),
            ...array_fill_keys(array_map(fn($i) => 'conpintura' . $i, range(1, 10)), 'nullable|boolean'),
        
            'notasadicionales' => 'nullable|string|max:500',
            'indicacionescliente' => 'nullable|string|max:500',
            'admintrasporte' => 'nullable|string|max:255',
            'jefedelproceso' => 'nullable|string|max:255',
        ]);
        $img = $request->input('miCanvas');
        $img2 = $request->input('canvasfirma');
        if (!$img) {
            return response()->json(['error' => 'Los detalles son obligatorios.'], 400);
        }
        try {
            $fileName = $this->guardarImagenBase64($img, 'carror');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al guardar la imagen miCanvas.'], 500);
        }
        if ($img2) {
            return response()->json(['error' => 'La firma es obligatoria.'], 400);
        }
            try {
                $fileName2 = $this->guardarImagenBase64($img2, 'firmas');
            } catch (\Exception $e) {
                return response()->json(['error' => 'Error al guardar la imagen canvasfirma.'], 500);
            }
        
        DB::beginTransaction();
            try {
            $recepcion = new Color;
            $ExterioresEquipo = new ExterioresEquipo();
            $CondicionesPintura = new CondicionesPintura();
            $EquipoInventario = new EquipoInventario();
            $InterioresEquipo = new InterioresEquipo();
            $pVehiculos2023 = new pVehiculos2023();
            $pGenerales2023 = new pGenerales2023();
            $presupuestos2023 = new presupuestos2023();
            $HojaConcepto = new HojaConcepto();
            $EntradasSalidas = new EntradasSalidas();
            $OrdenesPagadas = new OrdenesPagadas();
            
            //iniciorecepcion
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
            $recepcion->tecnico= $request->input('');
            $recepcion->fecha= $request->input('fecha');
            $recepcion->firma= $fileName2;
            $recepcion->carro= $fileName;
            $recepcion->fecha_compromiso= $request->input('fecha_esperada');
            $recepcion->sucursal_id=$idsucursal;
            $recepcion->status= 0;
            $recepcion->fecha_entrega= $request->input('fecha_entrega');
            $recepcion->modulo= 3;
            $recepcion->administrador= $request->input('admintrasporte');
            $recepcion->jefedeprocesos= $request->input('jefedelproceso');
            $recepcion->telefonojefe= $request->input('telefonorecepcion');
            $recepcion->trabajador= $request->input('Trabajador');
            $recepcion->id_anio_correspondiente=3;
            $recepcion->save();

            $CondicionesPintura->recepcion_vehicular_id= $recepcion->id;
            $ExterioresEquipo->decolorada=$request->input('conpintura1');
            $ExterioresEquipo->emblemas_completos=$request->input('conpintura2');
            $ExterioresEquipo->color_no_igual=$request->input('conpintura3');
            $ExterioresEquipo->logos=$request->input('conpintura4');
            $ExterioresEquipo->exeso_rayones=$request->input('conpintura5');
            $ExterioresEquipo->exeso_rociado=$request->input('conpintura6');
            $ExterioresEquipo->pequenias_grietas=$request->input('conpintura7');
            $ExterioresEquipo->danios_granizado=$request->input('conpintura8');
            $ExterioresEquipo->carroceria_golpes=$request->input('conpintura9');
            $ExterioresEquipo->lluvia_acido=$request->input('conpintura10');
            $recepcion->save();

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
