<?php

try {

    $pdo = new PDO(
        "mysql:host=31.97.87.58;port=3306;dbname=trackgpszulia;charset=utf8",
        "rasp1989",
        "Rodrigo2410$"
    );

    echo "CONEXION OK";

} catch (PDOException $e) {

    echo "ERROR: " . $e->getMessage();

}