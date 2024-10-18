<!DOCTYPE html>
  <?php 
    include '../../modelo/conexion.php';
    include '../../helper/usuarioValidar.php';
    include 'barraNavegacionAdmin.php';
  ?>  
  <html>
    <head>
      <title>Usuarios</title>
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
      <script src="https://kit.fontawesome.com/7568cd4100.js" crossorigin="anonymous"></script>
      <link rel="stylesheet" href="../../css/admin/usuarios.css">
      <link rel="icon" type="image/x-icon" href="../../assets/logo.jpg">
    </head>
    <body>
      
      
      <?php
        if($_POST){
          $qryDelete = "DELETE FROM usuarios WHERE id=". $_POST["idborrar"]; 
          mysqli_query($conexion, $qryDelete);
        }

        $qrySel = "Select * from usuarios"; 
        $usuarios = mysqli_query($conexion, $qrySel);
      ?>
      <div class='Container'>
        <div class='row'>
          <div class="col-12">
          </div>
        </div>
        <div class="row">
          </div>
          <div class="col-11">
            <div class="container-fluid">
              <div class="row">
                <div class="col-2">
                  <a class="Abutton"href="usuarioNuevo.php">
                    <button class="btnUsr">Nuevo usuario</button>
                  </a>
                </div>
                <div class="lineaSuperior"></div>
              </div>
              <div class="row">
                <table class="tableUser">
                  <thead>
                    <tr>
                      <th>Nombre</th>
                      <th>mail</th>
                      <th>rol</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      foreach ($usuarios as $fila) { 
                    ?>
                      <tr>
                        <td><?php echo $fila['nombre'] ?></td>
                        <td><?php echo $fila['email'] ?></td>
                        <td><?php echo $fila['rol'] ?></td>

                        <td class="text-right">
                          <span title="Actualizar usuario">
                            <a class="btnAct" id="btactualizar<?php echo $fila['id'] ?>" role="button" 
                              href="usuarioModificar.php?id=<?php echo $fila['id'] ?>" >
                              <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                          </span>
                          <span title="Borrar usuario">
                            <a class="btnBorr" id="btnBorrar<?php echo $fila['id'] ?>" role="button" 
                              href="#" onClick="modalEliminacion(<?php echo $fila['id'] ?>);">
                              <i class="fa-solid fa-trash"></i>
                            </a>
                          </span>
                          <!--Modal para eliminacion -->
                          <div id="id<?php echo $fila['id'] ?>" class="modaldelete">
                            <span onclick="document.getElementById('id<?php echo $fila['id'] ?>').style.display='none'" class="cerrardelete" title="Cerrar">&times;</span>
                            <form id="frm<?php echo $fila['id'] ?>"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                              <div class="modalcontentdelete">
                                <input type="hidden" id="idborrar" name="idborrar" value="<?php echo $fila['id']?>">
                                <div class="containerdelete">
                                  <h1>Borrar usuario</h1>
                                  <p>Esta seguro de borrar el usuario <b> <?php echo $fila['nombre'] ?></b>?</p>
                                <div class="clearfix">
                                  <button type="button" class="boton cancelbtn" onclick="document.getElementById('id<?php echo $fila['id']?>').style.display='none'">Cancelar</button>
                                  <button type="button" class="boton deletebtn" onclick="document.forms['frm<?php echo $fila['id']?>'].submit();">Borrar</button>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                        </td>
                        <?php
                          }
                        ?>
                      </tr>
                  </tbody>
                </table> 
              <div>
            </div>
          </div>
        </div>
      </div>
      <script>
          function modalEliminacion(idborrar){
            document.getElementById("id"+idborrar).style.display="block";
          }
      </script>
    </body>
</html> 
