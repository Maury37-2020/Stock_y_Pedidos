<?php
  class pedido{
          private $codigo;
          private $fecha;
          private $prioridad;
          private $usuario;
          private $destinatario;
          private $fecha_entrega;
          private $direccion;
          private $campania;
          private $razon_social;
          
          public function __construct($codigo = null, $fecha = null, $prioridad = null,
                                      $usuario = null, $destinatario = null, $fecha_entrega = null,
                                      $direccion = null,$camapnia=null,$razon_social=null){
          
                $this->codigo = $codigo;
                $this->fecha = $fecha;
                $this->prioridad = $prioridad;
                $this->usuario = $usuario;
                $this->destinatario = $destinatario;
                $this->fecha_entrega = $fecha_entrega;
                $this->direccion = $direccion;
                $this->campania = $camapnia;
                $this->razon_social = $razon_social;
          }

          public function getCodigo(){
            return $this->codigo;
          }
          public function getFecha(){
            return $this->fecha;
          }
          public function getPrioridad(){
            return $this->prioridad;
          }
          public function getUsuario(){
            return $this->usuario;
          }
          public function getDestinatario(){
            return $this->destinatario;
          }
          public function getFecha_entrega()
          {
            return $this->fecha_entrega;
          }
          public function getDireccion()
          {
                    return $this->direccion;
          }
          public function getCampania()
          {
                    return $this->campania;
                  }
          public function getRazon_social()
          {
                    return $this->razon_social;
          }
          public function setFecha_entrega($fecha_entrega)
          {
                    $this->fecha_entrega = $fecha_entrega;

                    return $this;
          }
          public function setPrioridad($prioridad)
          {
                    $this->prioridad = $prioridad;

                    return $this;
          }
          public function setCampania($campania)
          {
                    $this->campania = $campania;

                    return $this;
          }
          public function setDireccion($direccion)
          {
                    $this->direccion = $direccion;

                    return $this;
          }

          public function setRazon_social($razon_social)
          {
                    $this->razon_social = $razon_social;

                    return $this;
          }

          public function cantidadPaginasPedidos($filtro = null){
            include 'conexion.php';

            if($filtro == null){
            $selCantidad = "SELECT CEIL(COUNT(*) / 15) AS totalpaginas
            FROM 
            pedidoscab pc
            JOIN 
            direcciones_destinatarios dd ON pc.direccion_id = dd.id 
            JOIN 
            destinatarios d ON dd.destinatario_id = d.id 
            JOIN
            usuarios u ON pc.usuario_id = u.id 
            JOIN
            prioridades pri ON pc.prioridad_importante = pri.id
            WHERE estado_id = 1 
            ORDER BY 
            pc.prioridad_importante DESC, 
            pc.fecha_creacion ASC;";
            }else{
              //FALTA HACER FILTRO
            }

            $rsCantidadPaginas = mysqli_query($conexion,$selCantidad) or
            die("Problemas en el select " . mysqli_error($conexion));

            $row = $rsCantidadPaginas->fetch_assoc();
            $totalpaginas = $row["totalpaginas"];

            mysqli_close($conexion);
            return $totalpaginas;
          }
          
          
          
          public function obtenerPedidosBandejaEntrada($pagina,$filtro = null){
            include 'conexion.php';

            $numero_pagina = ($pagina - 1) * 15;

            $queryBandejaEntrada = "SELECT 
            pc.id AS codigo,
            pc.fecha_creacion AS fecha,
            pri.descripcion AS prioridad, 
            u.nombre AS usuario,
            d.razon_social AS nombre_destinatario
            FROM 
            pedidoscab pc
            JOIN 
            direcciones_destinatarios dd ON pc.direccion_id = dd.id 
            JOIN 
            destinatarios d ON dd.destinatario_id = d.id 
            JOIN
            usuarios u ON pc.usuario_id = u.id 
            JOIN
            prioridades pri ON pc.prioridad_importante = pri.id
            WHERE estado_id = 1 
            ORDER BY 
            pc.prioridad_importante DESC, 
            pc.fecha_creacion ASC LIMIT 15 OFFSET " . $numero_pagina . ";";

              $rsBandejaEntrada = mysqli_query($conexion,$queryBandejaEntrada);

              if(!$rsBandejaEntrada){
                echo "Erro al ejecutar" . mysqli_error($conexion);
                mysqli_close($conexion);
                return false;
              }

              mysqli_close($conexion);

              return $rsBandejaEntrada;
          }

          public function obtenerPedidosProcesando(){
            include 'conexion.php';

            $queryPedidoProceso = "SELECT 
            pc.id AS codigo,
            pc.fecha_creacion AS fecha,
            pri.descripcion AS prioridad, 
            u.nombre AS usuario,
            di.direccion AS direccion,
            loc.cod_postal_corto AS codigo_postal,
            d.razon_social AS nombre_destinatario
            FROM 
            pedidoscab pc
            JOIN 
            direcciones_destinatarios di ON pc.direccion_id = di.id
            JOIN 
            destinatarios d ON di.destinatario_id = d.id
            JOIN
            usuarios u ON pc.usuario_id = u.id
            JOIN
            prioridades pri ON pc.prioridad_importante = pri.id
            LEFT JOIN 
            localidad loc ON di.id_localidad = loc.id  
            WHERE 
            pc.estado_id = 2
            ORDER BY 
            pc.prioridad_importante DESC, 
            pc.fecha_creacion ASC;";


            $rsPedidoProcesado = mysqli_query($conexion,$queryPedidoProceso);

            if(!$rsPedidoProcesado){
              echo "Error al ejecutar" . mysqli_error($conexion);

              mysqli_close($conexion);

              return false;
            }

            mysqli_close($conexion);

            return $rsPedidoProcesado;

          }

          public function obtenerPedidosEnviados(){
            include 'conexion.php';

            $queryPedidoProceso = "SELECT 
            pc.id AS codigo,
            pc.fecha_creacion AS fecha,
            pc.fecha_despacho AS fecha_despacho,
            pri.descripcion AS prioridad, 
            u.nombre AS usuario,
            di.direccion AS direccion,
            loc.cod_postal_corto AS codigo_postal,
            d.razon_social AS nombre_destinatario
            FROM 
            pedidoscab pc
            JOIN 
            direcciones_destinatarios di ON pc.direccion_id = di.id
            JOIN 
            destinatarios d ON di.destinatario_id = d.id
            JOIN
            usuarios u ON pc.usuario_id = u.id
            JOIN
            prioridades pri ON pc.prioridad_importante = pri.id
            LEFT JOIN 
            localidad loc ON di.id_localidad = loc.id  
            WHERE 
            pc.estado_id = 3
            ORDER BY 
            codigo DESC";

            $rsPedidoProcesado = mysqli_query($conexion,$queryPedidoProceso);

            if(!$rsPedidoProcesado){
              echo "Erro al ejecutar" . mysqli_error($conexion);

              mysqli_close($conexion);

              return false;
            }

            mysqli_close($conexion);

            return $rsPedidoProcesado;

          }
          // HISTORIAL PEDIDOS USR
          public function obtenerMisPedidosUsuario($idUsuario,$pagina,$filtro = null){
            include 'conexion.php';

            $id = (int) $idUsuario;

            $numero_pagina = ($pagina - 1) * 15;

            $queryObtenerMisPedidos = "SELECT 
            pc.id AS codigo,
            pc.fecha_creacion AS fecha,
            pri.descripcion AS prioridad, 
            es.descripcion AS estado,
            d.razon_social AS nombre_destinatario,
            tra.nombre AS transporte,
            pc.campania AS campania
            FROM 
            pedidoscab pc
            LEFT JOIN 
            direcciones_destinatarios dd ON pc.direccion_id = dd.id 
            LEFT JOIN
            estados es ON pc.estado_id = es.id
            LEFT JOIN
            destinatarios d ON dd.destinatario_id = d.id 
            LEFT JOIN
            prioridades pri ON pc.prioridad_importante = pri.id
            LEFT JOIN 
            transportes tra ON pc.transporte_id = tra.id
            WHERE 
            usuario_id = $id
            ORDER BY 
            pc.fecha_creacion DESC LIMIT 15 OFFSET " . $numero_pagina . ";";

            $rsMisPedidos = mysqli_query($conexion,$queryObtenerMisPedidos);

            if(!$rsMisPedidos){
              echo "Error al ejecutar" . mysqli_error($conexion);

              mysqli_close($conexion);

              return false;
            }

            mysqli_close($conexion);

            return $rsMisPedidos;

          }

          public function cantidadPaginas($id_usuario,$filtro = null){
            include 'conexion.php';

            if($filtro == null){
              $selCantidad = "SELECT CEIL(COUNT(*) / 15) AS totalpaginas
            FROM pedidoscab pc
            LEFT JOIN direcciones_destinatarios dd ON pc.direccion_id = dd.id 
            LEFT JOIN estados es ON pc.estado_id = es.id
            LEFT JOIN destinatarios d ON dd.destinatario_id = d.id 
            LEFT JOIN prioridades pri ON pc.prioridad_importante = pri.id
            LEFT JOIN transportes tra ON pc.transporte_id = tra.id
            WHERE usuario_id = $id_usuario;";
            }else{
              //FALTA HACER FILTRO
            }

            $rsCantidadPaginas = mysqli_query($conexion,$selCantidad) or
            die("Problemas en el select " . mysqli_error($conexion));

            $row = $rsCantidadPaginas->fetch_assoc();
            $totalpaginas = $row["totalpaginas"];

            mysqli_close($conexion);
            return $totalpaginas;
          }

          public function cambiarEstadoPedidoEnviado($idPedido,$estado,$idTransporte) {
            include 'conexion.php';
        
            $idPedido = mysqli_real_escape_string($conexion, $idPedido);
            $estado = (int) $estado;
        
            $queryCambiarEstado = "UPDATE pedidoscab 
            SET estado_id = $estado, transporte_id = $idTransporte
            WHERE id = $idPedido";
        
            $rsCambioEstado = mysqli_query($conexion, $queryCambiarEstado);
        
            if (!$rsCambioEstado) {
                echo "Error al ejecutar cambio de estado: " . mysqli_error($conexion);
                mysqli_close($conexion);
                return false;
            }
        
            mysqli_close($conexion);
            return true;
          }
          
          public function cambiarEstadoPedidoProcesado($idPedido,$estado) {
            include 'conexion.php';
        
            $idPedido = mysqli_real_escape_string($conexion, $idPedido);
            $estado = (int) $estado;
        
            $queryCambiarEstado = "UPDATE pedidoscab 
            SET estado_id = $estado
            WHERE id = $idPedido";
        
            $rsCambioEstado = mysqli_query($conexion, $queryCambiarEstado);
        
            if (!$rsCambioEstado) {
                echo "Error al ejecutar cambio de estado: " . mysqli_error($conexion);
                mysqli_close($conexion);
                return false;
            }
        
            mysqli_close($conexion);
            return true;
          }

          public function modificarFechaEnvio($idPedido) {
            include 'conexion.php';
        
            $idPedido = mysqli_real_escape_string($conexion, $idPedido);
            $fechaEnvio = date('Y-m-d H:i:s');
            
            $queryCambiarFecha = "UPDATE pedidoscab SET
             fecha_despacho = '$fechaEnvio' WHERE id = $idPedido";
        
            $rsCambioEstado = mysqli_query($conexion, $queryCambiarFecha);
        
            if (!$rsCambioEstado) {
                echo "Error al ejecutar cambio de fecha: " . mysqli_error($conexion);
                mysqli_close($conexion);
                return false;
            }
        
            mysqli_close($conexion);
            return true;
          }

        public static function obtenerCantidadDeBultos($id_pedido){
          include 'conexion.php';
      
          $queryBultos = "SELECT COUNT(*) as cantidad FROM bultos WHERE id_pedido = $id_pedido;";
      
          $rsBultos = mysqli_query($conexion, $queryBultos);
      
          if (!$rsBultos) {
              echo "Error al ejecutar query bultos";
              mysqli_close($conexion);
              return false;
          } else {
              $row = mysqli_fetch_assoc($rsBultos); // Obtener la fila del resultado
              mysqli_close($conexion);
              return $row['cantidad']; // Devolver la cantidad
          }
        }

        public function obtenerDatosPdf($idPedido) {
          include 'conexion.php';
      
          $queryDatosPdf = "SELECT 
              pc.fecha_creacion AS fecha,
              pri.descripcion AS prioridad, 
              u.nombre AS usuario,
              d.razon_social AS nombre_destinatario
              FROM 
              pedidoscab pc
              LEFT JOIN 
              direcciones_destinatarios dd ON pc.direccion_id = dd.id 
              LEFT JOIN 
              destinatarios d ON dd.destinatario_id = d.id 
              LEFT JOIN
              usuarios u ON pc.usuario_id = u.id 
              LEFT JOIN
              prioridades pri ON pc.prioridad_importante = pri.id
              WHERE pc.id = $idPedido;";
      
          $rsDatos = mysqli_query($conexion, $queryDatosPdf);
      
          if (!$rsDatos) {
              echo "Error al ejecutar" . mysqli_error($conexion);
              mysqli_close($conexion);
              return false;
          }
      
          $datos = mysqli_fetch_assoc($rsDatos);
          mysqli_close($conexion);
      
          return $datos;
      }

      public function obtenerDatosCaratulas($idPedido) {
        include 'conexion.php';
    
        $queryDatosPdf = "SELECT 
        dest.razon_social AS destinatario,
        dd.telefono AS telefono,
        loc.cod_postal_corto AS codigo_postal,
        dd.direccion AS direccion,
        prov.nombre AS provincia,
        loc.nombre AS ciudad,
        dd.horario_desde AS horaD,
        dd.horario_hasta AS horaH
        FROM 
        pedidoscab pc
        LEFT JOIN 
        direcciones_destinatarios dd ON pc.direccion_id = dd.id
        LEFT JOIN 
        destinatarios dest ON dd.destinatario_id = dest.id
        LEFT JOIN 
        localidad loc ON dd.id_localidad = loc.id
        LEFT JOIN 
        provincias prov ON loc.id_provincia = prov.id
        WHERE 
        pc.id = $idPedido;";
    
        $rsDatos = mysqli_query($conexion, $queryDatosPdf);
    
        if (!$rsDatos) {
            echo "Error al ejecutar" . mysqli_error($conexion);
            mysqli_close($conexion);
            return false;
        }
    
        $datos = mysqli_fetch_assoc($rsDatos);
        mysqli_close($conexion);
    
        return $datos;
    }
      
          
        }

        class pedidoDetalle {
          private $nombre_articulo;
          private $descripcion_articulo;
          private $cantidad;
      
          public function __construct($nombre_articulo = null, $descripcion_articulo = null, $cantidad = null) {
              $this->nombre_articulo = $nombre_articulo;
              $this->descripcion_articulo = $descripcion_articulo;
              $this->cantidad = $cantidad;
          }
      
          public function getNom_articulo() {
              return $this->nombre_articulo;
          }
      
          public function getDescripcion_articulo() {
              return $this->descripcion_articulo;
          }
      
          public function getCantidad() {
              return $this->cantidad;
          }
      
          public static function obtenerDetalle($idPedido){
              include 'conexion.php';
      
              $queryDetalle = "SELECT 
                  pd.cantidad AS cantidad,
                  a.nombre AS nombre_articulo,
                  a.descripcion AS descripcion_articulo
                  FROM 
                  pedidosdet pd
                  LEFT JOIN 
                  articulos a ON pd.articulo_id = a.id
                  WHERE 
                  pd.pedidoscab_id = $idPedido;";
              
              $rsDetalle = mysqli_query($conexion, $queryDetalle);
              if (!$rsDetalle) {
                  echo "Error al ejecutar" . mysqli_error($conexion);
                  mysqli_close($conexion);
                  return false;
              }
      
              $detalles = [];
              while ($row = mysqli_fetch_assoc($rsDetalle)) {
                  $detalles[] = new self($row['nombre_articulo'], $row['descripcion_articulo'], $row['cantidad']);
              }
      
              mysqli_close($conexion);
              return $detalles;
          }

          public static function obtenerDetallePdf($idPedido) {
            include 'conexion.php';
        
            $queryDetalle = "SELECT
                a.id AS codigo,
                a.nombre AS nombre_articulo,
                pd.cantidad AS cantidad
                FROM 
                pedidosdet pd
                LEFT JOIN 
                articulos a ON pd.articulo_id = a.id
                WHERE 
                pd.pedidoscab_id = $idPedido;";
            
            $rsDetalle = mysqli_query($conexion, $queryDetalle);
            if (!$rsDetalle) {
                echo "Error al ejecutar" . mysqli_error($conexion);
                mysqli_close($conexion);
                return false;
            }
        
            $detalles = [];
            while ($row = mysqli_fetch_assoc($rsDetalle)) {
                $detalles[] = [
                    'codigo' => $row['codigo'],
                    'nombre_articulo' => $row['nombre_articulo'],
                    'cantidad' => $row['cantidad']
                ];
            }
        
            mysqli_close($conexion);
            return $detalles;
        }
        

          private function obtenerIdDireccion($idPedido) {
            include 'conexion.php';
    
            $queryIdDireccion = "SELECT direccion_id FROM pedidoscab WHERE id = $idPedido;";
            $rsId = mysqli_query($conexion, $queryIdDireccion);
    
            if (!$rsId) {
                echo "Error al buscar ID de la dirección: " . mysqli_error($conexion);
                mysqli_close($conexion);
                return null;
            }
    
            $row = mysqli_fetch_assoc($rsId);
            mysqli_close($conexion);
            return $row['direccion_id'];
        }
    
        public static function obtenerCiudad($idPedido) {
            include 'conexion.php';
            $pedido = new self();
            //$idDireccion = $pedido->obtenerIdDireccion($idPedido);
    
            if ($idPedido === null) {
                return null;
            }
    
            $queryCiudad = "SELECT 
            loc.nombre AS ciudad
            FROM 
            pedidoscab pc
            LEFT JOIN 
            direcciones_destinatarios di ON pc.direccion_id = di.id
            LEFT JOIN 
            localidad loc ON di.id_localidad = loc.id
            WHERE 
            pc.id = $idPedido;";
            $rsCiudad = mysqli_query($conexion, $queryCiudad);
    
            if (!$rsCiudad) {
                echo "Error al buscar ciudad: " . mysqli_error($conexion);
                mysqli_close($conexion);
                return null;
            }
    
            $row = mysqli_fetch_assoc($rsCiudad);
            mysqli_close($conexion);
            return $row['ciudad'];
        
          }

          public function obtenerDatosDestinoPdf($idPedido){
            include 'conexion.php';
            $pedido = new self();
            $idDireccion = $pedido->obtenerIdDireccion($idPedido);
    
            if ($idDireccion === null) {
                return null;
            }
    
            $queryCiudad = "SELECT 
            prov.nombre AS provincia,
            loc.nombre AS ciudad,
            dd.direccion AS direccion,
            loc.cod_postal_corto AS codigo_postal,
            dd.telefono AS telefono
            FROM 
            pedidoscab pc
            LEFT JOIN 
            direcciones_destinatarios dd ON pc.direccion_id = dd.id
            LEFT JOIN 
            localidad loc ON dd.id_localidad = loc.id
            LEFT JOIN 
            provincias prov ON loc.id_provincia = prov.id
            WHERE 
            pc.id = $idPedido;";
            $rsDatosDireccion = mysqli_query($conexion, $queryCiudad);
    
            if (!$rsDatosDireccion) {
                echo "Error al buscar ciudad: " . mysqli_error($conexion);
                mysqli_close($conexion);
                return null;
            }
    
            $row = mysqli_fetch_assoc($rsDatosDireccion);
            mysqli_close($conexion);
            return $row; 
          }

          public static function obtenerTransporte($idPedido){
            include 'conexion.php';
            //$pedido = new self();
            //$idDireccion = $pedido->obtenerIdDireccion($idPedido);
    
            $queryTransporte = "SELECT nombre 
            FROM transportes 
            WHERE id IN (SELECT transporte_id FROM pedidoscab WHERE id = $idPedido);";
            $rsTrasnp = mysqli_query($conexion, $queryTransporte);
    
            if (!$rsTrasnp) {
                echo "Error al buscar ciudad: " . mysqli_error($conexion);
                mysqli_close($conexion);
                return null;
            }
    
            $row = mysqli_fetch_assoc($rsTrasnp);
            mysqli_close($conexion);
            return $row ? $row['nombre'] : null;
        
          }

        }
        

        
      
?>