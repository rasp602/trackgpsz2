<?php
require '../../bd/config.php';

header('Content-Type: application/json; charset=utf-8');

$columns = [
    'b.numeroBus',
    'b.placaBus',
    'b.tipoBus',
    "CONCAT(COALESCE(p.nombre1Persona, ''), ' ', COALESCE(p.apellido1Persona, ''))",
    'bd.imei',
    'd.simCard',
    'd.modelo',
    'b.estadoBus'
];

$campo = isset($_POST['campo']) ? trim($_POST['campo']) : '';
$limit = isset($_POST['registros']) ? intval($_POST['registros']) : 10;
$pagina = isset($_POST['pagina']) ? intval($_POST['pagina']) : 1;
$orderCol = isset($_POST['orderCol']) ? intval($_POST['orderCol']) : 0;
$orderType = isset($_POST['orderType']) && strtolower($_POST['orderType']) === 'desc'
    ? 'DESC'
    : 'ASC';

if ($limit <= 0 || $limit > 500) {
    $limit = 10;
}

if ($pagina <= 0) {
    $pagina = 1;
}

if (!isset($columns[$orderCol])) {
    $orderCol = 0;
}

$inicio = ($pagina - 1) * $limit;

$from = "
    FROM buses b
    LEFT JOIN persona p
        ON p.idPersona = b.idPersona
    LEFT JOIN bus_dispositivo bd
        ON bd.idBus = b.idBus
        AND bd.estado = 'ACTIVO'
        AND bd.fechaFin IS NULL
    LEFT JOIN dispositivos d
        ON d.imei = bd.imei
";

$where = '';
$params = [];
$types = '';

if ($campo !== '') {
    $like = '%' . $campo . '%';

    $where = "
        WHERE (
            CAST(b.numeroBus AS CHAR) LIKE ?
            OR b.placaBus LIKE ?
            OR b.tipoBus LIKE ?
            OR p.nombre1Persona LIKE ?
            OR p.apellido1Persona LIKE ?
            OR bd.imei LIKE ?
            OR d.simCard LIKE ?
            OR d.marca LIKE ?
            OR d.modelo LIKE ?
            OR d.descripcion LIKE ?
        )
    ";

    for ($i = 0; $i < 10; $i++) {
        $params[] = $like;
        $types .= 's';
    }
}

$sqlTotal = "SELECT COUNT(*) AS total FROM buses";
$resTotal = $conn->query($sqlTotal);
$totalRegistros = $resTotal ? intval($resTotal->fetch_assoc()['total']) : 0;

$sqlFiltro = "SELECT COUNT(DISTINCT b.idBus) AS total " . $from . $where;
$stmtFiltro = $conn->prepare($sqlFiltro);

