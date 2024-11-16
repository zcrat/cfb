<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();
//routes clientes
//users
Route::get('clientes/usuarios', 'CustomerController@clientes')->name('cliente.usuarios')->middleware('auth');
Route::post('clientes/newusuario', 'CustomerController@create')->name('cliente.register');
Route::post('clientes/deleteuser', 'CustomerController@deleteuser')->name('cliente.delete');
Route::get('clientes/obtenerusuarios', 'CustomerController@obtenerusuarios')->name('cliente.users')->middleware('auth');
Route::get('clientes/obtenerusuario', 'CustomerController@obtenerusuario')->name('cliente.user')->middleware('auth');
//companis
Route::get('clientes/empresas', 'CustomerController@empresas')->name('cliente.empresas')->middleware('auth');
Route::post('clientes/newempresa', 'CustomerController@create_empresa')->name('cliente.compani_register');
Route::post('clientes/deletecompani', 'CustomerController@deletecompani')->name('cliente.deletecompani');
Route::get('clientes/obtenerempresas', 'CustomerController@obtenerempresas')->name('cliente.companies')->middleware('auth');
Route::get('clientes/obtenerempresa', 'CustomerController@obtenerempresa')->name('cliente.compani')->middleware('auth');

//facturacion
Route::get('facturacion/facturas', 'FacturasController@facturas')->name('facturacion.facturas')->middleware('auth');
Route::get('facturacion/obtenerfacturas', 'FacturasController@obtenerfacturas')->name('facturacion.obtenerfacturas')->middleware('auth');
Route::get('facturacion/obtenerarticulo', 'FacturasController@obtenerarticulo')->name('facturacion.articulos')->middleware('auth');



