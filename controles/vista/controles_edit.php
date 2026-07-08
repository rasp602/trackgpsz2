<?php
error_reporting(E_ERROR | E_PARSE);
?>

<script>
window.initMap = function () {
	console.log('Google Maps callback cargado');
};
</script>

<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css">

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>

<?php include_once 'menu_principal/vista/Menu_Usuarios.php'; ?>

<?php
session_start();

if (isset($_SESSION['usuario'])) {
	$usuario = $_SESSION['usuario'];
	$cliente = $usuario->id_user;
}
?>

<?php
if (isset($_GET["repetido"])) {
	echo '<div class="alert alert-warning" role="alert">El Bus que intenta ingresar ya se encuentra registrado...</div>';
}
?>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">

			<h2 align="center" class="titulos">Nuevo Control</h2>

			<div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">Datos del control</h3>
				</div>

				<form id="form1" action="?c=controles&a=Guardar" name="form1" method="post" enctype="multipart/form-data">

					<div class="col-md-6">
						<div class="card-body">

							<div class="form-group">
								<input type="hidden" class="form-control" id="idControl" name="idControl" value="<?php echo $vte->idControl; ?>">

								<label>Nombre control</label>
								<input type="text" class="form-control" id="nombreControl" name="nombreControl"
									value="<?php echo $vte->nombreControl; ?>" maxlength="50"
									placeholder="Ingresa el nombre del control">
							</div>

							<div class="form-group">
								<label>Abreviación</label>
								<input type="text" class="form-control" id="abreviacionControl" name="abreviacionControl"
									value="<?php echo $vte->abreviacionControl; ?>"
									placeholder="Ingresa la Abreviación">
							</div>

							<div class="form-group">
								<label>Longitud 1</label>
								<input type="text" class="form-control" id="longitud1" name="longitud1"
									value="<?php echo $vte->longitud1; ?>"
									placeholder="Longitud 1">
							</div>

							<div class="form-group">
								<label>Longitud 2</label>
								<input type="text" class="form-control" id="longitud2" name="longitud2"
									value="<?php echo $vte->longitud2; ?>"
									placeholder="Longitud 2">
							</div>

							<div class="form-group">
								<label>Latitud 1</label>
								<input type="text" class="form-control" id="latitud1" name="latitud1"
									value="<?php echo $vte->latitud1; ?>"
									placeholder="Latitud 1">
							</div>

							<div class="form-group">
								<label>Latitud 2</label>
								<input type="text" class="form-control" id="latitud2" name="latitud2"
									value="<?php echo $vte->latitud2; ?>"
									placeholder="Latitud 2">
							</div>

							<div class="form-group">
								<label>Ángulo de Entrada</label>
								<input type="text" class="form-control" id="anguloEntrada" name="anguloEntrada"
									value="<?php echo $vte->anguloEntrada; ?>"
									placeholder="Ingresa el ángulo de entrada"
									onkeypress="return numeros(event)">
							</div>

							<div class="form-group">
								<label>Tolerancia Entrada</label>
								<input type="text" class="form-control" id="toleraciaEntrada" name="toleraciaEntrada"
									value="<?php echo $vte->toleraciaEntrada; ?>"
									placeholder="Ingresa la tolerancia"
									onkeypress="return numeros(event)">
							</div>

							<input type="hidden" class="form-control" id="estadoControl" name="estadoControl" value="A">

						</div>
					</div>

					<div class="col-md-6">
						<div class="card-body">

							<div class="form-group">
								<label>Tipo de Control:</label>
								<select name="tipoControl" id="tipoControl" class="form-control">
									<option value="NORMAL" <?php echo ($vte->tipoControl == 'NORMAL') ? 'selected' : ''; ?>>Normal</option>
									<option value="TERMINAL" <?php echo ($vte->tipoControl == 'TERMINAL') ? 'selected' : ''; ?>>Terminal</option>
								</select>
							</div>

							<div class="form-group">
								<label>Velocidad max</label>
								<input type="text" class="form-control" id="velMax" name="velMax"
									value="<?php echo $vte->velMax; ?>">
							</div>

							<div class="form-group">
								<label>Visible:</label>
								<select name="visible" id="visible" class="form-control">
									<option value="0" <?php echo ($vte->visible == '0') ? 'selected' : ''; ?>>Sí</option>
									<option value="1" <?php echo ($vte->visible == '1') ? 'selected' : ''; ?>>No</option>
								</select>
							</div>

							<div class="form-group">
								<label>Sentido:</label>
								<select name="sentido" id="sentido" class="form-control">
									<option value="I" <?php echo ($vte->sentido == 'I') ? 'selected' : ''; ?>>IDA</option>
									<option value="R" <?php echo ($vte->sentido == 'R') ? 'selected' : ''; ?>>REGRESO</option>
								</select>
							</div>

							<div class="form-group">
								<button type="button" class="btn btn-info" onclick="abrirMapaGeocerca()">
									Configurar Geocerca
								</button>
							</div>

							<div class="form-group">
								<button type="submit" class="btn btn-primary">Registrar</button>

								<input type="button" id="cancelar" class="btn btn-danger" name="Cancelar"
									value="Cancelar"
									onclick="location.href='?c=menu_principal&a=menu_usuarios'">
							</div>

						</div>
					</div>

				</form>
			</div>

		</div>
	</div>
