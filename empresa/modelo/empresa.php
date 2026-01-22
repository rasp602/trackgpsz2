<?php
class Empresa
{
	private $pdo;
    
    public $idEmpresa;
    public $rutEmpresa;
    public $nombreEmpresa;
    public $ContratoEmpresa;
    public $contratoEmpresa1;
    public $horaSalida;


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

	public function ListarEmpresa()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT * FROM empresa ORDER BY idEmpresa");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function Empresa()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT count(*) AS cantidad FROM idEmpresa");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}


	public function Obtener($idEmpresa)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT * FROM empresa
        WHERE idEmpresa = ?;");
			          
			$stm->execute(array($idEmpresa));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

		public function ObtenerRutEmpresa($rutEmpresa)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT * FROM empresa
        WHERE rutEmpresa = ?;");
			          
			$stm->execute(array($rutEmpresa));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}


	public function Registrar(Empresa $data)
	{
		try 
		{


		$sql = "INSERT INTO empresa (idEmpresa,rutEmpresa, nombreEmpresa, ContratoEmpresa, contratoEmpresa1,horaSalida) 
		        VALUES (?, ?, ?,?, ?,?)";
	
	 	

		$this->pdo->prepare($sql)
		     ->execute(
				array(
				   $data->idEmpresa = NULL,
				   $data->rutEmpresa,	
				   $data->nombreEmpresa,
				   $data->ContratoEmpresa,
				   $data->contratoEmpresa1,
				   $data->horaSalida  
                )
			);
			

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
		
	}



public function ActualizarEmpresa($data)
	{
		try 
		{
			$sql = "UPDATE empresa SET 
					rutEmpresa = ?,
				    nombreEmpresa = ?,
				    ContratoEmpresa = ?,
				    contratoEmpresa1 = ?,
				    horaSalida = ?

			       WHERE idEmpresa = ?";


			$this->pdo->prepare($sql)
			     ->execute(
				    array(
                   $data->rutEmpresa,
                   $data->nombreEmpresa,
                   $data->ContratoEmpresa,
                   $data->contratoEmpresa1,
                   $data->horaSalida,
                   $data->idEmpresa

					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}


	public function Eliminar($idEmpresa)
	{
		try 
		{
			$stm = $this->pdo->prepare("DELETE FROM empresa WHERE idEmpresa = ?");			          

			$stm->execute(array($idEmpresa));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

}



?>
