@extends ('layouts.admin2')
@section ('contenido')
<main class="main vaniflex vanigrow">
    <div class="container-fluid vaniflex vanigrow">
            <div class="card vanigrow">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i>Catalogo Coceptos
                    <button type="button"  class="boton1" onclick="limpiarmodaliye()">
                        <i class="fa-solid fa-circle-plus"></i>&nbsp;Nuevo
                    </button>
                    <div id="submenu"></div>
                </div>
                <div class="card-body mycard ">
                    <div class="vaniwidth vaniflex zdfd-column" id="dataupload" >
                        <div class="d-flex">
                            <div class="iconoin zdmgr-r05">
                                <input class="misearch zdw-r15"
                                    type="text" id="search" name="s"
                                    placeholder="Busqueda Por Concepto" >
                                    <i class="fa fa-search" aria-hidden="true"></i>&nbsp;
                            </div>
                            <div class="selectconlabel zdmgx-r02 zdw-70pct"> 
                                <label>AÑO</label>
                                    <select  class="form-control"  id="aniofilter">
                                        <option value="">Todos</option>
                                        <option value="2">2024</option>
                                        <option value="3">2025</option>
                                    </select>
                                </div>
                            <div class="selectconlabel zdmgx-r02 zdw-70pct"> 
                                <label>Tipo de Contrato</label>
                                    <select  class="form-control"  id="modulofilter">
                                        <option value="">Todos</option>
                                        <option value="1">CFE GASOLINA</option>
                                        <option value="2">CFE DIESEL</option>
                                    </select>
                                </div>
                                
                            <div class="selectconlabel zdmgx-r02 zdw-70pct"> 
                                <label>Tipo de Concepto</label>
                                <select  class="form-control"  id="contratofilter">
                                    <option value="">Todos</option>
                                    <option value="2">MORELIA</option>
                                    <option value="3">JIQUILPAN</option>
                                    <option value="4">ZACAPU</option>
                                    <option value="5">BAJIO</option>
                                    <option value="6">DIVISINALES</option>
                                    <option value="7">ECO</option>
                                    <option value="9">APATZINGAN</option>
                            </select>
                            </div>
                            <div class="selectconlabel zdmgx-r02 zdw-70pct"> 
                                <label>Vehiculo</label>
                                <select required id="Tiposconceptos_Select2filter">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="viewelements vanigrow vaniflex zdfd-column" id="viewelements">
                            <div class="elementosporpagina">
                                <select   class="rounded" id="epp">
                                <option value="21" >21</option>
                                    @for ($i = 15; $i <= $elementostotales/3; $i += 5)
                                        <option value="{{ $i }}" >{{ $i }}</option>
                                    @endfor
                                </select>
                                <div id='pagination'></div>
                            </div>
                            <div id='cardstable' class="vanigrow vaniflex zdfd-column">
                                
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
   
    @include('modales.conceptoglogalmodal')
