<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Entrega_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Ventas_Register_Model');
        $this->load->model('Entrega_model');
    }

    public function entregar_turno($username, $total_ventas, $pagos, $saldo_final_caja) {
        $data = array(
            'username' => $username,
            'total_ventas' => $total_ventas,
            'pagos' => $pagos,
            'saldo_final_caja' => $saldo_final_caja,
            'created' => date('Y-m-d H:i:s')
        );
    
        if ($this->db->insert('entrega_turno', $data)){
            return true;
        } else {
            return false;
        }
    }

    public function obtener_historico()
    {
        $query = $this->db->get('entrega_turno');
        return $query->result();
    }

    public function obtener_historico_filtrado($fechaInicio, $fechaFinal)
    {
        $this->db->where('created >=', $fechaInicio);
        $this->db->where('created <=', $fechaFinal);
        $query = $this->db->get('entrega_turno');
        return $query->result();
    }

    // data de los input de fecha
    public function input_date_values()
    {
        $data = array(
            'fechaInicio' => $this->input->post('fechaInicio', true),
            'fechaFinal' => $this->input->post('fechaFinal', true),
        );
        return $data;
    }

    public function get_data_by_date_range($fechaInicio, $fechaFinal)
    {
        $this->db->select("*");
        $this->db->where("created >=", $fechaInicio . ' 00:00:00');
        $this->db->where("created <=", $fechaFinal . ' ' . date('H:i:s'));
        $this->db->from("entrega_turno")->order_by('created', 'desc');
        $resultado = $this->db->get();
        return $resultado->result();
    }
}

