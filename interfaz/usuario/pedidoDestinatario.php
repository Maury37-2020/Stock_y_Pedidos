<!DOCTYPE html>
<html>
  <head>
    <link rel="icon" type="image/x-icon" href="../../assets/logo.jpg">
    <link rel="stylesheet" href="../../css/usuario/destinatarioPedido.css">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <script src="https://kit.fontawesome.com/7568cd4100.js" crossorigin="anonymous"></script>
    <title>Destinatarios</title>
    <script>
      function buscarDirecciones(event){
        let razonSocial = document.getElementById('razonSoc').value;
        if (event.key === "Enter"){
          console.log(razonSocial)
        }
      }
  
    </script>
  </head>
  <body class="cuerpo">
  <div id="snackbar"></div>
  <?php
ob_start(); 

include '../../helper/usuarioValidar.php';
include '../../modelo/conexion.php';
include '../../modelo/destinatario.php';
include '../../modelo/carrito.php';
include '../../modelo/localidad.php';
include 'barraNavegacion.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$destinatarios = new destinatario(null,null,null,null,null);
$direcciones = new direccion(null, null, null, null,null);

$carrito_cab = new carrito_cab();
$idCarrito = $carrito_cab->obtener_carrito($_SESSION["id"]);
$usuario_id = $_SESSION["id"];
$direcciones = new direccion();
$localidad = new localidad();
$listProvincias = $localidad->obtenerProvincias();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['provinciaId'])) {
  $provinciaId = intval($_POST['provinciaId']);
  $ciudades = $localidad->obtenerLocalidadesPorProvincia($provinciaId);

  foreach ($ciudades as $ciudad) {
      echo "<option value='" . $ciudad['id'] . "' data-id='" . $ciudad['nombre'] . "'>" . $ciudad['nombre'] . "</option>";
  }
  exit();
}


if ($_POST) {
    if (isset($_POST['form_id'])) {
        switch ($_POST['form_id']) {
            case 'frmBuscar':
                $idDest = $_POST['selID'];
                $_SESSION['idDest'] = $idDest; 
                $DireccionesLista = $direcciones->obtenerDirecciones($idDest);
                break;
            case 'frmSeleccion':
                $direcciones->guardarDireccionCarrito($idCarrito, $_POST['direccion']);
                header('Location: articulos.php');
                exit();
                break;
            case 'frmNuevo':
                $idLocalidad = intval($_POST['id_localidad']);
                $direcciones->crearNuevaDireccion($_POST['idDest'],$_POST['dire'],$_POST['tel'],$_POST['hora_d'],$_POST['hora_h'],$_POST['localidadNombre']);
                break;
        }
    }
}else{
  $DireccionesLista = $direcciones->obtenerDireccionesDestinatarios($idCarrito);
}


$dest = $destinatarios->get_destinatarios();
echo '<script> var destinatarios = [' . json_encode($dest)  . '] </script>';

