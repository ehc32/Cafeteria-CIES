<?php defined('BASEPATH') or exit('No direct script access allowed');

class Settings_model extends CI_Model
{
    //get general settings
    public function get_general_settings()
    {
        $this->db->where('id', 1);
        $query = $this->db->get('general_settings');
        return $query->row();
    }

    //get settings
    public function get_settings()
    {
        $this->db->where('id', 1);
        $query = $this->db->get('settings');
        return $query->row();
    }

    //update settings
    public function update_settings()
    {
        $data = array(
            'application_name' => $this->input->post('application_name', true),
            'site_description' => $this->input->post('site_description', true),
            'keywords' => $this->input->post('keywords', true),
            'copyright' => $this->input->post('copyright', true),
            'contact_address' => $this->input->post('contact_address', true),
            'contact_email' => $this->input->post('contact_email', true),
            'contact_phone' => $this->input->post('contact_phone', true),
            'facebook_url' => $this->input->post('facebook_url', true),
            'twitter_url' => $this->input->post('twitter_url', true),
            'youtube_url' => $this->input->post('youtube_url', true),
        );
        $this->db->where('id', 1);
        return $this->db->update('settings', $data);
    }

    //update general settings
    public function update_general_settings()
    {
        $data = array(
            'timezone' => $this->input->post('timezone', true),
            'custom_css_codes' => trim($this->input->post('custom_css_codes', false)),
            'custom_javascript_codes' => trim($this->input->post('custom_javascript_codes', false)),
        );
        $this->load->model('upload_model');
        $logo_path = $this->upload_model->logo_upload('logo');
        $favicon_path = $this->upload_model->favicon_upload('favicon');
        if (!empty($logo_path)) {
            $data["logo_path"] = $logo_path;
        }
        if (!empty($favicon_path)) {
            $data["favicon_path"] = $favicon_path;
        }
        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //set mode
    public function set_mode()
    {
        $data = array(
            'dark_mode' => $this->input->post('dark_mode', true)
        );
        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    // Actualizar mqtt settings
    public function update_mqtt_settings()
    {
        $data = array(
            'mqtt_protocol' => $this->input->post('mqtt_protocol', true),
            'mqtt_host' => $this->input->post('mqtt_host', true),
            'mqtt_port' => trim($this->input->post('mqtt_port', false)),
            'emqx_AppID' => trim($this->input->post('emqx_AppID', false)),
            'emqx_AppSecret' => trim($this->input->post('emqx_AppSecret', false)),
            'emqx_ApiWebToken' => trim($this->input->post('emqx_ApiWebToken', false)),
            'emqx_AppPort' => trim($this->input->post('emqx_AppPort', false)),
        );

        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

}

