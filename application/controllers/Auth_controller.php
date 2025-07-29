<?php defined('BASEPATH') or exit('No direct script access allowed');

class Auth_controller extends Core_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Users_model');
        $this->load->model('Email_model');
    }

    public function cargar_login()
    {   
        $data['title'] = "Inicio de sesión";
        $data['application_name'] = $this->settings->application_name;
        $data['description'] = $this->settings->site_description;
        $data['keywords'] = $this->settings->keywords;

        $this->load->view("admin/auth/login", $data);
    }

    /***
     *  Cargar la vista del login
     * */
    public function index()
    {
        $data['title'] = "Inicio de sesión";
        $data['application_name'] = $this->settings->application_name;
        $data['description'] = $this->settings->site_description;
        $data['keywords'] = $this->settings->keywords;

        if ($this->session->userdata('login')) {
            redirect(base_url() . 'admin/dashboard');
        } else {
            $this->load->view("admin/auth/login", $data);
        }
    }

    /***
     *  Metodo POST del login
     * */

    public function login()
    {

        $this->form_validation->set_rules('email', 'Email', 'required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'required|xss_clean');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('error', '¡Parámetros incorrectos, intente de nuevo!');
            redirect(base_url());
        } else {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            // ejecutar la petición al modelo
            $res = $this->Users_model->login($email, hash('sha256', $password, FALSE));

            if (!$res) {
                $this->session->set_flashdata('error', '¡El usuario y/o contraseña son incorrectos, intente de nuevo!');
                redirect(base_url() . 'inicio-sesion');
            } else {
                $this->Users_model->update_last_seen($res->id);
                // datos del usuario logeado
                $data  = array(
                    'id' => $res->id,
                    'username' => $res->username,
                    'mqtt_token' => base64_encode($password),
                    'user_token' => $res->token,
                    'fullname' => $res->fullname,
                    'email' => $res->email,
                    'photo' => $res->photo,
                    'is_superuser' => $res->is_superuser,
                    'login' => TRUE
                );
                $this->session->set_userdata($data);
                $this->session->set_flashdata('info', '¡Bienvenido a la Plataforma de IoT Tecnoparque!');
                // salvamos el log en la base de datos.
                log_activity('Usuario logeado [User Id: ' . $res->id . ', Is super_user: ' . ($res->is_superuser == true ? 'Yes' : 'No') . ', IP: ' . $this->input->ip_address() . ']', 'login');
                // redireccionamos al dashboard
                redirect(base_url() . 'admin/inicio');
            }
        }
    }
    /**
     * cerrar la sesión de usuario
     */
    public function logout()
    {
        // actualizar la ultima conexión
        $this->Users_model->update_last_seen($this->session->userdata("id"));
        $this->session->sess_destroy();
        redirect(base_url());
    }

    /**
     * Vista de formulario de registro de usuario
     */
    public function register()
    {

        $data['title'] = "Registro de Usuario";
        $data['application_name'] = $this->settings->application_name;
        $data['description'] = $this->settings->site_description;
        $data['keywords'] = $this->settings->keywords;
        if ($this->session->userdata('login')) {
            redirect(base_url() . 'admin/dashboard');
        } else {
            $this->load->view("admin/auth/register", $data);
        }
    }
    /**
     * MetodoPOST para registro de usuario
     */
    public function registerUser()
    {
        // validate inputs
        $this->form_validation->set_rules('fullname', 'Fullname', 'xss_clean|min_length[4]|max_length[100]');
        $this->form_validation->set_rules('username', 'Username', 'required|xss_clean|min_length[4]|max_length[100]');
        $this->form_validation->set_rules('email', 'Email', 'required|xss_clean|valid_email|max_length[255]');
        $this->form_validation->set_rules('password', 'Password', 'required|xss_clean|min_length[8]|max_length[100]|callback_password_check');



        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('error', "¡Error, parámetros no válidos!");
            $this->session->set_flashdata('form_data', $this->Users_model->input_values());
            redirect($this->agent->referrer());
        } else {
            $username = $this->input->post('username', true);
            $email = $this->input->post('email', true);

            //is username unique
            if (!$this->Users_model->is_unique_username($username)) {
                $this->session->set_flashdata('form_data', $this->Users_model->input_values());
                $this->session->set_flashdata('error', "¡Error, el Username tiene que ser único!");
                redirect($this->agent->referrer());
            }
            //is email unique
            if (!$this->Users_model->is_unique_email($email)) {
                $this->session->set_flashdata('form_data', $this->Users_model->input_values());
                $this->session->set_flashdata('error', "¡Error, el correo electrónico tiene que ser único!");
                redirect($this->agent->referrer());
            }


            //add user
            if ($this->Users_model->add_user()) {
                $this->session->set_flashdata('success', "¡Registro de nuevo usuario exitoso!");
            } else {
                $this->session->set_flashdata('error', "¡Error, no se pudo registrar el usuario!");
            }

            redirect($this->agent->referrer());
        }
    }

    // Callback function for password validation
    public function password_check($password)
    {
        // Verificar que la contraseña tenga al menos una letra minúscula, una letra mayúscula, un número y un carácter especial
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).+$/', $password)) {
            $this->form_validation->set_message('password_check', 'La contraseña debe contener al menos una letra mayúscula, una letra minúscula, un número y un carácter especial.');
            return false;
        }
        return true;
    }

    /**
     * Vista de recuperar la contraseña
     */
    public function forgot_password()
    {

        $data['title'] = "Recuperar la contraseña";
        $data['application_name'] = $this->settings->application_name;
        $data['description'] = $this->settings->site_description;
        $data['keywords'] = $this->settings->keywords;
        if ($this->session->userdata('login')) {
            redirect(base_url() . 'admin/dashboard');
        } else {
            $this->load->view("admin/auth/forgot_password", $data);
        }
    }
    /**
     * metodo POST para recuperar la contraseña.
     */
    public function forgot_password_post()
    {
        //comprobar si el usuario esta logueado.
        if ($this->session->userdata('login')) {
            redirect(base_url());
        }
        //POST
        $email = $this->input->post('email', true);
        //Capturar user por correo.
        $user = $this->Users_model->get_user_by_email($email);

        if (empty($user)) {
            $this->session->set_flashdata('error', html_escape("¡Error, no se pudo recuperar su contraseña!"));
            redirect($this->agent->referrer());
        } else {
            $this->load->model("email_model");
            $this->email_model->send_email_reset_password($user->id);
            $this->session->set_flashdata('success', "Le hemos enviado un correo electrónico para restablecer su contraseña. Por favor revise su bandeja de entrada o no deseados para los próximos pasos.");
            redirect($this->agent->referrer());
        }
    }

    /**
     * vista pare reset de la contraseña.
     */
    public function reset_password()
    {
        $data['title'] = "Establecer nueva contraseña";
        $data['application_name'] = $this->settings->application_name;
        $data['description'] = $this->settings->site_description;
        $data['keywords'] = $this->settings->keywords;

        $token = $this->input->get('token', true); // capturar el token desde URL
        //get user
        $data["user"] = $this->Users_model->get_user_by_token($token);

        $data["login"] = $this->session->flashdata('login'); // si esta logeado

        if (empty($data["user"]) && empty($data["login"])) {
            redirect(base_url());
        }

        $this->load->view('admin/auth/reset_password', $data);
    }
    /**
     * Reset Password Post
     */
    public function reset_password_post()
    {
        $login = $this->input->post('login', true);

        if ($login == 1) {
            redirect(base_url());
        }

        $this->form_validation->set_rules('password', "new_password", 'required|xss_clean|min_length[4]|max_length[50]');
        $this->form_validation->set_rules('password_confirm', "confirm_password", 'required|xss_clean|matches[password]');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('error', validation_errors());
            $this->session->set_flashdata('form_data', $this->Users_model->change_password_input_values());
            redirect($this->agent->referrer());
        } else {
            $token = $this->input->post('token', true);
            //get user
            $user = $this->Users_model->get_user_by_token($token);

            if ($this->Users_model->reset_password($token) && !empty($user)) {
                // envio del mensaje de confirmación al usuario
                $this->Email_model->send_email_reset_password_confirmation($user->id);
                // retornar al Login
                $this->session->set_flashdata('success', "¡Su contraseña ha sido cambiada exitosamente!");
                redirect(base_url());
            } else {
                $this->session->set_flashdata('error', "¡Error, hubo un problema al cambiar su contraseña!");
                redirect($this->agent->referrer());
            }
        }
    }
}
