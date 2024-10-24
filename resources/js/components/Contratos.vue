<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" @click="$store.state.menuc=0">Escritorio</a></li>
            </ol>

            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify mr-2"></i> Contratos
                          <template v-if="veraspirante==0">
                    <button class="btn btn-secondary btn_sm float-right" type="button" @click="abrirModal">
                        <i class="fa fa-plus-circle mr-2"></i>Nuevo
                    </button>
                          </template>
                    </div>

                     <template v-if="veraspirante==0">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-10">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="clave">Clave</option>
                                      <option value="nombre">Nombre</option>
                        
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarSucursales(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarSucursales(1,buscar,criterio)" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Nombre</th>
                                    <th>Numero</th>
                                    <th>Monto</th>
                                    <th>Fecha de Creación</th>
                                   
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="alumno in arraySucursales" :key="alumno.id">
                                    <td>
                                      
                                        <button type="button"  class="btn btn-warning btn-sm" @click="edit(alumno)">
                                          <i class="icon-pencil"></i>
                                        </button> 
                                       
                                            <button type="button" class="btn btn-danger btn-sm" @click="deleter(alumno)">
                                                <i class="icon-trash"></i>
                                            </button>
                                      
                                    </td>
                                    <td v-text="alumno.nombre"></td>
                                    <td v-text="alumno.numero"></td>
                                    <td v-text="alumno.monto"></td>
                                    <td v-text="alumno.created_at"></td>
                                   
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
               </template>

             <!-- Modal  - Nueva empresa-->
            <template v-if="veraspirante==2">
                 <div class="card">
                        <div v-if="tipoAccion==1" class="card-header">
                            <i class="fa fa-plus-circle mr-2"></i> Nuevo Contrato
                            <small class="badge badge-pill badge-secondary px-2">
                                <i class="fa fa-asterisk mr-2" aria-hidden="true"></i>Campos 0bligatorios
                            </small>
                        </div>
                         <div v-if="tipoAccion==2" class="card-header">
                            <i class="fa fa-plus-circle mr-2"></i> Editar Contrato 
                            <small class="badge badge-pill badge-secondary px-2">
                                <i class="fa fa-asterisk mr-2" aria-hidden="true"></i>Campos 0bligatorios
                            </small>
                        </div>
                    <div class="card-body">

                        


                                 <div class="my-4">
                                    <p class="h5 text-uppercase font-weight-bold  border-bottom">Datos Generales</p>
                                    <div class="row">
                                         <div class="col-12 col-lg-4">
                                            <div class="form-group">
                                                <label for="order-id">Nombre<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                <input id="order-id" class="form-control" type="text"
                                                       placeholder="Ej. MOR001" v-model="modeloSucursal.nombre">
                                            </div>
                                        </div>
                                         <div class="col-12 col-lg-4">
                                            <div class="form-group">
                                                <label for="order-id">Numero<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                <input id="order-id" class="form-control" type="text"
                                                       placeholder="Ej. MOR001" v-model="modeloSucursal.numero">
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <div class="form-group">
                                                <label for="order-id">Monto<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                                <input id="order-id" class="form-control" type="text"
                                                       placeholder="Ej. Sucursal Morelia" v-model="modeloSucursal.monto">
                                            </div>
                                        </div>
                                       
                                       
                                    </div>
                                  
                                    

                                  
                                 </div>
                                <div v-show="errorSucursal" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjSucursal " :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>
                 
                              <div class="my-4">
                                    <div class="col-12 text-right p-3">
                                        <button v-if="tipoAccion==1" class="btn btn-primary" @click="registrarSucursal"><i
                                                class="fa fa-floppy-o mr-2"></i>Guardar
                                        </button>
                                         <button v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarAlumno"><i
                                                class="fa fa-floppy-o mr-2"></i>Actualizar
                                        </button>
                                        <button class="btn btn-secondary" @click="cerrarModal"><i
                                                class="fa fa-times mr-2"></i>Cancelar
                                        </button>
                                    </div>
                                </div>
                </div>
                <!-- /.modal-dialog -->
            </div>
            </template>

             <template v-if="veraspirante==1">
                       <div class="card">
                        
                    <div class="card-body">

                        

                        

                                 <div class="my-4">
                                    <p class="h5 text-uppercase font-weight-bold  border-bottom">Datos Generales</p>
                                    
                                    <div class="row">

                                         <div class="col-12 col-lg-4">
                                            <div class="form-group">
                                                <label for="order-id">Numero<i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                               <b> <h5><p v-text="modeloSucursal.numero"></p></h5></b>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <div class="form-group">
                                                <label for="order-id">Monto</label>
                                               <b> <h5><p v-text="modeloSucursal.monto"></p></h5></b>
                                            </div>
                                        </div>
                                       
                                    </div>
                                 

                                     
                                 </div>
                              <div class="my-4">
                                    <div class="col-12 text-right p-3">
                                       
                                        <button class="btn btn-secondary" @click="cerrarModal"><i
                                                class="fa fa-times mr-2"></i>Cerrar
                                        </button>
                                    </div>
                                </div>
                </div>
                <!-- /.modal-dialog -->
            </div>
                    </template>
          
           </div>
           </div>
        </main>
</template>

<script>
import { constants } from 'crypto';
    export default {
        data (){
            return {
                erroresmodeloSucursals: null,
                modeloSucursal: {},
                modeloSucursalvista: {},
                modeloDireccion: {},
                modeloContacto: {},
                modeloRedes: {},
                modeloAgenda: {},
                arrayRedes : [],
                arrayAgenda : [],
                id:0,
                Sucursales_id: 0,
                nombre : '',
                veraspirante:0,
                tipo_documento : '',
                num_documento : '',
                direccion : '',
                telefono : '',
                email : '',
                usuario: '',
                password:'',
                idrol: '',
                roles : [],
                arraySucursales : [],
                arrayRol : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorSucursal : 0,
                errorMostrarMsjSucursal  : [],
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
                btnEnabled: false,
                erroresValidacion: null,
                registerAlumno: false,
            }
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
        methods : {
            listarSucursales (page,buscar,criterio){
                let me=this;
                var url= 'contratos?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                   console.log(response.data);
                    var respuesta= response.data;
                    me.arraySucursales = respuesta.contratos.data;
                    me.pagination= respuesta.pagination;

                   
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            abrirModal(){
                this.limpiarCampos();
                this.veraspirante=2;
                this.tipoAccion = 1;     
            },
             cerrarModal(){
                this.errorAspirante=0;
                this.veraspirante=0;
            },
            validarSucursal(){
                this.errorSucursal=0;
                this.errorMostrarMsjSucursal  =[];
                
                if (!this.modeloSucursal.numero) this.errorMostrarMsjSucursal .push("Escriba un numero de contrato.");
                if (!this.modeloSucursal.monto) this.errorMostrarMsjSucursal .push("Escriba un monto de contrato .");
                
            
                if (this.errorMostrarMsjSucursal .length) this.errorSucursal = 1;

                return this.errorSucursal;
            },
             registrarSucursal(){
                  let me = this;
                if (me.validarSucursal()){
                    return;
                }

                axios.post('contratos/registrar',{
                    'nombre': this.modeloSucursal.nombre,
                    'numero': this.modeloSucursal.numero,
                    'monto': this.modeloSucursal.monto,
                    
                }).then(function (response) {

                    console.log(response.data);


                     var respuesta = response.data;
                     if (response.data.estado === true) {
                        me.arraySucursales.push(respuesta.Sucursales);
                        me.limpiarCampos();
                        me.cerrarModal();
                        me.$toastr.success('Nuevo Contrato Registrado', 'Contratos');
                     }
                }).catch(function (error) {
                    console.log(error);
                });
            
            },
            limpiarCampos(){
              this.modeloSucursal.numero = '';
              this.modeloSucursal.monto = '';

            },
             edit(alumno) {
                 this.abrirModal();
                 this.modeloSucursal.id = alumno.id;
                 this.modeloSucursal.nombre = alumno.nombre;
                 this.modeloSucursal.numero = alumno.numero;
                 this.modeloSucursal.monto = alumno.monto;
                this.tipoAccion = 2; //cambia a estado actulizar
            },
            deleter(alumno) {
                let me = this;
                swal({
                    title: 'Sucursales',
                    html: "¿Está seguro de eliminar el Sucursal " + alumno.nombre + " e información relacionada?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#AEAFAF',
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Eliminar',
                }).then(function (result) {
                    if (result.value === true) {
                        let status = false;
                        axios.post(url + 'sucursales/delete', alumno).then(function (response) {
                            console.log(response.data);
                            //Si el guardado se realizo correctamente
                            if (response.data.estado === true) {
                                me.listarSucursales(1,'','nombre');
                                me.$toastr.success('Sucursal eliminado', 'Sucursal');
                            }
                        })
                            .catch(function (error) {
                                //error 422 = validacion
                                if (error.response.status === 422) {
                                    me.erroresValidacion = error.response.data.errors;
                                    me.$toastr.warning('Ucurrio un error, intenta otra vez.', 'Alumnos');
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
            },
            actualizarAlumno() {
               let me = this;
                if (me.validarSucursal()){
                    return;
                }
                let status = false;
              
                axios.post(url + 'contratos/update', me.modeloSucursal).then(function (response) {
                    console.log(response.data);
                   
                    //Si el guardado se realizo correctamente
                    if (response.data.estado === true) {
                        me.limpiarCampos();
                        me.cerrarModal();
                        me.listarSucursales(1,'','nombre');
                        me.erroresValidacion = null;
                        me.$toastr.success('Contrato Actualizado', 'Contratos');
                    }

                })
                    .catch(function (error) {

                        //error 422 = validacion
                        if (error.response.status === 422) {
                            me.erroresValidacion = error.response.data.errors;
                            me.$toastr.warning('Válida los campos correctamente.', 'Sucursales');
                        } else {
                            me.$toastr.error('Ocurrio un error, consulta con el admin', 'Error');
                        }
                    });
                if (status) {
                    me.erroresValidacion = null;
                    me.limpiarCampos();
                }
            },
        
             
             verAspirante(id){
                let me=this;
                me.veraspirante=1;

                //Obtener datos del ingreso
                var arrayVista =[];
                var url= 'contratos/obtenerSucursal?id=' + id;

                axios.get(url).then(function (response) {
                    console.log(response.data);
                    var respuesta= response.data;
                    arrayVista = respuesta.alumno;
                    me.arrayRedes = respuesta.redes;
                    me.arrayAgenda = respuesta.agenda;
                    me.limpiarCampos();

                    me.modeloSucursal.id = arrayVista[0]['id'];
                    me.modeloSucursal.clave = arrayVista[0]['clave'];
                    me.modeloSucursal.nombre = arrayVista[0]['nombre'];
                    me.modeloSucursal.calle = arrayVista[0]['calle'];
                    me.modeloSucursal.numero_ext = arrayVista[0]['numero_ext'];
                    me.modeloSucursal.numero_int = arrayVista[0]['numero_int'];
                    me.modeloSucursal.colonia = arrayVista[0]['colonia'];
                    me.modeloSucursal.cp = arrayVista[0]['cp'];
                    me.modeloSucursal.ciudad = arrayVista[0]['ciudad'];
                    me.modeloSucursal.estado = arrayVista[0]['estado'];
                    me.modeloSucursal.telefono = arrayVista[0]['telefono'];
                    me.modeloSucursal.email = arrayVista[0]['email'];


                    
                    
                })
                .catch(function (error) {
                    console.log(error);
                });

             
            },
            ocultarDetalle(){
                this.veraspirante=0;
            },
          
        },
        mounted() {
            this.listarSucursales(1,this.buscar,this.criterio);
        }
    }
</script>
<style>    
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>