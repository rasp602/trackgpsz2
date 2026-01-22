<?php
class Controles
{
	private $pdo;
    
    public $idControl;
    public $nombreControl;
    public $abreviacionControl;
    public $tipoControl;
    public $longitud1;
    public $longitud2;
    public $latitud1;
    public $latitud2;
    public $anguloEntrada;
    public $toleraciaEntrada;
    public $velMax;
    public $estadoControl;
    public $sentido;
    public $visible;



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

	public function ListarControles()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT * FROM controles ORDER BY idControl");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function Controles()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT count(*) AS cantidad FROM controles");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}


	public function Obtener($idControl)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT * FROM controles
        WHERE idControl = ?;");
			          
			$stm->execute(array($idControl));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

		public function ObtenerNombreControl($NombreControl)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT * FROM controles
        WHERE nombreControl = ?;");
			          
			$stm->execute(array($nombreControl));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}


	public function Registrar(Controles $data)
	{
		try 
		{


		$sql = "INSERT INTO controles (idControl,nombreControl, abreviacionControl, tipoControl,longitud1,longitud2,latitud1,latitud2,anguloEntrada,toleraciaEntrada,velMax,estadoControl,sentido,visible) 
		        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";	 	

		$this->pdo->prepare($sql)
		     ->execute(
				array(
				   $data->idControl = NULL,
				   $data->nombreControl,	
				   $data->abreviacionControl,
				   $data->tipoControl,
				   $data->longitud1,
				   $data->longitud2,
				   $data->latitud1,
				   $data->latitud2,
				   $data->anguloEntrada,
				   $data->toleraciaEntrada,
				   $data->velMax,
				   $data->estadoControl,
				   $data->sentido,
				   $data->visible

                )
			);		

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
		
	}



public function ActualizarControl($data)
	{
		try 
		{
			$sql = "UPDATE controles SET 
					  nombreControl = ?,
				    abreviacionControl = ?,
				    tipoControl = ?,
				    longitud1 = ?,
				    longitud2 = ?,
				    latitud1 = ?,
				    latitud2 = ?,
				    anguloEntrada = ?,
				    toleraciaEntrada = ?,
				    velMax = ?,
				    estadoControl = ?,
				    sentido = ?,
				    visible = ?



			       WHERE idControl = ?";


			$this->pdo->prepare($sql)
			     ->execute(
				    array(
                   $data->nombreControl,
                   $data->abreviacionControl,
                   $data->tipoControl,
                   $data->longitud1,
                   $data->longitud2,
                   $data->latitud1,
                   $data->latitud2,
                   $data->anguloEntrada,
                   $data->toleraciaEntrada,
                   $data->velMax,
                   $data->estadoControl,
                   $data->sentido,
                   $data->visible,
                   $data->idControl



					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}


	public function Eliminar($idControl)
	{
		try 
		{
			$stm = $this->pdo->prepare("DELETE FROM controles WHERE idControl = ?");			          

			$stm->execute(array($idControl));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

}



?>
