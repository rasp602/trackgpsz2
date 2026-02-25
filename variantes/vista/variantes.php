<head>

</head>


    <div class="container-fluid">
        <h2>Variantes</h2>
        <div class="row">
            <div class="col-auto h5">
                <p align="center">Mostrar :</p>
                <select name="num_registros" id="num_registros" class="form-control">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                </select><br>
                     <p align="center">Registros</p>
            </div>
            <div class="col-md-2 h5">
                    <p align="left">Buscar:</p>
                    <input type="text" name="campo" id="campo" class="form-control">
            </div>
            <div class="col-auto h5">
                <a href="javascript:reportePDF1();"  data-toggle="tooltip" title="descargar buses"><img src="img/pdf.png" width="50px" height="50px"><p align="center">Descargar</p></a>
            </div> 
            <div class="col-auto h5">
                <a href="javascript:reporteExcel();"  data-toggle="tooltip" title="descargar buses"><img src="img/excel.png" width="50px" height="50px"><p align="center">Descargar</p></a> 
            </div> 
     
            <div class="col-auto h5" align="center">
                 <a href="?c=variantes&a=Crud"><span class="glyphicon glyphicon-road" style='font-size:48px'></span>
                 <p>Agregar Variante</p></a>
            </div>
        </div> 
        
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-condensed table-striped table-bordered table-hover">
                        <thead class="bg-primary" align="center">
                            <th class="sort asc h4">Numero</th>
                            <th class="sort asc h4">Nombre</th>
                            <th class="sort asc h4">Sentido</th>
                            <th class="sort asc h4">Estado</th>
                            <th class="sort asc h4">FrecMAx</th>
                            <th class="sort asc h4">FrecMin</th>
                            <th class="sort asc h4">FrecNormal</th>
                            <th class="sort asc h4">Media</th>
                            <th class="sort asc h4">Proxima Variante</th>
                            <th class="sort asc h4">Primera Salida</th>
                            <th class="sort asc h4">Color</th>
                            <th class="h4">Acciones</th>
                       
                        </thead>

                        <!-- El id del cuerpo de la tabla. -->
                        <tbody id="content" class="h5" align="center" >

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <label id="lbl-total"></label>
                </div>

                <div class="col-md-12" id="nav-paginacion"></div>

                <input type="hidden" id="pagina" value="1">
                <input type="hidden" id="orderCol" value="0">
                <input type="hidden" id="orderType" value="asc">
            </div>
            
    </div>    
    
    <div class="modal fade" id="modalRuta" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <div class="modal-header bg-warning text-white">
        <h5 class="modal-title">Configurar Ruta de Variante</h5>
        <button type="button" class="close text-white" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body">

        <!-- Guardamos idVariante oculto -->
        <input type="hidden" id="ruta_idVariante">

        <button type="button" class="btn btn-success mb-3" onclick="agregarFilaEditar()">
            Agregar Control
        </button>

        <table class="table table-bordered" id="tablaEditarControles">
          <thead class="bg-secondary text-white">
            <tr>
              <th>Posición</th>
              <th>Control</th>
              <th>Minutos</th>
              <th>Tolerancia</th>
              <th>Tipo Días</th>
              <th>Ang Entrada</th>
              <th>Ang Salida</th>
              <th>Multa Atraso</th>
              <th>Eliminar</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="guardarEdicionRuta()">
          Guardar Cambios
        </button>
      </div>

    </div>
  </div>
</div>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>



