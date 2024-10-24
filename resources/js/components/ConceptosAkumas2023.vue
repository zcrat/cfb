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
                <i class="fa fa-align-justify"></i> Conceptos Akumas 2023
                <button type="submit" @click="importar()" class="btn btn-warning float-right"><i class="icon-doc"></i> Importar</button>
                <button type="submit" @click="exportar()" class="btn btn-success float-right"><i class="icon-doc"></i> Exportar</button>
                
            </div>
            <div class="card-body">
                <div class="form-group row">
                            <div class="col-md-3">
                                 <select class="form-control" v-model="categorias_id" >
                                                <option value="0" disabled>Categoria</option>
                                                <option v-for="categoria in arrayCategorias" :key="categoria.id" :value="categoria.id" v-text="categoria.titulo"></option>
                                 </select>
                             </div>
                             <div class="col-md-3">
                                 <select class="form-control" v-model="tipos_id" >
                                                <option value="0" disabled>Tipo Vehiculo</option>
                                                <option v-for="tipo in arrayTipos" :key="tipo.id" :value="tipo.id" v-text="tipo.tipo"></option>
                                 </select>
                             </div>    


                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="text" v-model="buscar" @keyup.enter="listarCategoria(1,buscar,criterio, categorias_id, tipos_id)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarCategoria(1,buscar,criterio, categorias_id, tipos_id)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                </div>
               
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>Categoria</th>
                            <th>Tipo</th>
                            <th>Num</th>
                            <th>Descripcion</th>
                            <th>Total</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="categoria in arrayCategoria" :key="categoria.id">
                            <td>
                                <button type="button" @click="abrirModal('categoria','actualizar',categoria)" class="btn btn-warning btn-sm">
                                  <i class="icon-pencil"></i>
                                </button> &nbsp;
                               
                                    <button type="button" class="btn btn-danger btn-sm" @click="desactivarCategoria(categoria.id)">
                                        <i class="icon-trash"></i>
                                    </button>
                               
                               
                            </td>
                            <td v-text="categoria.categoria"></td>
                            <td v-text="categoria.tipo"></td>
                            <td v-text="categoria.num"></td>
                            <td v-text="categoria.descripcion"></td>
                            <td v-text="categoria.p_total"></td>
                            <td>
                                
                                    <span class="badge badge-success">Activo</span>
                    
                                
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
                
                <div class="row">
                <div class="col-12 col-md-4">
                <div class="form-group">
                <label for="">Categoria</label>
                <div class="col-12">
                <select class="form-control" v-model="arrayProducto.categorias_id" >
                                <option value="0" disabled>Seleccione Categoria</option>
                                <option v-for="categoria in arrayCategorias" :key="categoria.id" :value="categoria.id" v-text="categoria.titulo"></option>
                </select>
                </div>
             
                </div>
                </div>

                <div class="col-12 col-md-4">
                <div class="form-group">
                <label for="">Tipos</label>
                <div class="col-12">
                <select class="form-control" v-model="arrayProducto.tipos_id" >
                                <option value="0" disabled>Seleccione Tipo</option>
                                <option v-for="tipo in arrayTipos" :key="tipo.id" :value="tipo.id" v-text="tipo.tipo"></option>
                </select>
                </div>
               
                </div>
                </div>

                <div class="col-12 col-md-4">
                <div class="form-group">
                <label for="">Código</label>
                <input type="text" v-model="arrayProducto.codigo" class="form-control">
                </div>
                </div>

                </div>

                <div class="row">
                                       
                <div class="col-12 col-md-8">
                <div class="form-group">
                <label for="">Descripcion</label>
                <textarea v-model="arrayProducto.descripcion" cols="30" rows="3" class="form-control"></textarea>
                </div>
                </div>

                <div class="col-12 col-md-4">
                <div class="form-group">
                <label for="">Tiempo</label>
                <input type="text" v-model="arrayProducto.tiempo" class="form-control">
                </div>
                </div>

                </div>


                <div class="row">

                <div class="col-12 col-md-4">
                <div class="form-group">
                <label for="">P. Refaccion</label>
                <input type="text" v-model="arrayProducto.p_refaccion" class="form-control">
                </div>
                </div>
                                     
                <div class="col-12 col-md-4">
                <div class="form-group">
                <label for="">P. M.O.</label>
                <input type="text" v-model="arrayProducto.p_mo" class="form-control">
                </div>
                </div>

                <div class="col-12 col-md-4">
                <div class="form-group">
                <label for="">P. Total</label>
                <input type="text" v-model="arrayProducto.p_total" class="form-control">
                </div>
                </div>

                </div>


                                       <div class="row">

                                       <div class="col-12 col-md-3">
                                       <div class="form-group">
                                       <label for="">Codigo SAT.</label>
                                       <input type="text" v-model="arrayProducto.codigo_sat" class="form-control">
                                       </div>
                                       </div>

                                       

                                       <div class="col-12 col-md-3">
                                       <div class="form-group">
                                       <label for="">Codigo Unidad</label>
                                       <input type="text" v-model="arrayProducto.unidad_sat" class="form-control">
                                       </div>
                                       </div>
                                                   
                                   
                                       <div class="col-12 col-md-4">
                                       <div class="form-group">
                                       <label for="">Unidad</label>
                                       <input type="text" v-model="arrayProducto.unidad" class="form-control">
                                       </div>
                                       </div>

                                       <div id="formularios">
                                       </div>

                                       </div>





                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                    <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarCategoria()">Actualizar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->

     <!--Inicio del modal agregar/actualizar-->
     <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal1}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-text="tituloModal"></h4>
                    <button type="button" class="close" @click="cerrarModal1()" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                <div class="content">
                <div class="row">
                    <div class="form-group row">
                                                <label class="col-md-3 form-control-label" for="folio-id">Archivo</label>
                                                <input type="file" class="form-control"  v-on:change="archivoChanged" >
                    </div>
                </div>
             
            </div>
              

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal1()">Cerrar</button>
                    <button type="button" v-if="modal1==1" class="btn btn-primary" @click="importartoExel()">Importar</button>
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
        nombre : '',
        categorias_id:0,
        tipos_id:0,
        descripcion : '',
        arrayCategoria : [],
        arrayCategorias : [],
        arrayProducto : [],
        arrayTipos:[],
        modal : 0,
        modal1 : 0,
        archivo:'',
        tituloModal : '',
        tipoAccion : 0,
        errorCategoria : 0,
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
    archivoChanged(e){

            console.log(e.target.files[0]);
            this.archivo = e.target.files[0];


        },
    listarCategoria (page,buscar,criterio,categoria_id,tipo_id){
        let me=this;
        var url= 'conceptosAkumas2023?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio + '&categoria_id='+ categoria_id+ '&tipo_id='+ tipo_id;
        axios.get(url).then(function (response) {
            var respuesta= response.data;
            me.arrayCategoria = respuesta.conceptos.data;
            me.arrayCategorias = respuesta.categorias;
            me.arrayTipos = respuesta.tipos;
            me.pagination = respuesta.pagination;
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
        me.listarCategoria(page,buscar,criterio);
    },
    actualizarCategoria(){
        let me = this;

        axios.put('conceptosAkumas2023/actualizar',{
            'pCFECategorias_id':this.arrayProducto.categorias_id,
            'pCFETipos_id':this.arrayProducto.tipos_id,
            'num':this.arrayProducto.codigo,
            'descripcion':this.arrayProducto.descripcion,
            'p_refaccion':this.arrayProducto.p_refaccion,
            'tiempo':this.arrayProducto.tiempo,
            'p_mo':this.arrayProducto.p_mo,
            'p_total':this.arrayProducto.p_total,
            'codigo_sat':this.arrayProducto.codigo_sat,
            'codigo_unidad':this.arrayProducto.unidad_sat,
            'unidad_text':this.arrayProducto.unidad,
            'id': this.categoria_id
        }).then(function (response) {
            console.log(response);
            me.cerrarModal();
            me.listarCategoria(1,'','nombre');
            me.$toastr.success('Se guardo correctamente', 'Datos de Concepto');
        }).catch(function (error) {
            console.log(error);
        }); 
    },
    desactivarCategoria(id){
       swal({
        title: 'Esta seguro de eliminar esta tipo?',
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

            axios.post('conceptosAkumas2023/desactivar',{
                'id': id
            }).then(function (response) {
                me.listarCategoria(1,'','nombre');
                swal(
                'Desactivado!',
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

            axios.put('tiposCFE/activar',{
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

        if (!this.nombre) this.errorMostrarMsjCategoria.push("El nombre del tipo no puede estar vacío.");

        if (this.errorMostrarMsjCategoria.length) this.errorCategoria = 1;

        return this.errorCategoria;
    },
    cerrarModal(){
        this.modal=0;
        this.tituloModal='';
        this.nombre='';
        this.descripcion='';
    },
    cerrarModal1(){
        this.modal1=0;
    },
    exportar(){
                let me=this;
                window.open('conceptosAkumas2023/exportar','_blank');
            },
    importar(){
            let me=this;
            this.modal1 = 1;    
    },
    importartoExel(){
            let me=this;
            const config = {
                    headers: { 'content-type': 'multipart/form-data' }
            }
    
            let formData = new FormData();
            formData.append('file', this.archivo);
            console.log(formData);
            axios.post('conceptosAkumas2023/exelarchivo',formData, config).then(function (response) {
                console.log(response.data);
                me.modal1=0;
                me.$toastr.success('Se exporto correctamente', 'Datos de Concepto');
            }).catch(function (error) {
                console.log(error);
            });
            },
    abrirModal(modelo, accion, data = []){
        switch(modelo){
            case "categoria":
            {
                switch(accion){
                    case 'registrar':
                    {
                        this.modal = 1;
                        this.tituloModal = 'Registrar Concepto';
                        this.nombre= '';
                        this.tipoAccion = 1;
                        break;
                    }
                    case 'actualizar':
                    {
                        //console.log(data);
                        this.modal=1;
                        this.tituloModal='Actualizar Concepto';
                        this.tipoAccion=2;

                        this.categoria_id = data['id'];
                        this.arrayProducto.categorias_id=data['pCategorias_id'];
                        this.arrayProducto.tipos_id = data['pTipos_id'];
                        this.arrayProducto.codigo = data['num'];

                        this.arrayProducto.descripcion = data['descripcion'];
                        this.arrayProducto.p_refaccion = data['p_refaccion'];
                        
                        this.arrayProducto.tiempo = data['tiempo'];
                        this.arrayProducto.p_mo = data['p_mo'];

                        this.arrayProducto.p_total = data['p_total'];
                        this.arrayProducto.codigo_sat = data['codigo_sat'];
                        this.arrayProducto.unidad_sat = data['codigo_unidad'];
                        this.arrayProducto.unidad = data['unidad_text'];

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
.div-error{
display: flex;
justify-content: center;
}
.text-error{
color: red !important;
font-weight: bold;
}
</style>
