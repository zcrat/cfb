<template>
    <main class="main">
      <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
          <div class="card-header">
            <i class="fa fa-align-justify mr-2"></i> Hoja de Conceptos Akumas Eco
         
          </div>
  
          <!-- Listado de recepciones vehiculaes-->
          <template v-if="registrarRecepcion == 0">
            <div class="card-body">
              <div class="form-group">
                <div class="col-12 col-md-6 offset-md-3">
                  <div class="text-center">
                    <div class="input-group">
                      <input
                        type="text"
                        v-model="buscar"
                        @keyup.enter="listarIngreso(1,buscar,criterio)"
                        class="form-control"
                        placeholder="Buscar..."
                      />
                      <button
                        type="submit"
                        @click="listarIngreso(1,buscar,criterio)"
                        class="btn btn-primary"
                      >
                        <i class="fa fa-search"></i> Buscar
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-sm">
                  <thead>
                    <tr>
                      <th>Orden seguimiento</th>
                      <th>Folio</th>
                      <th>Empresa</th>
                      <th>Vehículo</th>
                      <th>Fecha recepción</th>
                      <th>Fecha compromiso</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>

                 

                     
                      <tr v-for="hojaConcepto in listaHojaConcepto" :key="hojaConcepto.id">
                        <template v-if="hojaConcepto.status == 0">
                            <td v-text="hojaConcepto.orden_seguimiento"></td>
                            <td v-text="hojaConcepto.folio"></td>
                            <td v-text="hojaConcepto.empresaNombre"></td>
                            <td>{{hojaConcepto.vehiculoPlacas}} - {{hojaConcepto.vehiculoMarcaModelo}}</td>
                            <td v-text="hojaConcepto.fecha"></td>
                            <td v-text="hojaConcepto.fecha_compromiso"></td>
                            <td bgcolor="red">
                              <button class="btn btn-primary" @click="reporte(hojaConcepto.id)">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                              </button>
                              <button class="btn btn-warning" @click="edit(hojaConcepto.id)">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                              </button>
                              <button class="btn btn-danger" @click="eliminarHoja(hojaConcepto.id)">
                                <i class="fas fa-trash-alt" aria-hidden="true"></i>
                              </button>
                              <button class="btn btn-info"  v-on:click="crearOrdenCompra(hojaConcepto)">
                                                    <i class="icon-doc" aria-hidden="true"></i>
                              </button>
                            </td>
                      </template>
                      <template v-if="hojaConcepto.status == 1">
                          <td v-text="hojaConcepto.orden_seguimiento"></td>
                          <td v-text="hojaConcepto.folio"></td>
                          <td v-text="hojaConcepto.empresaNombre"></td>
                          <td>{{hojaConcepto.vehiculoPlacas}} - {{hojaConcepto.vehiculoMarcaModelo}}</td>
                          <td v-text="hojaConcepto.fecha"></td>
                          <td v-text="hojaConcepto.fecha_compromiso"></td>
                          <td bgcolor="orange">
                            <button class="btn btn-primary" @click="reporte(hojaConcepto.id)">
                              <i class="fa fa-eye" aria-hidden="true"></i>
                            </button>
                            <button class="btn btn-warning" @click="edit(hojaConcepto.id)">
                              <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </button>
                            <button class="btn btn-danger" @click="eliminarHoja(hojaConcepto.id)">
                              <i class="fas fa-trash-alt" aria-hidden="true"></i>
                            </button>
                            <button class="btn btn-info"  v-on:click="crearOrdenCompra(hojaConcepto)">
                                                  <i class="icon-doc" aria-hidden="true"></i>
                            </button>
                          </td>
                        </template>
                        <template v-if="hojaConcepto.status == 2">
                          <td v-text="hojaConcepto.orden_seguimiento"></td>
                          <td v-text="hojaConcepto.folio"></td>
                          <td v-text="hojaConcepto.empresaNombre"></td>
                          <td>{{hojaConcepto.vehiculoPlacas}} - {{hojaConcepto.vehiculoMarcaModelo}}</td>
                          <td v-text="hojaConcepto.fecha"></td>
                          <td v-text="hojaConcepto.fecha_compromiso"></td>
                          <td bgcolor="green">
                            <button class="btn btn-primary" @click="reporte(hojaConcepto.id)">
                              <i class="fa fa-eye" aria-hidden="true"></i>
                            </button>
                            <button class="btn btn-warning" @click="edit(hojaConcepto.id)">
                              <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </button>
                            <button class="btn btn-danger" @click="eliminarHoja(hojaConcepto.id)">
                              <i class="fas fa-trash-alt" aria-hidden="true"></i>
                            </button>
                            <button class="btn btn-info"  v-on:click="crearOrdenCompra(hojaConcepto)">
                                                  <i class="icon-doc" aria-hidden="true"></i>
                            </button>
                          </td>
                        </template>
                    </tr>

             

                
                  </tbody>
                </table>
              </div>
              <nav>
                <ul class="pagination">
                  <li class="page-item" v-if="pagination.current_page > 1">
                    <a
                      class="page-link"
                      href="#"
                      @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)"
                    >Ant</a>
                  </li>
                  <li
                    class="page-item"
                    v-for="page in pagesNumber"
                    :key="page"
                    :class="[page == isActived ? 'active' : '']"
                  >
                    <a
                      class="page-link"
                      href="#"
                      @click.prevent="cambiarPagina(page,buscar,criterio)"
                      v-text="page"
                    ></a>
                  </li>
                  <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                    <a
                      class="page-link"
                      href="#"
                      @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)"
                    >Sig</a>
                  </li>
                </ul>
              </nav>
            </div>
          </template>
          <!--Fin Listado-->
           
          <!--Formulario registrar actualizar-->
          <template v-if="registrarRecepcion == 1" >
              <div class="card">
                  <div class="card-body">
                      <div class="row">
                          <div class="col-md-4">
                              <div class="form-group">
                                  <label for="fechaHojaConcepto-id">
                                  Fecha:
                                  <i class="fa fa-asterisk text-secundary ml-2" ></i>
                                  </label>
                                  <div class="input-group input-group-sm mb-3">
                                    <datetime
                                        input-id="fechaHojaConcepto-id"
                                        input-class="form-control form-control-sm"
                                        type="datetime"
                                        v-model="dataHojaConceptos.hojaConceptoFecha"
                                        >
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
                      </div>
                      <div class="row" >
                        <div class="col-md-6">
                          <div class="card">
                            <div class="card-body">
                              <div class="row">              
                                <div class="col-md-6">
                                  <label for="odes">Odes</label>
                                  <input type="text" class="form-control form-control-sm" name="odes" v-model="dataRecepcion.odes" @keyup.enter="getOrdenSeguimineto" />
                                </div>
                                <div class="col-md-6">
                                  <label for="nombre">Nombre</label>
                                  <input type="text" class="form-control form-control-sm" name="nombre" v-model="dataRecepcion.nombre" />
                                </div>
                              </div>
                              <div class="row">              
                                <div class="col-md-6">
                                  <label for="economico"># Económico:</label>
                                  <input type="text" class="form-control form-control-sm" name="economico" v-model="dataRecepcion.economico" />
                                </div>
                                <div class="col-md-6">
                                  <label for="rr">R.R:</label>
                                  <input type="text" class="form-control form-control-sm" name="rr" v-model="dataHojaConceptos.rr" />
                                </div>
                              </div>
                              <div class="row">              
                                <div class="col-md-6">
                                  <label for="tecnico">Técnico</label>
                                  <input class="form-control" v-model="dataHojaConceptos.tecnico"  />
                                </div>                              

                                <div class="col-md-6">
                                  <label for="tecnico">Status</label>
                                  <select class="form-control" v-model="dataHojaConceptos.status">
                                    <option value="0">Hay pedido de refacciones</option>
                                    <option value="1">En proceso de entrega</option>
                                    <option value="2">Entregadas</option>
                                  </select>
                                </div>        
                              </div>                            
                            </div>                          
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="card">
                            <div class="card-body">
                              <div class="row">              
                                <div class="col-md-6">
                                  <label for="anio">Año:</label>
                                  <input type="text" class="form-control form-control-sm" name="anio" v-model="dataRecepcion.anio"/>
                                </div>
                                <div class="col-md-6">
                                  <label for="marcaModelo">Marca/Modelo</label>
                                  <input type="text" class="form-control form-control-sm" name="marcaModelo" v-model="dataRecepcion.marcaModelo" />
                                </div>
                              </div>
                              <div class="row">                                            
                                <div class="col-md-6">
                                  <label for="color">Color:</label>
                                  <input type="text" class="form-control form-control-sm" name="color" v-model="dataRecepcion.color" />
                                </div>
                                 <div class="col-md-6">
                                  <label for="placas">Placas:</label>
                                  <input type="text" class="form-control form-control-sm" name="placas" v-model="dataRecepcion.placas"/>
                                </div>
                              </div>
                              <div class="row">      
                                <div class="col-md-6">
                                  <label for="km">Km:</label>
                                  <input type="text" class="form-control form-control-sm" name="km" 
                                  v-model="dataRecepcion.km"/>
                                </div>
                                <div class="col-md-6">
                                  <label for="vin">Vin:</label>
                                  <input type="text" class="form-control form-control-sm" name="vin" 
                                  v-model="dataRecepcion.vin" />
                                </div>
                              </div>                            
                            </div>                          
                          </div>
                        </div>
                      </div>
                      <br>  
                  
                    
                      <div class="table-responsive">
                          <table class="table table-striped text-center" id="tablaConceptos">
                              <thead>
                                  <tr> 
                                      <th rowspan="2" scope="col"><small>N°</small></th>
                                      <th rowspan="2" scope="col"><small>REMPLAZAR</small> </th>
                                      <th rowspan="2" scope="col"><small>REPARAR</small> </th>
                                      <th rowspan="2" scope="col"><small>FECHA DE APLICACIÓN</small> </th>
                                      <th rowspan="2" scope="col"><small>DESCRIPCIÓN</small> </th>
                                      <th colspan="5" scope="col"><small>COSTOS ($)</small> </th>
                                      <th rowspan="2" scope="col"><small>ACCION</small></th>
                                  </tr>
                                  <tr>  
                                      <th width="7%"><small>PARTES</small> </th>                                  
                                      <th width="10%"><small>MANO DE OBRA</small> </th>
                                      <th width="7%"><small>SUBCONTRATO</small> </th>
                                      <th width="7%"><small>OTROS</small> </th>
                                      <th width="7%"><small>SUBTOTAL COSTOS</small> </th>
                                  </tr>
                              </thead>
                              <tbody>
                                <tr v-for="(item) of dataConceptos" :id="'item-'+item.numConcepto" :key="item.numConcepto">
                                  <template v-if="item.status == 0">
                                  <td v-text="item.numConcepto"></td>
                                  <td v-text="item.remplazar"></td>
                                  <td v-text="item.reparar"></td>
                                  <td v-text="item.fechaAplicacion"></td>
                                  <td v-text="item.descripcion"></td>
                                  <td v-text="item.costoParte"></td>
                                  <td v-text="item.costoManoObra"></td>
                                  <td v-text="item.costoSubcontratado"></td>
                                  <td v-text="item.costoOtros"></td>
                                  <td v-text="item.subTotalCostos"></td>   
                                  <td bgcolor="red"> <button class="btn btn-warning" @click="editConceptoModal(item)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button><button class="btn btn-danger" v-on:click="eliminarConcepto(item.numConcepto,item.id)"><i class="fa fa-trash"></i> </button></td>
                                  </template>      
                                  <template v-if="item.status == 1">
                                  <td v-text="item.numConcepto"></td>
                                  <td v-text="item.remplazar"></td>
                                  <td v-text="item.reparar"></td>
                                  <td v-text="item.fechaAplicacion"></td>
                                  <td v-text="item.descripcion"></td>
                                  <td v-text="item.costoParte"></td>
                                  <td v-text="item.costoManoObra"></td>
                                  <td v-text="item.costoSubcontratado"></td>
                                  <td v-text="item.costoOtros"></td>
                                  <td v-text="item.subTotalCostos"></td>   
                                  <td bgcolor="orange"> <button class="btn btn-warning" @click="editConceptoModal(item)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button><button class="btn btn-danger" v-on:click="eliminarConcepto(item.numConcepto,item.id)"><i class="fa fa-trash"></i> </button></td>
                                  </template>                             
                                  <template v-if="item.status == 2">
                                  <td v-text="item.numConcepto"></td>
                                  <td v-text="item.remplazar"></td>
                                  <td v-text="item.reparar"></td>
                                  <td v-text="item.fechaAplicacion"></td>
                                  <td v-text="item.descripcion"></td>
                                  <td v-text="item.costoParte"></td>
                                  <td v-text="item.costoManoObra"></td>
                                  <td v-text="item.costoSubcontratado"></td>
                                  <td v-text="item.costoOtros"></td>
                                  <td v-text="item.subTotalCostos"></td>   
                                  <td bgcolor="green"> <button class="btn btn-warning" @click="editConceptoModal(item)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button><button class="btn btn-danger" v-on:click="eliminarConcepto(item.numConcepto,item.id)"><i class="fa fa-trash"></i> </button></td>
                                  </template>     
                                </tr>                                                       
                              </tbody>
                              <tfoot>
                                <tr>
                                  <th colspan="5"></th>
                                  <th><small>PARTES</small></th>
                                  <th><small>MANO DE OBRA</small></th>
                                  <th><small>SSUBCONTRATADO</small></th>
                                  <th><small>OTROS</small></th>
                                  <th><small>SUBTOTAL COSTOS</small></th>
                                </tr>    
                                <tr>
                                  <td  rowspan="3" colspan="4">
                                   
                                  </td> 
                                  <td>
                                    SUBTOTAL
                                  </td>    
                                  <td>{{dataHojaConceptos.subTotalPartes}}</td>  
                                  <td>{{dataHojaConceptos.subTotalManoObra}}</td>
                                  <td>{{dataHojaConceptos.subTotalSubcontratado}}</td>
                                  <td>{{dataHojaConceptos.subTotalOtros}}</td>
                                  <td>{{dataHojaConceptos.subTotalSubtotalCostos}}</td>                    
                                </tr>
                                <tr>
                                  <td>
                                    IVA
                                  </td>
                                  <td>{{dataHojaConceptos.ivaPartes}}</td>
                                  <td>{{dataHojaConceptos.ivaManoObra}}</td>
                                  <td>{{dataHojaConceptos.ivaSubcontratado}}</td>
                                  <td>{{dataHojaConceptos.ivaOtros}}</td>
                                  <td>{{dataHojaConceptos.ivaSubtotalCostos}}</td>
                                </tr>
                                <tr>
                                  <td>TOTAL</td>
                                  <td>{{dataHojaConceptos.totalPartes}}</td>  
                                  <td>{{dataHojaConceptos.totalManoObra}}</td>
                                  <td>{{dataHojaConceptos.totalSubcontratado}}</td>
                                  <td>{{dataHojaConceptos.totalOtros}}</td>
                                  <td>{{dataHojaConceptos.totalSubtotalCostos}}</td>
                                </tr>
                              </tfoot>
                          </table>                        
                      </div>
                  </div>
                  <div class="card-footer">
                    <button class="btn btn-success" v-if="!update" v-on:click="guardarConceptos">Guardar Conceptos</button>
                    <button class="btn btn-success" v-if="update" v-on:click="updateConceptos">Actualizar</button>
                    <button class="btn btn-default"   @click="CerrarvistaRecepcionRegistrar">Cancelar</button>
                  </div>
              </div>
          </template>
          <template v-if="registrarRecepcion == 2">
            <div class="card-header">
                    <i class="fa fa-align-justify mr-2"></i> Orden de Compra
                    <button class="btn btn-default float-right"   @click="CerrarvistaRecepcionRegistrar">Cancelar</button>
                    <button class="btn btn-secondary float-right" type="button" @click="crearOrden">
                        <i class="fa fa-plus-circle mr-2"></i>Nuevo
                    </button>
                </div>
            <div class="card-body">
              <div class="form-group">
                <div class="col-12 col-md-6 offset-md-3">
                  <div class="text-center">
                    <div class="input-group">
                      <input
                        type="text"
                        v-model="buscar"
                        @keyup.enter="listarIngreso(1,buscar,criterio)"
                        class="form-control"
                        placeholder="Buscar..."
                      />
                      <button
                        type="submit"
                        @click="listarIngreso(1,buscar,criterio)"
                        class="btn btn-primary"
                      >
                        <i class="fa fa-search"></i> Buscar
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-sm">
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Orden seguimiento</th>
                      <th>Folio</th>
                      <th>Vehículo</th>
                      <th>Fecha Creacion</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>

                 

                     
                      <tr v-for="hojaConcepto in listaOrdenCompras" :key="hojaConcepto.id">
                            <td v-text="hojaConcepto.id"></td>
                            <td v-text="hojaConcepto.odes"></td>
                            <td v-text="hojaConcepto.folio"></td>
                            <td v-text="hojaConcepto.vehiculo"></td>
                            <td v-text="hojaConcepto.fecha"></td>
                            <td>
                             
                              <button class="btn btn-warning" @click="editOrden(hojaConcepto)">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                              </button> 
                            
                              <button class="btn btn-info"  v-on:click="crearPresupuesto(hojaConcepto.id)">
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
                    <a
                      class="page-link"
                      href="#"
                      @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)"
                    >Ant</a>
                  </li>
                  <li
                    class="page-item"
                    v-for="page in pagesNumber"
                    :key="page"
                    :class="[page == isActived ? 'active' : '']"
                  >
                    <a
                      class="page-link"
                      href="#"
                      @click.prevent="cambiarPagina(page,buscar,criterio)"
                      v-text="page"
                    ></a>
                  </li>
                  <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                    <a
                      class="page-link"
                      href="#"
                      @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)"
                    >Sig</a>
                  </li>
                </ul>
              </nav>
            </div>
          </template>
          <!--Fin Listado-->
          <template v-if="registrarRecepcion == 3" >
              <div class="card">
                  <div class="card-body">
                      <div class="row">
                          <div class="col-md-4">
                              <div class="form-group">
                                  <label for="fechaHojaConcepto-id">
                                  Fecha:
                                  <i class="fa fa-asterisk text-secundary ml-2" ></i>
                                  </label>
                                  <div class="input-group input-group-sm mb-3">
                                    <datetime
                                            input-id="fechaOrdenCompra"
                                            input-class="form-control form-control-sm"
                                            type="date"
                                            v-model="ordenCompra.fechaCreacion">
                                            <template slot="button-cancel">
                                                <i class="fa fa-times mr-2"></i>Cancelar
                                            </template>
                                            <template slot="button-confirm">
                                                <i class="fa fa-check-circle mr-2"></i>Aceptar
                                            </template>
                                        </datetime>
                                  </div>
                              </div>
                              <div class="form-group">
                                        <label for="horaOrdenCompra">
                                            <small>
                                                    HORA DE SERVICIO:
                                                <i class="fa fa-asterisk text-secundary ml-2" ></i>
                                            </small>
                                        </label>
                                        <datetime
                                            input-id="horaOrdenCompra"
                                            input-class="form-control form-control-sm"
                                            type="time"
                                            v-model="ordenCompra.horaCreacion"
                                        >
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
                      <div class="row" >
                        <div class="col-md-12">
                          <div class="card">
                            <div class="card-body">
                              <div class="row">              
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="para"><small>Para:</small></label>
                                        <input type="text" class="form-control form-control-sm" v-model="ordenCompra.para" name="para" id="para"/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="para"><small>Tecnico:</small></label>
                                        <input type="text" class="form-control form-control-sm" v-model="ordenCompra.tecnico" name="para" id="para"/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="para"><small>Motor:</small></label>
                                        <input type="text" class="form-control form-control-sm" v-model="ordenCompra.motor" name="para" id="para"/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="para"><small>Economico:</small></label>
                                        <input type="text" class="form-control form-control-sm" v-model="ordenCompra.economico" name="para" id="para"/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="asignadaMensajeroHora"><small>Pedido a Proveedor - Hora:</small></label>
                                        <datetime
                                            input-id="asignadaMensajeroHora"
                                            input-class="form-control form-control-sm"
                                            type="time"
                                            v-model="ordenCompra.asignadaMensajeroHora"
                                        >
                                            <template slot="button-cancel">
                                                <i class="fa fa-times mr-2"></i>Cancelar
                                            </template>
                                            <template slot="button-confirm">
                                                <i class="fa fa-check-circle mr-2"></i>Aceptar
                                            </template>
                                        </datetime>  
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="entregadaMensajeroHora"><small>Recibido Almacen - Hora:</small></label>
                                        <datetime
                                            input-id="entregadaMensajeroHora"
                                            input-class="form-control form-control-sm"
                                            type="time"
                                            v-model="ordenCompra.entregadaMensajeroHora"
                                        >
                                            <template slot="button-cancel">
                                                <i class="fa fa-times mr-2"></i>Cancelar
                                            </template>
                                            <template slot="button-confirm">
                                                <i class="fa fa-check-circle mr-2"></i>Aceptar
                                            </template>
                                        </datetime>  
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="recibidoHora"><small> Recibido Técnico - Hora:</small></label>
                                    <datetime
                                        input-id="recibidoHora"
                                        input-class="form-control form-control-sm"
                                        type="time"
                                        v-model="ordenCompra.horaRecibido"
                                    >
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
                          </div>
                        </div>
                    
                      </div>
                      <br>  
                      <template v-if="!update">
                      <div class="form-group">    
                        <div class="row"> 
                          <div class="col-md-6">
                            <div class="card">
                              <div class="card-body">
                                <div class="row">
                                  <div class="col-md-6">                              
                                    <div class="custom-control custom-radio">
                                      <input type="radio" @click="getRadio('remplazar')" class="custom-control-input" id="remplazar" name="accion" :checked="remplazar === 'remplazar'" >
                                      <label class="custom-control-label" for="remplazar">Remplazar</label>
                                    </div> 
                                  </div>
                                  <div class="col-md-6">
                                    <div class="custom-control custom-radio">
                                      <input type="radio" @click="getRadio('reparar')" class="custom-control-input" id="reparar" name="accion" :checked="reparar === 'reparar'" >
                                      <label class="custom-control-label" for="reparar">Reparar</label>
                                    </div>                               
                                  </div>
                                </div>
                                <br>
                                <div class="row">
                                  <div class="col-md-4">
                                    <label for="fechaAplicacion">Fecha de aplicación:</label>
                                    <datetime
                                        input-id="fechaAplicacion"
                                        input-class="form-control form-control-sm"
                                        type="datetime"
                                        v-model="fechaAplicacion"
                                    >
                                        <template slot="button-cancel">
                                            <i class="fa fa-times mr-2"></i>Cancelar
                                        </template>
                                        <template slot="button-confirm">
                                            <i class="fa fa-check-circle mr-2"></i>Aceptar
                                        </template>
                                    </datetime>
                                  </div>
                                  <div class="col-md-8">
                                    <label for="descripcion" >Descripción</label>                            
                                    <input type="text" 
                                      class="form-control form-control-sm" name="descripcion" id="descripcion" v-model="descripcion" disabled>
                                  </div>  
  
                                </div>

                                <div class="row">
                                 
                                  <div class="col-md-6">
                                    <label for="descripcion" >Proveedor</label>                            
                                    <input type="text" 
                                      class="form-control form-control-sm" name="descripcion" id="descripcion" v-model="proveedor" >
                                  </div>  

                                  <div class="col-md-6">
                                    <label for="descripcion" >Clave</label>                            
                                    <input type="text" 
                                      class="form-control form-control-sm" name="descripcion" id="descripcion" v-model="clave" >
                                  </div>  
  
                                </div>
                               
                              </div>
                            </div>
                          </div>                   
                          <div class="col-md-6">
                            <div class="card">
                              <div class="card-header">
                                Costos
                              </div>
                              <div class="card-body">
                                <div class="row">
                                  <div class="col-md-6">
                                    <label >Partes</label>
                                    <input type="number" class="form-control form-control-sm" v-on:change="calSubtotalCostos"  min="0" name="costoParte" id="costoParte" v-model="costoParte" >
                                  </div>
                                  <div class="col-md-6">
                                    <label>Mano de obra</label>
                                    <input type="number"  class="form-control form-control-sm" v-on:change="calSubtotalCostos"  min="0" name="costoManoObra" id="costoManoObra" v-model="costoManoObra">
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-6">
                                    <label for="costoSubcontratado">Subcontratado</label>
                                    <input type="number" class="form-control form-control-sm" v-on:change="calSubtotalCostos" min="0" name="costoSubcontratado" id="costoSubcontratado" v-model="costoSubcontratado">
                                  </div>
                                  <div class="col-md-6">
                                    <label for="costoOtros">Otros</label>
                                    <input type="number" class="form-control form-control-sm" v-on:change="calSubtotalCostos" name="costoOtros" id="costoOtros" v-model="costoOtros">
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-6">
                                    <label for="subTotalCostos">Subtotal</label>
                                    <input type="number" class="form-control form-control-sm"  min="0" name="subTotalCostos" id="subTotalCostos" v-model="subTotalCostos" disabled>
                                  </div>
                                  <div class="col-md-6">
                                    <label for="subTotalCostos">Publico</label>
                                    <input type="number" class="form-control form-control-sm"  min="0" name="subTotalCostos" id="subTotalCostos" v-model="precio_publico">
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>                        
                        </div>
                      </div>
                     
                      <button type="button" @click="agregarConceptosr1" class="btn btn-success">Agregar Concepto</button>
                      <button  type="button" class="btn btn-warning" @click="abrirModal1" > <i class="icon-plus"></i>&nbsp;AGREGAR</button>
                      <button  type="button" class="btn btn-primary" @click="abrirModal"> <i class="icon-plus"></i>&nbsp;CONCEPTOS</button>
                    </template>
                      <div class="table-responsive">
                          <table class="table table-striped text-center" id="tablaConceptos">
                              <thead>
                                  <tr> 
                                      <th rowspan="2" scope="col"><small>N°</small></th>
                                      <th rowspan="2" scope="col"><small>REMPLAZAR</small> </th>
                                      <th rowspan="2" scope="col"><small>REPARAR</small> </th>
                                      <th rowspan="2" scope="col"><small>FECHA DE APLICACIÓN</small> </th>
                                      <th rowspan="2" scope="col"><small>DESCRIPCIÓN</small> </th>
                                      <th colspan="5" scope="col"><small>COSTOS ($)</small> </th>
                                      <th rowspan="2" scope="col"><small>ACCION</small></th>
                                  </tr>
                                  <tr>  
                                      <th width="7%"><small>PARTES</small> </th>                                  
                                      <th width="10%"><small>MANO DE OBRA</small> </th>
                                      <th width="7%"><small>SUBCONTRATO</small> </th>
                                      <th width="7%"><small>OTROS</small> </th>
                                      <th width="7%"><small>SUBTOTAL COSTOS</small> </th>
                                  </tr>
                              </thead>
                              <tbody>
                                <tr v-for="(item, index) of conceptosarray" :key="item.idLocal">
                                
                                  <td v-text="item.cantidad"></td>
                                  <td v-text="item.remplazar"></td>
                                  <td v-text="item.reparar"></td>
                                  <td v-text="item.fecha_aplicacion"></td>
                                  <td v-text="item.descripcion"></td>
                                  <td v-text="item.parte"></td>
                                  <td v-text="item.mano_obra"></td>
                                  <td v-text="item.subcontratado"></td>
                                  <td v-text="item.otros"></td>
                                  <td v-text="item.precio_nuevo"></td>   
                                  <td> 
                                    <template v-if="!update">
                                    <button class="btn btn-danger" v-on:click="eliminarConcepto1(index)"><i class="fa fa-trash"></i> </button>
                                     </template>

                                     <template v-if="update">
                                  
                                     </template>
                  
                                   </td>
                                 
                                 
                                </tr>                                                       
                              </tbody>
                              <tfoot>
                            
                              </tfoot>
                          </table>                        
                      </div>
                  </div>
                  <div class="card-footer">
                    <button class="btn btn-success" v-if="!update" v-on:click="guardarOrdenCompra">Guardar Conceptos</button>
                    <button class="btn btn-success" v-if="update" v-on:click="updateOrden">Actualizar</button>
                    <button class="btn btn-default"   @click="CerrarvistaRecepcionRegistrarOrden">Cancelar</button>
                  </div>
              </div>
          </template>
          <!--End Formulario registrar actualizar-->
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
                                  <div class="col-md-6">                              
                                    <div class="custom-control custom-radio">
                                      <input type="radio" @click="getRadio1('remplazar')" class="custom-control-input" id="remplazar1" name="accion1" :checked="arrayConcepto.remplazar === 'remplazar'">
                                      <label class="custom-control-label" for="remplazar1">Remplazar</label>
                                    </div> 
                                  </div>
                                  <div class="col-md-6">
                                    <div class="custom-control custom-radio">
                                      <input type="radio" @click="getRadio1('reparar')" class="custom-control-input" id="reparar1" name="accion1"  :checked="arrayConcepto.reparar === 'reparar'" >
                                      <label class="custom-control-label" for="reparar1">Reparar</label>
                                    </div>                               
                                  </div>
                                </div>
                                <br>
  
                                <div class="row">
                                  <div class="col-md-4">
                                    <label for="fechaAplicacion">Fecha de aplicación:</label>
                                    <datetime
                                        input-id="fechaAplicacion"
                                        input-class="form-control form-control-sm"
                                        type="datetime"
                                        v-model="arrayConcepto.fechaAplicacion"
                                    >
                                        <template slot="button-cancel">
                                            <i class="fa fa-times mr-2"></i>Cancelar
                                        </template>
                                        <template slot="button-confirm">
                                            <i class="fa fa-check-circle mr-2"></i>Aceptar
                                        </template>
                                    </datetime>
                                  </div>
                                  <div class="col-md-8">
                                    <label for="descripcion" >Descripción</label>                            
                                    <input type="text" 
                                      class="form-control form-control-sm" name="descripcion" id="descripcion" v-model="arrayConcepto.descripcion" disabled>
                                  </div>  
                                </div>
           
  
  
                                <div class="row">
                                  <div class="col-md-6">
                                    <label >Partes</label>
                                    <input type="number" class="form-control form-control-sm" v-on:change="calSubtotalCostosSolo"  min="0" name="costoParte" id="costoParte" v-model="arrayConcepto.costoParte" >
                                  </div>
                                  <div class="col-md-6">
                                    <label>Mano de obra</label>
                                    <input type="number"  class="form-control form-control-sm" v-on:change="calSubtotalCostosSolo"  min="0" name="costoManoObra" id="costoManoObra" v-model="arrayConcepto.costoManoObra">
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-6">
                                    <label for="costoSubcontratado">Subcontratado</label>
                                    <input type="number" class="form-control form-control-sm" v-on:change="calSubtotalCostosSolo" min="0" name="costoSubcontratado" id="costoSubcontratado" v-model="arrayConcepto.costoSubcontratado">
                                  </div>
                                  <div class="col-md-6">
                                    <label for="costoOtros">Otros</label>
                                    <input type="number" class="form-control form-control-sm" v-on:change="calSubtotalCostosSolo" name="costoOtros" id="costoOtros" v-model="arrayConcepto.costoOtros">
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-6">
                                    <label for="subTotalCostos">Subtotal</label>
                                    <input type="number" class="form-control form-control-sm"  min="0" name="subTotalCostos" id="subTotalCostos" v-model="arrayConcepto.subTotalCostos" >
                                  </div>
                                  <div class="col-md-6">
                                    <label for="subTotalCostos">Publico</label>
                                    <input type="number" class="form-control form-control-sm"  min="0" name="subTotalCostos" id="subTotalCostos" v-model="arrayConcepto.precio_publico" >
                                  </div>
                                </div>
                                <div class="row">
                                 
                                 <div class="col-md-6">
                                   <label for="descripcion" >Proveedor</label>                            
                                   <input type="text" 
                                     class="form-control form-control-sm" name="descripcion" id="descripcion" v-model="arrayConcepto.proveedor" >
                                 </div>  

                                 <div class="col-md-6">
                                   <label for="descripcion" >Clave</label>                            
                                   <input type="text" 
                                     class="form-control form-control-sm" name="descripcion" id="descripcion" v-model="arrayConcepto.clave" >
                                 </div>  
 
                               </div>
                               <div class="row">
                               <div class="col-md-6">
                                  <label for="tecnico">Status</label>
                                  <select class="form-control" v-model="arrayConcepto.status">
                                    <option value="0">Hay pedido de refacciones</option>
                                    <option value="1">En proceso de entrega</option>
                                    <option value="2">Entregadas</option>
                                  </select>
                                </div>   
                              </div>
  
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                      <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="editConcepto()">Actualizar</button>
                  </div>
              </div>
              <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
      </div>
      <!--Fin del modal-->

      <!-- Modal -->
