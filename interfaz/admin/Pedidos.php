<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../../css/admin/pedidos.css">
    <link rel="stylesheet" href="../../css/uicons-solid-rounded.css">
    <link rel="icon" type="image/x-icon" href="../../assets/logo.jpg">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos</title>
</head>
<body class="body-pedidos">
<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    
    include '../../modelo/conexion.php';
    include '../../helper/usuarioValidar.php';
    include 'barraNavegacionAdmin.php';
    include '../../modelo/pedido.php';
    include '../../modelo/bultos.php'; 
    require_once(__DIR__ . '../../../fpdf186/generarPdf.php');
    

    $pedido = new pedido();
    $pedidoDet = new pedidoDetalle();
    $pagina = isset($_GET["pag"]) ? (int)$_GET["pag"] : 1;
    $cantidadPaginas = $pedido->cantidadPaginasPedidos(null);
    $listPedidos = $pedido->obtenerPedidosBandejaEntrada($pagina,null);
    $listPedidoEnProceso = $pedido->obtenerPedidosProcesando();
    $listPedidosEnviados = $pedido->obtenerPedidosEnviados();

    if (isset($_POST['idPedido']) && isset($_POST['btnCambioEstadoEnProceso'])) {
        $pedido->cambiarEstadoPedidoProcesado($_POST['idPedido'],2);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit(); 
    }
     
    
    
     if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $embalajes = [];
        $pesos = [];
    
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'embalaje') === 0) {
                $embalajes[] = $value;
            } elseif (strpos($key, 'peso') === 0) {
                $pesos[] = $value;
            }
        }
    

        $bultos_array = [];
    
        // Verificar que todas las entradas de embalaje y peso están definidas
        foreach ($embalajes as $index => $embalaje) {
            if ($embalaje != "0" && isset($pesos[$index])) {
                $bulto = new bultos(null, $_POST['idPedido'], $pesos[$index], $embalaje);
                $bultos_array[] = $bulto;
            }
        }
        
        if (isset($_POST['idPedido']) && isset($_POST['btnCambioEstadoEnviado'])) {
            $idTransporte = $_POST['transp'];
            $idPedido = $_POST['idPedido'];
            $pedido->cambiarEstadoPedidoEnviado($idPedido,3,$idTransporte);
            $pedido->modificarFechaEnvio($idPedido);
            foreach ($bultos_array as $bulto) {
                $id_pedido = $bulto->getId_pedido();
                $id_peso = $bulto->getId_peso();
                $id_tamanio = $bulto->getId_tamanio();
                $bulto->insertar($id_pedido,$id_peso,$id_tamanio);
            }
            $bultos_array = [];
            header("Location: " . $_SERVER['PHP_SELF']);
            exit(); 
        }

        //BTN IMPRIMIR

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idPedidoImprimir'])) {
            $pedido = new pedido();
            $pedidoDetalle = new pedidoDetalle();
            $idPedido = $_POST['idPedidoImprimir'];
            $datosPedido = $pedido->obtenerDatosPdf($idPedido);
            $items = $pedidoDetalle->obtenerDetallePdf($idPedido);
            $datosDireccion = $pedidoDetalle->obtenerDatosDestinoPdf($idPedido);
            if ($datosPedido) {
                
        
                try {
                    $pdf = new PDF();
                    $pdf->AddPage();
                    $pdf->AliasNbPages();
                    $pdf->LlenarDatos(
                        $datosPedido['fecha'],
                        $datosPedido['usuario'],
                        $datosPedido['nombre_destinatario'],
                        $datosPedido['prioridad'],
                        '',
                        '',
                        $items,
                        $datosDireccion['provincia'] . ' - ' . $datosDireccion['ciudad'] . ' - ' . $datosDireccion['direccion'] . ' - ' .
                         $datosDireccion['codigo_postal'] . ' - ' . $datosDireccion['telefono']
                    );
        
                    ob_end_clean();
                    $pdf->Output('I', 'documento.pdf');
                    exit;
                } catch (Exception $e) {
                    echo "Error al generar el PDF: " . $e->getMessage();
                }
            } else {
                echo "No se pudieron obtener los datos del pedido.";
            }
        } else {
            echo "ID del pedido no especificado.";
        }

        //IMPRIMIR ENVIADOS

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnImprimirEnviado'])) {
            $pedido = new pedido();
            $pedidoDetalle = new pedidoDetalle();
            $idPedido = $_POST['idImprimir'];
            $datosPedido = $pedido->obtenerDatosPdf($idPedido);
            $items = $pedidoDetalle->obtenerDetallePdf($idPedido);
            $datosDireccion = $pedidoDetalle->obtenerDatosDestinoPdf($idPedido);
            $cantBultos = pedido::obtenerCantidadDeBultos($idPedido);
            $transporte = $pedidoDetalle->obtenerTransporte($idPedido);
            if ($datosPedido) {
                try {
                    $pdf = new PDF();
                    $pdf->AddPage();
                    $pdf->AliasNbPages();
                    $pdf->LlenarDatos(
                        $datosPedido['fecha'],
                        $datosPedido['usuario'],
                        $datosPedido['nombre_destinatario'],
                        $datosPedido['prioridad'],
                        $cantBultos,
                        $transporte,
                        $items,
                        $datosDireccion['provincia'] . ' - ' . $datosDireccion['ciudad'] . ' - ' . $datosDireccion['direccion'] . ' - ' .
                         $datosDireccion['codigo_postal'] . ' - ' . $datosDireccion['telefono']
                    );
        
                    ob_end_clean();
                    $pdf->Output('I', 'documento.pdf');
                    exit;
                } catch (Exception $e) {
                    echo "Error al generar el PDF: " . $e->getMessage();
                }
            } else {
                echo "No se pudieron obtener los datos del pedido.";
            }
        } else {
            echo "ID del pedido no especificado.";
        }
    }


        //IMPRIMIR CARATULA

        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnEtiquetas'])) {
            $idPedido = $_POST['idPedidoCaratula'];
            
            header("Location: pdfs.php?idPedido=" . urlencode($idPedido));
            exit;
        }
        
    
    ?>
    <header class="cabecera">
        <div id="cab-usuario">
            <span><?php echo $_SESSION["usuario"]?></span>
        </div>
    </header>
    <div class="contenedor">
        <button class="tablink btn1" onclick="openPage('Bandeja', this, '#FDC5BA')"id="defaultOpen">Bandeja de entrada</button>
        <button class="tablink" onclick="openPage('Proceso', this, '#FAF797')">En Proceso</button>
        <button class="tablink" onclick="openPage('Enviado', this, '#BCFA97')">Enviado</button>
