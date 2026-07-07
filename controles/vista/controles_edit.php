<?php
	error_reporting(E_ERROR | E_PARSE); // Desactiva la notificación y warnings de error en php.
/*  date_default_timezone_set("America/caracas");
  $hora=date("H:i:s");
  echo $hora;*/
?>

<!-- Include Date Range Picker -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css">

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>



  <?php include_once 'menu_principal/vista/Menu_Usuarios.php'; ?>   
  <?php session_start();
      if (isset($_SESSION['usuario'])) {
          $usuario = $_SESSION['usuario'];
          $cliente = $usuario->id_user;
      }
    ?>       

  <?php if (isset($_GET["repetido"])) echo '<div class="alert alert-warning" role="alert">El Bus que intenta ingresar ya se encuentra registrado...</div>';?> 

  <div class="container-fluid">

      <div class="row">         
      <div class="col-md-12">
            <h2 align="center" class="titulos">Nuevo Control</h2>
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Datos del control</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="form1" action="?c=controles&a=Guardar" name="form1" method="post" enctype="multipart/form-data">
              <div class="col-md-6">
                <div class="card-body">
                  <div class="form-group">
                    <input type="hidden" class="form-control" id="idControl" name="idControl" value="<?php echo $vte->idControl;?>">
                    <label for="exampleInputEmail1">Nombre control</label>
                   <input type="text" class="form-control" id="nombreControl" name="nombreControl" value="<?php echo $vte->nombreControl;?>" maxlength="50" placeholder="Ingresa el nombre del control">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Abreviación</label>
                    <input type="text" class="form-control" id="abreviacionControl" name="abreviacionControl" value="<?php echo $vte->abreviacionControl;?>"  placeholder="Ingresa la Abreviación">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Logitud 1</label>
                    <input type="text" class="form-control" id="longitud1" name="longitud1" value="<?php echo $vte->logitud1;?>"  placeholder="Ingresa la Abreviación">
                  </div>   

                  <div class="form-group">
                    <label for="exampleInputPassword1">Logitud 2</label>
                    <input type="text" class="form-control" id="longitud2" name="longitud2" value="<?php echo $vte->longitud2;?>"  placeholder="Ingresa la Abreviación">
                  </div>  
                  <div class="form-group">
                    <label for="exampleInputPassword1">Latitud 1</label>
                    <input type="text" class="form-control" id="latitud1" name="latitud1" value="<?php echo $vte->latitud1;?>"  placeholder="Ingresa la Abreviación">
                  </div>  
                  <div class="form-group">
                    <label for="exampleInputPassword1">Latitud 2</label>
                    <input type="text" class="form-control" id="latitud2" name="latitud2" value="<?php echo $vte->latitud2;?>"  placeholder="Ingresa la Abreviación">
                  </div>                    


                  <div class="form-group">
                    <label for="exampleInputEmail1">Angulo de Entrada</label>
                    <input type="text" class="form-control" id="anguloEntrada" name="anguloEntrada" value="<?php echo $vte->anguloEntrada;?>" placeholder="Ingresa el angulo de entrada"onkeypress="return numeros(event)">
                  </div> 
                  <div class="form-group">
                    <label for="exampleInputEmail1">Tolerancia Entrada</label>
                    <input type="text" class="form-control" id="toleraciaEntrada" name="toleraciaEntrada" value="<?php echo $vte->toleraciaEntrada;?>" placeholder="Ingresa la Tolerancia" onkeypress="return numeros(event)">
                  </div> 



                  <input type="hidden" class="form-control" id="estadoControl" name="estadoControl" value="A">              
                </div>
              </div>
              <div class="col-md-6">
                <div class="card-body">
                 <div class="form-group">
                    <label for="exampleInputPassword1">Tipo de Control:</label>
                    <select name="tipoControl" id="tipoControl" class="form-control">
                         <option value="NORMAL">Normal</option>
                         <option value="TERMINAL">Terminal</option>                       
                    </select>
                  </div>  
    

                  <div class="form-group">
                    <label for="exampleInputEmail1">Velocidad max</label>
                    <input type="text" class="form-control" id="velMax" name="velMax" value="<?php echo $vte->velMax;?>" >
                  </div> 
                 <div class="form-group">
                    <label for="exampleInputPassword1">Visible:</label>
                    <select name="visible" id="visible" class="form-control">
                         <option value="0">Si</option>
                         <option value="1">No</option>                       
                    </select>
                  </div>  
                 <div class="form-group">
                    <label for="exampleInputPassword1">Sentido:</label>
                    <select name="sentido" id="sentido" class="form-control">
                         <option value="I">IDA</option>
                         <option value="R">REGRESO</option>                       
                    </select>
                  </div>  
                  
                  <button type="button" class="btn btn-info" onclick="abrirMapaGeocerca()">
    Configurar Geocerca
