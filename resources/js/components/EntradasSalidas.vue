<template>
    <main class="main">

    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-header">
                    <i class="fa fa-plus-circle mr-2"></i>Entradas y Salidas
                    <button class="btn btn-warning btn_sm float-right" type="button" @click="listarEntradasSalidas(1,'','','','')">
                        <i class="fa fa-sync-alt mr-2"></i>Actualizar
                    </button>
                </div>

    

     <!-- Modal  - Nueva empresa-->
     <template v-if="modalTarea == 0">
               
            <div class="card-body">
                <div class="row">
                            <div class="col-md-2">
                                <div class="input-group">
                                     <input type="date" v-model="from"  class="form-control"/>
                                </div>
                             </div>
                              <div class="col-md-2">
                                <div class="input-group">
                                     <input type="date" v-model="to" class="form-control"/>
                                </div>
                             </div>
                             <div class="col-md-4">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="empresa">Empresa</option>
                                      <option value="n_orden">Numero de orden</option>
                                      <option value="orden_servicio">Orden de servicio</option>
                                      <option value="economico">Economico</option>
                                      <option value="placas">Placas</option>
                                      <option value="serie">Serie</option>
                                      <option value="asignado">Asignado</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarEntradasSalidas(1, buscar,criterio, from, to)" class="form-control" placeholder="Texto a buscar">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group">
                                    <button type="submit" @click="listarEntradasSalidas(1,buscar,criterio, from, to)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <button class="btn btn-secondary btn_sm float-right" type="button" @click="agregarEntardaSalida()">
                                    <i class="fa fa-plus-circle mr-2"></i>Nuevo
                                </button>
                                </div>
                            </div>

                            <button class="btn btn-info btn_sm float-right" type="button" @click="listarEntradasSalidas2(1,new Date(),'entradas_salidas.fecha_entrada', from, to)">
                                     <i class="fa fa-plus-circle mr-2"></i>ENTRADAS
                            </button>
                            <button class="btn btn-light btn_sm float-right" type="button" @click="listarEntradasSalidas2(1,new Date(),'entradas_salidas.fecha_salida', from, to)">
                                    <i class="fa fa-plus-circle mr-2"></i>SALIDAS
                            </button>
                    <div class="col-md-12 ">
                       
                
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Empresa</th>
                                    <th>Numero de orden</th>
                                    <th>Orden de servicio</th>
                                    <th>Economico</th>
                                    <th>Placas</th>
                                    <th>Serie</th>
                                    <th>Fecha entrada</th>
                                    <th>Hora entrada</th>
                                    <th>Dias</th>
                                   
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="entrada in arrayEntradasSalidas" :key="entrada.id">
                                   
                                    <td>
                                      
                                        <button type="button"  class="btn btn-warning btn-sm" @click="editarEntradaSalida(entrada)">
                                          <i class="icon-pencil"></i>
                                        </button> 
                                       
                                        <button type="button" class="btn btn-danger btn-sm" @click="deleter(entrada.id)">
                                                <i class="icon-trash"></i>
                                        </button>

                                        <template v-if="entrada.status == 1">
                                        
                                            <button type="button"  class="btn btn-success btn-sm" @click="EntradaSalidaOK(entrada)">
                                            Revizado
                                            </button> 

                                        </template>
                                         
                                      
                                    </td>
                                    <td v-text="entrada.empresa"></td>
                                    <td v-text="entrada.n_orden"></td>
                                    <td v-text="entrada.orden_servicio"></td>
                                    <td v-text="entrada.economico"></td>
                                    <td v-text="entrada.placas"></td>
                                    <td v-text="entrada.serie"></td>
                                    <td v-text="entrada.fecha_entrada"></td>
                                    <td v-text="entrada.hora_entrada"></td>
                                    <td>{{  obtenerdiferencia(entrada.fecha_entrada) }}</td>
                                  
                               
                                </tr>                                
                            </tbody>
                        </table>
                   
                    </div>
                
                    
                </div>
                <div class="row">

                
                    <div class="col-md-12">
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
        <!-- /.modal-dialog -->

    </template>
    <template v-if="modalTarea == 2">
       
            <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">

        

