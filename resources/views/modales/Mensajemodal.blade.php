<div class="modal fade" id="messagemodal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Cabecera del Modal -->
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">MENSAJES</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Cuerpo del Modal -->
            <div class="modal-body">
                <input type="hidden" id="presupuesto_id">
                <div id="tablemessage">
                    
                </div>

                <div class=" selectconlabel zdmg-r02">
                    <label for="newmessage">Nuevo Mensaje <strong></strong></label>
                    <textarea required class="form-control" type="text" placeholder="Espacio Para Escribir " id="newmessage"
                        name="newmessage"></textarea>
                </div>
            </div>

            <!-- Pie del Modal -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secundary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="savenewmessage">Guardar</button>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    $(function(){ 
    $('#savenewmessage').on('click',function(){
        Swal.fire({
            title: '¿Estás seguro de agregar el nuevo mensaje?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{route('2025.presupuesto.new.message')}}",
                        type: "post",
                        data:{
                            "_token": "{{ csrf_token() }}",
                            message:$('#newmessage').val(),
                            presupuesto:$('#presupuesto_id').val(),
                        },
                        success: function(response) {
                            executeSearchdata();
                            Swal.fire({ html: `${response.success}`, icon: 'success',showConfirmButton: false,timer: 1000,});
                            openmessagemodal($('#presupuesto_id').val());
                            $('#newmessage').val('')
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
            });
        
    })
    window.deletemessage= function(id){
        Swal.fire({
            title: '¿Estás seguro de Eliminar el mensaje?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{route('2025.presupuesto.delete.message')}}",
                        type: "delete",
                        data:{
                            "_token": "{{ csrf_token() }}",
                            message:id,
                        },
                        success: function(response) {
                            executeSearchdata();
                            Swal.fire({ html: `${response.success}`, icon: 'success',showConfirmButton: false,timer: 1000,});
                            openmessagemodal($('#presupuesto_id').val());
                            
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
            });
        
    };
    })
</script>
@endpush