ob_end_flush(); 
?>

    <header id="cabecera">
        <div class="usuario">
          <span><?php echo $_SESSION['usuario'] ?></span>
      </div>
      <div class="seccion">
        <span>Destinatarios</span>
      </div>
      <div class="contiene-carrito">
        <span>ID:</span>
        <span id="carrito" class="carrito"><?php echo $idCarrito;?></span>
      </div>
    </header>
  
  <div class="container">
    <div class="form">
      <label for="razonSoc">Razón Social:</label><br> 
      <div class="input">
        <form id='frmBuscar' autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
          <input type="hidden" name="form_id" value="frmBuscar">
          <input type="hidden" id="selID" name="selID" value="0">
          <input class="campo-form" id="razonSoc" type="text" name="razonSoc" placeholder="Razón Social"
            value="<?php echo (isset($_POST['form_id']) and $_POST['form_id']==="frmBuscar") ? 
                    $_POST['razonSoc'] :
                    (isset($DireccionesLista[0]['razon_social'])?
                    $DireccionesLista[0]['razon_social']:
                    '');?>"  
            onkeyup="buscarDirecciones(event)">
        </form> 
        <button id="btn-add" class="btn-add" type="button" onclick="levantarModal()">+</button> <br>
      </div>
    </div>
  </div>

  <div>
    <form id='frmdireccion' autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
      <div class="grid-container">  
        <input type="hidden" name="form_id" value="frmSeleccion">
          <?php 
            if(isset($DireccionesLista)){
              foreach($DireccionesLista as $direccion){
            ?>
                  <div class="card">
                    <div class="cabeceracard">
                      <input type="radio" id="direccion_<?php echo $direccion['id']; ?>" name="direccion" 
                        value="<?php echo $direccion['id']?>" <?php echo $direccion['actual'] === 't' ? 'checked' : ''; ?>>
                    </div>
                    <label><b>Teléfono:&nbsp;</b><?php echo $direccion['telefono']?></label><br>
                    <label><b>Código Postal:&nbsp;</b><?php echo $direccion['cod_postal_corto']?></label><br>
                    <label><b>Provincia:&nbsp;</b><?php echo $direccion['provincia']?></label><br>
                    <label><b>Ciudad:&nbsp;</b><?php echo $direccion['ciudad']?></label><br>
                    <label><b>Dirección:&nbsp;</b><?php echo $direccion['direccion']?></label><br>
                  </div>
            <?php
              }
            }
          ?>
      </div>
      <div class="botoncontinuar">
        <button id="btn-confirm" class="btn-enviar" type="submit">Continuar</button>
      </div>
    </form>
  </div>

  <div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
      <span class="close">&times;</span>
      <form id='frmdireccion' autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <input type="hidden" name="form_id" value="frmNuevo">
        <input type="hidden" name="idDest" value="<?php echo isset($_SESSION['idDest']) ? htmlspecialchars($_SESSION['idDest']) : ''; ?>">
        <div class="Contenedor-form-modal">
          <div class="titulo-Modal">
            <h2>Nueva Dirección</h2>
          </div>
          <div class="contiene-form">
            <section class="parte1">
              <label for="prov">Provincia:</label><br>
              <input class="campo-form" id="prov" list="Provincia" name="prov" required placeholder="Escriba para buscar...">
              <datalist id="Provincia">
              <?php foreach ($listProvincias as $provincia): ?>
                <option data-id="<?php echo $provincia['id']; ?>" value="<?php echo $provincia['nombre']; ?>"></option>
              <?php endforeach; ?>
              </datalist>
              <label for="localidadInput">Ciudad:</label>
                <input type="hidden" id="ciudadId" name="id_localidad">  <!-- Cambiado para enviar el id -->
                <select class="campo-form" id="localidadInput" name="localidadNombre">
    <!-- Aquí se cargarán las opciones dinámicamente -->
                </select>

                <label for="dire">Dirección:</label><br>
                <input class="campo-form" id="dire" type="text" name="dire" required/>    
            </section>
            <section class="parte2">
              <label for="tel">Teléfono</label><br>
              <input class="campo-form" id="tel" type="number" name="tel" required/><br>
              
              <label for="hora_d">Horario de visita Desde - Hasta:</label><br>
              <input class="campo-form" id="hora_d" type="time" name="hora_d" placeholder="Hora Desde" minlength="4"/>
              <input class="campo-form" id="hora_h" type="time" name="hora_h" placeholder="Hora Hasta" minlength="4"/>          
            </section>
          </div>
          <div class="contiene-boton">
            <button id="btn-confirm_add" class="btn btn_graba" type="submit" name="nuevaDir">Agregar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <footer class="pie-de-pagina">
    <span>Sección 2 de 4 </span>
  </footer>
  <script src="../../js/usuario/destinatarioPedido.js"></script>
  <script>
document.getElementById('prov').addEventListener('input', function() {
    var provinciaInput = document.getElementById('prov');
    var selectedOption = Array.from(document.querySelectorAll('#Provincia option'))
                              .find(option => option.value === provinciaInput.value);

    if (selectedOption) {
        var provinciaId = selectedOption.getAttribute('data-id');
        console.log('Provincia ID:', provinciaId); // Depuración

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                var localidadSelect = document.getElementById('localidadInput');
                localidadSelect.innerHTML = ''; // Limpiar el contenido anterior

                var ciudades = xhr.responseText.trim(); // Datos recibidos del servidor
                if (ciudades) {
                    // Insertar las ciudades devueltas como opciones del select
                    localidadSelect.innerHTML = ciudades;
                } else {
                    console.log('No se recibieron ciudades.');
                }
            } else {
                console.error('Error en la solicitud:', xhr.status, xhr.statusText);
            }
        };

        xhr.onerror = function() {
            console.error('Error en la solicitud.');
        };

        xhr.send('provinciaId=' + encodeURIComponent(provinciaId));
    } else {
        console.log('No se encontró una opción seleccionada.');
    }
});
</script>
<script>
document.getElementById('localidadInput').addEventListener('change', function() {
    var selectedOption = this.options[this.selectedIndex];

    if (selectedOption) {
        // Establecer el valor del campo oculto con el data-id de la opción seleccionada
        document.getElementById('ciudadId').value = selectedOption.getAttribute('data-id');
        console.log(selectedOption);
    } else {
        // Si no hay opción seleccionada, limpiar el campo oculto
        document.getElementById('ciudadId').value = '';
    }
});
</script>
</body> 
</html>