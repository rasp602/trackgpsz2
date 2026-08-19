<?php
require_once 'gps/modelo/gps.php';

class GpsController
{
    private $model;

    public function __CONSTRUCT()
    {
        $this->model = new Gps();
    }

    public function menuTotales()
    {
        require_once 'includes/header.php';
        require_once 'gps/vista/gps_total.php';
        require_once 'includes/footer.php';
    }

    public function menuGps()
    {
        require_once 'includes/header.php';
        require_once 'gps/vista/gps_list.php';
        require_once 'includes/footer.php';
    }

    public function Crud()
    {
        $vte = new Gps();

        if (isset($_REQUEST['idGps']) && trim($_REQUEST['idGps']) !== '') {
            $vte = $this->model->Obtener(trim($_REQUEST['idGps']));
        }

        require_once 'includes/header.php';
        require_once 'gps/vista/gps_edit.php';
        require_once 'includes/footer.php';
    }

    public function Crud1()
    {
        $vte = new Gps();

        if (isset($_REQUEST['idGps']) && trim($_REQUEST['idGps']) !== '') {
            $vte = $this->model->Obtener(trim($_REQUEST['idGps']));
        }

        require_once 'includes/header.php';
        require_once 'gps/vista/gps_editar.php';
        require_once 'includes/footer.php';
    }

    public function Crud2()
    {
        $vte = new Gps();

        if (isset($_REQUEST['idGps']) && trim($_REQUEST['idGps']) !== '') {
            $vte = $this->model->Obtener(trim($_REQUEST['idGps']));
        }

        require_once 'includes/header.php';
        require_once 'gps/vista/gps_ver.php';
        require_once 'includes/footer.php';
    }

    public function CrudRepetido()
    {
        $vte = new Gps();

        if (isset($_REQUEST['idGps']) && trim($_REQUEST['idGps']) !== '') {
            $vte = $this->model->Obtener(trim($_REQUEST['idGps']));
        }

        require_once 'includes/header.php';
        require_once 'gps/vista/gps_editRepetido.php';
        require_once 'includes/footer.php';
    }

    public function Guardar()
    {
        $vte = new Gps();

        $vte->idGps = isset($_REQUEST['idGps'])
            ? trim($_REQUEST['idGps'])
            : '';

        $vte->imei = isset($_REQUEST['imei'])
            ? trim($_REQUEST['imei'])
            : (isset($_REQUEST['imeiGps']) ? trim($_REQUEST['imeiGps']) : '');

        $vte->imeiGps = $vte->imei;

        $vte->simCard = isset($_REQUEST['simCard'])
            ? trim($_REQUEST['simCard'])
            : (isset($_REQUEST['simCardGps']) ? trim($_REQUEST['simCardGps']) : '');

        $vte->simCardGps = $vte->simCard;

        $vte->marca = isset($_REQUEST['marca']) && trim($_REQUEST['marca']) !== ''
            ? trim($_REQUEST['marca'])
            : 'COBAN';

        $vte->modelo = isset($_REQUEST['modelo']) && trim($_REQUEST['modelo']) !== ''
            ? trim($_REQUEST['modelo'])
            : '403';

        $vte->descripcion = isset($_REQUEST['descripcion'])
            ? trim($_REQUEST['descripcion'])
            : '';

        if ($vte->imei === '') {
            header('Location: ?c=gps&a=Crud&error=imei');
            exit;
        }

        if (!preg_match('/^[0-9]{10,30}$/', $vte->imei)) {
            header('Location: ?c=gps&a=Crud&error=imei');
            exit;
        }

        if ($vte->idGps !== '') {
            if ($vte->idGps !== $vte->imei) {
                $consultaRepetido = $this->model->ObtenerNumeroGps($vte->imei);

                if ($consultaRepetido) {
                    header(
                        'Location: ?c=gps&a=Crud1&idGps=' .
                        urlencode($vte->idGps) .
                        '&repetido=1'
                    );
                    exit;
                }
            }

            $this->model->ActualizarGps($vte);

            header('Location: ?c=gps&a=menuGps&update=1');
            exit;
        }

        $consultaRepetido = $this->model->ObtenerNumeroGps($vte->imei);

        if ($consultaRepetido) {
            header('Location: ?c=gps&a=Crud&repetido=1');
            exit;
        }

        $this->model->Registrar($vte);

        header('Location: ?c=gps&a=menuGps&success=1');
        exit;
    }

    public function Eliminar()
    {
        if (isset($_REQUEST['idGps']) && trim($_REQUEST['idGps']) !== '') {
            /*
             * Solo elimina el dispositivo de la tabla dispositivos.
             * NO elimina el historial de la tabla registro.
             */
            $this->model->Eliminar(trim($_REQUEST['idGps']));
        }

        header('Location: ?c=gps&a=menuGps&delete=1');
        exit;
    }
}
?>