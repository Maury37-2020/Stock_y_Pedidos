<!DOCTYPE html>
  <html>
    <head>
      <title>Modificar Artículos</title>
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
      <link rel="stylesheet" href="../../css/admin/articuloModificar.css">
      <link rel="icon" type="image/x-icon" href="../../assets/logo.jpg">
    </head>
    <body>
      <!-- Ventana modal, por defecto no visiblel -->
      <div id="ModalArticuloOk" class="modalActualizacion">
        <div class="contenido-modal-actualizacion">
          <p>Se actualizo el articulo correctamente.</p>
        </div>
      </div>
      
      <?php
        include '../../modelo/conexion.php';
        include '../../helper/usuarioValidar.php';
        include '../../modelo/articulo.php';
        include '../../modelo/movimientosDescripcion.php';
        include '../../modelo/movimientosStock.php';
        include 'barraNavegacionAdmin.php';

        function borrarViejaImagen($nombreArchivo){
          if (file_exists('../../imagenes/productos/'. $nombreArchivo)) {
            unlink('../../imagenes/productos/'. $nombreArchivo);
          }
        }

        function cargarNuevaImagen($nombreArchivo, $nrofile){
          
          $carpeta="../../imagenes/productos/";
          $archivoFinal= $carpeta . $nombreArchivo;
          //pathinfo: Devuelve información acerca de la ruta de un fichero
          $tipoArchivoImagen = strtolower(pathinfo($_FILES[$nrofile]["name"],PATHINFO_EXTENSION));
          $ArchivoOK = true;

          $check = getimagesize($_FILES[$nrofile]["tmp_name"]);
          if($check !== false) {
            $ArchivoOK = true;;
          } else {
            $ArchivoOK = false;
          }

          // verfica si existe el archivo
          if (file_exists($archivoFinal)) {
            $ArchivoOK = false;
          }

          // verifica el tamanio del archivo
          if ($_FILES[$nrofile]["size"] > 500000) {
            $ArchivoOK = false;
          }

          // permite ciertos formatos
          if($tipoArchivoImagen != "webp" && $tipoArchivoImagen != "jpg" && $tipoArchivoImagen != "png" && $tipoArchivoImagen != "jpeg" && $tipoArchivoImagen != "gif" ) {
            $ArchivoOK = false;
          }

          // verifica si el archivo es correcto para subir
          if ($ArchivoOK == false) {
            return false;
          // Si todo esta ok, subimos el archivo
          } else {
            if (move_uploaded_file($_FILES[$nrofile]["tmp_name"], $archivoFinal)) {
              return true;
            }else{
              return false;
            }         
          }
        }
        
        $actualizacion=false;

        if($_POST){
          $articulo = new articulo($_POST['idactualizar'],$_POST['nombre'],$_POST['descripcion'],
            $_POST['file1'], $_POST['file2'], $_POST["stock"], $_POST["stockminimo"]);

          if($_FILES['img1']['name'] != null){
            borrarViejaImagen($_POST['file1']);
            cargarNuevaImagen($_FILES['img1']['name'], 'img1');
            $articulo->setFoto1($_FILES['img1']['name']);
          }

          if($_FILES['img2']['name'] != null){
            borrarViejaImagen($_POST['file2']);
            cargarNuevaImagen($_FILES['img2']['name'], 'img2');
            $articulo->setFoto2($_FILES['img2']['name']);
          }

          $articulo->actualizarArticulo();

          if($_POST['tipoDeModficacionStock'] != "0"){
            $movimientoStock = new movimientoStock(null, $_POST['tipoDeModficacionStock'], $_POST['idactualizar'],
            $_POST['movimientoStock']);
            $movimientoStock->guardarMovimientoStock();
          }

          
          $actualizacion=true;
        }

        if($_GET){
            $articulo = new articulo($_GET['id']);
        }
        
        $movimientosDescripcion = new movimientosDescripcion();

        $qrySelect = "SELECT * FROM articulos WHERE id=" . $articulo->getID();
        $rsArticulo = mysqli_query($conexion, $qrySelect);
        $articulo = mysqli_fetch_array($rsArticulo);
        $rsMovimientosDescripcion = $movimientosDescripcion->obtenerMovimientosDescripcion(); 
      ?>
      
      <h1>Modificar articulo</h1>
      <div class="container">
        <div class="contForm">
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name='idactualizar' value='<?php echo $articulo['id'] ?>'>
            <label class="classLbl"for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" placeholder="Sin nombre"
              value='<?php echo $articulo['nombre'] ?>'>
            <label class="classLbl"for="descripcion">Descripcion:</label>
            <input type="text" id="descripcion" name="descripcion" placeholder="Sin descripcion"
              value='<?php echo $articulo['descripcion'] ?>'>
            <label class="classLbl"for="foto1">Foto 1:</label>
            <input type="hidden" id="file1" name="file1"
              value='<?php echo $articulo['foto1'] ?>'> 
            <span title="<?php echo $articulo['foto1']?>">
              <img src='../../imagenes/productos/<?php echo $articulo['foto1'] ?>'/>
            </span>
            <input type="file" id="img1" name="img1">
                
            <label class="classLbl"for="foto2">Foto 2:</label>
            <input type="hidden" id="file2" name="file2"
              value='<?php echo $articulo['foto2'] ?>'> 
            <span title="<?php echo $articulo['foto2']?>">
              <img src='../../imagenes/productos/<?php echo $articulo['foto2'] ?>'/>
            </span>
            <input type="file" id="img2" name="img2">

            <label class="classLbl"for="">Asignar tipo de modificacion</label>
            <select name='tipoDeModficacionStock' id="tipoDeModficacionStock">
              <option  value="0" disabled selected>Seleccionar tipo de modificación</option>
              <?php
                foreach($rsMovimientosDescripcion as $movimiento){
              ?>
                <option value="<?php echo $movimiento['id']?>">
                  <?php echo $movimiento['descripcion']?>
                </option>
              <?php    
                }
              ?>
            </select>
            <input type="number" id="movimientoStock" name="movimientoStock" placeholder="0">
            <br>
            <br>
                
            <label class="classLbl" for="stock">Stock</label>
            <input type="text" id='stock' name="stock" readonly value='<?php echo $articulo['stock'] ?>'>
            <label class="classLbl"for="stockminimo">Stock minimo</label>
            <input type="number" id="stockminimo" name="stockminimo" placeholder="0"
              value='<?php echo $articulo['stock_minimo'] ?>'>
            <input type="submit" id="modificar" name="modificar" value="Modificar">
          </form>
        </div>
      </div> 
      <script language='JavaScript'>
        <?php
          if($actualizacion){
            echo "let mimodal = document.getElementById('ModalArticuloOk');" ;
            echo "mimodal.style.display='block';" ;
            echo "setTimeout(function() {" ;
            echo "let mimodal = document.getElementById('ModalArticuloOk');" ;
            echo "mimodal.style.display='none';" ;
            echo "}, 2000); ";
          }
        ?>  
      </script>
    </body>
</html> 
