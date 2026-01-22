<?php
require_once 'usuarios/modelo/usuarios.php';

class UsuariosController{
    
    private $model;
    
    public function __CONSTRUCT(){
        $this->model = new Usuarios();
    }
    
        public function menuUsuario(){
        require_once 'includes/header.php';
        require_once 'usuarios/vista/User_list.php';
        require_once 'includes/footer.php';
    }

    
    public function Crud(){
        $vte = new Usuarios();
        
        if(isset($_REQUEST['idUsuario'])){
            $vte = $this->model->Obtener($_REQUEST['idUsuario']);
        }
        
        require_once 'includes/header.php';
        require_once 'usuarios/vista/User_edit.php';
        require_once 'includes/footer.php';
    }


    
    public function Guardar(){
        $vte = new Usuarios();
        

        $vte->idUsuario = $_REQUEST['idUsuario'];
        $vte->Tipo = $_REQUEST['Tipo'];
        $vte->Cedula = $_REQUEST['Cedula'];
        $vte->Nombre = $_REQUEST['Nombre'];
        $vte->Apellido = $_REQUEST['Apellido'];
        $vte->Fechacrea = $_REQUEST['Fechacrea'];
        $vte->Genero = $_REQUEST['Genero'];        
        $vte->edad = $_REQUEST['edad'];
        $vte->tipoT = $_REQUEST['tipoT'];  
        $vte->telefono = $_REQUEST['telefono'];
        $vte->Email = $_REQUEST['Email'];   
        $vte->Password = $_REQUEST['Password'];
        $vte->Nivel = $_REQUEST['Nivel'];   
               

       $this->model->Registrar($vte);
        
       
     header('Location:?c=usuarios&a=menuUser');
    }
    
    public function Eliminar(){
        $this->model->Eliminar($_REQUEST['idUsuario']);
        header('Location:?c=usuarios&a=menuUser');
    }




}