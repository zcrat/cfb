<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Recepción de Vehículo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('css/estilos_impresion.css')}}" media="print">
    <link rel="stylesheet" href="{{asset('css/estilos.css')}}">

    <script language="javascript">

        function imprSelec(nombre) {

            ////////
            var ficha = document.getElementById(nombre);

            var ventimp = window.open(' ', 'popimpr');

            ventimp.document.write(ficha.innerHTML);

            ventimp.document.close();

            ventimp.print();

            ventimp.close();

            window.close();

        }

    </script>


</head>
<body>

@foreach ($RecepcionVehicular as $c)

<div class="  ggg">


    <div class="titulo">
        <h5 class="cent titulo-principal">Reporte de Recepción de Vehículo</h5>
    </div>


    <div class="iden"><h6 class="titulo__folio">No: <span
                    class="text--rojo ">{{$c->folioNum}}</span></h6></div>


    <div class="completo col-md- "> <!--contenedor 1-->


        <div class="bloque__uno  "> <!--blouqe__uno 1-->


            <div class="l-3 uno-bor u1 "><label for="text">Nombre</label> <label for="text"><span
                            class="table--text ">{{$c->nombre}} </span></label></div>
            <div class=" l-2 uno-bor "><label for="text">Usuario</label> <label for="text"><span
                            class="table--text ">{{$c->usuario}} </span></label></div>
            <div class=" uno-bor u2 "><label for="text">OdeS</label> <label for="text"><span
                            class="table--text ">{{$c->orden_seguimiento}}</span></label></div>

            <div class="l-6 uno-bor "><label for="text">Dirección</label> <label for="text"> <span
                            class="table--text">{{$c->direccion}}</label></div>

            <div class="l-2 uno-bor "><label for="text">Ciudad</label> <label for="text"><span
                            class="table--text">{{$c->ciudad}}</span> </label></div>
            <div class=" uno-bor "><label for="text">Estado</label> <label for="text"><span
                            class="table--text">{{$c->estado}}</span></label></div>
            <div class=" uno-bor "><label for="text">C.P.</label> <label for="text"><span
                            class="table--text">{{$c->cp}} </span> </label></div>
            <div class=" uno-bor  "><label for="text">Tel. Negocio</label> <label for="text"> <span
                            class="table--text">{{$c->tel_negocio}}</span></label></div>
            <div class=" uno-bor  "><label for="text">Tel. Casa</label> <label for="text"> <span
                            class="table--text">{{$c->tel_casa}}</span></label></div>

            <div class=" uno-bor l-3"><label for="text">Email</label> <label for="text"><span
                            class="table--text">{{$c->email}}</span></label></div>
            <div class=" uno-bor "><label for="text">Tel. Celular</label> <label for="text"> <span
                            class="table--text">{{$c->tel_celular}}</span></label></div>
            <div class=" uno-bor "><label for="text">Gas. Entrada</label> <label for="text"><span class="table--text">
            <?php $con = $c->gas_entrada;
                    if ($con == 0) {
                        echo "LL";
                    } else if ($con == 1) {
                        echo "3/4";
                    } else if ($con == 2) {
                        echo "1/2";
                    } else if ($con == 3) {
                        echo "1/4";
                    }?>

           </span></label></div>
            <div class=" uno-bor "><label for="text">Gas. Salida</label> <label for="text"><span class="table--text">
            <?php $con = $c->gas_salida;
                    if ($con == 0) {
                        echo "LL";
                    } else if ($con == 1) {
                        echo "3/4";
                    } else if ($con == 2) {
                        echo "1/2";
                    } else if ($con == 3) {
                        echo "1/4";
                    }?>     </span></label></div>

            <div class=" uno-bor "><label for="text">Año</label> <label for="text"><span
                            class="table--text">{{$c->anio}}</span></label></div>
            <div class=" uno-bor "><label for="text">Marca</label> <label for="text"> <span
                            class="table--text">{{$c->marca}}</span></label></div>
            <div class=" uno-bor "><label for="text">Modelo</label> <label for="text"><span
                            class="table--text">{{$c->modelo}}</span></label></div>
            <div class=" uno-bor "><label for="text">Color</label> <label for="text"><span
                            class="table--text">{{$c->color}}</span></label></div>
            <div class=" uno-bor "><label for="text">Placas</label> <label for="text"> <span
                            class="table--text">{{$c->placas}}</span></label></div>
            <div class=" uno-bor "><label for="text">#Económico</label> <label for="text"><span
                            class="table--text">{{$c->no_economico}}</span></label></div>

            <div class=" uno-bor  u4 level--2"><label for="text">KM Entrada</label> <label for="text"><span
                            class="table--text">{{$c->km_entrada}}</span></label></div>
            <div class=" uno-bor level--2 "><label for="text">KM Salida</label> <label for="text"><span
                            class="table--text">{{$c->km_salida}}</span></label></div>
            <div class=" uno-bor l-2 u3"><label for="text">VIN</label> <label for="text"><span
                            class="table--text">{{$c->vim}}</span></label></div>


        </div> <!--blouqe__uno 1 fin-->

    </div>  <!--contenedor span2 fin 1-->


    <div class="bloque___dos    bord "> <!--ID-->


        <!--<div class="col-md-12"><label for="text">FOLIO</label> <label for="text">resultado</label></div>-->
        <div class=" fg"><label for="text">ID</label> <label for="text"><span
                        class="table--text">{{$c->folio}}</span></label></div>
        <div class=" fg"><label for="text">Escrito por</label> <label for="text">
            <span class="table--text">{{$c->name}}</span> </label></div>
        <div class=" fg"><label for="text">Recibido </label> <span
                    class="table--text">{{$c->fecha}}</span></div>
        <div class=" fg"><label for="text">Compromiso para</label> <span
                    class="table--text">{{$c->fecha_compromiso}}</span></div>
        <div class=" fg"><label for="text">Salida</label> <label for="text"><span
                        class="table--text">{{$c->fecha_entrega}}</span></label></div>
        <div class=" fg mas_div"><label for="text">Técnico</label>


            <div>

                <label for="text"><span class="table--text">
                {{$c->tecnico}}

							 </span></label>
            </div>


            <div>
                <label for="text"><span class="table--text">


 </span></label>


            </div>
            <div>
                <label for="text"><span class="table--text">
						



