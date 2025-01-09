<div class="modal fade" id="RecepcionVehicular" tabindex="-1" aria-labelledby="taskModalLabal" data-bs-backdrop="static" data-bs-keyboard="false">
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
                    <div class=" selectconlabel zdmg-r02"><label for="ord_seguimiento">Ord. seguimiento<strong>*</strong></label><input required class="form-control" type="text" placeholder="Ej.100A " id="ord_seguimiento" name="ord_seguimiento"></div>
                    <div class="selectconlabel zdmg-r02"><label for="folio">Id<strong></strong></label><input class="form-control"  type="text" placeholder="Ej. 100ABC " id="folio" name="folio"></div>
                    <div class="selectconlabel zdmg-r02"><label for="fecha">Fecha<strong>*</strong></label><input id="fecha" name="fecha"  class="form-control" required type="datetime-local" class="custom-datetime-icon-input form-control"></div>
                </div>
                <h4>Datos Cliente</h4>
                <div class="vaniflex zdmg-r05 zdjc-between zdfw-w">
                    <div class="select2conlabel zdw-45pct  zdrelative">
                        <label for="">Empresa</label><div><select id="empresasrecepcion" name="empresasrecepcion"></select>
                        <button id="newempresas"class="btnin" type="button">+</button>
                    </div>
                    </div>
                    <div class="select2conlabel zdw-40pct  zdrelative">
                        <label for="">Clientes <strong>*</strong></label>
                        <select  id="clientesrecepcion"name="clientesrecepcion" required></select>
                        <button id="newcustomer"class="btnin" type="button">+</button>
                    </div>
                </div>
                <h4>Datos Del Vehiculo</h4>
                <div class="vaniflex zdmg-r05 zdjc-between zdfw-w zdrelative">
                    <div class="vaniwidth">
                    <div class="select2conlabel"><label for="">Vehiculo <span class="spanrelleno"> #Econonomico- Placas</span><strong>*</strong></label><select required id="vehiculo" name="vehiculo"></select>
                    <button class="btnin" id="newcar"type="button">+</button>
                </div>
                    </div>
                    <div class="selectconlabel"><label for="kmentrada">Km Entrada <strong>*</strong></label><input required class="form-control" type="number" name="kmentrada" id="kmentrada"></div>
                    <div class="selectconlabel"><label for="kmsalida">Km Salida<strong>*</strong></label><input required class="form-control" type="number" name="kmsalida" id="kmsalida"></div>
                    <div class="selectconlabel"><label for="gasentrada">Gasolina Entreda<strong>*</strong></label>
                        <select id="gasentrada"required  name="gasentrada" class="form-control">
                            <option value="">Seleccionar</option>
                            <option value="0">LLENO</option>
                            <option value="1">3/4</option>
                            <option value="2">2/4</option>
                            <option value="3">1/4</option>
                        </select>
                    </div>
                    <div class="selectconlabel"><label for="gassalida">Gasolina Salida <strong>*</strong></label>
                        <select id="gassalida"required  name="gassalida" class="form-control">
                            <option value="">Seleccionar</option>
                            <option value="0">LLENO</option>
                            <option value="1">3/4</option>
                            <option value="2">2/4</option>
                            <option value="3">1/4</option>
                        </select></div>
                </div>
                <h4>Datos Del Tecnico</h4>
                <div class="vaniflex zdmg-r05 zdjc-between zdfd-column">
                    <label for="tecnico">Tecnico</label>
                    <input class="form-control"type="text" placeholder="Ej. " id="tecnico" name="tecnico">
                </div>
                <h4>Daños Fisicos Notables</h4>
                <div class="vaniflex zdmg-r05 zdjc-between canvasconlabel">
                    <label for="">Tipo de Auto</label>
                    <select required name="tipo_auto" id="tipo_auto" class="form-control">
                        <option value="">Seleccione el tipo de auto</option>
                        <option value="4">Coche 2p</option>
                        <option value="3">Coche 4p</option>
                        <option value="1">Camioneta</option>
                        <option value="2">Subirban</option></select>
                    <canvas id="miCanvas" required name="miCanvasmiCanvas" class="form-control canvasdetalles"></canvas>
                    <button type="button" id="deshacer" name="deshacer" class="btn btn-secondary">Deshacer</button>
                </div>
                <h4>Datos Del Responsable</h4>
                <div class="vaniflex zdmg-r05 zdjc-between zdfw-w">
                    <div class="zdw-60pct">
                        <div class="canvasconlabel">
                            <label for="canvasfirma"> Firma <strong>*</strong></label>
                            <canvas required id="canvasfirma" name="canvasfirma" class="canvasfirma form-control"></canvas>
                            <button type="button" id="deshacerfirma" class="btn btn-secondary">Deshacer</button>
                        </div>
                        
                    </div>
                    <div class="col-12 col-lg-6 zdw-35pct">
                        <div class="selectconlabel zdmgy-r10">
                            <label for="fecha_esperada_id">Fecha esperada</label>
                            <input required id="fecha_esperada" name="fecha_esperada" type="datetime-local">
                        </div>
                        <div class="selectconlabel zdmgy-r10">
                            <label for="fecha_entrega_id">Fecha de entrega:</label>
                            <input required id="fecha_entrega" name="fecha_entrega" type="datetime-local" class="custom-datetime-icon-input form-control"> 
                        </div>
                    </div>
                </div>
                <h4>Condiciones De Interiores Y Equipo</h4>
                <div class="vaniflex zdmg-r05 zdjc-between zdfw-w zdfd-column">
                    <div class="form-control zdmgy-r10"><h6>Paneles de Puerta</h6>
                        <div class="subdivicion vaniflex zdfw-w">
                            <div class="selectconlabel "><label for="puerta_interior_frontal">Interior Frontal<strong>*</strong></label><select required name="puerta_interior_frontal" id="puerta_interior_frontal" class="condiciones "></select></div>
                            <div class="selectconlabel "><label for="puerta_interior_trasera">Interior Trasera<strong>*</strong></label><select required name="puerta_interior_trasera" id="puerta_interior_trasera" class="condiciones "></select></div>
                            <div class="selectconlabel "><label for="puerta_delantera_frontal">Delantera Frontal<strong>*</strong></label><select required name="puerta_delantera_frontal" id="puerta_delantera_frontal" class="condiciones "></select></div>
                            <div class="selectconlabel "><label for="puerta_delantera_trasera">Delantera Trasera<strong>*</strong></label><select required name="puerta_delantera_trasera" id="puerta_delantera_trasera" class="condiciones "></select></div>
                        </div>
                    </div>
                    <div class="form-control zdmgy-r10"><h6>Asientos</h6>
                        <div class="subdivicion vaniflex  zdfw-w">
                            <div class="selectconlabel "><label for="asiento_interior_frontal">Interior Frontal<strong>*</strong></label><select required name="asiento_interior_frontal" id="asiento_interior_frontal" class="condiciones "></select></div>
                            <div class="selectconlabel "><label for="asiento_interior_trasera">Interior Trasera<strong>*</strong></label><select required name="asiento_interior_trasera" id="asiento_interior_trasera" class="condiciones "></select></div>
                            <div class="selectconlabel "><label for="asiento_delantera_frontal">Delantera Frontal<strong>*</strong></label><select required name="asiento_delantera_frontal" id="asiento_delantera_frontal" class="condiciones "></select></div>
                            <div class="selectconlabel "><label for="asiento_delantera_trasera">Delantera Trasera<strong>*</strong></label><select required name="asiento_delantera_trasera" id="asiento_delantera_trasera" class="condiciones "></select></div>
                        </div>
                    </div>
                    <div class="subdivicion vaniflex  form-control zdmgy-r10 zdfw-w">
                        <div class="selectconlabel "><label for="consola_central">Consola Central<strong>*</strong></label><select required name="consola_central" id="consola_central" class="condiciones "></select></div>
                        <div class="selectconlabel "><label for="claxon">Claxon<strong>*</strong></label><select required name="claxon" id="claxon" class="condiciones "></select></div>
                        <div class="selectconlabel "><label for="tablero">Tablero<strong>*</strong></label><select required name="tablero" id="tablero" class="condiciones "></select></div>
                        <div class="selectconlabel "><label for="quemacocos">Quemacocos<strong>*</strong></label><select required name="quemacocos" id="quemacocos" class="condiciones "></select></div>
                        <div class="selectconlabel "><label for="toldo">Toldo<strong>*</strong></label><select required name="toldo" id="toldo" class="condiciones "></select></div>
                        <div class="selectconlabel "><label for="elevadores_eletricos">Elevadores Electricos<strong>*</strong></label><select required name="elevadores_eletricos" id="elevadores_eletricos" class="condiciones "></select></div>
                        <div class="selectconlabel "><label for="luces_interiores">Luces Interiores<strong>*</strong></label><select required name="luces_interiores" id="luces_interiores" class="condiciones "></select></div>
                        <div class="selectconlabel "><label for="seguros_eletricos">Seguros Electricos<strong>*</strong></label><select required name="seguros_eletricos" id="seguros_eletricos" class="condiciones "></select></div>
                        <div class="selectconlabel "><label for="climatizador">Climatizador<strong>*</strong></label><select required name="climatizador" id="climatizador" class="condiciones "></select></div>
                        <div class="selectconlabel "><label for="radio">Radio<strong>*</strong></label><select required name="radio" id="radio" class="condiciones "></select></div>
                        <div class="selectconlabel "><label for="espejos_retrovizor">Espejo Retrovisor<strong>*</strong></label><select required name="espejos_retrovizor" id="espejos_retrovizor" class="condiciones "></select></div>
                        <div class="selectconlabel "><label for="tapetes">Tapetes<strong>*</strong></label><select required name="tapetes" id="tapetes" class="condiciones "></select></div>
                    </div>
                </div>
                <h4>Condiciones De Exteriores y Equipo</h4>
                <div class="vaniflex zdmg-r05  zdjc-between zdfw-w">
                    <div class="selectconlabel"><label for="antena_radio">Antena/Radio<strong>*</strong></label><select required name="antena_radio" id="antena_radio" class="condiciones "></select></div>
                    <div class="selectconlabel"><label for="estribos">Estribos<strong>*</strong></label><select required name="estribos" id="estribos" class="condiciones "></select></div>
                    <div class="selectconlabel"><label for="antena_telefono">Antena/Telefoono<strong>*</strong></label><select required name="antena_telefono" id="antena_telefono" class="condiciones "></select></div>
                    <div class="selectconlabel"><label for="guardafangos">Guardafangos<strong>*</strong></label><select required name="guardafangos" id="guardafangos" class="condiciones "></select></div>
                    <div class="selectconlabel"><label for="antena_cb">Antena/C.B<strong>*</strong></label><select required name="antena_cb" id="antena_cb" class="condiciones "></select></div>
                    <div class="selectconlabel"><label for="parabrisas">Parabrisas<strong>*</strong></label><select required name="parabrisas" id="parabrisas" class="condiciones "></select></div>
                    <div class="selectconlabel"><label for="sistema_alarma">Sist. Alarma<strong>*</strong></label><select required name="sistema_alarma" id="sistema_alarma" class="condiciones "></select></div>
                    <div class="selectconlabel"><label for="limpia_parabrisas">Limpia Parabrisas<strong>*</strong></label><select required name="limpia_parabrisas" id="limpia_parabrisas" class="condiciones "></select></div>
                    <div class="selectconlabel"><label for="luces_exteriores">Luces Exteriores<strong>*</strong></label><select required name="luces_exteriores" id="luces_exteriores" class="condiciones "></select></div>
                    <div class="selectconlabel"><label for="espejos_laterales">Espejos Laterales<strong>*</strong></label><select required name="espejos_laterales" id="espejos_laterales" class="condiciones "></select></div>
                </div>
                <div class="vaniflex vaniwidth zdfd-row zdfw-w zdjc-between">
                    
                    <div class="vaniflex zdmg-r05 form-control zdjc-between zdfw-w zdw-45pct">
                        <h4>Varios Equipos - Inventario</h4>
                        <div class="vaniflex zdai-center checkboxconlabel"><label for="llanta">Llanta Refacccion</label><input type="checkbox" value="1" name="llanta" id="llanta" class="inventariocheckbox"></div>
                        <div class="vaniflex zdai-center checkboxconlabel"><label for="cubreruedas">Cubreruedas</label><input type="checkbox" value="1" name="cubreruedas" id="cubreruedas" class="inventariocheckbox"></div>
                        <div class="vaniflex zdai-center checkboxconlabel"><label for="cables_corriente">Cables para Corriente</label><input type="checkbox" value="1" name="cables_corriente" id="cables_corriente" class="inventariocheckbox"></div>
                        <div class="vaniflex zdai-center checkboxconlabel"><label for="candado_ruedas">Candado de rueda</label><input type="checkbox" value="1" name="candado_ruedas" id="candado_ruedas" class="inventariocheckbox"></div>
                        <div class="vaniflex zdai-center checkboxconlabel"><label for="estuche_herramientas">Estuche De Herramienta</label><input type="checkbox" value="1" name="estuche_herramientas" id="estuche_herramientas" class="inventariocheckbox"></div>
                        <div class="vaniflex zdai-center checkboxconlabel"><label for="extinguidor">Extinguidor</label><input type="checkbox" value="1" name="extinguidor" id="extinguidor" class="inventariocheckbox"></div>
                        <div class="vaniflex zdai-center checkboxconlabel"><label for="llave_tuercas">Llave tuercas de rueda</label><input type="checkbox" value="1" name="llave_tuercas" id="llave_tuercas" class="inventariocheckbox"></div>
                        <div class="vaniflex zdai-center checkboxconlabel"><label for="gato">Gato</label><input type="checkbox" value="1" name="gato" id="gato" class="inventariocheckbox"></div>
                        <div class="vaniflex zdai-center checkboxconlabel"><label for="triangulo_seguridad">Triangulo de Seguridad</label><input type="checkbox" value="1" name="triangulo_seguridad" id="triangulo_seguridad" class="inventariocheckbox"></div>
                        <div class="vaniflex zdai-center checkboxconlabel"><label for="placas">Placas</label><input type="checkbox" value="1" name="placas" id="placas" class="inventariocheckbox"></div>
                        <div class="vaniflex zdai-center checkboxconlabel"><label for="tarjeta_circulacion">Tarjeta de Circulacion</label><input type="checkbox" value="1" name="tarjeta_circulacion" id="tarjeta_circulacion" class="inventariocheckbox"></div>
                    </div>
                    
                    <div class="vaniflex zdmg-r05 form-control zdjc-between zdfw-w zdw-45pct">
                    <h4>Condiciones De Pintura</h4>
                        <div class="vaniflex zdai-center checkboxconlabel"><label for="decolorada">Decolorada</label><input type="checkbox" value="1" name="decolorada" id="decolorada" class="conpinturacheckbox"></div>
                        <div class="vaniflex zdai-center checkboxconlabel"><label for="emblemas_completos">Emblemas completos</label><input type="checkbox" value="1" name="emblemas_completos" id="emblemas_completos" class="conpinturacheckbox"></div>
                        <div class="vaniflex zdai-center checkboxconlabel"><label for="color_no_igual">Color no Igualado</label><input type="checkbox" value="1" name="color_no_igual" id="color_no_igual" class="conpinturacheckbox"></div>
                        <div class="vaniflex zdai-center checkboxconlabel"><label for="color">Logos en buen estado </label><input type="checkbox" value="1" name="color" id="color" class="conpinturacheckbox"></div>
                        <div class="vaniflex zdai-center checkboxconlabel"><label for="exeso_rayones">Exceso de rayones</label><input type="checkbox" value="1" name="exeso_rayones" id="exeso_rayones" class="conpinturacheckbox"></div>
                        <div class="vaniflex zdai-center checkboxconlabel"><label for="exeso_rociado">Exceso de rociado</label><input type="checkbox" value="1" name="exeso_rociado" id="exeso_rociado" class="conpinturacheckbox"></div>
                        <div class="vaniflex zdai-center checkboxconlabel"><label for="pequenias_grietas">Pequeñas grietas</label><input type="checkbox" value="1" name="pequenias_grietas" id="pequenias_grietas" class="conpinturacheckbox"></div>
                        <div class="vaniflex zdai-center checkboxconlabel"><label for="danios_granizado">Daños por granizo</label><input type="checkbox" value="1" name="danios_granizado" id="danios_granizado" class="conpinturacheckbox"></div>
                        <div class="vaniflex zdai-center checkboxconlabel"><label for="carroceria_golpes">Carroceria con gopes</label><input type="checkbox" value="1" name="carroceria_golpes" id="carroceria_golpes" class="conpinturacheckbox"></div>
                        <div class="vaniflex zdai-center checkboxconlabel"><label for="lluvia_acido">Lluvia acida</label><input type="checkbox" value="1" name="lluvia_acido" id="lluvia_acido" class="conpinturacheckbox"></div>
                    </div>
                </div>
                <h4>Notas Adicionales</h4>
                <div class="vaniflex zdmg-r05  form-control zdjc-between zdfw-w ">
                    <div class="textareaconlabel"><label for="notasadicionales">Notas</label><textarea placeholder="Notas" class="form-control" name="notasadicionales" id="notasadicionales"></textarea></div>
                    <div class="textareaconlabel"><label for="indicacionescliente">Indicaciones del Cliente</label><textarea  class="form-control" placeholder="Notas del cliente" name="indicacionescliente" id="indicacionescliente"></textarea></div>
                </div>
                <h4>Otros Datos</h4>
                <div class="vaniflex zdmg-r05 zform-control zdjc-between zdfw-w zd2col">
                    <div class="selectconlabel"><label for="admintrasportes">Administrador de Trasportes</label><input class="form-control" id="admintrasporte" name="" type="text" placeholder="Ej. Juan Rodriguez"></div>
                    <div class="selectconlabel"><label for="jefedelproceso">Jefe de Proceso</label><input class="form-control" id="jefedelproceso" name="jefedelproceso"  type="text" placeholder="Ej.  Jose Leyva"></div>
                    <div class="selectconlabel"><label for="telefonorecepcion">Telefono</label><input class="form-control" id="telefonorecepcion" name="telefonorecepcion"  maxlength="10" pattern="\d{10}" type="tel" placeholder="Ej. 4443552266 "></div>
                    <div class="selectconlabel"><label for="Trabajador">Trabajador</label><input class="form-control" id="Trabajador" name="Trabajador" type="text" placeholder="Ej.Jesus Ivan "></div>
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
    let origen="nuevo";
     $(function(){
        let ideditar=""
        window.executeeditarrecepcion = function(id) {
            eval("editarrecepcion(id)");
        };
        function editarrecepcion(id){
        $.ajax({
            type: 'GET',
            url: '{{ route('2025.cfe.obtener.Recepcionvehicular') }}',
            data:{
                id:id,
                modulo : @json($modulo),
            },
            success: function(response) {
                console.log(response);
                origen="existe";
                editaruinputsrecepcion(response.recepcion)
                ideditar=response.recepcion.id;
            },
            error: function(xhr, status, error) {
                console.error(xhr);
            }
        });
        }
        
        function editaruinputsrecepcion(element){
            console.log(element);
           
            $("#empresasrecepcion").append('<option value="'+element.empresa_id+'">'+element.empresa.nombre+'</option>');
            $("#vehiculo").append('<option value="'+element.vehiculo.id+'">'+element.vehiculo.no_economico+'-'+element.vehiculo.placas+'</option>');
            $("#clientesrecepcion").append('<option value="'+element.customer.id+'">'+element.customer.nombre+'</option>');
            $("#empresasrecepcion").val(element.empresa_id).trigger('change');
            $("#vehiculo").val(element.vehiculo.id).trigger('change');
            $("#clientesrecepcion").val(element.customer.id).trigger('change');
            const textFields = {
                'orden_seguimiento': 'ord_seguimiento',
                'folio': 'folio',
                'notas_adicionales': 'notasadicionales',
                'indicaciones_del_cliente': 'indicacionescliente',
                'km_entrada': 'kmentrada',
                'km_salida': 'kmsalida',
                'gas_entrada': 'gasentrada',
                'gas_salida': 'gassalida',
                'tecnico': 'tecnico',
                'tipo_auto': 'tipo_auto',
                'fecha': 'fecha',
                'fecha_compromiso': 'fecha_esperada',
                'fecha_entrega': 'fecha_entrega',
                'administrador': 'admintrasportes',
                'jefedeprocesos': 'jefedelproceso',
                'telefonojefe': 'telefonorecepcion',
                'trabajador': 'Trabajador',
            };

            // Asignar los valores a los campos de texto
            for (let field in textFields) {
                $(`#${textFields[field]}`).val(element[field]);  // Usar element[field] para obtener el valor correcto
            }
            const exterioresEquipoFields = [
                'antena_radio', 'antena_telefono', 'antena_cb', 'estribos', 'espejos_laterales', 
                'guardafangos', 'parabrisas', 'sistema_alarma', 'limpia_parabrisas', 'luces_exteriores'
            ];

            const interioresEquipoFields = [
                'puerta_interior_frontal', 'puerta_interior_trasera', 'puerta_delantera_frontal', 'puerta_delantera_trasera',
                'asiento_interior_frontal', 'asiento_interior_trasera', 'asiento_delantera_frontal', 'asiento_delantera_trasera',
                'consola_central', 'claxon', 'tablero', 'quemacocos', 'toldo', 'elevadores_eletricos',
                'luces_interiores', 'seguros_eletricos', 'tapetes', 'climatizador', 'radio', 'espejos_retrovizor'
            ];

            // Asignar los valores a los campos de ExterioresEquipo
            exterioresEquipoFields.forEach(field => {
                $(`#${field}`).val(element.exteriores[field]);  // Asignar el valor correspondiente de element
            });

            // Asignar los valores a los campos de InterioresEquipo
            interioresEquipoFields.forEach(field => {
                $(`#${field}`).val(element.interiores[field]);  // Asignar el valor correspondiente de element
            });

                    let checkboxFields = [
                        'llanta', 'cubreruedas', 'cables_corriente', 'candado_ruedas', 'estuche_herramientas',
                        'gato', 'llave_tuercas', 'tarjeta_circulacion', 'triangulo_seguridad', 'extinguidor',
                        'placas'
                    ];
                    checkboxFields.forEach(field => {
                        $(`#${field}`).prop('checked', !!element.inventario[field]);
                    });
                    checkboxFields = [
                    'decolorada', 'emblemas_completos', 'color_no_igual', 'logos', 'exeso_rayones',
                        'exeso_rociado', 'pequenias_grietas', 'danios_granizado', 'carroceria_golpes', 'lluvia_acido'
                    ];

                    checkboxFields.forEach(field => {
                        $(`#${field}`).prop('checked', !!element.condicionespintura[field]);
                    });

                    let modal=$("#RecepcionVehicular");
                    modal.modal("show");
                    $("#formnewrecepcion").find(".error-message").remove();
                    modal.on('shown.bs.modal', function () {
                    console.log(origen);
                        if(origen=="existe"){
                        executedibujarImagen("/storage/carror/"+element.carro)
                        executedibujarImagenfr("/storage/firmas/"+element.firma)
                        }
                    });
                    
        }   
        window.limpiarmodalrecepciones = function(id) {
                    eval("limpiarmodalrecepcion()");
                };
        function limpiarmodalrecepcion(){
            origen="nuevo";
            $("#formnewrecepcion").find(".error-message").remove();
            $('#RecepcionVehicular input').not('input[name="_token"]').val('');
            $('#RecepcionVehicular textarea').val('');
            $('#RecepcionVehicular select').val('').trigger('change');;  // O puedes usar $('#RecepcionVehicular select').prop('selectedIndex', -1);
            $('#RecepcionVehicular input[type="checkbox"]').prop('checked', false);
            $('#RecepcionVehicular input[type="checkbox"]'). val(1)
        }
       
 
    $("#formnewrecepcion").submit(function(e) {
      e.preventDefault();
      origen="espera";
      let canvas = document.getElementById("miCanvas");
      let canvas2 = document.getElementById("canvasfirma");
      let canvasImage = canvas.toDataURL();
      let canvasImage2 = canvas2.toDataURL();
      let modal=$("#RecepcionVehicular");
      let guardar=$("#guardarrecepcion")
      let ruta="{{ route('2025.cfe.guardar.nuevarecepcion') }}";
      let form= $("#formnewrecepcion");
      let data=  form.serialize() + '&miCanvas=' + encodeURIComponent(canvasImage) + '&canvasfirma=' + encodeURIComponent(canvasImage2)+ '&modulo='+@json($modulo);
      if(ideditar){
        data=data +'&id='+ideditar
      }
      
      console.log(ideditar);
      modal.modal("hide");
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
              var $request = $.post(ruta,data);
              $request.done(function(data) {
                guardar.attr("disabled", false);
                if (data === "guardado") {
                    Swal.fire({
                        icon: "success",
                        title: "Se registró correctamente",
                        showConfirmButton: false,
                        timer: 2000,
                    });
                    executeSearchdata();
                }  else {
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
                    let errorMessages = Object.values(errors)
                        .map((msgs) => msgs.join("<br>"))
                        .join("<br>");
                    for (let field in errors) {
                      let input = form.find(`[name="${field}"]`);
                      let errorMessage = `<small class="text-danger error-message">${errors[field].join("<br>")}</small>`;
                      input.after(errorMessage);
                    }
                    Swal.fire({
                        icon: "warning",
                        title: "Errores",
                        html: errorMessages,
                    }).then(() => {
                        modal.modal("show");
                       
                    });
                } else {
                    modal.modal("hide");
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Ocurrió un error inesperado",
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
      modal.on('shown.bs.modal', function () {
            if(origen=="espera"){
            executedibujarImagen(canvasImage)
            executedibujarImagenfr(canvasImage2)
            }
        });
    });
});
  </script>
@endpush 