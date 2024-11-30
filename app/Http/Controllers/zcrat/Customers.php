<?php

namespace App\Http\Controllers\zcrat;
use App\Http\Controllers\controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Empresa;

class Customers extends Controller
{
    public function clientes(){
       
        $empresas = Empresa::select('id','nombre')->get();
        $elementostotales = Customer::with(['empresa:id,nombre'])->has('empresa')->count();
        
        return view('clientes.usuarios', compact('elementostotales','empresas'));
    }
    public function obtenerusuarios()
    {
        $customers = Customer::with(['empresa:id,nombre'])->has('empresa')->get();
        return response()->json(['usuarios'=>$customers]);
    }
    public function obtenerusuario(Request $request)
    {
        if ($request->has('id')) {
        $customer = Customer::where('id',$request->input('id'))->get();
        return response()->json(['customer'=>$customer]);
        }
    }
    public function create(Request $request)
    {
        if ($request->filled('customer-id')) {
            DB::beginTransaction();
            try {
            $id = $request->input('customer-id');
            $customer = Customer::findOrFail($id);
            $customer->empresa_id = $request->input('customer-idempresa');
            $customer->nombre = $request->input('customer-usuario');
            $customer->direccion = $request->input('customer-direccion');
            $customer->ciudad = $request->input('customer-ciudad');
            $customer->estado = $request->input('customer-estado');
            $customer->cp = $request->input('customer-cp');
            $customer->tel_casa = $request->input('customer-tel_casa');
            $customer->tel_oficina = $request->input('customer-tel_oficina');
            $customer->tel_celular = $request->input('customer-tel_celular');
            $customer->email = $request->input('customer-email');
            $customer->save();
            DB::commit();
            return "actualizado";
            } catch (\Exception $e) {
            DB::rollBack();
            return abort(500, $e->getMessage());
            }
        } else {
            DB::beginTransaction();
            try {
            $customer = new Customer;
            $customer->empresa_id = $request->input('customer-idempresa');
            $customer->nombre = $request->input('customer-usuario');
            $customer->direccion = $request->input('customer-direccion');
            $customer->ciudad = $request->input('customer-ciudad');
            $customer->estado = $request->input('customer-estado');
            $customer->cp = $request->input('customer-cp');
            $customer->tel_casa = $request->input('customer-tel_casa');
            $customer->tel_oficina = $request->input('customer-tel_oficina');
            $customer->tel_celular = $request->input('customer-tel_celular');
            $customer->email = $request->input('customer-email');
            $customer->save();
            DB::commit();
            return "creado";
            } catch (\Exception $e) {
            DB::rollBack();
            return abort(500, $e->getMessage());
            }
        }
    }
    public function deleteuser(Request $request){
        if ($request->id) {
            DB::beginTransaction();
            try {
            $customer = Customer::findOrFail($request->id);
            $customer->delete();
            DB::commit();
            return "eliminado";
            }catch (\Exception $e) {
                    DB::rollBack();
                    return abort(500, $e->getMessage());
                    }
                }else{
                    return "no hay usuario";
                }
       
    }
    
    public function Empresas(){
        $Regimenes = [
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
        $elementostotales = Empresa::count();
        return view('clientes.empresas', compact('elementostotales', 'Regimenes'));
    }

    public function obtenerempresas()
    {
        $companies =Empresa::get();
        return response()->json(['companies'=>$companies]);

    }

    public function obtenerempresa(Request $request)
    {
        if ($request->has('id')) {
        $compani = Empresa::where('id',$request->input('id'))->get();
        return response()->json(['compani'=>$compani]);
        }
    }
    public function create_empresa(Request $request)
    {  
        if ($request->filled('compani_id') ) {
            $id = $request->input('compani_id');
            try{
            $compani = Empresa::findOrFail($id);
            } catch (ModelNotFoundException $e) {
                return response()->json(['error' => 'Empresa no encontrada'], 404);   
            }
                if($request->hasfile('compani_logo')){
                $path = $request->file('compani_logo')->store('public/img/logos_empresas');
                $path = explode('/',$path);
                $path=$path[3];
                }else{
                $path=Empresas::select('logo')->where('id',$id)->first();    
                }
                if($path){
                    DB::beginTransaction();
                    try {
                        $compani->nombre = $request->input('compani_nombre');
                        $compani->rfc=$request->input('compani_rfc');
                        $compani->logo=$path;
                        $compani->email=$request->input('compani_email');
                        $compani->direccion = $request->input('compani_direccion');
                        $compani->ciudad =$request->input('compani_ciudad');
                        $compani->estado = $request->input('compani_estado');
                        $compani->cp =$request->input('compani_cp');
                        $compani->tel_casa =$request->input('compani_tel_casa');
                        $compani->tel_negocio = $request->input('compani_tel_negocio');
                        $compani->tel_celular =$request->input('compani_tel_celular');
                        $compani->regimen=$request->input('compani_regimen');
                        $compani->save();
                    DB::commit();
                    return "actualizado";
                    } catch (\Exception $e) {
                    DB::rollBack();
                    return abort(500, $e->getMessage());
                    }
                }else{
                    return "imagennosubida";
                }
           
        } else {
                if($request->hasfile('compani_logo')){
                $path = $request->file('compani_logo')->store('public/img/logos_empresas');
                $path = explode('/',$path);
                $path=$path[3];
                }else{
                $path="sinlogo.jpg";   
                }
                if($path){
                    DB::beginTransaction();
                    try {
                        $compani = new Empresa;
                        $compani->nombre = $request->input('compani_nombre');
                        $compani->rfc=$request->input('compani_rfc');
                        $compani->logo=$path;
                        $compani->email=$request->input('compani_email');
                        $compani->direccion = $request->input('compani_direccion');
                        $compani->ciudad =$request->input('compani_ciudad');
                        $compani->estado = $request->input('compani_estado');
                        $compani->cp =$request->input('compani_cp');
                        $compani->tel_casa =$request->input('compani_tel_casa');
                        $compani->tel_negocio = $request->input('compani_tel_negocio');
                        $compani->tel_celular =$request->input('compani_tel_celular');
                        $compani->regimen=$request->input('compani_regimen');
                        $compani->save();
                        DB::commit();
                        return "creado";
                    } catch (\Exception $e) {
                    DB::rollBack();
                    return abort(500, $e->getMessage());
                    }
                }else{
                    return "imagennosubida";
                }
        }
    }
    public function deletecompani(Request $request){
        if ($request->id) {
            DB::beginTransaction();
            try {
            $customer = Empresa::findOrFail($request->id);
            $customer->delete();
            DB::commit();
            return "eliminado";
            }catch (\Exception $e) {
                    DB::rollBack();
                    return abort(500, $e->getMessage());
                    }
                }else{
                    return "no hay usuario";
                }
       
    }
}
