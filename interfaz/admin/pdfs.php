<?php

include '../../modelo/conexion.php';
include '../../helper/usuarioValidar.php';
include '../../modelo/pedido.php';
include '../../modelo/bultos.php'; 
require_once(__DIR__ . '../../../fpdf186/generarPdf.php');





if (isset($_GET['idPedido'])) {
    $pedido = new pedido();
    $idPedido = $_GET['idPedido'];
    $datosCaratula = $pedido->obtenerDatosCaratulas($idPedido);
    $cantBultos = pedido::obtenerCantidadDeBultos($idPedido);

    if ($datosCaratula) {
        try {
            $pdfCaratula = new CaratulaPDF();
            $pdfCaratula->AliasNbPages();
            $pdfCaratula->generarCaratulasPDF(
                $datosCaratula['destinatario'],
                $datosCaratula['telefono'],
                $datosCaratula['direccion'],
                $datosCaratula['codigo_postal'],
                $datosCaratula['ciudad'] . " - " . $datosCaratula['provincia'],
                $datosCaratula['horaD'] . " - " . $datosCaratula['horaH'],
                "Cortada Avellaneda 1886",
                $idPedido,
                $cantBultos
            );
            ob_end_clean();
            $pdfCaratula->Output('I', 'documento.pdf');
        } catch (Exception $e) {
            echo "Error al generar el PDF: " . $e->getMessage();
        }
    } else {
        echo "No se pudieron obtener los datos del pedido";
    }
} else {
    echo "ID del pedido no especificado";
}


?>