<div class="modal fade fade bd-example-modal-lg" id="exampleModalCenter2" :class="{'mostrar' : modal2}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" >Catalogo Productos o Servicios</h5>
<button type="button" class="close" @click="cerrarModal">
  <span aria-hidden="true">&times;</span>
</button>
</div>

<div class="modal-footer">
<select class="form-control" v-model="categorias_id" >
                                                <option value="0" disabled>Categoria</option>
                                                <option v-for="categoria in arrayCategorias" :key="categoria.id" :value="categoria.id" v-text="categoria.titulo"></option>
                                 </select>
<select class="form-control" v-model="tipos_id" >
                                                <option value="0" disabled>Tipo Vehiculo</option>
                                                <option v-for="tipo in arrayTipos" :key="tipo.id" :value="tipo.id" v-text="tipo.tipo"></option>
                                 </select>

<button type="button" class="btn btn-primary" @click="buscarConceptops('1',categorias_id,tipos_id)" >Buscar</button>
<button type="button" class="btn btn-secondary" @click="cerrarModal" >Atras</button>
</div>
<div class="modal-body">
 <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                  
                                  
                                    <th>CANTIDAD</th>
                                    <th>DESCRIPCION</th>
                                    <th>TOTAL</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody v-if="arrayConceptos.length">
                                <tr v-for="detalle in arrayConceptos" :key="detalle.id">
                                   
                                    
                                    <td><input type="text" v-model="detalle.cantidad"  size="3" value="1"></td>
                                    <td v-text="detalle.descripcion" :style="{ width: '320px' }"></td>
                                     <td><input type="text" v-model="detalle.pnuevo"  size="6" value="1"></td>
                                    <td>   <button type="button" class="btn btn-secondary btn-sm" @click="agregarConceptos(detalle)" >Seleccione</button>
                                    <button type="button" class="btn btn-danger btn-sm" @click="borrarConcepto(detalle)" ><i class="icon-trash"></i></button></td>
                                   
                                </tr>
                             
                              
                            </tbody>  
                            <tbody v-else>
                                <tr>
                                    <td colspan="4">
                                        No hay articulos agregados
                                    </td>
                                </tr>
                            </tbody>                                  
                        </table>
                        <nav>
                    <ul class="pagination">
                        <li class="page-item" v-if="pagination.current_page > 1">
                            <a class="page-link" href="#" @click.prevent="cambiarPaginaConceptos(pagination.current_page - 1,categorias_id,tipos_id)">Ant</a>
                        </li>
                        <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                            <a class="page-link" href="#" @click.prevent="cambiarPaginaConceptos(page,categorias_id,tipos_id)" v-text="page"></a>
                        </li>
                        <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                            <a class="page-link" href="#" @click.prevent="cambiarPaginaConceptos(pagination.current_page + 1,categorias_id,tipos_id)">Sig</a>
                        </li>
                    </ul>
                </nav>
                        
