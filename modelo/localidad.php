<?php
    class localidad{
        private $id;
        private $nombre;
        private $cod_postal_corto;
        private $cod_postal_largo;
        private $id_provincia;

        public function __construct($id = null, $nombre = null, $cod_postal_corto = null, $cod_postal_largo = null, $id_provincia = null)
        {
            $this->id = $id;
            $this->nombre = $nombre;
            $this->cod_postal_corto = $cod_postal_corto;
            $this->cod_postal_largo = $cod_postal_largo;
            $this->id_provincia = $id_provincia;

        }

        public function crearLocalidad($nombre,$cod_postal_corto,$cod_postal_largo,$idProv){
            include 'conexion.php';

            $queryInsert = "INSERT INTO localidad(nombre,cod_postal_corto,cod_postal_largo,id_provincia)
            VALUES ('$nombre','$cod_postal_corto','$cod_postal_largo',$idProv);";

            $queryExisteCodPostal = "SELECT COUNT(cod_postal_largo) AS total FROM localidad WHERE cod_postal_largo = '$cod_postal_largo';";

            $codPostalTotal = mysqli_query($conexion,$queryExisteCodPostal);

            if($codPostalTotal){
                $row = mysqli_fetch_assoc($codPostalTotal);
                $total = isset($row['total']) ? $row['total'] : 0;
            }else{
                $total = 0;
            }

            if($total > 0){
                return null;
            }

            if(mysqli_query($conexion,$queryInsert)){
                $response = "Se creo localidad";
            }else{
                $response = "Error al crear localidad " . mysqli_error($conexion);
            }

            mysqli_close($conexion);

            return $response;

        }

        public function eliminarLocalidad($id_localidad){
            include 'conexion.php';

            $queryEstaEnPedido = "SELECT COUNT(direccion_id) AS total FROM pedidoscab WHERE direccion_id IN (SELECT id FROM direcciones_destinatarios
            WHERE id_localidad = $id_localidad);";

            $queryDelete  = "DELETE FROM localidad WHERE id = $id_localidad";

            $estaEnPedido = mysqli_query($conexion,$queryEstaEnPedido);

            if($estaEnPedido){
                $row = mysqli_fetch_assoc($estaEnPedido);
                $total = $row['total'];
            }

            if($total > 0){
                $response = "No se puede eliminar. La localidad esta asociada a un pedido" . mysqli_error($conexion);
            }else{
                mysqli_query($conexion,$queryDelete);
                $response = "Se elimino la localidad";
            }

            mysqli_close($conexion);
            
            return $response;

        }

        public function obtenerLocalidadesPorProvincia($idProv){
            include 'conexion.php';

            $queryLocalidades = "SELECT id,nombre FROM localidad WHERE id_provincia = $idProv";

            $listLocalidades = [];

            $result = mysqli_query($conexion,$queryLocalidades);

            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $listLocalidades[] = $row;
                }
            }

            mysqli_close($conexion);

            return $listLocalidades;
        }


        public function obtenerProvincias(){
            include 'conexion.php'; 
        
            $queryProv = "SELECT id, nombre FROM provincias;";
        
            $listProv = []; 

            $result = mysqli_query($conexion,$queryProv); 
        
            if ($result->num_rows > 0) {
                
                while($row = $result->fetch_assoc()) {
                    $listProv[] = $row; 
                }
            }

            mysqli_close($conexion);

            return $listProv; 
        }
    }





?>