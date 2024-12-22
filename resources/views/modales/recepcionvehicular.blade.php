<div class="modal fade" id="RecepcionVehicular" tabindex="-1" aria-labelledby="taskModalLabal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Encabezado del modal -->
            <div class="modal-header">
                <h5 class="modal-title" id="miModalLabel">Nueva Recepcion Vehicular</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <h4>Datos Generales</h4>
            <div class="vaniflex zdmg-r05 zdjc-between zdfw-w">
                <div class="vaniflex zdfd-column zdmgr-r02"><label for="">Ord. Seguimiento</label><input type="text" name="" id=""></div>
                <div class="vaniflex zdfd-column zdmgr-r02"><label for="">Folio</label><input type="text" name="" id=""></div>
                <div class="vaniflex zdfd-column"><label for=""> Fecha</label><input type="datetime-local" name="" id=""></div>
            </div>
            <h4>Datos Cliente</h4>
            <div class="vaniflex zdmg-r05 zdjc-between zdfw-w">
                <div>
                    <label for="">Empresa</label>  
                                <select class="empresas-Select2" id="subempresas">
                                        <option value="">Todas</option>
                                </select>
                                <button type="button">+</button>
                </div>
                <div>
                    <label for="">Clientes</label>
                                <select class="empresas-Select2" id="clientes">
                                        <option value="">Todas</option>
                                </select>
                                <button type="button">+</button>
                </div>
            </div>
            <h4>Datos Del Vehiculo</h4>
            <div class="vaniflex zdmg-r05 zdjc-between zdfw-w">
                <div ><label for="">Vehiculo <span> #Econonomico- Placas</span></label><select class="empresas-Select2" id="vehiculo">
                                        <option value="">Todas</option>
                                </select><button type="button">+</button></div>
                <div class="vaniflex zdfd-column"><label for="">Km Entrada </label><input type="number" name="" id=""></div>
                <div class="vaniflex zdfd-column"><label for="">Km Salida</label><input type="number" name="" id=""></div>
                <div class="vaniflex zdfd-column"><label for="">Gasolina Entreda</label>
                <select id="gasentrada">
                                        <option value="">Seleccionar</option>
                                        <option value="">LLENO</option>
                                        <option value="">3/4</option>
                                        <option value="">2/4</option>
                                        <option value="">1/4</option>
                                </select>
                </div>
                <div class="vaniflex zdfd-column"><label for="">Gasolina Salida</label>
                <select id="gassalida">
                                        <option value="">Seleccionar</option>
                                        <option value="">LLENO</option>
                                        <option value="">3/4</option>
                                        <option value="">2/4</option>
                                        <option value="">1/4</option>
                                </select></div>
            </div>
            <h4>Datos Del Tecnico</h4>
            <div class="vaniflex zdmg-r05 zdjc-between zdfd-column">
                <label for="">Tecnico</label>
                <input type="text">
            </div>
            <h4>Daños Fisicos Notables</h4>
            <div class="vaniflex zdmg-r05 zdjc-between zdfw-w">
                <label for="">Tipo de Auto</label>
                <select name="tipo_auto" class="form-control"><option value="0">Seleccione el tipo de auto</option> <option value="1">Coche 2p</option> <option value="2">Coche 4p</option> <option value="3">Camioneta</option> <option value="4">Subirban</option></select>
                <canvas id="miCanvas"></canvas>
                <button id="deshacer">Deshacer</button>
                <button id="limpiar">Limpiar Canvas</button>
            </div>
            <h4>Datos Del Responsable</h4>
            <div class="vaniflex zdmg-r05 zdjc-between zdfw-w">
            <div class="row"><div class="col-12 col-lg-6"><label for="tel-seg">
                                            Firma 
                                            <i class="fa fa-asterisk text-secundary ml-2"></i></label> <div class="border mb-3" style="width: 100%; height: 200px;"><canvas style="width: 100%; height: 100%; touch-action: none;" width="802" height="298"></canvas></div> <div><button class="btn btn-primary">
                                                Guardar firma
                                            </button> <button class="btn btn-secondary">
                                                Paso anterior
                                            </button></div></div> <div class="col-12 col-lg-6"><div class="form-group"><label for="tel-seg">Comprometido para
                                                <small>fecha y hora _20191226112707</small><i class="fa fa-asterisk text-secundary ml-2"></i></label> <div class="vdatetime"> <input id="fecha-id" type="text" class="vdatetime-input form-control"> <!---->  <div></div></div></div> <div class="form-group"><label for="tel-seg">fecha de entrega:
                                                <small>fecha y hora _20191226112707</small><i class="fa fa-asterisk text-secundary ml-2"></i></label> <div class="vdatetime"> <input id="fecha-id" type="text" class="vdatetime-input form-control"> <!---->  <div></div></div></div></div></div>
            </div>
            <h4>Condiciones De Interiores Y Equipo</h4>
            <div class="vaniflex zdmg-r05 zdjc-between zdfw-w">
            </div>
            <h4>Condiciones De Exteriores y Equipo</h4>
            <div class="vaniflex zdmg-r05 zdjc-between zdfw-w">
            </div>
            <h4>Varios Equipos - Inventario</h4>
            <div class="vaniflex zdmg-r05 zdjc-between zdfw-w">
            </div>
            <h4>Condiciones De Pintura</h4>
            <div class="vaniflex zdmg-r05 zdjc-between zdfw-w">
            </div>
            <h4>Notas Adicionales</h4>
            <div class="vaniflex zdmg-r05 zdjc-between zdfw-w">
            </div>
            <h4>Otros Datos</h4>
            <div class="vaniflex zdmg-r05 zdjc-between zdfw-w">
            </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>