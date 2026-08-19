<head>
    <script src="gps/js/ajaxGps.js"></script>

    <style>
        .gps-resumen {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin: 15px 0;
        }

        .gps-resumen-card {
            min-width: 155px;
            padding: 12px 15px;
            border: 1px solid #d9e2ec;
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 2px 7px rgba(0,0,0,.05);
        }

        .gps-resumen-card span {
            display: block;
            color: #6c757d;
            font-size: 12px;
        }

        .gps-resumen-card strong {
            display: block;
            margin-top: 3px;
            font-size: 22px;
        }

        .gps-ultima-fecha {
            white-space: nowrap;
        }

        .gps-coordenada {
            font-size: 12px;
            line-height: 1.3;
        }

        .btn-registros-gps {
            border: 0;
            border-radius: 5px;
            padding: 6px 10px;
            background: #17a2b8;
            color: #fff;
            cursor: pointer;
        }

        .btn-registros-gps:hover {
            background: #138496;
        }

        .gps-modal-fondo {
            display: none;
            position: fixed;
            z-index: 99999;
            inset: 0;
            padding: 25px;
            background: rgba(0,0,0,.65);
            overflow-y: auto;
        }

        .gps-modal-caja {
            width: min(1200px, 100%);
            margin: 20px auto;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 15px 45px rgba(0,0,0,.35);
        }

        .gps-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 18px;
            background: #007bff;
            color: #fff;
        }

        .gps-modal-header h4 {
            margin: 0;
        }

        .gps-modal-cerrar {
            border: 0;
            background: transparent;
            color: #fff;
            font-size: 28px;
            cursor: pointer;
        }

        .gps-modal-body {
            padding: 15px;
        }

        .gps-modal-toolbar {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: end;
            margin-bottom: 12px;
        }

        .gps-modal-toolbar .grupo {
            min-width: 130px;
        }

        .gps-modal-toolbar label {
            display: block;
            margin-bottom: 4px;
        }

        .gps-modal-toolbar select {
            width: 100%;
        }

        .gps-tabla-registros {
            overflow-x: auto;
        }

        .gps-tabla-registros table {
            min-width: 850px;
        }

        .gps-sin-registro {
            color: #999;
            font-style: italic;
        }

        @media(max-width: 768px) {
            .gps-modal-fondo {
                padding: 5px;
            }

            .gps-modal-caja {
                margin: 5px auto;
            }
        }
    </style>
</head>

<div class="container-fluid">
    <h2 align="center">Dispositivos GPS</h2>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Dispositivo registrado correctamente.</div>
    <?php endif; ?>

    <?php if (isset($_GET['update'])): ?>
        <div class="alert alert-success">Dispositivo actualizado correctamente.</div>
    <?php endif; ?>

    <?php if (isset($_GET['delete'])): ?>
        <div class="alert alert-warning">Dispositivo eliminado de la tabla de dispositivos. El historial GPS no fue eliminado.</div>
    <?php endif; ?>

    <div class="gps-resumen">
        <div class="gps-resumen-card">
            <span>Dispositivos registrados</span>
            <strong id="resumen-dispositivos">0</strong>
        </div>

        <div class="gps-resumen-card">
            <span>Con registros GPS</span>
            <strong id="resumen-con-registro">0</strong>
        </div>

        <div class="gps-resumen-card">
            <span>Sin registros GPS</span>
            <strong id="resumen-sin-registro">0</strong>
        </div>
    </div>

    <div class="row">
        <div class="col-auto h5">
            <p align="center">Mostrar:</p>

            <select name="num_registros" id="num_registros" class="form-control">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>

            <br>

            <p align="center">Registros</p>
        </div>

        <div class="col-md-2 h5">
            <p align="left">Buscar:</p>
            <input
                type="text"
                name="campo"
                id="campo"
                class="form-control"
                placeholder="IMEI, SIM, nombre, bus..."
            >
        </div>

        <div class="col-auto h5">
            <a href="javascript:reportePDF1();" data-toggle="tooltip" title="Descargar dispositivos">
                <img src="img/pdf.png" width="50px" height="50px">
                <p align="center">Descargar</p>
            </a>
        </div>

        <div class="col-auto h5">
            <a href="javascript:reporteExcel();" data-toggle="tooltip" title="Descargar dispositivos">
                <img src="img/excel.png" width="50px" height="50px">
                <p align="center">Descargar</p>
            </a>
        </div>

        <div class="col-auto h5">
            <a href="?c=gps&a=Crud">
                <i class="fas fa-wifi" style="font-size:48px"></i>
                <p>Agregar Dispositivo</p>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12" style="overflow-x:auto;">
            <table class="table table-condensed table-striped table-bordered table-hover">
                <thead class="bg-primary" align="center">
                    <tr>
                        <th class="sort asc">IMEI</th>
                        <th class="sort asc">SIM Card</th>
                        <th class="sort asc">Marca</th>
                        <th class="sort asc">Modelo</th>
                        <th class="sort asc">Descripción</th>
                        <th>Bus asignado</th>
                        <th>Último registro</th>
                        <th>Posición</th>
                        <th>Velocidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody id="content" class="h5" align="center"></tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <label id="lbl-total"></label>
        </div>

        <div class="col-md-12" id="nav-paginacion"></div>

        <input type="hidden" id="pagina" value="1">
        <input type="hidden" id="orderCol" value="0">
        <input type="hidden" id="orderType" value="asc">
    </div>
