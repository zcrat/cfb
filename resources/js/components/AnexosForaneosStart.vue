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
                <i class="fa fa-align-justify"></i> Start Foraneos
               
            </div>
            <!-- Listado-->
            <template v-if="listado==1">
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-3">
                     <select class="form-control" v-model="contrato"  @change="buscarContrato(contrato)" >
                         <option value="0">Clientes</option>
                         <option v-for="plantel in arrayPlanteles" :key="plantel.id" :value="plantel" v-text="plantel.nombre" ></option>
                      </select>
                     </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <select class="form-control col-md-3" v-model="criterio">
                                <option value="anexosFVehiculos.identificador">Economico</option>
                              <option value="anexosFVehiculos.vin">Serie</option>
                              <option value="anexosFVehiculos.placas">Placas</option>
                              <option value="anexosFGenerales.NSolicitud">Folio</option>
                            </select>
                            <input type="text" v-model="buscar" @keyup.enter="listarIngreso(1,buscar,criterio,'0')" class="form-control" placeholder="Texto a buscar">
                            <button type="submit" @click="listarIngreso(1,buscar,criterio,'0')" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Opciones</th>
                                <th>Folio</th>
                                <th>Economico</th>
                                <th>Marca</th>
                                <th>Modelos</th>
                                <th>Año</th>
                                <th>Placas</th>
                                <th>VIN</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="cotizacion in arrayCotizacion" :key="cotizacion.id">
                                <td>
                                     <template v-if="cotizacion.status == 0">
                                    
                                     <select name="LeaveType" @change="onChange($event,cotizacion)" class="form-control">
                                        <option value="0">Opciones de operación</option>
                                        <option value="2">Editar</option>
                                        <option value="4">Fotos Generales</option>
                                        <option value="7">Orden de servicio</option>
                                        <option value="13">Entrada</option>
                                    </select>   

                                     </template>


                                    <template v-if="cotizacion.status == 1">

                                    <select name="LeaveType" @change="onChange($event,cotizacion)" class="form-control">
                                        <option value="0">Opciones de operación</option>
                                        <option value="2">Editar</option>
                                        <option value="4">Fotos Generales</option>
                                        <option value="7">Orden de servicio</option>
                                        <option value="13">Entrada</option>
                                    </select>   



                                    <!-- <button type="button" class="btn btn-danger btn-sm" @click="desactivarIngreso(cotizacion.id)">
                                    <i class="icon-trash"></i>
                                    </button>
                                    <button type="button" class="btn btn-warning btn-sm" @click="abrirModalC('cotizacion','actualizar',cotizacion)">
                                    <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-info btn-sm" title="Recepcion Vehicular" @click="reporte(cotizacion.NSolicitud)" >
                                    <i class="fa fa-file-invoice"></i>
                                    </button>
                                    <button type="button" class="btn btn-warning btn-sm" title="Fotos Viejas" @click="fotosviejas(cotizacion.id)">
                                    <i class="fa fa-picture-o"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm" @click="pdfCotizacion(cotizacion.id)" title="Presupuesto Costos">
                                    <i class="fa fa-file-invoice"></i>
                                    </button>
                                       <button type="button" class="btn btn-dark btn-sm" @click="pdfCotizacionAcuse(cotizacion.id)" title="Acuse">
                                    <i class="fa fa-file-invoice"></i>
                                    </button>
                                      <button type="button" class="btn btn-secondary btn-sm" title="Reporte Anomalias"  @click="reporteAnomalias(cotizacion.id)">
                                    <i class="fa fa-file-invoice"></i>
                                    </button> -->
                                    </template>


                                     <template v-if="cotizacion.status == 2">
                                     <select name="LeaveType" @change="onChange($event,cotizacion)" class="form-control">
                                        <option value="0">Opciones de operación</option>
                                        <option value="2">Editar</option>
                                        <option value="4">Fotos Generales</option>
                                        <option value="7">Orden de servicio</option>
                                        <option value="13">Entrada</option>
                                    </select>  
                                    </template>

                                     <template v-if="cotizacion.status == 3">
                                    <select name="LeaveType" @change="onChange($event,cotizacion)" class="form-control">
                                        <option value="0">Opciones de operación</option>
                                        <option value="2">Editar</option>
                                        <option value="4">Fotos Generales</option>
                                        <option value="7">Orden de servicio</option>
                                        <option value="13">Entrada</option>
                                        <option value="9">Fotos Instaladas</option>
                                        <option value="8">Gastos</option>
                                        <option value="10">Factura PDF</option>
                                        <option value="11">Factura XML</option>
                                        <option value="12">Acuse</option>
                                    </select>  
                       
                                    <!-- <button type="button" class="btn btn-light btn-sm" title="Fotos Nuevas"  @click="fotosnuevas(cotizacion.id)">
                                    <i class="fa fa-picture-o"></i>
                                    </button>
                                    <button type="button" class="btn btn-dark btn-sm" title="Fotos Instaladas"  @click="fotosinstaladas(cotizacion.id)">
                                    <i class="fa fa-picture-o"></i>
                                    </button>
                                     <button type="button" class="btn btn-danger btn-sm" title="Factura PDF" @click="facturapdf(cotizacion.id)">
                                    <i class="fa fa-file-invoice"></i>
                                    </button> 
                                     <button type="button"class="btn btn-success btn-sm" title="Factura XML" @click="facturaxml(cotizacion.id)">
                                    <i class="fa fa-file-invoice"></i>
                                    </button> 
                                     <button type="button" class="btn btn-dark btn-sm" title="Acuse Firmado"  @click="acuse(cotizacion.id)">
                                    <i class="fa fa-picture-o"></i>
                                    </button> -->
                                    </template>

                                     <template v-if="cotizacion.status == 4">
                                    <select name="LeaveType" @change="onChange($event,cotizacion)" class="form-control">
                                        <option value="0">Opciones de operación</option>
                                        <option value="2">Editar</option>
                                        <option value="4">Fotos Generales</option>
                                        <option value="7">Orden de servicio</option>
                                        <option value="9">Fotos Instaladas</option>
                                        <option value="8">Gastos</option>
                                        <option value="10">Factura PDF</option>
                                        <option value="11">Factura XML</option>
                                        <option value="12">Acuse</option>
                                        <option value="13">Entrada</option>
                                    </select>  
                                     </template>    

                                       <template v-if="cotizacion.status == 5">
                                    <select name="LeaveType" @change="onChange($event,cotizacion)" class="form-control">
                                        <option value="0">Opciones de operación</option>
                                        <option value="2">Editar</option>
                                        <option value="4">Fotos Generales</option>
                                        <option value="7">Orden de servicio</option>
                                        <option value="9">Fotos Instaladas</option>
                                        <option value="8">Gastos</option>
                                        <option value="10">Factura PDF</option>
                                        <option value="11">Factura XML</option>
                                        <option value="12">Acuse</option>
                                        <option value="13">Entrada</option>
                                    </select>   
                                     </template>    
                                </td>
                                <td v-text="cotizacion.NSolicitud"></td>
                                <td v-text="cotizacion.identificador"></td>
                                <td v-text="cotizacion.marca"></td>
                                <td v-text="cotizacion.modelo"></td>
                                <td v-text="cotizacion.ano"></td>
                                <td v-text="cotizacion.placas"></td>
                                <td v-text="cotizacion.vin"></td>
                                <td v-text="cotizacion.created_at"></td>
                                <td v-text="cotizacion.listo"></td>
                                 <td>
                                       <template v-if="cotizacion.status == 0">
                                     <button type="button" class="btn btn-warning btn-sm" title="Boton de terminar" @click="cambiostatus(cotizacion.id,'1')">
                                    ENVIAR
                                    </button> 
                                       </template>
                                        <template v-if="cotizacion.status == 1">
                                     <button type="button" class="btn btn-secondary btn-sm" title="Boton de terminar">
                                    PENDIENTE
                                    </button> 
                                      <button type="button" class="btn btn-warning btn-sm" title="Factura XML" @click="abrirModal3(cotizacion)">
                                    <i class="fa fa-comment-alt"></i>
                                    </button>   
                                       </template>
                                       <template v-if="cotizacion.status == 2">
                                     <button type="button" class="btn btn-secondary btn-sm" title="Boton de terminar">
                                    PENDIENTE
                                    </button> 
                                      <button type="button" class="btn btn-warning btn-sm" title="Factura XML" @click="abrirModal3(cotizacion)">
                                    <i class="fa fa-comment-alt"></i>
                                    </button>   
                                       </template>
                                        <template v-if="cotizacion.status == 3">
                                     <button type="button" class="btn btn-primary btn-sm" title="Boton de terminar" @click="cambiostatus(cotizacion.id,'4')">
                                    CERRAR
                                    </button> 
                                       </template>
                                       <template v-if="cotizacion.status == 4">
                                     <button type="button" class="btn btn-success btn-sm" title="Boton de autorizacion">
                                    TERMINADO
                                    </button> 
                                     </template>
                                         <template v-if="cotizacion.status == 5">
                                     <button type="button" class="btn btn-success btn-sm" title="Boton de autorizacion">
                                    TERMINADO
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
<div class="modal fade fade bd-example-modal-lg" id="exampleModalCenter2" :class="{'mostrar2' : modal2}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" >Agregar fotos viejas</h5>
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
                    <div class="col-md-4">
                         <button type="button" class="btn btn-success" title="Fotos Viejas" @click="verFotosViejas()">
                         <i class="fa fa-picture-o"></i>
                        </button>
                    </div>   
                    <div class="col-md-8">
                        <button type="button" @click="cerrarModal()" class="btn btn-secondary">Cerrar</button>
                        <button type="button" class="btn btn-primary" @click="guardarFotosviejas()" :disabled="disabled == 1">Guardar</button>
                    </div>
