<!-- Include Date Range Picker -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

<script src="tarjetas/js/ajaxTarjetas.js"></script>


<div class="container-fluid">
         <?php 
            $usuario = null;
              if (isset($_SESSION["usuarioInventario"]))
              {
                $usuario = $_SESSION["usuarioInventario"];
                    if ($usuario->nivel == "U") 
                        {
                                echo "hola usuario";
                                 include_once 'menu_principal/vista/Menu_Usuarios.php'; 
                        }  

                   if ($usuario->nivel == "F") 
                        {
                                echo "hola Fiscalizador";
                                include_once 'menu_principal/vista/Menu_Fiscalizador.php';   
                        } 
               }               
         ?> 
     
     <?php include_once 'menu_principal/vista/Menu_Usuarios.php'; ?>  

     <?php if (isset($_GET["success"])) echo '<div class="alert alert-info" role="alert"> Tarjeta Generada correctamente..</div>'; ?> 

     <?php if (isset($_GET["delete"])) echo '<div class="alert alert-warning" role="alert">Hotel eliminado correctamente..</div>'; ?> 
        
     <?php if (isset($_GET["update"])) echo '<div class="alert alert-warning" role="alert">Hotel actulizado correctamente..</div>'; ?>


     <div class="container mt-5">
<h1>Tarjetas</h1>

<div class="col-md-2">
<h4>Conductor</h4>
            <select name="idBus" id="idBus" class="form-control input-sm" required>
                <option value="">Seleccionar Bus</option>
                <?php foreach ($this->model->ListarBuses() as $a): ?>
                    <option value="<?php echo $a->idBus; ?>" <?php echo $a->idBus == "" ? 'selected' : ''; ?>>
                        <?php echo $a->placaBus; ?>
                    </option>
                <?php endforeach; ?>
            </select>
    </div>
    <div class="col-md-2">
    <h4>Conductor</h4>
            <select name="idPersona" id="idPersona" class="form-control input-sm" required>
                <option value="">Seleccionar Conductor</option>
                <?php foreach ($this->model->ListarConductor() as $a): ?>
                    <option value="<?php echo $a->idPersona; ?>" <?php echo $a->idPersona == "" ? 'selected' : ''; ?>>
                        <?php echo $a->nombre1Persona . " " . $a->apellido1Persona; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>


        <div class="col-md-2">
        <h4>Variante</h4>
            <select name="idVariante" id="idVariante" class="form-control input-sm" required>
                <option value="">Seleccionar Variante</option>
                <?php foreach ($this->model->ListarVariante() as $a): ?>
                    <option value="<?php echo $a->idVariante; ?>" <?php echo $a->idVariante == "" ? 'selected' : ''; ?>>
                        <?php echo $a->nombreVariante; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-2">
            <h4>Desde</h4>
          <div class="input-group"> 
               <input class="form-control input-sm" id="desde" name="desde"  type="date" value=""  autocomplete="off" required/>

           </div>
        </div>  
        
        <div class="col-md-2">
            <h4>Hasta</h4>
          <div class="input-group">
               <input class="form-control input-sm" id="hasta" name="hasta"  type="date" value=""  autocomplete="off" required/>
          </div>
        </div>









</div>

   <div class="row">
        <div class="col-md-1"></div>
    	<div class="col-md-10">
    		<div class="outer_div"></div>
    	</div>
 <div class="col-md-1"></div>
        <div id="result"></div>
    </div>
<?php /*include_once 'tarjetas/vista/tarjetas.php';*/ ?>
</div>



