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
$hoja->setCellValue('A1', 'CEDULA');
$hoja->setCellValue('B1', 'NOMBRE PERSONA');
$hoja->setCellValue('C1', 'FECHA INGRESO');
$hoja->setCellValue('D1', 'EMAIL');
$hoja->setCellValue('E1', 'TELEFONO');
$hoja->setCellValue('F1', 'ESTADO');

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
        persona.idPersona,
        persona.cedulaPersona,
        persona.numeroPersona,
        persona.nombre1Persona,
        persona.nombre2Persona,
        persona.apellido1Persona,
        persona.apellido2Persona,
        persona.fechaIngreso,
        persona.direccionPersona,
        persona.estadoPersona,
        persona.emailPersona,
        persona.idRol,
        persona.nTelefonoPersona
     FROM persona
";

$result = $mysqli->query($sql);

// ------------------------------------------------------------
// 4️⃣ LLENAR EL EXCEL CON LOS DATOS
// ------------------------------------------------------------
$filaExcel = 2; // arranca luego del encabezado

while ($row = $result->fetch_assoc()) {

    // Convertimos estado a texto
    $estado = ($row['estadoPersona'] == 'A') ? "Activo" : "Inactivo";

    $hoja->setCellValue('A' . $filaExcel, $row['cedulaPersona']);
    $hoja->setCellValue('B' . $filaExcel, $row['nombre1Persona']);
    $hoja->setCellValue('C' . $filaExcel, $row['fechaIngreso']);
    $hoja->setCellValue('D' . $filaExcel, $row['emailPersona']);
    $hoja->setCellValue('E' . $filaExcel, $row['nTelefonoPersona']);
    $hoja->setCellValue('F' . $filaExcel, $estado);

    $filaExcel++;
}

// ------------------------------------------------------------
// 5️⃣ DESCARGAR EL ARCHIVO AL NAVEGADOR
// ------------------------------------------------------------
$nombreArchivo = "reporte_personas_" . date("Y-m-d") . ".xlsx";

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$nombreArchivo\"");
header('Cache-Control: max-age=0');

$writer = new Xlsx($excel);
$writer->save('php://output');
exit;
