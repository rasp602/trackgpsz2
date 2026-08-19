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
                    d.imei AS idGps,
                    d.imei,
                    d.imei AS imeiGps,
                    d.simCard,
                    d.simCard AS simCardGps,
                    d.marca,
                    d.modelo,
                    d.descripcion,

                    r.idregistro AS ultimoIdRegistro,
                    r.accion AS ultimaAccion,
                    r.fecha AS ultimaFecha,
                    r.lat AS ultimaLatitud,
                    r.lon AS ultimaLongitud,
                    r.vel AS ultimaVelocidad,

                    bd.idBus,
                    b.numeroBus,
                    b.placaBus

                FROM dispositivos d

                LEFT JOIN registro r
                    ON r.idregistro = (
                        SELECT MAX(r2.idregistro)
                        FROM registro r2
                        WHERE r2.imei = d.imei
                    )

                LEFT JOIN bus_dispositivo bd
                    ON bd.imei = d.imei
                    AND bd.estado = 'ACTIVO'
                    AND bd.fechaFin IS NULL

                LEFT JOIN buses b
                    ON b.idBus = bd.idBus

                ORDER BY d.imei ASC
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
                    d.imei AS idGps,
                    d.imei,
                    d.imei AS imeiGps,
                    d.simCard,
                    d.simCard AS simCardGps,
                    d.marca,
                    d.modelo,
                    d.descripcion,

                    r.idregistro AS ultimoIdRegistro,
                    r.accion AS ultimaAccion,
                    r.fecha AS ultimaFecha,
                    r.lat AS ultimaLatitud,
                    r.lon AS ultimaLongitud,
                    r.vel AS ultimaVelocidad

                FROM dispositivos d

                LEFT JOIN registro r
                    ON r.idregistro = (
                        SELECT MAX(r2.idregistro)
                        FROM registro r2
                        WHERE r2.imei = d.imei
                    )

                WHERE d.imei = ?
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

    public function UltimoRegistro($imei)
    {
        try {
            $stm = $this->pdo->prepare("
                SELECT
                    idregistro,
                    imei,
                    accion,
                    fecha,
                    lat,
                    lon,
                    vel
                FROM registro
                WHERE imei = ?
                ORDER BY idregistro DESC
                LIMIT 1
            ");

            $stm->execute([$imei]);

            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function ListarRegistros($imei, $limite = 100)
    {
        try {
            $limite = intval($limite);

            if ($limite <= 0) {
                $limite = 100;
            }

            if ($limite > 500) {
                $limite = 500;
            }

            $stm = $this->pdo->prepare("
                SELECT
                    idregistro,
                    imei,
                    accion,
                    fecha,
                    lat,
                    lon,
                    vel
                FROM registro
                WHERE imei = ?
                ORDER BY idregistro DESC
                LIMIT " . $limite
            );

            $stm->execute([$imei]);

            return $stm->fetchAll(PDO::FETCH_OBJ);
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