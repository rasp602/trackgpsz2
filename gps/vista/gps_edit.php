<?php
error_reporting(E_ERROR | E_PARSE);

$imei = isset($vte->imei) ? $vte->imei : (isset($vte->imeiGps) ? $vte->imeiGps : '');
$simCard = isset($vte->simCard) ? $vte->simCard : (isset($vte->simCardGps) ? $vte->simCardGps : '');
$marca = isset($vte->marca) && $vte->marca != '' ? $vte->marca : 'COBAN';
$modelo = isset($vte->modelo) && $vte->modelo != '' ? $vte->modelo : '403';
$descripcion = isset($vte->descripcion) ? $vte->descripcion : '';
?>

<?php include_once 'menu_principal/vista/Menu_Usuarios.php'; ?>
<?php $cliente = isset($usuario->id_user) ? $usuario->id_user : ''; ?>

<?php if (isset($_GET["repetido"])) echo '<div class="alert alert-warning" role="alert">El IMEI que intenta ingresar ya se encuentra registrado.</div>'; ?>
<?php if (isset($_GET["error"]) && $_GET["error"] == "imei") echo '<div class="alert alert-danger" role="alert">Debe ingresar el IMEI del dispositivo.</div>'; ?>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">

			<h2 align="center" class="titulos">Nuevo Dispositivo GPS</h2>

			<div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">Datos del dispositivo</h3>
				</div>

				<form id="form1" action="?c=gps&a=Guardar" name="form1" method="post" enctype="multipart/form-data">
					<div class="col-md-12">
						<div class="card-body">

							<input type="hidden" class="form-control" id="idGps" name="idGps" value="">

							<div class="form-group">
								<label>IMEI</label>
								<input
									type="text"
									class="form-control"
									id="imei"
									name="imei"
									value="<?php echo htmlspecialchars($imei, ENT_QUOTES, 'UTF-8'); ?>"
									maxlength="30"
									onkeypress="return numeros(event)"
									placeholder="Ingresa el IMEI del dispositivo"
									required
								>
							</div>

							<div class="form-group">
								<label>SIM Card</label>
								<input
									type="text"
									class="form-control"
									id="simCard"
									name="simCard"
									value="<?php echo htmlspecialchars($simCard, ENT_QUOTES, 'UTF-8'); ?>"
									maxlength="30"
									placeholder="Ingresa el número de SIM Card"
								>
							</div>

							<div class="form-group">
								<label>Marca</label>
								<input
									type="text"
									class="form-control"
									id="marca"
									name="marca"
									value="<?php echo htmlspecialchars($marca, ENT_QUOTES, 'UTF-8'); ?>"
									maxlength="50"
									placeholder="Ejemplo: COBAN"
								>
							</div>

							<div class="form-group">
								<label>Modelo</label>
								<input
									type="text"
									class="form-control"
									id="modelo"
									name="modelo"
									value="<?php echo htmlspecialchars($modelo, ENT_QUOTES, 'UTF-8'); ?>"
									maxlength="50"
									placeholder="Ejemplo: 403"
								>
							</div>

							<div class="form-group">
								<label>Descripción</label>
								<input
									type="text"
									class="form-control"
									id="descripcion"
									name="descripcion"
									value="<?php echo htmlspecialchars($descripcion, ENT_QUOTES, 'UTF-8'); ?>"
									maxlength="100"
									placeholder="Ejemplo: Máquina 12 / Bus 12 / GPS principal"
								>
							</div>

							<div class="form-group">
								<button type="submit" class="btn btn-primary">Registrar</button>
								<input
									type="button"
									id="cancelar"
									class="btn btn-danger"
									name="Cancelar"
									value="Cancelar"
									onclick="location.href='?c=gps&a=menuGps'"
								>
							</div>

						</div>
					</div>
				</form>
			</div>

		</div>
	</div>
</div>

<script>
function numeros(e) {
	let key = e.keyCode || e.which;
	let tecla = String.fromCharCode(key).toLowerCase();
	let letras = " 0123456789";
	let especiales = [9, 13, 8, 37, 39, 46];

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
</script>