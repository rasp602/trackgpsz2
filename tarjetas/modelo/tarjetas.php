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
variante.nombreVariante,variante.sentido,persona.idPersona,persona.nombre1Persona,persona.apellido1Persona
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
public function ObtenerControlesPorVariante($idVariante)
{
    try {

        $sql = "SELECT  
                    ruta.idRuta,
                    ruta.idVariante,
                    ruta.idControl,
                    ruta.minutos,
                    ruta.tolerancia,
                    controles.nombreControl
                FROM ruta 
                INNER JOIN controles 
                    ON ruta.idControl = controles.idControl
                WHERE ruta.idVariante = ?
                ORDER BY ruta.idRuta ASC"; // IMPORTANTE: orden definido

        $stm = $this->pdo->prepare($sql);
        $stm->execute([$idVariante]);

        return $stm->fetchAll(PDO::FETCH_OBJ);

    } catch (Exception $e) {
        die($e->getMessage());
    }
}

public function ExisteTarjetaold($fechaSalida, $horaTarjeta, $idBus, $idVariante)
{
    $sql = "SELECT COUNT(*) 
            FROM tarjeta
            WHERE fechaSalida = ?
              AND horaTarjeta = ?
              AND idBus = ?
              AND idVariante = ?";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([
        $fechaSalida,
        $horaTarjeta,
        $idBus,
        $idVariante
    ]);

    return $stmt->fetchColumn() > 0;
}

	public function Registrar(Tarjetas $data)
{
    try 
    {
        $this->pdo->beginTransaction();
		$sqlLock = "
    SELECT idTarjeta 
    FROM tarjeta
    WHERE fechaSalida = ?
      AND idBus = ?
      AND idVariante = ?
    ORDER BY idTarjeta DESC
    LIMIT 1
    FOR UPDATE
";

$stmtLock = $this->pdo->prepare($sqlLock);
$stmtLock->execute([
    $data->fechaSalida,
    $data->idBus,
    $data->idVariante
]);

		if ($this->ExisteTarjeta(
        $data->fechaSalida,
        $data->horaTarjeta,
        $data->idBus,
        $data->idVariante
    )) 
{
    throw new Exception("Ya existe una tarjeta registrada con esos datos.");
}
 // 🔹 1️⃣ Obtener bus anterior del mismo día y variante
        $stmtBusAnterior = $this->pdo->prepare("
            SELECT idBus
            FROM tarjeta
            WHERE fechaSalida = ?
              AND idVariante = ?
            ORDER BY idTarjeta DESC
            LIMIT 1
        ");

        $stmtBusAnterior->execute([
            $data->fechaSalida,
            $data->idVariante
        ]);

        $rowBusAnterior = $stmtBusAnterior->fetch(PDO::FETCH_ASSOC);

        if ($rowBusAnterior) {
            $busDelantero = $rowBusAnterior['idBus'];
        } else {
            $busDelantero = 0;
        }
        // 1️⃣ Insertar tarjeta
        $sql = "INSERT INTO tarjeta 
                (fechaSalida, horaTarjeta, idBus, idVariante, idPersona, frecuenciaTarjeta, busDelantero, busTrasero) 
                VALUES (?,?,?,?,?,?,?,?)";

        $this->pdo->prepare($sql)->execute([
            $data->fechaSalida,
            $data->horaTarjeta,
            $data->idBus,
            $data->idVariante,
            $data->idPersona,
            $data->frecuenciaTarjeta,
            $busDelantero,
            $data->busTrasero
        ]);

        $idTarjeta = $this->pdo->lastInsertId();

        // 2️⃣ Obtener controles
        $controles = $this->ObtenerControlesPorVariante($data->idVariante);

    // Hora base desde la tarjeta recién creada
$horaProgramada = new DateTime($data->horaTarjeta);

$sqlDetalle = "INSERT INTO detalleTarjeta
               (idTarjeta, idControl, horaProgramada, horaMarcada, diferenciaMinutos, toleranciaAsignada, valorPago)
               VALUES (?,?,?,?,?,?,?)";

$stmDetalle = $this->pdo->prepare($sqlDetalle);

foreach ($controles as $index => $control)
{
    if ($index > 0) {
        $horaProgramada->modify("+{$control->minutos} minutes");
    }

    $stmDetalle->execute([
        $idTarjeta,
        $control->idControl,
        $horaProgramada->format('H:i:s'),
        null,
        null,
        $control->tolerancia,
        null
    ]);
}

        $this->pdo->commit();

        return $idTarjeta;

    } 
catch (Exception $e) 
{
    $this->pdo->rollBack();
    return [
        'error' => true,
        'mensaje' => $e->getMessage()
    ];
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


	public function ObtenerUltimaFrecuenciaold() {
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

public function ObtenerUltimaFrecuencia($fecha, $idVariante) {
    try {

        $stmt = $this->pdo->prepare("
            SELECT frecuenciaTarjeta, horaTarjeta
            FROM tarjeta 
            WHERE fechaSalida = ?
              AND idVariante = ?
            ORDER BY idTarjeta DESC
            LIMIT 1
        ");

        $stmt->execute([$fecha, $idVariante]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return json_encode($row);
        } else {
            // No existe frecuencia ese día
            return json_encode([
                "frecuenciaTarjeta" => -1,
                "horaTarjeta" => null
            ]);
        }

    } catch (Exception $e) {
        return json_encode([
            "frecuenciaTarjeta" => -1,
            "horaTarjeta" => null
        ]);
    }
}

public function ObtenerPorId($idTarjeta)
{
    $stmt = $this->pdo->prepare("
        SELECT
            tarjeta.idTarjeta,
            tarjeta.fechaSalida,
            tarjeta.horaTarjeta,
            tarjeta.frecuenciaTarjeta,
            tarjeta.fechaGenerado,
            tarjeta.busDelantero,
            tarjeta.busTrasero,

            buses.numeroBus,
            buses.placaBus,

            variante.numeroVariante,
            variante.nombreVariante,

            persona.nombre1Persona,
            persona.apellido1Persona

        FROM tarjeta
        INNER JOIN buses ON tarjeta.idBus = buses.idBus
        INNER JOIN variante ON tarjeta.idVariante = variante.idVariante
        INNER JOIN persona ON tarjeta.idPersona = persona.idPersona
        WHERE tarjeta.idTarjeta = ?
    ");

    $stmt->execute([$idTarjeta]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function ObtenerDetalleTarjetaold($idTarjeta)
{
    $sql = "SELECT d.horaProgramada,
       d.horaMarcada,
       d.diferenciaMinutos,
       c.nombreControl
FROM detalletarjeta d
INNER JOIN controles c ON d.idControl = c.idControl
WHERE d.idTarjeta = ?
ORDER BY d.horaProgramada ASC
";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$idTarjeta]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function ObtenerDetalleTarjeta($idTarjeta)
{
    $sql = "
        SELECT 
            d.idTarjeta,
            d.horaProgramada,
            d.horaMarcada,
            d.diferenciaMinutos,
            c.nombreControl
        FROM detalletarjeta d
        INNER JOIN controles c ON d.idControl = c.idControl
        WHERE d.idTarjeta = :idTarjeta
        ORDER BY d.horaProgramada ASC
    ";

    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':idTarjeta', $idTarjeta, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function ListarTarjetasPorFecha($fecha)
{
    $sql = "SELECT t.idTarjeta,
                   t.fechaSalida,
                   t.horaTarjeta,
                   t.frecuenciaTarjeta,
                   b.placaBus,
                   b.numeroBus,
                   v.nombreVariante,
                   p.nombre1Persona,
                   p.apellido1Persona
            FROM tarjeta t
            INNER JOIN buses b ON t.idBus = b.idBus
            INNER JOIN variante v ON t.idVariante = v.idVariante
            INNER JOIN persona p ON t.idPersona = p.idPersona
            WHERE t.fechaSalida = ?
            ORDER BY t.horaTarjeta ASC";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$fecha]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
	
public function ExisteTarjeta($fechaSalida, $horaTarjeta,$idVariante)
{
    $sql = "SELECT 1
            FROM tarjeta
            WHERE fechaSalida = ?
              AND horaTarjeta = ?
              AND idVariante = ?
            LIMIT 1";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([
        $fechaSalida,
        $horaTarjeta,
        $idVariante
    ]);

    return $stmt->fetch() ? true : false;
}



}



?>
