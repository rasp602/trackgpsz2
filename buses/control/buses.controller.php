<?php
require_once 'buses/modelo/buses.php';


class BusesController{
    
    private $model;
    
    public function __CONSTRUCT(){
        $this->model = new Buses();
    }
    

        public function menuTotales(){
        require_once 'includes/header_buses.php';
        require_once 'buses/vista/buses_total.php';
        require_once 'includes/footer.php';
    }
        public function menuBuses(){
        require_once 'includes/header_buses.php';
        require_once 'buses/vista/buses_list.php';
        require_once 'includes/footer.php';
    }
        public function visorOnline(){
        require_once 'includes/header_visorOnline.php';
        require_once 'buses/vista/buses_visorOnline.php';
        require_once 'includes/footer.php';
    }
    
    public function Crud(){
        $vte = new Buses();
        
        if(isset($_REQUEST['idBus'])){
            $vte = $this->model->Obtener($_REQUEST['idBus']);
        }
        
        require_once 'includes/header_buses.php';
        require_once 'buses/vista/buses_edit.php';
        require_once 'includes/footer.php';
       
    }

    public function Crud1(){
        $vte = new Buses();
        
        if(isset($_REQUEST['idBus'])){
            $vte = $this->model->Obtener($_REQUEST['idBus']);
        }
        require_once 'includes/header_buses.php';
        require_once 'buses/vista/buses_editar.php';
        require_once 'includes/footer.php';
    }

        public function Crud2(){
        $vte = new Buses();
        
        if(isset($_REQUEST['idBus'])){
            $vte = $this->model->Obtener($_REQUEST['idBus']);
        }
        
        require_once 'includes/header_buses.php';
        require_once 'buses/vista/buses_ver.php';
        require_once 'includes/footer.php';
    }


    public function CrudRepetido(){
        $vte = new Buses();
        
        if(isset($_REQUEST['idBus'])){
            $vte = $this->model->Obtener($_REQUEST['idBus']);
        }

        require_once 'includes/header_buses.php';
        require_once 'buses/vista/buses_editRepetido.php';
        require_once 'includes/footer.php';
    }

    
    
    
    public function Guardar(){
        $vte = new Buses();
                      
        $vte->idBus = $_REQUEST['idBus'];
        $vte->numeroBus = $_REQUEST['numeroBus'];
        $vte->placaBus = $_REQUEST['placaBus'];
        $vte->tipoBus = $_REQUEST['tipoBus'];
        $vte->idPersona = $_REQUEST['idPersona'];
        $vte->estadoBus = $_REQUEST['estadoBus'];
        $vte->validez = $_REQUEST['validez'];
        $vte->idGps = $_REQUEST['idGps'];
      
        if ($vte->idBus !="") {
            $this->model->ActualizarBus($vte);
             header('Location: ?c=buses&a=menuBuses&update=1');
        }
       
        else{
            $consultaRepetido=$this->model->ObtenerNumeroBus($vte->numeroBus);
                if ($consultaRepetido) 
                    {
                     header('Location: ?c=buses&a=Crud&repetido=1');
                    }
                else
                    {
                        $this->model->Registrar($vte);
                        echo "ingresado ok";
                        header('Location: ?c=buses&a=menuBuses&success=1');
                         }
                    }

            }

         
    public function Eliminar(){
        $this->model->Eliminar($_REQUEST['idBus']);
        header('Location: ?c=buses&a=menuBuses&delete=1');
    }





}
?>