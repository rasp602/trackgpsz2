<?php
require_once 'gps/modelo/gps.php';


class GpsController{
    
    private $model;
    
    public function __CONSTRUCT(){
        $this->model = new Gps();
    }
    

        public function menuTotales(){
        require_once 'includes/header.php';
        require_once 'gps/vista/gps_total.php';
        require_once 'includes/footer.php';
    }
        public function menuGps(){
        require_once 'includes/header.php';
        require_once 'gps/vista/gps_list.php';
        require_once 'includes/footer.php';
    }

    
    public function Crud(){
        $vte = new Gps();
        
        if(isset($_REQUEST['idGps'])){
            $vte = $this->model->Obtener($_REQUEST['idGps']);
        }
        
        require_once 'includes/header.php';
        require_once 'gps/vista/gps_edit.php';
        require_once 'includes/footer.php';
       
    }

    public function Crud1(){
        $vte = new Gps();
        
        if(isset($_REQUEST['idGps'])){
            $vte = $this->model->Obtener($_REQUEST['idGps']);
        }
        require_once 'includes/header.php';
        require_once 'gps/vista/gps_editar.php';
        require_once 'includes/footer.php';
    }

        public function Crud2(){
        $vte = new Gps();
        
        if(isset($_REQUEST['idGps'])){
            $vte = $this->model->Obtener($_REQUEST['idGps']);
        }
        
        require_once 'includes/header.php';
        require_once 'gps/vista/gps_ver.php';
        require_once 'includes/footer.php';
    }


    public function CrudRepetido(){
        $vte = new Gps();
        
        if(isset($_REQUEST['idGps'])){
            $vte = $this->model->Obtener($_REQUEST['idGps']);
        }

        require_once 'includes/header.php';
        require_once 'gps/vista/gps_editRepetido.php';
        require_once 'includes/footer.php';
    }

    
    
    
    public function Guardar(){
        $vte = new Gps();
                      
        $vte->idGps = $_REQUEST['idGps'];
        $vte->imeiGps = $_REQUEST['imeiGps'];
        $vte->simCardGps = $_REQUEST['simCardGps'];
        $vte->modelo = $_REQUEST['modelo'];
      
        if ($vte->idGps !="") {
            $this->model->ActualizarGps($vte);
             header('Location: ?c=gps&a=menuGps&update=1');
        }
       
        else{
            $consultaRepetido=$this->model->ObtenerNumeroGps($vte->imeiGps);
                if ($consultaRepetido) 
                    {
                     header('Location: ?c=gps&a=Crud&repetido=1');
                    }
                else
                    {
                        $this->model->Registrar($vte);
                        echo "ingresado ok";
                        header('Location: ?c=gps&a=menuGps&success=1');
                         }
                    }

            }

         
    public function Eliminar(){
        $this->model->Eliminar($_REQUEST['idGps']);
        header('Location: ?c=gps&a=menuGps&delete=1');
    }





}
?>