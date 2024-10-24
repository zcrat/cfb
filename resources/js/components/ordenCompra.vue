<template>
    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#" @click="$store.state.menuc=0">Escritorio</a>
            </li>
        </ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify mr-2"></i> Orden de Compra
                    <button
                        class="btn btn-secondary float-right"
                        type="button"
                        @click="setOrdenCompra"
                    >
                        <i class="fa fa-plus-circle mr-2"></i>Agregar
                    </button>
                </div>
                <!-- Listado de recepciones vehiculaes-->
                <template v-if="!vistaOrdenCompra">
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
                            <tr v-for="orden of listaOrdenCompras" :key="listaOrdenCompras.id">
                                <td v-text="orden.ordenSeguimiento"></td>
                                <td v-text="orden.folio"></td>
                                <td v-text="orden.vehiculo"></td>
                                <td v-text="orden.fecha"></td>
                                <td>
                                <button class="btn btn-primary" @click="reporte(orden.id)">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </button>
                                <button class="btn btn-warning" @click="editOrdenCompras(orden.id)">
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

                <template v-if="vistaOrdenCompra">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-plus-circle mr-2"></i>Nueva Orden de Compra
                            <small class="badge badge-pill badge-secondary px-2">
                                <i class="fa fa-asterisk mr-2" aria-hidden="true"></i>campos obligatorios
                            </small>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="fechaOrdenCompra">
                                            <small>
                                                    FECHA:
                                                <i class="fa fa-asterisk text-secundary ml-2" ></i>
                                            </small>
                                        </label>
                                        <datetime
                                            input-id="fechaOrdenCompra"
                                            input-class="form-control form-control-sm"
                                            type="date"
                                            v-model="ordenCompra.fechaCreacion"
                                        >
                                            <template slot="button-cancel">
                                                <i class="fa fa-times mr-2"></i>Cancelar
                                            </template>
                                            <template slot="button-confirm">
                                                <i class="fa fa-check-circle mr-2"></i>Aceptar
                                            </template>
                                        </datetime>
                                    </div>
                                    <div class="form-group">
                                        <label for="horaOrdenCompra">
                                            <small>
                                                    HORA DE SERVICIO:
                                                <i class="fa fa-asterisk text-secundary ml-2" ></i>
                                            </small>
                                        </label>
                                        <datetime
                                            input-id="horaOrdenCompra"
                                            input-class="form-control form-control-sm"
                                            type="time"
                                            v-model="ordenCompra.horaCreacion"
                                        >
                                            <template slot="button-cancel">
                                                <i class="fa fa-times mr-2"></i>Cancelar
                                            </template>
                                            <template slot="button-confirm">
                                                <i class="fa fa-check-circle mr-2"></i>Aceptar
                                            </template>
                                        </datetime>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="ordenSeguimiento"><small>PARA LA O.R.#:</small></label>
                                        <input type="number" class="form-control form-control-sm" name="ordenSeguimiento" id="ordenSeguimiento" v-model="ordenSeguimiento" v-on:change="getORConcepto"/>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="marcaModeloAnio"><small>MARCA/MODELO/AÑO:</small></label>
                                        <input type="text" class="form-control form-control-sm" name="marcaModeloAnio" id="marcaModeloAnio" v-model="ordenCompra.marcaModeloAnio"/>
                                    </div>
                                </div>
                                <div class="col-md-2 offset-md-4 ">
                                    <div class="card">
                                        <div class="card-header text-center p-0">
                                            <small>FOLIO</small>
                                        </div>
                                        <div class="card-body text-center p-0 text-danger ">
                                            N° {{ordenCompra.folio}}
                                        </div>
                                    </div>
                                </div>
                            </div>  
                            <div class="row">                                
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="para"><small>Para:</small></label>
                                        <input type="text" class="form-control form-control-sm" v-model="ordenCompra.para" name="para" id="para"/>
                                    </div>
                                </div>
                            </div>  
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="asignadaMensajeroHora"><small>Asignada al mensajero - Hora:</small></label>
                                        <datetime
                                            input-id="asignadaMensajeroHora"
                                            input-class="form-control form-control-sm"
                                            type="time"
                                            v-model="ordenCompra.asignadaMensajeroHora"
                                        >
                                            <template slot="button-cancel">
                                                <i class="fa fa-times mr-2"></i>Cancelar
                                            </template>
                                            <template slot="button-confirm">
                                                <i class="fa fa-check-circle mr-2"></i>Aceptar
                                            </template>
                                        </datetime>  
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="entregadaMensajeroHora"><small>Entregada por el mensajero - Hora:</small></label>
                                        <datetime
                                            input-id="entregadaMensajeroHora"
                                            input-class="form-control form-control-sm"
                                            type="time"
                                            v-model="ordenCompra.entregadaMensajeroHora"
                                        >
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
                            <br>
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="clave"><small>Clave</small></label>
                                    <input type="number" name="clave" id="clave" class="form-control form-control-sm" v-model="clave"/>
                                </div>
                                <div class="col-md-2">
                                    <label for="cantidad"><small>Cantidad</small></label>
                                    <input type="number" name="cantidad" id="cantidad" class="form-control form-control-sm" v-model="cantidad" v-on:change="calcularMonto"/>
                                </div>
                                <div class="col-md-4">
                                  <label for="descripcion" >Descripción</label>                            
                                  <input type="serach" 
                                    class="form-control form-control-sm"  
                                    name="descripcion" id="descripcion" 
                                    v-model="descripcion"
                                    v-on:change="setArticulo"
                                    list="listArticulos"
                                  >
                                </div>  
                                <datalist id="listArticulos">
                                  <option v-for="articulo in articulos" :key="articulo.id" >
                                    {{articulo.id}}-{{articulo.descripcion}}
                                    <input type="hidden" :value="articulo.idcategoria"  :id="'articulo'+articulo.id"/>
                                    <input type="hidden" :value="articulo.codigo_sat" :id="'articuloClave'+articulo.id"/>
                                    <input type="hidden" :value="articulo.precio_venta" :id="'articuloPrecio'+articulo.id" />
                                    <input type="hidden" :value="articulo.id" :id="'idArticulo'+articulo.id" />
                                  </option> 
                                </datalist> 
                                <div class="col-md-2">
                                    <label for="precio"><small>Precio</small></label>
                                    <input type="number" name="precio" id="precio" class="form-control form-control-sm" v-model="precio"/>
                                </div>
                                <div class="col-md-2">
                                    <label for="monto"><small>Monto</small></label>
                                    <input type="number" name="monto" id="monto" class="form-control form-control-sm" v-model="monto"/>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-success" v-on:click="agregarConcepto" type="button">Agregar</button>
                                </div>
                                <div style="display:none">
                                    {{conceptosAgregados}}
                                </div>
                            </div>
                            <br>
                            Por favor realice la orden para lo siguiente:
                            <table class="table">
                                <thead class="bg-secondary text-center">
                                    <tr>
                                        <th class="p-0"><small>CLAVE</small></th>
                                        <th class="p-0"><small>CANTIDAD</small></th>
                                        <th class="p-0"><small>DESCRIPCIÓN</small></th>
                                        <th class="p-0"><small>PRECIO</small></th>
                                        <th class="p-0"><small>MONTO</small></th>
                                        <th>ACCION</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <tr  v-for="(item) of conceptos" :id="'item-'+item.numConcepto" :key="item.numConcepto">
                                        <td v-text="item.clave"></td>
                                        <td v-text="item.cantidad"></td>
                                        <td v-text="item.descripcion"></td>
                                        <td v-text="item.precio"></td>
                                        <td v-text="item.monto"></td>
                                        <td>
                                            <button class="btn btn-danger" v-on:click="eliminarConcepto(item.numConcepto,item.id)">
                                                <i class="fa fa-trash"></i> 
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="row">                                
                                <div class="col-md-4">
                                    <label for="recibidoHora"><small>HORA RECIBIDO</small></label>
                                    <datetime
                                        input-id="recibidoHora"
                                        input-class="form-control form-control-sm"
                                        type="time"
                                        v-model="ordenCompra.horaRecibido"
                                    >
                                        <template slot="button-cancel">
                                            <i class="fa fa-times mr-2"></i>Cancelar
                                        </template>
                                        <template slot="button-confirm">
                                            <i class="fa fa-check-circle mr-2"></i>Aceptar
                                        </template>
                                    </datetime>  
                                </div>
                            </div>  
                            <div class="row">
                                <div class="col-md-6">
                                    <label for=""><small>AUTORIZADO POR</small></label>
                                    <VueSignaturePad height="100px" class="border mb-3" ref="firmaAutoriza" />
                                    <div>
                                        <button class="btn btn-primary" @click="guardarFirmaAutoriza" >Guardar firma</button>
                                        <button @click="regresarFirmaAnteriorAutoriza" class="btn btn-secondary">Paso anterior</button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for=""><small>FIRMAR DE RECIBIDO</small></label>
                                    <VueSignaturePad height="100px" class="border mb-3" ref="firmaRecibido" />
                                    <div>
                                        <button class="btn btn-primary" @click="guardarFirmaRecibido" >Guardar firma</button>
                                        <button @click="regresarFirmaAnteriorRecibido" class="btn btn-secondary">Paso anterior</button>
                                    </div>    
                                </div>  
                            </div>       
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-success" v-if="!update" v-on:click="guardarOrdenCompra">Guardar</button>
                            <button class="btn btn-success" v-if="update" v-on:click="updateOrdenCompra">Actualizar</button>
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
                update:false,
                conceptos:{},
                monto:'',
                precio:'',
                descripcion:'',
                cantidad:'',
                clave:'',
                idArticulo:'',
                ordenCompra: {
                    fechaCreacion:'',
                    horaCreacion:'',
                    marcaModeloAnio:'',
                    folio:'',
                    para:'',
                    asignadaMensajeroHora:'',
                    entregadaMensajeroHora:'',
                    horaRecibido:'',
                    firmaRecibido:'',
                    firmaAutoriza:'',
                    ordenSeguimiento:''
                },
                conceptosAgregados:0,
                totalConceptos:'',
                articulos:'',
                ordenSeguimiento:0,
                listaOrdenCompras: [],
                vistaOrdenCompra: false,
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
            },
            calcularTotal: function() {
                var resultado = 0.0;
                for (var i = 0; i < this.arrayDetalle.length; i++) {
                    resultado =
                    resultado +
                    this.arrayDetalle[i].precio * this.arrayDetalle[i].cantidad;
                }
                return resultado;
            },
        },
        methods: {
            editOrdenCompras(id){
                let me = this;
                axios
                    .get('ordenCompra/' + id + '/edit')
                    .then(function(response){
                        me.ordenCompra = response.data.ordenCompra;
                        me.ordenSeguimiento = response.data.ordenCompra.ordenSeguimiento;
                        me.conceptos = response.data.conceptos;
                        me.totalConceptos = response.data.ordenCompra.numConcepto;
                        me.setOrdenCompra();
                        me.update = true;
                        console.log(response.data);
                    }).catch(function(error){
                        console.log(error);
                    });
            }, 
            eliminarConcepto(numConcepto, id){
                console.log(numConcepto);
                delete this.conceptos[numConcepto];
                document.getElementById("item-"+numConcepto).remove();
                if(this.update == true && id != undefined){
                    let me = this;
                    axios
                    .delete('concepto/'+numConcepto+'/'+id)
                    .then(function(response){
                        console.log(response.data);

                    })
                    .catch(function(arror){

                    });
                }
                
                console.log(this.conceptos);
            },
            updateOrdenCompra(){
                let me = this;
                me.ordenCompra.conceptos = me.conceptos; 
                me.ordenCompra.ordenSeguimiento = me.ordenSeguimiento;
                axios
                    .put('ordenCompra/'+ me.ordenCompra.id,{
                        ordenCompra: me.ordenCompra
                    })
                    .then(function(response){
                        console.log(response.data);
                    })
                    .catch(function(error){
                        console.log(error);
                    });
            },
            guardarOrdenCompra(){
                let me = this;
                me.ordenCompra.conceptos = me.conceptos; 
                me.ordenCompra.ordenSeguimiento = me.ordenSeguimiento;
                axios
                    .post('ordenCompra',me.ordenCompra)
                    .then(function(response){
                        console.log(response.data);
                    })
                    .catch(function(error){
                        console.log(error);
                    });
            },
            calcularMonto(){
                this.monto = parseFloat(this.cantidad * this.precio); 
            },
            setArticulo(){
                var temp = this.descripcion.split('-');
                this.descripcion = temp[1];

                this.clave      = document.getElementById('articuloClave'+temp[0]).value;
                this.precio     = document.getElementById('articuloPrecio'+temp[0]).value;   
                this.idArticulo = document.getElementById('idArticulo'+temp[0]).value;           

            },
            agregarConcepto(){
                this.totalConceptos = parseInt(this.totalConceptos)+1;
                this.conceptosAgregados = this.conceptosAgregados + 1;
                this.conceptos[this.conceptosAgregados] = {
                    idLocal:this.conceptosAgregados,
                    numConcepto:this.totalConceptos,
                    id_articulo:this.idArticulo,
                    clave:this.clave, 
                    cantidad:this.cantidad, 
                    descripcion:this.descripcion,
                    precio:this.precio,
                    monto:this.monto
                };
                console.log(this.totalConceptos);
                console.log(this.conceptos);
            },
            getArticulo(){
                let me = this;
                axios
                    .get("articulo/partes/get")
                    .then(function(response){
                        me.articulos = response.data;
                        console.log(response.data);
                    })
                    .catch(function(response){
                        console.log(response);
                    });
            },
            getORConcepto(){
                let me = this;
                axios     
                    .get("ordenCompra/" + me.ordenSeguimiento)
                    .then(function(response){
                        me.ordenCompra = response.data;
                        me.totalConceptos = response.data.numConcepto;
                        console.log(me.totalConceptos);
                    })
                    .catch(function(response){
                        console.log(response);
                    });
            },
            setOrdenCompra() {
                this.update = false;
                this.vistaOrdenCompra = !this.vistaOrdenCompra;
            },
            getlistOrdenCompra(){
                let me = this;
                axios
                    .get("listOrdenCompra/index")
                    .then(function(response) {
                        me.listaOrdenCompras = response.data;
                        console.log(me.listaOrdenCompras);
                    })
                    .catch(function(response) {
                        console.log(response);
                    });

            },
            guardarFirmaRecibido() {
                let me = this;
                const { isEmpty, data } = me.$refs.firmaRecibido.saveSignature();
                if (isEmpty) {
                    me.$toastr.warning("Ingrese firma de Recibido", "Firma");
                } else {
                    me.ordenCompra.firmaRecibido = data;
                    me.$toastr.success("Firma de Recibido guarda correctamente", "Firma");
                }
            },
            regresarFirmaAnteriorRecibido() {
                this.$refs.firmaRecibido.undoSignature();
            },
            guardarFirmaAutoriza(){
                let me = this;
                const { isEmpty, data } = me.$refs.firmaAutoriza.saveSignature();
                if (isEmpty) {
                    me.$toastr.warning("Ingrese firma de Autorizado", "Firma");
                } else {
                    me.ordenCompra.firmaAutoriza = data;
                    me.$toastr.success("Firma de Autorizado guarda correctamente", "Firma");
                }
            },
            regresarFirmaAnteriorAutoriza() {
                this.$refs.firmaAutoriza.undoSignature();
            },

            reporte(id){
                window.open("ordenCompra/reporte/" + id, "_blank");
            }
        },
        mounted() {
            this.getlistOrdenCompra();
            this.getArticulo();
        }   
    };
</script>