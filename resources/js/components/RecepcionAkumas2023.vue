<template>
    <main class="main">
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify mr-2"></i> Recepción Vehícular
                    <button class="btn btn-secondary float-right" type="button" @click="vistaRecepcionRegistrar">
                        <i class="fa fa-plus-circle mr-2"></i>Agregar
                    </button>
                </div>

                <!-- Listado de recepciones vehiculaes-->
                <template v-if="registrarRecepcion == 0">
                    <div class="card-body">
                        <div class="form-group">
                            <div class="col-12 col-md-6 offset-md-3">
                                <div class="text-center">
                                    <div class="input-group">
                                        <input type="text" v-model="buscar" @keyup.enter="listarRecepciones(1,buscar)"
                                               class="form-control" placeholder="Buscar...">
                                        <button type="submit" @click="listarRecepciones(1,buscar)"
                                                class="btn btn-primary"><i class="fa fa-search"></i> Buscar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                <tr>
                                    <th>No. Orden</th>
                                    <th>Orden seguimiento</th>
                                    <th>Folio</th>
                                    <th>Empresa</th>
                                    <th>Vehículo</th>
                                    <th>Fecha recepción</th>
                                    <th>Fecha compromiso</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="recepcion in listaRecepciones" :key="listaRecepciones.id">
                                    <td v-text="recepcion.folioNum"></td>
                                    <td v-text="recepcion.orden_seguimiento"></td>
                                    <td v-text="recepcion.folio"></td>
                                    <td v-text="recepcion.empresa.nombre"></td>
                                    <td>{{recepcion.vehiculo.placas}} - {{recepcion.vehiculo.marca.nombre}} - {{recepcion.vehiculo.modelo.nombre}}</td>
                                    <td v-text="recepcion.fecha"></td>
                                    <td v-text="recepcion.fecha_compromiso"></td>
                                    <td>
                                        <button class="btn btn-primary" @click="reporte(recepcion.id)">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </button>
                                        <button class="btn btn-warning" v-on:click="editRecepcion(recepcion.id)">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                        </button>
                                        <button class="btn btn-danger" v-on:click="deleter(recepcion.id)">
                                            <i class="icon-trash" aria-hidden="true"></i>
                                        </button>
                                        <button class="btn btn-info"  v-on:click="crearPresupuesto(recepcion.folioNum,recepcion.empresa.id)">
                                            <i class="icon-doc" aria-hidden="true"></i>
                                        </button>
                                        <button class="btn btn-success"  v-on:click="fotos(recepcion.id)">
                                            <i class="icon-picture" aria-hidden="true"></i>
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#"
                                       @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page"
                                    :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)"
                                       v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#"
                                       @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </template>
                <!--Fin Listado-->

                <!--Formulario registrar actualizar-->
                <template v-if="registrarRecepcion == 1">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-plus-circle mr-2"></i>Nueva recepción
                            <small class="badge badge-pill badge-secondary px-2">
                                <i class="fa fa-asterisk mr-2" aria-hidden="true"></i>campos obligatorios
                            </small>
                        </div>
                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="my-4">
                                    <div class="col-12">
                                        <div class="alert alert-danger"
                                             v-if="erroresModeloRecepcion !== null">
                                            <p class="h3">Errores de validación</p>
                                            <ul v-for="errores in erroresModeloRecepcion">
                                                <li v-for="error in errores">
                                                    {{error}}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="my-4">
                                    <p class="h5 text-uppercase font-weight-bold  border-bottom">Datos Generales</p>
                                    <div class="row">
                                        <div class="col-12 col-lg-4">
                                            <div class="form-group">
                                                <label for="order-id">Folio<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                <input id="order-id" class="form-control" type="text"
                                                       placeholder="Ej. 100A" v-model="modeloRecepcion.orden_seguimiento">
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <div class="form-group">
                                                <label for="folio-id">ID</label>
                                                <input id="folio-id" class="form-control" type="text"
                                                       placeholder="Ej. 100ABC" v-model="modeloRecepcion.folio">
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <div class="form-group">
                                                <label for="fecha-id">Fecha<i
                                                        class="fa fa-asterisk  text-secundary ml-2"></i></label>
                                                <datetime input-id="fecha-id" input-class="form-control" type="datetime"
                                                v-model="modeloRecepcion.fecha">
                                                    <template slot="button-cancel">
                                                        <i class="fa fa-times mr-2"></i>Cancelar
                                                    </template>
                                                    <template slot="button-confirm">
                                                        <i class="fa fa-check-circle mr-2"></i>Aceptar
                                                    </template>
                                                </datetime>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Cliente y vehiculo-->
                                <div class="my-4">
                                    <div class="row" v-if="!registrarEmpresa && !registrarCliente">
                                        <div class="col-12">
                                            <p class="h5 text-uppercase font-weight-bold  border-bottom">Datos del
                                                cliente</p>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="empresa-id">Empresa</label>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <v-select id="empresa-id" class="col-"
                                                                  :options="listaEmpresas"
                                                                  :reduce="label => label.code"
                                                                  v-model="modeloRecepcion.empresa_id"
                                                                  @change="listarEmpresaClientes"
                                                        ></v-select>
                                                    </div>
                                                    <div class="col-12 mt-2 text-center">
                                                        <button class="col- btn btn-primary"
                                                                @click="vistaEmpresaRegistrar"><i
                                                                class="fa fa-plus-circle"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--clientes-->
                                        <div class="col-12 col-md-6">
                                            <label for="cliente-id">Cliente<i
                                                    class="fa fa-asterisk  text-secundary ml-2"></i></label>
                                            <div class="col-12">
                                                <v-select id="cliente-id" class="col-" taggable :options="listaClientes"
                                                          v-model="modeloRecepcion.customer_id"></v-select>
                                            </div>
                                            <div class="col-12 text-center mt-2">
                                                <button class="btn btn-primary" @click="vistaClienteRegistrar"><i
                                                        class="fa fa-plus-circle"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <!--clientes-->
                                    </div>
                                    <div class="row" v-if="registrarEmpresa">
                                        <!--Formulario nueva empresa-->
                                        <div class="col-12 border">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h5 class="border-bottom pt-2">Registrar nueva empresa</h5>
                                                </div>
                                                <div class="col-12">
                                                    <div class="alert alert-danger"
                                                         v-if="erroresModeloEmpresa !== null">
                                                        <p class="h3">Errores de validación</p>
                                                        <ul v-for="errores in erroresModeloEmpresa">
                                                            <li v-for="error in errores">
                                                                {{error}}
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <div class="form-group border-bottom">
                                                        <label for="empresa-agregar-nombre">Nombre<i
                                                                class="fa fa-asterisk  text-secundary ml-2"></i>
                                                        </label>
                                                        <input id="empresa-agregar-nombre" type="text"
                                                               class="form-control" placeholder="Ej. Akumas"
                                                               v-model="modeloEmpresa.nombre">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <div class="form-group border-bottom">
                                                        <label for="empresa-agregar-telefono">Rfc<i
                                                                class="fa fa-asterisk  text-secundary ml-2"></i>
                                                        </label>
                                                        <input id="empresa-agregar-telefono" type="text"
                                                               class="form-control" placeholder="Ej. EUFA870518H53"
                                                               v-model="modeloEmpresa.rfc">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group border-bottom">
                                                        <label for="empresa-agregar-direccion">Dirección<i
                                                                class="fa fa-asterisk  text-secundary ml-2"></i>
                                                        </label>
                                                        <input id="empresa-agregar-direccion" type="text"
                                                               class="form-control"
                                                               placeholder="Ej. C. PUERTO DE ACAPULCO NO. 328, COL. TINIJARO, C.P. 58337"
                                                               v-model="modeloEmpresa.direccion">
                                                    </div>
                                                
                                                </div>

                                                <div class="col-6">
                                                    <div class="form-group">
                                                         <label for="customer-ciudad">Ciudad:<i class="ml-2 color-required fas fa-asterisk"></i>
                                                         </label>
                                                         <div class="input-group">
                                                         <div class="input-group-addon">
                                                             <i class="fas fa-map-marker-alt"></i>
                                                         </div>
                                                         <input id="customer-ciudad" class="form-control" type="text"
                                                                placeholder="Ej. Morelia"
                                                                v-model="modeloEmpresa.ciudad">
                                                         </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                         <label for="customer-estado">Estado:<i class="ml-2 color-required fas fa-asterisk"></i>
                                                         </label>
                                                         <div class="input-group">
                                                         <div class="input-group-addon">
                                                              <i class="fas fa-map-marker-alt"></i>
                                                         </div>
                                                         <input id="customer-estado" class="form-control" type="text"
                                                                placeholder="Ej. Michoacán"
                                                                v-model="modeloEmpresa.estado">
                                                         </div>
                                                    </div>
                                                </div>

                                                <div class="col-4">
                                                    <div class="form-group">
                                                         <label for="customer-cp">C.P.:<i class="ml-2 color-required fas fa-asterisk"></i>
                                                         </label>
                                                         <div class="input-group">
                                                         <div class="input-group-addon">
                                                              <i class="fas fa-map-marker-alt"></i>
                                                         </div>
                                                         <input id="customer-cp" class="form-control" type="text"
                                                                placeholder="Ej. 58000"
                                                                v-model="modeloEmpresa.cp">
                                                         </div>
                                                    </div>
                                                </div>

                                                <div class="col-8">
                                                    <div class="form-group">
                                                         <label for="customer-tel_casa">Tel Negocio:<i class="ml-2 color-required fas fa-asterisk"></i>
                                                         </label>
                                                         <div class="input-group">
                                                         <div class="input-group-addon">
                                                              <i class="fas fa-phone"></i>
                                                         </div>
                                                         <input id="customer-tel_casa" class="form-control" type="text"
                                                                placeholder="Ej. 4431040746"
                                                                v-model="modeloEmpresa.tel_negocio">
                                                         </div>
                                                    </div>
                                                </div>                  


                                                <div class="col-6">
                                                    <div class="form-group">
                                                         <label for="customer-tel_oficina">Tel Casa:<i class="ml-2 color-required fas fa-asterisk"></i>
                                                         </label>
                                                         <div class="input-group">
                                                         <div class="input-group-addon">
                                                              <i class="fas fa-phone"></i>
                                                         </div>
                                                         <input id="customer-tel_oficina" class="form-control" type="text"
                                                                placeholder="Ej. 4431040746"
                                                                v-model="modeloEmpresa.tel_casa">
                                                         </div>
                                                    </div>
                                                </div>
                                               <div class="col-6">
                                                   <div class="form-group">
                                                        <label for="customer-tel_celular">Tel Celular:<i class="ml-2 color-required fas fa-asterisk"></i>
                                                        </label>
                                                        <div class="input-group">
                                                        <div class="input-group-addon">
                                                             <i class="fas fa-phone"></i>
                                                        </div>
                                                        <input id="customer-tel_celular" class="form-control" type="text"
                                                               placeholder="Ej. 4431040746"
                                                               v-model="modeloEmpresa.tel_celular">
                                                        </div> 
                                                    </div>
                                                </div>

                                                  <div class="col-12">
                                                    <div class="form-group border-bottom">
                                                        <label for="empresa-agregar-direccion">Email<i
                                                                class="fa fa-asterisk  text-secundary ml-2"></i>
                                                        </label>
                                                        <input id="empresa-agregar-email" type="text"
                                                               class="form-control"
                                                               placeholder="Ej. digital_dws@hotmail.com"
                                                               v-model="modeloEmpresa.email">
                                                    </div>
                                                
                                                </div>
                           
                                                <div class="col-12 text-right p-3">
                                                    <button class="btn btn-primary" @click="guardarEmpresa"><i
                                                            class="fa fa-floppy-o mr-2"></i>Guardar
                                                    </button>
                                                    <button class="btn btn-secondary" @click="vistaEmpresaRegistrar"><i
                                                            class="fa fa-times mr-2"></i>Canclear
                                                    </button>
                                                </div>


                                            </div>
                                        </div>
                                        <!--End Formulario nueva empresa-->
                                    </div>
                                    <div class="row" v-if="registrarCliente">
                                        <!--Formulario nuevo cliente-->
                                        <div class="col-12 border">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h5 class="border-bottom pt-2">Registrar nuevo cliente</h5>
                                                </div>
                                                <div class="col-12">
                                                    <div class="alert alert-danger"
                                                         v-if="erroresModeloCliente !== null">
                                                        <p class="h3">Errores de validación</p>
                                                        <ul v-for="errores in erroresModeloCliente">
                                                            <li v-for="error in errores">
                                                                {{error}}
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-4">
                                                    <div class="form-group border-bottom">
                                                        <label for="cliente-agregar-empresa">Empresa</label>
                                                        <v-select id="cliente-agregar-empresa" class="col-" taggable
                                                                  :options="listaEmpresas"
                                                                  v-model="modeloCliente.empresa_id"></v-select>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-4">
                                                    <div class="form-group border-bottom">
                                                        <label for="cliente-nuevo-nombre">Nombre<i
                                                                class="fa fa-asterisk  text-secundary ml-2"></i>
                                                        </label>
                                                        <input id="cliente-nuevo-nombre" type="text"
                                                               class="form-control" placeholder="Ej. Alberto"
                                                               v-model="modeloCliente.usuario">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-4">
                                                    <div class="form-group border-bottom">
                                                        <label for="cliente-agregar-direccion">Dirección<i
                                                                class="fa fa-asterisk  text-secundary ml-2"></i>
                                                        </label>
                                                        <input id="cliente-agregar-direccion" type="text"
                                                               class="form-control"
                                                               placeholder="Ej. C. PUERTO DE ACAPULCO NO. 328, COL. TINIJARO, C.P. 58337"
                                                               v-model="modeloCliente.direccion">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-4">
                                                    <div class="form-group border-bottom">
                                                        <label for="cliente-agregar-ciudad">Ciudad<i
                                                                class="fa fa-asterisk  text-secundary ml-2"></i>
                                                        </label>
                                                        <input id="cliente-agregar-ciudad" type="text"
                                                               class="form-control" placeholder="Ej. Morelia"
                                                               v-model="modeloCliente.ciudad">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-4">
                                                    <div class="form-group border-bottom">
                                                        <label for="cliente-agregar-estado">Estado<i
                                                                class="fa fa-asterisk  text-secundary ml-2"></i></label>
                                                        <input id="cliente-agregar-estado" type="text"
                                                               class="form-control" placeholder="Ej. Michoacán"
                                                               v-model="modeloCliente.estado">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-4">
                                                    <div class="form-group border-bottom">
                                                        <label for="cliente-agregar-cp">Cp<i
                                                                class="fa fa-asterisk  text-secundary ml-2"></i></label>
                                                        <input id="cliente-agregar-cp" type="number"
                                                               class="form-control" placeholder="Ej. 58070"
                                                               v-model="modeloCliente.cp">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-4">
                                                    <div class="form-group border-bottom">
                                                        <label for="cliente-agregar-tel-casa">Teléfono casa<i
                                                                class="fa fa-asterisk  text-secundary ml-2"></i></label>
                                                        <input id="cliente-agregar-tel-casa" type="text"
                                                               class="form-control" placeholder="Ej. 4431910011"
                                                               v-model="modeloCliente.tel_casa">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-4">
                                                    <div class="form-group border-bottom">
                                                        <label for="cliente-agregar-tel-oficiona">Teléfono
                                                            oficina<i
                                                                    class="fa fa-asterisk  text-secundary ml-2"></i>
                                                        </label>
                                                        <input id="cliente-agregar-tel-oficiona" type="text"
                                                               class="form-control" placeholder="Ej. 4431910011"
                                                               v-model="modeloCliente.tel_oficina">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-4">
                                                    <div class="form-group border-bottom">
                                                        <label for="cliente-agregar-tel-celcular">Teléfono
                                                            celular</label>
                                                        <input id="cliente-agregar-tel-celcular" type="tel"
                                                               class="form-control" placeholder="Ej. 4431910011"
                                                               v-model="modeloCliente.tel_celular" pattern="[0-9]{7,15}">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-4">
                                                    <div class="form-group border-bottom">
                                                        <label for="cliente-agregar-tel-correo">Correo</label>
                                                        <input id="cliente-agregar-tel-correo" type="text"
                                                               class="form-control"
                                                               placeholder="Ej. cliente@akumas.com"
                                                               v-model="modeloCliente.email">
                                                    </div>
                                                </div>
                                                <div class="col-12 text-right p-3">
                                                    <button class="btn btn-primary" @click="guardarCliente"><i
                                                            class="fa fa-floppy-o mr-2"></i>Guardar
                                                    </button>
                                                    <button class="btn btn-secondary" @click="vistaClienteRegistrar"><i
                                                            class="fa fa-times mr-2"></i>Canclear
                                                    </button>
                                                </div>
                                            </div>
                                            <!--End Formulario nuevo cliente-->
                                        </div>
                                        <!--Formulario nuevo cliente-->
                                    </div>
                                    <!--Vehiculo-->
                                    <div class="my-4">
                                        <div class="row">
                                            <div class="col-12">
                                                <p class="h5 text-uppercase font-weight-bold  border-bottom">Datos del
                                                    vehículo</p>
                                            </div>
                                        </div>
                                        <!--vehiculo-->
                                        <div class="row" v-if="!registrarVehiculo">
                                            <div class="col-12 col-lg-4">
                                                <div class="form-group">
                                                    <label for="auto-id">Vehículo <small class="badge badge-info">Número ecónomico - Placas</small><i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                    <v-select id="auto-id" class="col-" taggable
                                                              :options="listaVehiculos"
                                                              v-model="modeloRecepcion.vehiculo_id"></v-select>
                                                    <div class="col-12 text-center mt-2">
                                                        <button class="btn btn-primary" @click="vistaVehiculoRegistrar"><i
                                                                class="fa fa-plus-circle"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <div class="form-group">
                                                    <label for="kilometro-entrada-id">KM Entrada<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                    <input id="kilometro-entrada-id" type="number" class="form-control"
                                                           placeholder="Ej. 10900" v-model="modeloRecepcion.km_entrada">
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <div class="form-group">
                                                    <label for="kilometro-salida-id">KM Salida<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                    <input id="kilometro-salida-id" type="number" class="form-control"
                                                           placeholder="Ej. 10900" v-model="modeloRecepcion.km_salida">
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <div class="form-group">
                                                    <label for="gas-entrada-id">Gasolina entrada<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                    <select id="gas-entrada-id" class="form-control" v-model="modeloRecepcion.gas_entrada">
                                                        <option value="0">LL</option>
                                                        <option value="1">3/4</option>
                                                        <option value="2">1/2</option>
                                                        <option value="3">1/4</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <div class="form-group">
                                                    <label for="gas-salida-id">Gasolina salida<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                    <select id="gas-salida-id" class="form-control" v-model="modeloRecepcion.gas_salida">
                                                        <option value="0">LL</option>
                                                        <option value="1">3/4</option>
                                                        <option value="2">1/2</option>
                                                        <option value="3">1/4</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!--Formulario nuevo vehiculo-->
                                        <div class="row border" v-if="registrarVehiculo && !registrarMarca && !registrarModelo && !registrarColor">
                                            <div class="col-12">
                                                <h5 class="border-bottom pt-2">Registrar nuevo vehículo</h5>
                                            </div>
                                            <div class="col-12">
                                                <div class="alert alert-danger"
                                                     v-if="erroresModeloVehiculo !== null">
                                                    <p class="h3">Errores de validación</p>
                                                    <ul v-for="errores in erroresModeloVehiculo">
                                                        <li v-for="error in errores">
                                                            {{error}}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <label for="tipo-vehiculo-id">Tipo<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                <div class="col-12">
                                                    <v-select id="tipo-vehiculo-id" class="col-" taggable
                                                              :options="listaTiposVehiculo" v-model="modeloVehiculo.tipo_id"
                                                              @change="listarMarcaModelos"
                                                    ></v-select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <label for="marca-id">Marca<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                <div class="col-12">
                                                    <v-select id="marca-id" class="col-" taggable
                                                              :options="listaMarcas" v-model="modeloVehiculo.marca_id"
                                                              @change="listarMarcaModelos"
                                                    ></v-select>
                                                </div>
                                                <div class="col-12 text-center mt-2">
                                                    <button class="btn btn-primary" @click="vistaMarcaRegistrar"><i
                                                            class="fa fa-plus-circle"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <label for="modelo-id">Modelo<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                <div class="form-group">
                                                    <div class="col-12">
                                                        <v-select id="modelo-id" class="col-" taggable
                                                                  :options="listaModelos"
                                                                  v-model="modeloVehiculo.modelo_id"
                                                        ></v-select>
                                                    </div>
                                                    <div class="col-12 text-center mt-2">
                                                        <button class="btn btn-primary" @click="vistaModeloRegistrar"><i
                                                                class="fa fa-plus-circle"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <div class="form-group">
                                                    <label for="color-id">Color<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                    <div class="col-12">
                                                        <v-select id="color-id" class="col-" taggable
                                                                  :options="listaColores"
                                                                  v-model="modeloVehiculo.color_id"
                                                        ></v-select>
                                                    </div>
                                                    <div class="col-12 text-center mt-2">
                                                        <button class="btn btn-primary" @click="vistaColorRegistrar"><i
                                                                class="fa fa-plus-circle"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <div class="form-group">
                                                    <label for="anio-id">Año<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                    <input id="anio-id" type="number" class="form-control"
                                                           placeholder="Ej. 1994" v-model="modeloVehiculo.anio">
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <div class="form-group">
                                                    <label for="numero-economico-id">Número ecónomico<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                    <input id="numero-economico-id" type="text" class="form-control"
                                                           placeholder="Ej. 894" v-model="modeloVehiculo.no_economico">
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <div class="form-group">
                                                    <label for="vim-id">VIN<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                    <input id="vim-id" type="text" class="form-control"
                                                           placeholder="Ej. JMZMA18P200411817" v-model="modeloVehiculo.vim">
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <div class="form-group">
                                                    <label for="placas-id">Placas<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                    <input id="placas-id" type="text" class="form-control"
                                                           placeholder="Ej. YBU-80-66" v-model="modeloVehiculo.placas">
                                                </div>
                                            </div>
                                            <div class="col-12 text-right p-3">
                                                <button class="btn btn-primary" @click="guardarVehiculo">
                                                    <i class="fa fa-floppy-o mr-2"></i>Guardar
                                                </button>
                                                <button class="btn btn-secondary" @click="vistaVehiculoRegistrar">
                                                    <i
                                                            class="fa fa-times mr-2"></i>Canclear
                                                </button>
                                            </div>
                                        </div>
                                        <!--Formulario nuevo vehiculo-->

                                    </div>
                                    <!--Vehiculo-->
                                    <div class="row" v-if="registrarMarca">
                                        <!--Formulario nueva marca-->
                                        <div class="col-12 border">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h5 class="border-bottom pt-2">Registrar nueva marca</h5>
                                                </div>
                                                <div class="col-12">
                                                    <div class="alert alert-danger"
                                                         v-if="erroresModeloMarca !== null">
                                                        <p class="h3">Errores de validación</p>
                                                        <ul v-for="errores in erroresModeloMarca">
                                                            <li v-for="error in errores">
                                                                {{error}}
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-4">
                                                    <div class="form-group border-bottom">
                                                        <label for="empresa-nuevo-nombre">Nombre<i
                                                                class="fa fa-asterisk  text-secundary ml-2"></i></label>
                                                        <input id="empresa-nuevo-nombre" type="text"
                                                               class="form-control" placeholder="Ej. Toyota" v-model="modeloMarca.nombre">
                                                    </div>
                                                </div>
                                                <div class="col-12 text-right p-3">
                                                    <button class="btn btn-primary" @click="guardarMarca"><i
                                                            class="fa fa-floppy-o mr-2"></i>Guardar
                                                    </button>
                                                    <button class="btn btn-secondary" @click="vistaMarcaRegistrar">
                                                        <i
                                                                class="fa fa-times mr-2"></i>Canclear
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <!--Formulario nueva marca-->
                                    </div>
                                    <div class="row" v-if="registrarModelo">
                                        <!--Formulario nuevo modelo-->
                                        <div class="col-12 border">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h5 class="border-bottom pt-2">Registrar nuevo modelo</h5>
                                                </div>
                                                <div class="col-12">
                                                    <div class="alert alert-danger"
                                                         v-if="erroresModeloMarca !== null">
                                                        <p class="h3">Errores de validación</p>
                                                        <ul v-for="errores in erroresModeloMarca">
                                                            <li v-for="error in errores">
                                                                {{error}}
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-4">
                                                    <div class="form-group border-bottom">
                                                        <label for="modelo-nuevo-marca">Marca<i
                                                                class="fa fa-asterisk  text-secundary ml-2"></i></label>
                                                        <v-select id="modelo-nuevo-marca" class="col-" taggable
                                                                  :options="listaMarcas" v-model="modeloModelo.marca_id"
                                                        ></v-select>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-4">
                                                    <div class="form-group border-bottom">
                                                        <label for="modelo-nuevo-nombre">Nombre<i
                                                                class="fa fa-asterisk  text-secundary ml-2"></i></label>
                                                        <input id="modelo-nuevo-nombre" type="text"
                                                               class="form-control" placeholder="Ej. Tacoma" v-model="modeloModelo.nombre">
                                                    </div>
                                                </div>
                                                <div class="col-12 text-right p-3">
                                                    <button class="btn btn-primary"  @click="guardarModelo"><i
                                                            class="fa fa-floppy-o mr-2"></i>Guardar
                                                    </button>
                                                    <button class="btn btn-secondary" @click="vistaModeloRegistrar">
                                                        <i
                                                                class="fa fa-times mr-2"></i>Canclear
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <!--Formulario nuevo modelo-->
                                    </div>
                                    <div class="row" v-if="registrarColor">
                                        <!--Formulario nuevo color-->
                                        <div class="col-12 border">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h5 class="border-bottom pt-2">Registrar nuevo color</h5>
                                                </div>
                                                <div class="col-12">
                                                    <div class="alert alert-danger"
                                                         v-if="erroresModeloColor !== null">
                                                        <p class="h3">Errores de validación</p>
                                                        <ul v-for="errores in erroresModeloColor">
                                                            <li v-for="error in errores">
                                                                {{error}}
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-4">
                                                    <div class="form-group border-bottom">
                                                        <label for="color-nuevo-nombre">Nombre<i
                                                                class="fa fa-asterisk  text-secundary ml-2"></i></label>
                                                        <input id="color-nuevo-nombre" type="text"
                                                               class="form-control" placeholder="Ej. Verde" v-model="modeloColor.nombre">
                                                    </div>
                                                </div>
                                                <div class="col-12 text-right p-3">
                                                    <button class="btn btn-primary" @click="guardarColor"><i
                                                            class="fa fa-floppy-o mr-2"></i>Guardar
                                                    </button>
                                                    <button class="btn btn-secondary" @click="vistaColorRegistrar">
                                                        <i
                                                                class="fa fa-times mr-2"></i>Canclear
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <!--Formulario nuevo color-->
                                    </div>
                                </div>
                                <!--Cliente y vehiculo-->
                                <div class="my-4">
                                    <p class="h5 text-uppercase font-weight-bold  border-bottom">Datos del
                                        seguro</p>
                                    <div class="row">
                                        {{"hola"+modeloSeguro.cia_seg}}
                                        <div class="col-12 col-lg-4">
                                            <div class="form-group">
                                                <label for="cia-seg-id">Cía seg.<i
                                                        class="fa fa-asterisk  text-secundary ml-2"></i></label>
                                                <input id="cia-seg-id" type="text" class="form-control"
                                                       placeholder="Ej. " v-model="modeloSeguro.cia_seg">
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <div class="form-group">
                                                <label for="tel-seg">Tel seg.<i
                                                        class="fa fa-asterisk  text-secundary ml-2"></i></label>
                                                <input id="tel-seg" type="tel" class="form-control"
                                                       placeholder="Ej. 4431910011" v-model="modeloSeguro.tel_seg">
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <div class="form-group">
                                                <label for="siniestro-id">Siniestro no.<i
                                                        class="fa fa-asterisk  text-secundary ml-2"></i></label>
                                                <input id="siniestro-id" type="text" class="form-control"
                                                       placeholder="Ej. 1" v-model="modeloSeguro.no_siniestro">
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <div class="form-group">
                                                <label for="ajustador-id">Ajustador<i
                                                        class="fa fa-asterisk  text-secundary ml-2"></i></label>
                                                <input id="ajustador-id" type="text" class="form-control"
                                                       placeholder="Ej. " v-model="modeloSeguro.ajustador">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="my-4">
                                    <p class="h5 text-uppercase font-weight-bold  border-bottom">Datos del
                                        tecnico</p>
                                    <div class="row">
                                        {{"hola"+modeloRecepcion.tecnico}}
                                        <div class="col-12 col-lg-4">
                                            <div class="form-group">
                                                <label for="cia-seg-id">Tecnico.<i
                                                        class="fa fa-asterisk  text-secundary ml-2"></i></label>
                                                <input id="cia-seg-id" type="text" class="form-control"
                                                       placeholder="Ej. " v-model="modeloRecepcion.tecnico">
                                            </div>
                                        </div>
                                    
                                    
                                     
                                    </div>
                                </div>
                                <div class="my-4">
                                    <p class="h5 text-uppercase font-weight-bold  border-bottom">Daños fisicos notables</p>
                                    <div class="row">
                                        <div class="col-12 col-lg-12" v-if="modeloRecepcion.firma = 'no firma'">
                                            <label for="tel-seg">
                                                Firma 
                                                <i class="fa fa-asterisk  text-secundary ml-2"></i>
                                            </label>
                                            <div class="form-group">
                                   <label for="tipo_impuesto">Tipo de Auto</label>
                                  <select name="tipo_auto" class="form-control" v-model="modeloRecepcion.tipoAuto" @change="cambioAuto()">
                                     <option value="0">Seleccione el tipo de auto</option>
                                     <option value="1">Coche 2p</option>
                                     <option value="2">Coche 4p</option>
                                     <option value="3">Camioneta</option>
                                     <option value="4">Subirban</option>
                                    </select>
                                    </div>
                                            <VueSignaturePad
                                                height= "200px"
                                                class= "border mb-3"
                                                ref= "signaturePad2"
                                                :options="{ onBegin, onEnd, penColor: 'red' }"
                                            />
                                            <div>
                                                <button class="btn btn-primary" @click="guardarFirma2">
                                                    Guardar firma
                                                </button>
                                                <button class="btn btn-secondary" @click="regresarFirmaAnterior2">
                                                    Paso anterior
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-12" v-else>
                                            <img :src="modeloRecepcion.firma+'.jpg'" width="50%" alt="">
                                        </div>
                                      
                                    </div>
                                </div>
                                <div class="my-4">
                                    <p class="h5 text-uppercase font-weight-bold  border-bottom">Datos del
                                        responsable</p>
                                    <div class="row">
                                        <div class="col-12 col-lg-6" v-if="modeloRecepcion.firma = 'no firma'">
                                            <label for="tel-seg">
                                                Firma 
                                                <i class="fa fa-asterisk  text-secundary ml-2"></i>
                                            </label>
                                            <VueSignaturePad
                                                height="200px"
                                                class="border mb-3"
                                                ref="signaturePad"
                                            />
                                            <div>
                                                <button class="btn btn-primary" @click="guardarFirma">
                                                    Guardar firma
                                                </button>
                                                <button class="btn btn-secondary" @click="regresarFirmaAnterior">
                                                    Paso anterior
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6" v-else>
                                            <img :src="modeloRecepcion.firma+'.jpg'" width="50%" alt="">
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <div class="form-group">
                                                <label for="tel-seg">Comprometido para
                                                    <small>fecha y hora _20191226112707</small><i
                                                            class="fa fa-asterisk  text-secundary ml-2"></i>
                                                </label>
                                                <datetime input-id="fecha-id" input-class="form-control"
                                                          type="datetime" v-model="modeloRecepcion.fecha_compromiso">
                                                    <template slot="button-cancel">
                                                        <i class="fa fa-times mr-2"></i>Cancelar
                                                    </template>
                                                    <template slot="button-confirm">
                                                        <i class="fa fa-check-circle mr-2"></i>Aceptar
                                                    </template>
                                                </datetime>
                                            </div>

                                              <div class="form-group">
                                                <label for="tel-seg">fecha de entrega:
                                                    <small>fecha y hora _20191226112707</small><i
                                                            class="fa fa-asterisk  text-secundary ml-2"></i>
                                                </label>
                                                <datetime input-id="fecha-id" input-class="form-control"
                                                          type="datetime" v-model="modeloRecepcion.fecha_entrega">
                                                    <template slot="button-cancel">
                                                        <i class="fa fa-times mr-2"></i>Cancelar
                                                    </template>
                                                    <template slot="button-confirm">
                                                        <i class="fa fa-check-circle mr-2"></i>Aceptar
                                                    </template>
                                                </datetime>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="my-4">
                                    <p class="h5 text-uppercase font-weight-bold  border-bottom">condiciones de
                                        interiores y equipo</p>
                                    <div class="row border my-3">
                                        <div class="col-12">
                                            <p class="h6 text-uppercase text-center">Paneles de Puertas</p>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <label for="interior-frontal-id">Interior Frontal<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                <select id="interior-frontal-id" class="form-control" v-model="modeloInterioresEquipo.puerta_interior_frontal">
                                                    <option 
                                                        v-for="estado in listaEstadoEquipo"  
                                                        :disabled="estado.code === 1" 
                                                        :value="estado.code"                            
                                                    >
                                                    {{estado.label}}                                                    
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <label for="interior-trasera-id">Interior Trasera<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                <select id="interior-trasera-id" class="form-control" v-model="modeloInterioresEquipo.puerta_interior_trasera">
                                                    <option v-for="estado in listaEstadoEquipo"  :disabled="estado.code === 1" :value="estado.code">{{estado.label}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <label for="delantera-frontal-id">Delantera Frontal<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                <select id="delantera-frontal-id" class="form-control" v-model="modeloInterioresEquipo.puerta_delantera_frontal">
                                                    <option v-for="estado in listaEstadoEquipo"  :disabled="estado.code === 1" :value="estado.code">{{estado.label}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <label for="delantera-trasera-id">Delantera Trasera<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                <select id="delantera-trasera-id" class="form-control" v-model="modeloInterioresEquipo.puerta_delantera_trasera">
                                                    <option v-for="estado in listaEstadoEquipo"  :disabled="estado.code === 1" :value="estado.code">{{estado.label}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row border my-3">
                                        <div class="col-12">
                                            <p class="h6 text-uppercase text-center">Asientos</p>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <label for="asientos-interior-frontal-id">Interior Frontal<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                <select id="asientos-interior-frontal-id"
                                                        class="form-control" v-model="modeloInterioresEquipo.asiento_interior_frontal">
                                                    <option v-for="estado in listaEstadoEquipo" :disabled="estado.code === 1" :value="estado.code">{{estado.label}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <label for="asientos-interior-trasera-id">Interior Trasera<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                <select id="asientos-interior-trasera-id"
                                                        class="form-control" v-model="modeloInterioresEquipo.asiento_interior_trasera">
                                                    <option v-for="estado in listaEstadoEquipo" :disabled="estado.code === 1" :value="estado.code">{{estado.label}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <label for="asientos-delantera-frontal-id">Delantera Frontal<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                <select id="asientos-delantera-frontal-id"
                                                        class="form-control" v-model="modeloInterioresEquipo.asiento_delantera_frontal">
                                                    <option v-for="estado in listaEstadoEquipo" :disabled="estado.code === 1" :value="estado.code">{{estado.label}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <label for="asientos-delantera-trasera-id">Delantera Trasera<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                <select id="asientos-delantera-trasera-id"
                                                        class="form-control" v-model="modeloInterioresEquipo.asiento_delantera_trasera">
                                                    <option v-for="estado in listaEstadoEquipo" :disabled="estado.code === 1" :value="estado.code">{{estado.label}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row border my-3">
                                        <div class="col-12">
                                            <p class="h6 text-uppercase text-center"></p>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <label for="consola-central-id">Consola Central<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                <select id="consola-central-id" class="form-control" v-model="modeloInterioresEquipo.consola_central">
                                                    <option v-for="estado in listaEstadoEquipo" :disabled="estado.code === 1" :value="estado.code">{{estado.label}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <label for="claxon-id">Claxon<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                <select id="claxon-id" class="form-control" v-model="modeloInterioresEquipo.claxon">
                                                    <option v-for="estado in listaEstadoEquipo" :disabled="estado.code === 1" :value="estado.code">{{estado.label}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <label for="tablero-id">Tablero<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                <select id="tablero-id" class="form-control" v-model="modeloInterioresEquipo.tablero">
                                                    <option v-for="estado in listaEstadoEquipo" :disabled="estado.code === 1" :value="estado.code">{{estado.label}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <label for="quemacocos-id">Quemacocos<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                <select id="quemacocos-id" class="form-control" v-model="modeloInterioresEquipo.quemacocos">
                                                    <option v-for="estado in listaEstadoEquipo" :disabled="estado.code === 1" :value="estado.code">{{estado.label}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <label for="toldo-id">Toldo<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                <select id="toldo-id" class="form-control" v-model="modeloInterioresEquipo.toldo">
                                                    <option v-for="estado in listaEstadoEquipo" :disabled="estado.code === 1" :value="estado.code">{{estado.label}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <label for="elevadores-electricos-id">Elevadores Eléctricos<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                <select id="elevadores-electricos-id" class="form-control" v-model="modeloInterioresEquipo.elevadores_eletricos">
                                                    <option v-for="estado in listaEstadoEquipo" :disabled="estado.code === 1" :value="estado.code">{{estado.label}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <label for="luces-interiores-id">Luces interiores<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                <select id="luces-interiores-id" class="form-control" v-model="modeloInterioresEquipo.luces_interiores">
                                                    <option v-for="estado in listaEstadoEquipo" :disabled="estado.code === 1" :value="estado.code">{{estado.label}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <label for="seguros-eletricos-id">Seguros Eléctricos<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                <select id="seguros-eletricos-id" class="form-control" v-model="modeloInterioresEquipo.seguros_eletricos">
                                                    <option v-for="estado in listaEstadoEquipo" :disabled="estado.code === 1" :value="estado.code">{{estado.label}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <label for="climatizador-id">A.C. /Climatizador<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                <select id="climatizador-id" class="form-control" v-model="modeloInterioresEquipo.climatizador">
                                                    <option v-for="estado in listaEstadoEquipo" :disabled="estado.code === 1" :value="estado.code">{{estado.label}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <label for="radio-id">Radio<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                <select id="radio-id" class="form-control" v-model="modeloInterioresEquipo.radio">
                                                    <option v-for="estado in listaEstadoEquipo" :disabled="estado.code === 1" :value="estado.code">{{estado.label}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <label for="espejo-retrovisor-id">Espejo Retrovisor<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                <select id="espejo-retrovisor-id" class="form-control" v-model="modeloInterioresEquipo.espejos_retrovizor">
                                                    <option v-for="estado in listaEstadoEquipo" :disabled="estado.code === 1" :value="estado.code">{{estado.label}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <label for="tapetes-id">Tapetes<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                <input id="tapetes-id" class="form-control" type="number"
                                                       placeholder="Ej. 2" v-model="modeloInterioresEquipo.tapetes">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="my-4">
                                    <p class="h5 text-uppercase font-weight-bold  border-bottom">condiciones de
                                        exteriores y equipo</p>
                                    <div class="row border my-3">
                                        <div class="col-12">
                                            <p class="h6 text-uppercase text-center"></p>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <label for="antena-radio-id">Antena/radio<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                <select id="antena-radio-id" class="form-control" v-model="modeloExterioresEquipo.antena_radio">
                                                    <option v-for="estado in listaEstadoEquipo" :disabled="estado.code === 1" :value="estado.code">{{estado.label}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <label for="estribos-id">Estribos<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                <select id="estribos-id" class="form-control" v-model="modeloExterioresEquipo.estribos">
                                                    <option v-for="estado in listaEstadoEquipo" :disabled="estado.code === 1" :value="estado.code">{{estado.label}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <label for="antena-telefono-id">Antena/teléfono<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                <select id="antena-telefono-id" class="form-control" v-model="modeloExterioresEquipo.antena_telefono">
                                                    <option v-for="estado in listaEstadoEquipo" :disabled="estado.code === 1" :value="estado.code">{{estado.label}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <label for="guardafangos-id">Guardafangos<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                <select id="guardafangos-id" class="form-control" v-model="modeloExterioresEquipo.guardafangos">
                                                    <option v-for="estado in listaEstadoEquipo" :disabled="estado.code === 1" :value="estado.code">{{estado.label}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <label for="antena-c-b-id">Antena/C.B.<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                <select id="antena-c-b-id" class="form-control" v-model="modeloExterioresEquipo.antena_cb">
                                                    <option v-for="estado in listaEstadoEquipo" :disabled="estado.code === 1" :value="estado.code">{{estado.label}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <label for="parabrisas-id">Parabrisas<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                <select id="parabrisas-id" class="form-control" v-model="modeloExterioresEquipo.parabrisas">
                                                    <option v-for="estado in listaEstadoEquipo" :disabled="estado.code === 1" :value="estado.code">{{estado.label}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <label for="sist-alarma-id">Sist. de Alarma<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                <select id="sist-alarma-id" class="form-control" v-model="modeloExterioresEquipo.sistema_alarma">
                                                    <option v-for="estado in listaEstadoEquipo" :disabled="estado.code === 1" :value="estado.code">{{estado.label}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <label for="limpiaparabrisas-id">Limpiaparabrisas<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                <select id="limpiaparabrisas-id" class="form-control" v-model="modeloExterioresEquipo.limpia_parabrisas">
                                                    <option v-for="estado in listaEstadoEquipo" :disabled="estado.code === 1" :value="estado.code">{{estado.label}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <label for="luces-exteriores-id">Luces Exteriores<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                <select id="luces-exteriores-id" class="form-control" v-model="modeloExterioresEquipo.luces_exteriores">
                                                    <option v-for="estado in listaEstadoEquipo" :disabled="estado.code === 1" :value="estado.code">{{estado.label}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <label for="esperjos-laterales-id">Espejos Laterales<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                <select id="esperjos-laterales-id" class="form-control" v-model="modeloExterioresEquipo.espejos_laterales">
                                                    <option v-for="estado in listaEstadoEquipo" :disabled="estado.code === 1" :value="estado.code">{{estado.label}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="my-4">
                                    <p class="h5 text-uppercase font-weight-bold  border-bottom">varios equipos -
                                        inventario</p>
                                    <div class="row border my-3">
                                        <div class="col-12">
                                            <p class="h6 text-uppercase text-center"></p>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <b-form-checkbox
                                                        id="eq-i-cubreruedas-llanta"
                                                        v-model="modeloEquipoInventario.llanta"
                                                        name="eq-i-cubreruedas-llanta"
                                                        value="accepted"
                                                        unchecked-value="not_accepted"
                                                >
                                                    Llanta de refacción
                                                </b-form-checkbox>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <b-form-checkbox
                                                        id="eq-i-cubreruedas-id"
                                                        v-model="modeloEquipoInventario.cubreruedas"
                                                        name="eq-i-cubreruedas-id"
                                                        value="accepted"
                                                        unchecked-value="not_accepted"
                                                >
                                                    Cubreruedas
                                                </b-form-checkbox>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <b-form-checkbox
                                                        id="eq-i-cables-corriend-id"
                                                        v-model="modeloEquipoInventario.cables_corriente"
                                                        name="eq-i-cables-corriend-id"
                                                        value="accepted"
                                                        unchecked-value="not_accepted"
                                                >
                                                    Cables para corriente
                                                </b-form-checkbox>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <b-form-checkbox
                                                        id="eq-i-candado-id"
                                                        v-model="modeloEquipoInventario.candado_ruedas"
                                                        name="eq-i-candado-id"
                                                        value="accepted"
                                                        unchecked-value="not_accepted"
                                                >
                                                    Candado de ruedas
                                                </b-form-checkbox>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <b-form-checkbox
                                                        id="eq-i-estuche-herramienta-id"
                                                        v-model="modeloEquipoInventario.estuche_herramientas"
                                                        name="eq-i-estuche-herramienta-id"
                                                        value="accepted"
                                                        unchecked-value="not_accepted"
                                                >
                                                    Estuche de herramientas
                                                </b-form-checkbox>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <b-form-checkbox
                                                        id="eq-i-gato-id"
                                                        v-model="modeloEquipoInventario.gato"
                                                        name="eq-i-gato-id"
                                                        value="accepted"
                                                        unchecked-value="not_accepted"
                                                >
                                                    Gato
                                                </b-form-checkbox>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <b-form-checkbox
                                                        id="eq-i-llave-tuerca-id"
                                                        v-model="modeloEquipoInventario.llave_tuercas"
                                                        name="eq-i-llave-tuerca-id"
                                                        value="accepted"
                                                        unchecked-value="not_accepted"
                                                >
                                                    Llave para tuercas de rueda
                                                </b-form-checkbox>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <b-form-checkbox
                                                        id="eq-i-tarjeta_circulacion-id"
                                                        v-model="modeloEquipoInventario.tarjeta_circulacion"
                                                        name="eq-i-tarjeta_circulacion-id"
                                                        value="accepted"
                                                        unchecked-value="not_accepted"
                                                >
                                                    Tarjeta de circulación
                                                </b-form-checkbox>

                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <b-form-checkbox
                                                        id="eq-i-triangulo-seguro-id"
                                                        v-model="modeloEquipoInventario.triangulo_seguridad"
                                                        name="eq-i-triangulo-seguro-id"
                                                        value="accepted"
                                                        unchecked-value="not_accepted"
                                                >
                                                    Triángulo de seguridad
                                                </b-form-checkbox>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <b-form-checkbox
                                                        id="eq-i-extinguidor"
                                                        v-model="modeloEquipoInventario.extinguidor"
                                                        name="eq-i-extinguidor"
                                                        value="accepted"
                                                        unchecked-value="not_accepted"
                                                >
                                                    Extinguidor
                                                </b-form-checkbox>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <b-form-checkbox
                                                        id="eq-i-placas"
                                                        v-model="modeloEquipoInventario.placas"
                                                        name="eq-i-placas"
                                                        value="accepted"
                                                        unchecked-value="not_accepted"
                                                >
                                                    Placas
                                                </b-form-checkbox>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="my-4">
                                    <p class="h5 text-uppercase font-weight-bold  border-bottom">condiciones de
                                        pintura</p>
                                    <div class="row border my-3">
                                        <div class="col-12">
                                            <p class="h6 text-uppercase text-center"></p>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <b-form-checkbox
                                                        id="eq-cp-decolorada-id"
                                                        v-model="modeloCondicionesPintura.decolorada"
                                                        name="eq-cp-decolorada-id"
                                                        value="accepted"
                                                        unchecked-value="not_accepted"
                                                >
                                                    Decolorada
                                                </b-form-checkbox>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <b-form-checkbox
                                                        id="eq-cp-emblemas_completos-id"
                                                        v-model="modeloCondicionesPintura.emblemas_completos"
                                                        name="eq-cp-emblemas_completos-id"
                                                        value="accepted"
                                                        unchecked-value="not_accepted"
                                                >
                                                    Emblemas completos
                                                </b-form-checkbox>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <b-form-checkbox
                                                        id="eq-cp-color-no-igual-id"
                                                        v-model="modeloCondicionesPintura.color_no_igual"
                                                        name="eq-cp-color-no-igual-id"
                                                        value="accepted"
                                                        unchecked-value="not_accepted"
                                                >
                                                    Color no igualado
                                                </b-form-checkbox>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <b-form-checkbox
                                                        id="eq-cp-logos-id"
                                                        v-model="modeloCondicionesPintura.logos"
                                                        name="eq-cp-logos-id"
                                                        value="accepted"
                                                        unchecked-value="not_accepted"
                                                >
                                                    Logos en buen estado
                                                </b-form-checkbox>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <b-form-checkbox
                                                        id="eq-cp-execo-rayones-id"
                                                        v-model="modeloCondicionesPintura.exeso_rayones"
                                                        name="eq-cp-execo-rayones-id"
                                                        value="accepted"
                                                        unchecked-value="not_accepted"
                                                >
                                                    Exceso de rayones
                                                </b-form-checkbox>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <b-form-checkbox
                                                        id="eq-cp-exceso-rociado-id"
                                                        v-model="modeloCondicionesPintura.exeso_rociado"
                                                        name="eq-cp-exceso-rociado-id"
                                                        value="accepted"
                                                        unchecked-value="not_accepted"
                                                >
                                                    Exceso de rociado
                                                </b-form-checkbox>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <b-form-checkbox
                                                        id="eq-cp-pequenias-grietas-id"
                                                        v-model="modeloCondicionesPintura.pequenias_grietas"
                                                        name="eq-cp-pequenias-grietas-id"
                                                        value="accepted"
                                                        unchecked-value="not_accepted"
                                                >
                                                    Pequeñas grietas
                                                </b-form-checkbox>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <b-form-checkbox
                                                        id="eq-cp-danios-granizado-id"
                                                        v-model="modeloCondicionesPintura.danios_granizado"
                                                        name="eq-cp-danios-granizado-id"
                                                        value="accepted"
                                                        unchecked-value="not_accepted"
                                                >
                                                    Daños por granizo
                                                </b-form-checkbox>

                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <b-form-checkbox
                                                        id="eq-cp-carroceria-golpes"
                                                        v-model="modeloCondicionesPintura.carroceria_golpes"
                                                        name="eq-cp-carroceria-golpes"
                                                        value="accepted"
                                                        unchecked-value="not_accepted"
                                                >
                                                    Carrocería con golpes
                                                </b-form-checkbox>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                            <div class="form-group">
                                                <b-form-checkbox
                                                        id="eq-cp-lluvia-acido-id"
                                                        v-model="modeloCondicionesPintura.lluvia_acido"
                                                        name="eq-cp-lluvia-acido-id"
                                                        value="accepted"
                                                        unchecked-value="not_accepted"
                                                >
                                                    Lluvia ácido
                                                </b-form-checkbox>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="my-4">
                                    <p class="h5 text-uppercase font-weight-bold  border-bottom">notas
                                        adicionales</p>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="notas-adicionales-id">Notas</label>
                                                <textarea id="notas-adicionales-id" class="form-control"
                                                          placeholder="Notas" cols="30" rows="5" v-model="modeloRecepcion.notas_adicionales"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="indicaciones-cliente-id">Indicaciones Cliente</label>
                                                <textarea id="indicaciones-cliente-id" class="form-control"
                                                          placeholder="Indicaciones cliente" cols="30"
                                                          rows="5" v-model="modeloRecepcion.indicaciones_del_cliente"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="my-4">
                                    <p class="h5 text-uppercase font-weight-bold  border-bottom">OTROS DATOS</p>
                                    <div class="row">
                                        <div class="col-md-3">
                                <div class="form-group">
                                    <label>Administrador de trasportes</label>
                                    <input type="text" class="form-control" v-model="modeloRecepcion.administrador" placeholder="000xx">
                                </div>
                            </div>
                            
                             <div class="col-md-3">
                                <div class="form-group">
                                    <label>Jefe de Proceso.</label>
                                    <input type="text" class="form-control" v-model="modeloRecepcion.jefedeprocesos" placeholder="000xx">
                                </div>
                            </div>

                            
                            
                           
                             <div class="col-md-3">
                                <div class="form-group">
                                    <label>Telefono</label>
                                    <input type="text" class="form-control" v-model="modeloRecepcion.telefonojefe" placeholder="000xx">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Trabajador</label>
                                    <input type="text" class="form-control" v-model="modeloRecepcion.trabajador" placeholder="000xx">
                                </div>
                            </div>
                                    </div>
                                </div>
                                <div class="my-4">
                                    <div class="col-12 text-right p-3">
                                        <button 
                                            v-if="updateRecepcion == false"
                                            class="btn btn-primary" 
                                            @click="guardarRecepcion"
                                        >
                                            <i class="fa fa-floppy-o mr-2"></i>Guardar
                                        </button>

                                        <button 
                                            v-if="updateRecepcion == true"
                                            class="btn btn-primary" 
                                            @click="actualizarRecepcion"
                                            :disabled="modeloRecepcion.firma != 'no firma'"
                                        >
                                            <i class="fa fa-edit mr-2"></i>Actualizar
                                        </button>

                                        <button class="btn btn-secondary" @click="vistaRecepcionCerrar"><i
                                                class="fa fa-times mr-2"></i>Canclear
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
                <template v-if="listado==1">
                    <div class="card-body">
                         <p class="h5 text-uppercase font-weight-bold  border-bottom">Datos del Vehiculo</p>
                        <div class="form-group row border">
                           
                            <div class="col-md-3">
                                <div class="form-group">
                                     <label>Economico</label>
                                     <input type="text" class="form-control" v-model="modeloPresupuesto.economico" placeholder="000xx">
                                </div>
                            </div>
                             <div class="col-md-3">
                                <div class="form-group">
                                     <label>Modelo</label>
                                     <input type="text" class="form-control" v-model="modeloPresupuesto.modelo" placeholder="000xx">
                                </div>
                            </div>
                             <div class="col-md-3">
                                <div class="form-group">
                                    <label>VIN</label>
                                    <input type="text" class="form-control" v-model="modeloPresupuesto.vin" placeholder="000xx">
                                </div>
                            </div>

                             <div class="col-md-3">
                                <div class="form-group">
                                    <label>Placas</label>
                                    <input type="text" class="form-control" v-model="modeloPresupuesto.placas" placeholder="000xx">
                                </div>
                            </div>

                             <div class="col-md-3">
                                <div class="form-group">
                                    <label>Año</label>
                                    <input type="text" class="form-control" v-model="modeloPresupuesto.ano" placeholder="000xx">
                                </div>
                            </div>

                             <div class="col-md-3">
                                <div class="form-group">
                                    <label>Kilometraje</label>
                                    <input type="text" class="form-control" v-model="modeloPresupuesto.kilometraje" placeholder="000xx">
                                </div>
                            </div>

                             <div class="col-md-3">
                                <div class="form-group">
                                    <label>Marca</label>
                                    <input type="text" class="form-control" v-model="modeloPresupuesto.marca" placeholder="000xx">
                                </div>
                            </div>

                             <div class="col-md-3">
                                <div class="form-group">
                                    <label>Ubicación</label>
                                    <input type="text" class="form-control" v-model="modeloPresupuesto.ubicacion" placeholder="000xx">
                                </div>
                            </div>

                        </div>
                         <p class="h5 text-uppercase font-weight-bold  border-bottom">Datos Generales Solicitud</p>
                        <div class="form-group row border">

                             <div class="col-md-3">
                                <div class="form-group">
                                    <label>Folio</label>
                                    <input type="text" class="form-control" v-model="modeloPresupuesto.NSolicitud" placeholder="000xx" >
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                     <label>Fecha Alta:</label>
                                     <input type="date" class="form-control" v-model="modeloPresupuesto.FechaAlta" placeholder="000xx">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>ID</label>
                                    <input type="text" class="form-control" v-model="modeloPresupuesto.ordenServicio" placeholder="000x">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>km De Ingreso</label>
                                    <input type="text" class="form-control" v-model="modeloPresupuesto.kmDeIngreso" placeholder="000xx">
                                </div>
                            </div>
                             <div class="col-md-3">
                                <div class="form-group">
                                    <label>Administrador de trasportes</label>
                                    <input type="text" class="form-control" v-model="modeloPresupuesto.clienteYRazonSocial" placeholder="000xx">
                                </div>
                            </div>
                            
                             <div class="col-md-3">
                                <div class="form-group">
                                    <label>Jefe de Proceso.</label>
                                    <input type="text" class="form-control" v-model="modeloPresupuesto.Mail" placeholder="000xx">
                                </div>
                            </div>

                            
                            
                           
                             <div class="col-md-3">
                                <div class="form-group">
                                    <label>Telefono</label>
                                    <input type="text" class="form-control" v-model="modeloPresupuesto.Telefono" placeholder="000xx">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Trabajador</label>
                                    <input type="text" class="form-control" v-model="modeloPresupuesto.Conductor" placeholder="000xx">
                                </div>
                            </div>
                           
                           <div class="col-md-12">
                                <div class="form-group">
                                    <label>Observaciones</label>
                                    <textarea id="notas-adicionales-id" class="form-control"
                                                          placeholder="Notas" cols="30" rows="5" v-model="modeloPresupuesto.observaciones"></textarea>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div v-show="errorIngreso" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjIngreso" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <template v-if="tipoAccion==1">
                         <p class="h5 text-uppercase font-weight-bold  border-bottom">ELIJA EL SERVICIO</p>
                        <div class="form-group row border">

                             <div class="col-md-4">
                                <div class="form-group">
                                    <label>Servicio</label>
                                    <select name="tipo_servicio" class="form-control" v-model="modeloPresupuesto.servicio">
                                     <option value="1">Preventivo</option>
                                     <option value="2">Correctivo</option>
                                    
                                  </select>
                                </div>
                            </div>

                              <div class="col-md-4">
                                <div class="form-group">
                                    <label>Ubicacion</label>
                                     <select class="form-control" v-model="modeloPresupuesto.ubi" >
                                            <option v-for="plantel in arrayUbicaicones" :key="plantel.id" :value="plantel.nombre" v-text="plantel.nombre"></option>
                                    </select>
                                   
                                </div>
                                 <div class="col-12 mt-2 text-center">
                                                        <button class="col- btn btn-primary"
                                                                @click="vistaUbicacionRegistrar"><i
                                                                class="fa fa-plus-circle"></i>
                                                        </button>
                                                    </div>
                            </div>

                               <div class="col-md-4">
                                <div class="form-group">
                                    <label>Area</label>
                                    <select name="tipo_servicio" class="form-control" v-model="modeloPresupuesto.area">
                                     <option value="Media tension">Media tension</option>
                                     <option value="Alta tension">Alta tension</option>
                                     <option value="Baja tension">Baja tension</option>
                                     <option value="Subestaciones">Subestaciones</option>
                                     <option value="Medicion">Medicion</option>
                                     <option value="Programa Especial">Programa Especial</option>
                                     <option value="Planeacion">Planeacion</option>
                                     <option value="Constructora">Constructora </option>
                                     <option value="Personal">Personal</option>
                                     <option value="Comunicaciones">Comunicaciones </option>
                                     <option value="Comercial">Comercial </option>
                                     <option value="Distribucion">Distribucion </option>
                                     <option value="Planeacion">Planeacion </option>

                                    
                                  </select>
                                </div>
                            </div>
                           


                          </div>
                           <template v-if="modeloPresupuesto.servicio==1">
                           <div class="form-group row border">
                             <div class="col-md-3">
                                <div class="form-group">
                                    <label>Tipo de servicio</label>
                                    <select name="tipo_servicio" class="form-control" v-model="modeloPresupuesto.tipo_servicio">
                                     <option value="1">Mayor</option>
                                     <option value="2">Menor</option>
                                    
                                  </select>
                                </div>
                            </div>

                             <div class="col-md-3">
                                <div class="form-group">
                                    <label>Kilometros</label>
                                    <input type="text" class="form-control" v-model="modeloPresupuesto.kmservicio" placeholder="000xx">
                                </div>
                            </div>
                          </div>

                          </template>  

                              <template v-if="modeloPresupuesto.servicio==2">
                           <div class="form-group row border">
                             <div class="col-md-3">
                                <div class="form-group">
                                   <div>
                                    <label class="typo__label">Correctivos</label>
                                    <multiselect v-model="modeloPresupuesto.value" tag-placeholder="Add this as new tag" placeholder="Search or add a tag" label="name" track-by="code" :options="options" :multiple="true" :taggable="true" @tag="addTag"></multiselect>
                                    
                                    </div>
                                </div>
                            </div>

                          
                          </div>
                              </template>
                               <div class="row" v-if="registrarUbicacion">
                                        <!--Formulario nueva empresa-->
                                        <div class="col-12 border">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h5 class="border-bottom pt-2">Registrar nueva Ubicacion</h5>
                                                </div>
                                            
                                                <div class="col-12 col-lg-12">
                                                    <div class="form-group border-bottom">
                                                        <label for="empresa-agregar-nombre">Nombre<i
                                                                class="fa fa-asterisk  text-secundary ml-2"></i>
                                                        </label>
                                                        <input id="empresa-agregar-nombre" type="text"
                                                               class="form-control" placeholder="Ej. Akumas"
                                                               v-model="modeloUbicacion.nombre">
                                                    </div>
                                                </div>
                                           
                                   
                           
                                                <div class="col-12 text-right p-3">
                                                    <button class="btn btn-primary" @click="guardarUbicacion"><i
                                                            class="fa fa-floppy-o mr-2"></i>Guardar
                                                    </button>
                                                    <button class="btn btn-secondary" @click="vistaUbicacionRegistrar"><i
                                                            class="fa fa-times mr-2"></i>Cancelar
                                                    </button>
                                                </div>


                                            </div>
                                        </div>
                                        <!--End Formulario nueva empresa-->
                                    </div>

                          </template> 


                        <div class="form-group row">
                            <div class="col-md-12">
                               
                                <button type="button" @click="ocultarDetalle()" class="btn btn-secondary float-right">Cerrar</button>
                                <button type="button" v-if="tipoAccion==1" class="btn btn-primary float-right" @click="registrarIngreso()"><i class="fa fa-floppy-o mr-2"> Agregar</i></button>
                               
                        
                            </div>
                        </div>
                    </div>
                </template>
                <template v-if="listado==2">
                    <div class="card-body">
                         <p class="h5 text-uppercase font-weight-bold  border-bottom">FOTOS</p>
                        <div class="form-group row border">
                           
                            <div class="row">
                                <div class="col-md-12 ">
                        <div class="row">
                            <form enctype="multipart/form-data" novalidate v-if="isInitial || isSaving">
                        <h1>Subir Archivos</h1>
                        <div class="dropbox">
                        <input type="file" multiple :name="uploadFieldName" :disabled="isSaving" @change="filesChange($event.target.files.length, $event.target.files); fileCount = $event.target.files.length"
                            accept="image/*" class="input-file">
                            <p v-if="isInitial">
                            Arrastra tus archivos<br> 
                            </p>
                            <p v-if="isSaving">
                            Uploading {{ fileCount }} files...
                            </p>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
                <br>


                <div class="row">
                    <div class="col-md-12 ">
                        <div class="row">
                            <div v-for="archivo in arrayArchivos" :key="archivo.id" class="col-md-2 ">
                               
                                    <blockquote class="blockquote text-center">
                                        <template v-if="archivo.tipo =='png'">
                                            <button type="button" class="close" @click="eliminarArchivo(archivo.id)" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
                                            <img :src="'img/png.png'" width="60" alt=""  @click="descargar(archivo.nombre)">
                                        </template>
                                        <template v-if="archivo.tipo =='pdf'">
                                            <button type="button" class="close" @click="eliminarArchivo(archivo.id)" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
                                            <img :src="'img/pdf.png'"  width="60" alt=""  @click="descargar(archivo.nombre)">
                                        </template>
                                        <template v-if="archivo.tipo =='xlsx'">
                                            <button type="button" class="close" @click="eliminarArchivo(archivo.id)" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
                                            <img :src="'img/exel.png'"  width="60" alt=""  @click="descargar(archivo.nombre)">
                                        </template>
                                        <template v-if="archivo.tipo =='xml'">
                                            <button type="button" class="close" @click="eliminarArchivo(archivo.id)" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
                                            <img :src="'img/exel.png'"  width="60" alt=""  @click="descargar(archivo.nombre)">
                                        </template>
                                        <template v-if="archivo.tipo =='jpg'">
                                            <button type="button" class="close" @click="eliminarArchivo(archivo.id)" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
                                            <img :src="'img/jpg.png'"  width="60" alt=""  @click="descargar(archivo.nombre)">
                                        </template>
                                        <template v-if="archivo.tipo =='jpeg'">
                                            <button type="button" class="close" @click="eliminarArchivo(archivo.id)" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
                                            <img :src="'img/jpeg.png'"  width="60" alt=""  @click="descargar(archivo.nombre)">
                                        </template>
                                        <template v-if="archivo.tipo =='docx'">
                                            <button type="button" class="close" @click="eliminarArchivo(archivo.id)" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
                                            <img :src="'img/doc.png'"  width="60" alt=""  @click="descargar(archivo.nombre)">
                                        </template>
                                        <template v-if="archivo.tipo =='pptx'">
                                            <button type="button" class="close" @click="eliminarArchivo(archivo.id)" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
                                            <img :src="'img/ppt.png'"  width="60" alt=""  @click="descargar(archivo.nombre)">
                                        </template>
                                        <template v-if="archivo.tipo =='mp3'">
                                            <button type="button" class="close" @click="eliminarArchivo(archivo.id)" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
                                            <img :src="'img/mp3.png'"  width="60" alt=""  @click="descargar(archivo.nombre)">
                                        </template>
                                        <template v-if="archivo.tipo =='ogg'">
                                            <button type="button" class="close" @click="eliminarArchivo(archivo.id)" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
                                            <img :src="'img/ogg.png'"  width="60" alt=""  @click="descargar(archivo.nombre)">
                                        </template>
                                        <template v-if="archivo.tipo =='zip'">
                                            <button type="button" class="close" @click="eliminarArchivo(archivo.id)" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
                                            <img :src="'img/zip.png'"  width="60" alt=""  @click="descargar(archivo.nombre)">
                                        </template>
                                       
                                    <p class="mb-0">{{ archivo.nombre }}</p>
                                    </blockquote>
                                
                            </div>
                        </div>
                 
                    </div>
                    </div>   
                </div> 

                            <div class="form-group row">
                                <div class="col-md-12">
                                
                                    <button type="button" @click="ocultarDetalle()" class="btn btn-secondary float-right">Cerrar</button>
                                
                            
                                </div>
                            </div>
                        </div>
                   
                </template>
                <!--End Formulario registrar actualizar-->
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>
    </main>
</template>

<script>
    import vSelect from 'vue-select';
    const STATUS_INITIAL = 0, STATUS_SAVING = 1, STATUS_SUCCESS = 2, STATUS_FAILED = 3;
    export default {
        data() {
            return {
                updateRecepcion: false,
                erroresModeloCliente: null,
                erroresModeloColor: null,
                erroresModeloEmpresa: null,
                erroresModeloMarca: null,
                erroresModeloModelo: null,
                erroresModeloRecepcion: null,
                erroresModeloVehiculo: null,

                registrarRecepcion: 0,
                registrarCliente: false,
                registrarColor: false,
                registrarEmpresa: false,
                registrarMarca: false,
                registrarModelo: false,
                registrarVehiculo: false,

                modeloCliente: {},
                modeloColor: {},
                modeloCondicionesPintura: {},
                modeloEmpresa: {},
                modeloEquipoInventario: {},
                modeloExterioresEquipo: {},
                modeloInterioresEquipo: {},
                modeloMarca: {},
                modeloModelo: {},
                modeloRecepcion: {
                    tipoAuto:0
                },
                modeloSeguro: {},
                //todo recepcion depende del vehiculo, pero en la vista se esta registrando almenos algunos campos podrian cambiarse
                modeloVehiculo: {},

                listaAutos: [],
                listaClientes: [],
                listaColores: [],
                listaEmpresas: [],
                listaEstadoEquipo: [],
                listaMarcas: [],
                listaModelos: [],
                listaRecepciones: [],
                listaTiposVehiculo: [],
                listaVehiculos: [],


                status: false,
                datetime: new Date(2019, 10, 11),
                ingreso_id: 0,
                idproveedor: 0,
                proveedor: '',
                nombre: '',
                tipo_comprobante: 'BOLETA',
                serie_comprobante: '',
                num_comprobante: '',
                impuesto: 0.18,
                total: 0.0,
                totalImpuesto: 0.0,
                totalParcial: 0.0,
                arrayIngreso: [],
                arrayProveedor: [],
                arrayDetalle: [],

                modeloPresupuesto:{
                    economico:'',
                    placas:'',
                    vin:'',
                    marca:'',
                    modelo:'',
                    NSolicitud:'',
                    ano:'',
                    FechaAlta:'',
                    kmDeIngreso:'',
                    ordenServicio:''
                },
                arrayUbicaicones : [],
                listado: 0,
                registrarUbicacion: false,
                modeloUbicacion: {},
                value: [],
                options: [
                    { name: 'Sistema Motor', code: '1' },
                    { name: 'Sistema Enfriamiento', code: '2' },
                    { name: 'Sistema de Embrague', code: '3' },
                    { name: 'Trasmision', code: '4' },
                    { name: 'Suspencion y Direccion', code: '5' },
                    { name: 'Frenos y Ruedas', code: '6' },
                    { name: 'Sistema Electrico', code: '7' },
                    { name: 'Sistema de Escape', code: '8' },
                    { name: 'Traslados y Arrastre de Grua', code: '9' },
                    { name: 'Fuera de Contrato', code: '10' },
                    
                ],
                idempresa:0,


                modal: 0,
                tituloModal: '',
                tipoAccion: 0,
                errorIngreso: 0,
                errorMostrarMsjIngreso: [],
                pagination: {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,
                },
                offset: 3,
                criterio: 'num_comprobante',
                buscar: '',
                criterioA: 'nombre',
                buscarA: '',
                arrayArticulo: [],
                idarticulo: 0,
                codigo: '',
                articulo: '',
                precio: 0,
                cantidad: 0,
                file: "",
                uploadedFiles: [],
                uploadError: null,
                currentStatus: null,
                uploadFieldName: 'photos',
                filenames: [],
                arrayArchivos: [],
                recep_id:0,
            }
        },
        components: {
            vSelect
        },
        computed: {
            isInitial() {
                return this.currentStatus === STATUS_INITIAL;
            },
            isSaving() {
                return this.currentStatus === STATUS_SAVING;
            },
            isSuccess() {
                return this.currentStatus === STATUS_SUCCESS;
            },
            isFailed() {
                return this.currentStatus === STATUS_FAILED;
            },
            isActived: function () {
                return this.pagination.current_page;
            },

            //Calcula los elementos de la paginación
            pagesNumber: function () {
                if (!this.pagination.to) {
                    return [];
                }

                var from = this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2);
                if (to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }

                var pagesArray = [];
                while (from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;

            },

            calcularTotal: function () {
                var resultado = 0.0;
                for (var i = 0; i < this.arrayDetalle.length; i++) {
                    resultado = resultado + (this.arrayDetalle[i].precio * this.arrayDetalle[i].cantidad)
                }
                return resultado;
            }
        },
        methods: {
            reset() {
                // reset form to initial state
                this.currentStatus = STATUS_INITIAL;
                this.uploadedFiles = [];
                this.uploadError = null;
            },
            save(formData) {
                // upload data to the server

                var el = this;
                this.currentStatus = STATUS_SAVING;

                axios.post('recepcionO2023/subir',formData ,
                    {
                    headers: {
                    "Content-Type": "multipart/form-data",
                    
                    }
                    }).then(function (response) {
                    console.log(response.data);
                    el.reset();
                    el.listarArchivos(el.recep_id);
                    el.$toastr.success(response.data + " archivos se han subido.", 'Archivos');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            descargar(cotizacion){
                        window.open('img/archivos/'+ cotizacion,'_blank');
                    },
            filesChange(fieldName, fileList) {

                let formData = new FormData();
                formData.append("id", this.recep_id  );
                for (var index = 0; index < fieldName; index++) {
                formData.append("files[]", fileList[index]);
                }

            
                this.save(formData);
            },
            listarArchivos(id){
                let me=this;
                var url= 'recepcionO2023/archivos?page=1' + '&buscar='+ id ;
                axios.get(url).then(function (response) {
                
                    var respuesta= response.data;
                    console.log(respuesta);
                    me.arrayArchivos = respuesta.archivos.data;
                
                
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            uploadFile: function(){

                var el = this;
                let formData = new FormData();

                // Leer archivos seleccionados
                var files = this.$refs.uploadfiles.files;
                var totalfiles = this.$refs.uploadfiles.files.length;
                for (var index = 0; index < totalfiles; index++) {
                formData.append("files[]", files[index]);
                }
                axios.post('recepcionO2023/subir', formData,
                    {
                    headers: {
                    "Content-Type": "multipart/form-data"
                    }
                    }).then(function (response) {
                    console.log(response.data);
                    el.filenames = response.data;
                    me.$toastr.success(el.filenames.length + " los archivos se han subido.", 'Archivos');
                }).catch(function (error) {
                    console.log(error);
                });


            },
            crearPresupuesto(solicitud,empresa){
                console.log(solicitud);
                console.log(empresa);
                this.listado = 1;
                this.tipoAccion = 1;
                this.registrarRecepcion = 2;
                this.idempresa = empresa;
                this.getOrdenSeguimineto(solicitud);
                this.$forceUpdate();
            },
            fotos(id){
                this.recep_id = id;
                this.listado = 2;
                this.tipoAccion = 1;
                this.registrarRecepcion = 2;
                this.listarArchivos(id);   
            },
            ocultarDetalle(){
                this.listado = 0;
                this.registrarRecepcion = 0;
                this.listarRecepciones(1,'');
            },
            deleter(id){
                swal({
                    title: 'Esta seguro de eliminar esta entrada?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Aceptar!',
                    cancelButtonText: 'Cancelar',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                    reverseButtons: true
                    }).then((result) => {
                    if (result.value) {
                        let me = this;

                        axios.put('recepcionO2023/delete',{
                            'id': id
                        }).then(function (response) {
                            me.listarRecepciones(1,'');
                            swal(
                            'Eliminado!',
                            'El registro ha sido eliminado con éxito.',
                            'success'
                            )
                        }).catch(function (error) {
                            console.log(error);
                        });
                        
                        
                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === swal.DismissReason.cancel
                    ) {
                        
                    }
                    }) 
                },
            getOrdenSeguimineto(solicitud){
            let me = this;
            axios
                .get("hojaConcepto/"+solicitud)
                .then(function(response){
                   var respuestaArray = response.data;
                console.log(respuestaArray);

                me.modeloPresupuesto.economico = respuestaArray.economico;
                me.modeloPresupuesto.placas = respuestaArray.placas;
                me.modeloPresupuesto.vin = respuestaArray.vin;
                me.modeloPresupuesto.marca = respuestaArray.marca;
                me.modeloPresupuesto.modelo = respuestaArray.modelo;
                me.modeloPresupuesto.NSolicitud = solicitud;
                me.modeloPresupuesto.ano = respuestaArray.anio;
                me.modeloPresupuesto.FechaAlta = respuestaArray.fecha;
                me.modeloPresupuesto.kmDeIngreso = respuestaArray.km;
                me.modeloPresupuesto.ordenServicio = respuestaArray.folio;
                me.modeloPresupuesto.kilometraje = respuestaArray.km;
                me.modeloPresupuesto.ubicacion = respuestaArray.ciudad;
                me.modeloPresupuesto.clienteYRazonSocial = respuestaArray.administrador;
                me.modeloPresupuesto.Mail = respuestaArray.jefedeprocesos;
                me.modeloPresupuesto.Telefono = respuestaArray.telefonojefe;
                me.modeloPresupuesto.Conductor = respuestaArray.trabajador;

                })
                .catch(function(response){
                console.log(response);
                });
            },
            listarUbicaciones(){
                let me=this;
                var url= 'ubicaciones';
                axios.get(url).then(function (response) {
                    console.log(response.data);
                    var respuesta= response.data;
                    me.arrayUbicaicones = respuesta.ubicaciones;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
             guardarUbicacion(){
                let me = this;

                axios.post('ubicaciones/registrar',{
                    'nombre': me.modeloUbicacion.nombre,

                }).then(function (response) {
                    
                    console.log(response.data);
                    me.listarUbicaciones();
                    me.$toastr.success('Nueva ubiacion registrada', 'Ubicaciones');
                    me.registrarUbicacion = false;
                   
                    

                }).catch(function (error) {
                    console.log(error);
                });
            },
            vistaUbicacionRegistrar() {
                this.registrarUbicacion = !this.registrarUbicacion;
                this.modeloUbicacion = {};
            },
            addTag (newTag) {
            const tag = {
                name: newTag,
                code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
            }
            this.options.push(tag)
            this.value.push(tag)
            },
            registrarIngreso(){
                
                let me = this;

                axios.post('ordenesNew/registrar',{
                    'identificador': this.modeloPresupuesto.economico,
                    'modelo': this.modeloPresupuesto.modelo,
                    'vin' : this.modeloPresupuesto.vin,
                    'placas' : this.modeloPresupuesto.placas,
                    'ano' : this.modeloPresupuesto.ano,
                    'kilometraje' : this.modeloPresupuesto.kilometraje,
                    'marca' : this.modeloPresupuesto.marca,
                    'nsolicitud' : this.modeloPresupuesto.NSolicitud,
                    'fechaalta' : this.modeloPresupuesto.FechaAlta,
                    'ordenservicio' : this.modeloPresupuesto.ordenServicio,
                    'kmdeingreso' : this.modeloPresupuesto.kmDeIngreso,
                    'clienteYRazonSocial' : this.modeloPresupuesto.clienteYRazonSocial,
                    'observaciones' : this.modeloPresupuesto.observaciones,
                    'mail' : this.modeloPresupuesto.Mail,
                    'telefono' : this.modeloPresupuesto.Telefono,
                    'ubicacion' : this.modeloPresupuesto.ubicacion,
                    'conductor' : this.modeloPresupuesto.Conductor,
                    'area' : this.modeloPresupuesto.area,
                    'ubi' : this.modeloPresupuesto.ubi,
                    'preocorr_id' : this.modeloPresupuesto.servicio,
                    'tipo_servicio' : this.modeloPresupuesto.tipo_servicio,
                    'kilome' : this.modeloPresupuesto.kmservicio,
                    'data' : this.modeloPresupuesto.value,
                    'empresa_id': this.idempresa,
                    'eco_id': '0'

                }).then(function (response) {
                    
                    console.log(response.data);
                    me.modeloPresupuesto.economico='';
                    me.modeloPresupuesto.modelo='';
                    me.modeloPresupuesto.vin='';
                    me.modeloPresupuesto.placas='';
                    me.modeloPresupuesto.ano='';
                    me.modeloPresupuesto.kilometraje='';
                    me.modeloPresupuesto.marca='';
                    me.modeloPresupuesto.NSolicitud='';
                    me.modeloPresupuesto.FechaAlta='';
                    me.modeloPresupuesto.ordenServicio='';
                    me.modeloPresupuesto.kmDeIngreso='';
                    me.modeloPresupuesto.clienteYRazonSocial = '';
                    me.modeloPresupuesto.observaciones ='';
                    me.modeloPresupuesto.Mail = '';
                    me.modeloPresupuesto.Telefono ='';
                    me.modeloPresupuesto.Conductor ='';
                    me.modeloPresupuesto.ubicacion ='';
                    me.$store.commit('presupuestosAkumas2023');
                    me.$toastr.success('Se registro correctamente', 'Presupuestos');

                }).catch(function (error) {
                    console.log(error);
                });
            },
            onBegin() {
               console.log('=== Begin ===');
            },
            onEnd() {
                console.log('=== End ===');
            },
            actualizarRecepcion(){
                let me = this;                
                axios
                    .put('recepcion/' + me.modeloRecepcion.id ,{
                        modeloRecepcion: me.modeloRecepcion,
                        modeloSeguro: me.modeloSeguro,
                        modeloInterioresEquipo: me.modeloInterioresEquipo,
                        modeloExterioresEquipo: me.modeloExterioresEquipo,
                        modeloEquipoInventario: me.modeloEquipoInventario,
                        modeloCondicionesPintura: me.modeloCondicionesPintura
                    })
                    .then(function (response) {
                        if(response.data.estado === true){
                            me.$toastr.success('Se actualizo correctamente', 'Actualizacion');
                            me.vistaRecepcionRegistrar(); 
                            me.listarRecepciones(1,'');
                        }
                    })
                    .catch(function (error) {
                         if (error.response.status && error.response.status === 422) {
                            me.erroresModeloEmpresa = error.response.data.errors;
                            me.$toastr.warning('Valida los campos correctamente.', 'Recepcion');
                        } else {
                            me.$toastr.error('Ocurrio un error, consulta con el admin', 'Error');
                        }            
                    });
            },
            editRecepcion(id){
                let me = this;
                axios
                    .get('recepcion/' + id + '/edit')
                    .then(function(response){
                        me.vistaRecepcionRegistrar();     
                        if(response.data.modeloSeguro != ''){
                            me.modeloSeguro = response.data.modeloSeguro['0'];
                        }
                        if(response.data.modeloRecepcion != ''){
                            me.modeloRecepcion = response.data.modeloRecepcion['0'];
                            if(response.data.modeloRecepcion['0'].firma){
                                me.modeloRecepcion.firma = "img/firmas/"+response.data.modeloRecepcion['0'].firma;
                            }else{
                                me.modeloRecepcion.firma = "no firma";
                            }
                        }
                        if(response.data.modeloInterioresEquipo != ''){
                            me.modeloInterioresEquipo = response.data.modeloInterioresEquipo['0'];
                        }
                        if(response.data.modeloExterioresEquipo != ''){
                            me.modeloExterioresEquipo = response.data.modeloExterioresEquipo['0'];
                        }

                        if(response.data.modeloCondicionesPintura != ''){
                            me.modeloCondicionesPintura = response.data.modeloCondicionesPintura['0'];
                            var idCondicionesPintura = response.data.modeloCondicionesPintura['0']['id'];

                            for (const prop in me.modeloCondicionesPintura) {
                                me.modeloCondicionesPintura[prop] = me.modeloCondicionesPintura[prop] == 1 ? 'accepted':'not_accepted';
                            }
                            me.modeloCondicionesPintura['id'] = idCondicionesPintura;

                        }
                        if(response.data.modeloEquipoInventario != ''){
                            me.modeloEquipoInventario = response.data.modeloEquipoInventario['0'];
                            var idEquipoInventario = response.data.modeloEquipoInventario['0']['id'];
                            for (const prop in me.modeloEquipoInventario) {
                                me.modeloEquipoInventario[prop] = me.modeloEquipoInventario[prop] == 1 ? 'accepted':'not_accepted';
                            }
                            me.modeloEquipoInventario['id'] = idEquipoInventario;
                        }
                        me.updateRecepcion = true;
                        console.log(me.modeloEquipoInventario);
                    }).catch(function(response){
                        console.log(response.data);
                    });
            },
            guardarEmpresa() {
                let me = this;
                axios.post('empresas/store', me.modeloEmpresa).then(function (response) {
                    console.log("~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~");
                    console.log(response.data);
                    console.log("~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~");
                    //Si el guardado se realizo correctamente
                    if (response.data.estado === true) {
                        me.listarEmpresas();
                        me.erroresModeloEmpresa = null;
                        me.modeloEmpresa = {};
                        me.$toastr.success('Nueva empresa registrada', 'Empresas');
                        me.vistaEmpresaRegistrar();
                    }

                }).catch(function (error) {
                    //error 422 = validacion

                    if (error.response.status && error.response.status === 422) {
                        me.erroresModeloEmpresa = error.response.data.errors;
                        me.$toastr.warning('Valida los campos correctamente.', 'Empresas');
                    } else {
                        me.$toastr.error('Ocurrio un error, consulta con el admin', 'Error');
                    }
                });
            },
            guardarCliente() {
                let me = this;
                let modeloCliente = JSON.parse(JSON.stringify(me.$data.modeloCliente));
                if (modeloCliente.empresa_id.code === -1) {
                    delete modeloCliente.empresa_id;
                }else{
                    modeloCliente.empresa_id = modeloCliente.empresa_id.code;
                }
                axios.post('customers/store', modeloCliente).then(function (response) {
                    console.log(response.data);
                    //Si el guardado se realizo correctamente
                    if (response.data.estado === true) {
                        me.$toastr.success('Nuevo cliente registrado', 'Clientes');
                        me.vistaClienteRegistrar();
                        me.modeloCliente = {};
                        me.erroresModeloCliente = null;
                    }
                }).catch(function (error) {
                    //error 422 = validacion
                    if (error.response.status === 422) {
                        me.erroresModeloCliente = error.response.data.errors;
                        me.$toastr.warning('Valida los campos correctamente.', 'Clientes');
                    } else {
                        me.$toastr.error('Ocurrio un error, consulta con el admin', 'Error');
                    }
                });
            },
            guardarColor() {
                let me = this;
                axios.post('colores/store', me.modeloColor).then(function (response) {
                    //Si el guardado se realizo correctamente
                    if (response.data.estado === true) {
                        me.listarColores();
                        me.$toastr.success('Nuevo color registrado', 'Colores');
                        me.vistaColorRegistrar();
                        me.modeloColor = {};
                        me.erroresModeloColor = null;
                    }
                }).catch(function (error) {
                    //error 422 = validacion
                    if (error.response.status === 422) {
                        me.erroresModeloColor = error.response.data.errors;
                        me.$toastr.warning('Valida los campos correctamente.', 'Colores');
                    } else {
                        me.$toastr.error('Ocurrio un error, consulta con el admin', 'Error');
                    }
                });
            },
            guardarMarca() {
                let me = this;
                axios.post('marcas/store', me.modeloMarca).then(function (response) {
                    //Si el guardado se realizo correctamente
                    if (response.data.estado === true) {
                        me.$toastr.success('Nueva marca registrada', 'Marca auto');
                        me.listarMarcas();
                        me.vistaMarcaRegistrar();
                        me.modeloMarca = {};
                        me.erroresModeloMarca = null;
                    }
                }).catch(function (error) {
                    //error 422 = validacion
                    if (error.response.status === 422) {
                        me.erroresModeloMarca = error.response.data.errors;
                        me.$toastr.warning('Valida los campos correctamente.', 'Marca auto');
                    } else {
                        me.$toastr.error('Ocurrio un error, consulta con el admin', 'Error');
                    }
                });
            },
            guardarModelo() {
                let me = this;
                let modeloModelo = JSON.parse(JSON.stringify(me.modeloModelo));
                modeloModelo.marca_id = modeloModelo.marca_id ? modeloModelo.marca_id.code :null;
                axios.post('modelos/store', modeloModelo).then(function (response) {
                    //Si el guardado se realizo correctamente
                    if (response.data.estado === true) {
                        me.$toastr.success('Nuevo modelo registrado', 'Modelo auto');
                        me.vistaModeloRegistrar();
                        me.modeloModelo = {};
                        me.erroresModeloModelo = null;
                    }
                }).catch(function (error) {
                    //error 422 = validacion
                    if (error.response.status === 422) {
                        me.erroresModeloMarca = error.response.data.errors;
                        me.$toastr.warning('Valida los campos correctamente.', 'Marca auto');
                    } else {
                        me.$toastr.error('Ocurrio un error, consulta con el admin', 'Error');
                    }
                });
            },
            guardarRecepcion() {
                let me = this;
                me.modeloRecepcion.modulo = 5;
                let modeloRecepcion = JSON.parse(JSON.stringify(me.modeloRecepcion));
                modeloRecepcion.empresa_id = modeloRecepcion.empresa_id ? modeloRecepcion.empresa_id.code : null;
                modeloRecepcion.customer_id = modeloRecepcion.customer_id ? modeloRecepcion.customer_id.code : null;
                modeloRecepcion.vehiculo_id = modeloRecepcion.vehiculo_id ? modeloRecepcion.vehiculo_id .code : null;
                axios.post('recepcion/store', {
                    modeloRecepcion: modeloRecepcion,
                    modeloSeguro: me.modeloSeguro,
                    modeloInterioresEquipo: me.modeloInterioresEquipo,
                    modeloExterioresEquipo: me.modeloExterioresEquipo,
                    modeloEquipoInventario: me.modeloEquipoInventario,
                    modeloCondicionesPintura: me.modeloCondicionesPintura,
                }).then(function (response) {
                    console.log("~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~");
                    console.log(response.data);
                    console.log("~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~");
                    //Si el guardado se realizo correctamente
                    if (response.data.estado === true) {
                        me.listarRecepciones(1,'');
                        me.$toastr.success('Nueva recepción registrada', 'Recepciónes');
                        me.vistaRecepcionCerrar();
                        me.modeloRecepcion = {};
                        me.modeloInterioresEquipo = {};
                        me.modeloExterioresEquipo = {};
                        me.modeloEquipoInventario = {};
                        me.modeloCondicionesPintura = {};
                        me.modeloSeguro = {};
                        me.erroresModeloRecepcion = null;
                    }
                }).catch(function (error) {
                    //error 422 = validacion
                    if (error.response.status === 422) {
                        me.erroresModeloRecepcion = error.response.data.errors;
                        me.$toastr.warning('Valida los campos correctamente.', 'Recepción');
                    } else {
                        me.$toastr.error('Ocurrio un error, consulta con el admin', 'Error');
                    }
                });
            },
            guardarVehiculo() {
                let me = this;
                let modeloVehiculo = JSON.parse(JSON.stringify(me.modeloVehiculo));
                modeloVehiculo.tipo_id = modeloVehiculo.tipo_id.code;
                modeloVehiculo.modelo_id = modeloVehiculo.modelo_id.code;
                modeloVehiculo.marca_id = modeloVehiculo.marca_id.code;
                modeloVehiculo.color_id = modeloVehiculo.color_id.code;
                axios.post('vehiculos/store', modeloVehiculo).then(function (response) {
                    console.log(response.data);
                    //Si el guardado se realizo correctamente
                    if (response.data.estado === true) {
                        me.listarVehiculos();
                        me.$toastr.success('Nuevo vehículo registrado', 'Vehiculos');
                        me.vistaVehiculoRegistrar();
                        me.modeloVehiculo = {};
                        me.erroresModeloVehiculo = null;
                    }
                }).catch(function (error) {
                    //error 422 = validacion
                    if (error.response.status === 422) {
                        me.erroresModeloVehiculo = error.response.data.errors;
                        me.$toastr.warning('Valida los campos correctamente.', 'Marca auto');
                    } else {
                        me.$toastr.error('Ocurrio un error, consulta con el admin', 'Error');
                    }
                });
            },
            guardarFirma() {
                let me = this;
                const { isEmpty, data } = me.$refs.signaturePad.saveSignature();
                if (isEmpty){
                    me.$toastr.warning('Ingrese una firma', 'Firma');
                } else{
                    me.modeloRecepcion.firma = data;
                    me.$toastr.success('Firma guarda correctamente', 'Firma');
                }
            },

               guardarFirma2() {
                let me = this;
                const { isEmpty, data } = me.$refs.signaturePad2.saveSignature();
                if (isEmpty){
                    me.$toastr.warning('Ingrese una firma', 'Firma');
                } else{
                    me.modeloRecepcion.firma2 = data;
                    me.$toastr.success('Firma guarda correctamente', 'Firma');
                }
            },

             reporte(id){
                window.open('recepcion/reporte/'+ id,'_blank');
            },

            listarEmpresas() {
                let me = this;
                me.listaEmpresas= [];
                axios.get('empresas/nombres').then(function (response) {
                    me.listaEmpresas = response.data;
                    me.listaEmpresas.unshift({'code': -1,'label': 'N/A'});
                    me.modeloRecepcion.empresa_id = me.listaEmpresas[me.listaEmpresas.length-1];
                }).catch(function (response) {
                    console.log(response);
                })
            },
            listarEmpresaClientes() {
                let me = this;
                if (!me.modeloRecepcion.empresa_id) return;
                //clientes que no pertenecen a una empresa
                if (me.modeloRecepcion.empresa_id.code === -1){
                    axios.get('customers/particulares').then(function (response) {
                        me.listaClientes = response.data;
                        me.modeloRecepcion.customer_id = me.listaClientes[me.listaClientes.length-1];
                    }).catch(function (response) {
                        console.log(response);
                    })
                }else{
                    axios.get('empresas/customers/'+me.modeloRecepcion.empresa_id.code).then(function (response) {
                        me.listaClientes = response.data;
                        me.modeloRecepcion.customer_id = me.listaClientes[me.listaClientes.length-1];
                    }).catch(function (response) {
                        console.log(response);
                    })
                }
            },
            listarEstadoEquipo(){
                let me = this;
                axios.get('estado-equipo/index').then(function (response) {
                    me.listaEstadoEquipo = response.data;
                    /*me.modeloInterioresEquipo.puerta_interior_frontal = 1;
                    me.modeloInterioresEquipo.puerta_interior_trasera = 1;
                    me.modeloInterioresEquipo.puerta_delantera_frontal = 1;
                    me.modeloInterioresEquipo.puerta_delantera_trasera = 1;

                    me.modeloInterioresEquipo.asiento_interior_frontal = 1;
                    me.modeloInterioresEquipo.asiento_interior_trasera = 1;
                    me.modeloInterioresEquipo.asiento_delantera_frontal = 1;
                    me.modeloInterioresEquipo.asiento_delantera_trasera = 1;

                    me.modeloInterioresEquipo.consola_central = 1;
                    me.modeloInterioresEquipo.claxon = 1;
                    me.modeloInterioresEquipo.tablero = 1;
                    me.modeloInterioresEquipo.quemacocos = 1;
                    me.modeloInterioresEquipo.toldo = 1;
                    me.modeloInterioresEquipo.toldo = 1;
                    me.modeloInterioresEquipo.elevadores_eletricos = 1;
                    me.modeloInterioresEquipo.luces_interiores = 1;
                    me.modeloInterioresEquipo.climatizador = 1;
                    me.modeloInterioresEquipo.radio = 1;
                    me.modeloInterioresEquipo.espejos_retrovizor = 1;
                    me.modeloInterioresEquipo.seguros_eletricos = 1;

                    me.modeloExterioresEquipo.antena_radio = 1;
                    me.modeloExterioresEquipo.antena_telefono = 1;
                    me.modeloExterioresEquipo.antena_cb = 1;
                    me.modeloExterioresEquipo.estribos = 1;
                    me.modeloExterioresEquipo.espejos_laterales = 1;
                    me.modeloExterioresEquipo.guardafangos = 1;
                    me.modeloExterioresEquipo.parabrisas = 1;
                    me.modeloExterioresEquipo.sistema_alarma = 1;
                    me.modeloExterioresEquipo.limpia_parabrisas = 1;
                    me.modeloExterioresEquipo.luces_exteriores = 1;*/
                }).catch(function (error) {
                });
            },
            listarClientes() {
                let me = this;
                axios.get('customers/index').then(function (response) {
                    me.listaClientes = response.data;
                    console.log(response.data);
                }).catch(function (response) {
                    console.log(response);
                })
            },
            listarColores() {
                let me = this;
                axios.get('colores/nombres').then(function (response) {
                    me.listaColores = response.data;
                    me.modeloVehiculo.color_id =   me.listaColores[me.listaColores.length-1];
                }).catch(function (response) {
                    console.log(response);
                })
            },
            listarMarcas() {
                let me = this;
                axios.get('marcas/nombres').then(function (response) {
                    me.listaMarcas = response.data;
                    me.modeloVehiculo.marca_id = me.listaMarcas[me.listaMarcas.length -1];
                }).catch(function (response) {
                    console.log(response);
                })
            },
            listarMarcaModelos() {
                let me = this;
                if(!me.modeloVehiculo.marca_id) return;
                axios.get('marcas/modelos/'+me.modeloVehiculo.marca_id.code).then(function (response) {
                    me.listaModelos = response.data;
                    me.modeloVehiculo.modelo_id = me.listaModelos[me.listaModelos.length -1];
                }).catch(function (response) {
                    console.log(response);
                })
            },
            listarRecepciones(page,orden) {
                let me = this;
                axios.get('recepcion/index?page='+page+'&orden='+orden+'&modulo=5').then(function (response) {
                    console.log(response.data);
                    me.listaRecepciones = response.data.recepciones;
                    me.pagination = response.data.pagination;
                }).catch(function (response) {
                    console.log(response);
                })
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarRecepciones(page,'');
            },
            listarTiposVehiculos() {
                let me = this;
                axios.get('tipos/nombres').then(function (response) {
                    me.listaTiposVehiculo = response.data;
                    me.modeloVehiculo.tipo_id = me.listaTiposVehiculo[me.listaTiposVehiculo.length -1];
                }).catch(function (response) {
                    console.log(response);
                })
            },
            listarVehiculos() {
                let me = this;
                axios.get('vehiculos/index').then(function (response) {
                    me.listaVehiculos = response.data;
                    me.modeloRecepcion.vehiculo_id =   me.listaVehiculos[me.listaVehiculos.length-1];

                }).catch(function (response) {
                    console.log(response);
                })
            },

            regresarFirmaAnterior() {
                this.$refs.signaturePad.undoSignature();
               
            },

            regresarFirmaAnterior2() {
                this.$refs.signaturePad2.undoSignature();
            },

             cambioAuto() {
                if(this.modeloRecepcion.tipoAuto == "1"){
                    this.$refs.signaturePad2.clearSignature()
                    this.$refs.signaturePad2.fromDataURL('img/carro4.png');
                }
                if(this.modeloRecepcion.tipoAuto == "2"){
                     this.$refs.signaturePad2.clearSignature()
                    this.$refs.signaturePad2.fromDataURL('img/carro3.png');
                }
                if(this.modeloRecepcion.tipoAuto == "3"){
                     this.$refs.signaturePad2.clearSignature()
                    this.$refs.signaturePad2.fromDataURL('img/carro1.png');
                }
                if(this.modeloRecepcion.tipoAuto == "4"){
                     this.$refs.signaturePad2.clearSignature()
                    this.$refs.signaturePad2.fromDataURL('img/carro2.png');
                }
                
            },
            vistaColorRegistrar() {
                this.registrarColor = !this.registrarColor;
            },
            vistaClienteRegistrar() {
                this.registrarCliente = !this.registrarCliente;
                this.modeloCliente = {};
                this.modeloCliente.empresa_id = this.modeloRecepcion.empresa_id;
                this.erroresModeloCliente = null;
            },
            vistaEmpresaRegistrar() {
                this.registrarEmpresa = !this.registrarEmpresa;
                this.modeloEmpresa = {};
                this.erroresModeloEmpresa = null;
            },
            vistaMarcaRegistrar() {
                this.modeloMarca = {};
                this.erroresModeloMarca = null;
                this.registrarMarca = !this.registrarMarca;
            },
            vistaModeloRegistrar() {
                this.modeloModelo = {};
                this.erroresModeloMarca = null;
                this.modeloModelo.marca_id = this.modeloVehiculo.marca_id;
                this.registrarModelo = !this.registrarModelo;
            },
            vistaRecepcionRegistrar() {
                let me = this;
                this.updateRecepcion = false;
                this.registrarRecepcion = 1;
                if (this.registrarRecepcion == 1){
                    this.modeloRecepcion.fecha =  new Date(Date.now()).toISOString();
                    this.listarEmpresas();
                    this.listarClientes();
                    this.listarVehiculos();
                    this.listarEstadoEquipo();
                    
                }
                

                
                
            },
            vistaRecepcionCerrar(){
                let me = this;
                this.updateRecepcion = false;
                this.registrarRecepcion = 0;
                if (this.registrarRecepcion == 0){
                    this.modeloRecepcion.fecha =  new Date(Date.now()).toISOString();
                    this.listarEmpresas();
                    this.listarClientes();
                    this.listarVehiculos();
                    this.listarEstadoEquipo();
                    
                }
            },
            vistaVehiculoRegistrar() {
                this.listarTiposVehiculos();
                this.listarMarcas();
                this.listarColores();
                this.modeloVehiculo = {};
                this.erroresModeloVehiculo = null;
                this.registrarVehiculo = !this.registrarVehiculo;
            },
        },
        mounted() {
            this.listarRecepciones(1,'');
            this.listarUbicaciones();
            this.reset();
        }
    }
</script>
<style>
    /*.dropdown{*/
    /*width: 90%;*/
    /*}*/
    /*.dropdown-toggle{*/
    /*height: 38px;*/
    /*}*/
    .modal-content {
        width: 100% !important;
        position: absolute !important;
    }

    .mostrar {
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }

    .div-error {
        display: flex;
        justify-content: center;
    }

    .text-error {
        color: red !important;
        font-weight: bold;
    }

    @media (min-width: 600px) {
        .btnagregar {
            margin-top: 2rem;
        }
    }

</style>
