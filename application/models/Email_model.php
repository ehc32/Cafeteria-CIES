<?php defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . "third_party/swiftmailer/vendor/autoload.php";
require APPPATH . "third_party/phpmailer/vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email_model extends CI_Model
{
    //send email reset password
    public function send_email_reset_password($user_id)
    {
        $user = $this->Users_model->get_user($user_id);

        if (!empty($user)) {
            $token = $user->token;

            // Generar un token único solo si está vacío
            if (empty($token)) {
                $token = generate_unique_id();
                // Actualizar el token en la base de datos
                $this->Users_model->update_user_token($user_id, $token);
            }

            $data = array(
                'subject' => "Recuperar la contraseña",
                'to' => $user->email,
                'template_path' => "email/email_reset_password",
                'token' => $token,
                'user' => $user->fullname
            );

            $this->send_email($data);
        }
    }

    //send email reset password confirmation
    public function send_email_reset_password_confirmation($user_id)
    {
        $user = $this->Users_model->get_user($user_id);
        if (!empty($user)) {
            $data = array(
                'subject' => "Contraseña restablecida",
                'to' => $user->email,
                'template_path' => "email/email_change_password",
                'user' => $user->fullname
            );
            $this->send_email($data);
        }
    }

    
    //send email ejecutar el envio del correo
    public function send_email($data)
    {
        //send with swift mailer
        if ($this->general_settings->mail_library == "swift") {
            try {
                // Create the Transport
                $transport = (new Swift_SmtpTransport($this->general_settings->mail_host, $this->general_settings->mail_port, 'tls'))
                    ->setUsername($this->general_settings->mail_username)
                    ->setPassword($this->general_settings->mail_password);

                // Create the Mailer using your created Transport
                $mailer = new Swift_Mailer($transport);

                // Create a message
                $message = (new Swift_Message($this->settings->application_name))
                    ->setFrom(array($this->general_settings->mail_username => $this->settings->application_name))
                    ->setTo([$data['to'] => ''])
                    ->setSubject($data['subject'])
                    ->setBody($this->load->view($data['template_path'], $data, TRUE), 'text/html');

                //Send the message
                $result = $mailer->send($message);
                if ($result) {
                    return true;
                }
            } catch (\Swift_TransportException $Ste) {
                $this->session->set_flashdata('error', $Ste->getMessage());
                return false;
            } catch (\Swift_RfcComplianceException $Ste) {
                $this->session->set_flashdata('error', $Ste->getMessage());
                return false;
            }
        }
        //send with php mailer
        if ($this->general_settings->mail_library == "php") {
            $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->isSMTP();
                $mail->Host = $this->general_settings->mail_host;
                $mail->SMTPAuth = true;
                $mail->Username = $this->general_settings->mail_username;
                $mail->Password = $this->general_settings->mail_password;
                $mail->SMTPSecure = 'tls';
                $mail->CharSet = 'UTF-8';
                $mail->Port = $this->general_settings->mail_port;
                //Recipients
                $mail->setFrom($this->general_settings->mail_username, $this->settings->application_name);
                $mail->addAddress($data['to']);
                //Content
                $mail->isHTML(true);
                $mail->Subject = $data['subject'];
                $mail->Body = $this->load->view($data['template_path'], $data, TRUE);
                $mail->send();
                return true;
            } catch (Exception $e) {
                $this->session->set_flashdata('error', $mail->ErrorInfo);
                return false;
            }
        }
        //send with codeigniter mail
        if ($this->general_settings->mail_library == "codeigniter") {

            $this->load->library('email');

            $general_settings = $this->settings_model->get_general_settings();

            if ($general_settings->mail_protocol == "smtp") {
                $config = array(
                    'protocol' => 'mail',
                    'smtp_host' => $general_settings->mail_host,
                    'smtp_port' => $general_settings->mail_port,
                    'smtp_user' => $general_settings->mail_username,
                    'smtp_pass' => $general_settings->mail_password,
                    'smtp_crypto' => 'tls',
                    'smtp_timeout' => 30,
                    'mailtype' => 'html',
                    'charset' => 'utf-8',
                    'wordwrap' => TRUE
                );
            } else {
                $config = array(
                    'protocol' => 'smtp',
                    'smtp_host' => $general_settings->mail_host,
                    'smtp_port' => $general_settings->mail_port,
                    'smtp_user' => $general_settings->mail_username,
                    'smtp_pass' => $general_settings->mail_password,
                    'smtp_crypto' => 'tls',
                    'smtp_timeout' => 30,
                    'mailtype' => 'html',
                    'charset' => 'utf-8',
                    'wordwrap' => TRUE
                );
            }
            $data['general_settings'] = $general_settings;
            $data['settings'] = $this->settings_model->get_settings();
            // initialize
            $this->email->initialize($config);
            // send email
            // cargamos la vista
            $message = $this->load->view($data['template_path'], $data, TRUE);

            $this->email->from($general_settings->mail_username, $this->settings->application_name);
            $this->email->to($data['to']);
            $this->email->subject($data['subject']);
            $this->email->message($message);
            $this->email->set_newline("\r\n");

            if ($this->email->send()) {
                return true;
            } else {
                $this->session->set_flashdata('error', $this->email->print_debugger(array('headers')));
                return false;
            }
        }
    }

    //update email settings
    public function update_email_settings()
    {
        $data = array(
            'mail_library' => $this->input->post('mail_library', true),
            'mail_protocol' => $this->input->post('mail_protocol', true),
            'mail_title' => $this->input->post('mail_title', true),
            'mail_host' => $this->input->post('mail_host', true),
            'mail_port' => $this->input->post('mail_port', true),
            'mail_username' => $this->input->post('mail_username', true),
            'mail_password' => $this->input->post('mail_password', true),
        );
        //update
        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }


}