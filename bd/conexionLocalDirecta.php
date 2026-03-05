<?php 

$mysqli = new mysqli("srv1056.hstgr.io", "u854084565_Rodri24", "Rodrigo2410$", "u854084565_trackgpsz1");
if ($mysqli->connect_error)
{
    die ('ERROR: No se establecio la conexion.'.mysqli_connect_error());
}

    # conectare la base de datos
    $con=@mysqli_connect('srv1056.hstgr.io', 'u854084565_Rodri24', 'Rodrigo2410$', 'u854084565_trackgpsz1');

    if(!$con){
        die("imposible conectar: ".mysqli_error($con));
    }
    if (@mysqli_connect_errno()) {
        die("Connect failed: ".mysqli_connect_errno()." : ". mysqli_connect_error());
    }  
?>