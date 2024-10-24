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
                        <i class="fa fa-align-justify"></i> Empresas
                        <button type="button" data-toggle="modal" data-target="#empresaStore" @click="abrirModal" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                       
                    </div>
                    <div class="card-body">

                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                  
                                    <input type="text" v-model="buscar" v-on:keyup.enter="searchEmpresa" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit"  @click="searchEmpresa" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                   
                        <table class="table table-bordered table-striped table-sm">

                            <thead>
                            <tr>
                                <th>Opciones</th>
                              
                                <th>Nombre</th>
                                <th>RFC</th>
                                <th>Email</th>
                                
                                <th>Teléfono</th>
                                <th>Fecha creación</th>
                                <th>Fecha actualización</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="empresa in empresas" :key="empresa.id">
                                 <td>
                                    <!--<button class="btn btn-primary">-->
                                    <!--<i class="fas fa-eye"></i>-->
                                    <!--</button>-->
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#empresaStore"
                                            @click="edit(empresa)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm" @click="destroy(empresa)">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                               
                                <td>{{empresa.nombre}}</td>
                                <td>{{empresa.rfc}}</td>
                                <td>{{empresa.email}}</td>
                               
                                <td>{{empresa.tel_negocio}}</td>
                                <td>{{empresa.created_at}}</td>
                                <td>{{empresa.updated_at}}</td>
                               
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
            </div>
 
        <!-- Modal  - Nueva empresa-->
        <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="empresaStore"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-uppercase" id="exampleModalLongTitle">Nueva empresa (cliente)</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                @click="cerrarModal">
                            <span aria-hidden="true"><i class="fas fa-times"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" v-if="erroresValidacion !== null">
                            <ul v-for="errores in erroresValidacion">
                                <li v-for="error in errores">
                                    {{error}}
                                </li>
                            </ul>
                        </div>
                        <div class="form-group">
                            <label for="empresa-nombre">Nombre:<i
                                    class="ml-2 color-required fas fa-asterisk"></i></label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fas fa-building"></i>
                                </div>
                                <input id="empresa-nombre" class="form-control" type="text" placeholder="Ej. Akumas"
                                       v-model="empresa.nombre"
                                       v-on:keyup="validarCampos">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="empresa-rfc">R.F.C:<i
                                    class="ml-2 color-required fas fa-asterisk"></i></label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fas fa-building"></i>
                                </div>
                                <input id="empresa-rfc" class="form-control" type="text" placeholder="Ej. EUFA870518H53"
                                       v-model="empresa.rfc"
                                       v-on:keyup="validarCampos">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="empresa-logo">Logo:<i
                                    class="ml-2 color-required fas fa-asterisk"></i></label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fas fa-building"></i>
                                </div>
                                <input type="file" class="form-control" @change="imageChanged" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="empresa-email">Email:<i
                                    class="ml-2 color-required fas fa-asterisk"></i></label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fas fa-building"></i>
                                </div>
                                <input id="empresa-email" class="form-control" type="text" placeholder="Ej. designapp.mx@gmail.com"
                                       v-model="empresa.email"
                                       v-on:keyup="validarCampos">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="empresa-direccion">Dirección:<i class="ml-2 color-required fas fa-asterisk"></i></label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <input id="empresa-direccion" class="form-control" type="text"
                                       placeholder="Ej. C. PUERTO DE ACAPULCO NO. 328, COL. TINIJARO, C.P. 58337"
                                       v-model="empresa.direccion"
                                       v-on:keyup="validarCampos">
                            </div>
                        </div>
                         <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                 <label for="customer-ciudad">Ciudad:<i class="ml-2 color-required fas fa-asterisk"></i></label>
                                 <div class="input-group">
                                 <div class="input-group-addon">
                                    <i class="fas fa-map-marker-alt"></i>
                                 </div>
                                 <input id="customer-ciudad" class="form-control" type="text"
                                       placeholder="Ej. Morelia"
                                       v-model="empresa.ciudad"
                                       v-on:keyup="validarCampos">
                                 </div>
                                 </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                <label for="customer-estado">Estado:<i class="ml-2 color-required fas fa-asterisk"></i></label>
                                <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <input id="customer-estado" class="form-control" type="text"
                                       placeholder="Ej. Michoacán"
                                       v-model="empresa.estado"
                                       v-on:keyup="validarCampos">
                                </div>
                                </div>
                           </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                           <div class="form-group">
                            <label for="customer-cp">C.P.:<i class="ml-2 color-required fas fa-asterisk"></i></label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <input id="customer-cp" class="form-control" type="text"
                                       placeholder="Ej. 58000"
                                       v-model="empresa.cp"
                                       v-on:keyup="validarCampos">
                            </div>
                        </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                            <label for="customer-tel_casa">Tel Negocio:<i class="ml-2 color-required fas fa-asterisk"></i></label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <input id="customer-tel_casa" class="form-control" type="text"
                                       placeholder="Ej. 4431040746"
                                       v-model="empresa.tel_negocio"
                                       v-on:keyup="validarCampos">
                            </div>
                        </div>
                            </div>
                        </div>    


                          <div class="row">
                            <div class="col-md-6">
                                 <div class="form-group">
                            <label for="customer-tel_CASA">Tel Casa:<i class="ml-2 color-required fas fa-asterisk"></i></label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <input id="customer-tel_oficina" class="form-control" type="text"
                                       placeholder="Ej. 4431040746"
                                       v-model="empresa.tel_casa"
                                       v-on:keyup="validarCampos">
                            </div>
                            </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group">
                            <label for="customer-tel_celular">Tel Celular:<i class="ml-2 color-required fas fa-asterisk"></i></label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <input id="customer-tel_celular" class="form-control" type="text"
                                       placeholder="Ej. 4431040746"
                                       v-model="empresa.tel_celular"
                                       v-on:keyup="validarCampos">
                            </div>
                            </div>
                            </div>

                            <div class="col-12 col-lg-12">
                                           <div class="form-group">
                                                <label for="folio-id">Regimen <i class="fa fa-asterisk ml-2" aria-hidden="true"></i></label>
                                               <select class="form-control" v-model="empresa.regimen">
                                                 <option value="0" disabled>Seleccione</option>
                                                 <option v-for="regimene in arrayRegimen" :key="regimene.id" :value="regimene.id" v-text="regimene.nombre"></option>
                                              </select>
                                            </div>
                                        </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="container-fluid">
                            <div class="row text-right">
                                <div class="col-xs-12" v-if="modalGuardar">
                                    <button type="button" class="btn btn-primary" @click="store">
                                        Guardar
                                    </button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                            @click="cerrarModal">Cancelar
                                    </button>
                                </div>
                                <div class="col-xs-12" v-else>
                                    <button type="button" class="btn btn-primary" @click="update">
                                        Actualizar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
 
      
    </main>
