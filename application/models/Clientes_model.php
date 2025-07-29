<?php defined('BASEPATH') or exit('No direct script access allowed');

class Clientes_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Clientes_model');
    }
    private $table = 'clientes';



    public function insertar_cliente($datos)
    {
        if ($this->db->insert('clientes', $datos)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function obtener_clientes()
    {
        $query = $this->db->get('clientes');
        return $query->result();
    }

    public function actualizar_cliente($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('clientes', $data);

        if ($this->db->update('clientes', $data, array('id' => $id))) {
            return true; 
        } else {
            return false; 
        }
    }

    //get users
    public function get_cliente()
    {
        $query = $this->db->get('clientes');
        return $query->result();
    }
    public function get_by_id($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);
        return $query->row();
    }

    // Eliminar
    public function delete($id)
    {
        $cliente = $this->get_by_id($id);
        if (!empty($cliente)) {
            $this->db->where('id', $id);
            return $this->db->delete('clientes');
        } else {
            return false;
        }
    }

    public function get_by_identificacion($identificacion) {
        $this->db->where('identificacion', $identificacion);
        $query = $this->db->get('clientes');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            log_message('error', 'No se encontró el cliente con identificación ' . $identificacion);
            return null; 
        }
    }
}
