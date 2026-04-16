<!-- Include Date Range Picker -->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

<!--<script src="hotel/js/ajaxH.js"></script>-->

<div class="container-fluid">
    <?php 
        $usuario = null;
        if (isset($_SESSION["usuarioInventario"])) {
            $usuario = $_SESSION["usuarioInventario"];

            if ($usuario->nivel == "U") {
                echo "hola usuario";
                include_once 'menu_principal/vista/Menu_Usuarios.php'; 
            }

            if ($usuario->nivel == "F") {
                echo "hola Fiscalizador";
                include_once 'menu_principal/vista/Menu_Fiscalizador.php';   
            }
        }               
    ?> 

    <?php if (!isset($_SESSION["usuarioInventario"]) || ($usuario && $usuario->nivel != "F")): ?>
        <?php include_once 'menu_principal/vista/Menu_Usuarios.php'; ?>  
    <?php endif; ?>

    <?php if (isset($_GET["success"])) echo '<div class="alert alert-info" role="alert">Tarjeta generada correctamente.</div>'; ?> 
    <?php if (isset($_GET["delete"])) echo '<div class="alert alert-warning" role="alert">Tarjeta eliminada correctamente.</div>'; ?> 
    <?php if (isset($_GET["update"])) echo '<div class="alert alert-warning" role="alert">Tarjeta actualizada correctamente.</div>'; ?>

    <div class="container-fluid">
        <div class="row">
            <!-- Formulario en el lado izquierdo -->
            <div class="col-md-4">
                <form id="form1" action="index.php?c=Tarjetas&a=Registrar" name="form1" method="post" enctype="multipart/form-data" class="p-4 shadow rounded bg-light">
                    <h2 class="text-center mb-4">Generador de Tarjeta</h2>

                    <?php
                    $_SESSION['token_tarjeta'] = bin2hex(random_bytes(32));
                    ?>
                    <input type="hidden" name="token_tarjeta" value="<?= $_SESSION['token_tarjeta'] ?>">

                    <!-- Fecha -->
                    <div class="mb-3">
                        <label for="fechaSalida" class="form-label"><strong>Fecha</strong></label>
                        <input class="form-control" id="fechaSalida" name="fechaSalida" type="date" value="<?= date('Y-m-d'); ?>" required />
                    </div>

                    <!-- Variante -->
                    <div class="mb-3">
                        <label for="idVariante" class="form-label"><strong>Variante</strong></label>
                        <select name="idVariante" id="idVariante" class="form-control" required>
                            <option value="">Seleccionar Variante</option>
                            <?php foreach ($this->model->ListarVariante() as $a): ?>
                                <option value="<?php echo $a->idVariante; ?>">
                                    <?php echo $a->idVariante . "-" . $a->nombreVariante; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Hora -->
                    <div class="mb-3">
                        <label for="horaTarjeta" class="form-label"><strong>Hora</strong></label>
                        <input type="time" class="form-control" id="horaTarjeta" name="horaTarjeta" value="<?php echo isset($vte->horaTarjeta) ? $vte->horaTarjeta : ''; ?>" />
                    </div>

                    <!-- Frecuencia -->
                    <div class="mb-3">
                        <label for="frecuenciaTarjeta" class="form-label"><strong>Frecuencia</strong></label>
                        <input type="number" class="form-control" id="frecuenciaTarjeta" name="frecuenciaTarjeta" value="<?php echo isset($vte->frecuenciaTarjeta) ? $vte->frecuenciaTarjeta : ''; ?>" />
                    </div>

                    <!-- Bus -->
                    <div class="mb-3">
                        <label for="idBus" class="form-label"><strong>Bus</strong></label>
                        <select name="idBus" id="idBus" class="form-control" required>
                            <option value="">Seleccionar Bus</option>
                            <?php foreach ($this->model->ListarBuses() as $a): ?>
                                <option value="<?php echo $a->idBus; ?>">
                                    <?php echo $a->placaBus; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <input type="hidden" class="form-control" id="idPersona" name="idPersona">  

                    <div class="row">
                        <div class="col-md-12"> 
                            <h4>Rut, nombre, apellido</h4>
                            <input type="text" class="form-control" id="nombre" name="nombre" autocomplete="off">
                            <div id="nombresListContainer" class="form-control" style="display:none; background-color:#fff; border:1px solid #ddd; max-height:200px; overflow-y:auto; position:relative; z-index:999;"></div>
                        </div>
                    </div>

                    <!-- Bus Delantero -->
                    <div class="mb-3">
                        <input type="hidden" class="form-control" id="busDelantero" name="busDelantero" value="1">
                    </div>

                    <!-- Bus Trasero -->
                    <div class="mb-3">
                        <input type="hidden" class="form-control" id="busTrasero" name="busTrasero" value="2">
                    </div>

                    <!-- Botones -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary me-2" id="btnGuardar">Generar</button>
                        <button type="button" class="btn btn-danger" id="cancelar" onclick="location.href='?c=menu_principal&a=menu_usuarios'">Cancelar</button>
                    </div>
                </form>
            </div>

            <!-- Tabla lado derecho -->
            <div class="col-md-8">
                <div class="p-4 shadow rounded bg-light">
                    <h2 class="text-center mb-4">Listado de Tarjetas</h2>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="tablaTarjetas">
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
                                <tr id="filaFiltros">
                                    <th><input type="text" class="form-control form-control-sm filtro-columna" data-col="0" placeholder="Buscar fecha"></th>
                                    <th><input type="text" class="form-control form-control-sm filtro-columna" data-col="1" placeholder="Buscar hora ini"></th>
                                    <th><input type="text" class="form-control form-control-sm filtro-columna" data-col="2" placeholder="Buscar hora fin"></th>
                                    <th><input type="text" class="form-control form-control-sm filtro-columna" data-col="3" placeholder="Buscar placa"></th>
                                    <th><input type="text" class="form-control form-control-sm filtro-columna" data-col="4" placeholder="Buscar bus"></th>
                                    <th><input type="text" class="form-control form-control-sm filtro-columna" data-col="5" placeholder="Buscar variante"></th>
                                    <th><input type="text" class="form-control form-control-sm filtro-columna" data-col="6" placeholder="Buscar sentido"></th>
                                    <th><input type="text" class="form-control form-control-sm filtro-columna" data-col="7" placeholder="Buscar frecuencia"></th>
                                    <th><input type="text" class="form-control form-control-sm filtro-columna" data-col="8" placeholder="Buscar conductor"></th>
                                    <th>
                                        <button type="button" class="btn btn-secondary btn-sm w-100" id="limpiarFiltros">Limpiar</button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="tablaTarjetasBody">
                                <?php foreach ($this->model->ListarTarjetasNuevo() as $tarjeta): ?>
                                    <tr>
                                        <td><?php echo $tarjeta->fechaSalida; ?></td>
                                        <td><?php echo $tarjeta->horaTarjeta; ?></td> 
                                        <td><?php echo $tarjeta->horaFin; ?></td>   
                                        <td><?php echo $tarjeta->placaBus; ?></td>
                                        <td><?php echo $tarjeta->numeroBus; ?></td>
                                        <td><?php echo $tarjeta->nombreVariante; ?></td> 
                                        <td><?php echo $tarjeta->sentido; ?></td>                               
                                        <td><?php echo $tarjeta->frecuenciaTarjeta; ?></td>
                                        <td><?php echo $tarjeta->nombre1Persona . " " . $tarjeta->apellido1Persona; ?></td>
                                        <td>
                                            <button class="btn btn-info btn-sm btn-ver" data-id="<?php echo $tarjeta->idTarjeta; ?>">Ver</button>
                                            <a href="?c=tarjetas&a=Editar&idTarjeta=<?php echo $tarjeta->idTarjeta; ?>" class="btn btn-warning btn-sm">Editar</a>
                                            <a href="?c=tarjetas&a=Eliminar&idTarjeta=<?php echo $tarjeta->idTarjeta; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar esta tarjeta?')">Eliminar</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalTarjeta" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body p-3">
                    <div id="ticketTarjeta" class="ticket-estilo" style="white-space:pre-line; font-family:monospace;"></div>

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
function aplicarFiltrosTabla() {
    const filtros = document.querySelectorAll(".filtro-columna");
    const filas = document.querySelectorAll("#tablaTarjetasBody tr");

    filas.forEach(fila => {
        let mostrar = true;
        const celdas = fila.querySelectorAll("td");

        filtros.forEach(filtro => {
            const col = parseInt(filtro.getAttribute("data-col"));
            const valorFiltro = filtro.value.trim().toLowerCase();

            if (valorFiltro !== "") {
                const textoCelda = celdas[col] ? celdas[col].textContent.trim().toLowerCase() : "";
                if (!textoCelda.includes(valorFiltro)) {
                    mostrar = false;
                }
            }
        });

        fila.style.display = mostrar ? "" : "none";
    });
}

