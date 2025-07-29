<?php defined('BASEPATH') or exit('No direct script access allowed');

class Core_controller extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
         // general settings
         $global_data['general_settings'] = $this->settings_model->get_general_settings();
         $this->general_settings = $global_data['general_settings'];
         // settings
         $global_data['settings'] = $this->settings_model->get_settings();
         $this->settings = $global_data['settings'];
 
         // definir la zona horaria global desde la BD | America/Bogota
         date_default_timezone_set($this->general_settings->timezone);        
    }
}