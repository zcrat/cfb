<template>
    <main class="main">
    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Reportes
            </div>
            <!-- Listado-->
            <template v-if="listado==1">
            <div class="card-body">
                <div class="form-group row">
                     <div class="col-md-3">
                        <div class="input-group">
                             <input type="date" v-model="fecha_inicio" class="form-control" />
                        </div>
                     </div>
                      <div class="col-md-3">
                        <div class="input-group">
                             <input type="date" v-model="fecha_final" class="form-control" />
                        </div>
                     </div>

                      <div class="col-md-2">
                        <div class="input-group">
                            <select class="form-control" v-model="servicio">
                                <option value="0">SERVICIO</option>
                                <option value="1">PREVENTIVO</option>
                                <option value="2">CORRECTIVO</option>
                            </select>
                        </div>
                     </div>


                      <template v-if="servicio==1">
                  
                     <div class="col-md-3">
                        <div class="form-group">
                             <select name="tipo_servicio" class="form-control" v-model="tipo_servicio">
                             <option value="0">TODOS</option>
                             <option value="1">MAYOR</option>
                             <option value="2">MENOR</option>
                          </select>
                        </div>
                    </div>
               

                  </template>  

                      <template v-if="servicio==2">
                  
                       <div class="col-md-3">
                        <div class="form-group">
                           
                            <select name="tipo_servicio" class="form-control" v-model="tipo_correctivo">
                             <option value="0">TODOS</option>
                             <option value="1">Sistema Motor</option>
                             <option value="2">Sistema Enfriamiento</option>
                             <option value="3">Sistema Embrague</option>
                             <option value="4">Trasmision</option>
                             <option value="5">Suspencion y Direccion</option>
                             <option value="6">Frenos y Ruedas</option>
                             <option value="7">Sistema Electrico</option>
                             <option value="8">Sistema de Escape</option>
                             <option value="9">Traslados y Arrastres de Grua</option>
                             <option value="10">Fuera de contrato</option>
                            
                          </select>
                        </div>
                    </div>
               
                      </template>


                   


                    
                </div>

                 <div class="form-group row border">


                      <div class="col-md-3">
                        <div class="form-group">
                           
                            <select name="tipo_servicio" class="form-control" v-model="ubi">
                             <option value="">ZONAS</option>
                             <option value="Morelia Sur">Morelia Sur</option>
                             <option value="Morelia Poniente">Morelia Poniente</option>
                             <option value="Morelia Norte">Morelia Norte</option>
                             <option value="Morelia Suroeste">Morelia Suroeste</option>
                             <option value="Morelia Centro">Morelia Centro</option>
                             <option value="Zacapu">Zacapu</option>
                             <option value="Puruandiro">Puruandiro</option>
                             <option value="Jiquilpan">Jiquilpan</option>
                             <option value="Sahuayo">Sahuayo</option>
                             <option value="San Jose de Gracia">San Jose de Gracia</option>
                             <option value="Zamora Arboledas">Zamora Arboledas</option>
                             <option value="Zamora Jardinadas">Zamora Jardinadas</option>
                             <option value="Los Reyes">Los Reyes</option>
                             <option value="Cotija">Cotija</option>
                             <option value="Tangancicuaro">Tangancicuaro</option>
                             <option value="Jacona">Jacona</option>
                             <option value="La Piedad">La Piedad</option>
                             <option value="Atotonilco">Atotonilco</option>
                             <option value="Zitacuaro">Zitacuaro</option>
                             <option value="Arandas">Arandas</option>
                             <option value="Divisionales">Divisionales</option>
                             <option value="Colima">Colima</option>
                             <option value="Tecoman">Tecoman</option>
                            
                          </select>
                        </div>
                    </div>
                  
                      <div class="col-md-2">
                        <div class="input-group">
                           <select name="fpago" class="form-control" v-model="criterio">
                             <option value="">AREA</option>
                             <option value="Media tension">Media tension</option>
                             <option value="Alta tension">Alta tension</option>
                             <option value="Baja tension">Baja tension</option>
                             <option value="Subestaciones">Subestaciones</option>
                             <option value="Medicion">Medicion</option>
                             <option value="Programa Especial">Programa Especial</option>
                             <option value="Planeacion">Planeacion</option>
                             <option value="Constructora">Constructora </option>
                             <option value="Personal">Personal</option>
                             <option value="Comunicaciones">Comunicaciones </option>
                             <option value="Comercial">Comercial </option>
                             <option value="Distribucion">Distribucion </option>
                             <option value="Planeacion">Planeacion </option>
                            </select>
                        </div>
                     </div>

                      <div class="col-md-3">
                        <div class="input-group">
                            <select class="form-control col-md-2" v-model="criterios">
                              <option value="identificador">Economico</option>
                              <option value="placas">Placas</option>
                              <option value="vin">Serie</option>
                            </select>
                            <input type="text" v-model="buscar" @keyup.enter="listarVenta(1,buscar,criterios,servicio,tipo_servicio,tipo_correctivo,ubi,criterio,criterio1,fecha_inicio, fecha_final)" class="form-control" placeholder="Texto a buscar">
                           
                        </div>
                    </div>


                    <div class="col-md-2">
                        <div class="input-group">
                            <button type="submit" @click="listarVenta(1,buscar,criterios,servicio,tipo_servicio,tipo_correctivo,ubi,criterio,criterio1,fecha_inicio, fecha_final)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="input-group">
                            <button type="submit" @click="verexel(1,buscar,criterios,servicio,tipo_servicio,tipo_correctivo,ubi,criterio,criterio1,fecha_inicio, fecha_final)" class="btn btn-success"><i class="icon-doc"></i> Exportar</button>
                        </div>
                    </div>
                         </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Opciones</th>
                                <th>No.</th>
                                <th>Fecha y Hora</th>
                                <th>Economico</th>
                                <th>Vehiculo</th>
                                <th>Orden Servicio</th>
                                <th>VIN</th>
                                <th>No. Solicitud</th>
                                <th>Encargado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="venta in arrayVenta" :key="venta.id">
                                <td>
                                     <button type="button" @click="pdfCotizacionp(venta.id)" class="btn btn-success btn-sm">
                                    <i class="icon-doc "></i>
                                    </button> 
                                </td>
                                <td v-text="venta.id"></td>
                                <td v-text="venta.FechaAlta"></td>
                                <td v-text="venta.identificador"></td>
                                <td>{{venta.marca}} {{venta.modelo}} </td>
                                <td v-text="venta.OrdenServicio"></td>
                                <td v-text="venta.vin"></td>
                                <td v-text="venta.NSolicitud"></td>
                                <td v-text="venta.Conductor"></td>
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
            </template>
            <!--Fin Listado-->
            <!--Ver ingreso-->
            <template v-else-if="listado==2">
            <div class="card-body">
                <div class="form-group row border">
                    <div class="col-md-9">
                        <div class="form-group">
                            <label for="">Cliente</label>
                            <p v-text="cliente"></p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="">Impuesto</label>
                        <p v-text="impuesto"></p>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tipo Comprobante</label>
                            <p v-text="tipo_comprobante"></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Serie Comprobante</label>
                            <p v-text="serie_comprobante"></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Número Comprobante</label>
                            <p v-text="num_comprobante"></p>
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
                                    <th>Descuento</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody v-if="arrayDetalle.length">
                                <tr v-for="detalle in arrayDetalle" :key="detalle.id">
                                    <td v-text="detalle.articulo">
                                    </td>
                                    <td v-text="detalle.precio">
                                    </td>
                                    <td v-text="detalle.cantidad">
                                    </td>
                                    <td v-text="detalle.descuento">
                                    </td>
                                    <td>
                                        {{detalle.precio*detalle.cantidad-detalle.descuento}}
                                    </td>
                                <tr style="background-color: #CEECF5;">
                                    <td colspan="4" align="right"><strong>Total Parcial:</strong></td>
                                    <td>$ {{totalParcial=(total-totalImpuesto).toFixed(2)}}</td>
                                </tr>
                                <tr style="background-color: #CEECF5;">
                                    <td colspan="4" align="right"><strong>Total Impuesto:</strong></td>
                                    <td>$ {{totalImpuesto=(total*impuesto).toFixed(2)}}</td>
                                </tr>
                                <tr style="background-color: #CEECF5;">
                                    <td colspan="4" align="right"><strong>Total Neto:</strong></td>
                                    <td>$ {{total}}</td>
                                </tr>
                            </tbody>  
                            <tbody v-else>
                                <tr>
                                    <td colspan="5">
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
                    </div>
                </div>
            </div>
            </template>

             <template v-if="listado==5">
            <div class="card-body">
                <div class="form-group row border">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Empresas(*)</label>
                            <v-select
                                :on-search="selectCliente"
                                label="nombre"
                                :options="arrayCliente"
                                placeholder="Buscar Empresas..."
                                :onChange="getDatosCliente"
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
                                    
                                    <td>Servicios de Paqueteria y Mensajeria</td>
                                    <td v-text="detalle.precio"></td>
                                    <td>1.O</td>
                                    <td v-text="detalle.precio"><input type="hidden" name="customfield" class="form-control" :value="detalle.id" ></td>

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
                        <button type="button" class="btn btn-warning" @click="timbrarprueba()">Vista</button>
                        <button type="button" class="btn btn-primary" @click="timbrar()">Timbrar</button>
                    </div>
                </div>
            </div>
            </template>

             <template v-if="listado==6">
            <div class="card-body">
                <div class="form-group row border">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Empresas(*)</label>
                            <v-select
                                :on-search="selectCliente"
                                label="nombre"
                                :options="arrayCliente"
                                placeholder="Buscar Empresas..."
                                :onChange="getDatosCliente"
                            >
                                
                            </v-select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                           <label for="metododepago">Metodo de pago</label>
                          <select name="mpago" class="form-control" v-model="factura.mpago" :disabled="inputDisabled=1">
                            <option value="PUE">PUE - Pago en una sola exhibicion</option>
                            <option value="PPD">PPD - Pago en parcialidades o diferidos</option>
                          </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                             <label for="formadepago">Forma de pago</label>
                          <select name="fpago" class="form-control" v-model="factura.fpago" :disabled="inputDisabled=1">
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
                 
                </div>

                <div class="form-group row border">
                 <div class="col-md-12">

                 <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                        <label class="col-md-4 form-control-label" for="text-input">Tipo de comprobante:</label>
                            <div class="col-md-8">
                                <select name="mpago" class="form-control" v-model="factura.tcomprobante">
                                     <option value="T">Carta Porte - Traslado</option>
                                </select>
                                
                            </div>
                        </div>
                    </div>       
                    <div class="col-md-6">
                        <div class="row">
                         <label class="col-md-4 form-control-label" for="text-input">Fecha entrega</label>
                            <div class="col-md-8">
                                 <input type="date" v-model="factura.f_entrega" />
                                
                            </div>
                         </div>
                    </div>       
                    
                 </div>

                    <div class="row">
                 <div class="col-md-6">
                        <div class="row">
                     <label class="col-md-4 form-control-label" for="text-input">Remitente:</label>
                            <div class="col-md-8">
                                <input type="text" v-model="factura.remitente" class="form-control" placeholder="">
                                
                            </div>
                            </div>
                    </div>        
                   <div class="col-md-6">
                        <div class="row">
                     <label class="col-md-4 form-control-label" for="text-input">Destinatario:</label>
                            <div class="col-md-8">
                                <input type="text" v-model="factura.destinatario" class="form-control" placeholder="">
                                
                            </div>
                            </div>
                    </div>      
                    
                 </div>

                  <div class="row">
                 <div class="col-md-6">
                        <div class="row">
                     <label class="col-md-4 form-control-label" for="text-input">Domicilio:</label>
                            <div class="col-md-8">
                                <input type="text" v-model="factura.domicilio_remitente" class="form-control" placeholder="">
                                
                            </div>
                            </div>
                    </div>        
                   <div class="col-md-6">
                        <div class="row">
                     <label class="col-md-4 form-control-label" for="text-input">Domicilio:</label>
                            <div class="col-md-8">
                                <input type="text" v-model="factura.domicilio_destinatario" class="form-control" placeholder="">
                                
                            </div>
                            </div>
                    </div>      
                    
                 </div>

                  <div class="row">
                 <div class="col-md-6">
                        <div class="row">
                     <label class="col-md-4 form-control-label" for="text-input">Se Recogerá en:</label>
                            <div class="col-md-8">
                                <input type="text" v-model="factura.serecogera" class="form-control" placeholder="">
                                
                            </div>
                            </div>
                    </div>        
                   <div class="col-md-6">
                        <div class="row">
                     <label class="col-md-4 form-control-label" for="text-input">Se entregara:</label>
                            <div class="col-md-8">
                                <input type="text" v-model="factura.seentregara" class="form-control" placeholder="">
                                
                            </div>
                            </div>
                    </div>      
                    
                 </div>
                    </div>
                 </div>

                          <div class="row">
                 <div class="col-md-6">
                       
                     <label class="col-md-12 form-control-label" for="text-input">Designación y/o Descripción de las Mercancias Transportadas</label>
                            <div class="col-md-12">
                                <textarea class="form-control" v-model="factura.descripcion"  rows="3" placeholder=" "></textarea>
                                
                            </div>
        
                    </div>        
                   <div class="col-md-6">
                        <div class="row">
                           <label class="col-md-4 form-control-label" for="text-input">Peso:</label>
                            <label class="col-md-4 form-control-label" for="text-input">Metros cúbicos:</label>
                            <label class="col-md-4 form-control-label" for="text-input">Litros:</label>
                            <div class="col-md-4">
                                <input type="text" v-model="factura.peso" class="form-control" placeholder="">
                                
                            </div>
                            <div class="col-md-4">
                                <input type="text" v-model="factura.metro" class="form-control" placeholder="">
                                
                            </div>
                            <div class="col-md-4">
                                <input type="text" v-model="factura.litros" class="form-control" placeholder="">
                                
                            </div>
                            </div>
                    </div>      
                    
                 </div>

                 <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                        <label class="col-md-6 form-control-label" for="text-input">Material o Residuo Peligroso:</label>
                            <div class="col-md-6">
                                <select name="mpago" class="form-control" v-model="factura.reciduo">
                                     <option value="No">No</option>
                                     <option value="Si">Si</option>
                                </select>
                                
                            </div>
                        </div>
                    </div>       
                     <div class="col-md-6">
                        <div class="row">
                     <label class="col-md-4 form-control-label" for="text-input">Valor Declarado:</label>
                            <div class="col-md-8">
                                <input type="text" v-model="factura.valord" class="form-control" placeholder="">
                                
                            </div>
                            </div>
                    </div>  
                    
                 </div>

                   <div class="row">
                 <div class="col-md-12">
                       
                     <label class="col-md-12 form-control-label" for="text-input">Idemnización:</label>
                            <div class="col-md-12">
                                <textarea class="form-control" v-model="factura.indemnizacion"  rows="3" placeholder=" "></textarea>
                                
                            </div>
        
                    </div>   
                   </div>

                                 <div class="row">
                 <div class="col-md-6">
                        <div class="row">
                     <label class="col-md-4 form-control-label" for="text-input">Conductor:</label>
                            <div class="col-md-8">
                                <input type="text" v-model="factura.conductor" class="form-control" placeholder="">
                                
                            </div>
                            </div>
                    </div>        
                   <div class="col-md-6">
                        <div class="row">
                     <label class="col-md-4 form-control-label" for="text-input">Vehículo:</label>
                            <div class="col-md-8">
                                <input type="text" v-model="factura.vehiculo" class="form-control" placeholder="">
                                
                            </div>
                            </div>
                    </div>      
                    
                 </div>

                               <div class="row">
                 <div class="col-md-6">
                        <div class="row">
                     <label class="col-md-4 form-control-label" for="text-input">Placas:</label>
                            <div class="col-md-8">
                                <input type="text" v-model="factura.placas" class="form-control" placeholder="">
                                
                            </div>
                            </div>
                    </div>        
                   <div class="col-md-6">
                        <div class="row">
                     <label class="col-md-4 form-control-label" for="text-input">Kilometros:</label>
                            <div class="col-md-8">
                                <input type="text" v-model="factura.kilometros" class="form-control" placeholder="">
                                
                            </div>
                            </div>
                    </div>      
                    
                 </div>

                  
              
                <div class="form-group row">
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
                                    
                                    <td>Servicios de Paqueteria y Mensajeria</td>
                                    <td v-text="detalle.precio"></td>
                                    <td>1.O</td>
                                    <td v-text="detalle.precio"><input type="hidden" name="customfield" class="form-control" :value="detalle.id" ></td>

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
                        <button type="button" class="btn btn-warning" @click="timbrarCartaPorteprueba()">Vista</button>
                        <button type="button" class="btn btn-primary" @click="timbrarCartaPorte()">Timbrar</button>
                    </div>
                </div>
            </div>
            </template>
            <!--Fin ver ingreso-->
        </div>
        <!-- Fin ejemplo de tabla Listado -->
    </div>
