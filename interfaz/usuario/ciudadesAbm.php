<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../../assets/logo.jpg">
    <link rel="stylesheet" href="../../css/usuario/ciudadesAbm.css">
    <link rel="stylesheet" href="../../css/uicons-solid-rounded.css">
    <title>ABM Destinatarios</title>
</head>
<body class="body_p">
    <?php
        include 'barraNavegacion.php';
        include '../../helper/usuarioValidar.php';
        include '../../modelo/localidad.php';

        $localidad = new localidad();
        $listProv = $localidad->obtenerProvincias();

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['graba'])) {
            $ciudad = $_POST['ciudad'];
            $codPosC = $_POST['codpc'];
            $codPosL = $_POST['codpl'];
            $idProv = $_POST['provId'];
        
            $response = $localidad->crearLocalidad($ciudad, $codPosC, $codPosL, $idProv);
        
            // VER RESPUESTA
            //echo "<p>$response</p>";
        }


    ?>
    <header class="cabecera">
        <div class="usuario">
            <span><?php echo $_SESSION["usuario"]?></span>
        </div>
        <div class="seccion">
            <span>ABM Ciudades</span>
        </div>
        <div class = "contiene-carrito"></div>  
    </header>
    <div class="contenedor">
        <form class="content_form" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <div class="form">
            <label for="prov">Provincia:<span class="obliga">*</span></label>
            <input class="campo-form" id="prov" list="Provincia" name="prov" placeholder="Seleccionar Provincia..."><br>
            <input type="hidden" id="provId" name="provId">
            <datalist id="Provincia">
                <?php foreach ($listProv as $provincia): ?>
                    <option data-id="<?php echo $provincia['id']; ?>" value="<?php echo $provincia['nombre']; ?>"></option>
                <?php endforeach; ?>
            </datalist>
            <label for="ciudad">Ciudad:<span class="obliga">*</span></label>
            <input class="campo-form" id="ciudad" list="Ciudad" name="ciudad" placeholder="Ciudad" ><br>
            <label for="cod_p_c">Codigo Postal Corto</label>
            <input class="campo-form" id="cod_p_c" type="number" name= "codpc" placeholder="xxxx" maxlength="4"/><br>
            <label for="cod_p_l">Codigo Postal Largo<span class="obliga">*</span></label>
            <input class="campo-form" id="cod_p_l" type="text" name= "codpl" placeholder="xxxxxxxx" maxlength="8" /><br>
            <!-- <label for="destinatario">Destinatario Asignado:</label> -->    
        </div>
    </div>
        <div class="contiene-boton">
            <button class="btn btn_graba" type="submit" id="graba" name="graba" onclick="return checkCampos()">Grabar</button>
            <button class="btn btn_borra" type="button" id="borra" onclick="return checkCampos()">Borrar</button>
            <button class="btn" type="button" id="nuevo" onclick="limpiaForm()">Nuevo</button>
        </div>
        <p>* Los campos son Obligatorios</p>
        </form>
    </div>
    <div id="snackbar">
        <button id="confirm" class="btn btn_graba" type="button" onclick="eliminar()">Aceptar</button>
        <button id="volver" class="btn btn_borra" type="button" onclick="ocultar()">Cancelar</button>
    </div>
    <script src="../../js/usuario/ciudadesABM.js"></script>
    
</body>
</html>