<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Settings_controller extends Core_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Settings_model');
        if (!is_admin()) {
            redirect(base_url());
        }
    }

    // cargar vista de las configuraciones generales
    public function index()
    {
        $data['title'] = "Configuraciones generales";
        $data['application_name'] = $this->settings->application_name;
        $data['description'] = $this->settings->site_description;
        $data['keywords'] = $this->settings->keywords;

        $data['form_settings'] = $this->settings_model->get_settings();

        $this->load->view("admin/settings/general_settings", $data);
    }

    // actualizar las configuraciones
    public function settings_post()
    {
        if ($this->settings_model->update_settings()) {
            $this->settings_model->update_general_settings();
        } else {
            $this->session->set_flashdata('error', '¡Parámetros incorrectos, intente de nuevo!');
        }
        $this->session->set_flashdata('success', '¡Configuraciones actualizadas!');
        redirect($this->agent->referrer()); // redirecciona al elemento que lo llama
    }

    /**
     * Set Mode Post
     */
    public function set_mode_post()
    {
        $this->settings_model->set_mode();
        redirect($this->agent->referrer());
    }

    // Vista de configuraciones del Broker MQTT
    public function mqtt_settings()
    {
        $data['title'] = "Configuraciones del Bróker MQTT";
        $data['application_name'] = $this->settings->application_name;
        $data['description'] = $this->settings->site_description;
        $data['keywords'] = $this->settings->keywords;

        $data['general_settings'] = $this->settings_model->get_general_settings();

        $this->load->view("admin/settings/mqtt_settings", $data);
    }

    // actualizar los parámetros de mqtt
    public function mqtt_settings_post()
    {
        if (!$this->settings_model->update_mqtt_settings()) {
            $this->session->set_flashdata('error', '¡Parámetros incorrectos, intente de nuevo!');
        }
        $this->session->set_flashdata('success', '¡Configuración del bróker MQTT actualizada!');
        redirect($this->agent->referrer()); // redirecciona al elemento que lo llama
    }

}