</button>
<div class="modal fade" id="modalGeocerca" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document" style="max-width:95%;">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Configurar Geocerca del Control</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div id="mapaGeocerca" style="width:100%; height:70vh;"></div>

                <div class="mt-3">
                    <button type="button" class="btn btn-success" onclick="guardarGeocerca()">
                        Guardar Geocerca
                    </button>

                    <button type="button" class="btn btn-warning" onclick="limpiarGeocerca()">
                        Limpiar
                    </button>

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
 
      <div id="mapa" style="height: 400px;"></div>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDV2KA_R534-_7ZGNn8MYKPzUHOAQiwlvI&callback=initMap"></script>


<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>var map = L.map('mapa').setView([-23.6467,-70.3976], 13);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);</script>

                  <div class="form-group">             
                    <button type="submit" class="btn btn-primary">Registrar</button>
                    <input type="button" id="cancelar" class="btn btn-danger" name="Cancelar" value="Cancelar" onClick="location.href='?c=menu_principal&a=menu_usuarios'">
                  </div>                 
                </div>
              </div>              
                <!-- /.card-body -->


              </form>
            </div>


            </div>
            
        </div>
   </div>    
   </div>    
<br>
   </div> 
 <script>
    function numeros(e){
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = " 0123456789";
    especiales = [9,13,8,37,39,46,38,46,164];
 
    tecla_especial = false
    for(var i in especiales){
 if(key == especiales[i]){
     tecla_especial = true;
     break;
        } 
    }
 
    if(letras.indexOf(tecla)==-1 && !tecla_especial)
        return false;
}
    </script>



      <script>
       
       function sololetras(e){
           key= e.keyCode || e.which;
           teclado= String .fromCharCode(key).toLowerCase();
           letras="abcdefghijklmnñopqrstuvwxyz"
           especiales="13-9-8-37-38-46-164";
           
           teclado_especial=false;
           
           for(var i in especiales){
               
               if(key==especiales[i]){
                   teclado_especial=true;break;
                   
                   }
               }
           if(letras.indexOf(teclado)==-1 && !teclado_especial){
               
               return false;
               
               }
           
           }
       
       
       </script> 

 <script>
       
function checkRut(rut) {
    // Despejar Puntos
    var valor = rut.value.replace('.','');
    // Despejar Guión
    valor = valor.replace('-','');
    
    // Aislar Cuerpo y Dígito Verificador
    cuerpo = valor.slice(0,-1);
    dv = valor.slice(-1).toUpperCase();
    
    // Formatear RUN
    rut.value = cuerpo + '-'+ dv
    
    // Si no cumple con el mínimo ej. (n.nnn.nnn)
    if(cuerpo.length < 7) { rut.setCustomValidity("RUT Incompleto"); return false;}
    
    // Calcular Dígito Verificador
    suma = 0;
    multiplo = 2;
    
    // Para cada dígito del Cuerpo
    for(i=1;i<=cuerpo.length;i++) {
    
        // Obtener su Producto con el Múltiplo Correspondiente
        index = multiplo * valor.charAt(cuerpo.length - i);
        
        // Sumar al Contador General
        suma = suma + index;
        
        // Consolidar Múltiplo dentro del rango [2,7]
        if(multiplo < 7) { multiplo = multiplo + 1; } else { multiplo = 2; }
  
    }
    
    // Calcular Dígito Verificador en base al Módulo 11
    dvEsperado = 11 - (suma % 11);
    
    // Casos Especiales (0 y K)
    dv = (dv == 'K')?10:dv;
    dv = (dv == 0)?11:dv;
    
    // Validar que el Cuerpo coincide con su Dígito Verificador
    if(dvEsperado != dv) { rut.setCustomValidity("RUT Inválido"); return false; }
    
    // Si todo sale bien, eliminar errores (decretar que es válido)
    rut.setCustomValidity('');
}
       
       </script> <script>
