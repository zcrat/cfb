<template>
    <main class="main">
    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Recepcion Vehicular Acuses Foraneos Eco
                <button type="button" @click="abrirModalC('cotizacion','registrar')" class="btn btn-secondary">
                    <i class="icon-plus"></i>&nbsp;Nuevo
                </button>
            </div>
            <!-- Listado-->
            <template v-if="listado==1">
            <div class="card-body">
                <div class="form-group row">
                  
                    <div class="col-md-6">
                        <div class="input-group">
                            <select class="form-control col-md-3" v-model="criterio">
                              <option value="anexosFRAcuse.no_economico">Economico</option>
                              <option value="anexosFRAcuse.no_serie">Serie</option>
                              <option value="anexosFRAcuse.placas">Placas</option>
                              <option value="anexosFRAcuse.folioNum">Folio</option>
                            </select>
                            <input type="text" v-model="buscar" @keyup.enter="listarIngreso(1,buscar,criterio,'0')" class="form-control" placeholder="Texto a buscar">
                            <button type="submit" @click="listarIngreso(1,buscar,criterio,'0')" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Opciones</th>
                                <th>Folio</th>
                                <th>Economico</th>
                                <th>Marca</th>
                                <th>Modelos</th>
                                <th>Año</th>
                                <th>Placas</th>
                                <th>VIN</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="cotizacion in arrayCotizacion" :key="cotizacion.id">
                                <td>
                                   
                                     <select name="LeaveType" @change="onChange($event,cotizacion)" class="form-control">
                                        <option value="0">Opciones de operación</option>
                                        <option value="1">Recepcion Acuse</option>
                                        <option value="2">Editar</option>
                                        <option value="3">Eliminar</option>
                                    </select>   

                                    

                                </td>
                                <td v-text="cotizacion.id"></td>
                                <td v-text="cotizacion.no_economico"></td>
                                <td v-text="cotizacion.marca"></td>
                                <td v-text="cotizacion.modelo"></td>
                                <td v-text="cotizacion.ano"></td>
                                <td v-text="cotizacion.placas"></td>
                                <td v-text="cotizacion.vin"></td>
                                <td v-text="cotizacion.created_at"></td>
                                <td v-text="cotizacion.listo"></td>
                                 <td>
                                      
                                    <button class="btn btn-info"  v-on:click="crearPresupuesto(cotizacion)">
                                            <i class="icon-doc" aria-hidden="true"></i>
                                        </button>  

                                </td>
                            </tr>                                
                        </tbody>
                    </table>
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
            <!--Fin Listado-->
            <!-- Detalle-->
            <template v-else-if="listado==0">
            <div class="card-body">
                 <p class="h5 text-uppercase font-weight-bold  border-bottom">Datos del Vehiculo</p>
                <div class="form-group row border">
                       <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Empresas(*)</label>
                            <v-select
                                :on-search="selectEmpresa"
                                label="nombre"
                                :options="arrayEmpresa"
                                placeholder="Buscar Empresas..."
                                :onChange="getDatosEmpresa"
                            >
                                
                            </v-select>
                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="form-group">
                             <label>Fecha:</label>
                             <input type="date" class="form-control" v-model="fecha" placeholder="000xx">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                             <label>Economico</label>
                             <input type="text" class="form-control" v-model="no_economico" placeholder="000xx">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Placas</label>
                            <input type="text" class="form-control" v-model="placas" placeholder="000xx">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Marca</label>
                            <input type="text" class="form-control" v-model="marca" placeholder="000xx">
                        </div>
                    </div>

                     <div class="col-md-3">
                        <div class="form-group">
                            <label>Sub Marca</label>
                            <input type="text" class="form-control" v-model="submarca" placeholder="000xx">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                             <label>Modelo</label>
                             <input type="text" class="form-control" v-model="modelo" placeholder="000xx">
                        </div>
                    </div>


                    
                     <div class="col-md-3">
                        <div class="form-group">
                            <label>Serie</label>
                            <input type="text" class="form-control" v-model="no_serie" placeholder="000xx">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Tipo de vehiculo</label>
                            <input type="text" class="form-control" v-model="tipo_de_vehiculo" placeholder="000xx">
                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Tipo de servicio</label>
                            <select v-model="tipo_de_servicio" class="form-control">
                                <option value="0">Seleccione</option>
                                <option value="Preventivo">Preventivo</option>
                                <option value="Correctivo">Correctivo</option>
                                <option value="Neumaticos">Neumaticos</option>
                                <option value="Otros">Otros</option>
                            </select>
                            
                        </div>
                    </div>

                  

                     <div class="col-md-3">
                        <div class="form-group">
                            <label>Nombre Taller</label>
                            <input type="text" class="form-control" v-model="nombre_taller" placeholder="000xx">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Razon social</label>
                            <input type="text" class="form-control" v-model="razon_social" placeholder="000xx">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Plaza</label>
                            <input type="text" class="form-control" v-model="usuario" placeholder="000xx">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>R.P.E.</label>
                            <input type="text" class="form-control" v-model="rpe" placeholder="000xx">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Km entrada</label>
                            <input type="numeric" class="form-control" v-model="km_entrada" placeholder="000xx">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Orden de servicio</label>
                            <input type="text" class="form-control" v-model="orden_servicio" placeholder="000xx">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>ID</label>
                            <input type="text" class="form-control" v-model="orden_id" placeholder="000xx">
                        </div>
                    </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Administrador de trasportes</label>
                                    <input type="text" class="form-control" v-model="clienteYRazonSocial" placeholder="000xx">
                                </div>
                            </div>
                            
                             <div class="col-md-3">
                                <div class="form-group">
                                    <label>Jefe de Proceso.</label>
                                    <input type="text" class="form-control" v-model="Mail" placeholder="000xx">
                                </div>
                            </div>

                            
                            
                           
                             <div class="col-md-3">
                                <div class="form-group">
                                    <label>Telefono</label>
                                    <input type="text" class="form-control" v-model="Telefono" placeholder="000xx">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Trabajador</label>
                                    <input type="text" class="form-control" v-model="Conductor" placeholder="000xx">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Es Casanova</label>
                                    <select class="form-control" v-model="casanova">
                                    <option value="0">No</option>
                                    <option value="1">Si</option>
                                    </select>
                                  
                                </div>
                            </div>

                </div>
               
                <div class="form-group row border">

                   
                   <div class="col-md-12">
                        <div class="form-group">
                            <label>Observaciones</label>
                            <textarea id="notas-adicionales-id" class="form-control"
                                                  placeholder="Observaciones" cols="30" rows="5" v-model="observaciones"></textarea>
                        </div>
                    </div>
                    
                 
                </div>
        

                <div class="form-group row">
                    <div class="col-md-12">
                        <button type="button" @click="ocultarDetalle()" class="btn btn-secondary float-right">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-primary float-right" @click="registrarIngreso()"><i class="fa fa-floppy-o mr-2"> Agregar</i></button>
                        <button type="button" v-if="tipoAccion==2" class="btn btn-primary float-right" @click="actualizarIngreso()">Actualizar</button>
                
                    </div>
                </div>
            </div>
            </template>
            <!-- Fin Detalle-->


            <template v-else-if="listado==4">
                <div class="card-body">
                         <p class="h5 text-uppercase font-weight-bold  border-bottom">Datos del Vehiculo</p>
                        <div class="form-group row border">
                           
                            <div class="col-md-3">
                                <div class="form-group">
                                     <label>Economico</label>
                                     <input type="text" class="form-control" v-model="modeloPresupuesto.economico" placeholder="000xx">
                                </div>
                            </div>
                             <div class="col-md-3">
                                <div class="form-group">
                                     <label>Modelo</label>
                                     <input type="text" class="form-control" v-model="modeloPresupuesto.modelo" placeholder="000xx">
                                </div>
                            </div>
                             <div class="col-md-3">
                                <div class="form-group">
                                    <label>VIN</label>
                                    <input type="text" class="form-control" v-model="modeloPresupuesto.vin" placeholder="000xx">
                                </div>
                            </div>

                             <div class="col-md-3">
                                <div class="form-group">
                                    <label>Placas</label>
                                    <input type="text" class="form-control" v-model="modeloPresupuesto.placas" placeholder="000xx">
                                </div>
                            </div>

                             <div class="col-md-3">
                                <div class="form-group">
                                    <label>Año</label>
                                    <input type="text" class="form-control" v-model="modeloPresupuesto.ano" placeholder="000xx">
                                </div>
                            </div>

                             <div class="col-md-3">
                                <div class="form-group">
                                    <label>Kilometraje</label>
                                    <input type="text" class="form-control" v-model="modeloPresupuesto.kilometraje" placeholder="000xx">
                                </div>
                            </div>

                             <div class="col-md-3">
                                <div class="form-group">
                                    <label>Marca</label>
                                    <input type="text" class="form-control" v-model="modeloPresupuesto.marca" placeholder="000xx">
                                </div>
                            </div>

                             <div class="col-md-3">
                                <div class="form-group">
                                    <label>Ubicación</label>
                                    <input type="text" class="form-control" v-model="modeloPresupuesto.ubicacion" placeholder="000xx">
                                </div>
                            </div>

                        </div>
                         <p class="h5 text-uppercase font-weight-bold  border-bottom">Datos Generales Solicitud</p>
                        <div class="form-group row border">

                             <div class="col-md-3">
                                <div class="form-group">
                                    <label>Folio</label>
                                    <input type="text" class="form-control" v-model="modeloPresupuesto.NSolicitud" placeholder="000xx" >
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                     <label>Fecha Alta:</label>
                                     <input type="date" class="form-control" v-model="modeloPresupuesto.FechaAlta" placeholder="000xx">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>ID</label>
                                    <input type="text" class="form-control" v-model="modeloPresupuesto.ordenServicio" placeholder="000x">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>km De Ingreso</label>
                                    <input type="text" class="form-control" v-model="modeloPresupuesto.kmDeIngreso" placeholder="000xx">
                                </div>
                            </div>
                             <div class="col-md-3">
                                <div class="form-group">
                                    <label>Administrador de trasportes</label>
                                    <input type="text" class="form-control" v-model="modeloPresupuesto.clienteYRazonSocial" placeholder="000xx">
                                </div>
                            </div>
                            
                             <div class="col-md-3">
                                <div class="form-group">
                                    <label>Jefe de Proceso.</label>
                                    <input type="text" class="form-control" v-model="modeloPresupuesto.Mail" placeholder="000xx">
                                </div>
                            </div>

                            
                            
                           
                             <div class="col-md-3">
                                <div class="form-group">
                                    <label>Telefono</label>
                                    <input type="text" class="form-control" v-model="modeloPresupuesto.Telefono" placeholder="000xx">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Trabajador</label>
                                    <input type="text" class="form-control" v-model="modeloPresupuesto.Conductor" placeholder="000xx">
                                </div>
                            </div>
                           
                           <div class="col-md-12">
                                <div class="form-group">
                                    <label>Observaciones</label>
                                    <textarea id="notas-adicionales-id" class="form-control"
                                                          placeholder="Notas" cols="30" rows="5" v-model="modeloPresupuesto.observaciones"></textarea>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div v-show="errorIngreso" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjIngreso" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                

                        <div class="form-group row">
                            <div class="col-md-12">
                               
                                <button type="button" @click="ocultarDetalle()" class="btn btn-secondary float-right">Cerrar</button>
                                <button type="button" v-if="tipoAccion==1" class="btn btn-primary float-right" @click="registrarAnexo()"><i class="fa fa-floppy-o mr-2"> Agregar</i></button>
                               
                        
                            </div>
                        </div>
                    </div>
            </template>
          

        </div>
        <!-- Fin ejemplo de tabla Listado -->
    </div>


