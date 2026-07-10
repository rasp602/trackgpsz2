<?php
require_once 'buses/modelo/buses.php';

class BusesController
{
    private $model;

    public function __CONSTRUCT()
    {
        $this->model = new Buses();
    }

    public function menuTotales()
    {
        require_once 'includes/header_buses.php';
        require_once 'buses/vista/buses_total.php';
        require_once 'includes/footer.php';
    }

    public function menuBuses()
    {
        require_once 'includes/header_buses.php';
        require_once 'buses/vista/buses_list.php';
        require_once 'includes/footer.php';
    }

    public function visorOnline()
    {
        require_once 'includes/header_visorOnline.php';
        require_once 'buses/vista/buses_visorOnline.php';
        require_once 'includes/footer.php';
    }

    public function Crud()
    {
        $vte = new Buses();

        if (isset($_REQUEST['idBus']) && intval($_REQUEST['idBus']) > 0) {
            $vte = $this->model->Obtener(intval($_REQUEST['idBus']));
        }

        require_once 'includes/header_buses.php';
        require_once 'buses/vista/buses_edit.php';
        require_once 'includes/footer.php';
    }

    public function Crud1()
    {
        $idBus = isset($_REQUEST['idBus']) ? intval($_REQUEST['idBus']) : 0;

        if ($idBus <= 0) {
            header('Location: ?c=buses&a=menuBuses&error=bus');
            exit;
        }

        $vte = $this->model->Obtener($idBus);

        if (!$vte) {
            header('Location: ?c=buses&a=menuBuses&error=no_encontrado');
            exit;
        }

        require_once 'includes/header_buses.php';
        require_once 'buses/vista/buses_editar.php';
        require_once 'includes/footer.php';
    }

    public function Crud2()
    {
        $vte = new Buses();

        if (isset($_REQUEST['idBus']) && intval($_REQUEST['idBus']) > 0) {
            $vte = $this->model->Obtener(intval($_REQUEST['idBus']));
        }

        require_once 'includes/header_buses.php';
        require_once 'buses/vista/buses_ver.php';
        require_once 'includes/footer.php';
    }

    public function CrudRepetido()
    {
        $vte = new Buses();

        if (isset($_REQUEST['idBus']) && intval($_REQUEST['idBus']) > 0) {
            $vte = $this->model->Obtener(intval($_REQUEST['idBus']));
        }

        require_once 'includes/header_buses.php';
        require_once 'buses/vista/buses_editRepetido.php';
        require_once 'includes/footer.php';
    }

    public function Guardar()
    {
        $vte = new Buses();

        $vte->idBus = isset($_POST['idBus']) ? intval($_POST['idBus']) : 0;
        $vte->numeroBus = isset($_POST['numeroBus']) ? trim($_POST['numeroBus']) : '';
        $vte->placaBus = isset($_POST['placaBus']) ? strtoupper(trim($_POST['placaBus'])) : '';
        $vte->tipoBus = isset($_POST['tipoBus']) ? trim($_POST['tipoBus']) : 'MICRO';
        $vte->idPersona = isset($_POST['idPersona']) ? intval($_POST['idPersona']) : 0;
        $vte->estadoBus = isset($_POST['estadoBus']) ? intval($_POST['estadoBus']) : 1;
        $vte->validez = isset($_POST['validez']) ? intval($_POST['validez']) : 1;
        $vte->idGrupo = 1;

        if ($vte->numeroBus === '') {
            $url = $vte->idBus > 0
                ? '?c=buses&a=Crud1&idBus=' . $vte->idBus . '&error=numero'
                : '?c=buses&a=Crud&error=numero';
            header('Location: ' . $url);
            exit;
        }

        $repetido = $this->model->ObtenerNumeroBus($vte->numeroBus, $vte->idBus);

        if ($repetido) {
            $url = $vte->idBus > 0
                ? '?c=buses&a=Crud1&idBus=' . $vte->idBus . '&repetido=1'
                : '?c=buses&a=Crud&repetido=1';
            header('Location: ' . $url);
            exit;
        }

        if ($vte->idBus > 0) {
            $this->model->ActualizarBus($vte);
            header('Location: ?c=buses&a=Crud1&idBus=' . $vte->idBus . '&update=1');
            exit;
        }

        $idBusNuevo = $this->model->Registrar($vte);

        $imeiInicial = isset($_POST['imeiInicial']) ? trim($_POST['imeiInicial']) : '';
        if ($imeiInicial !== '') {
            $usuarioRegistro = $this->obtenerUsuarioRegistro();
            $observacion = isset($_POST['observacionGps']) ? trim($_POST['observacionGps']) : '';
            $this->model->AsignarGps(
                $idBusNuevo,
                $imeiInicial,
                date('Y-m-d H:i:s'),
                'INSTALACIÓN INICIAL',
                $observacion,
                $usuarioRegistro
            );
        }

        header('Location: ?c=buses&a=Crud1&idBus=' . $idBusNuevo . '&success=1');
        exit;
    }