<!-- --------------Primera pestaña---------------- -->
        <div id="Bandeja" class="tabcontent"> 
            <section class="cab-pedidos">
                <div class="col1"><span>Código</span></div>
                <div class="col2"><span>Fecha</span></div>
                <div class="col3"><span>Prioridad</span></div>
                <div class="col4"><span>Usuario</span></div>
                <div class="col5"><span>Destinatario</span></div>
            </section>
            <?php 
                foreach($listPedidos as $pedido) {
                    $detalles = pedidoDetalle::obtenerDetalle($pedido['codigo']);
            ?>
                <section class="det-pedidos accordion">
                    <div class="col1"><span id="cod"><?php echo $pedido['codigo']; ?></span></div>
                    <div class="col2"><span id="fecha"><?php echo $pedido['fecha']; ?></span></div>
                    <div class="col3"><span id="prioridad"><?php echo $pedido['prioridad']; ?></span></div>
                    <div class="col4"><span id="usuario"><?php echo $pedido['usuario']; ?></span></div>
                    <div class="col5"><span id="destinatario"><?php echo $pedido['nombre_destinatario']; ?></span></div>
                </section>
        
                <div class="panel">
                    <section class="datos-pedido">
                        <div class="cab-articulos-det">
                            <div class="arrow"></div>
                            <div id="nombre"><p>Artículo</p></div>
                            <div id="desc"><p>Descripción</p></div>
                            <div id="cant"><p>Cantidad</p></div>
                        </div>

                        <?php foreach($detalles as $detalle) { ?>
                        <div class="articulos-det">
                            <div id="nom-articulo"><p><?php echo $detalle->getNom_articulo(); ?></p></div>
                            <div id="desc-articulo"><p><?php echo $detalle->getDescripcion_articulo(); ?></p></div>
                            <div id="cant-articulo"><p><?php echo $detalle->getCantidad(); ?></p></div>
                        </div>
                        <?php } ?>
                        <div class="btn-pedidos">
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" target="_blank">
                                    <input type="hidden" name="idPedidoImprimir" value="<?php echo $pedido['codigo']; ?>">
                                    <button type="submit" name ="btnImprimir" class="btn" >Imprimir</button>
                                </form>
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <input type="hidden" name="idPedido" value="<?php echo $pedido['codigo']; ?>">
                                <button type="submit" name="btnCambioEstadoEnProceso" value="procesar" class="btn">Procesar</button>
                                </form>
                            </div>
                    </section>
                </div>
            <?php } ?>
            <div class="pagination">
                <a href="pedidos.php">&laquo;</a>
                <?php 
                    for($i=1; $i <= $cantidadPaginas; $i++) {
                ?>
                    <a <?php 
                            echo ($i == $pagina) ? "class='active'" : ""; ?> 
                        href="pedidos.php?pag=<?php echo $i ?>"><?php echo $i ?></a>
                <?php   
                    }
                ?>
                <a href="pedidos.php?pag=<?php echo $cantidadPaginas ?>">&raquo;</a>
            </div>
        </div>
    
