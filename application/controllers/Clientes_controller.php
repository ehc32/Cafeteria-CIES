<?php defined('BASEPATH') or exit('No direct script access allowed');

class Clientes_controller extends Core_controller
{

    public function __construct()
    {
        parent::__construct();
        if (!is_user()) {
            redirect(base_url());
        }
        $this->load->model('Clientes_model');
    }

    public function clientes()
    {
        $data['title'] = "Registro de clientes";
        $data['application_name'] = $this->settings->application_name;
        $data['description'] = $this->settings->site_description;
        $data['keywords'] = $this->settings->keywords;


        // Cargar la vista con los datos
        $this->load->view("admin/clientes_add", $data);
    }

    public function registrar_cliente()
    {
        $data['title'] = "Registro de clientes";
        $data['application_name'] = $this->settings->application_name;
        $data['description'] = $this->settings->site_description;
        $data['keywords'] = $this->settings->keywords;
        $datos = array(
            'nombre' => $this->input->post('fullname'),
            'identificacion' => $this->input->post('identificacion'),
            'correo' => $this->input->post('email')
        );
        if ($this->Clientes_model->insertar_cliente($datos)) {
            $this->session->set_flashdata('success', "¡Registro de nuevo cliente exitoso!");
        } else {
            $this->session->set_flashdata('error', "¡Error, no se pudo registrar el cliente!");
        }
        redirect($this->agent->referrer());
    }


    public function listar_clientes()
    {
        $data['title'] = "Registro de clientes";
        $data['application_name'] = $this->settings->application_name;
        $data['description'] = $this->settings->site_description;
        $data['keywords'] = $this->settings->keywords;
        $data['clientes'] = $this->Clientes_model->obtener_clientes();
        $this->load->view('admin/clientes_list', $data);
    }

    public function editar_cliente($id)
    {
        $data['cliente'] = $this->Clientes_model->obtener_cliente($id);
        $this->load->view('admin/clientes/editar_cliente', $data);
    }

    public function change_cliente_post()
    {
        //check if admin
        if (!is_admin()) {
            redirect(base_url());
        }

        $data = array(
            'nombre' => $this->input->post("nombre"),
            'identificacion' => $this->input->post("identificacion"),
            'correo' => $this->input->post("correo"),
        );

        $id = $this->input->post('cliente_id', true);

        $cliente = $this->Clientes_model->get_cliente($id);

        //check if exists
        if (empty($cliente)) {
            redirect($this->agent->referrer());
        } else {

            if ($this->Clientes_model->actualizar_cliente($id, $data)) {
                $this->session->set_flashdata('success', "Cliente actualizado correctamente!");
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('error', "¡Error, ocurrió un problema!");
                redirect($this->agent->referrer());
            }
        }
    }

    public function actualizar_cliente()
    {
        $id = $this->input->post('id');
        $datos = array(
            'nombre' => $this->input->post('fullname'),
            'identificacion' => $this->input->post('identificacion'),
            'correo' => $this->input->post('email')
        );
        $this->Clientes_model->actualizar_cliente($id, $datos);
        redirect('clientes_controller/listar_clientes');
    }

 
    public function delete($id) {
        // Verificar si se recibió un ID válido
        if ($id) {
            // Llamar al método delete del modelo
            $result = $this->Clientes_model->delete($id);
    
            // Enviar una respuesta JSON según el resultado de la eliminación
            if ($result) {
                echo json_encode(['status' => true, 'message' => 'Cliente eliminado correctamente.']);
            } else {
                echo json_encode(['status' => false, 'message' => 'No se pudo eliminar el cliente.']);
            }
        } else {
            echo json_encode(['status' => false, 'message' => 'ID no proporcionado.']);
        }
    }

    public function buscar_cliente() {
        $identificacion = $this->input->post('identificacion');
        
        $cliente = $this->Clientes_model->get_by_identificacion($identificacion);
        if ($cliente != null) {
            echo json_encode(['nombre_cliente' => $cliente->nombre]);
            echo json_encode(['correo_electronico' => $cliente->correo]);
        } else {
            echo json_encode(['nombre_cliente' => '']);
            echo json_encode(['correo_electronico' => '']);
        }
    }
}

