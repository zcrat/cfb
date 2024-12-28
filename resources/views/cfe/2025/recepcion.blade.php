@extends ('layouts.admin2')
@section ('contenido')

<main class="main vaniflex vanigrow">
    <div class="container-fluid vaniflex vanigrow">
            <div class="card vanigrow">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Recepcion Vehicular
                    <button type="button"  class="boton1" data-bs-toggle="modal" data-bs-target="#RecepcionVehicular">
                        <i class="fa-solid fa-circle-plus"></i>&nbsp;Nueva
                    </button>
                </div>
                <div class="card-body mycard ">
                    <div class="vaniwidth" id="dataupload" >
                        <div class="d-flex">
                            <div class="iconoin zdmgr-r05">
                                <input class="misearch zdw-r29"
                                    type="text" id="search" name="s"
                                    placeholder="Busqueda Por #Orden,, Folio, Marca, Modelo, etc" min="1">
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
                                <select   class="rounded" id="epp">
                                    @for ($i = 10; $i <= $elementostotales/3; $i += 5)
                                        <option value="{{ $i }}" >{{ $i }}</option>
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
                        <div  class="no-results-message" hidden>
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
    @include('modales.empresas')
    @include('modales.clientes')
    @include('modales.vehiculo')
    @include('modales.marca')
    @include('modales.modelo')
    @include('modales.color')
    @include('modales.recepcionvehicular')


  
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{asset('js/paginacion.js')}}"></script>
<script src="{{asset('js/canvas.js')}}"></script>
<script src="{{asset('js/resepcionmodal.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.6.0/fabric.min.js"></script>
@stack('scripts')
<script>
     $(document).ready(function() {
                let elements = [];
                let originalelements = [];
                const modulo = @json($modulo);
                const anio = @json($anio);
                searchdata();
                function searchdata() {
                    document.getElementById('loadingdata').removeAttribute('hidden');
                    document.getElementById('dataupload').setAttribute('hidden', true);
                    $.ajax({
                        type: 'GET',
                        url: '{{ route('2025.cfe.obtener.Recepcionvehicular') }}',
                        data:{
                            modulo:modulo,
                            anio:anio
                        },
                        success: function(response) {
                            console.log(response)
                            originalelements = elements = response.recepciones;
                            document.getElementById('loadingdata').setAttribute('hidden', true);
                            document.getElementById('dataupload').removeAttribute('hidden');
                            filtering();
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr);
                        }
                    });
                }
                window.executeSearchdata = function() {
                    eval("searchdata()");
                };
                window.executeshowElements = function() {
                    eval("showElements()");
                };
                function showElements() {
                    ShowPagination(elements.length,8);
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
                        row.append('<td><div class="Datatable-content">' + (element.folioNum ? element.folioNum : "Sin #ORDEN" ) + '</div></td>');
                        row.append('<td><div class="Datatable-content">' + (element.orden_seguimiento ? element.orden_seguimiento : "Sin # Seguimiento")+ '</div></td>');
                        row.append('<td><div class="Datatable-content">' + (element.folio ? element.folio : "folio") + '</div></td></tr>');
                        row.append('<td><div class="Datatable-content">' + (element.empresa ? element.empresa.nombre : "Sin Empresa") + '</div></td></tr>');
                        row.append('<td><div class="Datatable-content">' +
                        (element.vehiculo ? ((element.vehiculo.marca ? element.vehiculo.marca.nombre : "Sin Marca") +'--'+(element.vehiculo.modelo ? element.vehiculo.modelo.nombre : "Sin Marca")+'--'+(element.vehiculo.placas ? element.vehiculo.placas : "Sin Placas") ) : "El vehicuylo no tiene datos") +
                        '</div></td></tr>');
                        row.append('<td><div class="Datatable-content">' + (element.fecha ? element.fecha : "No Se Registro") + '</div></td></tr>');
                        row.append('<td><div class="Datatable-content">' + (element.fecha_compromiso ? element.fecha_compromiso : "No Se Registro") + '</div></td></tr>');
                        row.append('<td><div class="Datatable-content"> Opciones</div></td></tr>');
                        $('#tablarecepciones tbody').append(row);
                    });
                }
                $('#search').on('input', filtering);
                $("#empresas").change(filtering);
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
                            element.vehiculo.placas.toLowerCase().includes(search) );

                        });
                    if (elements.length === 0) {
                        document.querySelector('.no-results-message').removeAttribute('hidden');
                        if(search !== '' && option1 === ''){
                            $('#no-results-message').text('No Se Encontraron Recepcion Vehiculares Con #Orden, Ord. Seguimmiento, Folio, Marca, Modelo o Placas que Coincidan Con '+ search);
                        }else if(search === '' && option1 !== ''){
                            $('#no-results-message').text('No Se Encontraron Recepcion Vehiculares de la Empresa '+ nombreempresa);
                        }else{
                            $('#no-results-message').text('No Se Encontraron Recepcion Vehiculares Con #Orden, Ord. Seguimmiento, Folio, Marca, Modelo o Placas Que Coincidan Con  '+search +' de la Empresa '+ nombreempresa);
                        }
                    } else {
                        document.querySelector('.no-results-message').setAttribute('hidden',true);
                        $('#no-results-message').text('');
                    }
                    showElements();
                
            }

        $("#EmpresaForm").submit(function(e) {
                    e.preventDefault();
                    $("#Empresa_modal").modal("hide");
                    $("#empresaupdated").attr("disabled", true);
                    $("#newempresa").attr("disabled", true)
                    let mensaje;
                    if(document.getElementById("compani_id").val==null){
                        mensaje ="¿Estás Seguro De Registrar A la Empresa "+ document.getElementById("compani_nombre").value+" ?"
                    }else{
                        mensaje ="¿Estás Seguro De Modificar Los Datos De La Empresa "+ document.getElementById("compani_nombre").value+" ?"
                    }
                    Swal.fire({
                            icon: "question",
                            text: mensaje,
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
                                var form = $("#EmpresaForm")[0];
                                var formData = new FormData(form);
                                let ruta="{{ route('cliente.compani_register') }}";
                                $.ajax({
                                url: ruta,
                                type: "POST",
                                data: formData,
                                contentType: false, // Evita que jQuery establezca un tipo de contenido
                                processData: false, // Evita que jQuery procese los datos
                                success: function(response) {
                                    
                                    $("#empresaupdated").attr("disabled", true);
                                    $("#newempresa").attr("disabled", true)
                                    if (response == "actualizado") {
                                        Swal.fire({
                                            icon: "success",
                                            title: "Se Actualizo Correctamente La Empresa",
                                            showConfirmButton: false,
                                            timer: 4000,
                                        });
                                        window.executeSearchdata();
                                    }
                                    else if (response == "creado") {
                                        Swal.fire({
                                            icon: "success",
                                            title: "Se Ha Creado Correctamente La Empresa",
                                            showConfirmButton: false,
                                            timer: 4000,
                                        });
                                        window.executeSearchdata();
                                    } 
                                    else if (response == "imagennosubida") {
                                        Swal.fire({
                                            icon: "error",
                                            title: "No Se Pudo Subir El Logo",
                                            showConfirmButton: false,
                                            timer: 4000,
                                        });
                                        window.executeSearchdata();
                                    } 
                                    else if (response == "noencontrado") {
                                        
                                    } 
                                    else {
                                        Swal.fire({
                                            icon: "error",
                                            title: "Oops...",
                                            html: data,
                                        });
                                    }
                                },
                                error: function(xhr) {
                                    if (xhr.status === 404) {
                                        Swal.fire({
                                            icon: "error",
                                            title: "No Se Pudo Encontrar La Empresa Que Desea Modificar",
                                            showConfirmButton: false,
                                            timer: 4000,
                                        });
                                        $("#empresaupdated").attr("disabled", false);
                                        $("#newempresa").attr("disabled", false);
                                    } else {
                                        alert('Ocurrió un error al procesar la solicitud');
                                        $("#empresaupdated").attr("disabled", false);
                                        $("#newempresa").attr("disabled", false);
                                    }
                                }
                            });
                     
                            } else {
                                $("#Empresa_modal").modal("show");
                                $("#empresaupdated").attr("disabled", false);
                                $("#newempresa").attr("disabled", false);
                            }
                        });
                });
    });
</script>
@endsection