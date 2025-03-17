@extends ('layouts.admin2')
@section ('contenido')

<main class="main vaniflex vanigrow">
    <div class="container-fluid vaniflex vanigrow">
            <div class="card vanigrow">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i>Aprobaciones Taller
                    <button class="btn btn-primary" disabled id="Verprefacturas">Ver Prefacturas</button>
                    <div id="submenu"></div>
                </div>
                <div class="card-body mycard ">
                    <div class="vaniwidth vaniflex zdfd-column" id="dataupload" >
                        <div class="d-flex">
                        
                            <div class="iconoin zdmgr-r05">
                                <input class="misearch zdw-r29"
                                    type="text" id="search" name="s"
                                    placeholder="Busqueda Por Folio, Marca, Modelo, Vin, Economico, etc" >
                                    <i class="fa fa-search" aria-hidden="true"></i>&nbsp;
                            </div>
                            <div class="zdflex">
                            <select name="estatus" class="form-control" id="estatus">
                                <option value="">Todos</option>
                                <option value="0">Pendientes</option>
                                <option value="1">Para Autorizar</option>
                                <!-- <option value="2">Finales</option>
                                <option value="3">Autorizacion En Proceso</option> -->
                                <option value="3">Para Facturar</option>
                                <option value="4">Facturados</option>
                            </select>
                            
                            </div>
                            
                        </div>
                        <div class="viewelements vanigrow vaniflex zdfd-column" id="viewelements">
                            <div class="elementosporpagina">
                            <button class="btn btn-success" disabled id="Facturarvarias">Facturar</button>
                                <select   class="rounded" id="epp">
                                <option value="10" >10</option>
                                    @for ($i = 15; $i <= $elementostotales/3; $i += 5)
                                        <option value="{{ $i }}" >{{ $i }}</option>
                                    @endfor
                                </select>
                                <div id='pagination'></div>
                            </div>
                            <div class="mitabla vanigrow vaniflex zdfd-column">
                                <table id="tablarecepciones" class="table table-sm  table-striped">
                                <colgroup>
                                <col class="button_options"> <!-- Columna con ancho fijo del 20% -->
                                    
                                </colgroup>
                                    <thead>
                                        <tr>
                                            <th>OPCIONES</th>
                                            <th>FOLIO</th>
                                            <th>ECONOMICO</th>
                                            <th>MARCA</th>
                                            <th>MODELOS</th>
                                            <th>AÑO</th>
                                            <th>PLACAS</th>
                                            <th>VIN</th>
                                            <th>FECHA</th>
                                            <th>ESTADO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div  class="no-results-message" hidden>
                        <span id="no-results-message"></span>
                        </div>
                    </div>
                    <div class="vaniwidth vaniflex zdfd-column" id="prefacturasdiv" hidden >
                        <div class="d-flex">
                            
                            <div class="iconoin zdmgr-r05">
                                <input class="misearch zdw-r25"
                                    type="text" id="searchprefacturas" name="s"
                                    placeholder="Busqueda Por Usuario, Cliente" >
                                    <i class="fa fa-search" aria-hidden="true"></i>&nbsp;
                            </div>
                            <div class=" selectconlabel zdmg-r02">
                       <label for="tipogasto">Fecha Inicio</label>
                       <input name="fechamovimientoinicio" id="fechamovimientoinicio" type="datetime-local" class="form-control">
                    </div><div class=" selectconlabel zdmg-r02">
                       <label for="tipogasto">Fecha Fin</label>
                       <input name="fechamovimientofin" id="fechamovimientofin" type="datetime-local" class="form-control">
                    </div>
                            
                        </div>
                        <div class="viewelements vanigrow vaniflex zdfd-column" id="viewprefacturas">
                            <div class="elementosporpagina">
                                <div id='pagination3'></div>
                            </div>
                            <div class="mitabla vanigrow vaniflex zdfd-column">
                                <table id="tablaprefacturas" class="table table-sm  table-striped">
                                <colgroup>
                                <col class="button_options"> <!-- Columna con ancho fijo del 20% -->
                                    
                                </colgroup>
                                    <thead>
                                        <tr>
                                            <th>OPCIONES</th>
                                            <th>Cliente</th>
                                            <th>Usuario</th>
                                            <th>Forma de Pago</th>
                                            <th>Moneda</th>
                                            <th>Tipo Comprobante</th>
                                            <th>Uso CFDI</th>
                                            <th>FECHA</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div  class="no-results-message" hidden>
                        <span id="no-results-message2"></span>
                        </div>
                    </div>
                    <div id='loadingdata' class="carga" hidden>
                        <h3 class="text-center m-2">Cargando Datos</h3>
                        <div class="spinnerp"></div>
                    </div>

                </div>
            </div>
    </div>
    @include('modales.Mensajemodal')
    @include('modales.presupuestosadmin')
    @include('modales.subidaarchivos')
    @include('modales.Facturarmodal')
    @include('modales.viewarchivopdf')
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{asset('js/paginacion.js')}}"></script>
<script src="{{asset('js/paginacion3.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.6.0/fabric.min.js"></script>
@stack('scripts')
<script>
    $(function(){ 

        console.log("oracio==gay , ",true)
     let elements = [];
     let originalelements = [];
     const modulo = @json($modulo);
        const anio = @json($anio);
        const contrato = @json($contrato);
    $('#Verprefacturas').on('click',function(){
        // Alternar el atributo 'hidden'
        if ($('#prefacturasdiv').attr('hidden')) {
            $('#prefacturasdiv').removeAttr('hidden');
            $('#dataupload').attr('hidden', 'hidden');
            executeviewprefacturas();
           

        } else {
            $('#prefacturasdiv').attr('hidden', 'hidden');
            $('#dataupload').removeAttr('hidden');
            executeSearchdata()
        }

    })
    function executeviewprefacturas(){
        document.getElementById('loadingdata').removeAttribute('hidden');
        document.getElementById('dataupload').setAttribute('hidden', true);
        document.getElementById('prefacturasdiv').setAttribute('hidden', true);
        $.ajax({
                type: 'GET',
                url: '{{ route('2025.cfe.obtener.prefacturas') }}',
                data:{
                    modulo:modulo,
                    anio:anio,
                    sucursal:contrato,
                },
                success: function(response) {
                    console.log(response)
                    originalelements = elements = response.prefacturas;
                    document.getElementById('loadingdata').setAttribute('hidden', true);
                    document.getElementById('dataupload').setAttribute('hidden', true);
                    document.getElementById('prefacturasdiv').removeAttribute('hidden');
                    filtering()
                },
                error: function(xhr, status, error) {
                    console.error(xhr);
                }
            });
    }
    $('#searchprefacturas').on('input', filtering);
    $('#fechamovimientoinicio').on('change', filtering);
    $('#fechamovimientofin').on('change', filtering); 
    function filtering() { 
            let search = $('#searchprefacturas').val().toLowerCase();
            let fecha1=$('#fechamovimientoinicio').val();
            let fecha2=$('#fechamovimientofin').val();
            Page = 1
                elements = originalelements.filter(function(element) {
                    return (search === '' || 
                    element.uso_cfdi.toLowerCase().includes(search) || 
                    element.tipo_comprobante.toLowerCase().includes(search) || 
                    element.moneda.toLowerCase().includes(search) ||
                    element.mpago.toLowerCase().includes(search) ||
                    element.cliente.nombre.toLowerCase().includes(search) ||
                    element.usuario.name.toLowerCase().includes(search)
                )&&(fecha2 === '' || new Date(element.created_at) <= new Date(fecha2))  &&
                (fecha1 === '' || new Date(element.created_at) >= new Date(fecha1));

                });
            if (elements.length === 0) {
                $('.no-results-message').removeAttr('hidden');
                $('#no-results-message2').text('No Se Encontraron Resultados');
                
            } else {
                $('.no-results-message').removeAttr('hidden');
                $('#no-results-message2').text('');
            }
            showElements();
            
    }
    function showElements() {
        ShowPagination3(elements.length,8);
        console.log(Page3);
        let startIndex = (Page3 - 1) * itemsPerPage;
        let endIndex = startIndex + itemsPerPage;
        let paginatedElements = elements.slice(startIndex, endIndex);
        $('#tablaprefacturas tbody').empty();
        if (paginatedElements.length > 0) {
            document.getElementById('viewprefacturas').removeAttribute('hidden');
        } else {
            document.getElementById('viewprefacturas').setAttribute('hidden', true);
        }
        $.each(paginatedElements, function(index, element) {
            let row = $('<tr class="zdrelative"><td><div class="Datatable-content" ></div></td></tr>');
            let dropdownContent = `
                <button type="button"class=" btn  btn-danger " onclick="deleteprefactura(`+element.id+`)"><i aria-hidden="true" class="fa-solid fa-trash"></i></button>
                <button type="button"class=" btn  btn-success" onclick="abrirprefactura(`+element.id+`)"><i aria-hidden="true"  class="fa fa-eye "></i></button>`

            row.find('.Datatable-content').append(dropdownContent);
            row.append('<td><div class="">' + (element.cliente ? element.cliente.nombre : "Sin Folio" ) + '</div></td>');
            row.append('<td><div class="">' + (element.usuario ? element.usuario.name : "Sin # Seguimiento")+ '</div></td>');
            row.append('<td><div class="">' + (element.mpago ? element.mpago : "marca") + '</div></td></tr>');
            row.append('<td><div class="">' + (element.moneda ? element.moneda : "Sin moneda") + '</div></td></tr>');
            row.append('<td><div class="">' + (element.tipo_comprobante ? element.tipo_comprobante : "No Se Registro") + '</div></td></tr>');
            row.append('<td><div class="">' + (element.uso_cfdi ? element.uso_cfdi : "Sin uso_cfdi") + '</div></td></tr>');
            row.append('<td><div class="">' + (element.created_at ? element.created_at : "No Se Registro") + '</div></td></tr>');
            $('#tablaprefacturas tbody').append(row);
        });
    }
    window.abrirfacturarmodal = function(id) {
        $('.rfcactive').removeClass('rfcactive');
        $("#original").addClass('rfcactive');
        $('#emisorrfc').val($('#original').attr('data-id'))
        $.ajax({
        type: 'GET',
        url: '{{ route('2025.cfe.obtener.conceptospresupuesto') }}',
        data:{
            id: id,
        },
        success: function(response) {
            listaconceptos=response.conceptos;
            console.log(listaconceptos);
            $('#tablaconceptosfactura thead').empty();
            $('#tablaconceptosfactura thead').append('<tr><th>Articulo</th><th>Precio</th><th>Cantidad</th><th>Total</th></tr>');
            $('#tablaconceptosfactura tbody').empty();
            $.each(listaconceptos, function(index, element) {
                let row = $('<tr>'); 
                row.append('<td><div class="Datatable-content">' + (element.concepto.descripcion ) + '</div></td>');
                row.append('<td><div class="Datatable-content">' + (element.precio_v ) + '</div></td>');
                row.append('<td><div class="Datatable-content">' + (element.cantidad ) + '</div></td>');
                row.append('<td><div class="Datatable-content">' + (element.cantidad * element.precio_v).toFixed(2) + '</div></td>');
                $('#tablaconceptosfactura tbody').append(row);
                
            });
            let subtotal = 0;
            listaconceptos.forEach(item => {
                subtotal += item.cantidad * item.precio_v;
        });
        let iva=subtotal*0.16;
        let total=subtotal+iva;
        $('#subtotalfactura').text("Subtotal: $").append(subtotal.toFixed(2));
        $('#ivafactura').text("Iva:      $").append(iva.toFixed(2));
        $('#totalfactura').text("Total:    $").append(total.toFixed(2));
        $('#timbrarfactura').attr('data-id', id);
        $('.unafactura').removeAttr('hidden');
        $('.prefacturas').attr('hidden',true);
        $('.variasfacturas').attr('hidden',true);
        $("#facturarmodal").modal('show');
        },
        error: function(xhr, status, error) {
            console.error(xhr);
        }
        });   
    }
    $('#Facturarvarias').click(function() {
        let valores = [];
        $('.presupuestoid:checked').each(function() {
            valores.push($(this).val());
        });
        $('.rfcactive').removeClass('rfcactive');
        $("#original").addClass('rfcactive');
        $('#emisorrfc').val($('#original').attr('data-id'))
        $.ajax({
            type: 'GET',
            url: '{{ route('2025.cfe.obtener.multiples.detalles') }}',
            data:{
                ids: valores,
            },
            success: function(response) {
                listaconceptos=response.detalles;
                console.log(listaconceptos);
                $('#tablaconceptosfactura thead').empty();
                $('#tablaconceptosfactura thead').append('<tr><th>Economico</th><th>Placas</th><th>No. Sol</th><th>KM</th><th>Servicio</th><th>Costo</th><th>Iva</th><th>Total</th></tr>');
                $('#tablaconceptosfactura tbody').empty();
                $.each(listaconceptos, function(index, element) {
                    let row = $('<tr>'); 
                    row.append('<td><div class="Datatable-content">' + (element.economico ?? '' ) + '</div></td>');
                    row.append('<td><div class="Datatable-content">' + (element.placas ?? '') + '</div></td>');
                    row.append('<td><div class="Datatable-content">' + (element.NSolicitud ?? '' ) + '</div></td>');
                    row.append('<td><div class="Datatable-content">' + (element.kilometraje ?? '') + '</div></td>');
                    row.append('<td><div class="Datatable-content">' + (element.descripcionMO ?? '') + '</div></td>');
                    row.append('<td><div class="Datatable-content">' + Number(element.importe ?? 0).toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '</div></td>');
                    row.append('<td><div class="Datatable-content">' + Number((element.importe ?? 0)*0.16 ).toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '</div></td>');
                    row.append('<td><div class="Datatable-content">' + Number((element.importe ?? 0)*1.16 ).toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '</div></td>');
                    $('#tablaconceptosfactura tbody').append(row);
                    
                });
                let subtotal = 0;
                listaconceptos.forEach(item => {
                    subtotal += item.importe;
            });
            let iva=subtotal*0.16;
            let total=subtotal+iva;
            $('#subtotalfactura').text("Subtotal: $").append( Number(subtotal).toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $('#ivafactura').text("Iva:      $").append( Number(subtotal*0.16 ).toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $('#totalfactura').text("Total:    $").append(Number(subtotal*1.16 ).toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $('#timbrarfacturas').attr('data-id', valores);
            $('#guardarfacturas').attr('data-id', valores);
            $('.variasfacturas').removeAttr('hidden');
            $('.unafactura').attr('hidden',true);
            $('.prefacturas').attr('hidden',true);
            $("#facturarmodal").modal('show');
            },
            error: function(xhr, status, error) {
                console.error(xhr);
            }
        }); 
    });
    window.deleteprefactura = (id) => { // Tu código aquí };
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Una vez eliminada, No lo podras revertir",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarla',
                cancelButtonText: 'No, Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{route('2025.facturacion.delete.prefactura')}}",
                        type: "DELETE",
                        data:{
                            "_token": "{{ csrf_token() }}",
                            id:id,
                        },
                        success: function(response) {
                            console.log(response);
                            const mensaje=response.success
                            Swal.fire({ html: `${mensaje}`, icon: 'success',showConfirmButton: false,timer: 2000,});
                            executeviewprefacturas()
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr);
                            if(xhr.status===499){
                                let errorMessage = 'Verifique Los Datos';
                                Swal.fire({ title: 'Error', html: `${errorMessage}<br>Detalles del error:<br>${xhr.responseJSON.error}`, icon: 'error'});
                                executeviewprefacturas();
                            }else{
                                let errorMessage = 'Intentelo de nuevo, si el error persiste contacte a Soporte.';
                                Swal.fire({ title: 'Error', html: `${errorMessage}<br>Detalles del error: ${error}<br>${status} : ${xhr.status}`, icon: 'error'});
                            }
                        }
                    });
                }
            });
        }
    window.abrirprefactura = function(id) {
        $('.rfcactive').removeClass('rfcactive');
        $("#original").addClass('rfcactive');
        $('#emisorrfc').val($('#original').attr('data-id'))
        $.ajax({
            type: 'GET',
            url: '{{ route('2025.cfe.obtener.multiples.detalles.prefactura') }}',
            data:{
                id: id,
            },
            success: function(response) {
                listaconceptos=response.detalles;
                prefactura=response.prefactura;
                empresa=response.empresa;
                console.log(listaconceptos);
                $('#tablaconceptosfactura thead').empty();
                $('#tablaconceptosfactura thead').append('<tr><th>Economico</th><th>Placas</th><th>No. Sol</th><th>KM</th><th>Servicio</th><th>Costo</th><th>Iva</th><th>Total</th></tr>');
                $('#tablaconceptosfactura tbody').empty();
                $.each(listaconceptos, function(index, element) {
                    let row = $('<tr>'); 
                    row.append('<td><div class="Datatable-content">' + (element.economico ?? '' ) + '</div></td>');
                    row.append('<td><div class="Datatable-content">' + (element.placas ?? '') + '</div></td>');
                    row.append('<td><div class="Datatable-content">' + (element.NSolicitud ?? '' ) + '</div></td>');
                    row.append('<td><div class="Datatable-content">' + (element.kilometraje ?? '') + '</div></td>');
                    row.append('<td><div class="Datatable-content">' + (element.descripcionMO ?? '') + '</div></td>');
                    row.append('<td><div class="Datatable-content">' + Number(element.importe ?? 0).toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '</div></td>');
                    row.append('<td><div class="Datatable-content">' + Number((element.importe ?? 0)*0.16 ).toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '</div></td>');
                    row.append('<td><div class="Datatable-content">' + Number((element.importe ?? 0)*1.16 ).toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '</div></td>');
                    $('#tablaconceptosfactura tbody').append(row);
                    
                });
                let subtotal = 0;
                listaconceptos.forEach(item => {
                    subtotal += item.importe;
            });
            let iva=subtotal*0.16;
            let total=subtotal+iva;
            const valueMap = {
                "1": "01",
                "2": "02",
                "3": "03",
                "4": "04",
                "5": "05",
                "6": "06",
                "7": "07",
                "8": "08",
                "9": "09",
            };
            $('#tipo_comprobante').val(prefactura.tipo_comprobante);
            $('#uso_cfdi').val(prefactura.uso_cfdi);
            $('#moneda').val(prefactura.moneda);
            $('#fpago').val(valueMap[prefactura.fpago]??prefactura.fpago);
            $('#mpago').val(prefactura.mpago);
            $('#subtotalfactura').text("Subtotal: $").append( Number(subtotal).toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $('#ivafactura').text("Iva:      $").append( Number(subtotal*0.16 ).toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $('#totalfactura').text("Total:    $").append(Number(subtotal*1.16 ).toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $('#timbrarprefacturas').attr('id', prefactura.id);
            $('.prefacturas').removeAttr('hidden');
            $('.variasfacturas').attr('hidden',true);
            $('.unafactura').attr('hidden',true);
            $("#empresasfactura").append('<option value="' + empresa.id + '">' + empresa.nombre+'</option>');
            $('#empresasfactura').val( empresa.id).trigger('change');
            $("#facturarmodal").modal('show');
            },
            error: function(xhr, status, error) {
                console.error(xhr);
            }
        }); 
    };
    })
    $(function() {
        let elements = [];
        let originalelements = [];
        const modulop = @json($modulo);
        const aniop = @json($anio);
        const contratop = @json($contrato);
        searchdata();
        window.limpiarmodaltalleres = function() {
            $("#formnewrecepcion").find(".error-message").remove();
            $('#recepcionservicio input').not('input[name="_token"]').val('');
            $('#recepcionservicio textarea').val('');
            $('#recepcionservicio select').val('').trigger('change');;  // O puedes usar $('#RecepcionVehicular select').prop('selectedIndex', -1);
            
        }
        function recepciondelete(id) {
            let ruta = "{{ route('2025.cfe.recepcion.delete') }}";
            Swal.fire({
                icon: "question",
                text: "¿Estás seguro de eliminar la recepción?",
                showCancelButton: true,
                confirmButtonText: "Confirmar",
                cancelButtonText: "Cancelar",
                reverseButtons: true,
                customClass: {
                    confirmButton: "btn-primary",
                    cancelButton: "btn-light",
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: ruta,
                        method: "POST",
                        data: { id: id, _token: "{{ csrf_token() }}" },
                        success: function (data) {
                            if (data === "eliminado") {
                                Swal.fire({
                                    icon: "success",
                                    title: "Recepción eliminada correctamente",
                                    showConfirmButton: false,
                                    timer: 2000,
                                });
                                searchdata();
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: "Oops...",
                                    html: data,
                                });
                            }
                        },
                        error: function (error) {
                            console.log(error)
                            if (error.status === 422) {
                                Swal.fire({
                                    icon: "warning",
                                    title:error.responseJSON.error,
                                });
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: "Oops...",
                                    text: "Ocurrió un error inesperado. Por favor, inténtalo nuevamente.",
                                });
                            }
                        },
                    });
                }
            });
        }      
        function searchdata() {
            $('#Verprefacturas').attr('disabled',true);
            document.getElementById('loadingdata').removeAttribute('hidden');
            document.getElementById('dataupload').setAttribute('hidden', true);
            $.ajax({
                type: 'GET',
                url: '{{ route('2025.cfe.obtener.talleres') }}',
                data:{
                    modulo:modulop,
                    anio:aniop,
                    contrato:contratop,
                },
                success: function(response) {
                    console.log(response)
                    originalelements = elements = response.recepciones;
                    document.getElementById('loadingdata').setAttribute('hidden', true);
                    document.getElementById('dataupload').removeAttribute('hidden');
                    filtering()
                },
                error: function(xhr, status, error) {
                    console.error(xhr);
                }
            });
        }
        window.executeSearchdata = function() {
            eval("searchdata()");
        };
        window.executedelete = function(id) {
            eval("recepciondelete("+id+")");
        };
        window.executeshowElements = function() {
            eval("showElements()");
        };
        window.executereporte = function(id) {
            eval("reporte("+id+")");
        };
        window.executeservicio = function(id) {
            $('#recepcionservicio').modal("show");
        };
        function reporte(id){
            window.open('/recepcion/reporte/'+ id,'_blank');
        };
        function showElements() {
            ShowPagination(elements.length,8);
            console.log(Page);
            let startIndex = (Page - 1) * itemsPerPage;
            let endIndex = startIndex + itemsPerPage;
            console.log(itemsPerPage)
            let paginatedElements = elements.slice(startIndex, endIndex);
            console.log(paginatedElements)
            $('#tablarecepciones tbody').empty();
            if (paginatedElements.length > 0) {
                document.getElementById('viewelements').removeAttribute('hidden');
            } else {
                document.getElementById('viewelements').setAttribute('hidden', true);
            }
            $.each(paginatedElements, function(index, element) {
                let row = $('<tr class="zdrelative"><td><div class="Datatable-content" ></div></td></tr>');
                let acciones =`<td><div class="Datatable-content ">`;
                let dropdownContent = ``;
                acciones+=`<div class="zdrelative zdinline"><button type="button" class="btn btn-warning btn-sm zdrelative" title="Mesajes" onclick="openmessagemodal(`+element.id+`)">
                            <i class="fa fa-comment-alt"></i>
                            </button>`+(element.mensajes ?`<p class="notificationcount">`+element.mensajes+`</p></div>` : `</div>`);
                if (element.status==0){
                        dropdownContent = `
                    <button type="button"class="opcionesdesplegables btn disabled btn-primary ">Opciones</button>`
                }else if(element.status==4){
                        dropdownContent = `
                        <div class="zdflex">
                    <input type="checkbox" class="zdw-r1 zdh-r1 zdmg-r04 presupuestoid" value=`+element.id+`>
                    <button type="button"class="opcionesdesplegables btn  btn-primary ">Opciones</button>
                        <ul class="detallesdesplegables zdw-r12 " hidden>
                        <li><a href="#" onclick="executedeletepresupuestos(`+element.id+`)" ">Eliminar</a></li>
                        <li><a href="#" onclick="executepresupuestoaprobar(`+element.id+`)">Editar</a></li>
                        <li><a href="#" class="reportevehicular" data-nrv="`+element.NSolicitud+`">Recepción Vehicular</a></li>
                        <li><a href="#" onclick="executesubirarchivo(`+element.id+`, 'Fotos Viejas')">Fotos Viejas</a></li>
                        <li><a href="#" class="presupuestopdf" data-id="`+element.id+`">Presupuesto Costo</a></li>
                        <li><a href="#" class="presupuestofinalpdf" data-id="`+element.id+`">Presupuesto Final</a></li>
                        <li><a href="#" class="presupuestoacusepdf" data-id="`+element.id+`">Presupuesto Acuse</a></li>
                        <li><a href="#" onclick="executesubirarchivo(`+element.id+`, 'Reporte Anomalías')">Reporte Anomalías</a></li>
                        <li><a href="#" onclick="executesubirarchivo(`+element.id+`, 'Entrada')">Entrada</a></li>
                        <li><a href="#" onclick="executesubirarchivo(`+element.id+`, 'Orden Servicio')">Orden Servicio</a></li> 
                        <li><a href="#" onclick="executesubirarchivo(`+element.id+`, 'Fotos Nuevas')">Fotos Nuevas</a></li>
                        <li><a href="#" onclick="executesubirarchivo(`+element.id+`, 'Fotos Instaladas')">Fotos Instaladas</a></li>
                        <li><a href="#" onclick="executesubirarchivo(`+element.id+`, 'Factura PDF')">Factura PDF</a></li>
                        <li><a href="#" onclick="executesubirarchivo(`+element.id+`, 'Factura XML')">Factura XML</a></li>
                        <li><a href="#" onclick="executesubirarchivo(`+element.id+`, 'Acuse')">Acuse</a></li>
                    </ul>
                    </div>`
                }else if(element.status==5){
                        dropdownContent = `
                        <div class="zdflex">
                        <button type="button"class="opcionesdesplegables btn  btn-primary ">Opciones</button>
                        <ul class="detallesdesplegables zdw-r12 " hidden>
                        <li><a href="#" class="reportevehicular" data-nrv="`+element.NSolicitud+`">Recepción Vehicular</a></li>
                        <li><a href="#" onclick="historialarchivos(`+element.id+`, 'Fotos Viejas')">Fotos Viejas</a></li>
                        <li><a href="#" class="presupuestopdf" data-id="`+element.id+`">Presupuesto Costo</a></li>
                        <li><a href="#" class="presupuestofinalpdf" data-id="`+element.id+`">Presupuesto Final</a></li>
                        <li><a href="#" class="presupuestoacusepdf" data-id="`+element.id+`">Presupuesto Acuse</a></li>
                        <li><a href="#" onclick="historialarchivos(`+element.id+`, 'Reporte Anomalías')">Reporte Anomalías</a></li>
                        <li><a href="#" onclick="historialarchivos(`+element.id+`, 'Entrada')">Entrada</a></li>
                        <li><a href="#" onclick="historialarchivos(`+element.id+`, 'Orden Servicio')">Orden Servicio</a></li> 
                        <li><a href="#" onclick="historialarchivos(`+element.id+`, 'Fotos Nuevas')">Fotos Nuevas</a></li>
                        <li><a href="#" onclick="historialarchivos(`+element.id+`, 'Fotos Instaladas')">Fotos Instaladas</a></li>
                        <li><a href="#" onclick="executesubirarchivo(`+element.id+`, 'Factura PDF')">Factura PDF</a></li>
                        <li><a href="#" onclick="executesubirarchivo(`+element.id+`, 'Factura XML')">Factura XML</a></li>
                        <li><a href="#" onclick="executesubirarchivo(`+element.id+`, 'Acuse')">Acuse</a></li>
                    </ul>
                    </div>`
                }else {
                        dropdownContent = `
                    <button type="button"class="opcionesdesplegables btn  btn-primary ">Opciones</button>
                    <ul class="detallesdesplegables zdw-r12" hidden>
                        <li><a href="#" onclick="executedeletepresupuestos(`+element.id+`)" ">Eliminar</a></li>
                        <li><a href="#" onclick="executepresupuestoaprobar(`+element.id+`)">Editar</a></li>
                        <li><a href="#" class="reportevehicular" data-nrv="`+element.NSolicitud+`">Recepción Vehicular</a></li>
                        <li><a href="#" onclick="executesubirarchivo(`+element.id+`, 'Fotos Viejas')">Fotos Viejas</a></li>
                        <li><a href="#" class="presupuestopdf" data-id="`+element.id+`">Presupuesto Costo</a></li>
                        <li><a href="#" class="presupuestofinalpdf" data-id="`+element.id+`">Presupuesto Final</a></li>
                        <li><a href="#" class="presupuestoacusepdf" data-id="`+element.id+`">Presupuesto Acuse</a></li>
                        <li><a href="#" onclick="executesubirarchivo(`+element.id+`, 'Reporte Anomalías')">Reporte Anomalías</a></li>
                        <li><a href="#" onclick="executesubirarchivo(`+element.id+`, 'Entrada')">Entrada</a></li>
                        <li><a href="#" onclick="executesubirarchivo(`+element.id+`, 'Orden Servicio')">Orden Servicio</a></li> 
                        <li><a href="#" onclick="executesubirarchivo(`+element.id+`, 'Fotos Nuevas')">Fotos Nuevas</a></li>
                        <li><a href="#" onclick="executesubirarchivo(`+element.id+`, 'Fotos Instaladas')">Fotos Instaladas</a></li>
                        <li><a href="#" onclick="executesubirarchivo(`+element.id+`, 'Factura PDF')">Factura PDF</a></li>
                        <li><a href="#" onclick="executesubirarchivo(`+element.id+`, 'Factura XML')">Factura XML</a></li>
                        <li><a href="#" onclick="executesubirarchivo(`+element.id+`, 'Acuse')">Acuse</a></li>
                    </ul>
                    `;
                
                }


                
                if (element.status == 0) {
                        acciones += `
                            <button type="button" class="btn btn-warning" onclick="executecambiostatus(`+element.id+`,1)"title="Boton de terminar">
                                Enviar
                            </button>
                    `;
                }
                if (element.status == 1) {
                        acciones += `
                    
                            <button type="button" class="btn btn-success" onclick="executecambiostatus(`+element.id+`,4)"title="Boton de terminar">
                                Autorizar
                            </button>
                            <button type="button" class="btn btn-danger" onclick="executecambiostatus(`+element.id+`,0)"title="Boton de terminar">
                                Denegar
                            </button>
                    `;
                }

                if (element.status == 2) {
                        acciones += `
                            <button type="button" class="btn btn-warning" onclick="executecambiostatus(`+element.id+`,3)"title="Boton de terminar">
                                Enviar a CFE
                            </button>
                    `;
                }
                if (element.status == 3) {
                        acciones += `
                            <button type="button" class="btn btn-success" onclick="executecambiostatus(`+element.id+`,4)"title="Boton de terminar">
                                CFE Autoriza
                            </button>
                            <button type="button" class="btn btn-danger" onclick="executecambiostatus(`+element.id+`,2)"title="Boton de terminar">
                                CFE Deniega
                            </button>
                    `;
                }
                if (element.status == 4) {
                    let userId = {{ auth()->id() }}
                    acciones += `
                            <button type="button" class="btn btn-success" onclick="abrirfacturarmodal(`+element.id+`)"title="Boton de Facturar">
                            Facturar
                            </button>

                    `;
                    if(userId == 1){
                        acciones += `
                            <button type="button" class="btn btn-primary" onclick="executecambiostatus(`+element.id+`,1)"title="Boton de Reversa Estatus">
                                R
                            </button>
                    `;
                }
                }
                if (element.status == 5) {
                    let userId = {{ auth()->id() }}
                        acciones += `
                            <button type="button" class="btn btn-success">
                            Facturado
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" title="Factura PDF" onclick="executefacturaPDF(`+element.factura_id+`)">
                            <i class="fa fa-file-invoice"></i>
                            </button> 
                            <button type="button" class="btn btn-warning btn-sm" title="Factura PDF" onclick="executefacturaXML(`+element.factura_id+`)">
                            <i class="fa fa-file-invoice"></i>
                            </button>
                    `;
                    if(userId == 1){
                        acciones += `
                            <button type="button" class="btn btn-primary" onclick="executecambiostatus(`+element.id+`,1)"title="Boton de Reversa Estatus">
                                R
                            </button>
                    `;}
                }

                acciones += `</div></td></tr>`;
                row.find('.Datatable-content').append(dropdownContent);
                row.append('<td><div class="">' + (element.NSolicitud ? element.NSolicitud : "Sin Folio" ) + '</div></td>');
                row.append('<td><div class="">' + (element.identificador ? element.identificador : "Sin # Seguimiento")+ '</div></td>');
                row.append('<td><div class="">' + (element.marca ? element.marca : "marca") + '</div></td></tr>');
                row.append('<td><div class="">' + (element.modelo ? element.modelo : "Sin Modelo") + '</div></td></tr>');
                row.append('<td><div class="">' + (element.ano ? element.ano : "No Se Registro") + '</div></td></tr>');
                row.append('<td><div class="">' + (element.placas ? element.placas : "Sin Placas") + '</div></td></tr>');
                row.append('<td><div class="">' + (element.vin ? element.vin : "No Se Registro") + '</div></td></tr>');
                row.append('<td><div class="">' + (element.created_at ? element.created_at : "No Se Registro") + '</div></td></tr>');
                row.append(acciones);
                ;
                $('#Verprefacturas').removeAttr('disabled');
                $('#tablarecepciones tbody').append(row);
            });recepciondelete
        }
        $('#search').on('input', filtering);
        $('#estatus').on('change', filtering);
        function filtering() { 
            let search = $('#search').val().toLowerCase();
            let estatus = $('#estatus').val();
            Page = 1
                elements = originalelements.filter(function(element) {

                    return ((search === '' || 
                    element.NSolicitud.toLowerCase().includes(search) || 
                    element.placas.toLowerCase().includes(search) || 
                    element.identificador.toLowerCase().includes(search) ||
                    element.vin.toLowerCase().includes(search) ||
                    element.marca.toLowerCase().includes(search) ||
                    element.modelo.toLowerCase().includes(search))&&(estatus===''||element.status==estatus))
                

                });
            if (elements.length === 0) {
                document.querySelector('.no-results-message').removeAttribute('hidden');
                $('#no-results-message').text('No Se Encontraron Resultados Con Folio, Economico, Placas, Vin, Modelos o Marca Que Coincidan Con  '+search );
                
            } else {
                document.querySelector('.no-results-message').setAttribute('hidden',true);
                $('#no-results-message').text('');
            }
            showElements();
            
        }
        window.executefacturaPDF = (id)=>{
            $.ajax({
                url: "{{route('Facturacion.obtener.factura.pdf')}}",
                type: "get",
                data:{
                    id:id,
                },
                success: function(response) {
                    var respuesta = '/facturas/'+response.success;
                    console.log(respuesta)
                    $('#pdf_factura').attr('src',respuesta);
                    $('#viewarchivomodal').modal('show');
                },
                error: function(xhr, status, errors) {
                    console.log(xhr)
                        let errorMessage = 'Intentelo de nuevo, si el error persiste contacte a Soporte.';
                        Swal.fire({ title: 'Error', html: `${errorMessage}<br>Detalles del error:<br> ${xhr.responseJSON.errors}`, icon: 'error'});
                   
                }
            })
        }
        window.executefacturaXML = (id)=>{
            $.ajax({
                url: "{{route('Facturacion.obtener.factura.xml')}}",
                type: "get",
                data:{
                    id:id,
                },
                success: function(response) {
                    var respuesta = '/facturas/'+response.success;
                    console.log(respuesta)
                    window.open('/download/'+ response.success,'_blank');
                },
                error: function(xhr, status, errors) {
                    console.log(xhr)
                        let errorMessage = 'Intentelo de nuevo, si el error persiste contacte a Soporte.';
                        Swal.fire({ title: 'Error', html: `${errorMessage}<br>Detalles del error:<br> ${xhr.responseJSON.errors}`, icon: 'error'});
                   
                }
            })
        }

        
        $(document).on('click', '.opcionesdesplegables', function(event) {
            event.stopPropagation(); 
            $(".detallesdesplegables").attr('hidden',true)
            $(this).next().removeAttr('hidden');
        });
        $(document).on('click', function() {
            $(".detallesdesplegables").attr('hidden',true)
        });
        $(document).on('click', '.reportevehicular', function(){
            const Nsolicitud=$(this).attr("data-nrv");
            console.log(Nsolicitud);
            $.ajax({
                url: "{{route('2025.cfe.obtener.idrecepcion')}}",
                type: "get",
                data:{
                    folionum:Nsolicitud,
                },
                success: function(response) {
                    var respuesta = response.id;
                    window.open('/recepcion/reporte/storage/'+ respuesta,'_blank');
                },
                error: function(xhr, status, error) {
                    if(xhr.status===499){
                        let errorMessage = 'Verifique Los Datos';
                        Swal.fire({ title: 'Error', html: `${errorMessage}<br>Detalles del error:<br>${xhr.responseJSON.error}`, icon: 'error'});
                    }else{
                        let errorMessage = 'Intentelo de nuevo, si el error persiste contacte a Soporte.';
                        Swal.fire({ title: 'Error', html: `${errorMessage}<br>Detalles del error: ${error}<br>${status} : ${xhr.status}`, icon: 'error'});
                    }
                }
            })
        });
        $(document).on('click', '.presupuestopdf', function(){
            const id=$(this).attr("data-id");
            window.open('/ordenes/pdf/'+ id,'_blank');
        });
        $(document).on('click', '.presupuestofinalpdf', function(){
            const id=$(this).attr("data-id");
            window.open('/ordenes/pdfCFE/'+ id,'_blank');
        });
        window.executedeletepresupuestos = (id) => { // Tu código aquí };
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Una vez eliminado, No lo podras revertir",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarlo',
                cancelButtonText: 'No, Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{route('2025.cfe.delete.presupuesto')}}",
                        type: "DELETE",
                        data:{
                            "_token": "{{ csrf_token() }}",
                            id:id,
                        },
                        success: function(response) {
                            console.log(response);
                            const mensaje=response.success
                            Swal.fire({ html: `${mensaje}`, icon: 'success',showConfirmButton: false,timer: 2000,});
                            executeSearchdata()
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr);
                            if(xhr.status===499){
                                let errorMessage = 'Verifique Los Datos';
                                Swal.fire({ title: 'Error', html: `${errorMessage}<br>Detalles del error:<br>${xhr.responseJSON.error}`, icon: 'error'});
                                executeSearchdata();
                            }else{
                                let errorMessage = 'Intentelo de nuevo, si el error persiste contacte a Soporte.';
                                Swal.fire({ title: 'Error', html: `${errorMessage}<br>Detalles del error: ${error}<br>${status} : ${xhr.status}`, icon: 'error'});
                            }
                        }
                    });
                }
            });
        }
        $(document).on('click', '.presupuestoacusepdf', function(){
            const id=$(this).attr("data-id");
            window.open('/ordenes/pdfAcuse/'+ id,'_blank');
        });
        window.executecambiostatus = (id,status)=>{
            Swal.fire({
                title: '¿Estás seguro?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{route('2025.cfe.cambiar.estatus.presupuesto')}}",
                        type: "post",
                        data:{
                            "_token": "{{ csrf_token() }}",
                            id:id,
                            estatus:status,
                        },
                        success: function(response) {
                            executeSearchdata()
                        },
                        error: function(xhr, status, error) {
                            if(xhr.status===499){
                                Swal.fire({ title: 'Error', html: `Detalles del error:<br>${xhr.responseJSON.error}`, icon: 'error'});
                                executeSearchdata();
                            }else{
                                let errorMessage = 'Intentelo de nuevo, si el error persiste contacte a Soporte.';
                                Swal.fire({ title: 'Error', html: `${errorMessage}<br>Detalles del error: ${error}<br>${status} : ${xhr.status}`, icon: 'error'});
                            }
                        }
                    });
                } else {
                    
                }
            });
        }
        window.openmessagemodal=(id)=>{
            $('#presupuesto_id').val(id);
            $.ajax({
                        url: "{{route('2025.presupuesto.get.messages')}}",
                        type: "get",
                        data:{
                            presupuesto:$('#presupuesto_id').val(),
                        },
                        success: function(response) {
                            $('#tablemessage').empty();
                            $.each(response.success, function(index, element) {
                                let row = $('<div class="zdflex zdmg-r05 zditemscenter">');
                                row.append(`<button type="button"class="btn  btn-danger btn-sm" onclick="deletemessage(`+element.id+`)"><i aria-hidden="true" class="fa-solid fa-trash"></i></button>`);
                                row.append('<div class="zdmgl-r05"><label class="zdbold zdblock">' + (element.mensaje ? element.mensaje : 'Nulo') + '</label>'+
                                '<label>' + (element.created_at ? element.created_at : 'Nulo') + ' &nbsp&nbsp&nbsp</label>'+
                                '<label>' + (element.usuarios ? element.usuarios.name : 'Nulo') + '</label></div>')
                                $('#tablemessage').append(row);
                            });
                            $('#messagemodal').modal('show');
                        },
                        error: function(xhr, status, error) {
                            let errorMessage = 'Intentelo de nuevo, si el error persiste contacte a Soporte.';
                            console.log(xhr)
                            Swal.fire({
                                title: 'Error',
                                html: `${errorMessage} ${xhr.responseJSON ? `<br>Detalles del error:<br>${xhr.responseJSON.error}`:``}`,
                                icon: 'error'
                                });

                        }
                    });
           
        }
        window.executesubirarchivo=(id,origen)=>{
            console.log(origen)
            $('#img_preview').attr('src',"");
            $('#img_preview').attr('hidden',true);
            $('#pdf_preview').attr('src',"");
            $('#pdf_preview').attr('hidden',true);
            $('#video_src_preview').attr('src',"");
            $('#video_preview')[0].load();
            $('#video_preview').attr('hidden',true);
            $('#text_preview').attr('hidden',true);
            $('#subida_archivos').attr('data-origen',origen);
            $('#subida_archivos').attr('data-id',id);
            $('#Historial_archivos').attr('data-id',id);
            $('#Historial_archivos').attr('data-origen',origen);
            $('#archivotitle').text('Agregar '+ origen);
            $('#subidaarchivos').modal('show');
        }
       
        $('#Historial_archivos').on('click',function(){
            let origen=$(this).attr('data-origen')
            let id=$(this).attr('data-id')
            $.ajax({
                url: "{{route('2025.cfe.obtener.archivo')}}",
                type: "get",
                data:{
                    id:id,
                    origen:origen
                },
                success: function(response) {
                    var respuesta = response.src;
                    if(origen=="Fotos Viejas"){
                        ruta = '/storage/documentos/fotosviejas/';
                    }else if (origen=="Reporte Anomalías") {
                        ruta = '/storage/documentos/reporteanomalias/';
                    }else if (origen=="Entrada") {
                        ruta = '/storage/documentos/entradas/';
                    }else if (origen=="Orden Servicio") {
                        ruta = '/storage/documentos/ordenservicio/';
                    }else if (origen=="Fotos Nuevas") {
                        ruta = '/storage/documentos/fotosnuevas/';
                    }else if (origen=="Fotos Instaladas") {
                        ruta = '/storage/documentos/fotosinstaladas/';
                    }else if (origen=="Factura PDF") {
                        ruta = '/storage/documentos/facturaspdf/';
                    }else if (origen=="Factura XML") {
                        ruta = '/storage/documentos/facturasxml/';
                    }else if (origen=="Acuse") {
                        ruta = '/storage/documentos/acuse/';
                    } else{
                        $conmodelo=false;
                    }
                    if(response)
                    window.open(ruta + respuesta,'_blank');
                },
                error: function(xhr, status, error) {
                    if(xhr.status===499){
                        Swal.fire({ title: 'Error', html: `Detalles del error:<br>${xhr.responseJSON.error}`, icon: 'error'});
                    }else{
                        let errorMessage = 'Intentelo de nuevo, si el error persiste contacte a Soporte.';
                        Swal.fire({ title: 'Error', html: `Detalles del error: ${error}<br>${status} : ${xhr.status}`, icon: 'error'});
                    }
                }
            })
        })
        window.historialarchivos=(id,origen)=>{
            $.ajax({
                url: "{{route('2025.cfe.obtener.archivo')}}",
                type: "get",
                data:{
                    id:id,
                    origen:origen
                },
                success: function(response) {
                    var respuesta = response.src;
                    if(origen=="Fotos Viejas"){
                        ruta = '/storage/documentos/fotosviejas/';
                    }else if (origen=="Reporte Anomalías") {
                        ruta = '/storage/documentos/reporteanomalias/';
                    }else if (origen=="Entrada") {
                        ruta = '/storage/documentos/entradas/';
                    }else if (origen=="Orden Servicio") {
                        ruta = '/storage/documentos/ordenservicio/';
                    }else if (origen=="Fotos Nuevas") {
                        ruta = '/storage/documentos/fotosnuevas/';
                    }else if (origen=="Fotos Instaladas") {
                        ruta = '/storage/documentos/fotosinstaladas/';
                    }else if (origen=="Factura PDF") {
                        ruta = '/storage/documentos/facturaspdf/';
                    }else if (origen=="Factura XML") {
                        ruta = '/storage/documentos/facturasxml/';
                    }else if (origen=="Acuse") {
                        ruta = '/storage/documentos/acuse/';
                    } else{
                        $conmodelo=false;
                    }
                    if(response)
                    window.open(ruta + respuesta,'_blank');
                },
                error: function(xhr, status, error) {
                    if(xhr.status===499){
                        Swal.fire({ title: 'Error', html: `Detalles del error:<br>${xhr.responseJSON.error}`, icon: 'error'});
                    }else{
                        let errorMessage = 'Intentelo de nuevo, si el error persiste contacte a Soporte.';
                        Swal.fire({ title: 'Error', html: `Detalles del error: ${error}<br>${status} : ${xhr.status}`, icon: 'error'});
                    }
                }
            })
        }

        $(document).on('click','.presupuestoid',function() {
            let valores = $('.presupuestoid:checked').length > 0;
            console.log(valores);
            if (valores) {
                $('#Facturarvarias').removeAttr('disabled');
            } else {
                $('#Facturarvarias').attr('disabled', true);
            }
        });

        

       
    });
</script>
@endsection