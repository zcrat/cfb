<!-- Modal -->
<div class="modal fade" id="recepcionservicio" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="recepcionservicioLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="recepcionservicioLabel">Nueva Recepcion Taller</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form id="serviciorecepcionform">
            @csrf
            <div class="modal-body">
                <!-- Datos del Vehículo -->
                <p class="h5 text-uppercase font-weight-bold border-bottom">Datos del Vehículo</p>
                <div class="vaniflex zdmg-r05 zdjc-between zdfw-w">
                    <div class=" selectconlabel zdmg-r02">
                        <label for="Economico">Economico<strong>*</strong></label>
                        <input required class="form-control" type="number"  id="rsEconomico" name="rsEconomico">
                    </div> <div class=" selectconlabel zdmg-r02">
                        <label for="rsmodelo">Modelo<strong>*</strong></label>
                        <input required class="form-control" type="text"  id="rsmodelo" name="rsmodelo">
                    </div> <div class=" selectconlabel zdmg-r02">
                        <label for="rsvin">VIN<strong>*</strong></label>
                        <input required class="form-control" type="text"  id="rsvin" name="rsvin">
                    </div> <div class=" selectconlabel zdmg-r02">
                        <label for="rsplacas">Placas<strong>*</strong></label>
                        <input required class="form-control" type="text"  id="rsplacas" name="rsplacas">
                    </div> <div class=" selectconlabel zdmg-r02">
                        <label for="rsAño">Año<strong>*</strong></label>
                        <input required class="form-control" type="text"  id="rsAño" name="rsAño">
                    </div> <div class=" selectconlabel zdmg-r02">
                        <label for="rsKilometraje">Kilometraje<strong>*</strong></label>
                        <input required class="form-control" type="number"  id="rsKilometraje" name="rsKilometraje">
                    </div> <div class=" selectconlabel zdmg-r02">
                        <label for="rsMarca">Marca<strong>*</strong></label>
                        <input required class="form-control" type="text"  id="rsMarca" name="rsMarca">
                    </div> <div class=" selectconlabel zdmg-r02">
                        <label for="rsUbicación">Ubicación<strong>*</strong></label>
                        <input required class="form-control" type="text"  id="rsUbicación" name="rsUbicación">
                    </div>
                </div>

                <!-- Datos Generales de la Solicitud -->
                <p class="h5 text-uppercase font-weight-bold border-bottom">Datos Generales de la Solicitud</p>
                <div class="vaniflex zdmg-r05 zdjc-between zdfw-w">
                    <div class=" selectconlabel zdmg-r02">
                        <label for="rsFolio">Folio<strong>*</strong></label>
                        <input required class="form-control" type="text"  id="rsFolio" name="rsFolio">
                    </div>
                    <div class=" selectconlabel zdmg-r02">
                        <label for="rsFecha_Alta">Fecha Alta<strong>*</strong></label>
                        <input required class="form-control" type="datetime-local"  id="rsFecha_Alta" name="rsFecha_Alta">
                    </div>
                    <div class=" selectconlabel zdmg-r02">
                        <label for="rsid">ID<strong>*</strong></label>
                        <input required class="form-control" type="text"  id="rsid" name="rsid">
                    </div>
                    <div class=" selectconlabel zdmg-r02">
                        <label for="rsKm_De_Ingreso">Km De Ingreso<strong>*</strong></label>
                        <input required class="form-control" type="number"  id="rsKm_De_Ingreso" name="rsKm_De_Ingreso">
                    </div>
                    <div class=" selectconlabel zdmg-r02">
                        <label for="rsAdministrador_de_Transportes">Administrador de Transportes<strong>*</strong></label>
                        <input required class="form-control" type="text"  id="rsAdministrador_de_Transportes" name="rsAdministrador_de_Transportes">
                    </div>
                    <div class=" selectconlabel zdmg-r02">
                        <label for="rsJefe_de_Proceso">Jefe de Proceso<strong>*</strong></label>
                        <input required class="form-control" type="text"  id="rsJefe_de_Proceso" name="rsJefe_de_Proceso">
                    </div>
                    <div class=" selectconlabel zdmg-r02">
                        <label for="rsTeléfono">Teléfono<strong>*</strong></label>
                        <input required class="form-control" type="tel"  id="rsTeléfono" name="rsTeléfono">
                    </div>
                    <div class=" selectconlabel zdmg-r02">
                        <label for="rsTrabajador">Trabajador<strong>*</strong></label>
                        <input required class="form-control" type="text"  id="rsTrabajador" name="rsTrabajador">
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="rsObservaciones">Observaciones</label>
                            <textarea class="form-control" placeholder="Notas" cols="30" rows="5" id="rsObservaciones" name="rsObservaciones"></textarea>
                        </div>
                    </div>
                </div>
                <p class="h5 text-uppercase font-weight-bold border-bottom">Datos Generales de la Solicitud</p>
                <div class="form-group row border">
                    <div class="vaniflex zdmg-r05 zdjc-between zdfw-w">
                        <div class="selectconlabel zdmg-r02">
                            <label for="rsServicio">Servicio</label>
                            <select class="form-control" id="rsServicio" name="rsServicio" required>
                                <option value="">Seleccione el tipo de servicio</option>
                                <option value="1">Preventivo</option>
                                <option value="2">Correctivo</option>
                            </select>
                        </div>
                        <div class="select2conlabel zdmg-r02">
                            <label for="rsUbicacion2">Ubicacion</label>
                            <select required class="form-control" id="rsUbicacion2" name="rsUbicacion2"></select>
                            <button id="btnrsUbicacion2" class="btnin" type="button">+</button>
                        </div>
                        <div class="selectconlabel zdmg-r02">
                            <label for="rsArea">Area</label>
                            <select required class="form-control" id="rsArea" name="rsArea">
                                <option value="">Selecciona</option>
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
                <div class="vaniflex zdmg-r05 zdjc-between zdfw-w" id="serviciopreventivo" hidden>
                    <div class="selectconlabel">
                        <label for="rsTipo_de_Servicio">Tipo de Servicio</label>
                        <select class="form-control"  id="rsTipo_de_Servicio" name="rsTipo_de_Servicio">
                        <option value="1">Mayor</option>
                        <option value="2">Menor</option>
                        </select>
                    </div>
                    <div class="selectconlabel">
                        <label for="rsKilometraje2">Kilometraje</label>
                        <input  class="form-control" type="number"id="rsKilometraje2" name="rsKilometraje2"></input>
                    </div>
                </div>
                <div class="vaniflex zdmg-r05 zdjc-between zdfw-w" id="serviciocorrectivo" hidden>
                    <div class="select2conlabel">
                        <label for="rsCorrectivos">Correctivos</label>
                        <select  class="form-control" id="rsCorrectivos" name="rsCorrectivos[]" multiple></select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" id="guardarDatos">Guardar</button>
            </div>