</div>

<div class="modal fade" id="modalGeocerca" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-xl" role="document" style="max-width:95%;">
		<div class="modal-content">

			<div class="modal-header bg-primary text-white">
				<h5 class="modal-title">Configurar Geocerca del Control</h5>

				<button type="button" class="close text-white" data-dismiss="modal">
					<span>&times;</span>
				</button>
			</div>

			<div class="modal-body">
				<div class="alert alert-info">
					Dibuja el polígono del punto de control. Debe tener mínimo 3 puntos.
				</div>

				<div id="mapaGeocerca" style="width:100%; height:70vh; border:1px solid #ddd;"></div>

				<div style="margin-top:15px;">
					<button type="button" class="btn btn-success" onclick="guardarGeocerca()">
						Guardar Geocerca
					</button>

					<button type="button" class="btn btn-warning" onclick="limpiarGeocerca()">
						Limpiar
					</button>

					<button type="button" class="btn btn-secondary" data-dismiss="modal">
						Cerrar
					</button>
				</div>
			</div>

		</div>
	</div>
</div>

<script>
let mapaGeocerca = null;
let drawnItems = null;
let drawControl = null;
let poligonoActual = null;

function abrirMapaGeocerca() {
	const idControlActual = obtenerIdControl();

	if (!idControlActual || idControlActual <= 0) {
		alert('Primero debe guardar el control antes de configurar la geocerca.');
		return;
	}

	$('#modalGeocerca').modal('show');

	setTimeout(function () {
		if (!mapaGeocerca) {
			iniciarMapaGeocerca();
		}

		mapaGeocerca.invalidateSize();
		cargarGeocercaExistente();
	}, 500);
}

function iniciarMapaGeocerca() {
	if (typeof L === 'undefined') {
		alert('Leaflet no se cargó correctamente.');
		return;
	}

	if (!L.Control || !L.Control.Draw) {
		alert('Leaflet Draw no se cargó correctamente. Revisa que leaflet.draw.js esté cargando por HTTPS.');
		return;
	}

	mapaGeocerca = L.map('mapaGeocerca').setView([-23.6467, -70.3976], 14);

	L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		maxZoom: 20,
		attribution: '&copy; OpenStreetMap contributors'
	}).addTo(mapaGeocerca);

	drawnItems = new L.FeatureGroup();
	mapaGeocerca.addLayer(drawnItems);

	drawControl = new L.Control.Draw({
		draw: {
			polygon: {
				allowIntersection: false,
				showArea: true,
				shapeOptions: {
					color: '#2563eb',
					weight: 4,
					fillOpacity: 0.25
				}
			},
			rectangle: {
				shapeOptions: {
					color: '#16a34a',
					weight: 4,
					fillOpacity: 0.25
				}
			},
			polyline: false,
			circle: false,
			circlemarker: false,
			marker: false
		},
		edit: {
			featureGroup: drawnItems,
			remove: true
		}
	});

	mapaGeocerca.addControl(drawControl);

	mapaGeocerca.on(L.Draw.Event.CREATED, function (event) {
		drawnItems.clearLayers();

		poligonoActual = event.layer;
		drawnItems.addLayer(poligonoActual);

		actualizarCamposCoordenadasDesdePoligono();
		centrarPoligono();
	});

	mapaGeocerca.on(L.Draw.Event.EDITED, function () {
		const layers = drawnItems.getLayers();
		poligonoActual = layers.length > 0 ? layers[0] : null;

		actualizarCamposCoordenadasDesdePoligono();
	});

	mapaGeocerca.on(L.Draw.Event.DELETED, function () {
		poligonoActual = null;
	});
}