let mapaGeocerca = null;
let drawnItems = null;
let drawControl = null;
let poligonoActual = null;

const idControlActual = document.getElementById('idControl').value;

function abrirMapaGeocerca() {
    $('#modalGeocerca').modal('show');

    setTimeout(() => {
        if (!mapaGeocerca) {
            iniciarMapaGeocerca();
        }

        mapaGeocerca.invalidateSize();
        cargarGeocercaExistente();
    }, 400);
}

function iniciarMapaGeocerca() {
    mapaGeocerca = L.map('mapaGeocerca').setView([-23.6509, -70.3975], 14);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 20,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(mapaGeocerca);

    drawnItems = new L.FeatureGroup();
    mapaGeocerca.addLayer(drawnItems);

    drawControl = new L.Control.Draw({
        draw: {
            polygon: {
                allowIntersection: false,
                showArea: true,
                shapeOptions: {
                    color: '#2563eb',
                    weight: 4
                }
            },
            rectangle: {
                shapeOptions: {
                    color: '#16a34a',
                    weight: 4
                }
            },
            polyline: false,
            circle: false,
            circlemarker: false,
            marker: false
        },
        edit: {
            featureGroup: drawnItems,
            remove: true
        }
    });

    mapaGeocerca.addControl(drawControl);

    mapaGeocerca.on(L.Draw.Event.CREATED, function (event) {
        drawnItems.clearLayers();

        poligonoActual = event.layer;
        drawnItems.addLayer(poligonoActual);

        centrarPoligono();
    });

    mapaGeocerca.on(L.Draw.Event.EDITED, function () {
        const layers = drawnItems.getLayers();
        poligonoActual = layers.length > 0 ? layers[0] : null;
    });

    mapaGeocerca.on(L.Draw.Event.DELETED, function () {
        poligonoActual = null;
    });
}

async function cargarGeocercaExistente() {
    if (!idControlActual || idControlActual <= 0) {
        return;
    }

    try {
        const response = await fetch(`?c=controles&a=ObtenerGeocerca&idControl=${idControlActual}`);
        const json = await response.json();

        if (!json.success || !json.data || json.data.length === 0) {
            return;
        }

        drawnItems.clearLayers();

        const puntos = json.data.map(p => [
            parseFloat(p.latitud),
            parseFloat(p.longitud)
        ]);

        poligonoActual = L.polygon(puntos, {
            color: '#2563eb',
            weight: 4,
            fillOpacity: 0.25
        });

        drawnItems.addLayer(poligonoActual);
        centrarPoligono();

    } catch (error) {
        console.error('Error cargando geocerca:', error);
        alert('Error cargando geocerca existente');
    }
}

function obtenerPuntosPoligono() {
    if (!poligonoActual) {
        return [];
    }

    let latLngs = poligonoActual.getLatLngs();

    if (Array.isArray(latLngs[0])) {
        latLngs = latLngs[0];
    }

    return latLngs.map(p => ({
        lat: p.lat,
        lng: p.lng
    }));
}

async function guardarGeocerca() {
    if (!idControlActual || idControlActual <= 0) {
        alert('Primero debe guardar el control antes de configurar la geocerca.');
        return;
    }

    const puntos = obtenerPuntosPoligono();

    if (puntos.length < 3) {
        alert('Debe dibujar un polígono con al menos 3 puntos.');
        return;
    }

    try {
        const response = await fetch('?c=controles&a=GuardarGeocerca', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                idControl: idControlActual,
                puntos: puntos
            })
        });

        const json = await response.json();

        if (json.success) {
            alert(json.message || 'Geocerca guardada correctamente');
            $('#modalGeocerca').modal('hide');
        } else {
            alert(json.message || 'No se pudo guardar la geocerca');
        }

    } catch (error) {
        console.error('Error guardando geocerca:', error);
        alert('Error guardando geocerca');
    }
}

function limpiarGeocerca() {
    if (!drawnItems) return;

    if (confirm('¿Seguro que desea borrar el polígono actual?')) {
        drawnItems.clearLayers();
        poligonoActual = null;
    }
}

function centrarPoligono() {
    if (!poligonoActual || !mapaGeocerca) return;

    const bounds = poligonoActual.getBounds();

    if (bounds.isValid()) {
        mapaGeocerca.fitBounds(bounds, {
            padding: [30, 30]
        });
    }
}
</script>
