<!-- Modal -->
<div class="modal fade" id="recepcionservicioyconceptos" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="recepcionservicioLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="recepcionservicioLabel">Editar Recepcion Taller</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form id="servicioyconceptosrecepcionform">
            @csrf
            <div class="modal-body">
                <!-- Datos del Vehículo -->
                <p class="h5 text-uppercase font-weight-bold border-bottom">Datos del Vehículo</p>
                <div class="vaniflex zdmg-r05 zdjc-between zdfw-w">
                    <div class=" selectconlabel zdmg-r02">
                        <label for="Economico">Economico<strong>*</strong></label>
                        <input required class="form-control" type="number"  id="2rsEconomico" name="2rsEconomico">
                    </div> <div class=" selectconlabel zdmg-r02">
                        <label for="rsmodelo">Modelo<strong>*</strong></label>
                        <input required class="form-control" type="text"  id="2rsmodelo" name="2rsmodelo">
                    </div> <div class=" selectconlabel zdmg-r02">
                        <label for="rsvin">VIN<strong>*</strong></label>
                        <input required class="form-control" type="text"  id="2rsvin" name="2rsvin">
                    </div> <div class=" selectconlabel zdmg-r02">
                        <label for="rsplacas">Placas<strong>*</strong></label>
                        <input required class="form-control" type="text"  id="2rsplacas" name="2rsplacas">
                    </div> <div class=" selectconlabel zdmg-r02">
                        <label for="rsAño">Año<strong>*</strong></label>
                        <input required class="form-control" type="text"  id="2rsAño" name="2rsAño">
                    </div> <div class=" selectconlabel zdmg-r02">
                        <label for="rsKilometraje">Kilometraje<strong>*</strong></label>
                        <input required class="form-control" type="number"  id="2rsKilometraje" name="2rsKilometraje">
                    </div> <div class=" selectconlabel zdmg-r02">
                        <label for="rsMarca">Marca<strong>*</strong></label>
                        <input required class="form-control" type="text"  id="2rsMarca" name="2rsMarca">
                    </div> <div class=" selectconlabel zdmg-r02">
                        <label for="rsUbicación">Ubicación<strong>*</strong></label>
                        <input required class="form-control" type="text"  id="2rsUbicación" name="2rsUbicación">
                    </div>
                </div>

                <!-- Datos Generales de la Solicitud -->
                <p class="h5 text-uppercase font-weight-bold border-bottom">Datos Generales de la Solicitud</p>
                <div class="vaniflex zdmg-r05 zdjc-between zdfw-w">
                    <div class=" selectconlabel zdmg-r02">
                        <label for="rsFolio">Folio<strong>*</strong></label>
                        <input required class="form-control" type="text"  id="2rsFolio" name="2rsFolio">
                    </div>
                    <div class=" selectconlabel zdmg-r02">
                        <label for="rsFecha_Alta">Fecha Alta<strong>*</strong></label>
                        <input required class="form-control" type="datetime-local"  id="2rsFecha_Alta" name="2rsFecha_Alta">
                    </div>
                    <div class=" selectconlabel zdmg-r02">
                        <label for="rsid">ID<strong>*</strong></label>
                        <input required class="form-control" type="text"  id="2rsid" name="2rsid">
                    </div>
                    <div class=" selectconlabel zdmg-r02">
                        <label for="rsKm_De_Ingreso">Km De Ingreso<strong>*</strong></label>
                        <input required class="form-control" type="number"  id="2rsKm_De_Ingreso" name="2rsKm_De_Ingreso">
                    </div>
                    <div class=" selectconlabel zdmg-r02">
                        <label for="rsAdministrador_de_Transportes">Administrador de Transportes<strong>*</strong></label>
                        <input required class="form-control" type="text"  id="2rsAdministrador_de_Transportes" name="2rsAdministrador_de_Transportes">
                    </div>
                    <div class=" selectconlabel zdmg-r02">
                        <label for="rsJefe_de_Proceso">Jefe de Proceso<strong>*</strong></label>
                        <input required class="form-control" type="text"  id="2rsJefe_de_Proceso" name="2rsJefe_de_Proceso">
                    </div>
                    <div class=" selectconlabel zdmg-r02">
                        <label for="rsTeléfono">Teléfono<strong>*</strong></label>
                        <input required class="form-control" type="tel"  id="2rsTeléfono" name="2rsTeléfono">
                    </div>
                    <div class=" selectconlabel zdmg-r02">
                        <label for="rsTrabajador">Trabajador<strong>*</strong></label>
                        <input required class="form-control" type="text"  id="2rsTrabajador" name="2rsTrabajador">
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="rsObservaciones">Observaciones</label>
                            <textarea class="form-control" placeholder="Notas" cols="30" rows="5" id="2rsObservaciones" name="2rsObservaciones"></textarea>
                        </div>
                    </div>
                </div>
            
            <div class="d-flex superior">
                    <button type="button" class="btn btn-primary" onclick="agregarnuevosconceptos()"><i class="fa-solid fa-circle-plus"></i>&nbsp;Agregar</button>
                    <button type="button" class="btn btn-secondary"  onclick="agregarconceptos()"><i class="fa-solid fa-bars"></i>&nbsp;Conceptos</button>
            </div>
            <p class="h5 text-uppercase font-weight-bold border-bottom">Diagnostico</p>
            <div>
            <table id="tablaconceptos" class="table table-sm  table-striped">
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Cantidad</th>
                        <th>Concepto</th>
                        <th>Precio Unitario</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
            </div>
            <div class="vaniflex zdmg-r05 zdjc-between zdfw-w">
                <div class="zdw-40pct vaniflex zdfd-column">
                    
                    <label for="descricionmo">Descripcion M.O.</label>
                    <textarea class="zdh-100pct form-control" name="descricionmo" id="descricionmo"></textarea>
                </div>
                <div class="zdw-40pct vaniflex zdfd-column">
                <label for="descricionmo">Tiempo de Entrega</label>
                <textarea class="zdh-100pct form-control" name="tiempoentrega" id="tiempoentrega"></textarea>
                </div>
                <div class="zdw-20pct vaniflex zdfd-column">
                    <div class="vaniflex zdfd-column zdmgb-r05"> 
                    <label for="">Importe</label>
                    <input type="number" class="form-control">
                    </div>
                    <label class="ImporteConceptos" for="">Subtotal: $0</label>
                    <label class="ImporteConceptos" for="">Iva:      $0</label>
                    <label class="ImporteConceptos" for="">Total:    $0</label>

                </div>
                
            </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" id="2guardarDatos">Guardar</button>
            </div>
