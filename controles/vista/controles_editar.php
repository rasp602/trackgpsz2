<?php
error_reporting(E_ERROR | E_PARSE);
?>

<script>
window.initMap = function () {
	console.log('Google Maps callback desactivado');
};
</script>

<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css">

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>

<?php include 'bd/config.php'; ?>
<?php include_once 'menu_principal/vista/Menu_Usuarios.php'; ?>

<?php
session_start();

if (isset($_SESSION['usuario'])) {
	$usuario = $_SESSION['usuario'];
	$cliente = $usuario->id_user;
}

if (isset($_GET["repetido"])) {
	echo '<div class="alert alert-warning" role="alert">El Bus que intenta ingresar ya se encuentra registrado...</div>';
}
?>

<style>
	.geo-modal {
		display: none;
		position: fixed;
		z-index: 999999;
		left: 0;
		top: 0;
		width: 100%;
		height: 100%;
		background: rgba(0, 0, 0, 0.65);
	}

	.geo-modal-content {
		background: white;
		width: 95%;
		height: 92%;
		margin: 2% auto;
		border-radius: 8px;
		overflow: hidden;
		display: flex;
		flex-direction: column;
	}

	.geo-modal-header {
		background: #007bff;
		color: white;
		padding: 12px 16px;
		display: flex;
		justify-content: space-between;
		align-items: center;
	}

	.geo-modal-header h3 {
		margin: 0;
		font-size: 18px;
	}

	.geo-modal-header button {
		background: transparent;
		color: white;
		border: none;
		font-size: 30px;
		cursor: pointer;
		line-height: 1;
	}

	.geo-modal-body {
		flex: 1;
		padding: 10px;
	}

	.geo-modal-footer {
		padding: 12px;
		border-top: 1px solid #ddd;
		text-align: right;
		background: #f8f9fa;
	}

	.geo-help {
		background: #e8f4ff;
		border: 1px solid #b6dcff;
		padding: 8px 12px;
		margin-bottom: 10px;
		border-radius: 5px;
		font-size: 13px;
	}

	#mapaGeocerca {
		width: 100%;
		height: calc(100% - 45px);
		border: 1px solid #ddd;
		border-radius: 6px;
	}

	#mapaPreview {
		height: 300px;
		border: 1px solid #ddd;
		border-radius: 8px;
	}

	@media (max-width: 768px) {
		.geo-modal-content {
			width: 100%;
			height: 100%;
			margin: 0;
			border-radius: 0;
		}

		.geo-modal-footer {
			text-align: center;
		}

		.geo-modal-footer .btn {
			margin-bottom: 6px;
		}
	}
</style>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">

			<h2 align="center" class="titulos">Editar Control</h2>

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
									placeholder="-70.3975000">
							</div>

							<div class="form-group">
								<label>Longitud 2</label>
								<input type="text" class="form-control" id="longitud2" name="longitud2"
									value="<?php echo $vte->longitud2; ?>"
									placeholder="-70.3979000">
							</div>

							<div class="form-group">
								<label>Latitud 1</label>
								<input type="text" class="form-control" id="latitud1" name="latitud1"
									value="<?php echo $vte->latitud1; ?>"
									placeholder="-23.6509000">
							</div>

							<div class="form-group">
								<label>Latitud 2</label>
								<input type="text" class="form-control" id="latitud2" name="latitud2"
									value="<?php echo $vte->latitud2; ?>"
									placeholder="-23.6512000">
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
									placeholder="Ingresa la Tolerancia"
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
								<select name="sentido" id="sentido" class="form-control input-md">
									<?php
									$sql_sentido = "SELECT DISTINCT sentido FROM controles";
									$result_sentido = $conn->query($sql_sentido);

									while ($row = $result_sentido->fetch_assoc()) {
										$selected = ($row['sentido'] == $vte->sentido) ? 'selected' : '';
										echo "<option value='{$row['sentido']}' $selected>{$row['sentido']}</option>";
									}
									?>
								</select>
							</div>

							<div class="form-group">
								<label>Mapa de referencia</label>
								<div id="mapaPreview"></div>
							</div>

							<div class="form-group">
								<button type="button" class="btn btn-info" onclick="abrirMapaGeocercaManual(); return false;">
									Configurar Geocerca
								</button>
							</div>

							<div class="form-group">
								<button type="submit" class="btn btn-primary">Actualizar</button>

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

