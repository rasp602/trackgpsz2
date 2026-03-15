<!-- Include Date Range Picker -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

<div class="container-fluid">
         <?php 
            $usuario = null;
              if (isset($_SESSION["usuarioInventario"]))
              {
                $usuario = $_SESSION["usuarioInventario"];
                    if ($usuario->nivel == "U") 
                        {
                                echo "hola usuario";
                                 include_once 'menu_principal/vista/Menu_sincantidades.php'; 
                        }  

                   if ($usuario->nivel == "F") 
                        {
                                echo "hola Fiscalizador";
                                include_once 'menu_principal/vista/Menu_Fiscalizador.php';   
                        } 
               }               
         ?> 
     




<div class="row">
    <input type="hidden" name="id_user" id="id_user" value=" 
     <?php session_start();
      if (isset($_SESSION['usuario'])) {
          $usuario = $_SESSION['usuario'];
          $cliente = $usuario->id_user;
      }
    ?>">

 
    </div>

   <div class="row">
  
    	<div class="col-md-12">
    		<div class="outer_div"></div>
            <iframe src="http://31.97.87.58:3000" width="100%" height="800px" frameborder="0"></iframe>
    	</div>


</div>


</div>
