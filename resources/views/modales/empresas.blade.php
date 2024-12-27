<div class="modal fade modal-basic" id="Empresa_modal" tabindex="-1" aria-labelledby="taskModalLabal" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-uppercase" id="modalcompanititle"></h5>
                    <button type="button" class="btn-close closenewempresa" >
                        
                    </button>
                </div>
                <div class="modal-body">
                    <form id="EmpresaForm" method="post" enctype="multipart/form-data" >
                        @csrf
                        <input id="compani_id" class="form-control" type="hidden" name="compani_id">
                        <div class="form-group">
                            <label for="compani_nombre">Nombre:<i class="ml-2 color-required fas fa-asterisk"></i></label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fas fa-building"></i>
                                </div>
                                <input id="compani_nombre" class="form-control" type="text" name="compani_nombre" placeholder="Ej. Akumas" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="compani_rfc">RFC:<i class="ml-2 color-required fas fa-asterisk"></i></label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fas fa-building"></i>
                                </div>
                                <input id="compani_rfc" class="form-control" type="text" name="compani_rfc" placeholder="Ej. EUFA870518H53" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="compani_logo">Logo:<i class="ml-2 color-required fas fa-asterisk"></i></label>
                            <div class="logos">
                                <img id="logo_preview" src="#" alt="Logo Preview" class="mimagen" hidden>
                            </div>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fas fa-building"></i>
                                </div>
                                <input id="compani_logo" class="form-control" type="file" accept="image/*" name="compani_logo">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="compani_email">Email:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fas fa-building"></i>
                                </div>
                                <input id="compani_email" class="form-control" type="email" name="compani_email" placeholder="Ej. designapp.mx@gmail.com" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label >Regimen Fiscal</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fas fa-building"></i>
                                </div>
                                <select id="compani_regimen" class="form-control" name="compani_regimen" required>
                                    <option value="">Seleccione El regimen </option>
                                    @foreach($Regimenes as $regimen)
                                        <option value="{{ $regimen['id'] }}">{{ $regimen['nombre'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="compani_direccion">Dirección:<i class="ml-2 color-required fas fa-asterisk"></i></label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <input id="compani_direccion" class="form-control" type="text" name="compani_direccion" placeholder="Ej. C. PUERTO DE ACAPULCO NO. 328, COL. TINIJARO, C.P. 58337" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="compani_ciudad">Ciudad:<i class="ml-2 color-required fas fa-asterisk"></i></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                        <input id="compani_ciudad" class="form-control" type="text" name="compani_ciudad" placeholder="Ej. Morelia" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="compani_estado">Estado:<i class="ml-2 color-required fas fa-asterisk"></i></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                        <input id="compani_estado" class="form-control" type="text" name="compani_estado" placeholder="Ej. Michoacán" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="compani_cp">C.P.:<i class="ml-2 color-required fas fa-asterisk"></i></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                        <input id="compani_cp" class="form-control" type="text" name="compani_cp" placeholder="Ej. 58000" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="compani_tel_casa">Tel Casa:<i class="ml-2 color-required fas fa-asterisk"></i></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fas fa-phone"></i>
                                        </div>
                                        <input id="compani_tel_casa" class="form-control" type="text" name="compani_tel_casa" placeholder="Ej. 4431040746" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="compani_tel_negocio">Tel Oficina:<i class="ml-2 color-required fas fa-asterisk"></i></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fas fa-phone"></i>
                                        </div>
                                        <input id="compani_tel_negocio" class="form-control" type="text" name="compani_tel_negocio" placeholder="Ej. 4431040746" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="compani_tel_celular">Tel Celular:<i class="ml-2 color-required fas fa-asterisk"></i></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fas fa-phone"></i>
                                        </div>
                                        <input id="compani_tel_celular" class="form-control" type="text" name="compani_tel_celular" placeholder="Ej. 4431040746" required>
                                    </div>
                                </div>
                            </div>
                        </div>   
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary closenewempresa" data-dismiss="modal">Cancelar</button>
                    <button type="submit" hidden id="empresaupdated" form="EmpresaForm"class="btn btn-primary">Actualizar</button>
                    <button type="submit" id="newempresa" form="EmpresaForm" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>