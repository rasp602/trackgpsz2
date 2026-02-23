<?php
error_reporting(E_ERROR | E_PARSE); // Desactiva la notificación y warnings de error en php.
session_start();

if (!isset($_SESSION['usuarioInventario']))
{

  exit;
}
?>


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
<br>
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
                <a href="?c=buses&a=visorOnline" class="nav-link">
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

             <i class='glyphicon glyphicon-road' style='font-size:24px'></i>
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
                  <p>Tarjeta de salida</p>
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
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">

          <!-- ./col -->

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3 class="cantidad"></h3>

                <h4>Personas registradas</h4>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="?c=persona&a=Crud" class="small-box-footer">Registrar Persona <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3 class="hospedaje"></h3>

                <h4>Buses</h4>
              </div>
                      <div class="icon">
                <i class="ion  ion-android-bus"></i>
              </div>
          
              
            <a href="?c=hospedaje&a=Crud" class="small-box-footer">Registrar Bus <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
    
          <!-- ./col -->

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3 class="comidas"></h3>
              <div class="icon">
                <i class="ion ion-ios-contact"></i>
              </div>
                <h4>Usuarios</h4>
              </div>

              <a href="?c=comida&a=Crud1" class="small-box-footer">Registrar usuario <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3 class="trabajadores"></h3>

                <h4>Controles</h4>
              </div>
              <div class="icon">
                <i class="ion ion-android-time"></i>
              </div>
              <a href="?c=trabajador&a=Crud" class="small-box-footer">Registrar Trabajador <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>






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