async function cargarGeocercaExistente() {
	const idControlActual = obtenerIdControl();

	if (!idControlActual || idControlActual <= 0) {
		return;
	}

	try {
		const response = await fetch('?c=controles&a=ObtenerGeocerca&idControl=' + encodeURIComponent(idControlActual));
		const json = await response.json();

		if (!json.success || !json.data || json.data.length === 0) {
			drawnItems.clearLayers();
			poligonoActual = null;
			return;
		}

		drawnItems.clearLayers();

		const puntos = json.data.map(function (p) {
			return [
				parseFloat(p.latitud),
				parseFloat(p.longitud)
			];
		});

		poligonoActual = L.polygon(puntos, {
			color: '#2563eb',
			weight: 4,
			fillOpacity: 0.25
		});

		drawnItems.addLayer(poligonoActual);
		actualizarCamposCoordenadasDesdePoligono();
		centrarPoligono();

	} catch (error) {
		console.error('Error cargando geocerca:', error);
		alert('Error cargando geocerca existente');
	}
}

function obtenerPuntosPoligono() {
	if (!poligonoActual) {
		return [];
	}

	let latLngs = poligonoActual.getLatLngs();

	if (Array.isArray(latLngs[0])) {
		latLngs = latLngs[0];
	}

	return latLngs.map(function (p) {
		return {
			lat: p.lat,
			lng: p.lng
		};
	});
}

async function guardarGeocerca() {
	const idControlActual = obtenerIdControl();

	if (!idControlActual || idControlActual <= 0) {
		alert('Primero debe guardar el control antes de configurar la geocerca.');
		return;
	}

	const puntos = obtenerPuntosPoligono();

	if (puntos.length < 3) {
		alert('Debe dibujar un polígono con al menos 3 puntos.');
		return;
	}

	try {
		const response = await fetch('?c=controles&a=GuardarGeocerca', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json'
			},
			body: JSON.stringify({
				idControl: idControlActual,
				puntos: puntos
			})
		});

		const json = await response.json();

		if (json.success) {
			alert(json.message || 'Geocerca guardada correctamente');
			$('#modalGeocerca').modal('hide');
		} else {
			alert(json.message || 'No se pudo guardar la geocerca');
		}

	} catch (error) {
		console.error('Error guardando geocerca:', error);
		alert('Error guardando geocerca');
	}
}

function limpiarGeocerca() {
	if (!drawnItems) return;

	if (confirm('¿Seguro que desea borrar el polígono actual?')) {
		drawnItems.clearLayers();
		poligonoActual = null;
	}
}

function centrarPoligono() {
	if (!poligonoActual || !mapaGeocerca) return;

	const bounds = poligonoActual.getBounds();

	if (bounds.isValid()) {
		mapaGeocerca.fitBounds(bounds, {
			padding: [30, 30]
		});
	}
}

function actualizarCamposCoordenadasDesdePoligono() {
	const puntos = obtenerPuntosPoligono();

	if (puntos.length === 0) return;

	let latitudes = puntos.map(function (p) { return p.lat; });
	let longitudes = puntos.map(function (p) { return p.lng; });

	document.getElementById('latitud1').value = Math.min.apply(null, latitudes).toFixed(7);
	document.getElementById('latitud2').value = Math.max.apply(null, latitudes).toFixed(7);

	document.getElementById('longitud1').value = Math.min.apply(null, longitudes).toFixed(7);
	document.getElementById('longitud2').value = Math.max.apply(null, longitudes).toFixed(7);
}

function obtenerIdControl() {
	const input = document.getElementById('idControl');

	if (!input) return 0;

	const valor = parseInt(input.value, 10);

	return isNaN(valor) ? 0 : valor;
}

function numeros(e) {
	let key = e.keyCode || e.which;
	let tecla = String.fromCharCode(key).toLowerCase();
	let letras = " 0123456789.-";
	let especiales = [9, 13, 8, 37, 39, 46, 38, 164];

	let tecla_especial = false;

	for (let i in especiales) {
		if (key == especiales[i]) {
			tecla_especial = true;
			break;
		}
	}

	if (letras.indexOf(tecla) == -1 && !tecla_especial) {
		return false;
	}
}

function sololetras(e) {
	let key = e.keyCode || e.which;
	let teclado = String.fromCharCode(key).toLowerCase();
	let letras = "abcdefghijklmnñopqrstuvwxyz ";
	let especiales = [13, 9, 8, 37, 38, 46, 164];

	let teclado_especial = false;

	for (let i in especiales) {
		if (key == especiales[i]) {
			teclado_especial = true;
			break;
		}
	}

	if (letras.indexOf(teclado) == -1 && !teclado_especial) {
		return false;
	}
}
</script>