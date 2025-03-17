<div class="modal fade" id="nuevosconceptos" tabindex="-1" aria-labelledby="miModalLabel" data-bs-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <!-- Encabezado del modal -->
      <div class="modal-header">
        <h5 class="modal-title" id="miModalLabel"></h5>
        <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <!-- Cuerpo del modal -->
       <form id="formnuevoconcepto">
      <div class="modal-body">
        @csrf
        
        <input type="hidden" name="id" id="idconcepto">
        <div class="vaniflex">
            <div class="selectconlabel zdmgx-r02 zdw-70pct"> 
                <label>Tipo de Contrato</label>
                <select  class="form-control" required id="modulo"name="modulo">
                    <option value="1">CFE GASOLINA</option>
                    <option value="2">CFE DiESEL</option>
            </select>
            </div>
            
            <div class="selectconlabel zdmgx-r02 zdw-70pct"> 
                <label>Tipo de Concepto</label>
                <select  class="form-control" required id="contrato"name="contrato">
                    <option value="2">MORELIA</option>
                    <option value="3">JIQUILPAN</option>
                    <option value="4">ZACAPU</option>
                    <option value="5">BAJIO</option>
                    <option value="6">DIVISINALES</option>
                    <option value="7">ECO</option>
                    <option value="9">APATZINGAN</option>
            </select>
            </div>
        </div>
        <div class="vaniflex">
            <div class="selectconlabel zdmgx-r02 zdw-70pct"> 
                <label>Tipo de Concepto</label>
                <select required id="Conceptos_Select2"name="Conceptos_Select2">
                    <option value=""></option>
            </select>
            </div>
            <div class="selectconlabel">
                <label>
                    Codigo Sat
                </label>
                <input id="ncsatcde" class="form-control" disabled>
            </div>
        </div>
        <div class="vaniflex">
            <div class="select2conlabel zdmg-r03"><label for="">Unidad</label><select class="form-control" name="unidadconcepto" id="unidadconcepto">@foreach ($unidades as $unidad) <option value="{{ $unidad['id'] }}">{{ $unidad['nombre'] }}</option> @endforeach</select></div>
            <div class="select2conlabel zdmg-r03"><label for="">Codigo Unidad</label><input id="codud" class="form-control" disabled value="H87" type="text"></div>
            <div class="select2conlabel zdmg-r03"><label for="">Codigo</label> <input name="cod" class="form-control" type="text" value="FC"></div>
            <div class="select2conlabel zdmg-r03"><label for="">tiempo</label> <input name="tiempo" class="form-control" type="text" value="1.0"></div>
        </div>
        <div class="vaniflex zdjc-between">
            <div class="select2conlabel zdw-45pct zdrelative">
            <label>Categoria</label>
            <select required id="Categoriaconceptos_Select2"name="Categoriaconceptos_Select2">
                <option value=""></option>
            </select>
            <button class="btnin zdabsolute" id="newCategoriaconceptos_Select2" name="newCategoriaconceptos_Select2" type="button">+</button>
            </div>
            <div class="select2conlabel zdrelative zdw-45pct">
            <label>Tipos</label>
            <select required id="Tiposconceptos_Select2"name="Tiposconceptos_Select2">
                <option value=""></option>
            </select>
            <button  class="btnin zdabsolute" id="newTiposconceptos_Select2" name="newTiposconceptos_Select2" type="button">+</button>
            </div>
        </div>
        <div class="vaniflex zdjc-between zdfw-w">
            <div class="selectconlabel">
            <label>P. Refaccion</label>
            <input required class="form-control"  type="number" id="prefaccion" step="0.01" name="prefaccion">
            </div>
            <div class="selectconlabel">
            <label>P.M.O.</label>
            <input required class="form-control"  type="number" id="pmo" name="pmo">
            </div>
            <div class="selectconlabel">
            <label>P. Total</label>
            <input class="form-control"  type="number" id="ptotal" disabled>
            </div>
            <div class="selectconlabel "><label for="">Año</label><select class="form-control" name="anioconcepto" id="anioconcepto">
                <!-- @foreach ($anios as $anio) <option value="{{ $anio['id'] }}">{{ $anio['descripcion'] }}</option> @endforeach -->
                 <option selected value="3">2025</option>
            </select></div>
        </div>
        <div class="textareaconlabel zdw-100pct">
            <label>Descripcion</label>
            <textarea required class="form-control"  name="descripcionconcepto" id="descripcionconcepto"></textarea>
        </div>
       
      </div>
      <!-- Pie del modal -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" id="guardarnuevoconcepto"class="btn btn-primary">Guardar</button>
      </div>
    </form>
    </div>
  </div>
