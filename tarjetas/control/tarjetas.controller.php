<?php
require_once 'tarjetas/modelo/tarjetas.php';


class TarjetasController{
    
    private $model;
    
    public function __CONSTRUCT(){
        $this->model = new Tarjetas();
    }
    

        public function menuTotales(){
        require_once 'includes/header_tarjetas.php';
        require_once 'tarjetas/vista/tarjetas_total.php';
        require_once 'includes/footer.php';
    }
        public function menuTarjetas(){
        require_once 'includes/header_tarjetas.php';
        require_once 'tarjetas/vista/tarjetas_list.php';
        require_once 'includes/footer.php';
    }

    
    public function Crud(){
        $vte = new Tarjetas();
        
        if(isset($_REQUEST['idTarjeta'])){
            $vte = $this->model->Obtener($_REQUEST['idTarjeta']);
        }
        
        require_once 'includes/header_tarjetas.php';
        require_once 'tarjetas/vista/tarjetas_edit.php';
        require_once 'includes/footer.php';
       
    }

    public function GenerarTarjetas(){
        $vte = new Tarjetas();
        
        if(isset($_REQUEST['idTarjeta'])){
            $vte = $this->model->Obtener($_REQUEST['idTarjeta']);
        }
        require_once 'includes/header_tarjetas.php';
        require_once 'tarjetas/vista/tarjetas_generar.php';
        require_once 'includes/footer.php';
    }

        public function Crud2(){
        $vte = new Tarjetas();
        
        if(isset($_REQUEST['idTarjeta'])){
            $vte = $this->model->Obtener($_REQUEST['idTarjeta']);
        }
        
        require_once 'includes/header_roles.php';
        require_once 'tarjetas/vista/tarjetas_ver.php';
        require_once 'includes/footer.php';
    }


    public function CrudRepetido(){
        $vte = new Tarjetas();
        
        if(isset($_REQUEST['idTarjeta'])){
            $vte = $this->model->Obtener($_REQUEST['idTarjeta']);
        }

        require_once 'includes/header_roles.php';
        require_once 'tarjetas/vista/tarjetas_editRepetido.php';
        require_once 'includes/footer.php';
    }

    public function ValidarDuplicado()
{
    $fecha = $_GET['fecha'];
    $hora = $_GET['hora'];
   // $idBus = $_GET['idBus'];
    $idVariante = $_GET['idVariante'];

    $existe = $this->model->ExisteTarjeta($fecha, $hora,$idVariante);

    header('Content-Type: application/json');
    echo json_encode(['existe' => $existe]);
    exit;
}
    
    
public function Guardar(){

    $vte = new Tarjetas();

    $vte->idTarjeta = $_REQUEST['idTarjeta'];
    $vte->fechaSalida = $_REQUEST['fechaSalida'];
    $vte->horaTarjeta = $_REQUEST['horaTarjeta'];
    $vte->idBus = $_REQUEST['idBus'];
    $vte->idVariante = $_REQUEST['idVariante'];
    $vte->idPersona = $_REQUEST['idPersona'];
    $vte->frecuenciaTarjeta = $_REQUEST['frecuenciaTarjeta'];
    $vte->busDelantero = $_REQUEST['busDelantero'];
    $vte->busTrasero = 0;

    if ($vte->idTarjeta != "") {

        $this->model->ActualizarTarjeta($vte);
        header('Location: ?c=tarjetas&a=menutarjetas&update=1');
        exit;

    } else {

        if ($this->model->ExisteTarjeta(
                $vte->fechaSalida,
                $vte->horaTarjeta,
                $vte->idBus,
                $vte->idVariante
            )) {

            header('Location: ?c=tarjetas&a=GenerarTarjetas&repetido=1');
            exit;

        } else {

            $this->model->Registrar($vte);
            header('Location: ?c=tarjetas&a=GenerarTarjetas&success=1');
            exit;
        }
    }
}

         
    public function Eliminar(){
        $this->model->Eliminar($_REQUEST['idTarjeta']);
        header('Location: ?c=tarjetas&a=GenerarTarjetas&delete=1');
    }


public function ObtenerUltimaFrecuencia1() {
   /* if(isset($_POST['idBus'])) {
        $idBus = $_POST['idBus'];
        
        // Llamamos al modelo para obtener la última frecuencia y hora
        $resultado = $this->model->ObtenerUltimaFrecuencia();
        
        echo $resultado; // Devuelve el JSON al AJAX
    } else {
        echo json_encode(["frecuenciaTarjeta" => "0", "horaTarjeta" => "00:00:00"]); // En caso de error
    }*/
}
public function ObtenerUltimaFrecuencia()
{
    $fechaSalida = $_POST['fechaSalida'];
    $idVariante  = $_POST['idVariante'];

    $modelo = new Tarjetas();

    echo $modelo->ObtenerUltimaFrecuencia($fechaSalida, $idVariante);
}

public function VerAjax()
{
    $idTarjeta = $_GET['idTarjeta'];

    $data = $this->model->ObtenerPorId($idTarjeta);

    header('Content-Type: application/json');
    echo json_encode($data);
    exit; // ← ESTO ES OBLIGATORIO
}
public function VerAjaxDetalleTarjeta()
{
    $idTarjeta = $_GET['idTarjeta'];

    $tarjeta = $this->model->ObtenerPorId($idTarjeta);
    $detalle = $this->model->ObtenerDetalleTarjeta($idTarjeta);

    $tarjeta['detalle'] = $detalle;

    header('Content-Type: application/json');
    echo json_encode($tarjeta);
    exit;
}

public function FiltrarPorFecha()
{
    $fecha = $_GET['fecha'];

    $data = $this->model->ListarTarjetasPorFecha($fecha);

    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}



}
?>