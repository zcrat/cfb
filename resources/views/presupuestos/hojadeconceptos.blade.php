@extends ('layouts.admin2')
@section ('contenido')

<main class="main">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body mycard" >
                <div class="dataupload" id="dataupload">
                    <div class="d-flex superior">
                    <button type="button" class="btn btn-primary"><i class="fa-solid fa-circle-plus"></i>&nbsp;Agregar</button>
                    <button type="button" class="btn"><i class="fa-solid fa-bars"></i>&nbsp;Conceptos</button>
                    </div>
                    <div class="viewelements" id="viewelements">
                        <div>
                            <div class="mismall">
                                <small>RR:</small>
                                <select class="rr-select2"name="rr" id="rr">
                                    <option value="">Seleccione Para Comenzar</option>
                                </select>
                            </div>
                            <div class="mismall"><small>Nombre:</small><input id="nombre" type="text" disabled="disabled"></div> 
                            <div class="mismall"><small>#Economico:</small><input id="economico" type="text" disabled="disabled"></div>
                            <div class="mismall"><small>Odes:</small><input id="odes" type="text" disabled="disabled"></div>
                            <div class="mismall"><small>Id:</small><input id="id" type="text" disabled="disabled"></div>
                            <div class="mismall"><small>Tecnico:</small><input id="tecnico" type="text" disabled="disabled"></div>
                            <div class="mismall"><small>Año:</small><input id="anio" type="text" disabled="disabled"></div>
                            <div class="mismall"><small>Marca:</small><input id="marca" type="text" disabled="disabled"></div>
                            <div class="mismall"><small>Modelo:</small><input id="modelo" type="text" disabled="disabled"></div>
                            <div class="mismall"><small>Color:</small><input id="color" type="text" disabled="disabled"></div>
                            <div class="mismall"><small>Placas:</small><input id="placas" type="text" disabled="disabled"></div>
                            <div class="mismall"><small>Km:</small><input id="km" type="text" disabled="disabled"></div>
                            <div class="mismall"><small>VIN:</small><input id="vin" type="text" disabled="disabled"></div>
                            
                            
                        </div>
                        <div class="mitabla">
                         <table class="table table-striped">
                            <cologroup>
                                <col class="colum_piezas">
                            </cologroup>
                            <thead>
                                <tr>
                                    <th>N#</th>
                                    <th>Clave</th>
                                    <th>Descripcion</th>
                                    <th>Partes</th>
                                    <th>Mano de Obra</th>
                                    <th>Subcontratado</th>
                                    <th>Otros</th>
                                    <th>Subtotal Costos</th>
                                    <th>Precio De Venta</th>
                                </tr>
                            </thead>
                            <tbody> </tbody>
                         </table>
                        </div>
                    </div>
                </div>
                <div  class="no-results-message" hidden>
                    <span id="no-results-message"></span>
                </div>
                <div id='loadingdata' class="carga" hidden>
                    <h3 class="text-center m-2">Cargando Datos</h3>
                    <div class="spinnerp"></div>
                </div>
            </div>
        </div>
    </div>
    
</main>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$('.rr-select2').select2({
            placeholder: 'Escribe para buscar...',
            allowClear: true,
            minimumInputLength: 0,
            ajax: {
                url: '{{ route('select2.rr') }}',
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
                                text: item.folioNum,
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
$('#rr').change(function(){
$.ajax({
    type:'GET',
    url:"{{route('vales.rr')}}",
    data:{
        id: $(this).val(),
    },
    success:function(response){
        console.log(response)
        
       $('#nombre').val(response.empresa.nombre)
       $('#economico').val(response.vehiculo.no_economico)
       $('#odes').val(response.orden_seguimiento)
       $('#id').val(response.id)
       $('#tecnico').val(response.tecnico ? response.tecnico : "Sin Tecnico" )
       $('#anio').val(response.vehiculo.anio)
       $('#marca').val(response.vehiculo.marca.nombre)
       $('#modelo').val(response.vehiculo.modelo.nombre)
       $('#color').val(response.vehiculo.color.nombre)
       $('#placas').val(response.vehiculo.placas)
       $('#km').val(response.km_entrada)
       $('#vin').val(response.vehiculo.vim)
    },
    error:function(xhr, status, error){
        console.error(xhr);
    }

})
});
</script>
@endsection