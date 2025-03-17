<template>
    <main class="main">
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify mr-2"></i> Reporte de Grúa
                    <button
                        class="btn btn-secondary float-right"
                        type="button"
                        @click="setReporteGrua"
                    >
                        <i class="fa fa-plus-circle mr-2"></i>Agregar
                    </button>
                </div>

                <!-- Listado de recepciones vehiculaes-->
                <template v-if="!vistaReporteGrua">
                <div class="card-body">
                    <div class="form-group">
                    <div class="col-12 col-md-6 offset-md-3">
                        <div class="text-center">
                        <div class="input-group">
                            <input
                            type="text"
                            @keyup.enter="listarIngreso(1,buscar,criterio)"
                            class="form-control"
                            placeholder="Buscar..."
                            />
                            <button
                            type="submit"
                            @click="listarIngreso(1,buscar,criterio)"
                            class="btn btn-primary"
                            >
                            <i class="fa fa-search"></i> Buscar
                            </button>
                        </div>
                        </div>
                    </div>
                    </div>
                    <div class="table-responsive">
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                        <tr>
                            <th>Orden seguimiento</th>
                            <th>Folio</th>
                            <th>Vehículo</th>
                            <th>Fecha inspeccion</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="recepcion in listaRecepcion" :key="listaRecepcion.id">
                            <td v-text="recepcion.orden_seguimiento"></td>
                            <td v-text="recepcion.folio"></td>
                            <td>{{recepcion.placas}} - {{recepcion.modnombre}} - {{recepcion.marnombre}}</td>
                            <td v-text="recepcion.fecha"></td>
                            <td>
                            <button class="btn btn-primary" @click="reporte(recepcion.id)">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </button>
                            <button class="btn btn-warning" @click="editReporte(recepcion.id)">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </button>
                            <button class="btn btn-danger">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    </div>
                    <nav>
                    <ul class="pagination">
                        <li class="page-item" v-if="pagination.current_page > 1">
                        <a
                            class="page-link"
                            href="#"
                            @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)"
                        >Ant</a>
                        </li>
                        <li
                        class="page-item"
                        v-for="page in pagesNumber"
                        :key="page"
                        :class="[page == isActived ? 'active' : '']"
                        >
                        <a
                            class="page-link"
                            href="#"
                            @click.prevent="cambiarPagina(page,buscar,criterio)"
                            v-text="page"
                        ></a>
                        </li>
                        <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                        <a
                            class="page-link"
                            href="#"
                            @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)"
                        >Sig</a>
                        </li>
                    </ul>
                    </nav>
                </div>
                </template>
                <!--Fin Listado-->

                <!--Formulario registrar actualizar-->
		        <template v-if="vistaReporteGrua">       
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-plus-circle mr-2"></i>Nuevo Reporte de Grúa
                            <small class="badge badge-pill badge-secondary px-2">
                                <i class="fa fa-asterisk mr-2" aria-hidden="true"></i>campos obligatorios
                            </small>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="conteiner">                                
                                        <div class="form-group">
                                            <label for="fechaServicio">
                                                <small>
                                                     HORA DE SERVICIO:
                                                    <i class="fa fa-asterisk text-secundary ml-2" ></i>
                                                </small>
                                            </label>
                                            <datetime
                                                input-id="fechaServicio"
                                                input-class="form-control form-control-sm"
                                                type="time"
                                            >
                                                <template slot="button-cancel">
                                                    <i class="fa fa-times mr-2"></i>Cancelar
                                                </template>
                                                <template slot="button-confirm">
                                                    <i class="fa fa-check-circle mr-2"></i>Aceptar
                                                </template>
                                            </datetime>
                                            <label for="hombreExtra">
                                                <small>HOMBRE EXTRA:</small>
                                            </label>
                                            <input type="number" class="form-control form-control-sm" name="hombreExtra" id="hombreExtra" />
                                            <label for="kilometrajeInicial">
                                               <small>KILOMETRAJE INICIAL:</small>
                                            </label>
                                            <input type="number" class="form-control form-control-sm" name="kilometrajeInicial" id="kilometrajeInicial" />
                                            <label for="kilometrajeFinal">
                                               <small>KILOMETRAJE FINAL:</small>
                                            </label>
                                            <input type="number" class="form-control form-control-sm" name="kilometrajeFinal" id="kilometrajeFinal" />
                                            <label for="kilometrajeTotal">
                                                <small>KILOMETRAJE TOTAL:</small>
                                            </label>
                                            <input type="number" class="form-control form-control-sm" name="kilometrajeTotal" id="kilometrajeTotal" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9 border p-1">
                                    <div class="row">
                                        <div class="col-md-4">   
                                            <div class="form-group">
                                                <label for="nombreCliente">
                                                    <small>NOMBRE:</small>
                                                </label>
                                                <input type="text" class="form-control form-control-sm" name="nombreCliente" id="nombreCliente" />

                                                <label for="fechaRecepcion">
                                                    <small>
                                                            HORA DE SERVICIO:
                                                        <i class="fa fa-asterisk text-secundary ml-2" ></i>
                                                    </small>
                                                </label>
                                                <datetime
                                                    input-id="fechaRecepcion"
                                                    input-class="form-control form-control-sm"
                                                    type="datetime"
                                                >
                                                    <template slot="button-cancel">
                                                        <i class="fa fa-times mr-2"></i>Cancelar
                                                    </template>
                                                    <template slot="button-confirm">
                                                        <i class="fa fa-check-circle mr-2"></i>Aceptar
                                                    </template>
                                                </datetime>
                                                <label for="direccionCliente">
                                                    <small>DIRECCIÓN:</small>
                                                </label>
                                                <input type="text" class="form-control form-control-sm" name="direccionCliente" id="direccionCliente" />
                                                <label for="ciudadCliente">
                                                    <small>CIUDAD:</small>
                                                </label>
                                                <input type="text" class="form-control form-control-sm" name="ciudadCliente" id="ciudadCliente" />
                                                <label for="EstadoCliente">
                                                    <small>ESTADO:</small>
                                                </label>
                                                <input type="text" class="form-control form-control-sm" name="EstadoCliente" id="EstadoCliente" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">                                                                    
                                            <div class="form-group">
                                                <label for="telCasaCliente">
                                                    <small>TEL. CASA:</small>
                                                </label>
                                                <input type="text" class="form-control form-control-sm" name="telCasaCliente" id="telCasaCliente" />
                                                <label for="telOficinaCliente">
                                                    <small>TEL. OFICINA:</small>
                                                </label>
                                                <input type="text" class="form-control form-control-sm" name="telOficinaCliente" id="telOficinaCliente" />
                                                <label for="compania">
                                                    <small>COMPAÑIA:</small>
                                                </label>
                                                <input type="text" class="form-control form-control-sm" name="compania" id="compania" />
                                                <label for="anio">
                                                    <small>AÑO:</small>
                                                </label>
                                                <input type="text" class="form-control form-control-sm" name="anio" id="anio" />
                                                <label for="marca">
                                                    <small>MARCA:</small>
                                                </label>
                                                <input type="text" class="form-control form-control-sm" name="marca" id="marca" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">                              
                                            <div class="form-group">                                            
                                                <label for="modelo">
                                                    <small>MODELO:</small>
                                                </label>
                                                <input type="text" class="form-control form-control-sm" name="modelo" id="modelo" />
                                                <label for="color">
                                                    <small>COLOR:</small>
                                                </label>
                                                <input type="text" class="form-control form-control-sm" name="color" id="color" />
                                                <label for="economico">
                                                    <small># ECONOMICO:</small>
                                                </label>
                                                <input type="text" class="form-control form-control-sm" name="economico" id="economico" />
                                                <label for="placas">
                                                    <small>PLACAS:</small>
                                                </label>
                                                <input type="text" class="form-control form-control-sm" name="placas" id="placas" />
                                                <label for="vin">
                                                    <small>VIN:</small>
                                                </label>
                                                <input type="text" class="form-control form-control-sm" name="vin" id="vin" />
                                                <label for="ordenSeguimiento">
                                                    <small>O.R #:</small>
                                                </label> 
                                                <input type="text" class="form-control form-control-sm" name="ordenSeguimiento" id="ordenSeguimiento" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <small>PROBLEMAS CON EL VEHÍCULO:</small>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" name="noArranca" id="noArranca"/>
                                                        <label class="form-check-label" for="noArranca"><small>NO ARRANCA</small></label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" name="bateria" id="bateria"/>
                                                        <label class="form-check-label" for="noArranca"><small>BATERÍA</small></label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" name="llantaPonchada" id="llantaPonchada"/>
                                                        <label class="form-check-label" for="noArranca"><small>LLANTA PONCHADA</small></label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" name="cerrado" id="cerrado"/>
                                                        <label class="form-check-label" for="noArranca"><small>CERRADO</small></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <label for="otroProblema"><small>OTRO</small></label>
                                            <input type="text" class="form-control form-control-sm" name="otroProblema" id="otroProblema"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <small>EL VEHÍCULO SE ENCUENTRA EN:</small>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" name="calle" id="calle"/>
                                                        <label class="form-check-label" for="calle"><small>CALLE</small></label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" name="garage" id="garage"/>
                                                        <label class="form-check-label" for="garage"><small>GARAGE</small></label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" name="estacionamiento" id="estacionamiento"/>
                                                        <label class="form-check-label" for="estacionamiento"><small>ESTACIONAMIENTO</small></label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" name="carretera" id="carretera"/>
                                                        <label class="form-check-label" for="carretera"><small>CARRETERA</small></label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" name="loteBaldio" id="loteBaldio"/>
                                                        <label class="form-check-label" for="carretera"><small>LOTE BALDÍO</small></label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" name="patioTrasero" id="patioTrasero"/>
                                                        <label class="form-check-label" for="patioTrasero"><small>PATIO TRASERO</small></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <label for="otroSeEncuentra"><small>OTRO</small></label>
                                            <input type="text" class="form-control form-control-sm" name="otroSeEncuentra" id="otroSeEncuentra"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="remolcadoDe"><small>REMOLCADO DE:</small></label>
                                    <textarea name="remolcadoDe" id="remolcadoDe" class="form-control" aria-label="With textarea"></textarea>
                                </div>
                                <div class="col-md-4">
                                    <label for="remolcadoA"><small>REMOLCADO A:</small></label>
                                    <textarea name="remolcadoA" id="remolcadoA" class="form-control" aria-label="With textarea"></textarea>
                                </div>
                                <div class="col-md-4">
                                    <label for="observaciones"><small>OBSERVACIONES:</small></label>
                                    <textarea name="observaciones" id="observaciones" class="form-control" aria-label="With textarea"></textarea>
                                </div>                                
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="tel-seg">
                                                <small>FIRMA DEL MECANICO</small>
                                                <i class="fa fa-asterisk text-secundary ml-2"></i>
                                            </label>
                                            <VueSignaturePad height="200px" class="border mb-3" ref="firmaMecanico" />
                                            <div>
                                                <button class="btn btn-primary" @click="guardarFirmaMecanico" >Guardar firma</button>
                                                <button @click="regresarFirmaAnteriorMecanico" class="btn btn-secondary">Paso anterior</button>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="tel-seg">
                                                <small>FIRMA DE AUTORIZACION</small>
                                                <i class="fa fa-asterisk text-secundary ml-2"></i>
                                            </label>
                                            <VueSignaturePad height="200px" class="border mb-3" ref="firmaAutoriza" />
                                            <div>
                                                <button class="btn btn-primary" @click="guardarFirmaAutoriza" >Guardar firma</button>
                                                <button @click="regresarFirmaAnteriorAutoriza" class="btn btn-secondary">Paso anterior</button>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <br>    
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row"> 
                                        <div class="col-md-6"></div>                              
                                        <div class="col-md-6">
                                            <div class="row bg-secondary">
                                                <div class="col-md-7">
                                                    <small>CARGO POR KILOMETRO</small>
                                                </div>
                                                <div class="col-md-4">
                                                    <small>$ </small>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-7">
                                                    <small>CARGO POR REMOLQUE</small>
                                                </div>
                                                <div class="col-md-4">
                                                    <small>$ </small>
                                                </div>
                                            </div>
                                            <div class="row bg-secondary">
                                                <div class="col-md-7">
                                                    <small>CARGO POR SERV. EN CARRETERA</small>
                                                </div>
                                                <div class="col-md-4">
                                                    <small>$ </small>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-7">
                                                    <small>CARGO POR ALMACENAJE</small>
                                                </div>
                                                <div class="col-md-4">
                                                    <small>$ </small>
                                                </div>
                                            </div>
                                            <div class="row bg-secondary">
                                                <div class="col-md-7">
                                                    <small>SUBTOTAL</small>
                                                </div>
                                                <div class="col-md-4">
                                                    <small>$ </small>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-7">
                                                    <small>I.V.A.</small>
                                                </div>
                                                <div class="col-md-4">
                                                    <small>$ </small>
                                                </div>
                                            </div>
                                            <div class="row bg-secondary">
                                                <div class="col-md-7">
                                                    <small>TOTAL</small>
                                                </div>
                                                <div class="col-md-4">
                                                    <small>$ </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col align-self-end">
                                    <button class="btn btn-success">GUARDAR</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>         
    </main>
