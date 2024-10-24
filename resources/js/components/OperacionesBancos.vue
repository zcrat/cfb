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
                <i class="fa fa-align-justify"></i> Operaciones Bancos
                <button type="button" @click="abrirModal('categoria','registrar')" class="btn btn-secondary float-right">
                    <i class="icon-plus"></i>&nbsp;Nuevo
                </button>
            </div>
            <div class="card-body">
                <div class="form-group row">
                     <div class="col-md-2">
                        <div class="input-group">
                             <input type="date" v-model="fecha_inicio" />
                        </div>
                     </div>
                      <div class="col-md-2">
                        <div class="input-group">
                             <input type="date" v-model="fecha_final" />
                        </div>
                     </div>
                    <div class="col-md-5">
                        <div class="input-group">
                            <button type="submit" @click="listarCategoria(1,fecha_inicio,fecha_final)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>
                          <div class="col-md-3">
    <!-- small box -->
    <div class="small-box bg-warning">
      <div class="inner">
        <h3>{{formatPrice(saldo)}}</h3>

        <p>SALDO ACTUAL</p>
      </div>
      <div class="icon">
        <i class="ion ion-stats-bars"></i>
      </div>
     
    </div>
  </div>
                </div>
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                           
                            <th>CONSEC</th>
                            <th>FECHA</th>
                            <th>CONCEPTO</th>
                            <th>INGRESO</th>
                            <th>EGRESO</th>
                            <th>SALDO</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="categoria in arrayCategoria" :key="categoria.id">
                           
                            <td v-text="categoria.id"></td>
                            <td v-text="categoria.fecha"></td>
                            <td v-text="categoria.concepto"></td>
                            <td v-text="categoria.ingreso"></td>
                            <td v-text="categoria.egreso"> </td>
                            <td v-text="categoria.saldo"> </td>
                             <td>
                                <button @click="abrirModalFacturas(categoria.id)" type="button" class="btn btn-success btn-sm">
                                                    <i class="icon-doc"></i>
                                </button> &nbsp;
                                <button type="button" @click="desactivarCategoria(categoria.id)" class="btn btn-danger btn-sm">
                                  <i class="icon-close"></i>
                                </button> &nbsp;
                                
                            </td>
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
        <!-- Fin ejemplo de tabla Listado -->
    </div>
    <!--Inicio del modal agregar/actualizar-->
    <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-text="tituloModal"></h4>
                    <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-2 form-control-label" for="text-input">Fecha: </label>
                             <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <datetime input-id="fecha-id" input-class="form-control" type="datetime"
                                        v-model="fecha">
                                            <template slot="button-cancel">
                                                <i class="fa fa-times mr-2"></i>Cancelar
                                            </template>
                                            <template slot="button-confirm">
                                                <i class="fa fa-check-circle mr-2"></i>Aceptar
                                            </template>
                                        </datetime>
                                    </div>
                                </div>
                             
                        </div>
                        <div class="form-group row">
                                    <label for="plantel" class="col-md-3 form-control-label">Cuentas  <i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                    <div class="col-md-9">
                                       <select class="form-control" v-model="cuenta" >
                                                        <option value="0" disabled>Seleccione su cuenta</option>
                                                        <option v-for="cuenta in arrayCuentas" :key="cuenta.id" :value="cuenta.id">{{cuenta.banco}}-{{cuenta.noCuenta}}</option>
                                                 </select>
                                    </div>
                                </div>
                        <div class="form-group row">
                            <label class="col-md-2 form-control-label" for="email-input">Concepto</label>
                            <div class="col-12 col-md-9">
                                <textarea class="form-control" v-model="concepto"  rows="3" placeholder="Ingrese concepto"></textarea>
                        
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 form-control-label" for="email-input"></label>
                            <div class="col-md-4">
                                <input type="radio" id="uno" value="0" v-model="picked"><label for="uno">Ingreso</label>
                            </div>
                            <label class="col-md-2 form-control-label" for="email-input"></label>
                            <div class="col-md-4">
                                <input type="radio" id="Dos" value="1" v-model="picked"><label for="Dos">Egreso</label>
                            </div>
                        </div>

                        <div class="form-group row border">
                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Folio</th>
                                            <th>Numero</th>
                                            <th>Monto</th>
                                            <th>Opciones</th>
                                        
                                        </tr>
                                        <tr>
                                            <th><input type="text" v-model="folio" class="form-control" placeholder="Folio"></th>
                                            <th><input type="text" v-model="numero" class="form-control" placeholder="Numero"></th>
                                            <th><input type="number" v-model="monto" class="form-control" placeholder="Monto"></th>
                                            <th>
                                                <button type="button" @click="abrirpdf()" class="btn btn-danger btn-sm">
                                                <i class="icon-doc "></i>
                                                </button> &nbsp;
                                                <button type="button" @click="abrirxml()" class="btn btn-info btn-sm">
                                                <i class="icon-doc"></i>
                                                </button> &nbsp;
                                                <button @click="agregarDetalle()" type="button" class="btn btn-success btn-sm">
                                                    <i class="icon-plus"></i>
                                            </button></th>
                                        
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayFacturas.length">
                                        <tr v-for="(detalle,index) in arrayFacturas" :key="detalle.id">
                                           
                                            <td v-text="detalle.folio"></td>
                                            <td v-text="detalle.numero"></td>
                                            <td v-text="detalle.monto"></td>
                                            <td>
                                               
                                                <button @click="eliminarDetalle(index)" type="button" class="btn btn-danger btn-sm">
                                                    <i class="icon-close"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        
                                    
                                    </tbody>  
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="5">
                                                No hay facturas
                                            </td>
                                        </tr>
                                    </tbody>                                  
                                </table>
                            </div>
                        </div>

                       
                         <div class="form-group row">
                            <label class="col-md-2 form-control-label" for="email-input">Importe</label>
                            <div class="col-md-4">
                                <input type="text" v-model="importe" class="form-control" placeholder="Ingrese importe">
                            </div>
                        </div>
                        <div v-show="errorCategoria" class="form-group row div-error">
                            <div class="text-center text-error">
                                <div v-for="error in errorMostrarMsjCategoria" :key="error" v-text="error">

                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                    <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarCategoria()">Guardar</button>
                    <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarCategoria()">Actualizar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->

     <!--Inicio del modal agregar/actualizar-->
     <div class="modal fade" tabindex="-1" :class="{'mostrar1' : modal1}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Facturas Relacionadas</h4>
                    <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                  
                        <div class="form-group row border">
                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Folio</th>
                                            <th>Numero</th>
                                            <th>Monto</th>
                                            <th>Archivos</th>
                                        
                                        </tr>
                                      
                                    </thead>
                                    <tbody v-if="arrayFacturasRelacionadas.length">
                                        <tr v-for="(detalle) in arrayFacturasRelacionadas" :key="detalle.id">
                                           
                                            <td v-text="detalle.folio"></td>
                                            <td v-text="detalle.numero"></td>
                                            <td v-text="detalle.monto"></td>
                                            <td><button type="button" @click="pdfdescargar(detalle.archivoxml)" class="btn btn-danger btn-sm">
                                            <i class="icon-doc "></i>
                                            </button> &nbsp;
                                             <button type="button" @click="xmldescargar(detalle.archivopdf)" class="btn btn-info btn-sm">
                                            <i class="icon-doc"></i>
                                            </button> &nbsp;
                                            </td>
                                            
                                        </tr>
                                    
                                    </tbody>  
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="5">
                                                No hay facturas
                                            </td>
                                        </tr>
                                    </tbody>                                  
                                </table>
                            </div>
                        </div>

                     

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                   
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->


      <!-- Modal -->
   <div class="modal fade fade bd-example-modal-lg" id="exampleModalCenter2" :class="{'mostrarxml' : modalxml}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >Agregar factura xml</h5>
        <button type="button" class="close" @click="cerrarModalxml">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     
   
       <div class="modal-body">
         <div class="form-group row">
               <label class="col-md-3 form-control-label" for="text-input">Archivo</label>
                <div class="col-md-9">
                <input id="folio-id" class="form-control" type="file" @change="subirarchivoxml">
             </div>
         </div>
      </div>
         <div class="modal-footer">
     <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" @click="cerrarModalxml()" class="btn btn-secondary" :disabled="disabledxml == 1">Guardar</button>
                            </div>
     </div>
    
    
      </div>
    </div>
  </div>
