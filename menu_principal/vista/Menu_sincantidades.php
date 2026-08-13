<?php
error_reporting(E_ERROR | E_PARSE); // Desactiva la notificación y warnings de error en php.
session_start();

if (!isset($_SESSION['usuarioInventario']))
{

  exit;
}
?>

<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

<style>
  :root {
    --executive-navy: #0b1f3a;
    --executive-blue: #175cd3;
    --executive-cyan: #0ea5e9;
    --executive-bg: #f3f6fa;
    --executive-text: #172033;
    --executive-muted: #667085;
    --executive-border: #e4e9f0;
    --executive-radius: 16px;
    --executive-shadow: 0 10px 30px rgba(15, 35, 64, .08);
  }

  html { -webkit-text-size-adjust: 100%; }
  body {
    background: var(--executive-bg);
    color: var(--executive-text);
    font-family: Inter, "Segoe UI", Roboto, Arial, sans-serif;
  }

  .main-header {
    min-height: 64px;
    padding: 0 22px;
    border: 0;
    border-bottom: 1px solid var(--executive-border);
    box-shadow: 0 2px 14px rgba(15, 35, 64, .05);
    position: relative;
    z-index: 1040;
  }
  .main-header .nav-link {
    min-height: 44px;
    display: flex;
    align-items: center;
    gap: 8px;
    color: #344054 !important;
    font-weight: 600;
    border-radius: 10px;
    margin: 10px 3px;
    transition: background .2s ease, color .2s ease;
  }
  .main-header .nav-link:hover { background: #eff6ff; color: var(--executive-blue) !important; }

  .main-sidebar { background: linear-gradient(180deg, #0b1f3a 0%, #07162a 100%) !important; }
  .brand-link {
    min-height: 92px;
    display: grid !important;
    grid-template-columns: 48px 1fr;
    grid-template-rows: auto auto;
    column-gap: 12px;
    align-content: center;
    padding: 15px 16px !important;
    border-bottom: 1px solid rgba(255,255,255,.09) !important;
    white-space: normal;
  }
  .brand-link .brand-image {
    grid-row: 1 / 3;
    width: 46px !important;
    height: 46px !important;
    max-height: 46px;
    margin: 0 !important;
    object-fit: contain;
    background: #fff;
    padding: 4px;
  }
  .brand-link span { color: #fff; font-size: 16px; font-weight: 700 !important; letter-spacing: .4px; }
  .brand-link p { color: #9fb2cc; font-size: 11px; line-height: 1.25; margin: 2px 0 0; }
  .sidebar { padding: 0 10px 24px; }
  .user-panel { align-items: center; padding: 15px 8px !important; }
  .user-panel .image { width: 40px; height: 40px; display: grid; place-items: center; border-radius: 12px; background: rgba(255,255,255,.1); }
  .user-panel .image svg { width: 24px; height: 24px; }
  .user-panel .info h4 { margin: 0; font-size: 14px; line-height: 1.35; font-weight: 600; }
  .nav-sidebar .nav-link { min-height: 46px; display: flex; align-items: center; border-radius: 10px; margin-bottom: 4px; }
  .nav-sidebar .nav-link.active { background: linear-gradient(135deg, var(--executive-blue), var(--executive-cyan)) !important; box-shadow: 0 8px 20px rgba(14,165,233,.22); }
  .nav-sidebar .nav-icon, .nav-treeview .nav-link > i:first-child { width: 28px !important; margin-right: 8px !important; font-size: 17px !important; text-align: center; }
  .nav-sidebar p { font-size: 13px; font-weight: 500; }

  .content-wrapper { background: var(--executive-bg); min-height: calc(100vh - 64px); }
  .content-header { padding: 22px 24px 10px; }
  .dashboard-heading { margin: 0; font-size: clamp(22px, 3vw, 30px); font-weight: 750; letter-spacing: -.5px; }
  .dashboard-subtitle { margin: 5px 0 0; color: var(--executive-muted); font-size: 14px; }
  #barraUsuarioFecha {
    display: inline-flex;
    align-items: center;
    min-height: 42px;
    padding: 9px 14px;
    color: #475467;
    background: #fff;
    border: 1px solid var(--executive-border);
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(15,35,64,.04);
    font-size: 13px;
    font-weight: 600;
  }
  .content { padding: 8px 24px 28px !important; }
  .dashboard-grid { margin-left: -8px; margin-right: -8px; }
  .dashboard-grid > [class*="col-"] { padding-left: 8px; padding-right: 8px; }
  .executive-card {
    min-height: 185px;
    overflow: hidden;
    background: #fff !important;
    color: var(--executive-text) !important;
    border: 1px solid var(--executive-border);
    border-radius: var(--executive-radius);
    box-shadow: var(--executive-shadow);
    transition: transform .2s ease, box-shadow .2s ease;
  }
  .executive-card:hover { transform: translateY(-3px); box-shadow: 0 15px 36px rgba(15,35,64,.12); }
  .executive-card::before { content: ""; position: absolute; inset: 0 auto 0 0; width: 5px; background: var(--accent); }
  .executive-card .inner { min-height: 136px; padding: 24px 22px; position: relative; z-index: 2; }
  .executive-card h3 { min-height: 36px; margin: 0 0 10px; color: var(--executive-text); font-size: 30px; font-weight: 750; }
  .executive-card h4 { margin: 0; color: #475467; font-size: 15px; font-weight: 650; }
  .executive-card .icon { top: 20px; right: 18px; }
  .executive-card .icon > i { color: var(--accent) !important; opacity: .14; font-size: 68px !important; }
  .executive-card .small-box-footer {
    min-height: 49px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 11px 18px;
    background: color-mix(in srgb, var(--accent) 8%, white) !important;
    color: var(--accent) !important;
    font-size: 13px;
    font-weight: 700;
  }
  .card-people { --accent: #d97706; }
  .card-buses { --accent: #0284c7; }
  .card-users { --accent: #dc2626; }
  .card-controls { --accent: #059669; }

  /* En computadores se oculta completamente la barra superior. */
  @media (min-width: 768px) {
    .main-header { display: none !important; }
  }

  @media (max-width: 767.98px) {
    /* En móviles se conserva una barra compacta para abrir el menú lateral. */
    .main-header {
      min-height: 50px;
      height: 50px;
      padding: 0 8px;
      background: linear-gradient(135deg, var(--executive-navy), #123a70) !important;
      border: 0;
      box-shadow: 0 5px 16px rgba(11,31,58,.18);
    }
    .main-header .navbar-nav { height: 50px; align-items: center; }
    .main-header .nav-link {
      width: 42px;
      min-height: 42px;
      margin: 4px 0;
      padding: 0;
      justify-content: center;
      color: #fff !important;
      font-size: 19px;
      background: rgba(255,255,255,.08);
    }
    .main-header .nav-link:hover,
    .main-header .nav-link:focus { background: rgba(255,255,255,.16); color: #fff !important; }
    .main-header .menu-label { display: none; }
    .main-header .nav-item.d-none { display: none !important; }
    .content-header { padding: 18px 14px 8px; }
    .content-header .row > div { flex: 0 0 100%; max-width: 100%; }
    .content-header .breadcrumb { float: none !important; margin: 12px 0 0; padding: 0; }
    #barraUsuarioFecha { width: 100%; justify-content: center; text-align: center; }
    .content { padding: 8px 14px 24px !important; }
    .executive-card { min-height: 164px; margin-bottom: 14px; }
    .executive-card .inner { min-height: 116px; padding: 20px 18px; }
    .executive-card .icon > i { font-size: 58px !important; }
    .executive-card:hover { transform: none; }
  }
  @media (max-width: 420px) {
    .dashboard-grid > [class*="col-"] { flex: 0 0 100%; max-width: 100%; }
    .dashboard-heading { font-size: 23px; }
  }
</style>

  <nav class="main-header navbar navbar-expand navbar-white navbar-light">

    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button" aria-label="Abrir menú"><i class="fas fa-bars"></i> <span class="menu-label">Menú</span></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="?c=menu_principal&a=menu_usuarios" class="nav-link">Inicio</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contactos</a>
      </li>
    </ul>

    <!-- Right navbar links -->

  </nav>

<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->

  <!-- /.navbar -->

  <!-- Main Sidebar Container (!!!LOGO!!!!) -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="?c=menu_principal&a=menu_usuarios" class="brand-link">
      <img src="img/icongps.png" alt="AdminLTE Logo" class="brand-image img-circle" width="80px" height="80px">
      <span class="brand-text font-weight-light">CONTROL FLOTA</span>
      <p class="brand-text font-weight-light">Servicio de geolocalización</p>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
     <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="white" class="bi bi-person" viewBox="0 0 16 16">
  <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z"/>
</svg>
        </div>
        <div class="info">
       
<h4 class="text-white">
                                  <?php 

                                  $usuario = null;
                                  if (isset($_SESSION["usuarioInventario"])) {
                                      $usuario = $_SESSION["usuarioInventario"];
                                     
                                      echo  $usuario->nombre ; echo"\n".$usuario->apellido;
                                  } else {
                                      header("Location: ../../index.php");
                                  }
                                       echo "\n ";
                                            if ( $_SESSION["usuarioInventario"] )
                                            {
                                                  
                                             
                                            }

                                  ?>
                      </h4>       
        </div>
      </div>

      <!-- SidebarSearch Form
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                MENÚ PRINCIPAL
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
   
              <li class="nav-item">
                <a href="?c=buses&a=menuBuses" class="nav-link">

                  <i class='fas fa-bus' style='font-size:24px'></i>
             
                  <p>Buses</p>
                </a>
              </li> 
              <li class="nav-item">
                <a href="?c=persona&a=menuPersona" class="nav-link">
              <i class='fas fa-users' style='font-size:24px'></i>
                  <p>Personas</p>
                </a>
              </li>                             

              <li class="nav-item">
                <a href="?c=roles&a=menuRoles" class="nav-link">
                  <i class='fas fa-user-tag' style='font-size:24px'></i>
                  <p>Roles</p>
                </a>
              </li>  
              <li class="nav-item">
                <a href="?c=visor&a=menuVisor" class="nav-link">
                <i class='fas fa-map-marked-alt' style='font-size:24px'></i>
                  <p>Visor online</p>
                </a>
              </li>  
              <li class="nav-item">
                <a href="?c=gps&a=menuGps" class="nav-link">
                  <i class='fas fa-wifi' style='font-size:24px'></i>
                  <p>Gps</p>
                </a>
              </li>                   
            
              <li class="nav-item">
                <a href="?c=variantes&a=menuVariantes" class="nav-link">

              <i class="fa fa-road" aria-hidden="true"></i>
                  <p>Variantes</p>
                </a>
              </li> 

               <li class="nav-item">
                <a href="?c=controles&a=menuControles" class="nav-link">
                 <i class='fas fa-clock' style='font-size:24px'></i>
                  <p>Controles</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="?c=rutas&a=menuRutas" class="nav-link">
                 <i class='far fa-file-alt' style='font-size:24px'></i>
                  <p>Hoja de Ruta</p>
                </a>
              </li> 
              <li class="nav-item">
                <a href="?c=tarjetas&a=menuTarjetas" class="nav-link">
                 <i class='far fa-file-alt' style='font-size:24px'></i>
                  <p>Tarjetas</p>
                </a>
              </li>               
              <li class="nav-item">
                <a href="?c=tarjetas&a=GenerarTarjetas" class="nav-link">
                 <i class='far fa-file-alt' style='font-size:24px'></i>
                  <p>Generar tarjeta</p>
                </a>
              </li>  
             <li class="nav-item">
                <a href="?c=hospedaje&a=menuResumenPago" class="nav-link">
                  <i class='fas fa-dollar-sign' style='font-size:24px'></i>
                  <p>Tabla de valores</p>
                </a>
              </li>   
                                   
              <li class="nav-item">
                <a href="?c=usuarios&a=menuUsuario" class="nav-link">
                  <i class='fas fa-user-alt' style='font-size:24px'></i>
                  <p>Usuarios</p>
                </a>
              </li>              
            </ul>
          </li>

     <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Charts
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pages/charts/chartjs.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>ChartJS</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/charts/flot.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Flot</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/charts/inline.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Inline</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/charts/uplot.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>uPlot</p>
                </a>
              </li>
            </ul>
          </li>
      
      
      
<!--          <li class="nav-header">EXAMPLES</li>



          <li class="nav-header">MISCELLANEOUS</li>-->
       <!--
          <li class="nav-item">
            <a href="https://adminlte.io/docs/3.1/" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>EDITAR USUARIO</p>
            </a>
          </li>-->

             <li class="nav-item">
            
              
    
                                 <?php 

                                          $usuario = null;
                                          if (isset($_SESSION["usuarioInventario"])) {
                                              $usuario = $_SESSION["usuarioInventario"];
                                        
                                          } else {
                                              header("Location: ../../index.php");
                                          }
                                               echo "\n ";
                                                    if ( $_SESSION["usuarioInventario"] )
                                                    {
                                                      echo "<li> <a href='includes/cerrarSesion.php'><h5 class='titulos2'><span class='glyphicon glyphicon-off titulos2'></span> Salir</h5></a></li>";
                                                    }

                                    ?>  
          
          </li>
         
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>


 <!-- /.HASTA AQUI MENU DE LA IZQUIERDA!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="dashboard-heading">Panel de control</h1>
            <p class="dashboard-subtitle">Resumen general de la operación de flota</p>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            
               <div  id="barraUsuarioFecha" align="right">  
                                <script type="text/javascript">
                                    var d = new Date();
                                    var dayname = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
                                    var monthname = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

                                    document.write(dayname[d.getDay()]);
                                    document.write(', ');
                                    document.write(d.getDate());
                                    document.write(' de ');
                                    document.write(monthname[d.getMonth()]);
                                    document.write(' de ');
                                    document.write(d.getFullYear());
                                </script>
                                  <?php
                     date_default_timezone_set("America/Santiago"); 
                    echo date("H:i:s");?>


                    
                              </div>
            
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">





          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
 
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

  <!-- /.content-wrapper -->
  

<script type="text/javascript">
            /*
      $(document).ready(function(){
 
          var id = 1;
          var parametros =      
                {"action":"ajax",id};       
    
        $.ajax({
            url:'persona/reportes/getCantPersonas.php',
            data: parametros,
         
            success:function(data){
            
                $(".cantidad1").html(data).fadeIn('slow');
            
            }
        })
    });*/
</script>
      
     

 <script type="text/javascript">
            /*
      $(document).ready(function(){
 
          var id = 1;
          var parametros =      
                {"action":"ajax",id};       
    
        $.ajax({
            url:'persona/reportes/getCantComidas.php',
            data: parametros,
         
            success:function(data){
            
                $(".comidas1").html(data).fadeIn('slow');
            
            }
        })
    });*/
</script>


 <script type="text/javascript">
            /*
      $(document).ready(function(){
 
          var id = 1;
          var parametros =      
                {"action":"ajax",id};       
    
        $.ajax({
            url:'hospedaje/reportes/getCantHospedajes.php',
            data: parametros,
         
            success:function(data){
            
                $(".hospedaje1").html(data).fadeIn('slow');
            
            }
        })
    });*/
</script>


 <script type="text/javascript">
            /*
      $(document).ready(function(){
 
          var id = 1;
          var parametros =      
                {"action":"ajax",id};       
    
        $.ajax({
            url:'trabajador/reportes/getTrabajadores.php',
            data: parametros,
         
            success:function(data){
            
                $(".trabajadores1").html(data).fadeIn('slow');
            
            }
        })
    });*/
</script>
