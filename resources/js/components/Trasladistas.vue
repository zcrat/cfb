<template>
    <main class="main">
    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify mr-2"></i> Trasladistas 
        
            </div>

             <template v-if="modalTarea == 0">
            <div class="card-body">
            
                <div class="form-group row">
                        <button class="btn btn-secondary btn_sm float-right" type="button" @click="agregarTecnico()">
                            <i class="fa fa-plus-circle mr-2"></i>Nuevo
                        </button>
                  </div>
                <div class="row">
                    <div class="col-md-12 ">
                        <div class="row">
                            <div v-for="persona in arrayPersona" :key="persona.id" class="col-md-3 ">
                               
                                    <blockquote class="blockquote text-center">
                                        <button type="button" class="close" @click="deleteTecnico(persona.id)" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
                                        <img :src="'img/user.png'" class="rounded-circle" width="120" alt="" @click="abrirModal(persona.id)">
                                    <p class="mb-0">{{ persona.nombre }}</p>
                                    <footer class="blockquote-footer">{{persona.sucursal}} <cite title="Source Title">{{persona.rol}}</cite></footer>
                                    </blockquote>
                                
                            </div>
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
                   

                </div>

              
               
            </div>
       </template>

     <!-- Modal  - Nueva empresa-->
     <template v-if="modalTarea == 1">
         <div class="card">
                <div class="card-header">
                    <i class="fa fa-plus-circle mr-2"></i>Reparaciones tenicos
                    <button class="btn btn-warning btn_sm float-right" type="button" @click="listarPersona2(1,user_id,'','','','')">
                        <i class="fa fa-sync-alt mr-2"></i>Actualizar
                    </button>
                   
                </div>
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
                             <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="economico_placas">Economico/Placas</option>
                                      <option value="r_r">R.R.</option>
                                      <option value="marca_modelo">Marca/Modelo</option>
                                      <option value="serie">Serie</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarPersona2(1,user_id,from, to, criterio, buscar)" class="form-control" placeholder="Texto a buscar">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group">
                                    <button type="submit" @click="listarPersona2(1,user_id,from, to, criterio, buscar)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                    <div class="col-md-12 ">
                        <div class="form-group row">
                        <button class="btn btn-secondary btn_sm float-right" type="button" @click="agregarTarea()">
                            <i class="fa fa-plus-circle mr-2"></i>Nuevo
                        </button>
                  </div>
                  <div  class="row ">
                    <div class="col-lg-3 col-6">
            <!-- small box -->
            <div  @click="listarPersona2(1,user_id,from, to, 'status', '0')" class="small-box bg-info">
              <div class="inner">
                <h3>{{asignados}}</h3>

                <p>Asignados</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
             
            </div>
          </div>
                      <div class="col-lg-3 col-6">
            <!-- small box -->
            <div  @click="listarPersona2(1,user_id,from, to, 'status', '1')" class="small-box bg-warning">
              <div class="inner">
                <h3>{{proceso}}</h3>

                <p>En Proceso</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
             
            </div>
          </div>
                      <div class="col-lg-3 col-6">
            <!-- small box -->
            <div  @click="listarPersona2(1,user_id,from, to, 'status', '2')" class="small-box bg-success">
              <div class="inner">
                <h3>{{terminados}}</h3>

                <p>Terminados</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
             
            </div>
          </div>
                  </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Económico/Placas</th>
                                    <th>Empresa</th>
                                    <th>Recibido</th>
                                    <th>Fecha</th>
                                    <th>Fecha entrega</th>
                                   
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="alumno in arrayPersona2" :key="alumno.id">
                                    <template v-if="alumno.status==2">
                                    <td>
                                      
                                        <button type="button"  class="btn btn-warning btn-sm" @click="editarTarea(alumno)">
                                          <i class="icon-pencil"></i>
                                        </button> 
                                       
                                            <button type="button" class="btn btn-danger btn-sm" @click="deleteReparacion(alumno.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                         
                                      
                                    </td>
                                    <td bgcolor="green" v-text="alumno.economico_placas"></td>
                                    <td bgcolor="green" v-text="alumno.empresa"></td>
                                    <td bgcolor="green" v-text="alumno.recibio"></td>
                                    <td bgcolor="green" v-text="alumno.fecha"></td>
                                    <td bgcolor="green" v-text="alumno.fecha_entrega"></td>
                                   </template>
                                   <template v-if="alumno.status==1">
                                    <td>
                                      
                                        <button type="button"  class="btn btn-warning btn-sm" @click="editarTarea(alumno)">
                                          <i class="icon-pencil"></i>
                                        </button> 
                                       
                                            <button type="button" class="btn btn-danger btn-sm" @click="deleteReparacion(alumno.id)" >
                                                <i class="icon-trash"></i>
                                            </button>
                                    
                                      
                                    </td>
                                    <td bgcolor="yellow" v-text="alumno.marca_modelo"></td>
                                    <td bgcolor="yellow" v-text="alumno.economico_placas"></td>
                                    <td bgcolor="yellow" v-text="alumno.r_r"></td>
                                    <td bgcolor="yellow" v-text="alumno.descripcion"></td>
                                    <td bgcolor="yellow" v-text="alumno.fecha"></td>
                                   </template>
                                   <template v-if="alumno.status==0">
                                    <td>
                                      
                                        <button type="button"  class="btn btn-warning btn-sm" @click="editarTarea(alumno)">
                                          <i class="icon-pencil"></i>
                                        </button> 
                                       
                                            <button type="button" class="btn btn-danger btn-sm" @click="deleteReparacion(alumno.id)" >
                                                <i class="icon-trash"></i>
                                            </button>

                               
                                
                                      
                                    </td>
                                    <td v-text="alumno.marca_modelo"></td>
                                    <td v-text="alumno.economico_placas"></td>
                                    <td v-text="alumno.r_r"></td>
                                    <td v-text="alumno.descripcion"></td>
                                    <td v-text="alumno.fecha"></td>
                                   </template>
                                </tr>                                
                            </tbody>
                        </table>
                   
                    </div>
                
                    
                </div>
                <div class="row">

                
                    <div class="col-md-12">
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
                <div class="form-group row">
                
                <button type="button" class="btn btn-secondary" @click="cerrarModal">Cerrar</button>
                </div>
        </div>
        <!-- /.modal-dialog -->
    </div>
    </template>
    <template v-if="modalTarea == 2">
        <div class="card">
                <div class="card-header">
                    <i class="fa fa-plus-circle mr-2"></i>Tareas trasladistas
                   
                </div>
            <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">

            <div class="form-group row">
                                    <label for="plantel" class="col-md-3 form-control-label">Vehiculos  <i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                    <div class="col-md-9">
                                       <select class="form-control" v-model="vehiculo_id" >
                                                        <option value="0" disabled>Seleccione su vehiculo</option>
                                                        <option v-for="plantel in arrayVehiculos" :key="plantel.id" :value="plantel.id" v-text="plantel.placas"></option>
                                                 </select>
                                    </div>
                                </div>
