<?php
class Rutas
{
	private $pdo;
    
    public $idRuta;
    public $idVariante;
    public $idControl;
    public $minutos;
	public $tolerancia;
	public $tipoDias;
	public $horaDesde;
	public $horaHasta;
	public $idTablaValores;




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

	public function ListarRutas()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT * FROM ruta ORDER BY idRuta");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function Rutas()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT count(*) AS cantidad FROM ruta");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}


	public function Obtener($idRuta)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT * FROM ruta
        WHERE idRuta = ?;");
			          
			$stm->execute(array($idRuta));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

		public function ObteneridControl($idControl)
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


	public function Registrar(Rutas $data)
	{
		try 
		{


		$sql = "INSERT INTO ruta (idRuta,idVariante, idControl, minutos,tolerancia,tipoDias,horaDesde,horaHasta,idTablaValores) 
		        VALUES (?,?,?,?,?,?,?,?,?)";	 	

		$this->pdo->prepare($sql)
		     ->execute(
				array(
				   $data->idRuta = NULL,
				   $data->idVariante,	
				   $data->idControl,
				   $data->minutos,
				   $data->tolerancia,
				   $data->tipoDias,
				   $data->horaDesde,
				   $data->horaHasta,
				   $data->idTablaValores


                )
			);		

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
		
	}
public function ActualizarRol($data)
	{
		try 
		{
			$sql = "UPDATE ruta SET 
				  	idVariante = ?,
				    idControl = ?,
				    minutos = ?,
					tolerancia = ?,
					tipoDias = ?,
					horaDesde = ?,
					horaHasta = ?,
                    idTablaValores = ?,
			       WHERE idRuta = ?";


			$this->pdo->prepare($sql)
			     ->execute(
				    array(
                   $data->idVariante,
                   $data->idControl,
                   $data->minutos,
                   $data->tolerancia,
				   $data->tipoDias,
				   $data->horaDesde,
				   $data->horaHasta,
				   $data->idTablaValores,



					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}


	public function Eliminar($idRuta)
	{
		try 
		{
			$stm = $this->pdo->prepare("DELETE FROM ruta WHERE idRuta = ?");			          

			$stm->execute(array($idBus));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

}



?>
