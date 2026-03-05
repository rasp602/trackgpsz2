<?php
/*
* Script: Conexión a base de datos de MySQL con PHP
* Autor: Marco Robles
* Team: Códigos de Programación
*/


/* Creando una nueva conexión a la base de datos. */
$conn = new mysqli("srv1056.hstgr.io", "u854084565_Rodri24", "Rodrigo2410$", "u854084565_trackgpsz1");

/* Comprobando si hay un error de conexión. */
if ($conn->connect_error) {
    die('Error de conexion ' . $conn->connect_error);
}

$servername = "srv1056.hstgr.io";
$username = "u854084565_Rodri24";
$password = "Rodrigo2410$";
$dbname = "u854084565_trackgpsz1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}