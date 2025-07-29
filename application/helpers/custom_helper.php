<?php

defined('BASEPATH') or exit('No direct script access allowed');

//check user
if (!function_exists('is_user')) {
    function is_user()
    {
        // Get a reference to the controller object
        $ci = &get_instance();
        $ci->load->model('users_model');
        return $ci->users_model->is_user();
    }
}
//remove forbidden characters
if (!function_exists('remove_forbidden_characters')) {
    function remove_forbidden_characters($str)
    {
        $str = str_replace(';', '', $str);
        $str = str_replace(',', '', $str);
        $str = str_replace('"', '', $str);
        $str = str_replace('$', '', $str);
        $str = str_replace('%', '', $str);
        $str = str_replace('&', '', $str);
        $str = str_replace('#', '', $str);
        $str = str_replace('*', '', $str);
        $str = str_replace('/', '', $str);
        $str = str_replace('\'', '', $str);
        $str = str_replace('<', '', $str);
        $str = str_replace('>', '', $str);
        $str = str_replace('=', '', $str);
        $str = str_replace('?', '', $str);
        $str = str_replace('[', '', $str);
        $str = str_replace(']', '', $str);
        $str = str_replace('\\', '', $str);
        $str = str_replace('^', '', $str);
        $str = str_replace('`', '', $str);
        $str = str_replace('{', '', $str);
        $str = str_replace('}', '', $str);
        $str = str_replace('|', '', $str);
        $str = str_replace('~', '', $str);
        return $str;
    }
}
// Generar el username de MQTT usuario uno | usuariouno
if (!function_exists('str_username')) {
    function str_username($str)
    {
        return str_replace(' ', '', $str);
    }
}
//generate unique id
if (!function_exists('generate_unique_id')) {
    function generate_unique_id()
    {
        $id = uniqid("", TRUE);
        $id = str_replace(".", "-", $id);
        return $id . "-" . rand(10000000, 99999999);
    }
}
//generate slug
if (!function_exists('str_slug')) {
    function str_slug($str)
    {
        return url_title(convert_accented_characters($str), "-", true);
    }
}
//print old form data
if (!function_exists('old')) {
    function old($field)
    {
        $ci = &get_instance();
        if (isset($ci->session->flashdata('form_data')[$field])) {
            return html_escape($ci->session->flashdata('form_data')[$field]);
        }
    }
}
//get logo
if (!function_exists('get_logo')) {
    function get_logo($settings)
    {
        if (!empty($settings)) {
            if (!empty($settings->logo_path) && file_exists(FCPATH . $settings->logo_path)) {
                return base_url() . $settings->logo_path;
            }
        }
        return base_url() . "assets/images/logo-dark.png";
    }
}
// check same user
if (!function_exists('is_same_user')) {
    function is_same_user($id)
    {
        // Get a reference to the controller object
        $ci = &get_instance();
        $ci->load->model('users_model');
        return $ci->users_model->is_same_user($id);
    }
}




// genera un tiempo
function time_ago($timestamp)
{
    $time_ago = strtotime($timestamp);
    $current_time = time();
    $time_difference = $current_time - $time_ago;
    $seconds = $time_difference;
    $minutes = round($seconds / 60);            // value 60 is seconds
    $hours = round($seconds / 3600);            //value 3600 is 60 minutes * 60 sec
    $days = round($seconds / 86400);            //86400 = 24 * 60 * 60;
    $weeks = round($seconds / 604800);          // 7*24*60*60;
    $months = round($seconds / 2629440);        //((365+365+365+365+366)/5/12)*24*60*60
    $years = round($seconds / 31553280);        //(365+365+365+365+366)/5 * 24 * 60 * 60
    if ($seconds <= 60) {
        return "just_now";
    } else if ($minutes <= 60) {
        if ($minutes == 1) {
            return "1 " . "minute_ago";
        } else {
            return "$minutes " . "minutes_ago";
        }
    } else if ($hours <= 24) {
        if ($hours == 1) {
            return "1 " . "hour_ago";
        } else {
            return "$hours " . "hours_ago";
        }
    } else if ($days <= 30) {
        if ($days == 1) {
            return "1 " . "day_ago";
        } else {
            return "$days " . "days_ago";
        }
    } else if ($months <= 12) {
        if ($months == 1) {
            return "1 " . "month_ago";
        } else {
            return "$months " . "months_ago";
        }
    } else {
        if ($years == 1) {
            return "1 " . "year_ago";
        } else {
            return "$years " . "years_ago";
        }
    }
}
//get user avatar
if (!function_exists('get_user_avatar')) {
    function get_user_avatar($user)
    {
        if (!empty($user)) {
            if (!empty($user->photo) && file_exists(FCPATH . $user->photo)) {
                return base_url() . $user->photo;
            } elseif (!empty($user->photo)) {
                return $user->photo;
            } else {
                return base_url() . "uploads/profile/avatar_default.jpg";
            }
        } else {
            return base_url() . "uploads/profile/avatar_default.jpg";
        }
    }
}
//delete file from server
if (!function_exists('delete_file_from_server')) {
    function delete_file_from_server($path)
    {
        $full_path = FCPATH . $path;
        if (strlen($path ?? '') > 15 && file_exists($full_path)) {
            unlink($full_path);
        }
    }
}
//check admin
if (!function_exists('is_admin')) {
    function is_admin()
    {
        // Get a reference to the controller object
        $ci = &get_instance();
        $ci->load->model('users_model');
        return $ci->users_model->is_admin();
    }
}