</main>
</template>

<script>
import vSelect from 'vue-select';
export default {
data (){
    return {
        factura:{
            tipo_comprobante:"I",
            uso_cfdi:"G01",
            moneda:"MXN",
            fpago:"01",
            tipo_impuesto_local:"1",
            mpago:"PUE"
        },
        check: [],
        venta_id: 0,
        cliente_id:1,
        idcliente:0,
        cliente:'',
        tipo_comprobante : 'BOLETA',
        serie_comprobante : '',
        num_comprobante : '',
        impuesto: 0.16,
        total:0.0,
        totalImpuesto: 0.0,
        totalParcial: 0.0,
        arrayVenta : [],
        arrayCliente : [],
        datoscartaporte:{},
        arrayDetalle : [],
        detallefactura:[],
        listado:1,
        modal : 0,
        tituloModal : '',
        tipoAccion : 0,
        errorVenta : 0,
        inputDisabled:0,
        errorMostrarMsjVenta : [],
        modeloGuia: {
            forma_pago:'01',
            factura:'No',
            empresa :'',
            nombre :'',
            calle :'',
            numero_ext :'',
            numero_int :'',
            colonia :'',
            cp :'',
            ciudad :'',
            estado :'',
            telefono :'',
            servicio : 0,
            tipo_servicio:0,
            cliente_id:1,
            alto:0,
            ancho:0,
            largo:0,
            pesovol:0,
            tarifaseguro:0,
            tarifadeservicio:0,
            valorparaseguro:0,
            embalaje:0,
            otrocobro:0,
            total:0,
        },
        tipo_correctivo:0,
        tipo_servicio:0,
        pagination : {
            'total' : 0,
            'current_page' : 0,
            'per_page' : 0,
            'last_page' : 0,
            'from' : 0,
            'to' : 0,
        },
        offset : 3,
        criterio : '',
        criterio1 : '0',
        servicio : 0,
        fecha_inicio: '',
        fecha_final:'',
        buscar : '',
        criterioA: 'nombre',
        buscarA:'',
        arrayArticulo: [],
        idarticulo: 0,
        codigo: '',
        criterios:'',
        articulo: '',
        precio: 0,
        cantidad: 0,
        descuento: 0,
        stock: 0,
        ubi:'',
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
        for(var i=0;i<this.arrayVenta.length;i++){
            resultado=resultado+(this.arrayVenta[i].total)
        }
        return resultado;
    },

    calcularTotalf: function(){
        var resultado=0.0;
        for(var i=0;i<this.detallefactura.length;i++){
            resultado=resultado+(this.detallefactura[i].precio*1)
        }
        return resultado;
    }
},
methods : {
    pdfCotizacionp(id){
        window.open('ordenes/pdfCFE/'+ id,'_blank');
    },
     selectCliente(search,loading){
        let me=this;
        loading(true)
        var url= 'clientes/selectCliente?filtro='+search;
        axios.get(url).then(function (response) {
            //console.log(response);
            let respuesta= response.data;
            q: search
            me.arrayCliente = respuesta.clientes;
            loading(false)
        })
        .catch(function (error) {
            console.log(error);
        });
    },
     getDatosCliente(val1){
        let me = this;
        me.loading = true;
        console.log(val1.id);
        me.factura.empresa_id= val1.id;
        me.factura.servicio_id = me.criterio1;
    },
    checkChoose: function() {
        var _this = this;
        
    },
    allchoosed: function(){
        var _this = this;
        if(_this.all.flag){
            _this.check = [];
            _this.ball.forEach(function(item, index){
                _this.check.push(item.id);
            });
            _this.all.flage = true;
            _this.all.label = 'Cancelar todas las selecciones';
        }else{
            _this.ball.forEach(function(item, index){
                _this.check = [];
            });
            _this.all.flage = false;
            _this.all.label = 'seleccionar todo';
        }
    },
     timbrarprueba(){
        let me = this;

        axios.post('facturacion/timbrar4',
           {
            'factura' : me.factura,   
            'data' : me.detallefactura
            }).then(function (response) {
            console.log(response.data);
            window.open('facturas/factura_prueba.pdf' ,'_blank');
           
        }).catch(function (error) {
            console.log(error);
        });
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
     timbrarCartaPorte(){
        let me = this;

        axios.post('facturacion/timbrarCartaPorte',
           {
            'factura' : me.factura,   
            'data' : me.detallefactura
            }).then(function (response) {
            console.log(response.data);
            window.open('facturas/cartaporte_prueba.pdf' ,'_blank');
            //me.$toastr.success('Nueva Factura Timbrada', 'Facturación');
            //me.$store.commit('facturacion');  
           

        }).catch(function (error) {
            console.log(error);
        });
    },

    timbrarCartaPorteprueba(){
        let me = this;

        axios.post('facturacion/timbrarCartaPorteprueba',
           {
            'factura' : me.factura,   
            'data' : me.detallefactura
            }).then(function (response) {
            console.log(response.data);
            window.open('facturas/cartaporte_prueba.pdf' ,'_blank');
            //me.$toastr.success('Nueva Factura Timbrada', 'Facturación');
            //me.$store.commit('facturacion');  
           

        }).catch(function (error) {
            console.log(error);
        });
    },

    listarVenta (page,buscar,criterios,servicio,tipo_servicio,tipo_correctivo,ubi,criterio,criterio1, finicio, ffinal){
        let me=this;
        var url= 'ordenesCFEBuscarB2023?page=' + page + '&buscar='+ buscar + '&criterios='+ criterios + '&servicio='+ servicio + '&tipo_servicio='+ tipo_servicio + '&tipo_correctivo='+ tipo_correctivo + '&ubi='+ ubi + '&criterio='+ criterio + '&criterio1='+ criterio1 + '&finicio='+ finicio + '&ffinal='+ ffinal;
        axios.get(url).then(function (response) {
            console.log(response.data);
            var respuesta= response.data;
            me.arrayVenta = respuesta.cotizaciones.data;
            me.pagination= respuesta.pagination;
        })
        .catch(function (error) {
            console.log(error);
        });
    },
    verexel(page,buscar,criterios,servicio,tipo_servicio,tipo_correctivo,ubi,criterio,criterio1, finicio, ffinal){
        let me=this;
        window.open('ordenesCFExelB2023?buscar='+ buscar + '&criterios='+ criterios + '&servicio='+ servicio + '&tipo_servicio='+ tipo_servicio + '&tipo_correctivo='+ tipo_correctivo + '&ubi='+ ubi + '&criterio='+ criterio + '&criterio1='+ criterio1 + '&finicio='+ finicio + '&ffinal='+ ffinal,'_blank');
    },

    facturar(){
        let me=this;
        me.listado=5;
        me.detallefactura = [];

         var url= 'envios/obtenerDetallesmulti';

        axios.post(url,{ 'ides' : me.check}).then(function (response) {
            console.log(response);
            var respuesta= response.data;
            me.detallefactura = respuesta.detalles;

        })
        .catch(function (error) {
            console.log(error);
        });

        
        
    },
     cartaporte(){
        let me=this;
        me.listado=6;
        me.detallefactura = [];

         var url= 'envios/obtenerDetallesmulti';

        axios.post(url,{ 'ides' : me.check}).then(function (response) {
            console.log(response);
            var respuesta= response.data;
            me.detallefactura = respuesta.detalles;

        })
        .catch(function (error) {
            console.log(error);
        });

        
        
    },
    pdfVenta(id){
        window.open('venta/pdf/'+ id ,'_blank');
    },
    cambiarPagina(page,buscar,criterio){
        let me = this;
        //Actualiza la página actual
        me.pagination.current_page = page;
        //Envia la petición para visualizar la data de esa página
        me.listarVenta(page,buscar,criterio);
    },
    mostrarDetalle(){
        let me=this;
        me.listado=0;

        me.idproveedor=0;
            me.tipo_comprobante='BOLETA';
            me.serie_comprobante='';
            me.num_comprobante='';
            me.impuesto=0.18;
            me.total=0.0;
            me.idarticulo=0;
            me.articulo='';
            me.cantidad=0;
            me.precio=0;
            me.arrayDetalle=[];
    },
    ocultarDetalle(){
        this.listado=1;
    },
    verVenta(id){
        let me=this;
        me.listado=2;

        //Obtener datos del ingreso
        var arrayVentaT=[];
        var url= 'venta/obtenerCabecera?id=' + id;

        axios.get(url).then(function (response) {
            var respuesta= response.data;
            arrayVentaT = respuesta.venta;
            
            me.cliente = arrayVentaT[0]['nombre'];
            me.tipo_comprobante=arrayVentaT[0]['tipo_comprobante'];
            me.serie_comprobante=arrayVentaT[0]['serie_comprobante'];
            me.num_comprobante=arrayVentaT[0]['num_comprobante'];
            me.impuesto=arrayVentaT[0]['impuesto'];
            me.total=arrayVentaT[0]['total'];
        })
        .catch(function (error) {
            console.log(error);
        });

        //obtener datos de los detalles
         var url= 'venta/obtenerDetalles?id=' + id;

        axios.get(url).then(function (response) {
            console.log(response);
            var respuesta= response.data;
            me.arrayDetalle = respuesta.detalles;

        })
        .catch(function (error) {
            console.log(error);
        });
    },

},
mounted() {
    this.listarVenta(1,this.buscar,this.criterio);
},
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
@media (min-width: 600px) {
.btnagregar {
    margin-top: 2rem;
}
}

</style>