</div>
@push('scripts')
    <script>
    $(function(){
        $('#Tiposconceptos_Select2').select2({
            language: { searching: ()=> "Buscando opciones...",noResults: () => "Sin Resultados",},
            dropdownParent: $("#nuevosconceptos"),
            placeholder: 'Escribe para buscar...',
            allowClear: true,
            minimumInputLength: 0,
            ajax: {
                url: '/select2/obtenertiposcatalogo',
                dataType: 'json',
                data: function(params) {
                    var query = {
                        term: params.term,
                        modulo: $('#modulo').val(),
                        contrato: $('#contrato').val(),
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
        $('#Categoriaconceptos_Select2').select2({
            language: { searching: ()=> "Buscando opciones...",noResults: () => "Sin Resultados",},
            dropdownParent: $("#nuevosconceptos"),
            placeholder: 'Escribe para buscar...',
            allowClear: true,
            minimumInputLength: 0,
            ajax: {
                url: '/select2/obtenercategoriacatalogo',
                dataType: 'json',
                data: function(params) {
                    var query = {
                        term: params.term,
                        modulo: $('#modulo').val(),
                    };
                    return query;
                },
                delay: 500,
                processResults: function(data) {
                    console.log(data);
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.titulo,
                                id: item.id
                            };
                        })
                    };
                },
                cache: true
            }
        });
        $('#Conceptos_Select2').on('change',function(){
            if($(this).val()){
                $.ajax({
                    type: 'GET',
                    url: '{{ route('2025.cfe.obtener.datosnuevoconcepto') }}',
                    data:{
                        id: $(this).val(),
                    },
                    success: function(response) {
                        console.log(response)
                        $("#ncsatcde").val(response.data.code)
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr);
                    }
                }); }
    })
    $('#unidadconcepto').on('change',function(){
        if($(this).val()){
        $.ajax({
            type: 'GET',
            url: '{{ route('2025.cfe.obtener.unidadessat') }}',
            data:{
                id: $(this).val(),
            },
            success: function(response) {
                console.log(response)
                $("#codud").val(response)
            },
            error: function(xhr, status, error) {
                console.error(xhr);
            }
        }); 
    }
    
})
$('#modulo, #contrato').on('change', function() {
  $('#Tiposconceptos_Select2').val('').trigger('change');
});

$('#formnuevoconcepto').submit(function(e){
            e.preventDefault();
            let ruta=($('#idconcepto').val() ? "{{ route('administracion.catalogos.update') }}" : "{{ route('administracion.catalogos.create') }}");
            let form= $("#formnuevoconcepto");
            let data=  form.serialize();
            let modal=$("#nuevosconceptos");
            let guardar=$("#guardarnuevoconcepto")
            guardar.attr("disabled", true);
            Swal.fire({
                icon: "question",
                text: "¿Estás seguro de guardar el concepto?",
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
                var $request = $.post(ruta,data);
                $request.done(function(data) {
                    guardar.attr("disabled", false);
                   
                        Swal.fire({
                            icon: "success",
                            title:data.suucess ,
                            showConfirmButton: false,
                            timer: 2000,
                        });
                        modal.modal("hide");
                        executeSearchdata();
                    
                });
                $request.fail(function(error) {
                    guardar.attr("disabled", false);
                    if (error.status === 422) {
                    form.find(".error-message").remove();
                        let errors = error.responseJSON.errors;
                        let errorMessages = Object.values(errors)
                            .map((msgs) => msgs.join("<br>"))
                            .join("<br>");
                        for (let field in errors) {
                        let input = form.find(`[name="${field}"]`);
                        let errorMessage = `<small class="text-danger error-message">${errors[field].join("<br>")}</small>`;
                        input.after(errorMessage);
                        }
                        modal.modal("show");
                    } else {
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
                    guardar.removeAttr("disabled");
                    
                }
        });

        })
        $('#prefaccion, #pmo').on('change',function(){
         let prefaccionVal = parseFloat($('#prefaccion').val()) || 0; 
            let pmoVal = parseFloat($('#pmo').val()) || 0; 
            let total = prefaccionVal + pmoVal
            $('#ptotal').val(total);
        });
    });
    </script>
@endpush