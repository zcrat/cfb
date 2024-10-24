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
                        <i class="fa fa-align-justify"></i> Productos & Servicios 
                        <button type="button" @click="abrirModal('articulo','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                         <button type="button" @click="cargarPdf()" class="btn btn-info">
                            <i class="icon-doc"></i>&nbsp;Reporte
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="descripcion">Descripción</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarArticulo(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarArticulo(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Categoría</th>
                                    <th>Descripción</th>
                                     <th>Stock</th>
                                    <th>Precio Costo</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="articulo in arrayArticulo" :key="articulo.id">
                                    <td>
                                        <button type="button" @click="abrirModal('articulo','actualizar',articulo)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="articulo.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarArticulo(articulo.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarArticulo(articulo.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                 
                                    <td v-text="articulo.categoria"></td>
                                      <td v-text="articulo.strdescripcion"></td>
                                      <td v-text="articulo.cantidad"></td>
                                    <td v-text="articulo.intprecio"></td>
                                    
                                  
                                    <td>
                                        <div v-if="articulo.condicion">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                        
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
                                    <label class="col-md-3 form-control-label" for="text-input">Categoría</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="idcategoria">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="categoria in arrayCategoria" :key="categoria.id" :value="categoria.id" v-text="categoria.nombre"></option>
                                        </select>                                        
                                    </div>
                                </div>
                               
                                  <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Código Sat</label>
                                    <div class="col-md-6">
                                        <input type="text" v-model="codigo_sat" class="form-control" placeholder="Código Sat"> 
                                                     
                                    </div>
                                     <div class="col-md-3">
                                          <button type="button" class="btn btn-primary" @click="abrirmodalcodes"> 
                                            Consultar</button>    
                                     </div>
                                </div>

                                  <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Unidad Sat</label>
                                    <div class="col-md-6">
                                        <input type="text" v-model="unidad_sat" class="form-control" placeholder="Unidad Sat"> 
                    
                                    </div>
                                     <div class="col-md-3">

                                    <button type="button" class="btn btn-primary" @click="abrirmodalunidades">
                                        Consultar</button>
                                     </div>
                                </div>

                                  <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Unidad</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="unidad" class="form-control" placeholder="Unidad"> 
                    
                                    </div>
                                </div>

                                                                
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Código</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="codigo" class="form-control" placeholder="Código de barras"> 
                                        <barcode :value="codigo" :options="{ format: 'EAN-13' }">
                                            Generando código de barras.    
                                        </barcode>                                       
                                    </div>
                                </div>
                               
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Precio Costo</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="precio_venta" class="form-control" placeholder="">                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Stock</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="stock" class="form-control" placeholder="">                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Descripción</label>
                                    <div class="col-md-9">
                                        <textarea class="form-control" v-model="descripcion"  rows="3" placeholder="Ingrese descripción"></textarea>
                                
                                    </div>
                                </div>
                                <div v-show="errorArticulo" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjArticulo" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarArticulo()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarArticulo()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->



<!-- Modal -->
<div class="modal fade" id="exampleModalCenter2" :class="{'mostrar' : modalcodes}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Catalogo Productos o Servicios</h5>
        <button type="button" @click="closecodemodal" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     
      <div class="modal-footer">
        <input  type="text" v-model="buscarcod" class="form-control"  placeholder="Buscar" />
        <button type="button" class="btn btn-primary" @click="cargarresultados(1,buscarcod)">Buscar</button>
        <button type="button" @click="closecodemodal" class="btn btn-secondary" data-dismiss="modal">Atras</button>
      </div>
       <div class="modal-body">
         <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>id</th>
                                    <th>Code</th>
                                    <th>Descripción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="codigo in arrayCodigos" :key="codigo.id">
                                    <td>
                                        <button type="button" @click="addandclose(codigo)" class="btn btn-success btn-sm">
                                          <i class="icon-plus"></i>&nbsp;
                                        </button> &nbsp;
                                      
                                    </td>
                                    <td v-text="codigo.id"></td>
                                    <td v-text="codigo.code"></td>
                                    <td v-text="codigo.descripcion"></td>
                                </tr>                                
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="paginationcodigos.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPaginacodigos(paginationcodigos.current_page - 1,buscarcod)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumbercodes" :key="page" :class="[page == isActivedcodes ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPaginacodigos(page,buscarcod)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="paginationcodigos.current_page < paginationcodigos.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPaginacodigos(paginationcodigos.current_page + 1,buscarcod)">Sig</a>
                                </li>
                            </ul>
                        </nav>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" :class="{'mostrar' : modalunidades}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Catalogo de Unidades</h5>
        <button type="button" @click="closeunidadmodal" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     
      <div class="modal-footer">
        <input type="text" v-model="buscarcod2" placeholder="Buscar" />
        <button type="button" class="btn btn-primary" @click="cargarresultados2(1,buscarcod2)">Buscar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Atras</button>
      </div>
       <div class="modal-body">
        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>id</th>
                                    <th>Code</th>
                                    <th>Nombre</th>
                                  
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="unidad in arrayUnidades" :key="unidad.id">
                                    <td>
                                        <button type="button" @click="addandclose2(unidad)" class="btn btn-success btn-sm">
                                          <i class="icon-plus"></i>&nbsp;
                                        </button> &nbsp;
                                      
                                    </td>
                                    <td v-text="unidad.id"></td>
                                    <td v-text="unidad.code"></td>
                                    <td v-text="unidad.nombre"></td>
                                   
                                </tr>                                
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="paginationunidades.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPaginaunidades(paginationunidades.current_page - 1,buscarcod2)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumberunidades" :key="page" :class="[page == isActivedunidades ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPaginaunidades(page,buscarcod2)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="paginationunidades.current_page < paginationunidades.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPaginaunidades(paginationunidades.current_page + 1,buscarcod2)">Sig</a>
                                </li>
                            </ul>
                        </nav>
      </div>
    </div>
  </div>
</div>



        </main>
</template>

<script>
    import VueBarcode from 'vue-barcode';
    export default {
        data (){
            return {
                articulo_id: 0,
                buscarcod:'',
                buscarcod2:'',
                idcategoria : 0,
                idgrupo : 0,
                nombre_categoria : '',
                codigo : '',
                codigo_sat : '',
                unidad_sat : '',
                unidad : '',
                nombre : '',
                precio_venta : 0,
                stock : 0,
                descripcion : '',
                arrayArticulo : [],
                arrayCodigos : [],
                arrayUnidades : [],
                modal : 0,
                modalcodes : 0,
                modalunidades : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorArticulo : 0,
                errorMostrarMsjArticulo : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                paginationcodigos : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                paginationunidades : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'nombre',
                buscar : '',
                arrayCategoria :[],
                arrayGrupos :[]
            }
        },
        components: {
        'barcode': VueBarcode
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
            isActivedcodes: function(){
                return this.paginationcodigos.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumbercodes: function() {
                if(!this.paginationcodigos.to) {
                    return [];
                }
                
                var from = this.paginationcodigos.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.paginationcodigos.last_page){
                    to = this.paginationcodigos.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;             

            },
            isActivedunidades: function(){
                return this.paginationunidades.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumberunidades: function() {
                if(!this.paginationunidades.to) {
                    return [];
                }
                
                var from = this.paginationunidades.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.paginationunidades.last_page){
                    to = this.paginationunidades.last_page;
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
            addandclose(code){

                this.modalcodes=0;
                this.codigo_sat=code.code;
                this.descripcion=code.descripcion;
             

            },
            addandclose2(code){

                this.modalunidades=0;
                this.unidad_sat=code.code;
                this.unidad=code.nombre;
             

            },
            closecodemodal(){

                this.modalcodes=0;
                          

            },
            closeunidadmodal(){

                this.modalunidades=0;
                          

            },
            abrirmodalcodes(){
                this.modalcodes = 1;
            },
            abrirmodalunidades(){
                this.modalunidades = 1;
            },
             cargarresultados(page,buscar){
                let me=this;
                var url= 'articulo/buscarcodigos?page=' + page + '&buscar='+ buscar;
                axios.get(url).then(function (response) {
                    console.log(response.data);
                    var respuesta= response.data;
                    me.arrayCodigos = respuesta.codigos.data;
                    me.paginationcodigos= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
             },
              cargarresultados2(page,buscar){
                let me=this;
                var url= 'articulo/buscarunidades?page=' + page + '&buscar='+ buscar;
                axios.get(url).then(function (response) {
                    console.log(response.data);
                    var respuesta= response.data;
                    me.arrayUnidades = respuesta.unidades.data;
                    me.paginationunidades= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
             },
            listarArticulo (page,buscar,criterio){
                let me=this;
                var url= 'productos?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    console.log(response.data);
                    var respuesta= response.data;
                    me.arrayArticulo = respuesta.articulos.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cargarPdf(){
                window.open('articulo/listarPdf','_blank');
            },
            selectCategoria(){
                let me=this;
                var url= 'categoria/selectCategoria';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayCategoria = respuesta.categorias;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectGrupos(){
                let me=this;
                var url= 'grupos/selectGrupos';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayGrupos = respuesta.categorias;
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
                me.listarArticulo(page,buscar,criterio);
            },
            cambiarPaginacodigos(page,buscar){
                let me = this;
                //Actualiza la página actual
                me.paginationcodigos.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.cargarresultados(page,buscar);
            },
            cambiarPaginaunidades(page,buscar){
                let me = this;
                //Actualiza la página actual
                me.paginationunidades.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.cargarresultados(page,buscar);
            },
            registrarArticulo(){
                if (this.validarArticulo()){
                    return;
                }
                
                let me = this;

                axios.post('productos/registrar',{
                    'idcategoria': this.idcategoria,
                    'codigo_sat': this.codigo_sat,
                    'unidad_sat': this.unidad_sat,
                    'unidad': this.unidad,
                    'codigo': this.codigo,
                    'stock': this.stock,
                    'precio_venta': this.precio_venta,
                    'descripcion': this.descripcion
                }).then(function (response) {
                    console.log(response.data);
                    me.cerrarModal();
                    me.listarArticulo(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarArticulo(){
               if (this.validarArticulo()){
                    return;
                }
                
                let me = this;

                axios.put('productos/actualizar',{
                    'idcategoria': this.idcategoria,
                    'codigo_sat': this.codigo_sat,
                    'unidad_sat': this.unidad_sat,
                    'unidad': this.unidad,
                    'codigo': this.codigo,
                    'stock': this.stock,
                    'precio_venta': this.precio_venta,
                    'descripcion': this.descripcion,
                    'id': this.articulo_id
                }).then(function (response) {
                    console.log(response.data);
                    me.cerrarModal();
                    me.listarArticulo(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            desactivarArticulo(id){
               swal({
                title: 'Esta seguro de desactivar este artículo?',
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

                    axios.put('articulo/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarArticulo(1,'','nombre');
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
            activarArticulo(id){
               swal({
                title: 'Esta seguro de activar este artículo?',
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

                    axios.put('articulo/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarArticulo(1,'','nombre');
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
            validarArticulo(){
                this.errorArticulo=0;
                this.errorMostrarMsjArticulo =[];

                if (this.idcategoria==0) this.errorMostrarMsjArticulo.push("Seleccione una categoría.");
                if (!this.stock) this.errorMostrarMsjArticulo.push("El stock del artículo debe ser un número y no puede estar vacío.");
                if (!this.precio_venta) this.errorMostrarMsjArticulo.push("El precio venta del artículo debe ser un número y no puede estar vacío.");

                if (this.errorMostrarMsjArticulo.length) this.errorArticulo = 1;

                return this.errorArticulo;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.idcategoria= 0;
                this.nombre_categoria = '';
                this.codigo = '';
                this.nombre = '';
                this.precio_venta = 0;
                this.stock = 0;
                this.descripcion = '';
		        this.errorArticulo=0;
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "articulo":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Producto & Servicio';
                                this.idcategoria=0;
                                this.nombre_categoria='';
                                this.codigo_sat='';
                                this.unidad_sat='';
                                this.unidad='';
                                this.codigo='';
                                this.nombre= '';
                                this.precio_venta=0;
                                this.stock=0;
                                this.descripcion = '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Producto & Servicio';
                                this.tipoAccion=2;
                                this.articulo_id=data['id'];
                                this.idcategoria=data['idcategoria'];
                                this.codigo_sat=data['codigosat'];
                                this.unidad_sat=data['unidadsat'];
                                this.unidad=data['unidad'];
                                this.codigo=data['strcodigo'];
                                this.stock=data['cantidad'];
                                this.precio_venta=data['intprecio'];
                                this.descripcion= data['strdescripcion'];
                                break;
                            }
                        }
                    }
                }
                this.selectCategoria();
                this.selectGrupos();
            }
        },
        mounted() {
            this.listarArticulo(1,this.buscar,this.criterio);
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
