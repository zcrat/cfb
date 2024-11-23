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

  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper" id="app">

      <header class="main-header">

        <!-- Logo -->
        <a href="{{ route('homevue') }}"  @click="$store.state.menuc=0" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>A</b>S</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><img src="{{asset('img/logo_cfb.png')}}" height="30px" alt=""></span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
       
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Navegación</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-top-links navbar-right">
              <!-- Messages: style can be found in dropdown.less-->
              <li class="nav-link"><a href="#" @click="$store.state.menuc=0">¡Bienvenido a Akumas {{ Auth::user()->name }}!</a></li>
              <notification-component :notifications="notifications"></notification-component>
              <!-- User Account: style can be found in dropdown.less -->
            
              <li class="dropdown" style="display: inline-block;">
                <a href="#" class="nav-link" data-toggle="dropdown">
                  <i class="fa fa-user"> </i>
                  <i class="fa fa-angle-down"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                  <div class="dropdown-header text-center">
                      <!-- <strong>{{ Auth::user()->name }}</strong> -->
                  </div>
                  <div class="pull-right">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-default btn-flat"> <i class="fa fa-lock"></i> Cerrar</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                      @csrf
                                  </form>
                  </div>

              </div>
            
          </div>

        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
                    
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header"></li>

           
            @can('clientes.index') 
            <li class="treeview">
              <a href="#">
                <i class="fa fa-group"></i>
                <span>Clientes</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li class="nav-item"><a href="{{ route('cliente.usuarios') }}" class="nav-link"><i class="fa fa-user"></i> Usuarios</a></li>
                <li class="nav-item"><a href="{{ route('cliente.empresas') }}" class="nav-link"><i class="fa fa-user"></i> Empresas</a></li>

              </ul>
            </li>
            @endcan
            
            @can('almacen.index') 
            <li class="treeview">
              <a href="#">
                <i class="fa fa-building"></i>
                <span>Almacén</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li  @click="$store.state.menuc=1" class="nav-item"><a href="#" class="nav-link"><i class="fa fa-cubes"></i> Productos & Servios</a></li>
                <li  @click="$store.state.menuc=26" class="nav-item"><a href="#" class="nav-link"><i class="fa fa-cubes"></i> Productos por Grupos</a></li>
                <li  @click="$store.state.menuc=2" class="nav-item"><a href="#" class="nav-link"><i class="fa fa-cube"></i> Categorías</a></li>
              </ul>
            </li>
            @endcan
            @can('compras.index') 
            <li class="treeview">
              <a href="#">
                <i class="fa fa-th"></i>
                <span>Compras</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li @click="$store.state.menuc=4"><a href="#"><i class="fa fa-bar-chart"></i> Ingresos</a></li>
                <li @click="$store.state.menuc=5"><a href="#"><i class="fa fa-user"></i> Proveedores</a></li>
              </ul>
            </li>
            @endcan

            @can('ventas.index') 
            <li class="treeview">
              <a href="#">
                <i class="fa fa-shopping-cart"></i>
                <span>Ventas</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li @click="$store.state.menuc=6"><a href="#"><i class="fa fa-bar-chart"></i> Ventas</a></li>
                <li @click="$store.state.menuc=7"><a href="#"><i class="fa fa-user"></i> Clientes</a></li>
              </ul>
            </li>
            @endcan
                      
            @can('acceso.index') 
            <li class="treeview">
              <a href="#">
                <i class="fa fa-address-card "></i> <span>Acceso</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
              @can('user.index') 
                <li @click="$store.state.menuc=8"><a href="#"><i class="fa fa-user"></i> Usuarios</a></li>
              @endcan
              @can('roles.index') 
                <li @click="$store.state.menuc=9"><a href="#"><i class="fa fa-cubes"></i> Roles</a></li>
              @endcan
              </ul>
            </li>
            @endcan
            
            @can('facturacion.index') 
            <li class="treeview">
              <a href="#">
                <i class="fa fa-file"></i>
                <span>Facturacion</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li  @click="$store.state.menuc=15" class="nav-item"><a href="#" class="nav-link"><i class="fa fa-file"></i> Facturas</a></li>
                <li  @click="$store.state.menuc=38" class="nav-item"><a href="#" class="nav-link"><i class="fa fa-file"></i> Facturas por cobrar</a></li>
                <li  @click="$store.state.menuc=52" class="nav-item"><a href="#" class="nav-link"><i class="fa fa-file"></i> Facturas por contrato</a></li>
                <li  @click="$store.state.menuc=16" class="nav-item"><a href="#" class="nav-link"><i class="fa fa-cog"></i> Configuracion</a></li>
              </ul>
            </li>
            @endcan

            @can('formatos.index') 
            <li class="treeview">
              <a href="#">
                <i class="fa fa-laptop"></i>
                <span>Formatos</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li  @click="$store.state.menuc=13" class="nav-item"><a href="#" class="nav-link"><i class="fa fa-circle-o"></i> Recepción Vehicular</a></li>
                <li  @click="$store.state.menuc=17" class="nav-item"><a href="#" class="nav-link"><i class="fa fa-circle-o"></i> Inspección Vehicular</a></li>
                <li  @click="$store.state.menuc=18" class="nav-item"><a href="#" class="nav-link"><i class="fa fa-circle-o"></i> Hoja de Conceptos</a></li>
                <li  @click="$store.state.menuc=19" class="nav-item"><a href="#" class="nav-link"><i class="fa fa-circle-o"></i> Reporte de Grúa</a></li>
                <li  @click="$store.state.menuc=20" class="nav-item"><a href="#" class="nav-link"><i class="fa fa-circle-o"></i> Orden de Compra</a></li>
                <li  @click="$store.state.menuc=21" class="nav-item"><a href="#" class="nav-link"><i class="fa fa-circle-o"></i> Orden de Reparación</a></li>
                <li  @click="$store.state.menuc=25" class="nav-item"><a href="#" class="nav-link"><i class="fa fa-circle-o"></i> Cotización</a></li>
              </ul>
            </li>
            @endcan

            @can('tecnico.index') 
            <li class="treeview">
              <a href="#">
                <i class="fas fa-wrench"></i>
                <span>Tecnico</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li  @click="$store.state.menuc=22" class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="fas fa-id-badge"></i>
                    Asignar Tecnico Recepción
                  </a>
                </li>
                <li  @click="$store.state.menuc=23" class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="fas fa-clipboard"></i>
                    Mis recepciones
                  </a>
                </li>
              </ul>
            </li>
            @endcan

            @can('sucursales.index') 

          <li class="treeview">
              <a href="#">
                <i class="fa fa-cog"></i> <span>Configuraciòn</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
              <li @click="$store.state.menuc=24"><a href="#"><i class="fa fa-user-tag"></i> Sucursales</a></li>
              <li @click="$store.state.menuc=37"><a href="#"><i class="fa fa-user-tag"></i> Contratos</a></li>
              <li @click="$store.state.menuc=42"><a href="#"><i class="fa fa-user-tag"></i> Ubicaciones</a></li>
              <li @click="$store.state.menuc=43"><a href="#"><i class="fa fa-user-tag"></i> Areas</a></li>
              <li @click="$store.state.menuc=44"><a href="#"><i class="fa fa-user-tag"></i> Categorias CFE</a></li>
              <li @click="$store.state.menuc=45"><a href="#"><i class="fa fa-user-tag"></i> Categorias CFB/ECO</a></li>
              <li @click="$store.state.menuc=100"><a href="#"><i class="fa fa-user-tag"></i> Categorias CFB/ECO 2024</a></li>
              <li @click="$store.state.menuc=93"><a href="#"><i class="fa fa-user-tag"></i> Categorias Foraneas</a></li>
              <li @click="$store.state.menuc=46"><a href="#"><i class="fa fa-user-tag"></i> Tipos CFE</a></li>
              <li @click="$store.state.menuc=47"><a href="#"><i class="fa fa-user-tag"></i> Tipos CFB/ECO</a></li>
              <li @click="$store.state.menuc=99"><a href="#"><i class="fa fa-user-tag"></i> Tipos CFB/ECO 2024</a></li>
              <li @click="$store.state.menuc=94"><a href="#"><i class="fa fa-user-tag"></i> Tipos Foraneas</a></li>
              <li @click="$store.state.menuc=48"><a href="#"><i class="fa fa-user-tag"></i> Conceptos CFE</a></li>
              <li @click="$store.state.menuc=49"><a href="#"><i class="fa fa-user-tag"></i> Conceptos CFB/ECO</a></li>
              <li @click="$store.state.menuc=77"><a href="#"><i class="fa fa-user-tag"></i> Conceptos CFB/ECO 2024</a></li>
              <li @click="$store.state.menuc=92"><a href="#"><i class="fa fa-user-tag"></i> Conceptos Foraneos</a></li>
              <li @click="$store.state.menuc=68"><a href="#"><i class="fa fa-user-tag"></i> Tareas Admin</a></li>
              
              </ul>
            </li>

            @endcan


            @can('reportes.index') 
            <li class="treeview">
              <a href="#">
                <i class="fa fa-folder"></i> <span>Reportes</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li @click="$store.state.menuc=10"><a href="#"><i class="fa fa-circle-o"></i> Reporte Ingresos</a></li>
                <li @click="$store.state.menuc=11"><a href="#"><i class="fa fa-circle-o"></i> Reporte Ventas</a></li>
              </ul>
            </li>
            @endcan

            @can('caja.index') 
            <li class="treeview">
              <a href="#">
                <i class="fa fa-money"></i> <span>Control de caja</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li @click="$store.state.menuc=29"><a href="#"><i class="fa fa-circle-o"></i> Operaciones Caja</a></li>
                <li @click="$store.state.menuc=50"><a href="#"><i class="fa fa-circle-o"></i> Operaciones Bancos</a></li>
                <li @click="$store.state.menuc=27"><a href="#"><i class="fa fa-circle-o"></i> Bancos</a></li>
                <li @click="$store.state.menuc=28"><a href="#"><i class="fa fa-circle-o"></i> Cuentas</a></li>
                <li @click="$store.state.menuc=51"><a href="#"><i class="fa fa-circle-o"></i> Saldos</a></li>
              </ul>
            </li>
            @endcan

             {{-- @can('cfe.index') 
            <li class="treeview">
              <a href="#">
                <i class="fa fa-money"></i> <span>CFE Bajio 2022</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                @can('cfe.recepcion') 
                <li @click="$store.state.menuc=78"><a href="#"><i class="fa fa-circle-o"></i> Recepcion Vehicular</a></li>
                @endcan
                @can('cfe.externos') 
                <li @click="$store.state.menuc=31"><a href="#"><i class="fa fa-circle-o"></i> Talleres Externos</a></li>
                @endcan
                @can('cfe.akumas') 
                <li @click="$store.state.menuc=30"><a href="#"><i class="fa fa-circle-o"></i> Anexos CFE</a></li>
                @endcan
                @can('cfe.aptaller') 
                <li @click="$store.state.menuc=32"><a href="#"><i class="fa fa-circle-o"></i> Aprobaciones Taller</a></li>
                @endcan
                {{-- @can('cfe.aptaller') 
                <li @click="$store.state.menuc=41"><a href="#"><i class="fa fa-circle-o"></i> Aprobaciones CFE Taller</a></li>
                @endcan
                @can('cfe.apcfe') 
                <li @click="$store.state.menuc=33"><a href="#"><i class="fa fa-circle-o"></i> Aprobaciones CFE</a></li>
                @endcan --}}
                 {{-- @can('cfe.start') 
                <li @click="$store.state.menuc=39"><a href="#"><i class="fa fa-circle-o"></i> Start CFE</a></li>
                @endcan
               
                @can('cfe.apcfe') 
                <li @click="$store.state.menuc=11"><a href="#"><i class="fa fa-circle-o"></i> Reportes</a></li>
                @endcan
              </ul>
            </li>
            @endcan--}}

            

            @can('cfeB2023.index') 
            <li class="treeview">
              <a href="#">
                <i class="fa fa-money"></i> <span>CFE Bajio 2024</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                @can('cfeB2023.recepcion') 
                <li @click="$store.state.menuc=79"><a href="#"><i class="fa fa-circle-o"></i> Recepcion Vehicular</a></li>
                @endcan
                @can('cfeB2023.recepcion') 
                <li @click="$store.state.menuc=98"><a href="#"><i class="fa fa-circle-o"></i> Hoja de Conceptos</a></li>
                @endcan
                @can('cfeB2023.externos') 
                <li @click="$store.state.menuc=53"><a href="#"><i class="fa fa-circle-o"></i> Talleres Externos</a></li>
                @endcan
                @can('cfeB2023.akumas') 
                <li @click="$store.state.menuc=54"><a href="#"><i class="fa fa-circle-o"></i> Anexos CFE</a></li>
                @endcan
                @can('cfeB2023.aptaller') 
                <li @click="$store.state.menuc=55"><a href="#"><i class="fa fa-circle-o"></i> Aprobaciones Taller</a></li>
                @endcan
                @can('cfeB2023.aptaller') 
                <li @click="$store.state.menuc=57"><a href="#"><i class="fa fa-circle-o"></i> Aprobaciones CFE Taller</a></li>
                @endcan
                {{-- @can('cfeB2023.apcfe') 
                <li @click="$store.state.menuc=56"><a href="#"><i class="fa fa-circle-o"></i> Aprobaciones CFE</a></li>
                @endcan
                @can('cfeB2023.start') 
                <li @click="$store.state.menuc=58"><a href="#"><i class="fa fa-circle-o"></i> Start CFE</a></li>
                @endcan --}}
               
                @can('cfeB2023.apcfe') 
                <li @click="$store.state.menuc=59"><a href="#"><i class="fa fa-circle-o"></i> Reportes</a></li>
                @endcan
              </ul>
            </li>
            @endcan

            @can('cfeO2023.index') 
            <li class="treeview">
              <a href="#">
                <i class="fa fa-money"></i> <span>CFE Occidente 2024</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                @can('cfeO2023.recepcion') 
                <li @click="$store.state.menuc=80"><a href="#"><i class="fa fa-circle-o"></i> Recepcion Vehicular</a></li>
                @endcan
                @can('cfeO2023.recepcion') 
                <li @click="$store.state.menuc=97"><a href="#"><i class="fa fa-circle-o"></i> Hoja de Conceptos</a></li>
                @endcan
                @can('cfeO2023.externos') 
                <li @click="$store.state.menuc=60"><a href="#"><i class="fa fa-circle-o"></i> Talleres Externos</a></li>
                @endcan
                @can('cfeO2023.akumas') 
                <li @click="$store.state.menuc=61"><a href="#"><i class="fa fa-circle-o"></i> Anexos CFE</a></li>
                @endcan
                @can('cfeO2023.aptaller') 
                <li @click="$store.state.menuc=62"><a href="#"><i class="fa fa-circle-o"></i> Aprobaciones Taller</a></li>
                @endcan
                {{-- @can('cfeO2023.aptaller') 
                <li @click="$store.state.menuc=64"><a href="#"><i class="fa fa-circle-o"></i> Aprobaciones CFE Taller</a></li>
                @endcan
                @can('cfeO2023.apcfe') 
                <li @click="$store.state.menuc=63"><a href="#"><i class="fa fa-circle-o"></i> Aprobaciones CFE</a></li>
                @endcan --}}
                @can('cfeO2023.start') 
                <li @click="$store.state.menuc=65"><a href="#"><i class="fa fa-circle-o"></i> Start CFE</a></li>
                @endcan
               
                @can('cfeO2023.apcfe') 
                <li @click="$store.state.menuc=66"><a href="#"><i class="fa fa-circle-o"></i> Reportes</a></li>
                @endcan
              </ul>
            </li>
            @endcan

            @can('akumas.index') 
            <li class="treeview">
              <a href="#">
                <i class="fa fa-money"></i> <span>Presupuestos CFB</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                @can('akumas.recepcion') 
                <li @click="$store.state.menuc=81"><a href="#"><i class="fa fa-circle-o"></i> Recepcion Vehicular</a></li>
                @endcan
                @can('akumas.recepcion') 
                <li @click="$store.state.menuc=96"><a href="#"><i class="fa fa-circle-o"></i> Hoja de Conceptos</a></li>
                @endcan
                @can('akumas.presupuestos') 
                <li @click="$store.state.menuc=34"><a href="#"><i class="fa fa-circle-o"></i> Anexos Taller</a></li>
                @endcan
                @can('akumas.aprobaciones') 
                <li @click="$store.state.menuc=35"><a href="#"><i class="fa fa-circle-o"></i> Aprobaciones</a></li>
                @endcan
                @can('akumas.start') 
                <li @click="$store.state.menuc=40"><a href="#"><i class="fa fa-circle-o"></i> Start Akumas</a></li>
                @endcan
                @can('akumas.reportes') 
                <li @click="$store.state.menuc=36"><a href="#"><i class="fa fa-circle-o"></i> Reportes</a></li>
                @endcan
              </ul>
             
            </li>
            @endcan

            @can('akumas2023.index') 
            <li class="treeview">
              <a href="#">
                <i class="fa fa-money"></i> <span>Presupuestos CFB 2024</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                @can('akumas2023.recepcion') 
                <li @click="$store.state.menuc=82"><a href="#"><i class="fa fa-circle-o"></i> Recepcion Vehicular</a></li>
                @endcan

                @can('akumas2023.recepcion') 
                <li @click="$store.state.menuc=95"><a href="#"><i class="fa fa-circle-o"></i> Hoja de Conceptos</a></li>
                @endcan
                @can('akumas2023.presupuestos') 
                <li @click="$store.state.menuc=69"><a href="#"><i class="fa fa-circle-o"></i> Anexos Taller</a></li>
                @endcan
                @can('akumas2023.aprobaciones') 
                <li @click="$store.state.menuc=70"><a href="#"><i class="fa fa-circle-o"></i> Aprobaciones</a></li>
                @endcan
                @can('akumas2023.start') 
                <li @click="$store.state.menuc=72"><a href="#"><i class="fa fa-circle-o"></i> Start Akumas</a></li>
                @endcan
                @can('akumas2023.reportes') 
                <li @click="$store.state.menuc=71"><a href="#"><i class="fa fa-circle-o"></i> Reportes</a></li>
                @endcan
              </ul>
             
            </li>
            @endcan

           


            @can('cfbForaneos.index') 
            <li class="treeview">
              <a href="#">
                <i class="fa fa-money"></i> <span>Presupuestos CFB Foraneos</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                @can('cfbForaneos.recepcion') 
                <li @click="$store.state.menuc=87"><a href="#"><i class="fa fa-circle-o"></i> Recepcion Vehicular (Acuse)</a></li>
                @endcan
                @can('cfbForaneos.presupuestos') 
                <li @click="$store.state.menuc=88"><a href="#"><i class="fa fa-circle-o"></i> Anexos Taller</a></li>
                @endcan
                @can('cfbForaneos.aprobaciones') 
                <li @click="$store.state.menuc=89"><a href="#"><i class="fa fa-circle-o"></i> Aprobaciones</a></li>
                @endcan
                @can('cfbForaneos.start') 
                <li @click="$store.state.menuc=90"><a href="#"><i class="fa fa-circle-o"></i> Start Akumas</a></li>
                @endcan
                @can('cfbForaneos.reportes') 
                <li @click="$store.state.menuc=91"><a href="#"><i class="fa fa-circle-o"></i> Reportes</a></li>
                @endcan
              </ul>
             
            </li>
            @endcan

            @can('cfeeco.index') 
            <li class="treeview">
              <a href="#">
                <i class="fa fa-money"></i> <span>CFE ECO 2024</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                @can('cfeeco.recepcion') 
                <li @click="$store.state.menuc=101"><a href="#"><i class="fa fa-circle-o"></i> Recepcion Vehicular</a></li>
                @endcan
                @can('cfeeco.recepcion') 
                <li @click="$store.state.menuc=102"><a href="#"><i class="fa fa-circle-o"></i> Hoja de Conceptos</a></li>
                @endcan
                @can('cfeeco.externos') 
                <li @click="$store.state.menuc=103"><a href="#"><i class="fa fa-circle-o"></i> Talleres Externos</a></li>
                @endcan
                @can('cfeeco.akumas') 
                <li @click="$store.state.menuc=104"><a href="#"><i class="fa fa-circle-o"></i> Anexos CFE</a></li>
                @endcan
                @can('cfeeco.aptaller') 
                <li @click="$store.state.menuc=105"><a href="#"><i class="fa fa-circle-o"></i> Aprobaciones Taller</a></li>
                @endcan
              
              </ul>
            </li>
            @endcan

            @can('akumas2023.index') 
            <li class="treeview">
              <a href="#">
                <i class="fa fa-money"></i> <span>Presupuestos ECO</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                @can('akumas2023.recepcion') 
                <li @click="$store.state.menuc=106"><a href="#"><i class="fa fa-circle-o"></i> Recepcion Vehicular</a></li>
                @endcan

                @can('akumas2023.recepcion') 
                <li @click="$store.state.menuc=107"><a href="#"><i class="fa fa-circle-o"></i> Hoja de Conceptos</a></li>
                @endcan
                @can('akumas2023.presupuestos') 
                <li @click="$store.state.menuc=108"><a href="#"><i class="fa fa-circle-o"></i> Anexos Taller</a></li>
                @endcan
                @can('akumas2023.aprobaciones') 
                <li @click="$store.state.menuc=109"><a href="#"><i class="fa fa-circle-o"></i> Aprobaciones</a></li>
                @endcan
            
              </ul>
             
            </li>
            @endcan

            @can('cfbECOForaneos.index') 
            <li class="treeview">
              <a href="#">
                <i class="fa fa-money"></i> <span>Presupuestos ECO Foraneos</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                @can('cfbECOForaneos.recepcion') 
                <li @click="$store.state.menuc=110"><a href="#"><i class="fa fa-circle-o"></i> Recepcion Vehicular (Acuse)</a></li>
                @endcan
                @can('cfbECOForaneos.presupuestos') 
                <li @click="$store.state.menuc=111"><a href="#"><i class="fa fa-circle-o"></i> Anexos Taller</a></li>
                @endcan
                @can('cfbECOForaneos.aprobaciones') 
                <li @click="$store.state.menuc=112"><a href="#"><i class="fa fa-circle-o"></i> Aprobaciones</a></li>
                @endcan
          
                @can('cfbECOForaneos.reportes') 
                <li @click="$store.state.menuc=114"><a href="#"><i class="fa fa-circle-o"></i> Reportes</a></li>
                @endcan
              </ul>
             
            </li>
            @endcan

            @can('tareas.index') 
            <li class="treeview">
              <a href="#">
                <i class="fa fa-money"></i> <span>Tareas</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li @click="$store.state.menuc=76"><a href="#"><i class="fa fa-circle-o"></i> Tareas Ejecutivas</a></li>
             
                <li @click="$store.state.menuc=67"><a href="#"><i class="fa fa-circle-o"></i> Revisar Tareas</a></li>
                <li @click="$store.state.menuc=73"><a href="#"><i class="fa fa-circle-o"></i> Tecnicos</a></li>
                <li @click="$store.state.menuc=74"><a href="#"><i class="fa fa-circle-o"></i> Trasladistas</a></li>
                <li @click="$store.state.menuc=75"><a href="#"><i class="fa fa-circle-o"></i> Vehiculos</a></li>
                <li @click="$store.state.menuc=83"><a href="#"><i class="fa fa-circle-o"></i> Entradas y Salidas</a></li>
                <li @click="$store.state.menuc=84"><a href="#"><i class="fa fa-circle-o"></i> Ordenes</a></li>
                <li @click="$store.state.menuc=85"><a href="#"><i class="fa fa-circle-o"></i> Ordenes Foraneas</a></li>
                <li @click="$store.state.menuc=86"><a href="#"><i class="fa fa-circle-o"></i> ES Foraneas</a></li>
              </ul>
        
            </li>
            @endcan
            
          
                        
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>





       <!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        
        <!-- Main content -->
        <section class="content">
          
          
                             
                             @yield('contenido')
                     
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      </div>
      <!--Fin-Contenido-->
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 2.3.0
        </div>
        <strong>Copyright &copy; 2019-2025 <a href="{{asset('http://www.corpomedia.mx')}}">Corpomedia</a>.</strong> All rights reserved.
      </footer>

      
    <!-- jQuery 3.4.1 -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="{{ mix('js/app.js') }}"></script>

    @stack('scripts')
    <!-- Bootstrap 4.3.1 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" ></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" ></script>
    <script src="{{asset('js/bootstrap-select.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('js/app.min.js')}}"></script>
    <script src="{{asset('js/plantilla.js')}}"></script>
  

    
  </body>
</html>