</div>
<div class="modal-footer">
<div class="form-group row">
                    <div class="col-md-12">
                        <button type="button" @click="cerrarModal()" class="btn btn-secondary">Cerrar</button>
                       
                    </div>
</div>


</div>
</div>
</div>
</div>


                                                      
                      

<!-- Modal -->
<div class="modal fade fade bd-example-modal-lg" id="exampleModalCenter2" :class="{'mostrar1' : modal3}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
                               <div class="modal-header">
                                 <h5 class="modal-title">Catalogo de conceptos</h5>
                                 <button type="button" class="close" @click="cerrarModal">
                                   <span aria-hidden="true">&times;</span>
                                 </button>
                               </div>
                              
                               <div class="modal-footer">

                     

                          <div class="col-12 col-md-12">

                            <v-select
                                :on-search="selectProductos"
                                label="descripcion"
                                :options="arrayProductos"
                                placeholder="Buscar Productos..."
                                :onChange="llenado(Producto)"
                                v-model="Producto">
                            </v-select>

                               

                             
                               </div>

                              
                              
                         
                                
                              
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

                                  <div class="col-12 text-center mt-2">
                                        <button class="btn btn-primary" @click="vistaCategoriasRegistrar"><i
                                                class="fa fa-plus-circle"></i>
                                        </button>
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
                                    <div class="col-12 text-center mt-2">
                                        <button class="btn btn-primary" @click="vistaTiposRegistrar"><i
                                                class="fa fa-plus-circle"></i>
                                        </button>
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

                                    <div class="row" v-if="registrarCategoria">
                                <!--Formulario nuevo cliente-->
                                <div class="col-12 border">
                                    <div class="row">
                                        <div class="col-12">
                                            <h5 class="border-bottom pt-2">Registrar Nueva Categoria</h5>
                                        </div>
                                    
                                       
                                        <div class="col-12 col-lg-4">
                                            <div class="form-group border-bottom">
                                                <label for="cliente-nuevo-nombre">Nombre<i
                                                        class="fa fa-asterisk  text-secundary ml-2"></i>
                                                </label>
                                                <input id="cliente-nuevo-nombre" type="text"
                                                       class="form-control" placeholder="Ej. Alberto"
                                                       v-model="modeloCategoria.nombre">
                                            </div>
                                        </div>
                                        
                               
                                       
                                        <div class="col-12 text-right p-3">
                                            <button class="btn btn-primary" @click="guardarCategoria"><i
                                                    class="fa fa-floppy-o mr-2"></i>Guardar
                                            </button>
                                            <button class="btn btn-secondary" @click="vistaCategoriasRegistrar"><i
                                                    class="fa fa-times mr-2"></i>Cancelar
                                            </button>
                                        </div>
                                    </div>
                                    <!--End Formulario nuevo cliente-->
                                </div>
                                <!--Formulario nuevo cliente-->
                            </div> 



                                    <div class="row" v-if="registrarTipo">
                                <!--Formulario nuevo cliente-->
                                <div class="col-12 border">
                                    <div class="row">
                                        <div class="col-12">
                                            <h5 class="border-bottom pt-2">Registrar Nuevo Tipo</h5>
                                        </div>
                                    
                                       
                                        <div class="col-12 col-lg-4">
                                            <div class="form-group border-bottom">
                                                <label for="cliente-nuevo-nombre">Nombre<i
                                                        class="fa fa-asterisk  text-secundary ml-2"></i>
                                                </label>
                                                <input id="cliente-nuevo-nombre" type="text"
                                                       class="form-control" placeholder="Ej. Alberto"
                                                       v-model="modeloTipos.nombre">
                                            </div>
                                        </div>
                                        
                               
                                       
                                        <div class="col-12 text-right p-3">
                                            <button class="btn btn-primary" @click="guardarTipo"><i
                                                    class="fa fa-floppy-o mr-2"></i>Guardar
                                            </button>
                                            <button class="btn btn-secondary" @click="vistaTiposRegistrar"><i
                                                    class="fa fa-times mr-2"></i>Cancelar
                                            </button>
                                        </div>
                                    </div>
                                    <!--End Formulario nuevo cliente-->
                                </div>
                                <!--Formulario nuevo cliente-->
                            </div> 

                                <div class="row">
                               
                                <div class="col-12 col-md-8">
                                <div class="form-group">
                                <label for="">Descripcion</label>
                                <textarea v-model="arrayProducto.descripcion1" cols="30" rows="3" class="form-control"></textarea>
                          
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
                                <input type="text" v-model="arrayProducto.p_refaccion1" class="form-control">
                                </div>
                                </div>
                              
                                <div class="col-12 col-md-4">
                                <div class="form-group">
                                <label for="">P. M.O.</label>
                                <input type="text" v-model="arrayProducto.p_mo1" class="form-control">
                                </div>
                                </div>

                                <div class="col-12 col-md-4">
                                <div class="form-group">
                                <label for="">P. Total</label>
                                <input type="text" v-model="arrayProducto.p_total1" class="form-control">
                                </div>
                                </div>

                                </div>



                                <div class="row">

                                <div class="col-12 col-md-4">
                                <div class="form-group">
                                <label for="">Codigo SAT.</label>
                                <input type="text" v-model="arrayProducto.codigo_sat" class="form-control">
                                </div>
                                </div>

                                <div class="col-12 col-md-4">
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

                                <div class="row">
                                 <div class="col-12 col-md-6">
                                    <div class="form-group">
                                         <button type="button"  class="btn btn-primary" @click="agregarConcepto(arrayProducto)" >Agregar</button>
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
  import vSelect from "vue-select";
  
  export default {
    data() {
      return {
        update:false,
        dataConceptos:{},
        concepto_id:0,
        idpresupuesto:0,
        registrarCategoria: false,
        modeloCategoria: {},
        registrarTipo: false,
        modeloTipos: {},
        categorias_id:0,
        tipos_id:0,
        arrayCategorias:[],
        arrayTipos:[],
        Producto:{},
        arrayConceptos:[],
        arrayConcepto:{},
        arrayProductos:[],
        arrayProducto:[],
        dataHojaConceptos:{
          idTecnico:'',
          idRecepcion: '',
          odes:'',
          rr:'',
          tecnico:'',
          subTotalPartes:0,
          subTotalManoObra:0,
          subTotalSubcontratado:0,
          subTotalOtros:0,
          subTotalSubtotalCostos:0,
          ivaPartes:0,
          ivaManoObra:0,
          ivaSubcontratado:0,
          ivaOtros:0,
          ivaSubtotalCostos:0,
          totalPartes:0,
          totalManoObra:0,
          totalSubcontratado:0,
          totalOtros:0,
          totalSubtotalCostos:0,
          firma:''
        },
        dataRecepcion:{
          odes:'',
          nombre:'',
          economico:'',  
          anio:'',
          marcaModelo:'',
          color:'',
          placas:'',
          km:'',
          vin:''        
        },        
        numConcepto:'',
        idArticulo:'',
        remplazar:'',
        proveedor:'',
        clave:'',
        reparar:'',
        fechaAplicacion:'',
        listaOrdenCompras: [],
        ordenCompra: {
                    fechaCreacion:'',
                    horaCreacion:'',
                    marcaModeloAnio:'',
                    folio:'',
                    para:'',
                    asignadaMensajeroHora:'',
                    entregadaMensajeroHora:'',
                    horaRecibido:'',
                    firmaRecibido:'',
                    firmaAutoriza:'',
                    hoja_concepto_id:'',
                    conceptos:[]
        },
        descripcion:'',
        cantidadParte:0,
        costoParte:0,
        idHoja:0,
        costoManoObra:0,
        costoSubcontratado:0,
        costoOtros:0,
        subTotalCostos:0,
        totalConceptos:0,
        tecnicos:{},
        articulos:{},
        //------------------------------------------------//
        erroresModeloCliente: null,
        erroresModeloColor: null,
        erroresModeloEmpresa: null,
        erroresModeloMarca: null,
        erroresModeloModelo: null,
        erroresModeloRecepcion: null,
        erroresModeloVehiculo: null,
  
        registrarRecepcion: 0,
        registrarCliente: false,
        registrarColor: false,
        registrarEmpresa: false,
        registrarMarca: false,
        registrarModelo: false,
        registrarVehiculo: false,
  
        modeloCliente: {},
        modeloColor: {},
        modeloCondicionesPintura: {},
        modeloEmpresa: {},
        modeloEquipoInventario: {},
        modeloExterioresEquipo: {},
        modeloInterioresEquipo: {},
        modeloMarca: {},
        modeloModelo: {},
        modeloRecepcion: {},
        modeloSeguro: {},
        //todo recepcion depende del vehiculo, pero en la vista se esta registrando almenos algunos campos podrian cambiarse
        modeloVehiculo: {},
  
        listaAutos: [],
        listaClientes: [],
        listaColores: [],
        listaEmpresas: [],
        listaEstadoEquipo: [],
        listaMarcas: [],
        listaModelos: [],
        listaHojaConcepto: [],
        listaTiposVehiculo: [],
        listaVehiculos: [],
  
        status: false,
        datetime: new Date(2019, 10, 11),
        ingreso_id: 0,
        idproveedor: 0,
        conceptosarray:[],
        proveedor: "",
        nombre: "",
        datosConcep: {
          subTotalCostos:0,
          totalPartes:0,
          totalOtros:0,
          totalManoObra:0,
          totalSubcontratado:0,
          precio_publico:0,
          codigo_sat:'',
          codigo_unidad:'',
          unidad_text:''
        },
        tipo_comprobante: "BOLETA",
        serie_comprobante: "",
        num_comprobante: "",
        impuesto: 0.18,
        total: 0.0,
        totalImpuesto: 0.0,
        totalParcial: 0.0,
        arrayIngreso: [],
        arrayProveedor: [],
        arrayDetalle: [],
        listado: 1,
        modal: 0,
        modal2: 0,
        modal3: 0,
        tituloModal: "",
        tipoAccion: 0,
        errorIngreso: 0,
        errorMostrarMsjIngreso: [],
        conceptosAgregados:0,
        pagination: {
          total: 0,
          current_page: 0,
          per_page: 0,
          last_page: 0,
          from: 0,
          to: 0
        },
        offset: 3,
        criterio: "num_comprobante",
        buscar: "",
        criterioA: "nombre",
        buscarA: "",
        arrayArticulo: [],
        arrayArticulo2: [],
        idarticulo: 0,
        codigo: "",
        articulo: "",
        precio: 0,
        cantidad: 0,
        codigo_sat:'',
        codigo_unidad:'',
        unidad_text:'',
        precio_publico:0,
      };
    },
    components: {
      vSelect
    },
    computed: {
      isActived: function() {
        return this.pagination.current_page;
      },
  
      //Calcula los elementos de la paginación
      pagesNumber: function() {
        if (!this.pagination.to) {
          return [];
        }
  
        var from = this.pagination.current_page - this.offset;
        if (from < 1) {
          from = 1;
        }
  
        var to = from + this.offset * 2;
        if (to >= this.pagination.last_page) {
          to = this.pagination.last_page;
        }
  
        var pagesArray = [];
        while (from <= to) {
          pagesArray.push(from);
          from++;
        }
        return pagesArray;
      },
  
      calcularTotal: function() {
        var resultado = 0.0;
        for (var i = 0; i < this.arrayDetalle.length; i++) {
          resultado =
            resultado +
            this.arrayDetalle[i].precio * this.arrayDetalle[i].cantidad;
        }
        return resultado;
      },
      
    },
    methods: {
      updateConceptos(){
        let me = this;
        axios 
          .put('hojaConceptos/'+ me.dataHojaConceptos.id,{
            dataHojaConceptos: me.dataHojaConceptos,
            dataConceptos: me.dataConceptos
          })
          .then(function(response){
            if(response.data.estado == true){
              me.$toastr.success('Se actualizo correctamente la Hoja de concepto', 'Hoja de concepto');
              me.registrarRecepcion = !me.registrarRecepcion;
              me.listarHojaConcepto();
            }
            console.log(response.data);
          })
          .catch(function(error){
            if (error.response.status && error.response.status === 422) {
              me.$toastr.warning("Valida los campos correctamente.", "Inspección");
              console.log(error.response.status);
            } else {
              me.$toastr.error("Ocurrio un error, consulta con el admin", "Error");
              console.log(error.response.data);
            }  
          });
      },
      updateOrden(){
        let me = this;
                axios
                    .put('ordenCompra/'+ me.ordenCompra.id,{
                        ordenCompra: me.ordenCompra
                    })
                    .then(function(response){
                        console.log(response.data);
                        me.$toastr.success('Se guardo correctamente la orden de compra', 'Orden de compra');
                        me.registrarRecepcion = 2;
                        me.listarOrdenCompra(me.idHoja);
                    })
                    .catch(function(error){
                        console.log(error);
                    });
      },
      guardarOrdenCompra(){
                let me = this;
                axios
                    .post('ordenCompra',{datos:me.ordenCompra,conceptos:me.conceptosarray})
                    .then(function(response){
                        console.log(response.data);
                        me.$toastr.success('Se guardo correctamente la orden de compra', 'Orden de compra');
                        me.registrarRecepcion = 2;
                        me.conceptosarray = [];
                        me.listarOrdenCompra(me.idHoja);
                    })
                    .catch(function(error){
                        console.log(error);
                    });
            },
      selectProductos(search,loading){
        let me=this;
        loading(true)
        var url= 'articulo/buscarcodigos?page=' + '1' + '&buscar='+ search;
        axios.get(url).then(function (response) {
            console.log(response.data);
            q: search
            var respuesta= response.data;
            me.arrayProducto = respuesta.codigos.data;
            loading(false)
            me.paginationcodigos= respuesta.pagination;
        })
        .catch(function (error) {
            console.log(error);
        });
    },
    llenado (p){
        let me = this;
        me.loading = true;
        console.log(p);
        me.arrayProducto.codigo_sat = p.code;
        me.arrayProducto.unidad_sat = p.unidad_sat;
        me.arrayProducto.unidad = p.unidad;
        //me.arrayProducto.descripcion = p.strdescripcion;
        me.arrayProducto.tiempo = '1.0';
        me.arrayProducto.codigo = 'FC';
    },
      eliminarHoja(id){
        swal({
        title: 'Esta seguro de eliminar esta Hoja de conceptos?',
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
            axios .delete('hojaconcepto/'+id)
            .then(function(response){
                me.listarHojaConcepto();
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
        }); 
      },
      editOrden(item){
          this.registrarRecepcion = 3;
          this.ordenCompra.id = item.id;
          this.ordenCompra.fechaCreacion = item.fecha_creada;
          this.ordenCompra.horaCreacion = item.hora_creada;
          this.ordenCompra.motor = item.motor;
          this.ordenCompra.tecnico = item.tecnico;
          this.ordenCompra.para = item.para;
          this.ordenCompra.asignadaMensajeroHora = item.asignada_mensajero_hora;
          this.ordenCompra.entregadaMensajeroHora = item.entrega_mensajero_hora;
          this.ordenCompra.horaRecibido = item.hora_firma;
          this.ordenCompra.economico = item.economico;
          this.getConceptos(item.id);

          this.update = true;
      },
      edit(ordenSeguimiento){
        this.idHoja = ordenSeguimiento;
        console.log("edit"+ordenSeguimiento);
        
        let me = this;
        
        axios
          .get('hojaConceptos/'+ordenSeguimiento+'/edit')
          .then(function(response){
            console.log(response);
            me.dataRecepcion     = response.data.ordenSeguimiento;  
            me.dataHojaConceptos = response.data.hojaConcepto;
            me.vistaRecepcionRegistrar();
            me.update = true;
            console.log(response.data);
            console.log(me.dataConceptos);
            me.conceptos(response.data.hojaConcepto.presupuesto_id);
            me.idpresupuesto = response.data.hojaConcepto.presupuesto_id;
  
  
          }).catch(function(error){
            console.log(error);
          });
      },
      conceptos(ordenSeguimiento){
        this.idHoja = ordenSeguimiento;
        let me = this;
        axios
          .get('conceptos/'+ordenSeguimiento)
          .then(function(response){
            console.log(response);
            me.dataConceptos     = response.data.conceptos;  
  
            me.dataHojaConceptos.subTotalPartes = 0;
            me.dataHojaConceptos.subTotalManoObra = 0;
            me.dataHojaConceptos.subTotalSubcontratado = 0;
            me.dataHojaConceptos.subTotalOtros = 0;
            me.dataHojaConceptos.subTotalSubtotalCostos = 0;
  
            me.dataHojaConceptos.ivaPartes = 0;
            me.dataHojaConceptos.ivaManoObra = 0;
            me.dataHojaConceptos.ivaSubcontratado = 0;
            me.dataHojaConceptos.ivaOtros = 0;
            me.dataHojaConceptos.ivaSubtotalCostos = 0;
  
            me.dataHojaConceptos.totalPartes = 0;
            me.dataHojaConceptos.totalManoObra = 0;
            me.dataHojaConceptos.totalSubcontratado = 0;
            me.dataHojaConceptos.totalOtros = 0;
            me.dataHojaConceptos.totalSubtotalCostos = 0;
  
            for (let value of Object.values(me.dataConceptos)) {
              
              //Subtotales//
              me.dataHojaConceptos.subTotalPartes += parseFloat(value.costoParte);
              me.dataHojaConceptos.subTotalManoObra += parseFloat(value.costoManoObra);
              me.dataHojaConceptos.subTotalSubcontratado += parseFloat(value.costoSubcontratado);
              me.dataHojaConceptos.subTotalOtros += parseFloat(value.costoOtros);
              me.dataHojaConceptos.subTotalSubtotalCostos += parseFloat(value.subTotalCostos);           
  
            }
            //IVA//
            me.dataHojaConceptos.ivaPartes += parseFloat(Number(me.dataHojaConceptos.subTotalPartes * 0.16).toFixed(2));
            me.dataHojaConceptos.ivaManoObra += parseFloat(Number(me.dataHojaConceptos.subTotalManoObra * 0.16).toFixed(2));
            me.dataHojaConceptos.ivaSubcontratado += parseFloat(Number(me.dataHojaConceptos.subTotalSubcontratado * 0.16).toFixed(2));
            me.dataHojaConceptos.ivaOtros += parseFloat(Number(me.dataHojaConceptos.subTotalOtros * 0.16).toFixed(2));
            me.dataHojaConceptos.ivaSubtotalCostos += parseFloat(Number(me.dataHojaConceptos.subTotalSubtotalCostos * 0.16).toFixed(2));
  
            //Totales//
            me.dataHojaConceptos.totalPartes += parseFloat(Number(me.dataHojaConceptos.subTotalPartes + me.dataHojaConceptos.ivaPartes).toFixed(2) );
            me.dataHojaConceptos.totalManoObra += parseFloat(Number(me.dataHojaConceptos.subTotalManoObra + me.dataHojaConceptos.ivaManoObra).toFixed(2));
            me.dataHojaConceptos.totalSubcontratado += parseFloat(Number(me.dataHojaConceptos.subTotalSubcontratado + me.dataHojaConceptos.ivaSubcontratado).toFixed(2));
            me.dataHojaConceptos.totalOtros += parseFloat(Number(me.dataHojaConceptos.subTotalOtros + me.dataHojaConceptos.ivaOtros).toFixed(2));
            me.dataHojaConceptos.totalSubtotalCostos += parseFloat(Number(me.dataHojaConceptos.subTotalSubtotalCostos + me.dataHojaConceptos.ivaSubtotalCostos).toFixed(2));
  
          }).catch(function(error){
            console.log(error);
          });
      },
      editConceptoModal(concepto){
       this.modal = 1;
       this.tipoAccion = 2;
       this.arrayConcepto.id = concepto.id;
       this.arrayConcepto.fechaAplicacion = concepto.fechaAplicacion;
       this.arrayConcepto.descripcion = concepto.descripcion;
       this.arrayConcepto.costoParte = concepto.costoParte;
       this.arrayConcepto.costoManoObra = concepto.costoManoObra;
       this.arrayConcepto.costoOtros = concepto.costoOtros;
       this.arrayConcepto.costoSubcontratado = concepto.costoSubcontratado;
       this.arrayConcepto.subTotalCostos = concepto.subTotalCostos;
       this.arrayConcepto.remplazar = concepto.remplazar;
       this.arrayConcepto.reparar = concepto.reparar;
       this.arrayConcepto.precio_publico = concepto.precio_publico;
       this.arrayConcepto.proveedor = concepto.proveedor;
       this.arrayConcepto.clave = concepto.clave;
       this.arrayConcepto.status = concepto.status;
      },
      cerrarModal(){
        this.modal = 0;
        this.modal2 = 0;
        this.modal3 = 0;
  
       this.arrayConcepto.id = 0;
       this.arrayConcepto.fechaAplicacion = '';
       this.arrayConcepto.descripcion = '';
       this.arrayConcepto.costoParte = '';
       this.arrayConcepto.costoManoObra = '';
       this.arrayConcepto.costoOtros = '';
       this.arrayConcepto.costoSubcontratado = '';
       this.arrayConcepto.subTotalCostos = '';
       this.arrayConcepto.remplazar = '';
       this.arrayConcepto.reparar = '';
      },
      editConcepto(){
        let me = this;
        
        axios
          .post('conceptos/update',{
            'id':  this.arrayConcepto.id,
            'num_concepto':  '1',
            'descripcion':  this.arrayConcepto.descripcion,
            'remplazar':  this.arrayConcepto.remplazar,
            'reparar':  this.arrayConcepto.reparar,
            'fecha_aplicacion':  this.arrayConcepto.fechaAplicacion,
            'partes':  this.arrayConcepto.costoParte,
            'mano_obra':  this.arrayConcepto.costoManoObra,
            'subcontratado':  this.arrayConcepto.costoSubcontratado,
            'otros':  this.arrayConcepto.costoOtros,
            'subtotal_costos':  this.arrayConcepto.subTotalCostos,
            'precio_publico':  this.arrayConcepto.precio_publico,
            'proveedor':  this.arrayConcepto.proveedor,
            'clave':  this.arrayConcepto.clave,
            'status':  this.arrayConcepto.status,
          })
          .then(function(response){
            console.log(response);
            me.$toastr.success('Se actualizo correctamente el concepto', 'Concepto');
            me.cerrarModal();
            me.conceptos(me.idHoja);
           
          }).catch(function(error){
            console.log(error);
          });
      },
      setTecnico(){
        var temp = this.dataHojaConceptos.tecnico.split('-');
        this.dataHojaConceptos.idTecnico = temp[0];
        alert(this.dataHojaConceptos.idTecnico);
      },
      calSubtotalCostos(){
          this.subTotalCostos = parseFloat(this.costoParte) + parseFloat(this.costoManoObra) + parseFloat(this.costoOtros) + parseFloat(this.costoSubcontratado);
      },
      calSubtotalCostosSolo(){
          this.arrayConcepto.subTotalCostos = parseFloat(this.arrayConcepto.costoParte) + parseFloat(this.arrayConcepto.costoManoObra) + parseFloat(this.arrayConcepto.costoOtros) + parseFloat(this.arrayConcepto.costoSubcontratado);
      },
      getRadio(value){
          if (value === 'remplazar') {
              this.remplazar = 'remplazar';
              this.reparar = '';
          }else{
              this.remplazar = '';
              this.reparar = 'reparar';
          }
      },
      abrirModal(){
        this.arrayArticulo2=[];
        this.modal2 = 1;
        this.tituloModal = 'Seleccione los articulos que desee';

      },
      abrirModal1(){
          this.arrayArticulo2=[];
          this.modal3 = 1;
          this.tituloModal = 'Seleccione los articulos que desee';

      },
      getRadio1(value){
          if (value === 'remplazar') {
              this.arrayConcepto.remplazar = 'remplazar';
              this.arrayConcepto.reparar = '';
          }else{
              this.arrayConcepto.remplazar = '';
              this.arrayConcepto.reparar = 'reparar';
          }
      },
      agregarConcepto(array){
    
        
    let me = this;

    axios.post('conceptos2023/registrar',{
        'pCFECategorias_id': array.categorias_id,
        'pCFETipos_id': array.tipos_id,
        'num': array.codigo,
        'descripcion': array.descripcion1,
        'p_refaccion': array.p_refaccion1,
        'tiempo': array.tiempo,
        'p_mo': array.p_mo1,
        'p_total': array.p_total1,
        'codigo_sat': array.codigo_sat,
        'codigo_unidad': array.unidad_sat,
        'unidad_text': array.unidad,

    }).then(function (response) {
        
        console.log(response.data);
        me.arrayProducto.categorias_id = 0;
        me.arrayProducto.tipos_id = 0;
        me.arrayProducto.codigo = '';
        me.arrayProducto.descripcion1 = '';
        me.arrayProducto.p_refaccion1 = 0.0;
        me.arrayProducto.tiempo = 0.0;
        me.arrayProducto.p_mo1 = 0.0;
        me.arrayProducto.codigo_sat = '';
        me.arrayProducto.p_total1 = 0.0;
        me.arrayProducto.unidad_sat = '';
        me.arrayProducto.unidad = '';


        me.cerrarModal();
        

    }).catch(function (error) {
        console.log(error);
    });
    },
      agregarConcepto22(){
        this.totalConceptos += 1;
        this.dataConceptos[this.totalConceptos] = {
          numConcepto:this.totalConceptos, 
          idArticulo:this.idArticulo,
          remplazar:this.remplazar, 
          reparar:this.reparar,
          fechaAplicacion:this.fechaAplicacion,
          descripcion:this.descripcion,
          costoParte:this.costoParte,
          costoManoObra:this.costoManoObra,
          costoSubcontratado:this.costoSubcontratado,
          costoOtros:this.costoOtros,
          subTotalCostos:this.subTotalCostos
        };
  
        this.dataHojaConceptos.subTotalPartes = 0;
        this.dataHojaConceptos.subTotalManoObra = 0;
        this.dataHojaConceptos.subTotalSubcontratado = 0;
        this.dataHojaConceptos.subTotalOtros = 0;
        this.dataHojaConceptos.subTotalSubtotalCostos = 0;
  
        this.dataHojaConceptos.ivaPartes = 0;
        this.dataHojaConceptos.ivaManoObra = 0;
        this.dataHojaConceptos.ivaSubcontratado = 0;
        this.dataHojaConceptos.ivaOtros = 0;
        this.dataHojaConceptos.ivaSubtotalCostos = 0;
  
        this.dataHojaConceptos.totalPartes = 0;
        this.dataHojaConceptos.totalManoObra = 0;
        this.dataHojaConceptos.totalSubcontratado = 0;
        this.dataHojaConceptos.totalOtros = 0;
        this.dataHojaConceptos.totalSubtotalCostos = 0;
  
        for (let value of Object.values(this.dataConceptos)) {
          
          //Subtotales//
          this.dataHojaConceptos.subTotalPartes += parseFloat(value.costoParte);
          this.dataHojaConceptos.subTotalManoObra += parseFloat(value.costoManoObra);
          this.dataHojaConceptos.subTotalSubcontratado += parseFloat(value.costoSubcontratado);
          this.dataHojaConceptos.subTotalOtros += parseFloat(value.costoOtros);
          this.dataHojaConceptos.subTotalSubtotalCostos += parseFloat(value.subTotalCostos);           
  
        }
        //IVA//
        this.dataHojaConceptos.ivaPartes += parseFloat(Number(this.dataHojaConceptos.subTotalPartes * 0.16).toFixed(2));
        this.dataHojaConceptos.ivaManoObra += parseFloat(Number(this.dataHojaConceptos.subTotalManoObra * 0.16).toFixed(2));
        this.dataHojaConceptos.ivaSubcontratado += parseFloat(Number(this.dataHojaConceptos.subTotalSubcontratado * 0.16).toFixed(2));
        this.dataHojaConceptos.ivaOtros += parseFloat(Number(this.dataHojaConceptos.subTotalOtros * 0.16).toFixed(2));
        this.dataHojaConceptos.ivaSubtotalCostos += parseFloat(Number(this.dataHojaConceptos.subTotalSubtotalCostos * 0.16).toFixed(2));
  
        //Totales//
        this.dataHojaConceptos.totalPartes += parseFloat(Number(this.dataHojaConceptos.subTotalPartes + this.dataHojaConceptos.ivaPartes).toFixed(2) );
        this.dataHojaConceptos.totalManoObra += parseFloat(Number(this.dataHojaConceptos.subTotalManoObra + this.dataHojaConceptos.ivaManoObra).toFixed(2));
        this.dataHojaConceptos.totalSubcontratado += parseFloat(Number(this.dataHojaConceptos.subTotalSubcontratado + this.dataHojaConceptos.ivaSubcontratado).toFixed(2));
        this.dataHojaConceptos.totalOtros += parseFloat(Number(this.dataHojaConceptos.subTotalOtros + this.dataHojaConceptos.ivaOtros).toFixed(2));
        this.dataHojaConceptos.totalSubtotalCostos += parseFloat(Number(this.dataHojaConceptos.subTotalSubtotalCostos + this.dataHojaConceptos.ivaSubtotalCostos).toFixed(2));
            
        console.log(this.dataConceptos);
  
      },
      eliminarConcepto1(index){
        let me = this;
        me.conceptosarray.splice(index, 1);
      },
      eliminarConcepto(numConcepto, id){
        console.log(numConcepto);
        delete this.dataConceptos[numConcepto];
        document.getElementById("item-"+numConcepto).remove();
        if(this.update == true && id != undefined){
          let me = this;
          axios
            .delete('concepto/'+numConcepto+'/'+id)
            .then(function(response){
              console.log(response.data);
  
            })
            .catch(function(arror){
  
            });
        }
        
        console.log(this.dataConceptos);
      },
      getConceptos(id){
        
        let me = this;
        axios
          .get("articulo/partes/get?id="+id)
          .then(function(response){
            console.log(response);
            me.conceptosarray = response.data;     
            console.log(me.conceptosarray);
  
          })
          .catch(function(response){
            console.log(response);
          });
      },
      getOrdenSeguimineto(){
        let me = this;
        axios
          .get("hojaConcepto/"+me.dataRecepcion.odes)
          .then(function(response){
            me.dataRecepcion = response.data;  
            me.dataHojaConceptos.odes = response.data.odes;  
            me.dataHojaConceptos.idRecepcion = response.data.idRecepcion;     
            console.log(me.dataRecepcion);
  
          })
          .catch(function(response){
            console.log(response);
          });
      },
      getTecnico(){
        let me = this;
        axios
          .get("tecnicos/get")
          .then(function(response){
            console.log(response.data);
            me.tecnicos = response.data;
          })
          .catch(function(response){
            console.log(response);
          });
      },
      getArticulo(){
        let me = this;
        axios
          .get("articulo/get")
          .then(function(response){
            me.articulos = response.data;
            console.log(response.data);
          })
          .catch(function(response){
            console.log(response);
          });
      },
      guardarConceptos(){
        let me = this;
        axios
          .post('conceptos/store', {
            dataHojaConceptos: me.dataHojaConceptos, 
            dataConceptos: me.dataConceptos
          })
          .then(function(response){
            if(response.data.estado == true){
              me.$toastr.success('Seguardo correctamente la Hoja de concepto', 'Hoja de concepto');
            }
            console.log(response.data);
          })
          .catch(function(error){
            if (error.response.status && error.response.status === 422) {
              me.$toastr.warning("Valida los campos correctamente.", "Inspección");
              console.log(error.response.status);
            } else {
              me.$toastr.error("Ocurrio un error, consulta con el admin", "Error");
              console.log(error.response.data);
            }  
          });
      },
      agregarConceptos(detalle){
       this.cantidad = detalle.cantidad;
       this.concepto_id = detalle.id;
       this.descripcion = detalle.descripcion;
       this.costoParte = '0';
       this.costoManoObra = '0';
       this.costoOtros = '0';
       this.costoSubcontratado = '0';
       this.subTotalCostos = detalle.pnuevo;
       this.precio_publico = detalle.p_total;
       this.cerrarModal();
       
      },
      agregarConceptosr1(){
               let me = this;
                me.totalConceptos = parseInt(me.totalConceptos)+1;
                me.conceptosAgregados = me.conceptosAgregados + 1;
                   
                me.conceptosarray.push({
                    idLocal:me.conceptosAgregados,
                    cantidad:me.cantidad,
                    presupuestoCFE_id:me.idpresupuesto,
                    pCFEConcepto_id:me.concepto_id, 
                    precio:me.precio_publico, 
                    precio_nuevo:me.subTotalCostos,
                    remplazar:me.remplazar,
                    reparar:me.reparar,
                    fecha_aplicacion:me.fechaAplicacion,
                    parte:me.costoParte,
                    mano_obra:me.costoManoObra,
                    subcontratado:me.costoSubcontratado,
                    otros:me.costoOtros,
                    proveedor:me.proveedor,
                    clave:me.clave,
                            });
                            me.cantidad=0;
                            me.concepto_id=0;
                            me.subTotalCostos='';
                            me.descuento=0;
                            me.remplazar='';
                            me.reparar='';
                            me.fechaAplicacion='';
                            me.costoParte='';
                            me.costoManoObra='';
                            me.costoSubcontratado='';
                            me.costoOtros='';
                            me.proveedor='';
                            me.clave='';
                            me.descripcion='';
                            me.precio_publico='';
                console.log(me.totalConceptos);
                console.log(me.conceptosarray);
            },
      agregarConceptosr(){
        let me = this;

        axios.post('detalleconceptos2023h/registrar',{
            'presupuestoCFE_id': this.idpresupuesto,
            'pCFEConcepto_id': this.concepto_id,
            'cantidad' :  this.cantidad,
            'precio' : this.precio_publico,
            'precio_nuevo' : this.subTotalCostos,
            'remplazar': this.remplazar,
            'reparar': this.reparar,
            'fecha_aplicacion': this.fechaAplicacion,
            'parte': this.costoParte,
            'mano_obra': this.costoManoObra,
            'subcontratado': this.costoSubcontratado,
            'otros': this.costoOtros,
            'proveedor': this.proveedor,
            'clave': this.clave,

        }).then(function (response) {
            
            console.log(response.data);
            me.cerrarModal();
            me.conceptos(me.idpresupuesto);
           

        }).catch(function (error) {
            console.log(error);
        });              
      },
      agregarConceptosFF(){
        console.log('=========================== id de la hoja ===================================');
        console.log(this.idHoja);
        let me = this;
        this.datosConcep.id = this.idHoja;
        this.datosConcep.numConcepto = '1';
        this.datosConcep.descripcion = this.descripcion;
        this.datosConcep.remplazar = this.remplazar;
        this.datosConcep.reparar = this.reparar;
        this.datosConcep.fechaAplicacion = this.fechaAplicacion;
        this.datosConcep.costoParte = this.costoParte;
        this.datosConcep.costoManoObra = this.costoManoObra;
        this.datosConcep.costoSubcontratado = this.costoSubcontratado;
        this.datosConcep.costoOtros = this.costoOtros;
        this.datosConcep.subTotalCostos = this.subTotalCostos;
        this.datosConcep.precio_publico = this.precio_publico;
        this.datosConcep.codigo_sat = this.codigo_sat;
        this.datosConcep.codigo_unidad = this.codigo_unidad;
        this.datosConcep.unidad_text = this.unidad_text;
        axios
          .post('conceptos/Agregar',{
            dataConceptos: this.datosConcep
          })
          .then(function(response){
            console.log(response.data);
            if(response.data.estado == true){
              me.conceptos(me.idHoja);
              me.$toastr.success('Se guardo correctamente el correcto', 'Concepto');
              
            }
            console.log(response.data);
          })
          .catch(function(error){
            if (error.response.status && error.response.status === 422) {
              me.$toastr.warning("Valida los campos correctamente.", "Inspección");
              console.log(error.response.status);
            } else {
              me.$toastr.error("Ocurrio un error, consulta con el admin", "Error");
              console.log(error.response.data);
            }  
          });
      },
      vistaRecepcionRegistrar() {
        this.update = false;
        this.registrarRecepcion = 1;
        this.modeloRecepcion.fecha = new Date(Date.now()).toISOString();
        this.listarEmpresas();
        this.listarClientes();
        this.listarVehiculos();
        this.listarEstadoEquipo();
      },
      CerrarvistaRecepcionRegistrar() {
        this.update = false;
        this.registrarRecepcion = 0;
        this.listarHojaConcepto();
      },
      CerrarvistaRecepcionRegistrarOrden() {
        this.update = false;
        this.registrarRecepcion = 2;
        this.listarOrdenCompra(this.idHoja);
      },
      listarHojaConcepto() {
        let me = this;
        axios
          .get("hojaConceptos/index?modulo=5")
          .then(function(response) {
            console.log(response);
            me.listaHojaConcepto = response.data.hojas;
            me.arrayCategorias = response.data.categorias;
            me.arrayTipos = response.data.tipos;
            me.arrayProductos = response.data.productos;
          })
          .catch(function(error) {
            console.log(error);
          });
      },
      listarOrdenCompra(id) {
        let me = this;
          axios
              .get("listOrdenCompra/index?id="+id)
              .then(function(response) {
                    me.listaOrdenCompras = response.data;
                    console.log(me.listaOrdenCompras);
               })
              .catch(function(response) {
                    console.log(response);
              });
      },
      crearOrdenCompra(hoja){
        this.registrarRecepcion = 2;
        this.ordenCompra.hoja_concepto_id = hoja.id;
        this.idHoja = hoja.id;
        this.idpresupuesto = hoja.presupuesto_id;
        this.listarOrdenCompra(hoja.id);
      },
      crearOrden(id){
        this.registrarRecepcion = 3;
        this.conceptosarray = [];
        this.tipoAccion = 1;
      },
      crearPresupuesto(id){
        window.open('ordenCompra/reporte/'+ id,'_blank');
      },
      guardarEmpresa() {
        let me = this;
        axios
          .post("empresas/store", me.modeloEmpresa)
          .then(function(response) {
            console.log("~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~");
            console.log(response.data);
            console.log("~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~");
            //Si el guardado se realizo correctamente
            if (response.data.estado === true) {
              me.listarEmpresas();
              me.erroresModeloEmpresa = null;
              me.modeloEmpresa = {};
              me.$toastr.success("Nueva empresa registrada", "Empresas");
              me.vistaEmpresaRegistrar();
            }
          })
          .catch(function(error) {
            //error 422 = validacion
  
            if (error.response.status && error.response.status === 422) {
              me.erroresModeloEmpresa = error.response.data.errors;
              me.$toastr.warning("Valida los campos correctamente.", "Empresas");
            } else {
              me.$toastr.error(
                "Ocurrio un error, consulta con el admin",
                "Error"
              );
            }
          });
      },
      guardarCliente() {
        let me = this;
        let modeloCliente = JSON.parse(JSON.stringify(me.$data.modeloCliente));
        if (modeloCliente.empresa_id.code === -1) {
          delete modeloCliente.empresa_id;
        } else {
          modeloCliente.empresa_id = modeloCliente.empresa_id.code;
        }
        axios
          .post("customers/store", modeloCliente)
          .then(function(response) {
            console.log(response.data);
            //Si el guardado se realizo correctamente
            if (response.data.estado === true) {
              me.$toastr.success("Nuevo cliente registrado", "Clientes");
              me.vistaRecepcionRegistrar();
              me.modeloCliente = {};
              me.erroresModeloCliente = null;
            }
          })
          .catch(function(error) {
            //error 422 = validacion
            if (error.response.status === 422) {
              me.erroresModeloCliente = error.response.data.errors;
              me.$toastr.warning("Valida los campos correctamente.", "Clientes");
            } else {
              me.$toastr.error(
                "Ocurrio un error, consulta con el admin",
                "Error"
              );
            }
          });
      },
      buscarConceptops(pagina,page,buscar){
        let me=this;
        var url= 'conceptos2023/selectConceptos?page=' + pagina +'&idc=' + page + '&idt='+ buscar;
        axios.get(url).then(function (response) {
            console.log(response.data);
            var respuesta= response.data;
            me.arrayConceptos = respuesta.conceptos.data;
            me.pagination= respuesta.pagination;
        })
        .catch(function (error) {
            console.log(error);
        });
    },
    cambiarPaginaConceptos(page,buscar,criterio){
        let me = this;
        //Actualiza la página actual
        me.pagination.current_page = page;
        //Envia la petición para visualizar la data de esa página
        me.buscarConceptops(page,buscar,criterio);
    },
      guardarColor() {
        let me = this;
        axios
          .post("colores/store", me.modeloColor)
          .then(function(response) {
            //Si el guardado se realizo correctamente
            if (response.data.estado === true) {
              me.listarColores();
              me.$toastr.success("Nuevo color registrado", "Colores");
              me.vistaColorRegistrar();
              me.modeloColor = {};
              me.erroresModeloColor = null;
            }
          })
          .catch(function(error) {
            //error 422 = validacion
            if (error.response.status === 422) {
              me.erroresModeloColor = error.response.data.errors;
              me.$toastr.warning("Valida los campos correctamente.", "Colores");
            } else {
              me.$toastr.error(
                "Ocurrio un error, consulta con el admin",
                "Error"
              );
            }
          });
      },
      guardarMarca() {
        let me = this;
        axios
          .post("marcas/store", me.modeloMarca)
          .then(function(response) {
            //Si el guardado se realizo correctamente
            if (response.data.estado === true) {
              me.$toastr.success("Nueva marca registrada", "Marca auto");
              me.listarMarcas();
              me.vistaMarcaRegistrar();
              me.modeloMarca = {};
              me.erroresModeloMarca = null;
            }
          })
          .catch(function(error) {
            //error 422 = validacion
            if (error.response.status === 422) {
              me.erroresModeloMarca = error.response.data.errors;
              me.$toastr.warning(
                "Valida los campos correctamente.",
                "Marca auto"
              );
            } else {
              me.$toastr.error(
                "Ocurrio un error, consulta con el admin",
                "Error"
              );
            }
          });
      },
      vistaCategoriasRegistrar() {
        this.registrarCategoria = !this.registrarCategoria;
        this.modeloCategoria = {};
     }, vistaTiposRegistrar() {
        this.registrarTipo = !this.registrarTipo;
        this.modeloTipos = {};
    },
    guardarCategoria(){
        let me=this;
         axios.post('ordenesNew/categoria',{
            'nombre': me.modeloCategoria.nombre,
        }).then(function (response) {
            var respuesta= response.data;
            console.log(response.data);
            me.vistaCategoriasRegistrar();
            me.arrayCategorias = respuesta.categorias;

        }).catch(function (error) {
            console.log(error);
        });    
        
    },
 
    guardarTipo(){
        let me=this;
         axios.post('ordenesNew/tipo',{
            'nombre': me.modeloTipos.nombre,
        }).then(function (response) {
            var respuesta= response.data;
            console.log(response.data);
            me.vistaTiposRegistrar();
            me.arrayTipos = respuesta.tipos;

        }).catch(function (error) {
            console.log(error);
        });    
        
    },
      guardarModelo() {
        let me = this;
        let modeloModelo = JSON.parse(JSON.stringify(me.modeloModelo));
        modeloModelo.marca_id = modeloModelo.marca_id
          ? modeloModelo.marca_id.code
          : null;
        axios
          .post("modelos/store", modeloModelo)
          .then(function(response) {
            //Si el guardado se realizo correctamente
            if (response.data.estado === true) {
              me.$toastr.success("Nuevo modelo registrado", "Modelo auto");
              me.vistaModeloRegistrar();
              me.modeloModelo = {};
              me.erroresModeloModelo = null;
            }
          })
          .catch(function(error) {
            //error 422 = validacion
            if (error.response.status === 422) {
              me.erroresModeloMarca = error.response.data.errors;
              me.$toastr.warning(
                "Valida los campos correctamente.",
                "Marca auto"
              );
            } else {
              me.$toastr.error(
                "Ocurrio un error, consulta con el admin",
                "Error"
              );
            }
          });
      },
      guardarFirma() {
        let me = this;
        const { isEmpty, data } = me.$refs.signaturePad.saveSignature();
        if (isEmpty) {
          me.$toastr.warning("Ingrese una firma", "Firma");
        } else {
          me.dataHojaConceptos.firma = data;
          me.$toastr.success("Firma guarda correctamente", "Firma");
        }
      },
  
      reporte(id) {
        window.open("hojaConcepto/reporte/" + id, "_blank");
      },
  
      listarEmpresas() {
        let me = this;
        me.listaEmpresas = [];
        axios
          .get("empresas/nombres")
          .then(function(response) {
            me.listaEmpresas = response.data;
            me.listaEmpresas.unshift({ code: -1, label: "N/A" });
            me.modeloRecepcion.empresa_id =
              me.listaEmpresas[me.listaEmpresas.length - 1];
          })
          .catch(function(response) {
            console.log(response);
          });
      },
      listarEmpresaClientes() {
        let me = this;
        if (!me.modeloRecepcion.empresa_id) return;
        //clientes que no pertenecen a una empresa
        if (me.modeloRecepcion.empresa_id.code === -1) {
          axios
            .get("customers/particulares")
            .then(function(response) {
              me.listaClientes = response.data;
              me.modeloRecepcion.customer_id =
                me.listaClientes[me.listaClientes.length - 1];
            })
            .catch(function(response) {
              console.log(response);
            });
        } else {
          axios
            .get("empresas/customers/" + me.modeloRecepcion.empresa_id.code)
            .then(function(response) {
              me.listaClientes = response.data;
              me.modeloRecepcion.customer_id =
                me.listaClientes[me.listaClientes.length - 1];
            })
            .catch(function(response) {
              console.log(response);
            });
        }
      },
      listarEstadoEquipo() {
        let me = this;
        axios
          .get("estado-equipo/index")
          .then(function(response) {
            me.listaEstadoEquipo = response.data;
            me.modeloInterioresEquipo.puerta_interior_frontal = 1;
            me.modeloInterioresEquipo.puerta_interior_trasera = 1;
            me.modeloInterioresEquipo.puerta_delantera_frontal = 1;
            me.modeloInterioresEquipo.puerta_delantera_trasera = 1;
  
            me.modeloInterioresEquipo.asiento_interior_frontal = 1;
            me.modeloInterioresEquipo.asiento_interior_trasera = 1;
            me.modeloInterioresEquipo.asiento_delantera_frontal = 1;
            me.modeloInterioresEquipo.asiento_delantera_trasera = 1;
  
            me.modeloInterioresEquipo.consola_central = 1;
            me.modeloInterioresEquipo.claxon = 1;
            me.modeloInterioresEquipo.tablero = 1;
            me.modeloInterioresEquipo.quemacocos = 1;
            me.modeloInterioresEquipo.toldo = 1;
            me.modeloInterioresEquipo.toldo = 1;
            me.modeloInterioresEquipo.elevadores_eletricos = 1;
            me.modeloInterioresEquipo.luces_interiores = 1;
            me.modeloInterioresEquipo.climatizador = 1;
            me.modeloInterioresEquipo.radio = 1;
            me.modeloInterioresEquipo.espejos_retrovizor = 1;
            me.modeloInterioresEquipo.seguros_eletricos = 1;
  
            me.modeloExterioresEquipo.antena_radio = 1;
            me.modeloExterioresEquipo.antena_telefono = 1;
            me.modeloExterioresEquipo.antena_cb = 1;
            me.modeloExterioresEquipo.estribos = 1;
            me.modeloExterioresEquipo.espejos_laterales = 1;
            me.modeloExterioresEquipo.guardafangos = 1;
            me.modeloExterioresEquipo.parabrisas = 1;
            me.modeloExterioresEquipo.sistema_alarma = 1;
            me.modeloExterioresEquipo.limpia_parabrisas = 1;
            me.modeloExterioresEquipo.luces_exteriores = 1;
          })
          .catch(function(error) {});
      },
      listarClientes() {
        let me = this;
        axios
          .get("customers/index")
          .then(function(response) {
            me.listaClientes = response.data;
            console.log(response.data);
          })
          .catch(function(response) {
            console.log(response);
          });
      },
      listarColores() {
        let me = this;
        axios
          .get("colores/nombres")
          .then(function(response) {
            me.listaColores = response.data;
            me.modeloVehiculo.color_id =
              me.listaColores[me.listaColores.length - 1];
          })
          .catch(function(response) {
            console.log(response);
          });
      },
      listarMarcas() {
        let me = this;
        axios
          .get("marcas/nombres")
          .then(function(response) {
            me.listaMarcas = response.data;
            me.modeloVehiculo.marca_id =
              me.listaMarcas[me.listaMarcas.length - 1];
          })
          .catch(function(response) {
            console.log(response);
          });
      },
      listarMarcaModelos() {
        let me = this;
        if (!me.modeloVehiculo.marca_id) return;
        axios
          .get("marcas/modelos/" + me.modeloVehiculo.marca_id.code)
          .then(function(response) {
            me.listaModelos = response.data;
            me.modeloVehiculo.modelo_id =
              me.listaModelos[me.listaModelos.length - 1];
          })
          .catch(function(response) {
            console.log(response);
          });
      },
       
      listarTiposVehiculos() {
        let me = this;
        axios
          .get("tipos/nombres")
          .then(function(response) {
            me.listaTiposVehiculo = response.data;
            me.modeloVehiculo.tipo_id =
              me.listaTiposVehiculo[me.listaTiposVehiculo.length - 1];
          })
          .catch(function(response) {
            console.log(response);
          });
      },
      listarVehiculos() {
        let me = this;
        axios
          .get("vehiculos/index")
          .then(function(response) {
            me.listaVehiculos = response.data;
            me.modeloRecepcion.vehiculo_id =
              me.listaVehiculos[me.listaVehiculos.length - 1];
          })
          .catch(function(response) {
            console.log(response);
          });
      },
  
      regresarFirmaAnterior() {
        this.$refs.signaturePad.undoSignature();
      },
  
      vistaColorRegistrar() {
        this.registrarColor = !this.registrarColor;
      },
      vistaClienteRegistrar() {
        this.registrarCliente = !this.registrarCliente;
        this.modeloCliente = {};
        this.modeloCliente.empresa_id = this.modeloRecepcion.empresa_id;
        this.erroresModeloCliente = null;
      },
      vistaEmpresaRegistrar() {
        this.registrarEmpresa = !this.registrarEmpresa;
        this.modeloEmpresa = {};
        this.erroresModeloEmpresa = null;
      },
      vistaMarcaRegistrar() {
        this.modeloMarca = {};
        this.erroresModeloMarca = null;
        this.registrarMarca = !this.registrarMarca;
      },
      vistaModeloRegistrar() {
        this.modeloModelo = {};
        this.erroresModeloMarca = null;
        this.modeloModelo.marca_id = this.modeloVehiculo.marca_id;
        this.registrarModelo = !this.registrarModelo;
      },
     
      vistaVehiculoRegistrar() {
        this.listarTiposVehiculos();
        this.listarMarcas();
        this.listarColores();
        this.modeloVehiculo = {};
        this.erroresModeloVehiculo = null;
        this.registrarVehiculo = !this.registrarVehiculo;
      }
    },
    mounted() {
      this.listarHojaConcepto();
      this.getArticulo();
    }
  };
  </script>
  <style>
  /*.dropdown{*/
  /*width: 90%;*/
  /*}*/
  /*.dropdown-toggle{*/
  /*height: 38px;*/
  /*}*/
  #tablaConceptos th{
    background-color: dimgray;
  }
  .modal-content {
    width: 100% !important;
    position: absolute !important;
  }
  
  .mostrar {
    display: list-item !important;
    opacity: 1 !important;
    position: absolute !important;
    background-color: #3c29297a !important;
  }
  
  .div-error {
    display: flex;
    justify-content: center;
  }
  
  .text-error {
    color: red !important;
    font-weight: bold;
  }
  
  @media (min-width: 600px) {
    .btnagregar {
      margin-top: 2rem;
    }
  }
  </style>
  