<div class="form-group row">
    <label class="col-md-3 form-control-label" for="text-input">Empresa</label>
    <div class="col-md-9">
        <input v-model="modeloEntradaSalida.empresa" type="text" class="form-control">
    </div>
</div>

<div class="form-group row">
    <label class="col-md-3 form-control-label" for="text-input">Numero de orden</label>
    <div class="col-md-9">
        <input v-model="modeloEntradaSalida.n_orden" type="text" class="form-control">
    </div>
</div>

<div class="form-group row">
    <label class="col-md-3 form-control-label" for="text-input">Hora entrada</label>
    <div class="col-md-9">
        <input v-model="modeloEntradaSalida.hora_entrada" type="time" class="form-control">
    </div>
</div>

<div class="form-group row">
    <label class="col-md-3 form-control-label" for="text-input">Orden de servicio</label>
    <div class="col-md-9">
        <input v-model="modeloEntradaSalida.orden_servicio" type="text" class="form-control">
    </div>
</div>

<div class="form-group row">
    <label class="col-md-3 form-control-label" for="text-input">Economico</label>
    <div class="col-md-9">
        <input v-model="modeloEntradaSalida.economico" type="text" class="form-control">
    </div>
</div>

<div class="form-group row">
    <label class="col-md-3 form-control-label" for="text-input">Placas</label>
    <div class="col-md-9">
        <input v-model="modeloEntradaSalida.placas" type="text" class="form-control">
    </div>
</div>

<div class="form-group row">
    <label class="col-md-3 form-control-label" for="text-input">KMS</label>
    <div class="col-md-9">
        <input v-model="modeloEntradaSalida.kms" type="text" class="form-control">
    </div>
</div>

<div class="form-group row">
    <label class="col-md-3 form-control-label" for="text-input">Serie</label>
    <div class="col-md-9">
        <input v-model="modeloEntradaSalida.serie" type="text" class="form-control">
    </div>
</div>

<div class="form-group row">
    <label class="col-md-3 form-control-label" for="text-input">Fecha entrada</label>
    <div class="col-md-9">
        <input v-model="modeloEntradaSalida.fecha_entrada" type="date" class="form-control">
    </div>
</div>

<div class="form-group row">
    <label class="col-md-3 form-control-label" for="text-input">Fecha salida</label>
    <div class="col-md-9">
        <input v-model="modeloEntradaSalida.fecha_salida" type="date" class="form-control">
    </div>
</div>

<div class="form-group row">
    <label class="col-md-3 form-control-label" for="text-input">Asignado a</label>
    <div class="col-md-9">
        <input v-model="modeloEntradaSalida.asignado" type="text" class="form-control">
    </div>
</div>





<div class="form-group row">
    <label class="col-md-3 form-control-label" for="text-input">Observaciones</label>
    <div class="col-md-9">
        <textarea v-model="modeloEntradaSalida.observaciones" cols="5" rows="3" class="form-control"  placeholder="Observaciones"></textarea>
                                             
    </div>
</div>

    

<div v-show="errorPersona" class="form-group row div-error">
    <div class="text-center text-error">
        <div v-for="error in errorMostrarMsjPersona" :key="error" v-text="error">

        </div>
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


