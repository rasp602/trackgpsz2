<head>
<div class="modal-header bg-primary text-white">
    <h5 class="modal-title">Editar Ruta</h5>
    <button type="button" class="close text-white" data-dismiss="modal">
        <span>&times;</span>
    </button>
</div>
</head>  
    <div class="container-fluid">
        <h2>Rutas</h2>
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
     

        <div class="col-auto h5">
            <a href="?c=rutas&a=Crud"><i class='fas fa-user-tag' style='font-size:48px'></i>
                 <p>Agregar Ruta</p></a>
        </div>


        </div> 
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-condensed table-striped table-bordered table-hover">
                        <thead class="bg-primary" align="center">
                         
                            
                            <th class="sort asc h4">N° Variante</th>
                            <th class="sort asc h4">Nombre Variante</th>
                            <th class="sort asc h4">Posición</th>
                            <th class="sort asc h4">N° Control</th>
                            <th class="sort asc h4">Nombre Control</th>
                            <th class="sort asc h4">Minutos</th>
                            <th class="sort asc h4">Toleracia</th>
                            <th class="sort asc h4">Tipo Dias</th>
                            <th class="sort asc h4">Hora Desde</th>
                            <th class="sort asc h4">Hora Hasta</th>
                            <th class="sort asc h4">Tabla Valores</th>
   
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
    
                <!-- Modal de Edición -->
