<?php
// simple conexion a la base de datos
function connect(){

    $conn = new mysqli("srv1056.hstgr.io","u854084565_Rodri24","Rodrigo2410$","u854084565_trackgpsz1",3306);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    return $conn;
}
?>