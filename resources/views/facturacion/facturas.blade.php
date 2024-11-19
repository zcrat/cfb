@extends ('layouts.admin2')
@section ('contenido')

<main class="main">
    <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Facturas
                    <button type="button"  onclick="openwin()" class="boton1">
                    <i class="fa-solid fa-circle-plus nuevafactura"></i></i>&nbsp;Nueva
                    </button>
                    <button type="button"  onclick="openpay()" class="boton2">
                    <i class="fa-solid fa-circle-plus nuevopago"></i></i>&nbsp;Pago
                    </button>
                </div>
                <div class="card-body mycard">
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
                                <input class="rounded-pill"
                                    type="text" id="search" name="s"
                                    placeholder="Busqueda por Nombre" min="1">
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
                                <table id="tablaufacturas" class="table table-sm  table-striped">
                                    <thead  class= "thead-light">
                                        <tr>
                                            <th>Opciones</th>
                                            <th>ID</th>
                                            <th>RFC</th>
                                            <th>Razon Social</th>
                                            <th>Folio</th>
                                            <th>Total</th>
                                            <th>Fecha</th>
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
                    <div id="newfactur" hidden>
                        <form id="newfactur">
                            <div>
                            <label>Empresas</label>
                            <select class="rounded" id="empresa">
                                    <option value=""></option>
                                    @foreach ($empresas as $option)
                                        <option value="{{ $option->id }}">{{ $option->nombre }}</option>
                                    @endforeach
                            </select>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                     <label>Tipo de Comprobante</label>
                                      <select name="tipo_comprobante" class="form-control">
                                      <option value=""></option>
                                    @foreach ($tcomprobante as $option)
                                        <option value="{{ $option['id'] }}">{{ $option['nombre'] }}</option>
                                    @endforeach
                                   </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="uso_cfdi">Uso de CFDI por parte del Receptor</label>
                                        <select name="uso_cfdi" class="form-control" >
                                        <option value=""></option>
                                    @foreach ($cfdi as $option)
                                        <option value="{{ $option['id'] }}">{{ $option['nombre'] }}</option>
                                    @endforeach
                                        </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                   <label for="tipo_impuesto">Tipo de Impuesto Local</label>
                                  <select name="tipo_impuesto_local" class="form-control">
                                  <option value=""></option>
                                    @foreach ($timpuesto as $option)
                                        <option value="{{ $option['id'] }}">{{ $option['nombre'] }}</option>
                                    @endforeach
                                  </select>
                                </div>
                            </div>
                             <div class="col-md-4">
                                <div class="form-group">
                                    <label for="moneda">Moneda</label>
                                  <select name="moneda" class="form-control" >
                                  <option value=""></option>
                                    @foreach ($moneda as $option)
                                        <option value="{{ $option['id'] }}">{{ $option['nombre'] }}</option>
                                    @endforeach
                                  </select>
                                </div>
                            </div>
                             <div class="col-md-4">
                                <div class="form-group">
                                     <label for="formadepago">Forma de pago</label>
                                  <select name="fpago" class="form-control" >
                                  <option value=""></option>
                                    @foreach ($formapago as $option)
                                        <option value="{{ $option['id'] }}">{{ $option['nombre'] }}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                             <div class="col-md-4">
                                <div class="form-group">
                                   <label for="metododepago">Metodo de pago</label>
                                  <select name="mpago" class="form-control">
                                  <option value=""></option>
                                    @foreach ($metodopago as $option)
                                        <option value="{{ $option['id'] }}">{{ $option['nombre'] }}</option>
                                    @endforeach
                                  </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                   <label for="metododepago">articulos</label>
                                  <select name="mpago" class="js-Select2" >
                                  <option value=""></option>
                                   
                                  </select>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div id="newpay" hidden>
                        <form id="newfactur">

                        </form>
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
    <div id="fileModal" class="modal fade modal-basic ajustarmodal" tabindex="-1" aria-labelledby="taskModalLabal"
            aria-hidden="true" data-bs-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ver Archivo</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body viewfile">
                        
                            <iframe id="fileViewer" src=""></iframe>
                      
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="cerrarModal('#fileModal')" class="btn btn-primary revokeURL"
                            data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
    </div>
    <div id="cancelarfactura" class="modal fade modal-basic" tabindex="-1" aria-labelledby="taskModalLabal"
            aria-hidden="true"data-bs-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Registro de Motivos de Cancelación</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                       <form id="cancelarfacturaform">
                            @csrf
                            <input id="factura_id" class="form-control" type="hidden" name="factura_id">
                            <label class="form-control-label" for="text-input">Para cada CFDI que desea cancelar debe capturar el motivo de cancelación</label>
                            <div class="form-group row">
                                
                                <div class="col-12 col-md-8">
                                    <label class="col-12 col-md-12 form-control-label" for="text-input">Motivo de cancelación</label>
                                    <select name="fpago" class="col-12 col-md-12 form-control" required>
                                            <option value="">Seleccione el motivo</option>
                                            <option value="01">01 - Comprobantes emitidos con errores con relación</option>
                                            <option value="02">02 - Comprobantes emitidos con errores sin relación</option>
                                            <option value="03">03 - No se llevó a cabo la operación</option>
                                            <option value="04">04 - Operación nominativa relacionada en una factura global</option>
                                                            
                                    </select>
                                </div>
                                    <div class="col-12 col-md-4">
                                <label class="col-12 col-md-12 form-control-label" for="text-input">Folio Relacionado</label>
                                <input id="foliocancelacion" disabled type="text" value="" class="col-12 col-md-12 form-control">
                                </div>
                            </div>
                       </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="cerrarModal('#cancelarfactura')" class="btn btn-secondary revokeURL"
                         data-dismiss="modal">Cerrar</button>
                         <button type="submit" id="btncancelarf" form="cancelarfacturaform" class="btn btn-danger">Confirmar</button>
                    </div>
                </div>
            </div>
    </div>

