<?php
require_once 'tarjetas/modelo/tarjetas.php';

class TarjetasController
{
    private $model;

    public function __CONSTRUCT()
    {
        $this->model = new Tarjetas();
    }

    public function menuTotales()
    {
        require_once 'includes/header_tarjetas.php';
        require_once 'tarjetas/vista/tarjetas_total.php';
        require_once 'includes/footer.php';
    }

    public function menuTarjetas()
    {
        require_once 'includes/header_tarjetas.php';
        require_once 'tarjetas/vista/tarjetas_list.php';
        require_once 'includes/footer.php';
    }

    public function Crud()
    {
        $vte = new Tarjetas();

        if (isset($_REQUEST['idTarjeta'])) {
            $vte = $this->model->Obtener($_REQUEST['idTarjeta']);
        }

        require_once 'includes/header_tarjetas.php';
        require_once 'tarjetas/vista/tarjetas_edit.php';
        require_once 'includes/footer.php';
    }

    public function GenerarTarjetas()
    {
        $vte = new Tarjetas();

        if (isset($_REQUEST['idTarjeta'])) {
            $vte = $this->model->Obtener($_REQUEST['idTarjeta']);
        }

        require_once 'includes/header_tarjetas.php';
        require_once 'tarjetas/vista/tarjetas_generar.php';
        require_once 'includes/footer.php';
    }

    public function Crud2()
    {
        $vte = new Tarjetas();

        if (isset($_REQUEST['idTarjeta'])) {
            $vte = $this->model->Obtener($_REQUEST['idTarjeta']);
        }

        require_once 'includes/header_roles.php';
        require_once 'tarjetas/vista/tarjetas_ver.php';
        require_once 'includes/footer.php';
    }

    public function CrudRepetido()
    {
        $vte = new Tarjetas();

        if (isset($_REQUEST['idTarjeta'])) {
            $vte = $this->model->Obtener($_REQUEST['idTarjeta']);
        }

        require_once 'includes/header_roles.php';
        require_once 'tarjetas/vista/tarjetas_editRepetido.php';
        require_once 'includes/footer.php';
    }

    public function ValidarDuplicado()
    {
        $fecha = $_GET['fecha'] ?? '';
        $hora = $_GET['hora'] ?? '';
        $idVariante = $_GET['idVariante'] ?? '';

        header('Content-Type: application/json; charset=utf-8');

        if ($fecha === '' || $hora === '' || $idVariante === '') {
            echo json_encode(['existe' => false, 'error' => 'Datos incompletos']);
            exit;
        }

        $existe = $this->model->ExisteTarjeta($fecha, $hora, $idVariante);

        echo json_encode(['existe' => $existe]);
        exit;
    }

    /* Alias por compatibilidad con formularios antiguos que apuntaban a Registrar */
    public function Registrar()
    {
        $this->Guardar();
    }

    public function Guardar()
    {
        header('Content-Type: application/json; charset=utf-8');

        try {
            $vte = new Tarjetas();

            $vte->idTarjeta = $_REQUEST['idTarjeta'] ?? '';
            $vte->fechaSalida = $_REQUEST['fechaSalida'] ?? '';
            $vte->horaTarjeta = $_REQUEST['horaTarjeta'] ?? '';
            $vte->horaFin = null;
            $vte->idBus = $_REQUEST['idBus'] ?? '';
            $vte->idVariante = $_REQUEST['idVariante'] ?? '';
            $vte->idPersona = $_REQUEST['idPersona'] ?? '';
            $vte->frecuenciaTarjeta = $_REQUEST['frecuenciaTarjeta'] ?? 0;
            $vte->busDelantero = $_REQUEST['busDelantero'] ?? 0;
            $vte->busTrasero = $_REQUEST['busTrasero'] ?? 0;

            if (
                $vte->fechaSalida === '' ||
                $vte->horaTarjeta === '' ||
                $vte->idBus === '' ||
                $vte->idVariante === '' ||
                $vte->idPersona === ''
            ) {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => 'Faltan datos obligatorios para generar la tarjeta.'
                ]);
                exit;
            }

            if ($vte->idTarjeta !== '') {
                $resultado = $this->model->ActualizarTarjeta($vte);

                if (is_array($resultado) && !empty($resultado['error'])) {
                    http_response_code(500);
                    echo json_encode([
                        'success' => false,
                        'message' => $resultado['mensaje']
                    ]);
                    exit;
                }

                echo json_encode([
                    'success' => true,
                    'message' => 'Tarjeta actualizada correctamente.',
                    'idTarjeta' => $vte->idTarjeta
                ]);
                exit;
            }

            if ($this->model->ExisteTarjeta(
                $vte->fechaSalida,
                $vte->horaTarjeta,
                $vte->idBus,
                $vte->idVariante
            )) {
                http_response_code(409);
                echo json_encode([
                    'success' => false,
                    'duplicado' => true,
                    'message' => 'Ya existe una tarjeta registrada con esa fecha, hora, bus y variante.'
                ]);
                exit;
            }

            $resultado = $this->model->Registrar($vte);

            if (is_array($resultado) && !empty($resultado['error'])) {
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'message' => $resultado['mensaje']
                ]);
                exit;
            }

            echo json_encode([
                'success' => true,
                'message' => 'Tarjeta generada correctamente.',
                'idTarjeta' => $resultado
            ]);
            exit;

        } catch (Throwable $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
            exit;
        }
    }

    public function Eliminar()
    {
        $this->model->Eliminar($_REQUEST['idTarjeta']);
        header('Location: ?c=tarjetas&a=GenerarTarjetas&delete=1');
        exit;
    }

    public function ObtenerUltimaFrecuencia1()
    {
        // Método antiguo mantenido por compatibilidad.
    }

    public function ObtenerUltimaFrecuencia()
    {
        $fechaSalida = $_POST['fechaSalida'] ?? '';
        $idVariante  = $_POST['idVariante'] ?? '';

        header('Content-Type: application/json; charset=utf-8');

        if ($fechaSalida === '' || $idVariante === '') {
            echo json_encode([
                "frecuenciaTarjeta" => -1,
                "horaTarjeta" => null
            ]);
            exit;
        }

        echo $this->model->ObtenerUltimaFrecuencia($fechaSalida, $idVariante);
        exit;
    }

    public function VerAjax()
    {
        $idTarjeta = $_GET['idTarjeta'] ?? 0;

        $data = $this->model->ObtenerPorId($idTarjeta);

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        exit;
    }

    public function VerAjaxDetalleTarjeta()
    {
        $idTarjeta = $_GET['idTarjeta'] ?? 0;

        $tarjeta = $this->model->ObtenerPorId($idTarjeta);
        $detalle = $this->model->ObtenerDetalleTarjeta($idTarjeta);

        if (!$tarjeta) {
            $tarjeta = [];
        }

        $tarjeta['detalle'] = $detalle;

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($tarjeta);
        exit;
    }

    public function FiltrarPorFecha()
    {
        $fecha = $_GET['fecha'] ?? date('Y-m-d');

        $data = $this->model->ListarTarjetasPorFecha($fecha);

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        exit;
    }
}
?>