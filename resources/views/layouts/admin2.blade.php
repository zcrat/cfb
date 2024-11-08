<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <title>Akumas | www.akumas.mx</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 4.3.1 -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-select.min.css')}}">
    <script src="https://kit.fontawesome.com/d675227da3.js" crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/misestilos.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=domain" />
    <style>
.material-symbols-outlined {
  font-variation-settings:
  'FILL' 0,
  'wght' 400,
  'GRAD' 0,
  'opsz' 24
}
</style>
  </head>
  <body>
    <div class="body-container">
      
        <header class="mtopbar">
              <nav>
                  <ul >
                   <li><a class="sider"><i class="fa-solid fa-bars"></i></a></li>
                  </ul>
              </nav>
        </header>
        <div class="content">
        <nav class="msidebar">
        <li class="logotipo">
         
          <a href="#">
          <span class="logoimg"><img src="{{asset('img/logo_cfb.png')}}" height="30px" alt=""></span>
          <span class="logoabr"><b>TAC</b</span>
          </a>
        </li>
          <ul class="msidebar-links" id="msidebar">
            <li class="msubdropdown">
        
              <a><i class="fas fa-users"></i><span >Clientes</span></a>
              <ul class="msubdropdown-menu">
                <li><a href="#"><i class="fas fa-city"></i>Empresas</a></li>
                <li><a href="#"><i class="fas fa-user-friends"></i></i>Usuarios</a></li>
              </ul>
            </li>
            <li class="mdropdown">
              <a><i class="fas fa-users"></i><span >CFE 2024</span></a>
              <ul class="mdropdown-menu">
                <li class="msubdropdown">
                  <a><i class="fas fa-users"></i>Bajio</a>
                  <ul class="msubdropdown-menu">
                    <li><a href="#"><i class="fas fa-city"></i>Recepcion Vehicular</a></li>
                    <li><a href="#"><i class="fas fa-city"></i>Hoja de Conceptos</a></li>
                    <li><a href="#"><i class="fas fa-city"></i>Talleres Externos</a></li>
                    <li><a href="#"><i class="fas fa-city"></i>Anexos CFE</a></li>
                    <li><a href="#"><i class="fas fa-city"></i>Aprobaciones Taller</a></li>
                    <li><a href="#"><i class="fas fa-city"></i>Star CFE</a></li>
                    <li><a href="#"><i class="fas fa-city"></i>Reportes</a></li>
                  </ul>
                </li>
                <li class="msubdropdown">
                <a><i class="fas fa-users"></i>Occidente</a>
                  <ul class="msubdropdown-menu">
                    <li><a href="#"><i class="fas fa-city"></i>Recepcion Vehicular</a></li>
                    <li><a href="#"><i class="fas fa-city"></i>Hoja de Conceptos</a></li>
                    <li><a href="#"><i class="fas fa-city"></i>Talleres Externos</a></li>
                    <li><a href="#"><i class="fas fa-city"></i>Anexos CFE</a></li>
                    <li><a href="#"><i class="fas fa-city"></i>Aprobaciones Taller</a></li>
                    <li><a href="#"><i class="fas fa-city"></i>Star CFE</a></li>
                    <li><a href="#"><i class="fas fa-city"></i>Reportes</a></li>
                  
                  </ul>
                </li><li class="msubdropdown">
                <a><i class="fas fa-users"></i>ECO</a>
                  <ul class="msubdropdown-menu">
                    <li><a href="#"><i class="fas fa-city"></i>Recepcion Vehicular</a></li>
                    <li><a href="#"><i class="fas fa-city"></i>Hoja de Conceptos</a></li>
                    <li><a href="#"><i class="fas fa-city"></i>Talleres Externos</a></li>
                    <li><a href="#"><i class="fas fa-city"></i>Anexos CFE</a></li>
                    <li><a href="#"><i class="fas fa-city"></i>Aprobaciones Taller</a></li>
                  </ul>
                </li>
              </ul>
            </li>                 
          </ul>
        </nav>
        <section class="misection">
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
        <script href="{{asset('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js')}}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" ></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" ></script>
        <script src="{{asset('js/bootstrap-select.min.js')}}"></script>
        <script>
          document.addEventListener('DOMContentLoaded', function() {
            let s1=document.querySelector('.msidebar');
           
            let s2=document.querySelector('.msidebar-links');
           
            let s3=document.querySelector('.body-container');
            
          document.querySelector('.sider').addEventListener('click', function() {
            
            s1.classList.toggle('active-sidebar');
            
            s2.classList.toggle('active-msidebar-links');
        
            s3.classList.toggle('active-body-container');
          });  
        
        });


        </script>
   
  </body> 
  
</html>