//  escaped function para Telegram
if (!function_exists('get_escaped_str')) {
    function get_escaped_str($str)
    {
        $str = str_replace("_", '\\_', $str);
        $str = str_replace("/", '\\/', $str);
        $str = str_replace("*", '\\*', $str);
        $str = str_replace("[", '\\[', $str);
        $str = str_replace("]", '\\]', $str);
        $str = str_replace("(", '\\(', $str);
        $str = str_replace(")", '\\)', $str);
        $str = str_replace("~", '\\~', $str);
        $str = str_replace(">", '\\>', $str);
        $str = str_replace("+", '\\+', $str);
        $str = str_replace("-", '\\-', $str);
        $str = str_replace("=", '\\=', $str);
        $str = str_replace("|", '\\|', $str);
        $str = str_replace("{", '\\{', $str);
        $str = str_replace("}", '\\}', $str);
        $str = str_replace(".", '\\.', $str);
        $str = str_replace("!", '\\!', $str);
        return $str;
    }
}

// return serialnumber to base64
if (!function_exists('get_serial64')) {
    function get_serial64($serialnumber)
    {
        return remove_forbidden_characters(base64_encode($serialnumber));
    }
}



/*----------------------------------------------------------------------------------*\
    MENSAJES DE LA APLICACIÓN
    - Telegram
    - Email   
\*----------------------------------------------------------------------------------*/

if (!function_exists('Message')) {
    function Message($type, $msg_id, $text)
    {
        // Instanciar CI
        $ci = &get_instance();
        if ($type === "Telegram") {
            // capturar el token de telegram
            $token = $ci->general_settings->telegram_bot_token;
            $datos = [
                'chat_id' => '' . $msg_id . '',
                #'chat_id' => '@el_canal si va dirigido a un canal',
                'text' => '' . $text . '',
                'parse_mode' => 'MarkdownV2' #formato del mensaje "parse_mode": "MarkdownV2"
            ];
            $ch = curl_init();
            // https://api.telegram.org/bot{token}/getUpdates  - ver si el bot se creo y el id usuario
            // https://api.telegram.org/bot{token}/sendMessage - enviar mensajes por telegram
            curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot" . $token . "/sendMessage");
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $datos);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $r_array = json_decode(curl_exec($ch), true);
            curl_close($ch);
            if ($r_array['ok'] == 1) {
                //echo "Mensaje enviado.";
                return json_encode(['status' => true, 'msg' => $text, 'type' => 'Telegram']);
            } else {
                //echo "Mensaje no enviado.";
                return json_encode(['status' => false, 'msg' => $r_array, 'type' => 'Telegram']);
            }
            //Email send
        } elseif ($type === "Email") {
            $user = $ci->Users_model->get_user($msg_id);
            // armar la data para el correo 
            if (!empty($user)) {
                $data = array(
                    'subject' => "¡Eventos de estados de Dispositivos!",
                    'to' => $user->email,
                    'template_path' => "email/email_device_status",
                    'user' => $user->fullname,
                    'msg' => $text
                );
                return $ci->Email_model->send_email($data);
            }
        } else {
        }
    }
}
