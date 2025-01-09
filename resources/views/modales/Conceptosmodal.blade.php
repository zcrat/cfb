<div class="modal fade" id="nuevosconceptos" tabindex="-1" aria-labelledby="miModalLabel" data-bs-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <!-- Encabezado del modal -->
      <div class="modal-header">
        <h5 class="modal-title" id="miModalLabel">Catalogo de Conceptos</h5>
        <button type="button" class="btn-close regresarmodal" aria-label="Cerrar"></button>
      </div>
      <!-- Cuerpo del modal -->
      <div class="modal-body">
        <div class="vaniflex">
            <label>Tipo de Concepto</label>
            <select id="Conceptos_Select2">
                <option value=""></option>
            </select>
        </div>
        <div class="vaniflex">
            <div class="mismall vaniw25">
                <small>
                    Codigo Sat
                </small>
                <label id="ncsatcde"></label>
            </div>
            <div class="mismall  vaniw25">
                <small>
                    Codigo Unidad
                </small>
                <label id="ncundcde"></label>
            </div>
            <div class="mismall  vaniw20">
                <small>
                    Codigo
                </small>
                <label id="nccde"></label>
            </div>
            <div class="mismall  vaniw15">
                <small>
                    Unidad
                </small>
                <label id="ncund"></label>
            </div>
            <div class="mismall  vaniw15">
                <small>
                    Tiempo
                </small>
                <label id="nctm"></label>
            </div>
        </div>
        <div class="vaniflex zdjc-between">
            <div class="select2conlabel zdw-45pct zdrelative">
            <label>Categoria</label>
            <select id="Categoriaconceptos_Select2">
                <option value=""></option>
            </select>
            <button class="btnin zdabsolute" id="newCategoriaconceptos_Select2" name="newCategoriaconceptos_Select2" type="button">+</button>
            </div>
            <div class="select2conlabel zdrelative zdw-45pct">
            <label>Tipos</label>
            <select id="Tiposconceptos_Select2">
                <option value=""></option>
            </select>
            <button  class="btnin zdabsolute" id="newTiposconceptos_Select2" name="newTiposconceptos_Select2" type="button">+</button>
            </div>
        </div>
        <div class="vaniflex zdjc-between zdfw-w">
            <div class="selectconlabel">
            <label>P. Refaccion</label>
            <input class="form-control"  type="text" id="prefaccion" name="prefaccion">
            </div>
            <div class="selectconlabel">
            <label>P.M.O.</label>
            <input class="form-control"  type="text" id="pmo" name="pmo">
            </div>
            <div class="selectconlabel">
            <label>P. Total</label>
            <input class="form-control"  type="text" id="ptotal" name="ptotal">
            </div>
        </div>
        <div class="textareaconlabel">
            <label>descripcion</label>
            <textarea class="form-control"  name="descripcionconcepto" id="descripcionconcepto"></textarea>
        </div>
       
      </div>
      <!-- Pie del modal -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary regresarmodal">Cerrar</button>
        <button type="button" class="btn btn-primary">Guardar cambios</button>
      </div>
    </div>
  </div>
</div>
