<script src="buses/js/ajaxBuses.js"></script>

<div class="container-fluid">
    <?php include_once 'menu_principal/vista/Menu_Usuarios.php'; ?>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Bus registrado correctamente.</div>
    <?php endif; ?>

    <?php if (isset($_GET['delete'])): ?>
        <div class="alert alert-warning">Bus eliminado correctamente.</div>
    <?php endif; ?>

    <?php if (isset($_GET['update'])): ?>
        <div class="alert alert-success">Bus actualizado correctamente.</div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8'); ?>
        </div>
    <?php endif; ?>

    <?php include_once 'buses/vista/buses.php'; ?>
</div>
