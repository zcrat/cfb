<div class="modal fade" id="Newusertallermodal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Cabecera del Modal -->
            <div class="modal-header">
                <h5 class="modal-title" id="titleusertaller"></h5>
                <button type="button" class="btn-close closenewusertaller"></button>
            </div>
            <!-- Cuerpo del Modal -->
            <form id='formusertaller'>
                @csrf
            <div class="modal-body">
                <div class=" selectconlabel zdmg-r02">
                    <input type="hidden" name="tipousertaller" id='tipousertaller'>
                    <label for="newmarca">Nombre<strong>*</strong></label>
                    <input required class="form-control" type="text" placeholder="Ej.Jose Martines" id="newusertaller"
                        name="newusertaller">
                </div>
            </div>

            <!-- Pie del Modal -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary closenewusertaller">Cerrar</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
<script>
    $('#formusertaller').submit(function(e){
        e.preventDefault();
        ruta="{{route('2025.Recepcion.Vehicular.create.user.taller')}}";
        data=$(this).serialize()
        $.ajax({
                url: ruta,
                type: "POST",
                data:data,
                success: function(response) {
                    $('.closenewusertaller').trigger('click');
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
    })
    $('.closenewusertaller').on('click',()=>{
        $('#Newusertallermodal').modal('hide');
        $('#RecepcionVehicular').modal('show');
    });
    
</script>
@endpush
