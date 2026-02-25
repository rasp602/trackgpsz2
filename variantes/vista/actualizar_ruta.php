<?php
require '../../bd/config.php';

$idVariante = $_POST['idVariante'];
$idRuta = $_POST['idRuta'];
$posicion = $_POST['posicion'];
$idControl = $_POST['idControl'];
$minutos = $_POST['minutos'];
$tolerancia = $_POST['tolerancia'];
$tipoDias = $_POST['tipoDias'];
$horaDesde = $_POST['horaDesde'];
$horaHasta = $_POST['horaHasta'];
$idTablaValores = $_POST['idTablaValores'];

for($i=0; $i<count($posicion); $i++){

    if($idRuta[$i] == 0){

        // INSERT
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

    }else{

        // UPDATE
        $sql = "UPDATE ruta SET
                posicion = '{$posicion[$i]}',
                idControl = '{$idControl[$i]}',
                minutos = '{$minutos[$i]}',
                tolerancia = '{$tolerancia[$i]}',
                tipoDias = '{$tipoDias[$i]}',
                horaDesde = '{$horaDesde[$i]}',
                horaHasta = '{$horaHasta[$i]}',
                idTablaValores = '{$idTablaValores[$i]}'
                WHERE idRuta = '{$idRuta[$i]}'";
    }

    $conn->query($sql);
}

echo "ok";