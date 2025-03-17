<!-- Modal -->
<div class="modal fade" id="recepcionservicioyconceptos" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="recepcionservicioLabel" >
    <div class="modal-dialog zdmw-95pct modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="recepcionservicioLabel">Editar Recepcion Taller</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
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
                <button type="button" class="btn btn-primary" onclick="agregarnuevosconceptos()"><i class="fa-solid fa-circle-plus"></i>&nbsp;Nuevo</button>
                <button type="button" class="btn btn-success"  onclick="agregarconceptos()" id="agragarconceptosacarrito"><i class="fa-solid fa-bars"></i>&nbsp;Agregar</button>
            </div>
            <p class="h5 text-uppercase font-weight-bold border-bottom">Diagnostico</p>
            <div>
            <table id="tablaconceptos" class="table table-sm  table-striped">
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Cantidad</th>
                        <th>Vehiculo</th>
                        <th>Concepto</th>
                        <th>Precio</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
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
                    <div class="vaniflex zdfd-column"> 
                        <label for="">Importe</label>
                        <label class="ImporteConceptos" id="subtotaldiagnostico" for="">Subtotal: $0</label>
                        <label class="ImporteConceptos" id="ivadiagnostico" for="">Iva:      $0</label>
                        <label class="ImporteConceptos" id="totaldiagnostico" for="">Total:    $0</label>
                    </div>

                </div>
                
            </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="2guardarDatos">Guardar Cambios</button>
            </div>

        </div>
    </div>
