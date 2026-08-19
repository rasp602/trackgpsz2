<?php
require '../../bd/config.php';

header('Content-Type: application/json; charset=utf-8');

$accion = isset($_POST['accion'])
    ? trim($_POST['accion'])
    : 'listar';

/*
 * =========================================================
 * HISTORIAL DE REGISTROS DE UN GPS
 * =========================================================
 */
if ($accion === 'registros') {
    $imei = isset($_POST['imei'])
        ? trim($_POST['imei'])
        : '';

    $limite = isset($_POST['limite'])
        ? intval($_POST['limite'])
        : 100;

    if ($imei === '') {
        echo json_encode([
            'success' => false,
            'error' => 'Debe indicar un IMEI.'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if (!preg_match('/^[0-9]{10,30}$/', $imei)) {
        echo json_encode([
            'success' => false,
            'error' => 'IMEI inválido.'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if ($limite <= 0) {
        $limite = 100;
    }

    if ($limite > 500) {
        $limite = 500;
    }

    $sqlTotal = "
        SELECT COUNT(*) AS total
        FROM registro
        WHERE imei = ?
    ";

    $stmtTotal = $conn->prepare($sqlTotal);

    if (!$stmtTotal) {
        echo json_encode([
            'success' => false,
            'error' => $conn->error
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $stmtTotal->bind_param('s', $imei);
    $stmtTotal->execute();

    $resultadoTotal = $stmtTotal->get_result();
    $filaTotal = $resultadoTotal->fetch_assoc();

    $totalRegistros = intval($filaTotal['total'] ?? 0);

    $sql = "
        SELECT
            idregistro,
            imei,
            accion,
            fecha,
            lat,
            lon,
            COALESCE(vel, 0) AS vel
        FROM registro
        WHERE imei = ?
        ORDER BY idregistro DESC
        LIMIT $limite
    ";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo json_encode([
            'success' => false,
            'error' => $conn->error
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $stmt->bind_param('s', $imei);
    $stmt->execute();

    $resultado = $stmt->get_result();

    $html = '';

    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $idregistro = intval($row['idregistro']);

            $fecha = htmlspecialchars(
                $row['fecha'] ?? '',
                ENT_QUOTES,
                'UTF-8'
            );

            $accionGps = htmlspecialchars(
                $row['accion'] ?? '',
                ENT_QUOTES,
                'UTF-8'
            );

            $lat = htmlspecialchars(
                $row['lat'] ?? '',
                ENT_QUOTES,
                'UTF-8'
            );

            $lon = htmlspecialchars(
                $row['lon'] ?? '',
                ENT_QUOTES,
                'UTF-8'
            );

            $vel = is_numeric($row['vel'])
                ? number_format((float)$row['vel'], 2, '.', '')
                : '0.00';

            $mapa = '';

            if (
                is_numeric($row['lat']) &&
                is_numeric($row['lon'])
            ) {
                $urlMapa =
                    'https://www.google.com/maps?q=' .
                    rawurlencode($row['lat'] . ',' . $row['lon']);

                $mapa =
                    '<a href="' .
                    htmlspecialchars($urlMapa, ENT_QUOTES, 'UTF-8') .
                    '" target="_blank" rel="noopener noreferrer">' .
                    'Ver mapa' .
                    '</a>';
            }

            $html .= '<tr>';
            $html .= '<td>' . $idregistro . '</td>';
            $html .= '<td>' . $fecha . '</td>';
            $html .= '<td>' . $accionGps . '</td>';
            $html .= '<td>' . $lat . '</td>';
            $html .= '<td>' . $lon . '</td>';
            $html .= '<td>' . $vel . '</td>';
            $html .= '<td>' . $mapa . '</td>';
            $html .= '</tr>';
        }
    } else {
        $html =
            '<tr>' .
            '<td colspan="7" class="gps-sin-registro">' .
            'Este dispositivo todavía no tiene registros GPS.' .
            '</td>' .
            '</tr>';
    }

    echo json_encode([
        'success' => true,
        'imei' => $imei,
        'totalRegistros' => $totalRegistros,
        'mostrados' => $resultado->num_rows,
        'data' => $html
    ], JSON_UNESCAPED_UNICODE);

    exit;
}

/*
 * =========================================================
 * LISTADO DE DISPOSITIVOS + ÚLTIMA POSICIÓN GPS
 * =========================================================
 */

$columns = [
    'd.imei',
    'd.simCard',
    'd.marca',
    'd.modelo',
    'd.descripcion'
];

$campo = isset($_POST['campo'])
    ? trim($_POST['campo'])
    : '';

$limit = isset($_POST['registros'])
    ? intval($_POST['registros'])
    : 10;

$pagina = isset($_POST['pagina'])
    ? intval($_POST['pagina'])
    : 1;

if ($limit <= 0) {
    $limit = 10;
}

if ($limit > 100) {
    $limit = 100;
}

if ($pagina <= 0) {
    $pagina = 1;
}

$inicio = ($pagina - 1) * $limit;

$orderCol = isset($_POST['orderCol'])
    ? intval($_POST['orderCol'])
    : 0;

$orderType = isset($_POST['orderType'])
    ? strtolower($_POST['orderType'])
    : 'asc';

if (!isset($columns[$orderCol])) {
    $orderCol = 0;
}

if ($orderType !== 'asc' && $orderType !== 'desc') {
    $orderType = 'asc';
}

$orderSql = $columns[$orderCol] . ' ' . strtoupper($orderType);

$whereSql = '';
$parametros = [];
$tipos = '';

if ($campo !== '') {
    $whereSql = "
        WHERE (
            d.imei LIKE ?
            OR COALESCE(d.simCard, '') LIKE ?
            OR COALESCE(d.marca, '') LIKE ?
            OR COALESCE(d.modelo, '') LIKE ?
            OR COALESCE(d.descripcion, '') LIKE ?
            OR CAST(COALESCE(b.numeroBus, '') AS CHAR) LIKE ?
            OR COALESCE(b.placaBus, '') LIKE ?
        )
    ";

    $buscar = '%' . $campo . '%';

    for ($i = 0; $i < 7; $i++) {
        $parametros[] = $buscar;
        $tipos .= 's';
    }
}

/*
 * La tabla registro ya tiene el índice:
 * idx_registro_imei_idregistro (imei, idregistro)
 * por lo tanto esta búsqueda de MAX(idregistro) por IMEI es rápida.
 */
$sqlBase = "
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

    $whereSql
";

$sqlConteoFiltro = "
    SELECT COUNT(DISTINCT d.imei) AS total
    $sqlBase
";

$stmtConteoFiltro = $conn->prepare($sqlConteoFiltro);

if (!$stmtConteoFiltro) {
    echo json_encode([
        'totalRegistros' => 0,
        'totalFiltro' => 0,
        'totalConRegistro' => 0,
        'totalSinRegistro' => 0,
        'data' => '<tr><td colspan="10">Error SQL: ' .
            htmlspecialchars($conn->error, ENT_QUOTES, 'UTF-8') .
            '</td></tr>',
        'paginacion' => ''
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

if ($tipos !== '') {
    $stmtConteoFiltro->bind_param($tipos, ...$parametros);
}

$stmtConteoFiltro->execute();

$resConteoFiltro = $stmtConteoFiltro->get_result();
$filaConteoFiltro = $resConteoFiltro->fetch_assoc();

$totalFiltro = intval($filaConteoFiltro['total'] ?? 0);

$sql = "
    SELECT
        d.imei,
        d.simCard,
        d.marca,
        d.modelo,
        d.descripcion,

        r.idregistro AS ultimoIdRegistro,
        r.fecha AS ultimaFecha,
        r.lat AS ultimaLatitud,
        r.lon AS ultimaLongitud,
        COALESCE(r.vel, 0) AS ultimaVelocidad,
        r.accion AS ultimaAccion,

        bd.idBus,
        b.numeroBus,
        b.placaBus

    $sqlBase

    ORDER BY $orderSql
    LIMIT $inicio, $limit
";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode([
        'totalRegistros' => 0,
        'totalFiltro' => 0,
        'totalConRegistro' => 0,
        'totalSinRegistro' => 0,
        'data' => '<tr><td colspan="10">Error SQL: ' .
            htmlspecialchars($conn->error, ENT_QUOTES, 'UTF-8') .
            '</td></tr>',
        'paginacion' => ''
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

if ($tipos !== '') {
    $stmt->bind_param($tipos, ...$parametros);
}

$stmt->execute();

$resultado = $stmt->get_result();

$resTotal = $conn->query("
    SELECT
        COUNT(*) AS total,
        SUM(
            CASE
                WHEN EXISTS (
                    SELECT 1
                    FROM registro r
                    WHERE r.imei = d.imei
                    LIMIT 1
                )
                THEN 1
                ELSE 0
            END
        ) AS conRegistro
    FROM dispositivos d
");

$filaTotal = $resTotal
    ? $resTotal->fetch_assoc()
    : ['total' => 0, 'conRegistro' => 0];

$totalRegistros = intval($filaTotal['total'] ?? 0);
$totalConRegistro = intval($filaTotal['conRegistro'] ?? 0);
$totalSinRegistro = max(
    0,
    $totalRegistros - $totalConRegistro
);

$output = [
    'totalRegistros' => $totalRegistros,
    'totalFiltro' => $totalFiltro,
    'totalConRegistro' => $totalConRegistro,
    'totalSinRegistro' => $totalSinRegistro,
    'data' => '',
    'paginacion' => ''
];

if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $imeiRaw = $row['imei'];

        $imei = htmlspecialchars(
            $imeiRaw,
            ENT_QUOTES,
            'UTF-8'
        );

        $simCard = htmlspecialchars(
            $row['simCard'] ?? '',
            ENT_QUOTES,
            'UTF-8'
        );

        $marca = htmlspecialchars(
            $row['marca'] ?? '',
            ENT_QUOTES,
            'UTF-8'
        );

        $modelo = htmlspecialchars(
            $row['modelo'] ?? '',
            ENT_QUOTES,
            'UTF-8'
        );

        $descripcionRaw = $row['descripcion'] ?? '';

        $descripcion = htmlspecialchars(
            $descripcionRaw,
            ENT_QUOTES,
            'UTF-8'
        );

        $urlImei = urlencode($imeiRaw);

        $bus = 'Sin asignar';

        if (!empty($row['numeroBus'])) {
            $bus =
                'Bus ' .
                htmlspecialchars(
                    $row['numeroBus'],
                    ENT_QUOTES,
                    'UTF-8'
                );

            if (!empty($row['placaBus'])) {
                $bus .= '<br><small>' .
                    htmlspecialchars(
                        $row['placaBus'],
                        ENT_QUOTES,
                        'UTF-8'
                    ) .
                    '</small>';
            }
        }

        $ultimaFecha = $row['ultimaFecha']
            ? htmlspecialchars(
                $row['ultimaFecha'],
                ENT_QUOTES,
                'UTF-8'
            )
            : '<span class="gps-sin-registro">Sin registros</span>';

        $posicion = '<span class="gps-sin-registro">Sin posición</span>';

        if (
            $row['ultimaLatitud'] !== null &&
            $row['ultimaLongitud'] !== null
        ) {
            $lat = htmlspecialchars(
                $row['ultimaLatitud'],
                ENT_QUOTES,
                'UTF-8'
            );

            $lon = htmlspecialchars(
                $row['ultimaLongitud'],
                ENT_QUOTES,
                'UTF-8'
            );

            $posicion =
                '<div class="gps-coordenada">' .
                '<strong>Lat:</strong> ' . $lat . '<br>' .
                '<strong>Lon:</strong> ' . $lon .
                '</div>';
        }

        $velocidad = $row['ultimoIdRegistro']
            ? number_format(
                (float)$row['ultimaVelocidad'],
                2,
                '.',
                ''
            ) . ' km/h'
            : '-';

        $descripcionJs = json_encode(
            $descripcionRaw,
            JSON_UNESCAPED_UNICODE |
            JSON_HEX_APOS |
            JSON_HEX_QUOT
        );

        $imeiJs = json_encode(
            $imeiRaw,
            JSON_HEX_APOS |
            JSON_HEX_QUOT
        );

        $output['data'] .= '<tr>';

        $output['data'] .= '<td>' . $imei . '</td>';
        $output['data'] .= '<td>' . $simCard . '</td>';
        $output['data'] .= '<td>' . $marca . '</td>';
        $output['data'] .= '<td>' . $modelo . '</td>';
        $output['data'] .= '<td>' . $descripcion . '</td>';
        $output['data'] .= '<td>' . $bus . '</td>';

        $output['data'] .=
            '<td class="gps-ultima-fecha">' .
            $ultimaFecha .
            '</td>';

        $output['data'] .= '<td>' . $posicion . '</td>';
        $output['data'] .= '<td>' . $velocidad . '</td>';

        $output['data'] .= '<td style="white-space:nowrap;">';

        $output['data'] .=
            '<button ' .
            'type="button" ' .
            'class="btn-registros-gps" ' .
            'title="Ver registros GPS" ' .
            'onclick=\'verRegistrosGps(' .
            $imeiJs .
            ',' .
            $descripcionJs .
            ')\'>' .
            '<i class="fas fa-map-marker-alt"></i> Registros' .
            '</button>';

        $output['data'] .= '&nbsp;&nbsp;';

        $output['data'] .=
            '<a ' .
            'class="glyphicon glyphicon-edit" ' .
            'title="Editar" ' .
            'href="?c=gps&a=Crud1&idGps=' .
            $urlImei .
            '">' .
            '</a>';

        $output['data'] .= '&nbsp;&nbsp;';

        $output['data'] .=
            '<a ' .
            'class="glyphicon glyphicon-trash" ' .
            'title="Eliminar" ' .
            'href="?c=gps&a=Eliminar&idGps=' .
            $urlImei .
            '" ' .
            'onclick="return confirm(\'¿Seguro de eliminar este dispositivo? El historial GPS no se eliminará.\');">' .
            '</a>';

        $output['data'] .= '</td>';
        $output['data'] .= '</tr>';
    }
} else {
    $output['data'] =
        '<tr>' .
        '<td colspan="10">Sin resultados</td>' .
        '</tr>';
}

if ($totalFiltro > 0) {
    $totalPaginas = intval(
        ceil($totalFiltro / $limit)
    );

    $output['paginacion'] .=
        '<nav><ul class="pagination">';

    $numeroInicio = max(
        1,
        $pagina - 4
    );

    $numeroFin = min(
        $totalPaginas,
        $numeroInicio + 9
    );

    if ($numeroFin - $numeroInicio < 9) {
        $numeroInicio = max(
            1,
            $numeroFin - 9
        );
    }

    if ($pagina > 1) {
        $output['paginacion'] .=
            '<li class="page-item">' .
            '<a class="page-link" href="#" ' .
            'onclick="nextPage(' .
            ($pagina - 1) .
            '); return false;">' .
            '&laquo;' .
            '</a></li>';
    }

    for ($i = $numeroInicio; $i <= $numeroFin; $i++) {
        if ($pagina == $i) {
            $output['paginacion'] .=
                '<li class="page-item active">' .
                '<a class="page-link" href="#" ' .
                'onclick="return false;">' .
                $i .
                '</a></li>';
        } else {
            $output['paginacion'] .=
                '<li class="page-item">' .
                '<a class="page-link" href="#" ' .
                'onclick="nextPage(' .
                $i .
                '); return false;">' .
                $i .
                '</a></li>';
        }
    }

    if ($pagina < $totalPaginas) {
        $output['paginacion'] .=
            '<li class="page-item">' .
            '<a class="page-link" href="#" ' .
            'onclick="nextPage(' .
            ($pagina + 1) .
            '); return false;">' .
            '&raquo;' .
            '</a></li>';
    }

    $output['paginacion'] .=
        '</ul></nav>';
}

echo json_encode(
    $output,
    JSON_UNESCAPED_UNICODE
);
?>