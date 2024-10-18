<?php

require_once(__DIR__ . '/fpdf.php');



class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {   
        $this->Image(__DIR__ . '/iconPcompostela.jpg', 170, 1, 30);
        $this->SetFont('Arial', '', 19);
        $this->Cell(45); // Movernos a la derecha
        $this->SetTextColor(0, 0, 0); // color
        $this->Cell(110, 15, ('Puerto Compostela'), 1, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
        $this->Ln(3); // Salto de línea
        $this->SetTextColor(103); // color
    }

    
    public function LlenarDatos($fecha, $cliente, $destinatario, $prioridad, $embalaje, $transporte, $items, $datosDestino)
    {
        
        $this->SetFont('Arial', '', 10);

        // Fila 1
        $this->SetX(20);
        $this->Cell(110, 10, ("Fecha: ") . $fecha, 0, 0, 'L', 0);
        $this->Cell(50, 10, ("Prioridad: ") . $prioridad, 0, 1, 'L', 0);

        // Fila 2
        $this->SetX(20);
        $this->Cell(110, 10, ("Cliente: ") . $cliente, 0, 0, 'L', 0);
        $this->Cell(50, 10, ("Bultos: ") . $embalaje, 0, 1, 'L', 0);

        // Fila 3
        $this->SetX(20);
        $this->Cell(110, 10, ("Destinatario: ") . $destinatario, 0, 0, 'L', 0);
        $this->Cell(50, 10, ("Transporte: ") . $transporte, 0, 1, 'L', 0);

        $this->Ln(10); // Salto de línea

        // Título de la tabla
        $this->SetTextColor(228, 100, 0);
        $this->Cell(50); // mover a la derecha
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(100, 10, ("Articulos"), 0, 1, 'C', 0);
        $this->Ln(7);

        // Campos de la tabla
        $this->SetFillColor(228, 100, 0); // colorFondo
        $this->SetTextColor(10, 10, 10); // colorTexto
        $this->SetDrawColor(163, 163, 163); // colorBorde
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(30, 10, ('Codigo'), 1, 0, 'C', 1);
        $this->Cell(100, 10, ('Descripcion'), 1, 0, 'C', 1);
        $this->Cell(30, 10, ('Cantidad'), 1, 0, 'C', 1);
        $this->Cell(30, 10, ('Check'), 1, 1, 'C', 1);

        // Llenar tabla
        $this->SetFont('Arial', '', 12);
        $this->SetDrawColor(163, 163, 163); // colorBorde
        foreach ($items as $item) {
            $this->Cell(30, 10, ($item['codigo']), 1, 0, 'C', 0);
            $this->Cell(100, 10, ($item['nombre_articulo']), 1, 0, 'C', 0);
            $this->Cell(30, 10, ($item['cantidad']), 1, 0, 'C', 0);
            $this->Cell(30, 10, (""), 1, 1, 'C', 0);
        }

        $this->Ln(10); // Salto de línea
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 10, ("Destino: ") . $datosDestino, 0, 1, 'L', 0);
    }
}

class CaratulaPDF extends FPDF {
    // Método para generar carátulas
    public function generarCaratulasPDF($destinatario, $telefono, $direccion, $cp, $localidad, $visita, $origen, $pedido, $cantidadCaratulas) {
        // Establecer los márgenes
        $this->SetLeftMargin(10);
        $this->SetTopMargin(10);

        // Definir el ancho y alto de la página A4
        $pageWidth = 210 - 20; // Ancho de la página A4 menos márgenes (izquierdo + derecho)
        $pageHeight = 297 - 20; // Alto de la página A4 menos márgenes (superior + inferior)

        // Ajustar el ancho y alto de cada carátula para que quepan 2 por hoja
        $caratulaWidth = $pageWidth; // Ancho total de la página A4
        $caratulaHeight = $pageHeight / 2; // Altura de cada carátula (2 por hoja)

        // Imagen a agregar (asegúrate de tener una imagen en esa ruta)
        $imagePath = __DIR__ . '/logoSSalud.jpg'; // Cambia 'path/to/image.jpg' por la ruta de tu imagen

        // Ajustar la fuente
        $this->SetFont('Arial', '', 15);

        // Generar las carátulas
        for ($i = 0; $i < $cantidadCaratulas; $i++) {
            if ($i % 2 === 0) {
                // Nueva página para cada par de carátulas
                $this->AddPage();
            }

            $x = 10; // Alineación horizontal (márgenes)
            $y = 10 + ($caratulaHeight * ($i % 2)); // Posición vertical de cada carátula

            // Dibuja el rectángulo para cada carátula
            $this->Rect($x, $y, $caratulaWidth, $caratulaHeight);

            // Insertar imagen (ajusta el tamaño y posición)
            $this->Image($imagePath, $x + 60, $y - 10, 80); // x, y, ancho de la imagen

            // Texto dentro de la carátula
            $this->SetXY($x + 160, $y + 5);
            $this->Cell(0, 10, ($i + 1) . '/' . $cantidadCaratulas, 0, 1, 'L');
            $this->SetXY($x + 20, $y + 30);
            $this->Cell(0, 10, 'Destinatario: ' . $destinatario, 0, 1, 'L');
            $this->SetXY($x + 20, $y + 40);
            $this->Cell(0, 10, 'Cel: ' . $telefono, 0, 1, 'L');
            $this->SetXY($x + 20, $y + 50);
            $this->Cell(0, 10, 'CP ' . $cp . ' - ' . $direccion, 0, 1, 'L');
            $this->SetXY($x + 20, $y + 60);
            $this->Cell(0, 10, $localidad, 0, 1, 'L');
            $this->SetXY($x + 20, $y + 70);
            $this->Cell(0, 10, 'Visita desde: ' . $visita, 0, 1, 'L');
            $this->SetXY($x + 20, $y + 80);
            $this->Cell(0, 10, 'Se envia desde: ' . $origen, 0, 1, 'L');
            $this->SetXY($x + 20, $y + 90);
            $this->Cell(0, 10, '(Puerto Compostela) - Sunchales - STA. FE', 0, 1, 'L');
            $this->SetXY($x + 145, $y + 110);
            $this->Cell(0, 10, 'Pedido: ' . $pedido, 0, 1, 'L');
        }
        
    }
}
?>

