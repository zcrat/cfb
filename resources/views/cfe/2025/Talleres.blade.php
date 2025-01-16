@extends ('layouts.admin2')
@section ('contenido')

<main class="main vaniflex vanigrow">
    <div class="container-fluid vaniflex vanigrow">
            <div class="card vanigrow">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i>Talleres Externos
                    <button type="button"  class="boton1" data-bs-toggle="modal" onclick="limpiarmodaltalleres()" data-bs-target="#recepcionservicio">
                        <i class="fa-solid fa-circle-plus"></i>&nbsp;Nueva
                    </button>
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
                        </div>
                        <div class="viewelements vanigrow vaniflex zdfd-column" id="viewelements">
                            <div class="elementosporpagina">
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
    @include('modales.recepcionservicio')
    @include('modales.recepcionservicioyconceptos')


  
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{asset('js/paginacion.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.6.0/fabric.min.js"></script>
@stack('scripts')
<script>


     $(function() {
        window.limpiarmodaltalleres = function() {
            $("#formnewrecepcion").find(".error-message").remove();
            $('#recepcionservicio input').not('input[name="_token"]').val('');
            $('#recepcionservicio textarea').val('');
            $('#recepcionservicio select').val('').trigger('change');;  // O puedes usar $('#RecepcionVehicular select').prop('selectedIndex', -1);
            
        }
        window.editarecepciontaller = function(id) {
            
            console.log(id);
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
                        url: '{{ route('2025.cfe.obtener.talleres') }}',
                        data:{
                            modulo:modulo,
                            anio:anio
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
                        let row = $('<tr><td><div class="Datatable-content" ></div></td></tr>');
                        let acciones =`<td><div class="Datatable-content ">`;
                        acciones+=`<button type="button" class="btn btn-warning btn-sm" title="Factura XML" @click="abrirModal3(cotizacion)">
                                    <i class="fa fa-comment-alt"></i>
                                    </button>  `;
                        let dropdownContent = `
                            <button type="button"class="opcionesdesplegables btn  btn-primary ">Opciones</button>
                            <ul class="detallesdesplegables zdw-r12"" hidden>
                                <li><a href="#" ">Eliminar</a></li>
                                <li><a href="#" onclick="executeagregarservicio2(`+element.id+`)">Editar</a></li>
                                <li><a href="#">Recepción Vehicular</a></li>
                                <li><a href="#">Fotos Viejas</a></li>
                                <li><a href="#">Presupuesto</a></li>
                                <li><a href="#">Presupuesto Acuse</a></li>
                                <li><a href="#">Reporte Anomalías</a></li>
                                <li><a href="#">Entrada</a></li>
                                <li><a href="#">Orden Servicio</a></li>
                        `;
                        if (element.status >= 3) {
                            dropdownContent += `
                                <li><a href="#">Fotos Nuevas</a></li>
                                <li><a href="#">Fotos Instaladas</a></li>
                                <li><a href="#">Factura PDF</a></li>
                                <li><a href="#">Factura XML</a></li>
                                <li><a href="#">Acuse</a></li>
                            `;
                        }
                        if (element.status == 0) {
                             acciones += `
                            
                                 <button type="button" class="btn btn-warning" title="Boton de terminar">
                                    Enviar
                                    </button>
                            `;
                        }
                        if (element.status < 3 && element.status>0 ) {
                             acciones += `
                            
                                 <button type="button" class="btn btn-secondary" title="Boton de terminar">
                                    PENDIENTE
                                    </button>
                            `;
                        }
                        if (element.status == 3) {
                            //cambia a estatus 4
                             acciones += `
                                 <button type="button" class="btn btn-warning" title="Boton de terminar" >
                                    Cerrar
                                    </button>
                            `;
                        }
                        if (element.status > 3) {
                             acciones += `
                                 <button type="button" class="btn btn-success" title="Boton de autorizar">
                                    TERMINADO
                                    </button> 
                            `;
                        }
   
                        dropdownContent += `</ul>`;
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
                        $('#tablarecepciones tbody').append(row);
                    });recepciondelete
                }
                $('#search').on('input', filtering);
    
                function filtering() { 
                    let search = $('#search').val().toLowerCase();
                    Page = 1
                        elements = originalelements.filter(function(element) {
                            return (search === '' || 
                            element.NSolicitud.toLowerCase().includes(search) || 
                            element.placas.toLowerCase().includes(search) || 
                            element.identificador.toLowerCase().includes(search) ||
                            element.vin.toLowerCase().includes(search) ||
                            element.marca.toLowerCase().includes(search) ||
                            element.modelo.toLowerCase().includes(search)
                        );

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
        $(document).on('click', '.opcionesdesplegables', function(event) {
            event.stopPropagation(); 
            $(".detallesdesplegables").attr('hidden',true)
            $(this).next().removeAttr('hidden');
        });
        $(document).on('click', function() {
            $(".detallesdesplegables").attr('hidden',true)
        });


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