</template>
<script>
    // import SiteUrl from './SiteComponent';

    export default {
        data() {
            return {
                url: '',
                empresa: {},
                empresas: [], //hace referencia a la lista de resultados
                buscar: '',
                erroresValidacion: null,
                modalGuardar: true, //va al formulario de registro, de lo cantrario a la actualizacion
                urlPagination: 'empresas/index',
                pagination: [],
                modal: 0,
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
                buscar : '',
                btnEnabled: false,
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
            };
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
        methods: {
            listarArticulo (page,buscar,criterio){
                let me=this;
                var url= 'empresas/index?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                
                axios.get(url).then(function (response) {
                  
                    var respuesta= response.data;
                    me.empresas = respuesta.empresas.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            imageChanged(e){

               
                var fileReader = new FileReader()
                fileReader.readAsDataURL(e.target.files[0])
                fileReader.onload = (e) => {
                    this.empresa.image = e.target.result
                }
               

            },
            doMath: function (index) {
                return index + 1
            },
            limpiarCampos() {
                let me = this;
                me.empresa.nombre = '';
                me.empresa.rfc = '';
                me.empresa.logo = '';
                me.empresa.email = '';
                me.empresa.direccion = '';
                me.empresa.ciudad = '';
                me.empresa.estado = '';
                me.empresa.cp = '';
                me.empresa.tel_negocio = '';
                me.empresa.tel_casa = '';
                me.empresa.tel_celular = '';
                me.empresa.image = '';
                me.modalGuardar = true; //default para guardar
            },
            validarCampos() {
                let me = this;
                me.btnEnabled = me.empresa.nombre && me.empresa.direccion;
            },
            abrirModal() {
                this.modal = 1;
                this.limpiarCampos();
            },
            cerrarModal() {
                this.modal = 0;
                this.limpiarCampos();
            },
          
            edit(empresa) {
                this.abrirModal();
                this.empresaupdate = empresa;
                this.empresa.id = empresa.id;
                this.empresa.nombre = empresa.nombre;
                this.empresa.rfc = empresa.rfc;
                this.empresa.logo = empresa.logo;
                this.empresa.email = empresa.email;
                this.empresa.direccion = empresa.direccion;
                this.empresa.ciudad = empresa.ciudad;
                this.empresa.estado = empresa.estado;
                this.empresa.cp = empresa.cp;
                this.empresa.tel_negocio = empresa.tel_negocio;
                this.empresa.tel_casa = empresa.tel_casa;
                this.empresa.tel_celular = empresa.tel_celular;
                this.empresa.regimen = empresa.regimen;
                this.modalGuardar = false; //cambia a estado actulizar
            },
            store() {
                let me = this;
                let status = false;
                axios.post(url + 'empresas/store', me.empresa).then(function (response) {
                    console.log(response.data);
                    //Si el guardado se realizo correctamente
                    if (response.data.estado === true) {
                       
                        me.empresas.push(response.data.empresa);
                        status = true;
                        me.limpiarCampos();
                        me.cerrarModal();
                        me.$toastr.success('Nueva empresa registrada', 'Empresas');
                    }

                })
                    .catch(function (error) {

                        //error 422 = validacion
                        if (error.response.status === 422) {
                            me.erroresValidacion = error.response.data.errors;
                            me.$toastr.warning('Valida los campos correctamente.', 'Empresas');
                        } else {
                            me.$toastr.error('Ocurrio un error, consulta con el admin', 'Error');
                        }
                    });
                if (status) {
                    me.erroresValidacion = null;
                    me.limpiarCampos();
                    //agregar elemento registrado a la lista
                }
            },
            update() {
                let me = this;
                let status = false;
              
                axios.post(url + 'empresas/update', me.empresa).then(function (response) {
                    console.log(response.data);
                   
                    //Si el guardado se realizo correctamente
                    if (response.data.estado === true) {
                        me.limpiarCampos();
                        me.cerrarModal();
                        me.listarArticulo(1,'','nombre');
                        me.erroresValidacion = null;
                        me.$toastr.success('Empresa actualizada', 'Empresas');
                    }

                })
                    .catch(function (error) {

                        //error 422 = validacion
                        if (error.response.status === 422) {
                            me.erroresValidacion = error.response.data.errors;
                            me.$toastr.warning('Valida los campos correctamente.', 'Empresas');
                        } else {
                            me.$toastr.error('Ocurrio un error, consulta con el admin', 'Error');
                        }
                    });
                if (status) {
                    me.erroresValidacion = null;
                    me.limpiarCampos();
                }
            },
            searchEmpresa() {
                let me = this;
                let status = false;
                if (!me.buscar) {
                    this.listarArticulo(1,'','nombre');
                } else {
                    axios.post(url + 'empresas/search', {busqueda: me.buscar}).then(function (response) {
                        console.log(response.data);
                        if (response.data.estado === true) {
                            me.erroresValidacion = null;
                            me.empresas = response.data.empresas;
                        }
                    })
                        .catch(function (error) {

                            //error 422 = validacion
                            if (error.response.status === 422) {
                                me.erroresValidacion = error.response.data.errors;
                                me.$toastr.warning('Valida los campos correctamente.', 'Empresas');
                            } else {
                                me.$toastr.error('Ocurrio un error, consulta con el admin', 'Error');
                            }
                        });
                }
            },
             cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarArticulo(page,buscar,criterio);
            },
            destroy(empresa) {
                let me = this;
                swal({
                    title: 'Empresas',
                    html: "¿Está seguro de eliminar la empresa " + empresa.nombre + " he información relacionada?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#AEAFAF',
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Eliminar',
                }).then(function (result) {
                    if (result.value === true) {
                        let status = false;
                        axios.post(url + 'empresas/destroy', empresa).then(function (response) {
                            //Si el guardado se realizo correctamente
                            if (response.data.estado === true) {
                                me.listarArticulo(1,'','nombre');
                                me.$toastr.success('Empresa eliminada', 'Empresas');
                            }
                        })
                            .catch(function (error) {
                                //error 422 = validacion
                                if (error.response.status === 422) {
                                    me.erroresValidacion = error.response.data.errors;
                                    me.$toastr.warning('Ucurrio un error, intenta otra vez.', 'Empresas');
                                } else {
                                    me.$toastr.error('Ocurrio un error, consulta con el admin', 'Error');
                                }
                            });
                        if (status) {
                            me.erroresValidacion = null;
                            me.limpiarCampos();
                        }
                    }

                }).catch(swal.noop);
            }
        },
        mounted() {
          
           this.listarArticulo(1,this.buscar,this.criterio);
        },
        
    }
</script>