<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/x-icon" href="../../assets/logo.jpg">  
    <link rel="stylesheet" href="../../css/usuario/pedidoDatos.css">
    <link rel="stylesheet" href="../../css/uicons-solid-rounded.css">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <script src="https://kit.fontawesome.com/7568cd4100.js" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <title>Pedido</title>
</head>

<body class="body_p">

    <?php
    ob_start();
        include '../../helper/usuarioValidar.php';
        include 'barraNavegacion.php';
        include("../../modelo/carrito.php");

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $carrito_cab = new carrito_cab();

    $idCarrito = $carrito_cab->obtener_carrito($_SESSION["id"]);

    $usuario_id = $_SESSION["id"];

    if($_POST){

        if($carrito_cab->insertar_carritoPrueba($usuario_id,$_POST['prioridad'],$_POST['fechaEntrega'],$_POST['campania'])){
            header('Location:pedidoDestinatario.php');
            exit; 
        } else {
            echo "<script>showSnackbar('".htmlspecialchars('Hubo un error', ENT_QUOTES, 'UTF-8')."');</script>";
            };
        }

        $prioridad = 0;
        $fechaEntrega = '';
        $campania = '';

        if($idCarrito != 0){
            $datoCarrito = $carrito_cab->obtener_datos_wizardUno($usuario_id);

            if($datoCarrito){
                $prioridad = $datoCarrito->getPrioridad();
                $fechaEntrega =date('Y-m-d',strtotime($datoCarrito->getFecha_entrega()));
                $campania = $datoCarrito->getCampania();
                
            }
            
        }
    ?>
    <div id="snackbar"></div>
    
    <header class="cabecera">
        <div class="usuario">
            <span><?php echo $_SESSION["usuario"]?></span>
        </div>
        <div class="seccion">
            <span>Pedidos</span>
        </div>
        <div class = "contiene-carrito">
            <span>ID:</span>
            <span id="carrito" class="carrito"><?php echo $idCarrito;?></span>
        </div>  
    </header>
    <div class="contenedor">      
        <form class="form-datos-finales" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <div class="datos-finales">
                <p>Prioridad:</p>
                <div class="contComponentes">
                    <input class="campo-form" type="radio" id="r-u" name="prioridad" value="0" <?php echo ($prioridad == 0) ? 'checked' : ''; ?>>
                    <label for="r-u">Normal</label><br>
                </div>
                <div class="contComponentes">
                    <input class="campo-form" type="radio" id="r-n" name="prioridad" value="1" <?php echo ($prioridad == 1) ? 'checked' : ''; ?>>
                    <label for="r-n">Urgente</label><br>
                </div>
                <div class="contComponentes">
                    <label for="fechaL">Fecha límite de entrega:</label>
                    <input class="campo-form" type="date" id="fechaL" name="fechaEntrega" value="<?php echo htmlspecialchars($fechaEntrega); ?>" min="<?php echo date('Y-m-d'); ?>" required><br>
                </div>
                <div class="contComponentes">
                    <label for="campania">Campaña:</label>
                    <input class="campo-form" type="text" id="campania" name="campania" value="<?php echo htmlspecialchars($campania); ?>"><br>
                </div>
                <div class="btn">
                    <button id="btn-enviar" class="btn-enviar" type="submit" onclick="return checkCampos()">Continuar</button>
                </div>
            </div>
        </form>
    </div>
    <footer class="pie-de-pagina">
        <span>Sección 1 de 4</span> 
    </footer>
        <script src="../../js/usuario/pedidoDatos.js"></script>
</body>
</html>
