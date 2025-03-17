@extends ('layouts.admin2')
    @section('contenido')
        <main class="main vaniflex vanigrow">
            <div class="container-fluid vaniflex vanigrow">
                <div class="card vanigrow">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Recepcion Vehicular
                        <button type="button" class="boton1" data-bs-toggle="modal" onclick="limpiarmodalrecepciones()"
                            data-bs-target="#RecepcionVehicular">
                            <i class="fa-solid fa-circle-plus"></i>&nbsp;Nueva
                        </button>
                        <div id="submenudemo">
                       
                        </div>
                    </div>
                    <div class="card-body mycard ">
                        <div class="vaniwidth" id="dataupload">
                            <div class="d-flex">
                                <div class="iconoin zdmgr-r05">
                                    <input class="misearch zdw-r29" type="text" id="search" name="s"
                                        placeholder="Busqueda Por #Orden,, Folio, Marca, Modelo, etc">
                                    <i class="fa fa-search" aria-hidden="true"></i>&nbsp;
                                </div>

                                <div class="vaniflex zditemscenter">
                                    <label class="zdmgr-r02">Empresas:</label>
                                    <select class="empresas-Select2" id="empresas">
                                        <option value="">Todas</option>
                                    </select>
                                </div>
                            </div>
                            <div class="viewelements" id="viewelements">
                                <div class="elementosporpagina">
                                    <select class="rounded" id="epp">
                                        <option value="10">10</option>
                                        @for ($i = 15; $i <= $elementostotales / 3; $i += 5)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                    <div id='pagination'></div>
                                </div>
                                <div class="mitabla">
                                    <table id="tablarecepciones" class="table table-sm  table-striped">
                                        <colgroup>
                                            <col class="button_options"> <!-- Columna con ancho fijo del 20% -->

                                        </colgroup>
                                        <thead>
                                            <tr>
                                                <th># Orden</th>
                                                <th>Ord. Seguimiento</th>
                                                <th>Folio</th>
                                                <th>Empresa</th>
                                                <th>Vehiculo</th>
                                                <th>F. Recepcion</th>
                                                <th>F. Compromiso</th>
                                                <th>Accciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="no-results-message" hidden>
                                <span id="no-results-message"></span>
                            </div>
                        </div>
                        <div id='loadingdata' class="carga" hidden>
                            <h3 class="text-center m-2">Cargando Datos</h3>
                            <div class="spinnerp"></div>
                        </div>
                    </div>
                </div>
            </div>
            @include('modales.RecepcionVehicularModal')
            @include('modales.nuevousuariotaller')
            


        </main>
    @endsection
    @section('scripts')
        <script src="{{ asset('js/paginacion.js') }}"></script>
        <script src="{{ asset('js/canvas.js') }}"></script>
        <script src="{{ asset('js/resepcionmodal.js') }}"></script>
        <script>
            $(function() {
                let elements = [];
                let originalelements = [];
                const modulo = @json($modulo);
                const anio = @json($anio);
                const contrato = @json($contrato);
                const zona = @json($zona);
                window.executeSearchdata = function() {
                    document.getElementById('loadingdata').removeAttribute('hidden');
                    document.getElementById('dataupload').setAttribute('hidden', true);
                    $.ajax({
                        type: 'GET',
                        url: '{{ route('2025.Recepcion.Vehicular.Get.Elements') }}',
                        data: {
                            modulo: modulo,
                            anio: anio,
                            zona: zona,
                            contrato: contrato
                        },
                        success: function(response) {
                            originalelements = elements = response.elements;
                            document.getElementById('loadingdata').setAttribute('hidden', true);
                            document.getElementById('dataupload').removeAttribute('hidden');
                            filtering();
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr);
                        }
                    });
                }
                window.executedelete = function(id) {
                    let ruta = "{{ route('2025.Recepcion.Vehicular.delete') }}";
                    Swal.fire({
                        icon: "question",
                        text: "¿Estás Seguro de Eliminar La Recepción Vehicular?",
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
                                method: "DELETE",
                                data: {
                                    id: id,
                                    _token: "{{ csrf_token() }}"
                                },
                                success: function(response) {
                                    let message=response.success;
                                    Swal.fire('Éxito', `${message}`, 'success');
                                    executeSearchdata();
                                    },
                                error: function(xhr, status, error) {
                                if(xhr.status===422){
                                    Swal.fire({ title: 'Error', html: `Detalles del error:<br>${xhr.responseJSON.error}`, icon: 'error'});
                                }else{
                                    let errorMessage = 'Intentelo de nuevo, si el error persiste contacte a Soporte.';
                                    Swal.fire({ title: 'Error', html: `${errorMessage}<br>Detalles del error: ${error}<br>${status} : ${xhr.status}`, icon: 'error'});
                                }
                                }
                            });
                        }
                    });
                };
                
                window.executeservicio = function(id) {
                    $('#recepcionservicio').modal("show");
                };
                window.executereporte = function(id) {
                    window.open('/recepcion/reporte/storage/' + id, '_blank');
                };
                window.executeshowElements = function () {
                    ShowPagination(elements.length, 8);
                    let startIndex = (Page - 1) * itemsPerPage;
                    let endIndex = startIndex + itemsPerPage;
                    let paginatedElements = elements.slice(startIndex, endIndex);
                    $('#tablarecepciones tbody').empty();
                    if (paginatedElements.length > 0) {
                        document.getElementById('viewelements').removeAttribute('hidden');
                    } else {
                        document.getElementById('viewelements').setAttribute('hidden', true);
                    }
                    $.each(paginatedElements, function(index, element) {
                        let row = $('<tr>');
                        row.append('<td><div class="Datatable-content">' + (element.detalles_generales.Folio ? element.detalles_generales.Folio: "Sin #ORDEN") + '</div></td>');
                        row.append('<td><div class="Datatable-content">' + (element.detalles_generales.OrdenSeguimiento ? element.detalles_generales.OrdenSeguimiento : "Sin # Seguimiento") + '</div></td>');
                        row.append('<td><div class="Datatable-content">' + (element.detalles_generales.Folio ? element.detalles_generales.Folio :
                            "folio") + '</div></td></tr>');
                        row.append('<td><div class="Datatable-content">' + (element.detalles_generales.empresa ? element.detalles_generales.empresa.nombre : "Sin Empresa") + '</div></td></tr>');
                        row.append('<td><div class="Datatable-content">' +
                            (element.detalles_generales.vehiculo ? ((element.detalles_generales.vehiculo.marca ? element.detalles_generales.vehiculo.marca.nombre :
                                    "Sin Marca") + '--' + (element.detalles_generales.vehiculo.modelo ? element.detalles_generales.vehiculo
                                    .modelo.nombre : "Sin Marca") + '--' + (element.detalles_generales.vehiculo.placas ?
                                    element.detalles_generales.vehiculo.placas : "Sin Placas")) :
                                "El vehicuylo no tiene datos") +
                            '</div></td></tr>');
                        row.append('<td><div class="Datatable-content">' + (element.detalles_generales.Fecha_entrada ? element.detalles_generales.Fecha_entrada :
                            "No Se Registro") + '</div></td></tr>');
                        row.append('<td><div class="Datatable-content">' + (element.detalles_generales.Fecha_Esperada ? element.detalles_generales
                            .Fecha_Esperada : "No Se Registro") + '</div></td></tr>');
                        let userId = {{ auth()->id() }}
                        if(userId != 1 && userId != 170){
                            row.append('<td><div class="Datatable-content">' +
                            '<button class="btn btn-success reporte" onclick="executereporte(' + (element.detalles_generales
                                .id ? element.detalles_generales.id : 1) +
                            ')" ><i aria-hidden="true"  class="fa fa-eye "></i></button>' +
                            '<button class="btn btn-warning" onclick="executeeditarrecepcion(' + (element
                                .id ? element.id : 1) +
                            ')"><i aria-hidden="true" class="fa fa-pencil-square-o"></i></button>' +
                            '<button class="btn btn-danger" onclick="executedelete(' + (element.detalles_generales.id ? element.detalles_generales
                                .id : 1) +
                            ')"><i aria-hidden="true" class="fa-solid fa-trash"></i></button>' +
                            '<button class="btn btn-info" onclick="executeagregarservicio(\'' + (element.detalles_generales
                                .folioNum ? element.detalles_generales.folioNum : 1) + '\',' + (element.detalles_generales.empresa ? element.detalles_generales
                                .empresa.id : 1) + 
                            ')"><i aria-hidden="true" class="fa-solid fa-file"></i></button>' +
                            '</div></td></tr>');
                        }else{
                            row.append('<td><div class="Datatable-content">' +
                            '<button class="btn btn-success reporte" onclick="executereporte(' + element.id +
                            ')" ><i aria-hidden="true"  class="fa fa-eye "></i></button>' +
                            '<button class="btn btn-warning" onclick="executeeditarrecepcion(' + element .id+ ')"><i aria-hidden="true" class="fa fa-pencil-square-o"></i></button>' +
                            '<button class="btn btn-danger" onclick="executedelete(' + element.id +')"><i aria-hidden="true" class="fa-solid fa-trash"></i></button>' +
                            '<button class="btn btn-info" onclick="executeagregarservicio(\'' + element.id + '\')"><i aria-hidden="true" class="fa-solid fa-file"></i></button>' +
                            '<button class="btn '+ (element.Update_fotos==0 ? 'btn-danger' : 'btn-success')+'" onclick="executecambiarimagenes(\'' + (element.id) + '\',\'' + (element.Update_fotos) + '\')">R</button>' +
                            
                            '</div></td></tr>');
                        }

                        $('#tablarecepciones tbody').append(row);
                    });
                }
                function filtering() {
                    let search = $('#search').val().toLowerCase();
                    const empresas = document.getElementById("empresas");
                    let option1 = empresas.value;
                    let nombreempresa = empresas.options[empresas.selectedIndex].text;
                    Page = 1
                    elements = originalelements.filter(function(element) {
                        return (option1 === '' || element.empresa_id == option1) && (search === '' ||
                        element.folioNum.toLowerCase().includes(search) ||
                        element.orden_seguimiento.toLowerCase().includes(search) ||
                        element.folio.toLowerCase().includes(search) ||
                        element.vehiculo.marca.nombre.toLowerCase().includes(search) ||
                        element.vehiculo.modelo.nombre.toLowerCase().includes(search) ||
                        element.vehiculo.placas.toLowerCase().includes(search));

                    });
                    if (elements.length === 0) {
                        document.querySelector('.no-results-message').removeAttribute('hidden');
                        if (search !== '' && option1 === '') {
                            $('#no-results-message').text(
                                'No Se Encontraron Recepcion Vehiculares Con #Orden, Ord. Seguimmiento, Folio, Marca, Modelo o Placas que Coincidan Con ' +
                                search);
                            } else if (search === '' && option1 !== '') {
                            $('#no-results-message').text('No Se Encontraron Recepcion Vehiculares de la Empresa ' +
                                nombreempresa);
                            } else {
                                $('#no-results-message').text('No Existen  Recepciones Vehiculares');
                        }
                    } else {
                        document.querySelector('.no-results-message').setAttribute('hidden', true);
                        $('#no-results-message').text('');
                    }
                    executeshowElements();
                    
                }
                $('#search').on('input', filtering);
                $("#empresas").change(filtering);
                executeSearchdata();
            });

            window.executecambiarimagenes = function(id,actualizar) {
                let ruta = "{{ route('2025.Recepcion.Vehicular.fotosupdate') }}";
                if(actualizar == 0){
                    text="¿Estás Seguro de Aceptar Cambios En las Imagenes De Evidencia?"
                }else{
                    text="¿Estás Seguro de Ya No Aceptar Cambios En las Imagenes De Evidencia?"
                }
                    Swal.fire({
                        icon: "question",
                        text: text,
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
                                method: "PUT",
                                data: {
                                    id: id,
                                    _token: "{{ csrf_token() }}"
                                },
                                success: function(response) {
                                    let message=response.success;
                                    Swal.fire('Éxito', `${message}`, 'success');
                                    executeSearchdata();
                                    },
                                error: function(xhr, status, error) {
                                if(xhr.status===422){
                                    Swal.fire({ title: 'Error', html: `Detalles del error:<br>${xhr.responseJSON.error}`, icon: 'error'});
                                }else{
                                    let errorMessage = 'Intentelo de nuevo, si el error persiste contacte a Soporte.';
                                    Swal.fire({ title: 'Error', html: `${errorMessage}<br>Detalles del error: ${error}<br>${status} : ${xhr.status}`, icon: 'error'});
                                }
                                }
                            });
                        }
                    });
                };
        </script>
        @stack('scripts')
    @endsection
