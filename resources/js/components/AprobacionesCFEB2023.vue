<template>
    <main class="main">
    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Aprobaciones CFE
                
            </div>
            <!-- Listado-->
            <template v-if="listado==1">
            <div class="card-body">
                 <div class="form-group row">
                   
                    <div class="col-md-6">
                        <div class="input-group">
                            <select class="form-control col-md-3" v-model="criterio">
                               <option value="pCFEVehiculos.identificador">Economico</option>
                              <option value="pCFEVehiculos.vin">Serie</option>
                              <option value="pCFEVehiculos.placas">Placas</option>
                                <option value="pCFEGenerales.NSolicitud">Folio</option>
                            </select>
                            <input type="text" v-model="buscar" @keyup.enter="listarIngreso(1,buscar,criterio,'0')" class="form-control" placeholder="Texto a buscar">
                            <button type="submit" @click="listarIngreso(1,buscar,criterio,'0')" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>
                  
                </div>
                 <p class="h5 text-uppercase font-weight-bold  border-bottom">PRESUPUESTOS</p>
             
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Opciones</th>
                                <th>Folio </th>
                                <th>Economico</th>
                                <th>Centro de Trabajo</th>
                                <th>Orden</th>
                                <th></th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="cotizacion in arrayCotizacion" :key="cotizacion.id">
                                <td>
                                     <template v-if="cotizacion.status == 1">
                                     <select name="LeaveType" @change="onChange($event,cotizacion)" class="form-control">
                                        <option value="0" >Opciones de operación</option>
                                        <option value="1" >Recepcion Vehicular</option>
                                        <option value="2" >Fotos Viejas</option>
                                        <option value="3">Presupuesto</option>
                                        <option value="4">Reporte Anomalias</option>
                                         <option value="14">Entrada</option>
                                    </select>    
                                    <!-- <button type="button" class="btn btn-info btn-sm" title="Recepcion Vehicular"  @click="reporte(cotizacion.NSolicitud)">
                                    //<i class="fa fa-file-invoice"></i>
                                    </button>
                                    <button type="button" class="btn btn-warning btn-sm" title="Fotos Viejas" @click="verFotosViejas(cotizacion.id)">
                                    <i class="fa fa-picture-o"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm" title="Presupuesto" @click="pdfCotizacionp(cotizacion.id)">
                                    <i class="fa fa-file-invoice"></i>
                                      </button>
                                     <button type="button" class="btn btn-secondary btn-sm" title="Reporte Anomalias" @click="verReporteAnomalias(cotizacion.id)">
                                    <i class="fa fa-file-invoice"></i>
                                    </button> -->
                                     </template>

                                       <template v-if="cotizacion.status == 2">
                                    <select name="LeaveType" @change="onChange($event,cotizacion)" class="form-control">
                                        <option value="0" >Opciones de operación</option>
                                        <option value="1" >Recepcion Vehicular</option>
                                        <option value="2" >Fotos Viejas</option>
                                        <option value="3">Presupuesto</option>
                                        <option value="4">Reporte Anomalias</option>
                                         <option value="14">Entrada</option>
                                    </select>   
                                    <!-- <button type="button" class="btn btn-info btn-sm" title="Recepcion Vehicular"  @click="reporte(cotizacion.NSolicitud)">
                                    <i class="fa fa-file-invoice"></i>
                                    </button>
                                    <button type="button" class="btn btn-warning btn-sm" title="Fotos Viejas" @click="verFotosViejas(cotizacion.id)">
                                    <i class="fa fa-picture-o"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm" title="Presupuesto" @click="pdfCotizacionp(cotizacion.id)">
                                    <i class="fa fa-file-invoice"></i>
                                      </button>
                                     <button type="button" class="btn btn-secondary btn-sm" title="Reporte Anomalias" @click="verReporteAnomalias(cotizacion.id)">
                                    <i class="fa fa-file-invoice"></i>
                                    </button> -->
                                     </template>

                                         <template v-if="cotizacion.status == 3">
                                    <select name="LeaveType" @change="onChange($event,cotizacion)" class="form-control">
                                        <option value="0" >Opciones de operación</option>
                                        <option value="1" >Recepcion Vehicular</option>
                                        <option value="2" >Fotos Viejas</option>
                                        <option value="3">Presupuesto</option>
                                        <option value="4">Reporte Anomalias</option>
                                         <option value="14">Entrada</option>
                                    </select> 
                                    <!-- <button type="button" class="btn btn-info btn-sm" title="Recepcion Vehicular" @click="reporte(cotizacion.NSolicitud)" >
                                    <i class="fa fa-file-invoice"></i>
                                    </button>
                                    <button type="button" class="btn btn-warning btn-sm" title="Fotos Viejas" @click="verFotosViejas(cotizacion.id)">
                                    <i class="fa fa-picture-o"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm" title="Presupuesto" @click="pdfCotizacionp(cotizacion.id)">
                                    <i class="fa fa-file-invoice"></i>
                                      </button>
                                     <button type="button" class="btn btn-secondary btn-sm" title="Reporte Anomalias" @click="verReporteAnomalias(cotizacion.id)">
                                    <i class="fa fa-file-invoice"></i>
                                    </button> -->
                                     </template>

                                       <template v-if="cotizacion.status == 4">
                                     <select name="LeaveType" @change="onChange($event,cotizacion)" class="form-control">
                                        <option value="0" >Opciones de operación</option>
                                        <option value="1" >Recepcion Vehicular</option>
                                        <option value="2" >Fotos Viejas</option>
                                        <option value="3">Presupuesto</option>
                                        <option value="4">Reporte Anomalias</option>
                                         <option value="14">Entrada</option>
                                    </select>       
                                    <!-- <button type="button" class="btn btn-info btn-sm" title="Recepcion Vehicular" @click="reporte(cotizacion.NSolicitud)">
                                    <i class="fa fa-file-invoice"></i>
                                    </button>
                                    <button type="button" class="btn btn-warning btn-sm" title="Fotos Viejas" @click="verFotosViejas(cotizacion.id)">
                                    <i class="fa fa-picture-o"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm" title="Presupuesto" @click="pdfCotizacionp(cotizacion.id)">
                                    <i class="fa fa-file-invoice"></i>
                                      </button>
                                     <button type="button" class="btn btn-secondary btn-sm" title="Reporte Anomalias" @click="verReporteAnomalias(cotizacion.id)">
                                    <i class="fa fa-file-invoice"></i>
                                    </button>-->
                                     </template>

                                      <template v-if="cotizacion.status == 5">
                                    <select name="LeaveType" @change="onChange($event,cotizacion)" class="form-control">
                                        <option value="0" >Opciones de operación</option>
                                        <option value="1" >Recepcion Vehicular</option>
                                        <option value="2" >Fotos Viejas</option>
                                        <option value="3">Presupuesto</option>
                                        <option value="4">Reporte Anomalias</option>
                                        <option value="5">Fotos Nuevas</option>
                                        <option value="6">Fotos Instaladas</option>
                                        <option value="7">Orden Servicio</option>
                                        <option value="8">Acuse</option>
                                        <option value="9">Factura PDF</option>
                                        <option value="10">Factura XML</option>
                                        <option value="14">Entrada</option>
                                    </select>         
                                    <!-- <button type="button" class="btn btn-info btn-sm" title="Recepcion Vehicular" @click="reporte(cotizacion.NSolicitud)">
                                    <i class="fa fa-file-invoice"></i>
                                    </button>
                                    <button type="button" class="btn btn-warning btn-sm" title="Fotos Viejas" @click="verFotosViejas(cotizacion.id)">
                                    <i class="fa fa-picture-o"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm" title="Presupuesto" @click="pdfCotizacionp(cotizacion.id)">
                                    <i class="fa fa-file-invoice"></i>
                                    </button>
                                     <button type="button" class="btn btn-secondary btn-sm" title="Reporte Anomalias" @click="verReporteAnomalias(cotizacion.id)">
                                    <i class="fa fa-file-invoice"></i>
                                    </button>
                                    <button type="button" class="btn btn-light btn-sm" title="Fotos Nuevas" @click="verFotosNuevas(cotizacion.id)">
                                    <i class="fa fa-picture-o"></i>
                                    </button>
                                    <button type="button" class="btn btn-dark btn-sm" title="Fotos Instaladas" @click="verFotosInstaladas(cotizacion.id)">
                                    <i class="fa fa-picture-o"></i>
                                    </button>
                                     <button type="button" class="btn btn-info btn-sm" title="Orden Servicio" @click="ordenservicio(cotizacion.id)">
                                    <i class="fa fa-file-invoice"></i>
                                    </button>
                                     <button type="button" class="btn btn-dark btn-sm" title="Acuse" @click="verAcuse(cotizacion.id)">
                                    <i class="fa fa-file-invoice"></i>
                                    </button>
                                     <button type="button" class="btn btn-danger btn-sm" title="Factura PDF" @click="pdfdescargar(cotizacion)">
                                    <i class="fa fa-file-invoice"></i>
                                    </button> 
                                     <button type="button" class="btn btn-success btn-sm" title="Factura XML" @click="xmldescargar(cotizacion)">
                                    <i class="fa fa-file-invoice"></i>
                                    </button> -->
                                     </template>
                                </td>
                                <td v-text="cotizacion.NSolicitud"></td>
                                <td v-text="cotizacion.identificador"></td>
                                <td v-text="cotizacion.marca"></td>
                                <td v-text="cotizacion.modelo"></td>
                                <td>
                                     <template v-if="cotizacion.status == 2">
                                     <button type="button" class="btn btn-success btn-sm" title="Boton de autorizacion" @click="cambiostatus(cotizacion.id,'3')">
                                    AUTORIZAR
                                    </button> 
                                     </template>
                                      <template v-if="cotizacion.status == 3">
                                     <button type="button" class="btn btn-secondary btn-sm" title="Boton de autorizacion">
                                    EN PROCESO
                                    </button> 
                                     </template>
                                       <template v-if="cotizacion.status == 4">
                                     <button type="button" class="btn btn-secondary btn-sm" title="Boton de autorizacion">
                                    EN PROCESO
                                    </button> 
                                     </template>
                                       <template v-if="cotizacion.status == 5">
                                     <button type="button" class="btn btn-success btn-sm" title="Boton de autorizacion">
                                    TERMINADO Y FACTURADO
                                    </button> 
                                     </template>
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
              <!-- Modal -->
