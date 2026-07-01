<?php
// simple conexion a la base de datos
function connect(){

    $conn = new mysqli("localhost","rasp1989","Rodrigo2410$","trackgpszulia",3306);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    return $conn;
}
?>