<!-- Include Date Range Picker -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

<!--<script src="hotel/js/ajaxH.js"></script>-->

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


     <div class="container mt-4">
     <div class="row">
        <!-- Formulario en el lado izquierdo -->
        <div class="col-md-4">
    <form id="form1" action="?c=tarjetas&a=Guardar" name="form1" method="post" enctype="multipart/form-data" class="p-4 shadow rounded bg-light">
        <h2 class="text-center mb-4">Generador de Tarjeta</h2>

        <!-- Fecha -->
        <div class="mb-3">
            <label for="desde" class="form-label"><strong>Fecha</strong></label>
<input class="form-control" id="fechaSalida" name="fechaSalida" type="date" value="<?= date('Y-m-d'); ?>" required />
        </div>

        <!-- Bus -->
        <div class="mb-3">
            <label for="idBus" class="form-label"><strong>Bus</strong></label>
            <select name="idBus" id="idBus" class="form-select" required>
                <option value="">Seleccionar Bus</option>
                <?php foreach ($this->model->ListarBuses() as $a): ?>
                    <option value="<?php echo $a->idBus; ?>" <?php echo $a->idBus == "" ? 'selected' : ''; ?>>
                        <?php echo $a->placaBus; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Hora -->
        <div class="mb-3">
            <label for="horaTarjeta" class="form-label"><strong>Hora</strong></label>
            <input type="time" class="form-control" id="horaTarjeta" name="horaTarjeta" value="<?php echo $vte->horaTarjeta; ?>" />
        </div>

        <!-- Frecuencia -->
        <div class="mb-3">
            <label for="frecuenciaTarjeta" class="form-label"><strong>Frecuencia</strong></label>
            <input type="number" class="form-control" id="frecuenciaTarjeta" name="frecuenciaTarjeta" value="<?php echo $vte->frecuenciaTarjeta; ?>" />
        </div>

        <input type="hidden" class="form-control" id="idPersona" name="idPersona">  
        <div class="row">
            <div class="col-md-12"> 
                <h4>Rut, nombre, apellido</h4>
                <!-- Combo box que funciona como input -->
                <input type="text" class="form-control" id="nombre" name="nombre">
                <!-- Lista desplegable de nombres -->
                <div id="nombresListContainer" class="form-control" style="display: none; background-color: #fff; border: 1px solid #ddd; max-height: 200px; overflow-y: auto;"></div>
            </div>
            <br>
        </div>

        <!-- Variante -->
        <div class="mb-3">
            <label for="idVariante" class="form-label"><strong>Variante</strong></label>
            <select name="idVariante" id="idVariante" class="form-select" required>
                <option value="">Seleccionar Variante</option>
                <?php foreach ($this->model->ListarVariante() as $a): ?>
                    <option value="<?php echo $a->idVariante; ?>" <?php echo $a->idVariante == "" ? 'selected' : ''; ?>>
                        <?php echo $a->idVariante. "-". $a->nombreVariante; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>


        <!-- Bus Delantero -->
        <div class="mb-3">
            <label for="busDelantero" class="form-label"><strong>Bus Delantero</strong></label>
            <select name="busDelantero" id="busDelantero" class="form-select" required>
                <option value="">Seleccionar Bus</option>
                <?php foreach ($this->model->ListarBuses() as $a): ?>
                    <option value="<?php echo $a->idBus; ?>" <?php echo $a->idBus == "" ? 'selected' : ''; ?>>
                        <?php echo $a->placaBus; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Bus Trasero -->
        <div class="mb-3">
            <label for="busTrasero" class="form-label"><strong>Bus Trasero</strong></label>
            <select name="busTrasero" id="busTrasero" class="form-select" required>
                <option value="">Seleccionar Bus</option>
                <?php foreach ($this->model->ListarBuses() as $a): ?>
                    <option value="<?php echo $a->idBus; ?>" <?php echo $a->idBus == "" ? 'selected' : ''; ?>>
                        <?php echo $a->placaBus; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        

        <!-- Botones -->
        <div class="text-center">
            <button type="submit" class="btn btn-primary me-2">Generar</button>
            <button type="button" class="btn btn-danger" id="cancelar" onclick="location.href='?c=menu_principal&a=menu_usuarios'">Cancelar</button>
        </div>
    </form>
