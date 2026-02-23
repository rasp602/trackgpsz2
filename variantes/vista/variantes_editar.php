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


  <?php include_once 'menu_principal/vista/Menu_Usuarios.php'; ?>   
  <?php $cliente=$usuario->id_user;?>       

  <?php if (isset($_GET["repetido"])) echo '<div class="alert alert-warning" role="alert">El Bus que intenta ingresar ya se encuentra registrado...</div>';?> 

  <div class="container-fluid">

      <div class="row">         
      <div class="col-md-12">
            <h2 align="center" class="titulos">Actualizar Variante</h2>
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Datos de la variante</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="form1" action="?c=variantes&a=Guardar" name="form1" method="post" enctype="multipart/form-data">
              <div class="col-md-6">
                <div class="card-body">
                  <div class="form-group">
                    <input type="hidden" class="form-control" id="idVariante" name="idVariante" value="<?php echo $vte->idVariante;?>">
                    <label for="exampleInputEmail1">Nombre variante</label>
                   <input type="text" class="form-control" id="nombreVariante" name="nombreVariante" value="<?php echo $vte->nombreVariante;?>" maxlength="10" placeholder="Ingresa el nombre de la variante">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Numero de variante</label>
                    <input type="text" class="form-control" id="numeroVariante" name="numeroVariante" value="<?php echo $vte->numeroVariante;?>"  placeholder="Ingresa numero de la variante" onkeypress="return numeros(event)">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Freciencia Maxima</label>
                    <input type="text" class="form-control" id="frecMax" name="frecMax" value="<?php echo $vte->frecMax;?>" placeholder="Ingresa la frecuencia maxima" onkeypress="return numeros(event)">
                  </div> 
                  <div class="form-group">
                    <label for="exampleInputEmail1">Freciencia Minima</label>
                    <input type="text" class="form-control" id="frecMin" name="frecMin" value="<?php echo $vte->frecMin;?>" placeholder="Ingresa la frecuencia minima"onkeypress="return numeros(event)">
                  </div> 
                  <div class="form-group">
                    <label for="exampleInputEmail1">Freciencia Normal</label>
                    <input type="text" class="form-control" id="frecNormal" name="frecNormal" value="<?php echo $vte->frecNormal;?>" placeholder="Ingresa la frecuencia Normal" onkeypress="return numeros(event)">
                  </div> 
                  <input type="hidden" class="form-control" id="estadoVariante" name="estadoVariante" value="A">              
                </div>
              </div>
              <div class="col-md-6">
                <div class="card-body">
                 <div class="form-group">
                    <label for="exampleInputPassword1">Media Vuelta:</label>
                    <select name="mediaVuelta" id="mediaVuelta" class="form-control">
                         <option value="NO">No</option>
                         <option value="SI">Si</option>                       
                    </select>
                  </div>  
                  <div class="form-group">
                    <label for="exampleInputPassword1">Proxima Variante</label>
                       <select name="proximaVariante" id="proximaVariante" class="form-control  input-md">
                        <?php  foreach ($this->model->ListarVariantes()as $a): ?>
                        <option  <?php echo $a->idVariante == "" ? 'selected' : ''; ?> value="<?php echo "$a->idVariante" ;?>"><?php echo $a->nombreVariante;?></option>
                                      <?php endforeach; ?>  
                      </select>
                  </div>  

                  <div class="form-group">
                    <label for="exampleInputEmail1">Hora de Primera salida</label>
                    <input type="time" class="form-control" id="primeraSalida" name="primeraSalida" value="<?php echo $vte->primeraSalida;?>" >
                  </div> 
                  <div class="form-group">
                    <label for="exampleInputEmail1">Color de variante</label>
                    <input type="color" class="form-control" id="colorVariante" name="colorVariante" value="<?php echo $vte->colorVariante;?>" >
                  </div>

                  <div class="form-group">             
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                    <input type="button" id="cancelar" class="btn btn-danger" name="Cancelar" value="Cancelar" onClick="location.href='?c=menu_principal&a=menu_usuarios'">
                  </div>                 
                </div>
              </div>              
                <!-- /.card-body -->


              </form>
            </div>


            </div>
            
        </div>
   </div>    
   </div>    
<br>
   </div> 
 <script>
    function numeros(e){
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = " 0123456789";
    especiales = [9,13,8,37,39,46,38,46,164];
 
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
           especiales="13-9-8-37-38-46-164";
           
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