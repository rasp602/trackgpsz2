<?php
require '../../bd/config.php';

header('Content-Type: application/json; charset=utf-8');

$columns = [
	'imei',
	'simCard',
	'marca',
	'modelo',
	'descripcion'
];

$table = "dispositivos";
$id = "imei";

$campo = isset($_POST['campo']) ? $conn->real_escape_string($_POST['campo']) : null;

$where = '';

if ($campo != null && $campo != '') {
	$where = "WHERE (";

	$cont = count($columns);

	for ($i = 0; $i < $cont; $i++) {
		$where .= $columns[$i] . " LIKE '%" . $campo . "%' OR ";
	}

	$where = substr_replace($where, "", -3);
	$where .= ")";
}

$limit = isset($_POST['registros']) ? intval($_POST['registros']) : 10;
$pagina = isset($_POST['pagina']) ? intval($_POST['pagina']) : 1;

if ($limit <= 0) {
	$limit = 10;
}

if ($pagina <= 0) {
	$pagina = 1;
}

$inicio = ($pagina - 1) * $limit;
$sLimit = "LIMIT $inicio, $limit";

$sOrder = "ORDER BY imei ASC";

if (isset($_POST['orderCol'])) {
	$orderCol = intval($_POST['orderCol']);
	$orderType = isset($_POST['orderType']) ? strtolower($_POST['orderType']) : 'asc';

	if (!isset($columns[$orderCol])) {
		$orderCol = 0;
	}

	if ($orderType != 'asc' && $orderType != 'desc') {
		$orderType = 'asc';
	}

	$sOrder = "ORDER BY " . $columns[$orderCol] . " " . $orderType;
}

$sql = "
	SELECT SQL_CALC_FOUND_ROWS
		imei,
		simCard,
		marca,
		modelo,
		descripcion
	FROM $table
	$where
	$sOrder
	$sLimit
";

$resultado = $conn->query($sql);

if (!$resultado) {
	echo json_encode([
		'totalRegistros' => 0,
		'totalFiltro' => 0,
		'data' => '<tr><td colspan="6">Error SQL: ' . htmlspecialchars($conn->error, ENT_QUOTES, 'UTF-8') . '</td></tr>',
		'paginacion' => ''
	], JSON_UNESCAPED_UNICODE);
	exit;
}

$num_rows = $resultado->num_rows;

$sqlFiltro = "SELECT FOUND_ROWS()";
$resFiltro = $conn->query($sqlFiltro);
$row_filtro = $resFiltro->fetch_array();
$totalFiltro = intval($row_filtro[0]);

$sqlTotal = "SELECT COUNT($id) FROM $table";
$resTotal = $conn->query($sqlTotal);
$row_total = $resTotal->fetch_array();
$totalRegistros = intval($row_total[0]);

$output = [];
$output['totalRegistros'] = $totalRegistros;
$output['totalFiltro'] = $totalFiltro;
$output['data'] = '';
$output['paginacion'] = '';

if ($num_rows > 0) {
	while ($row = $resultado->fetch_assoc()) {
		$imei = htmlspecialchars($row['imei'], ENT_QUOTES, 'UTF-8');
		$simCard = htmlspecialchars($row['simCard'] ?? '', ENT_QUOTES, 'UTF-8');
		$marca = htmlspecialchars($row['marca'] ?? '', ENT_QUOTES, 'UTF-8');
		$modelo = htmlspecialchars($row['modelo'] ?? '', ENT_QUOTES, 'UTF-8');
		$descripcion = htmlspecialchars($row['descripcion'] ?? '', ENT_QUOTES, 'UTF-8');

		$urlImei = urlencode($row['imei']);

		$output['data'] .= '<tr>';
		$output['data'] .= '<td>' . $imei . '</td>';
		$output['data'] .= '<td>' . $simCard . '</td>';
		$output['data'] .= '<td>' . $marca . '</td>';
		$output['data'] .= '<td>' . $modelo . '</td>';
		$output['data'] .= '<td>' . $descripcion . '</td>';

		$output['data'] .= '<td>
			<a class="glyphicon glyphicon-edit" title="Editar" href="?c=gps&a=Crud1&idGps=' . $urlImei . '"></a>
			&nbsp;&nbsp;
			<a class="glyphicon glyphicon-trash" title="Eliminar" href="?c=gps&a=Eliminar&idGps=' . $urlImei . '" onclick="return confirm(\'¿Seguro de eliminar este dispositivo?\');"></a>
		</td>';

		$output['data'] .= '</tr>';
	}
} else {
	$output['data'] .= '<tr>';
	$output['data'] .= '<td colspan="6">Sin resultados</td>';
	$output['data'] .= '</tr>';
}

if ($output['totalRegistros'] > 0) {
	$totalPaginas = ceil($output['totalFiltro'] / $limit);

	$output['paginacion'] .= '<nav>';
	$output['paginacion'] .= '<ul class="pagination">';

	$numeroInicio = 1;

	if (($pagina - 4) > 1) {
		$numeroInicio = $pagina - 4;
	}

	$numeroFin = $numeroInicio + 9;

	if ($numeroFin > $totalPaginas) {
		$numeroFin = $totalPaginas;
	}

	for ($i = $numeroInicio; $i <= $numeroFin; $i++) {
		if ($pagina == $i) {
			$output['paginacion'] .= '<li class="page-item active"><a class="page-link" href="#">' . $i . '</a></li>';
		} else {
			$output['paginacion'] .= '<li class="page-item"><a class="page-link" href="#" onclick="nextPage(' . $i . ')">' . $i . '</a></li>';
		}
	}

	$output['paginacion'] .= '</ul>';
	$output['paginacion'] .= '</nav>';
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
?>