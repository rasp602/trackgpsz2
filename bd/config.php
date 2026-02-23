<?php
/*
* Script: Conexión a base de datos de MySQL con PHP
* Autor: Marco Robles
* Team: Códigos de Programación
*/


/* Creando una nueva conexión a la base de datos. */
$conn = new mysqli("localhost", "rasp602", "Rodrigo2410$", "trackgpszulia");

/* Comprobando si hay un error de conexión. */
if ($conn->connect_error) {
    die('Error de conexion ' . $conn->connect_error);
}

$servername = "localhost";
$username = "rasp602";
$password = "Rodrigo2410$";
$dbname = "trackgpszulia";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}