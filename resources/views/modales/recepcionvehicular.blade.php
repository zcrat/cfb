<div class="modal fade" id="RecepcionVehicular" tabindex="-1" aria-labelledby="taskModalLabal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!--  del modal -->
            <div class="modal-header">
                <h4 class="modal-title" id="miModalLabel">Nueva Recepcion Vehicular</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="formnewrecepcion">
                <div class="modal-body">
                <h4>Datos Generales</h4>
                <div class="vaniflex zdmg-r05 zdjc-between zdfw-w">
                    <div class=" selectconlabel zdmg-r02"><label for="folio">Folio<strong>*</strong></label><input required class="form-control" type="text" placeholder="Ej.100A " id="folio" name="folio"></div>
                    <div class="selectconlabel zdmg-r02"><label for="ord_segumineto">Ord. Segumineto<strong>*</strong></label><input class="form-control" required type="text" placeholder="Ej. 100ABC " id="ord_segumineto" name="ord_segumineto"></div>
                    <div class="selectconlabel zdmg-r02"><label for="fecha">Fecha<strong>*</strong></label><input id="fecha"   class="form-control" required type="datetime-local" class="custom-datetime-icon-input form-control"></div>
                </div>
                <h4>Datos Cliente</h4>
                <div class="vaniflex zdmg-r05 zdjc-between zdfw-w">
                    <div class="select2conlabel zdw-45pct">
                        <label for="">Empresa</label><div><select id="empresasrecepcion" name="empresasrecepcion"></select>
                        <button id="newempresas"class="btnin" type="button">+</button>
                    </div>
                    </div>
                    <div class="select2conlabel zdw-40pct">
                        <label for="">Clientes <strong>*</strong></label>
                        <select  id="clientesrecepcion"name="clientesrecepcion" required></select>
                        <button id="newcustomer"class="btnin" type="button">+</button>
                    </div>
                </div>
                <h4>Datos Del Vehiculo</h4>
                <div class="vaniflex zdmg-r05 zdjc-between zdfw-w">
                    <div class="vaniwidth">
                    <div class="select2conlabel"><label for="">Vehiculo <span class="spanrelleno"> #Econonomico- Placas</span><strong>*</strong></label><select required id="vehiculo"></select>
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
                    <button id="deshacer" name="deshacer" class="btn btn-secondary">Deshacer</button>
                </div>
                <h4>Datos Del Responsable</h4>
                <div class="vaniflex zdmg-r05 zdjc-between zdfw-w">
                    <div class="zdw-60pct">
                        <div class="canvasconlabel">
                            <label for="canvasfirma"> Firma <strong>*</strong></label>
                            <canvas required id="canvasfirma"required  class="canvasfirma form-control"></canvas>
                            <button type="button" id="deshacerfirma" class="btn btn-secondary">Deshacer</button>
                        </div>
                        
                    </div>
                    <div class="col-12 col-lg-6 zdw-35pct">
                        <div class="selectconlabel zdmgy-r10">
                            <label for="fecha_esperada_id">Fecha esperada</label>
                            <input required id="fecha_esperada_id" type="datetime-local">
                        </div>
                        <div class="selectconlabel zdmgy-r10">
                            <label for="fecha_entrega_id">Fecha de entrega:</label>
                            <input required id="fecha_entrega_id" type="datetime-local" class="custom-datetime-icon-input form-control"> 
                        </div>
                    </div>
                </div>
                <h4>Condiciones De Interiores Y Equipo</h4>
                <div class="vaniflex zdmg-r05 zdjc-between zdfw-w zdfd-column">
                    <div class="form-control zdmgy-r10">
                        <h6>Paneles de Puerta</h6>
                        <div class="subdivicion vaniflex zdfw-w">
                        <div class="selectconlabel "><label for="opcion_1">Interior Frontal<strong>*</strong></label><select required name="pcondicion1" id="pcondicion1" class="condiciones "></select></div>
                        <div class="selectconlabel "><label for="opcion_2">Interior Trasera<strong>*</strong></label><select required name="pcondicion2" id="pcondicion2" class="condiciones "></select></div>
                        <div class="selectconlabel "><label for="opcion_3">Delantera Frontal<strong>*</strong></label><select required name="pcondicion3" id="pcondicion3" class="condiciones "></select></div>
                        <div class="selectconlabel "><label for="opcion_4">Delantera Trasera<strong>*</strong></label><select required name="pcondicion4" id="pcondicion4" class="condiciones "></select></div>
                    </div>
                </div>
                <div class="form-control zdmgy-r10"><h6>Asientos</h6>
                    <div class="subdivicion vaniflex  zdfw-w">
                        <div class="selectconlabel "><label for="opcion_1">Interior Frontal<strong>*</strong></label><select required name="acondicion1" id="acondicion1" class="condiciones "></select></div>
                        <div class="selectconlabel "><label for="opcion_2">Interior Trasera<strong>*</strong></label><select required name="acondicion2" id="acondicion2" class="condiciones "></select></div>
                        <div class="selectconlabel "><label for="opcion_3">Delantera Frontal<strong>*</strong></label><select required name="acondicion3" id="acondicion3" class="condiciones "></select></div>
                        <div class="selectconlabel "><label for="opcion_4">Delantera Trasera<strong>*</strong></label><select required name="acondicion4" id="acondicion4" class="condiciones "></select></div>
                    </div>
                </div>
                <div class="subdivicion vaniflex  form-control zdmgy-r10 zdfw-w">
                    <div class="selectconlabel "><label for="opcion_1">Consola Central<strong>*</strong></label><select required name="condicion1" id="condicion1" class="condiciones "></select></div>
                    <div class="selectconlabel "><label for="opcion_2">Claxon<strong>*</strong></label><select required name="condicion2" id="condicion2" class="condiciones "></select></div>
                    <div class="selectconlabel "><label for="opcion_3">Tablero<strong>*</strong></label><select required name="condicion3" id="condicion3" class="condiciones "></select></div>
                    <div class="selectconlabel "><label for="opcion_4">Quemacocos<strong>*</strong></label><select required name="condicion4" id="condicion4" class="condiciones "></select></div>
                    <div class="selectconlabel "><label for="opcion_5">Toldo<strong>*</strong></label><select required name="condicion5" id="condicion5" class="condiciones "></select></div>
                    <div class="selectconlabel "><label for="opcion_6">Elevadores Electricos<strong>*</strong></label><select required name="condicion6" id="condicion6" class="condiciones "></select></div>
                    <div class="selectconlabel "><label for="opcion_7">Luces Interiores<strong>*</strong></label><select required name="condicion7" id="condicion7" class="condiciones "></select></div>
                    <div class="selectconlabel "><label for="opcion_8">Seguros Electricos<strong>*</strong></label><select required name="condicion8" id="condicion8" class="condiciones "></select></div>
                    <div class="selectconlabel "><label for="opcion_5">Climatizador<strong>*</strong></label><select required name="condicion9" id="condicion9" class="condiciones "></select></div>
                    <div class="selectconlabel "><label for="opcion_6">Radio<strong>*</strong></label><select required name="condicion10" id="condicion10" class="condiciones "></select></div>
                    <div class="selectconlabel "><label for="opcion_7">Espejo Retrovisor<strong>*</strong></label><select required name="condicion11" id="condicion11" class="condiciones "></select></div>
                    <div class="selectconlabel "><label for="opcion_8">Tapetes<strong>*</strong></label><select required name="condicion12" id="condicion12" class="condiciones "></select></div>
                </div>
                <h4>Condiciones De Exteriores y Equipo</h4>
                <div class="vaniflex zdmg-r05  zdjc-between zdfw-w">
                    <div class="selectconlabel"><label for="condicionext">Antena/Radio<strong>*</strong></label><select required name="condicionext1" id="condicionext1" class="condiciones "></select></div>
                    <div class="selectconlabel"><label for="condicionext">Estribos<strong>*</strong></label><select required name="condicionext2" id="condicionext2" class="condiciones "></select></div>
                    <div class="selectconlabel"><label for="condicionext">Antena/Telefoono<strong>*</strong></label><select required name="condicionext3" id="condicionext3" class="condiciones "></select></div>
                    <div class="selectconlabel"><label for="condicionext">Guardafangos<strong>*</strong></label><select required name="condicionext4" id="condicionext4" class="condiciones "></select></div>
                    <div class="selectconlabel"><label for="condicionext">Antena/C.B<strong>*</strong></label><select required name="condicionext5" id="condicionext5" class="condiciones "></select></div>
                    <div class="selectconlabel"><label for="condicionext">Parabrisas<strong>*</strong></label><select required name="condicionext6" id="condicionext6" class="condiciones "></select></div>
                    <div class="selectconlabel"><label for="condicionext">Sist. Alarma<strong>*</strong></label><select required name="condicionext7" id="condicionext7" class="condiciones "></select></div>
                    <div class="selectconlabel"><label for="condicionext">Limpia Parabrisas<strong>*</strong></label><select required name="condicionext8" id="condicionext8" class="condiciones "></select></div>
                    <div class="selectconlabel"><label for="condicionext">Luces Exteriores<strong>*</strong></label><select required name="condicionext9" id="condicionext9" class="condiciones "></select></div>
                    <div class="selectconlabel"><label for="condicionext">Espejos Laterales<strong>*</strong></label><select required name="condicionext10" id="condicionext10" class="condiciones "></select></div>
                </div>
                <div class="vaniflex vaniwidth zdfd-row zdfw-w zdjc-between">
                    
                    <div class="vaniflex zdmg-r05 form-control zdjc-between zdfw-w zdw-45pct">
                        <h4>Varios Equipos - Inventario</h4>
                        <div class="vaniflex zdai-center checkboxconlabel"><label for="inventario1">Llanta Refacccion</label><input type="checkbox" name="inventario1" id="inventario1" class="inventariocheckbox"></div>
                        <div class="vaniflex zdai-center checkboxconlabel"><label for="inventario2">Cubreruedas</label><input type="checkbox" name="inventario2" id="inventario2" class="inventariocheckbox"></div>
                        <div class="vaniflex zdai-center checkboxconlabel"><label for="inventario3">Cables para Corriente</label><input type="checkbox" name="inventario3" id="inventario3" class="inventariocheckbox"></div>
                        <div class="vaniflex zdai-center checkboxconlabel"><label for="inventario4">Candado de rueda</label><input type="checkbox" name="inventario4" id="inventario4" class="inventariocheckbox"></div>
                        <div class="vaniflex zdai-center checkboxconlabel"><label for="inventario5">Estuche De Herramienta</label><input type="checkbox" name="inventario5" id="inventario5" class="inventariocheckbox"></div>
                        <div class="vaniflex zdai-center checkboxconlabel"><label for="inventario6">Extinguidor</label><input type="checkbox" name="inventario6" id="inventario6" class="inventariocheckbox"></div>
                        <div class="vaniflex zdai-center checkboxconlabel"><label for="inventario7">Llave tuercas de rueda</label><input type="checkbox" name="inventario7" id="inventario7" class="inventariocheckbox"></div>
                        <div class="vaniflex zdai-center checkboxconlabel"><label for="inventario8">Gato</label><input type="checkbox" name="inventario8" id="inventario8" class="inventariocheckbox"></div>
                        <div class="vaniflex zdai-center checkboxconlabel"><label for="inventario9">Triangulo de Seguridad</label><input type="checkbox" name="inventario9" id="inventario9" class="inventariocheckbox"></div>
                        <div class="vaniflex zdai-center checkboxconlabel"><label for="inventario10">Placas</label><input type="checkbox" name="inventario10" id="inventario10" class="inventariocheckbox"></div>
                        <div class="vaniflex zdai-center checkboxconlabel"><label for="inventario11">Tarjeta de Circulacion</label><input type="checkbox" name="inventario11" id="inventario11" class="inventariocheckbox"></div>
                    </div>
                    
                    <div class="vaniflex zdmg-r05 form-control zdjc-between zdfw-w zdw-45pct">
                    <h4>Condiciones De Pintura</h4>
                        <div class="vaniflex zdai-center checkboxconlabel"><label for="conpintura1">Decolorada</label><input type="checkbox" name="conpintura1" id="conpintura1" class="conpinturacheckbox"></div>
                        <div class="vaniflex zdai-center checkboxconlabel"><label for="conpintura2">Emblemas completos</label><input type="checkbox" name="conpintura2" id="conpintura2" class="conpinturacheckbox"></div>
                        <div class="vaniflex zdai-center checkboxconlabel"><label for="conpintura3">Color no Igualado</label><input type="checkbox" name="conpintura3" id="conpintura3" class="conpinturacheckbox"></div>
                        <div class="vaniflex zdai-center checkboxconlabel"><label for="conpintura4">Logos en buen estado </label><input type="checkbox" name="conpintura4" id="conpintura4" class="conpinturacheckbox"></div>
                        <div class="vaniflex zdai-center checkboxconlabel"><label for="conpintura5">Exceso de rayones</label><input type="checkbox" name="conpintura5" id="conpintura5" class="conpinturacheckbox"></div>
                        <div class="vaniflex zdai-center checkboxconlabel"><label for="conpintura6">Exceso de rociado</label><input type="checkbox" name="conpintura6" id="conpintura6" class="conpinturacheckbox"></div>
                        <div class="vaniflex zdai-center checkboxconlabel"><label for="conpintura7">Pequeñas grietas</label><input type="checkbox" name="conpintura7" id="conpintura7" class="conpinturacheckbox"></div>
                        <div class="vaniflex zdai-center checkboxconlabel"><label for="conpintura8">Daños por granizo</label><input type="checkbox" name="conpintura8" id="conpintura8" class="conpinturacheckbox"></div>
                        <div class="vaniflex zdai-center checkboxconlabel"><label for="conpintura9">Carroceria con gopes</label><input type="checkbox" name="conpintura9" id="conpintura9" class="conpinturacheckbox"></div>
                        <div class="vaniflex zdai-center checkboxconlabel"><label for="cnopintura10">Lluvia acida</label><input type="checkbox" name="conpintura10" id="conpintura10" class="conpinturacheckbox"></div>
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
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>