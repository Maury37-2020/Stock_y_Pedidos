<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="icon" type="image/x-icon" href="../../assets/logo.jpg">
      <link rel="stylesheet" href="../../css/usuario/passwordCambiar.css">
      <title>Cambio contraseña</title>
  </head>
  <body>
      <?php 
        include 'barraNavegacion.php';
        include '../../helper/usuarioValidar.php';
      ?>
      <header id="cabecera">
        <div class="usuario">
            <span><?php echo $_SESSION["usuario"]?></span>
        </div>
        <div class="seccion">
            <span>Cambiar contraseña</span>
        </div>
        <div class="contiene-carrito"></div>
      </header>
      <div class='conteiner'>
        
        <div class="contForm">
          <form action="../../helper/cambiarContrasenia.php" method="post">

            <input type="hidden" name="hdnID" value="<?php echo $_SESSION['id']?>">
          
            <label class="classLbl" for="nueva">Nueva contraseña:</label>
            <input type="password" id="nueva" name="nueva" placeholder="nueva contraseña">

            <label class="classLbl" for="confirmar">Confirmar Contraseña</label>
            <input type="password" id="confirmar" name="confirmar" placeholder="confirmar contraseña">

            <div id='passdiferentes'>
              <p>La nueva contraseña y su confirmacion son diferentes.</p>
            </div>

            <input type="submit" id="cargar" name="cargar" value="Guardar">
          </form>
        </div>
        
      </div>
      <script src='../../js/cambiarPass.js'></script>
  </body>
</html>

