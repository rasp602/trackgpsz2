<?php
error_reporting(E_ERROR | E_PARSE);

$numeroBus = isset($vte->numeroBus) ? $vte->numeroBus : '';
$placaBus = isset($vte->placaBus) ? $vte->placaBus : '';
$tipoBus = isset($vte->tipoBus) && $vte->tipoBus !== '' ? $vte->tipoBus : 'MICRO';
$idPersona = isset($vte->idPersona) ? intval($vte->idPersona) : 0;
?>

<?php include_once 'menu_principal/vista/Menu_Usuarios.php'; ?>

<div class="container-fluid">
    <?php if (isset($_GET['repetido'])): ?>
        <div class="alert alert-warning">El número de bus ya se encuentra registrado.</div>
    <?php endif; ?>

    <?php if (isset($_GET['error']) && $_GET['error'] === 'numero'): ?>
        <div class="alert alert-danger">Debe ingresar el número del bus.</div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-12">
            <h2 class="titulos" style="text-align:center;">Nuevo Bus</h2>

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Datos del Bus</h3>
                </div>

                <form id="form1" action="?c=buses&a=Guardar" method="post">
                    <input type="hidden" id="idBus" name="idBus" value="">
                    <input type="hidden" id="validez" name="validez" value="1">
                    <input type="hidden" id="estadoBus" name="estadoBus" value="1">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="numeroBus">Número de Bus</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="numeroBus"
                                        name="numeroBus"
                                        value="<?php echo htmlspecialchars($numeroBus, ENT_QUOTES, 'UTF-8'); ?>"
                                        maxlength="10"
                                        onkeypress="return numeros(event)"
                                        placeholder="Ingresa el número de bus"
                                        required
                                    >
                                </div>

                                <div class="form-group">
                                    <label for="placaBus">Placa Bus</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="placaBus"
                                        name="placaBus"
                                        value="<?php echo htmlspecialchars($placaBus, ENT_QUOTES, 'UTF-8'); ?>"
                                        maxlength="20"
                                        placeholder="Ingresa la placa del bus"
                                    >
                                </div>

                                <div class="form-group">
                                    <label for="tipoBus">Tipo de Bus</label>
                                    <select name="tipoBus" id="tipoBus" class="form-control" required>
                                        <option value="MICRO" <?php echo $tipoBus === 'MICRO' ? 'selected' : ''; ?>>Micro</option>
                                        <option value="VANS" <?php echo $tipoBus === 'VANS' ? 'selected' : ''; ?>>Vans</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="idPersona">Propietario</label>
                                    <select name="idPersona" id="idPersona" class="form-control">
                                        <option value="0">Empresa</option>
                                        <?php foreach ($this->model->ListarPropietarios() as $propietario): ?>
                                            <option
                                                value="<?php echo intval($propietario->idPersona); ?>"
                                                <?php echo intval($propietario->idPersona) === $idPersona ? 'selected' : ''; ?>
                                            >
                                                <?php
                                                echo htmlspecialchars(
                                                    trim($propietario->nombre1Persona . ' ' . $propietario->apellido1Persona),
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                );
                                                ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card-body">
                                <div class="alert alert-info">
                                    Puedes asignar el GPS inicial ahora o dejarlo sin equipo y asignarlo después desde la edición del bus.
                                </div>

                                <div class="form-group">
                                    <label for="imeiInicial">GPS inicial opcional</label>
                                    <select name="imeiInicial" id="imeiInicial" class="form-control">
                                        <option value="">Sin GPS inicial</option>
                                        <?php foreach ($this->model->ListarGpsDisponibles() as $gps): ?>
                                            <option value="<?php echo htmlspecialchars($gps->imei, ENT_QUOTES, 'UTF-8'); ?>">
                                                <?php
                                                $texto = $gps->imei;
                                                if (!empty($gps->descripcion)) {
                                                    $texto .= ' - ' . $gps->descripcion;
                                                }
                                                if (!empty($gps->modelo)) {
                                                    $texto .= ' (' . $gps->modelo . ')';
                                                }
                                                echo htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
                                                ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="observacionGps">Observación de instalación</label>
                                    <textarea
                                        class="form-control"
                                        id="observacionGps"
                                        name="observacionGps"
                                        rows="3"
                                        maxlength="255"
                                        placeholder="Ejemplo: Equipo instalado al incorporar el bus"
                                    ></textarea>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Registrar Bus</button>
                                    <button
                                        type="button"
                                        class="btn btn-danger"
                                        onclick="location.href='?c=buses&a=menuBuses'"
                                    >
                                        Cancelar
                                    </button>
                                </div>
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
    const key = e.keyCode || e.which;
    const tecla = String.fromCharCode(key);
    const permitidos = "0123456789";
    const especiales = [8, 9, 13, 37, 39, 46];

    if (especiales.indexOf(key) !== -1) {
        return true;
    }

    return permitidos.indexOf(tecla) !== -1;
}
</script>
