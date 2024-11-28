@extends ('layouts.admin2')
@section ('contenido')
<div>
    <div></div>
    <div>
        <div>
            <input type="text" disabled="disabled">
            <input type="text" disabled="disabled">
            <input type="text" disabled="disabled">
            <input type="text" disabled="disabled">
            <input type="text" disabled="disabled">
            <input type="text" disabled="disabled">
            <input type="text" disabled="disabled">
            <input type="text" disabled="disabled">

        </div>
        <div>
            <input type="text" disabled="disabled">
            <input type="text" disabled="disabled">
            <input type="text" disabled="disabled">
            <input type="text" disabled="disabled">
            <input type="text" disabled="disabled">
            <input type="text" disabled="disabled">
        </div>
        <table class="table table-striped">
            <cologroup>
                <col class="colum_piezas">
            </cologroup>
            <thead>
                <tr>
                    <th>N#</th>
                    <th>Clave</th>
                    <th>Descripcion</th>
                    <th>Partes</th>
                    <th>Mano de Obra</th>
                    <th>Subcontratado</th>
                    <th>Otros</th>
                    <th>Subtotal Costos</th>
                    <th>Precio De Venta</th>
                </tr>
            </thead>
            <tbody>

        </tbody>
        </table>
        <div>
            <Button class="btn btn-primary">Guardar</Button>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection