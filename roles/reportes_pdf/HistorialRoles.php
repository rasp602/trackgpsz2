<?php
require('../../fpdf/fpdf.php');
require('../../bd/database.php');
require('../../bd/conexionLocal.php');

class PDF extends FPDF
{
    var $widths;
    var $aligns;

    function SetWidths($w) { $this->widths = $w; }
    function SetAligns($a) { $this->aligns = $a; }

    function Row($data)
    {
        $nb = 0;
        for ($i = 0; $i < count($data); $i++) {
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        }
        $h = 5 * $nb;

        $this->CheckPageBreak($h);

        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';

            $x = $this->GetX();
            $y = $this->GetY();

            $this->Rect($x, $y, $w, $h);
            $this->MultiCell($w, 5, $data[$i], 0, $a, true);

            $this->SetXY($x + $w, $y);
        }
        $this->Ln($h);
    }

    function CheckPageBreak($h)
    {
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w, $txt)
    {
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }

function Header()
{
    // Logo
    $this->Image('../../img/icongps.png' , 30 ,8, 30 , 30,'PNG');

    // Fecha
    $this->SetFont('Arial', '', 10);
    $this->Cell(0, 10, 'Hoy: '.date('d-m-Y'), 0, 1, 'R');

    // Título
    $this->Ln(5);
    $this->SetFont('Arial', 'B', 14);
    $this->Cell(0, 8, 'REGISTRO DE ROLES', 0, 1, 'C');

    // Espacio antes de tabla
    $this->Ln(8);

    // Posiciona tabla debajo del logo
    $this->SetY(45);

    // Encabezados
    $this->SetFont('Arial','B',10);
    $this->SetFillColor(51, 122, 183);
    $this->SetTextColor(255,255,255);
    $this->SetAligns(['C', 'C', 'C','C']);
    $this->SetWidths(array(80,80,80,80));

    $this->Row(array('#','NOMBRE ROL','DESCRIPCION','ESTADO'));

    // Restablecer colores para el contenido
    $this->SetTextColor(0);
}


    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(130, 10, ' ', 0);
        $this->Cell(150, 10, 'Historial de Roles', 0, 0, 'L');
    }
}

$pdf = new PDF('L', 'mm', 'Legal');
$pdf->AddPage();
$pdf->SetMargins(10, 20, 20);

$campo = isset($_REQUEST["campo"]) ? $_REQUEST["campo"] : "";

$where = "";
if ($campo != "") {
    // FILTRAR POR NÚMERO DE BUS EN LUGAR DE "nombreHotel"
    $where = "WHERE persona.nombre1Persona LIKE '%$campo%'";
}

$query3 = mysqli_query($con,
    "SELECT * FROM roles $where
     ORDER BY roles.idRol ASC"
);

$i = 1;

while ($fila = mysqli_fetch_assoc($query3)) {

    //$estado = ($fila['estadoGps'] == 'A') ? 'Activo' : 'Inactivo';

    $pdf->SetFont('Arial', '', 10);
    $pdf->SetFillColor(255, 255, 255);
     $pdf->SetTextColor(0);
    $pdf->Row(array(
        $i,
        $fila['idRol'],
        $fila['nombreRol'],
        $fila['estadoRol'],        

    ));

    $i++;
}


$pdf->Output();
?>