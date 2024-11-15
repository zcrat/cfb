<!DOCTYPE html>
<html lang="es" id="general" data-bs-theme="dark">
  <head>
    <meta charset="utf-8">
    <title>Akumas | www.akumas.mx</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta content="initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Iconos-->
    <script src="https://kit.fontawesome.com/d675227da3.js" crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- etsilos personalizados-->
    <link rel="stylesheet" href="{{ asset('css/misestilos.css') }}">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      </head>
  <body>
<div>
  <nav class="msidebar">
    <li class="logotipo">
      <a href="{{ route('homevue') }}"  @click="$store.state.menuc=0">
        <span class="logoimg"><img src="{{asset('img/logo_cfb.png')}}" width="50px"height="40px" alt=""></span>
        <span class="contraer"><i class="fa-solid fa-outdent"></i></span>
      </a>
    </li>
    <ul class="msidebar-links" id="msidebar">
      <li class="msubdropdown">
        <a><i class="fas fa-users"></i><span >Clientes</span></a>
        <ul class="msubdropdown-menu">
          <li><a href="{{ route('cliente.empresas') }}"><i class="fas fa-city"></i>Empresas</a></li>
          <li><a href="{{ route('cliente.usuarios') }}"><i class="fas fa-user-friends"></i></i>Usuarios</a></li>
        </ul>
      </li>
      <li class="mdropdown">
        <a><i class="fas fa-users"></i><span >CFE 2024</span></a>
        <ul class="mdropdown-menu">
          <li class="msubdropdown">
            <a><i class="fas fa-users"></i>Bajio</a>
            <ul class="msubdropdown-menu">
              <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Recepcion Vehicular</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Hoja de Conceptos</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Talleres Externos</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Anexos CFE</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Aprobaciones Taller</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Star CFE</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Reportes</a></li>
            </ul>
          </li>
          <li class="msubdropdown">
            <a><i class="fas fa-users"></i>Occidente</a>
            <ul class="msubdropdown-menu">
              <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Recepcion Vehicular</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Hoja de Conceptos</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Talleres Externos</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Anexos CFE</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Aprobaciones Taller</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Star CFE</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Reportes</a></li>
            </ul>
          </li>
          <li class="msubdropdown">
            <a><i class="fas fa-users"></i>ECO</a>
            <ul class="msubdropdown-menu">
              <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Recepcion Vehicular</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Hoja de Conceptos</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Talleres Externos</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Anexos CFE</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Aprobaciones Taller</a></li>
            </ul>
          </li>
        </ul>
      </li>  
      @can('almacen.index') 
        <li class="msubdropdown">
          <a><i class="fa fa-building"></i> <span>Almacén</span> </a>
          <ul class="msubdropdown-menu">
            <li  @click="$store.state.menuc=1"><a href="{{ route('homevue') }}" class="nav-link"><i class="fa fa-cubes"></i> Productos & Servios</a></li>
            <li  @click="$store.state.menuc=26"><a href="{{ route('homevue') }}" class="nav-link"><i class="fa fa-cubes"></i> Productos por Grupos</a></li>
            <li  @click="$store.state.menuc=2"><a href="{{ route('homevue') }}" class="nav-link"><i class="fa fa-cube"></i> Categorías</a></li>
          </ul>
        </li>
      @endcan
      @can('compras.index') 
        <li class="msubdropdown">
          <a><i class="fa fa-th"></i><span>Compras</span></a>
          <ul class="msubdropdown-menu">
            <li @click="$store.state.menuc=4"><a href="{{ route('homevue') }}"><i class="fa fa-bar-chart"></i> Ingresos</a></li>
            <li @click="$store.state.menuc=5"><a href="{{ route('homevue') }}"><i class="fa fa-user"></i> Proveedores</a></li>
          </ul>
        </li>
      @endcan
      @can('ventas.index') 
        <li class="msubdropdown">
          <a><i class="fa fa-shopping-cart"></i><span>Ventas</span></a>
          <ul class="msubdropdown-menu">
            <li @click="$store.state.menuc=6"><a href="{{ route('homevue') }}"><i class="fa fa-bar-chart"></i> Ventas</a></li>
            <li @click="$store.state.menuc=7"><a href="{{ route('homevue') }}"><i class="fa fa-user"></i> Clientes</a></li>
          </ul>
        </li>
      @endcan
      @can('acceso.index') 
        <li class="msubdropdown">
          <a><i class="fa fa-address-card "></i> <span>Acceso</span></a>
          <ul class="msubdropdown-menu">
          @can('user.index') 
            <li @click="$store.state.menuc=8"><a href="{{ route('homevue') }}"><i class="fa fa-user"></i> Usuarios</a></li>
          @endcan
          @can('roles.index') 
            <li @click="$store.state.menuc=9"><a href="{{ route('homevue') }}"><i class="fa fa-cubes"></i> Roles</a></li>
          @endcan
          </ul>
        </li>
      @endcan
      @can('facturacion.index') 
        <li class="msubdropdown">
          <a><i class="fa fa-file"></i><span>Facturacion</span></a>
          <ul class="msubdropdown-menu">
            <li  @click="$store.state.menuc=15"><a href="{{ route('facturacion.facturas') }}" class="nav-link"><i class="fa fa-file"></i> Facturas</a></li>
            <li  @click="$store.state.menuc=38"><a href="{{ route('homevue') }}" class="nav-link"><i class="fa fa-file"></i> Facturas por cobrar</a></li>
            <li  @click="$store.state.menuc=52"><a href="{{ route('homevue') }}" class="nav-link"><i class="fa fa-file"></i> Facturas por contrato</a></li>
            <li  @click="$store.state.menuc=16"><a href="{{ route('homevue') }}" class="nav-link"><i class="fa fa-cog"></i> Configuracion</a></li>
          </ul>
        </li>
      @endcan
            @can('formatos.index') 
            <li class="msubdropdown">
              <a>
                <i class="fa fa-laptop"></i>
                <span>Formatos</span>
                
              </a>
              <ul class="msubdropdown-menu">
                <li  @click="$store.state.menuc=13"><a href="{{ route('homevue') }}" class="nav-link"><i class="fa fa-circle-o"></i> Recepción Vehicular</a></li>
                <li  @click="$store.state.menuc=17"><a href="{{ route('homevue') }}" class="nav-link"><i class="fa fa-circle-o"></i> Inspección Vehicular</a></li>
                <li  @click="$store.state.menuc=18"><a href="{{ route('homevue') }}" class="nav-link"><i class="fa fa-circle-o"></i> Hoja de Conceptos</a></li>
                <li  @click="$store.state.menuc=19"><a href="{{ route('homevue') }}" class="nav-link"><i class="fa fa-circle-o"></i> Reporte de Grúa</a></li>
                <li  @click="$store.state.menuc=20"><a href="{{ route('homevue') }}" class="nav-link"><i class="fa fa-circle-o"></i> Orden de Compra</a></li>
                <li  @click="$store.state.menuc=21"><a href="{{ route('homevue') }}" class="nav-link"><i class="fa fa-circle-o"></i> Orden de Reparación</a></li>
                <li  @click="$store.state.menuc=25"><a href="{{ route('homevue') }}" class="nav-link"><i class="fa fa-circle-o"></i> Cotización</a></li>
              </ul>
            </li>
            @endcan

            @can('tecnico.index') 
            <li class="msubdropdown">
              <a>
                <i class="fas fa-wrench"></i>
                <span>Tecnico</span>
                
              </a>
              <ul class="msubdropdown-menu">
                <li  @click="$store.state.menuc=22">
                  <a href="{{ route('homevue') }}" class="nav-link">
                    <i class="fas fa-id-badge"></i>
                    Asignar Tecnico Recepción
                  </a>
                </li>
                <li  @click="$store.state.menuc=23">
                  <a href="{{ route('homevue') }}" class="nav-link">
                    <i class="fas fa-clipboard"></i>
                    Mis recepciones
                  </a>
                </li>
              </ul>
            </li>
            @endcan

            @can('sucursales.index') 

          <li class="msubdropdown">
              <a>
                <i class="fa fa-cog"></i> <span>Configuraciòn</span>
                
              </a>
              <ul class="msubdropdown-menu">
              <li @click="$store.state.menuc=24"><a href="{{ route('homevue') }}"><i class="fa fa-user-tag"></i> Sucursales</a></li>
              <li @click="$store.state.menuc=37"><a href="{{ route('homevue') }}"><i class="fa fa-user-tag"></i> Contratos</a></li>
              <li @click="$store.state.menuc=42"><a href="{{ route('homevue') }}"><i class="fa fa-user-tag"></i> Ubicaciones</a></li>
              <li @click="$store.state.menuc=43"><a href="{{ route('homevue') }}"><i class="fa fa-user-tag"></i> Areas</a></li>
              <li @click="$store.state.menuc=44"><a href="{{ route('homevue') }}"><i class="fa fa-user-tag"></i> Categorias CFE</a></li>
              <li @click="$store.state.menuc=45"><a href="{{ route('homevue') }}"><i class="fa fa-user-tag"></i> Categorias CFB/ECO</a></li>
              <li @click="$store.state.menuc=100"><a href="{{ route('homevue') }}"><i class="fa fa-user-tag"></i> Categorias CFB/ECO 2024</a></li>
              <li @click="$store.state.menuc=93"><a href="{{ route('homevue') }}"><i class="fa fa-user-tag"></i> Categorias Foraneas</a></li>
              <li @click="$store.state.menuc=46"><a href="{{ route('homevue') }}"><i class="fa fa-user-tag"></i> Tipos CFE</a></li>
              <li @click="$store.state.menuc=47"><a href="{{ route('homevue') }}"><i class="fa fa-user-tag"></i> Tipos CFB/ECO</a></li>
              <li @click="$store.state.menuc=99"><a href="{{ route('homevue') }}"><i class="fa fa-user-tag"></i> Tipos CFB/ECO 2024</a></li>
              <li @click="$store.state.menuc=94"><a href="{{ route('homevue') }}"><i class="fa fa-user-tag"></i> Tipos Foraneas</a></li>
              <li @click="$store.state.menuc=48"><a href="{{ route('homevue') }}"><i class="fa fa-user-tag"></i> Conceptos CFE</a></li>
              <li @click="$store.state.menuc=49"><a href="{{ route('homevue') }}"><i class="fa fa-user-tag"></i> Conceptos CFB/ECO</a></li>
              <li @click="$store.state.menuc=77"><a href="{{ route('homevue') }}"><i class="fa fa-user-tag"></i> Conceptos CFB/ECO 2024</a></li>
              <li @click="$store.state.menuc=92"><a href="{{ route('homevue') }}"><i class="fa fa-user-tag"></i> Conceptos Foraneos</a></li>
              <li @click="$store.state.menuc=68"><a href="{{ route('homevue') }}"><i class="fa fa-user-tag"></i> Tareas Admin</a></li>
              
              </ul>
            </li>

            @endcan


            @can('reportes.index') 
            <li class="msubdropdown">
              <a>
                <i class="fa fa-folder"></i> <span>Reportes</span>
                
              </a>
              <ul class="msubdropdown-menu">
                <li @click="$store.state.menuc=10"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Reporte Ingresos</a></li>
                <li @click="$store.state.menuc=11"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Reporte Ventas</a></li>
              </ul>
            </li>
            @endcan

            @can('caja.index') 
            <li class="msubdropdown">
              <a>
                <i class="fa fa-money"></i> <span>Control de caja</span>
                
              </a>
              <ul class="msubdropdown-menu">
                <li @click="$store.state.menuc=29"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Operaciones Caja</a></li>
                <li @click="$store.state.menuc=50"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Operaciones Bancos</a></li>
                <li @click="$store.state.menuc=27"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Bancos</a></li>
                <li @click="$store.state.menuc=28"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Cuentas</a></li>
                <li @click="$store.state.menuc=51"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Saldos</a></li>
              </ul>
            </li>
            @endcan

             {{-- @can('cfe.index') 
            <li class="msubdropdown">
              <a>
                <i class="fa fa-money"></i> <span>CFE Bajio 2022</span>
                
              </a>
              <ul class="msubdropdown-menu">
                @can('cfe.recepcion') 
                <li @click="$store.state.menuc=78"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Recepcion Vehicular</a></li>
                @endcan
                @can('cfe.externos') 
                <li @click="$store.state.menuc=31"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Talleres Externos</a></li>
                @endcan
                @can('cfe.akumas') 
                <li @click="$store.state.menuc=30"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Anexos CFE</a></li>
                @endcan
                @can('cfe.aptaller') 
                <li @click="$store.state.menuc=32"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Aprobaciones Taller</a></li>
                @endcan
                {{-- @can('cfe.aptaller') 
                <li @click="$store.state.menuc=41"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Aprobaciones CFE Taller</a></li>
                @endcan
                @can('cfe.apcfe') 
                <li @click="$store.state.menuc=33"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Aprobaciones CFE</a></li>
                @endcan --}}
                 {{-- @can('cfe.start') 
                <li @click="$store.state.menuc=39"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Start CFE</a></li>
                @endcan
               
                @can('cfe.apcfe') 
                <li @click="$store.state.menuc=11"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Reportes</a></li>
                @endcan
              </ul>
            </li>
            @endcan--}}

            

            @can('cfeB2023.index') 
            <li class="msubdropdown">
              <a>
                <i class="fa fa-money"></i> <span>CFE Bajio 2024</span>
                
              </a>
              <ul class="msubdropdown-menu">
                @can('cfeB2023.recepcion') 
                <li @click="$store.state.menuc=79"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Recepcion Vehicular</a></li>
                @endcan
                @can('cfeB2023.recepcion') 
                <li @click="$store.state.menuc=98"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Hoja de Conceptos</a></li>
                @endcan
                @can('cfeB2023.externos') 
                <li @click="$store.state.menuc=53"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Talleres Externos</a></li>
                @endcan
                @can('cfeB2023.akumas') 
                <li @click="$store.state.menuc=54"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Anexos CFE</a></li>
                @endcan
                @can('cfeB2023.aptaller') 
                <li @click="$store.state.menuc=55"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Aprobaciones Taller</a></li>
                @endcan
                @can('cfeB2023.aptaller') 
                <li @click="$store.state.menuc=57"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Aprobaciones CFE Taller</a></li>
                @endcan
                {{-- @can('cfeB2023.apcfe') 
                <li @click="$store.state.menuc=56"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Aprobaciones CFE</a></li>
                @endcan
                @can('cfeB2023.start') 
                <li @click="$store.state.menuc=58"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Start CFE</a></li>
                @endcan --}}
               
                @can('cfeB2023.apcfe') 
                <li @click="$store.state.menuc=59"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Reportes</a></li>
                @endcan
              </ul>
            </li>
            @endcan

            @can('cfeO2023.index') 
            <li class="msubdropdown">
              <a>
                <i class="fa fa-money"></i> <span>CFE Occidente 2024</span>
                
              </a>
              <ul class="msubdropdown-menu">
                @can('cfeO2023.recepcion') 
                <li @click="$store.state.menuc=80"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Recepcion Vehicular</a></li>
                @endcan
                @can('cfeO2023.recepcion') 
                <li @click="$store.state.menuc=97"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Hoja de Conceptos</a></li>
                @endcan
                @can('cfeO2023.externos') 
                <li @click="$store.state.menuc=60"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Talleres Externos</a></li>
                @endcan
                @can('cfeO2023.akumas') 
                <li @click="$store.state.menuc=61"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Anexos CFE</a></li>
                @endcan
                @can('cfeO2023.aptaller') 
                <li @click="$store.state.menuc=62"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Aprobaciones Taller</a></li>
                @endcan
                {{-- @can('cfeO2023.aptaller') 
                <li @click="$store.state.menuc=64"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Aprobaciones CFE Taller</a></li>
                @endcan
                @can('cfeO2023.apcfe') 
                <li @click="$store.state.menuc=63"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Aprobaciones CFE</a></li>
                @endcan --}}
                @can('cfeO2023.start') 
                <li @click="$store.state.menuc=65"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Start CFE</a></li>
                @endcan
               
                @can('cfeO2023.apcfe') 
                <li @click="$store.state.menuc=66"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Reportes</a></li>
                @endcan
              </ul>
            </li>
            @endcan

            @can('akumas.index') 
            <li class="msubdropdown">
              <a>
                <i class="fa fa-money"></i> <span>Presupuestos CFB</span>
                
              </a>
              <ul class="msubdropdown-menu">
                @can('akumas.recepcion') 
                <li @click="$store.state.menuc=81"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Recepcion Vehicular</a></li>
                @endcan
                @can('akumas.recepcion') 
                <li @click="$store.state.menuc=96"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Hoja de Conceptos</a></li>
                @endcan
                @can('akumas.presupuestos') 
                <li @click="$store.state.menuc=34"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Anexos Taller</a></li>
                @endcan
                @can('akumas.aprobaciones') 
                <li @click="$store.state.menuc=35"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Aprobaciones</a></li>
                @endcan
                @can('akumas.start') 
                <li @click="$store.state.menuc=40"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Start Akumas</a></li>
                @endcan
                @can('akumas.reportes') 
                <li @click="$store.state.menuc=36"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Reportes</a></li>
                @endcan
              </ul>
             
            </li>
            @endcan

            @can('akumas2023.index') 
            <li class="msubdropdown">
              <a>
                <i class="fa fa-money"></i> <span>Presupuestos CFB 2024</span>
                
              </a>
              <ul class="msubdropdown-menu">
                @can('akumas2023.recepcion') 
                <li @click="$store.state.menuc=82"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Recepcion Vehicular</a></li>
                @endcan

                @can('akumas2023.recepcion') 
                <li @click="$store.state.menuc=95"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Hoja de Conceptos</a></li>
                @endcan
                @can('akumas2023.presupuestos') 
                <li @click="$store.state.menuc=69"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Anexos Taller</a></li>
                @endcan
                @can('akumas2023.aprobaciones') 
                <li @click="$store.state.menuc=70"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Aprobaciones</a></li>
                @endcan
                @can('akumas2023.start') 
                <li @click="$store.state.menuc=72"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Start Akumas</a></li>
                @endcan
                @can('akumas2023.reportes') 
                <li @click="$store.state.menuc=71"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Reportes</a></li>
                @endcan
              </ul>
             
            </li>
            @endcan

           


            @can('cfbForaneos.index') 
            <li class="msubdropdown">
              <a>
                <i class="fa fa-money"></i> <span>Presupuestos CFB Foraneos</span>
                
              </a>
              <ul class="msubdropdown-menu">
                @can('cfbForaneos.recepcion') 
                <li @click="$store.state.menuc=87"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Recepcion Vehicular (Acuse)</a></li>
                @endcan
                @can('cfbForaneos.presupuestos') 
                <li @click="$store.state.menuc=88"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Anexos Taller</a></li>
                @endcan
                @can('cfbForaneos.aprobaciones') 
                <li @click="$store.state.menuc=89"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Aprobaciones</a></li>
                @endcan
                @can('cfbForaneos.start') 
                <li @click="$store.state.menuc=90"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Start Akumas</a></li>
                @endcan
                @can('cfbForaneos.reportes') 
                <li @click="$store.state.menuc=91"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Reportes</a></li>
                @endcan
              </ul>
             
            </li>
            @endcan

            @can('cfeeco.index') 
            <li class="msubdropdown">
              <a>
                <i class="fa fa-money"></i> <span>CFE ECO 2024</span>
                
              </a>
              <ul class="msubdropdown-menu">
                @can('cfeeco.recepcion') 
                <li @click="$store.state.menuc=101"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Recepcion Vehicular</a></li>
                @endcan
                @can('cfeeco.recepcion') 
                <li @click="$store.state.menuc=102"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Hoja de Conceptos</a></li>
                @endcan
                @can('cfeeco.externos') 
                <li @click="$store.state.menuc=103"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Talleres Externos</a></li>
                @endcan
                @can('cfeeco.akumas') 
                <li @click="$store.state.menuc=104"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Anexos CFE</a></li>
                @endcan
                @can('cfeeco.aptaller') 
                <li @click="$store.state.menuc=105"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Aprobaciones Taller</a></li>
                @endcan
              
              </ul>
            </li>
            @endcan

            @can('akumas2023.index') 
            <li class="msubdropdown">
              <a>
                <i class="fa fa-money"></i> <span>Presupuestos ECO</span>
                
              </a>
              <ul class="msubdropdown-menu">
                @can('akumas2023.recepcion') 
                <li @click="$store.state.menuc=106"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Recepcion Vehicular</a></li>
                @endcan

                @can('akumas2023.recepcion') 
                <li @click="$store.state.menuc=107"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Hoja de Conceptos</a></li>
                @endcan
                @can('akumas2023.presupuestos') 
                <li @click="$store.state.menuc=108"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Anexos Taller</a></li>
                @endcan
                @can('akumas2023.aprobaciones') 
                <li @click="$store.state.menuc=109"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Aprobaciones</a></li>
                @endcan
            
              </ul>
             
            </li>
            @endcan

            @can('cfbECOForaneos.index') 
            <li class="msubdropdown">
              <a>
                <i class="fa fa-money"></i> <span>Presupuestos ECO Foraneos</span>
                
              </a>
              <ul class="msubdropdown-menu">
                @can('cfbECOForaneos.recepcion') 
                <li @click="$store.state.menuc=110"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Recepcion Vehicular (Acuse)</a></li>
                @endcan
                @can('cfbECOForaneos.presupuestos') 
                <li @click="$store.state.menuc=111"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Anexos Taller</a></li>
                @endcan
                @can('cfbECOForaneos.aprobaciones') 
                <li @click="$store.state.menuc=112"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Aprobaciones</a></li>
                @endcan
          
                @can('cfbECOForaneos.reportes') 
                <li @click="$store.state.menuc=114"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Reportes</a></li>
                @endcan
              </ul>
             
            </li>
            @endcan

            @can('tareas.index') 
            <li class="msubdropdown">
              <a>
                <i class="fa fa-money"></i> <span>Tareas</span>
                
              </a>
              <ul class="msubdropdown-menu">
                <li @click="$store.state.menuc=76"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Tareas Ejecutivas</a></li>
             
                <li @click="$store.state.menuc=67"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Revisar Tareas</a></li>
                <li @click="$store.state.menuc=73"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Tecnicos</a></li>
                <li @click="$store.state.menuc=74"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Trasladistas</a></li>
                <li @click="$store.state.menuc=75"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Vehiculos</a></li>
                <li @click="$store.state.menuc=83"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Entradas y Salidas</a></li>
                <li @click="$store.state.menuc=84"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Ordenes</a></li>
                <li @click="$store.state.menuc=85"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Ordenes Foraneas</a></li>
                <li @click="$store.state.menuc=86"><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> ES Foraneas</a></li>
              </ul>
        
            </li>
            @endcan
    </ul>
  </nav>
</div>
        
    <div class="body-container">
      
    <header class="mtopbar">
  <nav>
    <ul>
      <!-- Icono de barra lateral -->
      <li><a title="Menu" class="sider"><i class="fa-solid fa-bars"></i></a></li>
      
      <!-- Bienvenida al usuario -->
      <li class="topbar-center">
        <a>
          ¡Bienvenido a Akumas, {{ Auth::user()->name }}!
        </a>
      </li>
      <li title="modo obscuro" class="dark hidden"><a><i class="fa-solid fa-moon"></i></a></li>
      <li title="modo claro" class="light hidden"><a><i class="fa-solid fa-sun"></i></a></li>
      <!-- Icono de notificación -->
      <li><a href="{{ route('homevue') }}" title="Notificaciones"><i class="fa-solid fa-bell"></i></a></li>
      
      <!-- Botón de cerrar sesión -->
      <li>
        <a title="Cerrar Secion" href="{{ route('logout') }}" class="btn btn-default btn-flat">
          <i class="fa-solid fa-right-to-bracket"></i>
        </a>
      </li>
    </ul>
  </nav>

  <!-- Formulario de cierre de sesión -->
  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
  </form>
</header>
        <div class="content">
        
        <section>
          @yield('contenido')
        </section>
      </div>
        <footer class="footer">
          <div class="pull-right hidden-xs">
              <b>Version</b>1.0.0
          </div>
          <strong>Copyright &copy; 2018-2025 </strong> All rights reserved.
        </footer>
    </div> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
        <script src="{{asset('js/bootstrap-select.min.js')}}"></script>
        <script>
          document.addEventListener('DOMContentLoaded', function() {
            let s1=document.querySelector('.msidebar');
           
            let s2=document.querySelector('.msidebar-links');
           
            let s3=document.querySelector('.body-container');

            let barra = localStorage.getItem('barra') || 'activa';
            cambiarbarra(barra);
           

          document.querySelector('.sider').addEventListener('click', function() {
            s1.classList.toggle('active-sidebar');
            s2.classList.toggle('active-msidebar-links');
            s3.classList.toggle('active-body-container');
            let barra = localStorage.getItem('barra');
            barra = barra === "activa" ? "noactiva" : "activa";
            localStorage.setItem('barra', barra);
          });  
          document.querySelector('.contraer').addEventListener('click', function() {
            s1.classList.toggle('active-sidebar');
            s2.classList.toggle('active-msidebar-links');
            s3.classList.toggle('active-body-container');

          });

          function cambiarbarra(barra){
          if(barra ==="noactiva"){
                    s1.classList.toggle('active-sidebar');
                    s2.classList.toggle('active-msidebar-links');
                    s3.classList.toggle('active-body-container');
          }
        }

        });
        function toggleTheme(currentTheme) {
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    document.querySelector('.dark').classList.toggle('hidden');
    document.querySelector('.light').classList.toggle('hidden');
    document.getElementById('general').setAttribute('data-bs-theme', newTheme);
    localStorage.setItem('theme', newTheme); // Guardar el nuevo tema
    cambiarcolores(newTheme);
}

function cambiarcolores(savedTheme){
  if (savedTheme === 'dark') {
        document.documentElement.style.setProperty('--fondo', '#000000');
        document.documentElement.style.setProperty('--letra', '#ffffff');
        document.documentElement.style.setProperty('--fondor', '#ffffff');
        document.documentElement.style.setProperty('--letrar', '#000000');
    } else {        
        document.documentElement.style.setProperty('--fondo', '#0073b7');
        document.documentElement.style.setProperty('--letra', '#ffffff');
        document.documentElement.style.setProperty('--fondor', '#ffa200');
        document.documentElement.style.setProperty('--letrar', '#f2f2f2')
    }
}

document.querySelector('.dark').addEventListener('click', () => toggleTheme('dark'));
document.querySelector('.light').addEventListener('click', () => toggleTheme('light'));

// Al cargar la página, configurar el tema basado en `localStorage`
document.addEventListener('DOMContentLoaded', () => {
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.getElementById('general').setAttribute('data-bs-theme', savedTheme);
    document.querySelector(`.${savedTheme}`).classList.remove('hidden');
    cambiarcolores(savedTheme);

});

        </script>
   
  </body> 
  
</html>
