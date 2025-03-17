<template>
    <main class="main">
    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Saldos - Concentrado de saldos por cuenta
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
                    <div class="col-md-2">
                        <div class="input-group">
                            <button type="submit" @click="listarCategoria(1,fecha_inicio,fecha_final,0)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>
                          <div class="col-md-3">
    <!-- small box -->
    <div class="small-box bg-warning">
      <div class="inner">
        <h3>{{formatPrice(saldo)}}</h3>

        <p>SALDO CAJA</p>
      </div>
      <div class="icon">
        <i class="ion ion-stats-bars"></i>
      </div>
     
    </div>
  </div>
  <div class="col-md-3">
    <!-- small box -->
    <div class="small-box bg-success">
      <div class="inner">
        <h3>{{formatPrice(saldobanco)}}</h3>

        <p>SALDO BANCOS</p>
      </div>
      <div class="icon">
        <i class="ion ion-stats-bars"></i>
      </div>
     
    </div>
  </div>
                </div>
                <template v-if="cuentacampo==0">
                    <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                           
                            <th>Nombre del banco</th>
                            <th>Numero de cuenta</th>
                            <th>Moneda</th>
                            <th>Saldo</th>
                            <th>Ultimo Mov</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="categoria in arrayCategoria" :key="categoria.id">
                           
                            <td v-text="categoria.banco"></td>
                            <td><a href="#" @click.prevent="listarCategoria(1,fecha_inicio,fecha_final,categoria.cuenta_id)">{{categoria.cuenta}}</a></td>
                            <td v-text="categoria.moneda"></td>
                            <td v-text="categoria.ingreso-categoria.egreso"></td>
                            <td v-text="categoria.updated_at"> </td>
                             <td>
                               
                                
                            </td>
                        </tr>                                
                    </tbody>
                </table>


                </template>

                <template  v-else-if="cuentacampo==1">
                    <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                           
                            <th>Nombre del banco</th>
                            <th>Numero de cuenta</th>
                            <th>Moneda</th>
                            <th>Ingreso</th>
                            <th>Egreso</th>
                            <th>Saldo</th>
                            <th>Ultimo Mov</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="categoria in arrayCategoria" :key="categoria.id">
                           
                            <td v-text="categoria.banco"></td>
                            <td v-text="categoria.cuenta"></td>
                            <td v-text="categoria.moneda"></td>
                            <td v-text="categoria.ingreso"></td>
                            <td v-text="categoria.egreso"></td>
                            <td v-text="categoria.saldo"></td>
                            <td v-text="categoria.updated_at"> </td>
                             <td>
                               
                                
                            </td>
                        </tr>                                
                    </tbody>
                </table>
                    
                </template>
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
                       
                         <div class="form-group row">
                            <label class="col-md-2 form-control-label" for="email-input">Importe</label>
                            <div class="col-md-4">
                                <input type="email" v-model="importe" class="form-control" placeholder="Ingrese importe">
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
        saldobanco:0.0,
        concepto:'',
        picked:0,
        importe:0.0,
        tiposCuenta_id: 0,
        monedas_id: 0,
        noCuenta : '',
        domicilioBanco : '',
        telefonoBanco : '',
        nombreEjecutivo : '',
        emailEjecutivo : '',
        telefonoEjecutivo : '',
        arrayCategoria : [],
        cuentacampo:0,
        modal : 0,
        tituloModal : '',
        tipoAccion : 0,
        errorCategoria : 0,
        arrayBancos : [],
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

    }
},
methods : {
    listarCategoria (page,buscar,criterio,cuenta){
        let me=this;
        if(cuenta==0){
            me.cuentacampo=0;
        } else {
            me.cuentacampo=1;
        } 
        var url= 'saldos?page=' + page + '&finicio='+ buscar + '&ffinal='+ criterio + '&idcuenta='+ cuenta;
        axios.get(url).then(function (response) {
            var respuesta= response.data;
            console.log(respuesta);
            me.arrayCategoria = respuesta.bancos.data;
            me.saldo = respuesta.saldo;
            me.saldobanco = respuesta.saldobanco;
            me.pagination= respuesta.pagination;
        })
        .catch(function (error) {
            console.log(error);
        });
    },
     formatPrice(value) {
let val = (value/1).toFixed(2).replace('.', ',')
return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
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

        axios.post('caja/registrar',{
            'fecha': this.fecha,
            'concepto': this.concepto,
            'importe': this.importe,
            'ingreso': this.picked
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
        title: 'Esta seguro de desactivar esta categoría?',
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

            axios.put('categoria/desactivar',{
                'id': id
            }).then(function (response) {
                me.listarCategoria(1,'','nombre');
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
        this.tituloModal='';
        this.fecha='';
        this.concepto='';
        this.importe=0;
        this.picked=0;
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
    this.listarCategoria(1,this.buscar,this.criterio,0);
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
