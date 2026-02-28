<?php
header('Content-Type: application/json');
ini_set('display_errors', 0);
error_reporting(E_ALL);

require_once '../../bd/config.php';

try {

    // Acepta GET o POST
    $idControl = null;

    if (isset($_GET['idControl']) && !empty($_GET['idControl'])) {
        $idControl = intval($_GET['idControl']);
    } elseif (isset($_POST['idControl']) && !empty($_POST['idControl'])) {
        $idControl = intval($_POST['idControl']);
    }

    if (!$idControl) {
        echo json_encode([
            "success" => false,
            "message" => "Parámetro idControl requerido"
        ]);
        exit;
    }

    $sql = "SELECT 
                idControl,
                tipoDia,
                desdeHora,
                hastaHora,
                masMinutos,
                tolerancia
            FROM detalleControl
            WHERE idControl = ?
            ORDER BY desdeHora ASC";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        throw new Exception("Error en prepare: " . $conn->error);
    }

    // SOLO un parámetro porque solo hay un ?
    $stmt->bind_param("i", $idControl);

    $stmt->execute();
    $result = $stmt->get_result();

    $datos = [];

    while ($row = $result->fetch_assoc()) {
        $datos[] = $row;
    }

    echo json_encode([
        "success" => true,
        "data" => $datos
    ]);

    $stmt->close();
    $conn->close();

} catch (Throwable $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}