</main>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{asset('js/paginacion.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.6.0/fabric.min.js"></script>
@stack('scripts')
<script>
    $(function(){
        $('#Tiposconceptos_Select2filter').select2({
            language: { searching: ()=> "Buscando opciones...",noResults: () => "Sin Resultados",},
            placeholder: 'Escribe para buscar...',
            allowClear: true,
            minimumInputLength: 0,
            ajax: {
                url: '/select2/obtenertiposcatalogo/filter',
                dataType: 'json',
                data: function(params) {
                    var query = {
                        term: params.term,
                        modulo: $('#modulofilter').val(),
                        contrato: $('#contratofilter').val(),
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
        let elements = [];
        let originalelements = [];

        function searchdata() {
            document.getElementById('loadingdata').removeAttribute('hidden');
            document.getElementById('dataupload').setAttribute('hidden', true);
            $.ajax({
                type: 'GET',
                url: '{{ route('obtener.administracion.catalogos.conceptospresupuestos') }}',
                success: function(response) {
                    console.log(response)
                    originalelements = elements = response.Conceptos;
                    console.log(response)
                    document.getElementById('loadingdata').setAttribute('hidden', true);
                    document.getElementById('dataupload').removeAttribute('hidden');
                    filtering()
                    //showElements()
                },
                error: function(xhr, status, error) {
                    console.error(xhr);
                }
            });
        }
        window.executeSearchdata = function() {
            eval("searchdata()");
        };
        executeSearchdata();
        window.executeshowElements = function() {
            eval("showElements()");
        };
        function showElements() {
            ShowPagination(elements.length,8);
            console.log('se hace filtro');
            let startIndex = (Page - 1) * itemsPerPage;
            let endIndex = startIndex + itemsPerPage;
            console.log(itemsPerPage)
            let paginatedElements = elements.slice(startIndex, endIndex);
            console.log(elements)
            $('#cardstable').empty();
            if (paginatedElements.length > 0) {
                document.getElementById('viewelements').removeAttribute('hidden');
            } else {
                document.getElementById('viewelements').setAttribute('hidden', true);
            }
                let table = $('<div class="tablacard vanigrow">');
            $.each(paginatedElements, function(index, element) {
                let row = $('<div class="cardelement ">');
                row.append('<label class="zdbold">' + (element.descripcion ? element.descripcion : 'Nulo') + '</label>');
                row.append('<label>' + (element.categoria ? element.categoria.titulo : 'Nulo') + '</label>');
                row.append('<label>' + (element.contrato ? element.contrato.nombre : 'Nulo') + '</label>');
                row.append('<label>' + ((element.anio ? element.anio.descripcion : '0000')+'  '+(element.num ? element.num : 'FC')+'  '+(element.modulo ? element.modulo.descripcion : '---' )) + '</label>');
                row.append('<label>' + (element.tipo_vehiculo ? element.tipo_vehiculo.tipo : 'Nulo') + '</label>');
                row.append('<label>' + (element.codigo_sat ? element.codigo_sat : 'Nulo') + '</label>');
                row.append('<label>' + ((element.unidad_text ? element.unidad_text : 'Nulo')+'  '+(element.codigo_unidad ? element.codigo_unidad : '' )) + '</label>');
                row.append('<label>Total: ' + (element.p_total ? element.p_total : 'Nulo') + '</label>');
                row.append(`<div class="zdrelative"><button type="button"class="opcionesdesplegables btn  btn-primary ">Opciones</button><ul class="detallesdesplegables ajustedeposicionmenudespleglaple zdw-r12" hidden>
                        <li><a href="#" onclick="executeeliminarconcepto(`+element.id+`)" ">Eliminar</a></li>
                        <li><a href="#" onclick="executeeditarconcepto(`+element.id+`)">Editar</a></li>
                    </ul></div>`);
                table.append(row);
            });
            $('#cardstable').append(table);
        }
        $('#search').on('input', filtering);
        $('#modulofilter').on('change', filtering);
        $('#contratofilter').on('change', filtering);
        $('#Tiposconceptos_Select2filter').on('change', filtering);
        $('#aniofilter').on('change', filtering);
        function filtering() { 
            let search = $('#search').val().toLowerCase();
            let modulo = $('#modulofilter').val();
            let contrato = $('#contratofilter').val();
            let vehiculo = $('#Tiposconceptos_Select2filter').val();
            let anio = $('#aniofilter').val();
            Page = 1
            let total=0
           
            elements = originalelements.filter(function(element) {
               
                return (
                    (search === '' || element.descripcion.toLowerCase().includes(search))&&
                    (modulo === '' || element.CFE_id == modulo) &&
                    (contrato === '' || element.contrato_id == contrato) &&
                    (vehiculo === '' || element.pCFETipos_id == vehiculo) &&
                    (anio === '' || element.id_anio_correspondiente == anio) 
                );
            }); 
            if (elements.length === 0) {
                document.querySelector('.no-results-message').removeAttribute('hidden');
                $('#no-results-message').text('No Se Encontraron Conceptos');

            } else {
                
                document.querySelector('.no-results-message').setAttribute('hidden',true);
                $('#no-results-message').text('');
            }
            showElements();
        
        }
        $(document).on('click', '.opcionesdesplegables', function(event) {
            event.stopPropagation(); 
            if( $(this).next().attr('hidden')){
                $(".detallesdesplegables").attr('hidden',true)
                $(this).next().removeAttr('hidden');
            }else{
                $(".detallesdesplegables").attr('hidden',true)
            }
            

        });
        $(document).on('click', function() {
            $(".detallesdesplegables").attr('hidden',true)
        });
        window.executeeliminarconcepto = (id)=>{
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "Una vez eliminado, no podrás recuperar este concepto.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminarlo'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{route('administracion.catalogos.concepto.delete')}}",
                            type: "DELETE",
                            data:{
                                "_token": "{{ csrf_token() }}",
                                id:id,
                            },
                            success: function(response) {
                                Swal.fire('Éxito', 'El Concepto Fue Eliminado Correctamente', 'success');
                                executeSearchdata();
                            },
                            error: function(xhr, status, error) {
                            if(xhr.status===499){
                                Swal.fire({ title: 'Error', html: `Detalles del error:<br>${xhr.responseJSON.error}`, icon: 'error'});
                            }else{
                                let errorMessage = 'Intentelo de nuevo, si el error persiste contacte a Soporte.';
                                Swal.fire({ title: 'Error', html: `${errorMessage}<br>Detalles del error: ${error}<br>${status} : ${xhr.status}`, icon: 'error'});
                            }
                            }
                        });
                    } 
                });
            }
            window.limpiarmodaliye = function() {
            $("#nuevosconceptos").find(".error-message").remove();
            $('#nuevosconceptos input').not('input[name="_token"]').val('').trigger('change');
            $('#nuevosconceptos select').val('').trigger('change'); 
            $('#nuevosconceptos').modal('show');  
        }
        window.executeeditarconcepto = (id)=>{
            $.ajax({
                url: "{{route('obtener.administracion.catalogo.concepto')}}",
                type: "get",
                data:{
                    id:id,
                },
                success: function(response) {
                    
                    let concepto=response.success;
                    $('#modulo').val(concepto.CFE_id).trigger('change');
                    $('#contrato').val(concepto.contrato_id).trigger('change');
                    $('#pmo').val(concepto.p_mo);
                    $('#prefaccion').val(concepto.p_refaccion).trigger('change');
                    $('#unidadconcepto').val(concepto.id_unidad).trigger('change');
                    $('#cod').val(concepto.num);
                    $('#tiempo').val(concepto.tiempo);
                    $('#recepcionservicio select').val('').trigger('change');
                    $("#ncsatcde").val(concepto.codigo_sat)
                    $("#descripcionconcepto").val(concepto.descripcion)
                    $("#anioconcepto").val(concepto.id_anio_correspondiente)
                    $("#idconcepto").val(concepto.id)
                    $("#miModalLabel").text('Editar Concepto')

                    $("#Categoriaconceptos_Select2").append('<option value="' + concepto.pCFECategorias_id + '">' + concepto.categoria+'</option>');

                    $("#Tiposconceptos_Select2").append('<option value="' + concepto.pCFETipos_id + '">' + concepto.vehiculo + '</option>');

                    $("#Conceptos_Select2").append('<option value="' + concepto.tipoconcepto + '">' + concepto.tipoconceptodescripcion + '</option>');
                    $('#Categoriaconceptos_Select2').val(concepto.pCFECategorias_id).trigger('change');
                    $('#Tiposconceptos_Select2').val(concepto.pCFETipos_id).trigger('change');
                    $('#Conceptos_Select2').val(concepto.tipoconcepto).trigger('change');
                    $('#nuevosconceptos').modal('show');  
                    console.log('kaszjfclkjsdj');
                },
                error: function(xhr, status, error) {
                if(xhr.status===499){
                    Swal.fire({ title: 'Error', html: `Detalles del error:<br>${xhr.responseJSON.error}`, icon: 'error'});
                }else{
                    let errorMessage = 'Intentelo de nuevo, si el error persiste contacte a Soporte.';
                    Swal.fire({ title: 'Error', html: `${errorMessage}<br>Detalles del error: ${error}<br>${status} : ${xhr.status}`, icon: 'error'});
                }
                }
            });
            }
            window.limpiarmodaliye = function() {
            $("#nuevosconceptos").find(".error-message").remove();
            $('#nuevosconceptos input').not('input[name="_token"]').val('').trigger('change');
            $('#nuevosconceptos select').val('').trigger('change'); 
            $('#nuevosconceptos textarea').val(''); 
            $('#nuevosconceptos').modal('show');  
        }
    })
</script>
@endsection