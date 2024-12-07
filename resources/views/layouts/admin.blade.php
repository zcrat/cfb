<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Akumas | www.akumas.mx</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 4.3.1 -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-select.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('css/font-awesome.css')}}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('css/_all-skins.min.css')}}">
    <link rel="apple-touch-icon" href="{{asset('img/apple-touch-icon.png')}}">
    <link rel="shortcut icon" href="{{asset('img/favicon.ico')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script href="{{asset('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js')}}"></script>
    <link href="{{asset('css/plantilla.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/vue-multiselect@2.1.0/dist/vue-multiselect.min.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
   
    <link rel="stylesheet" href="{{asset('css/estilosnavbar.css')}}">
  </head>
  <body>
    <div id="app">
      <nav class="msidebar">
        <ul class="msidebar-links" id="msidebar">
          <li class="logotipo">
              <a href="{{ route('homevue') }}"><img class="logoimg" src="{{asset('img/logo_cfb.png')}}" alt="">
              </a>
              <span class="contraer"><i class="fas fa-stream"></i></span>
          </li>
          @can('clientes.index') 
            <li >
              <a>
                <i class="fa fa-group"></i>
                <span>Clientes</span>
              </a>
              <ul class="menudown">
                <div>
                  <li ><a href="{{ route('cliente.usuarios') }}" ><i class="fa fa-user"></i> Usuarios</a></li>
                  <li ><a href="{{ route('cliente.empresas') }}" ><i class="fa fa-user"></i> Empresas</a></li>
                </div>
              </ul>
            </li>
          @endcan
          @can('almacen.index') 
            <li >
              <a>
                <i class="fa fa-building"></i>
                <span>Almacén</span>
              </a>
              <ul>
                <div>
                <li class="vista"  @click="$store.state.menuc=1" ><a href="#" ><i class="fa fa-cubes"></i> Productos & Servios</a></li>
                <li class="vista"  @click="$store.state.menuc=26" ><a href="#" ><i class="fa fa-cubes"></i> Productos por Grupos</a></li>
                <li class="vista"  @click="$store.state.menuc=2" ><a href="#" ><i class="fa fa-cube"></i> Categorías</a></li>
                </div>
              </ul>
            </li>
          @endcan
          @can('compras.index') 
            <li>
              <a>
                <i class="fa fa-th"></i>
                <span>Compras</span>
              </a>
              <ul>
                <div>
                  <li class="vista"  @click="$store.state.menuc=4"><a href="#"><i class="fa fa-bar-chart"></i> Ingresos</a></li>
                  <li class="vista"  @click="$store.state.menuc=5"><a href="#"><i class="fa fa-user"></i> Proveedores</a></li>
                </div>
              </ul>
            </li>
          @endcan
          @can('ventas.index') 
            <li>
              <a>
                <i class="fa fa-shopping-cart"></i>
                <span>Ventas</span>
              </a>
              <ul>
                <div>
                <li class="vista"  @click="$store.state.menuc=6"><a href="#"><i class="fa fa-bar-chart"></i> Ventas</a></li>
                <li class="vista"  @click="$store.state.menuc=7"><a href="#"><i class="fa fa-user"></i> Clientes</a></li>
                </div>
              </ul>
            </li>
          @endcan      
          @can('acceso.index') 
            <li >
              <a>
                <i class="fa fa-address-card"></i> <span>Acceso</span>
              </a>
              <ul>
                <div>
                @can('user.index') 
                  <li class="vista"  @click="$store.state.menuc=8"><a href="#"><i class="fa fa-user"></i> Usuarios</a></li>
                @endcan
                @can('roles.index') 
                  <li class="vista"  @click="$store.state.menuc=9"><a href="#"><i class="fa fa-cubes"></i> Roles</a></li>
                @endcan
                </div>
              </ul>
            </li>
          @endcan
          @can('facturacion.index') 
            <li >
              <a>
                <i class="fa fa-file"></i>
                <span>Facturacion</span>
              </a>
              <ul>
                <div>
                <li class="vista"  @click="$store.state.menuc=15" ><a href="#" ><i class="fa fa-file"></i> Facturas</a></li>
                <li class="vista"  @click="$store.state.menuc=38" ><a href="#" ><i class="fa fa-file"></i> Facturas por cobrar</a></li>
                <li class="vista"  @click="$store.state.menuc=52" ><a href="#" ><i class="fa fa-file"></i> Facturas por contrato</a></li>
                <li class="vista"  @click="$store.state.menuc=16" ><a href="#" ><i class="fa fa-cog"></i> Configuracion</a></li>
                </div>
              </ul>
            </li>
          @endcan
          @can('formatos.index') 
            <li >
              <a>
                <i class="fa fa-laptop"></i>
                <span>Formatos</span>
              </a>
              <ul>
                <div>
                <li class="vista"  @click="$store.state.menuc=13" ><a href="#" ><i class="fas fa-circle"></i> Recepción Vehicular</a></li>
                <li class="vista"  @click="$store.state.menuc=17" ><a href="#" ><i class="fas fa-circle"></i> Inspección Vehicular</a></li>
                <li class="vista"  @click="$store.state.menuc=18" ><a href="#" ><i class="fas fa-file-invoice-dollar"></i> Hoja de Conceptos</a></li>
                <li class="vista"  @click="$store.state.menuc=19" ><a href="#" ><i class="fas fa-circle"></i> Reporte de Grúa</a></li>
                <li class="vista"  @click="$store.state.menuc=20" ><a href="#" ><i class="fas fa-circle"></i> Orden de Compra</a></li>
                <li class="vista"  @click="$store.state.menuc=21" ><a href="#" ><i class="fas fa-circle"></i> Orden de Reparación</a></li>
                <li class="vista"  @click="$store.state.menuc=25" ><a href="#" ><i class="fas fa-circle"></i> Cotización</a></li>
                </div>
              </ul>
            </li>
          @endcan
          @can('tecnico.index') 
            <li >
              <a>
                <i class="fas fa-wrench"></i>
                <span>Tecnico</span>
                
              </a>
              <ul>
                <div>
                <li class="vista"  @click="$store.state.menuc=22" >
                  <a href="#" >
                    <i class="fas fa-id-badge"></i>
                    Asignar Tecnico Recepción
                  </a>
                </li>
                <li class="vista"  @click="$store.state.menuc=23" >
                  <a href="#" >
                    <i class="fas fa-clipboard"></i>
                    Mis recepciones
                  </a>
                </li>
              </div>
              </ul>
            </li>
          @endcan
          @can('sucursales.index') 
            <li >
              <a>
                <i class="fa fa-cog"></i> <span>Configuraciòn</span>
              </a>
              <ul>
                <div>
                <li class="vista"  @click="$store.state.menuc=24"><a href="#"><i class="fa fa-user-tag"></i> Sucursales</a></li>
                <li class="vista"  @click="$store.state.menuc=37"><a href="#"><i class="fa fa-user-tag"></i> Contratos</a></li>
                <li class="vista"  @click="$store.state.menuc=42"><a href="#"><i class="fa fa-user-tag"></i> Ubicaciones</a></li>
                <li class="vista"  @click="$store.state.menuc=43"><a href="#"><i class="fa fa-user-tag"></i> Areas</a></li>
                <li class="vista"  @click="$store.state.menuc=44"><a href="#"><i class="fa fa-user-tag"></i> Categorias CFE</a></li>
                <li class="vista"  @click="$store.state.menuc=45"><a href="#"><i class="fa fa-user-tag"></i> Categorias CFB/ECO</a></li>
                <li class="vista"  @click="$store.state.menuc=100"><a href="#"><i class="fa fa-user-tag"></i> Categorias CFB/ECO 2024</a></li>
                <li class="vista"  @click="$store.state.menuc=93"><a href="#"><i class="fa fa-user-tag"></i> Categorias Foraneas</a></li>
                <li class="vista"  @click="$store.state.menuc=46"><a href="#"><i class="fa fa-user-tag"></i> Tipos CFE</a></li>
                <li class="vista"  @click="$store.state.menuc=47"><a href="#"><i class="fa fa-user-tag"></i> Tipos CFB/ECO</a></li>
                <li class="vista"  @click="$store.state.menuc=99"><a href="#"><i class="fa fa-user-tag"></i> Tipos CFB/ECO 2024</a></li>
                <li class="vista"  @click="$store.state.menuc=94"><a href="#"><i class="fa fa-user-tag"></i> Tipos Foraneas</a></li>
                <li class="vista"  @click="$store.state.menuc=48"><a href="#"><i class="fa fa-user-tag"></i> Conceptos CFE</a></li>
                <li class="vista"  @click="$store.state.menuc=49"><a href="#"><i class="fa fa-user-tag"></i> Conceptos CFB/ECO</a></li>
                <li class="vista"  @click="$store.state.menuc=77"><a href="#"><i class="fa fa-user-tag"></i> Conceptos CFB/ECO 2024</a></li>
                <li class="vista"  @click="$store.state.menuc=92"><a href="#"><i class="fa fa-user-tag"></i> Conceptos Foraneos</a></li>
                <li class="vista"  @click="$store.state.menuc=68"><a href="#"><i class="fa fa-user-tag"></i> Tareas Admin</a></li>        
                </div>
              </ul>
            </li>
          @endcan 
          @can('reportes.index') 
            <li>
              <a>
                <i class="fa fa-folder"></i> <span>Reportes</span>
              </a>
              <ul>
                <div>
                <li class="vista"  @click="$store.state.menuc=10"><a href="#"><i class="fas fa-wallet"></i></i> Reporte Ingresos</a></li>
                <li class="vista"  @click="$store.state.menuc=11"><a href="#"><i class="fas fa-money-check"></i></i> Reporte Ventas</a></li>
                </div>
              </ul>
            </li>
          @endcan
          @can('caja.index') 
            <li >
              <a>
                <i class="fa fa-money"></i> <span>Control de caja</span>
              </a>
              <ul>
                <div>
                <li class="vista"  @click="$store.state.menuc=29"><a href="#"><i class="fas fa-circle"></i> Operaciones Caja</a></li>
                <li class="vista"  @click="$store.state.menuc=50"><a href="#"><i class="fas fa-circle"></i> Operaciones Bancos</a></li>
                <li class="vista"  @click="$store.state.menuc=27"><a href="#"><i class="fas fa-circle"></i> Bancos</a></li>
                <li class="vista"  @click="$store.state.menuc=28"><a href="#"><i class="fas fa-circle"></i> Cuentas</a></li>
                <li class="vista"  @click="$store.state.menuc=51"><a href="#"><i class="fas fa-circle"></i> Saldos</a></li>
                </div> 
              </ul>
            </li>
          @endcan 
          @canany(['cfeB2023.index', 'cfeO2023.index','cfeeco.index'])
            <li>
              <a><i class="fas fa-users"></i><span >CFE 2024</span></a>
              <ul>
                <div>
                  @can('cfeeco.index') 
                    <li class="vista"  @click="$store.state.menuc=101" data-id="cfe2024eco" >
                      <a href="#">
                        <i  class="fa fa-money"></i>CFE ECO 2024
                      </a>
                      
                    </li>
                  @endcan
                  @can('cfeB2023.index') 
                    <li class="vista"  @click="$store.state.menuc=79" data-id="cfe2024bajio">
                      <a  href="#">
                        <i class="fa fa-money"></i> CFE Bajio 2024
                      </a>
                     
                    </li>
                  @endcan
                  @can('cfeO2023.index') 
                    <li class="vista"  @click="$store.state.menuc=80" data-id="cfe2024occidente">
                      <a href="#">
                        <i class="fa fa-money"></i> CFE Occidente 2024 
                      </a>
                    </li>
                  @endcan
                </div>
              </ul>
            </li>
          @endcan
          @canany(['akumas.index', 'akumas2023.index','cfbForaneos.index'])
            <li>
              <a><i class="fas fa-users"></i><span >Presupuestos CFB 2024 </span></a>
              <ul>
                <div>
                  @can('akumas.index') 
                    <li class="vista"  @click="$store.state.menuc=81" data-id="presupuestos2024cfb">
                      <a href="#">
                        <i class="fa fa-money"></i> Presupuestos CFB
                      </a>
                    </li>
                  @endcan
                  @can('akumas2023.index') 
                    <li class="vista"  @click="$store.state.menuc=82" data-id="presupuestos2024cfb2024">
                      <a href="#">
                        <i class="fa fa-money"></i> Presupuestos CFB 2024
                      </a>
                    </li>
                  @endcan
                  @can('cfbForaneos.index') 
                    <li class="vista"  @click="$store.state.menuc=87"  data-id="presupuestos2024cfbforaneos">
                      <a href="#">
                        <i class="fa fa-money"></i> Presupuestos CFB Foraneos
                      </a>
                    </li>
                  @endcan
                </div>
              </ul>
            </li>
          @endcan
          @canany(['akumas2023.index', 'cfbECOForaneos.index'])
            <li>
              <a><i class="fas fa-users"></i><span >Presupuestos Eco 2024</span></a>
              <ul>
                <div>
                  @can('akumas2023.index') 
                    <li class="vista"  @click="$store.state.menuc=106"  data-id="presupuestoseco2024eco">
                      <a href="#">
                        <i class="fa fa-money"></i> Presupuestos ECO
                      </a>
                    </li>
                  @endcan
                  @can('akumas2023.index') 
                    <li class="vista"  @click="$store.state.menuc=115"  data-id="presupuestoseco2024edenred">
                      <a href="#">
                        <i class="fa fa-money"></i> Presupuestos ECO Edenred
                      </a>
                    </li>
                  @endcan
                  @can('cfbECOForaneos.index') 
                    <li class="vista"  @click="$store.state.menuc=110"  data-id="presupuestoseco2024foraneos">
                      <a href="#">
                        <i class="fa fa-money"></i> Presupuestos ECO Foraneos
                      </a>
                    </li>
                  @endcan
                </div>
              </ul>
            </li>
          @endcan
          @can('tareas.index') 
            <li >
              <a>
                <i class="fa fa-money"></i> <span>Tareas</span>
              </a>
              <ul class="menuup">
                <div>
                <li class="vista"  @click="$store.state.menuc=76"><a href="#"><i class="fas fa-circle"></i> Tareas Ejecutivas</a></li>
                <li class="vista"  @click="$store.state.menuc=67"><a href="#"><i class="fas fa-circle"></i> Revisar Tareas</a></li>
                <li class="vista"  @click="$store.state.menuc=73"><a href="#"><i class="fas fa-circle"></i> Tecnicos</a></li>
                <li class="vista"  @click="$store.state.menuc=74"><a href="#"><i class="fas fa-circle"></i> Trasladistas</a></li>
                <li class="vista"  @click="$store.state.menuc=75"><a href="#"><i class="fas fa-circle"></i> Vehiculos</a></li>
                <li class="vista"  @click="$store.state.menuc=83"><a href="#"><i class="fas fa-circle"></i> Entradas y Salidas</a></li>
                <li class="vista"  @click="$store.state.menuc=84"><a href="#"><i class="fas fa-circle"></i> Ordenes</a></li>
                <li class="vista"  @click="$store.state.menuc=85"><a href="#"><i class="fas fa-circle"></i> Ordenes Foraneas</a></li>
                <li class="vista"  @click="$store.state.menuc=86"><a href="#"><i class="fas fa-circle"></i> ES Foraneas</a></li>
                </div>
              </ul>
            </li>
          @endcan
                        
        </ul>
      </nav>
      <div class="body-container">

        <header class="mtopbar">
          <nav>
              <ul>
                <li><a title="Menu" id="sider"><i class="fas fa-bars"></i></a></li>
                  <li class="topbar-center">
                    <a>
                      ¡Bienvenido a Akumas, {{ Auth::user()->name }}!
                    </a>
                  </li>
                  <notification-component :notifications="notifications"></notification-component>
                  <li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                      @csrf
                      <button class="btn" type="submit" title="cerrar seccion"><i class="fas fa-sign-in-alt"></i></button>
                    </form>
                  </li>
              </ul>
          </nav>
        </header>
        <section class="content">
          <div>
            <ul class="subbarra" id="cfe2024eco" hidden>
              <div>
                  @can('cfeeco.recepcion') 
                  <li @click="$store.state.menuc=101"><a href="#"><i class="fas fa-truck-pickup"></i> Recepcion Vehicular</a></li>
                  @endcan
                  @can('cfeeco.recepcion') 
                  <li @click="$store.state.menuc=102"><a href="#"><i class="fas fa-file-invoice-dollar"></i> Hoja de Conceptos</a></li>
                  @endcan
                  @can('cfeeco.externos') 
                  <li @click="$store.state.menuc=103"><a href="#"><i class="fas fa-circle"></i> Talleres Externos</a></li>
                  @endcan
                  @can('cfeeco.akumas') 
                  <li @click="$store.state.menuc=104"><a href="#"><i class="fas fa-list-alt"></i> Anexos CFE</a></li>
                  @endcan
                  @can('cfeeco.aptaller') 
                  <li @click="$store.state.menuc=105"><a href="#"><i class="fas fa-check-square"></i> Aprobaciones Taller</a></li>
                  @endcan
              </div>
            </ul>
            <ul class="subbarra" id="cfe2024bajio" hidden>
              <div>
                @can('cfeB2023.recepcion') 
                <li @click="$store.state.menuc=79"><a href="#"><i class="fas fa-truck-pickup"></i> Recepcion Vehicular</a></li>
                @endcan
                @can('cfeB2023.recepcion') 
                <li @click="$store.state.menuc=98"><a href="#"><i class="fas fa-file-invoice-dollar"></i> Hoja de Conceptos</a></li>
                @endcan
                @can('cfeB2023.externos') 
                <li @click="$store.state.menuc=53"><a href="#"><i class="fas fa-circle"></i> Talleres Externos</a></li>
                @endcan
                @can('cfeB2023.akumas') 
                <li @click="$store.state.menuc=54"><a href="#"><i class="fas fa-list-alt"></i> Anexos CFE</a></li>
                @endcan
                @can('cfeB2023.aptaller') 
                <li @click="$store.state.menuc=55"><a href="#"><i class="fas fa-check-square"></i> Aprobaciones Taller</a></li>
                @endcan
                @can('cfeB2023.aptaller') 
                <li @click="$store.state.menuc=57"><a href="#"><i class="fas fa-check-square"></i> Aprobaciones CFE Taller</a></li>
                @endcan
                {{-- @can('cfeB2023.apcfe') 
                <li @click="$store.state.menuc=56"><a href="#"><i class="fas fa-check-square"></i> Aprobaciones CFE</a></li>
                @endcan
                @can('cfeB2023.start') 
                <li @click="$store.state.menuc=58"><a href="#"><i class="fas fa-circle"></i> Start CFE</a></li>
                @endcan --}}
                @can('cfeB2023.apcfe') 
                <li @click="$store.state.menuc=59"><a href="#"><i class="fas fa-folder"></i></i> Reportes</a></li>
                @endcan
              </div>
            </ul>
            <ul class="subbarra" id="cfe2024occidente" hidden>
              <div>
                @can('cfeO2023.recepcion') 
                <li @click="$store.state.menuc=80"><a href="#"><i class="fas fa-truck-pickup"></i> Recepcion Vehicular</a></li>
                @endcan
                @can('cfeO2023.recepcion') 
                <li @click="$store.state.menuc=97"><a href="#"><i class="fas fa-file-invoice-dollar"></i> Hoja de Conceptos</a></li>
                @endcan
                @can('cfeO2023.externos') 
                <li @click="$store.state.menuc=60"><a href="#"><i class="fas fa-circle"></i> Talleres Externos</a></li>
                @endcan
                @can('cfeO2023.akumas') 
                <li @click="$store.state.menuc=61"><a href="#"><i class="fas fa-list-alt"></i> Anexos CFE</a></li>
                @endcan
                @can('cfeO2023.aptaller') 
                <li @click="$store.state.menuc=62"><a href="#"><i class="fas fa-check-square"></i> Aprobaciones Taller</a></li>
                @endcan
                {{-- @can('cfeO2023.aptaller') 
                <li @click="$store.state.menuc=64"><a href="#"><i class="fas fa-check-square"></i> Aprobaciones CFE Taller</a></li>
                @endcan
                @can('cfeO2023.apcfe') 
                <li @click="$store.state.menuc=63"><a href="#"><i class="fas fa-check-square"></i> Aprobaciones CFE</a></li>
                @endcan --}}
                @can('cfeO2023.start') 
                <li @click="$store.state.menuc=65"><a href="#"><i class="fas fa-circle"></i> Start CFE</a></li>
                @endcan
              
                @can('cfeO2023.apcfe') 
                <li @click="$store.state.menuc=66"><a href="#"><i class="fas fa-folder"></i></i> Reportes</a></li>
                @endcan
              </div>
            </ul>
            <ul class="subbarra" id="presupuestos2024cfb" hidden>
              <div>
                @can('akumas.recepcion') 
                <li @click="$store.state.menuc=81"><a href="#"><i class="fas fa-truck-pickup"></i> Recepcion Vehicular</a></li>
                @endcan
                @can('akumas.recepcion') 
                <li @click="$store.state.menuc=96"><a href="#"><i class="fas fa-file-invoice-dollar"></i> Hoja de Conceptos</a></li>
                @endcan
                @can('akumas.presupuestos') 
                <li @click="$store.state.menuc=34"><a href="#"><i class="fas fa-list-alt"></i> Anexos Taller</a></li>
                @endcan
                @can('akumas.aprobaciones') 
                <li @click="$store.state.menuc=35"><a href="#"><i class="fas fa-check-square"></i> Aprobaciones</a></li>
                @endcan
                @can('akumas.start') 
                <li @click="$store.state.menuc=40"><a href="#"><i class="fas fa-circle"></i> Start Akumas</a></li>
                @endcan
                @can('akumas.reportes') 
                <li @click="$store.state.menuc=36"><a href="#"><i class="fas fa-folder"></i></i> Reportes</a></li>
                @endcan
              </div>
            </ul>
            <ul class="subbarra" id="presupuestos2024cfb2024" hidden>
              <div>
                @can('akumas2023.recepcion') 
                <li @click="$store.state.menuc=82"><a href="#"><i class="fas fa-truck-pickup"></i> Recepcion Vehicular</a></li>
                @endcan

                @can('akumas2023.recepcion') 
                <li @click="$store.state.menuc=95"><a href="#"><i class="fas fa-file-invoice-dollar"></i> Hoja de Conceptos</a></li>
                @endcan
                @can('akumas2023.presupuestos') 
                <li @click="$store.state.menuc=69"><a href="#"><i class="fas fa-list-alt"></i> Anexos Taller</a></li>
                @endcan
                @can('akumas2023.aprobaciones') 
                <li @click="$store.state.menuc=70"><a href="#"><i class="fas fa-check-square"></i> Aprobaciones</a></li>
                @endcan
                @can('akumas2023.start') 
                <li @click="$store.state.menuc=72"><a href="#"><i class="fas fa-circle"></i> Start Akumas</a></li>
                @endcan
                @can('akumas2023.reportes') 
                <li @click="$store.state.menuc=71"><a href="#"><i class="fas fa-folder"></i></i> Reportes</a></li>
                @endcan
              </div>
            </ul>
            <ul class="subbarra" id="presupuestos2024cfbforaneos" hidden>
              <div>
                @can('cfbForaneos.recepcion') 
                <li @click="$store.state.menuc=87"><a href="#"><i class="fas fa-truck-pickup"></i> Recepcion Vehicular (Acuse)</a></li>
                @endcan
                @can('cfbForaneos.presupuestos') 
                <li @click="$store.state.menuc=88"><a href="#"><i class="fas fa-list-alt"></i> Anexos Taller</a></li>
                @endcan
                @can('cfbForaneos.aprobaciones') 
                <li @click="$store.state.menuc=89"><a href="#"><i class="fas fa-check-square"></i> Aprobaciones</a></li>
                @endcan
                @can('cfbForaneos.start') 
                <li @click="$store.state.menuc=90"><a href="#"><i class="fas fa-circle"></i> Start Akumas</a></li>
                @endcan
                @can('cfbForaneos.reportes') 
                <li @click="$store.state.menuc=91"><a href="#"><i class="fas fa-folder"></i></i> Reportes</a></li>
                @endcan
              </div>
            </ul>
            <ul class="subbarra" id="presupuestoseco2024eco" hidden>
              <div>
              @can('akumas2023.recepcion') 
              <li @click="$store.state.menuc=106"><a href="#"><i class="fas fa-truck-pickup"></i> Recepcion Vehicular</a></li>
              @endcan

              @can('akumas2023.recepcion') 
              <li @click="$store.state.menuc=107"><a href="#"><i class="fas fa-file-invoice-dollar"></i> Hoja de Conceptos</a></li>
              @endcan
              @can('akumas2023.presupuestos') 
              <li @click="$store.state.menuc=108"><a href="#"><i class="fas fa-list-alt"></i> Anexos Taller</a></li>
              @endcan
              @can('akumas2023.aprobaciones') 
              <li @click="$store.state.menuc=109"><a href="#"><i class="fas fa-check-square"></i> Aprobaciones</a></li>
              @endcan
              </div>
            </ul>
            <ul class="subbarra" id="presupuestoseco2024edenred" hidden>
              <div>
              @can('akumas2023.recepcion') 
              <li @click="$store.state.menuc=115"><a href="#"><i class="fas fa-truck-pickup"></i> Recepcion Vehicular</a></li>
              @endcan

              @can('akumas2023.recepcion') 
              <li @click="$store.state.menuc=116"><a href="#"><i class="fas fa-file-invoice-dollar"></i> Hoja de Conceptos</a></li>
              @endcan
              @can('akumas2023.presupuestos') 
              <li @click="$store.state.menuc=117"><a href="#"><i class="fas fa-list-alt"></i> Anexos Taller</a></li>
              @endcan
              @can('akumas2023.aprobaciones') 
              <li @click="$store.state.menuc=118"><a href="#"><i class="fas fa-check-square"></i> Aprobaciones</a></li>
              @endcan
              </div>
            </ul>
            <ul class="subbarra" id="presupuestoseco2024foraneos" hidden>
              <div>
              @can('cfbECOForaneos.recepcion') 
              <li @click="$store.state.menuc=110"><a href="#"><i class="fas fa-truck-pickup"></i> Recepcion Vehicular (Acuse)</a></li>
              @endcan
              @can('cfbECOForaneos.presupuestos') 
              <li @click="$store.state.menuc=111"><a href="#"><i class="fas fa-list-alt"></i> Anexos Taller</a></li>
              @endcan
              @can('cfbECOForaneos.aprobaciones') 
              <li @click="$store.state.menuc=112"><a href="#"><i class="fas fa-check-square"></i> Aprobaciones</a></li>
              @endcan
              @can('cfbECOForaneos.reportes') 
              <li @click="$store.state.menuc=114"><a href="#"><i class="fas fa-folder"></i></i> Reportes</a></li>
              @endcan
              </div>
            </ul>
          </div>
          @yield('contenido')         
        </section>
        <footer class="footer">
          <div class="pull-right hidden-xs">
            <b>Version</b> 2.3.0
          </div>
          <strong>Copyright &copy; 2019-2025 <a href="{{asset('http://www.corpomedia.mx')}}">Corpomedia</a>.</strong> All rights reserved.
        </footer>
      </div>
      </div>
      <!-- jQuery 3.4.1 -->
      <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
      <script src="{{asset('/js/sidebar.js')}}"></script>
      <script src="{{asset('js/app.js')}}"></script>
      @stack('scripts')
      <!-- Bootstrap 4.3.1 -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" ></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" ></script>
      <script src="{{asset('js/bootstrap-select.min.js')}}"></script>
      <!-- AdminLTE App -->
      <script src="{{asset('js/app.min.js')}}"></script>
      <script src="{{asset('js/plantilla.js')}}"></script>
    </div>
  </body>
</html>
