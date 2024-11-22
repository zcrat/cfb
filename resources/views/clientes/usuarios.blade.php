@extends ('layouts.admin2')
@section ('contenido')

<main class="main">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Usuarios
                <button type="button"  onclick="openmodal()" class="boton1">
                <i class="fa-solid fa-circle-plus"></i>&nbsp;Nuevo
                </button>
            </div>
            <div class="card-body mycard" >
                <div class="dataupload" id="dataupload">
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
                            <input class="misearch"
                                type="text" id="search" name="s"
                                placeholder="Busqueda por Nombre" min="1">
                        </div>
                    </div>
                    <div class="viewelements" id="viewelements">
                        <div class="elementosporpagina">         
                            <select  class="rounded" id="epp">
                                @for ($i = 10; $i <= $elementostotales/3; $i += 5)
                                    <option value="{{ $i }}" >{{ $i }}</option>
                                @endfor
                            </select>
                            <div id='pagination'></div>
                        </div>
                        <div class="mitabla">
                            <table id="tablausuarios" class="table table-sm table-striped">
                            <colgroup>
                            <col class="button_options"> <!-- Columna con ancho fijo del 20% -->
                                
                            </colgroup>
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
                    </div>
                </div>
                <div  class="no-results-message" hidden>
                    <span id="no-results-message"></span>
                </div>
                <div id='loadingdata' class="carga">
                    <h3 class="text-center m-2">Cargando Datos</h3>
                    <div class="spinnerp"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="usuarioStore" tabindex="-1" role="dialog" aria-labelledby="usuarioStoreLabel" aria-hidden="true" 
    data-bs-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document" >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-uppercase" id="modalusertitle">Nuevo cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
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
<script src="{{asset('js/paginacion.js')}}"></script>
<script>
    function cerrarModal() {
        $('#usuarioStore').modal('hide');
    }
    function openmodal(title){
        
        document.getElementById('newuser').removeAttribute('hidden');
        document.getElementById('userupdated').setAttribute('hidden', true);
        $('#usuarioStore input').not('[name="_token"]').val('');
        $('#usuarioStore select').val('');
        $('#modalusertitle').text(title);
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
                            $('#modalusertitle').text("Modificar Usuario")
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
                    console.log(startIndex);
                    console.log(itemsPerPage);
                    let endIndex = startIndex + itemsPerPage;
                    console.log(endIndex);
                    let paginatedElements = elements.slice(startIndex, endIndex);
                    console.log(paginatedElements);
                    $('#tablausuarios tbody').empty();
                    if (paginatedElements.length > 0) {
                        document.getElementById('viewelements').removeAttribute('hidden');
                    } else {
                        document.getElementById('viewelements').setAttribute('hidden', true);
                    }
                    $.each(paginatedElements, function(index, element) {
                        let row = $('<tr>');
                        
                        row.append('<td > <div class="Datatable-content-button"> <button class="btn btn-warning btn-sm" '+
                                            'onclick="actualizar(\''+element.id+'\')"><i class="fas fa-edit"></i>'+
                                    '</button>'+
                                    '<button class="btn btn-danger btn-sm" onclick="eliminar(\''+element.id+'\',\''+element.nombre+'\')">'+
                                        '<i class="fas fa-trash-alt"></i></button></div></td>');
                        row.append('<td><div class="userDatatable-content">' + (element.empresa ? element.empresa.nombre : "Sin Empresa" )+ '</div></td>');
                        row.append('<td><div class="userDatatable-content">' + (element.nombre ? element.nombre : "Sin Nombre" ) + '</div></td>');
                        row.append('<td><div class="userDatatable-content">' + (element.email ? element.email : "")+ '</div></td>');
                        row.append('<td><div class="userDatatable-content">' + (element.direccion ? element.direccion : "") + '</div></td></tr>');
                        $('#tablausuarios tbody').append(row);
                    });
                }
                
                $('#empresa').change(filtering);
                $('#search').on('input', filtering);
                function filtering() {
                    const empresas = document.getElementById("empresa");
                    let option1 = empresas.value;
                    let empresa = empresas.options[empresas.selectedIndex].text;

                    console.log('el id de la empres es '+ option1 )
                    let search = $('#search').val().toLowerCase();
                    Page = 1
                   
                        elements = originalelements.filter(function(element) {
                            
                            return (option1 === '' || element.empresa_id == option1) &&
                                (search === '' || element.nombre.toLowerCase().includes(search));

                        });
                    

                    if (elements.length === 0) {
                        document.querySelector('.no-results-message').removeAttribute('hidden');
                        if(search !== '' && option1 === ''){
                            $('#no-results-message').text('No Se Encontraron Usuarios Con El Nombre '+ search);
                        }else if(search === '' && option1 !== ''){
                            $('#no-results-message').text('No Se Encontraron Usuarios Afiliados A La Empresa '+ empresa);
                        }else{
                            $('#no-results-message').text('No Se Encontraron Usuarios Con el Nombre '+search +' Afiliados A La Empresa '+ empresa);
                        }


                    } else {
                        document.querySelector('.no-results-message').setAttribute('hidden',true);
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