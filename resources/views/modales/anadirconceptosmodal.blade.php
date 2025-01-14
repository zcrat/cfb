
    <div class="modal fade" id="agregarconceptos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar Conceptos</h5>
                    <button type="button" class="btn-close regresarmodal2" >
                    </button>
                </div>
                <div class="modal-body">
                <div class="vaniflex zdjc-between">
                    <div class="select2conlabel zdw-30pct zdrelative">
                        <label>Categoria</label>
                        <select  id="Categoriaconceptos2_Select2"name="Categoriaconceptos2_Select2">
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="select2conlabel zdrelative zdw-30pct">
                        <label>Tipos</label>
                        <select  id="Tiposconceptos2_Select2"name="Tiposconceptos2_Select2">
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="iconoin zdmgr-r05 zdw-30pct">
                        <input class="misearch zdw-100pct"
                            type="text" id="searchservicio" name="searchservicio"
                            placeholder="Buscar por descripcion" >
                            <i class="fa fa-search" aria-hidden="true"></i>&nbsp;
                    </div>
                </div>
                <div id='pagination2'></div>
                <div id="lista" hidden>
                    <table id="tablaproductoslista" class="table table-sm  table-striped">
                        <thead>
                            <tr>
                                <th>Check</th>
                                <th>Descripcion</th>
                                <th>Cantidad</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div id='listacarga' class="carga" >
                            <h3 class="text-center m-2">Cargando Datos</h3>
                            <div class="spinnerp"></div>
                        </div>
                        <div  class="no-results-message2" hidden>
                        <span id="no-results-message2"></span>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary regresarmodal2">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="agregarconceptosalista">Agregar</button>
                </div>
            </div>
        </div>
    </div>
@push('scripts')

