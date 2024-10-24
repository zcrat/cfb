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
                <i class="fa fa-align-justify mr-2"></i> Tareas 
                <div class="col-md-6 ">
                    <div class="row">
                <select class="form-control" v-model="nombretarea" >
                                                        <option value="0" disabled>Seleccione su usuario</option>
                                                        <option v-for="plantel in arrayPersona" :key="plantel.id" :value="plantel.nombre" v-text="plantel.nombre"></option>
                </select>
                     </div>
                </div>

                <button class="btn btn-info btn_sm float-right" type="button" @click="listarPersona3 ('1','','nombre',nombretarea)">
                        <i class="fa fa-plus-circle mr-2"></i>Mis tareas
                 </button>
                <button class="btn btn-danger btn_sm float-right" type="button" @click="listarPersona2 ('1','3','status',nombretarea)">
                        <i class="fa fa-plus-circle mr-2"></i>Fuera de tiempo
                 </button>
                 <button class="btn btn-success btn_sm float-right" type="button" @click="listarPersona2 ('1','2','status',nombretarea)">
                        <i class="fa fa-plus-circle mr-2"></i>Terminadas
                 </button>
                 <button class="btn btn-primary btn_sm float-right" type="button" @click="listarPersona2 ('1','1','status',nombretarea)">
                        <i class="fa fa-plus-circle mr-2"></i>Nuevas
                 </button>
                 <button class="btn btn-warning btn_sm float-right" type="button" @click="listarPersona2 ('1','4','status',nombretarea)">
                        <i class="fa fa-plus-circle mr-2"></i>En proceso
                 </button>
                 <button class="btn btn-secondary btn_sm float-right" type="button" @click="listarPersona2 ('1','5','status',nombretarea)">
                        <i class="fa fa-plus-circle mr-2"></i>Por aprobar terminacion
                 </button>

                 <div class="col-md-4">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                       <option value="descripcion">Descripcion</option>
                                      <option value="id_user">Id Usuario</option>
                                    </select>
                                    <template v-if="criterio == 'id_user'">
                                    <div class="col-md-3">
                                       <select class="form-control" v-model="buscar" >
                                                        <option value="0" disabled>Seleccione su usuario</option>
                                                        <option v-for="plantel in arrayPersona" :key="plantel.id" :value="plantel.id" v-text="plantel.nombre"></option>
                                        </select>
                                    </div>
                                    </template>
                                    <template v-if="criterio == 'descripcion'">
                                    <input type="text" v-model="buscar" @keyup.enter="listarPersona2(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    </template>
                                    <button type="submit" @click="listarPersona2(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                </div>
            </div>

             <template v-if="!registrarUser">
            <div class="card-body">
            

                <div class="row">
                    <div class="col-md-6 ">
                        <div class="row">
                            <div v-for="persona in arrayPersona" :key="persona.id" class="col-md-4 ">
                               
                                    <blockquote class="blockquote text-center">
                                        <img :src="'img/user.png'" class="rounded-circle" width="120" alt="" @click="agregarTarea(persona.id)">
                                    <p class="mb-0">{{ persona.nombre }}</p>
                                    <footer class="blockquote-footer">{{persona.sucursal}} <cite title="Source Title">{{persona.rol}}</cite></footer>
                                    </blockquote>
                                
                            </div>
                        </div>
                 
                    </div>
                    <div class="col-md-6 ">
                        <div class="col-md-12" v-for="persona1 in arrayPersona2" :key="persona1.id">
                        <template v-if="persona1.status == 1">
                            <div class="alert alert-primary" role="alert" @click="edit(persona1)">
                                {{ persona1.nombre }}  - {{ persona1.id }} - {{ persona1.descripcion }}
                            <button type="button" class="btn btn-danger btn-sm float-right" @click="desactivarUsuario(persona1.id)">
                                                <i class="icon-trash"></i>
                             </button>
                            </div>
                        </template>
                        <template v-if="persona1.status == 2">
                            <div class="alert alert-success" role="alert" @click="edit(persona1)" >
                                {{ persona1.nombre }}  - {{ persona1.id }} - {{ persona1.descripcion }}
                            <button type="button" class="btn btn-danger btn-sm float-right" @click="desactivarUsuario(persona1.id)">
                                                <i class="icon-trash"></i>
                             </button>
                            </div>
                        </template>
                        <template v-if="persona1.status == 3">
                            <div class="alert alert-danger" role="alert" @click="edit(persona1)">
                                {{ persona1.nombre }}  - {{ persona1.id }} - {{ persona1.descripcion }}
                            <button type="button" class="btn btn-danger btn-sm float-right" @click="desactivarUsuario(persona1.id)">
                                                <i class="icon-trash"></i>
                             </button>
                            </div>
                        </template>
                        <template v-if="persona1.status == 4">
                            <div class="alert alert-warning" role="alert" @click="edit(persona1)" >
                                {{ persona1.nombre }}  - {{ persona1.id }} - {{ persona1.descripcion }}
                            <button type="button" class="btn btn-danger btn-sm float-right" @click="desactivarUsuario(persona1.id)">
                                                <i class="icon-trash"></i>
                             </button>
                            </div>
                        </template>
                        <template v-if="persona1.status == 5">
                            <div class="alert alert-secondary" role="alert" @click="edit(persona1)" >
                                {{ persona1.nombre }}  - {{ persona1.id }} - {{ persona1.descripcion }}
                            <button type="button" class="btn btn-danger btn-sm float-right" @click="desactivarUsuario(persona1.id)">
                                                <i class="icon-trash"></i>
                             </button>
                            </div>
                        </template>
                       
                    </div>
                   
                    </div>
                
                    
                </div>
                <div class="row">

                    <div class="col-md-6">
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
                    <div class="col-md-6">
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination2.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina2(pagination2.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber2" :key="page" :class="[page == isActived2 ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina2(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination2.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina2(pagination2.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                         </nav>
                    </div>

                </div>

              
               
            </div>
       </template>

     <!-- Modal  - Nueva empresa-->
     <template v-if="registrarUser">
         <div class="card">
                <div class="card-header">
                    <i class="fa fa-plus-circle mr-2"></i>Datos de la tarea
                   
                </div>
            <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Descripcion  <i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                            <div class="col-md-9">
                                <textarea  v-model="descripcion" name="" id="" cols="30" rows="10" placeholder="Descripocion de la tarea" class="form-control"></textarea>                                     
                            </div>
                        </div>
                        <div class="form-group row">
                                                <label class="col-md-3 form-control-label" for="tel-seg">Fecha Inicio
                                                </label>
                                                <div class="col-md-9">
                                                <datetime input-id="fecha-id" input-class="form-control"
                                                          type="datetime" v-model="fecha_inicio">
                                                    <template slot="button-cancel">
                                                        <i class="fa fa-times mr-2"></i>Cancelar
                                                    </template>
                                                    <template slot="button-confirm">
                                                        <i class="fa fa-check-circle mr-2"></i>Aceptar
                                                    </template>
                                                </datetime>
                                                 </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-3 form-control-label" for="tel-seg">Fecha Termino
                                                </label>
                                                <div class="col-md-9">
                                                <datetime input-id="fecha-id" input-class="form-control"
                                                          type="datetime" v-model="fecha_termino">
                                                    <template slot="button-cancel">
                                                        <i class="fa fa-times mr-2"></i>Cancelar
                                                    </template>
                                                    <template slot="button-confirm">
                                                        <i class="fa fa-check-circle mr-2"></i>Aceptar
                                                    </template>
                                                </datetime>
                                                </div>
                                            </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Status  <i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                            <div class="col-md-9">
                                <select v-model="status" name="" id="" class="form-control">
                                    <option value="1">Tarea Nueva</option>
                                    <option value="2">Tarea Terminada</option>
                                    <option value="4">Tarea En Proceso</option>
                                    <option value="3">Tarea Fuera de Tiempo</option>
                                </select>
                            </div>
                        </div>

                    
                    </form>
                     <!--UPLOAD-->
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
                <br>
                
              
                <div class="row">
                    <div class="col-md-12 ">
                        <div class="row">
                            <div v-for="archivo in arrayArchivos" :key="archivo.id" class="col-md-4 ">
                               
                                <blockquote class="blockquote text-center">
                                        <template v-if="archivo.tipo =='png'">
                                            <button type="button" class="close" @click="eliminarArchivo(archivo.id)" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
                                            <img :src="'img/archivos/'+archivo.nombre" width="100%" alt=""  @click="descargar(archivo.nombre)">
                                        </template>
                                        <template v-if="archivo.tipo =='pdf'">
                                            <button type="button" class="close" @click="eliminarArchivo(archivo.id)" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
                                            <embed :src="'img/archivos/'+archivo.nombre" type="application/pdf" width="100%" height="600px" @click="descargar(archivo.nombre)" />
                                        </template>
                                        <template v-if="archivo.tipo =='xlsx'">
                                            <button type="button" class="close" @click="eliminarArchivo(archivo.id)" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
                                            <img :src="'img/exel.png'"  width="100%" alt=""  @click="descargar(archivo.nombre)">
                                        </template>
                                        <template v-if="archivo.tipo =='xml'">
                                            <button type="button" class="close" @click="eliminarArchivo(archivo.id)" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
                                            <img :src="'img/exel.png'"  width="100%" alt=""  @click="descargar(archivo.nombre)">
                                        </template>
                                        <template v-if="archivo.tipo =='jpg'">
                                            <button type="button" class="close" @click="eliminarArchivo(archivo.id)" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
                                            <img :src="'img/archivos/'+archivo.nombre"  width="100%" alt=""  @click="descargar(archivo.nombre)">
                                        </template>
                                        <template v-if="archivo.tipo =='jpeg'">
                                            <button type="button" class="close" @click="eliminarArchivo(archivo.id)" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
                                            <img :src="'img/archivos/'+archivo.nombre"  width="100%" alt=""  @click="descargar(archivo.nombre)">
                                        </template>
                                        <template v-if="archivo.tipo =='docx'">
                                            <button type="button" class="close" @click="eliminarArchivo(archivo.id)" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
                                            <img :src="'img/doc.png'"  width="100%" alt=""  @click="descargar(archivo.nombre)">
                                        </template>
                                        <template v-if="archivo.tipo =='pptx'">
                                            <button type="button" class="close" @click="eliminarArchivo(archivo.id)" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
                                            <img :src="'img/ppt.png'"  width="100%" alt=""  @click="descargar(archivo.nombre)">
                                        </template>
                                        <template v-if="archivo.tipo =='mp3'">
                                            <button type="button" class="close" @click="eliminarArchivo(archivo.id)" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
                                            <img :src="'img/mp3.png'"  width="100%" alt=""  @click="descargar(archivo.nombre)">
                                        </template>
                                        <template v-if="archivo.tipo =='ogg'">
                                            <button type="button" class="close" @click="eliminarArchivo(archivo.id)" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
                                            <img :src="'img/ogg.png'"  width="100%" alt=""  @click="descargar(archivo.nombre)">
                                        </template>
                                        <template v-if="archivo.tipo =='zip'">
                                            <button type="button" class="close" @click="eliminarArchivo(archivo.id)" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
                                            <img :src="'img/zip.png'"  width="100%" alt=""  @click="descargar(archivo.nombre)">
                                          
                                        </template>
                                        <p class="mb-0">{{ archivo.nombre }}</p>
                                    </blockquote>
                                
                            </div>
                        </div>
                 
                    </div>
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

       <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modalTarea}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModalTarea()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Descripcion (*)</label>
                                    <div class="col-md-9">
                                        <textarea v-model="descripcionTarea" cols="30" rows="10" class="form-control"  placeholder="Descripcion de la tarea"></textarea>
                                                                             
                                    </div>
                                </div>
                                <div class="form-group row">
                                                <label class="col-md-3 form-control-label" for="tel-seg">Fecha Inicio
                                                </label>
                                                <div class="col-md-9">
                                                <datetime input-id="fecha-id" input-class="form-control"
                                                          type="datetime" v-model="fecha_inicio">
                                                    <template slot="button-cancel">
                                                        <i class="fa fa-times mr-2"></i>Cancelar
                                                    </template>
                                                    <template slot="button-confirm">
                                                        <i class="fa fa-check-circle mr-2"></i>Aceptar
                                                    </template>
                                                </datetime>
                                                 </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-3 form-control-label" for="tel-seg">Fecha Termino
                                                </label>
                                                <div class="col-md-9">
                                                <datetime input-id="fecha-id" input-class="form-control"
                                                          type="datetime" v-model="fecha_termino">
                                                    <template slot="button-cancel">
                                                        <i class="fa fa-times mr-2"></i>Cancelar
                                                    </template>
                                                    <template slot="button-confirm">
                                                        <i class="fa fa-check-circle mr-2"></i>Aceptar
                                                    </template>
                                                </datetime>
                                                </div>
                                            </div>
                               
                                <div v-show="errorPersona" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjPersona" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModalTarea()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarPersona()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarPersona()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
</main>
</template>

<script>
import { constants } from 'crypto';
import moment from 'moment';
const STATUS_INITIAL = 0, STATUS_SAVING = 1, STATUS_SUCCESS = 2, STATUS_FAILED = 3;
export default {
data (){
    return {
        user_id: 0,
        tareas_id: 0,
        nombre : '',
        descripcion:"",
        descripcionTarea : '',
        fecha_inicio: '',
        fecha_termino: '',
        tipo_documento : '',
        num_documento : '',
        direccion : '',
        telefono : '',
        email : '',
        usuario: '',
        password:'',
        idrol: '',
        nombretarea:'',
        roles : [],
        uploadFieldName: 'photos',
        arrayPersona : [],
        arrayArchivos: [],
        arrayPersona2 : [],
        arrayRol : [],
        arrayPlanteles:[],
        planteles_id:0,
        modal : 0,
        modalTarea : 0,
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
        pagination2 : {
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
        uploadedFiles: [],
        uploadError: null,
        currentStatus: null,
        uploadFieldName: 'photos',
        buscar : '',
        btnEnabled: false,
        registrarUser: false,
    }
},
computed:{
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
    isActived: function(){
        return this.pagination.current_page;
    },
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

    },
    isActived2: function(){
        return this.pagination2.current_page;
    },
    //Calcula los elementos de la paginación
    pagesNumber2: function() {
        if(!this.pagination2.to) {
            return [];
        }
        
        var from = this.pagination2.current_page - this.offset; 
        if(from < 1) {
            from = 1;
        }

        var to = from + (this.offset * 2); 
        if(to >= this.pagination2.last_page){
            to = this.pagination2.last_page;
        }  

        var pagesArray2 = [];
        while(from <= to) {
            pagesArray2.push(from);
            from++;
        }
        return pagesArray2;             

    }
},
methods : {
    eliminarArchivo(id){
       swal({
        title: 'Esta seguro de eliminar este archivo?',
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

            axios.put('tareasArchivosEliminar/eliminar',{
                'id': id
            }).then(function (response) {
                me.listarArchivos(me.tareas_id);
                swal(
                'Archivo!',
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

        axios.post('tareas/subir',formData ,
            {
            headers: {
            "Content-Type": "multipart/form-data",
            
            }
            }).then(function (response) {
            console.log(response.data);
            el.reset();
            el.listarArchivos(el.tareas_id);
            el.$toastr.success(response.data + " archivos se han subido.", 'Archivos');
        }).catch(function (error) {
            console.log(error);
        });
      },
   
      filesChange(fieldName, fileList) {

        let formData = new FormData();
        formData.append("id", this.tareas_id);
        for (var index = 0; index < fieldName; index++) {
        formData.append("files[]", fileList[index]);
        }

    
        this.save(formData);
      },
    listarPersona2 (page,buscar,criterio,nombretarea){
        let me=this;
        var url= 'tac/public/tareas/admin/?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio+ '&nombretarea='+ nombretarea;
        axios.get(url).then(function (response) {
           
            var respuesta= response.data;
            me.arrayPersona2 = respuesta.tareas.data;
            me.pagination2= respuesta.pagination;
           
           
        })
        .catch(function (error) {
            console.log(error);
        });
    },
    listarPersona3 (page,buscar,criterio){
        let me=this;
        var url= 'tareas?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
        axios.get(url).then(function (response) {
           
            var respuesta= response.data;
            me.arrayPersona2 = respuesta.tareas.data;
            me.pagination2= respuesta.pagination;
           
           
        })
        .catch(function (error) {
            console.log(error);
        });
    },
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
    listarArchivos (id){
        console.log(id)
        let me=this;
        var url= 'tareas/archivos?page=1' + '&buscar='+ id;
        axios.get(url).then(function (response) {
           
            var respuesta= response.data;
            console.log(respuesta);
            me.arrayArchivos = respuesta.archivos.data;
           
           
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
    cambiarPagina2(page,buscar,criterio){
        let me = this;
        //Actualiza la página actual
        me.pagination2.current_page = page;
        //Envia la petición para visualizar la data de esa página
        me.listarPersona2(page,buscar,criterio,me.nombretarea);
    },
    agregarTarea(id){
        let me = this;
        me.modalTarea=1;
        me.tipoAccion = 1;
        me.user_id = id;
    },
    cerrarModalTarea(){
        let me = this;
        me.modalTarea=0;
    },
    registrarPersona(){

       
        let me = this;

        console.log('-------------------------DATOS A REGISTRAR-------------------');
        console.log(this.user_id);
        console.log(this.descripcionTarea);
        console.log(this.fecha_inicio);
        console.log(this.fecha_termino);
        console.log('-------------------------FIN A REGISTRAR-------------------');
        axios.post('tareas/registrar',{
            'user_id': this.user_id,
            'descripcion': this.descripcionTarea,
            'fecha_inicio': this.fecha_inicio,
            'fecha_termino' : this.fecha_termino

        }).then(function (response) {
            console.log(response.data);
            me.cerrarModalTarea();
            me.listarPersona(1,'','nombre');
            me.listarPersona2(1,'','nombre');
            me.$toastr.success('Nueva Tarea agregada', 'Tareas');
        }).catch(function (error) {
            console.log(error);
        });
    },
      edit(user) {
       
        console.log('NUMERO DE Tarea');
        console.log(user.id);
        this.tipoAccion = 2;
        this.arrayArchivos = [];    
        this.listarArchivos(user.id);    
        let me = this;
        me.abrirModal();
        me.tareas_id = user.id;
        me.descripcion =user.descripcion;
        me.fecha_inicio =moment(String(user.fecha_inicio)).format();
        me.fecha_termino =moment(String(user.fecha_termino)).format();
        me.status =user.status;
        me.modalGuardar = false; //cambia a estado actulizar

        console.log('-------------------------DATOS A ACTUALIZAR-------------------');
        console.log(user.id);
        console.log(user.descripcion);
        console.log(moment(String(user.fecha_inicio)).format());
        console.log(moment(String(user.fecha_termino)).format());
        console.log(user.status);
        console.log('-------------------------FIN ACTUALIZACION-------------------');
    },
    actualizarPersona(){
        this.tipoAccion = 1;
        let me = this;

        console.log('-------------------------DATOS A ACTUALIZAR-------------------');
        console.log(this.tareas_id);
        console.log(this.status);
        console.log(this.descripcion);
        console.log(this.fecha_inicio);
        console.log(this.fecha_termino);
        console.log('-------------------------FIN ACTUALIZACION-------------------');

        axios.put('tareas/actualizar/admin',{
            'id': this.tareas_id,
            'fecha_inicio': this.fecha_inicio,
            'fecha_termino': this.fecha_termino,
            'descripcion': this.descripcion,
            'status': this.status,
        }).then(function (response) {
            console.log(response.data);
            me.cerrarModal();
            me.listarPersona(1,'','nombre');
            me.listarPersona2(1,'','nombre');
            me.$toastr.success('Tarea actualizada con exito', 'Tareas');
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
        title: 'Esta seguro de eliminar esta tarea?',
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

            axios.put('tareas/desactivar',{
                'id': id
            }).then(function (response) {
                me.listarPersona2(1,'','nombre');
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
    descargar(cotizacion){
                 window.open('tareas/download/'+ cotizacion,'_blank');
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
    this.listarPersona2(1,this.buscar,this.criterio);
    this.reset();
   
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
.modal-dialog {
    margin: 20vh auto 0px auto !important
}
.dropbox {
    outline: 2px dashed grey; /* the dash box */
    outline-offset: -10px;
    background: lightcyan;
    color: dimgray;
    padding: 10px 10px;
    min-height: 200px; /* minimum height */
    position: relative;
    cursor: pointer;
  }
  
  .input-file {
    opacity: 0; /* invisible but it's there! */
    width: 100%;
    height: 200px;
    position: absolute;
    cursor: pointer;
  }
  
  .dropbox:hover {
    background: lightblue; /* when mouse over to the drop zone, change color */
  }
  
  .dropbox p {
    font-size: 1.2em;
    text-align: center;
    padding: 50px 0;
  }
</style>
