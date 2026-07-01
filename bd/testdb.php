<?php

try {

    $pdo = new PDO(
        "mysql:host=127.0.0.1;port=3306;dbname=trackgpszulia;charset=utf8",
        "trackgps_rasp1989",
        "Rodrigo2410$"
    );

    echo "CONEXION OK";

} catch (PDOException $e) {

    echo "ERROR: " . $e->getMessage();

}