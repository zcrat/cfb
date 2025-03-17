<div class="modal fade" id="movimientoscajamodal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Cabecera del Modal -->
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nueva Operacion</h5>
                <button type="button" class="btn-close"  data-bs-dismiss="modal"></button>
            </div>
            <form id="newmovimientocaja">
                @csrf
                <input name="idmovimiento" id="idmovimiento" type="hidden" >
                <div class="modal-body">
                    <div class=" selectconlabel zdmg-r02">
                       <label for="tipogasto" >Tipo de Movimiento</label>
                       <select name="tipogasto" class="form-control" id="tipogasto">
                        <option   selected value="1">Ingreso</option>
                        <option value="2">Egreso</option>
                       </select>
                       
                    </div>
                    <div class=" selectconlabel zdmg-r02">
                       <label for="tipogasto">Fecha</label>
                       <input name="fechamovimiento" id="fechamovimiento" type="datetime-local" class="form-control">
                    </div>
                    <div class=" selectconlabel zdmg-r02">
                       <label for="tipogasto">Concepto</label>
                       <input name="conceptomovimiento" id="conceptomovimiento" type="text" class="form-control">
                    </div>
                    <div class=" selectconlabel zdmg-r02">
                       <label for="tipogasto">Cantidad</label>
                       <input name="cantidadmovimiento" id="cantidadmovimiento" min='0' step="0.01" type="number" class="form-control">
                    </div>
                    <div class="select2conlabel zdrelative">
                        <label>usuario</label>
                        <select required class="form-control" id="Useridmovimineto" name="Useridmovimineto">
                            <option value=""></option>
                        </select>
                        <button class="btnin zdabsolute" id="newusermovimiento" name="newusermovimiento" type="button">+</button>
                        </div>
                    <div class="zdmg-r02 zdflex zdscroll-y zdmw-r30" id='archivosmovimientocaja' hidden></div>
                    <div class="zdmg-r02 zdw-r30 zdmw-r30" id='archivogrande' hidden>

                    </div>
                    <div class=" selectconlabel zdmg-r02">
                        <label for="newmarca">Nuevo Archivo<strong>*</strong></label>
                        <input id="nuevo_archivo" class="form-control" type="file"  name="nuevo_archivo">
                    </div>
                    <div class="logos zdmg-r02 zdw-r30 zdmw-r30">
                        <iframe id="pdf_preview" src="#"  class="mimagen" hidden></iframe>
                        <img id="img_preview" src="#"  class="mimagen" hidden></img>
                        <video id="video_preview" class="mimagen" hidden controls> 
                            <source id="video_src_preview" src="" type="video/mp4"> Tu navegador no soporta la etiqueta de video. 
                        </video>
                        <h5 id="text_preview" hidden>El Archivo Que Se Eligio No Se uede Mostrar</h5>
                    </div>
                    </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" id="MovimientoGuardar" class="btn btn-primary">Guardar</button>
                    <button type="button" id="verarchivosmovimiento" class="btn btn-primary" hidden>Ver archivos</button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('modales.nuevousuariocaja')