</main>
</template>




<script>
import vSelect from 'vue-select';
import { constants } from 'crypto';
export default {
data (){
    return {
        empresa_id:0,
        no_economico: '',
        fecha: '',
        placas : '',
        marca : '',
        submarca : '',
        modelo : '',
        no_serie : '',
        tipo_de_vehiculo: [],
        tipo_de_servicio: '',
        observaciones : '',
        nombre_taller:'',
        razon_social : '',
        usuario : '',
        rpe : '',
        km_entrada : 0,
        orden_servicio : '',
        orden_id : '',
        clienteYRazonSocial:'',
        Mail:'',
        Telefono:'',
        Conductor:'',
        casanova:'0',

        anexo_id:0,

        listado:1,
        tipoAccion : 0,

        modeloPresupuesto:{
                    economico:'',
                    placas:'',
                    vin:'',
                    marca:'',
                    modelo:'',
                    NSolicitud:'',
                    ano:'',
                    FechaAlta:'',
                    kmDeIngreso:'',
                    ordenServicio:''
                },
       
        arrayCotizacion : [],
        arrayEmpresa : [],
       
        errorIngreso : 0,
        errorMostrarMsjIngreso : [],
        pagination : {
            'total' : 0,
            'current_page' : 0,
            'per_page' : 0,
            'last_page' : 0,
            'from' : 0,
            'to' : 0,
        },

        criterio : '',
        buscar : '',
        
    }
},
components: {
    vSelect
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

    },

    calcularTotal: function(){
        var resultado=0.0;
        for(var i=0;i<this.detalleConceptos.length;i++){
            resultado=resultado+(this.detalleConceptos[i].precio*this.detalleConceptos[i].cantidad)
        }
        return resultado;
    },
    calcularTotalf: function(){
        var resultado=0.0;
        for(var i=0;i<this.detallefactura.length;i++){
            resultado=resultado+(this.detallefactura[i].precio*this.detallefactura[i].cantidad)
        }
        return resultado;
    }
},
methods : {
   
     onChange(event , cotizacion ) {
        console.log(event.target.value);
   
        if(event.target.value == 1){
            this.pdfCotizacionAcuse(cotizacion.id)
        }
        if(event.target.value == 2){
            this.abrirModalC('cotizacion','actualizar',cotizacion);
        }
        if(event.target.value == 3){
           this.delete(cotizacion.id);
        }
       
       
    },

    crearPresupuesto(solicitud){
                console.log(solicitud);
                this.listado = 4;
                this.tipoAccion = 1;
                this.modeloPresupuesto.empresa_id = solicitud.empresa_id;
                this.modeloPresupuesto.economico = solicitud.no_economico;
                this.modeloPresupuesto.placas = solicitud.placas;
                this.modeloPresupuesto.vin = solicitud.no_serie;
                this.modeloPresupuesto.marca = solicitud.marca;
                this.modeloPresupuesto.modelo = solicitud.submarca;
                this.modeloPresupuesto.NSolicitud = solicitud.orden_servicio;
                this.modeloPresupuesto.ano = solicitud.modelo;
                this.modeloPresupuesto.FechaAlta = solicitud.fecha;
                this.modeloPresupuesto.kmDeIngreso = solicitud.km_entrada;
                this.modeloPresupuesto.ordenServicio = solicitud.orden_servicio;
                this.modeloPresupuesto.kilometraje = solicitud.km_entrada;
                this.modeloPresupuesto.ubicacion = solicitud.usuario;
                this.modeloPresupuesto.clienteYRazonSocial = solicitud.ClienteYRazonSocial;
                this.modeloPresupuesto.Mail = solicitud.Mail;
                this.modeloPresupuesto.Telefono = solicitud.Telefono;
                this.modeloPresupuesto.Conductor = solicitud.Conductor;

                this.$forceUpdate();
    },

    pdfCotizacionAcuse(id){
        window.open('anexosFRA/pdfAcuse/'+ id,'_blank');
    },
   
    vistaCategoriasRegistrar() {
        this.registrarCategoria = !this.registrarCategoria;
        this.modeloCategoria = {};
    },
     vistaTiposRegistrar() {
        this.registrarTipo = !this.registrarTipo;
        this.modeloTipos = {};
    },
    ocultarDetalle(){
        this.listado=1;
        this.listarIngreso(1,this.buscar,this.criterio,'0');
    },
    
    selectEmpresa(search,loading){
        let me=this;
        loading(true)
        var url= 'empresa/selectEmpresa?filtro='+search;
        axios.get(url).then(function (response) {
            //console.log(response);
            let respuesta= response.data;
            q: search
            me.arrayEmpresa = respuesta.empresas;
            loading(false)
        })
        .catch(function (error) {
            console.log(error);
        });
    },
 
    
   
    listarIngreso (page,buscar,criterio, contra){
        let me=this;
        var url= 'anexosFRA?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio + '&contra='+ contra + '&eco_id=1';
        axios.get(url).then(function (response) {
            console.log(response.data);
            var respuesta= response.data;
            me.arrayCotizacion = respuesta.cotizaciones.data;
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
        me.listarIngreso(page,this.buscar,this.criterio, '1');
    },
   
    registrarIngreso(){
    
        
        let me = this;

        axios.post('anexosFRA/registrar',{
            'empresa_id': this.empresa_id,
            'fecha': this.fecha,
            'no_economico': this.no_economico,
            'placas' : this.placas,
            'marca' : this.marca,
            'submarca' : this.submarca,
            'modelo': this.modelo,
            'no_serie' : this.no_serie,
            'tipo_de_vehiculo' : this.tipo_de_vehiculo,
            'tipo_de_servicio' : this.tipo_de_servicio,
            'observaciones' : this.observaciones,
            'nombre_taller' : this.nombre_taller,
            'razon_social' : this.razon_social,
            'usuario' : this.usuario,
            'rpe' : this.rpe,
            'a' : this.clienteYRazonSocial,
            'b' : this.Telefono,
            'c' : this.Mail,
            'd' : this.Conductor,
            'casanova' : this.casanova,
            'km_entrada' : this.km_entrada,
            'orden_servicio' : this.orden_servicio,
            'orden_id' : this.orden_id,
            'eco_id' : '1',
            

        }).then(function (response) {
            
            console.log(response.data);
            me.listado=1;
            me.listarIngreso(1,'','odes','0');

        }).catch(function (error) {
            console.log(error);
        });
    },
    
    registrarAnexo(){
                
                let me = this;

                axios.post('ordenesForaneas/registrar',{
                    'identificador': this.modeloPresupuesto.economico,
                    'modelo': this.modeloPresupuesto.modelo,
                    'vin' : this.modeloPresupuesto.vin,
                    'placas' : this.modeloPresupuesto.placas,
                    'ano' : this.modeloPresupuesto.ano,
                    'kilometraje' : this.modeloPresupuesto.kilometraje,
                    'marca' : this.modeloPresupuesto.marca,
                    'nsolicitud' : this.modeloPresupuesto.NSolicitud,
                    'fechaalta' : this.modeloPresupuesto.FechaAlta,
                    'ordenservicio' : this.modeloPresupuesto.ordenServicio,
                    'kmdeingreso' : this.modeloPresupuesto.kmDeIngreso,
                    'clienteYRazonSocial' : this.modeloPresupuesto.clienteYRazonSocial,
                    'observaciones' : this.modeloPresupuesto.observaciones,
                    'mail' : this.modeloPresupuesto.Mail,
                    'telefono' : this.modeloPresupuesto.Telefono,
                    'ubicacion' : this.modeloPresupuesto.ubicacion,
                    'conductor' : this.modeloPresupuesto.Conductor,
                    'area' : this.modeloPresupuesto.area,
                    'ubi' : this.modeloPresupuesto.ubi,
                    'preocorr_id' : this.modeloPresupuesto.servicio,
                    'tipo_servicio' : this.modeloPresupuesto.tipo_servicio,
                    'kilome' : this.modeloPresupuesto.kmservicio,
                    'data' : this.modeloPresupuesto.value,
                    'empresa_id': this.modeloPresupuesto.empresa_id,
                    'eco_id': '1',


                }).then(function (response) {
                    
                    console.log(response.data);
                    me.modeloPresupuesto.economico='';
                    me.modeloPresupuesto.modelo='';
                    me.modeloPresupuesto.vin='';
                    me.modeloPresupuesto.placas='';
                    me.modeloPresupuesto.ano='';
                    me.modeloPresupuesto.kilometraje='';
                    me.modeloPresupuesto.marca='';
                    me.modeloPresupuesto.NSolicitud='';
                    me.modeloPresupuesto.FechaAlta='';
                    me.modeloPresupuesto.ordenServicio='';
                    me.modeloPresupuesto.kmDeIngreso='';
                    me.modeloPresupuesto.clienteYRazonSocial = '';
                    me.modeloPresupuesto.observaciones ='';
                    me.modeloPresupuesto.Mail = '';
                    me.modeloPresupuesto.Telefono ='';
                    me.modeloPresupuesto.Conductor ='';
                    me.modeloPresupuesto.ubicacion ='';
                    me.$store.commit('presupuestosAkumas2023');
                    me.$toastr.success('Se registro correctamente', 'Presupuestos');

                }).catch(function (error) {
                    console.log(error);
                });
            },
    actualizarIngreso(){
     
        let me = this;

        axios.post('anexosFRA/actualizar',{
            'empresa_id': this.empresa_id,
            'fecha': this.fecha,
            'no_economico': this.no_economico,
            'placas' : this.placas,
            'marca' : this.marca,
            'submarca' : this.submarca,
            'modelo': this.modelo,
            'no_serie' : this.no_serie,
            'tipo_de_vehiculo' : this.tipo_de_vehiculo,
            'tipo_de_servicio' : this.tipo_de_servicio,
            'observaciones' : this.observaciones,
            'nombre_taller' : this.nombre_taller,
            'razon_social' : this.razon_social,
            'usuario' : this.usuario,
            'rpe' : this.rpe,
            'id': this.anexo_id,
            'km_entrada' : this.km_entrada,
            'orden_servicio' : this.orden_servicio,
            'orden_id' : this.orden_id,
            'a' : this.clienteYRazonSocial,
            'b' : this.Mail,
            'c' : this.Telefono,
            'd' : this.Conductor,
        }).then(function (response) {
            console.log(response.data);
            me.listado=1;
            me.listarIngreso(1,'','odes','0');
        }).catch(function (error) {
            console.log(error);
        }); 
    },
    getDatosEmpresa(val1){
        let me = this;
        me.loading = true;
        me.empresa_id = val1.id;
    },
   
   
    cerrarModal(){
        this.modal=0;
        this.modal1=0;
        this.modal2=0;
        this.modal3=0;
        this.modal4=0;
        this.modal5=0;
        this.modal6=0;
        this.modal7=0;
        this.modal8=0;
        this.modal9=0;
        this.modal13=0;
        this.modal55=0;
    },
   
    delete(id){
       swal({
        title: 'Esta seguro de eliminar esta Cotización?',
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

            axios.put('anexosFRA/delete',{
                'id': id
            }).then(function (response) {
                console.log(response.data);
                me.listarIngreso(1,'','odes');
                swal(
                'Eliminado!',
                'La cotización ha sido eliminada con éxito.',
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
     abrirModalC(modelo, accion, data = []){
        switch(modelo){
            case "cotizacion":
            {
                switch(accion){
                    case 'registrar':
                    {
                        this.listado=0;
                        this.tipoAccion=1;
                        this.no_economico='';
                        this.empresa_id=0;
                        this.fecha='';
                        this.placas='';
                        this.submarca='';
                        this.marca='';
                        this.modelo='';
                        this.no_serie = ''; 
                        this.tipo_de_vehiculo= '';
                        this.tipo_de_servicio = '';
                        this.observaciones = '';
                        this.nombre_taller = '';
                        this.razon_social = '';
                        this.usuario = '';
                        this.rpe = '';
                        this.km_entrada = '';
                        this.orden_servicio = '';
                        this.orden_id = '';
                        this.clienteYRazonSocial = '';
                        this.Mail = '';
                        this.Telefono = '';
                        this.Conductor = '';
                        break;
                    }
                    case 'actualizar':
                    {
                        //console.log(data);
                        this.listado=0;
                        this.tipoAccion=2;
                        this.no_economico = data['no_economico'];
                        this.empresa_id = data['empresa_id'];
                        this.fecha = data['fecha'];
                        this.placas = data['placas'];
                        this.submarca = data['submarca'];
                        this.marca = data['marca'];
                        this.modelo = data['modelo'];
                        this.no_serie = data['no_serie'];
                        this.tipo_de_vehiculo = data['tipo_de_vehiculo'];
                        this.tipo_de_servicio = data['tipo_de_servicio'];
                        this.observaciones = data['observaciones'];
                        this.nombre_taller = data['nombre_taller'];
                        this.razon_social = data['razon_social'];
                        this.usuario = data['usuario'];
                        this.rpe = data['rpe'];
                        this.anexo_id = data['id'];
                        this.km_entrada = data['km_entrada'];
                        this.orden_servicio = data['orden_servicio'];
                        this.orden_id = data['orden_id'];
                        this.clienteYRazonSocial = data['ClienteYRazonSocial'];
                        this.Mail = data['Mail'];
                        this.Telefono = data['Telefono'];
                        this.Conductor = data['Conductor'];
                
                        break;
                    }
                }
            }
        }
        
    },
     

},
mounted() {
     this.listarIngreso(1,this.buscar,this.criterio,'0');
   
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
.mostrar1{
display: list-item !important;
opacity: 1 !important;
position: absolute !important;
background-color: #3c29297a !important;
}
.mostrar2{
display: list-item !important;
opacity: 1 !important;
position: absolute !important;
background-color: #3c29297a !important;
}
.mostrar3{
display: list-item !important;
opacity: 1 !important;
position: absolute !important;
background-color: #3c29297a !important;
}
.mostrar4{
display: list-item !important;
opacity: 1 !important;
position: absolute !important;
background-color: #3c29297a !important;
}
.mostrar5{
display: list-item !important;
opacity: 1 !important;
position: absolute !important;
background-color: #3c29297a !important;
}
.mostrar6{
display: list-item !important;
opacity: 1 !important;
position: absolute !important;
background-color: #3c29297a !important;
}
.mostrar7{
display: list-item !important;
opacity: 1 !important;
position: absolute !important;
background-color: #3c29297a !important;
}
.mostrar8{
display: list-item !important;
opacity: 1 !important;
position: absolute !important;
background-color: #3c29297a !important;
}
.mostrar9{
display: list-item !important;
opacity: 1 !important;
position: absolute !important;
background-color: #3c29297a !important;
}
.mostrar55{
display: list-item !important;
opacity: 1 !important;
position: absolute !important;
background-color: #3c29297a !important;
}
.mostrar13{
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
@media (min-width: 600px) {
.btnagregar {
    margin-top: 2rem;
}
}

</style>