<?php
error_reporting(E_ERROR | E_PARSE);

$idBus = intval($vte->idBus);
$gpsActivo = $this->model->ObtenerGpsActivo($idBus);
$historialGps = $this->model->HistorialGpsBus($idBus);
$gpsDisponibles = $this->model->ListarGpsDisponibles($idBus);
?>

<?php include_once 'menu_principal/vista/Menu_Usuarios.php'; ?>

<style>
.gps-box {
    border: 1px solid #dbe3ec;
    border-radius: 8px;
    margin-top: 18px;
    overflow: hidden;
}
.gps-box-header {
    background: #f4f7fb;
    border-bottom: 1px solid #dbe3ec;
    padding: 12px 15px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.gps-active-card {
    background: #ecfdf3;
    border: 1px solid #a7f3d0;
    border-radius: 8px;
    padding: 14px;
    margin-bottom: 15px;
}
.gps-none {
    background: #fff7ed;
    border: 1px solid #fed7aa;
    border-radius: 8px;
    padding: 14px;
    margin-bottom: 15px;
}
.gps-history-table td,
.gps-history-table th {
    vertical-align: middle !important;
}
.status-active {
    color: #15803d;
    font-weight: bold;
}
.status-inactive {
    color: #64748b;
    font-weight: bold;
}
</style>

<div class="container-fluid">
    <?php if (isset($_GET['update'])): ?>
        <div class="alert alert-success">Bus actualizado correctamente.</div>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Bus registrado correctamente. Ahora puedes gestionar sus GPS.</div>
    <?php endif; ?>

    <?php if (isset($_GET['gps_success'])): ?>
        <div class="alert alert-success">GPS asignado correctamente. La asignación anterior fue cerrada si existía.</div>
    <?php endif; ?>

    <?php if (isset($_GET['gps_retirado'])): ?>
        <div class="alert alert-info">GPS retirado correctamente.</div>
    <?php endif; ?>

    <?php if (isset($_GET['gps_error'])): ?>
        <div class="alert alert-danger">
            No se pudo completar la operación GPS:
            <?php echo htmlspecialchars($_GET['gps_error'], ENT_QUOTES, 'UTF-8'); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['repetido'])): ?>
        <div class="alert alert-warning">El número de bus ya se encuentra registrado.</div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-12">
            <h2 class="titulos" style="text-align:center;">
                Actualizar Bus N.º <?php echo htmlspecialchars($vte->numeroBus, ENT_QUOTES, 'UTF-8'); ?>
            </h2>

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Datos del Bus</h3>
                </div>

                <form action="?c=buses&a=Guardar" method="post">
                    <input type="hidden" name="idBus" value="<?php echo $idBus; ?>">

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
                                        value="<?php echo htmlspecialchars($vte->numeroBus, ENT_QUOTES, 'UTF-8'); ?>"
                                        maxlength="10"
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
                                        value="<?php echo htmlspecialchars($vte->placaBus, ENT_QUOTES, 'UTF-8'); ?>"
                                        maxlength="20"
                                    >
                                </div>

                                <div class="form-group">
                                    <label for="tipoBus">Tipo de Bus</label>
                                    <select name="tipoBus" id="tipoBus" class="form-control" required>
                                        <option value="MICRO" <?php echo $vte->tipoBus === 'MICRO' ? 'selected' : ''; ?>>Micro</option>
                                        <option value="VANS" <?php echo $vte->tipoBus === 'VANS' ? 'selected' : ''; ?>>Vans</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="idPersona">Propietario</label>
                                    <select name="idPersona" id="idPersona" class="form-control">
                                        <option value="0" <?php echo intval($vte->idPersona) === 0 ? 'selected' : ''; ?>>Empresa</option>

                                        <?php foreach ($this->model->ListarPropietarios() as $propietario): ?>
                                            <option
                                                value="<?php echo intval($propietario->idPersona); ?>"
                                                <?php echo intval($propietario->idPersona) === intval($vte->idPersona) ? 'selected' : ''; ?>
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

                                <div class="form-group">
                                    <label for="estadoBus">Estado</label>
                                    <select name="estadoBus" id="estadoBus" class="form-control">
                                        <option value="1" <?php echo intval($vte->estadoBus) === 1 ? 'selected' : ''; ?>>Activo</option>
                                        <option value="0" <?php echo intval($vte->estadoBus) === 0 ? 'selected' : ''; ?>>Inactivo</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="validez">Validez</label>
                                    <select name="validez" id="validez" class="form-control">
                                        <option value="1" <?php echo intval($vte->validez) === 1 ? 'selected' : ''; ?>>Vigente</option>
                                        <option value="0" <?php echo intval($vte->validez) === 0 ? 'selected' : ''; ?>>No vigente</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Actualizar Bus</button>
                                    <button
                                        type="button"
                                        class="btn btn-danger"
                                        onclick="location.href='?c=buses&a=menuBuses'"
                                    >
                                        Volver
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="gps-box">
                <div class="gps-box-header">
                    <strong>Equipo GPS activo</strong>
                    <span>Bus N.º <?php echo htmlspecialchars($vte->numeroBus, ENT_QUOTES, 'UTF-8'); ?></span>
                </div>

                <div class="card-body">
                    <?php if ($gpsActivo): ?>
                        <div class="gps-active-card">
                            <div class="row">
                                <div class="col-md-8">
                                    <div><strong>IMEI:</strong> <?php echo htmlspecialchars($gpsActivo->imei, ENT_QUOTES, 'UTF-8'); ?></div>
                                    <div><strong>SIM:</strong> <?php echo htmlspecialchars($gpsActivo->simCard ?: 'Sin registrar', ENT_QUOTES, 'UTF-8'); ?></div>
                                    <div><strong>Marca / Modelo:</strong> <?php echo htmlspecialchars(trim($gpsActivo->marca . ' ' . $gpsActivo->modelo), ENT_QUOTES, 'UTF-8'); ?></div>
                                    <div><strong>Descripción:</strong> <?php echo htmlspecialchars($gpsActivo->descripcion ?: 'Sin descripción', ENT_QUOTES, 'UTF-8'); ?></div>
                                    <div><strong>Instalado desde:</strong> <?php echo htmlspecialchars($gpsActivo->fechaInicio, ENT_QUOTES, 'UTF-8'); ?></div>
                                </div>

                                <div class="col-md-4">
                                    <form action="?c=buses&a=RetirarGps" method="post" onsubmit="return confirm('¿Confirma retirar el GPS activo de este bus?');">
                                        <input type="hidden" name="idBus" value="<?php echo $idBus; ?>">
                                        <input type="hidden" name="idBusDispositivo" value="<?php echo intval($gpsActivo->idBusDispositivo); ?>">

                                        <div class="form-group">
                                            <label>Fecha y hora de retiro</label>
                                            <input
                                                type="datetime-local"
                                                class="form-control"
                                                name="fechaFin"
                                                value="<?php echo date('Y-m-d\TH:i'); ?>"
                                                required
                                            >
                                        </div>

                                        <div class="form-group">
                                            <label>Motivo</label>
                                            <select name="motivoCambio" class="form-control">
                                                <option value="RETIRO">Retiro</option>
                                                <option value="EQUIPO DAÑADO">Equipo dañado</option>
                                                <option value="MANTENIMIENTO">Mantenimiento</option>
                                                <option value="REEMPLAZO">Reemplazo</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Observación</label>
                                            <textarea name="observacion" class="form-control" rows="2" maxlength="255"></textarea>
                                        </div>

                                        <button type="submit" class="btn btn-warning">Retirar GPS</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="gps-none">
                            Este bus no posee un GPS activo.
                        </div>
                    <?php endif; ?>

                    <form action="?c=buses&a=AsignarGps" method="post" onsubmit="return confirmarAsignacionGps();">
                        <input type="hidden" name="idBus" value="<?php echo $idBus; ?>">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="imei">Seleccionar GPS</label>
                                    <select name="imei" id="imei" class="form-control" required>
                                        <option value="">Seleccione un equipo</option>

                                        <?php foreach ($gpsDisponibles as $gps): ?>
                                            <?php
                                            $esActivoEsteBus = intval($gps->idBusActivo) === $idBus;
                                            if ($esActivoEsteBus) {
                                                continue;
                                            }

                                            $textoGps = $gps->imei;
                                            if (!empty($gps->descripcion)) {
                                                $textoGps .= ' - ' . $gps->descripcion;
                                            }
                                            if (!empty($gps->modelo)) {
                                                $textoGps .= ' (' . $gps->modelo . ')';
                                            }
                                            ?>
                                            <option value="<?php echo htmlspecialchars($gps->imei, ENT_QUOTES, 'UTF-8'); ?>">
                                                <?php echo htmlspecialchars($textoGps, ENT_QUOTES, 'UTF-8'); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="fechaInicio">Fecha y hora de instalación</label>
                                    <input
                                        type="datetime-local"
                                        class="form-control"
                                        id="fechaInicio"
                                        name="fechaInicio"
                                        value="<?php echo date('Y-m-d\TH:i'); ?>"
                                        required
                                    >
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="motivoCambio">Motivo</label>
                                    <select name="motivoCambio" id="motivoCambio" class="form-control">
                                        <option value="INSTALACIÓN">Instalación</option>
                                        <option value="REEMPLAZO DE EQUIPO">Reemplazo</option>
                                        <option value="EQUIPO DAÑADO">Equipo dañado</option>
                                        <option value="MANTENIMIENTO">Mantenimiento</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="observacion">Observación</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="observacion"
                                        name="observacion"
                                        maxlength="255"
                                        placeholder="Detalle de instalación o cambio"
                                    >
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success">
                            <?php echo $gpsActivo ? 'Reemplazar GPS activo' : 'Asignar GPS'; ?>
                        </button>
                    </form>
                </div>
            </div>

            <div class="gps-box">
                <div class="gps-box-header">
                    <strong>Historial de equipos GPS</strong>
                    <span><?php echo count($historialGps); ?> asignaciones</span>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered gps-history-table" style="margin-bottom:0;">
                        <thead class="bg-primary">
                            <tr>
                                <th>IMEI</th>
                                <th>SIM</th>
                                <th>Marca / Modelo</th>
                                <th>Descripción</th>
                                <th>Inicio</th>
                                <th>Fin</th>
                                <th>Motivo</th>
                                <th>Observación</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($historialGps) > 0): ?>
                                <?php foreach ($historialGps as $asignacion): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($asignacion->imei, ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($asignacion->simCard ?: '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars(trim($asignacion->marca . ' ' . $asignacion->modelo), ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($asignacion->descripcion ?: '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($asignacion->fechaInicio, ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($asignacion->fechaFin ?: '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($asignacion->motivoCambio ?: '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($asignacion->observacion ?: '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td>
                                            <?php if ($asignacion->estado === 'ACTIVO'): ?>
                                                <span class="status-active">ACTIVO</span>
                                            <?php else: ?>
                                                <span class="status-inactive">INACTIVO</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" style="text-align:center;">Este bus todavía no tiene historial de GPS.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmarAsignacionGps() {
    const gpsActivo = <?php echo $gpsActivo ? 'true' : 'false'; ?>;

    if (gpsActivo) {
        return confirm(
            'Este bus ya tiene un GPS activo. Al continuar, el equipo anterior quedará INACTIVO y se registrará el nuevo GPS. ¿Desea continuar?'
        );
    }

    return confirm('¿Confirma asignar este GPS al bus?');
}
</script>
