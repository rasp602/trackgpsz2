<?php

require __DIR__ . '/ticket/autoload.php'; 
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

$idTarjeta = $_POST['idTarjeta']; 
$horaimpresion = date("H:i:s");
$idPersona = $_POST['idPersona'];
$idBus = $_POST['idBus'];
$fechaSalida = $_POST['fechaSalida'];
$idVariante = $_POST['idVariante'];
//$idVariante = 1;
$frecuenciaTarjeta = $_POST['frecuenciaTarjeta'];
$busDelantero = $_POST['busDelantero'];
$busTrasero = $_POST['busTrasero'];
$horaTarjeta = $_POST['horaTarjeta'];
$horanueva = date("H:i", strtotime($horaTarjeta . " +2 minute"));


require('bd/conexionLocal.php');
//$con = mysqli_connect('localhost','root','','hoteleria');
// Check connection
if (mysqli_connect_errno())
{
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
date_default_timezone_set("America/Santiago");


	  /*CONSULTA DE DATOS DE VARIANTE */
	  $consultaRUTA = mysqli_query($con, "SELECT  
	  ruta.idRuta,
	  ruta.idVariante,
	  ruta.idControl,
	  ruta.minutos,
	  ruta.tolerancia,
	  variante.idVariante,
	  variante.nombreVariante,
	  controles.nombreControl,
	  controles.idControl
	  FROM ruta 
	  INNER JOIN variante ON ruta.idVariante=variante.idVariante
       INNER JOIN controles ON ruta.idControl=controles.idControl
	  WHERE variante.idVariante ='".$idVariante."'");

$consultaVariante = mysqli_query($con, "SELECT  
    variante.idVariante,
    variante.nombreVariante,
    variante.numeroVariante
    FROM variante 
    WHERE variante.idVariante ='".$idVariante."'");

$rowcount1 = mysqli_num_rows($consultaVariante);
if ($row = mysqli_fetch_array($consultaVariante)) {
    $nombreVariante = $row['nombreVariante'];
    $numeroVariante = $row['numeroVariante'];
}

$consultaPersona = mysqli_query($con, "SELECT  
    persona.idPersona,
    persona.nombre1Persona,
    persona.apellido1Persona
    FROM persona 
    WHERE persona.idPersona ='".$idPersona."'");

$rowcount2 = mysqli_num_rows($consultaPersona);
if ($row1 = mysqli_fetch_array($consultaPersona)) {
    $nombrePersona = $row1['nombre1Persona'];
    $apellidoPersona = $row1['apellido1Persona'];
} else {
    $nombrePersona = "Desconocido";
    $apellidoPersona = "";
}

$consultaBus = mysqli_query($con, "SELECT  
    buses.idBus,
    buses.numeroBus,
    buses.placaBus
    FROM buses 
    WHERE buses.idBus ='".$idBus."'");

$rowcount3 = mysqli_num_rows($consultaBus);
if ($row2 = mysqli_fetch_array($consultaBus)) {
    $placaBus = $row2['placaBus'];
    $numeroBus = $row2['numeroBus'];
} else {
    $placaBus = "Desconocido";
    $numeroBus = "";
}
 
  $nombre_impresora = "Generica";
  $connector = new WindowsPrintConnector($nombre_impresora);
  $printer = new Printer($connector);
  
  $printer->setJustification(Printer::JUSTIFY_LEFT);
  $printer->setTextSize(1, 1); // Tamaño normal para todo el texto
  
  // Cargar logo (opcional, eliminar si no es necesario)
  try {
	  $logo1 = EscposImage::load("img/icongps.png", false);
	  $printer->bitImage($logo1);
  } catch (Exception $e) {}
  

// Si no se encuentra un número de variante, evitar errores
$nombreCompleto = trim("$nombrePersona $apellidoPersona"); // Evita espacios extra si no hay apellido

// Si no se encuentra un número de variante, evitar errores
$numeroVariante = isset($numeroVariante) ? "($numeroVariante)" : "";

$texto = "SERVICIO: $nombreVariante $numeroVariante\nBUS: $placaBus\nCONDUCTOR: $nombreCompleto\n";
$texto .= "Hora de Impresión: $horaimpresion\nFecha Salida: $fechaSalida\n";
$texto .= "Folio: $idTarjeta\nFrecuencia: $frecuenciaTarjeta\n";
$texto .= "Bus Delantero: $busDelantero\nBus Trasero: $busTrasero\n";
$texto .= "-----------------------------------------\n";
$texto .= "PUNTO DE CONTROL             HORA\n";
$texto .= "-----------------------------------------\n";

$printer->text($texto);

// Convertir $horaTarjeta a un timestamp inicial
$horaBase = strtotime($horaTarjeta);

// Encabezado alineado
$printer->text("-----------------------------------------\n");
$printer->text(sprintf("%-25s %10s\n", "PUNTO DE CONTROL", "HORA"));
$printer->text("-----------------------------------------\n");
$printer->setTextSize(2, 2); // Tamaño grande
// Loop para imprimir los datos alineados
while ($row = mysqli_fetch_array($consultaRUTA)) {
    if (is_numeric($row['minutos'])) {
        // Sumar los minutos a la hora base
        $horaCalculada = strtotime("+" . $row['minutos'] . " minutes", $horaBase);
        $horaFormateada = date("H:i", $horaCalculada);
        
        // Formato de impresión alineado
        $printer->text(sprintf("%-25s %10s\n", $row['nombreControl'], $horaFormateada));

        // Actualizar la hora base para la siguiente iteración
        $horaBase = $horaCalculada;
    } else {
        $printer->text(sprintf("%-25s %10s\n", $row['nombreControl'], "Error"));
    }
}
$printer->setTextSize(1, 1); // Tamaño grande
// Pie de ticket
$printer->text("-----------------------------------------\n");
$printer->setJustification(Printer::JUSTIFY_CENTER);
$printer->text("RaspSolutions.com\nFeliz viaje\n" . date("Y-m-d H:i:s") . "\n");

$printer->feed(2);
$printer->cut();
$printer->pulse();
$printer->close();
  ?>
  