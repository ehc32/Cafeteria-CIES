<?php

defined('BASEPATH') or exit('No direct script access allowed');

class   Inventario_comercio_controller extends Core_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_user()) {
            redirect(base_url());
        }
        $this->load->model('Inventario_comercio_model');
    }

    public function inventario()
    {
        $data['title'] = "Inventario";
        $data['application_name'] = $this->settings->application_name;
        $data['description'] = $this->settings->site_description;
        $data['keywords'] = $this->settings->keywords;

        // Obtener la lista de productos del modelo
        $data['productos'] = $this->Inventario_comercio_model->get_all();

        // Cargar la vista con los datos
        $this->load->view("admin/inventario", $data);
    }



    /**
     * MetodoPOST para registro de producto
     */
    public function registerProduct()
    {
        // Validate inputs
        $this->form_validation->set_rules('nombre', 'Nombre', 'required');
        $this->form_validation->set_rules('presentacion', 'Presentación', 'required');
        $this->form_validation->set_rules('cantidad', 'Cantidad', 'required|numeric');
        $this->form_validation->set_rules('categoria', 'Categoría', 'required');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('error', "¡Error, parámetros no válidos!");
            $this->session->set_flashdata('form_data', $this->input->post());
            redirect($this->agent->referrer());
        } else {
            $id = $this->input->post('product_id'); // Obtén el ID del producto
            $data = array(
                'nombre' => $this->input->post('nombre'),
                'presentacion' => $this->input->post('presentacion'),
                'cantidad' => $this->input->post('cantidad'),
                'categoria' => $this->input->post('categoria'),
            );

            if (empty($id)) {
                // Agregar nuevo producto
                if ($this->Inventario_comercio_model->add_product($data)) {
                    $this->session->set_flashdata('success', "¡Producto agregado exitosamente!");
                } else {
                    $this->session->set_flashdata('error', "¡Error, no se pudo agregar el producto!");
                }
            } else {
                // Editar producto existente
                if ($this->Inventario_model->update($id, $data)) {
                    $this->session->set_flashdata('success', "¡Producto actualizado exitosamente!");
                } else {
                    $this->session->set_flashdata('error', "¡Error, no se pudo actualizar el producto!");
                }
            }

            redirect($this->agent->referrer());
        }
    }


    public function edit($id)
    {
        // Si el formulario ha sido enviado
        if ($this->input->post()) {
            // Recoge los datos del formulario
            $data = array(
                'nombre' => $this->input->post('nombre'),
                'presentacion' => $this->input->post('presentacion'),
                'cantidad' => $this->input->post('cantidad'),
                'categoria' => $this->input->post('categoria'),
                'sede' => $this->input->post('sede') 
            );
    
            // Validar los datos
            $this->form_validation->set_rules('nombre', 'Nombre', 'required');
            $this->form_validation->set_rules('presentacion', 'Presentación', 'required');
            $this->form_validation->set_rules('cantidad', 'Cantidad', 'required');
            $this->form_validation->set_rules('categoria', 'Categoría', 'required');
            $this->form_validation->set_rules('sede', 'Sede', 'required'); 
    
            if ($this->form_validation->run() === FALSE) {
                // Si la validación falla, recargar la vista de edición con errores
                $this->load->view('inventario/edit', array('item' => $this->Inventario_model->get_by_id($id)));
            } else {
                // Determinar en qué modelo actualizar el producto basado en la sede
                if ($data['sede'] == 'CIES') {
                    $this->load->model('Inventario_model');
                    $updated = $this->Inventario_model->update($id, $data);
                } elseif ($data['sede'] == 'Comercio') {
                    $this->load->model('Inventario_comercio_model');
                    $updated = $this->Inventario_comercio_model->update($id, $data);
                } else {
                    $this->session->set_flashdata('error', 'Sede inválida.');
                    redirect('inventario');
                }
    
                // Mensajes de éxito o error
                if ($updated) {
                    $this->session->set_flashdata('success', 'Producto actualizado exitosamente.');
                } else {
                    $this->session->set_flashdata('error', 'Error al actualizar el producto.');
                }
                redirect('inventario');
            }
        } else {
            // Cargar los datos del producto para el formulario de edición
            $data['item'] = $this->Inventario_model->get_by_id($id); 
            $this->load->view('inventario/edit', $data);
        }
    }

 public function delete() {
        // Obtener los datos del POST en formato JSON
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'];

        // Verificar si se recibió un ID válido
        if ($id) {
            // Llamar al método delete del modelo
            $result = $this->Inventario_comercio_model->delete($id);

            // Enviar una respuesta JSON según el resultado de la eliminación
            if ($result) {
                echo json_encode(['status' => true, 'message' => 'Producto eliminado correctamente.']);
            } else {
                echo json_encode(['status' => false, 'message' => 'No se pudo eliminar el producto.']);
            }
        } else {
            echo json_encode(['status' => false, 'message' => 'ID no proporcionado.']);
        }
    }
}