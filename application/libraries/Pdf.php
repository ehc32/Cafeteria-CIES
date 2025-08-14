<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Librería PDF simple para generar reportes básicos
 */
class Pdf
{
    private $CI;
    private $content = '';
    private $title = 'Reporte';
    private $author = 'SENACoffe';
    private $creator = 'SENACoffe';

    public function __construct()
    {
        $this->CI =& get_instance();
        
        // Cargar TCPDF si está disponible
        if (!class_exists('TCPDF')) {
            // Intentar cargar desde vendor si existe
            $tcpdf_path = APPPATH . '../vendor/tecnickcom/tcpdf/tcpdf.php';
            if (file_exists($tcpdf_path)) {
                require_once($tcpdf_path);
            }
        }
    }

    /**
     * Genera un PDF real usando TCPDF o fallback a HTML
     * @param array $data Datos para el reporte
     * @param string $filename Nombre del archivo
     */
    public function generate_simple_pdf($data, $filename = 'reporte.pdf')
    {
        // Intentar usar TCPDF si está disponible
        if (class_exists('TCPDF')) {
            $this->generate_tcpdf($data, $filename);
        } else {
            // Fallback: generar HTML que se puede imprimir
            $this->generate_html_printable($data, $filename);
        }
    }

    /**
     * Genera PDF real usando TCPDF
     */
    private function generate_tcpdf($data, $filename)
    {
        // Crear nueva instancia de TCPDF
        $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
        
        // Configurar información del documento
        $pdf->SetCreator('SENACoffe');
        $pdf->SetAuthor('SENACoffe');
        $pdf->SetTitle('Reporte de Ventas');
        
        // Configurar márgenes
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetHeaderMargin(5);
        $pdf->SetFooterMargin(10);
        
        // Configurar auto page break
        $pdf->SetAutoPageBreak(TRUE, 25);
        
        // Agregar página
        $pdf->AddPage();
        
        // Configurar fuente
        $pdf->SetFont('helvetica', '', 9);
        
        // Título
        $pdf->Cell(0, 10, 'REPORTE DE VENTAS - SENACoffe', 0, 1, 'C');
        $pdf->Ln(5);
        
        // Información del período
        if (isset($data['fecha_inicio']) && isset($data['fecha_final'])) {
            $pdf->Cell(0, 8, 'Período: ' . date('d/m/Y', strtotime($data['fecha_inicio'])) . ' - ' . date('d/m/Y', strtotime($data['fecha_final'])), 0, 1, 'L');
        }
        
        // Encabezados de tabla
        $headers = array('Producto', 'Precio', 'Cant.', 'Total', 'Desc.', 'Fecha', 'Vendedor', 'Ref.');
        $widths = array(50, 20, 15, 25, 20, 25, 30, 25);
        
        // Imprimir encabezados
        $pdf->SetFont('helvetica', 'B', 8);
        for ($i = 0; $i < count($headers); $i++) {
            $pdf->Cell($widths[$i], 7, $headers[$i], 1, 0, 'C');
        }
        $pdf->Ln();
        
        // Datos
        $pdf->SetFont('helvetica', '', 7);
        $total_ventas = 0;
        $total_descuentos = 0;
        $total_productos = 0;
        $row_count = 0;
        
        foreach ($data['ventas'] as $venta) {
            $productos_vendidos = json_decode($venta->productos_vendidos, true);
            if (!empty($productos_vendidos)) {
                foreach ($productos_vendidos as $producto) {
                    $total_ventas += $producto['subtotal'];
                    $total_descuentos += $venta->descuento;
                    $total_productos += $producto['cantidad'];
                    $row_count++;
                    
                    // Limitar filas para evitar sobrecarga
                    if ($row_count > 500) {
                        $pdf->Cell(0, 6, '... y ' . (count($data['ventas']) - 500) . ' registros más', 1, 1, 'C');
                        break 2;
                    }
                    
                    $pdf->Cell($widths[0], 6, substr($producto['producto'], 0, 30), 1, 0, 'L');
                    $pdf->Cell($widths[1], 6, '$' . number_format($producto['valor_unitario'], 0), 1, 0, 'R');
                    $pdf->Cell($widths[2], 6, $producto['cantidad'], 1, 0, 'C');
                    $pdf->Cell($widths[3], 6, '$' . number_format($producto['subtotal'], 0), 1, 0, 'R');
                    $pdf->Cell($widths[4], 6, '$' . number_format($venta->descuento, 0), 1, 0, 'R');
                    $pdf->Cell($widths[5], 6, date('d/m', strtotime($venta->created)), 1, 0, 'C');
                    $pdf->Cell($widths[6], 6, substr($venta->vendedor_username, 0, 15), 1, 0, 'L');
                    $pdf->Cell($widths[7], 6, empty($venta->num_referencia) ? 'Efectivo' : substr($venta->num_referencia, 0, 10), 1, 0, 'L');
                    $pdf->Ln();
                }
            }
        }
        
        // Totales
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->Cell(85, 7, 'TOTALES:', 1, 0, 'R');
        $pdf->Cell(25, 7, '$' . number_format($total_ventas, 0), 1, 0, 'R');
        $pdf->Cell(20, 7, '$' . number_format($total_descuentos, 0), 1, 0, 'R');
        $pdf->Cell(0, 7, '', 1, 1, 'L');
        
        // Resumen
        $pdf->Ln(5);
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 8, 'RESUMEN DEL REPORTE', 0, 1, 'L');
        $pdf->SetFont('helvetica', '', 9);
        $pdf->Cell(0, 6, 'Total productos vendidos: ' . $total_productos, 0, 1, 'L');
        $pdf->Cell(0, 6, 'Total ventas: $' . number_format($total_ventas, 0), 0, 1, 'L');
        $pdf->Cell(0, 6, 'Total descuentos: $' . number_format($total_descuentos, 0), 0, 1, 'L');
        $pdf->Cell(0, 6, 'Total neto: $' . number_format($total_ventas - $total_descuentos, 0), 0, 1, 'L');
        $pdf->Cell(0, 6, 'Transacciones: ' . count($data['ventas']), 0, 1, 'L');
        
