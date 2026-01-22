<?php
/*
* Script: Cargar datos de lado del servidor con PHP y MySQL
* Autor: Marco Robles
* Team: Códigos de Programación
*/


require '../../bd/config.php';

/* Un arreglo de las columnas a mostrar en la tabla */
$columns = ['controles.idControl','controles.nombreControl', 'controles.abreviacionControl', 'controles.tipoControl', 'controles.longitud1', 'controles.longitud2', 'controles.latitud1', 'controles.latitud2','controles.anguloEntrada','controles.toleraciaEntrada','controles.velMax','controles.estadoControl','controles.sentido','controles.visible'];

/* Nombre de la tabla */
$table = "controles";

$id = 'idControl';

$campo = isset($_POST['campo']) ? $conn->real_escape_string($_POST['campo']) : null;


/* Filtrado */
$where = '';

if ($campo != null ) {
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


/* Consulta */
$sql = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $columns) . "
FROM $table 


$where
$sOrder
$sLimit";
$resultado = $conn->query($sql);
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
if ($row['estadoControl']==1) {
  $estadoControl="Activo";
}
elseif($row['estadoControl']==0){
    $estadoControl="Inactivo";
}

if ($row['sentido']=='I') {
  $sentido="IDA";
}
elseif($row['sentido']=='R'){
    $sentido="REGRESO";
}
if ($row['visible']==0) {
  $visible="Si";
}
elseif($row['visible']==1){
    $visible="No";
}

        $output['data'] .= '<tr>';
     
        $output['data'] .= '<td>' . $row['idControl'] . '</td>';
        $output['data'] .= '<td>' . $row['nombreControl'] . '</td>';
        $output['data'] .= '<td>' . $row['abreviacionControl'] . '</td>';    
        $output['data'] .= '<td>' . $row['tipoControl'] . '</td>';
        $output['data'] .= '<td>' . $row['anguloEntrada'] . '</td>';
        $output['data'] .= '<td>' . $row['toleraciaEntrada'] . '</td>';
        $output['data'] .= '<td>' . $row['velMax'] . '</td>';
        $output['data'] .= '<td>' . $estadoControl . '</td>';
        $output['data'] .= '<td>' . $sentido . '</td>';    
        $output['data'] .= '<td>' . $visible . '</td>';
    

        $output['data'] .= '<td><a class="glyphicon glyphicon-edit" href="?c=controles&a=Crud1&idControl=' . $row['idControl'] . '"></a>  <a class="glyphicon glyphicon-trash" href="?c=controles&a=Eliminar&idControl='. $row['idControl'] . '" onclick="javascript:return confirm("¿Seguro de eliminar este registro?"");""></a>
        </td>';

        $output['data'] .= '</tr>';
    }
} else {
    $output['data'] .= '<tr>';
    $output['data'] .= '<td colspan="7">Sin resultados</td>';
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
