<template>
            <main class="main">
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify mr-2"></i> Usuarios
                        <button v-if="tipoAccion==0" type="button" @click="abrirModalnuevo" class="btn btn-secondary btn_sm float-right">
                            <i class="fa fa-plus-circle mr-2"></i>&nbsp;Nuevo
                        </button>
                    </div>

                     <template v-if="!registrarUser">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-10">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="email">Correo</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarPersona(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarPersona(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Sucursal</th>
                                    <th>Rol</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="persona in arrayPersona" :key="persona.id">
                                    <td>
                                        <button type="button" @click="edit(persona.id)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                      
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarUsuario(persona.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        
                                       
                                    </td>
                                    <td v-text="persona.nombre"></td>
                                    <td v-text="persona.email"></td>
                                    <td v-text="persona.sucursal"></td>
                                    <td v-text="persona.rol"></td>
                                   
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
            <template v-if="registrarUser">
                 <div class="card">
                        <div class="card-header">
                            <i class="fa fa-plus-circle mr-2"></i>Nuevo Usuario
                            <small class="badge badge-pill badge-secondary px-2">
                                <i class="fa fa-asterisk mr-2" aria-hidden="true"></i>campos obligatorios
                            </small>
                        </div>
                    <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre  <i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de la persona">                                        
                                    </div>
                                </div>
                               
                              
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Correo  <i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="email" class="form-control" placeholder="Correo">
                                    </div>
                                </div>
                               
                            
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Contraseña  <i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                    <div class="col-md-9">
                                        <input type="password" v-model="password" class="form-control" placeholder="Contraseña del usuario">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="plantel" class="col-md-3 form-control-label">Sucursales  <i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                    <div class="col-md-9">
                                       <select class="form-control" v-model="planteles_id" >
                                                        <option value="0" disabled>Seleccione su sucursal</option>
                                                        <option v-for="plantel in arrayPlanteles" :key="plantel.id" :value="plantel.id" v-text="plantel.nombre"></option>
                                                 </select>
                                    </div>
                                </div>
                                <div v-show="errorPersona" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjPersona" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        <br>
                        <h3>Lista de Roles</h3>

                        <div class="form-group">
                         <ul class="list-unstyled">
                             <li v-for="rol in arrayRol" :key="rol.id">
                                 <div class="form-check">
                                  <label class="form-check-label">
                                     <input type="checkbox" v-model="roles" class="form-check-input"   :value="rol.id" >
                                     {{ rol.name }}
                                    <em> ({{ rol.description }}) </em> 
                                   </label>
                                  
                                 </div>
                             </li>
                         </ul>
                        </div>

                        
                     
                   
                       
                        
                            <div class="form-group row">
                        
                            <button type="button" class="btn btn-secondary" @click="cerrarModal">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarPersona()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarPersona()">Actualizar</button>
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
                user_id: 0,
                nombre : '',
                tipo_documento : '',
                num_documento : '',
                direccion : '',
                telefono : '',
                email : '',
                usuario: '',
                password:'',
                idrol: '',
                roles : [],
                arrayPersona : [],
                arrayRol : [],
                arrayPlanteles:[],
                planteles_id:0,
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorPersona : 0,
                errorMostrarMsjPersona : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                selectId:1,
                selectedOption:'',
                offset : 3,
                criterio : 'nombre',
                buscar : '',
                btnEnabled: false,
                registrarUser: false,
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
            listarPersona (page,buscar,criterio){
                let me=this;
                var url= 'user?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                   
                    var respuesta= response.data;
                    me.arrayPersona = respuesta.personas.data;
                    me.arrayRol = respuesta.roles;
                    me.arrayPlanteles = respuesta.planteles;
                    me.pagination= respuesta.pagination;
                   
                   
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarPersona(page,buscar,criterio);
            },
            registrarPersona(){

                if (this.validarPersona()){
                    return;
                }
               
                let me = this;

                axios.post('user/registrar',{
                    'planteles_id': this.planteles_id,
                    'nombre': this.nombre,
                    'email' : this.email,
                    'password': this.password,
                    'roles': this.roles

                }).then(function (response) {
                    console.log(response.data);
                    me.cerrarModal();
                    me.listarPersona(1,'','nombre');
                    me.$toastr.success('Nuevo Usuario Agregado', 'Usuarios');
                }).catch(function (error) {
                    console.log(error);
                });
            },
              edit(user) {
                this.tipoAccion = 2;
                
                let me = this;
                var url = 'user/edit?id='+user;
                axios.get(url).then(function (response) {

                console.log(response.data);
                var respuesta= response.data;
                me.arrayPersona = respuesta.persona;
                me.arrayRol = respuesta.roles;
                me.roles = respuesta.rolescheck;
            

                me.abrirModal();
                me.user_id = me.arrayPersona.id;
                me.nombre = me.arrayPersona.name;
                me.email = me.arrayPersona.email;
                me.planteles_id = me.arrayPersona.sucursal_id;
                me.modalGuardar = false; //cambia a estado actulizar
                   
                }).catch(function (error) {
                    console.log(error);
                }); 

               
            },
            actualizarPersona(){
                 this.tipoAccion = 1;
               
               if (this.validarPersona()){
                    return;
                }
                
                let me = this;

                axios.put('user/actualizar',{
                    'planteles_id': this.planteles_id,
                    'name': this.nombre,
                    'email' : this.email,
                    'password': this.password,
                    'id': this.user_id,
                    'roles': this.roles
                }).then(function (response) {
                    console.log(response.data);
                    me.cerrarModal();
                    me.listarPersona(1,'','nombre');
                    me.$toastr.success('Usuario actualizo con exito', 'Usuarios');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            validarPersona(){
                this.errorPersona=0;
                this.errorMostrarMsjPersona =[];

                if (!this.nombre) this.errorMostrarMsjPersona.push("El nombre de la pesona no puede estar vacío.");
                if (!this.email) this.errorMostrarMsjPersona.push("El email del usuario no puede estar vacía.");
                if (!this.password) this.errorMostrarMsjPersona.push("El password del usuario no puede estar vacía.");
                if (this.planteles_id==0) this.errorMostrarMsjPersona.push("Debe sellecionar un sucursal.");
                if (this.errorMostrarMsjPersona.length) this.errorPersona = 1;

                return this.errorPersona;
            },
            cerrarModal(){
    
                this.abrirModal();
                this.tipoAccion=0;
                this.tituloModal='';
                this.user_id=0;
                this.nombre='';
                this.email='';
                this.planteles_id=0;
                this.errorPersona=0;
               
            },
            abrirModal(){
                if (!this.registrarUser){
                     this.listarPersona(1,this.buscar,this.criterio);
                }
                this.registrarUser = !this.registrarUser;
                
            },

            abrirModalnuevo(){
                if (!this.registrarUser){
                   this.tipoAccion = 1;
                    
                }
                this.registrarUser = !this.registrarUser;
            },
            desactivarUsuario(id){
               swal({
                title: 'Esta seguro de desactivar este usuario?',
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

                    axios.put('user/desactivar',{
                        'id': id
                    }).then(function (response) {
                        console.log(response);
                        me.listarPersona(1,'','nombre');
                        swal(
                        'Desactivado!',
                        'El registro ha sido desactivado con éxito.',
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
            activarUsuario(id){
               swal({
                title: 'Esta seguro de activar este usuario?',
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

                    axios.put('user/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarPersona(1,'','nombre');
                        swal(
                        'Activado!',
                        'El registro ha sido activado con éxito.',
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
        },
        mounted() {
            this.listarPersona(1,this.buscar,this.criterio);
           
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
