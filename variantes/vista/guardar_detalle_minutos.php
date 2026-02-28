<?php
require '../../bd/config.php';

header('Content-Type: application/json');

try {

    if (!isset($_POST['idControl'])) {
        throw new Exception("Falta idControl");
    }

    $idControl   = intval($_POST['idControl']);
    $tipoDia     = $_POST['tipoDia'] ?? [];
    $desdeHora   = $_POST['desdeHora'] ?? [];
    $hastaHora   = $_POST['hastaHora'] ?? [];
    $masMinutos  = $_POST['masMinutos'] ?? [];
    $tolerancia  = $_POST['tolerancia'] ?? [];

    if (count($tipoDia) == 0) {
        throw new Exception("No hay datos para guardar");
    }

    // 🔥 Iniciar transacción
    $conn->begin_transaction();

    // 1️⃣ Eliminar registros anteriores del control
    $stmtDelete = $conn->prepare("DELETE FROM detalleControl WHERE idControl = ?");
    $stmtDelete->bind_param("i", $idControl);
    $stmtDelete->execute();
    $stmtDelete->close();

    // 2️⃣ Insertar nueva configuración
    $sqlInsert = "
        INSERT INTO detalleControl
        (idControl, tipoDia, desdeHora, hastaHora, masMinutos, tolerancia)
        VALUES (?, ?, ?, ?, ?, ?)
    ";

    $stmtInsert = $conn->prepare($sqlInsert);

    for ($i = 0; $i < count($tipoDia); $i++) {

        // Validación mínima
        if (
            empty($tipoDia[$i]) ||
            empty($desdeHora[$i]) ||
            empty($hastaHora[$i])
        ) {
            continue;
        }

        $mas = intval($masMinutos[$i]);
        $tol = intval($tolerancia[$i]);

        $stmtInsert->bind_param(
            "isssii",
            $idControl,
            $tipoDia[$i],
            $desdeHora[$i],
            $hastaHora[$i],
            $mas,
            $tol
        );

        $stmtInsert->execute();
    }

    $stmtInsert->close();

    $conn->commit();

    echo json_encode([
        "status" => "ok",
        "message" => "Detalle guardado correctamente"
    ]);

} catch (Exception $e) {

    if ($conn->errno === 0) {
        $conn->rollback();
    }

    http_response_code(500);

    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}