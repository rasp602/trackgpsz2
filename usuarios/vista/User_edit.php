<?php
	error_reporting(E_ERROR | E_PARSE); // Desactiva la notificación y warnings de error en php.
?>
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


<div class="container-fluid">

<div class="col-md-4">
    <form id="frm-alumno" action="handler.php?c=usuarios&a=Guardar" method="post" enctype="multipart/form-data">
    <h3><span class="glyphicon glyphicon-paperclip"></span> Datos Personales: </h3>

    <input type="hidden" name ="idUsuario"value="<?php echo $vte->idUsuario?>">

    <div class="row">
        <div class="row">
            <div class="col-xs-8 col-sm-9 col-md-9">
               <input type="text" class="form-control" name="Cedula" placeholder="Cedula:" value="<?php echo $vte->rut; ?>">
            </div>

        </div> 
               <input type='text'   class='form-control'  name='Nombre'   placeholder="Nombre:"   value="<?php echo $vte->nombre; ?>"><br>
               <input type='text'   class='form-control'  name='Apellido' placeholder="Apellido:" value="<?php echo $vte->apellido; ?>"><br> 
               <input type="date"   class='form-control'  name="FechaNacimiento"  placeholder="fecha de nacimiento" value="<?php echo $vte->fechacrea; ?>">
               <input type="hidden" class='form-control'  name="Fechacrea"                        value="<?php echo date("Y-m-d");?>">
                <br>
                <select name="genero" id="option" class="form-control">
                    <option value="">Genero:</option>
                    <option <?php echo $alm->genero == F ? 'selected' : ''; ?> value="F">Femenino</option>
                    <option <?php echo $alm->genero == M ? 'selected' : ''; ?> value="M">Masculino</option>
                </select>
       
         
        
    </div>
</div>


    <div class="col-md-4">
        <h3><span class="glyphicon glyphicon-user"></span> Datos de Usuario:</h3>
        <input type='text' id='email' class='form-control' name='Email' placeholder="E-mail:" value="<?php echo $alm->email; ?>"><br>
        <input type='password' id='password' class='form-control' name='Password' placeholder="Clave:"  value="<?php echo $alm->password; ?>"><br>
    </div>

    <div class="col-md-12" align="center"><br>
         <input type="submit"  id="Registrar" class="btn btn-lg btn-default" value='Registrar'/>
         <input type="button"  class="btn btn-lg btn-default" name="Cancelar" value="Cancelar" onClick="location.href='?c=usuarios&a=menuUsuario'">
    </div> 

</form>
</div>  

</div>
 

       



