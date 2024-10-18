<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/x-icon" href="../../assets/logo.jpg">
    <link rel="stylesheet" href="../../css/usuario/articulos.css">
    <link rel="stylesheet" href="../../css/uicons-solid-rounded.css">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <script src="https://kit.fontawesome.com/7568cd4100.js" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <title>Compras</title>
</head>
<body>
    <?php
        include '../../helper/usuarioValidar.php';
        include '../../modelo/articulo.php';
        include 'barraNavegacion.php';
    ?>
<header id="cabecera">
    <div id="usuario">
        <span><?php echo $_SESSION["usuario"]?></span>
    </div>
    <div class="seccion">
        <span>Pedidos</span>
    </div>
    <div class="contiene-carrito"></div>
</header>
<main>
<form class="campo-form" autocomplete="off" action="">
    <div class="form">
        <label for="responsable">Responsable de Compra:</label><br>
        <input class="campo-form" id="responsable" type="text" name= "responsable" placeholder="Responsable" size="10" required/><br>
        <label for="solicita">Solicitado por:</label><br>
        <input class="campo-form" id="solicita" type="text" name= "solicita" placeholder="DNI" size="35" required/><br>
        <label for="dni">Fecha de Compra:</label><br>
        <input class="campo-form" id="dni" type="text" name= "dni" placeholder="Solicitante" size="35" required/><br>
        <label for="dni">Proveedor:</label><br>
        <input class="campo-form" id="provee" type="text" name= "provee" placeholder="Proveedor" size="10" required/><br>
        <label for="articulo">Artículo:</label><br>
            <div class="input">
                <input class="campo-form" id="articulo" type="text" name="articulo" placeholder="Razón Social" required>
            </div>

        <label for="dni">Nombre para el alta:</label><br>

        <label for="dni">Cantidad:</label><br>

        <label for="dni">Cantidad dañada:</label><br>
        <input class="campo-form" id="dni" type="number" name= "dni" placeholder="DNI" size="10" required/><br>
        <label for="dni">Condiciones del embalaje:</label><br>

        <label for="dni">Transporte:</label><br>


    </div>
</form>

</main>
    
    
</body>
</html>