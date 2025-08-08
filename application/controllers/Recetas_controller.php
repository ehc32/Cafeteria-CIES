<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Recetas_controller extends Core_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_user()) {
            redirect(base_url());
        }
        $this->load->model('Recetas_model');
        $this->load->model('Inventario_model');
        $this->load->model('Inventario_comercio_model');
        $this->load->model('Users_model');
        // Para cargar catálogo (JSON) de ventas por categoría
        $this->load->model('Ventas_model');
    }

    // Vista principal de recetas
    public function index()
    {
        $data['title'] = "Gestión de Recetas";
        $data['application_name'] = $this->settings->application_name;
        $data['description'] = $this->settings->site_description;
        $data['keywords'] = $this->settings->keywords;

        // Obtener lista de recetas
        $data['recetas'] = $this->Recetas_model->get_all();
        $data['productos'] = $this->Recetas_model->get_productos_inventario();
        
        // Catálogo completo (categoría, producto_vendido, valor_unitario) desde ventas
        $data['catalogo_ventas'] = $this->Ventas_model->get_catalogo_completo();
        $data['usuario'] = $this->Users_model->is_admin();

        // Cargar la vista
        $this->load->view("admin/recetas", $data);
    }

    // Agregar nueva receta
    public function add()
    {
        // Validación de campos
        $this->form_validation->set_rules('nombre', 'Nombre', 'required');
        $this->form_validation->set_rules('numero_receta', 'Número de Receta', 'required');
        $this->form_validation->set_rules('numero_porciones', 'Número de Porciones', 'required|numeric');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($this->agent->referrer());
        } else {
            $result = $this->Recetas_model->add_receta();
            
            if ($result) {
                $this->session->set_flashdata('success', '¡Receta agregada exitosamente!');
            } else {
                $this->session->set_flashdata('error', '¡Error al agregar la receta!');
            }
            
            redirect('admin/recetas');
        }
    }

    // Actualizar receta
    public function update($id = null)
    {
        if (!$id) {
            $id = $this->input->post('receta_id');
        }

        // Validación de campos
        $this->form_validation->set_rules('nombre', 'Nombre', 'required');
        $this->form_validation->set_rules('numero_receta', 'Número de Receta', 'required');
        $this->form_validation->set_rules('numero_porciones', 'Número de Porciones', 'required|numeric');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($this->agent->referrer());
        } else {
            $result = $this->Recetas_model->update_receta($id);
            
            if ($result) {
                $this->session->set_flashdata('success', '¡Receta actualizada exitosamente!');
            } else {
                $this->session->set_flashdata('error', '¡Error al actualizar la receta!');
            }
            
            redirect('admin/recetas');
        }
    }

    // Eliminar receta
    public function delete()
    {
        $id = $this->input->post('id');
        
        if ($id) {
            $result = $this->Recetas_model->delete($id);
            
            if ($result) {
                echo json_encode(['status' => true, 'message' => 'Receta eliminada correctamente.']);
            } else {
                echo json_encode(['status' => false, 'message' => 'No se pudo eliminar la receta.']);
            }
        } else {
            echo json_encode(['status' => false, 'message' => 'ID no proporcionado.']);
        }
    }

    // Obtener receta por ID (AJAX)
    public function get_receta()
    {
        $id = $this->input->post('id');
        
        if ($id) {
            $receta = $this->Recetas_model->get_receta_completa($id);
            
            if ($receta) {
                echo json_encode(['status' => true, 'data' => $receta]);
            } else {
                echo json_encode(['status' => false, 'message' => 'Receta no encontrada.']);
            }
        } else {
            echo json_encode(['status' => false, 'message' => 'ID no proporcionado.']);
        }
    }

    // Obtener receta por nombre (AJAX) para ventas
    public function get_receta_por_nombre()
    {
        $nombre = $this->input->get('nombre');
        if (!$nombre) {
            echo json_encode(['status' => false, 'message' => 'Nombre no proporcionado.']);
            return;
        }
        $recetas = array();
        $ids_agregados = array();

        // Coincidencia exacta de nombre de receta
        $receta_directa = $this->Recetas_model->get_receta_completa_por_nombre($nombre);
        if ($receta_directa) {
            $recetas[] = $receta_directa;
            $ids_agregados[$receta_directa->id] = true;
        }

        // Recetas que usan el producto del inventario por su nombre
        $relacionadas = $this->Recetas_model->get_recetas_by_producto_nombre($nombre);
        if (!empty($relacionadas)) {
            foreach ($relacionadas as $r) {
                if (!isset($ids_agregados[$r->id])) {
                    $recetas[] = $this->Recetas_model->get_receta_completa($r->id);
                    $ids_agregados[$r->id] = true;
                }
            }
        }

        if (!empty($recetas)) {
            echo json_encode(['status' => true, 'data' => $recetas]);
        } else {
            echo json_encode(['status' => false, 'message' => 'No existe receta asociada al producto.']);
        }
    }

    // Ver detalles de receta
    public function view($id)
    {
        $data['title'] = "Detalle de Receta";
        $data['application_name'] = $this->settings->application_name;
        $data['description'] = $this->settings->site_description;
        $data['keywords'] = $this->settings->keywords;
        
        $data['receta'] = $this->Recetas_model->get_receta_completa($id);
        
        if (!$data['receta']) {
            $this->session->set_flashdata('error', 'Receta no encontrada.');
            redirect('admin/recetas');
        }
        
        $data['usuario'] = $this->Users_model->is_admin();
        
        $this->load->view("admin/receta_detalle", $data);
    }

    // Duplicar receta
    public function duplicar($id)
    {
        $result = $this->Recetas_model->duplicar_receta($id);
        
        if ($result) {
            $this->session->set_flashdata('success', '¡Receta duplicada exitosamente!');
        } else {
            $this->session->set_flashdata('error', '¡Error al duplicar la receta!');
        }
        
        redirect('admin/recetas');
    }

    // Buscar recetas
    public function search()
    {
        $term = $this->input->post('search_term');
        
        if ($term) {
            $recetas = $this->Recetas_model->search($term);
            echo json_encode(['status' => true, 'data' => $recetas]);
        } else {
            echo json_encode(['status' => false, 'message' => 'Término de búsqueda vacío.']);
        }
    }

    // Exportar receta a PDF
    public function export_pdf($id)
    {
        $receta = $this->Recetas_model->get_receta_completa($id);
        
        if (!$receta) {
            $this->session->set_flashdata('error', 'Receta no encontrada.');
            redirect('admin/recetas');
        }

        // Cargar librería PDF (debes tener instalada una como TCPDF o DOMPDF)
        // $this->load->library('pdf');
        
        // Por ahora solo mostramos los datos en una vista simple
        $data['receta'] = $receta;
        $data['title'] = "Receta: " . $receta->nombre;
        
        $this->load->view('admin/receta_pdf', $data);
    }

    // Recalcular costos de todas las recetas
    public function recalcular_costos()
    {
        $recetas = $this->Recetas_model->get_all();
        $contador = 0;
        
        foreach ($recetas as $receta) {
            $this->Recetas_model->recalcular_costos($receta->id);
            $contador++;
        }
        
        $this->session->set_flashdata('success', "Costos recalculados exitosamente para $contador recetas.");
        redirect('admin/recetas');
    }

    // Obtener productos para select2 (AJAX)
    public function get_productos()
    {
        $term = $this->input->get('term');
        $sede = $this->input->get('sede');
        
        // Si se especifica sede, obtener productos de esa sede
        if ($sede == 'CIES') {
            $productos = $this->Inventario_model->get_all();
        } elseif ($sede == 'Comercio') {
            $productos = $this->Inventario_comercio_model->get_all();
        } else {
            // Por defecto, obtener productos con stock disponible
            $productos = $this->Recetas_model->get_productos_inventario();
        }
        
        $results = array();
        foreach ($productos as $producto) {
            if (empty($term) || stripos($producto->nombre, $term) !== false) {
                $results[] = array(
                    'id' => $producto->id,
                    'text' => $producto->nombre . ' (' . $producto->presentacion . ')',
                    'valor_unitario' => $producto->valor_unitario ?? 0,
                    'presentacion' => $producto->presentacion,
                    'categoria' => $producto->categoria ?? ''
                );
            }
        }
        
        echo json_encode(['results' => $results]);
    }

    // Obtener estadísticas de recetas
    public function estadisticas()
    {
        $data['title'] = "Estadísticas de Recetas";
        $data['application_name'] = $this->settings->application_name;
        
        $data['stats'] = $this->Recetas_model->get_estadisticas();
        $data['usuario'] = $this->Users_model->is_admin();
        
        $this->load->view("admin/recetas_estadisticas", $data);
    }

    // Verificar disponibilidad de ingredientes
    public function verificar_disponibilidad($receta_id)
    {
        $ingredientes = $this->Recetas_model->get_ingredientes_by_receta($receta_id);
        $disponibilidad = array();
        $disponible = true;
        
        foreach ($ingredientes as $ingrediente) {
            // Obtener stock actual del producto
            $this->db->select('cantidad');
            $this->db->where('id', $ingrediente->producto_id);
            $producto = $this->db->get('inventario')->row();
            
            $stock_actual = $producto ? $producto->cantidad : 0;
            $suficiente = $stock_actual >= $ingrediente->cantidad;
            
            if (!$suficiente) {
                $disponible = false;
            }
            
            $disponibilidad[] = array(
                'producto' => $ingrediente->producto_nombre,
                'requerido' => $ingrediente->cantidad,
                'disponible' => $stock_actual,
                'suficiente' => $suficiente
            );
        }
        
        echo json_encode([
            'status' => true,
            'disponible' => $disponible,
            'detalle' => $disponibilidad
        ]);
    }

    // Descontar ingredientes del inventario (para cuando se prepara una receta)
    public function descontar_ingredientes()
    {
        $receta_id = $this->input->post('receta_id');
        $cantidad_preparada = $this->input->post('cantidad', true) ?: 1;
        
        if (!$receta_id) {
            echo json_encode(['status' => false, 'message' => 'Receta no especificada.']);
            return;
        }
        
        $this->db->trans_start();
        
        $ingredientes = $this->Recetas_model->get_ingredientes_by_receta($receta_id);
        
        foreach ($ingredientes as $ingrediente) {
            $cantidad_a_descontar = $ingrediente->cantidad * $cantidad_preparada;
            
            // Actualizar inventario
            $this->db->set('cantidad', 'cantidad - ' . $cantidad_a_descontar, FALSE);
            $this->db->where('id', $ingrediente->producto_id);
            $this->db->where('cantidad >=', $cantidad_a_descontar);
            $this->db->update('inventario');
            
            if ($this->db->affected_rows() == 0) {
                $this->db->trans_rollback();
                echo json_encode([
                    'status' => false, 
                    'message' => 'Stock insuficiente para ' . $ingrediente->producto_nombre
                ]);
                return;
            }
        }
        
        $this->db->trans_complete();
        
        if ($this->db->trans_status()) {
            echo json_encode([
                'status' => true,
                'message' => 'Ingredientes descontados correctamente del inventario.'
            ]);
        } else {
            echo json_encode([
                'status' => false,
                'message' => 'Error al descontar ingredientes.'
            ]);
        }
    }

    // Obtener recetas por categoría
    public function get_by_categoria()
    {
        $categoria = $this->input->post('categoria');
        
        if ($categoria) {
            $recetas = $this->Recetas_model->get_recetas_by_categoria($categoria);
            echo json_encode(['status' => true, 'data' => $recetas]);
        } else {
            $recetas = $this->Recetas_model->get_all();
            echo json_encode(['status' => true, 'data' => $recetas]);
        }
    }
}