<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Users_controller extends Core_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Users_model');
    }

    /**
     * Vista del Perfil de usuario
     */
    public function profile($id)
    {
        // verificar que sea el mismo usuario
        if (!is_same_user($id)) {
            redirect(base_url());
        }
        // header
        $data['title'] = "Perfil de usuario";
        $data['application_name'] = $this->settings->application_name;
        $data['description'] = $this->settings->site_description;
        $data['keywords'] = $this->settings->keywords;
        // capturar el usuario
        $data['user'] = $this->Users_model->get_user($id);
        // cargar la vista
        $this->load->view("admin/users/user_profile", $data);
    }

    /**
     * Update Profile Post
     */
    public function update_profile_post()
    {
        // verificar el usuario logeado
        if (!is_user()) {
            redirect(base_url());
        }

        $user_id = $this->Users_model->get_user_id();

        //validate inputs
        $this->form_validation->set_rules('username', "username", 'required|xss_clean|max_length[100]');
        $this->form_validation->set_rules('email', "email", 'required|xss_clean|max_length[255]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($this->agent->referrer());
        } else {

            $data = array(
                'fullname' => $this->input->post('fullname', true),
                'username' => $this->input->post('username', true),
                'phone' => $this->input->post('phone', true),
                'email' => $this->input->post('email', true),
                'slug'  => $this->Users_model->generate_uniqe_slug($this->input->post('fullname', true)),
            );

            //is email unique
            if (!$this->Users_model->is_unique_email($data["email"], $user_id)) {
                $this->session->set_flashdata('error', "¡Error, el correo electrónico tiene que ser único!");
                redirect($this->agent->referrer());
                exit();
            }

            //is username unique
            if (!$this->Users_model->is_unique_username($data["username"], $user_id)) {
                $this->session->set_flashdata('error', "¡Error, el Username tiene que ser único!");
                redirect($this->agent->referrer());
                exit();
            }
            // almacenar los cambios en BD
            if ($this->Users_model->update_profile($data, $user_id)) {
                $this->session->set_flashdata('success', "¡Perfil de usuario actualizado!");
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('error', "¡Error, ocurrió un problema!");
                redirect($this->agent->referrer());
            }
        }
    }

    /**
     * Update Profile alertas por correo o telegram
     */
    public function alerts_update_post()
    {

        $id = $this->input->post('user_id', true);

        if (!is_same_user($id)) {
            redirect(base_url());
        }

        $data = array(
            'email_enable_send' => $this->input->post('email_enable_send', true),
            'telegram_enable_send' => $this->input->post('telegram_enable_send', true),
            'telegram_ChatId' => trim($this->input->post('telegram_ChatId', false)),
        );

        if ($this->Users_model->update_user($id, $data)) {
            $this->session->set_flashdata('success', "¡Notificaciones actualizadas!");
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', "¡Error, ocurrió un problema!");
            redirect($this->agent->referrer());
        }
    }


    /**
     * Update Profile la contraseña
     */
    public function change_password_post()
    {
        if (!is_user()) {
            redirect(base_url());
        }
        $this->form_validation->set_rules('password', "password", 'required|xss_clean|min_length[4]|max_length[100]');
        $this->form_validation->set_rules('password_confirm', "confirm_password", 'required|xss_clean|min_length[4]|max_length[100]|matches[password]');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('error', validation_errors());
            $this->session->set_flashdata('form_data', $this->Users_model->change_password_input_values());
            redirect($this->agent->referrer());
        } else {
            if ($this->Users_model->change_password()) {
                $this->session->set_flashdata('success', "¡Contraseña actualizada!");
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('error', "¡Error, ocurrió un problema!");
                redirect($this->agent->referrer());
            }
        }
    }

    /**
     * Eliminar el usuario (auto elimina)
     */
    public function delete_user_profile()
    {
        // Capturar POST con formato json
        $_POST = json_decode($this->security->xss_clean(file_get_contents("php://input")), TRUE);
        // POST
        $id = $this->input->post('id', true);
        if (!is_same_user($id)) {
            //redirect(base_url());
            echo json_encode(['status' => false]);
        }

        $resp = $this->Users_model->delete_user($id);
        log_activity('Usuario eliminado [User Id: ' . $id . ', By user: ' .  $this->Users_model->get_user_username() . ']', 'delete');
        echo json_encode(['status' => $resp]);
    }

    // Vista agregar usuario
    public function add_user()
    {
        if (!is_admin()) {
            redirect(base_url());
        }

        $data['title'] = "Registro de usuarios";
        $data['application_name'] = $this->settings->application_name;
        $data['description'] = $this->settings->site_description;
        $data['keywords'] = $this->settings->keywords;

        $this->load->view("admin/users/user_add", $data);
    }

    // vista lista de usuarios
    public function users()
    {
        if (!is_admin()) {
            redirect(base_url());
        }

        $data['title'] = "Usuarios";
        $data['application_name'] = $this->settings->application_name;
        $data['description'] = $this->settings->site_description;
        $data['keywords'] = $this->settings->keywords;

        $data['users'] = $this->users_model->get_users();

        $this->load->view("admin/users/users_list", $data);
    }


    // método para ban de usuarios
    public function user_options_post()
    {
        if (!is_admin()) {
            redirect(base_url());
        }
        $option = $this->input->post('option', true);
        $id = $this->input->post('id', true);
        if ($option == 'ban') {
            if ($this->Users_model->ban_user($id)) {
                // bloquear todos los dispositivos del usuario
                foreach ($devices_by_user as $clave => $device) {
                    // agregar BAN
                    add_ban_deviceID($device->serialnumber);
                    // deshabilitar la regla de los estados
                    action_web_hook_rule($device->rule_status_id, false, 'PUT');
                    // deshabilitar la regla de salvar los datos
                    action_web_hook_rule($device->rule_store_id, false, 'PUT');
                }
                // Salvar el log en la base de datos
                log_activity('Usuario deshabilitado [User Id: ' . $id . ', By administrator: ' .  $this->Users_model->get_user_username() . ', command: ' . $option . ']', 'disable');
                $this->session->set_flashdata('warning', "¡Usuario deshabilitado!");
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('error', "¡Error, ocurrió un problema!");
                redirect($this->agent->referrer());
            }
        }
        if ($option == 'remove_ban') {
            if ($this->Users_model->remove_user_ban($id)) {
                // desbloquear todos los dispositivos del usuario
                foreach ($devices_by_user as $clave => $device) {
                    remove_ban_deviceID($device->serialnumber);
                    // habilitar la regla de los estados
                    action_web_hook_rule($device->rule_status_id, true, 'PUT');
                    // habilitar la regla de salvar los datos
                    action_web_hook_rule($device->rule_store_id, true, 'PUT');
                }
                // Salvar el log en la base de datos
                log_activity('Usuario habilitado [User Id: ' . $id . ', By administrator: ' .  $this->Users_model->get_user_username() . ', command: ' . $option . ']', 'enable');
                $this->session->set_flashdata('success', "¡Usuario habilitado!");
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('error', "¡Error, ocurrió un problema!");
                redirect($this->agent->referrer());
            }
        }
    }

    // método POST update users
    public function change_user_post()
    {
        //check if admin
        if (!is_admin()) {
            redirect(base_url());
        }

        $data = array(
            'fullname' => $this->input->post("fullname"),
            'email' => $this->input->post("email"),
            'is_superuser' => $this->input->post("role"),
            'password' => hash('sha256', $this->input->post("password"), FALSE),
        );

        $id = $this->input->post('user_id', true);

        $user = $this->Users_model->get_user($id);

        //check if exists
        if (empty($user)) {
            redirect($this->agent->referrer());
        } else {

            if ($data['password'] == '') $data['password'] = $user->password;

            if ($this->Users_model->update_user($id, $data)) {
                $this->session->set_flashdata('success', "¡Usuario actualizado correctamente!");
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('error', "¡Error, ocurrió un problema!");
                redirect($this->agent->referrer());
            }
        }
    }

    public function delete($id)
    {
        // Verificar si se recibió un ID válido
        if ($id) {
            // Llamar al método delete del modelo
            $result = $this->Users_model->delete_user($id);

            // Enviar una respuesta JSON según el resultado de la eliminación
            if ($result) {
                echo json_encode(['status' => true, 'message' => 'Usuario eliminado correctamente.']);
            } else {
                echo json_encode(['status' => false, 'message' => 'No se pudo eliminar el Usuario.']);
            }
        } else {
            echo json_encode(['status' => false, 'message' => 'ID no proporcionado.']);
        }
    }
}