Route::middleware(['auth'])->group(function(){
       

     //Tareas
    Route::get('tareas', 'TareasController@index')->name('tareas.index')
    ->middleware('permission:tareas.index');
    Route::get('tareas/admin', 'TareasController@indexadmin')->name('tareas.index')
    ->middleware('permission:tareas.index');
    Route::put('/tareas/actualizar', 'TareasController@update')->name('tareas.index')
    ->middleware('permission:tareas.index');
    Route::put('/tareas/actualizar/admin', 'TareasController@updateadmin')->name('tareas.index')
    ->middleware('permission:tareas.index');
    Route::post('/tareas/registrar', 'TareasController@store')->name('tareas.index')
    ->middleware('permission:tareas.index');
    Route::put('/tareas/desactivar', 'TareasController@desactivar')->name('tareas.desactivar')
    ->middleware('permission:tareas.desactivar');
    Route::post('/tareas/subir', 'TareasController@subir')->name('tareas.index')
    ->middleware('permission:tareas.index');
    Route::get('tareas/archivos', 'TareasController@indexarchivos')->name('tareas.index')
    ->middleware('permission:tareas.index');
    Route::put('/tareasArchivosEliminar/eliminar', 'TareasController@eliminar')->name('tareas.index')
    ->middleware('permission:tareas.index');


    Route::post('/recepcionO2023/subir', 'RecepcionVehicularController@subir')->name('cfeO2023.index')
    ->middleware('permission:cfeO2023.index');
    Route::get('recepcionO2023/archivos', 'RecepcionVehicularController@indexarchivos')->name('cfeO2023.index')
    ->middleware('permission:cfeO2023.index');
    Route::put('/recepcionO2023/eliminar', 'RecepcionVehicularController@eliminar')->name('cfeO2023.index')
    ->middleware('permission:cfeO2023.index');

    Route::put('/recepcionO2023/delete', 'RecepcionVehicularController@delete')->name('tareas.index')
    ->middleware('permission:tareas.index');

    

    Route::get('tecnicos', 'TecnicosController@index')->name('tareas.index')
    ->middleware('permission:tareas.index');
    Route::get('tecnicos/reparaciones', 'TecnicosController@reparaciones')->name('tareas.index')
    ->middleware('permission:tareas.index');
    Route::post('/tecnicos/reparaciones/registrar', 'TecnicosController@store')->name('tareas.index')
    ->middleware('permission:tareas.index');
    Route::put('/tecnicos/reparaciones/actualizar', 'TecnicosController@update')->name('tareas.index')
    ->middleware('permission:tareas.index');
    Route::post('/tecnicos/registrar', 'TecnicosController@store2')->name('tareas.index')
    ->middleware('permission:tareas.index');\
    Route::put('/tecnicos/delete', 'TecnicosController@delete')->name('tareas.index')
    ->middleware('permission:tareas.index');
    Route::put('/tecnicos/reparaciones/delete', 'TecnicosController@delete2')->name('tareas.index')
    ->middleware('permission:tareas.index');
    Route::post('/tecnicos/subirarchivos', 'TecnicosController@updatearchivos')->name('tareas.index')
    ->middleware('permission:tareas.index');  
    Route::post('/tecnicos/guardarOrden', 'TecnicosController@guardarOrden')->name('tareas.index')
    ->middleware('permission:tareas.index');
    Route::post('/tecnicos/subir', 'TecnicosController@subir')->name('tareas.index')
    ->middleware('permission:tareas.index');
    Route::get('tecnicos/archivos', 'TecnicosController@indexarchivos')->name('tareas.index')
    ->middleware('permission:tareas.index');
    Route::put('/tecnicos/archivos/eliminar', 'TecnicosController@eliminar')->name('tareas.index')
    ->middleware('permission:tareas.index');


    Route::get('trasladistas', 'TrasladistasController@index')->name('tareas.index')
    ->middleware('permission:tareas.index');
    Route::get('trasladistas/reparaciones', 'TrasladistasController@reparaciones')->name('tareas.index')
    ->middleware('permission:tareas.index');
    Route::post('/trasladistas/reparaciones/registrar', 'TrasladistasController@store')->name('tareas.index')
    ->middleware('permission:tareas.index');
    Route::put('/trasladistas/reparaciones/actualizar', 'TrasladistasController@update')->name('tareas.index')
    ->middleware('permission:tareas.index');
    Route::post('/trasladistas/registrar', 'TrasladistasController@store2')->name('tareas.index')
    ->middleware('permission:tareas.index');\
    Route::put('/trasladistas/delete', 'TrasladistasController@delete')->name('tareas.index')
    ->middleware('permission:tareas.index');
    Route::put('/trasladistas/reparaciones/delete', 'TrasladistasController@delete2')->name('tareas.index')
    ->middleware('permission:tareas.index');
    Route::post('/trasladistas/subirarchivos', 'TrasladistasController@updatearchivos')->name('tareas.index')
    ->middleware('permission:tareas.index');  
    Route::post('/trasladistas/guardarOrden', 'TrasladistasController@guardarOrden')->name('tareas.index')
    ->middleware('permission:tareas.index');
    Route::post('/trasladistas/subir', 'TrasladistasController@subir')->name('tareas.index')
    ->middleware('permission:tareas.index');
    Route::get('trasladistas/archivos', 'TrasladistasController@indexarchivos')->name('tareas.index')
    ->middleware('permission:tareas.index');
    Route::put('/trasladistas/archivos/eliminar', 'TrasladistasController@eliminar')->name('tareas.index')
    ->middleware('permission:tareas.index');

    Route::get('vehiculostareas', 'VehiculosTareasController@index')->name('tareas.index')
    ->middleware('permission:tareas.index');
    Route::post('/vehiculostareas/registrar', 'VehiculosTareasController@store')->name('tareas.index')
    ->middleware('permission:tareas.index');
    Route::put('/vehiculostareas/actualizar', 'VehiculosTareasController@update')->name('tareas.index')
    ->middleware('permission:tareas.index');
    Route::put('/vehiculostareas/delete', 'VehiculosTareasController@delete')->name('tareas.index')
    ->middleware('permission:tareas.index');


    

    //Usuarios
    Route::get('user', 'UserController@index')->name('tareas.index')
        ->middleware('permission:tareas.index');
    Route::get('/user', 'UserController@index')->name('tareas.index')
        ->middleware('permission:tareas.index');
    Route::post('/user/registrar', 'UserController@store')->name('user.store')
        ->middleware('permission:user.store');
    Route::put('/user/actualizar', 'UserController@update')->name('user.update')
        ->middleware('permission:user.update');
    Route::put('/user/desactivar', 'UserController@desactivar')->name('user.desactivar')
        ->middleware('permission:desactivar');
    Route::put('/user/activar', 'UserController@activar')->name('user.activar')
        ->middleware('permission:user.activar');
    Route::get('/user/edit', 'UserController@edit')->name('user.update')
        ->middleware('permission:user.update');        

    //Roles    
    Route::get('/rol', 'RolController@index')->name('roles.index')
            ->middleware('permission:roles.index');  
    Route::post('/rol/store', 'RolController@store')->name('roles.store')
            ->middleware('permission:roles.store');   
    Route::post('/rol/actualizar', 'RolController@update')->name('roles.update')
            ->middleware('permission:roles.update');  
    Route::get('/rol/selectRol', 'RolController@selectRol')->name('roles.index')
            ->middleware('permission:roles.index');  
    Route::get('/rol/edit', 'RolController@edit')->name('roles.update')
            ->middleware('permission:roles.update');  
            

    //Sucursales        
    Route::get('/sucursales', 'SucursalesController@index')->name('sucursales.index')
            ->middleware('permission:sucursales.index');
    Route::post('/sucursales/registrar', 'SucursalesController@store')->name('sucursales.store')
            ->middleware('permission:sucursales.store');
    Route::post('/sucursales/update', 'SucursalesController@update')->name('sucursales.update')
            ->middleware('permission:sucursales.update');
    Route::post('/sucursales/delete', 'SucursalesController@delete')->name('sucursales.delete')
            ->middleware('permission:sucursales.delete');
    Route::get('/sucursales/obtenerPlantel', 'SucursalesController@obtenerPlantel')->name('sucursales.index')
            ->middleware('permission:sucursales.index'); 
            
        //Contratos        
        Route::get('/contratos', 'ContratosController@index')->name('contratos.index')
        ->middleware('permission:contratos.index');
        Route::post('/contratos/registrar', 'ContratosController@store')->name('contratos.store')
        ->middleware('permission:contratos.store');
        Route::post('/contratos/update', 'ContratosController@update')->name('contratos.update')
        ->middleware('permission:contratos.update');
        Route::get('/contratos/obtenerContratos', 'ContratosController@obtenerContratos')->name('contratos.index')
        ->middleware('permission:contratos.index'); 
            
    //Cotizaciones3        
    Route::get('/cotizacion3', 'Cotizacion3Controller@index')->name('cotizacion.index')
            ->middleware('permission:cotizacion.index');
    Route::post('/cotizacion3/registrar', 'Cotizacion3Controller@store')->name('cotizacion.store')
            ->middleware('permission:cotizacion.store');
    Route::put('/cotizacion3/desactivar', 'Cotizacion3Controller@desactivar')->name('cotizacion.delete')
            ->middleware('permission:cotizacion.delete');
    Route::get('/cotizacion3/obtenerCabecera', 'Cotizacion3Controller@obtenerCabecera')->name('cotizacion.index')
            ->middleware('permission:cotizacion.index');
    Route::get('/cotizacion3/obtenerDetalles', 'Cotizacion3Controller@obtenerDetalles')->name('cotizacion.index')
            ->middleware('permission:cotizacion.index');
    Route::get('/cotizacion3/pdf/{id}', 'Cotizacion3Controller@pdf')->name('cotizacion.index')
            ->middleware('permission:cotizacion.index');
    Route::get('/cotizacion3/selectDetalle', 'Cotizacion3Controller@selectDetalle')->name('cotizacion.index')
            ->middleware('permission:cotizacion.index');
    Route::get('/cotizacion3/deleteDetalle', 'Cotizacion3Controller@deleteDetalle')->name('cotizacion.delete')
            ->middleware('permission:cotizacion.delete');  
    Route::post('/cotizacion3/update', 'Cotizacion3Controller@update')->name('cotizacion.update')
            ->middleware('permission:cotizacion.update'); 
            

   //Ordenes       
        Route::get('/ordenesB2023', 'presupuestosCFEBajio2023Controller@index')->name('cfeB2023.index')
        ->middleware('permission:cfeB2023.index');
        Route::get('/ordenesAllB2023', 'presupuestosCFEBajio2023Controller@indexAll')->name('cfeB2023.index')
        ->middleware('permission:cfeB2023.index');
        Route::get('/ordenesCFEB2023', 'presupuestosCFEBajio2023Controller@indexCFE')->name('cfeB2023.apcfe')
        ->middleware('permission:cfeB2023.apcfe');
        Route::get('/ordenesCFEBuscarB2023', 'presupuestosCFEBajio2023Controller@indexCFEBuscar')->name('cfeB2023.apcfe')
        ->middleware('permission:cfeB2023.apcfe');  
        Route::post('/ordenesB2023/tipo', 'presupuestosCFEBajio2023Controller@tipo')->name('cfeB2023.index')
        ->middleware('permission:cfeB2023.index'); 
        Route::post('/ordenesB2023/categoria', 'presupuestosCFEBajio2023Controller@categoria')->name('cfeB2023.index')
        ->middleware('permission:cfeB2023.index'); 
        Route::get('/ordenesB2023/selectCategorias', 'presupuestosCFEBajio2023Controller@selectCategorias')->name('cfeB2023.index')
        ->middleware('permission:cfeB2023.index');  
        Route::get('/ordenesB2023/selectTipos', 'presupuestosCFEBajio2023Controller@selectTipos')->name('cfeB2023.index')
        ->middleware('permission:cfeB2023.index');   
        Route::post('/ordenesB2023/registrar', 'presupuestosCFEBajio2023Controller@store')->name('cfeB2023.index')
        ->middleware('permission:cfeB2023.index'); 
        Route::get('/ordenesB2023/exel', 'presupuestosCFEBajio2023Controller@exel')->name('cfeB2023.index')
        ->middleware('permission:cfeB2023.index');  
        

        //Ordenes       
        Route::get('/ordenesO2023', 'presupuestosCFEOccidente2023Controller@index')->name('cfeO2023.index')
        ->middleware('permission:cfeO2023.index');
        Route::get('/ordenesAllO2023', 'presupuestosCFEOccidente2023Controller@indexAll')->name('cfeO2023.index')
        ->middleware('permission:cfeO2023.index');
        Route::get('/ordenesCFEO2023', 'presupuestosCFEOccidente2023Controller@indexCFE')->name('cfeO2023.apcfe')
        ->middleware('permission:cfeO2023.apcfe');
        Route::get('/ordenesCFEBuscarO2023', 'presupuestosCFEOccidente2023Controller@indexCFEBuscar')->name('cfeO2023.apcfe')
        ->middleware('permission:cfeO2023.apcfe');  
        Route::post('/ordenesO2023/tipo', 'presupuestosCFEOccidente2023Controller@tipo')->name('cfeO2023.index')
        ->middleware('permission:cfeO2023.index'); 
        Route::post('/ordenesO2023/categoria', 'presupuestosCFEOccidente2023Controller@categoria')->name('cfeO2023.index')
        ->middleware('permission:cfeO2023.index'); 
        Route::get('/ordenesO2023/selectCategorias', 'presupuestosCFEOccidente2023Controller@selectCategorias')->name('cfeO2023.index')
        ->middleware('permission:cfeO2023.index');  
        Route::get('/ordenesO2023/selectTipos', 'presupuestosCFEOccidente2023Controller@selectTipos')->name('cfeO2023.index')
        ->middleware('permission:cfeO2023.index');   
        Route::post('/ordenesO2023/registrar', 'presupuestosCFEOccidente2023Controller@store')->name('cfeO2023.index')
        ->middleware('permission:cfeO2023.index');  
        Route::post('/ordenesO2023/registrar', 'presupuestosCFEOccidente2023Controller@store')->name('cfeO2023.index')
        ->middleware('permission:cfeO2023.index');  
        Route::get('/ordenesO2023/exel', 'presupuestosCFEOccidente2023Controller@exel')->name('cfeO2023.index')
        ->middleware('permission:cfeO2023.index');  
        
        
        

        //Ordenes       
        Route::get('/ordenesCFEECO', 'presupuestosCFEECOController@index')->name('cfeO2023.index')
        ->middleware('permission:cfeO2023.index');
        Route::get('/ordenesAllCFEECO', 'presupuestosCFEECOController@indexAll')->name('cfeO2023.index')
        ->middleware('permission:cfeO2023.index');
        Route::get('/ordenesCFEECO', 'presupuestosCFEECOController@indexCFE')->name('cfeO2023.apcfe')
        ->middleware('permission:cfeO2023.apcfe');
        Route::get('/ordenesCFEBuscarCFEECO', 'presupuestosCFEECOController@indexCFEBuscar')->name('cfeO2023.apcfe')
        ->middleware('permission:cfeO2023.apcfe');  
        Route::post('/ordenesCFEECO/tipo', 'presupuestosCFEECOController@tipo')->name('cfeO2023.index')
        ->middleware('permission:cfeO2023.index'); 
        Route::post('/ordenesCFEECO/categoria', 'presupuestosCFEECOController@categoria')->name('cfeO2023.index')
        ->middleware('permission:cfeO2023.index'); 
        Route::get('/ordenesCFEECO/selectCategorias', 'presupuestosCFEECOController@selectCategorias')->name('cfeO2023.index')
        ->middleware('permission:cfeO2023.index');  
        Route::get('/ordenesCFEECO/selectTipos', 'presupuestosCFEECOController@selectTipos')->name('cfeO2023.index')
        ->middleware('permission:cfeO2023.index');   
        Route::post('/ordenesCFEECO/registrar', 'presupuestosCFEECOController@store')->name('cfeO2023.index')
        ->middleware('permission:cfeO2023.index');  
        Route::post('/conceptosCFEECO/registrar', 'pCFEECOConceptosController@store')->name('cfeO2023.index')
        ->middleware('permission:cfeO2023.index'); 
        Route::get('/conceptosCFEECO/selectConceptos', 'pCFEECOConceptosController@selectConceptos')->name('cfeO2023.index')
        ->middleware('permission:cfeO2023.index');
        Route::get('/ordenesCFEECO/exel', 'presupuestosCFEECOController@exel')->name('cfeO2023.index')
        ->middleware('permission:cfeO2023.index');  
        
        

        
        
                  //DetalleConceptos
         Route::get('/conceptosCFEB2023', 'pCFEB2023ConceptosController@index')->name('cfeB2023.index')
        ->middleware('permission:cfeB2023.index');     
        Route::post('/conceptosB2023/registrar', 'pCFEB2023ConceptosController@store')->name('cfeB2023.index')
        ->middleware('permission:cfeB2023.index'); 
        Route::get('/conceptosB2023/selectConceptos', 'pCFEB2023ConceptosController@selectConceptos')->name('cfeB2023.index')
        ->middleware('permission:cfeB2023.index');


                //DetalleConceptos
        Route::get('/conceptosCFEO2023', 'pCFEO2023ConceptosController@index')->name('cfeO2023.index')
        ->middleware('permission:cfeO2023.index');     
        Route::post('/conceptosO2023/registrar', 'pCFEO2023ConceptosController@store')->name('cfeO2023.index')
        ->middleware('permission:cfeO2023.index'); 
        Route::get('/conceptosO2023/selectConceptos', 'pCFEO2023ConceptosController@selectConceptos')->name('cfeO2023.index')
        ->middleware('permission:cfeO2023.index');





    //Ordenes       
    Route::get('/ordenes', 'presupuestosCFEController@index')->name('ordenes.index')
            ->middleware('permission:ordenes.index');
    Route::get('/ordenesAll', 'presupuestosCFEController@indexAll')->name('ordenes.index')
            ->middleware('permission:ordenes.index');
    Route::get('/ordenesCFE', 'presupuestosCFEController@indexCFE')->name('cfe.apcfe')
            ->middleware('permission:cfe.apcfe');
    Route::get('/ordenesCFEBuscar', 'presupuestosCFEController@indexCFEBuscar')->name('cfe.apcfe')
            ->middleware('permission:cfe.apcfe');  
    Route::post('/ordenes/tipo', 'presupuestosCFEController@tipo')->name('ordenes.index')
            ->middleware('permission:ordenes.index'); 
    Route::post('/ordenes/categoria', 'presupuestosCFEController@categoria')->name('ordenes.index')
            ->middleware('permission:ordenes.index'); 
    Route::get('/ordenes/selectCategorias', 'presupuestosCFEController@selectCategorias')->name('ordenes.index')
            ->middleware('permission:ordenes.index');  
    Route::get('/ordenes/selectTipos', 'presupuestosCFEController@selectTipos')->name('ordenes.index')
            ->middleware('permission:ordenes.index');   
    Route::post('/ordenes/registrar', 'presupuestosCFEController@store')->name('ordenes.store')
            ->middleware('permission:ordenes.store');        

             


    Route::post('/ordenes/update', 'presupuestosCFEController@update')->name('ordenes.update')
            ->middleware('permission:ordenes.update');   
    Route::get('/ordenes/pdf/{id}', 'presupuestosCFEController@pdf')->name('ordenes.index')
            ->middleware('permission:ordenes.index');  
   Route::get('/ordenes/pdfAcuse/{id}', 'presupuestosCFEController@pdfacuse')->name('ordenes.index')
            ->middleware('permission:ordenes.index');         
   Route::get('/ordenes/pdfCFE/{id}', 'presupuestosCFEController@pdfcfe')->name('ordenes.index')
            ->middleware('permission:ordenes.index');           
   Route::post('/ordenes/subirarchivos', 'presupuestosCFEController@updatearchivos')->name('ordenes.index')
            ->middleware('permission:ordenes.index');   
   Route::post('/ordenes/subirarchivos2', 'presupuestosCFEController@updatearchivos2')->name('ordenes.index')
            ->middleware('permission:ordenes.index');  
   Route::post('/ordenes/subirarchivos3', 'presupuestosCFEController@updatearchivos3')->name('ordenes.index')
            ->middleware('permission:ordenes.index');
   Route::post('/ordenes/subirarchivos4', 'presupuestosCFEController@updatearchivos4')->name('ordenes.index')
            ->middleware('permission:ordenes.index');  
   Route::post('/ordenes/subirarchivos5', 'presupuestosCFEController@updatearchivos5')->name('ordenes.index')
            ->middleware('permission:ordenes.index');                     
   Route::post('/ordenes/subirarchivos6', 'presupuestosCFEController@updatearchivos6')->name('ordenes.index')
            ->middleware('permission:ordenes.index');  
   Route::post('/ordenes/subirarchivos7', 'presupuestosCFEController@updatearchivos7')->name('ordenes.index')
            ->middleware('permission:ordenes.index'); 
   Route::post('/ordenes/subirarchivos8', 'presupuestosCFEController@updatearchivos8')->name('ordenes.index')
            ->middleware('permission:ordenes.index');    
  Route::post('/ordenes/subirarchivos9', 'presupuestosCFEController@updatearchivos9')->name('ordenes.index')
            ->middleware('permission:ordenes.index');        
   
   
   Route::post('/ordenes/guardarFotoVieja', 'presupuestosCFEController@guardarFotoVieja')->name('ordenes.index')
            ->middleware('permission:ordenes.index');    
   Route::post('/ordenes/obtenerDetallesmulti', 'presupuestosCFEController@obtenerDetallesmulti')->name('ordenes.index')
            ->middleware('permission:ordenes.index');   
  Route::post('/ordenes/obtenerDetallesmultiSave', 'presupuestosCFEController@obtenerDetallesmultiSave')->name('ordenes.index')
            ->middleware('permission:ordenes.index');   
           
   Route::post('/ordenes/guardarFotoNueva', 'presupuestosCFEController@guardarFotoNueva')->name('ordenes.index')
            ->middleware('permission:ordenes.index');                                  
   Route::post('/ordenes/guardarFotoInstalada', 'presupuestosCFEController@guardarFotoInstalada')->name('ordenes.index')
            ->middleware('permission:ordenes.index'); 
   Route::post('/ordenes/guardarReporteAnomalias', 'presupuestosCFEController@guardarReporteAnomalias')->name('ordenes.index')
            ->middleware('permission:ordenes.index');
   Route::post('/ordenes/guardarFacturaPDF', 'presupuestosCFEController@guardarFacturaPDF')->name('ordenes.index')
            ->middleware('permission:ordenes.index');                    
   Route::post('/ordenes/guardarFacturaXML', 'presupuestosCFEController@guardarFacturaXML')->name('ordenes.index')
            ->middleware('permission:ordenes.index'); 
   Route::post('/ordenes/guardarAcuse', 'presupuestosCFEController@guardarAcuse')->name('ordenes.index')
            ->middleware('permission:ordenes.index');  
   Route::post('/ordenes/guardarOrdenServicio', 'presupuestosCFEController@guardarOrdenServicio')->name('ordenes.index')
            ->middleware('permission:ordenes.index');  
   Route::post('/ordenes/guardarEntrada', 'presupuestosCFEController@guardarEntrada')->name('ordenes.index')
            ->middleware('permission:ordenes.index');            
   Route::post('/ordenes/cambioStatus', 'presupuestosCFEController@cambioStatus')->name('ordenes.index')
            ->middleware('permission:ordenes.index'); 

   Route::post('/ordenes/tramitado', 'presupuestosCFEController@tramitado')->name('ordenes.index')
            ->middleware('permission:ordenes.index'); 
   Route::get('/ordenes/obtenerDetalles', 'presupuestosCFEController@obtenerDetalles')->name('ordenes.index')
            ->middleware('permission:ordenes.index');    
            
   Route::put('/ordenes/desactivar', 'presupuestosCFEController@desactivar')->name('ordenes.index')
            ->middleware('permission:ordenes.index');

 
            
            
            


     //Ordenes       
        Route::get('/ordenes2', 'presupuestosController@index')->name('ordenes2.index')
        ->middleware('permission:ordenes2.index');
        
        Route::get('/ordenes2/presupuestoHoja/{id}', 'presupuestosController@pdfConceptos')->name('ordenes2.index')
            ->middleware('permission:ordenes2.index');   
            

        Route::get('/ordenes2/start', 'presupuestosController@indexStart')->name('ordenes2.index')
        ->middleware('permission:ordenes2.index');
        Route::post('/ordenes2/registrar', 'presupuestosController@store')->name('ordenes2.store')
        ->middleware('permission:ordenes2.store');  
        Route::post('/ordenes2/update', 'presupuestosController@update')->name('ordenes2.update')
        ->middleware('permission:ordenes2.update');   
        Route::get('/ordenes2/selectCategorias', 'presupuestosController@selectCategorias')->name('ordenes2.index')
        ->middleware('permission:ordenes2.index');  
        Route::get('/ordenes2/selectTipos', 'presupuestosController@selectTipos')->name('ordenes2.index')
        ->middleware('permission:ordenes2.index');  
        Route::get('/ordenes2/pdf/{id}', 'presupuestosController@pdf')->name('ordenes2.index')
        ->middleware('permission:ordenes2.index');  
        Route::get('/ordenes2/pdfAcuse/{id}', 'presupuestosController@pdfacuse')->name('ordenes2.index')
        ->middleware('permission:ordenes2.index');         
        Route::get('/ordenes2/pdfCFE/{id}', 'presupuestosController@pdfcfe')->name('ordenes2.index')
        ->middleware('permission:ordenes2.index');           
        Route::post('/ordenes2/subirarchivos', 'presupuestosController@updatearchivos')->name('ordenes2.index')
        ->middleware('permission:ordenes2.index');   
        Route::post('/ordenes2/subirarchivos2', 'presupuestosController@updatearchivos2')->name('ordenes2.index')
        ->middleware('permission:ordenes2.index');  
        Route::post('/ordenes2/subirarchivos3', 'presupuestosController@updatearchivos3')->name('ordenes2.index')
        ->middleware('permission:ordenes2.index');
        Route::post('/ordenes2/subirarchivos4', 'presupuestosController@updatearchivos4')->name('ordenes2.index')
        ->middleware('permission:ordenes2.index');  
        Route::post('/ordenes2/subirarchivos5', 'presupuestosController@updatearchivos5')->name('ordenes2.index')
        ->middleware('permission:ordenes2.index');                     
        Route::post('/ordenes2/subirarchivos6', 'presupuestosController@updatearchivos6')->name('ordenes2.index')
        ->middleware('permission:ordenes2.index');  
        Route::post('/ordenes2/subirarchivos7', 'presupuestosController@updatearchivos7')->name('ordenes2.index')
        ->middleware('permission:ordenes2.index'); 
        Route::post('/ordenes2/subirarchivos8', 'presupuestosController@updatearchivos8')->name('ordenes2.index')
        ->middleware('permission:ordenes2.index'); 
        Route::post('/ordenes2/subirarchivos9', 'presupuestosController@updatearchivos9')->name('ordenes2.index')
        ->middleware('permission:ordenes2.index'); 


       
        
        


        Route::post('/ordenes2/guardarFotoVieja', 'presupuestosController@guardarFotoVieja')->name('ordenes2.index')
        ->middleware('permission:ordenes2.index');    
        Route::post('/ordenes2/guardarFotoNueva', 'presupuestosController@guardarFotoNueva')->name('ordenes2.index')
        ->middleware('permission:ordenes2.index');                                  
        Route::post('/ordenes2/guardarFotoInstalada', 'presupuestosController@guardarFotoInstalada')->name('ordenes2.index')
        ->middleware('permission:ordenes2.index'); 
        Route::post('/ordenes2/guardarReporteAnomalias', 'presupuestosController@guardarReporteAnomalias')->name('ordenes2.index')
        ->middleware('permission:ordenes2.index');
        Route::post('/ordenes2/guardarFacturaPDF', 'presupuestosController@guardarFacturaPDF')->name('ordenes2.index')
        ->middleware('permission:ordenes2.index');                    
        Route::post('/ordenes2/guardarFacturaXML', 'presupuestosController@guardarFacturaXML')->name('ordenes2.index')
        ->middleware('permission:ordenes2.index'); 
        Route::post('/ordenes2/guardarAcuse', 'presupuestosController@guardarAcuse')->name('ordenes2.index')
        ->middleware('permission:ordenes2.index');  
        Route::post('/ordenes2/guardarEntrada', 'presupuestosController@guardarEntrada')->name('ordenes2.index')
        ->middleware('permission:ordenes2.index');     
        Route::post('/ordenes2/guardarOrdenServicio', 'presupuestosController@guardarOrdenServicio')->name('ordenes2.index')
        ->middleware('permission:ordenes2.index');    
        Route::post('/ordenes2/cambioStatus', 'presupuestosController@cambioStatus')->name('ordenes2.index')
        ->middleware('permission:ordenes2.index'); 
        Route::get('/ordenes2/obtenerDetalles', 'presupuestosController@obtenerDetalles')->name('ordenes2.index')
        ->middleware('permission:ordenes2.index');  
        
        Route::post('/ordenes2/tipo', 'presupuestosController@tipo')->name('ordenes2.index')
        ->middleware('permission:ordenes2.index'); 
        Route::post('/ordenes2/categoria', 'presupuestosController@categoria')->name('ordenes2.index')
        ->middleware('permission:ordenes2.index'); 

        Route::put('/ordenes2/desactivar', 'presupuestosController@desactivar')->name('ordenes2.index')
        ->middleware('permission:ordenes2.index');

        Route::get('/ordenes2/exel', 'presupuestosController@exel')->name('ordenes2.index')
        ->middleware('permission:ordenes2.index');   



         //Ordenes       
         Route::get('/ordenesNew', 'presupuestos2023Controller@index')->name('ordenesNew.index')
         ->middleware('permission:ordenesNew.index');
         Route::get('/ordenesNew/start', 'presupuestos2023Controller@indexStart')->name('ordenesNew.index')
         ->middleware('permission:ordenesNew.index');
         Route::post('/ordenesNew/registrar', 'presupuestos2023Controller@store')->name('ordenesNew.store')
         ->middleware('permission:ordenesNew.store');  
         Route::post('/ordenesNew/update', 'presupuestos2023Controller@update')->name('ordenesNew.update')
         ->middleware('permission:ordenesNew.update');   
         Route::get('/ordenesNew/selectCategorias', 'presupuestos2023Controller@selectCategorias')->name('ordenesNew.index')
         ->middleware('permission:ordenesNew.index');  
         Route::get('/ordenesNew/selectTipos', 'presupuestos2023Controller@selectTipos')->name('ordenesNew.index')
         ->middleware('permission:ordenesNew.index');  
         Route::get('/ordenesNew/pdf/{id}', 'presupuestos2023Controller@pdf')->name('ordenesNew.index')
         ->middleware('permission:ordenesNew.index');  
         Route::get('/ordenesNew/pdfAcuse/{id}', 'presupuestos2023Controller@pdfacuse')->name('ordenesNew.index')
         ->middleware('permission:ordenesNew.index');         
         Route::get('/ordenesNew/pdfCFE/{id}', 'presupuestos2023Controller@pdfcfe')->name('ordenesNew.index')
         ->middleware('permission:ordenesNew.index');           
         Route::post('/ordenesNew/subirarchivos', 'presupuestos2023Controller@updatearchivos')->name('ordenesNew.index')
         ->middleware('permission:ordenesNew.index');   
         Route::post('/ordenesNew/subirarchivos2', 'presupuestos2023Controller@updatearchivos2')->name('ordenesNew.index')
         ->middleware('permission:ordenesNew.index');  
         Route::post('/ordenesNew/subirarchivos3', 'presupuestos2023Controller@updatearchivos3')->name('ordenesNew.index')
         ->middleware('permission:ordenesNew.index');
         Route::post('/ordenesNew/subirarchivos4', 'presupuestos2023Controller@updatearchivos4')->name('ordenesNew.index')
         ->middleware('permission:ordenesNew.index');  
         Route::post('/ordenesNew/subirarchivos5', 'presupuestos2023Controller@updatearchivos5')->name('ordenesNew.index')
         ->middleware('permission:ordenesNew.index');                     
         Route::post('/ordenesNew/subirarchivos6', 'presupuestos2023Controller@updatearchivos6')->name('ordenesNew.index')
         ->middleware('permission:ordenesNew.index');  
         Route::post('/ordenesNew/subirarchivos7', 'presupuestos2023Controller@updatearchivos7')->name('ordenesNew.index')
         ->middleware('permission:ordenesNew.index'); 
         Route::post('/ordenesNew/subirarchivos8', 'presupuestos2023Controller@updatearchivos8')->name('ordenesNew.index')
         ->middleware('permission:ordenesNew.index'); 
         Route::post('/ordenesNew/subirarchivos9', 'presupuestos2023Controller@updatearchivos9')->name('ordenesNew.index')
         ->middleware('permission:ordenesNew.index'); 
         Route::get('/ordenesNew/exel', 'presupuestos2023Controller@exel')->name('ordenesNew.index')
         ->middleware('permission:ordenesNew.index');           
         
 
 
         Route::post('/ordenesNew/guardarFotoVieja', 'presupuestos2023Controller@guardarFotoVieja')->name('ordenesNew.index')
         ->middleware('permission:ordenesNew.index');    
         Route::post('/ordenesNew/guardarFotoNueva', 'presupuestos2023Controller@guardarFotoNueva')->name('ordenesNew.index')
         ->middleware('permission:ordenesNew.index');                                  
         Route::post('/ordenesNew/guardarFotoInstalada', 'presupuestos2023Controller@guardarFotoInstalada')->name('ordenesNew.index')
         ->middleware('permission:ordenesNew.index'); 
         Route::post('/ordenesNew/guardarReporteAnomalias', 'presupuestos2023Controller@guardarReporteAnomalias')->name('ordenesNew.index')
         ->middleware('permission:ordenesNew.index');
         Route::post('/ordenesNew/guardarFacturaPDF', 'presupuestos2023Controller@guardarFacturaPDF')->name('ordenesNew.index')
         ->middleware('permission:ordenesNew.index');                    
         Route::post('/ordenesNew/guardarFacturaXML', 'presupuestos2023Controller@guardarFacturaXML')->name('ordenesNew.index')
         ->middleware('permission:ordenesNew.index'); 
         Route::post('/ordenesNew/guardarAcuse', 'presupuestos2023Controller@guardarAcuse')->name('ordenesNew.index')
         ->middleware('permission:ordenesNew.index');  
         Route::post('/ordenesNew/guardarEntrada', 'presupuestos2023Controller@guardarEntrada')->name('ordenesNew.index')
         ->middleware('permission:ordenesNew.index');     
         Route::post('/ordenesNew/guardarOrdenServicio', 'presupuestos2023Controller@guardarOrdenServicio')->name('ordenesNew.index')
         ->middleware('permission:ordenesNew.index');    
         Route::post('/ordenesNew/cambioStatus', 'presupuestos2023Controller@cambioStatus')->name('ordenesNew.index')
         ->middleware('permission:ordenesNew.index'); 
         Route::get('/ordenesNew/obtenerDetalles', 'presupuestos2023Controller@obtenerDetalles')->name('ordenesNew.index')
         ->middleware('permission:ordenesNew.index');  
         
         Route::post('/ordenesNew/tipo', 'presupuestos2023Controller@tipo')->name('ordenesNew.index')
         ->middleware('permission:ordenesNew.index'); 
         Route::post('/ordenesNew/categoria', 'presupuestos2023Controller@categoria')->name('ordenesNew.index')
         ->middleware('permission:ordenesNew.index'); 
 
         Route::put('/ordenesNew/desactivar', 'presupuestos2023Controller@desactivar')->name('ordenesNew.index')
         ->middleware('permission:ordenesNew.index');
    //Conceptos   
   
    Route::post('/conceptos/obtenerDetallesmulti', 'pCFEConceptosController@obtenerDetallesmulti')->name('ordenes.index')
            ->middleware('permission:ordenes.index');  
                    
            
    //DetalleConceptos
    Route::get('/detalleconceptos', 'pCFECarritoController@index')->name('ordenes.index')
            ->middleware('permission:ordenes.index');     
    Route::post('/detalleconceptos/registrar', 'pCFECarritoController@store')->name('ordenes.index')
            ->middleware('permission:ordenes.index'); 
   Route::get('/detalleconceptos/delete', 'pCFECarritoController@delete')->name('ordenes.index')
            ->middleware('permission:ordenes.index'); 
  Route::post('/detalleconceptos/actualizar', 'pCFECarritoController@update')->name('ordenes.index')
            ->middleware('permission:ordenes.index');  


  //DetalleConceptos
  Route::get('/ubicaciones', 'UbicacionesController@index')->name('ordenes.index')
  ->middleware('permission:ordenes.index');     
  Route::post('/ubicaciones/registrar', 'UbicacionesController@store')->name('ordenes.index')
  ->middleware('permission:ordenes.index');  
  Route::put('/ubicaciones/actualizar', 'UbicacionesController@update')->name('ordenes.index')
  ->middleware('permission:ordenes.index');   
  Route::post('/ubicaciones/desactivar', 'UbicacionesController@desactivar')->name('ordenes.index')
  ->middleware('permission:ordenes.index');    
  
  
    //DetalleConceptos
    Route::get('/areas', 'AreasController@index')->name('ordenes.index')
    ->middleware('permission:ordenes.index');     
    Route::post('/areas/registrar', 'AreasController@store')->name('ordenes.index')
    ->middleware('permission:ordenes.index');  
    Route::put('/areas/actualizar', 'AreasController@update')->name('ordenes.index')
    ->middleware('permission:ordenes.index');   
    Route::post('/areas/desactivar', 'AreasController@desactivar')->name('ordenes.index')
    ->middleware('permission:ordenes.index');  


      //DetalleConceptos
      Route::get('/categoriasCFE', 'CategoriasCFEController@index')->name('ordenes.index')
      ->middleware('permission:ordenes.index');     
      Route::post('/categoriasCFE/registrar', 'CategoriasCFEController@store')->name('ordenes.index')
      ->middleware('permission:ordenes.index');  
      Route::put('/categoriasCFE/actualizar', 'CategoriasCFEController@update')->name('ordenes.index')
      ->middleware('permission:ordenes.index');   
      Route::post('/categoriasCFE/desactivar', 'CategoriasCFEController@desactivar')->name('ordenes.index')
      ->middleware('permission:ordenes.index');  

           //DetalleConceptos
           Route::get('/categoriasAkumas', 'CategoriasAkumasController@index')->name('ordenes2.index')
           ->middleware('permission:ordenes2.index');     
           Route::post('/categoriasAkumas/registrar', 'CategoriasAkumasController@store')->name('ordenes2.index')
           ->middleware('permission:ordenes2.index');  
           Route::put('/categoriasAkumas/actualizar', 'CategoriasAkumasController@update')->name('ordenes2.index')
           ->middleware('permission:ordenes2.index');   
           Route::post('/categoriasAkumas/desactivar', 'CategoriasAkumasController@desactivar')->name('ordenes2.index')
           ->middleware('permission:ordenes2.index');
           
                      //DetalleConceptos
                      Route::get('/categoriasAkumas2024', 'CategoriasAkumas2024Controller@index')->name('ordenes2.index')
                      ->middleware('permission:ordenes2.index');     
                      Route::post('/categoriasAkumas2024/registrar', 'CategoriasAkumas2024Controller@store')->name('ordenes2.index')
                      ->middleware('permission:ordenes2.index');  
                      Route::put('/categoriasAkumas2024/actualizar', 'CategoriasAkumas2024Controller@update')->name('ordenes2.index')
                      ->middleware('permission:ordenes2.index');   
                      Route::post('/categoriasAkumas2024/desactivar', 'CategoriasAkumas2024Controller@desactivar')->name('ordenes2.index')
                      ->middleware('permission:ordenes2.index');  

        //DetalleConceptos
      Route::get('/tiposCFE', 'TiposCFEController@index')->name('ordenes.index')
      ->middleware('permission:ordenes.index');     
      Route::post('/tiposCFE/registrar', 'TiposCFEController@store')->name('ordenes.index')
      ->middleware('permission:ordenes.index');  
      Route::put('/tiposCFE/actualizar', 'TiposCFEController@update')->name('ordenes.index')
      ->middleware('permission:ordenes.index');   
      Route::post('/tiposCFE/desactivar', 'TiposCFEController@desactivar')->name('ordenes.index')
      ->middleware('permission:ordenes.index');  

           //DetalleConceptos
           Route::get('/tiposAkumas', 'TiposAkumasController@index')->name('ordenes2.index')
           ->middleware('permission:ordenes2.index');     
           Route::post('/tiposAkumas/registrar', 'TiposAkumasController@store')->name('ordenes2.index')
           ->middleware('permission:ordenes2.index');  
           Route::put('/tiposAkumas/actualizar', 'TiposAkumasController@update')->name('ordenes2.index')
           ->middleware('permission:ordenes2.index');   
           Route::post('/tiposAkumas/desactivar', 'TiposAkumasController@desactivar')->name('ordenes2.index')
           ->middleware('permission:ordenes2.index');      

                      //DetalleConceptos
                      Route::get('/tiposAkumas2024', 'TiposAkumas2024Controller@index')->name('ordenes2.index')
                      ->middleware('permission:ordenes2.index');     
                      Route::post('/tiposAkumas2024/registrar', 'TiposAkumas2024Controller@store')->name('ordenes2.index')
                      ->middleware('permission:ordenes2.index');  
                      Route::put('/tiposAkumas2024/actualizar', 'TiposAkumas2024Controller@update')->name('ordenes2.index')
                      ->middleware('permission:ordenes2.index');   
                      Route::post('/tiposAkumas2024/desactivar', 'TiposAkumas2024Controller@desactivar')->name('ordenes2.index')
                      ->middleware('permission:ordenes2.index');  

              //DetalleConceptos
      Route::get('/conceptosCFE', 'pCFEConceptosController@index')->name('ordenes.index')
      ->middleware('permission:ordenes.index');     
      Route::post('/conceptos/registrar', 'pCFEConceptosController@store')->name('ordenes.index')
      ->middleware('permission:ordenes.index'); 
      Route::get('/conceptos/selectConceptos', 'pCFEConceptosController@selectConceptos')->name('ordenes.index')
      ->middleware('permission:ordenes.index');


      Route::put('/conceptosCFE/actualizar', 'pCFEConceptosController@update')->name('ordenes.index')
      ->middleware('permission:ordenes.index');   
      Route::post('/conceptosCFE/desactivar', 'pCFEConceptosController@delete')->name('ordenes.index')
      ->middleware('permission:ordenes.index');  

           //DetalleConceptos
           Route::get('/conceptosAkumas', 'pConceptosController@index')->name('ordenes2.index')
           ->middleware('permission:ordenes2.index');     
           Route::post('/conceptosAkumas/registrar', 'pConceptosController@store')->name('ordenes2.index')
           ->middleware('permission:ordenes2.index');  
           Route::put('/conceptosAkumas/actualizar', 'pConceptosController@update')->name('ordenes2.index')
           ->middleware('permission:ordenes2.index');   
           Route::post('/conceptosAkumas/desactivar', 'pConceptosController@delete')->name('ordenes2.index')
           ->middleware('permission:ordenes2.index');    

          

        //Conceptos   
        Route::post('/conceptos2/registrar', 'pConceptosController@store')->name('ordenes2.index')
        ->middleware('permission:ordenes2.index');  
        Route::get('/conceptos2/selectConceptos', 'pConceptosController@selectConceptos')->name('ordenes2.index')
        ->middleware('permission:ordenes2.index');
        Route::post('/conceptos2/obtenerDetallesmulti', 'pConceptosController@obtenerDetallesmulti')->name('ordenes2.index')
        ->middleware('permission:ordenes2.index'); 
        Route::post('/conceptos2/delete', 'pConceptosController@delete')->name('ordenes2.index')
        ->middleware('permission:ordenes2.index'); 
        Route::post('/conceptos/delete', 'pCFEConceptosController@delete')->name('ordenes.index')
        ->middleware('permission:ordenes.index');     
        
      

           //DetalleConceptos
           Route::get('/conceptosAkumas2023', 'pConceptos2023Controller@index')->name('ordenesNew.index')
           ->middleware('permission:ordenesNew.index');     
           Route::post('/conceptosAkumas2023/registrar', 'pConceptos2023Controller@store')->name('ordenesNew.index')
           ->middleware('permission:ordenesNew.index');  
           Route::put('/conceptosAkumas2023/actualizar', 'pConceptos2023Controller@update')->name('ordenesNew.index')
           ->middleware('permission:ordenesNew.index');   
           Route::post('/conceptosAkumas2023/desactivar', 'pConceptos2023Controller@delete')->name('ordenesNew.index')
           ->middleware('permission:ordenesNew.index'); 
           Route::post('/conceptosAkumas2023/exelarchivo', 'pConceptos2023Controller@exelimport')->name('ordenesNew.index')
           ->middleware('permission:ordenesNew.index');     

        //Conceptos   
        Route::post('/conceptos2023/registrar', 'pConceptos2023Controller@store')->name('ordenesNew.index')
        ->middleware('permission:ordenesNew.index');  
        Route::get('/conceptos2023/selectConceptos', 'pConceptos2023Controller@selectConceptos')->name('ordenesNew.index')
        ->middleware('permission:ordenesNew.index');
        Route::post('/conceptos2023/obtenerDetallesmulti', 'pConceptos2023Controller@obtenerDetallesmulti')->name('ordenesNew.index')
        ->middleware('permission:ordenesNew.index'); 
        Route::post('/conceptos2023/delete', 'pConceptos2023Controller@delete')->name('ordenesNew.index')
        ->middleware('permission:ordenesNew.index'); 
        
                
        
        //DetalleConceptos
        Route::get('/detalleconceptos2', 'pCarritoController@index')->name('ordenes2.index')
        ->middleware('permission:ordenes2.index');     
        Route::post('/detalleconceptos2/registrar', 'pCarritoController@store')->name('ordenes2.index')
        ->middleware('permission:ordenes2.index'); 
        Route::get('/detalleconceptos2/delete', 'pCarritoController@delete')->name('ordenes2.index')
        ->middleware('permission:ordenes2.index'); 
        Route::post('/detalleconceptos2/actualizar', 'pCarritoController@update')->name('ordenes2.index')
        ->middleware('permission:ordenes2.index');  



        //DetalleConceptos
        Route::get('/detalleconceptos2023', 'pCarrito2023Controller@index')->name('ordenesNew.index')
        ->middleware('permission:ordenesNew.index');     
        Route::post('/detalleconceptos2023/registrar', 'pCarrito2023Controller@store')->name('ordenesNew.index')
        ->middleware('permission:ordenesNew.index'); 
        Route::post('/detalleconceptos2023h/registrar', 'pCarrito2023Controller@store2')->name('ordenesNew.index')
        ->middleware('permission:ordenesNew.index'); 
        Route::get('/detalleconceptos2023/delete', 'pCarrito2023Controller@delete')->name('ordenesNew.index')
        ->middleware('permission:ordenesNew.index'); 
        Route::post('/detalleconceptos2023/actualizar', 'pCarrito2023Controller@update')->name('ordenesNew.index')
        ->middleware('permission:ordenesNew.index');  


        //Mensajes
        Route::get('/mensajes', 'MensajesController@index')->name('ordenes2.index')
        ->middleware('permission:ordenes2.index');     
        Route::post('/mensajes/enviar', 'MensajesController@store')->name('ordenes2.index')
        ->middleware('permission:ordenes2.index'); 


        //Mensajes CFE
        Route::get('/mensajesCFE', 'MensajesCFEController@index')->name('ordenes.index')
        ->middleware('permission:ordenes.index');     
        Route::post('/mensajesCFE/enviar', 'MensajesCFEController@store')->name('ordenes.index')
        ->middleware('permission:ordenes.index'); 
    

            
    Route::get('/dashboard','DashboardController')->name('cfe.apcfe')
    ->middleware('permission:cfe.apcfe');     
            
            

    
    //Productos        
    Route::get('/productos', 'ProductosController@index')->name('productos.index')
    ->middleware('permission:productos.index');     
    Route::post('/productos/registrar', 'ProductosController@store')->name('productos.store')
    ->middleware('permission:productos.store');     
    Route::put('/productos/actualizar', 'ProductosController@update')->name('productos.update')
    ->middleware('permission:productos.update');  
    Route::get('/productos/selectProductos', 'ProductosController@selectProductos')->name('productos.index')
    ->middleware('permission:productos.index');  

    //ProductosGrupos        
    Route::get('/productosgrupos', 'ProductosGruposController@index')->name('productosgrupos.index')
    ->middleware('permission:productosgrupos.index');     
    Route::post('/productosgrupos/registrar', 'ProductosGruposController@store')->name('productosgrupos.store')
    ->middleware('permission:productosgrupos.store');     
    Route::put('/productosgrupos/actualizar', 'ProductosGruposController@update')->name('productosgrupos.update')
    ->middleware('permission:productosgrupos.update'); 
    Route::get('/productosgrupos/listarProductos', 'ProductosGruposController@listarProductos')->name('productosgrupos.index')
    ->middleware('permission:productosgrupos.index');     
    
    //Categorias
    Route::get('/categoria/selectCategoria', 'CategoriaController@selectCategoria')->name('categorias.index')
    ->middleware('permission:categorias.index');  
    Route::get('/categoria', 'CategoriaController@index')->name('categorias.index')
    ->middleware('permission:categorias.index');  
    Route::post('/categoria/registrar', 'CategoriaController@store')->name('categorias.store')
    ->middleware('permission:categorias.store');  
    Route::put('/categoria/actualizar', 'CategoriaController@update')->name('categorias.update')
    ->middleware('permission:categorias.update');  

    //Bancos
    Route::get('/bancos/selectBancos', 'BancosController@selectBancos')->name('bancos.index')
    ->middleware('permission:bancos.index');  
    Route::get('/bancos', 'BancosController@index')->name('bancos.index')
    ->middleware('permission:bancos.index');  
    Route::post('/bancos/registrar', 'BancosController@store')->name('bancos.store')
    ->middleware('permission:bancos.store');  
    Route::put('/bancos/actualizar', 'BancosController@update')->name('bancos.update')
    ->middleware('permission:bancos.update'); 

    //Cuentas
    Route::get('/cuentas/selectCuentas', 'CuentasController@selectCuentas')->name('cuentas.index')
    ->middleware('permission:cuentas.index');  
    Route::get('/cuentas', 'CuentasController@index')->name('cuentas.index')
    ->middleware('permission:cuentas.index');  
    Route::post('/cuentas/registrar', 'CuentasController@store')->name('cuentas.store')
    ->middleware('permission:cuentas.store');  
    Route::put('/cuentas/actualizar', 'CuentasController@update')->name('cuentas.update')
    ->middleware('permission:cuentas.update'); 


    Route::get('/facturacion/deleter', 'FacturasController@delete')->name('facturacion.index')
    ->middleware('permission:facturacion.index');

    //Caja

    Route::get('/caja', 'CajaController@index')->name('caja.index')
    ->middleware('permission:caja.index');  
    Route::post('/caja/registrar', 'CajaController@store')->name('caja.store')
    ->middleware('permission:caja.store');  
    Route::put('/caja/actualizar', 'CajaController@update')->name('caja.update')
    ->middleware('permission:caja.update'); 
    Route::post('/caja/delete', 'CajaController@delete')->name('caja.delete')
    ->middleware('permission:caja.delete'); 
    Route::get('/cajaFacturas', 'CajaController@selectFacturas')->name('caja.index')
    ->middleware('permission:caja.index');
    Route::post('/caja/subirXML', 'CajaController@updatearchivoXML')->name('caja.index')
    ->middleware('permission:caja.index'); 
    Route::post('/caja/subirPDF', 'CajaController@updatearchivoPDF')->name('caja.index')
    ->middleware('permission:caja.index'); 
    Route::post('/caja/guardarXML', 'CajaController@guardarFacturaXMLEfectivo')->name('caja.index')
    ->middleware('permission:caja.index');   
    Route::post('/caja/guardarPDF', 'CajaController@guardarFacturaPDFEfectivo')->name('caja.index')
    ->middleware('permission:caja.index');  
    Route::post('/caja/subir', 'CajaController@subir')->name('caja.index')
    ->middleware('permission:caja.index');
    Route::get('caja/archivos', 'CajaController@indexarchivos')->name('caja.index')
    ->middleware('permission:caja.index');
    Route::put('/caja/eliminar', 'CajaController@eliminar')->name('caja.index')
    ->middleware('permission:caja.index'); 


    Route::get('/cajaBancos', 'CajaBancosController@index')->name('caja.index')
    ->middleware('permission:caja.index');  
    Route::post('/cajaBancos/registrar', 'CajaBancosController@store')->name('caja.store')
    ->middleware('permission:caja.store');  
    Route::put('/cajaBancos/actualizar', 'CajaBancosController@update')->name('caja.update')
    ->middleware('permission:caja.update'); 
    Route::post('/cajaBancos/delete', 'CajaBancosController@delete')->name('caja.delete')
    ->middleware('permission:caja.delete'); 
    Route::post('/cajaBancos/subirXML', 'CajaBancosController@updatearchivoXML')->name('caja.index')
    ->middleware('permission:caja.index'); 
    Route::post('/cajaBancos/subirPDF', 'CajaBancosController@updatearchivoPDF')->name('caja.index')
    ->middleware('permission:caja.index'); 
    Route::post('/cajaBancos/guardarXML', 'CajaBancosController@guardarFacturaXMLBancos')->name('caja.index')
    ->middleware('permission:caja.index');   
    Route::post('/cajaBancos/guardarPDF', 'CajaBancosController@guardarFacturaPDFBancos')->name('caja.index')
    ->middleware('permission:caja.index');  
    


    Route::get('/saldos', 'SaldosController@index')->name('caja.index')
    ->middleware('permission:caja.index');  

    Route::get('/cajaFacturasBancos', 'CajaBancosController@selectFacturas')->name('caja.index')
    ->middleware('permission:caja.index');  

    //Grupos
    Route::get('/grupos/selectGrupos', 'GruposController@selectGrupos')->name('grupos.index')
    ->middleware('permission:grupos.index');  
    

    //EntradasSalidas

    Route::get('entradassalidas', 'EntradasSalidasController@index')->name('tareas.index')
    ->middleware('permission:tareas.index');
    Route::get('entradassalidas/buscar', 'EntradasSalidasController@index2')->name('tareas.index')
    ->middleware('permission:tareas.index');
    Route::post('/entradassalidas/registrar', 'EntradasSalidasController@store')->name('tareas.index')
    ->middleware('permission:tareas.index');
    Route::put('/entradassalidas/actualizar', 'EntradasSalidasController@update')->name('tareas.index')
    ->middleware('permission:tareas.index');
    Route::put('/entradassalidas/delete', 'EntradasSalidasController@delete')->name('tareas.index')
    ->middleware('permission:tareas.index');

    //OrdenesPagos

      Route::get('ordenespagadas', 'OrdenesPagadasController@index')->name('tareas.index')
      ->middleware('permission:tareas.index');
      Route::post('/ordenespagadas/registrar', 'OrdenesPagadasController@store')->name('tareas.index')
      ->middleware('permission:tareas.index');
      Route::put('/ordenespagadas/actualizar', 'OrdenesPagadasController@update')->name('tareas.index')
      ->middleware('permission:tareas.index');
      Route::put('/ordenespagadas/delete', 'OrdenesPagadasController@delete')->name('tareas.index')
      ->middleware('permission:tareas.index');

     //OrdenesForaneas

      Route::get('ordenesf', 'OrdenesForaneasController@index')->name('tareas.index')
      ->middleware('permission:tareas.index');
      Route::post('/ordenesf/registrar', 'OrdenesForaneasController@store')->name('tareas.index')
      ->middleware('permission:tareas.index');
      Route::put('/ordenesf/actualizar', 'OrdenesForaneasController@update')->name('tareas.index')
      ->middleware('permission:tareas.index');
      Route::put('/ordenesf/delete', 'OrdenesForaneasController@delete')->name('tareas.index')
      ->middleware('permission:tareas.index');

       //EntradasSalidas

    Route::get('eysf', 'ESForaneasController@index')->name('tareas.index')
    ->middleware('permission:tareas.index');
    Route::post('/eysf/registrar', 'ESForaneasController@store')->name('tareas.index')
    ->middleware('permission:tareas.index');
    Route::put('/eysf/actualizar', 'ESForaneasController@update')->name('tareas.index')
    ->middleware('permission:tareas.index');
    Route::put('/eysf/delete', 'ESForaneasController@delete')->name('tareas.index')
    ->middleware('permission:tareas.index');

    
    //NuevasOrdenesForaneas
     //Ordenes       
     Route::get('/ordenesForaneas', 'AnexosForaneosController@index')->name('cfbForaneos.index')
     ->middleware('permission:cfbForaneos.index');
     Route::get('/ordenesForaneas/start', 'AnexosForaneosController@indexStart')->name('cfbForaneos.index')
     ->middleware('permission:cfbForaneos.index');
     Route::post('/ordenesForaneas/registrar', 'AnexosForaneosController@store')->name('cfbForaneos.index')
     ->middleware('permission:cfbForaneos.index');  
     Route::post('/ordenesForaneas/update', 'AnexosForaneosController@update')->name('cfbForaneos.index')
     ->middleware('permission:cfbForaneos.index');   
     Route::get('/ordenesForaneas/selectCategorias', 'AnexosForaneosController@selectCategorias')->name('cfbForaneos.index')
     ->middleware('permission:cfbForaneos.index');  
     Route::get('/ordenesForaneas/selectTipos', 'AnexosForaneosController@selectTipos')->name('cfbForaneos.index')
     ->middleware('permission:cfbForaneos.index');  
     Route::get('/ordenesForaneas/pdf/{id}', 'AnexosForaneosController@pdf')->name('cfbForaneos.index')
     ->middleware('permission:cfbForaneos.index');  
     Route::get('/ordenesForaneas/pdfAcuse/{id}', 'AnexosForaneosController@pdfacuse')->name('cfbForaneos.index')
     ->middleware('permission:cfbForaneos.index');         
     Route::get('/ordenesForaneas/pdfCFE/{id}', 'AnexosForaneosController@pdfcfe')->name('cfbForaneos.index')
     ->middleware('permission:cfbForaneos.index');           
     Route::post('/ordenesForaneas/subirarchivos', 'AnexosForaneosController@updatearchivos')->name('cfbForaneos.index')
     ->middleware('permission:cfbForaneos.index');   
     Route::post('/ordenesForaneas/subirarchivos2', 'AnexosForaneosController@updatearchivos2')->name('cfbForaneos.index')
     ->middleware('permission:cfbForaneos.index');  
     Route::post('/ordenesForaneas/subirarchivos3', 'AnexosForaneosController@updatearchivos3')->name('cfbForaneos.index')
     ->middleware('permission:cfbForaneos.index');
     Route::post('/ordenesForaneas/subirarchivos4', 'AnexosForaneosController@updatearchivos4')->name('cfbForaneos.index')
     ->middleware('permission:cfbForaneos.index');  
     Route::post('/ordenesForaneas/subirarchivos5', 'AnexosForaneosController@updatearchivos5')->name('cfbForaneos.index')
     ->middleware('permission:cfbForaneos.index');                     
     Route::post('/ordenesForaneas/subirarchivos6', 'AnexosForaneosController@updatearchivos6')->name('cfbForaneos.index')
     ->middleware('permission:cfbForaneos.index');  
     Route::post('/ordenesForaneas/subirarchivos7', 'AnexosForaneosController@updatearchivos7')->name('cfbForaneos.index')
     ->middleware('permission:cfbForaneos.index'); 
     Route::post('/ordenesForaneas/subirarchivos8', 'AnexosForaneosController@updatearchivos8')->name('cfbForaneos.index')
     ->middleware('permission:cfbForaneos.index'); 
     Route::post('/ordenesForaneas/subirarchivos9', 'AnexosForaneosController@updatearchivos9')->name('cfbForaneos.index')
     ->middleware('permission:cfbForaneos.index'); 
     
     


     Route::post('/ordenesForaneas/guardarFotoVieja', 'AnexosForaneosController@guardarFotoVieja')->name('cfbForaneos.index')
     ->middleware('permission:cfbForaneos.index');    
     Route::post('/ordenesForaneas/guardarFotoNueva', 'AnexosForaneosController@guardarFotoNueva')->name('cfbForaneos.index')
     ->middleware('permission:cfbForaneos.index');                                  
     Route::post('/ordenesForaneas/guardarFotoInstalada', 'AnexosForaneosController@guardarFotoInstalada')->name('cfbForaneos.index')
     ->middleware('permission:cfbForaneos.index'); 
     Route::post('/ordenesForaneas/guardarReporteAnomalias', 'AnexosForaneosController@guardarReporteAnomalias')->name('cfbForaneos.index')
     ->middleware('permission:cfbForaneos.index');
     Route::post('/ordenesForaneas/guardarFacturaPDF', 'AnexosForaneosController@guardarFacturaPDF')->name('cfbForaneos.index')
     ->middleware('permission:cfbForaneos.index');                    
     Route::post('/ordenesForaneas/guardarFacturaXML', 'AnexosForaneosController@guardarFacturaXML')->name('cfbForaneos.index')
     ->middleware('permission:cfbForaneos.index'); 
     Route::post('/ordenesForaneas/guardarAcuse', 'AnexosForaneosController@guardarAcuse')->name('cfbForaneos.index')
     ->middleware('permission:cfbForaneos.index');  
     Route::post('/ordenesForaneas/guardarEntrada', 'AnexosForaneosController@guardarEntrada')->name('cfbForaneos.index')
     ->middleware('permission:cfbForaneos.index');     
     Route::post('/ordenesForaneas/guardarOrdenServicio', 'AnexosForaneosController@guardarOrdenServicio')->name('cfbForaneos.index')
     ->middleware('permission:cfbForaneos.index');    
     Route::post('/ordenesForaneas/cambioStatus', 'AnexosForaneosController@cambioStatus')->name('cfbForaneos.index')
     ->middleware('permission:cfbForaneos.index'); 
     Route::get('/ordenesForaneas/obtenerDetalles', 'AnexosForaneosController@obtenerDetalles')->name('cfbForaneos.index')
     ->middleware('permission:cfbForaneos.index');  
     
     Route::post('/ordenesForaneas/tipo', 'AnexosForaneosController@tipo')->name('cfbForaneos.index')
     ->middleware('permission:cfbForaneos.index'); 
     Route::post('/ordenesForaneas/categoria', 'AnexosForaneosController@categoria')->name('cfbForaneos.index')
     ->middleware('permission:cfbForaneos.index'); 

     Route::put('/ordenesForaneas/desactivar', 'AnexosForaneosController@desactivar')->name('cfbForaneos.index')
     ->middleware('permission:cfbForaneos.index');

      //DetalleConceptos
      Route::get('/afconceptos', 'AFConceptosController@index')->name('cfbForaneos.index')
      ->middleware('permission:cfbForaneos.index');     
      Route::put('/afconceptos/actualizar', 'AFConceptosController@update')->name('cfbForaneos.index')
      ->middleware('permission:cfbForaneos.index');   
      Route::post('/afconceptos/exelarchivo', 'AFConceptosController@exelimport')->name('cfbForaneos.index')
      ->middleware('permission:cfbForaneos.index');     
      Route::post('/afconceptos/registrar', 'AFConceptosController@store')->name('cfbForaneos.index')
      ->middleware('permission:cfbForaneos.index');  
      Route::get('/afconceptos/selectConceptos', 'AFConceptosController@selectConceptos')->name('cfbForaneos.index')
      ->middleware('permission:cfbForaneos.index');
      Route::post('/afconceptos/obtenerDetallesmulti', 'AFConceptosController@obtenerDetallesmulti')->name('cfbForaneos.index')
      ->middleware('permission:cfbForaneos.index'); 
      Route::post('/afconceptos/delete', 'AFConceptosController@delete')->name('cfbForaneos.index')
      ->middleware('permission:cfbForaneos.index'); 

        //DetalleConceptos
        Route::get('/detalleCarritoAF', 'AFCarritoController@index')->name('cfbForaneos.index')
        ->middleware('permission:cfbForaneos.index');     
        Route::post('/detalleCarritoAF/registrar', 'AFCarritoController@store')->name('cfbForaneos.index')
        ->middleware('permission:cfbForaneos.index'); 
        Route::get('/detalleCarritoAF/delete', 'AFCarritoController@delete')->name('cfbForaneos.index')
        ->middleware('permission:cfbForaneos.index'); 
        Route::post('/detalleCarritoAF/actualizar', 'AFCarritoController@update')->name('cfbForaneos.index')
        ->middleware('permission:cfbForaneos.index');  

        //AnexosForaneosRecepcionAcuse
        Route::get('/anexosFRA', 'anexosForaneosRecepcionAcuseController@index')->name('cfbForaneos.index')
        ->middleware('permission:cfbForaneos.index');     
        Route::post('/anexosFRA/registrar', 'anexosForaneosRecepcionAcuseController@store')->name('cfbForaneos.index')
        ->middleware('permission:cfbForaneos.index'); 
        Route::put('/anexosFRA/delete', 'anexosForaneosRecepcionAcuseController@delete')->name('cfbForaneos.index')
        ->middleware('permission:cfbForaneos.index'); 
        Route::post('/anexosFRA/actualizar', 'anexosForaneosRecepcionAcuseController@update')->name('cfbForaneos.index')
        ->middleware('permission:cfbForaneos.index');  
        Route::get('/anexosFRA/pdfAcuse/{id}', 'anexosForaneosRecepcionAcuseController@pdfacuse')->name('cfbForaneos.index')
        ->middleware('permission:cfbForaneos.index');     


        //DetalleConceptos
        Route::get('/categoriasForaneas', 'AFCategoriasController@index')->name('cfbForaneos.index')
        ->middleware('permission:cfbForaneos.index');     
        Route::post('/categoriasForaneas/registrar', 'AFCategoriasController@store')->name('cfbForaneos.index')
        ->middleware('permission:cfbForaneos.index');  
        Route::put('/categoriasForaneas/actualizar', 'AFCategoriasController@update')->name('cfbForaneos.index')
        ->middleware('permission:cfbForaneos.index');   
        Route::post('/categoriasForaneas/desactivar', 'AFCategoriasController@desactivar')->name('cfbForaneos.index')
        ->middleware('permission:cfbForaneos.index');  

        //DetalleConceptos
        Route::get('/tiposForaneos', 'AFTiposController@index')->name('cfbForaneos.index')
        ->middleware('permission:cfbForaneos.index');     
        Route::post('/tiposForaneos/registrar', 'AFTiposController@store')->name('cfbForaneos.index')
        ->middleware('permission:cfbForaneos.index');  
        Route::put('/tiposForaneos/actualizar', 'AFTiposController@update')->name('cfbForaneos.index')
        ->middleware('permission:cfbForaneos.index');   
        Route::post('/tiposForaneos/desactivar', 'AFTiposController@desactivar')->name('cfbForaneos.index')
        ->middleware('permission:cfbForaneos.index');  



});



