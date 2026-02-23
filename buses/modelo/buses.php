<?php
class Buses
{
	private $pdo;
    
    public $idBus;
    public $numeroBus;
    public $placaBus;
    public $tipoBus;
    public $idPersona;
    public $estadoBus;
    public $validez;
    public $idGps;

	    public $idGrupo;


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

	public function ListarPropietarios()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT * FROM persona WHERE idRol = 2");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}
	public function ListarBuses()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT * FROM buses ORDER BY idBus");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
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

	public function Buses()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT count(*) AS cantidad FROM idBus");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}


	public function Obtener($idBus)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT * FROM buses
        WHERE idBus = ?;");
			          
			$stm->execute(array($idBus));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

		public function ObtenerNumeroBus($NumeroBus)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT * FROM buses
        WHERE numeroBus = ?;");
			          
			$stm->execute(array($numeroBus));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}


	public function Registrar(Buses $data)
	{
		try 
		{


		$sql = "INSERT INTO buses (idBus,numeroBus, placaBus, tipoBus,idPersona,estadoBus,validez,idGps,idGrupo) 
		        VALUES (?,?,?,?,?,?,?,?,?)";	 	

		$this->pdo->prepare($sql)
		     ->execute(
				array(
				   $data->idBus = NULL,
				   $data->numeroBus,	
				   $data->placaBus,
				   $data->tipoBus,
				   $data->idPersona,
				   $data->estadoBus,
				   $data->validez,
				   $data->idGps,
				   $data->idGrupo = 1

                )
			);		

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
		
	}



public function ActualizarBus($data)
	{
		try 
		{
			$sql = "UPDATE buses SET 
					numeroBus = ?,
				    placaBus = ?,
				    tipoBus = ?,
				    idPersona = ?,
				    estadoBus = ?,
				    validez = ?,
				    idGps = ?

			       WHERE idBus = ?";


			$this->pdo->prepare($sql)
			     ->execute(
				    array(
                   $data->numeroBus,
                   $data->placaBus,
                   $data->tipoBus,
                   $data->idPersona,
                   $data->estadoBus,
                   $data->validez,
                   $data->idGps,
                   $data->idBus


					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}


	public function Eliminar($idBus)
	{
		try 
		{
			$stm = $this->pdo->prepare("DELETE FROM buses WHERE idBus = ?");			          

			$stm->execute(array($idBus));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

}



?>