</form>
        </div>
    </div>
</div>
@push('scripts')
<script>
    $(function(){
        idempresa="";
    window.executeagregarservicio = function(id,empresa) {
            eval("agregarservicio(id,empresa)");
        };
        function agregarservicio(id,empresa){
           idempresa=empresa;
        $.ajax({
            type: 'GET',
            url: '{{ route('2025.cfe.obtener.datosservicio') }}',
            data:{
                orden: id,
                modulo : @json($modulo),
            },
            success: function(response) {
                console.log("hfsjka")
               
                
                console.log(idempresa);
                llenar_campos(response.data)
            },
            error: function(xhr, status, error) {
                console.error(xhr);
            }
        }); 
        }
     
        function llenar_campos(data){
            console.log(data)
            $("#rsEconomico").val(data.economico);
            $("#rsmodelo").val(data.modelo);
            $("#rsvin").val(data.vin);
            $("#rsplacas").val(data.placas);
            $("#rsAño").val(data.anio);
            $("#rsKilometraje").val(data.km);
            $("#rsMarca").val(data.marca);
            $("#rsUbicación").val(data.ubicacion);
            $("#rsFolio").val(data.folio);
            $("#rsFecha_Alta").val(data.fecha);
            $("#rsid").val(data.id);
            $("#rsKm_De_Ingreso").val(data.km);
            $("#rsAdministrador_de_Transportes").val(data.administrador);
            $("#rsJefe_de_Proceso").val(data.jefedeprocesos);
            $("#rsTeléfono").val(data.telefonojefe);
            $("#rsTrabajador").val(data.trabajador);
            $("#rsObservaciones").val(data.notas);
            $("#recepcionservicio").modal("show");
        }
        $('#rsServicio').on('change',function(){
            if($(this).val()==1){
                $('#serviciocorrectivo').attr("hidden",true);
                $('#serviciopreventivo').removeAttr("hidden");
            }else if($(this).val()==2){
                $('#serviciopreventivo').attr("hidden");
                $('#serviciocorrectivo').removeAttr("hidden");
            }else{
                $('#serviciopreventivo').attr("hidden");
                $('#serviciocorrectivo').attr("hidden");
            }
        })
        $("#serviciorecepcionform").submit(function(e) {
      e.preventDefault();
      let modal=$("#recepcionservicio");
      let guardar=$("#guardarDatos")
      let ruta="{{ route('2025.cfe.guardar.nuevarecepcionservicio') }}";
      let form= $("#serviciorecepcionform");
      let id_empresa= window.idempresa;
      let data=  form.serialize() + '&modulo='+@json($modulo)+ '&empresa_id='+id_empresa;
      modal.modal("hide");
      guardar.attr("disabled", true);
      Swal.fire({
              icon: "question",
              text: "¿Estás seguro de guardar el servicio?",
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
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Ocurrió un error inesperado",
                    }).then(() => {
                        modal.modal("show");
                       
                    });
                
              });
            } else {
                modal.modal("show");
                guardar.attr("disabled", false);
                
            }
      });
      
    });

       
    });
</script>
@endpush