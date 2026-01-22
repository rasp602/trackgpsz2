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
        $vte->busTrasero = $_REQUEST['busTrasero'];

        /*$vte->idTarjeta = null;
        $vte->fechaSalida = '2025-03-08';
        $vte->horaTarjeta = '14:05:00';
        $vte->idBus = 1;
        $vte->idVariante = 1;
        $vte->idPersona = 4;
        $vte->frecuenciaTarjeta = 5;
        $vte->busDelantero = 1;
        $vte->busTrasero = 3;*/
      
        if ($vte->idTarjeta !="") {
            $this->model->ActualizarTarjeta($vte);
             header('Location: ?c=tarjetas&a=menutarjetas&update=1');
        }
       
        else{
            $consultaRepetido=$this->model->ObteneridTarjeta($vte->idTarjeta);
                if ($consultaRepetido) 
                    {
                     header('Location: ?c=tarjetas&a=menuTarjeta&repetido=1');
                    }
                else
                    {
                        $this->model->Registrar($vte);
                        echo "ingresado ok";
                        header('Location: ?c=tarjetas&a=menuTarjetas&success=1');
                         }
                    }

            }

         
    public function Eliminar(){
        $this->model->Eliminar($_REQUEST['idTarjeta']);
        header('Location: ?c=tarjetas&a=menuTarjetas&delete=1');
    }


public function ObtenerUltimaFrecuencia() {
    if(isset($_POST['idBus'])) {
        $idBus = $_POST['idBus'];
        
        // Llamamos al modelo para obtener la última frecuencia y hora
        $resultado = $this->model->ObtenerUltimaFrecuencia();
        
        echo $resultado; // Devuelve el JSON al AJAX
    } else {
        echo json_encode(["frecuenciaTarjeta" => "0", "horaTarjeta" => "00:00:00"]); // En caso de error
    }
}




}
?>