</div>


</div>
</div>
</div>
</div>
<!-- Modal -->
<div class="modal fade fade bd-example-modal-lg" id="exampleModalCenter2" :class="{'mostrar3' : modal3}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" >Agregar Reporte Anomalias</h5>
<button type="button" class="close" @click="cerrarModal">
  <span aria-hidden="true">&times;</span>
</button>
</div>


<div class="modal-body">
 <div class="form-group row">
       <label class="col-md-3 form-control-label" for="text-input">Archivo</label>
        <div class="col-md-9">
        <input id="folio-id" class="form-control" type="file" @change="subirarchivo2">
     </div>
 </div>
</div>
 <div class="modal-footer">
<div class="form-group row">
                    <div class="col-md-4">
                         <button type="button" class="btn btn-success" title="Fotos Viejas" @click="verReporteAnomalias()">
                         <i class="fa fa-picture-o"></i>
                        </button>
                    </div>   
                    <div class="col-md-8">
                        <button type="button" @click="cerrarModal()" class="btn btn-secondary">Cerrar</button>
                        <button type="button" class="btn btn-primary" @click="guardarReporteAnomalias()" :disabled="disabled == 1" >Guardar</button>
                    </div>
</div>


</div>
</div>
</div>
</div>
<div class="modal fade fade bd-example-modal-lg" id="exampleModalCenter2" :class="{'mostrar4' : modal4}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" >Agregar Fotos Nuevas</h5>
<button type="button" class="close" @click="cerrarModal">
  <span aria-hidden="true">&times;</span>
</button>
</div>


<div class="modal-body">
 <div class="form-group row">
       <label class="col-md-3 form-control-label" for="text-input">Archivo</label>
        <div class="col-md-9">
        <input id="folio-id" class="form-control" type="file" @change="subirarchivo3">
     </div>
 </div>
</div>
 <div class="modal-footer">
<div class="form-group row">
                     <div class="col-md-4">
                         <button type="button" class="btn btn-success" title="Fotos Viejas" @click="verFotosNuevas()">
                         <i class="fa fa-picture-o"></i>
                        </button>
                    </div>   
                    <div class="col-md-12">
                        <button type="button" @click="cerrarModal()" class="btn btn-secondary">Cerrar</button>
                        <button type="button" class="btn btn-primary" @click="guardarFotosNuevas()" :disabled="disabled == 1" >Guardar</button>
                    </div>
</div>


</div>
</div>
</div>
</div>
<div class="modal fade fade bd-example-modal-lg" id="exampleModalCenter2" :class="{'mostrar5' : modal5}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" >Agregar Fotos Instaladas</h5>
<button type="button" class="close" @click="cerrarModal">
  <span aria-hidden="true">&times;</span>
</button>
</div>


<div class="modal-body">
 <div class="form-group row">
       <label class="col-md-3 form-control-label" for="text-input">Archivo</label>
        <div class="col-md-9">
        <input id="folio-id" class="form-control" type="file" @change="subirarchivo4">
     </div>
 </div>
</div>
 <div class="modal-footer">
<div class="form-group row">
                   <div class="col-md-4">
                         <button type="button" class="btn btn-success" title="Fotos Viejas" @click="verFotosInstaladas()">
                         <i class="fa fa-picture-o"></i>
                        </button>
                    </div>   
                    <div class="col-md-12">
                        <button type="button" @click="cerrarModal()" class="btn btn-secondary">Cerrar</button>
                        <button type="button" class="btn btn-primary" @click="guardarFotosInstaladas()" :disabled="disabled == 1" >Guardar</button>
                    </div>
</div>


</div>
</div>
</div>
</div>
<div class="modal fade fade bd-example-modal-lg" id="exampleModalCenter2" :class="{'mostrar6' : modal6}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" >Agregar Acuse</h5>
<button type="button" class="close" @click="cerrarModal">
  <span aria-hidden="true">&times;</span>
</button>
</div>


<div class="modal-body">
 <div class="form-group row">
       <label class="col-md-3 form-control-label" for="text-input">Archivo</label>
        <div class="col-md-9">
        <input id="folio-id" class="form-control" type="file" @change="subirarchivo5">
     </div>
 </div>
</div>
 <div class="modal-footer">
<div class="form-group row">
                    <div class="col-md-4">
                         <button type="button" class="btn btn-success" title="Fotos Viejas" @click="verAcuse()">
                         <i class="fa fa-picture-o"></i>
                        </button>
                    </div>  
                    <div class="col-md-12">
                        <button type="button" @click="cerrarModal()" class="btn btn-secondary">Cerrar</button>
                        <button type="button" class="btn btn-primary" @click="guardarAcuse()" :disabled="disabled == 1" >Guardar</button>
                    </div>
