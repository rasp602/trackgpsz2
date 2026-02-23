<?php
/*
* Script: Cargar datos de lado del servidor con PHP y MySQL
* Autor: Marco Robles
* Team: Códigos de Programación
*/

require '../../bd/config.php';

/* Un arreglo de las columnas a mostrar en la tabla */
$columns = ['idControl','nombreControl', 'abreviacionControl', 'tipoControl', 'longitud1', 'longitud2', 'latitud1', 'latitud2','anguloEntrada','toleraciaEntrada','velMax','estadoControl','sentido','visible'];

/* Nombre de la tabla */
$table = "controles";

$id = 'idControl';

$campo = isset($_POST['campo']) ? $conn->real_escape_string($_POST['campo']) : null;

/* Filtrado */
$where = '';

if ($campo != null) {
    $where = "WHERE (";

    $cont = count($columns);
    for ($i = 0; $i < $cont; $i++) {
        $where .= $columns[$i] . " LIKE '%" . $campo . "%' OR ";
    }
    $where = substr_replace($where, "", -3);
    $where .= ")";
}

/* Limit */
$limit = isset($_POST['registros']) ? $conn->real_escape_string($_POST['registros']) : 10;
$pagina = isset($_POST['pagina']) ? $conn->real_escape_string($_POST['pagina']) : 0;

if (!$pagina) {
    $inicio = 0;
    $pagina = 1;
} else {
    $inicio = ($pagina - 1) * $limit;
}

$sLimit = "LIMIT $inicio , $limit";

/**
 * Ordenamiento
 */
$sOrder = "";
if(isset($_POST['orderCol'])){
    $orderCol = $_POST['orderCol'];
    $oderType = isset($_POST['orderType']) ? $_POST['orderType'] : 'asc';
    
    $sOrder = "ORDER BY ". $columns[intval($orderCol)] . ' ' . $oderType;
}

/* Consulta principal - CORREGIDA: eliminado el espacio extra antes de $where */
$sql = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $columns) . "
FROM $table 
$where
$sOrder
$sLimit";

$resultado = $conn->query($sql);

// Verificar si hay error en la consulta
if (!$resultado) {
    die("Error en la consulta: " . $conn->error . " - SQL: " . $sql);
}

$num_rows = $resultado->num_rows;

/* Consulta para total de registro filtrados */
$sqlFiltro = "SELECT FOUND_ROWS()";
$resFiltro = $conn->query($sqlFiltro);
$row_filtro = $resFiltro->fetch_array();
$totalFiltro = $row_filtro[0];

/* Consulta para total de registro filtrados */
$sqlTotal = "SELECT count($id) FROM $table ";
$resTotal = $conn->query($sqlTotal);
$row_total = $resTotal->fetch_array();
$totalRegistros = $row_total[0];

/* Mostrado resultados */
$output = [];
$output['totalRegistros'] = $totalRegistros;
$output['totalFiltro'] = $totalFiltro;
$output['data'] = '';
$output['paginacion'] = '';

if ($num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        // CORREGIDO: Las condiciones estaban mal indentadas y la lógica de 'visible' estaba invertida
        if ($row['estadoControl'] == 1) {
            $estadoControl = "Activo";
        } elseif ($row['estadoControl'] == 0) {
            $estadoControl = "Inactivo";
        } else {
            $estadoControl = "Desconocido";
        }

        if ($row['sentido'] == 'I') {
            $sentido = "IDA";
        } elseif ($row['sentido'] == 'R') {
            $sentido = "REGRESO";
        } else {
            $sentido = "No definido";
        }
        
        // CORREGIDO: La lógica estaba invertida (0=Si, 1=No)
        if ($row['visible'] == 0) {
            $visible = "Si";  // Si visible=0 significa que NO es visible
        } elseif ($row['visible'] == 1) {
            $visible = "No";  // Si visible=1 significa que SÍ es visible
        } else {
            $visible = "No definido";
        }

        $output['data'] .= '<tr>';
        $output['data'] .= '<td>' . htmlspecialchars($row['idControl']) . '</td>';
        $output['data'] .= '<td>' . htmlspecialchars($row['nombreControl']) . '</td>';
        $output['data'] .= '<td>' . htmlspecialchars($row['abreviacionControl']) . '</td>';    
        $output['data'] .= '<td>' . htmlspecialchars($row['tipoControl']) . '</td>';
        $output['data'] .= '<td>' . htmlspecialchars($row['longitud1']) . '</td>';  
        $output['data'] .= '<td>' . htmlspecialchars($row['longitud2']) . '</td>';  
        $output['data'] .= '<td>' . htmlspecialchars($row['latitud1']) . '</td>';    
        $output['data'] .= '<td>' . htmlspecialchars($row['latitud2']) . '</td>';    
        $output['data'] .= '<td>' . htmlspecialchars($row['anguloEntrada']) . '</td>';
        $output['data'] .= '<td>' . htmlspecialchars($row['toleraciaEntrada']) . '</td>';
        $output['data'] .= '<td>' . htmlspecialchars($row['velMax']) . '</td>';
        $output['data'] .= '<td>' . htmlspecialchars($estadoControl) . '</td>';
        $output['data'] .= '<td>' . htmlspecialchars($sentido) . '</td>';    
        $output['data'] .= '<td>' . htmlspecialchars($visible) . '</td>';
        
        // CORREGIDO: El onclick del confirm tenía problemas con las comillas
        $output['data'] .= '<td>
            <a class="glyphicon glyphicon-edit" href="?c=controles&a=Crud1&idControl=' . $row['idControl'] . '"></a>  
            <a class="glyphicon glyphicon-trash" href="?c=controles&a=Eliminar&idControl='. $row['idControl'] . '" onclick="return confirm(\'¿Seguro de eliminar este registro?\');"></a>
        </td>';
        $output['data'] .= '</tr>';
    }
} else {
    $output['data'] .= '<tr>';
    // CORREGIDO: El colspan debe coincidir con el número de columnas (11 columnas mostradas)
    $output['data'] .= '<td colspan="11">Sin resultados</td>';
    $output['data'] .= '</tr>';
}

if ($output['totalRegistros'] > 0) {
    $totalPaginas = ceil($output['totalRegistros'] / $limit);

    $output['paginacion'] .= '<nav>';
    $output['paginacion'] .= '<ul class="pagination">';

    $numeroInicio = 1;

    if(($pagina - 4) > 1){
        $numeroInicio = $pagina - 4;
    }

    $numeroFin = $numeroInicio + 9;

    if($numeroFin > $totalPaginas){
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