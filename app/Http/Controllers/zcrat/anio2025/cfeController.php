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




}