</div>


</div>
</div>
</div>
</div>
<div class="modal fade fade bd-example-modal-lg" id="exampleModalCenter2" :class="{'mostrar13' : modal13}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" >Agregar Entrada</h5>
<button type="button" class="close" @click="cerrarModal">
  <span aria-hidden="true">&times;</span>
</button>
</div>


<div class="modal-body">
 <div class="form-group row">
       <label class="col-md-3 form-control-label" for="text-input">Archivo</label>
        <div class="col-md-9">
        <input id="folio-id" class="form-control" type="file" @change="subirarchivo9">
     </div>
 </div>
</div>
 <div class="modal-footer">
<div class="form-group row">
                    <div class="col-md-4">
                         <button type="button" class="btn btn-success" title="Fotos Viejas" @click="verEntrada()">
                         <i class="fa fa-picture-o"></i>
                        </button>
                    </div>  
                    <div class="col-md-12">
                        <button type="button" @click="cerrarModal()" class="btn btn-secondary">Cerrar</button>
                        <button type="button" class="btn btn-primary" @click="guardarEntrada()" :disabled="disabled == 1" >Guardar</button>
                    </div>
</div>


</div>
</div>
</div>
</div>
<div class="modal fade fade bd-example-modal-lg" id="exampleModalCenter2" :class="{'mostrar8' : modal8}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" >Agregar Factura XML</h5>
<button type="button" class="close" @click="cerrarModal">
  <span aria-hidden="true">&times;</span>
</button>
</div>


<div class="modal-body">
 <div class="form-group row">
       <label class="col-md-3 form-control-label" for="text-input">Archivo</label>
        <div class="col-md-9">
        <input id="folio-id" class="form-control" type="file" @change="subirarchivo6">
     </div>
 </div>
</div>
 <div class="modal-footer">
<div class="form-group row">
                   <div class="col-md-4">
                         <button type="button" class="btn btn-success" title="Fotos Viejas" @click="verFacturaXML()">
                         <i class="fa fa-picture-o"></i>
                        </button>
                    </div>  
                    <div class="col-md-12">
                        <button type="button" @click="cerrarModal()" class="btn btn-secondary">Cerrar</button>
                        <button type="button" class="btn btn-primary" @click="guardarFacturaXML()" :disabled="disabled == 1" >Guardar</button>
                    </div>
</div>


</div>
</div>
</div>
</div>
<div class="modal fade fade bd-example-modal-lg" id="exampleModalCenter2" :class="{'mostrar9' : modal9}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" >Agregar Factura PDF</h5>
<button type="button" class="close" @click="cerrarModal">
  <span aria-hidden="true">&times;</span>
</button>
</div>


<div class="modal-body">
 <div class="form-group row">
    
       <label class="col-md-3 form-control-label" for="text-input">Archivo</label>
        <div class="col-md-9">
        <input id="folio-id" class="form-control" type="file" @change="subirarchivo7">
     </div>
 </div>
</div>
 <div class="modal-footer">
<div class="form-group row">
                     <div class="col-md-4">
                         <button type="button" class="btn btn-success" title="Fotos Viejas" @click="verFacturaPDF()">
                         <i class="fa fa-picture-o"></i>
                        </button>
                    </div>  
                    <div class="col-md-12">
                        <button type="button" @click="cerrarModal()" class="btn btn-secondary">Cerrar</button>
                        <button type="button" class="btn btn-primary" @click="guardarFacturaPDF()" :disabled="disabled == 1" >Guardar</button>
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

                     <div class="col-md-3">
                        <div class="form-group">
                            <label>Ubicación</label>
                            <input type="text" class="form-control" v-model="ubicacion" placeholder="000xx">
                        </div>
                    </div>

                </div>
                 <p class="h5 text-uppercase font-weight-bold  border-bottom">Datos Generales Solicitud</p>
                <div class="form-group row border">

                     <div class="col-md-3">
                        <div class="form-group">
                            <label>Folio</label>
                            <input type="text" class="form-control" v-model="NSolicitud" placeholder="000xx" @keyup.enter="getOrdenSeguimineto" >
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                             <label>Fecha Alta:</label>
                             <input type="date" class="form-control" v-model="FechaAlta" placeholder="000xx">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>ID</label>
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
                            <label>Administrador de trasportes</label>
                            <input type="text" class="form-control" v-model="clienteYRazonSocial" placeholder="000xx">
                        </div>
                    </div>
                    
                     <div class="col-md-3">
                        <div class="form-group">
                            <label>Jefe de Proceso.</label>
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
                            <label>Trabajador</label>
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
                <template v-if="tipoAccion==1">
                 <p class="h5 text-uppercase font-weight-bold  border-bottom">ELIJA EL SERVICIO</p>
                <div class="form-group row border">

                     <div class="col-md-4">
                        <div class="form-group">
                            <label>Servicio</label>
                            <select name="tipo_servicio" class="form-control" v-model="servicio">
                             <option value="1">Preventivo</option>
                             <option value="2">Correctivo</option>
                            
                          </select>
                        </div>
                    </div>

                      <div class="col-md-4">
                        <div class="form-group">
                            <label>Ubicacion</label>
                             <select class="form-control" v-model="ubi" >
                                    <option v-for="plantel in arrayUbicaicones" :key="plantel.id" :value="plantel.nombre" v-text="plantel.nombre"></option>
                            </select>
                           
                        </div>
                         <div class="col-12 mt-2 text-center">
                                                <button class="col- btn btn-primary"
                                                        @click="vistaUbicacionRegistrar"><i
                                                        class="fa fa-plus-circle"></i>
                                                </button>
                                            </div>
                    </div>

                       <div class="col-md-4">
                        <div class="form-group">
                            <label>Area</label>
                            <select name="tipo_servicio" class="form-control" v-model="area">
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
                   


                  </div>
                   <template v-if="servicio==1">
                   <div class="form-group row border">
                     <div class="col-md-3">
                        <div class="form-group">
                            <label>Tipo de servicio</label>
                            <select name="tipo_servicio" class="form-control" v-model="tipo_servicio">
                             <option value="1">Mayor</option>
                             <option value="2">Menor</option>
                            
                          </select>
                        </div>
                    </div>

                     <div class="col-md-3">
                        <div class="form-group">
                            <label>Kilometros</label>
                            <input type="text" class="form-control" v-model="kmservicio" placeholder="000xx">
                        </div>
                    </div>
                  </div>

                  </template>  

                      <template v-if="servicio==2">
                   <div class="form-group row border">
                     <div class="col-md-3">
                        <div class="form-group">
                           <div>
                            <label class="typo__label">Correctivos</label>
                            <multiselect v-model="value" tag-placeholder="Add this as new tag" placeholder="Search or add a tag" label="name" track-by="code" :options="options" :multiple="true" :taggable="true" @tag="addTag"></multiselect>
                            
                            </div>
                        </div>
                    </div>

                  
                  </div>
                      </template>
                       <div class="row" v-if="registrarUbicacion">
                                <!--Formulario nueva empresa-->
                                <div class="col-12 border">
                                    <div class="row">
                                        <div class="col-12">
                                            <h5 class="border-bottom pt-2">Registrar nueva Ubicacion</h5>
                                        </div>
                                    
                                        <div class="col-12 col-lg-12">
                                            <div class="form-group border-bottom">
                                                <label for="empresa-agregar-nombre">Nombre<i
                                                        class="fa fa-asterisk  text-secundary ml-2"></i>
                                                </label>
                                                <input id="empresa-agregar-nombre" type="text"
                                                       class="form-control" placeholder="Ej. Akumas"
                                                       v-model="modeloUbicacion.nombre">
                                            </div>
                                        </div>
                                   
                           
                   
                                        <div class="col-12 text-right p-3">
                                            <button class="btn btn-primary" @click="guardarUbicacion"><i
                                                    class="fa fa-floppy-o mr-2"></i>Guardar
                                            </button>
                                            <button class="btn btn-secondary" @click="vistaUbicacionRegistrar"><i
                                                    class="fa fa-times mr-2"></i>Canclear
                                            </button>
                                        </div>


                                    </div>
                                </div>
                                <!--End Formulario nueva empresa-->
                            </div>

                  </template> 
