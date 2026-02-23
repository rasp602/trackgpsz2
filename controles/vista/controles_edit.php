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
            <h2 align="center" class="titulos">Nuevo Control</h2>
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Datos del control</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="form1" action="?c=controles&a=Guardar" name="form1" method="post" enctype="multipart/form-data">
              <div class="col-md-6">
                <div class="card-body">
                  <div class="form-group">
                    <input type="hidden" class="form-control" id="idControl" name="idControl" value="<?php echo $vte->idControl;?>">
                    <label for="exampleInputEmail1">Nombre control</label>
                   <input type="text" class="form-control" id="nombreControl" name="nombreControl" value="<?php echo $vte->nombreControl;?>" maxlength="10" placeholder="Ingresa el nombre del control">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Abreviación</label>
                    <input type="text" class="form-control" id="abreviacionControl" name="abreviacionControl" value="<?php echo $vte->abreviacionControl;?>"  placeholder="Ingresa la Abreviación">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Logitud 1</label>
                    <input type="text" class="form-control" id="longitud1" name="longitud1" value="<?php echo $vte->logitud1;?>"  placeholder="Ingresa la Abreviación">
                  </div>   

                  <div class="form-group">
                    <label for="exampleInputPassword1">Logitud 2</label>
                    <input type="text" class="form-control" id="longitud2" name="longitud2" value="<?php echo $vte->longitud2;?>"  placeholder="Ingresa la Abreviación">
                  </div>  
                  <div class="form-group">
                    <label for="exampleInputPassword1">Latitud 1</label>
                    <input type="text" class="form-control" id="latitud1" name="latitud1" value="<?php echo $vte->latitud1;?>"  placeholder="Ingresa la Abreviación">
                  </div>  
                  <div class="form-group">
                    <label for="exampleInputPassword1">Latitud 2</label>
                    <input type="text" class="form-control" id="latitud2" name="latitud2" value="<?php echo $vte->latitud2;?>"  placeholder="Ingresa la Abreviación">
                  </div>                    


                  <div class="form-group">
                    <label for="exampleInputEmail1">Angulo de Entrada</label>
                    <input type="text" class="form-control" id="anguloEntrada" name="anguloEntrada" value="<?php echo $vte->anguloEntrada;?>" placeholder="Ingresa el angulo de entrada"onkeypress="return numeros(event)">
                  </div> 
                  <div class="form-group">
                    <label for="exampleInputEmail1">Tolerancia Entrada</label>
                    <input type="text" class="form-control" id="toleraciaEntrada" name="toleraciaEntrada" value="<?php echo $vte->toleraciaEntrada;?>" placeholder="Ingresa la Tolerancia" onkeypress="return numeros(event)">
                  </div> 



                  <input type="hidden" class="form-control" id="estadoControl" name="estadoControl" value="A">              
                </div>
              </div>
              <div class="col-md-6">
                <div class="card-body">
                 <div class="form-group">
                    <label for="exampleInputPassword1">Tipo de Control:</label>
                    <select name="tipoControl" id="tipoControl" class="form-control">
                         <option value="NORMAL">Normal</option>
                         <option value="TERMINAL">Terminal</option>                       
                    </select>
                  </div>  
    

                  <div class="form-group">
                    <label for="exampleInputEmail1">Velocidad max</label>
                    <input type="text" class="form-control" id="velMax" name="velMax" value="<?php echo $vte->velMax;?>" >
                  </div> 
                 <div class="form-group">
                    <label for="exampleInputPassword1">Visible:</label>
                    <select name="visible" id="visible" class="form-control">
                         <option value="0">Si</option>
                         <option value="1">No</option>                       
                    </select>
                  </div>  
                 <div class="form-group">
                    <label for="exampleInputPassword1">Visible:</label>
                    <select name="sentido" id="sentido" class="form-control">
                         <option value="I">IDA</option>
                         <option value="R">REGRESO</option>                       
                    </select>
                  </div>                                    
 
      <div id="mapa" style="height: 400px;"></div>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDV2KA_R534-_7ZGNn8MYKPzUHOAQiwlvI&callback=initMap"></script>


<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>var map = L.map('mapa').setView([-23.6467,-70.3976], 13);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);</script>

                  <div class="form-group">             
                    <button type="submit" class="btn btn-primary">Registrar</button>
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