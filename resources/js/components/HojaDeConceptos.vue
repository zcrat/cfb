<template>
  <main class="main">
    <div class="container-fluid">
      <!-- Ejemplo de tabla Listado -->
      <div class="card">
        <div class="card-header">
          <i class="fa fa-align-justify mr-2"></i> Hoja de Conceptos
       
        </div>

        <!-- Listado de recepciones vehiculaes-->
        <template v-if="!registrarRecepcion">
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
                    <td v-text="hojaConcepto.orden_seguimiento"></td>
                    <td v-text="hojaConcepto.folio"></td>
                    <td v-text="hojaConcepto.empresaNombre"></td>
                    <td>{{hojaConcepto.vehiculoPlacas}} - {{hojaConcepto.vehiculoMarcaModelo}}</td>
                    <td v-text="hojaConcepto.fecha"></td>
                    <td v-text="hojaConcepto.fecha_compromiso"></td>
                    <td>
                      <button class="btn btn-primary" @click="reporte(hojaConcepto.id)">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                      </button>
                      <button class="btn btn-warning" @click="edit(hojaConcepto.id)">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                      </button>
                      <button class="btn btn-danger" @click="eliminarHoja(hojaConcepto.id)">
                        <i class="fas fa-trash-alt" aria-hidden="true"></i>
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

        <!--Formulario registrar actualizar-->
        <template v-if="registrarRecepcion" >
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
                                <input type="search" class="form-control form-control-sm" 
                                name="tecnico" 
                                id="tecnico"
                                v-model="dataHojaConceptos.tecnico"    
                                list="listTecnicos"  
                                @change="setTecnico"
                              />
                                <datalist id="listTecnicos">
                                  <option v-for="tecnico in tecnicos" :key="tecnico.id">
                                    {{tecnico.id}}-{{tecnico.nombre}}
                                  </option> 
                                </datalist>
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
                    <div class="form-group">    
                      <div class="row"> 
                        <div class="col-md-6">
                          <div class="card">
                            <div class="card-body">
                              <div class="row">
                                <div class="col-md-6">                              
                                  <div class="custom-control custom-radio">
                                    <input type="radio" @click="getRadio('remplazar')" class="custom-control-input" id="remplazar" name="accion" value="remplazar" >
                                    <label class="custom-control-label" for="remplazar">Remplazar</label>
                                  </div> 
                                </div>
                                <div class="col-md-6">
                                  <div class="custom-control custom-radio">
                                    <input type="radio" @click="getRadio('reparar')" class="custom-control-input" id="reparar" name="accion" >
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
                                    class="form-control form-control-sm" name="descripcion" id="descripcion" v-model="descripcion">
                                </div>  

                              </div>
                              <div class="row">
                                <div class="col-md-4">
                                  <label for="descripcion" >Codigo Sat</label>                            
                                  <input type="text" 
                                    class="form-control form-control-sm" name="descripcion" id="descripcion" v-model="codigo_sat">
                                </div>  

                                <div class="col-md-4">
                                  <label for="descripcion" >Codigo Unidad</label>                            
                                  <input type="text" 
                                    class="form-control form-control-sm" name="descripcion" id="descripcion" v-model="codigo_unidad">
                                </div>  

                                <div class="col-md-4">
                                  <label for="descripcion" >Unidad</label>                            
                                  <input type="text" 
                                    class="form-control form-control-sm" name="descripcion" id="descripcion" v-model="unidad_text">
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
                    <button type="button" @click="agregarConceptos" class="btn btn-success">Agregar Concepto</button>
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
                                <td> <button class="btn btn-warning" @click="editConceptoModal(item)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button><button class="btn btn-danger" v-on:click="eliminarConcepto(item.numConcepto,item.id)"><i class="fa fa-trash"></i> </button></td>                             
                              </tr>                                                       
                            </tbody>
                            <tfoot>
                              <tr>
                                <th colspan="5"><small>AUTORIZACIÓN</small></th>
                                <th><small>PARTES</small></th>
                                <th><small>MANO DE OBRA</small></th>
                                <th><small>SSUBCONTRATADO</small></th>
                                <th><small>OTROS</small></th>
                                <th><small>SUBTOTAL COSTOS</small></th>
                              </tr>    
                              <tr>
                                <td  rowspan="3" colspan="4">
                                  <VueSignaturePad height="200px" class="border mb-3" ref="signaturePad" />
                                  <div>
                                    <button class="btn btn-primary" @click="guardarFirma" >Guardar firma</button>
                                    <button @click="regresarFirmaAnterior" class="btn btn-secondary">Paso anterior</button>
                                  </div>
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
                  <button class="btn btn-default"   @click="vistaRecepcionRegistrar">Cancelar</button>
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
                                    class="form-control form-control-sm" name="descripcion" id="descripcion" v-model="arrayConcepto.descripcion">
                                </div>  
                              </div>
                              <div class="row">
                                <div class="col-md-4">
                                  <label for="descripcion" >Codigo Sat</label>                            
                                  <input type="text" 
                                    class="form-control form-control-sm" name="descripcion" id="descripcion" v-model="arrayConcepto.codigo_sat">
                                </div>  
                                <div class="col-md-4">
                                  <label for="descripcion" >Codigo Unidad</label>                            
                                  <input type="text" 
                                    class="form-control form-control-sm" name="descripcion" id="descripcion" v-model="arrayConcepto.codigo_unidad">
                                </div>  
                                <div class="col-md-4">
                                  <label for="descripcion" >Unidad</label>                            
                                  <input type="text" 
                                    class="form-control form-control-sm" name="descripcion" id="descripcion" v-model="arrayConcepto.unidad_text">
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
                                  <input type="number" class="form-control form-control-sm"  min="0" name="subTotalCostos" id="subTotalCostos" v-model="arrayConcepto.subTotalCostos" disabled>
                                </div>
                                <div class="col-md-6">
                                  <label for="subTotalCostos">Publico</label>
                                  <input type="number" class="form-control form-control-sm"  min="0" name="subTotalCostos" id="subTotalCostos" v-model="arrayConcepto.precio_publico" >
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
  </main>
