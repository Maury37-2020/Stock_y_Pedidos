<!DOCTYPE html>
  <html>
    <head>
      <title>Administrador</title>
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
      <link rel="stylesheet" href="../../css/admin/usuariomodificar.css">
      <link rel="icon" type="image/x-icon" href="../../assets/logo.jpg">
    </head>
    <body>
      <!-- Ventana modal, por defecto no visiblel -->
      <div id="modalactualizarusuario" class="modal">
        <div class="contenido-modal">
          <p>Se actualizo el usuario.</p>
        </div>
      </div>
      <?php
        include '../../modelo/usuario.php';
        include '../../helper/usuarioValidar.php';
        include '../admin/barraNavegacionAdmin.php';

        $usuario = new usuario();
        $actualizacion=false;
        
        if($_POST){

          $usuario->setID($_POST['idactualizar']);
          $usuario->setNombre($_POST['nombre']);
          $usuario->setMail($_POST['mail']);
          $usuario->setPassword($_POST["password"]);
          $usuario->setRol($_POST['opcion_seleccionada']);

          $usuario->modificarUsuario();

          $actualizacion=true;
        }

        if($_GET){
          $usuario->setID($_GET['id']);
        }

        $dataUsuario = mysqli_fetch_array($usuario->seleccionarUsuario());

      ?>
     
    
      <h1 class="classH1">Modificar usuario</h1>
    

        <div class='container'>
          <div class="contForm">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name='idactualizar' value='<?php echo $dataUsuario['id']; ?>'>
              <label class="classLbl" for="nombre">Nombre:</label>
              <input type="text" id="nombre" name="nombre" placeholder="Sin nombre"
                  value='<?php echo $dataUsuario['nombre'];?>'>
              <label class="classLbl" for="mail">Mail:</label>
              <input type="text" id="mail" name="mail" placeholder="Sin mail"
                  value='<?php echo $dataUsuario['email'];?>'>
              <label class="classLbl" for="password">Password:</label>
              <input type="text" id="password" name="password" placeholder="Sin password"
                  value='<?php echo $dataUsuario['password'];?>'>
              <label for="rol">Rol:</label>
              <input type="hidden" id="opcion_seleccionada" name="opcion_seleccionada"  
                  value='<?php echo $dataUsuario['rol'];?>'>
              <select class="comBox" id='rol' name='rol'>
                <option value="cliente" <?php if($dataUsuario['rol']=='cliente'){echo 'selected';} ?>>Cliente</option>
                <option value="admin" <?php if($dataUsuario['rol']=='admin'){echo 'selected';} ?>>Administrador</option>
              </select>
              <input type="submit" id="cargar" name="modificar" value="modifciar">
            </form>
          </div>
       </div>
      
      <script>
        // Obtener referencia al select y al input hidden
        const select = document.getElementById('rol');
        const inputHidden = document.getElementById('opcion_seleccionada');

        // Agregar un event listener para el evento 'change' del select
        select.addEventListener('change', function() {
            // Obtener el valor seleccionado del select
            const selectedValue = select.value;

            // Asignar el valor seleccionado del select al input hidden
            inputHidden.value = selectedValue;

        });
    </script>
      <script language="javascript">
        <?php
          if($actualizacion){
            echo "let mimodal = document.getElementById('modalactualizarusuario');" ;
            echo "mimodal.style.display='block';" ;
            echo "setTimeout(function() {" ;
            echo "let mimodal = document.getElementById('modalactualizarusuario');" ;
            echo "mimodal.style.display='none';" ;
            echo "}, 2000); ";
          }
        ?>  
      </script>
        </script>
    </body>
</html> 
