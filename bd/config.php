<?php
/*
* Script: Conexión a base de datos de MySQL con PHP
* Autor: Marco Robles
* Team: Códigos de Programación
*/


/* Creando una nueva conexión a la base de datos. */
$conn = new mysqli("127.0.0.1", "trackgps_rasp1989", "Rodrigo2410$", "trackgpszulia");

/* Comprobando si hay un error de conexión. */
if ($conn->connect_error) {
    die('Error de conexion ' . $conn->connect_error);
}

$servername = "127.0.0.1";
$username = "trackgps_rasp1989";
$password = "Rodrigo2410$";
$dbname = "trackgpszulia";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}