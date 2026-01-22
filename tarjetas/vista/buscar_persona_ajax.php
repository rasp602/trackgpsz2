<?php
// simple conexion a la base de datos
function connect(){
    return new mysqli("srv1433.hstgr.io", "u410124118_raspgpsz2", "Rodrigo2410$", "u410124118_trackgpszulia2");
}


// Función para limpiar y preparar la cadena de búsqueda
function limpiarBusqueda($str)
{
    return mysqli_real_escape_string(connect(), $str);
}

// Obtener el nombre ingresado desde la solicitud AJAX
$nombre = limpiarBusqueda($_POST['nombre']);

// Consulta para buscar la persona por nombre y/o apellido
$consulta = "SELECT 
persona.idPersona, 
CONCAT(persona.nombre1Persona, ' ', persona.apellido1Persona) AS nombreCompleto, 
persona.cedulaPersona,
persona.estadoPersona,
persona.idRol
FROM 
persona
WHERE 
(persona.nombre1Persona LIKE '%$nombre%' OR 
CONCAT(persona.nombre1Persona, ' ',persona.apellido1Persona) LIKE '%$nombre%' OR  
persona.cedulaPersona LIKE '%$nombre%' OR  
persona.apellido1Persona LIKE '%$nombre%')
AND persona.estadoPersona = 'A' and persona.idRol = 1";

$resultado = mysqli_query(connect(), $consulta);
// Arreglo para almacenar los resultados
$resultadosArray = array();

while ($misdatos = mysqli_fetch_assoc($resultado)) {
    $resultadosArray[] = $misdatos;
}

// Verificar si no hay resultados
if (empty($resultadosArray)) {
    // Si no hay resultados, enviar el mensaje "Persona no existe"
    $mensaje = array("mensaje" => "Persona no existe");
    echo json_encode($mensaje);
} else {
    // Si hay resultados, enviar los resultados en formato JSON
    header('Content-Type: application/json');
    echo json_encode($resultadosArray);
}

?>
