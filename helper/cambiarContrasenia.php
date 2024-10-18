<?php
    
    include '../modelo/usuario.php';

    $usuario = new Usuario($_POST['hdnID'],'','',$_POST['nueva'],'');

   $usuario->cambiarPassword();
   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambio de password</title>
    <link rel="stylesheet" href="../css/passwordCambiar.css"> 
</head>
<body>
    <div class="lineasup"></div>
    <div class="aviso">
        <img src="../assets/passwordOK.jpg" width="5%" height="5%">
        <p>Tu contraseña ya fue modificada<p>
    </div>
    <div class="lineainf">
        <button class="button"><a href='../login.php'><span>Volver </span></a></button>
    </div>
</body>
</html>