</div>

  <!-- Div para la tabla en el lado derecho -->
        <div class="col-md-8">
            <div class="p-4 shadow rounded bg-light">
                <h2 class="text-center mb-4">Listado de Tarjetas</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Hora</th>
                      
                            
                            <th>Bus</th>
                            <th>Variante</th>
                            <th>Frecuencia</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Aquí se llenará la tabla con PHP -->
                        <?php foreach ($this->model->ListarTarjetasNuevo() as $tarjeta): ?>
                            <tr>
                               <td><?php echo $tarjeta->horaTarjeta; ?></td>                     
                            
                                <td><?php echo $tarjeta->placaBus; ?></td>
                                <td><?php echo $tarjeta->nombreVariante; ?></td>                               
                                <td><?php echo $tarjeta->frecuenciaTarjeta; ?></td>
                                <td>
                                    <a href="?c=tarjetas&a=Editar&id=<?php echo $tarjeta->id; ?>" class="btn btn-warning btn-sm">Editar</a>
                                    <a href="?c=tarjetas&a=Eliminar&id=<?php echo $tarjeta->id; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



   <!--<div class="row">
        <div class="col-md-1"></div>
    	<div class="col-md-10">
    		<div class="outer_div"></div>
    	</div>
 <div class="col-md-1"></div>
        <div id="result"></div>
    </div>-->
<?php /*include_once 'tarjetas/vista/tarjetas.php';*/ ?>
</div>



              
<script src="jquery-3.1.1.min.js"></script>
<script>
    $(document).ready(function(){
    $('#form1').submit(function(event){
        event.preventDefault(); // Evita el envío tradicional del formulario

        var idPersona = $("#idPersona").val();
        var idBus = $("#idBus").val();    
        var fechaSalida = $("#fechaSalida").val();
        var idVariante = $("#idVariante").val();     
        var frecuenciaTarjeta = $("#frecuenciaTarjeta").val();
        var busDelantero = $("#busDelantero").val();
        var busTrasero = $("#busTrasero").val();
        var horaTarjeta = $("#horaTarjeta").val();

        var parametros = {
            "idPersona": idPersona,
            "idBus": idBus,
            "idVariante": idVariante,
            "frecuenciaTarjeta": frecuenciaTarjeta,
            "busDelantero": busDelantero,
            "busTrasero": busTrasero,
            "horaTarjeta": horaTarjeta,
            "fechaSalida": fechaSalida
        };

        $.ajax({
            url: 'http://localhost/trackgpsz2/ticketTarjeta.php', // Agregué 'http://'
            type: 'POST',
            data: parametros,
            success: function(data){
                if(data == "1"){
                    alert('Imprimiendo....');
                } else {
                    location.reload();
                }
            },
            error: function(xhr, status, error) {
                console.log("Error en la petición AJAX: " + error);
                alert("Hubo un error al procesar la solicitud.");
            }
        }); 
    });
});



$(document).ready(function(){
    $('#form1').submit(function(event){
        console.log("Formulario intentando enviarse..."); // Prueba si entra aquí
        event.preventDefault(); // Evita el envío tradicional del formulario
        
        var idPersona = $("#idPersona").val();
        var idBus = $("#idBus").val();    
        var fechaSalida = $("#fechaSalida").val();
        var idVariante = $("#idVariante").val();     
        var frecuenciaTarjeta = $("#frecuenciaTarjeta").val();
        var busDelantero = $("#busDelantero").val();
        var busTrasero = $("#busTrasero").val();
        var horaTarjeta = $("#horaTarjeta").val();

        var parametros = {
            "idPersona": idPersona,
            "idBus": idBus,
            "idVariante": idVariante,
            "frecuenciaTarjeta": frecuenciaTarjeta,
            "busDelantero": busDelantero,
            "busTrasero": busTrasero,
            "horaTarjeta": horaTarjeta,
            "fechaSalida": fechaSalida
        };

        console.log("Parámetros a enviar:", parametros); // Verificar valores antes de enviar

        $.ajax({
            url: '?c=tarjetas&a=Guardar', // Verifica que esta URL sea correcta
            type: 'POST',
            data: parametros,
            success: function(data){
                console.log("Respuesta del servidor:", data);
                if(data.trim() === "1"){
                    alert('Imprimiendo....');
                } else {
                   // location.reload();
                   header('Location: ?c=tarjetas&a=menuTarjetas&success=1');
                }
            },
            error: function(xhr, status, error) {
                console.log("Error en la petición AJAX:", error);
                alert("Hubo un error al procesar la solicitud.");
            }
        }); 
    });
});


