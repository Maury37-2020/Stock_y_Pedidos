<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../../assets/logo.jpg">
    <link rel="stylesheet" href="../../css/usuario/destinatariosCiudades.css">
    <link rel="stylesheet" href="../../css/uicons-solid-rounded.css">
    <title>Direcciones Destinatarios</title>
</head>
<body class="body_p">
    <?php
        include 'barraNavegacion.php';
        include '../../helper/usuarioValidar.php';
        include '../../modelo/localidad.php';
        include '../../modelo/destinatario.php';

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);


        // Verificar si el parámetro 'id' está presente en la URL
        if (isset($_GET['id'])) {
            $idDestinatario = intval($_GET['id']);
        }else{
            $idDestinatario = intval($_POST['idDestinatario']);
        }

        $localidad = new localidad();
        $direcciones = new direccion();
        $listProvincias = $localidad->obtenerProvincias();
        $listDirecc = $direcciones->obtenerDireccUnDest($idDestinatario);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['provinciaId'])) {
                $provinciaId = intval($_POST['provinciaId']);
                $ciudades = $localidad->obtenerLocalidadesPorProvincia($provinciaId);

                foreach ($ciudades as $ciudad) {
                    echo "<option data-id='" . $ciudad['id'] . "' value='" . $ciudad['nombre'] . "'></option>";
                }
                exit();
            }
        }
        
        if (isset($_POST['graba'])) {
            $idDestinatario = intval($_POST['idDestinatario']); // Recuperar idDestinatario desde POST
            $idLocalidad= intval($_POST['ciudadId']);
            $direcciones->crearNuevaDireccion($idDestinatario, $_POST['tel'], $_POST['direcc'], $_POST['horaD'], $_POST['horaH'], $idLocalidad);
            header("Location: ".$_SERVER['PHP_SELF']."?id=".$idDestinatario);
            exit();

            }else if(isset($_POST['guardarModal'])){
                $idDir = $_POST['direccion_ID'];
                $idDestinatario = intval($_POST['idDestinatario']);
                $direccion = $_POST['direccModal'];
                $telefono = $_POST['telefonoModal'];
                $horaD = $_POST['horaDModal'];
                $horaH = $_POST['horaHModal'];
        
                $direcciones->modificarDireccionDest($idDir,$direccion,$telefono,$horaD,$horaH);
        
                header("Location: ".$_SERVER['PHP_SELF']."?id=".$idDestinatario);
                exit();
            }else if(isset($_POST['btnEliminar'])){

                $idDireccion = $_POST['id_destinatario'];
                $direcciones->eliminarUnaDireccion($idDireccion);

                header("Location: ".$_SERVER['PHP_SELF']."?id=".$idDestinatario);
                exit;
            }

    ?>
    <div id="snackbar"></div>
   <header class="cabecera">
        <div class="usuario">
            <span><?php echo $_SESSION["usuario"] ?></span>
        </div>
        <div class="seccion">
            <span>Direcciones Destinatarios</span>
        </div>
        <div class="contiene-carrito"></div>
    </header>
    <div class="contenedor">
        <form class="content_form" autocomplete="off" action="" method="POST">
            <!-- Campo oculto para pasar el idDestinatario -->
            <?php if ($idDestinatario !== null): ?>
                <input type="hidden" name="idDestinatario" value="<?php echo $idDestinatario; ?>">
            <?php endif; ?>

            <div class="form">
                <fieldset class="field1">
                    <legend>Nueva Dirección:</legend>
                    <div class="parte1">
                        <div class="col1_t">
                            <label for="prov">Provincia:<span class="obliga">*</span></label>
                            <input class="campo-form" id="prov" list="Provincia" name="prov" placeholder="Seleccionar Provincia...">
                            <input type="hidden" id="provId" name="provId">
                            <datalist id="Provincia">
                                <?php foreach ($listProvincias as $provincia): ?>
                                    <option data-id="<?php echo $provincia['id']; ?>" value="<?php echo $provincia['nombre']; ?>"></option>
                                <?php endforeach; ?>
                            </datalist>
                        </div>
                        <div class="col1_t">
                            <label for="ciudad">Ciudad:<span class="obliga">*</span></label>
                            <input class="campo-form" id="ciudad" list="Ciudad" name="ciudad" placeholder="Escriba para buscar...">
                            <input type="hidden" id="ciudadId" name="ciudadId">
                            <datalist id="Ciudad"></datalist>
                        </div>
                       
                        <div class="col1_t">
                            <label for="direcc">Dirección:<span class="obliga">*</span></label>
                            <input class="campo-form" id="direcc" type="text" name="direcc" placeholder="xxxxxxxx"/>
                        </div>
                        <div class="col1_t">
                            <label for="tel">Telefono:<span class="obliga">*</span></label>
                            <input class="campo-form" id="tel" type="number" name="tel" step="any" placeholder="xxxxxxxx"/>
                        </div>
                        <div class="col1_t">
                            <label for="horaD">Horario desde:</label>
                            <input class="campo-form time" id="horaD" type="time" name="horaD"/>
                        </div>
                        <div class="col1_t">
                            <label for="horaH">Horario hasta:</label>
                            <input class="campo-form time" id="horaH" type="time" name="horaH"/>
                        </div>
                        <div class="col2_t">
                            <button class="btn btn_graba" type="submit" id="graba" name="graba" onclick="return checkCampos2()" title="Agregar">
                                <i class="fi fi-sr-plus-small"></i>
                            </button>
                        </div>
                    </div>
                </fieldset>
                <section class="parte2">
                    <fieldset class="field2">
                        <legend>Destinatarios:</legend>
                        <table>
                            <tr>
                                <th class="col_t_3">Provincia</th>
                                <th class="col_t_3">Ciudad</th>
                                <th class="col_t_1">Dirección</th>
                                <th class="col_t_1">Telefono</th>
                                <th class="col_t_1">Hora desde</th>
                                <th class="col_t_1" colspan="2">Hora hasta</th>
                            </tr>
                            <?php foreach ($listDirecc as $direccion): ?>
                                <tr>
                                    <td class="col1"><?php echo $direccion['provincia'] ?></td>
                                    <td class="col2"><?php echo $direccion['ciudad'] ?></td>
                                    <td class="col3"><?php echo $direccion['direccion'] ?></td>
                                    <td class="col4"><?php echo $direccion['telefono'] ?></td>
                                    <td class="col5"><?php echo $direccion['horaD'] ?></td>
                                    <td class="col6"><?php echo $direccion['horaH'] ?></td>
                                    <td class="col7">
                                        <button class="btn" title="Editar dirección" type="button" onclick="mostrarModalEditarDirecciones(<?php echo $direccion['id']; ?>,'<?php echo $direccion['direccion']; ?>', '<?php echo $direccion['telefono']; ?>',
                                        '<?php echo $direccion['horaD']; ?>', '<?php echo $direccion['horaH']; ?>')">
                                            <i class="fi fi-rs-map-marker-edit"></i>
                                        </button>
                                        <button class="btn btn_borra" title="Eliminar dirección" type="button" onclick="mostrarModalConfirmacion(<?php echo $direccion['id'] ?>)">
                                            <i class="fi fi-rr-delete-user"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </fieldset>
                </section>
                <p>* Los campos son Obligatorios</p>
            </div>
        </form>
    </div>
    <div class="modal">
        <span class="close" title="Close Modal">×</span>
        <div class="modal-content">
            <div class="container">
                <img src="../../assets/alerta.svg" alt="Alerta"> <h1>ATENCIÓN</h1>
                <p>¿Está seguro que desea eliminar la dirección?</p>
                <form id="formEliminar" method="POST">
                    <input type="hidden" name="id_destinatario" id="id_destinatario">
                    <div class="clearfix">
                        <button type="button" class="btn" onclick="cancelar(0)">Cancelar</button>
                        <button type="submit" class="btn btn_elim" name="btnEliminar">Borrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal" id="modalForm">
        <div class="modal-content">
        <form class="content_form" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <div class="container">
                    <h3>Editar Dirección</h3><br>
                    <input type="hidden" id="direccion_ID" name="direccion_ID">
                    <input type="hidden" name="idDestinatario" value="<?php echo $idDestinatario; ?>">
                    <label for="prov">Dirección:</label>
                    <input class="campo-form" id="direccModal" name="direccModal">
                    <label for="ciudad">Telefono:</label>
                    <input class="campo-form" id="telefonoModal"  type="number" name="telefonoModal" >
                    <label for="cod_p_c">Hora desde</label>
                    <input class="campo-form" id="horaDModal" type="time" name="horaDModal" />
                    <label for="cod_p_l">Hora hasta</label>
                    <input class="campo-form" id="horaHModal" type="time" name="horaHModal" />
                    <div class="clearfix">
                        <button type="button" class="btn" onclick="cancelar(1)">Cancelar</button>
                        <button type="submit" class="btn btn_graba" name="guardarModal" onclick="checkCampos2()">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="../../js/usuario/destinatariosABM.js"></script>
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
                var ciudadDatalist = document.getElementById('Ciudad');
                ciudadDatalist.innerHTML = xhr.responseText;
                document.getElementById('provId').value = provinciaId;
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
    document.getElementById('ciudad').addEventListener('input', function() {
    var inputValue = this.value;
    var datalist = document.getElementById('Ciudad');
    var options = datalist.querySelectorAll('option');
    
    // Buscar la opción que coincide con el valor del input
    for (var i = 0; i < options.length; i++) {
        if (options[i].value === inputValue) {
            // Establecer el valor del campo oculto con el data-id de la opción seleccionada
            document.getElementById('ciudadId').value = options[i].getAttribute('data-id');
            return;
        }
    }

    // Si no se encuentra una coincidencia, limpiar el campo oculto
    document.getElementById('ciudadId').value = '';

});
</script>
<script>
    const btn_a_2 = document.getElementsByClassName('back')
    btn_a_2[0].href = 'DestinatariosAbm.php'
</script>
</body>
</html>