</span></label>
            </div>

        </div>


        <div class=" di"><label for="text">Firma de Supervisión</label>

            <img src="{{asset('/storage/firmas/'.$c->firma.'')}}" width="100%" height="50px"/>


        </div>

    </div> <!--ID FIN-->


    <div class="guia bor">
        <div>D = Dañada</div>
        <div> ✔ =Sin daño visible</div>
        <div> O = Operacional</div>
        <div>R = Reparación necesaria</div>
        <div>F = Falta objeto</div>
        <div>N/A = No aplica</div>

    </div>


    <div class="titulo-50">
        <h6 class="titulo-principal">Condiciones de Interiores y Equipo</h6>
    </div>

    @foreach ($InterioresEquipo as $i)
    <div class="interiores">  <!--interiores-->

        <div class="bor">  <!--borde ifs-->
            <div class="contenedor-ifs"> <!--IFS-->
                <div></div>
                <div><p class="cent">IF</p></div>
                <div><p class="cent">IT</p></div>
                <div><p class="cent">DF</p></div>
                <div><p class="cent">DT</p></div>

                <div><p class="text-right">Paneles de Puertas</p></div>

                <div class="bb">

                <?php $con = $i->puerta_interior_frontal;
                    if ($con == 1) {
                        echo "✔";
                    } else if ($con == 2) {
                        echo "O";
                    } else if ($con == 3) {
                        echo "F";
                    } else if ($con == 4) {
                        echo "D";
                    } else if ($con == 5) {
                        echo "R";
                    } else if ($con == 7) {
                        echo "N/A";
                    } ?> </div>
                <div class="bb"> <?php $con = $i->puerta_interior_trasera;
                    if ($con == 1) {
                        echo "✔";
                    } else if ($con == 2) {
                        echo "O";
                    } else if ($con == 3) {
                        echo "F";
                    } else if ($con == 4) {
                        echo "D";
                    } else if ($con == 5) {
                        echo "R";
                    } else if ($con == 7) {
                        echo "N/A";
                    } ?> </div>
                <div class="bb"><?php $con = $i->puerta_delantera_frontal;
                    if ($con == 1) {
                        echo "✔";
                    } else if ($con == 2) {
                        echo "O";
                    } else if ($con == 3) {
                        echo "F";
                    } else if ($con == 4) {
                        echo "D";
                    } else if ($con == 5) {
                        echo "R";
                    } else if ($con == 7) {
                        echo "N/A";
                    } ?></div>
                <div class="bb"><?php $con = $i->puerta_delantera_trasera;
                    if ($con == 1) {
                        echo "✔";
                    } else if ($con == 2) {
                        echo "O";
                    } else if ($con == 3) {
                        echo "F";
                    } else if ($con == 4) {
                        echo "D";
                    } else if ($con == 5) {
                        echo "R";
                    } else if ($con == 7) {
                        echo "N/A";
                    } ?></div>
                <div><p class="text-right">Asientos</p></div>
                <div class="bb"><?php $con = $i->asiento_interior_frontal;
                    if ($con == 1) {
                        echo "✔";
                    } else if ($con == 2) {
                        echo "O";
                    } else if ($con == 3) {
                        echo "F";
                    } else if ($con == 4) {
                        echo "D";
                    } else if ($con == 5) {
                        echo "R";
                    } else if ($con == 7) {
                        echo "N/A";
                    } ?></div>
                <div class="bb"><?php $con = $i->asiento_interior_trasera;
                    if ($con == 1) {
                        echo "✔";
                    } else if ($con == 2) {
                        echo "O";
                    } else if ($con == 3) {
                        echo "F";
                    } else if ($con == 4) {
                        echo "D";
                    } else if ($con == 5) {
                        echo "R";
                    } else if ($con == 7) {
                        echo "N/A";
                    } ?></div>
                <div class="bb"><?php $con = $i->asiento_delantera_frontal;
                    if ($con == 1) {
                        echo "✔";
                    } else if ($con == 2) {
                        echo "O";
                    } else if ($con == 3) {
                        echo "F";
                    } else if ($con == 4) {
                        echo "D";
                    } else if ($con == 5) {
                        echo "R";
                    } else if ($con == 7) {
                        echo "N/A";
                    } ?>  </div>
                <div class="bb"><?php $con = $i->asiento_delantera_trasera;
                    if ($con == 1) {
                        echo "✔";
                    } else if ($con == 2) {
                        echo "O";
                    } else if ($con == 3) {
                        echo "F";
                    } else if ($con == 4) {
                        echo "D";
                    } else if ($con == 5) {
                        echo "R";
                    } else if ($con == 7) {
                        echo "N/A";
                    } ?></div>


            </div> <!--IFS FIN-->


            <!--SECCION RESTANTE-->


            <div class="similares ">


                <div class="text-right"><label class="level-1  " for="text">Consola Central</label></div>
                <div class="bb"><?php $con = $i->consola_central;
                    if ($con == 1) {
                        echo "✔";
                    } else if ($con == 2) {
                        echo "O";
                    } else if ($con == 3) {
                        echo "F";
                    } else if ($con == 4) {
                        echo "D";
                    } else if ($con == 5) {
                        echo "R";
                    } else if ($con == 7) {
                        echo "N/A";
                    } ?></div>
                <div class="text-right"><label class="level-2 " for="text">Claxon</label></div>
                <div class="bb"><?php $con = $i->claxon;
                    if ($con == 1) {
                        echo "✔";
                    } else if ($con == 2) {
                        echo "O";
                    } else if ($con == 3) {
                        echo "F";
                    } else if ($con == 4) {
                        echo "D";
                    } else if ($con == 5) {
                        echo "R";
                    } else if ($con == 7) {
                        echo "N/A";
                    } ?></div>
                <div class="text-right"><label class=" " for="text">Tablero</label></div>
                <div class="bb"><?php $con = $i->tablero;
                    if ($con == 1) {
                        echo "✔";
                    } else if ($con == 2) {
                        echo "O";
                    } else if ($con == 3) {
                        echo "F";
                    } else if ($con == 4) {
                        echo "D";
                    } else if ($con == 5) {
                        echo "R";
                    } else if ($con == 7) {
                        echo "N/A";
                    } ?></div>


                <div class="text-right"><label class=" " for="text">Quemacocos</label></div>
                <div class="bb"><?php $con = $i->quemacocos;
                    if ($con == 1) {
                        echo "✔";
                    } else if ($con == 2) {
                        echo "O";
                    } else if ($con == 3) {
                        echo "F";
                    } else if ($con == 4) {
                        echo "D";
                    } else if ($con == 5) {
                        echo "R";
                    } else if ($con == 7) {
                        echo "N/A";
                    } ?></div>


                <div class="text-right"><label class=" " for="text">Toldo</label></div>
                <div class="bb"><?php $con = $i->toldo;
                    if ($con == 1) {
                        echo "✔";
                    } else if ($con == 2) {
                        echo "O";
                    } else if ($con == 3) {
                        echo "F";
                    } else if ($con == 4) {
                        echo "D";
                    } else if ($con == 5) {
                        echo "R";
                    } else if ($con == 7) {
                        echo "N/A";
                    } ?></div>


                <div class="text-right">
                    <l abel class=" " for="text">Elevadores Eléctricos</label>
                </div>
                <div class="bb"><?php $con = $i->elevadores_eletricos;
                    if ($con == 1) {
                        echo "✔";
                    } else if ($con == 2) {
                        echo "O";
                    } else if ($con == 3) {
                        echo "F";
                    } else if ($con == 4) {
                        echo "D";
                    } else if ($con == 5) {
                        echo "R";
                    } else if ($con == 7) {
                        echo "N/A";
                    } ?></div>

                <div class="text-right"><label class=" " for="text">Luces Interiores</label></div>
                <div class="bb"><?php $con = $i->luces_interiores;
                    if ($con == 1) {
                        echo "✔";
                    } else if ($con == 2) {
                        echo "O";
                    } else if ($con == 3) {
                        echo "F";
                    } else if ($con == 4) {
                        echo "D";
                    } else if ($con == 5) {
                        echo "R";
                    } else if ($con == 7) {
                        echo "N/A";
                    } ?></div>


                <div class="text-right"><label class=" " for="text">Seguros Eléctricos</label></div>
                <div class="bb"> <?php $con = $i->seguros_eletricos;
                    if ($con == 1) {
                        echo "✔";
                    } else if ($con == 2) {
                        echo "O";
                    } else if ($con == 3) {
                        echo "F";
                    } else if ($con == 4) {
                        echo "D";
                    } else if ($con == 5) {
                        echo "R";
                    } else if ($con == 7) {
                        echo "N/A";
                    } ?></div>


                <div class="text-right"><label class=" " for="text">Tapetes <span
                                class="bb"><?php echo $i->tapetes; ?></span></label></div>
                <div class="bb"></label> <?php $con = $i->tapetes;
                    if ($con == 1) {
                        echo "✔";
                    } else if ($con == 2) {
                        echo "O";
                    } else if ($con == 3) {
                        echo "F";
                    } else if ($con == 4) {
                        echo "D";
                    } else if ($con == 5) {
                        echo "R";
                    } else if ($con == 7) {
                        echo "N/A";
                    } ?></div>
                <div class="text-right"><label class=" " for="text">A.C./Climatizador </label></div>
                <div class="bb"><?php $con = $i->climatizador;
                    if ($con == 1) {
                        echo "✔";
                    } else if ($con == 2) {
                        echo "O";
                    } else if ($con == 3) {
                        echo "F";
                    } else if ($con == 4) {
                        echo "D";
                    } else if ($con == 5) {
                        echo "R";
                    } else if ($con == 7) {
                        echo "N/A";
                    } ?></div>
                <div class="text-right"><label class="" for="text">Radio</label></div>
                <div class="bb">
                    <?php
                    $con = $i->radio;
                    if ($con == 1) {
                        echo "✔";
                    } else if ($con == 2) {
                        echo "O";
                    } else if ($con == 3) {
                        echo "F";
                    } else if ($con == 4) {
                        echo "D";
                    } else if ($con == 5) {
                        echo "R";
                    } else if ($con == 7) {
                        echo "N/A";
                    }
                    ?>
                </div>
                <div class="text-right"><label class="" for="text">Espejo Retrovisor</label></div>
                <div class="bb">
                    <?php
                    $con = $i->espejos_retrovizor;
                    if ($con == 1) {
                        echo "✔";
                    } else if ($con == 2) {
                        echo "O";
                    } else if ($con == 3) {
                        echo "F";
                    } else if ($con == 4) {
                        echo "D";
                    } else if ($con == 5) {
                        echo "R";
                    } else if ($con == 7) {
                        echo "N/A";
                    }
                    ?>
                </div>
            </div> <!--borde IFS FIN-->
        </div> <!--interiores-->

        @endforeach
    </div>

    @foreach ($ExterioresEquipo as $e)
    <div class="exteriores">
        <h6 class="titulo-principal">Condiciones de Exteriores y Equipo</h6>
    </div>
    <div class="bloque-r-50 layo">  <!-- bloque r 50-->
        <div class="similares"> <!-- similares r 50-->
            <div><label class="level-1 text--right" for="text">Antena/radio</label></div>
            <div class="bb">
                <?php
                $con = $e->antena_radio;
                if ($con == 1) {
                    echo "✔";
                } else if ($con == 2) {
                    echo "O";
                } else if ($con == 3) {
                    echo "F";
                } else if ($con == 4) {
                    echo "D";
                } else if ($con == 5) {
                    echo "R";
                } else if ($con == 7) {
                    echo "N/A";
                }
                ?>
            </div>
            <div>
                <label class="level-2 text--right" for="text">Estribos</label>
            </div>
            <div class="bb">
                <?php
                $con = $e->estribos;
                if ($con == 1) {
                    echo "✔";
                } else if ($con == 2) {
                    echo "O";
                } else if ($con == 3) {
                    echo "F";
                } else if ($con == 4) {
                    echo "D";
                } else if ($con == 5) {
                    echo "R";
                } else if ($con == 7) {
                    echo "N/A";
                }
                ?>
            </div>
            <div><label class=" text--right" for="text">Antena/teléfono</label></div>
            <div class="bb">
                <?php
                $con = $e->antena_telefono;
                if ($con == 1) {
                    echo "✔";
                } else if ($con == 2) {
                    echo "O";
                } else if ($con == 3) {
                    echo "F";
                } else if ($con == 4) {
                    echo "D";
                } else if ($con == 5) {
                    echo "R";
                } else if ($con == 7) {
                    echo "N/A";
                }
                ?>
            </div>
            <div class="fl">
                <label class=" text--right" for="text">Guardafangos</label>
            </div>
            <div class="bb">
                <?php
                $con = $e->guardafangos;
                if ($con == 1) {
                    echo "✔";
                } else if ($con == 2) {
                    echo "O";
                } else if ($con == 3) {
                    echo "F";
                } else if ($con == 4) {
                    echo "D";
                } else if ($con == 5) {
                    echo "R";
                } else if ($con == 7) {
                    echo "N/A";
                }
                ?>
            </div>
            <div><label class=" text--right" for="text">Antena/C.B.</label></div>
            <div class="bb">
                <?php
                $con = $e->antena_cb;
                if ($con == 1) {
                    echo "✔";
                } else if ($con == 2) {
                    echo "O";
                } else if ($con == 3) {
                    echo "F";
                } else if ($con == 4) {
                    echo "D";
                } else if ($con == 5) {
                    echo "R";
                } else if ($con == 7) {
                    echo "N/A";
                }
                ?>
            </div>
            <div>
                <label class=" text--right" for="text">Parabrisas</label>
            </div>
            <div class="bb">
                <?php
                $con = $e->parabrisas;
                if ($con == 1) {
                    echo "✔";
                } else if ($con == 2) {
                    echo "O";
                } else if ($con == 3) {
                    echo "F";
                } else if ($con == 4) {
                    echo "D";
                } else if ($con == 5) {
                    echo "R";
                } else if ($con == 7) {
                    echo "N/A";
                }
                ?>
            </div>
            <div><label class=" text--right" for="text">Sist. de Alarma</label></div>
            <div class="bb">
                <?php
                $con = $e->sistema_alarma;
                if ($con == 1) {
                    echo "✔";
                } else if ($con == 2) {
                    echo "O";
                } else if ($con == 3) {
                    echo "F";
                } else if ($con == 4) {
                    echo "D";
                } else if ($con == 5) {
                    echo "R";
                } else if ($con == 7) {
                    echo "N/A";
                }
                ?>
            </div>
            <div>
                <label class=" text--right" for="text">Limpiaparabrisas</label>
            </div>
            <div class="bb">
                <?php
                $con = $e->limpia_parabrisas;
                if ($con == 1) {
                    echo "✔";
                } else if ($con == 2) {
                    echo "O";
                } else if ($con == 3) {
                    echo "F";
                } else if ($con == 4) {
                    echo "D";
                } else if ($con == 5) {
                    echo "R";
                } else if ($con == 7) {
                    echo "N/A";
                }
                ?>
            </div>
            <div><label class=" text--right" for="text">Luces Exteriores</label></div>
            <div class="bb">
                <?php
                $con = $e->luces_exteriores;
                if ($con == 1) {
                    echo "✔";
                } else if ($con == 2) {
                    echo "O";
                } else if ($con == 3) {
                    echo "F";
                } else if ($con == 4) {
                    echo "D";
                } else if ($con == 5) {
                    echo "R";
                } else if ($con == 7) {
                    echo "N/A";
                }
                ?>
            </div>
            <div><label class=" text--right" for="text">Espejos Laterales</label></div>
            <div class="bb">
                <?php
                $con = $e->espejos_laterales;
                if ($con == 1) {
                    echo "✔";
                } else if ($con == 2) {
                    echo "O";
                } else if ($con == 3) {
                    echo "F";
                } else if ($con == 4) {
                    echo "D";
                } else if ($con == 5) {
                    echo "R";
                } else if ($con == 7) {
                    echo "N/A";
                }
                ?>
            </div>
            <div class="bb">
                <label for="text">
                    <span>

                    </span>
                </label>
            </div>
            <div class="bb">
                <label for="text">
                   <?php
