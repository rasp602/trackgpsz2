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
$hoja->setTitle("GPS");

// ------------------------------------------------------------
// 2️⃣ ESCRIBIR ENCABEZADOS
// ------------------------------------------------------------
$hoja->setCellValue('A1', 'ID');
$hoja->setCellValue('B1', 'NOMBRE ROL');
$hoja->setCellValue('C1', 'ESTADO');


// Poner encabezados en negrita
$hoja->getStyle('A1:F1')->getFont()->setBold(true);

// Autosize columnas
foreach (range('A', 'F') as $col) {
    $hoja->getColumnDimension($col)->setAutoSize(true);
}

// ------------------------------------------------------------
// 3️⃣ CONSULTA A LA BASE DE DATOS
// ------------------------------------------------------------
$sql = "SELECT * FROM roles";

$result = $mysqli->query($sql);

// ------------------------------------------------------------
// 4️⃣ LLENAR EL EXCEL CON LOS DATOS
// ------------------------------------------------------------
$filaExcel = 2; // arranca luego del encabezado

while ($row = $result->fetch_assoc()) {

    // Convertimos estado a texto
   // $estado = ($row['estadoPersona'] == 'A') ? "Activo" : "Inactivo";

    $hoja->setCellValue('A' . $filaExcel, $row['idRol']);
    $hoja->setCellValue('B' . $filaExcel, $row['nombreRol']);
    $hoja->setCellValue('C' . $filaExcel, $row['estadoRol']);


    $filaExcel++;
}

// ------------------------------------------------------------
// 5️⃣ DESCARGAR EL ARCHIVO AL NAVEGADOR
// ------------------------------------------------------------
$nombreArchivo = "reporte_roles_" . date("Y-m-d") . ".xlsx";

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$nombreArchivo\"");
header('Cache-Control: max-age=0');

$writer = new Xlsx($excel);
$writer->save('php://output');
exit;
