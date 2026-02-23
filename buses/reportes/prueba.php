<!DOCTYPE html>
<html>
<head>
    <title>Listado de Personas</title>
</head>
<body>
    <?php
    $conn = new mysqli("localhost", "tu_usuario", "tu_contraseña", "testdb");

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $perPage = 10;
    $start = ($page - 1) * $perPage;

    $orderField = isset($_GET['order']) ? $_GET['order'] : 'nombre';
    $orderType = isset($_GET['type']) ? $_GET['type'] : 'asc';

    $query = "SELECT * FROM personas ORDER BY $orderField $orderType LIMIT $start, $perPage";
    $result = $conn->query($query);

    echo '<table border="1">
            <tr>
                <th><a href="?order=id&type=' . ($orderField === 'id' && $orderType === 'asc' ? 'desc' : 'asc') . '">ID</a></th>
                <th><a href="?order=nombre&type=' . ($orderField === 'nombre' && $orderType === 'asc' ? 'desc' : 'asc') . '">Nombre</a></th>
                <th><a href="?order=dni&type=' . ($orderField === 'dni' && $orderType === 'asc' ? 'desc' : 'asc') . '">DNI</a></th>
            </tr>';

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<tr>
                    <td>' . $row['id'] . '</td>
                    <td>' . $row['nombre'] . '</td>
                    <td>' . $row['dni'] . '</td>
                </tr>';
        }
    } else {
        echo '<tr><td colspan="3">No hay registros</td></tr>';
    }

    echo '</table>';

    $conn->close();

    echo '<br>';

    $prevPage = $page - 1;
    $nextPage = $page + 1;

    echo '<a href="?page=' . $prevPage . '&order=' . $orderField . '&type=' . $orderType . '">Anterior</a> ';

    echo '<a href="?page=' . $nextPage . '&order=' . $orderField . '&type=' . $orderType . '">Siguiente</a>';
    ?>
</body>
</html>
