<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

<div class="container-fluid">
	<?php include_once 'menu_principal/vista/Menu_Usuarios.php'; ?>

	<?php if (isset($_GET["success"])) echo '<div class="alert alert-info" role="alert">Dispositivo registrado correctamente.</div>'; ?>

	<?php if (isset($_GET["delete"])) echo '<div class="alert alert-warning" role="alert">Dispositivo eliminado correctamente.</div>'; ?>

	<?php if (isset($_GET["update"])) echo '<div class="alert alert-warning" role="alert">Dispositivo actualizado correctamente.</div>'; ?>

	<?php if (isset($_GET["error"]) && $_GET["error"] == "imei") echo '<div class="alert alert-danger" role="alert">Debe ingresar el IMEI del dispositivo.</div>'; ?>

	<div class="row">
		<input type="hidden" name="id_user" id="id_user" value="<?php echo isset($usuario->id_user) ? $usuario->id_user : ''; ?>">
	</div>

	<?php include_once 'gps/vista/gps.php'; ?>
</div>