@extends ('layouts.admin2')
@section ('contenido')

<main class="main">
    <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Empresas
                    <button type="button"  onclick="openmodal('Nueva Empresa')" class="btn btn-secondary">
                        <i class="icon-plus"></i>&nbsp;Agregar
                    </button>
                </div>
                <div class="card-body mycard">
                    <div class="dataupload" id="dataupload">
                        <div class="d-flex">
                            <div class="d-flex align-items-left user-member__form">
                                <input class="misearch"
                                    type="text" id="search" name="s"
                                    placeholder="Busqueda Por Nombre, RFC, Correo O Telefono" min="1">
                                    <i class="fa fa-search" aria-hidden="true"></i>&nbsp;
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
                                <table id="tablausuarios" class="table table-sm  table-striped">
                                    <thead  class= "thead-light">
                                        <tr>
                                            <th>Opciones</th>
                                            <th>ID</th>
                                            <th>RFC</th>
                                            <th>Razon Social</th>
                                            <th>Folio</th>
                                            <th>Total</th>
                                            <th>Fecha Creacion</th>
                                            <th>Fecha Actualizacion</th>
                                            <th>Documento</th>
                                            <th>Estado</th>
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
    <div class="modal fade modal-basic" id="Empresa_modal" tabindex="-1" aria-labelledby="taskModalLabal" aria-hidden="true" 
    data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-uppercase" id="modalcompanititle"></h5>
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
                                <img id="logo_preview" src="#" alt="Logo Preview" class="mimagen" hidden>
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
<script src="{{asset('js/paginacion.js')}}"></script>
<script>
    function cerrarModal() {
        $('#Empresa_modal').modal('hide');
    }
    function openmodal(title){
        document.getElementById('newempresa').removeAttribute('hidden');
        document.getElementById('empresaupdated').setAttribute('hidden', true);
        $('#Empresa_modal input').not('[name="_token"]').val('');
        $('#Empresa_modal select').val('');
        document.getElementById('logo_preview').src = "";
        document.getElementById('logo_preview').setAttribute('hidden',true);
        $('#modalcompanititle').text(title)
        $('#Empresa_modal').modal('show');
    }
    $('#compani_logo').change(function(){ 
        const file = this.files[0]; // Obtén el primer archivo seleccionado
    if (file) {
        const reader = new FileReader();
        reader.readAsDataURL(file); // Lee el archivo como una URL de datos
        reader.onload = function(e) {
            // Asigna el resultado de la lectura al src de la imagen
            document.getElementById('logo_preview').src = e.target.result;
            document.getElementById('logo_preview').removeAttribute('hidden');
        }
    }
    })
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
                            imgElement.src = '/storage/img/logos_empresas/'+compani.logo; // Asignar la URL a la fuente de la imagen
                            imgElement.removeAttribute('hidden');
                            $('#modalcompanititle').text("Modificar Empresa")

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
                searchdata();
                function searchdata() {
                    document.getElementById('loadingdata').removeAttribute('hidden');
                    document.getElementById('dataupload').setAttribute('hidden', true);
                    console.log("entra")
                    $.ajax({
                        type: 'GET',
                        url: '{{ route('facturacion.obtenerfacturas') }}',
                        success: function(response) {
                            originalelements = elements = response.facturas;

                            document.getElementById('loadingdata').setAttribute('hidden', true);
                            document.getElementById('dataupload').removeAttribute('hidden');
                            console.log(elements);
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
                                    '<button class="btn btn-danger btn-sm" onclick="eliminar(\''+element.id+'\',\''+element.folio+'\')">'+
                                        '<i class="fas fa-trash-alt"></i></button></div></td>');
                        $('#tablausuarios tbody').append(row);
                    });
                }
                $('#search').on('input', filtering);
                function filtering() {
                   
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
                                        $("#newempresa").attr("disabled", false);s
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