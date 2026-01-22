<?php
require_once 'rutas/modelo/rutas.php';


class RutasController{
    
    private $model;
    
    public function __CONSTRUCT(){
        $this->model = new Rutas();
    }
    

        public function menuTotales(){
        require_once 'includes/header_rutas.php';
        require_once 'rutas/vista/rutas_total.php';
        require_once 'includes/footer.php';
    }
        public function menuRutas(){
        require_once 'includes/header_rutas.php';
        require_once 'rutas/vista/rutas_list.php';
        require_once 'includes/footer.php';
    }

    
    public function Crud(){
        $vte = new Rutas();
        
        if(isset($_REQUEST['idRuta'])){
            $vte = $this->model->Obtener($_REQUEST['idRuta']);
        }
        
        require_once 'includes/header_rutas.php';
        require_once 'rutas/vista/rutas_edit.php';
        require_once 'includes/footer.php';
       
    }

    public function Crud1(){
        $vte = new Rutas();
        
        if(isset($_REQUEST['idRuta'])){
            $vte = $this->model->Obtener($_REQUEST['idRuta']);
        }
        require_once 'includes/header_ruta.php';
        require_once 'rutas/vista/rutas_editar.php';
        require_once 'includes/footer.php';
    }

        public function Crud2(){
        $vte = new Rutas();
        
        if(isset($_REQUEST['idRuta'])){
            $vte = $this->model->Obtener($_REQUEST['idRuta']);
        }
        
        require_once 'includes/header_roles.php';
        require_once 'rutas/vista/rutas_ver.php';
        require_once 'includes/footer.php';
    }


    public function CrudRepetido(){
        $vte = new Rutas();
        
        if(isset($_REQUEST['idRuta'])){
            $vte = $this->model->Obtener($_REQUEST['idRuta']);
        }

        require_once 'includes/header_roles.php';
        require_once 'rutas/vista/rutas_editRepetido.php';
        require_once 'includes/footer.php';
    }

    
    
    
    public function Guardar(){
        $vte = new Rutas();
                      
        $vte->idRuta = $_REQUEST['idRuta'];
        $vte->idVariante = $_REQUEST['idVariante'];
        $vte->idControl = $_REQUEST['idControl'];
        $vte->minutos = $_REQUEST['minutos'];
        $vte->tolerancia = $_REQUEST['tolerancia'];
        $vte->tipoDias = $_REQUEST['tipoDias'];
        $vte->horaDesde = $_REQUEST['horaDesde'];
        $vte->horaHasta = $_REQUEST['horaHasta'];
        $vte->idTablaValores = $_REQUEST['idTablaValores'];

        
      
        if ($vte->idRuta !="") {
            $this->model->ActualizarRuta($vte);
             header('Location: ?c=rutas&a=menuRutas&update=1');
        }
       
        else{
            $consultaRepetido=$this->model->ObteneridControl($vte->idControl);
                if ($consultaRepetido) 
                    {
                     header('Location: ?c=rutas&a=Crud&repetido=1');
                    }
                else
                    {
                        $this->model->Registrar($vte);
                        echo "ingresado ok";
                        header('Location: ?c=rutas&a=menuRutas&success=1');
                         }
                    }

            }

         
    public function Eliminar(){
        $this->model->Eliminar($_REQUEST['idRuta']);
        header('Location: ?c=rutas&a=menuRutas&delete=1');
    }





}
?>