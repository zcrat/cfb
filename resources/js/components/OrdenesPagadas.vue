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
                    <i class="fa fa-plus-circle mr-2"></i>Ordenes Pagos
                    <button class="btn btn-warning btn_sm float-right" type="button" @click="listarordenespagos(1,criterio,buscar,'','')">
                        <i class="fa fa-sync-alt mr-2"></i>Actualizar
                    </button>
                </div>

    

     <!-- Modal  - Nueva empresa-->
     <template v-if="modalTarea == 0">
               
            <div class="card-body">
                <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div @click="btonstatus('status',0, from, to)"  class="small-box bg-danger" >
                <div class="inner">
                    <h3>{{formatPrice(sinpanifa)}}</h3>

                    <p>Sin Pagar y Sin Facturar</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                
                </div>
            </div>
           
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div @click="btonstatus('status',1, from, to)" class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ formatPrice(sinpaconfa) }}</h3>

                    <p> Sin pagar con factura</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div @click="btonstatus('status',2, from, to)" class="small-box bg-success">
                <div class="inner">
                    <h3>{{formatPrice(confaypa)}}</h3>

                    <p>Pagado y Facturado</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                
                </div>
            </div>
            </div>
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
                                      <option value="orden">Orden</option>
                                      <option value="empresa">Empresa</option>
                                      <option value="placa">Placas</option>
                                      <option value="serie">Serie</option>
                                      <option value="os">Os</option>
                                      <option value="folio_sistema">Folio de sistema</option>
                                      <option value="presupuesto">Presupuesto</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarordenespagos(1,criterio, buscar, from, to)" class="form-control" placeholder="Texto a buscar">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group">
                                    <button type="submit" @click="listarordenespagos(1,criterio, buscar, from, to)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <button class="btn btn-secondary btn_sm float-right" type="button" @click="agregarEntardaSalida()">
                                    <i class="fa fa-plus-circle mr-2"></i>Nuevo
                                </button>
                                </div>
                            </div>
                    <div class="col-md-12 ">
                       
                
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Fecha</th>
                                    <th>Orden</th>
                                    <th>Empresa</th>
                                    <th>Placa</th>
                                    <th>Serie</th>
                                    <th>Os</th>
                                    <th>Folio sistema</th>
                                    <th>Presupuesto</th>
                                    <th>Factura</th>
                                    <th>Monto</th>
                                    <th>IVA</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                   
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="entrada in arrayordenespagos" :key="entrada.id">
                                   
                                    <td>
                                      
                                        <button type="button"  class="btn btn-warning btn-sm" @click="editarEntradaSalida(entrada)">
                                          <i class="icon-pencil"></i>
                                        </button> 
                                       
                                            <button type="button" class="btn btn-danger btn-sm" @click="deleter(entrada.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                         
                                      
                                    </td>
                                    <td v-text="entrada.fecha"></td>
                                    <td v-text="entrada.orden"></td>
                                    <td v-text="entrada.empresa"></td>
                                    <td v-text="entrada.placa"></td>
                                    <td v-text="entrada.serie"></td>
                                    <td v-text="entrada.os"></td>
                                    <td v-text="entrada.folio_sistema"></td>
                                    <td v-text="entrada.presupuesto"></td>
                                    <td v-text="entrada.factura"></td>
                                    <td>${{ formatPrice(entrada.monto) }}</td>
                                    <td>${{ formatPrice(entrada.iva) }}</td>
                                    <td>${{ formatPrice(entrada.total) }}</td>
                                    <td>
                                    
                                     <template v-if="entrada.status === 0">
                                        <button class="btn btn-danger btn_sm float-right" type="button">
                                             Sin pagar y Sin facturar
                                      </button>

                                     </template>   

                                     <template v-if="entrada.status === 1">
                                        <button class="btn btn-warning btn_sm float-right" type="button">
                                             Sin pagar con facturar
                                      </button>
                                     </template>   
                                     
                                      <template v-if="entrada.status === 2">
                                        <button class="btn btn-success btn_sm float-right" type="button">
                                             Pagado y Facturado
                                      </button>

                                     </template>   

                                    
                                        
                                    
                                    </td>
                                  
                               
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
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,criterio,buscar)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,criterio,buscar)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination2.current_page + 1,criterio,buscar)">Sig</a>
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
    <label class="col-md-3 form-control-label" for="text-input">Fecha</label>
    <div class="col-md-9">
        <input v-model="modeloEntradaSalida.fecha" type="date" class="form-control">
    </div>