</template>

<script>
	export default {
		data() {
			return {
                ReporteGrua: {
                    horaServicio: '',
                },
                listaRecepcion: {},
                vistaReporteGrua: false,
                pagination: {
					total: 0,
					current_page: 0,
					per_page: 0,
					last_page: 0,
					from: 0,
					to: 0
                },
            };
        },
        computed: {
            isActived: function() {
                return this.pagination.current_page;
            },

            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if (!this.pagination.to) {
                        return [];
                }

                var from = this.pagination.current_page - this.offset;
                if (from < 1) {
                        from = 1;
                }

                var to = from + this.offset * 2;
                if (to >= this.pagination.last_page) {
                        to = this.pagination.last_page;
                }

                var pagesArray = [];
                while (from <= to) {
                        pagesArray.push(from);
                        from++;
                }
                return pagesArray;
            }
        },
        methods: {
            setReporteGrua() {
                this.vistaReporteGrua = !this.vistaReporteGrua;
            },
            getlistInspeccion(){
                let me = this;
                axios
                .get("inspeccion/index")
                .then(function(response) {
                    me.listaRecepcion = response.data;
                    console.log(response);
                })
                .catch(function(response) {
                    console.log(response);
                });

            },
            guardarFirmaMecanico() {
                let me = this;
                const { isEmpty, data } = me.$refs.firmaMecanico.saveSignature();
                if (isEmpty) {
                    me.$toastr.warning("Ingrese una firma", "Firma");
                } else {
                    me.modeloInspeccion.inspeccionTecnicaVehiculo.anteFirma = data;
                    me.$toastr.success("Firma guarda correctamente", "Firma");
                }
            },
            regresarFirmaAnteriorMecanico() {
                this.$refs.firmaMecanico.undoSignature();
            },
            guardarFirmaAutoriza(){
                let me = this;
                const { isEmpty, data } = me.$refs.firmaAutoriza.saveSignature();
                if (isEmpty) {
                    me.$toastr.warning("Ingrese una firma", "Firma");
                } else {
                    me.modeloInspeccion.inspeccionTecnicaVehiculo.anteFirma = data;
                    me.$toastr.success("Firma guarda correctamente", "Firma");
                }
            },
            regresarFirmaAnteriorAutoriza() {
                this.$refs.firmaAutoriza.undoSignature();
            },
        },
        mounted() {
            this.getlistInspeccion();
        }   
    };        

</script>