document.addEventListener("input", function(e) {
    if (e.target.classList.contains("filtro-columna")) {
        aplicarFiltrosTabla();
    }
});

document.getElementById("limpiarFiltros").addEventListener("click", function() {
    document.querySelectorAll(".filtro-columna").forEach(input => input.value = "");
    aplicarFiltrosTabla();
});
</script>

<script>
document.getElementById("fechaSalida").addEventListener("change", function() {
    let fecha = this.value;

    fetch("?c=tarjetas&a=FiltrarPorFecha&fecha=" + encodeURIComponent(fecha))
        .then(res => res.json())
        .then(data => {
            let tbody = document.getElementById("tablaTarjetasBody");
            tbody.innerHTML = "";

            if (!data || data.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="10" class="text-center">
                            No hay tarjetas para esta fecha
                        </td>
                    </tr>`;
                return;
            }

            data.forEach(t => {
                tbody.innerHTML += `
                    <tr>
                        <td>${t.fechaSalida ?? ''}</td>
                        <td>${t.horaTarjeta ?? ''}</td>
                        <td>${t.horaFin ?? ''}</td>
                        <td>${t.placaBus ?? ''}</td>
                        <td>${t.numeroBus ?? ''}</td>
                        <td>${t.nombreVariante ?? ''}</td>
                        <td>${t.sentido ?? ''}</td>
                        <td>${t.frecuenciaTarjeta ?? ''}</td>
                        <td>${(t.nombre1Persona ?? '')} ${(t.apellido1Persona ?? '')}</td>
                        <td>
                            <button class="btn btn-info btn-sm btn-ver" data-id="${t.idTarjeta}">Ver</button>
                            <a href="?c=tarjetas&a=Editar&idTarjeta=${t.idTarjeta}" class="btn btn-warning btn-sm">Editar</a>
                            <a href="?c=tarjetas&a=Eliminar&idTarjeta=${t.idTarjeta}" class="btn btn-danger btn-sm">Eliminar</a>
                        </td>
                    </tr>
                `;
            });

            aplicarFiltrosTabla();
        })
        .catch(error => {
            console.log("Error al filtrar por fecha:", error);
        });
});
</script>

<script>
$(document).ready(function(){

    let enviando = false;

    $('#form1').on('submit', function(event){
        event.preventDefault();

        if (enviando) {
            return;
        }

        let btn = document.getElementById("btnGuardar");
        btn.disabled = true;
        btn.innerHTML = "Generando tarjeta...";
        enviando = true;

        var idPersona = $("#idPersona").val();
        var idBus = $("#idBus").val();    
        var fechaSalida = $("#fechaSalida").val();
        var horaFin = null;
        var idVariante = $("#idVariante").val();     
        var frecuenciaTarjeta = $("#frecuenciaTarjeta").val();
        var busDelantero = $("#busDelantero").val();
        var busTrasero = $("#busTrasero").val();
        var horaTarjeta = $("#horaTarjeta").val();
        var token_tarjeta = $('input[name="token_tarjeta"]').val();

        if (!idPersona || !idBus || !fechaSalida || !idVariante || !horaTarjeta) {
            alert("Completa todos los campos obligatorios.");
            btn.disabled = false;
            btn.innerHTML = "Generar";
            enviando = false;
            return;
        }

        var parametros = {
            idPersona: idPersona,
            idBus: idBus,
            idVariante: idVariante,
            frecuenciaTarjeta: frecuenciaTarjeta,
            busDelantero: busDelantero,
            busTrasero: busTrasero,
            horaTarjeta: horaTarjeta,
            fechaSalida: fechaSalida,
            horaFin: horaFin,
            token_tarjeta: token_tarjeta
        };

        console.log("Parámetros a enviar:", parametros);

        $.ajax({
            url: '?c=tarjetas&a=Guardar',
            type: 'POST',
            data: parametros,
            success: function(data){
                console.log("Respuesta Guardar:", data);

                $.ajax({
                    url: '../../trackgpsz2/ticketTarjeta.php',
                    type: 'POST',
                    data: parametros,
                    success: function(respTicket){
                        console.log("Respuesta ticket:", respTicket);
                        window.location.href = '?c=tarjetas&a=menuTarjetas&success=1';
                    },
                    error: function(xhr, status, error) {
                        console.log("Error al imprimir ticket:", error);
                        window.location.href = '?c=tarjetas&a=menuTarjetas&success=1';
                    }
                });
            },
            error: function(xhr, status, error) {
                console.log("Error en Guardar:", error);
                alert("Hubo un error al guardar la tarjeta.");
                btn.disabled = false;
                btn.innerHTML = "Generar";
                enviando = false;
            }
        });
    });

});
</script>

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

                    if (ultimaFrecuencia === -1 || isNaN(ultimaFrecuencia)) {
                        let horaActual = new Date();
                        let horas = String(horaActual.getHours()).padStart(2, '0');
                        let minutos = String(horaActual.getMinutes()).padStart(2, '0');
                        let horaNow = horas + ":" + minutos;

                        $('#frecuenciaTarjeta').val(0);
                        $('#horaTarjeta').val(horaNow);

                        $('#horaTarjeta')
                            .attr('data-hora-inicial', horaNow)
                            .attr('data-tiene-anterior', 0);
                    } else {
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

    $('#frecuenciaTarjeta').on('input', function(){
        let tieneAnterior = $('#horaTarjeta').attr('data-tiene-anterior');
        let horaBase = $('#horaTarjeta').attr('data-hora-inicial');
        let frecuencia = parseInt($(this).val());

        if (tieneAnterior == 1 && !isNaN(frecuencia) && horaBase) {
            $('#horaTarjeta').val(sumarMinutos(horaBase, frecuencia));
        }
    });

    $('#horaTarjeta').on('input', function(){
        let tieneAnterior = $('#horaTarjeta').attr('data-tiene-anterior');

        if (tieneAnterior == 0) {
            $('#frecuenciaTarjeta').val(0);
            return;
        }

        let nuevaHora = $(this).val();
        let horaBase = $('#horaTarjeta').attr('data-hora-inicial');

        if (horaBase && nuevaHora) {
            let nuevaFrecuencia = calcularDiferenciaMinutos(horaBase, nuevaHora);
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

        return String(horas).padStart(2, '0') + ":" + String(mins).padStart(2, '0');
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

<script>
$(document).ready(function () {
    $('#nombre').on('input', function () {
        var inputNombre = $(this).val();

        $.ajax({
            type: 'POST',
            url: 'tarjetas/vista/buscar_persona_ajax.php',
            data: {nombre: inputNombre},
            dataType: 'json',
            success: function (data) {
                $('#nombresListContainer').empty();
                $('#nombresListContainer').show();

                if (data.length > 0) {
                    $.each(data, function (key, value) {
                        $('#nombresListContainer').append(
                            '<div class="dropdown-item" data-idpersona="' + value.idPersona + '">' + value.nombreCompleto + ' - ' + value.cedulaPersona + '</div>'
                        );
                    });
                } else {
                    $('#nombresListContainer').append('<div class="dropdown-item disabled text-muted">Conductor no encontrado</div>');
                }
            }
        });
    });

    $(document).on('click', '#nombresListContainer .dropdown-item:not(.disabled)', function () {
        $('#nombre').val($(this).text());
        $('#idPersona').val($(this).data('idpersona'));
        $('#nombresListContainer').hide();
    });

    $(document).on('click', function (event) {
        if (!$(event.target).closest('#nombresListContainer').length && !$(event.target).is('#nombre')) {
            $('#nombresListContainer').hide();
        }
    });
});
</script>

<script>
document.addEventListener("click", function(e) {
    if (e.target.classList.contains("btn-ver")) {
        let idTarjeta = e.target.getAttribute("data-id");

        fetch("?c=tarjetas&a=VerAjaxDetalleTarjeta&idTarjeta=" + encodeURIComponent(idTarjeta))
            .then(res => res.json())
            .then(data => {
                let fechaImp = new Date().toLocaleString();
                let linea = "----------------------------------";

                let tabla = "";
                tabla += "HORA      CONTROL   DIF\n";
                tabla += linea + "\n";

                if (data.detalle && data.detalle.length > 0) {
                    data.detalle.forEach(d => {
                        let hora = (d.horaProgramada || "").substring(0,5).padEnd(10, " ");
                        let control = (" " + (d.nombreControl || "")).padEnd(10, " ");
                        let dif = "";

                        if (d.diferenciaMinutos !== null && d.diferenciaMinutos !== undefined) {
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
MAQUINA : ${data.numeroBus || ''}

Conductor  : ${data.nombre1Persona || ''} ${data.apellido1Persona || ''}
Placa      : ${data.placaBus || ''}
Folio      : ${data.idTarjeta || ''}

Fecha Sal. : ${data.fechaSalida || ''}
Hora Sal.  : ${data.horaTarjeta || ''}
Frecuencia : ${data.frecuenciaTarjeta || ''} min

${linea}

${tabla}

${linea}

Bus Delantero : ${data.busDelantero || ''}
Bus Trasero   : ${data.busTrasero || ''}

${linea}

Hora Impresion:
${fechaImp}
                `;

                document.getElementById("ticketTarjeta").innerText = ticket;
                $('#modalTarjeta').modal('show');
            })
            .catch(error => {
                console.log("Error al obtener detalle:", error);
            });
    }
});
</script>

