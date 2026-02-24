<?php
ob_start();

require '../../bd/config.php';

header('Content-Type: application/json; charset=utf-8');

$response = ['success' => false, 'mensaje' => ''];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'mensaje' => 'Método no permitido']);
    exit;
}

if (empty($_POST['idRuta'])) {
    echo json_encode(['success' => false, 'mensaje' => 'ID de ruta no proporcionado']);
    exit;
}

try {

    $idRuta = intval($_POST['idRuta']);
    $idVariante = intval($_POST['idVariante']);
    $posicion = intval($_POST['posicion']);
    $idControl = intval($_POST['idControl']);
    $minutos = intval($_POST['minutos']);
    $tolerancia = intval($_POST['tolerancia']);

    $tipoDias = $conn->real_escape_string($_POST['tipoDias']);
    $horaDesde = $conn->real_escape_string($_POST['horaDesde']);
    $horaHasta = $conn->real_escape_string($_POST['horaHasta']);

    $idTablaValores = !empty($_POST['idTablaValores'])
        ? intval($_POST['idTablaValores'])
        : "NULL";

    $sql = "UPDATE ruta SET 
            idVariante = $idVariante,
            posicion = $posicion,
            idControl = $idControl,
            minutos = $minutos,
            tolerancia = $tolerancia,
            tipoDias = '$tipoDias',
            horaDesde = '$horaDesde',
            horaHasta = '$horaHasta',
            idTablaValores = $idTablaValores
            WHERE idRuta = $idRuta";

    if ($conn->query($sql)) {
        $response['success'] = true;
        $response['mensaje'] = 'Registro actualizado correctamente';
    } else {
        $response['mensaje'] = $conn->error;
    }

} catch (Throwable $e) {
    $response['mensaje'] = $e->getMessage();
}

ob_clean();
echo json_encode($response);
exit;