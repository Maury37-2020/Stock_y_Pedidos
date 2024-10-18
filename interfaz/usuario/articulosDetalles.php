<!DOCTYPE html>
<html>
  <head>
    <link rel="icon" type="image/x-icon" href="../../assets/logo.jpg">
    <link rel="stylesheet" href="../../css/usuario/articulosDetalles.css">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <script src="https://kit.fontawesome.com/7568cd4100.js" crossorigin="anonymous"></script>
    <title>Stock</title>
  </head>
  
  <body class="cuerpo">
    
    <?php
      include '../../helper/usuarioValidar.php';
      include("../../modelo/articulo.php");
      include 'barraNavegacion.php';
      
      $articulo = new articulo();
      $pagina = 1;

      if(!isset($_SESSION['buscado'])) {
        $_SESSION['buscado'] = "";
      }

      if ($_GET){
        $pagina = $_GET["pag"]; 
      }

      if($_POST) {
        $_SESSION['buscado'] = $_POST['buscado'];
      }

      $listaArticulos = $articulo->obtenerArticulos($pagina, $_SESSION['buscado']);
      $cantidadPaginas = $articulo->cantidadPaginas($pagina, $_SESSION['buscado']);

    ?>  

  <!--FORMULARIO DE-->             
  <div>
    <form class="formulario" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <div class="containerBuscador">
          <input type="text" class="inputBuscar" name="buscado" placeholder="Search..." value="<?php echo $_SESSION['buscado']; ?>">
          <button class="btnBuscar" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
      </form>
  </div>
  <!--CARDS PRODUCTOS-->  
  <div class="row">
  <?php
    while ($lineaArticulo = mysqli_fetch_array($listaArticulos)) {
  ?>
  <div class="col-4">
    <div class="card">
        <img src='../../imagenes/productos/<?php echo $lineaArticulo['foto1']?>' alt=""
        onClick="mostrarModalImagenes('<?php echo $lineaArticulo['foto1']?>','<?php echo $lineaArticulo['foto2']?>')">
      <div class="contenidoCard">
        <h3 class="tituloCard"><?php echo $lineaArticulo['nombre'] ?></h3>
        <p class="descripcionCard"><?php echo $lineaArticulo['descripcion'] ?></p>
        <p class="stockCard"><?php echo intval($lineaArticulo['stock']) ?> en stock.</p>
      </div>
    </div>
  </div>
  <?php
    }
  ?>
</div>
<!--PAGINADOR-->
    <nav class="pagination">
        <a href="articulosdetalles.php?pag=1">&laquo;</a>
        <?php 
            for($i=1; $i <= $cantidadPaginas; $i++) {
        ?>
            <a <?php echo ($i == $pagina) ? "class='active'" : ""; ?>   
            href="articulosdetalles.php?pag=<?php echo $i?>"><?php echo $i?> </a>
        <?php   
            }
        ?>
        <a href="articulosdetalles.php?pag=<?php echo $cantidadPaginas ?>">&raquo;</a>
    </nav>
    <div id="imagenesModal" class="modal">
    
    <div class="modal-content">
        <div style="margin-bottom:20px">
            <span class="close" onclick='ocultarModalImagenes()'>&times;</span>
        </div> 
        <!-- Slideshow container -->
        <div class="slideshow-container">
            <div style="text-align:center">
                <!-- Slides -->
                <div class="mySlides fade">
                    <img id='imgModal1' src="" style="max-width:20%; max-height:20%">
                </div>
                <div class="mySlides fade">
                    <img id='imgModal2' src="" style="max-width:20%; max-height:20%">
                </div>
            </div>
            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
        </div>
        <nav style="text-align:center">
            <span class="dot" onclick="currentSlide(1)"></span> 
            <span class="dot" onclick="currentSlide(2)"></span> 
        </nav>
    </div>
    <script src="../../js/usuario/articulosDetalles.js"></script>
  </body> 
</html>