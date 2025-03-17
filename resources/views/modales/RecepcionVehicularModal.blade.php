<div class="modal fade" id="RecepcionVehicular" tabindex="-1" aria-labelledby="taskModalLabal" data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!--  del modal -->
            <div class="modal-header">
                <h4 class="modal-title" id="miModalLabel">Nueva Recepcion Vehicular</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="formnewrecepcion">
                @csrf
                <div class="modal-body">
                    <h4>Datos Generales</h4>
                    <div class="vaniflex zdmg-r05 zdjc-between zdfw-w">
                        <div class=" selectconlabel zdmg-r02">
                            <label for="ord_seguimiento">Ord.seguimiento</label><input class="form-control" type="text" placeholder="Ej.100A " id="ord_seguimiento" name="ord_seguimiento">
                        </div>
                        <div class="selectconlabel zdmg-r02">
                            <label for="folio">Id</label><input class="form-control" type="text" placeholder="Ej. 100ABC " id="folio" name="folio">
                        </div>
                    </div>
                    <h4>Datos Cliente</h4>
                    <div class="vaniflex zdmg-r05 zdjc-between zdfw-w">
                        <div class="select2conlabel zdw-45pct  zdrelative">
                            <label for="">Empresa<strong>*</strong></label>
                            <div>
                                <select id="empresasrecepcion" name="empresasrecepcion" required></select>
                                <button id="newempresas" class="btnin" type="button">+</button>
                            </div>
                        </div>
                        <div class="select2conlabel zdw-45pct  zdrelative">
                            <label for="">Clientes <strong>*</strong></label>
                            <select id="clientesrecepcion"name="clientesrecepcion" required></select>
                            <button id="newcustomer"class="btnin" type="button">+</button>
                        </div>
                    </div>
                    <h4>Datos Del Vehiculo</h4>
                    <div class="vaniflex zdmg-r05 zdjc-between zdfw-w zdrelative">
                        <div class="vaniwidth vaniflex zdjc-between">
                        <div class="select2conlabel zdw-45pct zdcambiartamanio zdrelative">
                                <label for="">Vehiculo <span class="spanrelleno">#Econonomico - Placas</span><strong>*</strong></label>
                                <select  id="vehiculo" name="vehiculo" required></select>
                                <button class="btnin" id="newcar" type="button">+</button>
                                <button class="btnin" id="editcar" type="button" hidden>+</button>
                            </div>
                            <div class="zdw-45pct zdhidden">
                                <label for="tipo" class='zdfz-r08'>Tipo <strong class='zdfz-r08'>*</strong></label>
                                <select id="tipovehiculo"name="tipovehiculo" required></select>
                            </div>
                        </div>
                        <div class="selectconlabel zdmg-r02">
                            <label for="fecha">Fecha Entrada<strong>*</strong></label>
                            <input id="fecha" name="fecha"  type="datetime-local" class="form-control" required>
                        </div>
                        <div class="selectconlabel"><label for="kmentrada">Km Entrada <strong>*</strong></label>
                            <input class="form-control" type="number" name="kmentrada" id="kmentrada" required>
                        </div>
                        <div class="selectconlabel">
                            <label for="gasentrada">Gasolina Entreda<strong>*</strong></label>
                            <select id="gasentrada" name="gasentrada" class="form-control" required>
                                <option value="">Seleccionar</option>
                                <option value="0">LLENO</option>
                                <option value="1">3/4</option>
                                <option value="2">2/4</option>
                                <option value="3">1/4</option>
                                <option value="4">vacio</option>
                            </select>
                        </div>
                        <div class="selectconlabel zdmg-r02">
                            <label for="fechasalida">Fecha Salida</label>
                            <input id="fechasalida" name="fechasalida"  type="datetime-local" class="form-control">
                        </div>
                        <div class="selectconlabel"><label for="kmsalida">Km Salida</label><input
                                 class="form-control" type="number" name="kmsalida" id="kmsalida">
                        </div>
                        <div class="selectconlabel"><label for="gassalida">Gasolina Salida </label>
                            <select id="gassalida" name="gassalida" class="form-control">
                                <option value="">Seleccionar</option>
                                <option value="0">LLENO</option>
                                <option value="1">3/4</option>
                                <option value="2">2/4</option>
                                <option value="3">1/4</option>
                                <option value="4">vacio</option>
                            </select>
                        </div>
                    </div>
                    <h4>Datos Del Taller</h4>
                    
                    <div class="vaniflex zdmg-r05 zform-control zdjc-between zdfw-w zd2col">
                        <div class="select2conlabel zdw-45pct  zdrelative">
                            <label for="admintrasportes">Administrador de Trasportes <strong>*</strong></label></label>
                            <select id="admintrasportedemo" name="admintrasporte" required></select>
                            <button data-origen="Administrador de Trasportes"class="btnin newusertaller" type="button">+</button>
                        </div>
                        <div class="select2conlabel zdw-45pct  zdrelative">
                            <label for="Tecnico">Tecnico <strong>*</strong></label>
                            <select id="Tecnico"name="Tecnico" required></select>
                            <button data-origen="Tecnico" class="btnin newusertaller" type="button">+</button>
                        </div>
                        <div class="select2conlabel zdw-45pct  zdrelative">
                            <label for="jefedelproceso">Jefe de Proceso<strong>*</strong></label></label>
                            <select id="jefedelprocesodemo"name="jefedelproceso" required></select>
                            <button data-origen="Jefe de Proceso" class="btnin newusertaller" type="button">+</button>
                        </div>
                        
                        <div class="select2conlabel zdw-45pct  zdrelative">
                            <label for="Trabajador">Trabajador<strong>*</strong></label></label>
                            <select id="Trabajadordemo"name="Trabajador" required></select>
                            <button data-origen="Trabajador" class="btnin newusertaller" type="button">+</button>
                        </div>
                    </div>
                    <h4>Daños Fisicos Notables</h4>
                    <div class="vaniflex zdmg-r05 zdjc-between canvasconlabel">
                        <canvas id="miCanvas"  name="miCanvas" class="form-control canvasdetalles"></canvas>
                        <button type="button" id="deshacer" name="deshacer"
                            class="btn btn-secondary">Deshacer</button>
                    </div>
                    <h4>Datos Del Responsable</h4>
                    <div class="vaniflex zdmg-r05 zdjc-between zdfw-w">
                        <div class="zdw-60pct">
                            <div class="canvasconlabel">
                                <label for="canvasfirma"> Firma <strong>*</strong></label>
                                <canvas  id="canvasfirma" name="canvasfirma"
                                    class="canvasfirma form-control"></canvas>
                                <button type="button" id="deshacerfirma" class="btn btn-secondary">Deshacer</button>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 zdw-35pct">
                            <div class="selectconlabel zdmg-r05">
                                <label for="fecha_esperada_id">Fecha esperada<strong>*</strong></label>
                                <input  id="fecha_esperada" name="fecha_esperada" class='form-control' type="datetime-local"required>
                            </div>
                            <div class="selectconlabel zdmg-r05"><label for="telefonorecepcion">Telefono<strong>*</strong></label><input
                                class="form-control" id="telefonorecepcion" name="telefonorecepcion" maxlength="10"
                                pattern="\d{10}" type="tel" placeholder="Ej. 4443552266 " required>
                            </div>
                            <div class="selectconlabel zdmg-r05 zdhidden">
                            <label for="tipo_servicio_presupuesto">Tipo de Servicio<strong>*</strong></label>
                            <select id="tipo_servicio_presupuesto"  name="tipo_servicio_presupuesto" class="form-control" required>
                                <option value="1">Preventivo</option>
                                <option value="2">Correctivo</option>
                                <option value="3">Ambos juntos</option>
                                <option value="4">Ambos Separados</option>
                            </select>
                        </div>
                        </div>
                    </div>
                    
                    <h4>Condiciones De Interiores Y Equipo</h4>
                    <div class="vaniflex zdmg-r05 zdjc-between zdfw-w zdfd-column">
                        <div class="form-control zdmgy-r10">
                            <h6>Paneles de Puerta</h6>
                            <div class="subdivicion vaniflex zdfw-w">
                                <div class="selectconlabel "><label for="puerta_interior_frontal">Interior
                                        Frontal<strong>*</strong></label><select required 
                                        name="puerta_interior_frontal" id="puerta_interior_frontal"
                                        class="condiciones "></select>
                                </div>
                                <div class="selectconlabel "><label for="puerta_interior_trasera">Interior
                                        Trasera<strong>*</strong></label><select required 
                                        name="puerta_interior_trasera" id="puerta_interior_trasera"
                                        class="condiciones "></select>
                                </div>
                                <div class="selectconlabel "><label for="puerta_delantera_frontal">Delantera
                                        Frontal<strong>*</strong></label><select required 
                                        name="puerta_delantera_frontal" id="puerta_delantera_frontal"
                                        class="condiciones "></select>
                                </div>
                                <div class="selectconlabel "><label for="puerta_delantera_trasera">Delantera
                                        Trasera<strong>*</strong></label><select required 
                                        name="puerta_delantera_trasera" id="puerta_delantera_trasera"
                                        class="condiciones "></select>
                                </div>
                            </div>
                        </div>
                        <div class="form-control zdmgy-r10">
                            <h6>Asientos</h6>
                            <div class="subdivicion vaniflex  zdfw-w">
                                <div class="selectconlabel "><label for="asiento_interior_frontal">Interior
                                        Frontal<strong>*</strong></label><select required 
                                        name="asiento_interior_frontal" id="asiento_interior_frontal"
                                        class="condiciones "></select>
                                </div>
                                <div class="selectconlabel "><label for="asiento_interior_trasera">Interior
                                        Trasera<strong>*</strong></label><select required 
                                        name="asiento_interior_trasera" id="asiento_interior_trasera"
                                        class="condiciones "></select>
                                </div>
                                <div class="selectconlabel "><label for="asiento_delantera_frontal">Delantera
                                        Frontal<strong>*</strong></label><select required 
                                        name="asiento_delantera_frontal" id="asiento_delantera_frontal"
                                        class="condiciones "></select>
                                </div>
                                <div class="selectconlabel "><label for="asiento_delantera_trasera">Delantera
                                        Trasera<strong>*</strong></label><select required 
                                        name="asiento_delantera_trasera" id="asiento_delantera_trasera"
                                        class="condiciones "></select>
                                </div>
                            </div>
                        </div>
                        <div class="subdivicion vaniflex  form-control zdmgy-r10 zdfw-w">
                            <div class="selectconlabel "><label for="consola_central">Consola
                                    Central<strong>*</strong></label><select required  name="consola_central"
                                    id="consola_central" class="condiciones "></select>
                            </div>
                            <div class="selectconlabel "><label for="claxon">Claxon<strong>*</strong></label><select required
                                     name="claxon" id="claxon" class="condiciones "></select>
                            </div>
                            <div class="selectconlabel "><label
                                    for="tablero">Tablero<strong>*</strong></label><select required  name="tablero"
                                    id="tablero" class="condiciones "></select>
                            </div>
                            <div class="selectconlabel "><label
                                    for="quemacocos">Quemacocos<strong>*</strong></label><select required 
                                    name="quemacocos" id="quemacocos" class="condiciones "></select>
                            </div>
                            <div class="selectconlabel "><label for="toldo">Toldo<strong>*</strong></label><select required
                                     name="toldo" id="toldo" class="condiciones "></select>
                            </div>
                            <div class="selectconlabel "><label for="elevadores_eletricos">Elevadores
                                    Electricos<strong>*</strong></label><select required  name="elevadores_eletricos"
                                    id="elevadores_eletricos" class="condiciones "></select>
                            </div>
                            <div class="selectconlabel "><label for="luces_interiores">Luces
                                    Interiores<strong>*</strong></label><select required  name="luces_interiores"
                                    id="luces_interiores" class="condiciones "></select>
                            </div>
                            <div class="selectconlabel "><label for="seguros_eletricos">Seguros
                                    Electricos<strong>*</strong></label><select required  name="seguros_eletricos"
                                    id="seguros_eletricos" class="condiciones "></select>
                            </div>
                            <div class="selectconlabel "><label
                                    for="climatizador">Climatizador<strong>*</strong></label><select required 
                                    name="climatizador" id="climatizador" class="condiciones "></select>
                            </div>
                            <div class="selectconlabel "><label for="radio">Radio<strong>*</strong></label><select required
                                     name="radio" id="radio" class="condiciones "></select>
                            </div>
                            <div class="selectconlabel "><label for="espejos_retrovizor">Espejo
                                    Retrovisor<strong>*</strong></label><select required  name="espejos_retrovizor"
                                    id="espejos_retrovizor" class="condiciones "></select>
                            </div>
                            <div class="selectconlabel "><label
                                    for="tapetes">Tapetes<strong>*</strong></label><select required  name="tapetes"
                                    id="tapetes" class="condiciones "></select>
                            </div>
                        </div>
                    </div>
                    <h4>Condiciones De Exteriores y Equipo</h4>
                    <div class="vaniflex zdmg-r05  zdjc-between zdfw-w">
                        <div class="selectconlabel"><label
                                for="antena_radio">Antena/Radio<strong>*</strong></label><select required 
                                name="antena_radio" id="antena_radio" class="condiciones "></select>
                        </div>
                        <div class="selectconlabel"><label for="estribos">Estribos<strong>*</strong></label><select required
                                 name="estribos" id="estribos" class="condiciones "></select>
                        </div>
                        <div class="selectconlabel"><label
                                for="antena_telefono">Antena/Telefoono<strong>*</strong></label><select required 
                                name="antena_telefono" id="antena_telefono" class="condiciones "></select>
                        </div>
                        <div class="selectconlabel"><label
                                for="guardafangos">Guardafangos<strong>*</strong></label><select required 
                                name="guardafangos" id="guardafangos" class="condiciones "></select></div>
                        <div class="selectconlabel"><label for="antena_cb">Antena/C.B<strong>*</strong></label><select required
                                 name="antena_cb" id="antena_cb" class="condiciones "></select>
                        </div>
                        <div class="selectconlabel"><label
                                for="parabrisas">Parabrisas<strong>*</strong></label><select required 
                                name="parabrisas" id="parabrisas" class="condiciones "></select>
                        </div>
                        <div class="selectconlabel"><label for="sistema_alarma">Sist.
                                Alarma<strong>*</strong></label><select required  name="sistema_alarma"
                                id="sistema_alarma" class="condiciones "></select>
                        </div>
                        <div class="selectconlabel"><label for="limpia_parabrisas">Limpia
                                Parabrisas<strong>*</strong></label><select required  name="limpia_parabrisas"
                                id="limpia_parabrisas" class="condiciones "></select>
                        </div>
                        <div class="selectconlabel"><label for="luces_exteriores">Luces
                                Exteriores<strong>*</strong></label><select required  name="luces_exteriores"
                                id="luces_exteriores" class="condiciones "></select>
                        </div>
                        <div class="selectconlabel"><label for="espejos_laterales">Espejos
                                Laterales<strong>*</strong></label><select required  name="espejos_laterales"
                                id="espejos_laterales" class="condiciones "></select>
                        </div>
                    </div>
                    <div class="vaniflex vaniwidth zdfd-row zdfw-w zdjc-between">

                        <div class="vaniflex zdmg-r05 form-control zdjc-between zdfw-w zdw-45pct">
                            <h4>Varios Equipos - Inventario</h4>
                            <div class="vaniflex zdai-center checkboxconlabel"><label for="llanta">Llanta
                                    Refacccion</label><input type="checkbox" value="1" name="llanta"
                                    id="llanta" class="inventariocheckbox">
                            </div>
                            <div class="vaniflex zdai-center checkboxconlabel"><label
                                    for="cubreruedas">Cubreruedas</label><input type="checkbox" value="1"
                                    name="cubreruedas" id="cubreruedas" class="inventariocheckbox">
                            </div>
                            <div class="vaniflex zdai-center checkboxconlabel"><label for="cables_corriente">Cables
                                    para Corriente</label><input type="checkbox" value="1"
                                    name="cables_corriente" id="cables_corriente" class="inventariocheckbox">
                            </div>
                            <div class="vaniflex zdai-center checkboxconlabel"><label for="candado_ruedas">Candado de
                                    rueda</label><input type="checkbox" value="1" name="candado_ruedas"
                                    id="candado_ruedas" class="inventariocheckbox">
                            </div>
                            <div class="vaniflex zdai-center checkboxconlabel"><label
                                    for="estuche_herramientas">Estuche De Herramienta</label><input type="checkbox"
                                    value="1" name="estuche_herramientas" id="estuche_herramientas"
                                    class="inventariocheckbox">
                            </div>
                            <div class="vaniflex zdai-center checkboxconlabel"><label
                                    for="extinguidor">Extinguidor</label><input type="checkbox" value="1"
                                    name="extinguidor" id="extinguidor" class="inventariocheckbox">
                            </div>
                            <div class="vaniflex zdai-center checkboxconlabel"><label for="llave_tuercas">Llave
                                    tuercas de rueda</label><input type="checkbox" value="1"
                                    name="llave_tuercas" id="llave_tuercas" class="inventariocheckbox">
                            </div>
                            <div class="vaniflex zdai-center checkboxconlabel"><label
                                    for="gato">Gato</label><input type="checkbox" value="1" name="gato"
                                    id="gato" class="inventariocheckbox">
                            </div>
                            <div class="vaniflex zdai-center checkboxconlabel"><label
                                    for="triangulo_seguridad">Triangulo de Seguridad</label><input type="checkbox"
                                    value="1" name="triangulo_seguridad" id="triangulo_seguridad"
                                    class="inventariocheckbox">
                            </div>
                            <div class="vaniflex zdai-center checkboxconlabel"><label
                                    for="placas">Placas</label><input type="checkbox" value="1"
                                    name="placas" id="placas" class="inventariocheckbox">
                            </div>
                            <div class="vaniflex zdai-center checkboxconlabel"><label
                                    for="tarjeta_circulacion">Tarjeta de Circulacion</label><input type="checkbox"
                                    value="1" name="tarjeta_circulacion" id="tarjeta_circulacion"
                                    class="inventariocheckbox">
                            </div>
                        </div>

                        <div class="vaniflex zdmg-r05 form-control zdjc-between zdfw-w zdw-45pct">
                            <h4>Condiciones De Pintura</h4>
                            <div class="vaniflex zdai-center checkboxconlabel"><label
                                    for="decolorada">Decolorada</label><input type="checkbox" value="1"
                                    name="decolorada" id="decolorada" class="conpinturacheckbox">
                            </div>
                            <div class="vaniflex zdai-center checkboxconlabel"><label
                                    for="emblemas_completos">Emblemas completos</label><input type="checkbox"
                                    value="1" name="emblemas_completos" id="emblemas_completos"
                                    class="conpinturacheckbox">
                            </div>
                            <div class="vaniflex zdai-center checkboxconlabel"><label for="color_no_igual">Color no
                                    Igualado</label><input type="checkbox" value="1" name="color_no_igual"
                                    id="color_no_igual" class="conpinturacheckbox">
                            </div>
                            <div class="vaniflex zdai-center checkboxconlabel"><label for="color">Logos en buen
                                    estado </label><input type="checkbox" value="1" name="color"
                                    id="color" class="conpinturacheckbox">
                            </div>
                            <div class="vaniflex zdai-center checkboxconlabel"><label for="exeso_rayones">Exceso de
                                    rayones</label><input type="checkbox" value="1" name="exeso_rayones"
                                    id="exeso_rayones" class="conpinturacheckbox">
                            </div>
                            <div class="vaniflex zdai-center checkboxconlabel"><label for="exeso_rociado">Exceso de
                                    rociado</label><input type="checkbox" value="1" name="exeso_rociado"
                                    id="exeso_rociado" class="conpinturacheckbox">
                            </div>
                            <div class="vaniflex zdai-center checkboxconlabel"><label for="pequenias_grietas">Pequeñas
                                    grietas</label><input type="checkbox" value="1" name="pequenias_grietas"
                                    id="pequenias_grietas" class="conpinturacheckbox">
                            </div>
                            <div class="vaniflex zdai-center checkboxconlabel"><label for="danios_granizado">Daños por
                                    granizo</label><input type="checkbox" value="1" name="danios_granizado"
                                    id="danios_granizado" class="conpinturacheckbox">
                            </div>
                            <div class="vaniflex zdai-center checkboxconlabel"><label
                                    for="carroceria_golpes">Carroceria con gopes</label><input type="checkbox"
                                    value="1" name="carroceria_golpes" id="carroceria_golpes"
                                    class="conpinturacheckbox">
                            </div>
                            <div class="vaniflex zdai-center checkboxconlabel"><label for="lluvia_acido">Lluvia
                                    acida</label><input type="checkbox" value="1" name="lluvia_acido"
                                    id="lluvia_acido" class="conpinturacheckbox">
                            </div>
                        </div>
                    </div>
                    <h4>Notas Adicionales</h4>
                    <div class="vaniflex zdmg-r05  form-control zdjc-between zdfw-w ">
                        <div class="textareaconlabel"><label for="notasadicionales">Notas</label>
                            <textarea placeholder="Notas" class="form-control" name="notasadicionales" id="notasadicionales"></textarea>
                        </div>
                        <div class="textareaconlabel"><label for="indicacionescliente">Indicaciones del Cliente</label>
                            <textarea class="form-control" placeholder="Notas del cliente" name="indicacionescliente" id="indicacionescliente"></textarea>
                        </div>
                    </div>

                    <h4 for="photos" name='Fotos Del Vehiculo'>Fotos Del Vehiculo</h4>
                    <input hidden type="file" class='form-control' id="photos" name="photos[]" accept="image/*" multiple capture="environment">
                    <button type="button"  class='btn btn-success' id="elegirarchivo">Tomar Foto</button>
                    <button type="button"  class='btn btn-success' id="deletepreimagerecepcionvehicular">Eliminar Fotos</button>

                    <div class="zdmg-r02 zdflex zdscroll-y zdw-100pct zdmw-45vw" id='fotosevidencia' hidden></div>
                    <div class="zdw-100pct zdflex zdjc-center" >
                    <div class="zdmg-r02 zdw-r30 zdmw-r30  zdflex zdfd-column ">
                        <img id="img_preview" src="#"  class="mimagen" hidden></img>
                        <button type="button"  class='btn btn-info' id='cerrarimagen' hidden>Cerrar</button>
                    </div>
                    </div>
                    

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" id="guardarrecepcion" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        let origen = "nuevo";
        let arrayfiles=[];
        $(function() {
            $("#photos").on("change", function (event) {
                let files = event.target.files;
                
                if (files.length > 0) {
                    $("#fotosevidencia").removeAttr('hidden');

                    for (let i = 0; i < files.length; i++) {
                        let reader = new FileReader();

                        reader.onload = function (e) {
                            let dataURL = e.target.result; // Base64 de la imagen
                            arrayfiles.push(dataURL); // Guardar en array sin borrar los anteriores

                            let index = arrayfiles.length - 1; // Índice de la nueva imagen

                            // Agregar la imagen con botón para eliminar
                            let tipoArchivo = `<div class="zdflex zdjc-center zdfd-column image-container" data-index="${index}">
                                <button type="button" class="boton-imagen zdmg-r02 zdw-r8 zdmnw-r8 zdh-r8" onclick="viewfotorecepcion('${dataURL}')" title='Foto-${index}'>
                                    <img src="${dataURL}" class="zdw-100pct zdh-100pct">
                                </button>
                                <button type="button" class="deletepreimagerecepcionvehicular eliminar-imagen" 
                                    data-id="${index}" title="Eliminar">Eliminar</button>
                            </div>`;

                            $("#fotosevidencia").append(tipoArchivo);
                        };

                        reader.readAsDataURL(files[i]); // Leer archivo como Base64
                    }
                } else {
                    $("#fotosevidencia").attr('hidden', true);
                }
                $(this).val('')
            });

            $("#elegirarchivo").on("click", function (event) {
                 $("#photos").trigger("click");
            });
            $(document).on("click", ".deletepreimagerecepcionvehicular", function (event) {
                let indice = $(this).data('id'); // Asegúrate de tener el índice del elemento en algún atributo de datos
                arrayfiles.splice(indice,1);
                $("#fotosevidencia").empty();
                if (arrayfiles.length > 0) {

                    for (let i = 0; i < arrayfiles.length; i++) {
                        let tipoArchivo = `<div class="zdflex zdjc-center zdfd-column">
                            <button type="button" class="boton-imagen zdmg-r02 zdw-r8 zdmnw-r8 zdh-r8">
                                <img src="${arrayfiles[i]}" class="zdw-100pct zdh-100pct">
                            </button>
                            <button type="button" class="deletepreimagerecepcionvehicular eliminar-imagen" 
                                data-id="${i}" title="Eliminar">Eliminar</button>
                        </div>`;

                        $("#fotosevidencia").append(tipoArchivo);
                    }
                }
            });
            $("#deletepreimagerecepcionvehicular").on("click", function (indice) {
                arrayfiles=[];
                $("#fotosevidencia").empty();
            });
            $('#tipovehiculo').select2({
                language: { searching: ()=> "Buscando opciones...",noResults: () => "Sin Resultados",},
                dropdownParent: $("#RecepcionVehicular"),
                placeholder: 'Escribe para buscar...',
                allowClear: true,
                minimumInputLength: 0,
                ajax: {
                    url: '/select2/obtenertiposcatalogo2',
                    dataType: 'json',
                    data: function(params) {
                        var query = {
                            term: params.term,
                            modulo: @json($modulo),
                            contrato:@json($contrato),
                            anio: @json($anio),
                            zona:@json($zona)
                        };
                        return query;
                    },
                    delay: 500,
                    processResults: function(data) {
                        console.log(data);
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.tipo,
                                    id: item.id
                                };
                            })
                        };
                    },
                    cache: true
                }
            });
            let ideditar = ""
            window.executeeditarrecepcion = function(id) {
                eval("editarrecepcion(id)");
            };
            function editarrecepcion(id) {
                $.ajax({
                    type: 'GET',
                    url: '{{ route('2025.Recepcion.Vehicular.Get.Element') }}',
                    data: {
                        id: id,
                        modulo: @json($modulo),
                    },
                    success: function(response) {
                        console.log(response);
                        origen = "existe";
                        editaruinputsrecepcion(response.recepcion)
                        ideditar = response.recepcion.id;
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr);
                    }
                });
            }
            function editaruinputsrecepcion(element) {
                console.log(element);
                $('.zdhidden').attr('hidden',true);
                $('#tipovehiculo').removeAttr('required');
                if(element.Update_fotos==0){
                    $('#elegirarchivo').attr('hidden',true);
                    $('#deletepreimagerecepcionvehicular').attr('hidden',true);
                }else{
                    $('#elegirarchivo').removeAttr('hidden');
                    $('#deletepreimagerecepcionvehicular').removeAttr('hidden');
                }
                $('.zdcambiartamanio').removeClass('zdw-45pct').addClass('zdw-90pct');
                $("#empresasrecepcion").append('<option value="' + element.detalles_generales.empresa.id + '">' + element.detalles_generales.empresa.nombre + '</option>');
                $("#vehiculo").append('<option value="' + element.detalles_generales.vehiculo.id + '">' + element.detalles_generales.vehiculo.no_economico + '-' + element.detalles_generales.vehiculo.placas + '</option>');
                $("#clientesrecepcion").append('<option value="' + element.detalles_generales.Customer_id + '">' + element.detalles_generales.customer.nombre + '</option>');
                $("#admintrasportedemo").append('<option value="' + element.detalles_generales.administrador_trasporte.id + '">' + element.detalles_generales.administrador_trasporte.Nombre + '</option>');
                $("#Tecnico").append('<option value="' + element.tecnico.id + '">' + element.tecnico.Nombre+'</option>');
                $("#jefedelprocesodemo").append('<option value="' + element.detalles_generales.jefede_proceso.id + '">' + element.detalles_generales.jefede_proceso.Nombre + '</option>');
                $("#Trabajadordemo").append('<option value="' + element.detalles_generales.trabajador.id + '">' + element.detalles_generales.trabajador.Nombre + '</option>');
                $("#notasadicionales").val(element.Notas); 


                const textFields = {
                    'OrdenSeguimiento': 'ord_seguimiento',
                    'Folio': 'folio',
                    'Indicaciones_cliente': 'indicacionescliente',
                    'Kilometraje_entrada': 'kmentrada',
                    'Kilometraje_salida': 'kmsalida',
                    'Gas_entrada': 'gasentrada',
                    'Gas_salida': 'gassalida',
                    'Fecha_entrada': 'fecha',
                    'Fecha_Esperada': 'fecha_esperada',
                    'Fecha_salida': 'fechasalida',
                    'Telefono': 'telefonorecepcion',
                };

                for (let field in textFields) {
                    console.log(element.detalles_generales[field])
                    $(`#${textFields[field]}`).val(element.detalles_generales[field]); // Usar element[field] para obtener el valor correcto
                }

                const exterioresEquipoFields = [
                    'antena_radio', 'antena_telefono', 'antena_cb', 'estribos', 'espejos_laterales',
                    'guardafangos', 'parabrisas', 'sistema_alarma', 'limpia_parabrisas', 'luces_exteriores'
                ];

                const interioresEquipoFields = [
                    'puerta_interior_frontal', 'puerta_interior_trasera', 'puerta_delantera_frontal',
                    'puerta_delantera_trasera',
                    'asiento_interior_frontal', 'asiento_interior_trasera', 'asiento_delantera_frontal',
                    'asiento_delantera_trasera',
                    'consola_central', 'claxon', 'tablero', 'quemacocos', 'toldo', 'elevadores_eletricos',
                    'luces_interiores', 'seguros_eletricos', 'tapetes', 'climatizador', 'radio',
                    'espejos_retrovizor'
                ];

                // Asignar los valores a los campos de ExterioresEquipo
                exterioresEquipoFields.forEach(field => {$(`#${field}`).val(element.exteriores[0][field]);}); // Asignar el valor correspondiente de element
                

                // Asignar los valores a los campos de InterioresEquipo
                interioresEquipoFields.forEach(field => {
                    $(`#${field}`).val(element.interiores[0][field])});// Asignar el valor correspondiente de element
               

                let checkboxFields = [
                    'llanta', 'cubreruedas', 'cables_corriente', 'candado_ruedas', 'estuche_herramientas',
                    'gato', 'llave_tuercas', 'tarjeta_circulacion', 'triangulo_seguridad', 'extinguidor',
                    'placas'
                ];
                checkboxFields.forEach(field => {
                    $(`#${field}`).prop('checked', !!element.inventario[0][field]);
                });
                checkboxFields = [
                    'decolorada', 'emblemas_completos', 'color_no_igual', 'logos', 'exeso_rayones',
                    'exeso_rociado', 'pequenias_grietas', 'danios_granizado', 'carroceria_golpes',
                    'lluvia_acido'
                ];

                checkboxFields.forEach(field => {
                    console.log(element.pintura[0][field]);
                    $(`#${field}`).prop('checked', !!element.pintura[0][field]);
                });
                archivos=element.fotos
                if (archivos.length > 0) {
                    $("#fotosevidencia").empty();
                    $("#fotosevidencia").removeAttr('hidden');
                    archivos.forEach(function(archivo) {
                        if(element.Update_fotos==0){
                            tipoArchivo='<div class="zdflex zdjc-center zdfd-column"><button type="button" class="boton-imagen zdmg-r02 zdw-r4 zdmnw-r4 zdh-r4" onclick="viewfotorecepcion(\'/storage/evidenciasrecepcionvehicular/'+archivo.Foto+'\')"title='+archivo.Foto+'>'+
                                            '<img  src="/storage/evidenciasrecepcionvehicular/'+archivo.Foto+'"  class="zdw-100pct zdh-100pct"></img>'+
                                        '</button></div>'
                                        $("#fotosevidencia").append(tipoArchivo);
                        }else{
                            fetch('/storage/evidenciasrecepcionvehicular/'+archivo.Foto)
                                .then(response => {
                                    if (!response.ok) {
                                    throw new Error('Error al obtener la imagen.');
                                    }
                                    return response.blob(); // Convertir la respuesta en un Blob
                                })
                                .then(blob => {
                                    let reader = new FileReader();
                                        reader.onload = function (e) {
                                        let dataURL = e.target.result; // Base64 de la imagen
                                        arrayfiles.push(dataURL); // Guardar en array sin borrar los anteriores

                                        let index = arrayfiles.length - 1; // Índice de la nueva imagen

                                        // Agregar la imagen con botón para eliminar
                                        let tipoArchivo = `<div class="zdflex zdjc-center zdfd-column image-container" data-index="${index}">
                                            <button type="button" class="boton-imagen zdmg-r02 zdw-r8 zdmnw-r8 zdh-r8"  onclick="viewfotorecepcion('${dataURL}')" title='Foto-${index}'>
                                                <img src="${dataURL}" class="zdw-100pct zdh-100pct">
                                            </button>
                                            <button type="button" class="deletepreimagerecepcionvehicular eliminar-imagen" 
                                                data-id="${index}" title="Eliminar">Eliminar</button>
                                        </div>`;

                                        $("#fotosevidencia").append(tipoArchivo);
                                    };
                                    reader.readAsDataURL(blob);
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                }); 
                    }
                        
                    });
                }
                let modal = $("#RecepcionVehicular");
                modal.modal("show");
                $("#formnewrecepcion").find(".error-message").remove();
                modal.on('shown.bs.modal', function() {
                    console.log(origen);
                    if (origen == "existe") {
                        if(element.Carro){
                            executedibujarImagen("/storage/carros/" + element.Carro)
                        }
                        if(element.Firma){
                            executedibujarImagenfr("/storage/firmastaller/" + element.Firma)
                        }
                    }
                });

            }
            window.viewfotorecepcion=function (archivo){
                $("#img_preview").attr('src',archivo) 
                $("#cerrarimagen").removeAttr('hidden') 
                $("#img_preview").removeAttr('hidden') 
            }
            $('#cerrarimagen').on('click',function(){
                $(this).attr('hidden',true)  
                $("#img_preview").attr('hidden',true) 
            })
            window.limpiarmodalrecepciones = function(id) {
                eval("limpiarmodalrecepcion()");
            };
            function limpiarmodalrecepcion() {
                origen = "nuevo";
                $('.zdhidden').removeAttr('hidden');
                $('.zdcambiartamanio').removeClass('zdw-90pct').addClass('zdw-45pct');
                $('#elegirarchivo').removeAttr('hidden');
                $('#deletepreimagerecepcionvehicular').removeAttr('hidden');
                $('#tipovehiculo').attr('required',true);
                $("#formnewrecepcion").find(".error-message").remove();
                $('#RecepcionVehicular input').not('input[name="_token"]').val('');
                $('#RecepcionVehicular textarea').val('');
                $('#RecepcionVehicular select').val('').trigger('change'); // O puedes usar $('#RecepcionVehicular select').prop('selectedIndex', -1);
                $('#tipo_servicio_presupuesto').val(3);
                $('#RecepcionVehicular input[type="checkbox"]').prop('checked', false);
                $('#RecepcionVehicular input[type="checkbox"]').val(1)
                arrayfiles=[];
                $("#fotosevidencia").empty();
                $("#img_preview").attr('src','#') 
                $("#cerrarimagen").attr('hidden',true) 
                $("#img_preview").attr('hidden',true) 
            }
            $("#formnewrecepcion").submit(function(e) {
                e.preventDefault();
                
                origen = "espera";
                let canvas = document.getElementById("miCanvas");
                let canvas2 = document.getElementById("canvasfirma");
                let canvasImage = canvas.toDataURL();
                let canvasImage2 = canvas2.toDataURL();
                let modal = $("#RecepcionVehicular");
                let guardar = $("#guardarrecepcion")
                let ruta = "{{ route('2025.Recepcion.Vehicular.create') }}";
                
                let form = $("#formnewrecepcion");
                let data = form.serialize() + '&miCanvas=' + encodeURIComponent(canvasImage) +
                '&canvasfirma=' + encodeURIComponent(canvasImage2) + '&modulo=' +
                @json($modulo) + '&contrato=' + @json($contrato) + '&anio=' + @json($anio) + '&zona=' + @json($zona) ;
                if (ideditar) {
                    data = data + '&id=' + ideditar
                    //data = data + '&id=' + 122222
                    ruta = "{{ route('2025.Recepcion.Vehicular.update') }}";
                }
                for (let i = 0; i < arrayfiles.length; i++) {
                    data+='&fotos[]='+ encodeURIComponent(arrayfiles[i]);
                }
               
                guardar.attr("disabled", true);
                Swal.fire({
                        icon: "question",
                        text: "¿Estás seguro de guardar la recepcion?",
                        showCancelButton: true,
                        confirmButtonText: "Confirmar",
                        cancelButtonText: "Cancelar",
                        reverseButtons: true,
                        customClass: {
                            confirmButton: "btn-primary",
                            cancelButton: "btn-light",
                        },
                    })
                    .then((result) => {
                        if (result.isConfirmed) {
                            $(".error-message").remove();
                            var $request = $.post(ruta, data);
                            $request.done(function(data) {
                                guardar.attr("disabled", false);
                                if (data === "guardado") {
                                    Swal.fire({
                                        icon: "success",
                                        title: "Se registró correctamente",
                                        showConfirmButton: false,
                                        timer: 2000,
                                    });
                                    modal.modal("hide");
                                    $(".modal-backdrop").remove(); // Elimina el fondo oscuro
                                    $("body").removeClass("modal-open");
                              
                                    executeSearchdata();
                                } else {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Oops...",
                                        html: data,
                                    }).then((result) => {
                                        modal.modal("show");

                                    });
                                }
                            });
                            $request.fail(function(error) {
                                guardar.attr("disabled", false);
                                if (error.status === 422) {
                                    $("#formnewrecepcion").find(".error-message").remove();
                                    let errors = error.responseJSON.errors;
                                    let errorMessages = Object.values(errors).map((msgs) =>{if(msgs != "Este campo es obligatorio." && msgs != "La opción no es válida"){return msgs.join("<br>")}}).filter(Boolean).join("<br>");
                                    for (let field in errors) {
                                        let input = form.find(`[name="${field}"]`);
                                        let errorMessage =
                                            `<small class="text-danger error-message">${errors[field].join("<br>")}</small>`;
                                        input.after(errorMessage);
                                    }
                                    Swal.fire({
                                        icon: "warning",
                                        title: "Errores",
                                        html: errorMessages,
                                    }).then(() => {
                                        modal.modal("show");

                                    });
                                }else if (error.status === 420) {
                                    $("#formnewrecepcion").find(".error-message").remove();
                                    Swal.fire({
                                        icon: "warning",
                                        title: "Error",
                                        html: error.responseJSON.error,
                                        timer: 2000,
                                    }).then(() => {
                                        modal.modal("show");

                                    });
                                } else {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Oops...",
                                        text: "Ocurrió un error inesperado",
                                        timer: 2000,
                                    }).then(() => {
                                        modal.modal("show");

                                    });
                                }
                            });
                        } else {
                            modal.modal("show");
                            guardar.attr("disabled", false);

                        }
                    });
                modal.on('shown.bs.modal', function() {
                    if (origen == "espera") {
                        executedibujarImagen(canvasImage)
                        executedibujarImagenfr(canvasImage2)
                    }
                });
            });
        });
    </script>
@endpush