<!-- --------------Segunda pestaña---------------- -->

        <div id="Proceso" class="tabcontent">
            <section class="cab-pedidos">
                <div class="col1"><span>Código</span></div>
                <div class="col2"><span>Fecha</span></div>
                <div class="col3"><span>Prioridad</span></div>
                <div class="col4"><span>Usuario</span></div>
                <div class="col5"><span>Destinatario</span></div>
                <div class="col6"><span>Destino</span></div>
            </section>
            <?php foreach($listPedidoEnProceso as $pedido) {
                $detalles = pedidoDetalle::obtenerDetalle($pedido['codigo']);
                $ciudad = pedidoDetalle::obtenerCiudad($pedido['codigo']);
              
            ?>
            <section class="det-pedidos accordion">
                <div class="col1"><span id="cod"><?php echo $pedido['codigo']; ?></span></div>
                <div class="col2"><span id="fecha"><?php echo $pedido['fecha']; ?></span></div>
                <div class="col3"><span id="prioridad"><?php echo $pedido['prioridad']; ?></span></div>
                <div class="col4"><span id="usuario"><?php echo $pedido['usuario']; ?></span></div>
                <div class="col5"><span id="destinatario"><?php echo $pedido['nombre_destinatario']; ?></span></div>
                <div class="col6"><span id="cp"><?php echo $pedido['codigo_postal']; ?></span><span> - </span><span id="localidad"><?php echo $pedido['direccion']; ?></span></div>
            </section>
            <div class="panel">
                <section class="datos-pedido">
                    <div class="det_pedido">
                        <p>Detalles del pedido</p>
                    </div>
                    <div class="accordion2 cab-articulos-det">
                        <div class="arrow"><img src="../../assets/arrow_drop_down.svg" alt=""></div>
                        <div id="nombre"><p>Artículo</p></div>
                        <div id="desc"><p>Descripción</p></div>
                        <div id="cant"><p>Cantidad</p></div> 
                    </div> 
                    <div class="panel2">
                    <?php foreach($detalles as $detalle) { ?>
                        <div class="articulos-det ">
                            <div id="nom-articulo"><p><?php echo $detalle->getNom_articulo(); ?></p></div>
                            <div id="desc-articulo"><p><?php echo $detalle->getDescripcion_articulo(); ?></p></div>
                            <div id="cant-articulo"><p><?php echo $detalle->getCantidad(); ?></p></div>
                        </div>
                    <?php } ?>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="datos-embalaje">
                            <fieldset>
                                <legend>Embalaje:</legend>
                                <label for="cant-b">Cantidad bultos: </label>
                                <input type="number" id="cant-b" class="input" name="cant-b" min=1 value=1>
                                <button class="btn" type="button" onclick="generar()">Generar tabla</button>       
                                <table id="dataTable">
                                    <thead>    
                                        <tr>
                                            <th class="col-t-1">Tipo Embalaje</th>
                                            <th class="col-t-2">Especial</th>
                                            <th class="col-t-3">Peso</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </fieldset>
                            <fieldset>
                                <legend>Envío:</legend>
                                <span class="detalle-e">Localidad destino: </span><span class="detalle-e"><?php echo $ciudad ?></span><br><br>
                                <label for="transp">Transporte:</label>
                                <select class="input" id="transp" name="transp">
                                    <option value="0">Asignar transporte</option>
                                    <option value="1">Credifin</option>
                                    <option value="2">Oca</option>
                                    <option value="3">Pairone</option>
                                    <option value="4">Andreani</option>
                                    <option value="5">Iribas</option>
                                </select>
                            </fieldset>
                            <div class="btn-pedidos">
                                <input type="hidden" name="idPedido" value="<?php echo $pedido['codigo'];?>">
                                <button type="submit" name="btnCambioEstadoEnviado" value="procesar" class="btn">Procesar</button>
                            </div>
                        </div>
                    </form>

                </section>
            </div>
            <?php } ?>
        </div>
