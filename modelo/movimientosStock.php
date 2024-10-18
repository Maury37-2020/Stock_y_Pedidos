<?php
    class movimientoStock {
            private $id;
            private $movimientoDescripcionID;
            private $articuloID;
            private $cantidad;
            private $fechaHora;

            public function __construct($id = null, $movimientoDescripcionID = null, $articuloID = null,
                                        $cantidad = null, $fechaHora = null) {
                $this->id = $id;
                $this->movimientoDescripcionID = $movimientoDescripcionID;
                $this->articuloID = $articuloID;
                $this->cantidad = $cantidad;
                $this->fechaHora = $fechaHora;
            }
            
            public function getID(){
                return $this->id;
            }

            public function guardarMovimientoStock(){
                include 'conexion.php';
                
                $insMovimientoStock = "INSERT INTO movimientos_stock (movimientos_descripcion_id, articulo_id,
                    cantidad) values(" . $this->movimientoDescripcionID . "," . $this->articuloID . ","
                    . $this->cantidad . ")";

                mysqli_query($conexion, $insMovimientoStock) or
                    die("Problemas en el select:" . mysqli_error($conexion));

                mysqli_close($conexion);
            }

            public function obtenerMovimientoStockporArticulo(){
                include 'conexion.php';
                
                $selMovimientoStock = "SELECT a.nombre, ms.fecha_hora, md.descripcion, ms.cantidad 
                    FROM movimientos_stock ms 
                    LEFT JOIN
                        movimientos_descripcion md ON ms.movimientos_descripcion_id = md.id
                    LEFT JOIN
                        articulos a ON  ms.articulo_id = a.id
                    WHERE articulo_id = " . $this->articuloID . " 
                    ORDER BY ms.fecha_hora";

                $rsMovimientosStock = mysqli_query($conexion, $selMovimientoStock) or
                    die("Problemas en el select:" . mysqli_error($conexion));

                mysqli_close($conexion);

                return $rsMovimientosStock;
            }
        }
?>
