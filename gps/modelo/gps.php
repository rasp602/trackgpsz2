<?php
class Gps
{
	private $pdo;
    
    public $idGps;
    public $imeiGps;
    public $simCardGps;
    public $modelo;




  	public function __CONSTRUCT()
	{
		try
		{
			$this->pdo = DatabaseLocal::ConectarLocal();     
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}
	public function ListarGps()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT * FROM gps ORDER BY idGps");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function Gps()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT count(*) AS cantidad FROM idGps");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}


	public function Obtener($idGps)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT * FROM gps
        WHERE idGps = ?;");
			          
			$stm->execute(array($idGps));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

		public function ObtenerNumeroGps($imeiGps)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT * FROM gps
        WHERE imeiGps = ?;");
			          
			$stm->execute(array($imeiGps));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}


	public function Registrar(Gps $data)
	{
		try 
		{


		$sql = "INSERT INTO gps (idGps,imeiGps, simCardGps, modelo) 
		        VALUES (?,?,?,?)";	 	

		$this->pdo->prepare($sql)
		     ->execute(
				array(
				   $data->idGps = NULL,
				   $data->imeiGps,	
				   $data->simCardGps,
				   $data->modelo
                )
			);		

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
		
	}



public function ActualizarGps($data)
	{
		try 
		{
			$sql = "UPDATE gps SET 
					  imeiGps = ?,
				    simCardGps = ?,
				    modelo = ?

			       WHERE idGps = ?";


			$this->pdo->prepare($sql)
			     ->execute(
				    array(
                   $data->imeiGps,
                   $data->simCardGps,
                   $data->modelo,              
                   $data->idGps
                 


					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}


	public function Eliminar($idGps)
	{
		try 
		{
			$stm = $this->pdo->prepare("DELETE FROM gps WHERE idGps = ?");			          

			$stm->execute(array($idGps));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

}



?>
