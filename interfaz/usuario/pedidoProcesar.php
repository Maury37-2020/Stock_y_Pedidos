<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/x-icon" href="../../assets/logo.jpg">
    <link rel="stylesheet" href="../../css/usuario/pedidoProcesar.css"> 
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <script src="https://kit.fontawesome.com/7568cd4100.js" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <title>Resultado Pedido</title>
</head>
<body class="body_p">
    <?php
        include '../../helper/usuarioValidar.php';
        include("../../modelo/carrito.php");
        include 'barraNavegacion.php';
    ?>
    
    <header>
        <div class="usuario">
            <span><?php echo $_SESSION["usuario"]?></span>
        </div>
        <div class="seccion">
            <span>Resultado final del procesamiento del pedido</span>
        </div>
        <div class="contiene-carrito"></div>
    </header>
    <div class="contenedor">
        <?php
            $carrito = new carrito_cab();
            $idCarrito = $carrito->obtener_carrito($_SESSION["id"]);
            if($idCarrito === 0){
                echo "<div class='log'>Warning: El carrito ya se proceso o no existe <span class='ribbon-warn'>warn</span></div>";
                
            }else{
                $response = $carrito->moverCarritoAPedido($idCarrito);
                if (is_string($response)) {
                    echo $response;
                    echo "<div class='log'>Error: no se pudo ejecutar el proceso de creacion del pedido <span class='ribbon-er'>Error</span></div>";
                   
                }else{
                    foreach($response as $rsp){
                        if(substr($rsp['estado'], 0, 2)==='ok'){
                            echo "<div class='log'> Articulo: " . $rsp["nombre"] . " Estado: OK <span class='ribbon-ok'>OK</span></div>";
                        }else{
                            echo "<div class='log'>Articulo: " . $rsp["nombre"] . " Estado: " . $rsp["estado"]   . "<span class='ribbon-er'>Error</span></div>";
                        }
                    }
                    if (substr($rsp['estado'], 0, 2) === 'ok') {
                        echo "<div class='log'>EXITO AL CREAR PEDIDO!!</div>";
                        echo "<div class='ontiene-boton'>
                            <a href='usuarioInicio.php' id='idRedireccionBtnContinuar'>
                            <button id='btn-confirm_add' class='btn-continuar'>Finalizar</button></a>";
                    } else {
                        echo "<div class='log'>ERROR: INTENTAS CREAR UN CARRITO CON UN ARTICULO QUE NO TIENE EL STOCK SOLICITADO!<br>
                              Articulo : " . htmlspecialchars($rsp['nombre']) . "</div>";
                        echo "<div class='ontiene-boton'>
                            <a href='articulos.php' id='idRedireccionBtnContinuar'>
                            <button id='btn-confirm_add' class='btn-continuar'>Volver a articulos</button></a>";
                    }
                } 
            }
        ?>
    </div>
    <footer class="pie-de-pagina">
        <span>Sección 4 de 4</span> 
    </footer>

    <script>
        const btn_a = document.getElementsByClassName('back')
        btn_a[0].href = 'pedidoDestinatario.php'
    </script>
    
</body>

    