</script>
<script>
$(document).ready(function(){
    $('#idBus').change(function(){
        obtenerUltimaFrecuencia();
    });

    function obtenerUltimaFrecuencia() {
        var idBus = $('#idBus').val();
        
        if(idBus) {
            $.ajax({
                url: '?c=tarjetas&a=ObtenerUltimaFrecuencia',
                type: 'POST',
                data: { idBus: idBus },
                dataType: 'json',
                success: function(response){
                    console.log("Respuesta recibida:", response);

                    let horaTarjeta = response.horaTarjeta; // Ejemplo: "06:05"
                    let frecuencia = parseInt(response.frecuenciaTarjeta); // Ejemplo: 5

                    if (!isNaN(frecuencia) && horaTarjeta) {
                        $('#frecuenciaTarjeta').val(frecuencia);
                        $('#horaTarjeta').val(sumarMinutos(horaTarjeta, frecuencia));
                        $('#horaTarjeta').attr('data-hora-inicial', horaTarjeta); // Guardamos la hora original
                    }
                },
                error: function(xhr, status, error){
                    console.log("Error al obtener la frecuencia:", error);
                    alert("No se pudo obtener la última frecuencia.");
                }
            });
        } else {
            $('#frecuenciaTarjeta').val("");
            $('#horaTarjeta').val("");
        }
    }

    // Evento cuando cambia la frecuencia
    $('#frecuenciaTarjeta').on('input', function(){
        let horaBase = $('#horaTarjeta').attr('data-hora-inicial'); // Obtener hora original
        let frecuencia = parseInt($(this).val());

        if (!isNaN(frecuencia) && horaBase) {
            $('#horaTarjeta').val(sumarMinutos(horaBase, frecuencia));
        }
    });

    // Evento cuando cambia la hora
    $('#horaTarjeta').on('input', function(){
        let nuevaHora = $(this).val();
        let horaBase = $('#horaTarjeta').attr('data-hora-inicial'); // Obtener hora original

        if (horaBase && nuevaHora) {
            let nuevaFrecuencia = calcularDiferenciaMinutos(horaBase, nuevaHora);
            $('#frecuenciaTarjeta').val(nuevaFrecuencia);
        }
    });

    // Función para sumar minutos a una hora
    function sumarMinutos(hora, minutos) {
        let partesHora = hora.split(":");
        let horas = parseInt(partesHora[0]);
        let mins = parseInt(partesHora[1]);

        mins += minutos;

        if (mins >= 60) {
            horas += Math.floor(mins / 60);
            mins = mins % 60;
        }

        return (horas < 10 ? "0" : "") + horas + ":" + (mins < 10 ? "0" : "") + mins;
    }

    // Función para calcular diferencia de minutos entre dos horas
    function calcularDiferenciaMinutos(horaInicial, horaFinal) {
        let partesInicio = horaInicial.split(":");
        let partesFin = horaFinal.split(":");

        let horasInicio = parseInt(partesInicio[0]);
        let minutosInicio = parseInt(partesInicio[1]);

        let horasFin = parseInt(partesFin[0]);
        let minutosFin = parseInt(partesFin[1]);

        return (horasFin * 60 + minutosFin) - (horasInicio * 60 + minutosInicio);
    }

});
</script>

<script>
$(document).ready(function () {
    // Evento de entrada en el input
    $('#nombre').on('input', function () {
        // Obtener el valor ingresado
        var inputNombre = $(this).val();

        // Realizar la búsqueda AJAX
        $.ajax({
            type: 'POST',
            url: 'tarjetas/vista/buscar_persona_ajax.php',
            data: {nombre: inputNombre},
            dataType: 'json',
            success: function (data) {
                // Limpiar y mostrar la lista desplegable
                $('#nombresListContainer').empty();
                $('#nombresListContainer').show();

                if (data.length > 0) {
                    // Llenar la lista desplegable con los resultados
                    $.each(data, function (key, value) {
                        $('#nombresListContainer').append('<div class="dropdown-item" data-idpersona="' + value.idPersona + '">' + value.nombreCompleto + '-' + value.cedulaPersona + '</div>');
                    });
                } else {
                    // Mostrar mensaje cuando no hay resultados
                    $('#nombresListContainer').append('<div class="dropdown-item disabled text-muted">Conductor no encontrado</div>');
                }
            }
        });
    });

    // Manejar clics en los elementos de la lista desplegable
    $(document).on('click', '#nombresListContainer .dropdown-item:not(.disabled)', function () {
        // Colocar el valor clicado en el campo de búsqueda
        $('#nombre').val($(this).text());

        // Almacenar el idPersona en el input oculto
        $('#idPersona').val($(this).data('idpersona'));

        // Ocultar la lista desplegable
        $('#nombresListContainer').hide();
    });

    // Ocultar la lista desplegable al hacer clic fuera de ella
    $(document).on('click', function (event) {
        if (!$(event.target).closest('#nombresListContainer').length && !$(event.target).is('#nombre')) {
            $('#nombresListContainer').hide();
        }
    });
});
</script>


