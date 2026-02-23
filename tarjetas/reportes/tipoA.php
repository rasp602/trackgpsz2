<?php     error_reporting(E_ERROR | E_PARSE); // Desactiva la notificación y warnings de error en php. ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
  
<?php
include '../../bd/conexionLocal.php'; //incluir el archivo de conexion

	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if($action == 'ajax'){
		include 'pagination_tarjetas.php'; //incluir el archivo de paginación

		//las variables de paginación
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //la cantidad de registros que desea mostrar
		$adjacents  = 4; //brecha entre páginas después de varios adyacentes
		$offset = ($page - 1) * $per_page;
		
$usuario = $_REQUEST['id_user'];
$where="";
$desde = $_REQUEST["desde"];
$hasta = $_REQUEST["hasta"];
$fecha1= Date('3000-01-01');
/*
echo "idMaquina:". $idMaquina;
echo "tipoA". $tipoA;  


$fecha2= Date('3000-12-31');

echo "fecha 1:".$fecha1;
echo "fecha 2:".$fecha2;
*/




      	$count_query1 = mysqli_query($con,"SELECT count(*) AS numrows1 FROM ruta ");

    		if ($row= mysqli_fetch_array($count_query1)){$numrows1 = $row['numrows1'];}
    		$total_pages = ceil($numrows1/$per_page);
    		$reload = 'index.php';
	
		//consulta principal para recuperar los datos

$query = mysqli_query($con,"SELECT
tarjeta.idTarjeta,tarjeta.fechaSalida,tarjeta.horaTarjeta,tarjeta.idBus,tarjeta.idVariante,tarjeta.idPersona,tarjeta.frecuenciaTarjeta,
tarjeta.fechaGenerado,tarjeta.busDelantero,tarjeta.busTrasero,buses.idBus,buses.numeroBus,buses.placaBus,variante.idVariante,variante.numeroVariante,
variante.nombreVariante,persona.idPersona,persona.nombre1Persona,persona.apellido1Persona
FROM tarjeta
INNER JOIN buses ON tarjeta.idBus = buses.idBus
INNER JOIN variante ON tarjeta.idVariante = variante.idVariante
INNER JOIN persona ON tarjeta.idPersona = persona.idPersona
ORDER by idTarjeta LIMIT $offset,$per_page");

	
		
		if (mysqli_num_rows($query) > 0){
			?>
		<div class="container-fluid">
            <div class="row">
                <div class="table-responsive">
		<table class="table table-condensed table-striped table-bordered table-hover" id="tabla">
							<thead>
                                <tr class="bg-primary">              
                                 <th>#</th>
								 <th>Fecha</th>
								 <th>Hora</th>
								 <th>Variante</th>
                                 <th>BUS</th>
                                 <th>CONDUCTOR</th>
								 <th>Ver</th>

            
                                 <th>Acciones</th>                              
                                </tr>
                            </thead>
			<tbody>
                <br>
			<?php
    			while($row = mysqli_fetch_array($query)){    	 
                
                //$newDate = date("d-m-Y", strtotime($row['fechaCreado']));          
                //$newhora = date("g:i a",strtotime($row['horaCreado']));

            ?>
				<tr>

            <td class="contenidoTabla"><?php echo utf8_encode($row['idTarjeta']);?></td>
			<td class="contenidoTabla"><?php echo utf8_encode($row['fechaSalida']);?></td>
			<td class="contenidoTabla"><?php echo utf8_encode($row['horaTarjeta']);?></td>
			<td class="contenidoTabla"><?php echo utf8_encode($row['nombreVariante']);?></td>
            <td class="contenidoTabla"><?php echo utf8_encode($row['placaBus']);?></td>
            <td class="contenidoTabla"><?php echo utf8_encode($row['nombre1Persona'].' '.$row['apellido1Persona']);?></td>
			<td class="contenidoTabla"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
  <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
  <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
</svg></td>
                
            <td>
            	<a href="?c=tarjetas&a=Crud1&idTarjetas=<?php echo $row['idTarjetas']?>" class="glyphicon glyphicon-pencil"></a> 
            	<a onclick="javascript:return confirm('¿Seguro de eliminar este registro?');" href="?c=hotel&a=Eliminar&idTarjetas=<?php echo $row['idTarjetas']?>" class="glyphicon glyphicon-remove"></a>
            </td>
     			</tr>
			<?php
			 }
			?>
			</tbody>
		</table>
		</div>
		<?php echo "<div align='center'> <b>Total de Registros encontrados :</b>"; echo"&nbsp".$numrows1 ; echo "</div>"; ?>
            </div>
        </div>
			<div class="table-pagination pull" align="center">
				<?php echo paginate($reload, $page, $total_pages, $adjacents);?><br><br>
			</div>
		
			<?php
			
		} else {
			?>
			<div class="container"><br>
			<div class="alert alert-danger alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              
              <h4>Aviso!!!</h4> No hay datos para mostrar..!!!!!
			</div>
            </div>
			<?php

		}
	}
    
?>
</body>
</html>