//                    $con = $row_Recordset1['vextra1'];
//                    if ($con == 1) {
//                        echo "✔";
//                    } else if ($con == 2) {
//                        echo "O";
//                    } else if ($con == 3) {
//                        echo "F";
//                    } else if ($con == 4) {
//                        echo "D";
//                    } else if ($con == 5) {
//                        echo "R";
//                    } else if ($con == 7) {
//                        echo "N/A";
//                    }
                    ?>
                </label>
            </div>
            <div class="bb">
                <label for="text">
                    <span>

                    </span>
                </label>
            </div>
            <div class="bb">
                <label for="text">
                   <?php
//                    $con = $row_Recordset1['vextra2'];
//                    if ($con == 1) {
//                        echo "✔";
//                    } else if ($con == 2) {
//                        echo "O";
//                    } else if ($con == 3) {
//                        echo "F";
//                    } else if ($con == 4) {
//                        echo "D";
//                    } else if ($con == 5) {
//                        echo "R";
//                    } else if ($con == 7) {
//                        echo "N/A";
//                    }
                    ?>
                </label>
            </div>
        </div> <!-- bloque r 50-->
    </div>   <!-- similares r 50-->

    @endforeach

    @foreach ($EquipoInventario as $ei)
    <div class="bloque-varios ">  <!--  varios-->
        <div><h6 class="titulo-principal">Varios Equipos - Inventario</h6></div>
        <div class="g-3">
            <div><p>SI </p></div>
            <div><P>NO</P></div>
            <div></div>
            <div class="cuadrado">
                <?php if($ei->llanta == 1 ){
                echo "✔";
                } ?>
            </div>
            <div class="cuadrado">
            <?php if($ei->llanta == 0 ){
                echo "✔";
            } ?>
            </div>
            <div><p>Llantas de Refacción</p></div>
            <div class="cuadrado">
            <?php if($ei->cubreruedas == 1 ){
                echo "✔";
            } ?>
            </div>
            <div class="cuadrado">
            <?php if($ei->cubreruedas == 0 ){
                echo "✔";
            } ?>
            </div>
            <div><p>Cubreruedas</p></div>
            <div class="cuadrado">
            <?php if($ei->candado_ruedas == 1 ){
                echo "✔";
            } ?>
            </div>
            <div class="cuadrado">
            <?php if($ei->candado_ruedas == 0 ){
                echo "✔";
            } ?>
            </div>
            <div><p>Candado de Ruedas</p></div>
            <div class="cuadrado">
            <?php if($ei->gato == 1 ){
                echo "✔";
            } ?>
            </div>
            <div class="cuadrado">
            <?php if($ei->gato == 0 ){
                echo "✔";
            } ?>
            </div>
            <div><p>Gato</p></div>
            <div class="cuadrado">
            <?php if($ei->llave_tuercas == 1 ){
                echo "✔";
            } ?>
            </div>
            <div class="cuadrado">
            <?php if($ei->llave_tuercas == 0 ){
                echo "✔";
            } ?>
            </div>
            <div><p>Llave para Tuercas de Rueda</p></div>
            <div class="cuadrado">
            <?php if($ei->triangulo_seguridad == 1 ){
                echo "✔";
            } ?>
            </div>
            <div class="cuadrado">
            <?php if($ei->triangulo_seguridad == 0 ){
                echo "✔";
            } ?>
            </div>
            <div><p>Triángulo de Seguridad</p></div>
            <div class="cuadrado">
            <?php if($ei->extinguidor == 1 ){
                echo "✔";
            } ?>
            </div>
            <div class="cuadrado">
            <?php if($ei->extinguidor == 0 ){
                echo "✔";
            } ?>
            </div>
            <div><p>Extinguidor</p></div>
            <div class="cuadrado">
            <?php if($ei->cables_corriente == 1 ){
                echo "✔";
            } ?>
            </div>
            <div class="cuadrado">
            <?php if($ei->cables_corriente == 0 ){
                echo "✔";
            } ?>
            </div>
            <div><p>Cables para Corriente</p></div>
            <div class="cuadrado">
            <?php if($ei->estuche_herramientas == 1 ){
                echo "✔";
            } ?>
            </div>
            <div class="cuadrado">
            <?php if($ei->estuche_herramientas == 0 ){
                echo "✔";
            } ?>
            </div>
            <div><p>Estuche de Herramientas</p></div>
            <div class="cuadrado">
            <?php if($ei->tarjeta_circulacion == 1 ){
                echo "✔";
            } ?>
            </div>
            <div class="cuadrado">
            <?php if($ei->tarjeta_circulacion == 0 ){
                echo "✔";
            } ?>
            </div>
            <div><p>Tarjeta de Circulación</p></div>
            <div class="cuadrado">
            <?php if($ei->placas == 1 ){
                echo "✔";
            } ?>
            </div>
            <div class="cuadrado">
            <?php if($ei->placas == 0 ){
                echo "✔";
            } ?>
            </div>
            <div>
                <p>Placas</p>
            </div>
        </div> <!--g3-->
    </div> <!--  varios-->
    @endforeach


    @foreach ($condicionesPintura as $cp)
    <div class="level--2"><h6 class="titulo-principal">Condiciones de Pintura</h6></div>
    <div class="bloque-r-50 level--2 row--3"> <!-- contenedor pintura  50 r-->
        <div class="bloque-4"> <!-- bloque-cond-int -->
            <div><label class="level-1" for="text">SI</label></div>
            <div><label class="level-1" for="text">NO</label></div>
            <div></div>
            <div><label class="level-2" for="text">SI </label></div>
            <div><label class="level-2" for="text">NO</label></div>
            <div></div>
            <div class="cuadrado">
                <label class="" for="text">
                <?php if($cp->decolorada== 1 ){
                echo "✔";
            } ?>
                </label>
            </div>
            <div class="cuadrado">
                <label class="" for="text">
                <?php if($cp->decolorada == 0 ){
                echo "✔";
            } ?>
                </label>
            </div>
            <div>Decolorada</div>
            <div class="cuadrado">
                <label class="" for="text">
                <?php if($cp->logos == 1 ){
                echo "✔";
            } ?>
                </label>
            </div>
            <div class="cuadrado">
                <label for="text">
                <?php if($cp->logos == 0 ){
                echo "✔";
            } ?>
                </label>
            </div>
            <div>Logos en buen estado</div>
            <div class="cuadrado">
                <label for="text">
                <?php if($cp->color_no_igual == 1 ){
                echo "✔";
            } ?>
                </label>
            </div>
            <div class="cuadrado">
                <label for="text">
                <?php if($cp->color_no_igual == 0 ){
                echo "✔";
            } ?>
                </label>
            </div>
            <div>Color no igualado</div>
            <div class="cuadrado">
                <label class="" for="text">
                <?php if($cp->exeso_rociado == 1 ){
                echo "✔";
            } ?>
                </label>
            </div>
            <div class="cuadrado">
                <label for="text">
                <?php if($cp->exeso_rociado == 0 ){
                echo "✔";
            } ?>
                </label>
            </div>
            <div>Exceso de rociado</div>
            <div class="cuadrado">
                <label class="" for="text">
                <?php if($cp->exeso_rayones == 1 ){
                echo "✔";
            } ?>
                </label>
            </div>
            <div class="cuadrado">
                <label for="text">
                <?php if($cp->exeso_rayones == 0 ){
                echo "✔";
            } ?>
                </label>
            </div>
            <div>Exceso de rayones</div>
            <div class="cuadrado">
                <label class="" for="text">
                <?php if($cp->danios_granizado == 1 ){
                echo "✔";
            } ?>
                </label>
            </div>
            <div class="cuadrado">
                <label for="text">
                <?php if($cp->danios_granizado == 0 ){
                echo "✔";
            } ?>
                </label>
            </div>
            <div>Daños por granizo</div>
            <div class="cuadrado">
                <label class="" for="text">
                <?php if($cp->pequenias_grietas == 1 ){
                echo "✔";
            } ?>
                </label>
            </div>
            <div class="cuadrado">
                <label for="text">
                <?php if($cp->pequenias_grietas == 0 ){
                echo "✔";
            } ?>
                </label>
            </div>
            <div>Pequeñas grietas</div>
            <div class="cuadrado">
                <label class="" for="text">
                <?php if($cp->lluvia_acido == 1 ){
                echo "✔";
            } ?>
                </label>
            </div>
            <div class="cuadrado">
                <label for="text">
                <?php if($cp->lluvia_acido == 0 ){
                echo "✔";
            } ?>
                </label>
            </div>
            <div>Lluvia ácida</div>
            <div class="cuadrado">
                <label class="" for="text">
                <?php if($cp->carroceria_golpes == 1 ){
                echo "✔";
            } ?>
                </label>
            </div>
            <div class="cuadrado">
                <label for="text">
                <?php if($cp->carroceria_golpes == 0 ){
                echo "✔";
            } ?>
                </label>
            </div>
            <div> Carroceria con golpes</div>
            <div class="cuadrado">
                <label class="" for="text">

                </label>
            </div>
            <div class="cuadrado">
                <label for="text">

                </label>
            </div>
            <div class="bb">
                <label for="text">

                </label>
            </div>
            <div class="cuadrado">
                <label class="" for="text">
                <?php if($cp->emblemas_completos == 1 ){
                echo "✔";
            } ?>
                </label>
            </div>
            <div class="cuadrado">
                <label for="text">
                <?php if($cp->emblemas_completos == 0 ){
                echo "✔";
            } ?>
                </label>
            </div>
            <div>Emblemas completos</div>
            <div class="cuadrado"><label class="" for="text">

                </label>
            </div>
            <div class="cuadrado">
                <label for="text">

                </label>
            </div>
            <div class="bb">
                <label for="text">

                </label>
            </div>
        </div> <!-- bloque-cond-int -->
    </div><!-- contenedor pintura  50 r-->

    @endforeach
    <div class="layo-car bor "> <!--carro -->
        <div class="ffond">
            <img src="{{asset('/storage/carror/'.$c->carro.'')}}" alt="Tipo de vehiculo" id="v" alt="Carros" width="100%" height="156"
                 usemap="#carro_8" border="0"/>
        </div>
       
        </div> <!--carro -->
        <div class="nnno bor"> <!--final content -->
            <div class="notas col-md-12 fl ">
                <p>Notas:
                    <span class="table--text"> {{$c->notas_adicionales}}</span>
                </p>
            </div>
            <div class="leyenda  bor"> <!--leyenda -->
                <p class="lll">
                    Hemos registrado los daños en su vehículo que no están relacionados con las reparaciones
                    autorizadas.
                    El que usted y nuestro representante hayan revisado estas áreas conjuntamente,
                    ambos podemos tener la seguridad del mejor servicio posible. Hemos indicado cada área de daño o
                    defecto,
                    junto con otros artículos diversos, por favor no dude en ayudarnos mientras llenamos este formato.
                </p>
                <div class="recibido cent">
                    {{--todo ruta imagen--}}
                    <img src="{{asset('/storage/firmas/'.$c->firma)}}"
                         width="100%"
                         height="80px"/>
                    <p>Firma de Recibido</p></div>
                <div class=" cliente cent ">
                    <p class="arriba-abajo">___________________________________ <br> <br> Firma del Cliente</p>
                </div>
            </div><!--leyenda -->
            <div class="indicaciones  bor ">
                <p>Indicaciones del cliente:
                    <span class="table--text">
                       {{$c->indicaciones_del_cliente}}
                    </span>
                </p>
            </div>
            <div class="akumas">
                {{--todo--}}
            </div>
            <div class="pix">
                <img src="{{asset('img/LogoAkumas.png')}}" alt="Logotipo Akumas">
                <p>ECO IMPULSA, S.A. DE .C.V. <br>
                    PUERTO DE ACAPULCO #328, COL. RINCON DEL ANGEL. C.P. 58337 <br>
                    MORELIA, MICH, TEL (433) 2532182
                </p>
            </div>
        </div>
    </div><!--final content -->
</div> <!--container -->
<div class="fi">
    <a class="" href="#">
        <button onclick="window.print()"><img src="{{asset('img/imprime.jpg')}}" height="50"/></button>
    </a>
</div>

@endforeach
</body>
</html>
