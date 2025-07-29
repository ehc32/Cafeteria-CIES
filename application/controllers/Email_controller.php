<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Email_controller extends Core_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Email_model');

        if (!is_admin()) {
            redirect(base_url());
        }

    }

    //  vista de correo  ?library=phpmailer
    public function index(){
        $data['title'] = "Configuraciones de correo electrónico";
        $data['application_name'] = $this->settings->application_name;
        $data['description'] = $this->settings->site_description;
        $data['keywords'] = $this->settings->keywords;

        $data['general_settings'] = $this->settings_model->get_general_settings();

        $data["library"] = $this->input->get('library');

        if (empty($data["library"])) {
            $data["library"] = "codeigniter"; // por defecto
            
            if (!empty($this->general_settings->mail_library)) {
                $data["library"] = $this->general_settings->mail_library;
            }

            redirect(base_url() . "admin/email-settings?library=" . $data["library"]); // si no trae data la libreria ponemos por defecto codeigniter en la url
        }
        $this->load->view("admin/settings/email_settings", $data);
    }

    /**
    * Email Settings Post
    */
    public function email_settings_post()
    {
        if ($this->Email_model->update_email_settings()) {
            $this->session->set_flashdata('success', "¡Configuraciones de correo electrónico actualizadas!");
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', "¡Error, ocurrió un problema!");
            redirect($this->agent->referrer());
        }
    }



}