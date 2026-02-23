<?php
	error_reporting(E_ERROR | E_PARSE); // Desactiva la notificación y warnings de error en php.
/*  date_default_timezone_set("America/caracas");
  $hora=date("H:i:s");
  echo $hora;*/
?>

<!-- Include Date Range Picker -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

<script>
function subirimagen()
{
  self.name = 'opener';
  remote = open('persona/vista/gestionimagen.php', 'remote', 'width=600,height=200,location=no,scrollbars=yes,menubars=no,toolbars=no,resizable=yes,fullscreen=yes, status=yes');
  remote.focus();
  }

</script>


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
  <?php $cliente=$usuario->id_user;?>       

  <div class="row">
    <div class="col-md-12">
<?php if (isset($_GET["success"])) echo '<div class="alert alert-info" role="alert"> Persona registrada correctamente..</div>'; ?> 

     <?php if (isset($_GET["delete"])) echo '<div class="alert alert-warning" role="alert">Persona eliminada correctamente..</div>'; ?> 
        
     <?php if (isset($_GET["update"])) echo '<div class="alert alert-warning" role="alert">Persona actulizada correctamente..</div>'; ?>

    <?php if (isset($_GET["repetido"])) echo '<div class="alert alert-warning" role="alert">La persona que intenta ingresar ya se encuentra registrada...</div>';?> 
    </div>
 </div>


        <div class="col-md-12">
                     

    <div class="row">         
      <div class="col-md-12">
           <h2 align="center" class="titulos">Nueva Persona</h2>
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Datos personales</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
           <form id="form1" action="?c=persona&a=Guardar" name="form1" method="post" enctype="multipart/form-data">
              <div class="col-md-6">
                <div class="card-body">
                  <div class="form-group">
                    <input type="hidden" class="form-control" id="idPersona" name="idPersona" value="<?php echo $vte->idPersona;?>"> 
                    <label for="exampleInputEmail1">Cedula Persona:</label>
                    <input type="text" class="form-control" id="cedulaPersona" name="cedulaPersona" value="<?php echo $vte->cedulaPersona;?>" oninput="" maxlength="10" placeholder="Ingresa la cedula"> 
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Numero Persona:</label>
                     <input type="text" class="form-control" id="numeroPersona" name="numeroPersona" value="<?php echo $vte->numeroPersona;?>" oninput="" maxlength="10" placeholder="Ingrese el numero"> 
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1"> Primer Nombre:</label>
                    <input type="text" class="form-control" id="nombre1Persona" name="nombre1Persona" value="<?php echo $vte->nombre1Persona;?>" onkeypress="" placeholder ="Ingrese el nombre">
                  </div>   

                  <div class="form-group">
                    <label for="exampleInputEmail1">Segundo Nombre:</label>
                   <input type="text" class="form-control" id="nombre2Persona" name="nombre2Persona" value="<?php echo $vte->nombre2Persona;?>" onkeypress="" placeholder="Ingrese el segundo nombre"> 
                  </div>  
                  <div class="form-group">
                    <label for="exampleInputEmail1">Primer Apellido:</label>
                   <input type="text" class="form-control" id="apellido1Persona" name="apellido1Persona" value="<?php echo $vte->apellido1Persona;?>" onkeypress="return sololetras(event)" placeholder="Ingrese el primer apellido"> 
                  </div>  

                  <div class="form-group">
                    <label for="exampleInputEmail1">Segundo Apellido:</label>
                  <input type="text" class="form-control" id="apellido2Persona" name="apellido2Persona" value="<?php echo $vte->apellido2Persona;?>" onkeypress="return sololetras(event)" placeholder="Ingrese el segundo apellido"> 
                  </div>  
                  <input type="hidden" class="form-control" id="fechaIngreso" name="fechaIngreso" placeholder="fechaIngreso" value="<?php echo date("Y-m-d");?>">
                  <input type="hidden" class="form-control" id="estadoPersona" name="estadoPersona" value="A">
                </div>
              </div>
              <div class="col-md-6">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Dirección:</label>
                     <input type="text" class="form-control" id="direccionPersona" name="direccionPersona" placeholder="Ingrese la dirección" value="<?php echo $vte->direccionPersona;?>">
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">Telefono:</label>
                      <input type="text" class="form-control" id="nTelefonoPersona" name="nTelefonoPersona" placeholder="Ingrese el numero de Telefono" value="<?php echo $vte->nTelefonoPersona;?>" maxlength="15">
                  </div>  

                  <div class="form-group">
                    <label for="exampleInputPassword1">E-mail:</label>
                     <input type="text" class="form-control" id="emailPersona" name="emailPersona" placeholder="Ingrese E-mail" value="<?php echo $vte->emailPersona;?>" maxlength="50">
                  </div>  
                  

                  <div class="form-group">
                    <label for="exampleInputPassword1">Seleccione un Rol:</label>
                      <select name="idRol" id="idRol" class="form-control  input-md">
                        <?php  foreach ($this->model->ListarRoles()as $a): ?>
                        <option  <?php echo $a->idRol == "" ? 'selected' : ''; ?> value="<?php echo "$a->idRol" ;?>"><?php echo $a->nombreRol;?></option>
                                      <?php endforeach; ?>  
                      </select>
                  </div>  

                  <div class="form-group">             
                    <button type="submit" class="btn btn-primary">Registrar</button>
                    <input type="button" id="cancelar" class="btn btn-danger" name="Cancelar" value="Cancelar" onClick="location.href='?c=menu_principal&a=menu_usuarios'">
                  </div>                     
                </div>
              </div> 
              </form>
            </div>


            </div>
            
        </div>
   </div>  

                   
          
