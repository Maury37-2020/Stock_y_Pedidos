<?php
    class destinatario {
        private $id;
        private $nombre;
        private $DNI;
        private $direccion;
        private $mail;

        public function __construct($id = null, $nombre = null, $DNI = null,$mail = null) {
            $this->id = $id;
            $this->nombre = $nombre;
            $this->DNI = $DNI;
            $this->mail = $mail;
        }

        public function set_direccion($direccion){
            $this->direccion = $direccion;
        }

        public function get_direccion(){
            return $this->direccion;
        }

        public function set_nombre($nombre){
            $this->nombre = $nombre;
        }

        public function set_DNI($DNI){
            $this->DNI = $DNI;
        }

        public function set_mail($mail){
            $this->mail = $mail;
        }

        public function get_destinatarios(){
            include 'conexion.php';

            $selDestinatarios = "SELECT id, razon_social, DNI FROM destinatarios;";

            $rsDestinatarios = mysqli_query($conexion,$selDestinatarios);
            
            $resultsArray = [];
            while ($row = $rsDestinatarios->fetch_array()) {
                $resultsArray[] = [
                    'id' => $row[0],
                    'desc' => $row[1]
                ];
            }

            mysqli_close($conexion);

            return $resultsArray;
        }

        public function obtenerDestinatariosPaginados($pagina, $filtro = null){
            include 'conexion.php';

            $numero_pagina = ($pagina - 1) * 15;

            if($filtro == null){
                $selArticulos = "SELECT id,razon_social,dni,mail FROM destinatarios ORDER BY razon_social ASC LIMIT 15 OFFSET " . $numero_pagina  . ";";
            } else {
                $selArticulos = "SELECT id,razon_social,dni,mail FROM destinatarios WHERE razon_social LIKE '%". $filtro ."%' LIMIT 15 OFFSET " . $numero_pagina . ";";
            }

            $rsDestinatarios = mysqli_query($conexion, $selArticulos) or
                die("Problemas en el select:" . mysqli_error($conexion));

            mysqli_close($conexion);
            return $rsDestinatarios;
        }

        public function cantidadPaginas($filtro = null){
            include 'conexion.php';
            if($filtro == null){
                $selCantidad = "SELECT ceil(count(*)/15) as totalpaginas FROM destinatarios;";
            } else {
                $selCantidad = "SELECT ceil(count(*)/15) as totalpaginas FROM destinatarios LIKE '%". $filtro ."%';";
            }

            $rsCantidadPaginas = mysqli_query($conexion, $selCantidad) or
                die("Problemas en el select:" . mysqli_error($conexion));

            $row = $rsCantidadPaginas->fetch_assoc();
            $totalpaginas = $row["totalpaginas"];   

            mysqli_close($conexion);
            return $totalpaginas;

        }

        public function obtenerIdDireccioensDestinatario($idDest){
            include 'conexion.php';

            $queryIds = "SELECT id FROM direcciones_destinatarios WHERE destinatario_id = $idDest;";

            $rsIds = mysqli_query($conexion,$queryIds);

            $listIds = [];

            while($row = $rsIds->fetch_array()){
                $listIds[] = $row['id'];
            }

            mysqli_close($conexion);

            return $listIds;
        }

        public function guardarDestinatario($razon_social, $dnicuit, $mail) {
            include 'conexion.php';
        
            $queryExisteDest = "SELECT COUNT(dni) as valor FROM destinatarios WHERE dni = '$dnicuit';";
            $resultExisteDest = mysqli_query($conexion, $queryExisteDest);
        
            if (empty($razon_social) || empty($dnicuit)) {
                return null;
            }
        
            $row = mysqli_fetch_assoc($resultExisteDest);
            $existe = $row['valor'];
        
            if ($existe > 0) {
                return null;
            }
        
            $insDest = "INSERT INTO destinatarios (razon_social, dni, mail) VALUES ('$razon_social', '$dnicuit', '$mail')";
        
            if (mysqli_query($conexion, $insDest)) {
                $response = "OK: Se inserto el destinatario"; 
            } else {
                $response = "Error: " . $insDest . "<br>" . mysqli_error($conexion);
            }
        
            mysqli_close($conexion);
        
            return $response;
        }

        public function modificarDestinatario($idDest,$nombre,$dni,$mail){
            include 'conexion.php';

            $idDest = (int) $idDest;

            $queryModificar = "UPDATE  destinatarios SET razon_social = '$nombre', dni = '$dni',
            mail = '$mail' WHERE id = $idDest;";
            
            mysqli_query($conexion,$queryModificar);

            mysqli_close($conexion);


        }

        public function eliminarDestinatario($idDest) {
            include 'conexion.php';
            $direccion = new direccion();
        
            $idDest = (int) $idDest;
        
            // ver si esta en pedido
            $queryEstaEnPedido = "SELECT COUNT(direccion_id) AS total FROM pedidoscab WHERE direccion_id IN (SELECT id FROM direcciones_destinatarios WHERE destinatario_id = $idDest)";
            
            $estaEnpedido = mysqli_query($conexion, $queryEstaEnPedido);
        
            if($estaEnpedido) {
                $row = mysqli_fetch_assoc($estaEnpedido);
                $total = $row['total'];
            }
        
            if($total > 0) {
                $response = "No se puede eliminar. El destinatario está asociado a un pedido.";
            } else {
                // Eliminar dir asociadas
                $queryEliminarDirecciones = "DELETE FROM direcciones_destinatarios WHERE destinatario_id = $idDest";
                mysqli_query($conexion, $queryEliminarDirecciones);
        
                // eliminar dest
                $queryEliminarDest = "DELETE FROM destinatarios WHERE id = $idDest";
                mysqli_query($conexion, $queryEliminarDest);
                
                $response = "Éxito al eliminar el destinatario.";
            }
        
            mysqli_close($conexion);
            return $response;
        }


    }

    class direccion {
        private $id;
        private $telefono;
        private $direccion;
        private $provincia;
        private $ciudad;
        private $horario_desde;
        private $horario_hasta;

        public function __construct($id = null, $telefono = null, $direccion = null, $provincia = null,$ciudad = null,
                                    $horario_desde = null, $horario_hasta = null) {
            $this->id = $id;
            $this->telefono = $telefono;
            $this->direccion = $direccion;
            $this->provincia = $provincia;
            $this->ciudad = $ciudad;
            $this->horario_desde = $horario_desde;
            $this->horario_hasta = $horario_hasta;
        }

        function obtenerDireccUnDest($id){
            include 'conexion.php';

            $selDir = "SELECT dd.id AS id,
            prov.nombre AS provincia,
			loc.nombre AS ciudad,
			dd.direccion, 
			dd.telefono,
            dd.horario_desde AS horaD,
            dd.horario_hasta AS horaH
            FROM 
            direcciones_destinatarios dd
            LEFT JOIN 
            localidad loc ON dd.id_localidad = loc.id
            LEFT JOIN 
            provincias prov ON loc.id_provincia = prov.id
            WHERE 
            dd.destinatario_id = $id";

            $rsDirecciones = mysqli_query($conexion,$selDir);

            mysqli_close($conexion);

            return $rsDirecciones;  
        }

        function obtenerDirecciones($idx){
            include 'conexion.php';

            $selDirecciones = "SELECT dd.id, dd.destinatario_id, dd.telefono, dd.direccion, 
            prov.nombre AS provincia, 
            loc.cod_postal_corto AS cod_postal_corto, 
            loc.nombre AS ciudad, 
            'f' AS actual 
            FROM 
            direcciones_destinatarios dd
            LEFT JOIN 
            localidad loc ON dd.id_localidad = loc.id
            LEFT JOIN 
            provincias prov ON loc.id_provincia = prov.id
            WHERE 
            dd.destinatario_id = " . intval($idx);

            $rsDirecciones = mysqli_query($conexion,$selDirecciones);

            mysqli_close($conexion);

            return $rsDirecciones;
            
        }

        public function crearNuevaDireccion($idDest,$telefono,$direccion,$horaD,$horaH,$idLocalidad){
            include 'conexion.php';

            $idLocalidad = (int) $idLocalidad;

            $queryInsert = "INSERT INTO direcciones_destinatarios (destinatario_id, telefono, direccion, 
            horario_desde, horario_hasta, id_localidad)
            VALUES ($idDest,'$telefono','$direccion', '$horaD','$horaH',$idLocalidad);";

            if(mysqli_query($conexion,$queryInsert)){
                $response = "Se inserto direccion";
            }else{
                $response = "Error: no se pudo insertar direccion";
            }

            mysqli_close($conexion);

            return $response;
        }

        public function modificarDireccionDest($idDir,$direccion,$telefono,$horaD,$horaH){
            include 'conexion.php';

            $idDir = (int) $idDir;

            $queryModificar = "UPDATE direcciones_destinatarios SET direccion = '$direccion', telefono = '$telefono',
            horario_desde = '$horaD', horario_hasta = '$horaH' WHERE id = $idDir;";

            mysqli_query($conexion,$queryModificar);

            mysqli_close($conexion);
        }

        function guardarDireccionCarrito($idcarrito, $iddireccion){
            include 'conexion.php';

            $updDireccion = "UPDATE carrito_cab SET direccion_id=$iddireccion WHERE id=$idcarrito";

            $response = "";
            if (mysqli_query($conexion, $updDireccion)) {
                $response = "ok";
            } else {
                $response = "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
            
            // Cerrar la conexión
            mysqli_close($conexion);

            return $response;
        }
        

        function obtenerDireccionesDestinatarios($id){
            include 'conexion.php';

            $selDirDest = "SELECT dd.id, d.razon_social,dd.telefono,dd.direccion, loc1.nombre AS ciudad, prov.nombre AS provincia,  loc1.cod_postal_corto, '' as actual 
                        FROM 
                        direcciones_destinatarios dd 
                        LEFT JOIN 
                        destinatarios d ON d.id = dd.destinatario_id  
                        LEFT JOIN 
                        localidad loc1 ON loc1.id = dd.id_localidad  
                        LEFT JOIN 
                        provincias prov ON loc1.id_provincia = prov.id 
                        WHERE 
                        destinatario_id IN ( 
                        SELECT destinatario_id 
                        FROM carrito_cab cc 
                        JOIN direcciones_destinatarios de ON cc.direccion_id = de.id 
                        JOIN destinatarios d ON d.id = de.destinatario_id 
                        WHERE cc.id=$id) ";
                        
            $rsDirDest = mysqli_query($conexion,$selDirDest);

            $selDirActual = "SELECT direccion_id FROM carrito_cab where id=$id";
            $rsDirActual = mysqli_query($conexion,$selDirActual);
            $arrDirActual = mysqli_fetch_assoc($rsDirActual);

            $direcciones = [];
            if ($rsDirDest) {
                while ($fila = mysqli_fetch_assoc($rsDirDest)) {
                    if($fila['id']===$arrDirActual['direccion_id']){
                        $fila['actual'] = 't';
                    }else{
                        $fila['actual'] = 'f';
                    }
                    $direcciones[] = $fila;
                }
            } 

            return $direcciones;
                
        }

        public function eliminarDireccion($idDir){
            include 'conexion.php';

            $queryDelete = "DELETE FROM direcciones_destinatarios where destinatario_id = $idDir;";

            if(mysqli_query($conexion,$queryDelete)){
                $response = "Exito al elminar direccion";
            }else{
                $response = "No se pudo eliminar direccion " . mysqli_error($conexion);
            }

            mysqli_close($conexion);

            return $response; 
            
        }

        public function eliminarUnaDireccion($id){
            include 'conexion.php';

            $queryDelete = "DELETE FROM direcciones_destinatarios where id = $id;";
            
            if(mysqli_query($conexion,$queryDelete)){
                $response = "Exito al elminar direccion";
            }else{
                $response = "No se pudo eliminar direccion " . mysqli_error($conexion);
            }

            mysqli_close($conexion);

            return $response; 
            
        }
    }
?>