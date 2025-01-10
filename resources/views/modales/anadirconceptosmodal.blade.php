
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
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Selecciona</th>
                                <th>Codigo</th>
                                <th>Cantidad</th>
                                <th>descripcion</th>
                                <th>total</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary regresarmodal2">Cerrar</button>
                    <button type="button" class="btn btn-primary">Agregar</button>
                </div>
            </div>
        </div>
    </div>
@push('scripts')
<script>
    $(function(){
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
    });
</script>
@endpush