</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{asset('js/paginacion.js')}}"></script>
<script>
    function cerrarModal(id) {
        $(id).modal('hide');
    }
    function openwin(){
        var dataUploadElement = document.getElementById('dataupload');
        var newFacturElement = document.getElementById('newfactur');
        var newpayElement = document.getElementById('newpay');
    // Si 'dataupload' está visible, lo ocultamos y mostramos 'newfactur'
    if (newFacturElement.hasAttribute('hidden')) {
        newFacturElement.removeAttribute('hidden'); // Mostramos 'dataupl
        dataUploadElement.setAttribute('hidden', true);
        newpayElement.setAttribute('hidden', true); // Ocultamos 'newfactur'
        
        document.querySelector('.boton1').classList.add('brojo');
        document.querySelector('.boton2').classList.remove('brojo');
        document.querySelector('.nuevafactura').classList.remove('fa-circle-plus');
        document.querySelector('.nuevafactura').classList.add('fa-circle-xmark');
        document.querySelector('.nuevopago').classList.add('fa-circle-plus');
        document.querySelector('.nuevopago').classList.remove('fa-circle-xmark');
    } else {
        document.querySelector('.nuevafactura').classList.add('fa-circle-plus');
        document.querySelector('.nuevafactura').classList.remove('fa-circle-xmark');
        document.querySelector('.boton1').classList.remove('brojo');
        newFacturElement.setAttribute('hidden', true); // Ocultamos 'dataupload'
        dataUploadElement.removeAttribute('hidden'); // Mostramos 'newfactur'
    }
    }
    function openpay(){
        var dataUploadElement = document.getElementById('dataupload');
        var newFacturElement = document.getElementById('newfactur');
        var newpayElement = document.getElementById('newpay');
    
    if (newpayElement.hasAttribute('hidden')) {
        newpayElement.removeAttribute('hidden'); // Mostramos 'dataupload'
        dataUploadElement.setAttribute('hidden', true);
        newFacturElement.setAttribute('hidden', true); // Ocultamos 'newfactur'
        document.querySelector('.boton2').classList.add('brojo');
        document.querySelector('.boton1').classList.remove('brojo');
        document.querySelector('.nuevafactura').classList.add('fa-circle-plus');
        document.querySelector('.nuevafactura').classList.remove('fa-circle-xmark');
        document.querySelector('.nuevopago').classList.remove('fa-circle-plus');
        document.querySelector('.nuevopago').classList.add('fa-circle-xmark');
    } else {
        document.querySelector('.boton2').classList.remove('brojo');
        document.querySelector('.nuevopago').classList.add('fa-circle-plus');
        document.querySelector('.nuevopago').classList.remove('fa-circle-xmark');
        newpayElement.setAttribute('hidden', true); // Ocultamos 'dataupload'
        dataUploadElement.removeAttribute('hidden'); // Mostramos 'newfactur'
    }
    }
    function mostrar(archivo){
        const fileViewer = document.getElementById('fileViewer');
        fileViewer.src = '/facturas/'+archivo;
        $('#fileModal').modal('show');
    }
    function descargar(archivo){
        Swal.fire({
                            icon: "question",
                            text: "¿Estás Seguro De Descargar El Archivo "+archivo+" ?",
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
                                console.log("se debe de descargar el archivo "+ archivo)
                            } else {
                               
                            }
                        });
    }
    
    function cancelarfactura(id,folio) {
        document.getElementById("factura_id").value = id;
        document.getElementById("foliocancelacion").value = folio;

        $('#cancelarfactura').modal('show');
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
                        url: '{{ route('facturacion.obtenerfacturas') }}',
                        success: function(response) {
                            originalelements = elements = response.facturas;
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

                    $('#tablaufacturas tbody').empty();
                    if (paginatedElements.length > 0) {
                        document.getElementById('viewelements').removeAttribute('hidden');
                    } else {
                        document.getElementById('viewelements').setAttribute('hidden', true);
                    }
                    $.each(paginatedElements, function(index, element) {
                        let row = $('<tr>');
                        if(element.acuse){
                            row.append('<td ><div class="Datatable-content-button2">'+
                            '<button class="btn icono" onclick="mostrar(\''+element.pdf+'\')" title="Archivo PDF"><img  src="{{asset('storage/img/iconos/iconopdf.png')}}"alt=""></button>'+
                            '<button class="btn icono2" onclick="mostrar(\''+element.xml+'\')" title="Archivo XML"><img  src="{{asset('storage/img/iconos/iconoxml.png')}}"alt=""></button>'+
                            '<button class="btn btn-danger icono2" onclick="descargar(\''+element.acuse+'\')" title="Acuse"><img  src="{{asset('storage/img/iconos/iconoacuse.png')}}"alt=""></button>'+
                            '</div></td>');
                        }else{
                            row.append('<td ><div class="Datatable-content-button2">'+
                            '<button class="btn icono" onclick="mostrar(\''+element.pdf+'\')" title="Archivo PDF"><img  src="{{asset('storage/img/iconos/iconopdf.png')}}"alt=""></button>'+
                            '<button class="btn icono2" onclick="mostrar(\''+element.xml+'\')" title="Archivo XML"><img  src="{{asset('storage/img/iconos/iconoxml.png')}}"alt=""></button>'+
                            '<button class="btn btn-secondary icono3" onclick="cancelarfactura(\''+element.id+'\',\''+element.folio+'\')" title="Sin Acuse"><i class="fa-solid fa-ban"></i></button>'+
                            '</div></td>');   
                        }
                        row.append('<td><div class="Datatable-content">' + (element.id ? element.id : "Sin id" ) + '</div></td>');
                        row.append('<td><div class="Datatable-content">' + (element.rfc ? element.rfc : "Sin rfc" ) + '</div></td>');
                        row.append('<td><div class="Datatable-content">' + (element.razon_social ? element.razon_social : "Sin razon social" ) + '</div></td>');
                        row.append('<td><div class="Datatable-content">' + (element.folio ? element.folio : "Sin folio" ) + '</div></td>');
                        row.append('<td><div class="Datatable-content">' + (element.total ? element.total : "Sin total" ) + '</div></td>');
                        row.append('<td><div class="Datatable-content">' + (element.created_at ? element.created_at : "Sin fecha" ) + '</div></td>');
                        row.append('<td><div class="Datatable-content">' + (element.movimiento ? element.movimiento : "Sin movimiento" ) + '</div></td>');
                        row.append('<td><div class="Datatable-content">' + (element.estado ? element.estado : "Sin estado" ) + '</div></td>');

                        $('#tablaufacturas tbody').append(row);
                    });
                }
                $('#search').on('input', filtering);
                $('#empresa').change(filtering);
                function filtering() {
                    const empresas = document.getElementById("empresa");
                    let option1 = empresas.value;
                    let empresa = empresas.options[empresas.selectedIndex].text;
                    let search = $('#search').val().toLowerCase();
                    Page = 1
                    console.log(elements)
                    elements = originalelements.filter(function(element) {
                      
                        return (option1 === '' || element.empresa_id == option1) &&
                                (search === '' || element.rfc.toLowerCase().includes(search) || element.folio.toLowerCase().includes(search));
                    });
                    if (elements.length === 0) {
                        document.querySelector('.no-results-message').removeAttribute('hidden');
                        if(search !== '' && option1 === ''){
                            $('#no-results-message').text('No Se Encontraron Facturas Con El RFC O Folio '+ search);
                        }else if(search === '' && option1 !== ''){
                            $('#no-results-message').text('No Se Encontraron Facturas Afiliados A La Empresa '+ empresa);
                        }else{
                            $('#no-results-message').text('No Se Encontraron Facturas Con El RFC O Folio '+search +' Afiliados A La Empresa '+ empresa);
                        }


                    } else {
                        document.querySelector('.no-results-message').setAttribute('hidden',true);
                        $('#no-results-message').text('');
                    }
                    showElements();
                }
                $("#cancelarfacturaform").submit(function(e) {
                    e.preventDefault();
                    $("#cancelarfactura").modal("hide");
                    $("#btncancelarf").attr("disabled", true);
                    let mensaje="¿Estas Seguro de Cancelar la Factura Con El Folio "+document.getElementById("foliocancelacion").value+"?";
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
                                console.log("aqui va la logica para cancelar");
                            
                            } else {
                                $("#cancelarfactura").modal("show");
                                $("#btncancelarf").attr("disabled", false);
                            }
                        });
                });

                $('.js-Select2').select2({
                    placeholder: 'Escribe para buscar...',
                    allowClear: true,
                    minimumInputLength: 0,
                    ajax: {
                        url: '{{ route('facturacion.articulos') }}',
                        dataType: 'json',
                        data: function(params) {
                            var query = {
                                term: params.term,
                            };
                            return query;
                        },
                        delay: 500,
                        processResults: function(data) {
                            console.log(data);
                            return {
                                results: $.map(data, function(item) {
                                    return {
                                        text: item.descripcion,
                                        id: item.id
                                    };
                                })
                            };
                        },
                        cache: true
                    }
                }).on('select2:open', function(e) {
                    selectActivo = $(e.target); // Almacena el select actualmente abierto
                }).on('change', function(e) {
                    selectChange = $(e.target); // Almacena el select actualmente abierto
                });
    });
</script>
      
         
@endsection