</div>

<div class="form-group row">
    <label class="col-md-3 form-control-label" for="text-input">Orden</label>
    <div class="col-md-9">
        <input v-model="modeloEntradaSalida.orden" type="text" class="form-control">
    </div>
</div>

<div class="form-group row">
    <label class="col-md-3 form-control-label" for="text-input">Empresa</label>
    <div class="col-md-9">
        <input v-model="modeloEntradaSalida.empresa" type="text" class="form-control">
    </div>
</div>

<div class="form-group row">
    <label class="col-md-3 form-control-label" for="text-input">Placa</label>
    <div class="col-md-9">
        <input v-model="modeloEntradaSalida.placa" type="text" class="form-control">
    </div>
</div>

<div class="form-group row">
    <label class="col-md-3 form-control-label" for="text-input">Serie</label>
    <div class="col-md-9">
        <input v-model="modeloEntradaSalida.serie" type="text" class="form-control">
    </div>
</div>

<div class="form-group row">
    <label class="col-md-3 form-control-label" for="text-input">OS</label>
    <div class="col-md-9">
        <input v-model="modeloEntradaSalida.os" type="text" class="form-control">
    </div>
</div>

<div class="form-group row">
    <label class="col-md-3 form-control-label" for="text-input">Folio Sistema</label>
    <div class="col-md-9">
        <input v-model="modeloEntradaSalida.folio_sistema" type="text" class="form-control">
    </div>
</div>

<div class="form-group row">
    <label class="col-md-3 form-control-label" for="text-input">Presupuesto</label>
    <div class="col-md-9">
        <input v-model="modeloEntradaSalida.presupuesto" type="text" class="form-control">
    </div>
</div>

<div class="form-group row">
    <label class="col-md-3 form-control-label" for="text-input">Factura</label>
    <div class="col-md-9">
        <input v-model="modeloEntradaSalida.factura" type="text" class="form-control">
    </div>
</div>



<div class="form-group row">
    <label class="col-md-3 form-control-label" for="text-input">Monto</label>
    <div class="col-md-9">
        <input v-model="modeloEntradaSalida.monto" type="text" class="form-control" @input="calculoIVA">
    </div>
</div>

<div class="form-group row">
    <label class="col-md-3 form-control-label" for="text-input">IVA</label>
    <div class="col-md-9">
        <input v-model="modeloEntradaSalida.iva" type="text" class="form-control">
    </div>
</div>

<div class="form-group row">
    <label class="col-md-3 form-control-label" for="text-input">Total</label>
    <div class="col-md-9">
        <input v-model="modeloEntradaSalida.total" type="text" class="form-control">
    </div>
</div>

<div class="form-group row">
    <label class="col-md-3 form-control-label" for="text-input">Status</label>
    <div class="col-md-9">
        <select v-model="modeloEntradaSalida.status" class="form-control">
        <option value="0">Sin pagar y sin facturar</option>
        <option value="1">Sin pagar con factura</option>
        <option value="2">Pagado y Facturado</option>
        </select>
    </div>
</div>


</form>


