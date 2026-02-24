<?php
require '../../bd/config.php';

$response = array('success' => false, 'nombre' => '');

if (isset($_POST['idControl'])) {
    $idControl = $conn->real_escape_string($_POST['idControl']);
    
    $sql = "SELECT nombreControl FROM controles WHERE idControl = $idControl";
    $resultado = $conn->query($sql);
    
    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        $response['success'] = true;
        $response['nombre'] = $row['nombreControl'];
    }
}

echo json_encode($response);
?>