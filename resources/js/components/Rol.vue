<template>
            <main class="main">
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify mr-2"></i> Roles
                          <button type="button" data-toggle="modal" data-target="#RolStore" @click="abrirModal" class="btn btn-secondary btn_sm float-right">
                            <i class="fa fa-plus-circle mr-2"></i>&nbsp;Nuevo
                        </button>
                    </div>

                     <template v-if="!registrarRol">

                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-10">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="name">Nombre</option>
                                      <option value="description">Descripción</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarRol(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarRol(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Nombre</th>
                                     <th>Clave</th>
                                    <th>Descripción</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="rol in arrayRol" :key="rol.id">
                                     <td>

                                         
                                        <button type="button" @click="edit(rol.id)" class="btn btn-warning btn-sm">
                                          <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                        </button>
                                       
                                        
                                          
                                    
                                    </td>
                                    
                                    <td v-text="rol.name"></td>
                                     <td v-text="rol.slug"></td>
                                    <td v-text="rol.description"></td>
                                   
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
            <template v-if="registrarRol">
                 <div class="card">
                        <div class="card-header">
                            <i class="fa fa-plus-circle mr-2"></i>Nuevo Rol
                            <small class="badge badge-pill badge-secondary px-2">
                                <i class="fa fa-asterisk mr-2" aria-hidden="true"></i>campos obligatorios
                            </small>
                        </div>
                    <div class="card-body">
                      
                        <div class="form-group">
                            <label for="rol-name">Nombre:<i
                                    class="ml-2 color-required fas fa-asterisk"></i></label>
                            <div class="input-group">
                               
                                <input id="rol-name" class="form-control" type="text" placeholder="Ej. Administrador"
                                       v-model="roler.name"
                                       v-on:keyup="validarCampos">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="rol-slug">Clave:</label>
                            <div class="input-group">
                              
                                <input id="rol-slug" class="form-control" type="text" placeholder="Ej. admin.store"
                                       v-model="roler.slug"
                                       v-on:keyup="validarCampos">
                            </div>
                        </div>

                      
                        <div class="form-group">
                            <label for="rol-description">Descripción:</label>
                            <div class="input-group">
                               
                                <textarea id="rol-description" cols="30" rows="3"  v-model="roler.description"
                                       v-on:keyup="validarCampos" placeholder="Ej. Administrador General" class="form-control" ></textarea>
                        
                            </div>
                        </div>

                         <h3>Permiso Especial</h3>
                        
                        <div class="form-group">
                                <div class="form-check">
                                   <label class="form-check-label">
                                     <input type="radio" v-model="roler.special" class="form-check-input" name="special" id="" value="all-access">
                                    Acceso total
                                   </label>
                                </div>
                                <div class="form-check">
                                   <label class="form-check-label">
                                     <input type="radio" v-model="roler.special" class="form-check-input" name="special" id="" value="no-access">
                                    Ningún acceso
                                   </label>
                                 </div>

                                  <div class="form-check">
                                   <label class="form-check-label">
                                     <input type="radio" v-model="roler.special" class="form-check-input" name="special" id="" value="">
                                    Con permisos
                                   </label>
                                 </div>
                        </div>

                        <h3>Lista de Permisos</h3>
                       
                        <div class="form-group">
                         <ul class="list-unstyled">
                             <li v-for="per in permissions" :key="per.id">
                                 <div class="form-check">
                                    <label>
                                    <input type="checkbox"  class="form-check-input" v-model="permiso" :value="per.id" >
                                     {{per.description}}
                                    </label>
                                 </div>
                             </li>
                         </ul>
                        </div>

                       
                       
                  
                            <div class="row text-right">
                                <div class="col-xs-12" v-if="modalGuardar">
                                    <button type="button" class="btn btn-primary" @click="store">
                                        Guardar
                                    </button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                            @click="abrirModal">Cancelar
                                    </button>
                                </div>
                                <div class="col-xs-12" v-else>
                                    <button type="button" class="btn btn-primary" @click="update(roler)">
                                        Actualizar
                                    </button>
                                </div>
                            </div>
                        </div>
                 </div>
                        </template>
                </div>
                </div>
           <div>
           </div>
        </main>
</template>

<script>
    export default {
        data (){
            return {
                url: '',
                rol_id: 0,
                name : '',
                roler: {},
                description : '',
                arrayRol : [],
                permiso: [],
                permissions : [],
                modalGuardar: true, 
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'name',
                buscar : '',
                btnEnabled: false,
                registrarRol: false,
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
            listarRol (page,buscar,criterio){
                let me=this;
                var url= 'rol?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    console.log(response.data);
                    var respuesta= response.data;
                    me.arrayRol = respuesta.roles.data;
                    me.permissions = respuesta.permissions;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            validarCampos() {
                let me = this;
                me.btnEnabled = me.roler.name && me.roler.slug;
            },
            limpiarCampos() {
                let me = this;
                me.roler.name = '';
                me.roler.slug = '';
                me.roler.description = '';
                me.roler.special = '';
                me.permiso = [];
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarRol(page,buscar,criterio);
            },
             abrirModal() {
                if (!this.registrarRol){
                

                    
                }
                this.registrarRol = !this.registrarRol;
                
            },
            cerrarModal() {
                this.modal = 0;
                this.limpiarCampos();
            },
            store() {
                let me = this;
                let status = false;
                axios.post(url + 'rol/store',
                {
                    'rol': me.roler,
                    'per': me.permiso
                
                }
                 ).then(function (response) {
                    console.log(response.data);
                    //Si el guardado se realizo correctamente
                    if (response.data.estado === true) {

                        me.arrayRol.push(response.data.roles);
                         me.limpiarCampos();
                         me.abrirModal();
                        me.$toastr.success('Nuevo Rol Agregado', 'Roles');
                       
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
                if (status) {
                    me.erroresValidacion = null;
                    me.limpiarCampos();
                    //agregar elemento registrado a la lista
                }
            },
             edit(rol) {
                
                let me = this;
            var url = 'rol/edit?id='+rol;
                axios.get(url).then(function (response) {

               console.log(response.data);
                var respuesta= response.data;
                me.arrayRol = respuesta.roles
                me.permissions = respuesta.permisos;
                me.permiso = respuesta.permisoscheck;
            

                me.abrirModal();
                me.roler.id = me.arrayRol.id;
                me.roler.name = me.arrayRol.name;
                me.roler.slug = me.arrayRol.slug;
                me.roler.description = me.arrayRol.description;
                me.roler.special = me.arrayRol.special;
                me.modalGuardar = false; //cambia a estado actulizar
                   
                }).catch(function (error) {
                    console.log(error);
                }); 

               
            },
             update(roler) {
                let me = this;
                let status = false;
                axios.post(url + 'rol/actualizar',
                {
                    'rol': roler,
                    'per': me.permiso
                
                }
                 ).then(function (response) {
                    console.log(response.data);
                    //Si el guardado se realizo correctamente
                        
                        me.limpiarCampos();
                         me.abrirModal();
                         
                        me.$toastr.success('Rol Actualizado con exito', 'Roles');
                       
                       
                    

               }).catch(function (error) {
                    console.log(error);
                }); 
                 this.listarRol(1,this.buscar,this.criterio);
            },

        },
        mounted() {
            this.listarRol(1,this.buscar,this.criterio);
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
