<?php



class Database
{
    public static function Conectar()
    {
        try {

            $host = "31.97.87.58";
            $dbname = "trackgpszulia";
            $user = "rasp1989";
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