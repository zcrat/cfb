<!DOCTYPE html>
<html lang="es" id="general" data-bs-theme="dark">
  <head>
    <meta charset="utf-8">
    <title>Akumas | www.akumas.mx</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <!-- Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Iconos-->
    <script src="https://kit.fontawesome.com/d675227da3.js" crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- etsilos personalizados-->
    <link rel="stylesheet" href="{{asset('css/estilosnavbar.css')}}">
    <link rel="stylesheet" href="{{asset('css/misestilos.css')}}">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      </head>
  <body>
    <nav class="msidebar"> 
      <ul class="msidebar-links" id="msidebar">
      <li class="logotipo">
          <a href="{{ route('homevue') }}"><img class="logoimg" src="{{asset('img/logo_cfb.png')}}" alt="">
          </a>
          <span class="contraer"><i class="fa-solid fa-outdent"></i></span>
      </li>
        @can('clientes.index')
          <li class="msubdropdown">
            <a><i class="fas fa-users"></i><span >Clientes</span></a>
            <ul class="msubdropdown-menu menudown">
              <div>
              <li><a href="{{ route('cliente.empresas') }}"><i class="fas fa-city"></i>Empresas</a></li>
              <li><a href="{{ route('cliente.usuarios') }}"><i class="fas fa-user-friends"></i>Usuarios</a></li>
            </div>           
                </ul> 
          </li>
        @endcan
       
        @can('almacen.index') 
          <li class="msubdropdown">
            <a><i class="fa fa-building"></i> <span>Almacén</span> </a>
            <ul class="msubdropdown-menu">
              <div>
              <li ><a href="{{ route('homevue') }}" class="nav-link"><i class="fa fa-cubes"></i> Productos & Servios</a></li>
              <li ><a href="{{ route('homevue') }}" class="nav-link"><i class="fa fa-cubes"></i> Productos por Grupos</a></li>
              <li ><a href="{{ route('homevue') }}" class="nav-link"><i class="fa fa-cube"></i> Categorías</a></li>
            </div>           
                </ul>
          </li>
        @endcan
        @can('compras.index') 
          <li class="msubdropdown">
            <a><i class="fa fa-th"></i><span>Compras</span></a>
            <ul class="msubdropdown-menu">
              <div>
              <li><a href="{{ route('homevue') }}"><i class="fa fa-bar-chart"></i> Ingresos</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fa fa-user"></i> Proveedores</a></li>
            </div>           
                </ul>
          </li>
        @endcan
        @can('ventas.index') 
          <li class="msubdropdown">
            <a><i class="fa fa-shopping-cart"></i><span>Ventas</span></a>
            <ul class="msubdropdown-menu">
              <div>
              <div>
              <li><a href="{{ route('homevue') }}"><i class="fa fa-bar-chart"></i> Ventas</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fa fa-user"></i> Clientes</a></li>
              </div>
            </div>           
                </ul>
          </li>
        @endcan
        @can('acceso.index') 
          <li class="msubdropdown">
            <a><i class="fa fa-address-card "></i> <span>Acceso</span></a>
            <ul class="msubdropdown-menu">
              <div>
            @can('user.index') 
              <li><a href="{{ route('homevue') }}"><i class="fa fa-user"></i> Usuarios</a></li>
            @endcan
            @can('roles.index') 
              <li><a href="{{ route('homevue') }}"><i class="fa fa-cubes"></i> Roles</a></li>
            @endcan
            </div>           
                </ul>
          </li>
        @endcan
        @can('facturacion.index') 
          <li class="msubdropdown">
            <a><i class="fa fa-file"></i><span>Facturacion</span></a>
            <ul class="msubdropdown-menu">
              <div>
              <li ><a href="{{ route('facturacion.facturas') }}" class="nav-link"><i class="fa fa-file"></i> Facturas</a></li>
              <li ><a href="{{ route('homevue') }}" class="nav-link"><i class="fa fa-file"></i> Facturas por cobrar</a></li>
              <li ><a href="{{ route('homevue') }}" class="nav-link"><i class="fa fa-file"></i> Facturas por contrato</a></li>
              <li ><a href="{{ route('homevue') }}" class="nav-link"><i class="fa fa-cog"></i> Configuracion</a></li>
            </div>           
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
              <div>
              <li ><a href="{{ route('homevue') }}" class="nav-link"><i class="fa fa-circle-o"></i> Recepción Vehicular</a></li>
              <li ><a href="{{ route('homevue') }}" class="nav-link"><i class="fa fa-circle-o"></i> Inspección Vehicular</a></li>
              <li ><a href="{{ route('homevue') }}" class="nav-link"><i class="fa fa-circle-o"></i> Hoja de Conceptos</a></li>
              <li ><a href="{{ route('homevue') }}" class="nav-link"><i class="fa fa-circle-o"></i> Reporte de Grúa</a></li>
              <li ><a href="{{ route('homevue') }}" class="nav-link"><i class="fa fa-circle-o"></i> Orden de Compra</a></li>
              <li ><a href="{{ route('homevue') }}" class="nav-link"><i class="fa fa-circle-o"></i> Orden de Reparación</a></li>
              <li ><a href="{{ route('homevue') }}" class="nav-link"><i class="fa fa-circle-o"></i> Cotización</a></li>
            </div>           
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
              <div>
              <li >
                <a href="{{ route('homevue') }}" class="nav-link">
                  <i class="fas fa-id-badge"></i>
                  Asignar Tecnico Recepción
                </a>
              </li>
              <li >
                <a href="{{ route('homevue') }}" class="nav-link">
                  <i class="fas fa-clipboard"></i>
                  Mis recepciones
                </a>
              </li>
            </div>           
                </ul>
          </li>
        @endcan
        @can('sucursales.index') 
          <li class="msubdropdown">
            <a>
              <i class="fa fa-cog"></i> <span>Configuraciòn</span>  
            </a>
            <ul class="msubdropdown-menu">
              <div>
              <li><a href="{{ route('homevue') }}"><i class="fa fa-user-tag"></i> Sucursales</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fa fa-user-tag"></i> Contratos</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fa fa-user-tag"></i> Ubicaciones</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fa fa-user-tag"></i> Areas</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fa fa-user-tag"></i> Categorias CFE</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fa fa-user-tag"></i> Categorias CFB/ECO</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fa fa-user-tag"></i> Categorias CFB/ECO 2024</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fa fa-user-tag"></i> Categorias Foraneas</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fa fa-user-tag"></i> Tipos CFE</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fa fa-user-tag"></i> Tipos CFB/ECO</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fa fa-user-tag"></i> Tipos CFB/ECO 2024</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fa fa-user-tag"></i> Tipos Foraneas</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fa fa-user-tag"></i> Conceptos CFE</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fa fa-user-tag"></i> Conceptos CFB/ECO</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fa fa-user-tag"></i> Conceptos CFB/ECO 2024</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fa fa-user-tag"></i> Conceptos Foraneos</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fa fa-user-tag"></i> Tareas Admin</a></li>
            </div>           
                </ul>
          </li>
        @endcan
        @can('reportes.index') 
          <li class="msubdropdown">
            <a>
              <i class="fa fa-folder"></i> <span>Reportes</span>
            </a>
            <ul class="msubdropdown-menu">
              <div>
              <li><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Reporte Ingresos</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Reporte Ventas</a></li>
            </div>           
                </ul>
          </li>
        @endcan
        @can('caja.index') 
          <li class="msubdropdown">
            <a>
              <i class="fa fa-money"></i> <span>Control de caja</span>
            </a>
            <ul class="msubdropdown-menu">
              <div>
              <li><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Operaciones Caja</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Operaciones Bancos</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Bancos</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Cuentas</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Saldos</a></li>
            </div>           
                </ul>
          </li>
        @endcan
        @canany(['cfeB2023.index', 'cfeO2023.index','cfeeco.index'])
          <li class="mdropdown">
            <a><i class="fas fa-users"></i><span >CFE 2024</span></a>
            <ul class="mdropdown-menu">

            <div>
            @can('cfeB2023.index')
              <li class="msubdropdown">
                <a><i class="fas fa-users"></i>Bajio</a>
                <ul class="msubdropdown-menu">
                <div>
                  @can('cfeB2023.recepcion')
                  <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Recepcion Vehicular</a></li>
                  @endcan
                  @can('cfeB2023.recepcion')  
                  <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Hoja de Conceptos</a></li>
                  @endcan
                  @can('cfeB2023.externos')
                  <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Talleres Externos</a></li>
                  @endcan
                  @can('cfeB2023.akumas')
                  <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Anexos CFE</a></li>
                  @endcan
                  @can('cfeB2023.aptaller')
                  <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Aprobaciones Taller</a></li>
                  @endcan
                  @can('cfeB2023.aptaller')
                  <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Aprobaciones CFE Taller</a></li>
                  @endcan
                  @can('cfeB2023.apcfe')
                  <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Reportes</a></li>
                  @endcan 
                        
                </div>           
                </ul>
              </li>
            @endcan
            @can('cfeO2023.index')
              <li class="msubdropdown">
                <a><i class="fas fa-users"></i>Occidente</a>
                <ul class="msubdropdown-menu">
                  <div>
                <div>
                  @can('cfeO2023.recepcion')
                  <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Recepcion Vehicular</a></li>
                  @endcan
                  @can('cfeO2023.recepcion')  
                  <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Hoja de Conceptos</a></li>
                  @endcan
                  @can('cfeO2023.externos')
                  <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Talleres Externos</a></li>
                  @endcan
                  @can('cfeO2023.akumas')
                  <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Anexos CFE</a></li>
                  @endcan
                  @can('cfeO2023.aptallar')
                  <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Aprobaciones Taller</a></li>
                  @endcan
                  @can('cfeO2023.start')
                  <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Star CFE</a></li>
                  @endcan
                  @can('cfeO2023.apcfe')
                  <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Reportes</a></li>
                  @endcan
                </div>
                </div>           
                </ul>
              </li>
            @endcan
            @can('cfeeco.index')
              <li class="msubdropdown">
                <a><i class="fas fa-users"></i>ECO</a>
                <ul class="msubdropdown-menu">
                  <div>
                <div>
                  @can('cfeeco.recepcion')
                  <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Recepcion Vehicular</a></li>
                  @endcan
                  @can('cfeeco.recepcion')
                  <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Hoja de Conceptos</a></li>
                  @endcan
                  @can('cfeeco.externos')
                  <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Talleres Externos</a></li>
                  @endcan
                  @can('cfeeco.akumas')
                  <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Anexos CFE</a></li>
                  @endcan
                  @can('cfeeco.aptaller')
                  <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Aprobaciones Taller</a></li>
                  @endcan
                </div>
                </div>           
                </ul>
                
              </li>
            @endcan
            </div>           
                </ul>
          </li>
        @endcan  
        @canany(['akumas2023.index', 'akumas.index','cfbForaneos.index'])
          <li class="mdropdown">
            <a><i class="fas fa-users"></i><span >Presupuestos CFB</span></a>
            <ul class="mdropdown-menu">
              <div>
            @can('akumas.index')
              <li class="msubdropdown">
                <a><i class="fas fa-users"></i>Presupuestos CFB</a>
                <ul class="msubdropdown-menu">
                  <div>
                  @can('akumas.recepcion')
                  <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Recepcion Vehicular</a></li>
                  @endcan
                  @can('akumas.recepcion')
                  <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Hoja de Conceptos</a></li>
                  @endcan
                  @can('akumas.presupuestos')
                  <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Anexos Taller</a></li>
                  @endcan
                  @can('akumas.aprobaciones')
                  <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Aprobaciones</a></li>
                  @endcan
                
                  @can('akumas.start')
                  <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Star Akumas</a></li>
                  @endcan
                  @can('akumas.reportes')
                  <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Reportes</a></li>
                  @endcan
                </div>           
                </ul>
              </li>
              @endcan
            
              @can('akumas2023.index') 
              <li class="msubdropdown">
                <a><i class="fas fa-users"></i>Presupuestos CFB 2024</a>
                <ul class="msubdropdown-menu">
                  <div>
                  @can('akumas2023.recepcion') 
                  <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Recepcion Vehicular</a></li>
                  @endcan
                  @can('akumas2023.recepcion') 
                  <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Hoja de Conceptos</a></li>
                  @endcan
                  @can('akumas2023.presupuestos') 
                  <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Anexos Taller</a></li>
                  @endcan
                  @can('akumas2023.aprobaciones') 
                  <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Aprobaciones</a></li>
                  @endcan
                  @can('akumas2023.start') 
                  <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Star Akumas</a></li>
                  @endcan
                  @can('akumas2023.reportes') 
                  <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Reportes</a></li>
                  @endcan
                </div>           
                </ul>
              </li>
              @endcan
              @can('cfbForaneos.index')
              <li class="msubdropdown">
                <a><i class="fas fa-users"></i>Presupuestos CFB Foraneos</a>
                <ul class="msubdropdown-menu">
                  <div>
                  @can('cfbForaneos.recepcion')
                  <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Recepcion Vehicular (Acuse)</a></li>
                  @endcan
                  @can('cfbForaneos.presupuestos')
                  <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Anexos Taller</a></li>
                  @endcan
                  @can('cfbForaneos.aprobaciones')
                  <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Aprobaciones</a></li>
                  @endcan
                  @can('cfbForaneos.start')
                  <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Star Akumas</a></li>
                  @endcan
                  @can('cfbForaneos.reportes')
                  <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Reportes</a></li>
                  @endcan
                </div>           
                </ul>
              </li>
              @endcan
            </div>           
                </ul>
          </li>
        @endcan
        @canany(['akumas2023.index', 'cfbECOForaneos.index']) 
          <li class="mdropdown">
            <a><i class="fas fa-users"></i><span >Presupuestos ECO</span></a>
            <ul class="mdropdown-menu">
              <div>
            @can('akumas2023.index') 
              <li class="msubdropdown">
                <a><i class="fas fa-users"></i>Presupuestos ECO</a>
                <ul class="msubdropdown-menu">
                  <div>
                @can('akumas2023.recepcion') 
                  <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Recepcion Vehicular</a></li>
                  @endcan
                  @can('akumas2023.recepcion') 
                  <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Hoja de Conceptos</a></li>
                  @endcan
                  @can('akumas2023.presupuestos') 
                  <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Anexos Taller</a></li>
                  @endcan
                  @can('akumas2023.reportes') 
                  <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Aprobaciones</a></li>
                  @endcan
                </div>           
                </ul>
              </li>
              @endcan
              @can('cfbECOForaneos.index')
              <li class="msubdropdown">
                <a><i class="fas fa-users"></i>Presupuestos ECO Foranea</a>
                <ul class="msubdropdown-menu">
                  <div>
                  @can('cfbECOForaneos.recepcion')
                  <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Recepcion Vehicular (Acuse)</a></li>
                  @endcan
                  @can('cfbECOForaneos.presupuestos')
                  <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Hoja de Conceptos</a></li>
                  @endcan
                  @can('cfbECOForaneos.aprobaciones')
                  <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Anexos Taller</a></li>
                  @endcan
                  @can('cfbECOForaneos.reportes')
                  <li><a href="{{ route('homevue') }}"><i class="fas fa-city"></i>Aprobaciones</a></li>
                  @endcan
                </div>           
                </ul>
              </li>
              @endcan
            </div>           
            </ul>
          </li>
        @endcan   
        @can('tareas.index') 
          <li class="msubdropdown">
            <a>
              <i class="fa fa-money"></i> <span>Tareas</span>
            </a>
            <ul class="msubdropdown-menu menuup">
              <div>
              <li><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Tareas Ejecutivas</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Revisar Tareas</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Tecnicos</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Trasladistas</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Vehiculos</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Entradas y Salidas</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Ordenes</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> Ordenes Foraneas</a></li>
              <li><a href="{{ route('homevue') }}"><i class="fa fa-circle-o"></i> ES Foraneas</a></li>
            </div>           
                </ul>
          </li>
        @endcan
          
        <li><a href="{{ route('presupuestos.vales')}}"><i class="fas fa-city"></i><span>Vales</span></a></li>      
      </ul>
    </nav>  
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
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn" title="Cerrar Secion">
                  <i class="fa-solid fa-right-to-bracket"></i>
            </button>
            </form>
                
          </li>           
        </ul>
      </nav>
    </header>
    <div class="content">
            @yield('contenido')

    </div>
    </section>
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
    document.documentElement.removeAttribute("style");

    } else {        
        document.documentElement.style.setProperty('--fondo', '#0073b7');
        document.documentElement.style.setProperty('--letra', '#ffffff');
        document.documentElement.style.setProperty('--fondor', '#ffa200');
        document.documentElement.style.setProperty('--letrar', '#f2f2f2');
        document.documentElement.style.setProperty('--fondos2', '#DEE2E6');
        document.documentElement.style.setProperty('--fondobody', '#DEE2E6');
        document.documentElement.style.setProperty('--letrasbody', '#212529');
        
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
