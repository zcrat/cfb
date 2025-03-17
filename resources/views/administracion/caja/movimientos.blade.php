@extends ('layouts.admin2')
@section ('contenido')
<main class="main vaniflex vanigrow">
    <div class="container-fluid vaniflex vanigrow">
            <div class="card vanigrow">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i>Caja Movientos
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
                            <div class=" selectconlabel zdmg-r02">
                                        <label for="tipomovimientofilter">Tipo</label>
                                        <select name="tipomovimientofilter" class="form-control"id="tipomovimientofilter">
                                            <option   selected value="">Saldo</option>
                                            <option    value="1">Ingreso</option>
                                            <option value="2">Egreso</option>
                                        </select>
                            </div>
                            <div class="select2conlabel zdrelative">
                        <label>usuario</label>
                        <select required class="form-control" id="usercajafilter" name="usercajafilter">
                            <option value=""></option>
                        </select>
                     
                    </div>
                    <div class=" selectconlabel zdmg-r02">
                       <label for="tipogasto">Fecha Inicio</label>
                       <input name="fechamovimientoinicio" id="fechamovimientoinicio" type="datetime-local" class="form-control">
                    </div><div class=" selectconlabel zdmg-r02">
                       <label for="tipogasto">Fecha Fin</label>
                       <input name="fechamovimientofin" id="fechamovimientofin" type="datetime-local" class="form-control">
                    </div>
                    <div class=" selectconlabel zdmg-r02">
                       <label for="tipogasto">Total</label>
                       <label name="totalizacion" id="totalizacion" type="text" disabled class="form-control">
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
                                <table id="tablamovimientos" class="table table-sm  table-striped">
                                <colgroup>
                                <col class="button_options"> <!-- Columna con ancho fijo del 20% -->
                                    
                                </colgroup>
                                    <thead>
                                        <tr>
                                            <th>N#</th>
                                            <th>Tipo</th>
                                            <th>Usuario</th>
                                            <th>Cantidad</th>
                                            <th>Concepto</th>
                                            <th>Fecha</th>
                                            <th>Acciones</th>
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
   
    @include('modales.Movimientoscaja')
