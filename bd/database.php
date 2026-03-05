<?php



class Database
{
    public static function Conectar()
    {
        try {

            $host = "srv1056.hstgr.io";
            $dbname = "u854084565_trackgpsz1";
            $user = "u854084565_Rodri24";
            $pass = "Rodrigo2410$";

            $pdo = new PDO("mysql:host=$host;port=3306;dbname=$dbname;charset=utf8", $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $pdo;

        } catch (PDOException $e) {

            die("Error de conexión: " . $e->getMessage());

        }
    }
}
?>