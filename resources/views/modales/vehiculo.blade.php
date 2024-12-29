
<div class="modal fade" id="newcarmodal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <!-- Cabecera del Modal -->
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nuevo Vehiculo</h5>
       
      </div>

      <!-- Cuerpo del Modal -->
      <div class="modal-body">
        <div class="vaniflex zdmg-r05 zdjc-between zdfw-w">
            <div class="select2conlabel zdw-40pct">
                <label for="tipo">Tipo <strong>*</strong></label>
                <select id="tiponewvehiculo"name="tiponewvehiculo" required></select>
                <button id="newtipovehiculo"class="btnin" type="button">+</button>
            </div>
            <div class="select2conlabel zdw-40pct">
                <label for="marcanewvehiculo">Marca <strong>*</strong></label>
                <select id="marcanewvehiculo"name="marcanewvehiculo" required></select>
                <button class="btnin newmarcacar" type="button">+</button>
            </div>
            <div class="select2conlabel zdw-40pct">
                <label for="modelonewvehiculo">Modelo <strong>*</strong></label>
                <select id="modelonewvehiculo"name="modelonewvehiculo" required></select>
                <button id="newmodelocar"class="btnin" type="button">+</button>
            </div>
            <div class="select2conlabel zdw-40pct">
                <label for="colornewvehiculo">Color <strong>*</strong></label>
                <select id="colornewvehiculo"name="colornewvehiculo" required></select>
                <button id="newcolorcar"class="btnin" type="button">+</button>
            </div>
            <div class=" selectconlabel zdmg-r02">
                <label for="anionewcar">Año<strong>*</strong></label>
                <input required class="form-control" type="number"  pattern="^\d{4}$" max="9999" placeholder="Ej.2024 " id="anionewcar" name="anionewcar">
            </div>
            <div class=" selectconlabel zdmg-r02">
                <label for="numeconomiconewcar">Numero Economico<strong>*</strong></label>
                <input required class="form-control" type="number"   placeholder="Ej.27379 " id="numeconomiconewcar" name="numeconomiconewcar">
            </div>
            <div class=" selectconlabel zdmg-r02">
                <label for="vimnewcar">VIM<strong>*</strong></label>
                <input required class="form-control" type="text"   placeholder="Ej.JJSOE18P388988750 " id="vimnewcar" name="vimnewcar">
            </div>
            <div class=" selectconlabel zdmg-r02">
                <label for="placasnewcar">Placas<strong>*</strong></label>
                <input required class="form-control" type="text"   placeholder="Ej.YBU-80-66 " id="placasnewcar" name="placasnewcar">
            </div>
        
        </div>
      </div>

      <!-- Pie del Modal -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary closenewcar" >Cerrar</button>
        <button type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>
