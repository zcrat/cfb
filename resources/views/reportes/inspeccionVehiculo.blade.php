<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <title>Reporte Inspección Técnica de Vehículo</title>
    <script>
        function imprim1(print){
            var printContents = document.getElementById('print').innerHTML;
            w = window.open();
            w.document.write(printContents);
            w.document.close(); // necessary for IE >= 10
            w.focus(); // necessary for IE >= 10
            w.print();
            w.close();
            return true;
        }
    </script>
    <style>
      .text-akumas{
        color: #000075;
      }
      .bg-akumas{
        background-color: #000075;
      }
      .border-akumas{
        border: 1px solid #000075 !important;
      }
      .badge-akumas{
        background-color: #000075;
        color: white;
      }
    </style>
</head>

<body>
    @foreach ($reporte as $item)
    <div class="container-fluid" id="print">
        <div class="container">
            <div class="row">
                <div class="col-md-7 text-center" style="background: #B3B3B3">
                    <h2 class="">Reporte de Inspección Técnica de Vehículo Multi-Punto </h2>
                </div>
                <div class="col-md-5 text-center">
                    <img src="{{asset('img/logo_akumas.png')}}" width="100%"  alt="Logo Akumas">
                </div>
            </div>
            <div class="row">
                <div class="col-md-7 text-left">
                    <strong>Fecha: </strong><small>{{$item['rFecha']}}</small>
                </div>
                <div class="col-md-5 text-center">
                    <strong>ECO IMPULSO, S.A DE C.V</b></strong>
                    <div><small class="text-akumas">CORREGIDORA #1033, COL. CENTRO, C.P. 58000, MORELIA, MICH.</small></div>
                    <div><small class="text-akumas">TELS (443) 690 3540 / Nex. 279 7139 Y 29</small></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <strong>Nombre: </strong><small>{{$item['nombre']}}</small>
                </div>
                <div class="col-md-6">
                    <strong>Tel. </strong><small>{{$item['telefono']}}</small>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <strong>Vehíc./Marca/Modelo/Año: </strong><small>{{$item['Vehic']}}</small>
                </div>
                <div class="col-md-3">
                    <strong>Placas: </strong> <small>{{$item['placas']}}</small>
                </div>
                <div class="col-md-3">
                    <strong>Kilometraje: </strong> <small>{{$item['kilometraje']}}</small>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <strong>#VIN: </strong><small>{{$item['vin']}}</small>
                </div>
                <div class="col-md-3">
                    <strong>#economico: </strong> <small>{{$item['economico']}}</small>
                </div>
                <div class="col-md-3">
                    <strong>O.R. #: </strong> <small>{{$item['inspeccionTecnicaVehiculo']['orden_seguimiento']}}</small>
                </div>
            </div>
            <div class="row">
                <div class="col-md-7">
                    <div class="card border border-danger">
                        <div class="p-0 pl-3 card-header">
                            Daños Visibles en Pre-Inspección del Vehículo:
                        </div>
                        <div class="card-body p-0">
                            <img src="{{asset('img/carros_inspeccion.png')}}" width="100%" height="" alt="Daños">
                        </div>
                        <div class="p-0 card-footer bg-white text-center">
                            <strong>Antefirma del Cliente:
                                @if ($item['inspeccionTecnicaVehiculo']['anteFirma'])
                                    <img src="{{asset('img/firmas/'.$item['inspeccionTecnicaVehiculo']['anteFirma'])}}" width="20%" alt="">
                                @else
                                _________________
                                @endif
                               </strong>
                            <strong> Fecha: </strong><small>{{$item['inspeccionTecnicaVehiculo']['iFecha']}}</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card border border-danger">
                        <div class="p-0 pl-3 card-header ">
                           Indicaciones del cliente:
                        </div>
                        <div class="card-body">
                            @if ($item['inspeccionTecnicaVehiculo']['indicacionesCliente'])
                                <small>{{$item['inspeccionTecnicaVehiculo']['indicacionesCliente']}}</small>
                            @else
                                <hr>
                                <hr>
                                <hr>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-1">
                <div class="col-md-12">
                    <div class="card text-center ">
                        <div class="p-0 pl-3 card-header">
                            <i class="fas fa-circle" style="color:red"></i><strong> Requiere Atención Inmediata</strong>
                            <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i><strong> Puede Requerir Atención Futura</strong>
                            <i class="fas fa-circle" style="color:green" ></i><strong> Inspeccionada y esta bien</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container ">
            <div class="row mt-1">
                <div class="col-md-12">
                    <div class="card border border-danger ">
                        <div class="p-0 pl-3 card-header bg-danger">
                            <i class="fas fa-square" style="color:white"></i>
                            <strong class="text-white"> 26 PUNTOS - INSPECCIÓN DE VEHÍCULO </strong>
                        </div>
                        <div class="card-body py-1">
                            <div class="row">
                                <div class="col-md-4 px-0">
                                    <div class="card">
                                        <div class="p-0 pl-3 card-header bg-akumas">
                                            <strong class="text-white">REVISIÓN DE LUCES ESPÍAS</strong>
                                        </div>
                                        <div class="card-body py-0 px-0">
                                            @if ($item['revisionLucesEspias']['codigo'] == 1)
                                                <i class="fas fa-check-circle" style="color:red"></i>
                                                <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                <i class="fas fa-circle" style="color:green"></i>
                                            @elseif($item['revisionLucesEspias']['codigo'] == 2)
                                                <i class="fas fa-circle" style="color:red"></i>
                                                <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                <i class="fas fa-circle" style="color:green"></i>
                                            @elseif($item['revisionLucesEspias']['codigo'] == 3)
                                                <i class="fas fa-circle" style="color:red"></i>
                                                <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                <i class="fas fa-check-circle" style="color:green"></i>
                                            @endif
                                            <small class="text-akumas">Código(s):</small>
                                            <hr>
                                            <hr>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-1 px-0">
                                        <div class="card">
                                            <div class="p-0 pl-3 card-header bg-akumas">
                                                <strong class="text-white">LÍQUIDOS</strong>
                                            </div>
                                            <div class="card-body py-0 px-0">
                                              <div class="row">
                                                <div class="col-md-9">
                                                  <small class="text-akumas"><strong>CONDICIÓN:</strong></small>
                                                </div>
                                                <div class="col-md-1 px-0">
                                                  <small class="text-akumas"><strong>OK</strong></small>
                                                </div>
                                                <div class="col-md-2 px-0">
                                                  <small class="text-akumas"><strong>LLENO</strong> </small>
                                                </div>
                                              </div>
                                              <div class="row">
                                                <div class="col-md-9 pr-0">
                                                    @if ($item['liquidos']['aceiteMotor'] == 1)
                                                        <i class="fas fa-check-circle" style="color:red"></i>
                                                        <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                        <i class="fas fa-circle" style="color:green"></i>
                                                    @elseif($item['liquidos']['aceiteMotor'] == 2)
                                                        <i class="fas fa-circle" style="color:red"></i>
                                                        <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                        <i class="fas fa-circle" style="color:green"></i>
                                                    @elseif($item['liquidos']['aceiteMotor'] == 3)
                                                        <i class="fas fa-circle" style="color:red"></i>
                                                        <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                        <i class="fas fa-check-circle" style="color:green"></i>
                                                    @endif
                                                  <small class="text-akumas">Aceite de Motor:</small>
                                                </div>
                                                <div class="col-md-1 px-0">
                                                    @if ($item['liquidos']['aMOK'] == true)
                                                        <input type="checkbox" checked disabled />
                                                    @else
                                                        <input type="checkbox" disabled />
                                                    @endif

                                                </div>
                                                <div class="col-md-2">
                                                    @if ($item['liquidos']['aMLleno'] == true)
                                                        <input type="checkbox" checked disabled />
                                                    @else
                                                        <input type="checkbox" disabled />
                                                    @endif
                                                </div>
                                              </div>
                                              <div class="row">
                                                <div class="col-md-9 pr-0">
                                                    @if ($item['liquidos']['transmision'] == 1)
                                                        <i class="fas fa-check-circle" style="color:red"></i>
                                                        <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                        <i class="fas fa-circle" style="color:green"></i>
                                                    @elseif($item['liquidos']['transmision'] == 2)
                                                        <i class="fas fa-circle" style="color:red"></i>
                                                        <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                        <i class="fas fa-circle" style="color:green"></i>
                                                    @elseif($item['liquidos']['transmision'] == 3)
                                                        <i class="fas fa-circle" style="color:red"></i>
                                                        <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                        <i class="fas fa-check-circle" style="color:green"></i>
                                                    @endif
                                                  <small class="text-akumas">Transmisión:</small>
                                                </div>
                                                <div class="col-md-1 px-0">
                                                    @if ($item['liquidos']['tOK'] == true)
                                                        <input type="checkbox" checked disabled />
                                                    @else
                                                        <input type="checkbox" disabled />
                                                    @endif

                                                </div>
                                                <div class="col-md-2">
                                                    @if ($item['liquidos']['tLleno'] == true)
                                                        <input type="checkbox" checked disabled />
                                                    @else
                                                        <input type="checkbox" disabled />
                                                    @endif
                                                </div>
                                              </div>
                                              <div class="row">
                                                <div class="col-md-9 pr-0">
                                                    @if ($item['liquidos']['diferencialft'] == 1)
                                                        <i class="fas fa-check-circle" style="color:red"></i>
                                                        <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                        <i class="fas fa-circle" style="color:green"></i>
                                                    @elseif($item['liquidos']['diferencialft'] == 2)
                                                        <i class="fas fa-circle" style="color:red"></i>
                                                        <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                        <i class="fas fa-circle" style="color:green"></i>
                                                    @elseif($item['liquidos']['diferencialft'] == 3)
                                                        <i class="fas fa-circle" style="color:red"></i>
                                                        <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                        <i class="fas fa-check-circle" style="color:green"></i>
                                                    @endif
                                                  <small class="text-akumas">Diferencial: FRENTE/TRASERO:</small>
                                                </div>
                                                <div class="col-md-1 px-0">
                                                    @if ($item['liquidos']['dOK'] == true)
                                                        <input type="checkbox" checked disabled />
                                                    @else
                                                        <input type="checkbox" disabled />
                                                    @endif

                                                </div>
                                                <div class="col-md-2">
                                                    @if ($item['liquidos']['dLleno'] == true)
                                                        <input type="checkbox" checked disabled />
                                                    @else
                                                        <input type="checkbox" disabled />
                                                    @endif
                                                </div>
                                              </div>
                                              <div class="row">
                                                <div class="col-md-9 pr-0">
                                                    @if ($item['liquidos']['lRefrigerante'] == 1)
                                                        <i class="fas fa-check-circle" style="color:red"></i>
                                                        <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                        <i class="fas fa-circle" style="color:green"></i>
                                                    @elseif($item['liquidos']['lRefrigerante'] == 2)
                                                        <i class="fas fa-circle" style="color:red"></i>
                                                        <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                        <i class="fas fa-circle" style="color:green"></i>
                                                    @elseif($item['liquidos']['lRefrigerante'] == 3)
                                                        <i class="fas fa-circle" style="color:red"></i>
                                                        <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                        <i class="fas fa-check-circle" style="color:green"></i>
                                                    @endif
                                                  <small class="text-akumas">Refrigerante:</small>
                                                </div>
                                                <div class="col-md-1 px-0">
                                                    @if ($item['liquidos']['reOK'] == true)
                                                        <input type="checkbox" checked disabled />
                                                    @else
                                                        <input type="checkbox" disabled />
                                                    @endif

                                                </div>
                                                <div class="col-md-2">
                                                    @if ($item['liquidos']['reLleno'] == true)
                                                        <input type="checkbox" checked disabled />
                                                    @else
                                                        <input type="checkbox" disabled />
                                                    @endif
                                                </div>
                                              </div>
                                              <div class="row">
                                                <div class="col-md-9 pr-0">
                                                    @if ($item['liquidos']['frenos'] == 1)
                                                        <i class="fas fa-check-circle" style="color:red"></i>
                                                        <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                        <i class="fas fa-circle" style="color:green"></i>
                                                    @elseif($item['liquidos']['frenos'] == 2)
                                                        <i class="fas fa-circle" style="color:red"></i>
                                                        <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                        <i class="fas fa-circle" style="color:green"></i>
                                                    @elseif($item['liquidos']['frenos'] == 3)
                                                        <i class="fas fa-circle" style="color:red"></i>
                                                        <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                        <i class="fas fa-check-circle" style="color:green"></i>
                                                    @endif
                                                  <small class="text-akumas">Frenos:</small>
                                                </div>
                                                <div class="col-md-1 px-0">
                                                    @if ($item['liquidos']['frOK'] == true)
                                                        <input type="checkbox" checked disabled />
                                                    @else
                                                        <input type="checkbox" disabled />
                                                    @endif

                                                </div>
                                                <div class="col-md-2">
                                                    @if ($item['liquidos']['frLleno'] == true)
                                                        <input type="checkbox" checked disabled />
                                                    @else
                                                        <input type="checkbox" disabled />
                                                    @endif
                                                </div>
                                              </div>
                                              <div class="row">
                                                <div class="col-md-9 pr-0">
                                                    @if ($item['liquidos']['direccionHidraulica'] == 1)
                                                        <i class="fas fa-check-circle" style="color:red"></i>
                                                        <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                        <i class="fas fa-circle" style="color:green"></i>
                                                    @elseif($item['liquidos']['direccionHidraulica'] == 2)
                                                        <i class="fas fa-circle" style="color:red"></i>
                                                        <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                        <i class="fas fa-circle" style="color:green"></i>
                                                    @elseif($item['liquidos']['direccionHidraulica'] == 3)
                                                        <i class="fas fa-circle" style="color:red"></i>
                                                        <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                        <i class="fas fa-check-circle" style="color:green"></i>
                                                    @endif
                                                  <small class="text-akumas">Dirección Hidráulica:</small>
                                                </div>
                                                <div class="col-md-1 px-0">
                                                    @if ($item['liquidos']['dHOK'] == true)
                                                        <input type="checkbox" checked disabled />
                                                    @else
                                                        <input type="checkbox" disabled />
                                                    @endif

                                                </div>
                                                <div class="col-md-2">
                                                    @if ($item['liquidos']['dHLleno'] == true)
                                                        <input type="checkbox" checked disabled />
                                                    @else
                                                        <input type="checkbox" disabled />
                                                    @endif
                                                </div>
                                              </div>
                                              <div class="row">
                                                <div class="col-md-9 pr-0">
                                                    @if ($item['liquidos']['limpiaparabrisas'] == 1)
                                                        <i class="fas fa-check-circle" style="color:red"></i>
                                                        <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                        <i class="fas fa-circle" style="color:green"></i>
                                                    @elseif($item['liquidos']['limpiaparabrisas'] == 2)
                                                        <i class="fas fa-circle" style="color:red"></i>
                                                        <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                        <i class="fas fa-circle" style="color:green"></i>
                                                    @elseif($item['liquidos']['limpiaparabrisas'] == 3)
                                                        <i class="fas fa-circle" style="color:red"></i>
                                                        <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                        <i class="fas fa-check-circle" style="color:green"></i>
                                                    @endif
                                                  <small class="text-akumas">Limpiaparabrisas:</small>
                                                </div>
                                                <div class="col-md-1 px-0">
                                                    @if ($item['liquidos']['liOK'] == true)
                                                        <input type="checkbox" checked disabled />
                                                    @else
                                                        <input type="checkbox" disabled />
                                                    @endif

                                                </div>
                                                <div class="col-md-2">
                                                    @if ($item['liquidos']['liLleno'] == true)
                                                        <input type="checkbox" checked disabled />
                                                    @else
                                                        <input type="checkbox" disabled />
                                                    @endif
                                                </div>
                                              </div>
                                                <h5><span class="badge badge-akumas">NOTAS:</span></h5>
                                                @if ($item['liquidos']['lNotas'])
                                                    <small>{{$item['liquidos']['lNotas']}}</small>
                                                @else
                                                    <hr>
                                                    <hr>
                                                    <hr>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 px-0">
                                    <div class="card">
                                        <div class="p-0 pl-3 card-header bg-akumas">
                                            <strong class="text-white">MANGUERAS</strong>
                                        </div>
                                        <div class="card-body pt-0 px-0">
                                            @if ($item['mangueras']['mRefrigerante'] == 1)
                                                <i class="fas fa-check-circle" style="color:red"></i>
                                                <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                <i class="fas fa-circle" style="color:green"></i>
                                            @elseif($item['mangueras']['mRefrigerante'] == 2)
                                                <i class="fas fa-circle" style="color:red"></i>
                                                <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                <i class="fas fa-circle" style="color:green"></i>
                                            @elseif($item['mangueras']['mRefrigerante'] == 3)
                                                <i class="fas fa-circle" style="color:red"></i>
                                                <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                <i class="fas fa-check-circle" style="color:green"></i>
                                            @endif
                                            <small class="text-akumas">Refrigerante:</small>
                                            <br>
                                            @if ($item['mangueras']['direccionAireAcondic'] == 1)
                                                <i class="fas fa-check-circle" style="color:red"></i>
                                                <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                <i class="fas fa-circle" style="color:green"></i>
                                            @elseif($item['mangueras']['direccionAireAcondic'] == 2)
                                                <i class="fas fa-circle" style="color:red"></i>
                                                <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                <i class="fas fa-circle" style="color:green"></i>
                                            @elseif($item['mangueras']['direccionAireAcondic'] == 3)
                                                <i class="fas fa-circle" style="color:red"></i>
                                                <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                <i class="fas fa-check-circle" style="color:green"></i>
                                            @endif
                                            <small class="text-akumas">Dirección/Aire Acondic.:</small>
                                            <br>
                                            @if ($item['mangueras']['calefaccion'] == 1)
                                                <i class="fas fa-check-circle" style="color:red"></i>
                                                <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                <i class="fas fa-circle" style="color:green"></i>
                                            @elseif($item['mangueras']['calefaccion'] == 2)
                                                <i class="fas fa-circle" style="color:red"></i>
                                                <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                <i class="fas fa-circle" style="color:green"></i>
                                            @elseif($item['mangueras']['calefaccion'] == 3)
                                                <i class="fas fa-circle" style="color:red"></i>
                                                <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                <i class="fas fa-check-circle" style="color:green"></i>
                                            @endif
                                            <small class="text-akumas">Calefacción:</small>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-1 px-0">
                                        <div class="card">
                                            <div class="p-0 pl-3 card-header bg-akumas">
                                                <strong class="text-white">BANDAS</strong>
                                            </div>
                                            <div class="card-body pt-0 px-0">
                                                @if ($item['bandas']['accesorios'] == 1)
                                                    <i class="fas fa-check-circle" style="color:red"></i>
                                                    <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                    <i class="fas fa-circle" style="color:green"></i>
                                                @elseif($item['bandas']['accesorios'] == 2)
                                                    <i class="fas fa-circle" style="color:red"></i>
                                                    <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                    <i class="fas fa-circle" style="color:green"></i>
                                                @elseif($item['bandas']['accesorios'] == 3)
                                                    <i class="fas fa-circle" style="color:red"></i>
                                                    <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                    <i class="fas fa-check-circle" style="color:green"></i>
                                                @endif
                                                <small class="text-akumas">Accesorios:</small>
                                                <br>
                                                @if ($item['bandas']['bDireccionHidraulica'] == 1)
                                                    <i class="fas fa-check-circle" style="color:red"></i>
                                                    <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                    <i class="fas fa-circle" style="color:green"></i>
                                                @elseif($item['bandas']['bDireccionHidraulica'] == 2)
                                                    <i class="fas fa-circle" style="color:red"></i>
                                                    <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                    <i class="fas fa-circle" style="color:green"></i>
                                                @elseif($item['bandas']['bDireccionHidraulica'] == 3)
                                                    <i class="fas fa-circle" style="color:red"></i>
                                                    <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                    <i class="fas fa-check-circle" style="color:green"></i>
                                                @endif
                                                <small class="text-akumas">Dirección Hidráulica:</small>
                                                <br>
                                                @if ($item['bandas']['alternadorAAcondic'] == 1)
                                                    <i class="fas fa-check-circle" style="color:red"></i>
                                                    <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                    <i class="fas fa-circle" style="color:green"></i>
                                                @elseif($item['bandas']['alternadorAAcondic'] == 2)
                                                    <i class="fas fa-circle" style="color:red"></i>
                                                    <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                    <i class="fas fa-circle" style="color:green"></i>
                                                @elseif($item['bandas']['alternadorAAcondic'] == 3)
                                                    <i class="fas fa-circle" style="color:red"></i>
                                                    <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                    <i class="fas fa-check-circle" style="color:green"></i>
                                                @endif
                                                <small class="text-akumas">Alternador/A.Acondic:</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-1 px-0">
                                        <div class="card">
                                            <div class="p-0 pl-3 card-header bg-akumas">
                                                <strong class="text-white">FILTROS</strong>
                                            </div>
                                            <div class="card-body py-0 px-0">
                                                @if ($item['filtros']['aire'] == 1)
                                                    <i class="fas fa-check-circle" style="color:red"></i>
                                                    <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                    <i class="fas fa-circle" style="color:green"></i>
                                                @elseif($item['filtros']['aire'] == 2)
                                                    <i class="fas fa-circle" style="color:red"></i>
                                                    <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                    <i class="fas fa-circle" style="color:green"></i>
                                                @elseif($item['filtros']['aire'] == 3)
                                                    <i class="fas fa-circle" style="color:red"></i>
                                                    <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                    <i class="fas fa-check-circle" style="color:green"></i>
                                                @endif
                                                <small class="text-akumas">Aire:</small>
                                                <br>
                                                @if ($item['filtros']['combustible'] == 1)
                                                    <i class="fas fa-check-circle" style="color:red"></i>
                                                    <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                    <i class="fas fa-circle" style="color:green"></i>
                                                @elseif($item['filtros']['combustible'] == 2)
                                                    <i class="fas fa-circle" style="color:red"></i>
                                                    <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                    <i class="fas fa-circle" style="color:green"></i>
                                                @elseif($item['filtros']['combustible'] == 3)
                                                    <i class="fas fa-circle" style="color:red"></i>
                                                    <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                    <i class="fas fa-check-circle" style="color:green"></i>
                                                @endif
                                                <small class="text-akumas">Combustible:</small>
                                                <br>
                                                @if ($item['filtros']['aceite'] == 1)
                                                    <i class="fas fa-check-circle" style="color:red"></i>
                                                    <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                    <i class="fas fa-circle" style="color:green"></i>
                                                @elseif($item['filtros']['aceite'] == 2)
                                                    <i class="fas fa-circle" style="color:red"></i>
                                                    <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                    <i class="fas fa-circle" style="color:green"></i>
                                                @elseif($item['filtros']['aceite'] == 3)
                                                    <i class="fas fa-circle" style="color:red"></i>
                                                    <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                    <i class="fas fa-check-circle" style="color:green"></i>
                                                @endif
                                                <small class="text-akumas">Aceite:</small>
                                                <br>
                                                <h5><span class="badge badge-akumas">NOTAS:</span></h5>
                                                @if ($item['filtros']['fNotas'])
                                                    <small>{{$item['filtros']['fNotas']}}</small>
                                                @else
                                                    <hr>
                                                    <hr>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 px-0">
                                    <div class="card">
                                        <div class="p-0 pl-3 card-header bg-akumas">
                                            <strong class="text-white">LLANTAS</strong>
                                        </div>
                                        <div class="card-body pt-0 px-0">
                                            <div class="row">
                                                <div class="col-md-8"><strong><small class="text-akumas">PATRÓN DE DESGASTE/DAÑO:</small></strong></div>
                                                <div class="col-md-3 p-0 pl-2"><strong><small class="text-akumas">PRESIÓN</small></strong></div>
                                            </div>
                                            <div class="row">
                                              <div class="col-md-8">
                                                @if ($item['llantas']['dIDelantera'] == 1)
                                                    <i class="fas fa-check-circle" style="color:red"></i>
                                                    <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                    <i class="fas fa-circle" style="color:green"></i>
                                                @elseif($item['llantas']['dIDelantera'] == 2)
                                                    <i class="fas fa-circle" style="color:red"></i>
                                                    <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                    <i class="fas fa-circle" style="color:green"></i>
                                                @elseif($item['llantas']['dIDelantera'] == 3)
                                                    <i class="fas fa-circle" style="color:red"></i>
                                                    <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                    <i class="fas fa-check-circle" style="color:green"></i>
                                                @endif
                                                <small class="text-akumas">I. Dlantera:</small>
                                              </div>
                                              <div class="col-md-2 p-0">
                                                <input class="form-control form-control-sm text-center" type="text" value="{{$item['llantas']['pIDelantera']}}" disabled />
                                              </div>
                                            </div>
                                            <div class="row">
                                              <div class="col-md-8">
                                                @if ($item['llantas']['dITrasera'] == 1)
                                                    <i class="fas fa-check-circle" style="color:red"></i>
                                                    <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                    <i class="fas fa-circle" style="color:green"></i>
                                                @elseif($item['llantas']['dITrasera'] == 2)
                                                    <i class="fas fa-circle" style="color:red"></i>
                                                    <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                    <i class="fas fa-circle" style="color:green"></i>
                                                @elseif($item['llantas']['dITrasera'] == 3)
                                                    <i class="fas fa-circle" style="color:red"></i>
                                                    <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                    <i class="fas fa-check-circle" style="color:green"></i>
                                                @endif
                                                <small class="text-akumas">I. Trasera:</small>
                                              </div>
                                              <div class="col-md-2 p-0">
                                                <input class="form-control form-control-sm text-center" type="text" value="{{$item['llantas']['pITrasera']}}" disabled />
                                              </div>
                                            </div>
                                            <div class="row">
                                              <div class="col-md-8">
                                                @if ($item['llantas']['dDDelantera'] == 1)
                                                    <i class="fas fa-check-circle" style="color:red"></i>
                                                    <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                    <i class="fas fa-circle" style="color:green"></i>
                                                @elseif($item['llantas']['dDDelantera'] == 2)
                                                    <i class="fas fa-circle" style="color:red"></i>
                                                    <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                    <i class="fas fa-circle" style="color:green"></i>
                                                @elseif($item['llantas']['dDDelantera'] == 3)
                                                    <i class="fas fa-circle" style="color:red"></i>
                                                    <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                    <i class="fas fa-check-circle" style="color:green"></i>
                                                @endif
                                                <small class="text-akumas">D. Delantera:</small>
                                              </div>
                                              <div class="col-md-2 p-0">
                                                <input class="form-control form-control-sm text-center" type="text" value="{{$item['llantas']['pDDdelantera']}}" disabled />
                                              </div>
                                            </div>
                                            <div class="row">
                                              <div class="col-md-8">
                                                @if ($item['llantas']['dDTrasera'] == 1)
                                                    <i class="fas fa-check-circle" style="color:red"></i>
                                                    <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                    <i class="fas fa-circle" style="color:green"></i>
                                                @elseif($item['llantas']['dDTrasera'] == 2)
                                                    <i class="fas fa-circle" style="color:red"></i>
                                                    <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                    <i class="fas fa-circle" style="color:green"></i>
                                                @elseif($item['llantas']['dDTrasera'] == 3)
                                                    <i class="fas fa-circle" style="color:red"></i>
                                                    <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                    <i class="fas fa-check-circle" style="color:green"></i>
                                                @endif
                                                <small class="text-akumas">D. Trasera:</small>
                                              </div>
                                              <div class="col-md-2 p-0">
                                                <input class="form-control form-control-sm text-center" type="text" value="{{$item['llantas']['pDTrasera']}}" disabled />
                                              </div>
                                            </div>
                                            <div class="row">
                                              <div class="col-md-8">
                                                @if ($item['llantas']['dRefaccion'] == 1)
                                                    <i class="fas fa-check-circle" style="color:red"></i>
                                                    <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                    <i class="fas fa-circle" style="color:green"></i>
                                                @elseif($item['llantas']['dRefaccion'] == 2)
                                                    <i class="fas fa-circle" style="color:red"></i>
                                                    <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                    <i class="fas fa-circle" style="color:green"></i>
                                                @elseif($item['llantas']['dRefaccion'] == 3)
                                                    <i class="fas fa-circle" style="color:red"></i>
                                                    <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                    <i class="fas fa-check-circle" style="color:green"></i>
                                                @endif
                                                <small class="text-akumas">Refacción:</small>
                                              </div>
                                              <div class="col-md-2 p-0">
                                                <input class="form-control form-control-sm text-center" type="text" value="{{$item['llantas']['pRefaccion']}}" disabled />
                                              </div>
                                            </div>
                                              <small class="text-akumas">EL DESGATE DE NEUMÁTICOS INDICA QUE:</small>
                                              <br>
                                                @if ($item['llantas']['alineacionBalanceo'] == 1)
                                                    <i class="fas fa-check-circle" style="color:red"></i>
                                                    <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                    <i class="fas fa-circle" style="color:green"></i>
                                                @elseif($item['llantas']['alineacionBalanceo'] == 2)
                                                    <i class="fas fa-circle" style="color:red"></i>
                                                    <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                    <i class="fas fa-circle" style="color:green"></i>
                                                @elseif($item['llantas']['alineacionBalanceo'] == 3)
                                                    <i class="fas fa-circle" style="color:red"></i>
                                                    <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                    <i class="fas fa-check-circle" style="color:green"></i>
                                                @endif
                                              <small class="text-akumas">Se necesita Alineación y Balanceo:</small>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-1 px-0">
                                        <div class="card">
                                            <div class="p-0 pl-3 card-header bg-akumas">
                                                <strong class="text-white">SEGURIDAD</strong>
                                            </div>
                                            <div class="card-body py-0 px-0">
                                                @if ($item['seguridad']['frenoEmergencia'] == 1)
                                                    <i class="fas fa-check-circle" style="color:red"></i>
                                                    <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                    <i class="fas fa-circle" style="color:green"></i>
                                                @elseif($item['seguridad']['frenoEmergencia'] == 2)
                                                    <i class="fas fa-circle" style="color:red"></i>
                                                    <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                    <i class="fas fa-circle" style="color:green"></i>
                                                @elseif($item['seguridad']['frenoEmergencia'] == 3)
                                                    <i class="fas fa-circle" style="color:red"></i>
                                                    <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                    <i class="fas fa-check-circle" style="color:green"></i>
                                                @endif
                                                <small class="text-akumas">Freno de Emergencia:</small>
                                                <br>
                                                <small class="text-akumas"><strong>LIMPIAPARABRISAS</strong></small>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        @if ($item['seguridad']['lpIzqDer'] == 1)
                                                            <i class="fas fa-check-circle" style="color:red"></i>
                                                            <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                            <i class="fas fa-circle" style="color:green"></i>
                                                        @elseif($item['seguridad']['lpIzqDer'] == 2)
                                                            <i class="fas fa-circle" style="color:red"></i>
                                                            <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                            <i class="fas fa-circle" style="color:green"></i>
                                                        @elseif($item['seguridad']['lpIzqDer'] == 3)
                                                            <i class="fas fa-circle" style="color:red"></i>
                                                            <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                            <i class="fas fa-check-circle" style="color:green"></i>
                                                        @endif
                                                        <small class="text-akumas">Izq./Der:</small>
                                                    </div>
                                                    <div class="col-md-6">
                                                        @if ($item['seguridad']['lpiTrasero'] == 1)
                                                            <i class="fas fa-check-circle" style="color:red"></i>
                                                            <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                            <i class="fas fa-circle" style="color:green"></i>
                                                        @elseif($item['seguridad']['lpiTrasero'] == 2)
                                                            <i class="fas fa-circle" style="color:red"></i>
                                                            <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                            <i class="fas fa-circle" style="color:green"></i>
                                                        @elseif($item['seguridad']['lpiTrasero'] == 3)
                                                            <i class="fas fa-circle" style="color:red"></i>
                                                            <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                            <i class="fas fa-check-circle" style="color:green"></i>
                                                        @endif
                                                        <small class="text-akumas">Trasero:</small>
                                                    </div>
                                                </div>
                                                <br>
                                                <h5><span class="badge badge-akumas">NOTAS:</span></h5>
                                                @if ($item['filtros']['fNotas'])
                                                    <small>{{$item['filtros']['fNotas']}}</small>
                                                @else
                                                    <hr>
                                                    <hr>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-1">
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-akumas">
                        <div class="p-0 pl-3 card-header bg-akumas">
                            <i class="fas fa-square" style="color:white"></i>
                            <strong class="text-white"> 57 PUNTOS - INSPECCIÓN DE VEHÍCULO <sub>(Incluye todos los anteriores)</sub> </strong>
                        </div>
                        <div class="card-body py-1 ">
                            <div class="row">
                                <div class="col-md-4 px-0">
                                    <div class="card">
                                        <div class="p-0 pl-3 card-header bg-akumas">
                                            <strong class="text-white">AFINACIÓN DE MOTOR</strong>
                                        </div>
                                        <div class="card-body pt-0 px-0">
                                            @if ($item['afinacionMotor']['tapadistribuidorBujíasCables'] == 1)
                                                <i class="fas fa-check-circle" style="color:red"></i>
                                                <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                <i class="fas fa-circle" style="color:green"></i>
                                            @elseif($item['afinacionMotor']['tapadistribuidorBujíasCables'] == 2)
                                                <i class="fas fa-circle" style="color:red"></i>
                                                <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                <i class="fas fa-circle" style="color:green"></i>
                                            @elseif($item['afinacionMotor']['tapadistribuidorBujíasCables'] == 3)
                                                <i class="fas fa-circle" style="color:red"></i>
                                                <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                <i class="fas fa-check-circle" style="color:green"></i>
                                            @endif
                                            <small class="text-akumas">Tapa del Distribuidor/Bujías/Cables:</small>
                                            <br>
                                            @if ($item['afinacionMotor']['fuelInjection'] == 1)
                                                <i class="fas fa-check-circle" style="color:red"></i>
                                                <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                <i class="fas fa-circle" style="color:green"></i>
                                            @elseif($item['afinacionMotor']['fuelInjection'] == 2)
                                                <i class="fas fa-circle" style="color:red"></i>
                                                <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                <i class="fas fa-circle" style="color:green"></i>
                                            @elseif($item['afinacionMotor']['fuelInjection'] == 3)
                                                <i class="fas fa-circle" style="color:red"></i>
                                                <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                <i class="fas fa-check-circle" style="color:green"></i>
                                            @endif
                                            <small class="text-akumas">Fuel Injection:</small>
                                        </div>
                                    </div>
                                    <div class="col-md-12 p-0">
                                        <div class="card">
                                            <div class="p-0 pl-3 card-header bg-akumas">
                                                <strong class="text-white">TREN DE TRANSMISÓN</strong>
                                            </div>
                                            <div class="card-body py-0 px-0">
                                                @if ($item['trenTransmision']['filtroTransmision'] == 1)
                                                    <i class="fas fa-check-circle" style="color:red"></i>
                                                    <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                    <i class="fas fa-circle" style="color:green"></i>
                                                @elseif($item['trenTransmision']['filtroTransmision'] == 2)
                                                    <i class="fas fa-circle" style="color:red"></i>
                                                    <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                    <i class="fas fa-circle" style="color:green"></i>
                                                @elseif($item['trenTransmision']['filtroTransmision'] == 3)
                                                    <i class="fas fa-circle" style="color:red"></i>
                                                    <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                    <i class="fas fa-check-circle" style="color:green"></i>
                                                @endif
                                                <small class="text-akumas">Filtro de Transmisión:</small>
                                                <br>
                                                @if ($item['trenTransmision']['unionTransmisiónCluth'] == 1)
                                                    <i class="fas fa-check-circle" style="color:red"></i>
                                                    <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                    <i class="fas fa-circle" style="color:green"></i>
                                                @elseif($item['trenTransmision']['unionTransmisiónCluth'] == 2)
                                                    <i class="fas fa-circle" style="color:red"></i>
                                                    <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                    <i class="fas fa-circle" style="color:green"></i>
                                                @elseif($item['trenTransmision']['unionTransmisiónCluth'] == 3)
                                                    <i class="fas fa-circle" style="color:red"></i>
                                                    <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                    <i class="fas fa-check-circle" style="color:green"></i>
                                                @endif
                                                <small class="text-akumas">Unión de la Transmisión/Clutch:</small>
                                                <br>
                                                @if ($item['trenTransmision']['ejeTracciónJuntasHomocinéticas'] == 1)
                                                    <i class="fas fa-check-circle" style="color:red"></i>
                                                    <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                    <i class="fas fa-circle" style="color:green"></i>
                                                @elseif($item['trenTransmision']['ejeTracciónJuntasHomocinéticas'] == 2)
                                                    <i class="fas fa-circle" style="color:red"></i>
                                                    <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                    <i class="fas fa-circle" style="color:green"></i>
                                                @elseif($item['trenTransmision']['ejeTracciónJuntasHomocinéticas'] == 3)
                                                    <i class="fas fa-circle" style="color:red"></i>
                                                    <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                    <i class="fas fa-check-circle" style="color:green"></i>
                                                @endif
                                                <small class="text-akumas">Eje de Tracción y Juntas Homocinéticas:</small>
                                                <br>
                                                @if ($item['trenTransmision']['ejeTransmisiónJuntasUniversales'] == 1)
                                                    <i class="fas fa-check-circle" style="color:red"></i>
                                                    <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                    <i class="fas fa-circle" style="color:green"></i>
                                                @elseif($item['trenTransmision']['ejeTransmisiónJuntasUniversales'] == 2)
                                                    <i class="fas fa-circle" style="color:red"></i>
                                                    <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                    <i class="fas fa-circle" style="color:green"></i>
                                                @elseif($item['trenTransmision']['ejeTransmisiónJuntasUniversales'] == 3)
                                                    <i class="fas fa-circle" style="color:red"></i>
                                                    <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                    <i class="fas fa-check-circle" style="color:green"></i>
                                                @endif
                                                <small class="text-akumas">Eje de Transmisión y Juntas Universales:</small>
                                                <br>
                                                @if ($item['trenTransmision']['rodamientosRueda'] == 1)
                                                    <i class="fas fa-check-circle" style="color:red"></i>
                                                    <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                    <i class="fas fa-circle" style="color:green"></i>
                                                @elseif($item['trenTransmision']['rodamientosRueda'] == 2)
                                                    <i class="fas fa-circle" style="color:red"></i>
                                                    <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                    <i class="fas fa-circle" style="color:green"></i>
                                                @elseif($item['trenTransmision']['rodamientosRueda'] == 3)
                                                    <i class="fas fa-circle" style="color:red"></i>
                                                    <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                    <i class="fas fa-check-circle" style="color:green"></i>
                                                @endif
                                                <small class="text-akumas">Rodamientos de Rueda:</small>
                                                <br>
                                                @if ($item['trenTransmision']['tTransmision'] == 1)
                                                    <i class="fas fa-check-circle" style="color:red"></i>
                                                    <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                    <i class="fas fa-circle" style="color:green"></i>
                                                @elseif($item['trenTransmision']['tTransmision'] == 2)
                                                    <i class="fas fa-circle" style="color:red"></i>
                                                    <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                    <i class="fas fa-circle" style="color:green"></i>
                                                @elseif($item['trenTransmision']['tTransmision'] == 3)
                                                    <i class="fas fa-circle" style="color:red"></i>
                                                    <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                    <i class="fas fa-check-circle" style="color:green"></i>
                                                @endif
                                                <small class="text-akumas">Transmisón:</small>
                                                <br>
                                                @if ($item['trenTransmision']['cluth'] == 1)
                                                    <i class="fas fa-check-circle" style="color:red"></i>
                                                    <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                    <i class="fas fa-circle" style="color:green"></i>
                                                @elseif($item['trenTransmision']['cluth'] == 2)
                                                    <i class="fas fa-circle" style="color:red"></i>
                                                    <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                    <i class="fas fa-circle" style="color:green"></i>
                                                @elseif($item['trenTransmision']['cluth'] == 3)
                                                    <i class="fas fa-circle" style="color:red"></i>
                                                    <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                    <i class="fas fa-check-circle" style="color:green"></i>
                                                @endif
                                                <small class="text-akumas">Clutch:</small>
                                                <br>
                                                <h5><span class="badge badge-akumas">NOTAS:</span></h5>
                                                @if ($item['trenTransmision']['tTNotas'])
                                                    <small>{{$item['trenTransmision']['tTNotas']}}</small>
                                                @else
                                                    <hr>
                                                    <hr>
                                                    <hr>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 px-0">
                                    <div class="card">
                                        <div class="p-0 pl-3 card-header bg-akumas">
                                            <strong class="text-white">ELÉCTRICO</strong>
                                        </div>
                                        <div class="card-body pt-0 px-0">
                                            @if ($item['electrico']['sistemaCargaBateria'] == 1)
                                                <i class="fas fa-check-circle" style="color:red"></i>
                                                <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                <i class="fas fa-circle" style="color:green"></i>
                                            @elseif($item['electrico']['sistemaCargaBateria'] == 2)
                                                <i class="fas fa-circle" style="color:red"></i>
                                                <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                <i class="fas fa-circle" style="color:green"></i>
                                            @elseif($item['electrico']['sistemaCargaBateria'] == 3)
                                                <i class="fas fa-circle" style="color:red"></i>
                                                <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                <i class="fas fa-check-circle" style="color:green"></i>
                                            @endif
                                            <small class="text-akumas">Sistema de Carga/Bateria:</small>
                                            <br>
                                            @if ($item['electrico']['cablesConexionesFusibles'] == 1)
                                                <i class="fas fa-check-circle" style="color:red"></i>
                                                <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                <i class="fas fa-circle" style="color:green"></i>
                                            @elseif($item['electrico']['cablesConexionesFusibles'] == 2)
                                                <i class="fas fa-circle" style="color:red"></i>
                                                <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                <i class="fas fa-circle" style="color:green"></i>
                                            @elseif($item['electrico']['cablesConexionesFusibles'] == 3)
                                                <i class="fas fa-circle" style="color:red"></i>
                                                <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                <i class="fas fa-check-circle" style="color:green"></i>
                                            @endif
                                            <small class="text-akumas">Cables/Conexiones/Fusibles:</small>
                                            <br>
                                            <small class="text-akumas">LUCES:</small>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    @if ($item['electrico']['faros'] == 1)
                                                        <i class="fas fa-check-circle" style="color:red"></i>
                                                        <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                        <i class="fas fa-circle" style="color:green"></i>
                                                    @elseif($item['electrico']['faros'] == 2)
                                                        <i class="fas fa-circle" style="color:red"></i>
                                                        <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                        <i class="fas fa-circle" style="color:green"></i>
                                                    @elseif($item['electrico']['faros'] == 3)
                                                        <i class="fas fa-circle" style="color:red"></i>
                                                        <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                        <i class="fas fa-check-circle" style="color:green"></i>
                                                    @endif
                                                    <small class="text-akumas">Faros:</small>
                                                </div>
                                                <div class="col-md-3">
                                                    <small class="text-akumas">
                                                        @if ($item['electrico']['faIzq'] == true)
                                                            Izq. <i class="fas fa-check"></i>
                                                        @else
                                                            Izq.
                                                        @endif
                                                    </small>
                                                </div>
                                                <div class="col-md-3">
                                                    <small class="text-akumas">
                                                        @if ($item['electrico']['faDer'] == true)
                                                            Der. <i class="fas fa-check"></i>
                                                        @else
                                                            Der.
                                                        @endif
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    @if ($item['electrico']['cuartos'] == 1)
                                                        <i class="fas fa-check-circle" style="color:red"></i>
                                                        <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                        <i class="fas fa-circle" style="color:green"></i>
                                                    @elseif($item['electrico']['cuartos'] == 2)
                                                        <i class="fas fa-circle" style="color:red"></i>
                                                        <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                        <i class="fas fa-circle" style="color:green"></i>
                                                    @elseif($item['electrico']['cuartos'] == 3)
                                                        <i class="fas fa-circle" style="color:red"></i>
                                                        <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                        <i class="fas fa-check-circle" style="color:green"></i>
                                                    @endif
                                                    <small class="text-akumas">Cuartos:</small>
                                                </div>
                                                <div class="col-md-3">
                                                    <small class="text-akumas">
                                                        @if ($item['electrico']['cuIzq'] == true)
                                                            Izq. <i class="fas fa-check"></i>
                                                        @else
                                                            Izq.
                                                        @endif
                                                    </small>
                                                </div>
                                                <div class="col-md-3">
                                                    <small class="text-akumas">
                                                        @if ($item['electrico']['cuDer'] == true)
                                                            Der. <i class="fas fa-check"></i>
                                                        @else
                                                            Der.
                                                        @endif
                                                    </small>
                                                </div>
                                            </div>
                                                @if ($item['electrico']['frenosReversa'] == 1)
                                                    <i class="fas fa-check-circle" style="color:red"></i>
                                                    <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                    <i class="fas fa-circle" style="color:green"></i>
                                                @elseif($item['electrico']['frenosReversa'] == 2)
                                                    <i class="fas fa-circle" style="color:red"></i>
                                                    <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                    <i class="fas fa-circle" style="color:green"></i>
                                                @elseif($item['electrico']['frenosReversa'] == 3)
                                                    <i class="fas fa-circle" style="color:red"></i>
                                                    <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                    <i class="fas fa-check-circle" style="color:green"></i>
                                                @endif
                                            <small class="text-akumas">Frenos/Reversa:</small>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-5 pr-0">
                                                    @if ($item['electrico']['direccionales'] == 1)
                                                        <i class="fas fa-check-circle" style="color:red"></i>
                                                        <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                        <i class="fas fa-circle" style="color:green"></i>
                                                    @elseif($item['electrico']['direccionales'] == 2)
                                                        <i class="fas fa-circle" style="color:red"></i>
                                                        <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                        <i class="fas fa-circle" style="color:green"></i>
                                                    @elseif($item['electrico']['direccionales'] == 3)
                                                        <i class="fas fa-circle" style="color:red"></i>
                                                        <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                        <i class="fas fa-check-circle" style="color:green"></i>
                                                    @endif
                                                    <small class="text-akumas">Direccionales:</small>
                                                </div>
                                                <div class="col-md-1 px-0">
                                                    <small class="text-akumas">
                                                        @if ($item['electrico']['cuIzq'] == true)
                                                            IF. <i class="fas fa-check"></i>
                                                        @else
                                                            IF.
                                                        @endif
                                                    </small>
                                                </div>
                                                <div class="col-md-1 px-0">
                                                    <small class="text-akumas">
                                                        @if ($item['electrico']['cuDer'] == true)
                                                            IT. <i class="fas fa-check"></i>
                                                        @else
                                                            IT.
                                                        @endif
                                                    </small>
                                                </div>
                                                <div class="col-md-1 px-0">
                                                    <small class="text-akumas">
                                                        @if ($item['electrico']['cuIzq'] == true)
                                                            DF. <i class="fas fa-check"></i>
                                                        @else
                                                            DF.
                                                        @endif
                                                    </small>
                                                </div>
                                                <div class="col-md-2 px-0">
                                                    <small class="text-akumas">
                                                        @if ($item['electrico']['cuDer'] == true)
                                                            DT. <i class="fas fa-check"></i>
                                                        @else
                                                            DT.
                                                        @endif
                                                    </small>
                                                </div>
                                            </div>
                                            @if ($item['electrico']['intermitentes'] == 1)
                                                <i class="fas fa-check-circle" style="color:red"></i>
                                                <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                <i class="fas fa-circle" style="color:green"></i>
                                            @elseif($item['electrico']['intermitentes'] == 2)
                                                <i class="fas fa-circle" style="color:red"></i>
                                                <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                <i class="fas fa-circle" style="color:green"></i>
                                            @elseif($item['electrico']['intermitentes'] == 3)
                                                <i class="fas fa-circle" style="color:red"></i>
                                                <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                <i class="fas fa-check-circle" style="color:green"></i>
                                            @endif
                                            <small class="text-akumas">Intermitentes:</small>
                                        </div>
                                    </div>
                                    <div class="card">
                                      <div class="p-0 pl-3 card-header bg-akumas">
                                          <strong class="text-white">SUSPENSIÓN/DIRECCIÓN</strong>
                                      </div>
                                      <div class="card-body py-0 px-0">
                                        @if ($item['suspensionDireccion']['amortiguadoresSuspension'] == 1)
                                            <i class="fas fa-check-circle" style="color:red"></i>
                                            <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                            <i class="fas fa-circle" style="color:green"></i>
                                        @elseif($item['suspensionDireccion']['amortiguadoresSuspension'] == 2)
                                            <i class="fas fa-circle" style="color:red"></i>
                                            <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                            <i class="fas fa-circle" style="color:green"></i>
                                        @elseif($item['suspensionDireccion']['amortiguadoresSuspension'] == 3)
                                            <i class="fas fa-circle" style="color:red"></i>
                                            <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                            <i class="fas fa-check-circle" style="color:green"></i>
                                        @endif
                                          <small class="text-akumas">Amortiguadores/Suspensión:</small>
                                          <br>
                                            @if ($item['suspensionDireccion']['juntasDirecciónRotulas'] == 1)
                                                <i class="fas fa-check-circle" style="color:red"></i>
                                                <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                <i class="fas fa-circle" style="color:green"></i>
                                            @elseif($item['suspensionDireccion']['juntasDirecciónRotulas'] == 2)
                                                <i class="fas fa-circle" style="color:red"></i>
                                                <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                <i class="fas fa-circle" style="color:green"></i>
                                            @elseif($item['suspensionDireccion']['juntasDirecciónRotulas'] == 3)
                                                <i class="fas fa-circle" style="color:red"></i>
                                                <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                <i class="fas fa-check-circle" style="color:green"></i>
                                            @endif
                                            <small class="text-akumas">Juntas de Dirección/Rótulas:</small>
                                            <br>
                                            <h5><span class="badge badge-akumas">NOTAS:</span></h5>
                                            @if ($item['suspensionDireccion']['sDNotas'])
                                                <small>{{$item['suspensionDireccion']['sDNotas']}}</small>
                                            @else
                                                <hr>
                                                <hr>
                                                <hr>
                                            @endif
                                      </div>
                                  </div>
                                </div>
                                <div class="col-md-4 px-0">
                                    <div class="card">
                                        <div class="p-0 pl-3 card-header bg-akumas">
                                            <strong class="text-white">FRENOS</strong>
                                        </div>
                                        <div class="card-body py-0 px-0">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <small class="text-akumas">PASTILLAS:</small>
                                                    <br>
                                                    @if ($item['frenos']['pIzquierdoDelantero'] == 1)
                                                        <i class="fas fa-check-circle" style="color:red"></i>
                                                        <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                        <i class="fas fa-circle" style="color:green"></i>
                                                    @elseif($item['frenos']['pIzquierdoDelantero'] == 2)
                                                        <i class="fas fa-circle" style="color:red"></i>
                                                        <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                        <i class="fas fa-circle" style="color:green"></i>
                                                    @elseif($item['frenos']['pIzquierdoDelantero'] == 3)
                                                        <i class="fas fa-circle" style="color:red"></i>
                                                        <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                        <i class="fas fa-check-circle" style="color:green"></i>
                                                    @endif
                                                    <small class="text-akumas">I. Del.:</small>
                                                    <br>
                                                    @if ($item['frenos']['pDerechaDelantero'] == 1)
                                                        <i class="fas fa-check-circle" style="color:red"></i>
                                                        <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                        <i class="fas fa-circle" style="color:green"></i>
                                                    @elseif($item['frenos']['pDerechaDelantero'] == 2)
                                                        <i class="fas fa-circle" style="color:red"></i>
                                                        <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                        <i class="fas fa-circle" style="color:green"></i>
                                                    @elseif($item['frenos']['pDerechaDelantero'] == 3)
                                                        <i class="fas fa-circle" style="color:red"></i>
                                                        <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                        <i class="fas fa-check-circle" style="color:green"></i>
                                                    @endif
                                                    <small class="text-akumas">D. Del.:</small>
                                                    <br>
                                                    @if ($item['frenos']['pIzquierdoTrasera'] == 1)
                                                        <i class="fas fa-check-circle" style="color:red"></i>
                                                        <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                        <i class="fas fa-circle" style="color:green"></i>
                                                    @elseif($item['frenos']['pIzquierdoTrasera'] == 2)
                                                        <i class="fas fa-circle" style="color:red"></i>
                                                        <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                        <i class="fas fa-circle" style="color:green"></i>
                                                    @elseif($item['frenos']['pIzquierdoTrasera'] == 3)
                                                        <i class="fas fa-circle" style="color:red"></i>
                                                        <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                        <i class="fas fa-check-circle" style="color:green"></i>
                                                    @endif
                                                    <small class="text-akumas">I. Tras.:</small>
                                                    <br>
                                                    @if ($item['frenos']['pDerechaTrasera'] == 1)
                                                        <i class="fas fa-check-circle" style="color:red"></i>
                                                        <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                        <i class="fas fa-circle" style="color:green"></i>
                                                    @elseif($item['frenos']['pDerechaTrasera'] == 2)
                                                        <i class="fas fa-circle" style="color:red"></i>
                                                        <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                        <i class="fas fa-circle" style="color:green"></i>
                                                    @elseif($item['frenos']['pDerechaTrasera'] == 3)
                                                        <i class="fas fa-circle" style="color:red"></i>
                                                        <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                        <i class="fas fa-check-circle" style="color:green"></i>
                                                    @endif
                                                    <small class="text-akumas">D. Tras.:</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <small class="text-akumas">ROTORES:</small>
                                                    <br>
                                                    @if ($item['frenos']['rIzquierdoDelantero'] == 1)
                                                        <i class="fas fa-check-circle" style="color:red"></i>
                                                        <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                        <i class="fas fa-circle" style="color:green"></i>
                                                    @elseif($item['frenos']['rIzquierdoDelantero'] == 2)
                                                        <i class="fas fa-circle" style="color:red"></i>
                                                        <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                        <i class="fas fa-circle" style="color:green"></i>
                                                    @elseif($item['frenos']['rIzquierdoDelantero'] == 3)
                                                        <i class="fas fa-circle" style="color:red"></i>
                                                        <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                        <i class="fas fa-check-circle" style="color:green"></i>
                                                    @endif
                                                    <small class="text-akumas">I. Del.:</small>
                                                    <br>
                                                    @if ($item['frenos']['rDerechaDelantero'] == 1)
                                                        <i class="fas fa-check-circle" style="color:red"></i>
                                                        <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                        <i class="fas fa-circle" style="color:green"></i>
                                                    @elseif($item['frenos']['rDerechaDelantero'] == 2)
                                                        <i class="fas fa-circle" style="color:red"></i>
                                                        <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                        <i class="fas fa-circle" style="color:green"></i>
                                                    @elseif($item['frenos']['rDerechaDelantero'] == 3)
                                                        <i class="fas fa-circle" style="color:red"></i>
                                                        <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                        <i class="fas fa-check-circle" style="color:green"></i>
                                                    @endif
                                                    <small class="text-akumas">D. Del.:</small>
                                                    <br>
                                                    @if ($item['frenos']['rIzquierdoTrasera'] == 1)
                                                        <i class="fas fa-check-circle" style="color:red"></i>
                                                        <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                        <i class="fas fa-circle" style="color:green"></i>
                                                    @elseif($item['frenos']['rIzquierdoTrasera'] == 2)
                                                        <i class="fas fa-circle" style="color:red"></i>
                                                        <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                        <i class="fas fa-circle" style="color:green"></i>
                                                    @elseif($item['frenos']['rIzquierdoTrasera'] == 3)
                                                        <i class="fas fa-circle" style="color:red"></i>
                                                        <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                        <i class="fas fa-check-circle" style="color:green"></i>
                                                    @endif
                                                    <small class="text-akumas">I. Tras.:</small>
                                                    <br>
                                                    @if ($item['frenos']['rDerechaTrasera'] == 1)
                                                        <i class="fas fa-check-circle" style="color:red"></i>
                                                        <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                        <i class="fas fa-circle" style="color:green"></i>
                                                    @elseif($item['frenos']['rDerechaTrasera'] == 2)
                                                        <i class="fas fa-circle" style="color:red"></i>
                                                        <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                        <i class="fas fa-circle" style="color:green"></i>
                                                    @elseif($item['frenos']['rDerechaTrasera'] == 3)
                                                        <i class="fas fa-circle" style="color:red"></i>
                                                        <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                        <i class="fas fa-check-circle" style="color:green"></i>
                                                    @endif
                                                    <small class="text-akumas">D. Tras.:</small>
                                                </div>
                                            </div>
                                            <small class="text-akumas">PINZAS/CILINDROS DE RUEDA:</small>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    @if ($item['frenos']['pCRIzquierdaDelantera'] == 1)
                                                        <i class="fas fa-check-circle" style="color:red"></i>
                                                        <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                        <i class="fas fa-circle" style="color:green"></i>
                                                    @elseif($item['frenos']['pCRIzquierdaDelantera'] == 2)
                                                        <i class="fas fa-circle" style="color:red"></i>
                                                        <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                        <i class="fas fa-circle" style="color:green"></i>
                                                    @elseif($item['frenos']['pCRIzquierdaDelantera'] == 3)
                                                        <i class="fas fa-circle" style="color:red"></i>
                                                        <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                        <i class="fas fa-check-circle" style="color:green"></i>
                                                    @endif
                                                    <small class="text-akumas">I. Del.:</small>
                                                    <br>
                                                    @if ($item['frenos']['pCRIzquierdaTrasera'] == 1)
                                                        <i class="fas fa-check-circle" style="color:red"></i>
                                                        <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                        <i class="fas fa-circle" style="color:green"></i>
                                                    @elseif($item['frenos']['pCRIzquierdaTrasera'] == 2)
                                                        <i class="fas fa-circle" style="color:red"></i>
                                                        <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                        <i class="fas fa-circle" style="color:green"></i>
                                                    @elseif($item['frenos']['pCRIzquierdaTrasera'] == 3)
                                                        <i class="fas fa-circle" style="color:red"></i>
                                                        <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                        <i class="fas fa-check-circle" style="color:green"></i>
                                                    @endif
                                                    <small class="text-akumas">I. Tras.:</small>
                                                </div>
                                                <div class="col-md-6">
                                                    @if ($item['frenos']['pCRDerechaDelantera'] == 1)
                                                        <i class="fas fa-check-circle" style="color:red"></i>
                                                        <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                        <i class="fas fa-circle" style="color:green"></i>
                                                    @elseif($item['frenos']['pCRDerechaDelantera'] == 2)
                                                        <i class="fas fa-circle" style="color:red"></i>
                                                        <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                        <i class="fas fa-circle" style="color:green"></i>
                                                    @elseif($item['frenos']['pCRDerechaDelantera'] == 3)
                                                        <i class="fas fa-circle" style="color:red"></i>
                                                        <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                        <i class="fas fa-check-circle" style="color:green"></i>
                                                    @endif
                                                    <small class="text-akumas">D. Del.:</small>
                                                    <br>
                                                    @if ($item['frenos']['pCRDerechaTrasera'] == 1)
                                                        <i class="fas fa-check-circle" style="color:red"></i>
                                                        <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                        <i class="fas fa-circle" style="color:green"></i>
                                                    @elseif($item['frenos']['pCRDerechaTrasera'] == 2)
                                                        <i class="fas fa-circle" style="color:red"></i>
                                                        <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                        <i class="fas fa-circle" style="color:green"></i>
                                                    @elseif($item['frenos']['pCRDerechaTrasera'] == 3)
                                                        <i class="fas fa-circle" style="color:red"></i>
                                                        <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                        <i class="fas fa-check-circle" style="color:green"></i>
                                                    @endif
                                                    <small class="text-akumas">D. Tras.:</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="p-0 pl-3 card-header bg-akumas">
                                            <strong class="text-white">ESCAPE</strong>
                                        </div>
                                        <div class="card-body py-0 px-0">
                                            @if ($item['escape']['mofleConvertidorCatlitico'] == 1)
                                                <i class="fas fa-check-circle" style="color:red"></i>
                                                <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                <i class="fas fa-circle" style="color:green"></i>
                                            @elseif($item['escape']['mofleConvertidorCatlitico'] == 2)
                                                <i class="fas fa-circle" style="color:red"></i>
                                                <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                <i class="fas fa-circle" style="color:green"></i>
                                            @elseif($item['escape']['mofleConvertidorCatlitico'] == 3)
                                                <i class="fas fa-circle" style="color:red"></i>
                                                <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                <i class="fas fa-check-circle" style="color:green"></i>
                                            @endif
                                            <small class="text-akumas">Mofle/Convertidor Catlítico:</small>
                                            <br>
                                            @if ($item['escape']['sensoresSoportesTubos'] == 1)
                                                <i class="fas fa-check-circle" style="color:red"></i>
                                                <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                <i class="fas fa-circle" style="color:green"></i>
                                            @elseif($item['escape']['sensoresSoportesTubos'] == 2)
                                                <i class="fas fa-circle" style="color:red"></i>
                                                <img src="{{asset('img/triangle-check.png')}}" style="position:relative; top:-2px"  width="18px">
                                                <i class="fas fa-circle" style="color:green"></i>
                                            @elseif($item['escape']['sensoresSoportesTubos'] == 3)
                                                <i class="fas fa-circle" style="color:red"></i>
                                                <i class="fas fa-exclamation-triangle" style="color: #FFEA00"></i>
                                                <i class="fas fa-check-circle" style="color:green"></i>
                                            @endif
                                            <small class="text-akumas">Sensores/Soportes/tubos:</small>
                                            <br>
                                            <h5><span class="badge badge-akumas">NOTAS:</span></h5>
                                            @if ($item['escape']['eNotas'])
                                                <small>{{$item['escape']['eNotas']}}</small>
                                            @else
                                                <hr>
                                                <hr>
                                                <hr>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
              <div class="col-md-4">
                  <small>Inspeccionado por:</small>
                  @if ($item['user'])
                      {{$item['user']}}
                  @else
                  _________________
                  @endif
              </div>
              <div class="col-md-4">
                <small>Firma del cliente:</small>
                @if ($item['inspeccionTecnicaVehiculo']['anteFirma'])
                  <img src="{{"/img/firmas/".$item['inspeccionTecnicaVehiculo']['anteFirma']}}"
                  width="20%" alt="">
                @else
                _________________
                @endif
              </div>
              <div class="col-md-4">
                <small>Fecha:</small>
                {{$item['inspeccionTecnicaVehiculo']['iFecha']}}
              </div>
            </div>
          </div>
    </div>

    @endforeach
</body>
</html>
