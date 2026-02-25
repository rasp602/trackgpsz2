<div class="modal fade" id="modalEditarRuta" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <div class="modal-header bg-warning text-white">
        <h5 class="modal-title">Editar Ruta</h5>
        <button type="button" class="close text-white" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body">

        <!-- Seleccionar Variante -->
        <div class="form-group">
          <label>Seleccione Variante</label>
          <select id="editar_idVariante" class="form-control">
              <option value="">Seleccione</option>
              <?php
              $sql_variantes = "SELECT idVariante, nombreVariante FROM variante ORDER BY nombreVariante";
              $result_variantes = $conn->query($sql_variantes);
              while($row = $result_variantes->fetch_assoc()){
                  echo '<option value="'.$row['idVariante'].'">'.$row['nombreVariante'].'</option>';
              }
              ?>
          </select>
        </div>

        <hr>

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
              <th>Hora Desde</th>
              <th>Hora Hasta</th>
              <th>Tabla Valores</th>
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
<script>

function abrirModalEditar(idVariante){

    document.getElementById("modalEditarRuta").querySelector("tbody").innerHTML = "";
    document.getElementById("editar_idVariante").value = idVariante;

    fetch("variantes/vista/obtener_ruta.php?idVariante="+idVariante)
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
                    <td><input type="time" class="form-control" value="${row.horaDesde}"></td>
                    <td><input type="time" class="form-control" value="${row.horaHasta}"></td>
                    <td><input type="number" class="form-control" value="${row.idTablaValores}"></td>
                    <td><button class="btn btn-danger" onclick="this.closest('tr').remove()">X</button></td>
                </tr>
            `;

            document.querySelector("#tablaEditarControles tbody")
            .insertAdjacentHTML("beforeend", fila);
        });

        $('#modalEditarRuta').modal('show');
    });
}
</script>

<script>

function guardarEdicionRuta(){

    let variante = document.getElementById("editar_idVariante").value;
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
        formData.append("horaDesde[]", fila.cells[5].querySelector("input").value);
        formData.append("horaHasta[]", fila.cells[6].querySelector("input").value);
        formData.append("idTablaValores[]", fila.cells[7].querySelector("input").value);
    });

    fetch("variantes/vista/actualizar_ruta.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.text())
    .then(data => {
        alert("Ruta actualizada correctamente");
        location.reload();
    });
}
</script>
<script>

function agregarFilaEditar(){

    let variante = document.getElementById("editar_idVariante").value;

    if(variante == ""){
        alert("Debe seleccionar una variante primero");
        return;
    }

    let fila = `
        <tr data-idRuta="0">
            <td><input type="number" class="form-control"></td>
            <td>
                <select class="form-control">
                    <option value="">Seleccione</option>
                    <?php
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
            <td><input type="time" class="form-control"></td>
            <td><input type="time" class="form-control"></td>
            <td><input type="number" class="form-control"></td>
            <td>
                <button type="button" class="btn btn-danger"
                    onclick="this.closest('tr').remove()">
                    X
                </button>
            </td>
        </tr>
    `;

    document.querySelector("#tablaEditarControles tbody")
    .insertAdjacentHTML("beforeend", fila);
}

</script>