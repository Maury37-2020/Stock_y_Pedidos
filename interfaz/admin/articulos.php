<!DOCTYPE html>
  <html>
  <?php
        include '../../modelo/conexion.php';
        include '../../helper/usuarioValidar.php';
        include 'barraNavegacionAdmin.php';
  ?>
    <head>
      <title>Artículos</title>
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
      <link rel="stylesheet" href="../../css/admin/articulos.css">
      <script src="https://kit.fontawesome.com/7568cd4100.js" crossorigin="anonymous"></script>
      <link rel="icon" type="image/x-icon" href="../../assets/logo.jpg">
    </head>

    <body>
      <?php
        
      $query="";

        
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
          if (isset($_POST['busqueda'])) {
            echo "Procesar el formulario de busqueda"; //REVISAR ESTE ECHO
            $query = "SELECT * FROM articulos where nombre like '%" . $_POST['search'] . "%'";
          } else {
            $qryDelete = "UPDATE articulos SET fecha_baja=current_timestamp WHERE id=". $_POST["idborrar"]; 
            mysqli_query($conexion, $qryDelete);
            $query = "Select * from articulos";  
          }
        } else {
          $query = "Select * from articulos"; 
        }

        $productos = mysqli_query($conexion, $query) or die("Eliminar");
        
      ?>

      <div class='container-fluid'>
        <div class='row'>
          <div class="col-12">
          </div>
        </div>
        
        <div class="row">
          <div class="col-1">
            
          </div>
          <div class="col-11">
            <div class="container-fluid">
              <div class="topnav">
                <a href="articuloNuevo.php">
                  <button id="nuevoArticulo" class="btnNuevoArt">Nuevo articulo</button>
                </a>
                <div class="contBusqueda">
                  <form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                    <input type="text" placeholder="Search..." name="search">
                    <button name="busqueda" type="submit" class="btnBusc"><i class="fa-solid fa-magnifying-glass"></i></button>
                  </form>
                </div>
              </div>
              <div class="lineaSuperior"></div>
              <div class="row">
              <table class="table">
                  <thead>
                    <tr>
                      <th>Nombre</th>
                      <th>Descripción</th>
                      <th>Foto 1</th>  
                      <th>Foto 2</th>
                      <th>Stock </th>
                      <th>Stock mínimo</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $IDfoto = 0;
                      foreach ($productos as $fila) { 
                    ?>
                      <tr>
                        <td><?php echo $fila['nombre'] ?></td>
                        <td><?php echo $fila['descripcion'] ?></td>
                        <td>
                          <span title="<?php echo $fila['foto1']?>">
                            <img class="imagenchica" src="../../imagenes/productos/<?php echo $fila['foto1']?>" onclick="mostrar(<?php echo $IDfoto?>,'<?php echo $fila['descripcion']?>');" />
                          </span>
                          <!-- Modal para la imagen -->
                          <div id="imgModal<?php echo $IDfoto?>" class="modal">

                            <!-- Boton cerrar -->
                            <span class="close" onclick="document.getElementById('imgModal<?php echo $IDfoto?>').style.display='none'">&times;</span>

                            <!-- Contenido del modal (imagen) -->
                            <img class="contenido-modal" id="img<?php echo $IDfoto?>"
                              src="../../imagenes/productos/<?php echo $fila['foto1']?>"/>

                            <!--Caption del modal (texto) -->
                            <div class='caption' id="caption<?php echo $IDfoto++?>"></div>
                          </div>
                        </td>
                        <td>
                          <span title="<?php echo $fila['foto2']?>">
                            <img class="imagenchica" src="../../imagenes/productos/<?php echo $fila['foto2']?>" onclick="mostrar(<?php echo $IDfoto?>,'<?php echo $fila['descripcion']?>');"/>
                          </span>
                          <!-- Modal para la imagen -->
                          <div id="imgModal<?php echo $IDfoto?>" class="modal">

                            <!-- Boton cerrar -->
                            <span class="close" onclick="document.getElementById('imgModal<?php echo $IDfoto?>').style.display='none'">&times;</span>

                            <!-- Contenido del modal (imagen) -->
                            <img class="contenido-modal" id="img<?php echo $IDfoto?>"
                            src="../../imagenes/productos/<?php echo $fila['foto2']?>"/>

                            <!--Caption del modal (texto) -->
                            <div class='caption' id="caption<?php echo $IDfoto++?>"></div>
                          </div>
                        </td>
                        <td><?php echo intval($fila['stock'])?></td>
                        <td><?php echo intval($fila['stock_minimo'])?></td>
                        
                        <td style="color:red">
                          <?php if($fila['fecha_baja']!=null)  {
          
                          ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentcolor" class="bi bi-x-square" viewBox="0 0 16 16">
                              <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                              <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                            </svg>
                          
                          <?php
                            }
                          ?>
                          
                        </td>

                        <td class="text-right">
                          <span title="Actualizar articulo">
                            <a class="btnAct" id="btnactualizar<?php echo $fila['id'] ?>" role="button" 
                              href="articuloModificar.php?id=<?php echo $fila['id'] ?>">
                              <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                          </span>
                          <span title="Borrar articulo">
                            <a class="btnBorr" id="btnBorrar<?php echo $fila['id'] ?>" role="button" 
                              href="#" onClick="modalEliminacion(<?php echo $fila['id'] ?>);">
                              <i class="fa-solid fa-trash"></i>
                            </a>
                          </span>
                          <span title="Historial articulo">
                            <a class="btnHist" id="btnHistorial<?php echo $fila['id'] ?>" role="button" 
                              href="articuloHistorial.php?id=<?php echo $fila['id'] ?>">
                              <i class="fa-solid fa-book"></i>
                            </a>
                          </span>
                        </td>

                        <!--Modal para eliminacion -->
                        <div id="id<?php echo $fila['id'] ?>" class="modaldelete">
                          <span onclick="document.getElementById('id<?php echo $fila['id'] ?>').style.display='none'" class="cerrardelete" title="Cerrar">&times;</span>
                          <form id="frm<?php echo $fila['id'] ?>"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                            <div class="modalcontentdelete">
                              <input type="hidden" id="idborrar" name="idborrar" value="<?php echo $fila['id']?>">
                              <div class="containerdelete">
                                <h1>Borrar articulo</h1>
                                <p>Esta seguro de borrar el articulo <b> <?php echo $fila['descripcion'] ?></b>?</p>
                                <div class="clearfix">
                                  <button type="button" class="boton cancelbtn" onclick="document.getElementById('id<?php echo $fila['id']?>').style.display='none'">Cancelar</button>
                                  <button type="button" class="boton deletebtn" onclick="document.forms['frm<?php echo $fila['id']?>'].submit();">Borrar</button>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                        <?php
                          }
                        ?>
                      </tr>
                  </tbody>
                </table> 
              </div>
            </div>
        </div>
      </div>  
      <script src="../../js/admin/articulos.js"></script>
    </body>
</html> 
