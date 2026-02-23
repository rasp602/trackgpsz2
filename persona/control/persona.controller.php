<?php
require_once 'persona/modelo/persona.php';


class PersonaController{
    
    private $model;
    
    public function __CONSTRUCT(){
        $this->model = new Persona();
    }
    

        public function menuTotales(){
        require_once 'includes/header_personas.php';
        require_once 'persona/vista/persona_total.php';
        require_once 'includes/footer.php';
    }
        public function menuPersona(){
        require_once 'includes/header_personas.php';
        require_once 'persona/vista/persona_list.php';
        require_once 'includes/footer.php';
    }

    
    public function Crud(){
        $vte = new Persona();
        
        if(isset($_REQUEST['idPersona'])){
            $vte = $this->model->Obtener($_REQUEST['idPersona']);
        }
        
        require_once 'includes/header_personas.php';
        require_once 'persona/vista/persona_edit.php';
        require_once 'includes/footer.php';
       
    }

    public function Crud1(){
        $vte = new Persona();
        
        if(isset($_REQUEST['idPersona'])){
            $vte = $this->model->Obtener($_REQUEST['idPersona']);
        }
        require_once 'includes/header_personas.php';
        require_once 'persona/vista/persona_editar.php';
        require_once 'includes/footer.php';
    }

        public function Crud2(){
        $vte = new Persona();
        
        if(isset($_REQUEST['idPersona'])){
            $vte = $this->model->Obtener($_REQUEST['idPersona']);
        }
        
        require_once 'includes/header_personas.php';
        require_once 'persona/vista/persona_ver.php';
        require_once 'includes/footer.php';
    }




    public function CrudRepetido(){
        $vte = new Persona();
        
        if(isset($_REQUEST['idPersona'])){
            $vte = $this->model->Obtener($_REQUEST['idPersona']);
        }
        
        require_once 'includes/header.php';

        require_once 'persona/vista/persona_editRepetido.php';

        require_once 'includes/footer.php';
    }

    
    
    
    public function Guardar(){
        $vte = new Persona();

        $vte->idPersona = $_REQUEST['idPersona'];
        $vte->cedulaPersona = $_REQUEST['cedulaPersona'];
        $vte->numeroPersona = $_REQUEST['numeroPersona'];
        $vte->nombre1Persona = $_REQUEST['nombre1Persona'];
        $vte->nombre2Persona = $_REQUEST['nombre2Persona'];
        $vte->apellido1Persona = $_REQUEST['apellido1Persona'];
        $vte->apellido2Persona = $_REQUEST['apellido2Persona'];
        $vte->fechaIngreso = $_REQUEST['fechaIngreso'];
        $vte->direccionPersona = $_REQUEST['direccionPersona'];
        $vte->estadoPersona = $_REQUEST['estadoPersona'];
        $vte->emailPersona = $_REQUEST['emailPersona'];
        $vte->nTelefonoPersona = $_REQUEST['nTelefonoPersona'];
        $vte->idRol = $_REQUEST['idRol'];       


        if ($vte->idPersona !="") {
            $this->model->ActualizarP($vte);
             header('Location: ?c=persona&a=menuPersona&update=1');
        }
       
        else{
            $consultaRepetido=$this->model->ObtenerCedula($vte->cedulaPersona);
                if ($consultaRepetido) 
                    {
                     header('Location: ?c=persona&a=Crud&repetido=1');
                    }
                else
                    {
                        $this->model->Registrar($vte);
                       /* $consultaRut = $this->model->ObtenerRut($vte->rutPersona);

                        if ($consultaRut) {                           
                       
                        require_once'library/phpqrcode/qrlib.php';
                        $id = $consultaRut->idPersona;
                        QRcode::png($id,"persona/codigosQR/qr_".$id.".png",'L',10,5);
                        $consultaRut->qrPersona = $id;
                        $this->model->ActualizarQr($consultaRut);*/
                        echo "ingresado ok";
                        header('Location: ?c=persona&a=Crud&success=1');
                        
                    }

            }
        

        }


    public function GuardarQR(){
        $vte = new Persona();
                      
        $vte->idPersona = $_REQUEST['idPersona'];
  
        $vte->qrPersona = $_REQUEST['qrPersona'];
       
      
        if ($vte->idPersona !="") {
            $this->model->ActualizarQr($vte);
             header('Location: ?c=persona&a=menuPersona&update=1');
        }
       
    

        }


         
    public function Eliminar(){
        $this->model->Eliminar($_REQUEST['idPersona']);
        header('Location: ?c=persona&a=menuPersona&delete=1');
    }





}
?>