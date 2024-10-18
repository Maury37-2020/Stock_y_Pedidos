<?php
    class carrito_cab {
        private $id;
        private $fecha_entrega;
        private $prioridad_importante;
        private $destinatario;
        private $nro_sistema_externo;
        private $en_carrito;
        private $carrito_detalle = array();

        public function __construct($id = null, $en_carrito = null) {
            $this->id = $id;
            $this->en_carrito = $en_carrito;
        }

        public function set_fecha_entrega($fecha){
            $this->fecha_entrega = $fecha;
        }

        public function get_fecha_entrega() {
            return $this->fecha_entrega;
        }

        public function set_es_importante($es_importante){
            $this->prioridad_importante = $es_importante;
        }

        public function get_es_importante(){
            return $this->prioridad_importante;
        }

        public function set_destinatario($destinatario){
            $this->destinatario = $destinatario;
        }

        public function get_destinatario(){
            return $this->destinatario;
        }

        public function get_detalle() {
            return $this->carrito_detalle;
        }

        public function obtener_carrito($usuario_id){
            include 'conexion.php';

            $selPedido = "SELECT id FROM carrito_cab WHERE usuario_id=" . $usuario_id
                . " and en_carrito=1";
            
            $rsPedido = mysqli_query($conexion,$selPedido);
            $result = mysqli_fetch_assoc($rsPedido);
            
            mysqli_close($conexion);

            if(mysqli_num_rows($rsPedido) > 0) {
                $this->id = $result['id'];                
                return $this->id;
            } else {
                return 0;
            }
        }


        public function obtener_datos_wizardUno($usuario_id) {
            include 'conexion.php';
            include 'pedido.php';
        
            $idCarrito = $this->obtener_carrito($usuario_id);
        
            // Asegurarse de que idCarrito no sea 0 o NULL
            if (!$idCarrito) {
                return null;
            }
        
            $queryDatosCarrito = "SELECT prioridad_importante, fecha_entrega, campania 
                                  FROM carrito_cab
                                  WHERE id = $idCarrito";
        
            $rsDatos = mysqli_query($conexion, $queryDatosCarrito);
        
            if ($rsDatos && mysqli_num_rows($rsDatos) > 0) {
                $datosCarrito = mysqli_fetch_assoc($rsDatos);
        
                $pedido = new pedido();
                $pedido->setFecha_entrega($datosCarrito["fecha_entrega"]);
                $pedido->setCampania($datosCarrito["campania"]);
                $pedido->setPrioridad($datosCarrito["prioridad_importante"]);
        
                return $pedido;
            } else {
                return null;
            }
            mysqli_close($conexion);
        }

        public function insertar_carrito_detalle_prueba($usuario_id,$articulo_id,$cantidad){
            include 'conexion.php';

            $nroCarrito = $this->obtener_carrito($usuario_id);

            $selTotalDetalle = "SELECT count(*) as total FROM carrito_det WHERE carrito_cab_id=" . $nroCarrito;
            $rsTotalDetalle = mysqli_query($conexion, $selTotalDetalle);
            $total = mysqli_fetch_assoc($rsTotalDetalle);

            if ($total["total"] <= 30){
                $insDetalle = "INSERT INTO carrito_det (carrito_cab_id,articulo_id,cantidad)
                          VALUES(". $nroCarrito . "," . $articulo_id . "," . $cantidad . ")";
            
                mysqli_query($conexion,$insDetalle);        
            } else {
                $message = "El limite del carrito es de 30 productos";
                echo "<script>showSnackbar('".htmlspecialchars($message, ENT_QUOTES, 'UTF-8')."');</script>";

            }            
            mysqli_close($conexion);
        }

        public function insertar_carritoPrueba($usuario_id, $prioridad, $fecha_entrega, $campania){
            include 'conexion.php';
        
            $nroCarrito = $this->obtener_carrito($usuario_id);
        
            if($nroCarrito === 0){

                $prioridad = intval($prioridad); 
        
                $insCarrito = "INSERT INTO carrito_cab (usuario_id, prioridad_importante, fecha_entrega, campania, en_carrito)
                                VALUES ('$usuario_id', $prioridad, '$fecha_entrega', '$campania', 1)";
        
                mysqli_query($conexion, $insCarrito);
                
                $nroCarrito = mysqli_insert_id($conexion);
                return true;
            }else if($nroCarrito != 0){

                $prioridad = intval($prioridad);

                $updateCarrito = "UPDATE carrito_cab 
                  SET prioridad_importante = $prioridad, 
                      fecha_entrega = '$fecha_entrega',
                      campania = '$campania', 
                      en_carrito = 1 WHERE id = $nroCarrito;";

            
            mysqli_query($conexion, $updateCarrito);
                
            $nroCarrito = mysqli_insert_id($conexion);

            return true;
            }
        
            mysqli_close($conexion);
            
        }

        function moverCarritoAPedido($idcarrito){
            include 'conexion.php';

            try{
                mysqli_begin_transaction($conexion);

                $selControlStock = "SELECT a.id, a.nombre, a.stock, cd.cantidad FROM carrito_det cd
	                JOIN articulos a ON cd.articulo_id = a.id
                        WHERE cd.carrito_cab_id = $idcarrito;";
            
                $rsControlStock = mysqli_query($conexion, $selControlStock);

                //var_dump($rsControlStock);

                $controlStockResult = []; 
                foreach ($rsControlStock as $stock) {
                    $controlStockResult[] = array(
                        'id' => $stock['id'],
                        'nombre' => $stock['nombre'],
                        'estado' => ($stock['stock'] >= $stock['cantidad']) ? 'ok' : 'Er: stock insuficiente.'
                    );
                }
                
                //var_dump($controlStockResult);

                $resultOK = true;
                foreach($controlStockResult as $resultado){
                    if(substr($resultado['estado'], 0, 2) !== 'ok'){
                        $resultOK = false;
                    }
                }
            
                //var_dump($resultOK);
                if ($resultOK) {
                    //mover los datos de carrito a pedidos.
                    $selCarrito = "SELECT fecha_entrega, prioridad_importante, direccion_id, usuario_id, campania 
                            FROM carrito_cab WHERE id=$idcarrito";
                
                    //var_dump($selCarrito);

                    $rsCarrito = mysqli_query($conexion, $selCarrito);
                    $arrCarrito = mysqli_fetch_assoc($rsCarrito);

                    //var_dump($arrCarrito);

                    $insPedido = "INSERT INTO pedidoscab (carrito_id, estado_id, fecha_entrega, prioridad_importante, direccion_id, usuario_id, campania)
                                VALUES($idcarrito, 1,'" . $arrCarrito['fecha_entrega'] . "'," . $arrCarrito['prioridad_importante'] . "," .
                                    $arrCarrito['direccion_id'] . "," . $arrCarrito['usuario_id'] . ",'" .$arrCarrito['campania']  . "');";

                    
                    //var_dump($insPedido);

                    if(!mysqli_query($conexion,$insPedido)){
                        throw new Exception("Error al pasar la cabecera del Carrito a Pedido");
                    }

                    $idpedido = mysqli_insert_id($conexion);

                    //var_dump($idpedido);

                    foreach ($rsControlStock as $pedido) {
                        $insDestallePedido = "INSERT INTO pedidosdet (articulo_id, cantidad, pedidoscab_id)
                                        VALUES(" . $pedido['id'] . "," . $pedido['cantidad'] . ",$idpedido)";
                        //var_dump($insDestallePedido);
                        if(!mysqli_query($conexion,$insDestallePedido)){
                            throw new Exception("Error al pasar el detalle del Carrito a Pedido");
                        }   
                    }   

                    //desactivar el carrito
                    $updCarritoCab = "UPDATE carrito_cab SET en_carrito=0 WHERE id=$idcarrito";

                    //var_dump($updCarritoCab);

                    if(!mysqli_query($conexion,$updCarritoCab)){
                        throw new Exception("Error al desactivar el carrito");
                    }

                    //inserta los movimientos de los articulos en movimientos
                    foreach($rsControlStock as $resultado){
                        $insMovimientos = "INSERT INTO movimientos_stock (movimientos_descripcion_id, articulo_id, cantidad) 
                                    VALUES(5," . $resultado['id'] . "," . (-$resultado['cantidad']) . ");";
                        //var_dump($insMovimientos);
                        if(!mysqli_query($conexion,$insMovimientos)){   
                            throw new Exception("Error al insertar movimientos de stock de articulos");
                        }  
                    }
                    mysqli_commit($conexion);
                }else{
                    mysqli_rollback($conexion);
                }
                return $controlStockResult;
            } catch (Exception $ex) {
                return $ex->getMessage();
            }
        }

    }

    class carrito_det {
        private $id;
        private $articulo;
        private $cantidad;

        public function __construct($id = null, $articulo =null,  $cantidad = null) {
            $this->id = $id;
            $this->articulo = $articulo;
            $this->cantidad = $id;
        }

        public function set_articulo($articulo){
            $this->articulo;       
        }

        public function get_articulo(){
            return $this->articulo;
        }

        public function get_detalle_carrito($carrito_id) {
            include 'conexion.php';

            $selDetalle = "SELECT a.id as id, det.id detid, det.cantidad, a.foto1, a.nombre FROM carrito_det det 
                JOIN articulos a ON  a.id=det.articulo_id 
                WHERE carrito_cab_id=" . $carrito_id;

            $rsDetalle = mysqli_query($conexion,$selDetalle);
            
            $resultsArray = [];
            while ($row = $rsDetalle->fetch_assoc()) {
                 $resultsArray[] = $row;
            }

            mysqli_close($conexion);

           return $resultsArray;
        }

        public function borrar_detalle($id){
            include 'conexion.php';

            $delDetalle = "DELETE FROM carrito_det WHERE id=" . $id;

            mysqli_query($conexion,$delDetalle);

            mysqli_close($conexion);
        }

        public function esta_en_carrito($id, $detalleCarrito){
            include 'conexion.php';

            if ($detalleCarrito) {
                foreach ($detalleCarrito as $row) {
                    if ($row['id'] === $id) {
                        return 1;
                    }
                }
            }
            return 0;
        }
    }
?>