<div class="modal fade" id="editarModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editarModalLabel">Editar Ruta</h5>
              <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="formEditar" method="POST">
                    <input type="hidden" id="edit_idRuta" name="idRuta">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_idVariante" class="form-label">N° Variante</label>
                            <select class="form-control" id="edit_idVariante" name="idVariante" required>
                                <option value="">Seleccione una variante</option>
                                <?php
                                // Cargar variantes para el select
                                require 'bd/config.php';
                                $sql_variantes = "SELECT idVariante, nombreVariante FROM variante ORDER BY nombreVariante";
                                $result_variantes = $conn->query($sql_variantes);
                                while($row_var = $result_variantes->fetch_assoc()) {
                                    echo '<option value="'.$row_var['idVariante'].'">'.$row_var['nombreVariante'].'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="edit_nombreVariante" class="form-label">Nombre Variante</label>
                            <input type="text" class="form-control" id="edit_nombreVariante" name="nombreVariante" readonly>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_posicion" class="form-label">Posición</label>
                            <input type="number" class="form-control" id="edit_posicion" name="posicion" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="edit_idControl" class="form-label">N° Control</label>
                            <select class="form-control" id="edit_idControl" name="idControl" required>
                                <option value="">Seleccione un control</option>
                                <?php
                                // Cargar controles para el select
                                $sql_controles = "SELECT idControl, nombreControl FROM controles ORDER BY nombreControl";
                                $result_controles = $conn->query($sql_controles);
                                while($row_con = $result_controles->fetch_assoc()) {
                                    echo '<option value="'.$row_con['idControl'].'">'.$row_con['idControl'].' - '.$row_con['nombreControl'].'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_nombreControl" class="form-label">Nombre Control</label>
                            <input type="text" class="form-control" id="edit_nombreControl" name="nombreControl" readonly>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="edit_minutos" class="form-label">Minutos</label>
                            <input type="number" class="form-control" id="edit_minutos" name="minutos" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_tolerancia" class="form-label">Tolerancia</label>
                            <input type="number" class="form-control" id="edit_tolerancia" name="tolerancia" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="edit_tipoDias" class="form-label">Tipo Días</label>
                            <select class="form-control" id="edit_tipoDias" name="tipoDias" required>
                                <option value="L">Lunes a Viernes</option>
                                <option value="S">Sábados</option>
                                <option value="D">Domingos</option>
                                <option value="T">Todos los días</option>
                                <option value="F">Solo festivos</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_horaDesde" class="form-label">Hora Desde</label>
                            <input type="time" class="form-control" id="edit_horaDesde" name="horaDesde" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="edit_horaHasta" class="form-label">Hora Hasta</label>
                            <input type="time" class="form-control" id="edit_horaHasta" name="horaHasta" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="edit_idTablaValores" class="form-label">Tabla Valores</label>
                            <input type="number" class="form-control" id="edit_idTablaValores" name="idTablaValores">
                        </div>
                    </div>
                    <div id="mensajeEditar" class="alert d-none" role="alert"></div>
                </form>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="guardarEdicion()">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>

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

            let url = "rutas/vista/loadRutas.php"
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
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
    <!-- Bootstrap core JS -->
    <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>-->


<script>
    // Función para cargar los datos de la ruta a editar
function editarRuta(idRuta) {
    // Realizar petición para obtener los datos de la ruta
    let url = "rutas/vista/getRuta.php"
    let formaData = new FormData()
    formaData.append('idRuta', idRuta)
    
    fetch(url, {
        method: "POST",
        body: formaData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Llenar el formulario con los datos
            document.getElementById('edit_idRuta').value = data.datos.idRuta
            document.getElementById('edit_idVariante').value = data.datos.idVariante
            document.getElementById('edit_nombreVariante').value = data.datos.nombreVariante
            document.getElementById('edit_posicion').value = data.datos.posicion
            document.getElementById('edit_idControl').value = data.datos.idControl
            document.getElementById('edit_nombreControl').value = data.datos.nombreControl
            document.getElementById('edit_minutos').value = data.datos.minutos
            document.getElementById('edit_tolerancia').value = data.datos.tolerancia
            document.getElementById('edit_tipoDias').value = data.datos.tipoDias
            document.getElementById('edit_horaDesde').value = data.datos.horaDesde
            document.getElementById('edit_horaHasta').value = data.datos.horaHasta
            document.getElementById('edit_idTablaValores').value = data.datos.idTablaValores
            
            // Mostrar el modal
            var modal = new bootstrap.Modal(document.getElementById('editarModal'))
            modal.show()
        } else {
            alert('Error al cargar los datos: ' + data.mensaje)
        }
    })
    .catch(err => {
        console.log(err)
        alert('Error al cargar los datos')
    })
}

// Función para guardar los cambios
function guardarEdicion() {
    let form = document.getElementById('formEditar');
    let formData = new FormData(form);
    let mensajeDiv = document.getElementById('mensajeEditar');

    // Limpiar mensaje previo
    mensajeDiv.className = 'alert d-none';
    mensajeDiv.innerText = '';

    fetch("rutas/vista/actualizarRuta.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log("Respuesta:", data);

        if (data.success) {
            // Mostrar mensaje de éxito dentro del modal
            mensajeDiv.className = 'alert alert-success';
            mensajeDiv.innerText = '¡Cambios guardados correctamente!';

            // Opcional: refrescar tabla después de 1-2 segundos
            setTimeout(function () {
                getData();
                // Si quieres, también puedes ocultar el mensaje después de un tiempo
                mensajeDiv.className = 'alert d-none';
            }, 1500);

        } else {
            // Mostrar mensaje de error dentro del modal
            mensajeDiv.className = 'alert alert-danger';
            mensajeDiv.innerText = 'Error: ' + data.mensaje;
        }
    })
    .catch(err => {
        console.log("Error fetch:", err);
        mensajeDiv.className = 'alert alert-danger';
        mensajeDiv.innerText = "Error al conectar con el servidor";
    });
}

// Actualizar nombre de variante cuando se selecciona una
document.getElementById('edit_idVariante')?.addEventListener('change', function() {
    let idVariante = this.value
    if (idVariante) {
        let url = "rutas/vista/getVariante.php"
        let formaData = new FormData()
        formaData.append('idVariante', idVariante)
        
        fetch(url, {
            method: "POST",
            body: formaData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('edit_nombreVariante').value = data.nombre
            }
        })
    }
})

// Actualizar nombre de control cuando se selecciona uno
document.getElementById('edit_idControl')?.addEventListener('change', function() {
    let idControl = this.value
    if (idControl) {
        let url = "rutas/vista/getControl.php"
        let formaData = new FormData()
        formaData.append('idControl', idControl)
        
        fetch(url, {
            method: "POST",
            body: formaData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('edit_nombreControl').value = data.nombre
            }
        })
    }
})
</script>
