<?php
require_once 'roles/modelo/roles.php';


class RolesController{
    
    private $model;
    
    public function __CONSTRUCT(){
        $this->model = new Roles();
    }
    

        public function menuTotales(){
        require_once 'includes/header_roles.php';
        require_once 'roles/vista/roles_total.php';
        require_once 'includes/footer.php';
    }
        public function menuRoles(){
        require_once 'includes/header_roles.php';
        require_once 'roles/vista/roles_list.php';
        require_once 'includes/footer.php';
    }

    
    public function Crud(){
        $vte = new Roles();
        
        if(isset($_REQUEST['idRol'])){
            $vte = $this->model->Obtener($_REQUEST['idRol']);
        }
        
        require_once 'includes/header_roles.php';
        require_once 'roles/vista/roles_edit.php';
        require_once 'includes/footer.php';
       
    }

    public function Crud1(){
        $vte = new Roles();
        
        if(isset($_REQUEST['idRol'])){
            $vte = $this->model->Obtener($_REQUEST['idRol']);
        }
        require_once 'includes/header_roles.php';
        require_once 'roles/vista/roles_editar.php';
        require_once 'includes/footer.php';
    }

        public function Crud2(){
        $vte = new Roles();
        
        if(isset($_REQUEST['idRol'])){
            $vte = $this->model->Obtener($_REQUEST['idRol']);
        }
        
        require_once 'includes/header_roles.php';
        require_once 'roles/vista/roles_ver.php';
        require_once 'includes/footer.php';
    }


    public function CrudRepetido(){
        $vte = new Roles();
        
        if(isset($_REQUEST['idRol'])){
            $vte = $this->model->Obtener($_REQUEST['idRol']);
        }

        require_once 'includes/header_roles.php';
        require_once 'roles/vista/roles_editRepetido.php';
        require_once 'includes/footer.php';
    }

    
    
    
    public function Guardar(){
        $vte = new Roles();
                      
        $vte->idRol = $_REQUEST['idRol'];
        $vte->nombreRol = $_REQUEST['nombreRol'];
        $vte->descripcionRol = $_REQUEST['descripcionRol'];
        $vte->estadoRol = $_REQUEST['estadoRol'];

        
      
        if ($vte->idRol !="") {
            $this->model->ActualizarRol($vte);
             header('Location: ?c=roles&a=menuRoles&update=1');
        }
       
        else{
            $consultaRepetido=$this->model->ObtenerNombreRol($vte->nombreRol);
                if ($consultaRepetido) 
                    {
                     header('Location: ?c=roles&a=Crud&repetido=1');
                    }
                else
                    {
                        $this->model->Registrar($vte);
                        echo "ingresado ok";
                        header('Location: ?c=roles&a=menuRoles&success=1');
                         }
                    }

            }

         
    public function Eliminar(){
        $this->model->Eliminar($_REQUEST['idRol']);
        header('Location: ?c=roles&a=menuRoles&delete=1');
    }





}
?>