        // Generar PDF
        $pdf->Output($filename, 'I');
        exit;
    }

    /**
     * Fallback: genera HTML imprimible
     */
    private function generate_html_printable($data, $filename)
    {
        // Crear contenido HTML optimizado
        $html = $this->create_html_content($data);
        
        // Configurar headers para visualización
        header('Content-Type: text/html; charset=UTF-8');
        header('Cache-Control: private, max-age=0, must-revalidate');
        header('Pragma: public');
        
        // Generar HTML con script de auto-impresión
        echo $html;
        exit;
    }

    /**
     * Crea contenido HTML para el PDF
     * @param array $data Datos del reporte
     * @return string HTML generado
     */
    private function create_html_content($data)
    {
        $html = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>' . $this->title . '</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 15px; font-size: 11px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 1px solid #333; padding-bottom: 8px; }
        .title { font-size: 20px; font-weight: bold; color: #333; margin: 0; }
        .subtitle { font-size: 12px; color: #666; margin: 3px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 10px; }
        th, td { border: 1px solid #ccc; padding: 4px 6px; text-align: left; }
        th { background-color: #f0f0f0; font-weight: bold; font-size: 10px; }
        .footer { margin-top: 20px; text-align: center; font-size: 10px; color: #666; }
        .info { margin-bottom: 15px; font-size: 11px; }
        .info p { margin: 3px 0; }
        .summary { margin-top: 15px; padding: 10px; background-color: #f8f9fa; border: 1px solid #dee2e6; }
        .summary h3 { margin: 0 0 8px 0; font-size: 14px; color: #333; }
        .summary p { margin: 3px 0; font-size: 11px; }
        .totals { background-color: #e3f2fd; font-weight: bold; }
        @media print { body { margin: 10px; } }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">REPORTE DE VENTAS</div>
        <div class="subtitle">SENACoffe</div>
    </div>';

        // Información del reporte
        if (isset($data['fecha_inicio']) && isset($data['fecha_final'])) {
            $html .= '<div class="info">
                <p><strong>Período:</strong> ' . date('d/m/Y', strtotime($data['fecha_inicio'])) . ' - ' . date('d/m/Y', strtotime($data['fecha_final'])) . '</p>
                <p><strong>Total de registros:</strong> ' . count($data['ventas']) . '</p>
                <p><strong>Fecha de generación:</strong> ' . date('d/m/Y H:i:s') . '</p>
            </div>';
        }

        // Tabla de datos optimizada
        $html .= '<table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cant.</th>
                    <th>Total</th>
                    <th>Desc.</th>
                    <th>Fecha</th>
                    <th>Vendedor</th>
                    <th>Ref.</th>
                </tr>
            </thead>
            <tbody>';

        $total_ventas = 0;
        $total_descuentos = 0;
        $total_productos = 0;
        $row_count = 0;

        foreach ($data['ventas'] as $venta) {
            $productos_vendidos = json_decode($venta->productos_vendidos, true);
            if (!empty($productos_vendidos)) {
                foreach ($productos_vendidos as $producto) {
                    $total_ventas += $producto['subtotal'];
                    $total_descuentos += $venta->descuento;
                    $total_productos += $producto['cantidad'];
                    $row_count++;
                    
                    // Limitar a 1000 filas para evitar sobrecarga
                    if ($row_count > 1000) {
                        $html .= '<tr><td colspan="8" style="text-align: center; color: #666;">... y ' . (count($data['ventas']) - 1000) . ' registros más</td></tr>';
                        break 2;
                    }
                    
                    $html .= '<tr>
                        <td>' . substr(htmlspecialchars($producto['producto']), 0, 30) . '</td>
                        <td>$' . number_format($producto['valor_unitario'], 0) . '</td>
                        <td>' . $producto['cantidad'] . '</td>
                        <td>$' . number_format($producto['subtotal'], 0) . '</td>
                        <td>$' . number_format($venta->descuento, 0) . '</td>
                        <td>' . date('d/m', strtotime($venta->created)) . '</td>
                        <td>' . substr(htmlspecialchars($venta->vendedor_username), 0, 15) . '</td>
                        <td>' . (empty($venta->num_referencia) ? 'Efectivo' : substr(htmlspecialchars($venta->num_referencia), 0, 10)) . '</td>
                    </tr>';
                }
            }
        }

        // Agregar fila de totales
        $html .= '<tr style="background-color: #e6f3ff; font-weight: bold;">
            <td colspan="3"><strong>TOTALES:</strong></td>
            <td><strong>$' . number_format($total_ventas, 0) . '</strong></td>
            <td><strong>$' . number_format($total_descuentos, 0) . '</strong></td>
            <td colspan="3"></td>
        </tr>';

        $html .= '</tbody>
        </table>';

        // Agregar resumen optimizado
        $html .= '<div class="summary">
            <h3>Resumen del Reporte</h3>
            <p><strong>Productos vendidos:</strong> ' . $total_productos . '</p>
            <p><strong>Total ventas:</strong> $' . number_format($total_ventas, 0) . '</p>
            <p><strong>Total descuentos:</strong> $' . number_format($total_descuentos, 0) . '</p>
            <p><strong>Total neto:</strong> $' . number_format($total_ventas - $total_descuentos, 0) . '</p>
            <p><strong>Transacciones:</strong> ' . count($data['ventas']) . '</p>
        </div>
        
        <div class="footer">
            <p>Reporte generado por SENACoffe - ' . date('d/m/Y H:i') . '</p>
        </div>
        
        <script>
            // Auto-print cuando se carga la página
            window.onload = function() {
                setTimeout(function() {
                    window.print();
                }, 500);
            };
        </script>
    </body>
</html>';

        return $html;
    }

    /**
     * Genera un PDF usando mPDF (si está disponible)
     * @param array $data Datos para el reporte
     * @param string $filename Nombre del archivo
     */
    public function generate_mpdf($data, $filename = 'reporte.pdf')
    {
        // Verificar si mPDF está disponible
        if (class_exists('mPDF')) {
            $mpdf = new mPDF();
            $html = $this->create_html_content($data);
            $mpdf->WriteHTML($html);
            $mpdf->Output($filename, 'D');
        } else {
            // Fallback a HTML
            $this->generate_simple_pdf($data, $filename);
        }
    }
} 