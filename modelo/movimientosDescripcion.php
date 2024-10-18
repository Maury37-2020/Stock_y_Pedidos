<?php
    class movimientosDescripcion {
            private $id;
            private $descripcion;

            public function __construct($id = null, $descripcion = null) {
                $this->id = $id;
                $this->descripcion = $descripcion;
            }
            
            public function getID(){
                return $this->id;
            }
            
            public function getDescripcion(){
              return $this->descripcion;
            }

            public function obtenerMovimientosDescripcion(){
                include 'conexion.php';
                
                $selMovimientosDescripcion = "SELECT * FROM movimientos_descripcion WHERE id BETWEEN 2 AND 4;";

                $rsMovimientosDescripcion = mysqli_query($conexion, $selMovimientosDescripcion) or
                    die("Problemas en el select:" . mysqli_error($conexion));

                mysqli_close($conexion);
                return $rsMovimientosDescripcion;
            }
        }
?>
