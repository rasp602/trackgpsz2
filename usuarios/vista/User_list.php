<!-- Include Date Range Picker -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>


<script src="usuarios/js/ajaxU.js"></script>

<div class="container-fluid">
          <?php include_once 'menu_principal/vista/Menu_Usuarios.php'; ?>
          <h2 class="titulos" align="center">USUARIOS</h2>
       <?php if (isset($_GET["success"])) echo '<div class="alert alert-info" role="alert"> Usuario registrado correctamente..</div>'; ?> 

     <?php if (isset($_GET["delete"])) echo '<div class="alert alert-warning" role="alert">Usuario eliminado correctamente..</div>'; ?> 
        
     <?php if (isset($_GET["update"])) echo '<div class="alert alert-warning" role="alert">Usuario actulizado correctamente..</div>'; ?>       
    
    <div class="row">
        <div class="col-md-3">
            <h4>Nombre de usuario: </h4>
           <input type="text" class="form-control input-sm" id="nombre" name="nombre" placeholder="Buscar:">
        </div>

    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="outer_div"></div>
        </div>
    </div>
</div>




