<?php

defined('BASEPATH') or exit('No direct script access allowed');

class   Entrega_controller extends Core_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Ventas_Register_Model');
        $this->load->model('Settings_Model');
        $this->load->model('Ventas_model');
        $this->load->model('Users_model');
        $this->load->model('Entrega_model');
    }



    public function vista_entrega_turno(){
        {
            $vendedor_username = $this->session->userdata("username");
            $ventas_vendedor_dia = $this->Ventas_Register_Model->ventas_vendedor_dia($vendedor_username);
            $total_ventas = 0;
            foreach ($ventas_vendedor_dia as $venta) {
                $total_ventas += $venta->valor_total;
            }

            // Pasar las ventas a la vista
            $data['ventas'] = $ventas_vendedor_dia;
            $data['total_ventas'] = $total_ventas;
            $data['title'] = "Entrega de turno";
            $data['application_name'] = $this->settings->application_name;
            $data['description'] = $this->settings->site_description;
            $data['keywords'] = $this->settings->keywords;

            $this->load->view("admin/entrega_turno", $data);
        }
    }

    public function entregar_turno() {
        $total_ventas = $this->input->post('total_ventas');
        $pagos = $this->input->post('pagos');
        $saldo_final_caja = $total_ventas - $pagos;
        $username = $this->session->userdata("username");
    
        $this->load->model('Entrega_model');
        if ($this->Entrega_model->entregar_turno($username, $total_ventas, $pagos, $saldo_final_caja)) {
            $this->session->set_flashdata('success', "¡Entrega de turno registrada exitosamente!");
            redirect($_SERVER['HTTP_REFERER']); // Recarga la página anterior
        } else {
            $this->session->set_flashdata('error', "¡Error al registrar la entrega de turno!");
            redirect($_SERVER['HTTP_REFERER']); // Recarga la página anterior
        }
    }

    public function listar_historial_filtrado()
    {
        $fechaInicio = $this->input->post('fechaInicio');
        $fechaFinal = $this->input->post('fechaFinal');

        redirect('/admin/historial_turnos?fecha_inicio=' . $fechaInicio . '&fecha_final=' . $fechaFinal);
    }

    public function listar_historico()
    {
        $fechaInicio = $this->input->get('fecha_inicio');
        $fechaFinal = $this->input->get('fecha_final');

        if ($fechaInicio && $fechaFinal) {
            $data['historico'] = $this->Entrega_model->obtener_historico_filtrado($fechaInicio, $fechaFinal);
        } else {
            $data['historico'] = $this->Entrega_model->obtener_historico();
        }
        $this->cargar_vistas($data);
    }

    public function cargar_vistas($data)
    {
        $data['title'] = "Detalle de venta";
        $data['application_name'] = $this->settings->application_name;
        $data['description'] = $this->settings->site_description;
        $data['keywords'] = $this->settings->keywords;
        $this->load->view("admin/includes/_header", $data);
        $this->load->view("admin/includes/_sidebar", $data);
        $this->load->view('admin/historial_turnos', $data);
    }
    
}