//Notificaciones
Route::post('/notification/get','NotificationController@get');


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/homevue', 'HomevueController@index')->name('homevue');
Route::get('/homevue2', 'Homevue2Controller@index')->name('homevue2');

Route::get('/categoria', 'CategoriaController@index');
Route::post('/categoria/registrar', 'CategoriaController@store');
Route::put('/categoria/actualizar', 'CategoriaController@update');
Route::put('/categoria/desactivar', 'CategoriaController@desactivar');
Route::put('/categoria/activar', 'CategoriaController@activar');

Route::get('/articulo', 'ArticuloController@index');
Route::get('/articulo/buscarunidades', 'ArticuloController@buscarunidades');
Route::get('/articulo/buscarcodigos', 'ArticuloController@buscarcodigos');
Route::post('/articulo/registrar', 'ArticuloController@store');
Route::put('/articulo/actualizar', 'ArticuloController@update');
Route::put('/articulo/desactivar', 'ArticuloController@desactivar');
Route::put('/articulo/activar', 'ArticuloController@activar');
Route::get('/articulo/buscarArticulo', 'ArticuloController@buscarArticulo');
Route::get('/articulo/listarArticulo', 'ArticuloController@listarArticulo');
Route::get('/articulo/listarArticuloVenta', 'ArticuloController@listarArticuloVenta');
Route::get('/articulo/buscarArticuloVenta', 'ArticuloController@buscarArticuloVenta');
Route::get('/articulo/listarPdf', 'ArticuloController@listarPdf')->name('articulos_pdf');
Route::get('/articulo/selectArticulo', 'ArticuloController@selectArticulo');

