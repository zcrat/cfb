
<div class="modal fade" id="newmodelocarmodal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <!-- Cabecera del Modal -->
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nuevo Modelo</h5>
        <button type="button" class="btn-close closemodelonewcar"></button>
      </div>

      <!-- Cuerpo del Modal -->
      <div class="modal-body">
        <div class="vaniflex zdmg-r05 zdjc-between zdfw-w">
          <div class="select2conlabel zdw-40pct">
              <label for="marcanewmodelo">Marca <strong>*</strong></label>
              <select class="marcasvehiculo-Select2" id="marcanewmodelo"name="marcanewmodelo" required></select>
              <button id="newmarcacar"class="btnin" type="button">+</button>
          </div>
          <div class=" selectconlabel zdmg-r02">
              <label for="newmodelo">Modelo<strong>*</strong></label>
              <input required class="form-control" type="text"  placeholder="Ej.Tacoma" id="newmodelo" name="newmodelo">
          </div>
        </div>
      </div>

      <!-- Pie del Modal -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary closemodelonewcar" >Cerrar</button>
        <button type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>
