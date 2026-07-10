<head>
	<script src="gps/js/ajaxGps.js"></script>
</head>

<div class="container-fluid">
	<h2 align="center">Dispositivos GPS</h2>

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
			<a href="javascript:reportePDF1();" data-toggle="tooltip" title="descargar dispositivos">
				<img src="img/pdf.png" width="50px" height="50px">
				<p align="center">Descargar</p>
			</a>
		</div>

		<div class="col-auto h5">
			<a href="javascript:reporteExcel();" data-toggle="tooltip" title="descargar dispositivos">
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
		<div class="col-md-12">
			<table class="table table-condensed table-striped table-bordered table-hover">
				<thead class="bg-primary" align="center">
					<th class="sort asc" align="center">IMEI</th>
					<th class="sort asc h4">SIM Card</th>
					<th class="sort asc h4">Marca</th>
					<th class="sort asc h4">Modelo</th>
					<th class="sort asc h4">Descripción</th>
					<th class="h4">Acciones</th>
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

		formaData.append("campo", input);
		formaData.append("registros", num_registros);
		formaData.append("pagina", pagina);
		formaData.append("orderCol", orderCol);
		formaData.append("orderType", orderType);

		fetch(url, {
			method: "POST",
			body: formaData
		})
			.then(response => response.json())
			.then(data => {
				content.innerHTML = data.data;
				document.getElementById("lbl-total").innerHTML =
					"Mostrando " + data.totalFiltro + " de " + data.totalRegistros + " registros";
				document.getElementById("nav-paginacion").innerHTML = data.paginacion;
			})
			.catch(err => console.log(err));
	}

	function nextPage(pagina) {
		document.getElementById("pagina").value = pagina;
		getData();
	}

	let columns = document.getElementsByClassName("sort");
	let tamanio = columns.length;

	for (let i = 0; i < tamanio; i++) {
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>