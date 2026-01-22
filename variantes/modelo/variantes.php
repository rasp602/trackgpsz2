<?php
class Variantes
{
	private $pdo;
    
    public $idVariante;
    public $nombreVariante;
    public $numeroVariante;
    public $estadoVariante;
    public $frecMax;
    public $frecMin;
    public $frecNormal;
    public $mediaVuelta;
    public $proximaVariante;
    public $primeraSalida;
    public $colorVariante;



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

	public function ListarVariantes()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT * FROM variante ORDER BY idVariante");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function Variantes()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT count(*) AS cantidad FROM variante");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}


	public function Obtener($idVariante)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT * FROM variante
        WHERE idVariante = ?;");
			          
			$stm->execute(array($idVariante));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

		public function ObtenerNumeroVariante($NumeroVariante)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT * FROM variante
        WHERE numeroVariante = ?;");
			          
			$stm->execute(array($numeroVariante));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}


	public function Registrar(Variantes $data)
	{
		try 
		{


		$sql = "INSERT INTO variante (idVariante,nombreVariante, numeroVariante, estadoVariante,frecMax,frecMin,frecNormal,mediaVuelta,proximaVariante,primeraSalida,colorVariante) 
		        VALUES (?,?,?,?,?,?,?,?,?,?,?)";	 	

		$this->pdo->prepare($sql)
		     ->execute(
				array(
				   $data->idVariante = NULL,
				   $data->nombreVariante,	
				   $data->numeroVariante,
				   $data->estadoVariante,
				   $data->frecMax,
				   $data->frecMin,
				   $data->frecNormal,
				   $data->mediaVuelta,
				   $data->proximaVariante,
				   $data->primeraSalida,
				   $data->colorVariante
                )
			);		

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
		
	}



public function ActualizarVariante($data)
	{
		try 
		{
			$sql = "UPDATE variante SET 
					  nombreVariante = ?,
				    numeroVariante = ?,
				    estadoVariante = ?,
				    frecMax = ?,
				    frecMin = ?,
				    frecNormal = ?,
				    mediaVuelta = ?,
				    proximaVariante = ?,
				    primeraSalida = ?,
				    colorVariante = ?


			       WHERE idVariante = ?";


			$this->pdo->prepare($sql)
			     ->execute(
				    array(
                   $data->nombreVariante,
                   $data->numeroVariante,
                   $data->estadoVariante,
                   $data->frecMax,
                   $data->frecMin,
                   $data->frecNormal,
                   $data->mediaVuelta,
                   $data->proximaVariante,
                   $data->primeraSalida,
                   $data->colorVariante,
                   $data->idVariante


					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}


	public function Eliminar($idVariante)
	{
		try 
		{
			$stm = $this->pdo->prepare("DELETE FROM variante WHERE idVariante = ?");			          

			$stm->execute(array($idVariante));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

}



?>
