<?php

try {

    $pdo = new PDO(
        "mysql:host=srv1056.hstgr.io;port=3306;dbname=u854084565_trackgpsz1;charset=utf8",
        "u854084565_Rodri24",
        "Rodrigo2410$"
    );

    echo "CONEXION OK";

} catch (PDOException $e) {

    echo "ERROR: " . $e->getMessage();

}