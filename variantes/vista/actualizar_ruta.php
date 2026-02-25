<?php
require '../../bd/config.php';

$conn->begin_transaction();

try {

    $idVariante = $_POST['idVariante'];
    $idRuta = $_POST['idRuta'] ?? [];
    $posicion = $_POST['posicion'];
    $idControl = $_POST['idControl'];
    $minutos = $_POST['minutos'];
    $tolerancia = $_POST['tolerancia'];
    $tipoDias = $_POST['tipoDias'];
    $anguloE = $_POST['anguloE'];
    $anguloS = $_POST['anguloS'];
    $multaAtraso = $_POST['multaAtraso'];

    // =========================================
    // 1️⃣ OBTENER IDS ACTUALES EN BD
    // =========================================

    $idsBD = [];
    $result = $conn->query("SELECT idRuta FROM ruta WHERE idVariante = '$idVariante'");

    while($row = $result->fetch_assoc()){
        $idsBD[] = $row['idRuta'];
    }

    // =========================================
    // 2️⃣ DETECTAR IDS ELIMINADOS
    // =========================================

    $idsEliminar = array_diff($idsBD, $idRuta);

    foreach($idsEliminar as $idEliminar){
        $conn->query("DELETE FROM ruta WHERE idRuta = '$idEliminar'");
    }

    // =========================================
    // 3️⃣ INSERT / UPDATE
    // =========================================

    for($i=0; $i<count($posicion); $i++){

        if($idRuta[$i] == 0){

            // INSERT
            $sql = "INSERT INTO ruta
                    (idVariante, posicion, idControl, minutos, tolerancia, tipoDias, anguloE, anguloS, multaAtraso)
                    VALUES
                    ('$idVariante',
                     '{$posicion[$i]}',
                     '{$idControl[$i]}',
                     '{$minutos[$i]}',
                     '{$tolerancia[$i]}',
                     '{$tipoDias[$i]}',
                     '{$anguloE[$i]}',
                     '{$anguloS[$i]}',
                     '{$multaAtraso[$i]}')";

        }else{

            // UPDATE
            $sql = "UPDATE ruta SET
                    posicion = '{$posicion[$i]}',
                    idControl = '{$idControl[$i]}',
                    minutos = '{$minutos[$i]}',
                    tolerancia = '{$tolerancia[$i]}',
                    tipoDias = '{$tipoDias[$i]}',
                    anguloE = '{$anguloE[$i]}',
                    anguloS = '{$anguloS[$i]}',
                    multaAtraso = '{$multaAtraso[$i]}'
                    WHERE idRuta = '{$idRuta[$i]}'";
        }

        $conn->query($sql);
    }

    $conn->commit();

    echo "ok";

} catch(Exception $e){

    $conn->rollback();
    echo "error";
}