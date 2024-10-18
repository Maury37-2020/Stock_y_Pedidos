<?php
    include 'usuarioValidar.php';
    $_SESSION['nropedido'] = uniqid();
    //$_SESSION['nropedido'] = 2;
    /* header("Location: ../interfaz/usuario/articulos.php"); */
    echo $_SESSION['nropedido'];
