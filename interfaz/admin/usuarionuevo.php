<!DOCTYPE html>
  <html>
    <head>
      <title>Nuevo Usuario</title>
      <link rel="stylesheet" href="../../css/admin/usuarioNuevo.css">
      <link rel="icon" type="image/x-icon" href="../../assets/logo.jpg">
    </head>
    <body>
      <!-- Ventana modal, por defecto no visiblel -->
      <div id="modalinsertarusuario" class="modal">
        <div class="contenido-modal">
          <p>Se inserto el usuario.</p>
        </div>
      </div>
      <?php
        include '../../helper/usuarioValidar.php';
        include '../../modelo/usuario.php';
        include 'barraNavegacionAdmin.php';

        $insercion=false;
        if($_POST){
          $usuario = new usuario(0, $_POST['nombre'], $_POST['mail'], $_POST['password'],$_POST['rol']);
          
          $usuario->insertarUsurio();

          $insercion=true;
        }
      ?>
      <div class='Container'>
        <div class='row'>
          <div class="col-12">
          </div>
        </div>
        <h1 class="classH1">Nuevo usuario</h1>
            <div class='container'>
              <div class="contForm">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
                  <label class="classLbl" for="nombre">Nombre:</label>
                  <input type="text" id="nombre" name="nombre" placeholder="Sin nombre">
                  <label class="classLbl" for="mail">Mail:</label>
                  <input type="text" id="mail" name="mail" placeholder="Sin mail">
                  <label class="classLbl" for="password">Password:</label>
                  <input type="text" id="password" name="password" placeholder="Sin password">
                  <label class="" for="rol">Rol:</label>
                  <select class="comBox" id='rol' name='rol'>
                    <option value="cliente">Cliente</option>
                    <option value="admin">Administrador</option>
                  </select>
                  <input type="submit" id="cargar" name="cargar" value="cargar">
                </form>
              </div>
            </div>
          </div>
      <script language="javascript">
        <?php
          if($insercion){
            echo "let mimodal = document.getElementById('modalinsertarusuario');" ;
            echo "mimodal.style.display='block';" ;
            echo "setTimeout(function() {" ;
            echo "let mimodal = document.getElementById('modalinsertarusuario');" ;
            echo "mimodal.style.display='none';" ;
            echo "}, 2000); ";
          }
        ?>
        </script>
    </body>
</html> 