    public function AsignarGps()
    {
        $idBus = isset($_POST['idBus']) ? intval($_POST['idBus']) : 0;
        $imei = isset($_POST['imei']) ? trim($_POST['imei']) : '';
        $fechaInicio = isset($_POST['fechaInicio']) && $_POST['fechaInicio'] !== ''
            ? str_replace('T', ' ', trim($_POST['fechaInicio']))
            : date('Y-m-d H:i:s');
        $motivoCambio = isset($_POST['motivoCambio']) ? trim($_POST['motivoCambio']) : 'INSTALACIÓN';
        $observacion = isset($_POST['observacion']) ? trim($_POST['observacion']) : '';
        $usuarioRegistro = $this->obtenerUsuarioRegistro();

        if ($idBus <= 0 || $imei === '') {
            header('Location: ?c=buses&a=Crud1&idBus=' . $idBus . '&gps_error=datos');
            exit;
        }

        try {
            $this->model->AsignarGps(
                $idBus,
                $imei,
                $fechaInicio,
                $motivoCambio,
                $observacion,
                $usuarioRegistro
            );

            header('Location: ?c=buses&a=Crud1&idBus=' . $idBus . '&gps_success=1');
            exit;
        } catch (Exception $e) {
            header('Location: ?c=buses&a=Crud1&idBus=' . $idBus . '&gps_error=' . urlencode($e->getMessage()));
            exit;
        }
    }

    public function RetirarGps()
    {
        $idBusDispositivo = isset($_POST['idBusDispositivo']) ? intval($_POST['idBusDispositivo']) : 0;
        $idBus = isset($_POST['idBus']) ? intval($_POST['idBus']) : 0;
        $fechaFin = isset($_POST['fechaFin']) && $_POST['fechaFin'] !== ''
            ? str_replace('T', ' ', trim($_POST['fechaFin']))
            : date('Y-m-d H:i:s');
        $motivoCambio = isset($_POST['motivoCambio']) ? trim($_POST['motivoCambio']) : 'RETIRO';
        $observacion = isset($_POST['observacion']) ? trim($_POST['observacion']) : '';

        if ($idBusDispositivo <= 0 || $idBus <= 0) {
            header('Location: ?c=buses&a=Crud1&idBus=' . $idBus . '&gps_error=retiro');
            exit;
        }

        try {
            $this->model->RetirarGps(
                $idBusDispositivo,
                $idBus,
                $fechaFin,
                $motivoCambio,
                $observacion
            );

            header('Location: ?c=buses&a=Crud1&idBus=' . $idBus . '&gps_retirado=1');
            exit;
        } catch (Exception $e) {
            header('Location: ?c=buses&a=Crud1&idBus=' . $idBus . '&gps_error=' . urlencode($e->getMessage()));
            exit;
        }
    }

    public function Eliminar()
    {
        $idBus = isset($_REQUEST['idBus']) ? intval($_REQUEST['idBus']) : 0;

        if ($idBus > 0) {
            try {
                $this->model->Eliminar($idBus);
                header('Location: ?c=buses&a=menuBuses&delete=1');
                exit;
            } catch (Exception $e) {
                header('Location: ?c=buses&a=menuBuses&error=' . urlencode($e->getMessage()));
                exit;
            }
        }

        header('Location: ?c=buses&a=menuBuses&error=bus');
        exit;
    }

    private function obtenerUsuarioRegistro()
    {
        if (isset($_SESSION['usuario']) && isset($_SESSION['usuario']->id_user)) {
            return intval($_SESSION['usuario']->id_user);
        }

        if (isset($_SESSION['usuarioInventario']) && isset($_SESSION['usuarioInventario']->id_user)) {
            return intval($_SESSION['usuarioInventario']->id_user);
        }

        return null;
    }
}
?>