Route::get('/proveedor', 'ProveedorController@index');
Route::post('/proveedor/registrar', 'ProveedorController@store');
Route::put('/proveedor/actualizar', 'ProveedorController@update');
Route::get('/proveedor/selectProveedor', 'ProveedorController@selectProveedor');

Route::get('/cliente', 'ClienteController@index');
Route::post('/cliente/registrar', 'ClienteController@store');
Route::put('/cliente/actualizar', 'ClienteController@update');
Route::get('/cliente/selectCliente', 'ClienteController@selectCliente');

Route::get('/venta', 'VentaController@index');
Route::post('/venta/registrar', 'VentaController@store');
Route::put('/venta/desactivar', 'VentaController@desactivar');
Route::get('/venta/obtenerCabecera', 'VentaController@obtenerCabecera');
Route::get('/venta/obtenerDetalles', 'VentaController@obtenerDetalles');
Route::get('/venta/pdf/{id}', 'VentaController@pdf')->name('venta_pdf');
Route::get('/ordenesCFExel', 'presupuestosCFEController@exel')->name('venta_pdf'); 


Route::get('/ingreso', 'IngresoController@index');
Route::post('/ingreso/registrar', 'IngresoController@store');
Route::put('/ingreso/desactivar', 'IngresoController@desactivar');
Route::get('/ingreso/obtenerCabecera', 'IngresoController@obtenerCabecera');
Route::get('/ingreso/obtenerDetalles', 'IngresoController@obtenerDetalles');