</div>
       
</div>

 <!-- div del menu -->
</div>

 <script>
    function numeros(e){
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = "0123456789";
    especiales = [];
 
    tecla_especial = false
    for(var i in especiales){
 if(key == especiales[i]){
     tecla_especial = true;
     break;
        } 
    }
 
    if(letras.indexOf(tecla)==-1 && !tecla_especial)
        return false;
}
    </script>



      <script>
       
       function sololetras(e){
           key= e.keyCode || e.which;
           teclado= String .fromCharCode(key).toLowerCase();
           letras="abcdefghijklmnñopqrstuvwxyz"
           especiales="13-9-8-37-38-46";
           
           teclado_especial=false;
           
           for(var i in especiales){
               
               if(key==especiales[i]){
                   teclado_especial=true;break;
                   
                   }
               }
           if(letras.indexOf(teclado)==-1 && !teclado_especial){
               
               return false;
               
               }
           
           }
       
       
       </script> 

 <script>
       
function checkRut(rut) {
    // Despejar Puntos
    var valor = rut.value.replace('.','');
    // Despejar Guión
    valor = valor.replace('-','');
    
    // Aislar Cuerpo y Dígito Verificador
    cuerpo = valor.slice(0,-1);
    dv = valor.slice(-1).toUpperCase();
    
    // Formatear RUN
    rut.value = cuerpo + '-'+ dv
    
    // Si no cumple con el mínimo ej. (n.nnn.nnn)
    if(cuerpo.length < 7) { rut.setCustomValidity("RUT Incompleto"); return false;}
    
    // Calcular Dígito Verificador
    suma = 0;
    multiplo = 2;
    
    // Para cada dígito del Cuerpo
    for(i=1;i<=cuerpo.length;i++) {
    
        // Obtener su Producto con el Múltiplo Correspondiente
        index = multiplo * valor.charAt(cuerpo.length - i);
        
        // Sumar al Contador General
        suma = suma + index;
        
        // Consolidar Múltiplo dentro del rango [2,7]
        if(multiplo < 7) { multiplo = multiplo + 1; } else { multiplo = 2; }
  
    }
    
    // Calcular Dígito Verificador en base al Módulo 11
    dvEsperado = 11 - (suma % 11);
    
    // Casos Especiales (0 y K)
    dv = (dv == 'K')?10:dv;
    dv = (dv == 0)?11:dv;
    
    // Validar que el Cuerpo coincide con su Dígito Verificador
    if(dvEsperado != dv) { rut.setCustomValidity("RUT Inválido"); return false; }
    
    // Si todo sale bien, eliminar errores (decretar que es válido)
    rut.setCustomValidity('');
}
       
       </script> 

<script type="text/javascript">
// Campos Nombres
$(document).ready(function () {
        $("#rutPersona").keyup(function () {
            var value = $(this).val();
            $("#qrPersona").val(value);
             $("#card").val(value);
        });
});

</script>