</div>

 <!-- Modal -->
 <div class="modal fade fade bd-example-modal-lg" id="exampleModalCenter2" :class="{'mostrarpdf' : modalpdf}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >Agregar factura pdf</h5>
        <button type="button" class="close" @click="subirarchivopdf">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     
   
       <div class="modal-body">
         <div class="form-group row">
               <label class="col-md-3 form-control-label" for="text-input">Archivo</label>
                <div class="col-md-9">
                <input id="folio-id" class="form-control" type="file" @change="subirarchivopdf">
             </div>
         </div>
      </div>
         <div class="modal-footer">
     <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" @click="cerrarModalpdf()" class="btn btn-secondary" :disabled="disabledpdf == 1">Guardar</button>
                            </div>
     </div>
    
    
      </div>
    </div>
  </div>
</div>

</main>
</template>

<script>
export default {
data (){
    return {
        categoria_id: 0,
        bancos_id: 0,
        fecha_inicio:'',
        fecha_final:'',
        fecha:'',
        saldo:0.0,
        caja_id:0,
        cuenta:0,
        folio:'',
        numero:'',
        monto:0.0,
        concepto:'',
        picked:0,
        importe:0.0,
        tiposCuenta_id: 0,
        monedas_id: 0,
        disabledxml:1,
        disabledpdf:1,
        noCuenta : '',
        domicilioBanco : '',
        telefonoBanco : '',
        nombreEjecutivo : '',
        emailEjecutivo : '',
        telefonoEjecutivo : '',
        arrayCategoria : [],
        arrayFacturasRelacionadas:[],
        arrayCuentas:[],
        modal : 0,
        modal1 : 0,
        modalxml : 0,
        modalpdf : 0,
        tituloModal : '',
        tipoAccion : 0,
        errorCategoria : 0,
        archivoxml:'',
        archivopdf:'',
        arrayBancos : [],
        arrayFacturas :[],
        arrayTiposCuenta : [],
        arrayMonedas : [],
        errorMostrarMsjCategoria : [],
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
        buscar : ''
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
    calcularTotal: function(){
                var resultado=0.0;
                for(var i=0;i<this.arrayFacturas.length;i++){
                    resultado=resultado+parseFloat(this.arrayFacturas[i].monto);
                  }
                return resultado;
    }
},
methods : {
    listarCategoria (page,buscar,criterio){
        let me=this;
        var url= 'cajaBancos?page=' + page + '&finicio='+ buscar + '&ffinal='+ criterio;
        axios.get(url).then(function (response) {
            var respuesta= response.data;
            console.log(respuesta);
            me.arrayCategoria = respuesta.caja.data;
            me.saldo = respuesta.saldo;
            me.arrayCuentas = respuesta.cuentas;
            me.pagination= respuesta.pagination;
        })
        .catch(function (error) {
            console.log(error);
        });
    },
     formatPrice(value) {
let val = (value/1).toFixed(2).replace(',', '.')
return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
},
listarFacturas(id){
        let me=this;
        var url= 'cajaFacturasBancos?id=' + id;
        axios.get(url).then(function (response) {
            var respuesta= response.data;
            console.log(respuesta);
            me.arrayFacturasRelacionadas = respuesta.facturas.data;
            me.pagination= respuesta.pagination;
        })
        .catch(function (error) {
            console.log(error);
        });
    },
     formatPrice(value) {
let val = (value/1).toFixed(2).replace(',', '.')
return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
},
    cambiarPagina(page,buscar,criterio){
        let me = this;
        //Actualiza la página actual
        me.pagination.current_page = page;
        //Envia la petición para visualizar la data de esa página
        me.listarCategoria(page,buscar,criterio);
    },
    registrarCategoria(){
        if (this.validarCategoria()){
            return;
        }
        
        let me = this;

        axios.post('cajaBancos/registrar',{
            'fecha': this.fecha,
            'cuenta_id': this.cuenta,
            'concepto': this.concepto,
            'importe': this.importe,
            'ingreso': this.picked,
            'facturas': this.arrayFacturas
        }).then(function (response) {
            console.log(response);
            me.cerrarModal();
            me.listarCategoria(1,'','nombre');
        }).catch(function (error) {
            console.log(error);
        });
    },
    actualizarCategoria(){
       if (this.validarCategoria()){
            return;
        }
        
        let me = this;

        axios.put('cuentas/actualizar',{
            'noCuenta': this.noCuenta,
            'bancos_id': this.bancos_id,
            'tiposCuenta_id': this.tiposCuenta_id,
            'monedas_id': this.monedas_id,
            'domicilioBanco': this.domicilioBanco,
            'telefonoBanco': this.telefonoBanco,
            'nombreEjecutivo': this.nombreEjecutivo,
            'emailEjecutivo': this.emailEjecutivo,
            'telefonoEjecutivo': this.telefonoEjecutivo,
            'id': this.categoria_id
        }).then(function (response) {
            me.cerrarModal();
            me.listarCategoria(1,'','nombre');
        }).catch(function (error) {
            console.log(error);
        }); 
    },
    desactivarCategoria(id){
       swal({
        title: 'Esta seguro de eliminar este registro?',
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

            axios.post('cajaBancos/delete',{
                'id': id
            }).then(function (response) {
                me.listarCategoria(1,'','nombre');
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
    agregarDetalle(){
        let me=this;
        if(me.folio=="" || me.numero=="" || me.monto==""){
        }else{
           
                    me.arrayFacturas.push({
                    folio: me.folio,
                    numero: me.numero,
                    monto: me.monto,
                    archivoxml: me.archivoxml,
                    archivopdf: me.archivopdf
                    });
                    me.folio='';
                    me.numero='';
                    me.monto="";
                    me.archivoxml = '';
                    me.archivopdf = '';
                    me.disabledxml=1;
                    me.disabledpdf=1;
                    me.importe = me.calcularTotal;
               
        }
        
    },
    eliminarDetalle(index){
        let me = this;
        me.arrayFacturas.splice(index, 1);
    },
    activarCategoria(id){
       swal({
        title: 'Esta seguro de activar esta categoría?',
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

            axios.put('categoria/activar',{
                'id': id
            }).then(function (response) {
                me.listarCategoria(1,'','nombre');
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
    validarCategoria(){
        this.errorCategoria=0;
        this.errorMostrarMsjCategoria =[];

        if (!this.fecha) this.errorMostrarMsjCategoria.push("Seleccione una fecha");
        if (!this.concepto) this.errorMostrarMsjCategoria.push("Ingrese un concepto");
        if (!this.importe) this.errorMostrarMsjCategoria.push("Ingrese un importe");

        if (this.errorMostrarMsjCategoria.length) this.errorCategoria = 1;

        return this.errorCategoria;
    },
    cerrarModal(){
        this.modal=0;
        this.modal1=0;
        this.tituloModal='';
        this.fecha='';
        this.concepto='';
        this.importe=0;
        this.picked=0;
        this.modalxml=0;
        this.modalpdf=0;
    },

    cerrarModalxml(){
        this.modalxml=0;
    },
    cerrarModalpdf(){
        this.modalpdf=0;
    },
    abrirxml(){
        this.modalxml = 1;
    },
    abrirpdf(){
        this.modalpdf = 1;
    },
    subirarchivoxml(e){
                let me = this;

                var fileReader = new FileReader()
                fileReader.readAsDataURL(e.target.files[0])
                fileReader.onload = (e) => {
                      axios.post('cajaBancos/subirXML',{
                        'doc': e.target.result
                    }).then(function (response) {
                    console.log(response.data);
                     if (response.data == "nada.doc"){

                    } else {
                        me.archivoxml = response.data.nombre;
                        me.disabledxml = 0;
                    }
                })
                    .catch(function (error) {
                    console.log(error);
                    me.limpiarCampos();
                       
                    });
                    
                }
              

            },
    subirarchivopdf(e){
                let me = this;

                var fileReader = new FileReader()
                fileReader.readAsDataURL(e.target.files[0])
                fileReader.onload = (e) => {
                      axios.post('cajaBancos/subirPDF',{
                        'doc': e.target.result
                    }).then(function (response) {
                    console.log(response.data);
                     if (response.data == "nada.doc"){

                    } else {
                        me.archivopdf = response.data.nombre;
                        me.disabledpdf = 0;
                    }
                })
                    .catch(function (error) {
                    console.log(error);
                    me.limpiarCampos();
                       
                    });
                    
                }
              

            },
           
    abrirModalFacturas(id){
        this.listarFacturas(id);
        this.modal1=1;
        
    },
    pdfdescargar(cotizacion){
                  window.open('downloadxml/'+ cotizacion,'_blank');
             },
    xmldescargar(cotizacion){
                 window.open('downloadpdf/'+ cotizacion,'_blank');
             },
    abrirModal(modelo, accion, data = []){
        switch(modelo){
            case "categoria":
            {
                switch(accion){
                    case 'registrar':
                    {
                        this.modal = 1;
                        this.tituloModal = 'Registrar Movimiento';
                        this.nombre= '';
                        this.descripcion = '';
                        this.tipoAccion = 1;
                        break;
                    }
                    case 'actualizar':
                    {
                        //console.log(data);
                        this.modal=1;
                        this.tituloModal='Actualizar Movimiento';
                        this.tipoAccion=2;
                        this.categoria_id=data['id'];
                        this.fecha = data['fecha'];
                        this.concepto= data['concepto'];
                        if ( data['ingreso'] == 0){
                            this.picked = 1;
                            this.importe= data['egreso'];
                        } else {
                            this.picked = 0;
                            this.importe= data['ingreso'];
                        }
                        
                        break;
                    }
                }
            }
        }
    }
},
mounted() {
    this.listarCategoria(1,this.buscar,this.criterio);
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
.mostrarxml{
display: list-item !important;
opacity: 1 !important;
position: absolute !important;
background-color: #3c29297a !important;
}
.mostrarpdf{
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
.div-error{
display: flex;
justify-content: center;
}
.text-error{
color: red !important;
font-weight: bold;
}
</style>
