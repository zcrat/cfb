@extends ('layouts.admin2')
@section ('contenido')

<main class="main">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Usuarios
                <button type="button"  onclick="openmodal()" class="btn btn-secondary">
                    <i class="icon-plus"></i>&nbsp;Nuevo
                </button>
            </div>
            <div class="card-body">
                <div>
                    <div class="d-flex superior">
                        <div class="encabezado" >
                            <label >Empresa:  </label>
                            <select class="rounded" id="empresa">
                                <option value="">Todos</option>
                                @foreach ($empresas as $option)
                                    <option value="{{ $option->id }}">{{ $option->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-flex busqueda">
                            <i class="fa fa-search" aria-hidden="true"></i>&nbsp;
                            <input class="rounded-pill"
                                type="text" id="search" name="s"
                                placeholder="Busqueda por Nombre" min="1">
                        </div>
                    </div>
                </div> 
                <div>
                            <label style="font-size: 1rem;">Usuarios maximos por pagina  </label>
                            <select style="width: 200px; height: 30px;"  class="rounded" id="epp">
                                @for ($i = 5; $i <= $elementostotales; $i += 5)
                                    <option value="{{ $i }}" >{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                <div id="dataupload">
                    <div id='pagination'></div>
                        <table id="tablausuarios" class="table table-sm table-striped">
                            <thead>
                            <tr>
                                <th>Opciones</th>
                                <th>Empresa</th>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Dirección</th>
                            </tr>
                            </thead>
                            <tbody>
                        
                            </tbody>
                        </table>
                    </div>
                <div id='loadingdata'class="overflow-hidden rounded-lg border border-gray-200 shadow-md m-5">
                    <h3 class="text-center m-2">Cargando Datos</h3>
                    <div class="spinnerp"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="usuarioStore" tabindex="-1" role="dialog" aria-labelledby="usuarioStoreLabel" aria-hidden="true" 
    data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document" >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-uppercase" id="usuarioStoreLabel">Nuevo cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="cerrarModal()">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="customerForm" >
                        @csrf
                        <input id="customer-id" class="form-control" type="hidden" name="customer-id">
                        <div class="form-group">
                            <div class="input-group">
                                <i class="fas fa-building"></i>
                                <label class="encabezadomodal ">Empresa</label>
                                    <select id="customer-idempresa" class="form-control" name="customer-idempresa" required>
                                    <option value="">Seleccione una empresa</option>
                                    @foreach($empresas as $empresa)
                                        <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="customer-usuario">Nombre:<i class="ml-2 color-required fas fa-asterisk"></i></label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <input id="customer-usuario" class="form-control" type="text" name="customer-usuario" placeholder="Ej. Alberto Esquivias Flores" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="customer-direccion">Dirección:<i class="ml-2 color-required fas fa-asterisk"></i></label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <input id="customer-direccion" class="form-control" type="text" name="customer-direccion" placeholder="Ej. C. PUERTO DE ACAPULCO NO. 328, COL. TINIJARO, C.P. 58337" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="customer-ciudad">Ciudad:<i class="ml-2 color-required fas fa-asterisk"></i></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                        <input id="customer-ciudad" class="form-control" type="text" name="customer-ciudad" placeholder="Ej. Morelia" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="customer-estado">Estado:<i class="ml-2 color-required fas fa-asterisk"></i></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                        <input id="customer-estado" class="form-control" type="text" name="customer-estado" placeholder="Ej. Michoacán" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="customer-cp">C.P.:<i class="ml-2 color-required fas fa-asterisk"></i></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                        <input id="customer-cp" class="form-control" type="text" name="customer-cp" placeholder="Ej. 58000" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="customer-tel_casa">Tel Casa:<i class="ml-2 color-required fas fa-asterisk"></i></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fas fa-phone"></i>
                                        </div>
                                        <input id="customer-tel_casa" class="form-control" type="text" name="customer-tel_casa" placeholder="Ej. 4431040746" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="customer-tel_oficina">Tel Oficina:<i class="ml-2 color-required fas fa-asterisk"></i></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fas fa-phone"></i>
                                        </div>
                                        <input id="customer-tel_oficina" class="form-control" type="text" name="customer-tel_oficina" placeholder="Ej. 4431040746" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="customer-tel_celular">Tel Celular:<i class="ml-2 color-required fas fa-asterisk"></i></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fas fa-phone"></i>
                                        </div>
                                        <input id="customer-tel_celular" class="form-control" type="text" name="customer-tel_celular" placeholder="Ej. 4431040746" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="customer-email">Email:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-mail-forward"></i>
                                </div>
                                <input id="customer-email" class="form-control" type="email" name="customer-email" placeholder="Ej. designapp.mx@gmail.com" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cerrarModal()">Cancelar</button>
                    <!--<button type="button" class="btn btn-primary" onclick="document.getElementById('customerForm').submit()">Guardar</button>-->
                    <button type="submit" hidden id="userupdated" form="customerForm"class="btn btn-primary">Actualizar</button>
                    <button type="submit" id="newuser" form="customerForm" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function cerrarModal() {
        $('#usuarioStore').modal('hide');
    }
    function openmodal(){
        
        document.getElementById('newuser').removeAttribute('hidden');
        document.getElementById('userupdated').setAttribute('hidden', true);
        $('#usuarioStore input').not('[name="_token"]').val('');
        $('#usuarioStore select').val('');
        $('#usuarioStore').modal('show');
    }
    
    
    function actualizar(id){
        $.ajax({
                        type: 'GET',
                        url: '{{ route('cliente.user') }}',
                        data: {'id' : id},
                        success: function(response) {
                            let customer= response.customer[0];
                            console.log(customer);
                            document.getElementById("customer-id").value = customer.id;
                            document.getElementById("customer-idempresa").value = customer.empresa_id;
                            document.getElementById("customer-usuario").value = customer.nombre;
                            document.getElementById("customer-direccion").value = customer.direccion;
                            document.getElementById("customer-ciudad").value = customer.ciudad;
                            document.getElementById("customer-estado").value = customer.estado;
                            document.getElementById("customer-cp").value = customer.cp;
                            document.getElementById("customer-tel_casa").value = customer.tel_casa;
                            document.getElementById("customer-tel_oficina").value = customer.tel_oficina;
                            document.getElementById("customer-tel_celular").value = customer.tel_celular;
                            document.getElementById("customer-email").value = customer.email;
                            document.getElementById('userupdated').removeAttribute('hidden');
                            document.getElementById('newuser').setAttribute('hidden', true);
                            $('#usuarioStore').modal('show');
        
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr);
                        }
                    });
       
                }
    function eliminar(id,nombre){
                    Swal.fire({
                            icon: "question",
                            text: "¿Estás seguro de Eliminar al Usuario "+nombre+" ?",
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
                                let $request = $.post("{{ route('cliente.delete') }}", {
                                    "_token": "{{ csrf_token() }}",
                                    id: id
                                });
                                $request.done(function(data) {
                                    console.log(data);
                                    if (data == "eliminado") {
                                        Swal.fire({
                                            icon: "success",
                                            title: "Se elimino correctamente al usuario",
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
                        url: '{{ route('cliente.users') }}',
                        success: function(response) {
                            originalelements = elements = response.usuarios;
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
                        row.append('<td><div class="userDatatable-content">' + (element.empresa ? element.empresa.nombre : "Sin Empresa" )+ '</div></td>');
                        row.append('<td><div class="userDatatable-content">' + (element.nombre ? element.nombre : "Sin Nombre" ) + '</div></td>');
                        row.append('<td><div class="userDatatable-content">' + (element.email ? element.email : "")+ '</div></td>');
                        row.append('<td><div class="userDatatable-content">' + (element.direccion ? element.direccion : "") + '</div></td></tr>');
                        $('#tablausuarios tbody').append(row);
                    });
                }
                

                function ShowPagination() {
                    
                    let totalPages = Math.ceil(elements.length / itemsPerPage);
                    let paginationHTML = '';
                   
                    let paginas = 10
                    if (Page > totalPages) {
                        Page = totalPages;
                    }
                    if (Page < 1) {
                        Page = 1;
                    }
                    if (totalPages > 1) {
                        if (Page > 1) {
                            paginationHTML += '<button class="pagina" data-page="' + (Page - 1) + '">Anterior</button>';
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
                                '">Siguiente</button>';
                        }
                    }
                    $('#pagination').html(paginationHTML);
                }
                $('#pagination').on('click', '.pagina', function() {
                    Page = parseInt($(this).data('page'));
                    showElements();

                });
                $('#empresa').change(filtering);
                $('#epp').change(function(){
                    itemsPerPage =  parseInt($('#epp').val(),10);
                    showElements();});

                $('#search').on('input', filtering);
                function filtering() {
                   
                    let option1 = $('#empresa').val();
                    console.log('el id de la empres es '+ option1 )
                    let search = $('#search').val().toLowerCase();
                    Page = 1
                    if (/^[\d.]+$/.test(search)) {
                        
                    console.log('el id de la empres es '+ option1 )
                        elements = originalelements.filter(function(element) {
                            
                    
                            return (option1 === '' || element.empresa_id === option1) &&
                                (search === '' || element.nombre.toLowerCase().includes(search));

                        });
                    } else {
                        elements = originalelements.filter(function(element) {
                            
                            return (option1 === '' || element.empresa_id == option1) &&
                                (search === '' || element.nombre.toLowerCase().includes(search));

                        });
                    }

                    if (elements.length === 0) {
                        $('#no-results-message').text('No se encontraron elements');
                    } else {
                        $('#no-results-message').text('');
                    }
                    showElements();
                }
                $("#customerForm").submit(function(e) {
                    e.preventDefault();
                    console.log("Formulario enviado");
                    $("#usuarioStore").modal("hide");
                    $("#userupdated").attr("disabled", true);
                    $("#newuser").attr("disabled", true)
                    Swal.fire({
                            icon: "question",
                            text: "¿Estás seguro de Modificar los datos del Usuario?",
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
                                var $request = $.post(
                            "{{ route('cliente.register') }}",
                            $("#customerForm").serialize()
                        );
                        $request.done(function(data) {
                            $("#userupdated").attr("disabled", false);
                            $("#newuser").attr("disabled", false);
                            console.log(data);
                            if (data === "creado") {
                                Swal.fire({
                                    icon: "success",
                                    title: "Se registró correctamente al nuevo usuario",
                                    showConfirmButton: false,
                                    timer: 4000,
                                });
                                searchdata();
                            }else if (data == "actualizado") {
                                Swal.fire({
                                    icon: "success",
                                    title: "El usuario se actualizo Correctamente",
                                    showConfirmButton: false,
                                    timer: 4000,
                                });
                                searchdata();
                            }  else {
                                Swal.fire({
                                    icon: "error",
                                    title: "Oops...",
                                    html: data,
                                }).then((result) => {
                                    $("#usuarioStore").modal("show");
                                });
                            }
                        });
                        $request.fail(function(error) {
                            $("#userupdated").attr("disabled", false);
                            $("#newuser").attr("disabled", false);
                            $("#usuarioStore").modal("hide");
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Ocurrió un error",
                            }).then((result) => {
                                $("#usuarioStore").modal("show");
                            });
                        });
                            } else {
                                $("#usuarioStore").modal("show");
                                $("#userupdated").attr("disabled", false);
                                $("#newuser").attr("disabled", false);
                            }
                        });
                });
    });
</script>

      
         
@endsection