<div class="row">
                            <button type="button" class="btn btn-secondary" @click="cerrarModalordenespagos()">Cerrar</button>
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
        arrayordenespagos : [],
        arrayTrasladistas: [],
        modeloEntradaSalida:{},
        arrayRol : [],
        arrayPlanteles:[],
        planteles_id:0,
        modal : 0,
        modal3 : 0,
        confaypa:0,
        sinpaconfa:0,
        sinpanifa:0,
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

    },
},
methods : {
    listarordenespagos (page,criterio,buscar, from, to){
        let me=this;
        var url= 'ordenespagadas?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio +'&from='+ from + '&to='+ to;
        axios.get(url).then(function (response) {
            var respuesta= response.data;
            console.log(respuesta);
           
            
            me.arrayordenespagos = respuesta.ordenespagos.data;
            me.sinpanifa = respuesta.sinpanifa;
            me.sinpaconfa = respuesta.sinpaconfa;
            me.confaypa = respuesta.confaypa;
            me.pagination= respuesta.pagination;
           
           
        })
        .catch(function (error) {
            console.log(error);
        });
    },
    btonstatus(criterio, buscar, from, to){

        this.criterio = criterio;
        this.buscar = buscar;
        this.listarordenespagos(1,criterio,buscar,from,to);

    },
    cambiarPagina(page,criterio,buscar){
        let me = this;
        //Actualiza la página actual
        me.pagination.current_page = page;
        //Envia la petición para visualizar la data de esa página
        me.listarordenespagos(page,criterio,buscar,'','');
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
    calculoIVA(){
        this.modeloEntradaSalida.iva = this.modeloEntradaSalida.monto*0.16
        this.modeloEntradaSalida.total = (this.modeloEntradaSalida.monto*1.16);

    },
    toNumber(val) {
    var n = parseFloat(val);
    return isNaN(n) ? val : n;
    },
    editarEntradaSalida(entrada){
        let me = this;
        me.modalTarea=2;
        me.tipoAccion = 2;
        me.modeloEntradaSalida.id = entrada.id;
        me.modeloEntradaSalida.fecha = entrada.fecha;
        me.modeloEntradaSalida.orden = entrada.orden;
        me.modeloEntradaSalida.empresa = entrada.empresa;
        me.modeloEntradaSalida.placa = entrada.placa;
        me.modeloEntradaSalida.serie = entrada.serie;
        me.modeloEntradaSalida.os = entrada.os;
        me.modeloEntradaSalida.folio_sistema = entrada.folio_sistema;
        me.modeloEntradaSalida.presupuesto =entrada.presupuesto;
        me.modeloEntradaSalida.factura = entrada.factura;
        me.modeloEntradaSalida.monto = entrada.monto;
        me.modeloEntradaSalida.iva = entrada.iva;
        me.modeloEntradaSalida.total = entrada.total;
        me.modeloEntradaSalida.status = entrada.status;
      
    },
    cerrarModalordenespagos(){
        let me = this;
        me.modalTarea=0;
    },
    formatPrice(value) {
                let val = (value/1).toFixed(2).replace(',', '.')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    },
    registrarEntradaySalida(){

        let me = this;

        axios.post('ordenespagadas/registrar',{
            'fecha': this.modeloEntradaSalida.fecha,
            'orden': this.modeloEntradaSalida.orden,
            'empresa': this.modeloEntradaSalida.empresa,
            'placa' : this.modeloEntradaSalida.placa,
            'serie': this.modeloEntradaSalida.serie,
            'os': this.modeloEntradaSalida.os,
            'folio_sistema': this.modeloEntradaSalida.folio_sistema,
            'presupuesto' : this.modeloEntradaSalida.presupuesto,
            'factura' : this.modeloEntradaSalida.factura,
            'monto': this.modeloEntradaSalida.monto,
            'iva': this.modeloEntradaSalida.iva,
            'total': this.modeloEntradaSalida.total,
            'status': this.modeloEntradaSalida.status,

        }).then(function (response) {
            console.log(response.data);
            me.cerrarModalordenespagos();
            me.listarordenespagos(1,'','','','');
            me.$toastr.success('Nueva Entrada agregada', 'Entradas y Salidas');
        }).catch(function (error) {
            console.log(error);
        });
    },
    
    actualizarEntardaySalida(){
        let me = this;

        axios.put('ordenespagadas/actualizar',this.modeloEntradaSalida).then(function (response) {
            console.log(response.data);
            me.cerrarModalordenespagos();
            me.listarordenespagos(1,'','','','');
            me.$toastr.success('Entrada actualizada con exito', 'Entradas y Salidas');
        }).catch(function (error) {
            console.log(error);
        }); 
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

            axios.put('ordenespagadas/delete',{
                'id': id
            }).then(function (response) {
                me.listarordenespagos(1,'','','','');
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
    this.listarordenespagos(1,this.criterio,this.buscar,'','');
   
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
