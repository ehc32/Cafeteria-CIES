<?php

defined('BASEPATH') or exit('No direct script access allowed');

class   Inventario_controller extends Core_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_user()) {
            redirect(base_url());
        }
        $this->load->model('Inventario_model');
        $this->load->model('Inventario_comercio_model');
        $this->load->model('Users_model');
    }

    public function inventario()
    {
        $data['title'] = "Inventario";
        $data['application_name'] = $this->settings->application_name;
        $data['description'] = $this->settings->site_description;
        $data['keywords'] = $this->settings->keywords;

        // Obtener la lista de productos del modelo
        $data['productos'] = $this->Inventario_model->get_all();
        $data['usuario'] = $this->Users_model->is_admin();

        // Cargar la vista con los datos
        $this->load->view("admin/inventario", $data);
    }

    /**
     * MetodoPOST para registro de producto
     */
    public function registerProduct()
{
    // Determinar si el usuario es superusuario
    $is_superuser = $this->session->userdata("is_superuser") === "1";

    // Validar campos
    if ($is_superuser) {
        $this->form_validation->set_rules('nombre', 'Nombre', 'required');
        $this->form_validation->set_rules('presentacion', 'Presentación', 'required');
        $this->form_validation->set_rules('cantidad', 'Cantidad', 'required|numeric');
        $this->form_validation->set_rules('categoria', 'Categoría', 'required');
        $this->form_validation->set_rules('sede', 'Sede', 'required');
    } else {
        // Solo validar 'cantidad' si no es superusuario
        $this->form_validation->set_rules('cantidad', 'Cantidad', 'required|numeric');
        // Asegurarse de que el campo 'sede' se incluya y tenga un valor válido
        $this->form_validation->set_rules('sede', 'Sede', 'required');
    }

    // Verificar si la validación ha fallado
    if ($this->form_validation->run() === false) {
        $this->session->set_flashdata('error', "¡Error, parámetros no válidos!");
        $this->session->set_flashdata('form_data', $this->input->post());
        redirect($this->agent->referrer());
    } else {
        // Obtener 'product_id' y 'sede' del formulario
        $id = $this->input->post('product_id');
        $sede = $this->input->post('sede'); // Asegurarse de que 'sede' está presente

        // Si el usuario es superusuario, recoger todos los datos
        if ($is_superuser) {
            $data = array(
                'nombre' => $this->input->post('nombre'),
                'presentacion' => $this->input->post('presentacion'),
                'cantidad' => $this->input->post('cantidad'),
                'categoria' => $this->input->post('categoria'),
                'sede' => $sede
            );
        } else {
            // Si no es superusuario, solo recoger 'cantidad' y valores predeterminados de los demás campos
            $data = array(
                'cantidad' => $this->input->post('cantidad'),
                'sede' => $sede // Asegurarse de que 'sede' se incluya para decidir el modelo
            );

            // Recuperar los valores actuales del producto desde la base de datos
            $currentData = $this->Inventario_model->get_by_id($id);
            $data['nombre'] = $currentData->nombre;
            $data['presentacion'] = $currentData->presentacion;
            $data['categoria'] = $currentData->categoria;
        }

        // Lógica para agregar o actualizar el producto
        if (empty($id)) {
            if ($sede == 'CIES') {
                $result = $this->Inventario_model->add_product($data);
            } elseif ($sede == 'Comercio') {
                $result = $this->Inventario_comercio_model->add_product($data);
            }
            $this->session->set_flashdata(
                $result ? 'success' : 'error',
                $result ? "¡Producto agregado exitosamente!" : "¡Error, no se pudo agregar el producto!"
            );
        } else {
            // Actualizar en el modelo correspondiente basado en el valor de 'sede'
            if ($sede == 'CIES') {
                $result = $this->Inventario_model->update($id, $data);
            } elseif ($sede == 'Comercio') {
                $result = $this->Inventario_comercio_model->update($id, $data);
            }
            $this->session->set_flashdata(
                $result ? 'success' : 'error',
                $result ? "Producto actualizado exitosamente." : "Error al actualizar el producto."
            );
        }

        redirect($this->agent->referrer());
    }
}

    
    public function delete()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'];
        $sede = $data['sede']; 
    
        if ($id && $sede) {
            if ($sede == 'Comercio') {
                $result = $this->Inventario_comercio_model->delete($id);
            } elseif ($sede == 'CIES') {
                $result = $this->Inventario_model->delete($id);
            } else {
                echo json_encode(['status' => false, 'message' => 'Sede inválida.']);
                return;
            }

            if ($result) {
                echo json_encode(['status' => true, 'message' => 'Producto eliminado correctamente.']);
            } else {
                echo json_encode(['status' => false, 'message' => 'No se pudo eliminar el producto.']);
            }
        } else {
            echo json_encode(['status' => false, 'message' => 'ID o sede no proporcionados.']);
        }
    }
    
    public function get_productos_by_sede()
    {
        $this->load->model('Inventario_comercio_model');
        $sede = $this->input->post('sede');
        if ($sede == 'CIES') {
            $productos = $this->Inventario_model->get_all();
        } elseif ($sede == 'Comercio') {
            $this->load->model('Inventario_comercio_model');
            $productos = $this->Inventario_comercio_model->get_all();
        } else {
            $productos = array();
        }
        echo json_encode($productos);
    }
}
