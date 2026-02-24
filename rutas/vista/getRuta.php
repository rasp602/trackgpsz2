<?php
// Archivo: rutas/vista/getRuta.php
require '../../bd/config.php';

$response = array('success' => false, 'mensaje' => '', 'datos' => null);

if (isset($_POST['idRuta'])) {
    $idRuta = $conn->real_escape_string($_POST['idRuta']);
    
    $sql = "SELECT r.*, c.nombreControl, v.nombreVariante 
            FROM ruta r
            INNER JOIN controles c ON r.idControl = c.idControl
            INNER JOIN variante v ON r.idVariante = v.idVariante
            WHERE r.idRuta = $idRuta";
    
    $resultado = $conn->query($sql);
    
    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        $response['success'] = true;
        $response['datos'] = $row;
    } else {
        $response['mensaje'] = 'No se encontró el registro';
    }
} else {
    $response['mensaje'] = 'ID no proporcionado';
}

echo json_encode($response);
?>