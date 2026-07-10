<?php
class Gps
{
	private $pdo;

	public $idGps;
	public $imei;
	public $imeiGps;
	public $simCard;
	public $simCardGps;
	public $marca;
	public $modelo;
	public $descripcion;

	public function __CONSTRUCT()
	{
		try {
			$this->pdo = DatabaseLocal::ConectarLocal();
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}

	public function ListarGps()
	{
		try {
			$stm = $this->pdo->prepare("
				SELECT 
					imei AS idGps,
					imei,
					imei AS imeiGps,
					simCard,
					simCard AS simCardGps,
					marca,
					modelo,
					descripcion
				FROM dispositivos
				ORDER BY imei ASC
			");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}

	public function Gps()
	{
		try {
			$stm = $this->pdo->prepare("
				SELECT COUNT(*) AS cantidad 
				FROM dispositivos
			");
			$stm->execute();

			return $stm->fetchAll(PDO::FETCH_OBJ);
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}

	public function Obtener($imei)
	{
		try {
			$stm = $this->pdo->prepare("
				SELECT 
					imei AS idGps,
					imei,
					imei AS imeiGps,
					simCard,
					simCard AS simCardGps,
					marca,
					modelo,
					descripcion
				FROM dispositivos
				WHERE imei = ?
				LIMIT 1
			");

			$stm->execute([$imei]);
			return $stm->fetch(PDO::FETCH_OBJ);
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}

	public function ObtenerNumeroGps($imei)
	{
		try {
			$stm = $this->pdo->prepare("
				SELECT *
				FROM dispositivos
				WHERE imei = ?
				LIMIT 1
			");

			$stm->execute([$imei]);
			return $stm->fetch(PDO::FETCH_OBJ);
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}

	public function Registrar(Gps $data)
	{
		try {
			$sql = "
				INSERT INTO dispositivos 
				(
					imei,
					simCard,
					marca,
					modelo,
					descripcion
				)
				VALUES (?, ?, ?, ?, ?)
			";

			$this->pdo->prepare($sql)->execute([
				$data->imei,
				$data->simCard,
				$data->marca,
				$data->modelo,
				$data->descripcion
			]);
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}

	public function ActualizarGps($data)
	{
		try {
			$sql = "
				UPDATE dispositivos SET
					imei = ?,
					simCard = ?,
					marca = ?,
					modelo = ?,
					descripcion = ?
				WHERE imei = ?
			";

			$this->pdo->prepare($sql)->execute([
				$data->imei,
				$data->simCard,
				$data->marca,
				$data->modelo,
				$data->descripcion,
				$data->idGps
			]);
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}

	public function Eliminar($imei)
	{
		try {
			$stm = $this->pdo->prepare("
				DELETE FROM dispositivos 
				WHERE imei = ?
			");

			$stm->execute([$imei]);
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}
}
?>