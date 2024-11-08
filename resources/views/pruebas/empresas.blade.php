@extends ('layouts.admin2')
@section ('contenido')

<main class="main">
    <div class="container-fluid">
    
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Empresas
                    <button type="button"  onclick="openmodal()" class="btn btn-secondary">
                        <i class="icon-plus"></i>&nbsp;Agregar
                    </button>
                </div>
                <div class="card-body">
                    <div class="card-header color-dark fw-500" style="text-transform: none;">
                        <div class="d-flex justify-content">
                            <div class="d-flex align-items-left user-member__form">
                                
                                <input style="width: 200px; height: 30px;" class=" fs-18 rounded-pill bg-normal color-light row-cols-sm-3"
                                    type="text" id="search" name="s"
                                    placeholder="Busqueda por Nombre" min="1">
                                    <i class="fa fa-search" aria-hidden="true"></i>&nbsp;
                            </div>
                        </div>
                    </div> 
                    <div>
                        <label style="font-size: 1rem;">Empresas maximas por pagina  </label>
                        <select style="width: 200px; height: 30px;"  class="rounded" id="epp">
                            @for ($i = 5; $i <= $elementostotales; $i += 5)
                                <option value="{{ $i }}" >{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div style="height:20px;"></div>
                    <div id="dataupload">
                        <div id='pagination'></div>
                        <div style="height:20px;"></div>
                        <div  class="mitabla">
                            <table id="tablausuarios" class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Nombre</th>
                                        <th>RFC</th>
                                        <th>Correo</th>
                                        <th>Telefono</th>
                                        <th>Fecha Creacion</th>
                                        <th>Fecha Actualizacion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id='loadingdata'
                        class="overflow-hidden rounded-lg border border-gray-200 shadow-md m-5">
                        <h3 class="text-center m-2">Cargando Datos</h3>
                        <div class="spinnerp"></div>
                    </div>
                </div>
            </div>

    </div>
    <div class="modal fade modal-basic" id="Empresa_modal" tabindex="-1" aria-labelledby="taskModalLabal" aria-hidden="true" 
    data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-uppercase" id="Empresa_modalLabel">Nueva Empresa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
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
                                <img id="logo_preview" src="#" alt="Logo Preview" style="width: 400px; height:auto; display: none;">
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cerrarModal()">Cancelar</button>
                    <button type="submit" hidden id="empresaupdated" form="EmpresaForm"class="btn btn-primary">Actualizar</button>
                    <button type="submit" id="newempresa" form="EmpresaForm" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function cerrarModal() {
        $('#Empresa_modal').modal('hide');
    }
    function openmodal(){
        
        document.getElementById('newempresa').removeAttribute('hidden');
        document.getElementById('empresaupdated').setAttribute('hidden', true);
        $('#Empresa_modal input').not('[name="_token"]').val('');
        $('#Empresa_modal select').val('');
        $('#Empresa_modal').modal('show');
    }
    
    
    function actualizar(id){
        $.ajax({
                        type: 'GET',
                        url: '{{ route('cliente.compani') }}',
                        data: {'id' : id},
                        success: function(response) {
                            let compani= response.compani[0];
                            document.getElementById("compani_id").value = compani.id;
                            document.getElementById("compani_nombre").value = compani.nombre;
                            document.getElementById("compani_rfc").value = compani.rfc;
                            document.getElementById("compani_regimen").value = compani.regimen;
                            document.getElementById("compani_email").value = compani.email;
                            document.getElementById("compani_direccion").value = compani.direccion;
                            document.getElementById("compani_ciudad").value = compani.ciudad;
                            document.getElementById("compani_estado").value = compani.estado;
                            document.getElementById("compani_cp").value = compani.cp;
                            document.getElementById("compani_tel_negocio").value = compani.tel_negocio;
                            document.getElementById("compani_tel_casa").value = compani.tel_casa;
                            document.getElementById("compani_tel_celular").value = compani.tel_celular;
                            document.getElementById('empresaupdated').removeAttribute('hidden');
                            document.getElementById('newempresa').setAttribute('hidden', true);
                            const imgElement = document.getElementById('logo_preview');
                            imgElement.src = '/img/logos-empresas/'+compani.logo; // Asignar la URL a la fuente de la imagen
                            imgElement.style.display = 'block';
                            $('#Empresa_modal').modal('show');
        
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr);
                        }
                    });
       
                }
    function eliminar(id,nombre){
                    Swal.fire({
                            icon: "question",
                            text: "¿Estás seguro de Eliminar la Empresa "+nombre+" ?",
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
                                let $request = $.post("{{ route('cliente.deletecompani') }}", {
                                    "_token": "{{ csrf_token() }}",
                                    id: id
                                });
                                $request.done(function(data) {
                                    console.log(data);
                                    if (data == "eliminado") {
                                        Swal.fire({
                                            icon: "success",
                                            title: "Se Elimino Correctamente La Empresa",
                                            showConfirmButton: false,
                                            timer: 4000,
                                        });
                                        window.executeSearchdata();
                                    }else {
                                        Swal.fire({
                                            icon: "error",
                                            title: "Oops...",
                                            html: data,
                                        });
                                    }
                                });
                                $request.fail(function(error) {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Oops...",
                                        text: "Ocurrió un error",
                                    });
                                });
                            } else {
                               
                            }
                        });
                }
    $(document).ready(function() {
                let elements = [];
                let originalelements = [];
                let Page = 1;
                let itemsPerPage = parseInt($('#epp').val(),10);
                searchdata();
                function searchdata() {
                    document.getElementById('loadingdata').removeAttribute('hidden');
                    document.getElementById('dataupload').setAttribute('hidden', true);
                    $.ajax({
                        type: 'GET',
                        url: '{{ route('cliente.companies') }}',
                        success: function(response) {
                            originalelements = elements = response.companies;
                            document.getElementById('loadingdata').setAttribute('hidden', true);
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

                function showElements() {
                    
                    ShowPagination();
                    let startIndex = (Page - 1) * itemsPerPage;
                    console.log(startIndex);
                    console.log(itemsPerPage);
                    let endIndex = startIndex + itemsPerPage;
                    console.log(endIndex);
                    let paginatedElements = elements.slice(startIndex, endIndex);
                    console.log(paginatedElements);
                    $('#tablausuarios tbody').empty();
                    if (paginatedElements.length > 0) {
                        document.getElementById('dataupload').removeAttribute('hidden');
                    } else {
                        document.getElementById('dataupload').setAttribute('hidden', true);
                    }
                    $.each(paginatedElements, function(index, element) {
                        let row = $('<tr>');
                        
                        row.append('<td> <button class="btn btn-warning btn-sm" '+
                                            'onclick="actualizar(\''+element.id+'\')"><i class="fas fa-edit"></i>'+
                                    '</button>'+
                                    '<button class="btn btn-danger btn-sm" onclick="eliminar(\''+element.id+'\',\''+element.nombre+'\')">'+
                                        '<i class="fas fa-trash-alt"></i></button></td>');
                        row.append('<td><div class="userDatatable-content">' + (element.nombre ? element.nombre : "Sin Nombre" ) + '</div></td>');
                        row.append('<td><div class="userDatatable-content">' + (element.rfc ? element.rfc : "")+ '</div></td>');
                        row.append('<td><div class="userDatatable-content">' + (element.email ? element.email : "") + '</div></td></tr>');
                        row.append('<td><div class="userDatatable-content">' + (element.tel_negocio ? element.tel_negocio : "") + '</div></td></tr>');
                        row.append('<td><div class="userDatatable-content">' + (element.created_at ? element.created_at : "") + '</div></td></tr>');
                        row.append('<td><div class="userDatatable-content">' + (element.updated_at ? element.updated_at : "") + '</div></td></tr>');
                        $('#tablausuarios tbody').append(row);
                    });
                }
                

                function ShowPagination() {
                    
                    let totalPages = Math.ceil(elements.length / itemsPerPage);
                    let paginationHTML = '';
                   
                    let paginas = 7
                    if (Page > totalPages) {
                        Page = totalPages;
                    }
                    if (Page < 1) {
                        Page = 1;
                    }
                    if (totalPages > 1) {
                        if (Page > 1) {
                            paginationHTML += '<button class="pagina" data-page="' + (Page - 1) + '"><<<</button>';
                        }
                        if (Page == 1) {
                            paginationHTML += '<button class="paginaactive" data-page="1">1</button>';
                        } else {
                            paginationHTML += '<button class="pagina" data-page="1">1</button>';
                        }

                        if (Page > paginas / 2 && totalPages > paginas) {
                            paginationHTML += '<span>...</span>';
                        }

                        for (let i = 2; i <= totalPages - 1; i++) {
                            if ((Page <= paginas / 2 && i <= paginas) || (Page > totalPages - paginas / 2 && i >=
                                    totalPages - paginas + 1)) {
                                if (Page == i) {
                                    paginationHTML += '<button class="paginaactive" data-page="' + i + '">' + i +
                                        '</button>';
                                } else {
                                    paginationHTML += '<button class="pagina" data-page="' + i + '">' + i + '</button>';
                                }
                            } else {
                                if (i < Page + paginas / 2 && i > Page - paginas / 2) {
                                    if (Page == i) {
                                        paginationHTML += '<button class="paginaactive" data-page="' + i + '">' + i +
                                            '</button>';
                                    } else {
                                        paginationHTML += '<button class="pagina" data-page="' + i + '">' + i +
                                            '</button>';
                                    }
                                }
                            }
                        }

                        if (Page < totalPages - paginas / 2 && totalPages > paginas) {
                            paginationHTML += '<span>...</span>';
                        }

                        if (totalPages > 1) {
                            if (Page == totalPages) {
                                paginationHTML += '<button class="paginaactive" data-page="' + (totalPages) + '">' +
                                    totalPages + '</button>';
                            } else {
                                paginationHTML += '<button class="pagina" data-page="' + (totalPages) + '">' +
                                    totalPages + '</button>';
                            }
                        }
                        if (Page < totalPages) {
                            paginationHTML += '<button class="pagina" data-page="' + (Page + 1) +
                                '">>>></button>';
                        }
                    }
                    $('#pagination').html(paginationHTML);
                }
                $('#pagination').on('click', '.pagina', function() {
                    Page = parseInt($(this).data('page'));
                    showElements();

                });
                $('#epp').change(function(){
                    itemsPerPage =  parseInt($('#epp').val(),10);
                    showElements();});
                $('#search').on('input', filtering);
                function filtering() {
                   
                  
                    let search = $('#search').val().toLowerCase();
                    Page = 1
                    if (/^[\d.]+$/.test(search)) {
                        elements = originalelements.filter(function(element) {
                             return (search === '' || element.nombre.toLowerCase().includes(search));
                        });
                    } else {
                        elements = originalelements.filter(function(element) {
                        return (search === '' || element.nombre.toLowerCase().includes(search));
                        });
                    }

                    if (elements.length === 0) {
                        $('#no-results-message').text('No se encontraron elements');
                    } else {
                        $('#no-results-message').text('');
                    }
                    showElements();
                }
$("#EmpresaForm").submit(function(e) {
                    e.preventDefault();
                    console.log("Formulario enviado");
                    $("#Empresa_modal").modal("hide");
                    $("#empresaupdated").attr("disabled", true);
                    $("#newempresa").attr("disabled", true)
                    Swal.fire({
                            icon: "question",
                            text: "¿Estás seguro de Modificar los datos de la Empresa?",
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
                                $.ajax({
                                url: "{{ route('cliente.compani_register') }}",
                                type: "POST",
                                data: formData,
                                contentType: false, // Evita que jQuery establezca un tipo de contenido
                                processData: false, // Evita que jQuery procese los datos
                                success: function(response) {
                                    // Maneja la respuesta del servidor aquí
                                    console.log(response);
                                },
                                error: function(error) {
                                    // Maneja los errores aquí
                                    console.error(error);
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