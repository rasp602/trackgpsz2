<?php
$token = $_GET['token']; // Obtener el token de la consulta

// Verificar si el token es válido (reemplaza 'tu_token_secreto' con tu propio token)
if ($token !== '123456') {
    header('HTTP/1.1 401 Unauthorized');
    exit();
}

$servername = "localhost";
$username = "u410124118_rodrigo602";
$password = "Rodrigo2410$";
$dbname = "u410124118_trackgpsz";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consultar la tabla "bus"
$sql = "SELECT idBus, placaBus FROM buses";
$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Cerrar conexión
$conn->close();

// Convertir a JSON y enviar respuesta
header('Content-Type: application/json');
echo json_encode($data);
?>