Route::get('/cotizacion', 'CotizacionesController@index');
Route::post('/cotizacion/registrar', 'CotizacionesController@store');
Route::put('/cotizacion/desactivar', 'CotizacionesController@desactivar');
Route::get('/cotizacion/obtenerCabecera', 'CotizacionesController@obtenerCabecera');
Route::get('/cotizacion/obtenerDetalles', 'CotizacionesController@obtenerDetalles');
Route::get('/cotizacion/pdf/{id}', 'CotizacionesController@pdf')->name('cotizacion_pdf');

Route::get('/recepcion/reporte/{id}', 'RecepcionVehicularController@reporte')->name('reporte_web');

Route::get('/ordenes/verFotosViejas', 'presupuestosCFEController@verFotosViejas');
Route::get('/ordenes/verReporteAnomalias', 'presupuestosCFEController@verReporteAnomalias');
Route::get('/ordenes/verFotosNuevas', 'presupuestosCFEController@verFotosNuevas');
Route::get('/ordenes/verFotosInstaladas', 'presupuestosCFEController@verFotosInstaladas');
Route::get('/ordenes/verAcuse', 'presupuestosCFEController@verAcuse');
Route::get('/ordenes/verOrdenServicio', 'presupuestosCFEController@verOrdenServicio');
Route::get('/ordenes/verEntrada', 'presupuestosCFEController@verOrdenEntrada');
Route::get('/ordenes/verFacturaXML', 'presupuestosCFEController@verFacturaXML');
Route::get('/ordenes/verFacturaPDF', 'presupuestosCFEController@verFacturaPDF');
Route::get('/ordenes/factura', 'presupuestosCFEController@factura');

