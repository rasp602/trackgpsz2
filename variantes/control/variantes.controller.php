<?php
require_once 'variantes/modelo/variantes.php';


class VariantesController{
    
    private $model;
    
    public function __CONSTRUCT(){
        $this->model = new Variantes();
    }
    

        public function menuTotales(){
        require_once 'includes/header_variante.php';
        require_once 'variantes/vista/variantes_total.php';
        require_once 'includes/footer.php';
    }
        public function menuVariantes(){
        require_once 'includes/header.php';
        require_once 'variantes/vista/variantes_list.php';
        require_once 'includes/footer.php';
    }

    
    public function Crud(){
        $vte = new Variantes();
        
        if(isset($_REQUEST['idVariante'])){
            $vte = $this->model->Obtener($_REQUEST['idVariante']);
        }
        
        require_once 'includes/header_variante.php';
        require_once 'variantes/vista/variantes_edit.php';
        require_once 'includes/footer.php';
       
    }

    public function Crud1(){
        $vte = new Variantes();
        
        if(isset($_REQUEST['idVariante'])){
            $vte = $this->model->Obtener($_REQUEST['idVariante']);
        }
        require_once 'includes/header_variante.php';
        require_once 'variantes/vista/variantes_editar.php';
        require_once 'includes/footer.php';
    }

        public function Crud2(){
        $vte = new Variantes();
        
        if(isset($_REQUEST['idVariante'])){
            $vte = $this->model->Obtener($_REQUEST['idVariante']);
        }
        
        require_once 'includes/header_variante.php';
        require_once 'variantes/vista/variantes_ver.php';
        require_once 'includes/footer.php';
    }


    public function CrudRepetido(){
        $vte = new Variantes();
        
        if(isset($_REQUEST['idVariante'])){
            $vte = $this->model->Obtener($_REQUEST['idVariante']);
        }

        require_once 'includes/header_variante.php';
        require_once 'variantes/vista/variantes_editRepetido.php';
        require_once 'includes/footer.php';
    }

    
    
    
    public function Guardar(){
        $vte = new Variantes();
                      
        $vte->idVariante = $_REQUEST['idVariante'];
        $vte->nombreVariante = $_REQUEST['nombreVariante'];
        $vte->numeroVariante = $_REQUEST['numeroVariante'];
        $vte->estadoVariante = $_REQUEST['estadoVariante'];
        $vte->frecMax = $_REQUEST['frecMax'];
        $vte->frecMin = $_REQUEST['frecMin'];
        $vte->frecNormal = $_REQUEST['frecNormal'];
        $vte->mediaVuelta = $_REQUEST['mediaVuelta'];
        $vte->proximaVariante = $_REQUEST['proximaVariante'];
        $vte->primeraSalida = $_REQUEST['primeraSalida'];
        $vte->colorVariante = $_REQUEST['colorVariante'];
      
        if ($vte->idVariante !="") {
            $this->model->ActualizarVariante($vte);
             header('Location: ?c=variantes&a=menuVariantes&update=1');
        }
       
        else{
            $consultaRepetido=$this->model->ObtenerNumeroVariante($vte->numeroVariante);
                if ($consultaRepetido) 
                    {
                     header('Location: ?c=variantes&a=Crud&repetido=1');
                    }
                else
                    {
                        $this->model->Registrar($vte);
                        echo "ingresado ok";
                        header('Location: ?c=variantes&a=menuVariantes&success=1');
                         }
                    }

            }

         
    public function Eliminar(){
        $this->model->Eliminar($_REQUEST['idVariante']);
        header('Location: ?c=variantes&a=menuVariantes&delete=1');
    }





}
?>