@push('scripts')
<script>
$(function(){
    $('#nuevo_archivo').change(function(){ 
        const file = this.files[0]; // Obtén el primer archivo seleccionado
          $('#img_preview').attr('src',"");
          $('#img_preview').attr('hidden',true);
          $('#pdf_preview').attr('src',"");
          $('#pdf_preview').attr('hidden',true);
          $('#video_src_preview').attr('src',"");
          $('#video_preview')[0].load();
          $('#video_preview').attr('hidden',true);
          $('#text_preview').attr('hidden',true);
          
    if (file) {
      let fileType = file.type;

        const reader = new FileReader();
        reader.readAsDataURL(file); // Lee el archivo como una URL de datos
        reader.onload = function(e) {
          
          if (fileType.startsWith('image/')) { 
           $('#img_preview').attr('src',e.target.result)
           $('#img_preview').removeAttr('hidden');}

          else if (fileType === 'application/pdf') {
             $('#pdf_preview').attr('src',e.target.result)
             $('#pdf_preview').removeAttr('hidden');} 

          else if (fileType.startsWith('video/')){ 
            console.log(e.target.result)
           $('#video_src_preview').attr('src',e.target.result)
           $('#video_preview')[0].load();
           $('#video_preview').removeAttr('hidden'); } 
          else { 
           $('#text_preview').removeAttr('hidden');
        }
      }
    }

    })
        $('#Useridmovimineto').select2({
            language: { searching: ()=> "Buscando opciones...",noResults: () => "Sin Resultados",},
            dropdownParent: $("#movimientoscajamodal"),
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
        $("#newusermovimiento").on('click',()=>{
            $("#movimientoscajamodal").modal('hide');
            $("#newusercajamodal").modal('show');
        })
        $(".closenewusercaja").on('click',()=>{
            $("#newusercajamodal").modal('hide');
            $("#movimientoscajamodal").modal('show');
        })
        $("#saveclosenewusercaja").on('click',()=>{
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Tendras Un Nuevo Usuario Para Asignar Gastos",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, Guardarlo'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{route('administracion.caja.movimiento.new.user')}}",
                            type: "post",
                            data:{
                                "_token": "{{ csrf_token() }}",
                                newusercaja:$('#newusercaja').val(),
                            },
                            success: function(response) {
                                $(".closenewusercaja").trigger('click');
                            },
                            error: function(xhr, status, error) {
                                
                            if(xhr.status===499){
                                Swal.fire({ title: 'Error', html: `Detalles del error:<br>${xhr.responseJSON.errors}`, icon: 'error'});
                            }else if(xhr.status===422){
                                $("#movimientoscajamodal").find(".error-message").remove();
                                    let errors = error.responseJSON.errors;
                                    let errorMessages = Object.values(errors)
                                        .map((msgs) => msgs.join("<br>"))
                                        .join("<br>");
                                    for (let field in errors) {
                                        let input = $("#movimientoscajamodal").find(`[name="${field}"]`);
                                        let errorMessage =
                                            `<small class="text-danger error-message">${errors[field].join("<br>")}</small>`;
                                        input.after(errorMessage);
                                    }
                                Swal.fire({ title: 'Error', html: `Verifique Los datos:<br>${xhr.responseJSON.errors}`, icon: 'error'});
                            }else{
                                let errorMessage = 'Intentelo de nuevo, si el error persiste contacte a Soporte.';
                                Swal.fire({ title: 'Error', html: `${errorMessage}<br>Detalles del error: ${error}<br>${status} : ${xhr.status}`, icon: 'error'});
                            }
                            }
                        });
                    } 
                });
        })
        
        $("#newmovimientocaja").submit(function(e) {
            e.preventDefault();
            let ruta= "{{route('administracion.caja.movimiento.create')}}";
            let data= new FormData(this);
            let id=$("#idmovimiento").val().trim();
            if(id){
                console.log("es una actualizacion");
                ruta= "{{route('administracion.caja.movimiento.update')}}"}else{
                console.log("no es una actualizacion");
            }
            Swal.fire({
                title: '¿Estás seguro de hacer el movimiento?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: ruta,
                            type: "post",
                            data:data,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                executeSearchdata()
                                $("#movimientoscajamodal").modal('hide');
                            },
                            error: function(xhr, status, error) {
                                console.log(xhr);
                            if(xhr.status===499){
                                Swal.fire({ title: 'Error', html: `Detalles del error:<br>${xhr.responseJSON.errors}`, icon: 'error'});
                            }else if(xhr.status===422){
                                $("#movimientoscajamodal").find(".error-message").remove()
                                let errors = xhr.responseJSON.errors;
                                    let errorMessages = Object.values(errors)
                                        .map((msgs) => msgs.join("<br>"))
                                        .join("<br>");
                                    for (let field in errors) {
                                        let input = $("#movimientoscajamodal").find(`[name="${field}"]`);
                                        let errorMessage =
                                            `<small class="text-danger error-message">${errors[field].join("<br>")}</small>`;
                                        input.after(errorMessage);
                                    }
                               
                            }else{
                                let errorMessage = 'Intentelo de nuevo, si el error persiste contacte a Soporte.';
                                Swal.fire({ title: 'Error', html: `${errorMessage}<br>Detalles del error: ${error}<br>${status} : ${xhr.status}`, icon: 'error'});
                            }
                            }
                        });
                    } 
                });
        })
})
</script>

@endpush