<!-- --------------Tercer pestaña---------------- -->
        <div id="Enviado" class="tabcontent">
        <section class="cab-pedidos">
                <div class="col3_1"><span>Código</span></div>
                <div class="col3_2"><span>Fecha</span></div>
                <div class="col3_3"><span>Prioridad</span></div>
                <div class="col3_4"><span>Usuario</span></div>   
                <div class="col3_5"><span>Destinatario</span></div>
                <div class="col3_6"><span>Fecha envío</span></div>
                <div class="col3_7"><span>Bultos</span></div>
                <div class="col3_8"></div>

        </section>
        <?php foreach($listPedidosEnviados as $pedido){
        $cantBultos = pedido::obtenerCantidadDeBultos($pedido['codigo']);
        
        ?>
        <section class="det-pedidos envios">
                <div class="col3_1"><span id="cod"><?php echo $pedido['codigo']?></span></div>
                <div class="col3_2"><span id="fecha"><?php echo date('d-m-Y', strtotime($pedido['fecha'])); ?></span></div> 
                <div class="col3_3"><span id="prioridad"><?php echo $pedido['prioridad']?></span></div>
                <div class="col3_4"><span id="usuario"><?php echo $pedido['usuario']?></span></div>  
                <div class="col3_5"><span id="destinatario"><?php echo $pedido['nombre_destinatario']?></span></div> 
                <div class="col3_6"><span id="fecha"></span><?php echo $pedido['fecha_despacho'];?></div>
                <div class="col3_7"><span id="bultos"><?php echo $cantBultos?></span></div>
                <div class="col3_8">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" target="_blank">
                        <input type="hidden" name="idImprimir" value="<?php echo $pedido['codigo']; ?>">
                        <button type="submit" name ="btnImprimirEnviado" class="btn"><i class="fi fi-rr-file-pdf"></i></button>
                        <input type="hidden" name="idPedidoCaratula" value="<?php echo $pedido['codigo']; ?>">
                        <button type="submit" name = "btnEtiquetas" class="btn" ><i class="fi fi-rr-tags"></i></button>
                    </form>  
                </div>
            </section>    
        <?php } ?>   
    </div>
</body>
<script src='../../js/admin/pedidos.js'></script>
    <!--<script>
        function abrirPdf(idPedido) {
            var url = '../../fpdf186/generarPdf.php?idPedido=' + idPedido;
            window.open(url, '_blank');
        }
    </script>-->
</html>

                                