<div class="row">
                            <button type="button" class="btn btn-secondary" @click="cerrarModalEntradasSalidas()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarEntradaySalida()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarEntardaySalida()">Actualizar</button>
  </div>
            </div>
       

    </template>
  
   </div>
   </div>



             <!--Inicio del modal agregar/actualizar-->
             <div class="modal fade" tabindex="-1" :class="{'mostrar' : modalTecnico}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModalTecnico()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre (*)</label>
                                    <div class="col-md-9">
                                        <input v-model="nombre" type="text" class="form-control">
                                    </div>
                                </div>

                               
            
                                    
                    
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModalTecnico()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarTecnico()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarTecnico()">Actualizar</button>
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
require('promise');
const STATUS_INITIAL = 0, STATUS_SAVING = 1, STATUS_SUCCESS = 2, STATUS_FAILED = 3;
export default {
data (){
    return {
        user_id: 0,
        tareas_id: 0,
        nombre : '',
        descripcion:"",
        descripcionTarea : '',
        from: '',
        to: '',
        numeproce:0,
        arrayprocesos:[],
        fecha_inicio: '',
        fecha_termino: '',
        tipo_documento : '',
        num_documento : '',
        odometro_entrada : '',
        odometro_salida : '',
        direccion : '',
        telefono : '',
        archivo : '',
        email : '',
        disablebutton:false,
        usuario: '',
        tecnico_id:0,
        disabled:1,
        marca:'',
        economico:'',
        rr:'',
        password:'',
        recibio:'',
        entrego:'',
        idrol: '',
        roles : [],
        uploadFieldName: 'photos',
        arrayPersona : [],
        arrayArchivos: [],
        arrayEntradasSalidas : [],
        arrayTrasladistas: [],
        modeloEntradaSalida:{},
        arrayRol : [],
        arrayPlanteles:[],
        planteles_id:0,
        modal : 0,
        modal3 : 0,
        modalTarea : 0,
        trasladista_id:0,
        modalTecnico : 0,
        terminados : 0,
        proceso : 0,
        asignados : 0,
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
        criterio : '',
        buscar : '',
        file: "",
        uploadedFiles: [],
        uploadError: null,
        currentStatus: null,
        uploadFieldName: 'photos',
        filenames: [],
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

    },
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

        axios.post('entradassalidas/subir',formData ,
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
                 window.open('entradassalidas/download/'+ cotizacion,'_blank');
             },
      filesChange(fieldName, fileList) {

        let formData = new FormData();
        formData.append("id", this.user_id  );
        for (var index = 0; index < fieldName; index++) {
        formData.append("files[]", fileList[index]);
        }

    
        this.save(formData);
      },
    listarEntradasSalidas (page,buscar, criterio, from, to){
        let me=this;
        var url= 'entradassalidas?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio +'&from='+ from + '&to='+ to;
        axios.get(url).then(function (response) {
           
            var respuesta= response.data;
            me.arrayEntradasSalidas = respuesta.entradassalidas.data;
            me.pagination= respuesta.pagination;
           
           
        })
        .catch(function (error) {
            console.log(error);
        });
    },
    listarEntradasSalidas2 (page,buscar, criterio, from, to){
        let me=this;
        var url= 'entradassalidas/buscar?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio +'&from='+ from + '&to='+ to;
        axios.get(url).then(function (response) {
           
            var respuesta= response.data;
            me.arrayEntradasSalidas = respuesta.entradassalidas.data;
            me.pagination= respuesta.pagination;
           
           
        })
        .catch(function (error) {
            console.log(error);
        });
    },
    listarArchivos(id){
        let me=this;
        var url= 'entradassalidas/archivos?page=1' + '&buscar='+ id ;
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
        axios.post('entradassalidas/subir', formData,
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

            axios.put('entradassalidas/eliminar',{
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
   
    cambiarPagina(page,buscar,criterio){
        let me = this;
        //Actualiza la página actual
        me.pagination.current_page = page;
        //Envia la petición para visualizar la data de esa página
        me.listarEntradasSalidas(page,buscar,criterio,'','');
    },
    
    agregarEntardaSalida(){
        let me = this;
        me.modalTarea=2;
        me.tipoAccion = 1;
        me.modeloEntradaSalida.empresa ='';
        me.modeloEntradaSalida.n_orden = '';
        me.modeloEntradaSalida.hora_entrada = '';
        me.modeloEntradaSalida.orden_servicio = '';
        me.modeloEntradaSalida.economico = '';
        me.modeloEntradaSalida.placas = '';
        me.modeloEntradaSalida.kms = '';
        me.modeloEntradaSalida.serie = '';
        me.modeloEntradaSalida.fecha_entrada = '';
        me.modeloEntradaSalida.fecha_salida = '';
        me.modeloEntradaSalida.observaciones = '';
        me.modeloEntradaSalida.asignado = '';
      
    },
    editarEntradaSalida(entrada){
        let me = this;
        me.modalTarea=2;
        me.tipoAccion = 2;
        me.modeloEntradaSalida.id = entrada.id;
        me.modeloEntradaSalida.empresa = entrada.empresa;
        me.modeloEntradaSalida.n_orden = entrada.n_orden;
        me.modeloEntradaSalida.hora_entrada = entrada.hora_entrada;
        me.modeloEntradaSalida.orden_servicio = entrada.orden_servicio;
        me.modeloEntradaSalida.economico = entrada.economico;
        me.modeloEntradaSalida.placas = entrada.placas;
        me.modeloEntradaSalida.kms = entrada.kms;
        me.modeloEntradaSalida.serie =entrada.serie;
        me.modeloEntradaSalida.fecha_entrada = entrada.fecha_entrada;
        me.modeloEntradaSalida.fecha_salida = entrada.fecha_salida;
        me.modeloEntradaSalida.observaciones = entrada.observaciones;
        me.modeloEntradaSalida.asignado = entrada.asignado;
        this.listarArchivos(entrada.id);   
      
    },
    cerrarModalEntradasSalidas(){
        let me = this;
        me.modalTarea=0;
    },
    
    registrarEntradaySalida(){

        let me = this;

        axios.post('entradassalidas/registrar',{
            'empresa': this.modeloEntradaSalida.empresa,
            'n_orden': this.modeloEntradaSalida.n_orden,
            'hora_entrada': this.modeloEntradaSalida.hora_entrada,
            'orden_servicio' : this.modeloEntradaSalida.orden_servicio,
            'economico': this.modeloEntradaSalida.economico,
            'placas': this.modeloEntradaSalida.placas,
            'kms': this.modeloEntradaSalida.kms,
            'serie' : this.modeloEntradaSalida.serie,
            'fecha_entrada' : this.modeloEntradaSalida.fecha_entrada,
            'fecha_salida': this.modeloEntradaSalida.fecha_salida,
            'observaciones': this.modeloEntradaSalida.observaciones,
            'asignado': this.modeloEntradaSalida.asignado,

        }).then(function (response) {
            console.log(response.data);
            me.cerrarModalEntradasSalidas();
            me.listarEntradasSalidas(1,'','nombre','','');
            me.$toastr.success('Nueva Entrada agregada', 'Entradas y Salidas');
        }).catch(function (error) {
            console.log(error);
        });
    },

    EntradaSalidaOK(modelo){
        let me = this;

axios.post('entradassalidas/status',{
    'empresa': modelo.id,
    'status': '2',

}).then(function (response) {
    console.log(response.data);
    me.listarEntradasSalidas(1,'','nombre','','');
    me.$toastr.success('Revisado y Finalizado', 'Entradas y Salidas');
}).catch(function (error) {
    console.log(error);
});
    },
    actualizarEntardaySalida(){
        let me = this;

        axios.put('entradassalidas/actualizar',this.modeloEntradaSalida).then(function (response) {
            console.log(response.data);
            me.cerrarModalEntradasSalidas();
            me.listarEntradasSalidas(1,'','nombre','','');
            me.$toastr.success('Entrada actualizada con exito', 'Entradas y Salidas');
        }).catch(function (error) {
            console.log(error);
        }); 
    },
    obtenerdiferencia(inicio){

        var moment = require('moment');
        // obtener el nombre del mes, día del mes, año, hora
        var now = moment().format("YYYY-MM-DD");
        var fecha1 = moment(inicio);
        var fecha2 = moment(now);
        console.log(now); 
        console.log(inicio);
       
        return fecha2.diff(fecha1, 'days');
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

            axios.put('entradassalidas/delete',{
                'id': id
            }).then(function (response) {
                me.listarEntradasSalidas(1,'','','','');
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
    
},
mounted() {
    this.listarEntradasSalidas(1,this.buscar,this.criterio,"","");
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
