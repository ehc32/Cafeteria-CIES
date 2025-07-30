<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ventas_register_controller extends Core_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Ventas_Register_Model');
        $this->load->model('Settings_Model');
        $this->load->model('Ventas_model');
        $this->load->model('Users_model');
        $this->load->helper('custom_helper');
        
        // Cargar autoload de Composer si existe
        $composer_autoload = APPPATH . '../vendor/autoload.php';
        if (file_exists($composer_autoload)) {
            require_once $composer_autoload;
        }
    }

    public function detalle_venta($id)
    {
        $data['title'] = "Detalle de venta";
        $data['application_name'] = $this->settings->application_name;
        $data['description'] = $this->settings->site_description;
        $data['keywords'] = $this->settings->keywords;
        $data['detalle_venta'] = $this->Ventas_Register_Model->get_by_id($id);
        $this->load->view('admin/detalle_venta', $data);
    }

    public function get_current_user_username()
    {
        $user_id = $this->session->userdata('user_id');
        $this->load->model('Users_model');
        $user = $this->Users_model->get_user_by_id($user_id);
        return $user->username;
    }

    public function registerVenta()
    {
        $vendedor_username = $this->Users_model->get_user_username();
        $productosJson = $this->input->post('productos_vendidos');
        $productosVendidos = array();

        if ($productosJson && is_string($productosJson)) {
            $productos = json_decode($productosJson, true); 

            if (is_array($productos) && !empty($productos)) {
                foreach ($productos as $producto) {

                    if (isset($producto['producto_vendido']) && isset($producto['valor_unitario']) && isset($producto['cantidad'])) {
                        $valorUnitario = (float)$producto['valor_unitario'];
                        $cantidad = (int)$producto['cantidad'];

                        $subtotal = $valorUnitario * $cantidad;

                        $productosVendidos[] = array(
                            'producto' => $producto['producto_vendido'],
                            'valor_unitario' => $valorUnitario,
                            'cantidad' => $cantidad,
                            'subtotal' => $subtotal
                        );
                    }
                }
            }
        }

        $descuento = (float)$this->input->post('descuento');
        $valorTotal = (float)$this->input->post('valor_total');
        $valorTotal = max($valorTotal, 0); 
        $nombreCliente = $this->input->post('nombre_cliente');
        $identificacionCliente = $this->input->post('identificacion_cliente');
        $correoCliente = $this->input->post('correo_cliente');
        $num_referencia = $this->input->post('num_referencia');

        // Preparar los datos para guardar
        $data = array(
            'productos_vendidos' => json_encode($productosVendidos), 
            'descuento' => $descuento,
            'valor_total' => $valorTotal,
            'nombre_cliente' => $nombreCliente,
            'identificacion_cliente' => $identificacionCliente,
            'correo_cliente' => $correoCliente,
            'vendedor_username' =>  $vendedor_username,
            'num_referencia' => $num_referencia,
            'created' => date('Y-m-d H:i:s')
        );

        // Guardar la venta y mostrar el mensaje correspondiente
        if ($this->Ventas_Register_Model->save($data)) {
            $this->session->set_flashdata('success', "¡Venta registrada exitosamente!");
            redirect($_SERVER['HTTP_REFERER']); // Recarga la página anterior
        } else {
            $this->session->set_flashdata('error', "¡Error al registrar la venta!");
            redirect($_SERVER['HTTP_REFERER']); // Recarga la página anterior
        }
    }



    public function change_venta_post()
    {
        if (!is_admin()) {
            redirect(base_url());
        }

        $data = array(
            'producto_vendido' => $this->input->post('producto_vendido'),
            'categoria' => $this->input->post('categoria'),
            'valor_unitario' => $this->input->post('valor_unitario'),
            'descuento' => $this->input->post('descuento'),
            'cantidad' => $this->input->post('cantidad'),
            'valor_total' => $this->input->post('valor_total'),
            'num_referencia' => $this->input->post('num_referencia')
        );

        $id = $this->input->post('venta_id', true);

        $venta = $this->Ventas_Register_Model->get_venta($id);

        if (empty($venta)) {
            redirect($this->agent->referrer());
        } else {

            if ($this->Ventas_Register_Model->actualizar_venta($id, $data)) {
                $this->session->set_flashdata('success', "Venta actualizada correctamente!");
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('error', "¡Error, ocurrió un problema!");
                redirect($this->agent->referrer());
            }
        }
    }


    public function delete($id)
    {

        if ($id) {
            $result = $this->Ventas_Register_Model->delete($id);

            // Enviar una respuesta JSON según el resultado de la eliminación
            if ($result) {
                echo json_encode(['status' => true, 'message' => 'Venta eliminado correctamente.']);
            } else {
                echo json_encode(['status' => false, 'message' => 'No se pudo eliminar la venta.']);
            }
        } else {
            echo json_encode(['status' => false, 'message' => 'ID no proporcionado.']);
        }
    }

    public function listar_ventas_filtradas()
    {
        $fechaInicio = $this->input->post('fechaInicio');
        $fechaFinal = $this->input->post('fechaFinal');

        redirect('/admin/ventas?fecha_inicio=' . $fechaInicio . '&fecha_final=' . $fechaFinal);
    }

    public function listar_ventas()
    {
        $fechaInicio = $this->input->get('fecha_inicio');
        $fechaFinal = $this->input->get('fecha_final');

        // OPTIMIZACIÓN PARA DATATABLE - Cargar datos optimizados
        if ($fechaInicio && $fechaFinal) {
            $data['ventas'] = $this->Ventas_Register_Model->obtener_ventas_filtradas($fechaInicio, $fechaFinal);
        } else {
            $data['ventas'] = $this->Ventas_Register_Model->obtener_ventas();
        }

        // No generar paginador - usar solo el del DataTable
        $data['pagination_links'] = '';
        
        // Pasar las fechas de filtro a la vista para mantener el estado
        $data['fecha_inicio'] = $fechaInicio;
        $data['fecha_final'] = $fechaFinal;

        $this->cargar_vistas($data);
    }

    // Método para DataTable Server-Side Processing
    public function get_ventas_ajax()
    {
        // Verificar si es una petición AJAX
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        // Parámetros del DataTable
        $draw = $this->input->post('draw');
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $search = $this->input->post('search')['value'];
        $order_column = $this->input->post('order')[0]['column'];
        $order_dir = $this->input->post('order')[0]['dir'];

        // Filtros de fecha
        $fechaInicio = $this->input->post('fecha_inicio');
        $fechaFinal = $this->input->post('fecha_final');

        // Obtener datos paginados
        $result = $this->Ventas_Register_Model->get_ventas_datatable($start, $length, $search, $order_column, $order_dir, $fechaInicio, $fechaFinal);

        // Preparar respuesta para DataTable
        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $result['total'],
            "recordsFiltered" => $result['filtered'],
            "data" => $result['data']
        );

        echo json_encode($response);
    }

    // Nuevo método para cargar datos via AJAX
    public function cargar_ventas_ajax()
    {
        // Verificar si es una petición AJAX
        if (!$this->input->is_ajax_request()) {
            log_message('error', 'Carga AJAX: No es una petición AJAX');
            show_404();
        }

        $page = $this->input->get('page') ? (int)$this->input->get('page') : 1;
        $fechaInicio = $this->input->get('fecha_inicio');
        $fechaFinal = $this->input->get('fecha_final');
        $per_page = 10;
        
        // Calcular el offset correctamente (página 1 = offset 0)
        $offset = ($page - 1) * $per_page;

        log_message('debug', 'Carga AJAX: Página=' . $page . ', Offset=' . $offset . ', Filtros: ' . $fechaInicio . ' - ' . $fechaFinal);

        // Cargar datos según los filtros
        if ($fechaInicio && $fechaFinal) {
            $ventas = $this->Ventas_Register_Model->obtener_ventas_filtradas_paginadas($fechaInicio, $fechaFinal, $per_page, $offset);
        } else {
            $ventas = $this->Ventas_Register_Model->obtener_ventas_paginadas($per_page, $offset);
        }

        log_message('debug', 'Carga AJAX: Registros encontrados: ' . count($ventas));

        // Preparar respuesta HTML
        $html = '';
        if (!empty($ventas)) {
            foreach ($ventas as $venta) {
                $productos_vendidos = json_decode($venta->productos_vendidos, true);
                if (!empty($productos_vendidos)) {
                    foreach ($productos_vendidos as $producto) {
                        $html .= '<tr>';
                        $html .= '<td>' . htmlspecialchars($producto['producto']) . '</td>';
                        $html .= '<td>$' . htmlspecialchars($producto['valor_unitario']) . '</td>';
                        $html .= '<td>' . htmlspecialchars($producto['cantidad']) . '</td>';
                        $html .= '<td>$' . htmlspecialchars($producto['subtotal']) . '</td>';
                        $html .= '<td>$' . number_format($venta->descuento, 0) . '</td>';
                        $html .= '<td>' . htmlspecialchars($venta->created) . '</td>';
                        $html .= '<td>' . htmlspecialchars($venta->vendedor_username) . '</td>';
                        $html .= '<td>' . (empty($venta->num_referencia) ? 'Efectivo' : htmlspecialchars($venta->num_referencia)) . '</td>';
                        $html .= '<td><a class="btn btn-icon btn-lg btn-white btn-dim btn-outline-primary" href="' . base_url() . 'admin/ventas-detalles/' . $venta->id . '" target="_blank"><em class="icon ni ni-printer-fill"></em></a></td>';
                        $html .= '</tr>';
                    }
                }
            }
        } else {
            $html = '<tr><td colspan="9" class="text-center">No se encontraron registros</td></tr>';
        }

        $response = ['status' => 'success', 'html' => $html, 'page' => $page, 'offset' => $offset];
        log_message('debug', 'Carga AJAX: Respuesta enviada: ' . json_encode($response));
        
        echo json_encode($response);
    }

    public function imprimir_factura($id)
    {
        $data['title'] = "Detalle de venta";
        $data['application_name'] = $this->settings->application_name;
        $data['description'] = $this->settings->site_description;
        $data['keywords'] = $this->settings->keywords;
        $data['detalle_venta'] = $this->Ventas_Register_Model->get_by_id($id);
        $this->load->view('admin/imprimir_factura', $data);
    }

    // ===================================
    // MÉTODOS DE EXPORTACIÓN COMPLETA
    // ===================================

    /**
     * Exporta todas las ventas filtradas a XLSX (Excel real)
     */
    public function export_xlsx()
    {
        try {
            // Obtener filtros de fecha
            $fechaInicio = $this->input->get('fecha_inicio');
            $fechaFinal = $this->input->get('fecha_final');
            
            // Obtener todos los datos filtrados (sin paginación)
            if ($fechaInicio && $fechaFinal) {
                $ventas = $this->Ventas_Register_Model->obtener_ventas_filtradas_exportacion($fechaInicio, $fechaFinal);
            } else {
                $ventas = $this->Ventas_Register_Model->obtener_ventas();
            }

            // Preparar datos para XLSX
            $excel_data = array();
            $excel_data[] = array(
                'Producto Vendido',
                'Valor Unitario',
                'Cantidad', 
                'Valor Total',
                'Descuento',
                'Fecha de Venta',
                'Vendedor',
                'Número de Referencia'
            );

            foreach ($ventas as $venta) {
                $productos_vendidos = json_decode($venta->productos_vendidos, true);
                if (!empty($productos_vendidos)) {
                    foreach ($productos_vendidos as $producto) {
                        $excel_data[] = array(
                            $producto['producto'],
                            '$' . $producto['valor_unitario'],
                            $producto['cantidad'],
                            '$' . $producto['subtotal'],
                            '$' . number_format($venta->descuento, 0),
                            $venta->created,
                            $venta->vendedor_username,
                            empty($venta->num_referencia) ? 'Efectivo' : $venta->num_referencia
                        );
                    }
                }
            }

            // Verificar si PhpSpreadsheet está disponible
            if (class_exists('PhpOffice\PhpSpreadsheet\Spreadsheet')) {
                // Configurar headers para XLSX
                $filename = 'ventas_' . date('Y-m-d_H-i-s');
                if ($fechaInicio && $fechaFinal) {
                    $filename .= '_' . $fechaInicio . '_a_' . $fechaFinal;
                }
                $filename .= '.xlsx';

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="' . $filename . '"');
                header('Cache-Control: max-age=0');

                $this->create_xlsx_file($excel_data, $filename);
            } else {
                // Fallback: generar CSV con extensión .csv
                $filename = 'ventas_' . date('Y-m-d_H-i-s');
                if ($fechaInicio && $fechaFinal) {
                    $filename .= '_' . $fechaInicio . '_a_' . $fechaFinal;
                }
                $filename .= '.csv';

                header('Content-Type: text/csv; charset=utf-8');
                header('Content-Disposition: attachment; filename="' . $filename . '"');
                header('Cache-Control: max-age=0');

                $this->create_csv_file($excel_data, $filename);
            }
        } catch (Exception $e) {
            // Log del error
            log_message('error', 'Error en export_xlsx: ' . $e->getMessage());
            
            // Redirigir con mensaje de error
            $this->session->set_flashdata('error', 'Error al generar el archivo XLSX. Intente con CSV o PDF.');
            redirect('admin/ventas');
        }
    }

    /**
     * Exporta todas las ventas filtradas a CSV
     */
    public function export_csv()
    {
        // Obtener filtros de fecha
        $fechaInicio = $this->input->get('fecha_inicio');
        $fechaFinal = $this->input->get('fecha_final');
        
        // Obtener todos los datos filtrados (sin paginación)
        if ($fechaInicio && $fechaFinal) {
            $ventas = $this->Ventas_Register_Model->obtener_ventas_filtradas_exportacion($fechaInicio, $fechaFinal);
        } else {
            $ventas = $this->Ventas_Register_Model->obtener_ventas();
        }

        // Configurar headers para descarga
        $filename = 'ventas_' . date('Y-m-d_H-i-s');
        if ($fechaInicio && $fechaFinal) {
            $filename .= '_' . $fechaInicio . '_a_' . $fechaFinal;
        }
        $filename .= '.csv';

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        // Crear archivo CSV
        $output = fopen('php://output', 'w');
        
        // BOM para UTF-8
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // Encabezados
        fputcsv($output, array(
            'Producto Vendido',
            'Valor Unitario', 
            'Cantidad',
            'Valor Total',
            'Descuento',
            'Fecha de Venta',
            'Vendedor',
            'Número de Referencia'
        ));

        // Datos
        foreach ($ventas as $venta) {
            $productos_vendidos = json_decode($venta->productos_vendidos, true);
            if (!empty($productos_vendidos)) {
                foreach ($productos_vendidos as $producto) {
                    fputcsv($output, array(
                        $producto['producto'],
                        '$' . $producto['valor_unitario'],
                        $producto['cantidad'],
                        '$' . $producto['subtotal'],
                        '$' . number_format($venta->descuento, 0),
                        $venta->created,
                        $venta->vendedor_username,
                        empty($venta->num_referencia) ? 'Efectivo' : $venta->num_referencia
                    ));
                }
            }
        }

        fclose($output);
        exit;
    }

    /**
     * Exporta todas las ventas filtradas a PDF
     */
    public function export_pdf()
    {
        // Cargar la librería PDF
        $this->load->library('Pdf');
        
        // Obtener filtros de fecha
        $fechaInicio = $this->input->get('fecha_inicio');
        $fechaFinal = $this->input->get('fecha_final');
        
        // Obtener todos los datos filtrados (sin paginación)
        if ($fechaInicio && $fechaFinal) {
            $ventas = $this->Ventas_Register_Model->obtener_ventas_filtradas_exportacion($fechaInicio, $fechaFinal);
        } else {
            $ventas = $this->Ventas_Register_Model->obtener_ventas();
        }

        // Preparar datos para la librería PDF
        $data = array(
            'ventas' => $ventas,
            'fecha_inicio' => $fechaInicio,
            'fecha_final' => $fechaFinal,
            'title' => "Reporte de Ventas",
            'application_name' => $this->settings->application_name
        );

        // Configurar nombre del archivo
        $filename = 'ventas_' . date('Y-m-d_H-i-s');
        if ($fechaInicio && $fechaFinal) {
            $filename .= '_' . $fechaInicio . '_a_' . $fechaFinal;
        }
        $filename .= '.pdf';

        // Generar PDF usando la librería optimizada
        $this->pdf->generate_simple_pdf($data, $filename);
    }

    /**
     * Crea archivo XLSX usando PhpSpreadsheet
     */
    private function create_xlsx_file($data, $filename)
    {
        try {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Agregar datos
            foreach ($data as $row_index => $row_data) {
                foreach ($row_data as $col_index => $value) {
                    $sheet->setCellValueByColumnAndRow($col_index + 1, $row_index + 1, $value);
                }
            }

            // Autoajustar columnas
            foreach (range(1, count($data[0])) as $col) {
                $sheet->getColumnDimensionByColumn($col)->setAutoSize(true);
            }

            // Crear writer
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save('php://output');
            
        } catch (Exception $e) {
            // Si falla, generar CSV como fallback
            $this->create_csv_file($data, 'ventas_' . date('Y-m-d_H-i-s') . '.csv');
        }
    }

    /**
     * Crea archivo CSV válido
     */
    private function create_csv_file($data, $filename)
    {
        $output = fopen('php://output', 'w');
        
        // BOM para UTF-8
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        foreach ($data as $row) {
            fputcsv($output, $row);
        }
        
        fclose($output);
    }

    public function cargar_vistas($data)
    {
        $data['title'] = "Detalle de venta";
        $data['application_name'] = $this->settings->application_name;
        $data['description'] = $this->settings->site_description;
        $data['keywords'] = $this->settings->keywords;
        $this->load->view("admin/includes/_header", $data);
        $this->load->view("admin/includes/_sidebar", $data);
        $this->load->view('admin/ventas', $data);
    }
}