<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/x-icon" href="../../assets/logo.jpg">
    <link rel="stylesheet" href="../../css/usuario/misPedidos.css">
    <link rel="stylesheet" href="../../css/uicons-solid-rounded.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos realizados</title>
</head>
<body class="body-pedidos">
    <?php
    
    include '../../modelo/conexion.php';
    include '../../helper/usuarioValidar.php';
    include 'barraNavegacion.php';
    include '../../modelo/pedido.php';

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    

    $pedido = new pedido();
    $pedidoDet = new pedidoDetalle();

    if ($_GET){
        $pagina = $_GET["pag"]; 
    }
    
    $pagina = isset($_GET["pag"]) ? (int)$_GET["pag"] : 1;

    $cantidadPaginas = $pedido->cantidadPaginas($_SESSION["id"],null);
    $listMisPedido = $pedido->obtenerMisPedidosUsuario($_SESSION["id"],$pagina,null);

    

    ?>
    <header class="cabecera">
        <div class="usuario">
            <span><?php echo $_SESSION["usuario"]?></span>
        </div>
        <div class="seccion">
            <span>Pedidos Realizados</span>
        </div>
        <div class = "contiene-carrito"></div>  
    </header>
    <button class="tablink btn1" onclick="openPage('Bandeja', this, 'white')"id="defaultOpen"></button>
    <div id="Bandeja" class="tabcontent"> 
            <section class="cab-pedidos">
                <div class="col1"><span>Código</span></div>
                <div class="col2"><span>Fecha</span></div>
                <div class="col3"><span>Prioridad</span></div>
                <div class="col4"><span>Estado</span></div>
                <div class="col5"><span>Destinatario</span></div>
                <div class="col6"><span>Transporte</span></div>
                <div class="col7"><span>Campañia</span></div>
            </section>
            <?php 
                foreach($listMisPedido as $pedido) {
                    $detalles = pedidoDetalle::obtenerDetalle($pedido['codigo']);
            ?>
                <section class="det-pedidos accordion">
                    <div class="col1"><span id="cod"><?php echo $pedido['codigo']; ?></span></div>
                    <div class="col2"><span id="fecha"><?php echo $pedido['fecha']; ?></span></div>
                    <div class="col3"><span id="prioridad"><?php echo $pedido['prioridad']; ?></span></div>
                    <div class="col4"><span id="usuario"><?php echo $pedido['estado']; ?></span></div>
                    <div class="col5"><span id="destinatario"><?php echo $pedido['nombre_destinatario']; ?></span></div>
                    <div class="col6"><span id="transporte"><?php echo $pedido['transporte'] ?> </span></div>
                    <div class="col7"><span id="campania"><?php echo $pedido['campania']?></span></div>
                </section>
        
                <div class="panel">
                    <section class="datos-pedido">
                        <div class="cab-articulos-det">
                            <div id="nombre"><p>Artículo</p></div>
                            <div id="desc"><p>Descripción</p></div>
                            <div id="cant"><p>Cantidad</p></div>
                        </div>
                        <?php foreach($detalles as $detalle) { ?>
                        <div class="articulos-det">
                            <div id="nom-articulo"><p><?php echo $detalle->getNom_articulo(); ?></p></div>
                            <div id="desc-articulo"><p><?php echo $detalle->getDescripcion_articulo(); ?></p></div>
                            <div id="cant-articulo"><p><?php echo $detalle->getCantidad(); ?></p></div>
                        </div>
                        <?php } ?>
                    </section>
                </div>
            <?php } ?>
            <div class="pagination">
            <a href="pedidosHistorial.php?pag=1">&laquo;</a>
            <?php 
                for($i=1; $i <= $cantidadPaginas; $i++) {
            ?>
                <a <?php 
                        echo ($i == $pagina) ? "class='active'" : ""; ?> 
                    href="pedidosHistorial.php?pag=<?php echo $i ?>"><?php echo $i ?></a>
            <?php   
                }
            ?>
            <a href="pedidosHistorial.php?pag=<?php echo $cantidadPaginas ?>">&raquo;</a>
        </div>
        </div>
    


</body>
<script src='../../js/admin/pedidos.js'></script>
<script>
    let atras = document.getElementsByClassName('back')
    atras[0].href = 'usuarioInicio.php'
</script>
</html>