<script src="{{asset('js/paginacion2.js')}}"></script>
<script>
    $(function(){
        let productosSeleccionados= new Map();
        window.agregarconceptos= function(){
            $.ajax({
            type: 'GET',
            url: '{{ route('2025.cfe.obtener.catalogoproductosyservicios') }}',
            data:{
                modulo: @json($modulo),
            },
            success: function(response) {
                console.log(response)
                $("#recepcionservicioyconceptos").modal("hide");
                $("#agregarconceptos").modal("show");
            },
            error: function(xhr, status, error) {
                console.error(xhr);
            }
        }); 
        }
        $('#Tiposconceptos2_Select2').select2({
            language: { searching: ()=> "Buscando opciones...",noResults: () => "Sin Resultados",},
            dropdownParent: $("#agregarconceptos"),
            placeholder: 'Escribe para buscar...',
            allowClear: true,
            minimumInputLength: 0,
            ajax: {
                url: '/select2/obtenertiposcatalogo',
                dataType: 'json',
                data: function(params) {
                    var query = {
                        term: params.term,
                        modulo: @json($modulo),
                    };
                    return query;
                },
                delay: 500,
                processResults: function(data) {
                    console.log(data);
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.tipo,
                                id: item.id
                            };
                        })
                    };
                },
                cache: true
            }
        });
        $('#Categoriaconceptos2_Select2').select2({
            language: { searching: ()=> "Buscando opciones...",noResults: () => "Sin Resultados",},
            dropdownParent: $("#agregarconceptos"),
            placeholder: 'Escribe para buscar...',
            allowClear: true,
            minimumInputLength: 0,
            ajax: {
                url: '/select2/obtenercategoriacatalogo',
                dataType: 'json',
                data: function(params) {
                    var query = {
                        term: params.term,
                        modulo: @json($modulo),
                    };
                    return query;
                },
                delay: 500,
                processResults: function(data) {
                    console.log(data);
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.titulo,
                                id: item.id
                            };
                        })
                    };
                },
                cache: true
            }
        });

        $(".regresarmodal2").on('click',function(){
            $("#agregarconceptos").modal('hide')
            $("#recepcionservicioyconceptos").modal('show')
        });
        $('#agregarconceptos').on('shown.bs.modal', function (){
            searchdata();
            let elements=[];
            let originalelements=[];
            productosSeleccionados= new Map();
                function searchdata() {
                    document.getElementById('listacarga').removeAttribute('hidden');
                    document.getElementById('lista').setAttribute('hidden', true);
                    $.ajax({
                        type: 'GET',
                        url: '{{ route('2025.cfe.obtener.catalogoproductosyservicios') }}',
                        data:{
                            modulo:@json($modulo)
                        },
                        success: function(response) {
                            console.log(response);
                            originalelements = elements = response.conceptos;
                            document.getElementById('listacarga').setAttribute('hidden', true);
                            document.getElementById('lista').removeAttribute('hidden');
                            filtering();
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr);
                        }
                    });
                }
                function filtering() {
                    let search = $('#searchservicio').val().toLowerCase();
                    let categoria = $('#Categoriaconceptos2_Select2').val();
                    let tipos = $('#Tiposconceptos2_Select2').val();
                    Page2 = 1
                    console.log(originalelements)
                    elements = originalelements.filter(function(element) {
                      
                        return (categoria === '' || element.categoria == categoria) && (tipos === '' || element.tipo == tipos) && (search === '' || element.descripcion.toLowerCase().includes(search));
                    });
                    if (elements.length === 0) {
                        document.querySelector('.no-results-message2').removeAttribute('hidden');
                            $('#no-results-message2').text('No Se Encontraron Conceptos');
                    } else {
                        document.querySelector('.no-results-message2').setAttribute('hidden',true);
                        $('#no-results-message2').text('');
                    }

                    showElements();
                }
                window.executeshowElements2 = function() {
                    eval("showElements()");
                };
                function showElements() {
    
                    ShowPagination2(elements.length,5,10);
                    let startIndex = (Page2 - 1) * itemsPerPage;
                    let endIndex = startIndex + itemsPerPage;
                    let paginatedElements = elements.slice(startIndex, endIndex);
                    
                    $('#tablaproductoslista tbody').empty();
                    $.each(paginatedElements, function(index, element) {
                        let row = $('<tr>'); 
                        row.append('<td><input type="checkbox" class="concepto" data-id="'+element.id+'" data-descripcion="'+element.descripcion+'" title="Agregar" ' + (productosSeleccionados.has(element.id) ? 'checked' : '') + '></td>');
                        row.append('<td><div class="Datatable-content">' + (element.descripcion ? element.descripcion : "Sin descripcion" ) + '</div></td>');
                        row.append('<td><div class="Datatable-content"><input type="number" class="cantidad" data-id="'+element.id+'"></input></div></td>');
                        row.append('<td><div class="Datatable-content"><input type="number" class="precio" data-id="'+element.id+'"></input></div></div></td>');

                        $('#tablaproductoslista tbody').append(row);
                    });
                    $('#searchservicio').on('input', filtering);
                    $('#Categoriaconceptos2_Select2 , #Tiposconceptos2_Select2').on('change', filtering);
                }
                $(document).on('change', '.concepto', function () {
                    let id = $(this).data('id');
                    let descripcion = $(this).data('descripcion')
                    let cantidad = $(`.cantidad[data-id="${id}"]`).val();
                    let precio = $(`.precio[data-id="${id}"]`).val(); // Obtener el valor del checkbox
                    if ($(this).is(':checked')) { // Verificar si el checkbox está marcado
                        productosSeleccionados.set(id, {
                            id: id,
                            descripcion:descripcion,
                            cantidad: parseFloat(cantidad) || 0, // Parsear cantidad como número
                            precio: parseFloat(precio) || 0      // Parsear precio como número
                        });
                    } else {
                        // Eliminar producto del mapa
                        productosSeleccionados.delete(id);
                    }
                    console.log(Array.from(productosSeleccionados.values()));
                });
                $(document).on('input', '.precio, .cantidad', function () {
                    let id = $(this).data('id');
                    let descripcion = $(`.concepto[data-id="${id}"]`).data('descripcion')
                    let cantidad = parseFloat($(`.cantidad[data-id="${id}"]`).val()) || 0;
                    let precio = parseFloat($(`.precio[data-id="${id}"]`).val()) || 0;
                    console.log(precio,cantidad)
                    if (productosSeleccionados.has(id)) {

                        productosSeleccionados.set(id, { 
                            id: id,
                            descripcion:descripcion,
                            cantidad: cantidad,
                            precio: precio
                        });
                    }
                    console.log(Array.from(productosSeleccionados.values()));
                });

            });
            $("#agregarconceptosalista").on('click',function(){
                actualizartablaconceptos(productosSeleccionados)
                $(".regresarmodal2").trigger('click')
            });
    });
</script>
@endpush

