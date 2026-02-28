<?php
require '../../bd/config.php';

header('Content-Type: application/json');

try {

    if (!isset($_GET['idVariante'])) {
        throw new Exception("idVariante no recibido");
    }

    if (!isset($conn)) {
        throw new Exception("Conexión no inicializada");
    }

    $idVariante = $_GET['idVariante'];

    // Consulta principal
    $stmt = $conn->prepare("SELECT * FROM ruta WHERE idVariante = ?");
    $stmt->bind_param("i", $idVariante);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];

while ($row = $result->fetch_assoc()) {

    // Verificar si tiene detalle
    $stmtDetalle = $conn->prepare("SELECT COUNT(*) as total FROM detalleControl WHERE idControl = ?");
    $stmtDetalle->bind_param("i", $row['idControl']);
    $stmtDetalle->execute();
    $resDetalle = $stmtDetalle->get_result();
    $detalle = $resDetalle->fetch_assoc();

    $row['tieneDetalle'] = ($detalle['total'] > 0) ? 1 : 0;

    // Consulta controles
    $stmtControl = $conn->prepare("SELECT idControl, nombreControl FROM controles");
    $stmtControl->execute();
    $res_control = $stmtControl->get_result();

    $select = "";

    while ($ctrl = $res_control->fetch_assoc()) {
        $selected = ($ctrl['idControl'] == $row['idControl']) ? "selected" : "";
        $select .= "<option value='{$ctrl['idControl']}' $selected>{$ctrl['nombreControl']}</option>";
    }

    $row['selectControl'] = $select;
    $data[] = $row;
}

    echo json_encode($data);

} catch (Throwable $e) {

    echo json_encode([
        "error" => true,
        "mensaje" => $e->getMessage()
    ]);

}