<div class="form-group row">
    <label class="col-md-3 form-control-label" for="text-input">Económico/Placas (*)</label>
    <div class="col-md-9">
        <input v-model="economico" type="text" class="form-control">
    </div>
</div>

<div class="form-group row">
    <label class="col-md-3 form-control-label" for="text-input">Empresa (*)</label>
    <div class="col-md-9">
        <input v-model="rr" type="text" class="form-control">
    </div>
</div>

<div class="form-group row">
                <label class="col-md-3 form-control-label" for="tel-seg">Fecha
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
                <label class="col-md-3 form-control-label" for="tel-seg">Fecha Entrego
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
    <label class="col-md-3 form-control-label" for="text-input">De:</label>
    <div class="col-md-3">
        <input v-model="de" type="text" class="form-control">
    </div>
  
</div>
<div class="form-group row">
    <label class="col-md-3 form-control-label" for="text-input">A:</label>
    <div class="col-md-3">
        <input v-model="a" type="text" class="form-control">
    </div>
  
</div>
<div class="form-group row">
    <label class="col-md-3 form-control-label" for="text-input">Recibio</label>
    <div class="col-md-3">
        <input v-model="recibio" type="text" class="form-control">
    </div>
  
</div>
<div class="form-group row">
    <label class="col-md-3 form-control-label" for="text-input">Odometro Entrada</label>
    <div class="col-md-3">
        <input v-model="odometro_entrada" type="text" class="form-control">
    </div>
  
</div>
<div class="form-group row">
    <label class="col-md-3 form-control-label" for="text-input">Odometro Salida</label>
    <div class="col-md-3">
        <input v-model="odometro_salida" type="text" class="form-control">
    </div>
  
</div>
<div class="form-group row">
<label class="col-md-3 form-control-label" for="text-input">Status  <i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
<div class="col-md-9">
<select v-model="status" name="" id="" class="form-control">
    <option value="0">Asignado</option>
    <option value="1">En proceso</option>
    <option value="2">Terminado</option>
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

<template  v-if="tipoAccion==2">

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
</template>

<div class="row">
                            <button type="button" class="btn btn-secondary" @click="cerrarModalTarea()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarPersona()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarPersona()">Actualizar</button>
  </div>
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
            <!-- Modal -->
<div class="modal fade fade bd-example-modal-lg" id="exampleModalCenter2" :class="{'mostrar' : modal3}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" >Orden de Servicio</h5>
<button type="button" class="close" @click="cerrarModalOrden">
  <span aria-hidden="true">&times;</span>
