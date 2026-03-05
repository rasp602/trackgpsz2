 <?php include_once 'header.php'; ?>
<?php include_once '../../bd/conexion.php'; ?>
<body>
    
     <div id="header" align="center" class="container-fluid"> 

            <div id="barraUsuarioFecha">
                <div class="usuario">
                    &nbsp;
                </div>
                <div class ="fecha">
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
                </div>
            </div>

      <div class="col-sm-4 col-md-6"><img src="../../img/logogps.jpg" width="600px" height="500px"></div>     
 <div class="col-md-6">
    <div class="col-md-6 col-lg-6">    
      <form name="formLogin" class="form-group" action="../../handler.php" method="POST">
        <div class="container-fluid">        
                <div class="col-md-12 inicio" align="center">
                    <br><br><br>
                   <h3 align="center" class="">¡Hola! Ingresa tu e‑mail o usuario</h3> 

                   <input type="text" class="form-control" name="txtUsuario" id="txtUsuario" maxlength="30" size="30" title="" placeholder=""  autocomplete="off" required/>  <br>  

                   <input type="password" class="form-control" name="txtPassword" id="txtPassword" maxlength="8" size="30" title="" placeholder="" required /> <br>
                </div>
           
                <div class="row">
                  <div class="col-md-12" align="center">
                     <button id="btnAceptar" name="btnAceptar" class="btn btn-success">Aceptar</button>    
                     <button  class="btn btn-danger" type='reset' value='Reset' name="btnCancelar">Limpiar</button> 
                  </div>  
                </div><br>

                <div class="row">
                  <div class="col-md-12" align="center"></div>
   

                      <?php if (isset($_GET["error"])) echo '<h5 align="center" class="registrarse">* Usuario o contraseña incorrecta.</h5>'; ?> 
                </div>     

                <input type="hidden" name="c" value="login">
                <input type="hidden" name="a" value="Procesar">                  
        </div>                   
      </form> 
    </div> 
            
</div>
</div>





