<?php
require '../../bd/config.php';

$response = array('success' => false, 'nombre' => '');

if (isset($_POST['idVariante'])) {
    $idVariante = $conn->real_escape_string($_POST['idVariante']);
    
    $sql = "SELECT nombreVariante FROM variante WHERE idVariante = $idVariante";
    $resultado = $conn->query($sql);
    
    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        $response['success'] = true;
        $response['nombre'] = $row['nombreVariante'];
    }
}

echo json_encode($response);
?>