<script>
function validarDuplicado() {
    let fecha = document.getElementById("fechaSalida").value;
    let hora = document.getElementById("horaTarjeta").value;
    let idVariante = document.getElementById("idVariante").value;

    if (!fecha || !hora || !idVariante) {
        return;
    }

    fetch(`?c=tarjetas&a=ValidarDuplicado&fecha=${encodeURIComponent(fecha)}&hora=${encodeURIComponent(hora)}&idVariante=${encodeURIComponent(idVariante)}`)
        .then(res => res.json())
        .then(data => {
            if (data.existe) {
                alert("⚠ Ya existe una tarjeta con esa hora y variante.");
                document.getElementById("btnGuardar").disabled = true;
            } else {
                document.getElementById("btnGuardar").disabled = false;
            }
        })
        .catch(error => {
            console.log("Error al validar duplicado:", error);
        });
}

document.getElementById("horaTarjeta").addEventListener("change", validarDuplicado);
document.getElementById("idVariante").addEventListener("change", validarDuplicado);
document.getElementById("fechaSalida").addEventListener("change", validarDuplicado);
</script>

<script>
function imprimirTicket() {
    var contenido = document.getElementById("ticketTarjeta").innerHTML;
    var ventana = window.open('', '', 'width=400,height=600');
    ventana.document.write(`
        <html>
            <head>
                <title>Imprimir Ticket</title>
                <style>
                    body {
                        font-family: monospace;
                        white-space: pre-line;
                        padding: 10px;
                    }
                </style>
            </head>
            <body>${contenido}</body>
        </html>
    `);
    ventana.document.close();
    ventana.focus();
    ventana.print();
    ventana.close();
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>