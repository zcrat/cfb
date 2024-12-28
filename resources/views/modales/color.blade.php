
<div class="modal fade" id="newcolorcarmodal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <!-- Cabecera del Modal -->
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nuevo Color</h5>
        <button type="button" class="btn-close closenewcolorcar"></button>
      </div>
      <form id="newcolorform">
      @csrf
        <div class="modal-body">
          <div class=" selectconlabel zdmg-r02">
            <label for="newcolor">Color<strong>*</strong></label>
            <input required class="form-control" type="text"   placeholder="Ej. Violeta " id="newcolor" name="newcolor">
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary closenewcolorcar" >Cerrar</button>
          <button type="submit" id="guardarnuevocolor" class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>
@push('scripts')
  <script>
    $("#newcolorform").submit(function(e) {
      e.preventDefault();
      console.log("Formulario enviado");
      let modalpadre=$("#newcarmodal");
      let modal=$("#newcolorcarmodal");
      let guardar=$("#guardarnuevocolor")
      let ruta="{{ route('2025.cfe.guardar.nuevocolor') }}";
      let form= $("#newcolorform");
      modal.modal("hide");
      guardar.attr("disabled", true);
      Swal.fire({
              icon: "question",
              text: "¿Estás seguro de Guardar El nuevo Color?",
              showCancelButton: true,
              confirmButtonText: "Confirmar",
              cancelButtonText: "Cancelar",
              reverseButtons: true,
              customClass: {
                  confirmButton: "btn-primary",
                  cancelButton: "btn-light",
              },
          })
          .then((result) => {
            if (result.isConfirmed) {
              $(".error-message").remove();
              var $request = $.post(ruta,form.serialize());
              $request.done(function(data) {
                guardar.attr("disabled", false);
                if (data === "guardado") {
                    Swal.fire({
                        icon: "success",
                        title: "Se registró correctamente al nuevo color",
                        showConfirmButton: false,
                        timer: 2000,
                    });
                    modalpadre.modal("show");
                }  else {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        html: data,
                    }).then((result) => {
                        modal.modal("show");
                    });
                }
              });
              $request.fail(function(error) {
                  guardar.attr("disabled", false);
                  if (error.status === 422) {
                    let errors = error.responseJSON.errors;
                    let errorMessages = Object.values(errors)
                        .map((msgs) => msgs.join("<br>"))
                        .join("<br>");
                    for (let field in errors) {
                      let input = form.find(`[name="${field}"]`);
                      let errorMessage = `<small class="text-danger error-message">${errors[field].join("<br>")}</small>`;
                      input.after(errorMessage);
                    }
                    Swal.fire({
                        icon: "warning",
                        title: "Errores",
                        html: errorMessages,
                    }).then(() => {
                        modal.modal("show");
                    });
                } else {
                    modal.modal("hide");
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Ocurrió un error inesperado",
                    }).then(() => {
                        modal.modal("show");
                    });
                }
              });
            } else {
                modal.modal("show");
                guardar.attr("disabled", false);
            }
      });
    });
  </script>
@endpush