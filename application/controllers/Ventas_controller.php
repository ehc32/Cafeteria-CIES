<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Ventas_controller extends Core_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_user()) {
            redirect(base_url());
        }
        $this->load->model('Ventas_model');
        $this->load->model('Ventas_Register_Model');
        $this->load->model('Users_model');
    }


    public function get_current_user_username()
    {
        $user_id = $this->session->userdata('user_id');
        log_message('debug', 'ID de usuario: ' . $user_id);
        
        $this->load->model('Users_model');
        $user = $this->Users_model->get_user_by_id($user_id);
        
        if ($user == null) {
            log_message('error', 'No se encontró el usuario con ID ' . $user_id);
            return null;
        }
        
        log_message('debug', 'Usuario encontrado: ' . $user->username);
        return $user->username;
    }


    public function get_categoria()
    {
        $categoria = $this->input->get('categoria');
        log_message('debug', 'Categoría recibida: ' . $categoria);
        return $categoria;
    }


    public function ventas_add()
    {
        $data['title'] = "Registrar venta";
        $data['application_name'] = $this->settings->application_name;
        $data['description'] = $this->settings->site_description;
        $data['keywords'] = $this->settings->keywords;
        $data['categorias'] = $this->Ventas_model->get_categorias();
        $data['vendedor_username'] = $this->get_current_user_username();
        $data['productos_por_categoria'] = array();

        $this->load->view("admin/ventas_add", $data);
    }

    public function get_productos_por_categoria()
    {
        $categoria = $this->input->get('categoria');
        $productos = $this->Ventas_model->productos_por_categoria($categoria);
        $productos_por_categoria = array();

        foreach ($productos as $producto) {
            $detalles = json_decode($producto->detalles, true);
            $productos_por_categoria = array_merge($productos_por_categoria, $detalles['productos']);
        }

        echo json_encode($productos_por_categoria);
    }

    public function productos_por_categoria($categoria)
    {
        $productos = array();
        foreach ($this->db->get('ventas')->result() as $row) {
            if ($row->categoria == $categoria) {
                $productos[] = array(
                    'producto_vendido' => $row->producto_vendido,
                    'valor_unitario' => $row->valor_unitario
                );
            }
        }
        return $productos;
    }
}
