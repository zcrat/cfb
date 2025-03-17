<template>
  <main class="main">
	<div class="container-fluid">
	  <!-- Ejemplo de tabla Listado -->
	  <div class="card">
		<div class="card-header">
		  <i class="fa fa-align-justify mr-2"></i> Inspección Vehícular
		  <button
			class="btn btn-secondary float-right"
			type="button"
			@click="vistaInspeccionVehicularRegistrar"
		  >
			<i class="fa fa-plus-circle mr-2"></i>Agregar
		  </button>
		</div>

        <!-- Listado de recepciones vehiculaes-->
        <template v-if="!registrarInspeccion">
          <div class="card-body">
            <div class="form-group">
              <div class="col-12 col-md-6 offset-md-3">
                <div class="text-center">
                  <div class="input-group">
                    <input
                      type="text"
                      v-model="criterio"
                      @keyup.enter="getlistInspeccion(criterio)"
                      class="form-control"
                      placeholder="Buscar..."
                    />
                    <button
                      type="submit"
                      @click="getlistInspeccion(criterio)"
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
                    <th>Vehículo</th>
                    <th>Fecha inspeccion</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="inspeccion in listaInspeccion" :key="inspeccion.id">
                    <td v-text="inspeccion.orden_seguimiento"></td>
                    <td v-text="inspeccion.folio"></td>
                    <td>{{inspeccion.placas}} - {{inspeccion.modnombre}} - {{inspeccion.marnombre}}</td>
                    <td v-text="inspeccion.fecha"></td>
                    <td>
                      <button class="btn btn-primary" @click="reporte(inspeccion.id)">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                      </button>
                      <button class="btn btn-warning" @click="editInspeccion(inspeccion.id)">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                      </button>
                      <button class="btn btn-danger">
                        <i class="icon-trash" aria-hidden="true"></i>
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
		<template v-if="registrarInspeccion">
		  <div class="card">
			<div class="card-header">
			  <i class="fa fa-plus-circle mr-2"></i>Nueva recepción
			  <small class="badge badge-pill badge-secondary px-2">
				<i class="fa fa-asterisk mr-2" aria-hidden="true"></i>campos obligatorios
			  </small>
			</div>
			<div class="card-body">
			  <div class="container-fluid">
				<div class="my-4">
				  <p class="h5 text-uppercase font-weight-bold border-bottom">
                      Datos Generales
                      <b-spinner v-if="loading" type="grow" variant="primary" label="Loading..."></b-spinner>
                  </p>
				  <div class="row">
					<div class="col-12 col-lg-4">
					  <div class="form-group">
						<label for="order-id">
						  Orden seguimiento
						  <i class="fa fa-asterisk ml-2" aria-hidden="true"></i>
						</label>
						<input
						  id="order-id"
						  class="form-control"
						  type="text"
						  v-model="modeloInspeccion.inspeccionTecnicaVehiculo.orden_seguimiento"
						  @keyup.enter="getRecepcionVehiculo"
						/>
					  </div>
					</div>
					<div class="col-12 col-lg-4">
					  <div class="form-group">
						<label for="fecha-id">
						  Fecha
						  <i class="fa fa-asterisk text-secundary ml-2" ></i>
						</label>
						<datetime
						  input-id="fechaRecepcion-id"
						  input-class="form-control"
						  type="datetime"
						  v-model="modeloInspeccion.rFecha"
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
					<div class="col-12 col-lg-4">
					  <div class="form-group">
						<label for="nombre-id">
						  Nombre
						  <i class="fa fa-asterisk ml-2" aria-hidden="true"></i>
						</label>
						<input
						  id="nombre-id"
						  class="form-control"
						  type="text"
						  v-model="modeloInspeccion.nombre"
						/>
					  </div>
					</div>
					<div class="col-12 col-lg-4">
					  <div class="form-group">
						<label for="telefono-id">
						  Teléfono
						  <i class="fa fa-asterisk ml-2" aria-hidden="true"></i>
						</label>
						<input
						  id="telefono-id"
						  class="form-control"
						  type="text"
						  v-model="modeloInspeccion.telefono"
						/>
					  </div>
					</div>
					<div class="col-12 col-lg-4">
					  <div class="form-group">
						<label for="Vehic-id">
						  Vehic./Marca/Modelo/Año
						  <i class="fa fa-asterisk ml-2" aria-hidden="true"></i>
						</label>
						<input
						  id="Vehic-id"
						  class="form-control"
						  type="text"
						  v-model="modeloInspeccion.Vehic"
						/>
					  </div>
					</div>
					<div class="col-12 col-lg-4">
					  <div class="form-group">
						<label for="placas-id">
						  Placas
						  <i class="fa fa-asterisk ml-2" aria-hidden="true"></i>
						</label>
						<input
						  id="placas-id"
						  class="form-control"
						  type="text"
						  v-model="modeloInspeccion.placas"
						/>
					  </div>
					</div>
					<div class="col-12 col-lg-4">
					  <div class="form-group">
						<label for="kilometraje-id">
						  Kilometraje
						  <i class="fa fa-asterisk ml-2" aria-hidden="true"></i>
						</label>
						<input
						  id="kilometra-id"
						  class="form-control"
						  type="text"
						  v-model="modeloInspeccion.kilometraje"
						/>
					  </div>
					</div>
					<div class="col-12 col-lg-4">
					  <div class="form-group">
						<label for="vin-id">
						  # VIN
						  <i class="fa fa-asterisk ml-2" aria-hidden="true"></i>
						</label>
						<input
						  id="vin-id"
						  class="form-control"
						  type="text"
						  v-model="modeloInspeccion.vin"
						/>
					  </div>
					</div>
					<div class="col-12 col-lg-4">
					  <div class="form-group">
						<label for="economico-id">
						  # Economico
						  <i class="fa fa-asterisk ml-2" aria-hidden="true"></i>
						</label>
						<input
						  id="economico-id"
						  class="form-control"
						  type="text"
						  v-model="modeloInspeccion.economico"
						/>
					  </div>
					</div>
				  </div>
				  <div class="my-4">
					<div class="row">
					  <div class="col-md-12 col-lg-6" v-if="firmaArchivo == ''">
						<label for="tel-seg">
						  Antefirma del Cliente
						  <i class="fa fa-asterisk text-secundary ml-2"></i>
						</label>
						<VueSignaturePad 
                            height="200px" 
                            class="border mb-3" 
                            ref="signaturePad"
                        />
						<div>
						  <button class="btn btn-primary" @click="guardarFirma" >Guardar firma</button>
						  <button @click="regresarFirmaAnterior" class="btn btn-secondary">Paso anterior</button>
						</div>
					  </div>
                      <div class="col-md-12 col-lg-6" v-else>
                          <label>Firma actual</label>
                            <img :src="[firmaArchivo]" class="img-thumbnail" alt="">
                      </div>
					  <div class="col-md-12 col-lg-6">
						<div class="form-group">
						  <label for="tel-seg">Fecha</label>
						  <datetime
							input-id="fecha-id"
							input-class="form-control"
							type="datetime"
							v-model="modeloInspeccion.inspeccionTecnicaVehiculo.iFecha"
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

				  <div class="my-4">
					<div class="row">
					  <div class="col-12">
						<div class="form-group">
						  <label for="Indicaciones del Cliente-id">Indicaciones del Cliente</label>
						  <textarea
							id="Indicaciones del Cliente-id"
							class="form-control"
							placeholder="Notas"
							cols="30"
							rows="5"
							v-model="modeloInspeccion.inspeccionTecnicaVehiculo.indicacionesCliente"
						  ></textarea>
						</div>
					  </div>
					</div>
				  </div>
				</div>
			</div>
            <div class="container-fluid">
				<div class="my-4">
                    <h1 class="h5 text-uppercase font-weight-bold border-bottom">
                        26 puntos-INSPECCION DE VEHICULO
                    </h1>
                    <div class="row">
                        <div class="col-sm-4 col-lg-4">
                            <label>Revisión de luces espías</label>
                            <RadioButtonInspeccion message="Codigo:" nombre="Codigo" id="codigo"
                            :val="modeloInspeccion.revisionLucesEspias.codigo"
                            @added="modeloInspeccion.revisionLucesEspias.codigo = $event"/>
                            <br>
                            <br>
                            <div class="col-sm-12 col-lg-12" style="padding-left: 0">
                                <label>Liquidos</label>

                                <div class="row">
                                    <div class="col-lg-8 col-sm-8">
                                        <label>Condición</label>
                                    </div>
                                    <div class="col-lg-1 col-sm-1">
                                        <label>OK</label>
                                    </div>
                                    <div class="col-lg-1 col-sm-1">
                                        <label>Lleno</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-9 col-sm-9">
                                        <RadioButtonInspeccion message="Aceite de motor:" nombre="aceiteMotor" id="aceiteMotor" :val="modeloInspeccion.liquidos.aceiteMotor"
                                        @added="modeloInspeccion.liquidos.aceiteMotor = $event"/>
                                    </div>
                                    <div class="custom-control form-control-lg custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="aMOK" name="aMOK"  v-model="modeloInspeccion.liquidos.aMOK">
                                        <label class="custom-control-label" for="aMOK"></label>
                                    </div>
                                    <div class="custom-control form-control-lg custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="aMLleno" name="aMLleno"  v-model="modeloInspeccion.liquidos.aMLleno">
                                        <label class="custom-control-label" for="aMLleno"></label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-9 col-sm-9">
                                        <RadioButtonInspeccion message="Transmisión" nombre="transmision" id="transmision" :val="modeloInspeccion.liquidos.transmision" @added="modeloInspeccion.liquidos.transmision = $event"/>
                                    </div>
                                    <div class="custom-control form-control-lg custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="tOK" name="tOK" v-model="modeloInspeccion.liquidos.tOK">
                                        <label class="custom-control-label" for="tOK"></label>
                                    </div>
                                    <div class="custom-control form-control-lg custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="tLleno" name="tLleno" v-model="modeloInspeccion.liquidos.tLleno">
                                        <label class="custom-control-label" for="tLleno"></label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-9 col-sm-9">
                                        <RadioButtonInspeccion message="Diferencial: F/T" nombre="diferencialft" id="diferencialft" :val="modeloInspeccion.liquidos.diferencialft" @added="modeloInspeccion.liquidos.diferencialft = $event"/>
                                    </div>
                                   <div class="custom-control form-control-lg custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="dOK" name="dOK"  v-model="modeloInspeccion.liquidos.dOK">
                                        <label class="custom-control-label" for="dOK"></label>
                                    </div>
                                    <div class="custom-control form-control-lg custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="dLleno" name="dLleno" v-model="modeloInspeccion.liquidos.dLleno">
                                        <label class="custom-control-label" for="dLleno"></label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-9 col-sm-9">
                                        <RadioButtonInspeccion message="Refrigerante:" nombre="lRefrigerante" id="lRefrigerante" :val="modeloInspeccion.liquidos.lRefrigerante" @added="modeloInspeccion.liquidos.lRefrigerante = $event"/>
                                    </div>
                                    <div class="custom-control form-control-lg custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="reOK" name="reOK" v-model="modeloInspeccion.liquidos.reOK">
                                        <label class="custom-control-label" for="reOK"></label>
                                    </div>
                                    <div class="custom-control form-control-lg custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="reLleno" name="reLleno"  v-model="modeloInspeccion.liquidos.reLleno">
                                        <label class="custom-control-label" for="reLleno"></label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-9 col-sm-9">
                                        <RadioButtonInspeccion message="Frenos:" nombre="frenos" id="frenos" :val="modeloInspeccion.liquidos.frenos" @added="modeloInspeccion.liquidos.frenos = $event"/>
                                    </div>
                                    <div class="custom-control form-control-lg custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="frOK" name="frOK" v-model="modeloInspeccion.liquidos.frOK">
                                        <label class="custom-control-label" for="frOK"></label>
                                    </div>
                                    <div class="custom-control form-control-lg custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="frLleno" name="frLleno" v-model="modeloInspeccion.liquidos.frLleno">
                                        <label class="custom-control-label" for="frLleno"></label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-9 col-sm-9">
                                        <RadioButtonInspeccion message="Dirección Hidráulica:" nombre="direccionHidraulica" :val="modeloInspeccion.liquidos.direccionHidraulica" id="direccionHidraulica" @added="modeloInspeccion.liquidos.direccionHidraulica = $event"/>
                                    </div>
                                    <div class="custom-control form-control-lg custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="dHOK" name="dHOK" v-model="modeloInspeccion.liquidos.dHOK">
                                        <label class="custom-control-label" for="dHOK"></label>
                                    </div>
                                    <div class="custom-control form-control-lg custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="dHLleno" name="dHLleno" v-model="modeloInspeccion.liquidos.dHLleno">
                                        <label class="custom-control-label" for="dHLleno"></label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-9 col-sm-9">
                                        <RadioButtonInspeccion message="Limpiaparabrisas:" nombre="limpiaparabrisas" id="limpiaparabrisas" :val="modeloInspeccion.liquidos.limpiaparabrisas" @added="modeloInspeccion.liquidos.limpiaparabrisas = $event"/>
                                    </div>
                                    <div class="custom-control form-control-lg custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="liOK" name="liOK" v-model="modeloInspeccion.liquidos.liOK">
                                        <label class="custom-control-label" for="liOK"></label>
                                    </div>
                                    <div class="custom-control form-control-lg custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="liLleno" name="liLleno" v-model="modeloInspeccion.liquidos.liLleno">
                                        <label class="custom-control-label" for="liLleno"></label>
                                    </div>
                                </div>
                                <label>Notas:</label>
                                <textarea
                                    id="lNotas"
                                    class="form-control"
                                    placeholder="Notas"
                                    cols="30"
                                    rows="3"
                                    v-model="modeloInspeccion.liquidos.lNotas"
                                ></textarea>
                            </div>
                        </div>
                        <!-- aquime quede -->
                        <div class="col-sm-4 col-lg-4">
                            <div class="row">
                                <label>Mangueras</label>
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12">
                                        <RadioButtonInspeccion message="Refrigerante:" nombre="mRefrigerante" id="mRefrigerante"
                                        :val="modeloInspeccion.mangueras.mRefrigerante"
                                        @added="modeloInspeccion.mangueras.mRefrigerante = $event"/>
                                    </div>
                                    <div class="col-lg-12 col-sm-12">
                                        <RadioButtonInspeccion message="Direccion/Aire Acondic.:" nombre="direccionAireAcondic"
                                        id="direccionAireAcondic"
                                        :val="modeloInspeccion.mangueras.direccionAireAcondic"
                                        @added="modeloInspeccion.mangueras.direccionAireAcondic = $event"/>
                                    </div>
                                    <div class="col-lg-12 col-sm-12">
                                        <RadioButtonInspeccion message="Calefacción:" nombre="calefacción" id="calefacción"
                                        :val="modeloInspeccion.mangueras.calefaccion"
                                        @added="modeloInspeccion.mangueras.calefaccion = $event"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label>Bandas</label>
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12">
                                        <RadioButtonInspeccion message="Accesorios:" nombre="accesorios" id="accesorios"
                                        :val="modeloInspeccion.bandas.accesorios"
                                        @added="modeloInspeccion.bandas.accesorios = $event"/>
                                    </div>
                                    <div class="col-lg-12 col-sm-12">
                                        <RadioButtonInspeccion message="Dirección Hidráulica:" nombre="bDireccionHidraulica"
                                        :val="modeloInspeccion.bandas.bDireccionHidraulica"
                                        id="bDireccionHidraulica" @added="modeloInspeccion.bandas.bDireccionHidraulica = $event"/>
                                    </div>
                                    <div class="col-lg-12 col-sm-12">
                                        <RadioButtonInspeccion message="Alternador/A. Acondic.:" nombre="alternadorAAcondic"
                                        :val="modeloInspeccion.bandas.alternadorAAcondic"
                                        id="alternadorAAcondic" @added="modeloInspeccion.bandas.alternadorAAcondic = $event"/>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <label>Filtros</label>
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12">
                                        <RadioButtonInspeccion message="Aire:" nombre="aire" id="aire"
                                        :val="modeloInspeccion.filtros.aire"
                                        @added="modeloInspeccion.filtros.aire = $event"/>
                                    </div>
                                    <div class="col-lg-12 col-sm-12">
                                        <RadioButtonInspeccion message="Combustible:" nombre="combustible" id="combustible"
                                        :val="modeloInspeccion.filtros.combustible"
                                        @added="modeloInspeccion.filtros.combustible = $event"/>
                                    </div>
                                    <div class="col-lg-12 col-sm-12">
                                        <RadioButtonInspeccion message="Aceite:" nombre="aceite" id="aceite"
                                        :val="modeloInspeccion.filtros.aceite"
                                        @added="modeloInspeccion.filtros.aceite = $event"/>
                                    </div>
                                </div>
                            </div>
                            <label>Notas:</label>
                            <textarea
                                id="fNotas"
                                class="form-control"
                                placeholder="Notas"
                                cols="30"
                                rows="3"
                                v-model="modeloInspeccion.filtros.fNotas"
                            ></textarea>
                        </div>
                        <div class="col-sm-4 col-lg-4">
                            <label>Llantas</label>

                            <div class="row">
                                <div class="col-lg-7 col-sm-7">
                                    <label>Patrón de desgaste/daño</label>
                                </div>
                                <div class="col-lg-2 col-sm-2">
                                    <label>Presión</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-7 col-sm-7">
                                    <RadioButtonInspeccion message="I. Delantera:" nombre="dIDelantera" id="dIDelantera"
                                    :val="modeloInspeccion.llantas.dIDelantera"
                                    @added="modeloInspeccion.llantas.dIDelantera = $event"/>
                                </div>
                               <div class="col-lg-2 col-sm-2">
                                    <div class="form-group row">
                                        <div class="col-xs-2">
                                            <input type="number" width="2" class="form-control" nombre="pIDelantera" min="1" v-model="modeloInspeccion.llantas.pIDelantera" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-7 col-sm-7">
                                    <RadioButtonInspeccion message="I. Trasera:" nombre="dITrasera" id="dITrasera"
                                    :val="modeloInspeccion.llantas.dITrasera"
                                    @added="modeloInspeccion.llantas.dITrasera = $event"/>
                                </div>
                                <div class="col-lg-2 col-sm-2">
                                    <div class="form-group row">
                                        <div class="col-xs-2">
                                            <input type="number" width="2" class="form-control" nombre="pITrasera" min="1"
                                            v-model="modeloInspeccion.llantas.pITrasera"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-7 col-sm-7">
                                    <RadioButtonInspeccion message="D. Delantera:" nombre="dDDelantera" id="dDDelantera"
                                    :val="modeloInspeccion.llantas.dDDelantera"
                                    @added="modeloInspeccion.llantas.dDDelantera = $event"/>
                                </div>
                                <div class="col-lg-2 col-sm-2">
                                    <div class="form-group row">
                                        <div class="col-xs-2">
                                            <input type="number" width="2" class="form-control" nombre="pDDdelantera" min="1"
                                            v-model="modeloInspeccion.llantas.pDDdelantera"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-7 col-sm-7">
                                    <RadioButtonInspeccion message="D. Trasera:" nombre="dDTrasera" id="dDTrasera"
                                    :val="modeloInspeccion.llantas.dDTrasera"
                                    @added="modeloInspeccion.llantas.dDTrasera = $event"/>
                                </div>
                                <div class="col-lg-2 col-sm-2">
                                    <div class="form-group row">
                                        <div class="col-xs-2">
                                            <input type="number" width="2" class="form-control" nombre="pDTrasera" min="1" v-model="modeloInspeccion.llantas.pDTrasera"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-7 col-sm-7">
                                    <RadioButtonInspeccion message="Refaccion:" nombre="dRefaccion" id="dRefaccion"
                                    :val="modeloInspeccion.llantas.dRefaccion"
                                    @added="modeloInspeccion.llantas.dRefaccion = $event"/>
                                </div>
                                <div class="col-lg-2 col-sm-2">
                                    <div class="form-group row">
                                        <div class="col-xs-2">
                                            <input type="number" width="2" class="form-control" nombre="pRefaccion" min="1" v-model="modeloInspeccion.llantas.pRefaccion"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <label>El desgaste de neumaticos indica que:</label>
                            <RadioButtonInspeccion message="Se necesita alineacion y balanceo:" nombre="alineacionBalanceo" id="alineacionBalanceo"
                            :val="modeloInspeccion.llantas.alineacionBalanceo"
                            @added="modeloInspeccion.llantas.alineacionBalanceo = $event"/>
                            <label>Seguridad</label>

                            <div class="row">
                                <div class="col-lg-7 col-sm-7">
                                    <RadioButtonInspeccion message="Freno de Emergencia:" nombre="frenoEmergencia" id="frenoEmergencia"
                                    :val="modeloInspeccion.seguridad.frenoEmergencia"
                                    @added="modeloInspeccion.seguridad.frenoEmergencia = $event"/>
                                </div>
                            </div>
                            <div class="row">
                                <label>Limpiaparabrisas</label>
                                <div class="col-lg-6 col-sm-7">
                                    <RadioButtonInspeccion message="Izq./Der.:" nombre="lpIzqDer" id="lpIzqDer"
                                    :val="modeloInspeccion.seguridad.lpIzqDer"
                                    @added="modeloInspeccion.seguridad.lpIzqDer = $event"/>
                                </div>
                                <div class="col-lg-6 col-sm-7">
                                    <RadioButtonInspeccion message="Trasero:" nombre="lpiTrasero" id="lpiTrasero"
                                    :val="modeloInspeccion.seguridad.lpiTrasero"
                                    @added="modeloInspeccion.seguridad.lpiTrasero = $event"/>
                                </div>
                            </div>
                            <label>Notas:</label>
                            <textarea
                                id="lpNotas"
                                class="form-control"
                                placeholder="Notas"
                                cols="30"
                                rows="3"
                                v-model="modeloInspeccion.seguridad.lpNotas"
                            ></textarea>
                        </div>

                  </div>
                  <div class="container-fluid">
                    <div class="my-4">
                        <h1 class="h5 text-uppercase font-weight-bold border-bottom">
                            57 puntos-INSPECCION DE VEHICULO
                            <small class="badge badge-pill badge-secondary px-2">
				                Incluye todos los anteriores
			                </small>
                        </h1>
                        <div class="row">
                            <div class="col-sm-4 col-lg-4">
                                <div class="row">
                                    <label>Afinacion de motor</label>
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12">
                                            <RadioButtonInspeccion message="Tapa de distribuidor/Bujías/Cables:" nombre="tapadistribuidorBujíasCables" id="tapadistribuidorBujíasCables"
                                            :val="modeloInspeccion.afinacionMotor.tapadistribuidorBujíasCables"
                                            @added="modeloInspeccion.afinacionMotor.tapadistribuidorBujíasCables = $event"/>
                                        </div>
                                        <div class="col-lg-12 col-sm-12">
                                            <RadioButtonInspeccion message="Fuel injection:" nombre="fuelInjection" id="fuelInjection"
                                            :val="modeloInspeccion.afinacionMotor.fuelInjection"
                                            @added="modeloInspeccion.afinacionMotor.fuelInjection = $event"/>
                                        </div>
                                    </div>

                                    <label>Tren de transmisión</label>
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12">
                                            <RadioButtonInspeccion message="Filtro de transmisión:" nombre="filtroTransmision" id="filtroTransmision"
                                            :val="modeloInspeccion.trenTransmision.filtroTransmision"
                                            @added="modeloInspeccion.trenTransmision.filtroTransmision = $event"/>
                                        </div>
                                        <div class="col-lg-12 col-sm-12">
                                            <RadioButtonInspeccion message="Unión de transmisión/Cluth:" nombre="unionTransmisiónCluth" id="unionTransmisiónCluth"
                                            :val="modeloInspeccion.trenTransmision.unionTransmisiónCluth"
                                            @added="modeloInspeccion.trenTransmision.unionTransmisiónCluth = $event"/>
                                        </div>
                                        <div class="col-lg-12 col-sm-12">
                                            <RadioButtonInspeccion message="Eje de tracción y juntas homocinéticas:" nombre="ejeTracciónJuntasHomocinéticas" id="ejeTracciónJuntasHomocinéticas"
                                            :val="modeloInspeccion.trenTransmision.ejeTracciónJuntasHomocinéticas"
                                            @added="modeloInspeccion.trenTransmision.ejeTracciónJuntasHomocinéticas = $event"/>
                                        </div>
                                        <div class="col-lg-12 col-sm-12">
                                            <RadioButtonInspeccion message="Eje de transmisión y juntas universales:" nombre="ejeTransmisiónJuntasUniversales" id="ejeTransmisiónJuntasUniversales"
                                            :val="modeloInspeccion.trenTransmision.ejeTransmisiónJuntasUniversales"
                                            @added="modeloInspeccion.trenTransmision.ejeTransmisiónJuntasUniversales = $event"/>
                                        </div>
                                        <div class="col-lg-12 col-sm-12">
                                            <RadioButtonInspeccion message="Rodamientos de rueda:" nombre="rodamientosRueda"
                                            id="rodamientosRueda"
                                            :val="modeloInspeccion.trenTransmision.rodamientosRueda"
                                            @added="modeloInspeccion.trenTransmision.rodamientosRueda = $event"/>
                                        </div>
                                        <div class="col-lg-12 col-sm-12">
                                            <RadioButtonInspeccion message="Transmisión:" nombre="tTransmision" id="tTransmision"
                                            :val="modeloInspeccion.trenTransmision.tTransmision"
                                            @added="modeloInspeccion.trenTransmision.tTransmision = $event"/>
                                        </div>
                                        <div class="col-lg-12 col-sm-12">
                                            <RadioButtonInspeccion message="Cluth:" nombre="cluth" id="cluth"
                                            :val="modeloInspeccion.trenTransmision.cluth"
                                            @added="modeloInspeccion.trenTransmision.cluth = $event"/>
                                        </div>
                                    </div>
                                    <label>Notas:</label>
                                    <textarea
                                        id="tTNotas"
                                        class="form-control"
                                        placeholder="Notas"
                                        cols="30"
                                        rows="3"
                                        v-model="modeloInspeccion.trenTransmision.tTNotas"
                                    ></textarea>
                                </div>
                            </div>
                            <div class="col-sm-4 col-lg-4">
                                <label>Electrico</label>
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12">
                                        <RadioButtonInspeccion message="Sistema de carga/bateria:" nombre="sistemaCargaBateria" id="sistemaCargaBateria"
                                        :val="modeloInspeccion.electrico.sistemaCargaBateria"
                                        @added="modeloInspeccion.electrico.sistemaCargaBateria = $event"/>
                                    </div>
                                    <div class="col-lg-12 col-sm-12">
                                        <RadioButtonInspeccion message="Cables/Conexiones/Fusibles:" nombre="cablesConexionesFusibles" id="cablesConexionesFusibles"
                                        :val="modeloInspeccion.electrico.cablesConexionesFusibles"
                                        @added="modeloInspeccion.electrico.cablesConexionesFusibles = $event"/>
                                    </div>
                                </div>

                                <label>Luces:</label>
                                <div class="row">
                                    <div class="col-lg-6 col-sm-6">
                                        <RadioButtonInspeccion message="Faros:" nombre="faros" id="faros"
                                        :val="modeloInspeccion.electrico.faros"
                                        @added="modeloInspeccion.electrico.faros = $event"/>
                                    </div>
                                    <div class="col-lg-2 col-sm-2">
                                        <div class="custom-control form-control-lg custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="faIzq" v-model="modeloInspeccion.electrico.faIzq">
                                            <label class="custom-control-label" for="faIzq">Izq.</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-2">
                                        <div class="custom-control form-control-lg custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="faDer" v-model="modeloInspeccion.electrico.faDer">
                                            <label class="custom-control-label" for="faDer">Der.</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-6">
                                        <RadioButtonInspeccion message="Cuartos:" nombre="cuartos" id="cuartos"
                                        :val="modeloInspeccion.electrico.cuartos"
                                        @added="modeloInspeccion.electrico.cuartos = $event"/>
                                    </div>
                                    <div class="col-lg-2 col-sm-2">
                                        <div class="custom-control form-control-lg custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="cuIzq" v-model="modeloInspeccion.electrico.cuIzq">
                                            <label class="custom-control-label" for="cuIzq">Izq.</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-2">
                                        <div class="custom-control form-control-lg custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="cuDer" v-model="modeloInspeccion.electrico.cuDer">
                                            <label class="custom-control-label" for="cuDer">Der.</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-sm-12">
                                        <RadioButtonInspeccion message="Frenos/Reversa:" nombre="frenosReversa" id="frenosReversa"
                                        :val="modeloInspeccion.electrico.frenosReversa"
                                        @added="modeloInspeccion.electrico.frenosReversa = $event"/>
                                    </div>
                                    <div class="col-lg-8 col-sm-8">
                                        <RadioButtonInspeccion message="Direccionales:" nombre="direccionales" id="direccionales"
                                        :val="modeloInspeccion.electrico.direccionales"
                                        @added="modeloInspeccion.electrico.direccionales = $event"/>
                                    </div>
                                    <div class="col-lg-2 col-sm-2">
                                        <div class="custom-control form-control-lg custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="diIF" v-model="modeloInspeccion.electrico.diIF">
                                            <label class="custom-control-label" for="diIF">IF</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-2">
                                        <div class="custom-control form-control-lg custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="diIT" v-model="modeloInspeccion.electrico.diIT">
                                            <label class="custom-control-label" for="diIT">IT</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-2">
                                        <div class="custom-control form-control-lg custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="diDF" v-model="modeloInspeccion.electrico.diDF">
                                            <label class="custom-control-label" for="diDF">DF</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-2">
                                        <div class="custom-control form-control-lg custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="diDT" v-model="modeloInspeccion.electrico.diDT">
                                            <label class="custom-control-label" for="diDT">DT</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-sm-12">
                                        <RadioButtonInspeccion message="Intermitentes:" nombre="intermitentes" id="intermitentes"
                                        :val="modeloInspeccion.electrico.intermitentes"
                                        @added="modeloInspeccion.electrico.intermitentes = $event"/>
                                    </div>
                                </div>
                                <label>Suspensión/dirección</label>
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12">
                                        <RadioButtonInspeccion message="Amortiguadores/suspensión:" nombre="amortiguadoresSuspension" id="amortiguadoresSuspension"
                                        :val="modeloInspeccion.suspensionDireccion.amortiguadoresSuspension"
                                        @added="modeloInspeccion.suspensionDireccion.amortiguadoresSuspension = $event"/>
                                    </div>
                                    <div class="col-lg-12 col-sm-12">
                                        <RadioButtonInspeccion message="Juntas de dirección/Rótulas:" nombre="juntasDirecciónRotulas" id="juntasDirecciónRotulas"
                                        :val="modeloInspeccion.suspensionDireccion.juntasDirecciónRotulas"
                                        @added="modeloInspeccion.suspensionDireccion.juntasDirecciónRotulas = $event"/>
                                    </div>
                                </div>
                                <label>Notas:</label>
                                <textarea
                                    id="sDNotas"
                                    class="form-control"
                                    placeholder="Notas"
                                    cols="30"
                                    rows="3"
                                    v-model="modeloInspeccion.suspensionDireccion.sDNotas"
                                ></textarea>

                            </div>
                            <div class="col-sm-4 col-lg-4">
                                <div class="row">
                                    <div class="col-lg-6 col-sm-6">
                                        <label>Frenos</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-sm-6">
                                        <label>Pastillas</label>
                                    </div>
                                    <div class="col-lg-6 col-sm-6">
                                        <label>Rotores</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-sm-6">
                                        <RadioButtonInspeccion message="I. Del.:" nombre="pIzquierdoDelantero" id="pIzquierdoDelantero"
                                        :val="modeloInspeccion.frenos.pIzquierdoDelantero"
                                        @added="modeloInspeccion.frenos.pIzquierdoDelantero = $event"/>
                                    </div>
                                    <div class="col-lg-6 col-sm-6">
                                        <RadioButtonInspeccion message="I. Del.:" nombre="rIzquierdoDelantero" id="rIzquierdoDelantero"
                                        :val="modeloInspeccion.frenos.rIzquierdoDelantero"
                                        @added="modeloInspeccion.frenos.rIzquierdoDelantero = $event"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-sm-6">
                                        <RadioButtonInspeccion message="D. Del.:" nombre="pDerechaDelantero" id="pDerechaDelantero"
                                        :val="modeloInspeccion.frenos.pDerechaDelantero"
                                        @added="modeloInspeccion.frenos.pDerechaDelantero = $event"/>
                                    </div>
                                    <div class="col-lg-6 col-sm-6">
                                        <RadioButtonInspeccion message="D. Del.:" nombre="rDerechaDelantero" id="rDerechaDelantero"
                                        :val="modeloInspeccion.frenos.rDerechaDelantero"
                                        @added="modeloInspeccion.frenos.rDerechaDelantero = $event"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-sm-6">
                                        <RadioButtonInspeccion message="I. Tras.:" nombre="pIzquierdoTrasera" id="pIzquierdoTrasera"
                                        :val="modeloInspeccion.frenos.pIzquierdoTrasera"
                                        @added="modeloInspeccion.frenos.pIzquierdoTrasera = $event"/>
                                    </div>
                                    <div class="col-lg-6 col-sm-6">
                                        <RadioButtonInspeccion message="I. Tras.:" nombre="rIzquierdoTrasera" id="rIzquierdoTrasera"
                                        :val="modeloInspeccion.frenos.rIzquierdoTrasera"
                                        @added="modeloInspeccion.frenos.rIzquierdoTrasera = $event"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-sm-6">
                                        <RadioButtonInspeccion message="D. Tras.:" nombre="pDerechaTrasera" id="pDerechaTrasera"
                                        :val="modeloInspeccion.frenos.pDerechaTrasera"
                                        @added="modeloInspeccion.frenos.pDerechaTrasera = $event"/>
                                    </div>
                                    <div class="col-lg-6 col-sm-6">
                                        <RadioButtonInspeccion message="D. Tras.:" nombre="rDerechaTrasera" id="rDerechaTrasera"
                                        :val="modeloInspeccion.frenos.rDerechaTrasera"
                                        @added="modeloInspeccion.frenos.rDerechaTrasera = $event"/>
                                    </div>
                                </div>
                                <label>Pinzas/Cilindros de rueda</label>
                                <div class="row">
                                    <div class="col-lg-6 col-sm-6">
                                        <RadioButtonInspeccion message="I. Del.:" nombre="pCRIzquierdaDelantera" id="pCRIzquierdaDelantera"
                                        :val="modeloInspeccion.frenos.pCRIzquierdaDelantera"
                                        @added="modeloInspeccion.frenos.pCRIzquierdaDelantera = $event"/>
                                    </div>
                                    <div class="col-lg-6 col-sm-6">
                                        <RadioButtonInspeccion message="D. Del.:" nombre="pCRDerechaDelantera" id="pCRDerechaDelantera"
                                        :val="modeloInspeccion.frenos.pCRDerechaDelantera"
                                        @added="modeloInspeccion.frenos.pCRDerechaDelantera = $event"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-sm-6">
                                        <RadioButtonInspeccion message="I. Tras.:" nombre="pCRIzquierdaTrasera" id="pCRIzquierdaTrasera"
                                        :val="modeloInspeccion.frenos.pCRIzquierdaTrasera"
                                        @added="modeloInspeccion.frenos.pCRIzquierdaTrasera = $event"/>
                                    </div>
                                    <div class="col-lg-6 col-sm-6">
                                        <RadioButtonInspeccion message="D. Tras.:" nombre="pCRDerechaTrasera" id="pCRDerechaTrasera"
                                        :val="modeloInspeccion.frenos.pCRDerechaTrasera"
                                        @added="modeloInspeccion.frenos.pCRDerechaTrasera = $event"/>
                                    </div>
                                </div>

                                <label>Escape</label>
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12">
                                        <RadioButtonInspeccion message="Mofle/Convertidor/Catlitico:" nombre="mofleConvertidorCatlitico" id="mofleConvertidorCatlitico"
                                        :val="modeloInspeccion.escape.mofleConvertidorCatlitico"
                                        @added="modeloInspeccion.escape.mofleConvertidorCatlitico = $event" />
                                    </div>
                                    <div class="col-lg-12 col-sm-12">
                                        <RadioButtonInspeccion
                                            message="Sensores/Soportes/Tubos:"
                                            nombre="sensoresSoportesTubos"
                                            id="sensoresSoportesTubos"
                                            :val="modeloInspeccion.escape.sensoresSoportesTubos"
                                            @added="modeloInspeccion.escape.sensoresSoportesTubos = $event"
                                        />
                                    </div>
                                </div>
                                <textarea
                                    id="eNotas"
                                    class="form-control"
                                    placeholder="Notas"
                                    cols="30"
                                    rows="3"
                                    v-model="modeloInspeccion.escape.eNotas"

                                ></textarea>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
            </div>            
		  </div>
            <div class="card-footer d-flex justify-content-end">
                <button v-if="save" class="btn btn-success m-1" @click="guardarDatos">Guardar</button>
                <button v-if="update" class="btn btn-success m-1" @click="updateInspeccion" 
                    :disabled="modeloInspeccion.inspeccionTecnicaVehiculo.anteFirma != ''"
                >
                    Actualizar
                </button>
                <button class="btn btn-default m-1">Cancelar</button>
                                
            </div>
		  </div>
        </template>
	  </div>
	</div>
  </main>