if (!$stmtFiltro) {
    echo json_encode([
        'totalRegistros' => 0,
        'totalFiltro' => 0,
        'data' => '<tr><td colspan="9">Error preparando conteo: ' .
            htmlspecialchars($conn->error, ENT_QUOTES, 'UTF-8') .
            '</td></tr>',
        'paginacion' => ''
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

if ($types !== '') {
    $stmtFiltro->bind_param($types, ...$params);
}

$stmtFiltro->execute();
$resultFiltro = $stmtFiltro->get_result();
$totalFiltro = intval($resultFiltro->fetch_assoc()['total']);
$stmtFiltro->close();

$sql = "
    SELECT
        b.idBus,
        b.numeroBus,
        b.placaBus,
        b.tipoBus,
        b.estadoBus,
        CONCAT(
            COALESCE(p.nombre1Persona, 'Empresa'),
            ' ',
            COALESCE(p.apellido1Persona, '')
        ) AS propietario,
        bd.imei,
        d.simCard,
        d.marca,
        d.modelo,
        d.descripcion
    " . $from . $where . "
    ORDER BY " . $columns[$orderCol] . " " . $orderType . "
    LIMIT ?, ?
";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode([
        'totalRegistros' => $totalRegistros,
        'totalFiltro' => $totalFiltro,
        'data' => '<tr><td colspan="9">Error preparando consulta: ' .
            htmlspecialchars($conn->error, ENT_QUOTES, 'UTF-8') .
            '</td></tr>',
        'paginacion' => ''
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$queryParams = $params;
$queryParams[] = $inicio;
$queryParams[] = $limit;
$queryTypes = $types . 'ii';

$stmt->bind_param($queryTypes, ...$queryParams);
$stmt->execute();
$resultado = $stmt->get_result();

$output = [
    'totalRegistros' => $totalRegistros,
    'totalFiltro' => $totalFiltro,
    'data' => '',
    'paginacion' => ''
];

if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $estado = intval($row['estadoBus']) === 1 ? 'Activo' : 'Inactivo';
        $estadoClase = intval($row['estadoBus']) === 1 ? 'text-success' : 'text-muted';

        $imei = $row['imei'] ?: 'Sin GPS';
        $simCard = $row['simCard'] ?: '-';
        $modelo = trim(($row['marca'] ?: '') . ' ' . ($row['modelo'] ?: ''));
        if ($modelo === '') {
            $modelo = '-';
        }

        $idBus = intval($row['idBus']);

        $output['data'] .= '<tr>';
        $output['data'] .= '<td>' . htmlspecialchars($row['numeroBus'], ENT_QUOTES, 'UTF-8') . '</td>';
        $output['data'] .= '<td>' . htmlspecialchars($row['placaBus'], ENT_QUOTES, 'UTF-8') . '</td>';
        $output['data'] .= '<td>' . htmlspecialchars($row['tipoBus'], ENT_QUOTES, 'UTF-8') . '</td>';
        $output['data'] .= '<td>' . htmlspecialchars(trim($row['propietario']), ENT_QUOTES, 'UTF-8') . '</td>';
        $output['data'] .= '<td>' . htmlspecialchars($imei, ENT_QUOTES, 'UTF-8') . '</td>';
        $output['data'] .= '<td>' . htmlspecialchars($simCard, ENT_QUOTES, 'UTF-8') . '</td>';
        $output['data'] .= '<td>' . htmlspecialchars($modelo, ENT_QUOTES, 'UTF-8') . '</td>';
        $output['data'] .= '<td class="' . $estadoClase . '"><strong>' . $estado . '</strong></td>';
        $output['data'] .= '
            <td>
                <a
                    class="glyphicon glyphicon-edit"
                    title="Editar bus y gestionar GPS"
                    href="?c=buses&a=Crud1&idBus=' . $idBus . '"
                ></a>
                &nbsp;&nbsp;
                <a
                    class="glyphicon glyphicon-trash"
                    title="Eliminar"
                    href="?c=buses&a=Eliminar&idBus=' . $idBus . '"
                    onclick="return confirm(\'¿Seguro de eliminar este bus? Los buses con historial GPS no pueden eliminarse.\');"
                ></a>
            </td>
        ';
        $output['data'] .= '</tr>';
    }
} else {
    $output['data'] = '<tr><td colspan="9">Sin resultados</td></tr>';
}

$stmt->close();

if ($totalFiltro > 0) {
    $totalPaginas = intval(ceil($totalFiltro / $limit));
    $numeroInicio = max(1, $pagina - 4);
    $numeroFin = min($totalPaginas, $numeroInicio + 9);

    $output['paginacion'] .= '<nav><ul class="pagination">';

    if ($pagina > 1) {
        $output['paginacion'] .=
            '<li class="page-item"><a class="page-link" href="#" onclick="nextPage(' .
            ($pagina - 1) .
            '); return false;">Anterior</a></li>';
    }

    for ($i = $numeroInicio; $i <= $numeroFin; $i++) {
        if ($pagina === $i) {
            $output['paginacion'] .=
                '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
        } else {
            $output['paginacion'] .=
                '<li class="page-item"><a class="page-link" href="#" onclick="nextPage(' .
                $i .
                '); return false;">' . $i . '</a></li>';
        }
    }

    if ($pagina < $totalPaginas) {
        $output['paginacion'] .=
            '<li class="page-item"><a class="page-link" href="#" onclick="nextPage(' .
            ($pagina + 1) .
            '); return false;">Siguiente</a></li>';
    }

    $output['paginacion'] .= '</ul></nav>';
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
?>