</button>
</div>


<div class="modal-body">
 <div class="form-group row">
       <label class="col-md-3 form-control-label" for="text-input">Archivo</label>
        <div class="col-md-9">
        <input id="folio-id" class="form-control" type="file" @change="subirarchivo2">
     </div>
 </div>
</div>
 <div class="modal-footer">
<div class="form-group row">
                    <div class="col-md-4">
                         <button type="button" class="btn btn-success" title="Fotos Viejas" @click="verOrden()">
                         <i class="fa fa-picture-o"></i>
                        </button>
                    </div>   
                    <div class="col-md-8">
                        <button type="button" @click="cerrarModalOrden()" class="btn btn-secondary">Cerrar</button>
                        <button type="button" class="btn btn-primary" @click="guardarOrden()" :disabled="disabled == 1" >Guardar</button>
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
        from: '',
        to: '',
        de:'',
        a:'',
        vehiculo_id:0,
        fecha_inicio: '',
        fecha_termino: '',
        tipo_documento : '',
        num_documento : '',
        direccion : '',
        telefono : '',
        archivo : '',
        odometro_entrada:'',
        odometro_salida:'',
        email : '',
        usuario: '',
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
        arrayVehiculos: [],
        arrayPersona2 : [],
        arrayRol : [],
        arrayPlanteles:[],
        planteles_id:0,
        modal : 0,
        modal3 : 0,
        modalTarea : 0,
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

            axios.put('trasladistas/archivos/eliminar',{
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

        axios.post('trasladistas/subir',formData ,
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
    listarPersona2 (page,id,from,to, criterio, buscar){
        let me=this;
        var url= 'tac/public/trasladistas/reparaciones/?page=' + page + '&id='+ id + '&from='+ from + '&to='+ to + '&criterio='+ criterio + '&buscar='+ buscar;
        axios.get(url).then(function (response) {
            console.log(response);
            var respuesta= response.data;
            me.arrayPersona2 = respuesta.personas.data;
            me.pagination2= respuesta.pagination;
            me.proceso = respuesta.proceso;
            me.asignados = respuesta.asignadas;
            me.terminados = respuesta.terminadas;
           
           
        })
        .catch(function (error) {
            console.log(error);
        });
    },
    subirarchivo2(e){
        let me = this;

        var fileReader = new FileReader()
        fileReader.readAsDataURL(e.target.files[0])
        fileReader.onload = (e) => {
            
            axios.post('trasladistas/subirarchivos',{
                'doc': e.target.result
            }).then(function (response) {
            console.log(response.data);
            if (response.data == "nada.doc"){

            } else {
                me.archivo = response.data.nombre;
                me.disabled = 0;
            }
        })
            .catch(function (error) {
            console.log(error);
            me.limpiarCampos();
               
            });

            
        }
        
    },
    guardarOrden(){
        let me = this;

        axios.post('trasladistas/guardarOrden',{
            'id': me.tareas_id,
            'archivo': me.archivo
        }).then(function (response) {
            
            console.log(response.data);
            me.cerrarModalOrden();
            me.listarPersona2(1,me.user_id,'','','','');
            me.disabled = 1;
           

        }).catch(function (error) {
            console.log(error);
        });              
    },
    listarPersona (page,buscar,criterio){
        let me=this;
        var url= 'trasladistas?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
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
        var url= 'trasladistas/archivos?page=1' + '&buscar='+ id;
        axios.get(url).then(function (response) {
           
            var respuesta= response.data;
            console.log(respuesta);
            me.arrayArchivos = respuesta.archivos.data;
           
           
        })
        .catch(function (error) {
            console.log(error);
        });
    },

    ordenEntrada(id){
     this.modal3 = 1;
     this.tareas_id = id;

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
        me.listarPersona2(page,me.user_id,'','','','');
    },
    agregarTarea(){
        let me = this;
        me.modalTarea=2;
        me.tipoAccion = 1;
        me.vehiculo_id = 0;
        me.economico = '';
        me.marca = '';
        me.rr = '';
        me.de ='';
        me.odometro_entrada ='';
        me.odometro_salida ='';
        me.a ='';
        me.descripcionTarea = '';
        me.status = 0;
        me.fecha_inicio = '';
      
    },
    agregarTecnico(){
        let me = this;
        me.modalTecnico=1;
        me.tipoAccion = 1;
        me.nombre = '';
      
    },
    editarTarea(id){
        let me = this;
        me.modalTarea=2;
        me.tipoAccion = 2;
        me.vehiculo_id = id.vehiculo_id;
        me.tareas_id = id.id;
        me.economico = id.economico_placas;
        me.rr = id.empresa;
        me.odometro_entrada =id.odometro_entrada;
        me.odometro_salida =id.odometro_salida;
        me.status = id.status;
        me.fecha_inicio = moment(String(id.fecha)).format();
        me.fecha_termino = moment(String(id.fecha_entrega)).format();
        me.recibio = id.recibio;
        me.de =id.de;
        me.a =id.a;
        this.arrayArchivos = [];    
        this.listarArchivos(id.id); 
      
    },
    cerrarModalTarea(){
        let me = this;
        me.modalTarea=1;
    },
    cerrarModalTecnico(){
        let me = this;
        me.modalTecnico=0;
    },
    registrarPersona(){

       
        let me = this;

        axios.post('trasladistas/reparaciones/registrar',{
            'user_id': this.user_id,
            'vehiculo_id': this.vehiculo_id,
            'descripcion': this.descripcionTarea,
            'fecha_inicio': this.fecha_inicio,
            'fecha_termino': this.fecha_termino,
            'economico' : this.economico,
            'rr' : this.rr,
            'recibio': this.recibio,
            'marca' : this.marca,
            'status': this.status,
            'odometro_entrada': this.odometro_entrada,
            'odometro_salida': this.odometro_salida,
            'status': this.status,
            'de':this.de,
            'a':this.a,

        }).then(function (response) {
            console.log(response.data);
            me.cerrarModalTarea();
            me.listarPersona(1,'','nombre');
            me.listarPersona2(1,me.user_id,'','','','');
            me.$toastr.success('Nueva Reparacion agregada', 'Reparaciones');
        }).catch(function (error) {
            console.log(error);
        });
    },
    registrarTecnico(){

       
    let me = this;

    axios.post('trasladistas/registrar',{
        'nombre': this.nombre,

    }).then(function (response) {
        console.log(response.data);
        me.cerrarModalTecnico();
        me.listarPersona(1,'','nombre');
        me.$toastr.success('Nuevo Tecnico agregado', 'Tecnicos');
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
    },
    cargarVehiculos (page,buscar,criterio){
        let me=this;
        var url= 'vehiculostareas?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
        axios.get(url).then(function (response) {
           
            var respuesta= response.data;
            me.arrayVehiculos= respuesta.personas.data;
            me.pagination= respuesta.pagination;
           
           
        })
        .catch(function (error) {
            console.log(error);
        });
    },
    actualizarPersona(){
        this.tipoAccion = 1;
        let me = this;

        axios.put('trasladistas/reparaciones/actualizar',{
            'id': this.tareas_id,
            'vehiculo_id': this.vehiculo_id,
            'descripcion': this.descripcionTarea,
            'fecha_inicio': this.fecha_inicio,
            'fecha_termino': this.fecha_termino,
            'recibio': this.recibio,
            'entrego': this.entrego,
            'odometro_entrada': this.odometro_entrada,
            'odometro_salida': this.odometro_salida,
            'economico' : this.economico,
            'rr' : this.rr,
            'marca' : this.marca,
            'status': this.status,
            'de':this.de,
            'a':this.a,
        }).then(function (response) {
            console.log(response.data);
            me.cerrarModalTarea();
            me.listarPersona(1,'','nombre');
            me.listarPersona2(1,me.user_id,'','','','');
            me.$toastr.success('Reparacion actualizada con exito', 'Reparaciones');
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

        this.modalTarea = 0;
        this.tipoAccion=0;
        this.tituloModal='';
        this.user_id=0;
        this.nombre='';
        this.email='';
        this.planteles_id=0;
        this.errorPersona=0;
        this.modal3=0;
       
    },
    cerrarModalOrden(){
this.modal3=0;

},
    verOrden(){
        let me=this;
        var url= 'trasladistas/verOrden?id=' + me.tareas_id;
        axios.get(url).then(function (response) {
            console.log(response.data);
            var respuesta = response.data;
            window.open('documentos/ordenes/'+ respuesta,'_blank');
        })
        .catch(function (error) {
            console.log(error);
        });
        
    },
    abrirModal(id){
        this.listarPersona2(1,id,'','','','');
        this.modalTarea = 1;
        this.user_id = id;
        
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
                me.listarPersona2(1,'','','','','');
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
    deleteTecnico(id){
       swal({
        title: 'Esta seguro de eliminar este tecnico?',
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

            axios.put('trasladistas/delete',{
                'id': id
            }).then(function (response) {
                me.listarPersona(1,'','','');
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
    deleteReparacion(id){
       swal({
        title: 'Esta seguro de eliminar esta asignacion?',
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

            axios.put('trasladistas/reparaciones/delete',{
                'id': id
            }).then(function (response) {
                me.listarPersona2(1,me.user_id,'','','','');
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
    this.cargarVehiculos(1,this.buscar,this.criterio);
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
