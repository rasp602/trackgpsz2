<?php

try {

    $pdo = new PDO(
        "mysql:host=193.203.175.238;port=3306;dbname=u854084565_trackgpsz1;charset=utf8",
        "u854084565_Rodri24",
        "Rodrigo2410$"
    );

    echo "CONEXION OK";

} catch (PDOException $e) {

    echo "ERROR: " . $e->getMessage();

}