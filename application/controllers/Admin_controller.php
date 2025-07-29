<?php

defined('BASEPATH') OR exit('No direct script access allowed'); 

class admin_controller extends Core_Controller
{   
    public function __construct()
    {
        parent::__construct();
        if (!is_user()) {
            redirect(base_url());
        }
        $this->load->model('');  
    }

    // vista del Dashboard
    public function index(){
		$data['title'] = "Inicio";
		$data['application_name'] = $this->settings->application_name;
		$data['description'] = $this->settings->site_description;
		$data['keywords'] = $this->settings->keywords;
        // data de cards
        
        // eventos
        $username = $this->session->userdata("username");
		$fullname = $this->session->userdata("fullname");
        $data['activity_logs'] = get_activity_logs($username, $fullname, 10);


        $this->load->view("admin/inicio", $data);

    }   

  

    // vista del Dashboard
    public function activity_logs()
    {
        $data['title'] = "Regístro de eventos";
        $data['application_name'] = $this->settings->application_name;
        $data['description'] = $this->settings->site_description;
        $data['keywords'] = $this->settings->keywords;
        // tabla
        $table = "activity_log";
        // contar los registros por tipo
        $data['login_count']   = get_total_by_type_table('login', $table);
        $data['delete_count']   = get_total_by_type_table('delete', $table);
        $data['disable_count']   = get_total_by_type_table('disable', $table);
        $data['enable_count']   = get_total_by_type_table('enable', $table);
        $data['status_count']   = get_total_by_type_table('status', $table);
        $data['store_count']   = get_total_by_type_table('store', $table);
        // tipo de evnto
        $type = (NULL == $this->input->get('type')) ? 'all' : $this->input->get('type');
        // retornar el tipo enviado
        $data['type'] = $type;
        // configuraciones para la paginación
        $limit_per_page = 10;
        $start_index = (NULL == $this->input->get('page')) ? 0 : intval($this->input->get('page'));
        $total_records = get_total_by_table($table, $type);

        if($total_records > 0){
            $data['activity_logs'] = get_current_page_records_by_table($limit_per_page, $start_index, $table, $type);
            $config['base_url'] = base_url('admin/activity-logs?type='.$type);
			$config['total_rows'] = $total_records;
			$config['per_page'] = $limit_per_page;
            // Inicializar la paginación
			$this->pagination->initialize($config);
            // pasar los Link generados para usar en la vista
			$data['activity_logs'] > 0 ? $data['links'] =  $this->pagination->create_links() : $data['links'] = '';		
            $data['total_records'] = $total_records/sizeof($data['activity_logs']);
        }

        $this->load->view("admin/activity_logs", $data);
    }

    // elemininar un evento por id
    public function delete_log_post($id){
        if (!is_user()) {
            redirect(base_url());
        }
        if (delete_element_by_table($id, "activity_log")) {
			$this->session->set_flashdata('success', "¡Regístro eliminado!");
			redirect($this->agent->referrer());
		} else {
			$this->session->set_flashdata('error', "¡Error, ocurrió un problema!");
			redirect($this->agent->referrer());
		}
    }

    // eliminar todos los registros de la tabla logs
    public function clear_activity_log_post(){
        //check if user
		if (!is_admin()) {
			echo json_encode(['status' => false]);
		}
        // Capturar POST con formato json
		$_POST = json_decode($this->security->xss_clean(file_get_contents("php://input")), TRUE);
		$table = $this->input->post("id", TRUE);

        $resp = clear_data_by_table($table);

        if($resp){
            echo json_encode(['status' => $resp]);
        }else{
            echo json_encode(['status' => $resp]); 
        }
    }


    // Vista del error 404
    
    public function error404()
	{
		$data['title'] = "Error 404";
		$data['application_name'] = $this->settings->application_name;
		$data['description'] = $this->settings->site_description;
		$data['keywords'] = $this->settings->keywords;
		$this->load->view("error404", $data);
	}


}