<script>
    function abrirModalEditar(idVariante){

    document.getElementById("ruta_idVariante").value = idVariante;
    document.querySelector("#tablaEditarControles tbody").innerHTML = "";

    fetch("variantes/vista/obtener_ruta.php?idVariante=" + idVariante)
    .then(res => res.json())
    .then(data => {

        data.forEach(row => {

            let fila = `
                <tr data-idRuta="${row.idRuta}">
                    <td><input type="number" class="form-control" value="${row.posicion}"></td>
                    <td>
                        <select class="form-control">
                            ${row.selectControl}
                        </select>
                    </td>
                    <td><input type="number" class="form-control" value="${row.minutos}"></td>
                    <td><input type="number" class="form-control" value="${row.tolerancia}"></td>
                    <td><input type="text" class="form-control" value="${row.tipoDias}"></td>
                    <td><input type="number" class="form-control" value="${row.anguloE}"></td>
                    <td><input type="number" class="form-control" value="${row.anguloS}"></td>
                    <td><input type="number" class="form-control" value="${row.multaAtraso}"></td>
                    <td>
                        <button class="btn btn-danger" onclick="this.closest('tr').remove()">X</button>
                    </td>
                </tr>
            `;

            document.querySelector("#tablaEditarControles tbody")
            .insertAdjacentHTML("beforeend", fila);
        });

        $('#modalRuta').modal('show');
    });
}
</script>
<script>
    function agregarFilaEditar(){

    let fila = `
        <tr data-idRuta="0">
            <td><input type="number" class="form-control"></td>
            <td>
                <select class="form-control">
                    <option value="">Seleccione</option>
                    <?php
                    require 'bd/config.php';
                    $sql_control = "SELECT idControl, nombreControl FROM controles";
                    $res_control = $conn->query($sql_control);
                    while($row_control = $res_control->fetch_assoc()){
                        echo '<option value="'.$row_control['idControl'].'">'.$row_control['nombreControl'].'</option>';
                    }
                    ?>
                </select>
            </td>
            <td><input type="number" class="form-control"></td>
            <td><input type="number" class="form-control"></td>
            <td><input type="text" class="form-control"></td>
            <td><input type="number" class="form-control"></td>
            <td><input type="number" class="form-control"></td>
            <td><input type="number" class="form-control"></td>
            <td>
                <button class="btn btn-danger" onclick="this.closest('tr').remove()">X</button>
            </td>
        </tr>
    `;

    document.querySelector("#tablaEditarControles tbody")
    .insertAdjacentHTML("beforeend", fila);
}
</script>

<script>
    function guardarEdicionRuta(){

    let variante = document.getElementById("ruta_idVariante").value;
    let filas = document.querySelectorAll("#tablaEditarControles tbody tr");

    let formData = new FormData();
    formData.append("idVariante", variante);

    filas.forEach(fila => {

        formData.append("idRuta[]", fila.dataset.idruta);
        formData.append("posicion[]", fila.cells[0].querySelector("input").value);
        formData.append("idControl[]", fila.cells[1].querySelector("select").value);
        formData.append("minutos[]", fila.cells[2].querySelector("input").value);
        formData.append("tolerancia[]", fila.cells[3].querySelector("input").value);
        formData.append("tipoDias[]", fila.cells[4].querySelector("input").value);
        formData.append("anguloE[]", fila.cells[5].querySelector("input").value);
        formData.append("anguloS[]", fila.cells[6].querySelector("input").value);
        formData.append("multaAtraso[]", fila.cells[7].querySelector("input").value);
    });

    fetch("variantes/vista/actualizar_ruta.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.text())
    .then(data => {
        alert("Ruta actualizada correctamente");
        $('#modalRuta').modal('hide');
    });
}
</script>


    <script>
        /* Llamando a la función getData() */
        getData()

        /* Escuchar un evento keyup en el campo de entrada y luego llamar a la función getData. */
        document.getElementById("campo").addEventListener("keyup", function() {
            getData()
        }, false)
        document.getElementById("num_registros").addEventListener("change", function() {
            getData()
        }, false)
           
        /* Peticion AJAX */
        function getData() {
            let input = document.getElementById("campo").value

            let num_registros = document.getElementById("num_registros").value
            let content = document.getElementById("content")
            let pagina = document.getElementById("pagina").value
            let orderCol = document.getElementById("orderCol").value
            let orderType = document.getElementById("orderType").value

            if (pagina == null) {
                pagina = 1
            }

            let url = "variantes/vista/loadVariantes.php"
            let formaData = new FormData()
            formaData.append('campo', input)

            formaData.append('registros', num_registros)
            formaData.append('pagina', pagina)
            formaData.append('orderCol', orderCol)
            formaData.append('orderType', orderType)

            fetch(url, {
                    method: "POST",
                    body: formaData
                }).then(response => response.json())
                .then(data => {
                    content.innerHTML = data.data
                    document.getElementById("lbl-total").innerHTML = 'Mostrando ' + data.totalFiltro +
                        ' de ' + data.totalRegistros + ' registros'
                    document.getElementById("nav-paginacion").innerHTML = data.paginacion
                }).catch(err => console.log(err))
        }

        function nextPage(pagina){
            document.getElementById('pagina').value = pagina
            getData()
        }

        let columns = document.getElementsByClassName("sort")
        let tamanio = columns.length
        for(let i = 0; i < tamanio; i++){
            columns[i].addEventListener("click", ordenar)
        }

        function ordenar(e){
            let elemento = e.target

            document.getElementById('orderCol').value = elemento.cellIndex

            if(elemento.classList.contains("asc")){
                document.getElementById("orderType").value = "asc"
                elemento.classList.remove("asc")
                elemento.classList.add("desc")
            } else {
                document.getElementById("orderType").value = "desc"
                elemento.classList.remove("desc")
                elemento.classList.add("asc")
            }

            getData()
        }

    </script>



    <!-- Bootstrap core JS 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>-->



