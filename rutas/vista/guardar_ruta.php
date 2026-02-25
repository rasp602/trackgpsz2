<?php
require '../../bd/config.php';

$idVariante = $_POST['idVariante'];

$posicion = $_POST['posicion'];
$idControl = $_POST['idControl'];
$minutos = $_POST['minutos'];
$tolerancia = $_POST['tolerancia'];
$tipoDias = $_POST['tipoDias'];
$horaDesde = $_POST['horaDesde'];
$horaHasta = $_POST['horaHasta'];
$idTablaValores = $_POST['idTablaValores'];

for($i = 0; $i < count($posicion); $i++){

    $sql = "INSERT INTO ruta 
    (idVariante, posicion, idControl, minutos, tolerancia, tipoDias, horaDesde, horaHasta, idTablaValores)
    VALUES 
    ('$idVariante',
     '{$posicion[$i]}',
     '{$idControl[$i]}',
     '{$minutos[$i]}',
     '{$tolerancia[$i]}',
     '{$tipoDias[$i]}',
     '{$horaDesde[$i]}',
     '{$horaHasta[$i]}',
     '{$idTablaValores[$i]}')";

    $conn->query($sql);
}

echo "ok";