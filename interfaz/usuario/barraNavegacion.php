<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú</title>
    <link rel="stylesheet" href="../../css/barraNavegacion.css">
    <link rel="stylesheet" href="../../css/uicons-solid-rounded.css">
    <script src="https://kit.fontawesome.com/7568cd4100.js" crossorigin="anonymous"></script>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.4.2/uicons-solid-rounded/css/uicons-solid-rounded.css'>
</head>
<body id="body-barra">
    <div class="menu__side" id="menu_side">
        <div class="options__menu">
            <a href="javascript:history.back()" class="selected back">
                <div class="option">
                    <i class="fi fi-sr-left" title="Atrás"></i>
                <!-- <i class="fas fa-bars" id="btn_open"></i> -->
                </div>
            </a>
            <a href="usuarioInicio.php" class="selected">
                <div class="option">
                    <i class="fi fi-sr-home" title="Principal"></i> <!--<i class="fa-regular fa-star" title="Principal"></i> -->
                </div>
            </a>    
            <a class="selected subm">
                <div class="option">
                    <i class="fa-solid fa-box-open" title="Consultar Stock"></i>
                </div>
            </a>
            <div id="menu-articulos">
                <a href="pedidoDatos.php">Crear pedido</a>
                <a href="pedidosHistorial.php">Historial pedidos</a>
                <a href="articulosDetalles.php">Stock</a>
            </div>
            <a href="destinatariosAbm.php" class="selected">
                <div class="option">
                    <i class="fa-solid fa-users" title="Destinatarios"></i>
                </div>
            </a>
            <a href="ciudadesAbm.php" class="selected">
                <div class="option">
                <i class="fi fi-ss-visit" title="ABM Ciudades"></i>
                    <h4>Pedidos Pendientes</h4>
                </div>
            </a>
            <!--<a href="#" class="selected">
                <div class="option">
                <i class="fa-solid fa-truck-fast" title="Pedidos en viaje"></i>
                    <h4>Pedidos en viaje</h4>
                </div>
            </a>
            <a href="#" class="selected">
                <div class="option">
                <i class="fa-solid fa-square-check" title="Pedidos Entregados"></i>
                    <h4>Pedidos entregados</h4>
                </div>
            </a>
            <a href="#" class="selected">
                <div class="option">
                <i class="fa-solid fa-shop" title="Compras"></i>
                    <h4>Compras</h4>
                </div>
            </a>-->
            <a href="passwordCambiar.php" class="selected">
                <div class="option">
                    <i class="fi fi-sr-key" title="Cambiar Contraseña"></i><!-- <i class="fa-solid fa-lock" title="Cambiar Contraseña"></i> -->
                </div>
            </a>
            <a href="../../login.php" class="selected">
                <div class="option">
                    <i class="fi fi-sr-exit-alt" title="Salir"></i><!-- <i class="fa-solid fa-rectangle-xmark" title="Cerrar"></i> -->
                </div>
            </a>
            
        </div>
    </div>
    <script src="../../js/usuario/menus.js"></script>
</body>

</html>