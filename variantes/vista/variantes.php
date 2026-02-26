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
                 <a href="?c=variantes&a=Crud"><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-sign-turn-right" viewBox="0 0 16 16">
  <path d="M5 8.5A2.5 2.5 0 0 1 7.5 6H9V4.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L9.41 8.658A.25.25 0 0 1 9 8.466V7H7.5A1.5 1.5 0 0 0 6 8.5V11H5z"/>
  <path fill-rule="evenodd" d="M6.95.435c.58-.58 1.52-.58 2.1 0l6.515 6.516c.58.58.58 1.519 0 2.098L9.05 15.565c-.58.58-1.519.58-2.098 0L.435 9.05a1.48 1.48 0 0 1 0-2.098zm1.4.7a.495.495 0 0 0-.7 0L1.134 7.65a.495.495 0 0 0 0 .7l6.516 6.516a.495.495 0 0 0 .7 0l6.516-6.516a.495.495 0 0 0 0-.7L8.35 1.134Z"/>
</svg>
                 <p>Crear Variante</p></a>
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
    <style>
  /* Aumentar ancho de los select dentro de la tabla del modal */
  #modalRuta table select.form-control {
      min-width: 150px; /* Ajusta este valor según necesites */
      width: 100%;      /* Para que ocupe todo el ancho de la celda */
  }

  /* Opcional: mejorar visibilidad en celdas pequeñas */
  #modalRuta table td {
      vertical-align: middle;
  }
</style>
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
              <th> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list-ol" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5"/>
              <path d="M1.713 11.865v-.474H2c.217 0 .363-.137.363-.317 0-.185-.158-.31-.361-.31-.223 0-.367.152-.373.31h-.59c.016-.467.373-.787.986-.787.588-.002.954.291.957.703a.595.595 0 0 1-.492.594v.033a.615.615 0 0 1 .569.631c.003.533-.502.8-1.051.8-.656 0-1-.37-1.008-.794h.582c.008.178.186.306.422.309.254 0 .424-.145.422-.35-.002-.195-.155-.348-.414-.348h-.3zm-.004-4.699h-.604v-.035c0-.408.295-.844.958-.844.583 0 .96.326.96.756 0 .389-.257.617-.476.848l-.537.572v.03h1.054V9H1.143v-.395l.957-.99c.138-.142.293-.304.293-.508 0-.18-.147-.32-.342-.32a.33.33 0 0 0-.342.338zM2.564 5h-.635V2.924h-.031l-.598.42v-.567l.629-.443h.635z"/>
              </svg> Posición</th>
              <th> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
              <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/>
              <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0"/>
              </svg> Control</th>
              <th> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock-history" viewBox="0 0 16 16">
             <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7 7 0 0 0-.985-.299l.219-.976q.576.129 1.126.342zm1.37.71a7 7 0 0 0-.439-.27l.493-.87a8 8 0 0 1 .979.654l-.615.789a7 7 0 0 0-.418-.302zm1.834 1.79a7 7 0 0 0-.653-.796l.724-.69q.406.429.747.91zm.744 1.352a7 7 0 0 0-.214-.468l.893-.45a8 8 0 0 1 .45 1.088l-.95.313a7 7 0 0 0-.179-.483m.53 2.507a7 7 0 0 0-.1-1.025l.985-.17q.1.58.116 1.17zm-.131 1.538q.05-.254.081-.51l.993.123a8 8 0 0 1-.23 1.155l-.964-.267q.069-.247.12-.501m-.952 2.379q.276-.436.486-.908l.914.405q-.24.54-.555 1.038zm-.964 1.205q.183-.183.35-.378l.758.653a8 8 0 0 1-.401.432z"/>
             <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0z"/>
             <path d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5"/>
             </svg> Minutos</th>
             <th> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hourglass-bottom" viewBox="0 0 16 16">
             <path d="M2 1.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1-.5-.5m2.5.5v1a3.5 3.5 0 0 0 1.989 3.158c.533.256 1.011.791 1.011 1.491v.702s.18.149.5.149.5-.15.5-.15v-.7c0-.701.478-1.236 1.011-1.492A3.5 3.5 0 0 0 11.5 3V2z"/>
             </svg> Tolerancia</th>
             <th> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-day" viewBox="0 0 16 16">
             <path d="M4.684 11.523v-2.3h2.261v-.61H4.684V6.801h2.464v-.61H4v5.332zm3.296 0h.676V8.98c0-.554.227-1.007.953-1.007.125 0 .258.004.329.015v-.613a2 2 0 0 0-.254-.02c-.582 0-.891.32-1.012.567h-.02v-.504H7.98zm2.805-5.093c0 .238.192.425.43.425a.428.428 0 1 0 0-.855.426.426 0 0 0-.43.43m.094 5.093h.672V7.418h-.672z"/>
             <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/>
             </svg> Tipo Días</th>
             <th> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-radar" viewBox="0 0 16 16">
             <path d="M6.634 1.135A7 7 0 0 1 15 8a.5.5 0 0 1-1 0 6 6 0 1 0-6.5 5.98v-1.005A5 5 0 1 1 13 8a.5.5 0 0 1-1 0 4 4 0 1 0-4.5 3.969v-1.011A2.999 2.999 0 1 1 11 8a.5.5 0 0 1-1 0 2 2 0 1 0-2.5 1.936v-1.07a1 1 0 1 1 1 0V15.5a.5.5 0 0 1-1 0v-.518a7 7 0 0 1-.866-13.847"/>
             </svg> Ang Entrada</th>
             <th> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-radar" viewBox="0 0 16 16">
             <path d="M6.634 1.135A7 7 0 0 1 15 8a.5.5 0 0 1-1 0 6 6 0 1 0-6.5 5.98v-1.005A5 5 0 1 1 13 8a.5.5 0 0 1-1 0 4 4 0 1 0-4.5 3.969v-1.011A2.999 2.999 0 1 1 11 8a.5.5 0 0 1-1 0 2 2 0 1 0-2.5 1.936v-1.07a1 1 0 1 1 1 0V15.5a.5.5 0 0 1-1 0v-.518a7 7 0 0 1-.866-13.847"/>
             </svg> Ang Salida</th>
             <th><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-currency-dollar" viewBox="0 0 16 16">
             <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73z"/>
             </svg> Multa Atraso $</th>
              <th> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
  <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