<template v-if="zonauno==0">
                <div class="form-group row">
                    <div class="col-md-9">
                        <div class="form-group">
                        
                        </div>
                    </div>

                   
                    <div class="col-md-3">
                        <div class="form-group">
                         
                        <button  type="button" class="btn btn-warning" @click="abrirModal1" > <i class="icon-plus"></i>&nbsp;AGREGAR</button>
                          <button  type="button" class="btn btn-primary" @click="abrirModal"> <i class="icon-plus"></i>&nbsp;CONCEPTOS</button>
                           </div>
                    </div>
                   
                </div>

<!-- Modal -->
<div class="modal fade fade bd-example-modal-lg" id="exampleModalCenter2" :class="{'mostrar' : modal}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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

<button type="button" class="btn btn-primary" @click="buscarConceptops(categorias_id,tipos_id)" >Buscar</button>
<button type="button" class="btn btn-secondary" @click="cerrarModal" >Atras</button>
</div>
<div class="modal-body">
 <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                  
                                    <th>SELECT</th>
                                    <th>CANTIDAD</th>
                                    <th>DESCRIPCION</th>
                                    <th>TOTAL</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody v-if="arrayConceptos.length">
                                <tr v-for="detalle in arrayConceptos" :key="detalle.id">
                                    <td><input type="checkbox"  v-model="check" :value="detalle" @click.stop="checkChoose()"></td>
                                    
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
                        
</div>
<div class="modal-footer">
<div class="form-group row">
                    <div class="col-md-12">
                        <button type="button" @click="cerrarModal()" class="btn btn-secondary">Cerrar</button>
                        <button type="button" class="btn btn-primary" @click="agregarDetalles()"  >Agregar</button>
                    </div>
</div>


</div>
</div>
</div>
</div>


                                                      
                      

<!-- Modal -->
<div class="modal fade fade bd-example-modal-lg" id="exampleModalCenter2" :class="{'mostrar1' : modal1}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                v-model="Producto"
                            >
                                
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
                                         <button type="button" id="enviar" class="btn btn-primary" @click="agregarConcepto(arrayProducto)" >Agregar</button>
                                    </div>
                                </div>
                               </div>

                               </div>
                             </div>
                           </div>
                         </div>    

<p class="h5 text-uppercase font-weight-bold  border-bottom">DIAGNÓSTICO</p>
<table class="table table-bordered table-striped table-sm" id="tabla">
<thead>
<tr style="background-color:#666; color:#fff"> 
    <th>CÓDIGO</th>
    <th>CANTIDAD</th>
    <th>CONCEPTO</th>
    <th>PRECIO UNITARIO</th>
    <th>TOTAL</th>
    <th>ACCIONES</th>
   
</tr>
</thead>
<tbody v-if="detalleConceptos.length">
                       
<tr v-for="(detalle,index) in detalleConceptos" :key="detalle.id">
                                    <td>
                                      
                                    </td>
                                    <td>
                                         <input v-model="detalle.cantidad" type="number" size="3" value="1" >
                                    </td>
                                    <td>
                                        {{detalle.descripcion}}
                                    </td>
                                    <td>
                
                                        <input v-model="detalle.precio" type="number"  class="form-control">
                                    </td>
                                    <td>
                                       {{detalle.precio*detalle.cantidad}}
                                    </td>
                                    <td>
                                         <button type="button" class="btn btn-danger btn-sm" @click="borrar(detalle.id)">
                                    <i class="icon-trash"></i>
                                    </button>
                                    </td>
                                    
                              
                                </tr>
                            </tbody>  
                            <tbody v-else>
                                <tr>
                                    <td colspan="6">
                                        No hay articulos agregados
                                    </td>
                                </tr>
                            </tbody> 
</table>
<br />

               
                <div class="form-group row">

<div class="col-md-8">
<div class="form-group">

</div>
</div>




</div>
<br />

                <table class="table table-bordered table-striped table-sm" id="tabla">
                    <thead>
                        <tr style="background-color:#666; color:#fff"> 
                            <th>DESCRIPCIÓN M.O.</th>
                              <th> TIEMPO DE ENTREGA</th>
                           
                            <th>IMPORTE</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        <tr >
                            <td>  <textarea v-model="descripcionMO" cols="30" rows="4" class="form-control" ></textarea></td>
                             <td>  <textarea v-model="tdeentrega" cols="15" rows="4" class="form-control" ></textarea></td>
                           
                            <td><input type="text" v-model="importe=calcularTotal" class="form-control"> </td>
                           
                           
                        </tr>                                
                    </tbody>
                </table>

                <div class="form-group row">

                <div class="col-md-8">
                <div class="form-group">
                   
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                        <label for="totalp" style="padding:2ch; background-color:#666; color:#fff">SUBTOTAL: <div id="subtotal">$ {{totalpre=calcularTotal}}</div> </label>
                       
                        </div>
                    </div>

                  

                   
                </div>
                <div class="form-group row">

<div class="col-md-8">
<div class="form-group">

</div>
</div>

<div class="col-md-3">
<div class="form-group">
<label for="totalp" style="padding:2ch; background-color:#666; color:#fff">IVA: <div id="iva">$ {{totalpre*0.16}}</div></label>

</div>
</div>




</div>
<div class="form-group row">

<div class="col-md-8">
<div class="form-group">

</div>
</div>

<div class="col-md-3">
<div class="form-group">
<label for="totalp" style="padding:2ch; background-color:#666; color:#fff">TOTAL: <div id="grantotal">$ {{(totalpre*1.16).toFixed(2)}}</div> </label>

</div>
</div>




</div>
<br />
<div class="form-group row">


<div class="col-12">
<div class="form-group">
               
</div>
</div>




</div>

</template>

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

             <div class="modal fade fade bd-example-modal-lg" id="exampleModalCenter2" :class="{'mostrar55' : modal55}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" >Mensajes</h5>
<button type="button" class="close" @click="cerrarModal">
  <span aria-hidden="true">&times;</span>
</button>
</div>

<div class="modal-footer">

