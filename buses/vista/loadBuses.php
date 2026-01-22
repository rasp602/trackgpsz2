<?php
/*
* Script: Cargar datos de lado del servidor con PHP y MySQL
* Autor: Marco Robles
* Team: Códigos de Programación
*/


require '../../bd/config.php';

/* Un arreglo de las columnas a mostrar en la tabla */
$columns = ['buses.idBus','buses.numeroBus', 'buses.placaBus', 'buses.tipoBus', 'buses.idPersona', 'buses.estadoBus', 'buses.validez', 'buses.idGps','persona.idPersona','persona.nombre1Persona','persona.apellido1Persona','gps.idGps','gps.imeiGps','gps.modelo'];

/* Nombre de la tabla */
$table = "buses";

$id = 'idBus';

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
INNER JOIN persona ON buses.idPersona = persona.idPersona
INNER JOIN gps ON buses.idGps = gps.idGps

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
if ($row['estadoBus']==1) {
  $estado="Activo";
}
elseif($row['estadoBus']==0){
    $estado="Inactivo";
}

        $output['data'] .= '<tr>';
     
        $output['data'] .= '<td>' . $row['numeroBus'] . '</td>';
        $output['data'] .= '<td>' . $row['placaBus'] . '</td>';
        $output['data'] .= '<td>' . $row['tipoBus'] . '</td>';
        $output['data'] .= '<td>' . $row['nombre1Persona'] ." ". $row['apellido1Persona'] . '</td>';
        $output['data'] .= '<td>' . $row['imeiGps'] . '</td>';
        $output['data'] .= '<td>' . $row['modelo'] . '</td>';
        $output['data'] .= '<td>' . $estado . '</td>';
        

$output['data'] .= '<td>
    <a class="glyphicon glyphicon-edit" href="?c=buses&a=Crud1&idBus=' . $row['idBus'] . '"></a>
    <a class="glyphicon glyphicon-trash" 
       href="?c=buses&a=Eliminar&idBus='. $row['idBus'] . '" 
       onclick="return confirm(\'¿Seguro de eliminar este registro?\');">
    </a>
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
