<?php
require __DIR__ . '/../../vendor/autoload.php';
require '../../bd/conexionLocal.php'; // ← tu conexión

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// ------------------------------------------------------------
// 1️⃣ CREAR HOJA DE EXCEL
// ------------------------------------------------------------
$excel = new Spreadsheet();
$hoja = $excel->getActiveSheet();
$hoja->setTitle("Buses");

// ------------------------------------------------------------
// 2️⃣ ESCRIBIR ENCABEZADOS
// ------------------------------------------------------------
$hoja->setCellValue('A1', 'ID');
$hoja->setCellValue('B1', 'Número Bus');
$hoja->setCellValue('C1', 'Placa');
$hoja->setCellValue('D1', 'Tipo');
$hoja->setCellValue('E1', 'Propietario');
$hoja->setCellValue('F1', 'Estado');

// Poner encabezados en negrita
$hoja->getStyle('A1:F1')->getFont()->setBold(true);

// Autosize columnas
foreach (range('A', 'F') as $col) {
    $hoja->getColumnDimension($col)->setAutoSize(true);
}

// ------------------------------------------------------------
// 3️⃣ CONSULTA A LA BASE DE DATOS
// ------------------------------------------------------------
$sql = "SELECT 
            buses.idBus,
            buses.numeroBus,
            buses.placaBus,
            buses.tipoBus,
            CONCAT(persona.nombre1Persona, ' ', persona.apellido1Persona) AS propietario,
            buses.estadoBus
        FROM buses
        LEFT JOIN persona ON persona.idPersona = buses.idPersona";

$result = $mysqli->query($sql);

// ------------------------------------------------------------
// 4️⃣ LLENAR EL EXCEL CON LOS DATOS
// ------------------------------------------------------------
$filaExcel = 2; // arranca luego del encabezado

while ($row = $result->fetch_assoc()) {

    // Convertimos estado a texto
    $estado = ($row['estadoBus'] == 1) ? "Activo" : "Inactivo";

    $hoja->setCellValue('A' . $filaExcel, $row['idBus']);
    $hoja->setCellValue('B' . $filaExcel, $row['numeroBus']);
    $hoja->setCellValue('C' . $filaExcel, $row['placaBus']);
    $hoja->setCellValue('D' . $filaExcel, $row['tipoBus']);
    $hoja->setCellValue('E' . $filaExcel, $row['propietario']);
    $hoja->setCellValue('F' . $filaExcel, $estado);

    $filaExcel++;
}

// ------------------------------------------------------------
// 5️⃣ DESCARGAR EL ARCHIVO AL NAVEGADOR
// ------------------------------------------------------------
$nombreArchivo = "reporte_buses_" . date("Y-m-d") . ".xlsx";

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$nombreArchivo\"");
header('Cache-Control: max-age=0');

$writer = new Xlsx($excel);
$writer->save('php://output');
exit;
