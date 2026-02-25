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

     <?php if (isset($_GET["delete"])) echo '<div class="alert alert-warning" role="alert">Tarjeta eliminado correctamente..</div>'; ?> 
        
     <?php if (isset($_GET["update"])) echo '<div class="alert alert-warning" role="alert">Tarjeta actualizada correctamente..</div>'; ?>


     <div class="container-fluid">
     <div class="row">
        <!-- Formulario en el lado izquierdo -->
        <div class="col-md-4">
        <form id="form1" action="?c=tarjetas&a=Guardar" name="form1" method="post" enctype="multipart/form-data" class="p-4 shadow rounded bg-light">
        <h2 class="text-center mb-4">Generador de Tarjeta</h2>

        <?php
        $_SESSION['token_tarjeta'] = bin2hex(random_bytes(32));
        ?>
        <input type="hidden" name="token_tarjeta" value="<?= $_SESSION['token_tarjeta'] ?>">
        <!-- Fecha -->
        <div class="mb-3">
            <label for="desde" class="form-label"><strong>Fecha</strong></label>
        <input class="form-control" id="fechaSalida" name="fechaSalida" type="date" value="<?= date('Y-m-d'); ?>" required />
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
        <!-- Bus Delantero -->
        <div class="mb-3">
          
            <input type="hidden" class="form-control" id="busDelantero" name="busDelantero" value="0">
        </div>

        <!-- Bus Trasero -->
        <div class="mb-3">
   
            <input type="hidden" class="form-control" id="busTrasero" name="busTrasero" value="0">
        </div>
      

        <!-- Botones -->
        <div class="text-center">
            <button type="submit" class="btn btn-primary me-2" id="btnGuardar">Generar</button>
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
                            <th>Fecha</th>
                            <th>Hora Ini</th>
                            <th>Hora Fin</th>
                            <th>Placa</th>
                            <th>Bus</th>
                            <th>Variante</th>
                            <th>Sentido</th>
                            <th>Frecuencia</th>
                            <th>Conductor</th>
                            <th>Acciones</th>
                          
                        </tr>
                    </thead>
                   <tbody id="tablaTarjetasBody">
                        <!-- Aquí se llenará la tabla con PHP -->
                        <?php foreach ($this->model->ListarTarjetasNuevo() as $tarjeta): ?>
                            <tr>
                                <td><?php echo $tarjeta->fechaSalida ?></td>
                               <td><?php echo $tarjeta->horaTarjeta; ?></td> 
                                <td><?php echo $tarjeta->horaFin; ?></td>   
                                <td><?php echo $tarjeta->placaBus; ?></td>
                                <td><?php echo $tarjeta->numeroBus; ?></td>
                                <td><?php echo $tarjeta->nombreVariante; ?></td> 
                                <td><?php echo $tarjeta->sentido; ?></td>                               
                                <td><?php echo $tarjeta->frecuenciaTarjeta; ?></td>
                                 <td><?php echo $tarjeta->nombre1Persona." ".$tarjeta->apellido1Persona; ?></td>
                                <td>
                                    <button class="btn btn-info btn-sm btn-ver"data-id="<?php echo $tarjeta->idTarjeta; ?>">Ver</button>
                                    <a href="?c=tarjetas&a=Editar&idTarjeta=<?php echo $tarjeta->idTarjeta; ?>" class="btn btn-warning btn-sm">Editar</a>
                                    <a href="?c=tarjetas&a=Eliminar&idTarjeta=<?php echo $tarjeta->idTarjeta; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalTarjeta" tabindex="-1">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">

      <div class="modal-body p-3">

        <div id="ticketTarjeta" class="ticket-estilo"></div>

        <div class="text-center mt-3">
          <button class="btn btn-sm btn-primary" onclick="imprimirTicket()">
            <i class="fa fa-print"></i> Imprimir
          </button>
        </div>

      </div>

    </div>
  </div>
</div>

</div>

<script>
    document.getElementById("formTarjeta").addEventListener("submit", function(e){

    let btn = document.getElementById("btnGuardar");

    if (btn.dataset.locked === "true") {
        e.preventDefault();
        return;
    }

    btn.dataset.locked = "true";
    btn.disabled = true;
    btn.innerHTML = "Generando tarjeta...";

});
</script>