Route::get('/tecnicos/verOrden', 'TecnicosController@verOrden');

Route::get('/ordenes2/verFotosViejas', 'presupuestosController@verFotosViejas');
Route::get('/ordenes2/verReporteAnomalias', 'presupuestosController@verReporteAnomalias');
Route::get('/ordenes2/verFotosNuevas', 'presupuestosController@verFotosNuevas');
Route::get('/ordenes2/verFotosInstaladas', 'presupuestosController@verFotosInstaladas');
Route::get('/ordenes2/verAcuse', 'presupuestosController@verAcuse');
Route::get('/ordenes2/verOrdenServicio', 'presupuestosController@verOrdenServicio');
Route::get('/ordenes2/verEntrada', 'presupuestosController@verOrdenEntrada');
Route::get('/ordenes2/verFacturaXML', 'presupuestosController@verFacturaXML');
Route::get('/ordenes2/verFacturaPDF', 'presupuestosController@verFacturaPDF');
Route::get('/ordenes2/factura', 'presupuestosController@factura');


Route::get('/ordenesNew/verFotosViejas', 'presupuestos2023Controller@verFotosViejas');
Route::get('/ordenesNew/verReporteAnomalias', 'presupuestos2023Controller@verReporteAnomalias');
Route::get('/ordenesNew/verFotosNuevas', 'presupuestos2023Controller@verFotosNuevas');
Route::get('/ordenesNew/verFotosInstaladas', 'presupuestos2023Controller@verFotosInstaladas');
Route::get('/ordenesNew/verAcuse', 'presupuestos2023Controller@verAcuse');
Route::get('/ordenesNew/verOrdenServicio', 'presupuestos2023Controller@verOrdenServicio');
Route::get('/ordenesNew/verEntrada', 'presupuestos2023Controller@verOrdenEntrada');
Route::get('/ordenesNew/verFacturaXML', 'presupuestos2023Controller@verFacturaXML');
Route::get('/ordenesNew/verFacturaPDF', 'presupuestos2023Controller@verFacturaPDF');
Route::get('/ordenesNew/factura', 'presupuestos2023Controller@factura');

