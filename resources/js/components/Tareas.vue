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
                <i class="fa fa-align-justify mr-2"></i> Mis Tareas
                <div class="card-header">
                <i class="fa fa-align-justify mr-2"></i> Tareas 
                <button class="btn btn-danger btn_sm float-right" type="button" @click="listarPersona ('1','3','status')">
                        <i class="fa fa-plus-circle mr-2"></i>Fuera de tiempo
                 </button>
                 <button class="btn btn-success btn_sm float-right" type="button" @click="listarPersona ('1','2','status')">
                        <i class="fa fa-plus-circle mr-2"></i>Terminadas
                 </button>
                 <button class="btn btn-primary btn_sm float-right" type="button" @click="listarPersona ('1','1','status')">
                        <i class="fa fa-plus-circle mr-2"></i>Nuevas
                 </button>
                 <button class="btn btn-warning btn_sm float-right" type="button" @click="listarPersona ('1','4','status')">
                        <i class="fa fa-plus-circle mr-2"></i>En proceso
                 </button>
                 <button class="btn btn-secondary btn_sm float-right" type="button" @click="listarPersona ('1','5','status')">
                        <i class="fa fa-plus-circle mr-2"></i>En aprobar terminacion
                 </button>
            </div>
            </div>

             <template v-if="!registrarUser">
            <div class="card-body">
              
                <div class="row">
                    <div class="col-md-12" v-for="persona in arrayPersona" :key="persona.id">
                        <template v-if="persona.status == 1">
                            <div class="alert alert-primary" role="alert"  @click="edit(persona)">
                                {{ persona.id }} -  {{ persona.descripcion }}
                            </div>
                        </template>
                        <template v-if="persona.status == 2">
                            <div class="alert alert-success" role="alert"  @click="edit(persona)">
                                {{ persona.id }} -  {{ persona.descripcion }}
                            </div>
                        </template>
                        <template v-if="persona.status == 3">
                            <div class="alert alert-danger" role="alert"  @click="edit(persona)">
                                {{ persona.id }} - {{ persona.descripcion }}
                            </div>
                        </template>
                        <template v-if="persona.status == 4">
                            <div class="alert alert-warning" role="alert"  @click="edit(persona)">
                                {{ persona.id }} - {{ persona.descripcion }}
                            </div>
                        </template>
                        <template v-if="persona.status == 5">
                            <div class="alert alert-secondary" role="alert"  @click="edit(persona)">
                                {{ persona.id }} - {{ persona.descripcion }}
                            </div>
                        </template>

                       
                    </div>
                </div>
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
                            <label class="col-md-3 form-control-label" for="text-input">Fecha inicio  <i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                            <div class="col-md-9">
                                <label class="form-control-label" for="text-input">{{ fecha_inicio }}</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Fecha termino  <i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                            <div class="col-md-9">
                                <label class="form-control-label" for="text-input">{{ fecha_termino }}</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Status  <i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                            <div class="col-md-9">
                                <select v-model="status" name="" id="" class="form-control">
                                    <option value="1">Tarea Nueva</option>
                                    <option value="5">Tarea Terminada</option>
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
</main>
</template>

<script>
import { constants } from 'crypto';
const STATUS_INITIAL = 0, STATUS_SAVING = 1, STATUS_SUCCESS = 2, STATUS_FAILED = 3;
export default {
data (){
    return {
        user_id: 0,
        tarea_id: 0,
        nombre : '',
        descripcion:"",
        fecha_inicio:"",
        fecha_termino:"",
        status:"",
        tipo_documento : '',
        num_documento : '',
        direccion : '',
        telefono : '',
        email : '',
        usuario: '',
        password:'',
        idrol: '',
        file: "",
        uploadedFiles: [],
        uploadError: null,
        currentStatus: null,
        uploadFieldName: 'photos',
        filenames: [],
        roles : [],
        arrayPersona : [],
        arrayArchivos: [],
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
            el.listarArchivos(el.user_id);
            el.$toastr.success(response.data + " archivos se han subido.", 'Archivos');
        }).catch(function (error) {
            console.log(error);
        });
      },
      descargar(cotizacion){
                 window.open('tareas/download/'+ cotizacion,'_blank');
             },
      filesChange(fieldName, fileList) {

        let formData = new FormData();
        formData.append("id", this.user_id  );
        for (var index = 0; index < fieldName; index++) {
        formData.append("files[]", fileList[index]);
        }

    
        this.save(formData);
      },
    listarPersona (page,buscar,criterio){
        let me=this;
        var url= 'tareas?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
        axios.get(url).then(function (response) {
           
            var respuesta= response.data;
            me.arrayPersona = respuesta.tareas.data;
            me.pagination= respuesta.pagination;
           
           
        })
        .catch(function (error) {
            console.log(error);
        });
    },
    listarArchivos(id){
        let me=this;
        var url= 'tareas/archivos?page=1' + '&buscar='+ id ;
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
        axios.post('tareas/subir', formData,
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
        this.arrayArchivos = [];
        this.listarArchivos(user.id);   
        let me = this;
        me.abrirModal();
        me.user_id = user.id;
        me.descripcion =user.descripcion;
        me.fecha_inicio =user.fecha_inicio;
        me.fecha_termino =user.fecha_termino;
        me.status =user.status;
        me.modalGuardar = false; //cambia a estado actulizar

       
    },
    actualizarPersona(){
         this.tipoAccion = 1;
       
       if (this.validarPersona()){
            return;
        }
        
        let me = this;

        axios.put('tareas/actualizar',{
            'id': this.user_id,
            'descripcion': this.descripcion,
            'status': this.status,
        }).then(function (response) {
            console.log(response.data);
            me.cerrarModal();
            me.listarPersona(1,'','nombre');
            me.$toastr.success('Tarea actualizada con exito', 'Tareas');
        }).catch(function (error) {
            console.log(error);
        }); 
    },
    validarPersona(){
    
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
                me.listarArchivos(me.user_id);
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
