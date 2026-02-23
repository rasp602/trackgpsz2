<?php
require_once 'controles/modelo/controles.php';


class ControlesController{
    
    private $model;
    
    public function __CONSTRUCT(){
        $this->model = new Controles();
    }
    

        public function menuTotales(){
        require_once 'includes/header_controles.php';
        require_once 'controles/vista/controles_total.php';
        require_once 'includes/footer.php';
    }
        public function menuControles(){
        require_once 'includes/header_controles.php';
        require_once 'controles/vista/controles_list.php';
        require_once 'includes/footer.php';
    }

    
    public function Crud(){
        $vte = new Controles();
        
        if(isset($_REQUEST['idControl'])){
            $vte = $this->model->Obtener($_REQUEST['idControl']);
        }
        
        require_once 'includes/header_controles.php';
        require_once 'controles/vista/controles_edit.php';
        require_once 'includes/footer.php';
       
    }

    public function Crud1(){
        $vte = new Controles();
        
        if(isset($_REQUEST['idControl'])){
            $vte = $this->model->Obtener($_REQUEST['idControl']);
        }
        require_once 'includes/header_controles.php';
        require_once 'controles/vista/controles_editar.php';
        require_once 'includes/footer.php';
    }

        public function Crud2(){
        $vte = new Controles();
        
        if(isset($_REQUEST['idControl'])){
            $vte = $this->model->Obtener($_REQUEST['idControl']);
        }
        
        require_once 'includes/header_controles.php';
        require_once 'controles/vista/controles_ver.php';
        require_once 'includes/footer.php';
    }


    public function CrudRepetido(){
        $vte = new Controles();
        
        if(isset($_REQUEST['idControl'])){
            $vte = $this->model->Obtener($_REQUEST['idControl']);
        }

        require_once 'includes/header_controles.php';
        require_once 'controles/vista/controles_editRepetido.php';
        require_once 'includes/footer.php';
    }

    
    
    
    public function Guardar(){
        $vte = new Controles();
                      
        $vte->idControl = $_REQUEST['idControl'];
        $vte->nombreControl = $_REQUEST['nombreControl'];
        $vte->abreviacionControl = $_REQUEST['abreviacionControl'];
        $vte->tipoControl = $_REQUEST['tipoControl'];
        $vte->longitud1 = $_REQUEST['longitud1'];
        $vte->longitud2 = $_REQUEST['longitud2'];
        $vte->latitud1 = $_REQUEST['latitud1'];
        $vte->latitud2 = $_REQUEST['latitud2'];
        $vte->anguloEntrada = $_REQUEST['anguloEntrada'];
        $vte->toleraciaEntrada = $_REQUEST['toleraciaEntrada'];
        $vte->velMax = $_REQUEST['velMax'];
        $vte->estadoControl = $_REQUEST['estadoControl'];
        $vte->sentido = $_REQUEST['sentido'];
        $vte->visible = $_REQUEST['visible'];
      
        if ($vte->idControl !="") {
            $this->model->ActualizarControl($vte);
             header('Location: ?c=controles&a=menuControles&update=1');
        }
       
        else{
            $consultaRepetido=$this->model->ObtenerNombreControl($vte->nombreControl);
                if ($consultaRepetido) 
                    {
                     header('Location: ?c=controles&a=Crud&repetido=1');
                    }
                else
                    {
                        $this->model->Registrar($vte);
                        echo "ingresado ok";
                        header('Location: ?c=controles&a=menuControles&success=1');
                         }
                    }

            }

         
    public function Eliminar(){
        $this->model->Eliminar($_REQUEST['idControl']);
        header('Location: ?c=controles&a=menuControles&delete=1');
    }





}
?>