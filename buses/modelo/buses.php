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
    public $idGrupo;

    public function __CONSTRUCT()
    {
        try {
            $this->pdo = DatabaseLocal::ConectarLocal();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function ListarPropietarios()
    {
        try {
            $stm = $this->pdo->prepare("
                SELECT
                    idPersona,
                    nombre1Persona,
                    apellido1Persona
                FROM persona
                WHERE idRol = 2
                ORDER BY nombre1Persona, apellido1Persona
            ");
            $stm->execute();

            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function ListarBuses()
    {
        try {
            $stm = $this->pdo->prepare("
                SELECT *
                FROM buses
                ORDER BY numeroBus
            ");
            $stm->execute();

            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function ListarGpsDisponibles($idBus = 0)
    {
        try {
            $sql = "
                SELECT
                    d.imei,
                    d.simCard,
                    d.marca,
                    d.modelo,
                    d.descripcion,
                    bd.idBus AS idBusActivo,
                    b.numeroBus AS numeroBusActivo
                FROM dispositivos d
                LEFT JOIN bus_dispositivo bd
                    ON bd.imei = d.imei
                    AND bd.estado = 'ACTIVO'
                    AND bd.fechaFin IS NULL
                LEFT JOIN buses b
                    ON b.idBus = bd.idBus
                WHERE bd.idBusDispositivo IS NULL
            ";

            $params = [];

            if (intval($idBus) > 0) {
                $sql .= " OR bd.idBus = ?";
                $params[] = intval($idBus);
            }

            $sql .= " ORDER BY d.descripcion, d.imei";

            $stm = $this->pdo->prepare($sql);
            $stm->execute($params);

            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function ObtenerGpsActivo($idBus)
    {
        try {
            $stm = $this->pdo->prepare("
                SELECT
                    bd.idBusDispositivo,
                    bd.idBus,
                    bd.imei,
                    bd.fechaInicio,
                    bd.fechaFin,
                    bd.estado,
                    bd.motivoCambio,
                    bd.observacion,
                    d.simCard,
                    d.marca,
                    d.modelo,
                    d.descripcion
                FROM bus_dispositivo bd
                INNER JOIN dispositivos d
                    ON d.imei = bd.imei
                WHERE bd.idBus = ?
                  AND bd.estado = 'ACTIVO'
                  AND bd.fechaFin IS NULL
                ORDER BY bd.fechaInicio DESC
                LIMIT 1
            ");
            $stm->execute([intval($idBus)]);

            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function HistorialGpsBus($idBus)
    {
        try {
            $stm = $this->pdo->prepare("
                SELECT
                    bd.idBusDispositivo,
                    bd.idBus,
                    bd.imei,
                    bd.fechaInicio,
                    bd.fechaFin,
                    bd.estado,
                    bd.motivoCambio,
                    bd.observacion,
                    bd.usuarioRegistro,
                    bd.fechaRegistro,
                    d.simCard,
                    d.marca,
                    d.modelo,
                    d.descripcion
                FROM bus_dispositivo bd
                INNER JOIN dispositivos d
                    ON d.imei = bd.imei
                WHERE bd.idBus = ?
                ORDER BY bd.fechaInicio DESC, bd.idBusDispositivo DESC
            ");
            $stm->execute([intval($idBus)]);

            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function Buses()
    {
        try {
            $stm = $this->pdo->prepare("
                SELECT COUNT(*) AS cantidad
                FROM buses
            ");
            $stm->execute();

            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function Obtener($idBus)
    {
        try {
            $stm = $this->pdo->prepare("
                SELECT *
                FROM buses
                WHERE idBus = ?
                LIMIT 1
            ");
            $stm->execute([intval($idBus)]);

            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function ObtenerNumeroBus($numeroBus, $idBusExcluir = 0)
    {
        try {
            $sql = "
                SELECT *
                FROM buses
                WHERE numeroBus = ?
            ";
            $params = [$numeroBus];

            if (intval($idBusExcluir) > 0) {
                $sql .= " AND idBus <> ?";
                $params[] = intval($idBusExcluir);
            }

            $sql .= " LIMIT 1";

            $stm = $this->pdo->prepare($sql);
            $stm->execute($params);

            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function Registrar(Buses $data)
    {
        try {
            $sql = "
                INSERT INTO buses
                (
                    numeroBus,
                    placaBus,
                    tipoBus,
                    idPersona,
                    estadoBus,
                    validez,
                    idGrupo
                )
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ";

            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $data->numeroBus,
                $data->placaBus,
                $data->tipoBus,
                $data->idPersona,
                $data->estadoBus,
                $data->validez,
                $data->idGrupo
            ]);

            return intval($this->pdo->lastInsertId());
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function ActualizarBus(Buses $data)
    {
        try {
            $sql = "
                UPDATE buses SET
                    numeroBus = ?,
                    placaBus = ?,
                    tipoBus = ?,
                    idPersona = ?,
                    estadoBus = ?,
                    validez = ?
                WHERE idBus = ?
            ";

            $this->pdo->prepare($sql)->execute([
                $data->numeroBus,
                $data->placaBus,
                $data->tipoBus,
                $data->idPersona,
                $data->estadoBus,
                $data->validez,
                $data->idBus
            ]);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function AsignarGps(
        $idBus,
        $imei,
        $fechaInicio,
        $motivoCambio,
        $observacion,
        $usuarioRegistro
    ) {
        try {
            $this->pdo->beginTransaction();

            $stmBus = $this->pdo->prepare("
                SELECT idBus
                FROM buses
                WHERE idBus = ?
                FOR UPDATE
            ");
            $stmBus->execute([intval($idBus)]);

            if (!$stmBus->fetch(PDO::FETCH_OBJ)) {
                throw new Exception('El bus indicado no existe.');
            }

            $stmGps = $this->pdo->prepare("
                SELECT imei
                FROM dispositivos
                WHERE imei = ?
                FOR UPDATE
            ");
            $stmGps->execute([$imei]);

            if (!$stmGps->fetch(PDO::FETCH_OBJ)) {
                throw new Exception('El dispositivo GPS indicado no existe.');
            }

            $stmActivoImei = $this->pdo->prepare("
                SELECT idBusDispositivo, idBus
                FROM bus_dispositivo
                WHERE imei = ?
                  AND estado = 'ACTIVO'
                  AND fechaFin IS NULL
                FOR UPDATE
            ");
            $stmActivoImei->execute([$imei]);
            $gpsActivo = $stmActivoImei->fetch(PDO::FETCH_OBJ);

            if ($gpsActivo && intval($gpsActivo->idBus) !== intval($idBus)) {
                throw new Exception('Este GPS ya está activo en otro bus.');
            }

            $stmActivoBus = $this->pdo->prepare("
                SELECT idBusDispositivo, imei
                FROM bus_dispositivo
                WHERE idBus = ?
                  AND estado = 'ACTIVO'
                  AND fechaFin IS NULL
                FOR UPDATE
            ");
            $stmActivoBus->execute([intval($idBus)]);
            $busActivo = $stmActivoBus->fetch(PDO::FETCH_OBJ);

            if ($busActivo && $busActivo->imei === $imei) {
                throw new Exception('Este GPS ya está asignado y activo en este bus.');
            }

            if ($busActivo) {
                $cerrar = $this->pdo->prepare("
                    UPDATE bus_dispositivo
                    SET
                        estado = 'INACTIVO',
                        fechaFin = ?,
                        motivoCambio = CASE
                            WHEN motivoCambio IS NULL OR motivoCambio = ''
                                THEN 'REEMPLAZO DE EQUIPO'
                            ELSE motivoCambio
                        END
                    WHERE idBusDispositivo = ?
                ");
                $cerrar->execute([
                    $fechaInicio,
                    intval($busActivo->idBusDispositivo)
                ]);
            }

            $insert = $this->pdo->prepare("
                INSERT INTO bus_dispositivo
                (
                    idBus,
                    imei,
                    fechaInicio,
                    fechaFin,
                    estado,
                    motivoCambio,
                    observacion,
                    usuarioRegistro
                )
                VALUES (?, ?, ?, NULL, 'ACTIVO', ?, ?, ?)
            ");
            $insert->execute([
                intval($idBus),
                $imei,
                $fechaInicio,
                $motivoCambio,
                $observacion,
                $usuarioRegistro
            ]);

            $this->pdo->commit();

            return intval($this->pdo->lastInsertId());
        } catch (Exception $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }

            throw $e;
        }
    }

    public function RetirarGps(
        $idBusDispositivo,
        $idBus,
        $fechaFin,
        $motivoCambio,
        $observacion
    ) {
        try {
            $this->pdo->beginTransaction();

            $stm = $this->pdo->prepare("
                SELECT idBusDispositivo
                FROM bus_dispositivo
                WHERE idBusDispositivo = ?
                  AND idBus = ?
                  AND estado = 'ACTIVO'
                  AND fechaFin IS NULL
                FOR UPDATE
            ");
            $stm->execute([
                intval($idBusDispositivo),
                intval($idBus)
            ]);

            if (!$stm->fetch(PDO::FETCH_OBJ)) {
                throw new Exception('La asignación activa no existe o ya fue retirada.');
            }

            $update = $this->pdo->prepare("
                UPDATE bus_dispositivo
                SET
                    estado = 'INACTIVO',
                    fechaFin = ?,
                    motivoCambio = ?,
                    observacion = CASE
                        WHEN ? = '' THEN observacion
                        ELSE ?
                    END
                WHERE idBusDispositivo = ?
            ");
            $update->execute([
                $fechaFin,
                $motivoCambio,
                $observacion,
                $observacion,
                intval($idBusDispositivo)
            ]);

            $this->pdo->commit();
        } catch (Exception $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }

            throw $e;
        }
    }

    public function Eliminar($idBus)
    {
        try {
            $stmHistorial = $this->pdo->prepare("
                SELECT COUNT(*) AS cantidad
                FROM bus_dispositivo
                WHERE idBus = ?
            ");
            $stmHistorial->execute([intval($idBus)]);
            $historial = $stmHistorial->fetch(PDO::FETCH_OBJ);

            if ($historial && intval($historial->cantidad) > 0) {
                throw new Exception(
                    'No se puede eliminar el bus porque posee historial de dispositivos GPS. Márquelo como inactivo.'
                );
            }

            $stm = $this->pdo->prepare("
                DELETE FROM buses
                WHERE idBus = ?
            ");
            $stm->execute([intval($idBus)]);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
?>
