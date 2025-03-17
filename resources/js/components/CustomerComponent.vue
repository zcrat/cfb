<template>
   <main class="main">
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Usuarios
                        <button type="button" data-toggle="modal" data-target="#usuarioStore" @click="abrirModal" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                       
                    </div>
                    <div class="card-body">

                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                  
                                    <input type="text" v-model="buscar" v-on:keyup.enter="searchCliente" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit"  @click="searchCliente" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                   
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                            <tr>
                                 <th>Opciones</th>
                            
                                <th>Empresa</th>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Dirección</th>
                               
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="customer in customers" :key="customer.id">
                                <td>
                                   
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#usuarioStore"
                                            @click="edit(customer)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm" @click="destroy(customer)">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                                <td>{{customer.nombre}}</td>
                                <td>{{customer.usuario}}</td>
                                <td>{{customer.email}}</td>
                                <td>{{customer.direccion}}</td>
                               
                            </tr>
                            </tbody>
                        </table>
                      <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
     
        <!-- Modal  - nuevo cliente-->
        <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="usuarioStore"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-uppercase" id="exampleModalLongTitle">Nuevo cliente</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                @click="cerrarModal">
                            <span aria-hidden="true"><i class="fas fa-times"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                          <div class="alert alert-danger" v-if="erroresValidacion !== null">
                            <ul v-for="errores in erroresValidacion">
                                <li v-for="error in errores">
                                    {{error}}
                                </li>
                            </ul>
                        </div>
                       
                        <div class="form-group">
                            <label for="customer-idempresa">Empresa:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fas fa-building"></i>
                                </div>
                                <v-select :options="empresas" v-model="customer.idempresa"></v-select>
                                <input id="customer-empresa_ids" class="form-control" type="hidden"  
                                         v-model="customer.empresa_id" 
                                         v-on:keyup="validarCampos">
                            </div>
                        </div>
                     
                        <div class="form-group">
                            <label for="customer-usuario">Nombre:<i
                                    class="ml-2 color-required fas fa-asterisk"></i></label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fas fa-building"></i>
                                </div>
                                <input id="customer-usuario" class="form-control" type="text" placeholder="Ej. Alberto Esquivias Flores"
                                       v-model="customer.usuario"
                                       v-on:keyup="validarCampos">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="customer-direccion">Dirección:<i class="ml-2 color-required fas fa-asterisk"></i></label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <input id="customer-direccion" class="form-control" type="text"
                                       placeholder="Ej. C. PUERTO DE ACAPULCO NO. 328, COL. TINIJARO, C.P. 58337"
                                       v-model="customer.direccion"
                                       v-on:keyup="validarCampos">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                 <label for="customer-ciudad">Ciudad:<i class="ml-2 color-required fas fa-asterisk"></i></label>
                                 <div class="input-group">
                                 <div class="input-group-addon">
                                    <i class="fas fa-map-marker-alt"></i>
                                 </div>
                                 <input id="customer-ciudad" class="form-control" type="text"
                                       placeholder="Ej. Morelia"
                                       v-model="customer.ciudad"
                                       v-on:keyup="validarCampos">
                                 </div>
                                 </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                <label for="customer-estado">Estado:<i class="ml-2 color-required fas fa-asterisk"></i></label>
                                <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <input id="customer-estado" class="form-control" type="text"
                                       placeholder="Ej. Michoacán"
                                       v-model="customer.estado"
                                       v-on:keyup="validarCampos">
                                </div>
                                </div>
                           </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                           <div class="form-group">
                            <label for="customer-cp">C.P.:<i class="ml-2 color-required fas fa-asterisk"></i></label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <input id="customer-cp" class="form-control" type="text"
                                       placeholder="Ej. 58000"
                                       v-model="customer.cp"
                                       v-on:keyup="validarCampos">
                            </div>
                        </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                            <label for="customer-tel_casa">Tel Casa:<i class="ml-2 color-required fas fa-asterisk"></i></label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <input id="customer-tel_casa" class="form-control" type="text"
                                       placeholder="Ej. 4431040746"
                                       v-model="customer.tel_casa"
                                       v-on:keyup="validarCampos">
                            </div>
                        </div>
                            </div>
                        </div>    


                          <div class="row">
                            <div class="col-md-6">
                                 <div class="form-group">
                            <label for="customer-tel_oficina">Tel Oficina:<i class="ml-2 color-required fas fa-asterisk"></i></label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <input id="customer-tel_oficina" class="form-control" type="text"
                                       placeholder="Ej. 4431040746"
                                       v-model="customer.tel_oficina"
                                       v-on:keyup="validarCampos">
                            </div>
                        </div>
                            </div>
                            <div class="col-md-6">
                                 <div class="form-group">
                            <label for="customer-tel_celular">Tel Celular:<i class="ml-2 color-required fas fa-asterisk"></i></label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <input id="customer-tel_celular" class="form-control" type="text"
                                       placeholder="Ej. 4431040746"
                                       v-model="customer.tel_celular"
                                       v-on:keyup="validarCampos">
                            </div>
                        </div>
                            </div>
                          </div>
                        
                        
                         
                        
                        
                        <div class="form-group">
                            <label for="customer-email">Email:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-mail-forward"></i>
                                </div>
                                <input id="customer-email" class="form-control" type="text"
                                       placeholder="Ej. designapp.mx@gmail.com"
                                       v-model="customer.email"
                                       v-on:keyup="validarCampos">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="container-fluid">
                            <div class="row text-right">
                                <div class="col-xs-12" v-if="modalGuardar">
                                    <button type="button" class="btn btn-primary" @click="store"
                                            :disabled="!btnEnabled">
                                        Guardar
                                    </button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                            @click="cerrarModal">Cancelar
                                    </button>
                                </div>
                                <div class="col-xs-12" v-else>
                                    <button type="button" class="btn btn-primary" @click="update"
                                            :disabled="!btnEnabled">
                                        Actualizar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>





    </main>