</div>
@include('modales.anadirconceptosmodal')
@include('modales.ConceptosModal')
@push('scripts')
<script>
    $(function(){
    let listaconceptos=[];
    window.eliminarconcepto= function(id,des){

        Swal.fire({
            title: '¿Está seguro de eliminar el siguiente producto?',
            text: des,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, Eliminar',
            cancelButtonText: 'Regresar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route('2025.cfe.update.eliminarconceptopresupuesto') }}', // Cambia esto por la URL del endpoint en tu backend
                    method: 'post',
                    data: {
                        id:id,
                        _token: "{{ csrf_token() }}",
                    },
                    success: function (response) {
                        if (response === "Eliminado") {
                            console.log(listaconceptos);
                            console.log(id);
                            listaconceptos = listaconceptos.filter(record => record.id != id);
                            console.log(listaconceptos);
                            actualizarlista() 
                        Swal.fire({
                            icon: "success",
                            title: "Cotizacion Actualizada correctamente",
                            showConfirmButton: false,
                            timer: 2000,
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            html: response,
                        });
                    }
                    },
                    error: function (error) {
                        Swal.fire(
                            'Error!',
                            'Hubo un problema al eliminarlo',
                            'error'
                        );
                    }
                });
            } 
        });
    }
    window.executeagregarservicio2 = function(id) {
        $.ajax({
            type: 'GET',
            url: '{{ route('2025.cfe.obtener.talleres') }}',
            data:{
                idservicio: id,
            },
            success: function(response) {
                listaconceptos=response.conceptos;
                console.log(response.recepcion)
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
        
        function llenar_campos(data,id){
            console.log(listaconceptos);
            
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
            $("#tiempoentrega").val(data.tdeentrega);
            $("#descricionmo").val(data.descripcionMO);
            $("#agragarconceptosacarrito").attr("data-id", data.id);
            $("#2guardarDatos").attr("data-id", data.id);
            actualizarlista()
            let subtotal = 0;
                listaconceptos.forEach(item => {
                    subtotal += item.cantidad * item.precio;
            });
            let iva=subtotal*0.16;
            let total=subtotal+iva;
            $('#subtotaldiagnostico').text("Subtotal: $").append(subtotal.toFixed(2));
            $('#ivadiagnostico').text("Iva:      $").append(iva.toFixed(2));
            $('#totaldiagnostico').text("Total:    $").append(total.toFixed(2));

            $("#recepcionservicioyconceptos").modal("show");

        }
   window.reloadlista = function(id){
    $.ajax({
            type: 'GET',
            url: '{{ route('2025.cfe.obtener.conceptospresupuesto') }}',
            data:{
                id: id,
            },
            success: function(response) {
                listaconceptos=response.conceptos;
                console.log(listaconceptos);
                actualizarlista()
            },
            error: function(xhr, status, error) {
                console.error(xhr);
            }
        }); 
};

    function actualizarlista(){
        console.log("se esta actualizando")
        $('#tablaconceptos tbody').empty();
        $.each(listaconceptos, function(index, element) {
            let row = $('<tr>'); 
            row.append('<td><div class="Datatable-content">' + (element.concepto.num ? element.concepto.num : "Sin Codigo" ) + '</div></td>');
            row.append('<td><div class="Datatable-content"><input type="number" class="cantidaddiagnostico zdw-r4" data-id="'+element.id+'"  value='+element.cantidad+' ></input></div></td>');
            row.append('<td><div class="Datatable-content">' + (element.concepto.tipodata ? element.concepto.tipodata.tipo : "Sin descripcion" ) + '</div></td>');
            row.append('<td><div class="Datatable-content">' + (element.concepto ? element.concepto.descripcion : "Sin descripcion" ) + '</div></td>');
            row.append('<td><div class="Datatable-content"><input type="number" class="preciodiagnostico zdw-r4" data-id="'+element.id+'" value='+element.precio+'></input></div></div></td>');
            row.append('<td><label data-id="'+element.id+'" class="subtotaldiagnostico ">' + (element.cantidad * element.precio) + '</label></td>');
            row.append('<td><button class="btn btn-danger" onclick="eliminarconcepto(\''+(element.id ? element.id : 1 )+'\',\''+(element.concepto ? element.concepto.descripcion : "Sin descripcion" )+'\')"><i class="fa-solid fa-trash"></i></button></td>');
            $('#tablaconceptos tbody').append(row);
        });
            let subtotal = 0;
                listaconceptos.forEach(item => {
                    subtotal += item.cantidad * item.precio;
            });
            let iva=subtotal*0.16;
            let total=subtotal+iva;
            
            $('#subtotaldiagnostico').text("Subtotal: $").append(subtotal.toFixed(2));
            $('#ivadiagnostico').text("Iva:      $").append(iva.toFixed(2));
            $('#totaldiagnostico').text("Total:    $").append(total.toFixed(2));
    }
    $(document).on('change','.preciodiagnostico, .cantidaddiagnostico', function () {
        console.log("secambia")
            const val = parseFloat($(this).val()) || 0; // Obtener el valor del input
            const id = parseInt($(this).data('id')); // Obtener el ID del data-id
            const itemIndex = listaconceptos.findIndex((item) => item.id === id); // Encontrar el índice

            if (itemIndex !== -1) {
                // Actualizar el valor correspondiente en el array
                if ($(this).hasClass('preciodiagnostico')) {
                    listaconceptos[itemIndex].precio = val;
                } else if ($(this).hasClass('cantidaddiagnostico')) {
                    listaconceptos[itemIndex].cantidad = val;
                }

                // Recalcular y mostrar el subtotal
                const subtotal = listaconceptos[itemIndex].cantidad * listaconceptos[itemIndex].precio;

                actualizarlista();

            }
            
    });
    $('#2guardarDatos').on('click',function(){
        let subtotal = 0;
                listaconceptos.forEach(item => {
                    subtotal += item.cantidad * item.precio;
            });
        Swal.fire({
            title: '¿Está seguro?',
            text: "Los datos se guardarán en el sistema.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route('2025.cfe.update.cotizacion') }}', // Cambia esto por la URL del endpoint en tu backend
                    method: 'POST',
                    data: {
                        id:$(this).attr("data-id"),
                        identificador: $("#2rsEconomico").val(),
                        modelo: $("#2rsmodelo").val(),
                        vin: $("#2rsvin").val(),
                        placas: $("#2rsplacas").val(),
                        ano: $("#2rsAño").val(),
                        kilometraje: $("#2rsKilometraje").val(),
                        marca: $("#2rsMarca").val(),
                        ubicacion: $("#2rsUbicación").val(),
                        NSolicitud: $("#2rsFolio").val(),
                        fecha_alta: $("#2rsFecha_Alta").val(),
                        orden_servicio: $("#2rsid").val(),
                        km_ingreso: $("#2rsKm_De_Ingreso").val(),
                        cliente_razon_social: $("#2rsAdministrador_de_Transportes").val(),
                        jefe_proceso: $("#2rsJefe_de_Proceso").val(),
                        telefono: $("#2rsTeléfono").val(),
                        conductor: $("#2rsTrabajador").val(),
                        observaciones: $("#2rsObservaciones").val(),
                        observacionesmo: $("#descricionmo").val(),
                        tdentrega: $("#tiempoentrega").val(),
                        importe:subtotal,
                        conceptos:listaconceptos,
                        modulo:@json($modulo),
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        if (response === "Actualizado") {
                        Swal.fire({
                            icon: "success",
                            title: "Cotizacion Actualizada correctamente",
                            showConfirmButton: false,
                            timer: 2000,
                        });
                        $('#recepcionservicioyconceptos').modal('hide');
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            html: response,
                        });
                    }
                    },
                    error: function (error) {
                        Swal.fire(
                            'Error!',
                            'Hubo un problema al guardar los datos.',
                            'error'
                        );
                    }
                });
            } 
        });
    })
});
</script>
@endpush