</svg> Eliminar</th>
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
                    <td>
                        <input type="number" class="form-control" value="${row.posicion}">
                    </td>

                    <td>
                        <select class="form-control">
                            ${row.selectControl}
                        </select>
                    </td>

                    <td>
                        <input type="number" class="form-control" value="${row.minutos}">
                    </td>

                    <td>
                        <input type="number" class="form-control" value="${row.tolerancia}">
                    </td>

                    <td>
                        <select class="form-control">
                            <option value="LABORAL" ${row.tipoDias == 'LABORAL' ? 'selected' : ''}>LABORAL</option>
                            <option value="SABADO" ${row.tipoDias == 'SABADO' ? 'selected' : ''}>SÁBADO</option>
                            <option value="DOMINGO" ${row.tipoDias == 'DOMINGO' ? 'selected' : ''}>DOMINGO</option>
                            <option value="FESTIVO" ${row.tipoDias == 'FESTIVO' ? 'selected' : ''}>FESTIVO</option>
                        </select>
                    </td>

                    <td>
                        <input type="number" class="form-control" value="${row.anguloE}">
                    </td>

                    <td>
                        <input type="number" class="form-control" value="${row.anguloS}">
                    </td>

                    <td>
                        <input type="number" class="form-control" value="${row.multaAtraso}">
                    </td>

                    <td>
                        <button class="btn btn-danger" onclick="this.closest('tr').remove()">X</button>
                    </td>
                </tr>
            `;

            document.querySelector("#tablaEditarControles tbody")
            .insertAdjacentHTML("beforeend", fila);
        });

        $('#modalRuta').modal('show');
    })
    .catch(error => {
        console.error("Error en fetch:", error);
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
            <td>
                <select class="form-control">
                    <option value="L">Laboral</option>
                    <option value="S">Sábado</option>
                    <option value="D">Domingo</option>
                    <option value="F">Feriado</option>                   
                </select>
            </td>
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
        formData.append("tipoDias[]", fila.cells[4].querySelector("select").value);
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