Route::get('/ordenesForaneas/verFotosViejas', 'AnexosForaneosController@verFotosViejas');
Route::get('/ordenesForaneas/verReporteAnomalias', 'AnexosForaneosController@verReporteAnomalias');
Route::get('/ordenesForaneas/verFotosNuevas', 'AnexosForaneosController@verFotosNuevas');
Route::get('/ordenesForaneas/verFotosInstaladas', 'AnexosForaneosController@verFotosInstaladas');
Route::get('/ordenesForaneas/verAcuse', 'AnexosForaneosController@verAcuse');
Route::get('/ordenesForaneas/verOrdenServicio', 'AnexosForaneosController@verOrdenServicio');
Route::get('/ordenesForaneas/verEntrada', 'AnexosForaneosController@verOrdenEntrada');
Route::get('/ordenesForaneas/verFacturaXML', 'AnexosForaneosController@verFacturaXML');
Route::get('/ordenesForaneas/verFacturaPDF', 'AnexosForaneosController@verFacturaPDF');
Route::get('/ordenesForaneas/factura', 'AnexosForaneosController@factura');


Route::get('/recepcion/folioBuscar', 'RecepcionVehicularController@folioBuscar');

Route::get('/facturacion', 'FacturasController@index');
Route::get('/facturacionPorCobrar', 'FacturasController@porcobrar');
Route::get('/facturacionPorContrato', 'FacturasController@porcontrato');
Route::get('/facturacion/open', 'FacturasController@indexSave');
Route::post('/facturacion/timbrar', 'FacturasController@store');
Route::post('/facturacion/timbrarmas', 'FacturasController@storemas');
Route::post('/facturacion/timbrarPago', 'FacturasController@storePago');
Route::post('/facturacion/timbrarprevia', 'FacturasController@storeprevia');
Route::post('/facturacion/timbrarpreviamas', 'FacturasController@storepreviamas');
Route::post('/facturacion/timbrarpreviasave', 'FacturasController@storepreviasave');
Route::post('/facturacion/timbrar2', 'FacturasController@store2');
Route::post('/facturacion/timbrar3', 'FacturasController@store3');
Route::post('/facturacion/timbrar4', 'FacturasController@store4');
Route::post('/facturacion/cancelar', 'FacturasController@cancelar');
Route::put('/facturacion/desactivar', 'CotizacionesController@desactivar');
Route::get('/facturacion/obtenerCabecera', 'FacturasController@obtenerCabecera');
Route::get('/facturacion/obtenerDetalles', 'FacturasController@obtenerDetalles');
Route::get('/facturacion/pdf/{id}', 'FacturasController@pdf')->name('cotizacion_pdf');
Route::post('/facturacion/actualizar', 'FacturasController@update');

