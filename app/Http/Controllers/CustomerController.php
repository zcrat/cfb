<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Empresa;
use App\Http\Requests\CustomerFormRequest;
use Illuminate\Http\Request;

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
    public function newcliente(){

    }

    public function empresas()
    {
        return view('pruebas.empresas');
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
    public function create()
    {
        //
    }


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
