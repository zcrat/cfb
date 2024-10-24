<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hoja de copceptos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

    
</head>
<body>
    <div class="container-fluid">
        <div class="row text-center">
            <div class="col-md-4">
                <h2 class="bg-primary p-1">Hoja de conceptos</h2>
            </div>
            <div class="col-md-4 ">
                <br>
                Fecha: {{$reporte["fecha"]}}
            </div>
            <div class="col-md-4">
                <img src="{{asset('img/logo_cfb_fact.png')}}" width="60%" alt="">
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6 border">
                <label for="nombre"><small>Nombre: {{$reporte["nombre"]}}</small></label>
            </div>
            <div class="col-md-2 border">
                <label for="nombre"><small>#Económico: {{$reporte["economico"]}}</small></label>
            </div>
            <div class="col-md-1 border">
                <label for="nombre"><small>R.R: {{$reporte["odes"]}}</small></label>
            </div>   
            <div class="col-md-1 border">
                <label for="nombre"><small>O.R.#: {{$reporte["odes"]}}</small></label>
            </div>            
            <div class="col-md-2 border">
                <label for="nombre"><small>Técnico: {{$hojaConceptos["id_tecnico"]}}</small></label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-1 border">
                <label for="nombre"><small>Años: {{$reporte["anio"]}} </small></label>
            </div>
            <div class="col-md-2 border">
                <label for="nombre"><small>Marca: {{$reporte["marca"]}}</small></label>
            </div>
            <div class="col-md-2 border">
                <label for="nombre"><small>Modelo: {{$reporte["modelo"]}}</small></label>
            </div>
            <div class="col-md-1 border">
                <label for="nombre"><small>Color: {{$reporte["color"]}}</small></label>
            </div>
            <div class="col-md-1 border">
                <label for="nombre"><small>Placas: {{$reporte["placas"]}}</small></label>
            </div>
            <div class="col-md-2 border">
                <label for="nombre"><small>Km: {{$reporte["km"]}}</small></label>
            </div>
            <div class="col-md-3 border">
                <label for="nombre"><small>Vin: {{$reporte["vin"]}}</small></label>
            </div>
        </div>
        <table class="table text-center border p-0 m-0">
            <thead class="thead-dark">
                <tr>
                    <th class="p-0 m-0" width="1%" rowspan="2" scope="col"></th>
                    <th class="p-0 m-0" rowspan="2" scope="col"><small>REMPLAZAR</small></th>
                    <th class="p-0 m-0" rowspan="2" scope="col"><small>REPARAR</small></th>
                    <th class="p-0 m-0" rowspan="2" scope="col"><small>FECHA A APLICAR</small></th>
                    <th class="p-0 m-0" rowspan="2" scope="col"><small>DESCRIPCIÓN</small></th>
                    <th class="p-0 m-0" rowspan="2" scope="col"><small>CANTIDAD</small></th>
                    <th class="p-0 m-0" colspan="5" scope="col"><small>COSTOS ($)</small></th>
                </tr>
                <tr>
                    <th class="p-0 m-0" scope="col"><small>PARTES</small></th>
                    <th class="p-0 m-0" scope="col"><small>MANO DE OBRA</small></th>
                    <th class="p-0 m-0" scope="col"><small>SUBCONTRATADO</small></th>
                    <th class="p-0 m-0" scope="col"><small>OTROS</small></th>
                    <th class="p-0 m-0" scope="col"><small>SUBTOTAL COSTOS</small></th>
                </tr>
            </thead>
            <tbody>
                @foreach($conceptos as $concepto)
                    <tr>
                        <td><small>{{$concepto->num_concepto}}</small></td>
                       
                            <td><small>{{$concepto->remplazar}}</i></small></td>
                         
                      
                         
                            <td><small>{{$concepto->reparar}}</i></small></td>
                      
                        <td><small>{{$concepto->fecha_aplicacion}}</small></td>
                        <td><small>{{$concepto->descripcion}}</small></td>
                        <td><small>{{$concepto->cantidad}}</small></td>
                        <td><small>${{$concepto->partes}}</small></td>
                        <td><small>${{$concepto->mano_obra}}</small></td>
                        <td><small>${{$concepto->subcontratado}}</small></td>
                        <td><small>${{$concepto->otros}}</small></td>                
                        <td><small>${{$concepto->subtotal_costos}}</small></td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="thead-dark">
                    <th colspan="5"><small>AUTORIZACIÓN</small></th>
                    <th></th>
                    <th><small>PARTES</small></th>
                    <th><small>MANO DE OBRA</small></th>
                    <th><small>SUBCONTRATADO</small></th>
                    <th><small>OTROS</small></th>
                    <th><small>SUBTOTAL COSTOS</small></th>
                </tr>
                <tr>
                    <td rowspan="3" colspan="5">
                        <img src="{{asset('img/firmas/12_20200108135336.jpg')}}" width="50%" alt="">
                    </td>
                    <td><small>Subtotal</small></td>
                    <td><small>${{$hojaConceptos->subtotal_partes}}</small></td>
                    <td><small>${{$hojaConceptos->subtotal_mano_obra}}</small></td>
                    <td><small>${{$hojaConceptos->subtotal_subcontratado}}</small></td>
                    <td><small>${{$hojaConceptos->subtotal_otros}}</small></td>
                    <td><small>${{$hojaConceptos->subtotal_subtotal_costos}}</small></td>
                </tr>
                <tr>
                    <td><small>IVA</small></td>
                    <td><small>${{$hojaConceptos->iva_subtotal_partes}}</small></td>
                    <td><small>${{$hojaConceptos->iva_subtotal_mano_obra}}</small></td>
                    <td><small>${{$hojaConceptos->iva_subtotal_subcontratado}}</small></td>
                    <td><small>${{$hojaConceptos->iva_subtotal_otros}}</small></td>
                    <td><small>${{$hojaConceptos->iva_subtotal_subtotal_costos}}</small></td>
                </tr>
                <tr>
                    <td><small>Total</small></td>
                    <td><small>${{$hojaConceptos->total_partes}}</small></td>
                    <td><small>${{$hojaConceptos->total_mano_obra}}</small></td>
                    <td><small>${{$hojaConceptos->total_subcontratado}}</small></td>
                    <td><small>${{$hojaConceptos->total_otros}}</small></td>
                    <td><small>${{$hojaConceptos->total_subtotal_costos}}</small></td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>