<div class="modal fade fade bd-example-modal-lg" id="exampleModalCenter2" :class="{'mostrar7' : modal7}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" >Agregar Orden Servicio</h5>
<button type="button" class="close" @click="cerrarModal">
  <span aria-hidden="true">&times;</span>
</button>
</div>


<div class="modal-body">
 <div class="form-group row">
       <label class="col-md-3 form-control-label" for="text-input">Archivo</label>
        <div class="col-md-9">
        <input id="folio-id" class="form-control" type="file" @change="subirarchivo">
     </div>
 </div>
</div>
 <div class="modal-footer">
<div class="form-group row">
                    <div class="col-md-12">
                        <button type="button" @click="cerrarModal()" class="btn btn-secondary">Cerrar</button>
                        <button type="button" class="btn btn-primary" @click="guardarOrdenServicio()" :disabled="disabled == 1">Guardar</button>
                    </div>
</div>


</div>
</div>
</div>
</div>
            </template>
            <!--Fin Listado-->
            <!-- Detalle-->
            <template v-else-if="listado==0">
            <div class="card-body">
                 <p class="h5 text-uppercase font-weight-bold  border-bottom">Datos del Vehiculo</p>
                <div class="form-group row border">
                    <div class="col-md-3">
                        <div class="form-group">
                             <label>Economico</label>
                             <input type="text" class="form-control" v-model="economico" placeholder="000xx">
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
                            <label>VIN</label>
                            <input type="text" class="form-control" v-model="vin" placeholder="000xx">
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
                            <label>Año</label>
                            <input type="text" class="form-control" v-model="ano" placeholder="000xx">
                        </div>
                    </div>

                     <div class="col-md-3">
                        <div class="form-group">
                            <label>Kilometraje</label>
                            <input type="text" class="form-control" v-model="kilometraje" placeholder="000xx">
                        </div>
                    </div>

                     <div class="col-md-3">
                        <div class="form-group">
                            <label>Marca</label>
                            <input type="text" class="form-control" v-model="marca" placeholder="000xx">
                        </div>
                    </div>

                </div>
                 <p class="h5 text-uppercase font-weight-bold  border-bottom">Datos Generales Solicitud</p>
                <div class="form-group row border">

                     <div class="col-md-3">
                        <div class="form-group">
                            <label>No. Solicitud</label>
                            <input type="text" class="form-control" v-model="NSolicitud" placeholder="000xx">
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                             <label>Fecha Alta:</label>
                             <datetime input-id="fecha" input-class="form-control" type="datetime" v-model="FechaAlta">
                                     <template slot="button-cancel">
                                                <i class="fa fa-times mr-2"></i>Cancelar
                                            </template>
                                            <template slot="button-confirm">
                                                <i class="fa fa-check-circle mr-2"></i>Aceptar
                                            </template>
                                        </datetime>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Orden Servicio</label>
                            <input type="text" class="form-control" v-model="ordenServicio" placeholder="000x">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>km De Ingreso</label>
                            <input type="text" class="form-control" v-model="kmDeIngreso" placeholder="000xx">
                        </div>
                    </div>
                     <div class="col-md-3">
                        <div class="form-group">
                            <label>Cliente y Razon Social</label>
                            <input type="text" class="form-control" v-model="clienteYRazonSocial" placeholder="000xx">
                        </div>
                    </div>
                    
                     <div class="col-md-3">
                        <div class="form-group">
                            <label>Mail.</label>
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
                            <label>Conductor</label>
                            <input type="text" class="form-control" v-model="Conductor" placeholder="000xx">
                        </div>
                    </div>
                   
                     <div class="col-md-12">
                        <div class="form-group">
                            <label>Observaciones</label>
                            <textarea id="notas-adicionales-id" class="form-control"
                                                  placeholder="Notas" cols="30" rows="5" v-model="observaciones"></textarea>
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

                 <div class="row col-md-12">
                      
                       <div class="form-group col-md-6">
                            <label for="archivo_cer">Seleccione un Archivo:</label>
                            <input type="file" name="archivo_cer"  class="form-control" @change="pdfChanged" >
                      </div>
                       </div>

                <div class="form-group row">
                    <div class="col-md-12">
                        <button type="button" @click="ocultarDetalle()" class="btn btn-secondary float-right">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-primary float-right" @click="registrarIngreso()"><i class="fa fa-floppy-o mr-2"> Agregar</i></button>
                        <button type="button" v-if="tipoAccion==2" class="btn btn-primary float-right" @click="actualizarIngreso()">Actualizar Cotizacion</button>
                
                    </div>
                </div>
            </div>
            </template>
            <!-- Fin Detalle-->
          

              <!-- Detalle-->
            <template v-else-if="listado==5">
            <div class="card-body">
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
                    
                    <div class="col-md-4">
                        <div class="form-group">
                             <label>Tipo de Comprobante</label>
                              <select name="tipo_comprobante" v-model="factura.tipo_comprobante" id="tipo_comprobante" class="form-control">
                                 <option value="I">I - Factura</option>
                                 <option value="E">E - Nota de credito</option>
                                 <option value="E">N - Nomina</option>
                           </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="uso_cfdi">Uso de CFDI por parte del Receptor</label>
                          <select name="uso_cfdi" class="form-control" v-model="factura.uso_cfdi">
                                                                <option value="G01">G01 - Adquisicion de mercancias</option>
                                                                          <option value="G02">G02 - Devoluciones, descuentos o bonificaciones</option>
                                                                          <option value="G03">G03 - Gastos en general</option>
                                                                          <option value="I01">I01 - Construcciones</option>
                                                                          <option value="I02">I02 - Mobilario y equipo de oficina por inversiones</option>
                                                                          <option value="I03">I03 - Equipo de transporte</option>
                                                                          <option value="I04">I04 - Equipo de computo y accesorios</option>
                                                                          <option value="I05">I05 - Dados, troqueles, moldes, matrices y herramental</option>
                                                                          <option value="I06">I06 - Comunicaciones telefonicas</option>
                                                                          <option value="I07">I07 - Comunicaciones satelitales</option>
                                                                          <option value="I08">I08 - Otra maquinaria y equipo</option>
                                                                          <option value="D01">D01 - Honorarios medicos, dentales y gastos hospitalarios.</option>
                                                                          <option value="D02">D02 - Gastos medicos por incapacidad o discapacidad</option>
                                                                          <option value="D03">D03 - Gastos funerales.</option>
                                                                          <option value="D04">D04 - Donativos.</option>
                                                                          <option value="D05">D05 - Intereses reales efectivamente pagados por creditos hipotecarios (casa habitaci?n)</option>
                                                                          <option value="D06">D06 - Aportaciones voluntarias al SAR.</option>
                                                                          <option value="D07">D07 - Primas por seguros de gastos medicos.</option>
                                                                          <option value="D08">D08 - Gastos de transportacion escolar obligatoria.</option>
                                                                          <option value="D09">D09 - Depositos en cuentas para el ahorro, primas que tengan como base planes de pension</option>
                                                                          <option value="D10">D10 - Pagos por servicios educativos (colegiaturas)</option>
                                                                          <option value="P01">P01 - Por definir</option>
                                                                    </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                           <label for="tipo_impuesto">Tipo de Impuesto Local</label>
                          <select name="tipo_impuesto_local" class="form-control" v-model="factura.tipo_impuesto_local">
                             <option value="1">Sin Impuesto Local</option>
                             <option value="2">Inspeccion, Vigilancia, Control</option>
                             <option value="3">Impuesto Cedular</option>
                             <option value="4">Impuesto Sobre Remuneraciones al Trabajo Personal No Subordinado (RTP)</option>
                             <option value="5">Impuesto Sobre Nomina</option>
                          </select>
                        </div>
                    </div>
                     <div class="col-md-4">
                        <div class="form-group">
                            <label for="moneda">Moneda</label>
                          <select name="moneda" class="form-control" v-model="factura.moneda">
                            <option value="MXN">MXN - PESOS</option>
                            <option value="USD">USD - DOLARES</option>
                            <option value="EUR">EUR - EUROS</option>
                          </select>
                        </div>
                    </div>
                     <div class="col-md-4">
                        <div class="form-group">
                             <label for="formadepago">Forma de pago</label>
                          <select name="fpago" class="form-control" v-model="factura.fpago">
                              <option value="01">01 - Efectivo</option>
                              <option value="02">02 - Cheque nominativo</option>
                              <option value="03">03 - Transferencia electronica de fondos</option>
                              <option value="04">04 - Tarjeta de credito</option>
                              <option value="05">05 - Monedero Electronico</option>
                              <option value="06">06 - Dinero electronico</option>
                              <option value="08">08 - Vales de despensa</option>
                              <option value="12">12 - Dacion en pago</option>
                              <option value="13">13 - Pago por subrogacion</option>
                              <option value="14">14 - Pago por consignacion</option>
                              <option value="15">15 - Condonacion</option>
                              <option value="17">17 - Compensacion</option>
                              <option value="23">23 - Novacion</option>
                              <option value="24">24 - Confusion</option>
                              <option value="25">25 - Remision de deuda</option>
                              <option value="26">26 - Prescripcion o caducidad</option>
                              <option value="27">27 - A satisfaccion del acredor</option>
                              <option value="28">28 - Tarjeta de debito</option>
                              <option value="29">29 - Tarjeta de servicios</option>
                              <option value="99">99 - Por definir.</option>
                            </select>
                        </div>
                    </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label for="metododepago">Metodo de pago</label>
                          <select name="mpago" class="form-control" v-model="factura.mpago">
                            <option value="PUE">PUE - Pago en una sola exhibicion</option>
                            <option value="PPD">PPD - Pago en parcialidades o diferidos</option>
                          </select>
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
              
                <div class="form-group row border">
                    <div class="table-responsive col-md-12">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                  
                                    <th>Artículo</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody v-if="detallefactura.length">
                                <tr v-for="(detalle,index) in detallefactura" :key="detalle.id">
                                    
                                    <td v-text="detalle.descripcion"></td>
                                    <td v-text="detalle.precio"></td>
                                    <td v-text="detalle.cantidad"></td>
                                    <td v-text="detalle.precio*detalle.cantidad"><input type="hidden" name="customfield" class="form-control" :value="detalle.idarticulo" ></td>

                                <tr style="background-color: #CEECF5;">
                                    <td colspan="3" align="right"><strong>Total Parcial:</strong></td>
                                    <td>$ {{totalParcial=(total-totalImpuesto).toFixed(2)}}</td>
                                </tr>
                                <tr style="background-color: #CEECF5;">
                                    <td colspan="3" align="right"><strong>Total Impuesto:</strong></td>
                                    <td>$ {{totalImpuesto=((total*0.16)/(1+0.16)).toFixed(2)}}</td>
                                </tr>
                                <tr style="background-color: #CEECF5;">
                                    <td colspan="3" align="right"><strong>Total Neto:</strong></td>
                                    <td>$ {{total=calcularTotalf}}</td>
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
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Cerrar</button>
                        <button type="button" class="btn btn-primary" @click="timbrar()">Timbrar</button>
                    </div>
                </div>
            </div>
            </template>
            <!-- Fin Detalle-->


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
                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <select class="form-control col-md-3" v-model="criterioA">
                              <option value="nombre">Nombre</option>
                              <option value="descripcion">Descripción</option>
                              <option value="codigo">Código</option>
                            </select>
                            <input type="text" v-model="buscarA" @keyup.enter="listarArticulo(idempresa,criterioA)" class="form-control" placeholder="Texto a buscar">
                            <button type="submit" @click="listarArticulo(idempresa,criterioA)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>
                </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm">
                         <thead>
                         <tr>
                            <th>Opciones</th>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Precio Venta</th>
                            <th>Stock</th>
                            <th>Estado</th>
                            </tr>
                           </thead>
                           <tbody>
                             <tr v-for="articulo in arrayArticulo" :key="articulo.id">
                            <td>
                                <button type="button" @click="agregarDetalleModal(articulo)" class="btn btn-success btn-sm">
                                  <i class="icon-check"></i>
                                </button>
                            </td>
                            <td v-text="articulo.codigo"></td>
                            <td v-text="articulo.nombre"></td>
                            <td v-text="articulo.nombre_categoria"></td>
                            <td v-text="articulo.precio_venta"></td>
                            <td v-text="articulo.stock"></td>
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
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                    <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarPersona()">Guardar</button>
                    <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarPersona()">Actualizar</button>
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
import vSelect from 'vue-select';
import { constants } from 'crypto';
export default {
data (){
    return {
        factura:{
            tipo_comprobante:"I",
            uso_cfdi:"G02",
            moneda:"MXN",
            fpago:"01",
            tipo_impuesto_local:"1",
            mpago:"PUE"
        },
        detallefactura:[],
        ingreso_id: 0,
        idempresa:0,
        idempresa:0,
        idcotizacion:0,
        empresa:'',
        modal7:0,
        nombre : '',
        fecha: '',
        styleMe: false,
        odes : '',
        ejecutivo: '',

        economico: '',
        modelo: '',
        vin : '',
        placas : '',
        ano : '',
        kilometraje : '',
        marca : '',

        NSolicitud: '',
        FechaAlta : '',
        ordenServicio:'',
        kmDeIngreso : '',
        clienteYRazonSocial : '',
        Mail : '',
        Telefono : '',
        Conductor : '',

        observaciones : '',
        archivo_pdf:'',
        archivo : '',
        disabled:1,
        idpresupuesto:0,

        total:0.0,
        totalImpuesto: 0.0,
        totalParcial: 0.0,
        arrayCotizacion : [],
        arrayEmpresa : [],
        arrayDetalle : [],
        listado:1,
        modal : 0,
        tituloModal : '',
        tipoAccion : 0,
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
        offset : 3,
        criterio : 'num_comprobante',
        buscar : '',
        criterioA: 'nombre',
        buscarA:'',
        arrayArticulo: [],
        idarticulo: 0,
        codigo: '',
        articulo: '',
        precio: 0,
        cantidad: 0,
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
        for(var i=0;i<this.arrayDetalle.length;i++){
            resultado=resultado+(this.arrayDetalle[i].precio*this.arrayDetalle[i].cantidad)
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
            this.reporte(cotizacion.NSolicitud);
        }
        if(event.target.value == 2){
            this.verFotosViejas(cotizacion.id);
         }
        if(event.target.value == 3){
            this.pdfCotizacionp(cotizacion.id);
        }
        if(event.target.value == 4){
            this.verReporteAnomalias(cotizacion.id);
        }
        if(event.target.value == 5){
            this.verFotosNuevas(cotizacion.id);
        }
         if(event.target.value == 6){
            this.verFotosInstaladas(cotizacion.id);
        }
        if(event.target.value == 7){
            this.ordenservici(cotizacion.id);
        }
        if(event.target.value == 8){
            this.verAcuse(cotizacion.id);
        }
        if(event.target.value == 9){
            this.pdfdescargar(cotizacion);
        }
        if(event.target.value == 10){
            this.xmldescargar(cotizacion);
        }if(event.target.value == 14){
            this.verEntrada(cotizacion.id);
        }
    },
     verEntrada(orden){
        let me=this;
        var url= 'ordenes/verEntrada?id=' + orden;
        axios.get(url).then(function (response) {
            console.log(response.data);
            var respuesta = response.data;
            window.open('documentos/ordenentrada/'+ respuesta,'_blank');
        })
        .catch(function (error) {
            console.log(error);
        });
        
    },
    pdfChanged(e){

       
        var fileReader = new FileReader()
        fileReader.readAsDataURL(e.target.files[0])
        fileReader.onload = (e) => {
            this.archivo_pdf= e.target.result;
        }

    },
    listarIngreso (page,buscar,criterio){

        this.buscar = buscar;
        this.criterio = criterio;
        
        let me=this;
        var url= 'ordenesCFEB2023?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
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
    reporte(id){
        let me=this;
        var url= 'recepcion/folioBuscar?id=' + id;
        axios.get(url).then(function (response) {
            console.log(response.data);
            var respuesta = response.data;
            window.open('recepcion/reporte/'+ respuesta,'_blank');
        })
        .catch(function (error) {
            console.log(error);
        });
        
    },
     pdfCotizacionp(id){
        window.open('ordenes/pdfCFE/'+ id,'_blank');
    },
     verFotosViejas(id){
        let me=this;
        var url= 'ordenes/verFotosViejas?id=' + id;
        axios.get(url).then(function (response) {
            console.log(response.data);
            var respuesta = response.data;
            window.open('documentos/fotosviejas/'+ respuesta,'_blank');
        })
        .catch(function (error) {
            console.log(error);
        });
        
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

    selectDetalle(id){
        let me=this;
        var url= 'cotizacion3/selectDetalle?id=' + id;
        axios.get(url).then(function (response) {
            console.log(response);
            var respuesta= response.data;
            me.arrayDetalle = respuesta.detalles;
            me.pagination= respuesta.pagination;
        })
        .catch(function (error) {
            console.log(error);
        });
    },


    getDatosEmpresa(val1){
        let me = this;
        me.loading = true;
        me.idempresa = val1.id;
        me.factura.empresa_id = val1.id;
    },
     timbrar(){
       
        let me = this;

        axios.post('facturacion/timbrar',
           {
            'factura' : me.factura,   
            'data' : me.detallefactura
            }).then(function (response) {
            console.log(response.data);
           
            me.$toastr.success('Nueva Factura Timbrada', 'Facturación');
            me.$store.commit('facturacion');
            
           
       

        }).catch(function (error) {
            console.log(error);
        });
    },
     verAcuse(id){
        let me=this;
        var url= 'ordenes/verAcuse?id=' + id;
        axios.get(url).then(function (response) {
            console.log(response.data);
            var respuesta = response.data;
            window.open('documentos/acuse/'+ respuesta,'_blank');
        })
        .catch(function (error) {
            console.log(error);
        });
        
    },

    selectArticulo(search,loading){
        let me=this;
        loading(true)
        var url='articulo/selectArticulo?filtro='+search;
        axios.get(url).then(function (response) {
            //console.log(response);
            let respuesta= response.data;
            q: search
            me.arrayArticulo = respuesta.articulos;
            loading(false)
        })
        .catch(function (error) {
            console.log(error);
        });
    },
     verFotosNuevas(id){
        let me=this;
        var url= 'ordenes/verFotosNuevas?id=' + id;
        axios.get(url).then(function (response) {
            console.log(response.data);
            var respuesta = response.data;
            window.open('documentos/fotosnuevas/'+ respuesta,'_blank');
        })
        .catch(function (error) {
            console.log(error);
        });
        
    },
     ordenservicio(id){
     this.modal7 = 1;
     this.presupuestoCFE_id = id;

    },
     cambiostatus(id , status){
        let me = this;
        axios.post('ordenes/cambioStatus',{
            'id': id,
            'status': status
        }).then(function (response) {
            console.log(response.data);
            me.listarIngreso(1,'','odes');
           
        }).catch(function (error) {
            console.log(error);
        });  
    },
    getDatosArticulo(val1){
        let me = this;
        me.loading = true;
        me.idarticulo = val1.id;
        me.articulo = val1.nombre;
    },

    buscarArticulo(){
        let me=this;
        var url= 'articulo/buscarArticulo?filtro=' + me.codigo;

        axios.get(url).then(function (response) {
            var respuesta= response.data;
            me.arrayArticulo = respuesta.articulos;

            if(me.arrayArticulo.length>0){
                me.articulo=me.arrayArticulo[0]['nombre'];
                me.idarticulo=me.arrayArticulo[0]['id'];
            }
            else{
                me.articulo='No existe este articulo';
                me.idarticulo=0;
            }
        })
        .catch(function (error){
            console.log(error);
        });
    },

    cambiarPagina(page,buscar,criterio){
        let me = this;
        //Actualiza la página actual
        me.pagination.current_page = page;
        //Envia la petición para visualizar la data de esa página
        me.listarIngreso(page,buscar,criterio);
    },
    encuentra(id){
        var sw=0;
        for(var i=0;i<this.arrayDetalle.length;i++){
            if(this.arrayDetalle[i].idarticulo==id){
                sw=true;
            }
        }
        return sw;
    },
    eliminarDetalle(id){
        let me=this;
        var url= 'cotizacion3/deleteDetalle?id=' + id;
        axios.get(url).then(function (response) {
            console.log(response.data);
             me.selectDetalle(me.idcotizacion);
        })
        .catch(function (error) {
            console.log(error);
        });
    },
    verFotosInstaladas(id){
        let me=this;
        var url= 'ordenes/verFotosInstaladas?id=' + id;
        axios.get(url).then(function (response) {
            console.log(response.data);
            var respuesta = response.data;
            window.open('documentos/fotosinstaladas/'+ respuesta,'_blank');
        })
        .catch(function (error) {
            console.log(error);
        });
        
    },
    pdfdescargar(cotizacion){
          let me=this;
        var url= 'ordenes/factura?id='+cotizacion.id;
        axios.get(url).then(function (response) {
            console.log(response.data);
            var respuesta= response.data;
            window.open('download/'+ respuesta.pdf,'_blank');
        })
        .catch(function (error) {
            console.log(error);
        });
     },
     xmldescargar(cotizacion){
         let me=this;
        var url= 'ordenes/factura?id='+cotizacion.id;
        axios.get(url).then(function (response) {
            console.log(response.data);
            var respuesta= response.data;
            window.open('download/'+ respuesta.xml,'_blank');
        })
        .catch(function (error) {
            console.log(error);
        });
         
     },
    agregarDetalle(){
        let me=this;
        if(me.idarticulo==0){
        }else{
            if(me.encuentra(me.idarticulo)){
                swal({
                    type: 'error',
                    title: 'Error...',
                    text: 'Este Artículo ya se encuentra agregado!',
                })
            }else{
                 me.arrayDetalle.push({
            idarticulo: me.idarticulo,
            articulo: me.articulo,
            cantidad: me.cantidad,
            precio: me.precio
            });
            me.codigo='';
            me.idarticulo=0;
            me.articulo='';
            me.cantidad=0;
            me.precio=0;
            }
           
        }
        
    },
    agregarDetalleModal(data =[]){
        let me=this;
        if(me.encuentra(data['id'])){
                swal({
                    type: 'error',
                    title: 'Error...',
                    text: 'Este Artículo ya se encuentra agregado!',
                })
            }else{
            me.arrayDetalle.push({
            idarticulo: data['id'],
            descripcion: data['nombre'],
            cantidad: 1,
            precio: data['precio']
            });
            }
    },
    listarArticulo (buscar,criterio){
        let me=this;
        var url= 'productosgrupos/listarProductos?empresas_id='+ buscar;
        axios.get(url).then(function (response) {
            console.log(response.data);
            var respuesta= response.data;
            me.arrayArticulo = respuesta.articulos.data;
        })
        .catch(function (error) {
            console.log(error);
        });
    },
    registrarIngreso(){
        if (this.validarIngreso()){
            return;
        }
        
        let me = this;

        axios.post('ordenesB2023/registrar',{
            'identificador': this.economico,
            'modelo': this.modelo,
            'vin' : this.vin,
            'placas' : this.placas,
            'ano' : this.ano,
            'kilometraje' : this.kilometraje,
            'marca' : this.marca,
            'nsolicitud' : this.NSolicitud,
            'fechaalta' : this.FechaAlta,
            'ordenservicio' : this.ordenServicio,
            'kmdeingreso' : this.kmDeIngreso,
            'clienteYRazonSocial' : this.clienteYRazonSocial,
            'observaciones' : this.observaciones,
            'mail' : this.Mail,
            'telefono' : this.Telefono,
            'conductor' : this.Conductor

        }).then(function (response) {
            
            console.log(response.data);
            me.listado=1;
            me.listarIngreso(1,'','odes');
            me.economico='';
            me.modelo='';
            me.vin='';
            me.placas='';
            me.ano='';
            me.kilometraje='';
            me.marca='';
            me.NSolicitud='';
            me.FechaAlta='';
            me.ordenServicio='';
            me.kmDeIngreso='';
            me.clienteYRazonSocial = '';
            me.observaciones ='';
            me.Mail = '';
            me.Telefono ='';
            me.Conductor ='';

        }).catch(function (error) {
            console.log(error);
        });
    },
    actualizarIngreso(){
     
        let me = this;

        axios.post('ordenes/update',{
            'identificador': this.economico,
            'modelo': this.modelo,
            'vin' : this.vin,
            'placas' : this.placas,
            'ano' : this.ano,
            'kilometraje' : this.kilometraje,
            'marca' : this.marca,
            'nsolicitud' : this.NSolicitud,
            'fechaalta' : this.FechaAlta,
            'ordenservicio' : this.ordenServicio,
            'kmdeingreso' : this.kmDeIngreso,
            'clienteYRazonSocial' : this.clienteYRazonSocial,
            'observaciones' : this.observaciones,
            'mail' : this.Mail,
            'telefono' : this.Telefono,
            'conductor' : this.Conductor,
            'id': this.idpresupuesto,
        }).then(function (response) {
            console.log(response.data);
            me.listado=1;
            me.listarIngreso(1,'','odes');
        }).catch(function (error) {
            console.log(error);
        }); 
    },
    validarIngreso(){
        this.errorIngreso=0;
        this.errorMostrarMsjIngreso =[];

        if (!this.economico) this.errorMostrarMsjIngreso.push("Escriba un economico");
        
       
        if (this.errorMostrarMsjIngreso.length) this.errorIngreso = 1;

        return this.errorIngreso;
    },
    pdfCotizacion(id){
        window.open('cotizacion3/pdf/'+ id,'_blank');
    },
    mostrarDetalle(){
        let me=this;
        me.listado=0;

        me.idproveedor=0;
            me.tipo_comprobante='BOLETA';
            me.serie_comprobante='';
            me.num_comprobante='';
            me.impuesto=0.16;
            me.total=0.0;
            me.idarticulo=0;
            me.articulo='';
            me.cantidad=0;
            me.precio=0;
            me.arrayDetalle=[];
    },
    verReporteAnomalias(id){
        let me=this;
        var url= 'ordenes/verReporteAnomalias?id=' + id;
        axios.get(url).then(function (response) {
            console.log(response.data);
            var respuesta = response.data;
            window.open('documentos/reporteanomalias/'+ respuesta,'_blank');
        })
        .catch(function (error) {
            console.log(error);
        });
        
    },
    ocultarDetalle(){
        this.listado=1;
        this.listarIngreso(1,this.buscar,this.criterio);
    },
    verIngreso(id){
        let me=this;
        me.listado=2;

        //Obtener datos del ingreso
        var arrayIngresoT=[];
        var url= 'ingreso/obtenerCabecera?id=' + id;

        axios.get(url).then(function (response) {
            var respuesta= response.data;
            arrayIngresoT = respuesta.ingreso;
            
            me.proveedor = arrayIngresoT[0]['nombre'];
            me.tipo_comprobante=arrayIngresoT[0]['tipo_comprobante'];
            me.serie_comprobante=arrayIngresoT[0]['serie_comprobante'];
            me.num_comprobante=arrayIngresoT[0]['num_comprobante'];
            me.impuesto=arrayIngresoT[0]['impuesto'];
            me.total=arrayIngresoT[0]['total'];
        })
        .catch(function (error) {
            console.log(error);
        });

        //obtener datos de los detalles
         var url= 'ingreso/obtenerDetalles?id=' + id;

        axios.get(url).then(function (response) {
            console.log(response);
            var respuesta= response.data;
            me.arrayDetalle = respuesta.detalles;

        })
        .catch(function (error) {
            console.log(error);
        });
    },
    cerrarModal(){
        this.modal=0;
        this.modal7=0;
        this.tituloModal='';
    },
    subirarchivo(e){
        let me = this;

        var fileReader = new FileReader()
        fileReader.readAsDataURL(e.target.files[0])
        fileReader.onload = (e) => {
              axios.post('ordenes/subirarchivos8',{
                'doc': e.target.result
            }).then(function (response) {
            console.log(response.data);
             if (response.data == "nada.doc"){

            } else {
                me.archivo = response.data.nombre;
                me.disabled = 0;
            }
        })
            .catch(function (error) {
            console.log(error);
            me.limpiarCampos();
               
            });
            
        }
      

    },
    guardarOrdenServicio(){
        let me = this;

        axios.post('ordenes/guardarOrdenServicio',{
            'id': me.presupuestoCFE_id,
            'archivo': me.archivo
        }).then(function (response) {
            
            console.log(response.data);
            me.cerrarModal();
            me.listarIngreso(1,'','odes');
            me.disabled = 1;
           

        }).catch(function (error) {
            console.log(error);
        });              
    },
    abrirModal(){
        this.arrayArticulo=[];
        this.modal = 1;
        this.tituloModal = 'Seleccione los articulos que desee';

    },

    desactivarIngreso(id){
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

            axios.put('cotizacion3/desactivar',{
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
                        this.tituloModal = 'Nuevo Presupuesto';
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
                        this.listado=0;
                        this.tituloModal='Editar Presupuesto';
                        this.tipoAccion=2;
                        this.economico=data['identificador'];
                        this.modelo=data['modelo'];
                        this.vin=data['vin'];
                        this.placas=data['placas'];
                        this.ano=data['ano'];
                        this.marca=data['marca'];
                        this.idpresupuesto = data['id']; 
                        this.selectDetalle(data['id']);
                        break;
                    }
                }
            }
        }
        
    },
     facturar(cotizacion){
        let me=this;
        me.listado=5;

         var url= 'cotizacion3/obtenerDetalles?id=' + cotizacion.id;

        axios.get(url).then(function (response) {
            console.log(response);
            var respuesta= response.data;
            me.detallefactura = respuesta.detalles;

        })
        .catch(function (error) {
            console.log(error);
        });

            
    },

},
mounted() {
    this.listarIngreso(1,this.buscar,this.criterio);
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
.mostrar7{
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
.new-color {
color: green;
}

.steely {
color: steelblue;
}

.purple {
 color: purple;
}
@media (min-width: 600px) {
.btnagregar {
    margin-top: 2rem;
}
}

</style>