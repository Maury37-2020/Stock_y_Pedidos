<!DOCTYPE html>
<html lang="es">
<?php
        include '../../modelo/conexion.php';
        include '../../helper/usuarioValidar.php';
        include 'barraNavegacionAdmin.php';
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/admin/transportesABM.css">
    <title>ABM Transportes</title>
    <link rel="icon" type="image/x-icon" href="../../assets/logo.jpg">
</head>
<body class="body">
<h1>ABM Transportes</h1>
<div class="contenedor">
    <button class="tablink" onclick="openPage('alta', this, '#b5daff')"id="defaultOpen">Alta</button>
    <button class="tablink" onclick="openPage('modif', this, '#b5daff')">Baja / Modificación</button>

    <div id="alta" class="tabcontent"> 
        <form class="campo-form" autocomplete="off" action="">
        <div class="form tbc1">
        <label for="razonSoc">Nombre:</label><br> 
        <input class="campo-form" id="razonSoc" type="text" name="razons" placeholder="Nombre" required><br>
            <label for="dni">DNI / CUIT:</label><br>
            <input class="campo-form" id="dni" type="text" name= "dni" placeholder="DNI - CUIT" size="10" required/><br>
            <label for="te">Teléfono:</label><br>
            <input class="campo-form" id="te" type="Text" name="te" placeholder="Teléfono" size="15" required/><br>
        </div>   
        <div class="destinos">
            <div><span class="titulo_r1">Destinos:</span></div>
            <div class="renglon">
                <input class="campo-form cod_p" type="text" id="cp_0" name="cp_0" placeholder="Codigo Postal" required>
                <select class="campo-form " id="local_0" name="local_0"> 
                    <option value="1">Sunchales</option>
                </select>  
                <button class="btn add1" id="add0" ype="button" onclick="generar(0)">+</button>
            </div>
        </div>                   

        <div class="contiene-boton">
            <button class="btn" type="button" id="graba">Grabar</button>
            <!--  <button class="btn" type="button" id="borra">Borrar</button> -->
        </div>
        </form>
    </div>
    <div id="modif" class="tabcontent"> 
    <form class="campo-form" autocomplete="off" action="">
        <div class="form">
        <label for="razonSoc">Nombre:</label><br> 
            <select class="campo-form" id="razonSoc" type="text" name="razons" required>
                <option value="1">Transporte Pedrito</option>
                <option value="1">Plumas Verdes</option>
            </select><br>
            <label for="dni">DNI / CUIT:</label><br>
            <input class="campo-form" id="dni" type="text" name= "dni" placeholder="DNI - CUIT" size="10" required/><br>
            <label for="te">Teléfono:</label><br>
            <input class="campo-form" id="te" type="Text" name="te" placeholder="Teléfono" size="15" required/><br>
        </div>   
        <div class="destinos">
            <span>Destinos: </span><br>
            <div class="renglon">
                <div class="campo-form cod_p"><span id="s1">2322</span><span> - </span><span id="s2">Suchales</span></div> <button class="btn btn_elim" type="button">X</button> <button class="btn add" id="add1" type="button" onclick="generar(1)">+</button>
            </div>
        </div>                   

        <div class="contiene-boton">
            <button class="btn" type="button" id="graba">Grabar</button>
            <button class="btn btn_elim" type="button" id="borrar">Borrar</button>
        </div>
        </form>
    </div>
</div>
<script src='../../js/admin/transportesABM.js'></script>
</body>
</html>