</div>
<div class="modal-body">
 <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Usuario</th>
                                    <th>Mensaje</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody v-if="arrayMensajes.length">
                                <tr v-for="mensaje in arrayMensajes" :key="mensaje.id">
                                    <td v-text="mensaje.nombre"></td>
                                    <td v-text="mensaje.mensaje"></td>
                                    <td v-text="mensaje.fecha"></td>
                                   
                                </tr>
                             
                              
                            </tbody>  
                            <tbody v-else>
                                <tr>
                                    <td colspan="4">
                                        No hay mensajes
                                    </td>
                                </tr>
                            </tbody>                                  
                        </table>
                        
</div>
<div class="modal-footer">
<div class="form-group row">
                    <div class="col-md-12">
                        <textarea v-model="mensajetext" cols="300" rows="2" class="form-control" ></textarea>
                        <button type="button" @click="cerrarModal()" class="btn btn-secondary">Cerrar</button>
                        <button type="button" class="btn btn-primary" @click="enviarMensaje(mensajetext,id_orden)"  >Enviar</button>
                    </div>
</div>


</div>
</div>
</div>
</div>

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
        value: [],
        options: [
            { name: 'Sistema Motor', code: '1' },
            { name: 'Sistema Enfriamiento', code: '2' },
            { name: 'Sistema de Embrague', code: '3' },
            { name: 'Trasmision', code: '4' },
            { name: 'Suspencion y Direccion', code: '5' },
            { name: 'Frenos y Ruedas', code: '6' },
            { name: 'Sistema Electrico', code: '7' },
            { name: 'Sistema de Escape', code: '8' },
            { name: 'Traslados y Arrastre de Grua', code: '9' },
            { name: 'Fuera de Contrato', code: '10' },
            
        ],
        detallefactura:[],
        arrayConceptos:[],
        ingreso_id: 0,
        idempresa:0,
        idcotizacion:0,
        categorias_id:0,
        arrayUbicaicones : [],
        tipos_id:0,
        empresa:'',
        doc:'',
        nombre : '',
        presupuestoCFE_id : '',
        fecha: '',
        odes : '',
        ejecutivo: '',
        contrato:0,

        registrarCategoria: false,
        modeloCategoria: {},

        registrarTipo: false,
        modeloTipos: {},

        economico: '',
        modelo: '',
        vin : '',
        placas : '',
        ano : '',
        kilometraje : '',
        marca : '',
        check: [],
        NSolicitud: '',
        FechaAlta : '',
        ordenServicio:'',
        registrarUbicacion: false,
        modeloUbicacion: {},
        kmDeIngreso : '',
        clienteYRazonSocial : '',
        Mail : '',
        Telefono : '',
        Conductor : '',
        ubicacion:'',
        tdeentrega:'',
        observaciones : '',
        archivo_pdf:'',
        idpresupuesto:0,
        idvehiculo : 0,
        idgenerales:0,
        total:0.0,
        totalpre:0.0,
        totalImpuesto: 0.0,
        totalParcial: 0.0,
        arrayCotizacion : [],
        arrayEmpresa : [],
        arrayCategorias : [],
        arrayProducto:{},
        arrayDetalleCotizacion:{},
        Producto:{},
        arrayTipos : [],
        arrayProductos : [],
        arrayDetalle : [],
        detalleConceptos :[],
        pciva:0.0,
        tipo_servicio:0,
        kmservicio:'',
        servicio:0,
        listado:1,
        modal : 0,
        modal1 : 0,
        modal2 : 0,
        modal3 : 0,
        modal4 : 0,
        modal5 : 0,
        modal6 : 0,
        modal7 : 0,
        modal8 : 0,
        modal9 : 0,
        modal13 : 0,
        tituloModal : '',
        tipoAccion : 0,
        disabled:1,
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
        arrayMensajes:[],
        modal55 : 0,
        id_orden:0,
        mensajetext:'',
        criterio : 'num_comprobante',
        buscar : '',
        criterioA: 'nombre',
        zonauno : 1,
        area:'',
        ubi:'',
        ptotal:0.0,
        buscarA:'',
        arrayArticulo: [],
        arrayPlanteles:[],
        idarticulo: 0,
        codigo: '',
        articulo: '',
        archivo : '',
        precio: 0,
        cantidad: 0,
        unidad: '',
        unidad_sat: '',
        codigo_sat:'',
        descripcion : '',
        descripcionMO : '',
        importe : 0.00,
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
        for(var i=0;i<this.detalleConceptos.length;i++){
            resultado=resultado+(this.detalleConceptos[i].precio*this.detalleConceptos[i].cantidad)
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
    enviarMensaje(mensaje, idorden){
        console.log('orden '+ idorden);
        console.log('mensaje '+ mensaje);
        
        let me = this;

        axios.post('mensajes/enviar',
           {
            'id' : idorden,   
            'mensaje' : mensaje
            }).then(function (response) {
            console.log(response.data);
            me.$toastr.success('Mensaje enviado', 'Mensaje');
            me.listarMensajes(idorden);
            me.mensajetext = '';

        }).catch(function (error) {
            console.log(error);
        });
    },
    listarMensajes(id){
        let me=this;
        var url= 'mensajes?id=' + id;
        axios.get(url).then(function (response) {
            console.log(response.data);
            var respuesta= response.data;
            me.arrayMensajes = respuesta.mensajes;
        })
        .catch(function (error) {
            console.log(error);
        });
    },
     abrirModal3(orden){
        this.arrayMensajes=[];
        this.id_orden = orden.id;
        this.modal55 = 1;
        this.listarMensajes(orden.id)
        this.tituloModal = '';

    },
     onChange(event , cotizacion ) {
        console.log(event.target.value);
        if(event.target.value == 1){
            this.desactivarIngreso(cotizacion.id);
        }
        if(event.target.value == 2){
            this.abrirModalC('cotizacion','actualizar',cotizacion);
        }
        if(event.target.value == 3){
            this.reporte(cotizacion.NSolicitud);
        }
        if(event.target.value == 4){
            this.fotosviejas(cotizacion.id);
         }
        if(event.target.value == 5){
            this.pdfCotizacion(cotizacion.id);
        }
        if(event.target.value == 6){
            this.pdfCotizacionAcuse(cotizacion.id)
        }
        if(event.target.value == 7){
            this.reporteAnomalias(cotizacion.id);
        }
        if(event.target.value == 8){
            this.fotosnuevas(cotizacion.id);
        }
        if(event.target.value == 9){
            this.fotosinstaladas(cotizacion.id);
        }
        if(event.target.value == 10){
            this.facturapdf(cotizacion.id);
        }
        if(event.target.value == 11){
            this.facturaxml(cotizacion.id);
        }
        if(event.target.value == 12){
            this.acuse(cotizacion.id);
        }
        if(event.target.value == 13){
            this.reporteEntrada(cotizacion.id);
        }
    },
    pdfChanged(e){
        var fileReader = new FileReader()
        fileReader.readAsDataURL(e.target.files[0])
        fileReader.onload = (e) => {
            this.archivo_pdf= e.target.result;
        }

    },
    addTag (newTag) {
    const tag = {
        name: newTag,
        code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
    }
    this.options.push(tag)
    this.value.push(tag)
    },
    facturapdf(id){
     this.modal9 = 1;
     this.presupuestoCFE_id = id;

    },
      reporteEntrada(id){
     this.modal13 = 1;
     this.presupuestoCFE_id = id;

    },
    facturaxml(id){
     this.modal8 = 1;
     this.presupuestoCFE_id = id;

    },
    ordenservicio(id){
     this.modal7 = 1;
     this.presupuestoCFE_id = id;

    },
    acuse(id){
     this.modal6 = 1;
     this.presupuestoCFE_id = id;

    },
    fotosinstaladas(id){
     this.modal5 = 1;
     this.presupuestoCFE_id = id;

    },
    fotosnuevas(id){
     this.modal4 = 1;
     this.presupuestoCFE_id = id;

    },
    reporteAnomalias(id){
     this.modal3 = 1;
     this.presupuestoCFE_id = id;
    },
    fotosviejas(id){
     this.modal2 = 1;
     this.presupuestoCFE_id = id;

    },
     vistaUbicacionRegistrar() {
        this.registrarUbicacion = !this.registrarUbicacion;
        this.modeloUbicacion = {};
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
     verReporteAnomalias(){
        let me=this;
        var url= 'ordenesForaneas/verReporteAnomalias?id=' + me.presupuestoCFE_id;
        axios.get(url).then(function (response) {
            console.log(response.data);
            var respuesta = response.data;
            window.open('documentos/reporteanomalias/'+ respuesta,'_blank');
        })
        .catch(function (error) {
            console.log(error);
        });
        
    },
     subirarchivo9(e){
        let me = this;

        var fileReader = new FileReader()
        fileReader.readAsDataURL(e.target.files[0])
        fileReader.onload = (e) => {
            
            axios.post('ordenesForaneas/subirarchivos9',{
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
     listarUbicaciones(){
        let me=this;
        var url= 'ubicaciones';
        axios.get(url).then(function (response) {
            console.log(response.data);
            var respuesta= response.data;
            me.arrayUbicaicones = respuesta.ubicaciones;
        })
        .catch(function (error) {
            console.log(error);
        });
    },
     guardarUbicacion(){
        let me = this;

        axios.post('ubicaciones/registrar',{
            'nombre': me.modeloUbicacion.nombre,

        }).then(function (response) {
            
            console.log(response.data);
            me.listarUbicaciones();
            me.$toastr.success('Nueva ubiacion registrada', 'Ubicaciones');
            me.registrarUbicacion = false;
           
            

        }).catch(function (error) {
            console.log(error);
        });
    },
    guardarEntrada(){
        let me = this;

        axios.post('ordenesForaneas/guardarEntrada',{
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
     verFotosNuevas(){
        let me=this;
        var url= 'ordenesForaneas/verFotosNuevas?id=' + me.presupuestoCFE_id;
        axios.get(url).then(function (response) {
            console.log(response.data);
            var respuesta = response.data;
            window.open('documentos/fotosnuevas/'+ respuesta,'_blank');
        })
        .catch(function (error) {
            console.log(error);
        });
        
    },
    vistaCategoriasRegistrar() {
        this.registrarCategoria = !this.registrarCategoria;
        this.modeloCategoria = {};
    },
     vistaTiposRegistrar() {
        this.registrarTipo = !this.registrarTipo;
        this.modeloTipos = {};
    },
    guardarCategoria(){
        let me=this;
         axios.post('ordenesForaneas/categoria',{
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
         axios.post('ordenesForaneas/tipo',{
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
    verFotosInstaladas(){
        let me=this;
        var url= 'ordenesForaneas/verFotosInstaladas?id=' + me.presupuestoCFE_id;
        axios.get(url).then(function (response) {
            console.log(response.data);
            var respuesta = response.data;
            window.open('documentos/fotosinstaladas/'+ respuesta,'_blank');
        })
        .catch(function (error) {
            console.log(error);
        });
        
    },
     verAcuse(){
        let me=this;
        var url= 'ordenesForaneas/verAcuse?id=' + me.presupuestoCFE_id;
        axios.get(url).then(function (response) {
            console.log(response.data);
            var respuesta = response.data;
            window.open('documentos/acuse/'+ respuesta,'_blank');
        })
        .catch(function (error) {
            console.log(error);
        });
        
    },
     verFacturaXML(){
        let me=this;
        var url= 'ordenesForaneas/verFacturaXML?id=' + me.presupuestoCFE_id;
        axios.get(url).then(function (response) {
            console.log(response.data);
            var respuesta = response.data;
            window.open('documentos/facturaxml/'+ respuesta,'_blank');
        })
        .catch(function (error) {
            console.log(error);
        });
        
    },
    verFacturaPDF(){
        let me=this;
        var url= 'ordenesForaneas/verFacturaPDF?id=' + me.presupuestoCFE_id;
        axios.get(url).then(function (response) {
            console.log(response.data);
            var respuesta = response.data;
            window.open('documentos/facturapdf/'+ respuesta,'_blank');
        })
        .catch(function (error) {
            console.log(error);
        });
        
    },
    buscarContrato(contrato){
        
        this.buscar = contrato.id;
        this.criterio = 'empresas.id';

        this.listarIngreso(1,this.buscar ,this.criterio, '1');
    },
    listarIngreso (page,buscar,criterio, contra){
        let me=this;
        var url= 'ordenesForaneas/start?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio + '&contra='+ contra + '&eco_id=0';
        axios.get(url).then(function (response) {
            console.log(response.data);
            var respuesta= response.data;
            me.arrayCotizacion = respuesta.cotizaciones.data;
            me.pagination= respuesta.pagination;
            me.arrayCategorias = respuesta.categorias;
            me.arrayTipos = respuesta.tipos;
            me.arrayProductos = respuesta.productos;
            me.arrayPlanteles = respuesta.clientes;
        })
        .catch(function (error) {
            console.log(error);
        });
    },
     verFotosViejas(){
        let me=this;
        var url= 'ordenesForaneas/verFotosViejas?id=' + me.presupuestoCFE_id;
        axios.get(url).then(function (response) {
            console.log(response.data);
            var respuesta = response.data;
            window.open('documentos/fotosviejas/'+ respuesta,'_blank');
        })
        .catch(function (error) {
            console.log(error);
        });
        
    },
     subirarchivo(e){
        let me = this;

        var fileReader = new FileReader()
        fileReader.readAsDataURL(e.target.files[0])
        fileReader.onload = (e) => {
              axios.post('ordenesForaneas/subirarchivos',{
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
    subirarchivo2(e){
        let me = this;

        var fileReader = new FileReader()
        fileReader.readAsDataURL(e.target.files[0])
        fileReader.onload = (e) => {
            
            axios.post('ordenesForaneas/subirarchivos2',{
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
    subirarchivo3(e){
        let me = this;

        var fileReader = new FileReader()
        fileReader.readAsDataURL(e.target.files[0])
        fileReader.onload = (e) => {
            
            axios.post('ordenesForaneas/subirarchivos3',{
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
    subirarchivo4(e){
        let me = this;

        var fileReader = new FileReader()
        fileReader.readAsDataURL(e.target.files[0])
        fileReader.onload = (e) => {
            
            axios.post('ordenesForaneas/subirarchivos4',{
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
    subirarchivo5(e){
        let me = this;

        var fileReader = new FileReader()
        fileReader.readAsDataURL(e.target.files[0])
        fileReader.onload = (e) => {
            
            axios.post('ordenesForaneas/subirarchivos5',{
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
    subirarchivo6(e){
        let me = this;

        var fileReader = new FileReader()
        fileReader.readAsDataURL(e.target.files[0])
        fileReader.onload = (e) => {
            
            axios.post('ordenesForaneas/subirarchivos6',{
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
    subirarchivo7(e){
        let me = this;

        var fileReader = new FileReader()
        fileReader.readAsDataURL(e.target.files[0])
        fileReader.onload = (e) => {
            
            axios.post('ordenesForaneas/subirarchivos7',{
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
    detallesConceptos(page){
        let me=this;
        var url= 'detalleCarritoAF?id=' + page;
        axios.get(url).then(function (response) {
            console.log(response.data);
            var respuesta= response.data;
            me.detalleConceptos = respuesta.detalleconceptos;
        })
        .catch(function (error) {
            console.log(error);
        });
    },
    getOrdenSeguimineto(){
    let me = this;
    axios
        .get("hojaConcepto/"+me.NSolicitud)
        .then(function(response){
           var respuestaArray = response.data;
        console.log(respuestaArray);

        me.economico = respuestaArray.economico;
        me.placas = respuestaArray.placas;
        me.vin = respuestaArray.vin;
        me.marca = respuestaArray.marca;
        me.modelo = respuestaArray.modelo;
        me.ano = respuestaArray.anio;
        me.FechaAlta = respuestaArray.fecha;
        me.kmDeIngreso = respuestaArray.km;
        me.ordenServicio = respuestaArray.folio;

        })
        .catch(function(response){
        console.log(response);
        });
    },
    listarCategorias (){
        let me=this;
        var url= 'ordenesForaneas/selectCategorias';
        axios.get(url).then(function (response) {
            console.log(response.data);
            var respuesta= response.data;
            me.arrayCategorias = respuesta.categorias;
            console.log(this.arrayCategorias);
        })
        .catch(function (error) {
            console.log(error);
        });
    },
    checkChoose: function() {
        var _this = this;
        
    },
     agregarDetalles(){
        let me=this;
        me.detalleConceptos = [];

         var url= 'afconceptos/obtenerDetallesmulti';

        axios.post(url,{ 'ides' : me.check, 'id': me.idpresupuesto}).then(function (response) {
            console.log(response);
            var respuesta= response.data;
            me.cerrarModal();
            me.detallesConceptos(me.idpresupuesto);
            me.check = []; 

        })
        .catch(function (error) {
            console.log(error);
        });

        
        
    },
    buscarConceptops(page,buscar){
        let me=this;
        var url= 'afconceptos/selectConceptos?idc=' + page + '&idt='+ buscar;
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
    listarTipos (){
        let me=this;
        var url= 'ordenesForaneas/selectTipos';
        axios.get(url).then(function (response) {
            console.log(response.data);
            var respuesta= response.data;
            me.arrayTipos = respuesta.tipos;
            console.log(this.arrayTipos);
        })
        .catch(function (error) {
            console.log(error);
        });
    },
   llenado (p){
        let me = this;
        me.loading = true;
        console.log(p);
        me.productos
        me.arrayProducto.codigo_sat = p.code;
        me.arrayProducto.unidad_sat = p.unidad_sat;
        me.arrayProducto.unidad = p.unidad;
        me.arrayProducto.descripcion = p.strdescripcion;
        me.arrayProducto.tiempo = '1.0';
        me.arrayProducto.codigo = 'FC';
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
        me.listarIngreso(page,this.buscar,this.criterio, '1');
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
     borrar(id){
        let me=this;
        var url= 'detalleCarritoAF/delete?id=' + id;
        axios.get(url).then(function (response) {
            console.log(response.data);
            me.detallesConceptos(me.idpresupuesto);
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
    agregarConceptos(detalle){
        let me = this;

        axios.post('detalleCarritoAF/registrar',{
            'presupuestoCFE_id': this.idpresupuesto,
            'pCFEConcepto_id': detalle.id,
            'cantidad' : detalle.cantidad,
            'precio' : detalle.p_total,
            'precio_nuevo' : detalle.pnuevo

        }).then(function (response) {
            
            console.log(response.data);
            me.cerrarModal();
            me.detallesConceptos(me.idpresupuesto);
           

        }).catch(function (error) {
            console.log(error);
        });              
    },

    borrarConcepto(detalle){
        let me = this;

        axios.post('afconceptos/delete',{
            'id': detalle.id,

        }).then(function (response) {
            
            console.log(response.data);
            me.cerrarModal();
            me.detallesConceptos(me.idpresupuesto);
           

        }).catch(function (error) {
            console.log(error);
        });              
    },

    cambiostatus(id , status){
        let me = this;
        axios.post('ordenesForaneas/cambioStatus',{
            'id': id,
            'status': status
        }).then(function (response) {
            console.log(response.data);
            me.listarIngreso(1,'','odes','0');
           
        }).catch(function (error) {
            console.log(error);
        });  
    },
    guardarFotosviejas(){
        let me = this;

        axios.post('ordenesForaneas/guardarFotoVieja',{
            'id': me.presupuestoCFE_id,
            'archivo': me.archivo
        }).then(function (response) {
            
            console.log(response.data);
            me.cerrarModal();
            me.listarIngreso(1,'','odes','0');
            me.disabled = 1;
           

        }).catch(function (error) {
            console.log(error);
        });              
    },
    guardarReporteAnomalias(){
        let me = this;

        axios.post('ordenesForaneas/guardarReporteAnomalias',{
            'id': me.presupuestoCFE_id,
            'archivo': me.archivo
        }).then(function (response) {
            
            console.log(response.data);
            me.cerrarModal();
            me.listarIngreso(1,'','odes','0');
            me.disabled = 1;
           

        }).catch(function (error) {
            console.log(error);
        });              
    },
    guardarFotosNuevas(){
        let me = this;

        axios.post('ordenesForaneas/guardarFotoNueva',{
            'id': me.presupuestoCFE_id,
            'archivo': me.archivo
        }).then(function (response) {
            
            console.log(response.data);
            me.cerrarModal();
            me.listarIngreso(1,'','odes','0');
            me.disabled = 1;
           

        }).catch(function (error) {
            console.log(error);
        });              
    },
    guardarFotosInstaladas(){
        let me = this;

        axios.post('ordenesForaneas/guardarFotoInstalada',{
            'id': me.presupuestoCFE_id,
            'archivo': me.archivo
        }).then(function (response) {
            
            console.log(response.data);
            me.cerrarModal();
            me.listarIngreso(1,'','odes','0');
            me.disabled = 1;
           

        }).catch(function (error) {
            console.log(error);
        });              
    },
    guardarAcuse(){
        let me = this;

        axios.post('ordenesForaneas/guardarAcuse',{
            'id': me.presupuestoCFE_id,
            'archivo': me.archivo
        }).then(function (response) {
            
            console.log(response.data);
            me.cerrarModal();
            me.listarIngreso(1,'','odes','0');
            me.disabled = 1;
           

        }).catch(function (error) {
            console.log(error);
        });              
    },
    guardarFacturaXML(){
        let me = this;

        axios.post('ordenesForaneas/guardarFacturaXML',{
            'id': me.presupuestoCFE_id,
            'archivo': me.archivo
        }).then(function (response) {
            
            console.log(response.data);
            me.cerrarModal();
            me.listarIngreso(1,'','odes','0');
            me.disabled = 1;
           

        }).catch(function (error) {
            console.log(error);
        });              
    },
    guardarFacturaPDF(){
        let me = this;

        axios.post('ordenesForaneas/guardarFacturaPDF',{
            'id': me.presupuestoCFE_id,
            'archivo': me.archivo
        }).then(function (response) {
            
            console.log(response.data);
            me.cerrarModal();
            me.listarIngreso(1,'','odes','0');
            me.disabled = 1;
           

        }).catch(function (error) {
            console.log(error);
        });              
    },
    registrarIngreso(){
        if (this.validarIngreso()){
            return;
        }
        
        let me = this;

        axios.post('ordenesForaneas/registrar',{
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
            'ubicacion' : this.ubicacion,
            'conductor' : this.Conductor,
            'area' : this.area,
            'ubi' : this.ubi,
            'preocorr_id' : this.servicio,
            'tipo_servicio' : this.tipo_servicio,
            'kilome' : this.kmservicio,
            'data' : this.value,
            'empresa_id': this.idempresa,
            'eco_id' : '0'

        }).then(function (response) {
            
            console.log(response.data);
            me.listado=1;
            me.listarIngreso(1,'','odes','0');
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
            me.ubicacion ='';

        }).catch(function (error) {
            console.log(error);
        });
    },
    agregarConcepto(array){
    
        
        let me = this;

        axios.post('afconceptos/registrar',{
            'pCFECategorias_id': array.categorias_id,
            'pCFETipos_id': array.tipos_id,
            'num': array.codigo,
            'descripcion': array.descripcion,
            'p_refaccion': array.p_refaccion,
            'tiempo': array.tiempo,
            'p_mo': array.p_mo,
            'p_total': array.p_total,
            'codigo_sat': array.codigo_sat,
            'codigo_unidad': array.unidad_sat,
            'unidad_text': array.unidad,

        }).then(function (response) {
            
            console.log(response.data);
            me.cerrarModal();
            

        }).catch(function (error) {
            console.log(error);
        });
    },
    actualizarIngreso(){
     
        let me = this;

        axios.post('ordenesForaneas/update',{
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
            'importe' : this.importe,
            'descripcionMO' : this.descripcionMO,
            'clienteYRazonSocial' : this.clienteYRazonSocial,
            'observaciones' : this.observaciones,
            'mail' : this.Mail,
            'telefono' : this.Telefono,
            'tdeentrega' : this.tdeentrega,
            'conductor' : this.Conductor,
            'ubicacion' : this.ubicacion,
            'id': this.idpresupuesto,
            'area' : this.area,
            'pCFEVehiculos_id': this.idvehiculo,
            'pCFEGenerales_id': this.idgenerales,
            'empresa_id': this.idempresa
        }).then(function (response) {
            console.log(response.data);
            me.listado=1;
            me.listarIngreso(1,'','odes','0');
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
        window.open('ordenesForaneas/pdf/'+ id,'_blank');
    },
    pdfCotizacionAcuse(id){
        window.open('ordenesForaneas/pdfAcuse/'+ id,'_blank');
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
    ocultarDetalle(){
        this.listado=1;
        this.listarIngreso(1,this.buscar,this.criterio,'0');
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
        this.modal1=0;
        this.modal2=0;
        this.modal3=0;
        this.modal4=0;
        this.modal5=0;
        this.modal6=0;
        this.modal7=0;
        this.modal8=0;
        this.modal9=0;
        this.modal13=0;
        this.modal55=0;
        this.tituloModal='';
    },
    abrirModal(){
        this.arrayArticulo=[];
        this.modal = 1;
        this.tituloModal = 'Seleccione los articulos que desee';

    },
    abrirModal1(){
        this.arrayArticulo=[];
        this.modal1 = 1;
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

            axios.put('ordenesForaneas/desactivar',{
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
                        this.economico='';
                        this.modelo='';
                        this.vin='';
                        this.placas='';
                        this.ano='';
                        this.marca='';
                        this.NSolicitud='';
                        this.idpresupuesto = ''; 
                        this.FechaAlta= '';
                        this.kilometraje = '';
                        this.ordenServicio = '';
                        this.kmDeIngreso = '';
                        this.clienteYRazonSocial = '';
                        this.Mail = '';
                        this.Telefono = '';
                        this.Conductor = '';
                        this.descripcionMO = '';
                        this.importe = '';
                        this.tipoAccion = 1;
                        this.zonauno = 1;
                        this.detalleConceptos = [];
                        this.observaciones = '';
                        this.ubicacion = '';
                        this.area = '';
                        this.tdeentrega = '';
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
                        this.NSolicitud=data['NSolicitud'];
                        this.idpresupuesto = data['id']; 
                        this.FechaAlta= data['FechaAlta'];
                        this.kilometraje = data['kilometraje'];
                        this.ordenServicio = data['OrdenServicio'];
                        this.kmDeIngreso = data['KmDeIngreso'];
                        this.clienteYRazonSocial = data['ClienteYRazonSocial'];
                        this.Mail = data['Mail'];
                        this.Telefono = data['Telefono'];
                        this.Conductor = data['Conductor'];
                        this.descripcionMO = data['descripcionMO'];
                        this.importe = data['importe'];
                        this.observaciones = data['observaciones'];
                        this.idvehiculo = data['pVehiculos_id'];
                        this.idgenerales = data['pGenerales_id'];
                        this.tdeentrega = data['tdeentrega'];
                        this.ubicacion = data['ubicacion'];
                        this.area = data['ares'];
                        this.zonauno = 0;
                        this.detallesConceptos(data['id']);
                
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
     this.listarIngreso(1,this.buscar,this.criterio,'0');
     this.listarUbicaciones();
   
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
.mostrar1{
display: list-item !important;
opacity: 1 !important;
position: absolute !important;
background-color: #3c29297a !important;
}
.mostrar2{
display: list-item !important;
opacity: 1 !important;
position: absolute !important;
background-color: #3c29297a !important;
}
.mostrar3{
display: list-item !important;
opacity: 1 !important;
position: absolute !important;
background-color: #3c29297a !important;
}
.mostrar4{
display: list-item !important;
opacity: 1 !important;
position: absolute !important;
background-color: #3c29297a !important;
}
.mostrar5{
display: list-item !important;
opacity: 1 !important;
position: absolute !important;
background-color: #3c29297a !important;
}
.mostrar6{
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
.mostrar8{
display: list-item !important;
opacity: 1 !important;
position: absolute !important;
background-color: #3c29297a !important;
}
.mostrar9{
display: list-item !important;
opacity: 1 !important;
position: absolute !important;
background-color: #3c29297a !important;
}
.mostrar55{
display: list-item !important;
opacity: 1 !important;
position: absolute !important;
background-color: #3c29297a !important;
}
.mostrar13{
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