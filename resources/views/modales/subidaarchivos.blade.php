
<div class="modal fade" id="subidaarchivos" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <!-- Cabecera del Modal -->
      <div class="modal-header">
        <h5 class="modal-title" id="archivotitle"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Cuerpo del Modal -->
      <div class="modal-body">
        <div class=" selectconlabel zdmg-r02">
                <label for="newmarca">Archivo<strong>*</strong></label>
                <input id="nuevo_archivo" class="form-control" type="file"  name="nuevo_archivo">
        </div>
        <div class="logos">
            <img id="img_preview" src="#" alt="Logo Preview" class="mimagen" hidden>
        </div>
      </div>

      <!-- Pie del Modal -->
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="Historial_archivos"><i class="fa fa-picture-o"></i></button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="subida_archivos">Guardar</button>
      </div>
    </div>
  </div>
</div>
@push('scripts')
<script>
    $('#nuevo_archivo').change(function(){ 
        const file = this.files[0]; // Obtén el primer archivo seleccionado
    if (file) {
        const reader = new FileReader();
        reader.readAsDataURL(file); // Lee el archivo como una URL de datos
        reader.onload = function(e) {
            // Asigna el resultado de la lectura al src de la imagen
            document.getElementById('img_preview').src = e.target.result;
            document.getElementById('img_preview').removeAttribute('hidden');
        }
    }
    })
    $('#subida_archivos').on('click',function(){
            let origen=$(this).attr('data-origen')
            let id=$(this).attr('data-id')
            const formData = new FormData();
            const fileInput = $('#nuevo_archivo');
            console.log(fileInput);
            if (fileInput[0].files.length > 0) {
                formData.append('file', fileInput[0].files[0]);
                formData.append('id', id);  // Agregar id al FormData
                formData.append('origen', origen);
                console.log(id,origen)
                $.ajax({
                    url: "{{route('2025.cfe.agregar.archivospresupuesto')}}",
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data:formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire({ html: `${response.success}`, icon: 'success',showConfirmButton: false,timer: 2000,});
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
                });
            } else {
                alert('Por favor, selecciona un archivo.');
                return;
            }

            
        })
</script>
@endpush