</template>

<script>
  import vSelect from "vue-select";
  import RadioButtonInspeccion from "./RadioButtonInspeccion";

	export default {
		data() {
			return {
                loading: false,
                update: false,
                save: false,
                criterio: '',
                listaInspeccion:{},
				modeloInspeccion:{
                    rFecha: '',
                    nombre:'',
                    telefono:'',
                    Vehic:'',
                    placas:'',
                    kilometraje:'',
                    vin:'',
                    economico:'',
                    inspeccionTecnicaVehiculo:{
                        orden_seguimiento:'',
                        indicacionesCliente:'',
                        anteFirma:'',
                        iFecha:''
                    },
                    revisionLucesEspias:{
                        codigo:''
                    },
                    mangueras:{
                        mRefrigerante:'',
                        direccionAireAcondic:'',
                        calefaccion:''
                    },
                    llantas:{
                        dIDelantera:'',
                        pIDelantera:'',
                        dITrasera:'',
                        pITrasera:'',
                        dDDelantera:'',
                        pDDdelantera:'',
                        dDTrasera:'',
                        pDTrasera:'',
                        dRefaccion:'',
                        pRefaccion:'',
                        alineacionBalanceo:''
                    },
                    liquidos:{
                        aceiteMotor:'',
                        transmision:'',
                        diferencialft:'',
                        lRefrigerante:'',
                        frenos:'',
                        direccionHidraulica:'',
                        limpiaparabrisas:'',
                        lNotas:'',
                        aMOK:'',
                        aMLleno:'',
                        tOK:'',
                        tLleno:'',
                        dOK:'',
                        dLleno:'',
                        reOK:'',
                        reLleno:'',
                        frOK:'',
                        frLleno:'',
                        dHOK:'',
                        dHLleno:'',
                        liOK:'',
                        liLleno:''
                    },
                    bandas:{
                        accesorios:'',
                        bDireccionHidraulica:'',
                        alternadorAAcondic:'',
                    },
                    filtros:{
                        aire:'',
                        combustible:'',
                        aceite:'',
                        fNotas:''
                    },
                    seguridad:{
                        frenoEmergencia:'',
                        lpIzqDer:'',
                        lpiTrasero:'',
                        lpNotas:'',
                    },
                    afinacionMotor:{
                        tapadistribuidorBujíasCables:'',
                        fuelInjection:'',
                    },
                    electrico:{
                        sistemaCargaBateria:'',
                        cablesConexionesFusibles:'',
                        faros:'',
                        faIzq:'',
                        faDer:'',
                        cuartos:'',
                        cuDer:'',
                        cuIzq:'',
                        frenosReversa:'',
                        direccionales:'',
                        diIF:'',
                        diIT:'',
                        diDF:'',
                        diDT:'',
                        intermitentes:''
                    },
                    frenos:{
                        pIzquierdoDelantero:'',
                        rIzquierdoDelantero:'',
                        pDerechaDelantero:'',
                        rDerechaDelantero:'',
                        pIzquierdoTrasera:'',
                        rIzquierdoTrasera:'',
                        pDerechaTrasera:'',
                        rDerechaTrasera:'',
                        pCRIzquierdaDelantera:'',
                        pCRDerechaDelantera:'',
                        pCRIzquierdaTrasera:'',
                        pCRDerechaTrasera:''
                    },
                    trenTransmision:{
                        filtroTransmision:'',
                        unionTransmisiónCluth:'',
                        ejeTracciónJuntasHomocinéticas:'',
                        ejeTransmisiónJuntasUniversales:'',
                        rodamientosRueda:'',
                        tTransmision:'',
                        cluth:'',
                        tTNotas:''
                    },
                    suspensionDireccion:{
                        amortiguadoresSuspension:'',
                        juntasDirecciónRotulas:'',
                        sDNotas:''
                    },
                    escape:{
                        mofleConvertidorCatlitico:'',
                        sensoresSoportesTubos:'',
                        eNotas:''
                    }

                },
                firmaArchivo: '',
				registrarInspeccion: false,
				status: false,
				offset: 3,
				pagination: {
					total: 0,
					current_page: 0,
					per_page: 0,
					last_page: 0,
					from: 0,
					to: 0
				},
			};
		},
		components: {
                vSelect,
                RadioButtonInspeccion
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
			}
		},
		methods: {
            updateInspeccion(){
                let me = this;
                axios
                    .put('inspeccion/' + me.modeloInspeccion.id, {
                        modeloInspeccion: me.modeloInspeccion
                    })
                    .then(function (response) {
                        if(response.data.estado == true){
                            me.$toastr.success('Seguardo correctamente la inspeccion', 'Inpeccion');
                        }
                        console.log(response.data);
                    })
                    .catch(function (error) {
                        if (error.response.status && error.response.status === 422) {
                           me.$toastr.warning("Valida los campos correctamente.", "Inspección");
                            console.log(error.response.status);
                        } else {
                            me.$toastr.error("Ocurrio un error, consulta con el admin", "Error");
                            console.log(error.response.data);
                        }          
                    });
            },
            editInspeccion(id){
                let me = this;
                axios.get("InspeccionTecnicaVehiculo/"+id+"/edit")
                     .then(function(response){
                        me.modeloInspeccion = response.data.modeloInspeccion;
                        if(response.data.modeloInspeccion.inspeccionTecnicaVehiculo.anteFirma){
                            me.firmaArchivo = "/img/firmas/" + response.data.modeloInspeccion.inspeccionTecnicaVehiculo.anteFirma;
                        }
                        me.registrarInspeccion = true;
                        me.update = true;
                        me.save = false;
                        console.log(response.data);
                        console.log(me.modeloInspeccion);
                     }).catch(function(response){
                        console.log(response);
                     });
            },
			getRecepcionVehiculo(){
                let me = this;
                me.loading = true;
                axios
                    .get("InspeccionTecnicaVehiculo/"+me.modeloInspeccion.inspeccionTecnicaVehiculo.orden_seguimiento)
                    .then(function(response) {
                        console.log(response.data);
                        me.modeloInspeccion.rFecha = response.data.fecha;
                        me.modeloInspeccion.inspeccionTecnicaVehiculo.orden_seguimiento = response.data.orden_seguimiento;
                        me.modeloInspeccion.nombre = response.data.nombre;
                        me.modeloInspeccion.telefono = response.data.telefono;
                        me.modeloInspeccion.Vehic = response.data.Vehic;
                        me.modeloInspeccion.placas = response.data.placas;
                        me.modeloInspeccion.kilometraje = response.data.kilometraje;
                        me.modeloInspeccion.vin = response.data.vin;
                        me.modeloInspeccion.economico = response.data.economico;
                    })
                    .catch(function(response) {
                        console.log(response);
                    }).finally(() => me.loading = false);
            },
            vistaInspeccionVehicularRegistrar() {
                this.registrarInspeccion = !this.registrarInspeccion;
                this.update = false;
                this.save = true;
            },
            regresarFirmaAnterior() {
                this.$refs.signaturePad.undoSignature();
            },
            guardarFirma() {
                let me = this;
                const { isEmpty, data } = me.$refs.signaturePad.saveSignature();
                if (isEmpty) {
                    me.$toastr.warning("Ingrese una firma", "Firma");
                } else {
                    me.modeloInspeccion.inspeccionTecnicaVehiculo.anteFirma = data;
                    me.$toastr.success("Firma guarda correctamente", "Firma");
                }
            },
            guardarDatos(){
                let me = this;
                me.loading = true;
                console.log(me.modeloInspeccion);
                axios
                    .post("InspeccionTecnicaVehiculo", me.modeloInspeccion)
                    .then(function(response) {
                        if(response.data == "1"){
                            me.$toastr.success('Seguardo correctamente la inspeccion', 'Inpeccion');
                            me.vistaInspeccionVehicularRegistrar();
                            me.getlistInspeccion('');
                        }
                        console.log(response.data);
                    })
                    .catch(function(error) {
                        //error 422 = validacion
                        if (error.response.status && error.response.status === 422) {
                           me.$toastr.warning("Valida los campos correctamente.", "Inspección");
                            console.log(error.response.status);
                        } else {
                            me.$toastr.error("Ocurrio un error, consulta con el admin", "Error");
                            console.log(error.response.data);
                        }
                    }).finally(() => me.loading = false);
            },
            getlistInspeccion(orden){
                let me = this;
                axios
                    .get("inspeccion/index?orden="+orden)
                    .then(function(response) {
                        me.listaInspeccion = response.data;
                        console.log(response);
                    })
                    .catch(function(response) {
                        console.log(response);
                    });

            },
            reporte(id){
                window.open('inspeccion/reporte/'+ id,'_blank');
            },

        },
         mounted() {
            this.getlistInspeccion('');
        }
	};
</script>
<style>
.custom-control-label::before,
.custom-control-label::after {
    top: .8rem;
    width: 1.25rem;
    height: 1.25rem;
}

</style>
