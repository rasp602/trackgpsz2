<?php
require '../../bd/config.php';

$idVariante = $_GET['idVariante'];

$sql = "SELECT * FROM ruta WHERE idVariante = '$idVariante'";
$result = $conn->query($sql);

$data = [];

while($row = $result->fetch_assoc()){

    // generar select de controles con seleccionado
    $select = "";
    $sql_control = "SELECT idControl, nombreControl FROM controles";
    $res_control = $conn->query($sql_control);

    while($ctrl = $res_control->fetch_assoc()){
        $selected = ($ctrl['idControl'] == $row['idControl']) ? "selected" : "";
        $select .= "<option value='{$ctrl['idControl']}' $selected>{$ctrl['nombreControl']}</option>";
    }

    $row['selectControl'] = $select;
    $data[] = $row;
}

echo json_encode($data);