<?php
$token = $_GET['token']; // Obtener el token de la consulta

// Verificar si el token es válido (reemplaza 'tu_token_secreto' con tu propio token)
if ($token !== 'VFEI7cA9acVLnXGhwpo006T6h5q7SFsep6x3') {
    header('HTTP/1.1 401 Unauthorized');
    exit();
}

$servername = "localhost";
$username = "u410124118_raspgpsz2";
$password = "Rodri2410$";
$dbname = "u410124118_trackgpszulia2";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$data = array("grupo" => array());

// Consultar la tabla "bus" y construir la estructura JSON
$sql = "SELECT buses.idBus, buses.placaBus,buses.idGps,buses.idGrupo,grupo.idGrupo,grupo.nombreGrupo, gps.imeiGps,gps.idGps FROM buses
INNER JOIN grupo ON buses.idGrupo = grupo.idGrupo
INNER JOIN gps ON buses.idGps = gps.idGps 
";
$result = $conn->query($sql);
$mapas="mapas";
if ($result->num_rows > 0) {
    $grupo_actual = null;
    while ($row = $result->fetch_assoc()) {
        $nombre_grupo = $row["nombreGrupo"];
        if ($nombre_grupo !== $grupo_actual) {
            $grupo_actual = $nombre_grupo;
            $data["grupo"][] = array(
                "nombre" => $nombre_grupo,
                "vehiculos" => array()
                
               
            );
        }

        // Agregar información del vehículo al grupo actual
        $data["grupo"][count($data["grupo"]) - 1]["vehiculos"][] = array(
            "idBus" => $row["idBus"],
            "placaBus" => $row["placaBus"],
            "imei" => $row["imeiGps"],

 
        );
    }

}

// Cerrar conexión
$conn->close();

// Convertir a JSON y enviar respuesta
header('Content-Type: application/json');
echo json_encode($data, JSON_PRETTY_PRINT);
?>