</template>
<script>
import { constants } from 'crypto';
    // import SiteUrl from './SiteComponent';

    export default {
        data() {
            return {
                url: '',
                customer: {},
                empresas:[], //listado de id y nombre de las empresas  (para registrar una customer que depende de una empresa)
                customers: [], //hace referencia a la lista de resultados
                buscar: '',
                erroresValidacion: null,
                modalGuardar: true, //va al formulario de registro, de lo cantrario a la actualizacion
                urlPagination: 'customers/index',
                pagination: [],
                modal: 0,
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'nombre',
                buscar : '',
                btnEnabled: false
            };
        },
        computed:{
           isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;             

            }
        },
        methods: {
           
            listarArticulo (page,buscar,criterio){
                let me=this;
                var url= 'customers/index?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                
                axios.get(url).then(function (response) {
                    console.log(response.data);
                  
                    var respuesta= response.data;
                    me.customers = respuesta.usuarios.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
           
            doMath: function (index) {
                return index + 1
            },
            limpiarCampos() {
                let me = this;
                me.customer.usuario = '';
                me.customer.direccion = '';
                me.customer.tel_casa = '';
                me.customer.empresa_id = '';
                me.customer.direccion = '';
                me.customer.idempresa = '';
                me.customer.tel_oficina = '';
                me.customer.tel_celular = '';
                me.customer.email = '';
                me.customer.cp = '';
                me.customer.ciudad = '';
                me.customer.estado = '';
                me.modalGuardar = true; //default para guardar
            },
            validarCampos() {
                let me = this;
                me.btnEnabled = me.customer.usuario && me.customer.direccion;
            },
            abrirModal() {
                this.modal = 1;
                this.limpiarCampos();
                this.empresasNombres();
            },
            cerrarModal() {
                this.modal = 0;
                this.limpiarCampos();
            },
            empresasNombres() {
                let me = this;
                axios.get('empresas/nombres').then(function (response) {
                    me.empresas = response.data;
                }).catch(function (error) {
                    console.log(error)
                });
            },
            edit(customer) {

                console.log(customer);
                
                this.abrirModal();
                this.customer.id = customer.id;
                this.customer.idempresa = customer.nombre;
                this.customer.empresa_id = customer.empresa_id;
                this.customer.usuario = customer.usuario;
                this.customer.direccion = customer.direccion;
                this.customer.ciudad = customer.ciudad;
                this.customer.estado = customer.estado;
                this.customer.cp = customer.cp;
                this.customer.tel_casa = customer.tel_casa;
                this.customer.tel_oficina = customer.tel_oficina;
                this.customer.tel_celular = customer.tel_celular;
                this.customer.email = customer.email;
                this.modalGuardar = false; //cambia a estado actulizar
            },
            store() {
            
                let me = this;
                let status = false;
                axios.post(url + 'customers/store', me.customer).then(function (response) {
                    console.log(response.data);
                    //Si el guardado se realizo correctamente
                    if (response.data.estado === true) {
                        
                        let respuesta = [];
                        respuesta = response.data.usuario

                        me.customers.push(respuesta);
                        me.erroresValidacion = null;
                        status = true;
                        me.limpiarCampos();
                        me.cerrarModal();
                        me.$toastr.success('Nuevo Usuario registrado', 'Usuarios');
                    }
                }).catch(function (error) {
                        //error 422 = validacion
                        if (error.response.status === 422) {
                            me.erroresValidacion = error.response.data.errors;
                            me.$toastr.warning('Valida los campos correctamente.', 'Usuarios');
                        } else {
                            me.$toastr.error('Ocurrio un error, consulta con el admin', 'Error');
                        }
                    });
                if (status) {
                    me.erroresValidacion = null;
                    me.limpiarCampos();
                    //agregar elemento registrado a la lista
                }
            },
            update() {
               
                let me = this;
                let status = false;
                axios.post(url + 'customers/update', me.customer).then(function (response) {
                    console.log(response.data);
                     //Si el guardado se realizo correctamente
                    if (response.data.estado === true) {
                        me.limpiarCampos();
                        me.cerrarModal();
                        me.listarArticulo(1,'','nombre');
                        me.erroresValidacion = null;
                        me.$toastr.success('Usuario actualizado', 'Usuarios');
                    }

                })
                    .catch(function (error) {

                        //error 422 = validacion
                        if (error.response.status === 422) {
                            me.erroresValidacion = error.response.data.errors;
                            me.$toastr.warning('Valida los campos correctamente.', 'Usuarios');
                        } else {
                            me.$toastr.error('Ocurrio un error, consulta con el admin', 'Error');
                        }
                    });
                if (status) {
                    me.erroresValidacion = null;
                    me.limpiarCampos();
                }
            },
             cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarArticulo(page,buscar,criterio);
            },
            searchCliente() {
                let me = this;
                let status = false;
                if (!me.buscar) {
                    this.index();
                } else {
                    axios.post(url + 'customers/search', {busqueda: me.buscar}).then(function (response) {
                        console.log("~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~");
                        console.log(response);
                        console.log("~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~");
                        if (response.data.estado === true) {
                            me.erroresValidacion = null;
                            me.customers = response.data.customers;
                        }
                    })
                        .catch(function (error) {

                            //error 422 = validacion
                            if (error.response.status === 422) {
                                me.erroresValidacion = error.response.data.errors;
                                me.$toastr.warning('Valida los campos correctamente.', 'Empresas');
                            } else {
                                me.$toastr.error('Ocurrio un error, consulta con el admin', 'Error');
                            }
                        });
                }
            },
            destroy(customer) {
                let me = this;
                swal({
                    title: 'Usuarios',
                    html: "¿Está seguro de eliminar el usuario " + customer.label + " he información relacionada?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#AEAFAF',
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Eliminar',
                }).then(function (result) {
                    if (result.value === true) {
                        let status = false;
                        axios.post(url + 'customers/destroy', customer).then(function (response) {
                            console.log(response.data);
                            //Si el guardado se realizo correctamente
                            if (response.data.estado === true) {
                                me.listarArticulo(1,'','nombre');
                                me.$toastr.success('Usuario eliminado', 'Usuarios');
                            }
                        })
                            .catch(function (error) {
                                //error 422 = validacion
                                if (error.response.status === 422) {
                                    me.erroresValidacion = error.response.data.errors;
                                    me.$toastr.warning('Ucurrio un error, intenta otra vez.', 'Usuarios');
                                } else {
                                    me.$toastr.error('Ocurrio un error, consulta con el admin', 'Error');
                                }
                            });
                        if (status) {
                            me.erroresValidacion = null;
                            me.limpiarCampos();
                        }
                    }

                }).catch(swal.noop);
            }

        },
        mounted() {
           this.listarArticulo(1,this.buscar,this.criterio);
        }
        
    }
</script>
