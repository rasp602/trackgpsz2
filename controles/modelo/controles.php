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

public function ObtenerNombreControl($nombreControl)
{
    try {
        $stm = $this->pdo->prepare("
            SELECT * FROM controles
            WHERE nombreControl = ?
        ");

        $stm->execute([$nombreControl]);
        return $stm->fetch(PDO::FETCH_OBJ);

    } catch (Exception $e) {
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

	public function ObtenerGeocerca($idControl)
{
    try {
        $sql = "SELECT idGeocerca, idControl, orden, latitud, longitud
                FROM control_geocerca
                WHERE idControl = ?
                ORDER BY orden ASC";

        $stm = $this->pdo->prepare($sql);
        $stm->execute([$idControl]);

        return $stm->fetchAll(PDO::FETCH_OBJ);
    } catch (Exception $e) {
        die($e->getMessage());
    }
}

public function GuardarGeocerca($idControl, $puntos)
{
    try {
        $this->pdo->beginTransaction();

        $delete = $this->pdo->prepare("DELETE FROM control_geocerca WHERE idControl = ?");
        $delete->execute([$idControl]);

        $insert = $this->pdo->prepare("
            INSERT INTO control_geocerca
            (idControl, orden, latitud, longitud)
            VALUES (?, ?, ?, ?)
        ");

        $orden = 1;

        foreach ($puntos as $punto) {
            $lat = isset($punto['lat']) ? $punto['lat'] : null;
            $lng = isset($punto['lng']) ? $punto['lng'] : null;

            if ($lat === null || $lng === null) {
                continue;
            }

            $insert->execute([
                $idControl,
                $orden,
                $lat,
                $lng
            ]);

            $orden++;
        }

        $this->pdo->commit();

        return true;
    } catch (Exception $e) {
        $this->pdo->rollBack();
        throw $e;
    }
}

public function ListarGeocercas()
{
    try {
        $sql = "
            SELECT 
                c.idControl,
                c.nombreControl,
                c.abreviacionControl,
                c.tipoControl,
                c.sentido,
                c.velMax,
                c.estadoControl,
                c.visible,
                g.orden,
                g.latitud,
                g.longitud
            FROM controles c
            INNER JOIN control_geocerca g ON c.idControl = g.idControl
            WHERE c.estadoControl = 'A'
            ORDER BY c.idControl ASC, g.orden ASC
        ";

        $stm = $this->pdo->prepare($sql);
        $stm->execute();

        $rows = $stm->fetchAll(PDO::FETCH_OBJ);

        $controles = [];

        foreach ($rows as $row) {
            $id = $row->idControl;

            if (!isset($controles[$id])) {
                $controles[$id] = [
                    'idControl' => (int)$row->idControl,
                    'nombreControl' => $row->nombreControl,
                    'abreviacionControl' => $row->abreviacionControl,
                    'tipoControl' => $row->tipoControl,
                    'sentido' => $row->sentido,
                    'velMax' => (float)$row->velMax,
                    'estadoControl' => $row->estadoControl,
                    'visible' => (int)$row->visible,
                    'color' => $row->sentido === 'R' ? '#dc2626' : '#2563eb',
                    'coordinates' => []
                ];
            }

            $controles[$id]['coordinates'][] = [
                (float)$row->latitud,
                (float)$row->longitud
            ];
        }

        return array_values($controles);

    } catch (Exception $e) {
        die($e->getMessage());
    }
}

}



?>
