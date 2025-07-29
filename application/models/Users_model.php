<?php defined('BASEPATH') or exit('No direct script access allowed');

class Users_model extends CI_Model{
    //Consulta a la BD del usuario por correo y contraseña.
    public function login($email, $password){
        $this->db->where('email', $email);
        $this->db->where('password', $password);
        $this->db->where('status', "1");
        $res = $this->db->get("users");

        if ($res->num_rows() > 0) {
            return $res->row();
        } else {
            return false;
        }
    }

    public function get_user_by_id($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('users');
        return $query->row();
    }
    public function get_current_user_username()
    {
        $user_id = $this->session->userdata('user_id');
        $this->load->model('Users_model');
        $user = $this->Users_model->get_user_by_id($user_id);
        return $user->username;
    }
    //update last_seen
    public function update_last_seen($id)
    {
        $data['last_seen'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }
    // nombre completo del usuario BD
    public function get_user_fullname($id)
    {
        $this->db->where('id', $id);
        $user = $this->db->select('fullname')->from('users')->get()->row();
        return html_escape($user->fullname);
    }
    // username del usuario logeado sesión
    public function get_user_username()
    {
        return $this->session->userdata('username');
    }
    // id del usuario logeado sesión
    public function get_user_id()
    {
        return $this->session->userdata('id');
    }
    // Es Usuario
    public function is_user()
    {
        // verificar si esta logueado
        if (!$this->is_logged_in()) {
            return false;
        }
        return true;
    }
     //verificar si esta logueado
     public function is_logged_in()
     {
         $user = $this->get_logged_user();
         // verificar si esta logueado
         if ($this->session->userdata('login') == true && !empty($user)) {
             if ($user->status == 0) {
                 $this->logout();
                 return false;
             } else {
                 return true;
             }
         } else {
             $this->logout();
             return false;
         }
     }
     // capturar el usuario de la base de datos con el id del usuario logeado
    public function get_logged_user()
    {
        if ($this->session->userdata('login') == true) {
            $query = $this->db->get_where('users', array('id' => $this->get_user_id()));
            return $query->row();
        }
    }
    // Salir limpiar sesión
    public function logout()
    {
        // eliminar la data de sessión
        $this->session->unset_userdata('id');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('user_token');
        $this->session->unset_userdata('fullname');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('photo');
        $this->session->unset_userdata('is_superuser');
        $this->session->unset_userdata('login');
    }
    //Formulario de registro
    public function input_values()
    {
        $data = array(
            'fullname' => remove_forbidden_characters($this->input->post('fullname', true)),
            'username' => str_username(remove_forbidden_characters($this->input->post('username', true))),
            'email' => remove_forbidden_characters($this->input->post('email', true)),
            'password' => $this->input->post('password', true),
        );
        return $data;
    }

    public function password_check($password) {
        // Verificar que la contraseña tenga al menos una letra minúscula, una letra mayúscula, un número y un carácter especial
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).+$/', $password)) {
            $this->form_validation->set_message('password_check', 'La contraseña debe contener al menos una letra mayúscula, una letra minúscula, un número y un carácter especial.');
            return false;
        }
        return true;
    }

    //check if username is unique
    public function is_unique_username($username, $user_id = 0)
    {
        $user = $this->get_user_by_username($username);

        //if id doesnt exists
        if ($user_id == 0) {
            if (empty($user)) {
                return true;
            } else {
                return false;
            }
        }

        if ($user_id != 0) {
            if (!empty($user) && $user->id != $user_id) {
                //username taken
                return false;
            } else {
                return true;
            }
        }
    }
    //get user by username
    public function get_user_by_username($username)
    {
        $this->db->select('id');
        $this->db->where('username', $username);
        $query = $this->db->get('users');
        return $query->row();
    }
    //check if email is unique
    public function is_unique_email($email, $user_id = 0)
    {
        $user = $this->get_user_by_email($email);

        //if id doesnt exists
        if ($user_id == 0) {
            if (empty($user)) {
                return true;
            } else {
                return false;
            }
        }

        if ($user_id != 0) {
            if (!empty($user) && $user->id != $user_id) {
                //email taken
                return false;
            } else {
                return true;
            }
        }
    }
    //get user by email
    public function get_user_by_email($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        return $query->row();
    }
    // add user
    public function add_user()
    {
        $data = $this->Users_model->input_values(); // capturado los inputs
        $data['is_superuser'] = $this->input->post('role', true) == NULL ? 0 : $this->input->post('role', true); //cuando se registre un usuario desde el panel de super_usuario
        // Secure password for EMQX
        $data['password'] = hash('sha256', $data['password'], FALSE); // redefinir la contraseña
        $data['token'] = generate_unique_id();
        $data['slug'] = $this->generate_uniqe_slug($data["fullname"]);
        $data['last_seen'] = date('Y-m-d H:i:s');

    if ($data['is_superuser'] == 0) {
        $data['status'] = 0; 
}
        return $this->db->insert('users', $data);
    }
    //generate uniqe slug
    public function generate_uniqe_slug($username)
    {
        $slug = str_slug($username);
        if (!empty($this->get_user_by_slug($slug))) {
            $slug = str_slug($username . "-1");
            if (!empty($this->get_user_by_slug($slug))) {
                $slug = str_slug($username . "-2");
                if (!empty($this->get_user_by_slug($slug))) {
                    $slug = str_slug($username . "-3");
                    if (!empty($this->get_user_by_slug($slug))) {
                        $slug = str_slug($username . "-" . uniqid());
                    }
                }
            }
        }
        return $slug;
    }
    //get user by slug
    public function get_user_by_slug($slug)
    {
        $query = $this->db->get_where('users', array('slug' => $slug));
        return $query->row();
    }

    //get user by id
    public function get_user($id)
    {
        $this->db->select("u.*");
        $this->db->from("users u");;
        $this->db->where('u.id', $id);
        $this->db->group_by('u.id');
        $query = $this->db->get();
        return $query->row();
        
    }
    //get user by token
    public function get_user_by_token($token)
    {
        $this->db->where('token', $token);
        $query = $this->db->get('users');
        return $query->row();
    }
    // Actualizar el token del usuario en la base de datos
    public function update_user_token($user_id, $token)
    {
        $data = array('token' => $token);
        $this->db->where('id', $user_id);
        $this->db->update('users', $data);
    }

    //change password input values
    public function change_password_input_values()
    {
        $data = array(
            'old_password' => $this->input->post('old_password', true),
            'password' => $this->input->post('password', true),
            'password_confirm' => $this->input->post('password_confirm', true)
        );
        return $data;
    }
        
    //reset password
    public function reset_password($token)
    {
        $user = $this->get_user_by_token($token);
        if (!empty($user)) {
            $new_password = $this->input->post('password', true);
            $data = array(
                'password' => hash('sha256', $new_password, FALSE),
                'token' => generate_unique_id()
            );
            //change password
            $this->db->where('id', $user->id);
            return $this->db->update('users', $data);
        }
        return false;
    }  

        // Es el mismo Usuario
        public function is_same_user($id)
        {
            // verificar si esta logueado
            if (!$this->is_logged_in()) {
                return false;
            }
            // verificar el id
            if ($this->get_user_id() == $id) {
                return true;
            } else {
                return false;
            }
        }

            //update profile
    public function update_profile($data, $user_id)
    {
        $this->load->model('upload_model');
        $temp_path = $this->upload_model->upload_temp_image('file', 'path');
        if (!empty($temp_path)) {
            $data["photo"] = $this->upload_model->avatar_upload($this->get_user_id(), $temp_path);

            $this->upload_model->delete_temp_image($temp_path);
            // delete old
            // Usuario
            $user = $this->get_user($user_id);
            // elimina la foto antigua de perfil
            delete_file_from_server($user->photo);
        }
        $this->db->where('id', $user_id);
        return $this->db->update('users', $data);
    }

    //update user 
    public function update_user($id, $data)
    {
        // Modificar el slug en la data antes de insertar el usuario
        $data['slug'] = $this->generate_uniqe_slug($data["fullname"]);
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    //change password
    public function change_password()
    {
        $user = $this->get_logged_user(); // usuario en sesion
        if (!empty($user)) {
            $data = $this->change_password_input_values();
            if ($this->input->post('is_pass_exist', true) == 1) {
                //password does not match stored password.
                if (hash('sha256', $data['old_password'], FALSE) !== $user->password) {
                    $this->session->set_flashdata('error', "¡Error, la contraseña anterior no coincide!");
                    $this->session->set_flashdata('form_data', $this->change_password_input_values());
                    redirect($this->agent->referrer());
                }
            }
            $data = array(
                'password' => hash('sha256', $data['password'], FALSE)
            );
            $this->db->where('id', $user->id);
            return $this->db->update('users', $data);
        } else {
            return false;
        }
    }

    // Eliminar
    public function delete_user($id)
    {
        $user = $this->get_user($id);
        if (!empty($user)) {
            $this->db->where('id', $id);
            return $this->db->delete('users');
        } else {
            return false;
        }
    }

    // Es Administrador
    public function is_admin()
    {
        // verificar si esta logueado
        if (!$this->is_logged_in()) {
            return false;
        }
        // verificar el rol
        if ($this->session->userdata('is_superuser') == '1') {
            return true;
        } else {
            return false;
        }
    }

     //get users
     public function get_users()
     {
         $query = $this->db->get('users');
         return $query->result();
     }
 
     //ban user
     public function ban_user($id)
     {
         $user = $this->get_user($id);
         if (!empty($user)) {
             $data = array(
                 'status' => 0
             );
             $this->db->where('id', $id);
             return $this->db->update('users', $data);
         } else {
             return false;
         }
     }
 
     //remove ban user
     public function remove_user_ban($id)
     {
         $user = $this->get_user($id);
         if (!empty($user)) {
             $data = array(
                 'status' => 1
             );
             $this->db->where('id', $id);
             return $this->db->update('users', $data);
         } else {
             return false;
         }
     }

}