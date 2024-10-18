<?php
    class articulo {
            private $id;
            private $nombre;
            private $descripcion;
            private $foto1;
            private $foto2;
            private $stock;
            private $stock_minimo;

            public function __construct($id = null, $nombre = null, $descripcion = null, $foto1 = null, 
                        $foto2 = null, $stock = null, $stock_minimo = null) {
                
                $this->id = $id;
                $this->nombre = $nombre;
                $this->descripcion = $descripcion;
                $this->foto1 = $foto1;
                $this->foto2 = $foto2;
                $this->stock = $stock;
                $this->stock_minimo = $stock_minimo;
            }
            
            public function getID(){
                return $this->id;
            }
            
            public function setFoto1($foto1){
              $this->foto1 = $foto1;
            }

            public function setFoto2($foto2){
              $this->foto2 = $foto2;
            }

            public function obtenerArticulos($pagina, $filtro = null){
                include 'conexion.php';

                $numero_pagina = ($pagina - 1) * 15;

                if($filtro == null){
                    $selArticulos = "SELECT * FROM articulos WHERE fecha_baja IS NULL LIMIT 15 OFFSET " . $numero_pagina  . ";";
                } else {
                    $selArticulos = "SELECT * FROM articulos WHERE fecha_baja IS NULL AND nombre LIKE '%". $filtro ."%' LIMIT 20 OFFSET " . $numero_pagina . ";";
                }

                $rsArticulos = mysqli_query($conexion, $selArticulos) or
                    die("Problemas en el select:" . mysqli_error($conexion));

                mysqli_close($conexion);
                return $rsArticulos;
            }

            public function cantidadPaginas($filtro = null){
                include 'conexion.php';
                if($filtro == null){
                    $selCantidad = "SELECT ceil(count(*)/15) as totalpaginas FROM articulos WHERE fecha_baja IS NULL ;";
                } else {
                    $selCantidad = "SELECT ceil(count(*)/15) as totalpaginas FROM articulos WHERE fecha_baja IS NULL AND nombre LIKE '%". $filtro ."%';";
                }

                $rsCantidadPaginas = mysqli_query($conexion, $selCantidad) or
                    die("Problemas en el select:" . mysqli_error($conexion));

                $row = $rsCantidadPaginas->fetch_assoc();
                $totalpaginas = $row["totalpaginas"];   

                mysqli_close($conexion);
                return $totalpaginas;

            }
            
            public function actualizarArticulo(){
                include 'conexion.php';
                
                $qryUpdate = "UPDATE articulos SET nombre='" . $this->nombre . "', foto1='" . $this->foto1 . "', foto2='" . $this->foto2
                        . "', descripcion='" . $this->descripcion . "', stock=" . $this->stock . ", stock_minimo=" . $this->stock_minimo 
                        . " where id=" . $this->id ;
                
                mysqli_query($conexion, $qryUpdate);
                
            }

            public function insertarArchivo(){
                include 'conexion.php';
              
                try {
                  $qryInsert = "INSERT INTO articulos VALUES(default,'" . $this->nombre . "','" . $this->foto1 . "','" . $this->foto2 .
                                "','". $this->descripcion . "', 0 ," . $this->stock_minimo  . ", CURRENT_TIMESTAMP(), 
                                null, CURRENT_TIMESTAMP());";
                
                  mysqli_query($conexion, $qryInsert);

                  $ultimo_id = mysqli_insert_id($conexion);

                  $qryInsert = "INSERT INTO movimientos_stock VALUES(default,1," . $ultimo_id . "," 
                    . $this->stock . ",CURRENT_TIMESTAMP());";
                  
                  echo $qryInsert;

                  mysqli_query($conexion, $qryInsert);

                  return true;

                } catch (Exception $e) {
                  return false;

                } finally {
                  mysqli_close($conexion);
                }
                
            }

            public function cargarArchivo($nroArchivo,$nombreArchivo){
                $carpeta="../imagenes/productos/";
                $archivoFinal= $carpeta . $nombreArchivo;
                //pathinfo: Devuelve información acerca de la ruta de un fichero
                $tipoArchivoImagen = strtolower(pathinfo($_FILES["file" . $nroArchivo]["name"],
                PATHINFO_EXTENSION));

                $ArchivoOK = true;
                $check = getimagesize($_FILES["file" . $nroArchivo]["tmp_name"]);
                
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
                if ($_FILES["file" . $nroArchivo]["size"] > 500000) {
                  
                  $ArchivoOK = false;
                }
      
                // permite ciertos formatos
                if($tipoArchivoImagen != "jpg" && $tipoArchivoImagen != "png" && $tipoArchivoImagen != "jpeg" && $tipoArchivoImagen != "gif" ) {
                  $ArchivoOK = false;
                }
      
                
                // verifica si el archivo es correcto para subir
                if ($ArchivoOK == false) {
                  return false;
                // Si todo esta ok, subimos el archivo
                } else {
                  if (move_uploaded_file($_FILES["file" . $nroArchivo]["tmp_name"], $archivoFinal)) {
                    return true;
                  }else{
                    return false;
                  }         
                }
              }

              public function obtenerNombreArticulo(){
                include 'conexion.php';

                $selArticulo = "SELECT nombre FROM articulos WHERE id=" . $this->id . ";";
                
                $rsArticulo = mysqli_query($conexion, $selArticulo) or
                    die("Problemas en el select:" . mysqli_error($conexion));

                $row = $rsArticulo->fetch_assoc();

                mysqli_close($conexion);
                return $row['nombre'];
              }

        }
?>
