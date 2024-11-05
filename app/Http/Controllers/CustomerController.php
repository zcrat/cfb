<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Empresa;
use App\Http\Requests\CustomerFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function clientes(){
       
        $empresas = Empresa::select('id','nombre')->get();
        $elementostotales = Customer::with(['empresa:id,nombre'])->has('empresa')->count();
        
        return view('pruebas.usuarios', compact('elementostotales','empresas'));
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
        return view('pruebas.empresas', compact('elementostotales', 'Regimenes'));
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
        if ($request->filled('compani_id')) {
           
            $path = $request->file('compani_logo')->store('pruebas/logos_empresas');
            return response()->json(['message' => 'Logo subido exitosamente', 'path' => $path]);

        } else {
            return response()->json(['message' => 'Logo subido exitosamente', 'path' => $path]);
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
    public function index()
    {
        
        $customer = Customer::join('empresas','customers.empresa_id','=','empresas.id')
        ->select('customers.id','empresas.nombre','customers.empresa_id',
        'customers.nombre as usuario','customers.email','customers.direccion','customers.ciudad',
        'customers.estado','customers.cp','customers.tel_casa','customers.tel_oficina','customers.tel_celular',
        'customers.email')
        ->paginate(10);
       
      
        return [
            'pagination' => [
                'total'        => $customer->total(),
                'current_page' => $customer->currentPage(),
                'per_page'     => $customer->perPage(),
                'last_page'    => $customer->lastPage(),
                'from'         => $customer->firstItem(),
                'to'           => $customer->lastItem(),
            ],
            'usuarios' => $customer
        ];
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   

    /**
     * @param CustomerFormRequest $request
     * @return array|\Illuminate\Support\Collection
     */
    public function store(Request $request)
    {


        $modelocustomer = $request->modelocustomer;
        if($request->idempresa == null)
        { 
            $modelocustomer['empresa_id'] = $request->empresa_id;
        } 
        else 
        { 
            $modelocustomer['empresa_id'] = $request->idempresa;
        }      
        $modelocustomer['nombre'] = $request->usuario;
        $modelocustomer['direccion'] = $request->direccion;
        $modelocustomer['ciudad'] = $request->ciudad;
        $modelocustomer['estado'] = $request->estado;
        $modelocustomer['cp'] = $request->cp;
        $modelocustomer['tel_casa'] = $request->tel_casa;
        $modelocustomer['tel_oficina'] = $request->tel_oficina;
        $modelocustomer['tel_celular'] = $request->tel_celular;
        $modelocustomer['email'] = $request->email;

      
        
        $customer = Customer::create($modelocustomer);
       
        if ($customer->id) {

            $customer = Customer::where('customers.id','=',$customer->id)
            ->join('empresas','customers.empresa_id','=','empresas.id')
            ->select('customers.id','empresas.nombre','customers.empresa_id',
            'customers.nombre as usuario','customers.email','customers.direccion','customers.ciudad',
            'customers.estado','customers.cp','customers.tel_casa','customers.tel_oficina','customers.tel_celular',
            'customers.email')
            ->first();

            return collect(
                ['estado' => true, 'usuario' => $customer]
            );
        }
        return collect(['estado' => false]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }


    public function search(Request $request)
    {
        $model = new Customer();
        $consulta = null;
        $firstTime = true;
        if ($request->get('busqueda')) {

            foreach ($model->getFillable() as $atributo) {
                if($atributo == 'empresa_id' || 'fecha' || 'email') continue;
                if ($firstTime) {
                    $firstTime = false;
                    $consulta = Customer::where($atributo, 'LIKE', "%$request->busqueda%");
                } else {
                    $consulta->orWhere($atributo, 'LIKE', "%$request->busqueda%");
                }
            }
            return $request->get('busqueda');
            $test = $consulta->get();
            return collect(['estado' => true, 'usuarios' => $consulta->get()]);
        } else {
            return collect(['estado' => false]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerFormRequest $request)
    {
       
      
        $customer = Customer::find($request->id);
        if(isset($request->idempresa['code'])){
            $customer->empresa_id = $request->idempresa['code'];   
        } else {
            $customer->empresa_id = $request->empresa_id;
        }
       
        $customer->nombre = $request->usuario;
        $customer->direccion = $request->direccion;
        $customer->ciudad = $request->ciudad;
        $customer->estado = $request->estado;
        $customer->cp = $request->cp;
        $customer->tel_casa = $request->tel_casa;
        $customer->tel_oficina = $request->tel_oficina;
        $customer->tel_celular = $request->tel_celular;
        $customer->email = $request->email;
        $customerTemp = $customer;
        $status = $customer->save();
        return collect(['estado' => $status, 'usuario' => $customerTemp]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
       
        $customer = Customer::findOrFail($request->id);
        //Eliminamos los clientes de esa empresa
        $estado = $customer->delete();
        return collect(['estado' => $estado]);
    }
    

    public function particulares(){
        $customersQuery = Customer::where('empresa_id',null)->get();
        $customers = collect();
        foreach($customersQuery as $customer){
            $customers->push(['code' => $customer->id,'label' => $customer->nombre]);
        }
        return $customers;
    }
}
