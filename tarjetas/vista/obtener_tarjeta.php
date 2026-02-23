<?php
// obtener_tarjeta.php
header('Content-Type: application/json');

// Configuración de la base de datos
$host = 'localhost';
$dbname = 'trackgpsz2';
$username = 'rasp602';
$password = 'Rodrigo2410$';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $idTarjeta = $_GET['idTarjeta'] ?? 0;
    
    $query = "SELECT 
        tarjeta.idTarjeta,
        tarjeta.fechaSalida,
        tarjeta.horaTarjeta,
        tarjeta.frecuenciaTarjeta,
        buses.numeroBus,
        buses.placaBus,
        variante.numeroVariante,
        variante.nombreVariante,
        persona.nombre1Persona,
        persona.apellido1Persona
    FROM tarjeta
    INNER JOIN buses ON tarjeta.idBus = buses.idBus
    INNER JOIN variante ON tarjeta.idVariante = variante.idVariante
    INNER JOIN persona ON tarjeta.idPersona = persona.idPersona
    WHERE tarjeta.idTarjeta = :idTarjeta";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute([':idTarjeta' => $idTarjeta]);
    $tarjeta = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Datos de ejemplo de la imagen (puntos de control)
    // En un caso real, estos vendrían de otra tabla
    $puntosControl = [
        ['hora' => '19:20', 'punto' => '*SALIDA*', 'simbolo' => ''],
        ['hora' => '19:21', 'punto' => 'KEFER', 'simbolo' => '$'],
        ['hora' => '19:23', 'punto' => 'PUENTE C.L', 'simbolo' => ''],
        ['hora' => '19:24', 'punto' => 'CALLE 3 N', 'simbolo' => ''],
        ['hora' => '19:28', 'punto' => 'COSTA LAGUNA', 'simbolo' => '$'],
        ['hora' => '19:31', 'punto' => 'COSTA L II', 'simbolo' => ''],
        ['hora' => '19:37', 'punto' => 'UNIMAR', 'simbolo' => ''],
        ['hora' => '19:4', 'punto' => 'PASAJE/CERDA', 'simbolo' => ''],
        ['hora' => '19:46', 'punto' => 'PÉREZ C./ S.NEVADA', 'simbolo' => '$'],
        ['hora' => '19:48', 'punto' => 'J.ORIONES', 'simbolo' => ''],
        ['hora' => '19:5', 'punto' => 'MARIA ELENA/HEROES', 'simbolo' => '$'],
        ['hora' => '19:55', 'punto' => 'J.BOLIVAR', 'simbolo' => '$'],
        ['hora' => '20:01', 'punto' => 'F.PRATT', 'simbolo' => '$'],
        ['hora' => '20:03', 'punto' => 'GRANDON2', 'simbolo' => ''],
        ['hora' => '20:11', 'punto' => 'EDDOS', 'simbolo' => '$'],
        ['hora' => '20:19', 'punto' => 'LA TORRE/PORRAS', 'simbolo' => '$ +2'],
        ['hora' => '20:25', 'punto' => 'ORELLA/MATTA', 'simbolo' => '$ +2'],
        ['hora' => '20:29', 'punto' => 'COPIAOP/ARGENTINA', 'simbolo' => '$ +2'],
        ['hora' => '20:36', 'punto' => 'PARQUE JAPONES', 'simbolo' => ''],
        ['hora' => '20:41', 'punto' => 'D`HALMAR', 'simbolo' => ''],
        ['hora' => '20:46', 'punto' => 'UNIMARC COVIEFI', 'simbolo' => '$ +3'],
        ['hora' => '20:49', 'punto' => 'STA.GUILLERMINA/MIN', 'simbolo' => ''],
        ['hora' => '20:5', 'punto' => 'KIOSKO ROJO', 'simbolo' => '']
    ];
    
    $response = [
        'success' => true,
        'tarjeta' => $tarjeta,
        'puntosControl' => $puntosControl
    ];
    
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>