</form>
        </div>
    </div>
</div>
@include('modales.ConceptosModal')
@include('modales.anadirconceptosmodal')
@push('scripts')
<script>
    $(function(){
    let listacoceptos=new Map;

    window.executeagregarservicio2 = function(id) {
        $.ajax({
            type: 'GET',
            url: '{{ route('2025.cfe.obtener.talleres') }}',
            data:{
                idservicio: id,
            },
            success: function(response) {
                llenar_campos(response.recepcion)
            },
            error: function(xhr, status, error) {
                console.error(xhr);
            }
        }); 
    }
        window.agregarnuevosconceptos= function(){
            $("#recepcionservicioyconceptos").modal("hide");
            $("#nuevosconceptos").modal("show");
        }
        
        function llenar_campos(data){
            console.log(data);
            
            let fecha=data.FechaAlta+" 00:00:00";
            console.log(fecha)
            $("#2rsEconomico").val(data.identificador);
            $("#2rsmodelo").val(data.modelo);
            $("#2rsvin").val(data.vin);
            $("#2rsplacas").val(data.placas);
            $("#2rsAño").val(data.ano);
            $("#2rsKilometraje").val(data.kilometraje);
            $("#2rsMarca").val(data.marca);
            $("#2rsUbicación").val(data.ubicacion);
            $("#2rsFolio").val(data.NSolicitud);
            $("#2rsFecha_Alta").val(fecha);
            $("#2rsid").val(data.OrdenServicio);
            $("#2rsKm_De_Ingreso").val(data.kilometraje);
            $("#2rsAdministrador_de_Transportes").val(data.ClienteYRazonSocial);
            $("#2rsJefe_de_Proceso").val(data.Mail);
            $("#2rsTeléfono").val(data.Telefono);
            $("#2rsTrabajador").val(data.Conductor);
            $("#2rsObservaciones").val(data.observaciones);
            $("#recepcionservicioyconceptos").modal("show");
        }
   

    window.actualizartablaconceptos= function(map2){
        let mensajes = []; // Almacena mensajes de elementos ignorados

        for (let [key, value] of map2) {
            if (listacoceptos.has(key)) {
                mensajes.push(value.descripcion);
            } else {
                // Si la clave no existe, se agrega al listacoceptos
                listacoceptos.set(key, value);
            }
        }
        if (mensajes.length > 0) {
            Swal.fire({
                title: 'Los Siguientes Conceptos Se Ignoraron Porque ya Estaban Agregados',
                html: `<ul>${mensajes.map(item => `<li>${item}</li>`).join('')}</ul>`,
                icon: 'Warning',
                showConfirmButton: true,
            });
        } else {
            Swal.fire({
                title: 'Todos los Conceptos se agregaron Correctamente',
                icon: 'success',
                timer: 4000,  // 4 segundos
                showConfirmButton: false,
            });

    }
    console.log(listacoceptos);
    }
});
</script>
@endpush