Route::get('/emisores', 'ConfigurarFacturaController@indexAll');
Route::put('/config-factura', 'ConfigurarFacturaController@index');
Route::put('/config-factura/actualizar', 'ConfigurarFacturaController@update');
Route::put('/config-factura/registrar', 'ConfigurarFacturaController@store');

Route::get('/empresa/selectEmpresa', 'EmpresaController@selectEmpresa');
Route::get('/facturas/selectFacturas', 'FacturasController@selectFacturas');

Route::get('{slug?}', 'HomeController@index')->name('home');



//Empresas
//Empresas
Route::prefix('empresas')->middleware('auth')->name('empresas.')->group(function(){
    Route::get('index','EmpresaController@index')->name('index');
    Route::get('nombres','EmpresaController@nombres')->name('nombres');
    Route::post('store','EmpresaController@store')->name('store');
    Route::post('search','EmpresaController@search')->name('search');
    Route::post('update','EmpresaController@update')->name('update');
    Route::post('destroy','EmpresaController@destroy')->name('destroy');
    Route::get('customers/{empresa_id}','EmpresaController@customers')->name('customers');
});
//Estado Equipo
Route::prefix('estado-equipo')->middleware('auth')->name('estado-equipo.')->group(function(){
    Route::get('index','EstadoEquipoController@index')->name('index');
});

//Colores
Route::prefix('colores')->middleware('auth')->name('colores.')->group(function(){
    Route::get('nombres','ColorController@nombres')->name('nombres');
    Route::post('store','ColorController@store')->name('store');
    Route::post('search','ColorController@search')->name('search');
    Route::post('update','ColorController@update')->name('update');
    Route::post('destroy','ColorController@destroy')->name('destroy');
});

//Customers
Route::prefix('customers')->middleware('auth')->name('customers.')->group(function(){
    Route::get('index','CustomerController@index')->name('index');
    Route::post('store','CustomerController@store')->name('store');
    Route::post('search','CustomerController@search')->name('search');
    Route::post('update','CustomerController@update')->name('update');
    Route::post('destroy','CustomerController@destroy')->name('destroy');
    Route::post('empresa','CustomerController@empresa')->name('destroy');
    Route::get('particulares', 'CustomerController@particulares')->name('particulares');
});


//Marcas
Route::prefix('marcas')->middleware('auth')->name('marcas.')->group(function(){
    Route::get('index','MarcaController@index')->name('index');
    Route::get('nombres','MarcaController@nombres')->name('nombres');
    Route::post('store','MarcaController@store')->name('store');
    Route::post('search','MarcaController@search')->name('search');
    Route::post('update','MarcaController@update')->name('update');
    Route::post('destroy','MarcaController@destroy')->name('destroy');
    Route::post('empresa','MarcaController@empresa')->name('destroy');
    Route::get('modelos/{marca_id}','MarcaController@marcas')->name('customers');
});

//Modelos
Route::prefix('modelos')->middleware('auth')->name('modelos.')->group(function(){
    Route::get('nombres','ModeloController@nombres')->name('nombres');
    Route::post('store','ModeloController@store')->name('store');
    Route::post('search','ModeloController@search')->name('search');
    Route::post('update','ModeloController@update')->name('update');
    Route::post('destroy','ModeloController@destroy')->name('destroy');
    Route::post('empresa','ModeloController@empresa')->name('destroy');
});

//Recepcion vehicular
Route::prefix('recepcion')->middleware('auth')->name('recepcion.')->group(function(){
    Route::get('index','RecepcionVehicularController@index')->name('index');
    Route::post('store','RecepcionVehicularController@store')->name('store');
    Route::get('{id}/edit','RecepcionVehicularController@edit')->name('edit');
});

Route::put('recepcion/{id}','RecepcionVehicularController@update');


//Tipos vehiculos
Route::prefix('tipos')->middleware('auth')->name('tipos.')->group(function(){
    Route::get('nombres','TipoAutoController@nombres')->name('nombres');
});


//Vehiculos
Route::prefix('vehiculos')->middleware('auth')->name('vehiculos.')->group(function(){
    Route::get('index','VehiculoController@index')->name('index');
    Route::post('store','VehiculoController@store')->name('store');
    Route::post('search','VehiculoController@search')->name('search');
    Route::post('update','VehiculoController@update')->name('update');
    Route::post('destroy','VehiculoController@destroy')->name('destroy');
});

Route::get('/download/{file}' , 'DescargasController@downloadFile');
Route::get('/downloadxml/{file}' , 'DescargasController@downloadFileXML');
Route::get('/downloadpdf/{file}' , 'DescargasController@downloadFilePDF');
Route::get('tareas/download/{file}' , 'TareasController@downloadFile');
Route::get('recepcionO2023/download/{file}' , 'RecepcionVehicularController@downloadFile');
Route::get('tecnicos/download/{file}' , 'TecnicosController@downloadFile');
Route::get('trasladistas/download/{file}' , 'TrasladistasController@downloadFile');
Route::get('caja/download/{file}' , 'CajaController@downloadFile');

//Inspeccion tecnica de vehiculo
Route::resource('InspeccionTecnicaVehiculo', 'InspeccionTecnicaVehiculoController');
Route::prefix('inspeccion')->middleware('auth')->name('inspeccion.')->group(function(){
    Route::get('index','InspeccionTecnicaVehiculoController@index')->name('index');
});
Route::get('/inspeccion/reporte/{id}', 'InspeccionTecnicaVehiculoController@reporte');
Route::put('inspeccion/{id}','InspeccionTecnicaVehiculoController@update');

//Hoja de Concepto
Route::get('conceptos/{id}', 'HojaConceptoController@conceptos');
Route::get('hojaConcepto/{id}', 'HojaConceptoController@getOrdenSeguimiento');
Route::get('tecnicos/get', 'HojaConceptoController@getTecnicos');
Route::get('articulo/get', 'HojaConceptoController@getArticulo');
Route::post('conceptos/store', 'HojaConceptoController@store');
Route::post('conceptos/Agregar', 'HojaConceptoController@storeConcepto');
Route::post('conceptos/update', 'HojaConceptoController@updateConceptos');
Route::get('hojaConcepto/reporte/{id}', 'HojaConceptoController@reporte');
Route::get('hojaConceptos/{odes}/edit', 'HojaConceptoController@edit');
Route::put('hojaConceptos/{id}', 'HojaConceptoController@update');
Route::delete('concepto/{numConcepto}/{id}', 'HojaConceptoController@delete');
Route::delete('hojaconcepto/{id}', 'HojaConceptoController@deletehoja');
Route::prefix('hojaConceptos')->middleware('auth')->name('hojaConceptos.')->group(function(){
    Route::get('index', 'HojaConceptoController@index')->name('index');
});

//Orden de Compra
Route::post('ordenCompra', 'OrdenCompraController@store')->name('ordenCompra.store');
Route::get('articulo/partes/get','OrdenCompraController@getPartes');
Route::get('ordenCompra/{id}', 'OrdenCompraController@show');
Route::get('listOrdenCompra/index', 'OrdenCompraController@index');
Route::get('ordenCompra/{id}/edit','OrdenCompraController@edit');
Route::put('ordenCompra/{id}', 'OrdenCompraController@update');
Route::get('ordenCompra/reporte/{id}', 'HojaConceptoController@reporteOrden');
Route::get('/ordenes/obtenerDetallesmultiExel', 'presupuestosCFEController@obtenerDetallesmultiExel')->name('venta_exel');


//nuevas 
Route::post('ordenCompra4', 'OrdenCompraController@store4')->name('ordenCompra.store');
Route::post('ordenCompra3', 'OrdenCompraController@store3')->name('ordenCompra.store');

Route::get('conceptos4/{id}', 'HojaConceptoController@conceptos4');
Route::get('conceptos3/{id}', 'HojaConceptoController@conceptos3');

Route::post('conceptos4/update', 'HojaConceptoController@updateConceptos4');
Route::post('conceptos3/update', 'HojaConceptoController@updateConceptos3');

Route::get('hojaConcepto4/reporte/{id}', 'HojaConceptoController@reporte4');
Route::get('hojaConcepto3/reporte/{id}', 'HojaConceptoController@reporte3');

Route::get('ordenCompra4/reporte/{id}', 'HojaConceptoController@reporteOrden4');
Route::get('ordenCompra3/reporte/{id}', 'HojaConceptoController@reporteOrden3');

Route::delete('concepto4/{numConcepto}/{id}', 'HojaConceptoController@delete4');
Route::delete('concepto3/{numConcepto}/{id}', 'HojaConceptoController@delete3');



//Asignar Tecnico a Recepción
Route::put('asignarTecnico/{id}','AsignarTecnicoRecepcionController@update');

//Mi recepciones
Route::get('mirecepciones/getestatus', 'MiRecepcionesController@getEstatus');
Route::put('asignarEstatus/{id}', 'MiRecepcionesController@update');


//Orden Reparacion
Route::get('ordenReparacion/recepcion/{id}', 'OrdenReparacionController@getRecepcion');
Route::get('/user/login', 'UserController@login');

Route::get('/conceptosAkumas2023/exportar', 'pConceptos2023Controller@exel')->name('conceptos_exel');