</div>

<!-- Modal nativo para ver historial de registros GPS -->
<div id="modalRegistrosGps" class="gps-modal-fondo">
    <div class="gps-modal-caja">
        <div class="gps-modal-header">
            <h4 id="tituloRegistrosGps">Registros GPS</h4>

            <button
                type="button"
                class="gps-modal-cerrar"
                onclick="cerrarRegistrosGps()"
                aria-label="Cerrar"
            >&times;</button>
        </div>

        <div class="gps-modal-body">
            <div class="gps-modal-toolbar">
                <div class="grupo">
                    <label>Mostrar últimos</label>

                    <select
                        id="limiteRegistrosGps"
                        class="form-control"
                        onchange="recargarRegistrosGps()"
                    >
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100" selected>100</option>
                        <option value="200">200</option>
                        <option value="500">500</option>
                    </select>
                </div>

                <div>
                    <button
                        type="button"
                        class="btn btn-primary"
                        onclick="recargarRegistrosGps()"
                    >
                        Actualizar
                    </button>
                </div>

                <div>
                    <strong id="totalRegistrosGps"></strong>
                </div>
            </div>

            <div id="estadoRegistrosGps" class="alert alert-info">
                Seleccione un dispositivo.
            </div>

            <div class="gps-tabla-registros">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha / Hora</th>
                            <th>Acción</th>
                            <th>Latitud</th>
                            <th>Longitud</th>
                            <th>Velocidad</th>
                            <th>Mapa</th>
                        </tr>
                    </thead>

                    <tbody id="contenidoRegistrosGps"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
let imeiRegistroSeleccionado = '';
let descripcionRegistroSeleccionada = '';

getData();

document.getElementById("campo").addEventListener("keyup", function () {
    document.getElementById("pagina").value = 1;
    getData();
}, false);

document.getElementById("num_registros").addEventListener("change", function () {
    document.getElementById("pagina").value = 1;
    getData();
}, false);