<div id="modalGeocercaManual" class="geo-modal">
	<div class="geo-modal-content">
		<div class="geo-modal-header">
			<h3>
				Configurar Geocerca:
				<strong><?php echo $vte->nombreControl; ?></strong>
			</h3>

			<button type="button" onclick="cerrarMapaGeocercaManual()">×</button>
		</div>

		<div class="geo-modal-body">
			<div class="geo-help">
				Dibuja el polígono del punto de control. Debe tener mínimo 3 puntos.
			</div>

			<div id="mapaGeocerca"></div>
		</div>

		<div class="geo-modal-footer">
			<button type="button" class="btn btn-success" onclick="guardarGeocerca()">
				Guardar Geocerca
			</button>

			<button type="button" class="btn btn-warning" onclick="limpiarGeocerca()">
				Limpiar
			</button>

			<button type="button" class="btn btn-danger" onclick="cerrarMapaGeocercaManual()">
				Cerrar
			</button>
		</div>
	</div>
</div>

<script>
let mapaPreview = null;
let mapaGeocerca = null;
let drawnItems = null;
let drawControl = null;
let poligonoActual = null;
let previewPolygon = null;

document.addEventListener('DOMContentLoaded', function () {
	iniciarMapaPreview();
});

function abrirMapaGeocercaManual() {
	const idControlActual = obtenerIdControl();

	if (!idControlActual || idControlActual <= 0) {
		alert('No se encontró idControl. Este control debe estar guardado.');
		return;
	}

	const modal = document.getElementById('modalGeocercaManual');

	if (!modal) {
		alert('No existe el modal modalGeocercaManual en la vista.');
		return;
	}

	modal.style.display = 'block';

	setTimeout(function () {
		if (!mapaGeocerca) {
			iniciarMapaGeocerca();
		}

		if (mapaGeocerca) {
			mapaGeocerca.invalidateSize();
			cargarGeocercaExistente();
		}
	}, 400);
}

function cerrarMapaGeocercaManual() {
	const modal = document.getElementById('modalGeocercaManual');

	if (modal) {
		modal.style.display = 'none';
	}

	if (mapaPreview) {
		mapaPreview.invalidateSize();
	}
}

function iniciarMapaPreview() {
	if (typeof L === 'undefined') {
		console.error('Leaflet no cargó');
		return;
	}

	if (mapaPreview) {
		return;
	}

	const centro = obtenerCentroMapaDesdeCampos();

	mapaPreview = L.map('mapaPreview').setView([centro.lat, centro.lng], centro.zoom);

	L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
		maxZoom: 20,
		attribution: '&copy; OpenStreetMap contributors'
	}).addTo(mapaPreview);

	setTimeout(function () {
		mapaPreview.invalidateSize();
	}, 300);

	cargarGeocercaPreview();
}

