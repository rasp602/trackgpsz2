<div class="container-fluid">
    <h2>Buses</h2>

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
            <input type="text" name="campo" id="campo" class="form-control">
        </div>

        <div class="col-auto h5">
            <a href="javascript:reportePDF1();" data-toggle="tooltip" title="Descargar buses">
                <img src="img/pdf.png" width="50" height="50" alt="PDF">
                <p align="center">Descargar</p>
            </a>
        </div>

        <div class="col-auto h5">
            <a href="javascript:reporteExcel();" data-toggle="tooltip" title="Descargar buses">
                <img src="img/excel.png" width="50" height="50" alt="Excel">
                <p align="center">Descargar</p>
            </a>
        </div>

        <div class="col-auto h5">
            <a href="?c=buses&a=Crud">
                <i class="fas fa-bus" style="font-size:48px"></i>
                <p>Agregar Bus</p>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 table-responsive">
            <table class="table table-condensed table-striped table-bordered table-hover">
                <thead class="bg-primary" align="center">
                    <tr>
                        <th class="sort asc">N.º Bus</th>
                        <th class="sort asc">Placa</th>
                        <th class="sort asc">Tipo</th>
                        <th class="sort asc">Propietario</th>
                        <th class="sort asc">GPS activo</th>
                        <th class="sort asc">SIM</th>
                        <th class="sort asc">Modelo GPS</th>
                        <th class="sort asc">Estado Bus</th>
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

<script>
getData();

document.getElementById("campo").addEventListener("keyup", function () {
    document.getElementById("pagina").value = 1;
    getData();
});

document.getElementById("num_registros").addEventListener("change", function () {
    document.getElementById("pagina").value = 1;
    getData();
});

function getData() {
    const formData = new FormData();

    formData.append("campo", document.getElementById("campo").value);
    formData.append("registros", document.getElementById("num_registros").value);
    formData.append("pagina", document.getElementById("pagina").value || 1);
    formData.append("orderCol", document.getElementById("orderCol").value);
    formData.append("orderType", document.getElementById("orderType").value);

    fetch("buses/vista/loadBuses.php", {
        method: "POST",
        body: formData
    })
        .then(function (response) {
            if (!response.ok) {
                throw new Error("Error HTTP " + response.status);
            }

            return response.json();
        })
        .then(function (data) {
            document.getElementById("content").innerHTML = data.data;
            document.getElementById("lbl-total").innerHTML =
                "Mostrando " + data.totalFiltro + " de " + data.totalRegistros + " registros";
            document.getElementById("nav-paginacion").innerHTML = data.paginacion;
        })
        .catch(function (error) {
            console.error(error);
            document.getElementById("content").innerHTML =
                '<tr><td colspan="9">No fue posible cargar los buses.</td></tr>';
        });
}

function nextPage(pagina) {
    document.getElementById("pagina").value = pagina;
    getData();
}

const columns = document.getElementsByClassName("sort");

for (let i = 0; i < columns.length; i++) {
    columns[i].addEventListener("click", ordenar);
}

function ordenar(event) {
    const elemento = event.target;

    document.getElementById("orderCol").value = elemento.cellIndex;

    if (elemento.classList.contains("asc")) {
        document.getElementById("orderType").value = "desc";
        elemento.classList.remove("asc");
        elemento.classList.add("desc");
    } else {
        document.getElementById("orderType").value = "asc";
        elemento.classList.remove("desc");
        elemento.classList.add("asc");
    }

    getData();
}
</script>
