@extends ('layouts.admin2')
@section ('contenido')

<main class="main vaniflex vanigrow">
    <div class="container-fluid vaniflex vanigrow">
            <div class="card vanigrow">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i>Talleres Externos
                    <button type="button"  class="boton1" data-bs-toggle="modal" onclick="limpiarmodaltalleres()" data-bs-target="#recepcionservicio">
                        <i class="fa-solid fa-circle-plus"></i>&nbsp;Nueva
                    </button>
                    <div id="submenu"></div>
                </div>
                <div class="card-body mycard ">
                    <div class="vaniwidth vaniflex zdfd-column" id="dataupload" >
                        <div class="d-flex">
                            <div class="iconoin zdmgr-r05">
                                <input class="misearch zdw-r29"
                                    type="text" id="search" name="s"
                                    placeholder="Busqueda Por Folio, Marca, Modelo, Vin, Economico, etc" >
                                    <i class="fa fa-search" aria-hidden="true"></i>&nbsp;
                            </div>
                            <div class="zdflex">
                            <select name="estatus" class="form-control" id="estatus">
                                <option value="">Todos</option>
                                <option value="0">Sin Enviar</option>
                                <option value="1">Pendientes</option>
                                <!-- <option value="2">Finales</option>
                                <option value="3">Autorizacion En Proceso</option> -->
                                <option value="4">Terminados</option>
                            </select>
                            
                            </div>
                        </div>
                        <div class="viewelements vanigrow vaniflex zdfd-column" id="viewelements">
                            <div class="elementosporpagina">
                                <select   class="rounded" id="epp">
                                <option value="10" >10</option>
                                    @for ($i = 15; $i <= $elementostotales/3; $i += 5)
                                        <option value="{{ $i }}" >{{ $i }}</option>
                                    @endfor
                                </select>
                                <div id='pagination'></div>
                            </div>
                            <div class="mitabla vanigrow vaniflex zdfd-column">
                                <table id="tablarecepciones" class="table table-sm  table-striped">
                                <colgroup>
                                <col class="button_options"> <!-- Columna con ancho fijo del 20% -->
                                    
                                </colgroup>
                                    <thead>
                                        <tr>
                                            <th>OPCIONES</th>
                                            <th>FOLIO</th>
                                            <th>ECONOMICO</th>
                                            <th>MARCA</th>
                                            <th>MODELOS</th>
                                            <th>AÑO</th>
                                            <th>PLACAS</th>
                                            <th>VIN</th>
                                            <th>FECHA</th>
                                            <th>ESTADO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
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
    @include('modales.subidaarchivos')
    @include('modales.recepcionservicio')
    @include('modales.recepcionservicioyconceptos')
    @include('modales.Mensajemodal')
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{asset('js/paginacion.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.6.0/fabric.min.js"></script>
@stack('scripts')
<script>


     $(function() {
        window.limpiarmodaltalleres = function() {
            $("#formnewrecepcion").find(".error-message").remove();
            $('#recepcionservicio input').not('input[name="_token"]').val('');
            $('#recepcionservicio textarea').val('');
            $('#recepcionservicio select').val('').trigger('change');;  // O puedes usar $('#RecepcionVehicular select').prop('selectedIndex', -1);
            
        }
        window.editarecepciontaller = function(id) {
            
            console.log(id);
        }
function recepciondelete(id) {
    let ruta = "{{ route('2025.cfe.recepcion.delete') }}";
    Swal.fire({
        icon: "question",
        text: "¿Estás seguro de eliminar la recepción?",
        showCancelButton: true,
        confirmButtonText: "Confirmar",
        cancelButtonText: "Cancelar",
        reverseButtons: true,
        customClass: {
            confirmButton: "btn-primary",
            cancelButton: "btn-light",
        },
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: ruta,
                method: "POST",
                data: { id: id, _token: "{{ csrf_token() }}" },
                success: function (data) {
                    if (data === "eliminado") {
                        Swal.fire({
                            icon: "success",
                            title: "Recepción eliminada correctamente",
                            showConfirmButton: false,
                            timer: 2000,
                        });
                        searchdata();
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            html: data,
                        });
                    }
                },
                error: function (error) {
                    console.log(error)
                    if (error.status === 422) {
                        Swal.fire({
                            icon: "warning",
                            title:error.responseJSON.error,
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Ocurrió un error inesperado. Por favor, inténtalo nuevamente.",
                        });
                    }
                },
            });
        }
    });
}
                let elements = [];
                let originalelements = [];
                const modulo = @json($modulo);
                const anio = @json($anio);
                const contrato = @json($contrato);
                searchdata();
                function searchdata() {
                    document.getElementById('loadingdata').removeAttribute('hidden');
                    document.getElementById('dataupload').setAttribute('hidden', true);
                    $.ajax({
                        type: 'GET',
                        url: '{{ route('2025.cfe.obtener.talleres') }}',
                        data:{
                            modulo:modulo,
                            anio:anio,
                            contrato:contrato,
                        },
                        success: function(response) {
                            console.log(response)
                            originalelements = elements = response.recepciones;
                            document.getElementById('loadingdata').setAttribute('hidden', true);
                            document.getElementById('dataupload').removeAttribute('hidden');
                            filtering()
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr);
                        }
                    });
                }
                window.executeSearchdata = function() {
                    eval("searchdata()");
                };
                
                window.executedelete = function(id) {
                    eval("recepciondelete("+id+")");
                };
                window.executeshowElements = function() {
                    eval("showElements()");
                };
                window.executereporte = function(id) {
                    eval("reporte("+id+")");
                };
                window.executeservicio = function(id) {
                    $('#recepcionservicio').modal("show");
                };
                function reporte(id){
                    window.open('/recepcion/reporte/'+ id,'_blank');
                };
                function showElements() {
                    ShowPagination(elements.length,8);
                    console.log(Page);
                    let startIndex = (Page - 1) * itemsPerPage;
                    let endIndex = startIndex + itemsPerPage;
                    console.log(itemsPerPage)
                    let paginatedElements = elements.slice(startIndex, endIndex);
                    console.log(paginatedElements)
                    $('#tablarecepciones tbody').empty();
                    if (paginatedElements.length > 0) {
                        document.getElementById('viewelements').removeAttribute('hidden');
                    } else {
                        document.getElementById('viewelements').setAttribute('hidden', true);
                    }
                    $.each(paginatedElements, function(index, element) {
                        let row = $('<tr class="zdrelative"><td><div class="Datatable-content" ></div></td></tr>');
                        let acciones =`<td><div class="Datatable-content ">`;
                        acciones+=`<div class="zdrelative zdinline"><button type="button" class="btn btn-warning btn-sm zdrelative" title="Mesajes" onclick="openmessagemodal(`+element.id+`)">
                            <i class="fa fa-comment-alt"></i>
                            </button>`+(element.mensajes ?`<p class="notificationcount">`+element.mensajes+`</p></div>` : `</div>`);
                        let dropdownContent = ``
                        if (element.status == 5) {
                            dropdownContent = `
                            <button type="button"class="opcionesdesplegables btn  btn-primary ">Opciones</button>
                            <ul class="detallesdesplegables zdw-r12"" hidden>
                                <li><a href="#" class="reportevehicular" data-nrv="`+element.NSolicitud+`">Recepción Vehicular</a></li>
                                <li><a href="#" onclick="historialarchivos(`+element.id+`, 'Fotos Viejas')">Fotos Viejas</a></li>
                                <li><a href="#" class="presupuestopdf" data-id="`+element.id+`">Presupuesto</a></li>
                                <li><a href="#" class="presupuestoacusepdf" data-id="`+element.id+`">Presupuesto Acuse</a></li>
                                <li><a href="#" onclick="historialarchivos(`+element.id+`, 'Reporte Anomalías')">Reporte Anomalías</a></li>
                                <li><a href="#" onclick="historialarchivos(`+element.id+`, 'Entrada')">Entrada</a></li>
                                <li><a href="#" onclick="historialarchivos(`+element.id+`, 'Orden Servicio')">Orden Servicio</a></li>
                                <li><a href="#" onclick="historialarchivos(`+element.id+`, 'Fotos Nuevas')">Fotos Nuevas</a></li>
                                <li><a href="#" onclick="historialarchivos(`+element.id+`, 'Fotos Instaladas')">Fotos Instaladas</a></li>
                                <li><a href="#" onclick="executesubirarchivo(`+element.id+`, 'Factura PDF')">Factura PDF</a></li>
                                <li><a href="#" onclick="executesubirarchivo(`+element.id+`, 'Factura XML')">Factura XML</a></li>
                                <li><a href="#" onclick="executesubirarchivo(`+element.id+`, 'Acuse')">Acuse</a></li>
                        `;
                        }else{
                            dropdownContent = `
                            <button type="button"class="opcionesdesplegables btn  btn-primary ">Opciones</button>
                            <ul class="detallesdesplegables zdw-r12"" hidden>
                                <li><a href="#" onclick="executedeletepresupuestos(`+element.id+`)" ">Eliminar</a></li>
                                <li><a href="#" onclick="executeagregarservicio2(`+element.id+`)">Editar</a></li>
                                <li><a href="#" class="reportevehicular" data-nrv="`+element.NSolicitud+`">Recepción Vehicular</a></li>
                                <li><a href="#" onclick="executesubirarchivo(`+element.id+`, 'Fotos Viejas')">Fotos Viejas</a></li>
                                <li><a href="#" class="presupuestopdf" data-id="`+element.id+`">Presupuesto</a></li>
                                <li><a href="#" class="presupuestoacusepdf" data-id="`+element.id+`">Presupuesto Acuse</a></li>
                                <li><a href="#" onclick="executesubirarchivo(`+element.id+`, 'Reporte Anomalías')">Reporte Anomalías</a></li>
                                <li><a href="#" onclick="executesubirarchivo(`+element.id+`, 'Entrada')">Entrada</a></li>
                                <li><a href="#" onclick="executesubirarchivo(`+element.id+`, 'Orden Servicio')">Orden Servicio</a></li>
                        `;
                        }
                        
                        if (element.status == 3 || element.status == 4) {
                            dropdownContent += `
                                <li><a href="#" onclick="executesubirarchivo(`+element.id+`, 'Fotos Nuevas')">Fotos Nuevas</a></li>
                                <li><a href="#" onclick="executesubirarchivo(`+element.id+`, 'Fotos Instaladas')">Fotos Instaladas</a></li>
                                <li><a href="#" onclick="executesubirarchivo(`+element.id+`, 'Factura PDF')">Factura PDF</a></li>
                                <li><a href="#" onclick="executesubirarchivo(`+element.id+`, 'Factura XML')">Factura XML</a></li>
                                <li><a href="#" onclick="executesubirarchivo(`+element.id+`, 'Acuse')">Acuse</a></li>
                            `;
                        }
                        
                        if (element.status == 0) {
                             acciones += `
                            
                                 <button type="button" class="btn btn-warning" onclick="executecambiostatus(`+element.id+`,1)"title="Boton de terminar">
                                    Enviar
                                    </button>
                            `;
                        }
                        if (element.status <= 3 && element.status>0 ) {
                             acciones += `
                            
                                 <button type="button" class="btn btn-secondary" title="Boton de terminar">
                                    PENDIENTE
                                    </button>
                            `;
                        }
                        // if (element.status == 3) {
                        //     //cambia a estatus 4
                        //      acciones += `
                        //          <button type="button" class="btn btn-warning" title="Boton de terminar" >
                        //             Cerrar
                        //             </button>
                        //     `;
                        // }
                        if (element.status > 3) {
                             acciones += `
                                 <button type="button" class="btn btn-success" title="Boton de autorizar">
                                    TERMINADO
                                    </button> 
                            `;
                        }
   
                        dropdownContent += `</ul>`;
                        acciones += `</div></td></tr>`;
                        row.find('.Datatable-content').append(dropdownContent);
                        row.append('<td><div class="">' + (element.NSolicitud ? element.NSolicitud : "Sin Folio" ) + '</div></td>');
                        row.append('<td><div class="">' + (element.identificador ? element.identificador : "Sin # Seguimiento")+ '</div></td>');
                        row.append('<td><div class="">' + (element.marca ? element.marca : "marca") + '</div></td></tr>');
                        row.append('<td><div class="">' + (element.modelo ? element.modelo : "Sin Modelo") + '</div></td></tr>');
                        row.append('<td><div class="">' + (element.ano ? element.ano : "No Se Registro") + '</div></td></tr>');
                        row.append('<td><div class="">' + (element.placas ? element.placas : "Sin Placas") + '</div></td></tr>');
                        row.append('<td><div class="">' + (element.vin ? element.vin : "No Se Registro") + '</div></td></tr>');
                        row.append('<td><div class="">' + (element.created_at ? element.created_at : "No Se Registro") + '</div></td></tr>');
                        row.append(acciones);
                       ;
                        $('#tablarecepciones tbody').append(row);
                    });recepciondelete
                }
                $('#search').on('input', filtering);
                $('#estatus').on('change', filtering);
    
                function filtering() { 
                    let search = $('#search').val().toLowerCase();
                    let estatus = $('#estatus').val();
                    Page = 1
                        elements = originalelements.filter(function(element) {
                        elementestatus=0;
                        if (element.status <= 3 && element.status>0 ) {
                            elementestatus=1;
                        }
                        if (element.status > 3) {
                            elementestatus=4;
                        }
                        console.log(elementestatus);
                        return ((search === '' || 
                            element.NSolicitud.toLowerCase().includes(search) || 
                            element.placas.toLowerCase().includes(search) || 
                            element.identificador.toLowerCase().includes(search) ||
                            element.vin.toLowerCase().includes(search) ||
                            element.marca.toLowerCase().includes(search) ||
                            element.modelo.toLowerCase().includes(search))&&(estatus===''|| elementestatus==estatus))

                        });
                    if (elements.length === 0) {
                        document.querySelector('.no-results-message').removeAttribute('hidden');
                        $('#no-results-message').text('No Se Encontraron Resultados Con Folio, Economico, Placas, Vin, Modelos o Marca Que Coincidan Con  '+search );
                        
                    } else {
                        document.querySelector('.no-results-message').setAttribute('hidden',true);
                        $('#no-results-message').text('');
                    }
                    showElements();
                
            }
        $(document).on('click', '.opcionesdesplegables', function(event) {
            event.stopPropagation(); 
            $(".detallesdesplegables").attr('hidden',true)
            $(this).next().removeAttr('hidden');
        });
        $(document).on('click', function() {
            $(".detallesdesplegables").attr('hidden',true)
        });
        $(document).on('click', '.reportevehicular', function(){
            const Nsolicitud=$(this).attr("data-nrv");
            console.log(Nsolicitud);
            $.ajax({
                url: "{{route('2025.cfe.obtener.idrecepcion')}}",
                type: "get",
                data:{
                    folionum:Nsolicitud,
                },
                success: function(response) {
                    var respuesta = response.id;
                    window.open('/recepcion/reporte/storage/'+ respuesta,'_blank');
                },
                error: function(xhr, status, error) {
                    if(xhr.status===499){
                        let errorMessage = 'Verifique Los Datos';
                        Swal.fire({ title: 'Error', html: `${errorMessage}<br>Detalles del error:<br>${xhr.responseJSON.error}`, icon: 'error'});
                    }else{
                        let errorMessage = 'Intentelo de nuevo, si el error persiste contacte a Soporte.';
                        Swal.fire({ title: 'Error', html: `${errorMessage}<br>Detalles del error: ${error}<br>${status} : ${xhr.status}`, icon: 'error'});
                    }
                }
            })
        });
        $(document).on('click', '.presupuestopdf', function(){
            const id=$(this).attr("data-id");
            window.open('/ordenes/pdf/'+ id,'_blank');
        });
        window.executedeletepresupuestos = (id) => { // Tu código aquí };
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Una vez eliminado, No lo podras revertir",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarlo',
                cancelButtonText: 'No, Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{route('2025.cfe.delete.presupuesto')}}",
                        type: "DELETE",
                        data:{
                            "_token": "{{ csrf_token() }}",
                            id:id,
                        },
                        success: function(response) {
                            console.log(response);
                            const mensaje=response.success
                            Swal.fire({ html: `${mensaje}`, icon: 'success',showConfirmButton: false,timer: 2000,});
                            executeSearchdata()
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr);
                            if(xhr.status===499){
                                let errorMessage = 'Verifique Los Datos';
                                Swal.fire({ title: 'Error', html: `${errorMessage}<br>Detalles del error:<br>${xhr.responseJSON.error}`, icon: 'error'});
                                executeSearchdata();
                            }else{
                                let errorMessage = 'Intentelo de nuevo, si el error persiste contacte a Soporte.';
                                Swal.fire({ title: 'Error', html: `${errorMessage}<br>Detalles del error: ${error}<br>${status} : ${xhr.status}`, icon: 'error'});
                            }
                        }
                    });
                }
            });
        }
        $(document).on('click', '.presupuestoacusepdf', function(){
            const id=$(this).attr("data-id");
            window.open('/ordenes/pdfAcuse/'+ id,'_blank');
        });
        window.executecambiostatus = (id,status)=>{
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Se Cambiara el estaus del presupuesto a pendiente ",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, Enviarlo'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{route('2025.cfe.cambiar.estatus.presupuesto')}}",
                        type: "post",
                        data:{
                            "_token": "{{ csrf_token() }}",
                            id:id,
                            estatus:status,
                        },
                        success: function(response) {
                            Swal.fire({ html: `${mensaje}`, icon: 'success',showConfirmButton: false,timer: 2000,});
                            executeSearchdata()
                        },
                        error: function(xhr, status, error) {
                            if(xhr.status===499){
                                Swal.fire({ title: 'Error', html: `Detalles del error:<br>${xhr.responseJSON.error}`, icon: 'error'});
                                executeSearchdata();
                            }else{
                                let errorMessage = 'Intentelo de nuevo, si el error persiste contacte a Soporte.';
                                Swal.fire({ title: 'Error', html: `${errorMessage}<br>Detalles del error: ${error}<br>${status} : ${xhr.status}`, icon: 'error'});
                            }
                        }
                    });
                } else {
                    
                }
            });
        }
        window.executesubirarchivo=(id,origen)=>{
            console.log(origen)
            $('#img_preview').attr('src',"");
            $('#img_preview').attr('hidden',true);
            $('#pdf_preview').attr('src',"");
            $('#pdf_preview').attr('hidden',true);
            $('#video_src_preview').attr('src',"");
            $('#video_preview')[0].load();
            $('#video_preview').attr('hidden',true);
            $('#text_preview').attr('hidden',true);
            $('#subida_archivos').attr('data-origen',origen);
            $('#subida_archivos').attr('data-id',id);
            $('#Historial_archivos').attr('data-id',id);
            $('#Historial_archivos').attr('data-origen',origen);
            $('#archivotitle').text('Agregar '+ origen);
            $('#subidaarchivos').modal('show');
        }
        window.historialarchivos=(id,origen)=>{
            $.ajax({
                url: "{{route('2025.cfe.obtener.archivo')}}",
                type: "get",
                data:{
                    id:id,
                    origen:origen
                },
                success: function(response) {
                    var respuesta = response.src;
                    if(origen=="Fotos Viejas"){
                        ruta = '/storage/documentos/fotosviejas/';
                    }else if (origen=="Reporte Anomalías") {
                        ruta = '/storage/documentos/reporteanomalias/';
                    }else if (origen=="Entrada") {
                        ruta = '/storage/documentos/entradas/';
                    }else if (origen=="Orden Servicio") {
                        ruta = '/storage/documentos/ordenservicio/';
                    }else if (origen=="Fotos Nuevas") {
                        ruta = '/storage/documentos/fotosnuevas/';
                    }else if (origen=="Fotos Instaladas") {
                        ruta = '/storage/documentos/fotosinstaladas/';
                    }else if (origen=="Factura PDF") {
                        ruta = '/storage/documentos/facturaspdf/';
                    }else if (origen=="Factura XML") {
                        ruta = '/storage/documentos/facturasxml/';
                    }else if (origen=="Acuse") {
                        ruta = '/storage/documentos/acuse/';
                    } else{
                        $conmodelo=false;
                    }
                    if(response)
                    window.open(ruta + respuesta,'_blank');
                },
                error: function(xhr, status, error) {
                    if(xhr.status===499){
                        Swal.fire({ title: 'Error', html: `Detalles del error:<br>${xhr.responseJSON.error}`, icon: 'error'});
                    }else{
                        let errorMessage = 'Intentelo de nuevo, si el error persiste contacte a Soporte.';
                        Swal.fire({ title: 'Error', html: `Detalles del error: ${error}<br>${status} : ${xhr.status}`, icon: 'error'});
                    }
                }
            })
        }
        window.openmessagemodal=(id)=>{
            $('#presupuesto_id').val(id);
            $.ajax({
                        url: "{{route('2025.presupuesto.get.messages')}}",
                        type: "get",
                        data:{
                            presupuesto:$('#presupuesto_id').val(),
                        },
                        success: function(response) {
                            $('#tablemessage').empty();
                            $.each(response.success, function(index, element) {
                                let row = $('<div class="zdflex zdmg-r05 zditemscenter">');
                                row.append('<div class="zdmgl-r05"><label class="zdbold zdblock">' + (element.mensaje ? element.mensaje : 'Nulo') + '</label>'+
                                '<label>' + (element.created_at ? element.created_at : 'Nulo') + ' &nbsp&nbsp&nbsp</label>'+
                                '<label>' + (element.usuarios ? element.usuarios.name : 'Nulo') + '</label></div>')
                                $('#tablemessage').append(row);
                            });
                            $('#messagemodal').modal('show');
                        },
                        error: function(xhr, status, error) {
                            let errorMessage = 'Intentelo de nuevo, si el error persiste contacte a Soporte.';
                            console.log(xhr)
                            Swal.fire({
                                title: 'Error',
                                html: `${errorMessage} ${xhr.responseJSON ? `<br>Detalles del error:<br>${xhr.responseJSON.error}`:``}`,
                                icon: 'error'
                                });

                        }
                    });
           
        }
        $('#Historial_archivos').on('click',function(){
            let origen=$(this).attr('data-origen')
            let id=$(this).attr('data-id')
            $.ajax({
                url: "{{route('2025.cfe.obtener.archivo')}}",
                type: "get",
                data:{
                    id:id,
                    origen:origen
                },
                success: function(response) {
                    var respuesta = response.src;
                    if(origen=="Fotos Viejas"){
                        ruta = '/storage/documentos/fotosviejas/';
                    }else if (origen=="Reporte Anomalías") {
                        ruta = '/storage/documentos/reporteanomalias/';
                    }else if (origen=="Entrada") {
                        ruta = '/storage/documentos/entradas/';
                    }else if (origen=="Orden Servicio") {
                        ruta = '/storage/documentos/ordenservicio/';
                    }else if (origen=="Fotos Nuevas") {
                        ruta = '/storage/documentos/fotosnuevas/';
                    }else if (origen=="Fotos Instaladas") {
                        ruta = '/storage/documentos/fotosinstaladas/';
                    }else if (origen=="Factura PDF") {
                        ruta = '/storage/documentos/facturaspdf/';
                    }else if (origen=="Factura XML") {
                        ruta = '/storage/documentos/facturasxml/';
                    }else if (origen=="Acuse") {
                        ruta = '/storage/documentos/acuse/';
                    } else{
                        $conmodelo=false;
                    }
                    if(response)
                    window.open(ruta + respuesta,'_blank');
                },
                error: function(xhr, status, error) {
                    if(xhr.status===499){
                        Swal.fire({ title: 'Error', html: `Detalles del error:<br>${xhr.responseJSON.error}`, icon: 'error'});
                    }else{
                        let errorMessage = 'Intentelo de nuevo, si el error persiste contacte a Soporte.';
                        Swal.fire({ title: 'Error', html: `Detalles del error: ${error}<br>${status} : ${xhr.status}`, icon: 'error'});
                    }
                }
            })
        })
    });
</script>
@endsection