<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Orden de Compra</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>
<style>
    .encabezado{
        writing-mode: vertical-lr;
        transform: rotate(180deg);
    }
    .card-body p{
        margin: 0;
    }
    table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
    }
</style>
<body>
    <div class="container">
        <div class="row">
            <div class="col-4" >
               
                    <img src="{{asset('img/logo_cfb_fact.png')}}" width="60%" alt="">
               
            </div>
            <div class="col-4 ">
                <div class="card">
                    <strong><h2>ORDEN DE COMPRA</h2></strong>
                </div>
            </div>
            <div class="col-4">
                <div class="card text-center p-0">
                    <p class="m-0"><strong>CAR FIX AND BEYOND SA DE CV.</strong></p>
                    <P class="m-0">C. PUERTO DE ACAPULCO NO.328, COL. RINCON DEL ANGEL,</P>
                    <P class="m-0">C.P. 58337, MORELIA, MICH</P>
                    <P class="m-0">TELS (443) 2 53 21 82 / (443) 1 58 70 41</P>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="row">
                    <strong>Fecha:&#160; {{$ordenCompra->fecha_creada}}</strong>
                </div>
                <div class="row"> 
                    <div class="col-md-12 p-0">
                        <strong>Hora:&#160; {{$ordenCompra->hora_creada}}</strong>&#160;&#160;
                    </div>
                    <div class="col-md-12 p-0">
                        <strong>Para:&#160; {{$ordenCompra->para}}</strong>
                    </div>
                    <div class="col-md-12 p-0">
                        <strong>Técnico:&#160; {{$ordenCompra->tecnico}}</strong>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card text-center">
                    <div class="card-header p-0 ">
                        <small>PROVEEDOR</small>
                    </div>
                    <div class="card-body p-0">
                        <strong style="color: grey">Recibido - Hora:</strong>
                        <center><strong style="color: black"> {{$ordenCompra->asignada_mensajero_hora}}</strong></Center>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card text-center">
                    <div class="card-header p-0 ">
                        <small>ALMACÉN</small>
                    </div>
                    <div class="card-body p-0">
                        <strong style="color: grey">Recibido - Hora:</strong>
                        <center><strong style="color: black"> {{$ordenCompra->entrega_mensajero_hora}}</strong></Center>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card text-center">
                    <div class="card-header p-0 ">
                        <small>TECNICO</small>
                    </div>
                    <div class="card-body p-0">
                        <strong style="color: grey">Recibido - Hora:</strong>
                        <center><strong style="color: black"> {{$ordenCompra->hora_firma}}</strong></Center>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card text-center">
                    <div class="card-header p-0 ">
                        <small>FOLIO</small>
                    </div>
                    <div class="card-body p-0">
                        <strong style="color: red">&#8470; {{$ordenCompra->id}}</strong>
                    </div>
                </div>
            </div>
        </div>
       
        <div class="row">
            <p><strong>Por favor realice la orden para lo siguiente:</strong></p>
        </div>
        <div class="row">
            <table class="table">
                <thead class="thead-dark text-center">
                    <tr>
                        <th><strong>PROVEEDOR</strong></th>
                        <th><strong>CLAVE</strong></th>
                        <th><strong>CANTIDAD</strong></th>
                        <th><strong>DESCRIPCIÓN</strong></th>
                        <th><strong>PRECIO</strong></th>
                        <th><strong>MONTO</strong></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($conceptos as $concepto)
                        <tr class="text-center">
                            <td>{{$concepto->proveedor}}</td>
                            <td>{{$concepto->clave}}</td>
                            <td>{{$concepto->cantidad}}</td>
                            <td>{{$concepto->descripcion}}</td>
                            <td>${{$concepto->precio}}</td>
                            <td>${{$concepto->precio * $concepto->cantidad}}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="thead-dark text-center">
                    <tr>
                        <th>ECONOMICO</th>
                        <th>PARA LA O.R #</th>
                        <th>MARCA/MODELO/AÑO/MOTOR</th>
                        <th>AUTORIZADO POR</th>
                        <th>FIRMA DE ALMACENISTA</th>
                        <th>FIRMA DE RECIBIDO</th>

                    </tr>
                    <tr>
                        <td>{{$ordenCompra['economico']}} </td>
                        <td>{{$reporte['odes']}} </td>
                        <td>{{$reporte['marca']}} / {{$reporte['modelo']}} / {{$reporte['anio']}} / {{$ordenCompra->motor}} </td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</body>
</html>