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
                        <div class="dataconcept">
                            <div class="mismall">
                                <small>RR:</small>
                                <select class="rr-select2"name="rr" id="rr">
                                    <option value="">Seleccione Para Comenzar</option>
                                </select>
                            </div>
                            <div class="mismall"><small>Nombre:</small><label id="nombre" ></label></div> 
                            <div class="mismall"><small>#Economico:</small><label id="economico" ></label></div>
                            <div class="mismall"><small>Odes:</small><label id="odes" ></label></div>
                            <div class="mismall"><small>Id:</small><label id="id" ></label></div>
                            <div class="mismall"><small>Tecnico:</small><label id="tecnico" ></label></div>
                            <div class="mismall"><small>Año:</small><label id="anio" ></label></div>
                            <div class="mismall"><small>Marca:</small><label id="marca" ></label></div>
                            <div class="mismall"><small>Modelo:</small><label id="modelo" ></label></div>
                            <div class="mismall"><small>Color:</small><label id="color" ></label></div>
                            <div class="mismall"><small>Placas:</small><label id="placas" ></label></div>
                            <div class="mismall"><small>Km:</small><label id="km" ></label></div>
                            <div class="mismall"><small>VIN:</small><label id="vin" ></label></div>
                            
                            
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
        
       $('#nombre').text(response.empresa.nombre)
       $('#economico').text(response.vehiculo.no_economico)
       $('#odes').text(response.orden_seguimiento)
       $('#id').text(response.id)
       $('#tecnico').text(response.tecnico ? response.tecnico : "Sin Tecnico" )
       $('#anio').text(response.vehiculo.anio)
       $('#marca').text(response.vehiculo.marca.nombre)
       $('#modelo').text(response.vehiculo.modelo.nombre)
       $('#color').text(response.vehiculo.color.nombre)
       $('#placas').text(response.vehiculo.placas)
       $('#km').text(response.km_entrada)
       $('#vin').text(response.vehiculo.vim)
    },
    error:function(xhr, status, error){
        console.error(xhr);
    }

})
});
</script>
@endsection