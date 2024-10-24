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
                        <i class="fa fa-align-justify"></i> Configurar Factura
                        <button type="button" @click="abrirModal('datos','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                      
                    </div>
                    <template v-if="listado==0">

                    <div class="card-body">
                        <div class="form-group row">
                        
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Razon Social</th>
                                    <th>RFC</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="categoria in arrayPersona" :key="categoria.id">
                                    <td>
                                        <button type="button" @click="abrirModal('datos','actualizar',categoria)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                       
                                    </td>
                                    <td v-text="categoria.nombre_emisor"></td>
                                    <td v-text="categoria.rfc_emisor"></td>
                                    
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

                    </template>

                    <template v-if="listado==1">

                    <div class="card-body">
		               <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                             <div class="form-group">
            	                    <label for="rfc">RFC</label>
                                	<input type="text" name="rfc" class="form-control" v-model="rfc" value="" placeholder="RFC...">
                              </div>
                             <div class="form-group">
                                	<label for="razonsocial">Nombre o Razón Social</label>
                                	<input type="text" name="razonsocial" class="form-control"  v-model="razonsocial" value="" placeholder="Nombre o Razón Social...">
                              </div>

                               <div class="form-group">
                                	<label for="regimen">Regimen Fiscal</label>
                                	 <select class="form-control" v-model="regimen">
                                         <option value="0" disabled>Seleccione</option>
                                        <option v-for="regimene in arrayRegimen" :key="regimene.id" :value="regimene.id" v-text="regimene.nombre"></option>
                                     </select>
                              </div>
                               <div class="form-group">
                                	<label for="codigo">Lugar de Expedicion (Codigo postal)</label>
                                	<input type="text" name="codigo" class="form-control"  v-model="codigo" value="" placeholder="Codigo Postal...">
                              </div>
                              <div class="row col-md-12">
                               <div class="form-group col-md-6">
                                	<label for="serie">Serie</label>
                                	<input type="text" name="serie" class="form-control"  v-model="serie" value="" placeholder="Serie...">
                              </div>
                               <div class="form-group col-md-6">
                                	<label for="folio">Folio Inicial</label>
                                	<input type="text" name="folio" class="form-control"  v-model="folio" value="" placeholder="Folio Inicial...">
                              </div>
                              </div>

                               <div class="form-group">
                                	<label for="n_certificado">No Certificado:(Automatico)</label>
                                	<input type="text" name="n_certificado" class="form-control"  v-model="n_certificado" value="" placeholder="Numero de Certificado...">
                              </div>
                               <div class="form-group">
                                	<label for="clave_key">Clave Privada:</label>
                                	<input type="text" name="clave_key" class="form-control"  v-model="clave_key" value="" placeholder="Clave key...">
                              </div>

                                <div class="row col-md-12">
                               <div class="form-group col-md-6">
                                	<label for="archivo_cer">Archivo Cer</label>
                                	<input type="text" name="serie" class="form-control"  v-model="archivo_cer" value="" placeholder="Seleccione un Archivo">
                              </div>
                               <div class="form-group col-md-6">
                                	<label for="archivo_cer">Seleccione un Archivo:</label>
                                	<input type="file" name="archivo_cer"  class="form-control" @change="cerChanged" >
                              </div>
                               </div>

                                 <div class="row col-md-12">
                               <div class="form-group col-md-6">
                                	<label for="archivo_key">Archivo Key</label>
                                	<input type="text" name="serie" class="form-control"  v-model="archivo_key" value="" placeholder="Seleccione un Archivo">
                              </div>
                               <div class="form-group col-md-6">
                                	<label for="archivo_key">Selecciona un Archivo:</label>
                                	<input type="file" name="archivo_key" class="form-control" @change="keyChanged">
                              </div>
                                 </div>
                         
                              
                              

                                    
                              <div v-show="errorArticulo" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjArticulo" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>
                             <div class="form-group">
                                  <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                                  <button v-if="tipoAccion==2" type="button" class="btn btn-primary" @click="actualizarConfig()">Actualizar</button>
                                  <button v-if="tipoAccion==1" type="button" class="btn btn-primary" @click="registrarConfig()">Guardar</button>
                              </div>
                      </form>
				</div>
                </template>
	    </div>
            </div>
 </main>
    </template>
    <script>
    export default {
         data (){
            return {
                listado:0,
                datos_id:0,
                rfc: '',
                razonsocial: '',
                regimen: 0,
                codigo: '',
                serie: '',
                folio: '',
                n_certificado: '',
                clave_key: '',
                archivo_cer:'',
                archivo_key:'',
                archivo_cerc:'',
                archivo_keyc:'',
                arrayPersona:[],
                errorArticulo : 0,
                errorMostrarMsjArticulo : [],
                arrayRegimen: [

                       { id : '601', nombre: '601 - General de Ley Personas Morales'},
                       { id : '603', nombre: '603 - Personas Morales con Fines no Lucrativos'},
                       { id : '605', nombre: '605 - Sueldos y Salarios e Ingresos Asimilados a Salarios'},
                       { id : '606', nombre: '606 - Arrendamiento'},
                       { id : '607', nombre: '607 - Régimen de Enajenación o Adquisición de Bienes'},
                       { id : '608', nombre: '608 - Demas Ingresos'},
                       { id : '609', nombre: '609 - Consolidación'},
                       { id : '610', nombre: '610 - Residentes en el Estranjero sin Establecimiento Permanente en Mexico'},
                       { id : '611', nombre: '611 - Ingresos por Dividendos (Socios y Accionistas)'},
                       { id : '612', nombre: '612 - Personas Fisicas con Actividades Empresariales y Profesionales'},
                       { id : '614', nombre: '614 - Ingresos por Intereses'},
                       { id : '615', nombre: '615 - Régimen de los ingresos por obtención de premios'},
                       { id : '616', nombre: '616 - Sin Obligaciones Fiscales '},
                       { id : '620', nombre: '620 - Sociedades Cooperativas de Producción que optan por diferir sus ingresos'},
                       { id : '621', nombre: '621 - Incorporacion Fiscal'},
                       { id : '622', nombre: '622 - Actividades Agricolas, Ganaderas, Silvicolas y Pesqueras'},
                       { id : '623', nombre: '623 - Opcional para Grupos de Sociedades'},
                       { id : '624', nombre: '624 - Coordinados'},
                       { id : '625', nombre: '625 - Régimen de las Actividades Empresariales con ingresos a través de Plataformas Tecnológicas'},
                       { id : '626', nombre: '626 - Régimen Simplificado de Confianza'},
                       { id : '628', nombre: '628 - Hidrocarburos'},
                       { id : '629', nombre: '629 - De los Regimenes Fiscales Preferentes y de las Empresas Multinacionales'},
                       { id : '630', nombre: '630 - Enajenacion de acciones en bolsa de valores'},           
                ],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                criterio : 'nombre',
                buscar : ''
               
            }

         },
         mounted(){
          var vm = this;
          this.listarEmisores(1,this.buscar,this.criterio);
           axios.put('config-factura',{
                    'id': '1'
                }).then(function (response) {
                    vm.rfc = response.data.emisor.rfc_emisor;
                    vm.razonsocial = response.data.emisor.nombre_emisor;
                    vm.regimen = response.data.emisor.regimen_emisor;
                    vm.codigo = response.data.emisor.codigo_emisor;
                    vm.serie = response.data.emisor.serie_factura;
                    vm.folio = response.data.emisor.folio_factura;
                    vm.n_certificado = response.data.emisor.n_certificado;
                    vm.clave_key = response.data.emisor.clave_key;
                    vm.archivo_cer = response.data.emisor.archivo_cer;
                    vm.archivo_key = response.data.emisor.archivo_key;
                  
                }).catch(function (error) {
                    console.log(error);
                }); 
         },
         methods : {
            listarEmisores (page,buscar,criterio){
                let me=this;
                var url= 'emisores?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayPersona = respuesta.emisores.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cerChanged(e){

               
                var fileReader = new FileReader()
                fileReader.readAsDataURL(e.target.files[0])
                fileReader.onload = (e) => {
                    this.archivo_cerc= e.target.result;
                }

                },
                keyChanged(e){

               
                var fileReader = new FileReader()
                fileReader.readAsDataURL(e.target.files[0])
                fileReader.onload = (e) => {
                    this.archivo_keyc= e.target.result
                }

                },
            actualizarConfig(){
               if (this.validarConfig()){
                    return;
                }
                
                let me = this;

                axios.put('config-factura/actualizar',{
                    'rfc': this.rfc,
                    'razonsocial': this.razonsocial,
                    'regimen': this.regimen,
                    'codigo': this.codigo,
                    'serie': this.serie,
                    'folio': this.folio,
                    'n_certificado': this.n_certificado,
                    'clave_key': this.clave_key,
                    'archivo_cer': this.archivo_cer,
                    'archivo_key': this.archivo_key,
                    'archivo_cerc': this.archivo_cerc,
                    'archivo_keyc': this.archivo_keyc,
                    'id': this.datos_id
                }).then(function (response) {
                    console.log(response.data);
                    var respuesta  = response.data.articulo;
                    me.rfc = respuesta.rfc_emisor;
                    me.razonsocial = respuesta.nombre_emisor;
                    me.regimen = respuesta.regimen_emisor;
                    me.codigo = respuesta.codigo_emisor;
                    me. serie = respuesta.serie_factura;
                    me. folio = respuesta.folio_factura;
                    me.n_certificado = respuesta.n_certificado;
                    me.clave_key = respuesta.clave_key;
                     me.archivo_cer = respuesta.archivo_cer;
                      me.archivo_key = respuesta.archivo_key;
                     me.$toastr.success('Se guardo correctamente', 'Datos de Factura');
                    
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            registrarConfig(){
               if (this.validarConfig()){
                    return;
                }
                
                let me = this;

                axios.put('config-factura/registrar',{
                    'rfc': this.rfc,
                    'razonsocial': this.razonsocial,
                    'regimen': this.regimen,
                    'codigo': this.codigo,
                    'serie': this.serie,
                    'folio': this.folio,
                    'n_certificado': this.n_certificado,
                    'clave_key': this.clave_key,
                    'archivo_cer': this.archivo_cer,
                    'archivo_key': this.archivo_key,
                    'archivo_cerc': this.archivo_cerc,
                    'archivo_keyc': this.archivo_keyc,
                }).then(function (response) {
                    console.log(response.data);
                    var respuesta  = response.data.estado;
                    if(respuesta == true){
                        me.listado = 0;
                        me.$toastr.success('Se regisgtro correctamente', 'Datos de Factura');
                        me.listarEmisores(1,me.buscar,me.criterio);
                    }
                    
                    
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            cerrarModal(){
                this.listado=0;

            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "datos":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.listado = 1;
                                this.tituloModal = 'Registrar Cuenta';
                                this.rfc= '';
                                this.razonsocial = '';
                                this.regimen = 0;
                                this.codigo = '';
                                this.serie = '';
                                this.folio = '';
                                this.n_certificado = '';
                                this.clave_key = '';
                                this.archivo_cer = '';
                                this.archivo_key = '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.listado=1;
                                this.tituloModal='Actualizar Cuenta';
                                this.tipoAccion=2;
                                
                                this.datos_id=data['id'];
                                this.rfc = data['rfc_emisor'];
                                this.razonsocial = data['nombre_emisor'];
                                this.regimen = data['regimen_emisor'];
                                this.codigo = data['codigo_emisor'];
                                this. serie = data['serie_factura'];
                                this. folio = data['folio_factura'];
                                this.n_certificado = data['n_certificado'];
                                this.clave_key = data['clave_key'];
                                this.archivo_cer = data['archivo_cer'];
                                this.archivo_key = data['archivo_key'];

                               
                                break;
                            }
                        }
                    }
                }
            },
            validarConfig(){
                this.errorArticulo=0;
                this.errorMostrarMsjArticulo =[];

                if (this.rfc==0) this.errorMostrarMsjArticulo.push("Ingrese su Rfc.");
               
                if (this.errorMostrarMsjArticulo.length) this.errorArticulo = 1;

                return this.errorArticulo;
            },

         }

    }
    </script>