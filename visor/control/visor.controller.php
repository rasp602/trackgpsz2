<?php
require_once 'visor/modelo/visor.php';


class VisorController{
    
    private $model;
    
    public function __CONSTRUCT(){
        $this->model = new Visor();
    }
    

        public function menuVisor(){
        require_once 'includes/header_roles.php';
        require_once 'visor/vista/visor_list.php';
        require_once 'includes/footer.php';
    }


}
?>