<script>
document.getElementById("fechaSalida").addEventListener("change", function() {

    let fecha = this.value;

    fetch("?c=tarjetas&a=FiltrarPorFecha&fecha=" + fecha)
        .then(res => res.json())
        .then(data => {

            let tbody = document.getElementById("tablaTarjetasBody");
            tbody.innerHTML = "";

            if (data.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="8" class="text-center">
                            No hay tarjetas para esta fecha
                        </td>
                    </tr>`;
                return;
            }

            data.forEach(t => {

                tbody.innerHTML += `
                    <tr>
                        <td>${t.fechaSalida}</td>
                        <td>${t.horaTarjeta}</td>
                        <td>${t.horaFin}</td>
                        <td>${t.placaBus}</td>
                        <td>${t.numeroBus}</td>
                        <td>${t.nombreVariante}</td>
                        <td>${t.sentido}</td>
                        <td>${t.frecuenciaTarjeta}</td>
                        <td>${t.nombre1Persona} ${t.apellido1Persona}</td>
                        <td>
                            <button class="btn btn-info btn-sm btn-ver" data-id="${t.idTarjeta}">
                                Ver
                            </button>
                            <a href="?c=tarjetas&a=Editar&idTarjeta=${t.idTarjeta}" 
                               class="btn btn-warning btn-sm">Editar</a>
                            <a href="?c=tarjetas&a=Eliminar&idTarjeta=${t.idTarjeta}" 
                               class="btn btn-danger btn-sm">Eliminar</a>
                        </td>
                    </tr>
                `;
            });

        });

});
</script>

<!--IMPRIME EL TICKET-->
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
</script>
<!-- ENVIA LOS DATOS A TABLA TARJETA -->
<script>
$(document).ready(function(){
    $('#form1').submit(function(event){
        console.log("Formulario intentando enviarse..."); // Prueba si entra aquí
        event.preventDefault(); // Evita el envío tradicional del formulario
        
        var idPersona = $("#idPersona").val();
        var idBus = $("#idBus").val();    
        var fechaSalida = $("#fechaSalida").val();
        var horaFin = null;
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
            "fechaSalida": fechaSalida,
            "horaFin": horaFin
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
<!-- OBTIENE LA ULTIMA FRECUENCIA -->

<script>
$(document).ready(function(){

    $('#idVariante, #fechaSalida').change(function(){
        obtenerUltimaFrecuencia();
    });

    function obtenerUltimaFrecuencia() {

        var idVariante = $('#idVariante').val();
        var fechaSalida = $('#fechaSalida').val();

        if(idVariante && fechaSalida) {

            $.ajax({
                url: '?c=tarjetas&a=ObtenerUltimaFrecuencia',
                type: 'POST',
                data: { 
                    idVariante: idVariante,
                    fechaSalida: fechaSalida
                },
                dataType: 'json',
                success: function(response){

                    let ultimaFrecuencia = parseInt(response.frecuenciaTarjeta);
                    let horaAnterior = response.horaTarjeta;

                    // 🔹 CASO 1: No existen registros
                    if (ultimaFrecuencia === -1) {

                        let horaActual = new Date();
                        let horas = String(horaActual.getHours()).padStart(2, '0');
                        let minutos = String(horaActual.getMinutes()).padStart(2, '0');
                        let horaNow = horas + ":" + minutos;

                        $('#frecuenciaTarjeta').val(0);
                        $('#horaTarjeta').val(horaNow);

                        $('#horaTarjeta')
                            .attr('data-hora-inicial', horaNow)
                            .attr('data-tiene-anterior', 0);

                    } 
                    // 🔹 CASO 2: Sí existen registros
                    else {

                        let nuevaFrecuencia = ultimaFrecuencia;

                        $('#frecuenciaTarjeta').val(nuevaFrecuencia);

                        $('#horaTarjeta')
                            .attr('data-hora-inicial', horaAnterior)
                            .attr('data-tiene-anterior', 1)
                            .val(sumarMinutos(horaAnterior, nuevaFrecuencia));
                    }
                }
            });

        } else {

            $('#frecuenciaTarjeta').val("");
            $('#horaTarjeta').val("");
        }
    }

    // 🔹 Cuando cambian manualmente la frecuencia
    $('#frecuenciaTarjeta').on('input', function(){

        let tieneAnterior = $('#horaTarjeta').attr('data-tiene-anterior');
        let horaBase = $('#horaTarjeta').attr('data-hora-inicial');
        let frecuencia = parseInt($(this).val());

        if (tieneAnterior == 1 && !isNaN(frecuencia) && horaBase) {

            $('#horaTarjeta').val(
                sumarMinutos(horaBase, frecuencia)
            );
        }
    });

    // 🔹 Cuando cambian manualmente la hora
    $('#horaTarjeta').on('input', function(){

        let tieneAnterior = $('#horaTarjeta').attr('data-tiene-anterior');

        // 🚫 Si no hay registro anterior, no recalcular
        if (tieneAnterior == 0) {
            $('#frecuenciaTarjeta').val(0);
            return;
        }

        let nuevaHora = $(this).val();
        let horaBase = $('#horaTarjeta').attr('data-hora-inicial');

        if (horaBase && nuevaHora) {

            let nuevaFrecuencia = calcularDiferenciaMinutos(
                horaBase,
                nuevaHora
            );

            $('#frecuenciaTarjeta').val(nuevaFrecuencia);
        }
    });

    function sumarMinutos(hora, minutos) {

        let partesHora = hora.split(":");
        let horas = parseInt(partesHora[0]);
        let mins = parseInt(partesHora[1]);

        mins += minutos;

        if (mins >= 60) {
            horas += Math.floor(mins / 60);
            mins = mins % 60;
        }

        return String(horas).padStart(2, '0') + ":" + 
               String(mins).padStart(2, '0');
    }

    function calcularDiferenciaMinutos(horaInicial, horaFinal) {

        let partesInicio = horaInicial.split(":");
        let partesFin = horaFinal.split(":");

        let totalInicio = parseInt(partesInicio[0]) * 60 + parseInt(partesInicio[1]);
        let totalFin = parseInt(partesFin[0]) * 60 + parseInt(partesFin[1]);

        return totalFin - totalInicio;
    }

});
</script>
<!--OBTIENE LOS DATOS DE LOS CONDUCTORES-->

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

<!-- OBTIENE LOS DATOS PARA VER LA TARJETA-->
<script>
document.addEventListener("click", function(e) {

    if (e.target.classList.contains("btn-ver")) {

        let idTarjeta = e.target.getAttribute("data-id");

        fetch("?c=tarjetas&a=VerAjaxDetalleTarjeta&idTarjeta=" + idTarjeta)
            .then(res => res.json())
            
.then(data => {

    let fechaImp = new Date().toLocaleString();
    let linea = "----------------------------------";

    let tabla = "";
    tabla += "HORA      CONTROL   DIF\n";
    tabla += linea + "\n";

    if (data.detalle.length > 0) {

        data.detalle.forEach(d => {

            let hora = (d.horaProgramada || "").substring(0,5).padEnd(10, " ");
            let control = (" " + d.nombreControl).padEnd(10, " ");

            let dif = "";

            if (d.diferenciaMinutos !== null) {
                dif = (d.diferenciaMinutos > 0 ? "+" : "") + d.diferenciaMinutos;
            }

            tabla += hora + control + dif + "\n";
        });

    } else {
        tabla += "SIN DETALLE GENERADO\n";
    }

    let ticket = `
TARJETA DE SALIDA   
${linea}
MAQUINA : ${data.numeroBus}

Conductor  : ${data.nombre1Persona} ${data.apellido1Persona}
Placa      : ${data.placaBus}
Folio      : ${data.idTarjeta}

Fecha Sal. : ${data.fechaSalida}
Hora Sal.  : ${data.horaTarjeta}
Frecuencia : ${data.frecuenciaTarjeta} min

${linea}

${tabla}

${linea}

Bus Delantero : ${data.busDelantero}
Bus Trasero   : ${data.busTrasero}

${linea}

Hora Impresion:
${fechaImp}
    `;

    document.getElementById("ticketTarjeta").innerText = ticket;

    $('#modalTarjeta').modal('show');

            });
    }

});

</script>

<!--FUNCION PARA VALIDAR SI HAY TARJETAS DUPLICADAS-->
<script>
function validarDuplicado() {

    let fecha = document.getElementById("fechaSalida").value;
    let hora = document.getElementById("horaTarjeta").value;
    let idVariante = document.getElementById("idVariante").value;

    if (!fecha || !hora || !idVariante) {
        return;
    }

    fetch(`?c=tarjetas&a=ValidarDuplicado&fecha=${fecha}&hora=${hora}&idVariante=${idVariante}`)
        .then(res => res.json())
        .then(data => {

            if (data.existe) {
                alert("⚠ Ya existe una tarjeta con esa hora y variante.");
                document.getElementById("btnGuardar").disabled = true;
            } else {
                document.getElementById("btnGuardar").disabled = false;
            }

        });
}

document.getElementById("horaTarjeta").addEventListener("change", validarDuplicado);
document.getElementById("idVariante").addEventListener("change", validarDuplicado);
document.getElementById("fechaSalida").addEventListener("change", validarDuplicado);
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
