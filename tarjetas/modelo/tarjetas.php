<?php
class Tarjetas
{
	private $pdo;
    
    public $idTarjeta;
    public $fechaSalida;
    public $horaTarjeta;
    public $idBus;
	public $idVariante;
	public $idPersona;
	public $frecuenciaTarjeta;
	public $busDelantero;
	public $busTrasero;
	public $idDetalleTarjeta;
	public $idControl;
	public $horaProgramada;
	public $horaMarcada;
	public $diferenciaMinutos;
	public $toleranciaAsignada;
	public $ValorPago;





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

	public function ListarTarjetas()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT * FROM tarjeta ORDER BY idTarjeta");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function ListarTarjetasNuevo()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT
tarjeta.idTarjeta,tarjeta.fechaSalida,tarjeta.horaTarjeta,tarjeta.idBus,tarjeta.idVariante,tarjeta.idPersona,tarjeta.frecuenciaTarjeta,
tarjeta.fechaGenerado,tarjeta.busDelantero,tarjeta.busTrasero,buses.idBus,buses.numeroBus,buses.placaBus,variante.idVariante,variante.numeroVariante,
variante.nombreVariante,persona.idPersona,persona.nombre1Persona,persona.apellido1Persona
FROM tarjeta
INNER JOIN buses ON tarjeta.idBus = buses.idBus
INNER JOIN variante ON tarjeta.idVariante = variante.idVariante
INNER JOIN persona ON tarjeta.idPersona = persona.idPersona
WHERE tarjeta.fechaSalida = CURDATE() ORDER BY variante.idVariante ASC, tarjeta.horaTarjeta DESC");

			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function Tarjetas()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT count(*) AS cantidad FROM tarjeta");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}


	public function ObteneridTarjeta($idTarjeta)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT * FROM tarjeta
        WHERE idTarjeta = ?;");
			          
			$stm->execute(array($idTarjeta));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
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
	public function ListarVariante()
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

	public function ListarConductor()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT * FROM persona where idRol = 1 ORDER BY idPersona");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function Obtener($idTarjeta)
	{
		try 
		{
	$stm = $this->pdo->prepare("SELECT * FROM tarjeta
        WHERE idTarjeta = ?;");
			          
			$stm->execute(array($idTarjeta));
			return $stm->fetch(PDO::FETCH_OBJ);

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function lafuncion()
	{
		
		 
		try 
		{
			$stm = $this->pdo->prepare("SELECT MAX(idTarjeta) as 'valor'  FROM tarjeta");

			     	$stm->execute();
			 return $stm->fetch(PDO::FETCH_BOTH);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
		 
	}

	public function laHora()
	{
		
		 
		try 
		{
			$stm = $this->pdo->prepare("SELECT MAX(horaTarjeta) as 'valor' FROM tarjeta");

			     	$stm->execute();
			 return $stm->fetch(PDO::FETCH_BOTH);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
		 
	}

	public function Registrar(Tarjetas $data)
	{
		try 
		{


		$sql = "INSERT INTO tarjeta (idTarjeta,fechaSalida, horaTarjeta, idBus,idVariante,idPersona,frecuenciaTarjeta,busDelantero,busTrasero) 
		        VALUES (?,?,?,?,?,?,?,?,?)";	 	

		$this->pdo->prepare($sql)
		     ->execute(
				array(
				   $data->idTarjeta = NULL,
				   $data->fechaSalida,	
				   $data->horaTarjeta,
				   $data->idBus,
				   $data->idVariante,
				   $data->idPersona,
				   $data->frecuenciaTarjeta,
				   $data->busDelantero,
				   $data->busTrasero,


                )
			);		

			  
			$dato=$this->lafuncion();
			$hora=$this->laHora();
			
	 	  	$tt= "INSERT INTO detalleTarjeta (idDetalleTarjeta,idTarjeta,idControl,horaProgramada,horaMarcada,diferenciaMinutos,toleranciaAsignada,
			valorPago) VALUES (?,'".$dato[0]."', ?, '".$hora[0]."', ?, ?, ?,?)";


			$this->pdo->prepare($tt)
		     ->execute(
				array(
				   $data->idDetalleTarjeta=Null,			  
				   $data->idControl = 1,
				   /*$data->horaProgramada = Null,	*/		   
				   $data->horaMarcada=Null,
				   $data->diferenciaMinutos=Null,
				   $data->toleranciaAsignada=Null,
				   $data->ValorPago=Null,
                          
                )
                );

				return $funcion; 

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
		
	}
public function ActualizarTarjeta($data)
	{
		try 
		{
			$sql = "UPDATE tarjeta SET 
				  	fechaSalida = ?,
				    horaTarjeta = ?,
				    idBus = ?,
					idVariante = ?,
					idPersona = ?,
					frecuenciaTarjeta = ?,
					busDelantero = ?,
                    busTraseroob = ?,
			       WHERE idTarjeta = ?";


			$this->pdo->prepare($sql)
			     ->execute(
				    array(
                   $data->fechaSalida,
                   $data->horaTarjeta,
                   $data->idBus,
                   $data->idVariante,
				   $data->idPersona,
				   $data->frecuenciaTarjeta,
				   $data->busDelantero,
				   $data->busTrasero,



					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}


	public function Eliminar($idTarjeta)
	{
		try 
		{
			$stm = $this->pdo->prepare("DELETE FROM tarjeta WHERE idTarjeta = ?");			          

			$stm->execute(array($idTarjeta));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}


	public function ObtenerUltimaFrecuencia() {
		try {
			$stmt = $this->pdo->prepare("
				SELECT frecuenciaTarjeta, horaTarjeta
				FROM tarjeta 
				ORDER BY idTarjeta DESC 
				LIMIT 1
			");
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
	
			if ($row) {
				return json_encode($row); // Devuelve frecuencia y hora en JSON
			} else {
				return json_encode(["frecuenciaTarjeta" => "0", "horaTarjeta" => "00:00:00"]); // Valores por defecto
			}
		} catch (Exception $e) {
			return json_encode(["frecuenciaTarjeta" => "0", "horaTarjeta" => "00:00:00"]); // En caso de error
		}
	}
	

}



?>
