<?php
// Archivo: rutas/vista/test_update.php
// Este archivo es solo para pruebas

require '../../bd/config.php';

$response = array('success' => true, 'mensaje' => 'Prueba exitosa', 'post' => $_POST);

header('Content-Type: application/json; charset=utf-8');
echo json_encode($response);
?>