async function cargarGeocercaPreview() {
	const idControlActual = obtenerIdControl();

	if (!idControlActual || idControlActual <= 0 || !mapaPreview) {
		return;
	}

	try {
		const response = await fetch('?c=controles&a=ObtenerGeocerca&idControl=' + encodeURIComponent(idControlActual));
		const json = await response.json();

		if (previewPolygon) {
			mapaPreview.removeLayer(previewPolygon);
			previewPolygon = null;
		}

		if (!json.success || !json.data || json.data.length === 0) {
			return;
		}

		const puntos = json.data.map(function (p) {
			return [
				parseFloat(p.latitud),
				parseFloat(p.longitud)
			];
		});

		previewPolygon = L.polygon(puntos, {
			color: '#2563eb',
			weight: 4,
			fillOpacity: 0.25
		}).addTo(mapaPreview);

		mapaPreview.fitBounds(previewPolygon.getBounds(), {
			padding: [20, 20]
		});

	} catch (error) {
		console.error('Error cargando preview de geocerca:', error);
	}
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

	const centro = obtenerCentroMapaDesdeCampos();

	mapaGeocerca = L.map('mapaGeocerca').setView([centro.lat, centro.lng], centro.zoom >= 16 ? centro.zoom : 16);

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

	if (!idControlActual || idControlActual <= 0 || !drawnItems) {
		return;
	}

	try {
		const response = await fetch('?c=controles&a=ObtenerGeocerca&idControl=' + encodeURIComponent(idControlActual));
		const json = await response.json();

		drawnItems.clearLayers();
		poligonoActual = null;

		if (!json.success || !json.data || json.data.length === 0) {
			return;
		}

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
			lat: parseFloat(p.lat),
			lng: parseFloat(p.lng)
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

			cerrarMapaGeocercaManual();

			if (mapaPreview) {
				cargarGeocercaPreview();
			}
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

	const latitudes = puntos.map(function (p) { return p.lat; });
	const longitudes = puntos.map(function (p) { return p.lng; });

	document.getElementById('latitud1').value = Math.min.apply(null, latitudes).toFixed(7);
	document.getElementById('latitud2').value = Math.max.apply(null, latitudes).toFixed(7);

	document.getElementById('longitud1').value = Math.min.apply(null, longitudes).toFixed(7);
	document.getElementById('longitud2').value = Math.max.apply(null, longitudes).toFixed(7);
}

function obtenerCentroMapaDesdeCampos() {
	let lat1 = parseFloat(document.getElementById('latitud1').value);
	let lat2 = parseFloat(document.getElementById('latitud2').value);
	let lng1 = parseFloat(document.getElementById('longitud1').value);
	let lng2 = parseFloat(document.getElementById('longitud2').value);

	if (valoresCoordenadasValidos(lat1, lat2, lng1, lng2)) {
		return {
			lat: (lat1 + lat2) / 2,
			lng: (lng1 + lng2) / 2,
			zoom: 16
		};
	}

	return {
		lat: -23.6467,
		lng: -70.3976,
		zoom: 13
	};
}

function valoresCoordenadasValidos(lat1, lat2, lng1, lng2) {
	if (isNaN(lat1) || isNaN(lat2) || isNaN(lng1) || isNaN(lng2)) {
		return false;
	}

	if (lat1 < -90 || lat1 > 90 || lat2 < -90 || lat2 > 90) {
		return false;
	}

	if (lng1 < -180 || lng1 > 180 || lng2 < -180 || lng2 > 180) {
		return false;
	}

	if (Math.abs(lat1) < 1 || Math.abs(lat2) < 1 || Math.abs(lng1) < 1 || Math.abs(lng2) < 1) {
		return false;
	}

	return true;
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

function checkRut(rut) {
	var valor = rut.value.replace('.', '');
	valor = valor.replace('-', '');

	cuerpo = valor.slice(0, -1);
	dv = valor.slice(-1).toUpperCase();

	rut.value = cuerpo + '-' + dv;

	if (cuerpo.length < 7) {
		rut.setCustomValidity("RUT Incompleto");
		return false;
	}

	suma = 0;
	multiplo = 2;

	for (i = 1; i <= cuerpo.length; i++) {
		index = multiplo * valor.charAt(cuerpo.length - i);
		suma = suma + index;

		if (multiplo < 7) {
			multiplo = multiplo + 1;
		} else {
			multiplo = 2;
		}
	}

	dvEsperado = 11 - (suma % 11);

	dv = (dv == 'K') ? 10 : dv;
	dv = (dv == 0) ? 11 : dv;

	if (dvEsperado != dv) {
		rut.setCustomValidity("RUT Inválido");
		return false;
	}

	rut.setCustomValidity('');
}
</script>