</template>

<script>
import vSelect from "vue-select";

export default {
  data() {
    return {
      update:false,
      dataConceptos:{},
      arrayConcepto:{},
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
      reparar:'',
      fechaAplicacion:'',
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

      registrarRecepcion: false,
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
      tituloModal: "",
      tipoAccion: 0,
      errorIngreso: 0,
      errorMostrarMsjIngreso: [],
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
   
    eliminarHoja(id){
    
        let me = this;
        axios
          .delete('hojaconcepto/'+id)
          .then(function(response){
            console.log(response.data);
            me.listarHojaConcepto();

          })
          .catch(function(arror){

          });
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
          me.conceptos(me.idHoja);


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
     this.arrayConcepto.codigo_sat = concepto.codigo_sat;
     this.arrayConcepto.codigo_unidad = concepto.codigo_unidad;
     this.arrayConcepto.unidad_text = concepto.unidad_text;
    },
    cerrarModal(){
      this.modal = 0;

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
          'codigo_sat':  this.arrayConcepto.codigo_sat,
          'codigo_unidad':  this.arrayConcepto.codigo_unidad,
          'unidad_text':  this.arrayConcepto.unidad_text,
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
    getRadio1(value){
        if (value === 'remplazar') {
            this.arrayConcepto.remplazar = 'remplazar';
            this.arrayConcepto.reparar = '';
        }else{
            this.arrayConcepto.remplazar = '';
            this.arrayConcepto.reparar = 'reparar';
        }
    },
    agregarConcepto(){
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
    agregarConceptos(){
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
      if (!this.registrarRecepcion) {
        this.modeloRecepcion.fecha = new Date(Date.now()).toISOString();
        this.listarEmpresas();
        this.listarClientes();
        this.listarVehiculos();
        this.listarEstadoEquipo();
      }
      this.registrarRecepcion = !this.registrarRecepcion;
    },
    listarHojaConcepto() {
      let me = this;
      axios
        .get("hojaConceptos/index")
        .then(function(response) {
          console.log(response);
          me.listaHojaConcepto = response.data;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    crearPresupuesto(id){
      window.open('ordenes2/presupuestoHoja/'+ id,'_blank');
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
            me.vistaClienteRegistrar();
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