function getData() {
    let input = document.getElementById("campo").value;
    let num_registros = document.getElementById("num_registros").value;
    let content = document.getElementById("content");
    let pagina = document.getElementById("pagina").value;
    let orderCol = document.getElementById("orderCol").value;
    let orderType = document.getElementById("orderType").value;

    if (pagina == null || pagina == "") {
        pagina = 1;
    }

    let url = "gps/vista/loadGps.php";
    let formaData = new FormData();

    formaData.append("accion", "listar");
    formaData.append("campo", input);
    formaData.append("registros", num_registros);
    formaData.append("pagina", pagina);
    formaData.append("orderCol", orderCol);
    formaData.append("orderType", orderType);

    fetch(url, {
        method: "POST",
        body: formaData
    })
    .then(function(response) {
        if (!response.ok) {
            throw new Error("HTTP " + response.status);
        }

        return response.json();
    })
    .then(function(data) {
        content.innerHTML = data.data || '';

        document.getElementById("lbl-total").innerHTML =
            "Mostrando " +
            (data.totalFiltro || 0) +
            " de " +
            (data.totalRegistros || 0) +
            " dispositivos";

        document.getElementById("nav-paginacion").innerHTML =
            data.paginacion || '';

        document.getElementById("resumen-dispositivos").textContent =
            data.totalRegistros || 0;

        document.getElementById("resumen-con-registro").textContent =
            data.totalConRegistro || 0;

        document.getElementById("resumen-sin-registro").textContent =
            data.totalSinRegistro || 0;
    })
    .catch(function(err) {
        console.error(err);

        content.innerHTML =
            '<tr><td colspan="10" class="text-danger">' +
            'No fue posible cargar los dispositivos: ' +
            escaparHtml(err.message) +
            '</td></tr>';
    });
}

function nextPage(pagina) {
    document.getElementById("pagina").value = pagina;
    getData();
}

function verRegistrosGps(imei, descripcion) {
    imeiRegistroSeleccionado = imei;
    descripcionRegistroSeleccionada = descripcion || '';

    document.getElementById("tituloRegistrosGps").textContent =
        "Registros GPS - " +
        (descripcionRegistroSeleccionada
            ? descripcionRegistroSeleccionada + " - "
            : "") +
        imeiRegistroSeleccionado;

    document.getElementById("modalRegistrosGps").style.display = "block";

    cargarRegistrosGps();
}

function recargarRegistrosGps() {
    if (!imeiRegistroSeleccionado) {
        return;
    }

    cargarRegistrosGps();
}

function cargarRegistrosGps() {
    const estado = document.getElementById("estadoRegistrosGps");
    const contenido = document.getElementById("contenidoRegistrosGps");
    const total = document.getElementById("totalRegistrosGps");

    estado.style.display = "block";
    estado.className = "alert alert-info";
    estado.textContent = "Consultando registros...";

    contenido.innerHTML = '';
    total.textContent = '';

    const formaData = new FormData();

    formaData.append("accion", "registros");
    formaData.append("imei", imeiRegistroSeleccionado);
    formaData.append(
        "limite",
        document.getElementById("limiteRegistrosGps").value
    );

    fetch("gps/vista/loadGps.php", {
        method: "POST",
        body: formaData
    })
    .then(function(response) {
        if (!response.ok) {
            throw new Error("HTTP " + response.status);
        }

        return response.json();
    })
    .then(function(data) {
        if (!data.success) {
            throw new Error(data.error || "Error consultando registros");
        }

        contenido.innerHTML = data.data || '';

        total.textContent =
            "Total histórico: " +
            (data.totalRegistros || 0) +
            " registros";

        estado.style.display = "none";
    })
    .catch(function(error) {
        estado.style.display = "block";
        estado.className = "alert alert-danger";
        estado.textContent =
            "No fue posible cargar los registros: " +
            error.message;
    });
}

function cerrarRegistrosGps() {
    document.getElementById("modalRegistrosGps").style.display = "none";
}

window.addEventListener("click", function(event) {
    const modal = document.getElementById("modalRegistrosGps");

    if (event.target === modal) {
        cerrarRegistrosGps();
    }
});

function escaparHtml(texto) {
    const div = document.createElement("div");
    div.textContent = texto || "";
    return div.innerHTML;
}

let columns = document.getElementsByClassName("sort");

for (let i = 0; i < columns.length; i++) {
    columns[i].addEventListener("click", ordenar);
}

function ordenar(e) {
    let elemento = e.target;

    document.getElementById("orderCol").value = elemento.cellIndex;

    if (elemento.classList.contains("asc")) {
        document.getElementById("orderType").value = "asc";
        elemento.classList.remove("asc");
        elemento.classList.add("desc");
    } else {
        document.getElementById("orderType").value = "desc";
        elemento.classList.remove("desc");
        elemento.classList.add("asc");
    }

    getData();
}
</script>