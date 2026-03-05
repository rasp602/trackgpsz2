<?php



class Database
{
    public static function Conectar()
    {
        try {

            $host = "193.203.175.238";
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
/*
class Database
{
    public static function Conectar()
    {
        $pdo = new PDO('mysql:host=200.74.49.175;dbname=hoteleria;charset=utf8', 'hotel', 'chile2023$');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
        return $pdo;
    }
}*/



/*
class DB{
	var $conect;
  
	var $BaseDatos;
	var $Servidor;
	var $Usuario;
	var $Clave;
	function DB(){
		$this->BaseDatos = "hoteleria";
		$this->Servidor = "localhost";
		$this->Usuario = "root";
		$this->Clave = "";
	}

	 function conectar() {
		if(!($con=@mysql_connect($this->Servidor,$this->Usuario,$this->Clave))){
			echo"<h1> [:(] Error al conectar a la base de datos</h1>";	
			exit();
		}
		if (!@mysql_select_db($this->BaseDatos,$con)){
			echo "<h1> [:(] Error al seleccionar la base de datos</h1>";  
			exit();
		}
		$this->conect=$con;
		return true;	
	}
} */?>