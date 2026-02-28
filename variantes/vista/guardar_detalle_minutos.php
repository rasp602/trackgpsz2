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

    // 🔥 Iniciar transacción
    $conn->begin_transaction();

    // 1️⃣ Eliminar registros anteriores del control
    $stmtDelete = $conn->prepare("DELETE FROM detalleControl WHERE idControl = ?");
    if (!$stmtDelete) throw new Exception("Error preparando DELETE: " . $conn->error);
    $stmtDelete->bind_param("i", $idControl);
    $stmtDelete->execute();
    $stmtDelete->close();

    // 2️⃣ Insertar nueva configuración solo si hay datos
    if (count($tipoDia) > 0) {
        $sqlInsert = "INSERT INTO detalleControl
            (idControl, tipoDia, desdeHora, hastaHora, masMinutos, tolerancia)
            VALUES (?, ?, ?, ?, ?, ?)";
        $stmtInsert = $conn->prepare($sqlInsert);
        if (!$stmtInsert) throw new Exception("Error preparando INSERT: " . $conn->error);

        for ($i = 0; $i < count($tipoDia); $i++) {
            $tipo = $tipoDia[$i] ?? '';
            $desde = $desdeHora[$i] ?? '';
            $hasta = $hastaHora[$i] ?? '';
            $mas = intval($masMinutos[$i] ?? 0);
            $tol = intval($tolerancia[$i] ?? 0);

            if ($tipo === '' || $desde === '' || $hasta === '') continue;

            $stmtInsert->bind_param("isssii", $idControl, $tipo, $desde, $hasta, $mas, $tol);
            if (!$stmtInsert->execute()) {
                throw new Exception("Error insertando detalle: " . $stmtInsert->error);
            }
        }
        $stmtInsert->close();
    }

    $conn->commit();

    // ✅ Comprobar si ahora el control tiene detalle
    $stmtCheck = $conn->prepare("SELECT COUNT(*) as total FROM detalleControl WHERE idControl = ?");
    $stmtCheck->bind_param("i", $idControl);
    $stmtCheck->execute();
    $result = $stmtCheck->get_result();
    $row = $result->fetch_assoc();
    $tieneDetalle = $row['total'] > 0 ? 1 : 0;
    $stmtCheck->close();

    echo json_encode([
        "status" => "ok",
        "message" => "Detalle guardado correctamente",
        "tieneDetalle" => $tieneDetalle
    ]);

} catch (Exception $e) {
    $conn->rollback(); // Siempre hacemos rollback si hay error real
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}