</main>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{asset('js/paginacion.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.6.0/fabric.min.js"></script>
@stack('scripts')
<script>

     $(function() {
        $('#usercajafilter').select2({
            language: { searching: ()=> "Buscando opciones...",noResults: () => "Sin Resultados",},
            placeholder: 'Escribe para buscar...',
            allowClear: true,
            minimumInputLength: 0,
            ajax: {
                url: '/select2/obtenerusuarioscaja',
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
                                text: item.name,
                                id: item.id
                            };
                        })
                    };
                },
                cache: true
            }
        });
        
        window.limpiarmodaliye = function() {
            $("#newmovimientocaja").find(".error-message").remove();
            $('#newmovimientocaja input').not('input[name="_token"]').val('').trigger('change');
            $('#newmovimientocaja select').val('').trigger('change'); 
            $('#verarchivosmovimiento').attr('hidden',true); 
            $('#movimientoscajamodal').modal('show');  
        }
        window.editmovimientocaja = function(id) {
            $.ajax({
                url: '{{route('administracion.caja.movimiento.get')}}',
                type: "GET",
                data:{
                    id:id,
                },
                success: function(response) {
                    data=response.data
                    archivos=response.archivos
                    console.log(response)
                    $('#newmovimientocaja input').not('input[name="_token"]').val('').trigger('change');
                    $('#verarchivosmovimiento').attr('hidden',true); 
                    $('#newmovimientocaja select').val('').trigger('change'); 
                    $("#newmovimientocaja").find(".error-message").remove();
                    $('#idmovimiento').val(data.id)
                    $('#conceptomovimiento').val(data.descripcion)
                    $('#cantidadmovimiento').val(data.cantidad)
                    $('#fechamovimiento').val(data.fecha)
                    $('#tipogasto').val(data.movimiento_id)
                    $("#Useridmovimineto").append('<option value="' + response.user.id + '">' + response.user.name + '</option>');
                    $("#Useridmovimineto").val(response.user.id).trigger('change');
                    $("#archivosmovimientocaja").attr('hidden',true)
                    $("#archivogrande").attr('hidden',true)
                    $("#archivosmovimientocaja").empty();
                    $("#archivogrande").empty();
                    archivos.forEach(function(archivo) {
                        $("#archivosmovimientocaja").removeAttr('hidden')
                        let ext=archivo.archivo.split('.')[1].toLowerCase();
                        console.log(ext)
                        switch (ext) {
                            case 'jpg':
                            case 'jpeg':
                            case 'png':
                            case 'gif':
                                tipoArchivo ='<div class="zdflex zdjc-center zdfd-column"><button type="button" class="boton-imagen zdmg-r02 zdw-r4 zdmnw-r4 zdh-r4" onclick="viewarchivo(\''+archivo.archivo+'\')"title='+archivo.archivo+'>'+
                                                '<img  src="/storage/documentos/caja/movimientos/'+archivo.archivo+'"  class="zdw-100pct zdh-100pct"></img>'+
                                            '</button>'+
                                            '<button type="button" class="eliminar-imagen" onclick="deletearchivomovimientocaja(\''+archivo.id+'\')"title=Eliminar '+archivo.archivo+'>Eliminar</button></div>'
                                break;
                            case 'pdf':
                                tipoArchivo ='<div class="zdflex zdjc-center zdfd-column"><button type="button"  class="boton-imagen zdmg-r02 zdw-r3 zdmnw-r3 zdh-r4" onclick="viewarchivo(\''+archivo.archivo+'\')"title='+archivo.archivo+'>'+
                                                '<img  src="{{asset('storage/iconos/pdf1.png')}}"alt=""  class="zdw-100pct zdh-100pct"></img>'+
                                            '</button>'+
                                             '<button type="button" class="eliminar-imagen" onclick="deletearchivomovimientocaja(\''+archivo.id+'\')"title=Eliminar '+archivo.archivo+'>Eliminar</button></div>'
                                break;
                            case 'doc':
                            case 'docx':
                                tipoArchivo ='<div class="zdflex zdjc-center zdfd-column"><button type="button"  class="boton-imagen zdmg-r02 zdw-r3 zdmnw-r3 zdh-r4" onclick="viewarchivo(\''+archivo.archivo+'\')"title='+archivo.archivo+'>'+
                                            '<img  src="{{asset('storage/iconos/DOC.png')}}"alt=""  class="zdw-100pct zdh-100pct"></img>'+
                                            '</button>'+
                                              '<button type="button" class="eliminar-imagen" onclick="deletearchivomovimientocaja(\''+archivo.id+'\')"title=Eliminar '+archivo.archivo+'>Eliminar</button></div>'
                                break;
                            case 'xls':
                            case 'xlsx':
                                tipoArchivo ='<div class="zdflex zdjc-center zdfd-column"><button type="button"  class="boton-imagen zdmg-r02 zdw-r3 zdmnw-r3 zdh-r4" onclick="viewarchivo(\''+archivo.archivo+'\')"title='+archivo.archivo+'>'+
                                            '<img  src="{{asset('storage/iconos/xlsx.png')}}"alt=""  class="zdw-100pct zdh-100pct"></img>'+
                                            '</button>'+
                                              '<button type="button" class="eliminar-imagen" onclick="deletearchivomovimientocaja(\''+archivo.id+'\')"title=Eliminar '+archivo.archivo+'>Eliminar</button></div>'
                                break;
                            case 'xml':
                                tipoArchivo ='<div class="zdflex zdjc-center zdfd-column"><button type="button"  class="boton-imagen zdmg-r02 zdw-r3 zdmnw-r3 zdh-r4" onclick="viewarchivo(\''+archivo.archivo+'\')"title='+archivo.archivo+'>'+
                                            '<img  src="{{asset('storage/iconos/XML.png')}}"alt=""  class="zdw-100pct zdh-100pct"></img>'+
                                            '</button>'+
                                            '<button type="button" class="eliminar-imagen" onclick="deletearchivomovimientocaja(\''+archivo.id+'\')"title=Eliminar '+archivo.archivo+'>Eliminar</button></div>'
                                break;
                            // case 'mp3':
                            // case 'wav':
                            //     tipoArchivo ='<button type="button" class="btn btn-warning" onclick="viewarchivo('+archivo.archivo+')"title='+archivo.archivo+'>'+
                            //                     '<img  src="/storage/documentos/caja/movimientos/'+archivo.archivo+'"  class="mimagen" hidden></img>'+
                            //                 '</button>'
                            //     break;
                            case 'mp4':
                            case 'avi':
                            case 'mov':
                                tipoArchivo ='<div class="zdflex zdjc-center zdfd-column"><button type="button"  class="boton-imagen zdmg-r02 zdw-r6 zdmnw-r6 zdh-r4" onclick="viewarchivo(\''+archivo.archivo+'\')"title='+archivo.archivo+'>'+
                                                '<video id="video_preview"  src="/storage/documentos/caja/movimientos/'+archivo.archivo+'"  class="zdw-100pct zdh-100pct"</video> '+
                                            '</button>'+
                                            '<button type="button" class="eliminar-imagen" onclick="deletearchivomovimientocaja(\''+archivo.id+'\')"title=Eliminar '+archivo.archivo+'>Eliminar</button></div>'
                                break;
                            default:
                            tipoArchivo ='<div class="zdflex zdjc-center zdfd-column"><button type="button" class="btn btn-warning" onclick="viewarchivo('+archivo.archivo+')"title='+archivo.archivo+'>'+
                                                '<img  src= src="{{asset('storage/iconos/desconocido.png')}}"  class="mimagen" hidden></img>'+
                                            '</button>'+
                                            '<button type="button" class="eliminar-imagen" onclick="deletearchivomovimientocaja(\''+archivo.id+'\')"title=Eliminar '+archivo.archivo+'>Eliminar</button></div>'
                        }
                        $("#archivosmovimientocaja").append(tipoArchivo);
                    });



                    $('#movimientoscajamodal').modal('show');
                },
                error: function(xhr, status, error) {
                    if(xhr.status===422){
                        Swal.fire({ title: 'Error', html: `Detalles del error:<br>${xhr.responseJSON.error}`, icon: 'error'});
                        searchdata();
                    }else{
                        let errorMessage = 'Intentelo de nuevo, si el error persiste contacte a Soporte.';
                        Swal.fire({ title: 'Error', html: `${errorMessage}<br>Detalles del error: ${error}<br>${status} : ${xhr.status}`, icon: 'error'});
                    }
                }
            });
        }
        window.deletemovimientocaja = function(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Eliminara este Movimiento de Forma Permanente",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, Eliminarlo'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{route('administracion.caja.movimiento.delete')}}",
                            type: "post",
                            data:{
                                "_token": "{{ csrf_token() }}",
                                id:id,
                            },
                            success: function(response) {
                                Swal.fire({ html: `Se Elimino Correctamente`, icon: 'success',showConfirmButton: false,timer: 2000,});
                                executeSearchdata()
                            },
                            error: function(xhr, status, error) {
                            if(xhr.status===499){
                                Swal.fire({ title: 'Error', html: `Detalles del error:<br>${xhr.responseJSON.error}`, icon: 'error'});
                            }else if(xhr.status===422){
                                Swal.fire({ title: 'Error', html: `Verifique Los datos:<br>${xhr.responseJSON.error}`, icon: 'error'});
                            }else{
                                let errorMessage = 'Intentelo de nuevo, si el error persiste contacte a Soporte.';
                                Swal.fire({ title: 'Error', html: `${errorMessage}<br>Detalles del error: ${error}<br>${status} : ${xhr.status}`, icon: 'error'});
                            }
                            }
                        });
                    } 
                });  
        }
        window.deletearchivomovimientocaja = function(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Eliminara El Archivo de Forma Permanente",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, Eliminarlo'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{route('administracion.caja.movimiento.archivo.delete')}}",
                            type: "post",
                            data:{
                                "_token": "{{ csrf_token() }}",
                                id:id,
                            },
                            success: function(response) {
                                Swal.fire({ html: `Se Elimino Correctamente`, icon: 'success',showConfirmButton: false,timer: 2000,});
                                editmovimientocaja(response.idmovimiento)
                            },
                            error: function(xhr, status, error) {
                            if(xhr.status===499){
                                Swal.fire({ title: 'Error', html: `Detalles del error:<br>${xhr.responseJSON.error}`, icon: 'error'});
                            }else if(xhr.status===422){
                                Swal.fire({ title: 'Error', html: `Verifique Los datos:<br>${xhr.responseJSON.error}`, icon: 'error'});
                            }else{
                                let errorMessage = 'Intentelo de nuevo, si el error persiste contacte a Soporte.';
                                Swal.fire({ title: 'Error', html: `${errorMessage}<br>Detalles del error: ${error}<br>${status} : ${xhr.status}`, icon: 'error'});
                            }
                            }
                        });
                    } 
                });  
        }
        let elements = [];
        let originalelements = [];

       
        function searchdata() {
            document.getElementById('loadingdata').removeAttribute('hidden');
            document.getElementById('dataupload').setAttribute('hidden', true);
            $.ajax({
                type: 'GET',
                url: '{{ route('administracion.caja.movimiento.get') }}',
                success: function(response) {
                    console.log(response)
                    originalelements = elements = response.movimientos;
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
        executeSearchdata();
        window.executedelete = function(id) {
            eval("recepciondelete("+id+")");
        };
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
            $('#tablamovimientos tbody').empty();
            if (paginatedElements.length > 0) {
                document.getElementById('viewelements').removeAttribute('hidden');
            } else {
                document.getElementById('viewelements').setAttribute('hidden', true);
            }
            
            $.each(paginatedElements, function(index, element) {
                let row = $('<tr class="zdrelative">');
                row.append('<td><div class="">' + (element.id ? element.id : "Sin N#" ) + '</div></td>');
                row.append('<td><div class="">' + (element.tipomovimiento ? element.tipomovimiento.descripcion : "Sin # Seguimiento")+ '</div></td>');
                row.append('<td><div class="">' + (element.usuarios ? element.usuarios.name : "Usuario") + '</div></td>');
                row.append('<td><div class="">' +  Number((element.cantidad ? element.cantidad : "")).toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 })+ '</div></td>');
                row.append('<td><div class="">' + (element.descripcion ? element.descripcion : "No Se Registro") + '</div></td>');
                row.append('<td><div class="">' + (element.fecha ? element.fecha : "Sin fecha") + '</div></td>');
                row.append('<td><div class="">'+
                '<button type="button" class="btn btn-warning" onclick="editmovimientocaja('+element.id+')"title="Boton de Cancelar Factura">'+
                    '<i aria-hidden="true" class="fa fa-pencil-square-o"></i>'+
                '</button>'+
                '<button type="button" class="btn btn-danger" onclick="deletemovimientocaja('+element.id+')"title="Boton de Cancelar Factura">'+
                    '<i aria-hidden="true" class="fa-solid fa-trash"></i>'+
                '</button>'+
                '</div></td></tr>');
                ;
                $('#tablamovimientos tbody').append(row);
            });
        }
        $('#search').on('input', filtering);
        $('#tipomovimientofilter').on('change', filtering);
        $('#usercajafilter').on('change', filtering);
        $('#fechamovimientoinicio').on('change', filtering);
        $('#fechamovimientofin').on('change', filtering); 
                    
        function filtering() { 
            let search = $('#search').val().toLowerCase();
            let tipo = $('#tipomovimientofilter').val();
            let user=$('#usercajafilter').val();
            let fecha1=$('#fechamovimientoinicio').val();
            let fecha2=$('#fechamovimientofin').val();
            Page = 1
            let total=0
           
            elements = originalelements.filter(function(element) {
                console.log(new Date(fecha1));
                console.log(new Date(element.fecha));
                return (
                    (search === '' || element.descripcion.toLowerCase().includes(search)) && 
                    (tipo === '' || element.movimiento_id == tipo) &&
                    (user === '' || element.user_id == user) &&
                    (fecha2 === '' || new Date(element.fecha) <= new Date(fecha2))  &&
                    (fecha1 === '' || new Date(element.fecha) >= new Date(fecha1))
                );
            });
            elements.forEach(movimiento => {
                    if (movimiento.tipomovimiento.id === 1) { // Suponiendo que '1' es 'Ingreso'
                        total += movimiento.cantidad; // Sumar la cantidad si es ingreso
                    } else {
                        total -= movimiento.cantidad; // Restar la cantidad si no es ingreso
                    }
                });

                $('#totalizacion').text(Number(total).toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 }))
            if (elements.length === 0) {
                document.querySelector('.no-results-message').removeAttribute('hidden');
                $('#no-results-message').text('No Se Encontraron Movimientos');

            } else {
                
                document.querySelector('.no-results-message').setAttribute('hidden',true);
                $('#no-results-message').text('');
            }
            showElements();
        
        }

        window.viewarchivo=function (archivo){
            let ext=archivo.split('.')[1].toLowerCase();
            $("#archivogrande").attr('hidden',true)
            $("#archivogrande").empty();
            switch (ext) {
                            case 'jpg':
                            case 'jpeg':
                            case 'png':
                            case 'gif':
                                tipoArchivo ='<img  src="/storage/documentos/caja/movimientos/'+archivo+'"  class="zdmw-100pct"></img>'
                                $("#archivogrande").removeAttr('hidden')
                                break;
                            case 'pdf':
                                tipoArchivo ='<iframe src="/storage/documentos/caja/movimientos/'+archivo+'" class="zdw-100pct zdmnh-r40" frameborder="0">'+
                                                    +'Tu navegador no soporta iframes.'+
                                                +'</iframe>'
                                                $("#archivogrande").removeAttr('hidden')
                                break;
                            case 'doc':
                            case 'docx':
                                tipoArchivo ='<iframe src="/storage/documentos/caja/movimientos/'+archivo+'" class="zdw-100pct zdmnh-r40" frameborder="0">'+
                                                    +'Tu navegador no soporta iframes.'+
                                                +'</iframe>'
                                break;
                            case 'xls':
                            case 'xlsx':
                                tipoArchivo ='<iframe src="/storage/documentos/caja/movimientos/'+archivo+'" class="zdw-100pct zdmnh-r40" frameborder="0">'+
                                                    +'Tu navegador no soporta iframes.'+
                                                +'</iframe>'
                                break;
                            case 'xml':
                                tipoArchivo ='<iframe src="/storage/documentos/caja/movimientos/'+archivo+'" class="zdw-100pct zdmnh-r40" frameborder="0">'+
                                                    +'Tu navegador no soporta iframes.'+
                                                +'</iframe>'
                                break;
                            // case 'mp3':
                            // case 'wav':
                            //     tipoArchivo ='<button type="button" class="btn btn-warning" onclick="viewarchivo('+archivo.archivo+')"title='+archivo.archivo+'>'+
                            //                     '<img  src="/storage/documentos/caja/movimientos/'+archivo.archivo+'"  class="mimagen" hidden></img>'+
                            //                 '</button>'
                            //     break;
                            case 'mp4':
                            case 'avi':
                            case 'mov':
                                tipoArchivo = '<video id="video_preview"  src="/storage/documentos/caja/movimientos/'+archivo+'" class="zdmw-100pct"  controls></video>'
                                $("#archivogrande").removeAttr('hidden')
                                break;
                            default:
                            tipoArchivo ='<h5>El Archivo Que Se Eligio No Se puede Mostrar</h5>'
                        }

                        
                        $("#archivogrande").append(tipoArchivo);
                        
                        
        }
    });
</script>
@endsection