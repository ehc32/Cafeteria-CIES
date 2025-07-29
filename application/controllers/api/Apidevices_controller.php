<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';

class Apidevices_controller extends \Restserver\Libraries\REST_Controller // CI_Controller //
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Devices_model');
        $this->load->model('Users_model');
        $this->load->model('Email_model');
    }

    // _post() agregar para definir el método POST
    // Actualizar el estado de la conexión de los dispositivos desde las reglas de EMQX
    public function status_post()
    {
        header("Access-Control-Allow-Origin: *");
        $_POST = json_decode($this->security->xss_clean(file_get_contents("php://input")), TRUE);
        $payload = $this->input->post('payload', true);
        $topic = $this->input->post('topic', true);
        $token = $this->input->post('token', true);
        $explode = explode("/", $topic ?? '');
        // mensaje
        $message = '';

        $emqx_ApiWebToken = $this->general_settings->emqx_ApiWebToken;
        // comparar los token enviado === bd
        if ($token == $emqx_ApiWebToken) {
            // actualizamos en BD
            $this->Devices_model->change_device_status($explode[1], $payload['connected']);
            // capturamos el Usuario
            $user = $this->Users_model->get_user_by_username($explode[0]);
            // telegram .... 
            $msg = $payload['connected'] == 1 ? "Conectado" : "Desconectado";
            // Si el usuario tiene telegram chat id y habilitado el envio de mensajes. 
            if ($user->telegram_enable_send && !empty($user->telegram_ChatId)) {
                // envio por telegram
                $message = Message("Telegram", $user->telegram_ChatId, get_escaped_str("Dispositivo con serie -> ") . $explode[1] . " " . $msg . " " . get_escaped_str("-> Fecha y Hora ->" . date("Y-m-d H:i:s")));
            }
            // Si el usuario tiene el correo habilitado para el envio de mensajes.
            if ($user->email_enable_send) {
                $message = Message("Email", $user->id, "Dispositivo con serie -> " . $explode[1] . " " . $msg . " " . "-> Fecha y Hora ->" . date("Y-m-d H:i:s"));
            }
            // Salvar el log en la base de datos
            log_activity(
                'Dispositivo ' . $msg . ' [Device Id: ' . $explode[1] . ', Username: ' . $explode[0] . ']',
                'status',
                $explode[1],
                $user->id
            );
            // respuesta desde la API
            $response = array(
                'status' => true,
                'topic' => $topic,
                'token' => $token,
                'device' => $explode[1],
                'messaje' => $message,
                'payload' => $payload
            );
            $this->output
                ->set_status_header(200)
                ->set_header('Access-Control-Allow-Origin: *')
                ->set_header('Cache-Control: no-store, no-cache, must-revalidate')
                ->set_header('Cache-Control: post-check=0, pre-check=0')
                ->set_header('Pragma: no-cache')
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
                ->_display();
            exit;
        }
        // respuesta desde la API
        $response = array(
            'status' => false,
            'msg' => 'Bad request',
        );
        $this->output
            ->set_status_header(400)
            ->set_header('Access-Control-Allow-Origin: *')
            ->set_header('Cache-Control: no-store, no-cache, must-revalidate')
            ->set_header('Cache-Control: post-check=0, pre-check=0')
            ->set_header('Pragma: no-cache')
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->_display();
        exit;
    }

    
    // Almacenar la data desde las reglas de EMQX
    public function store_post()
    {
        $_POST = json_decode($this->security->xss_clean(file_get_contents("php://input")), TRUE);
        $payload = $this->input->post('payload', true);
        $topic = $this->input->post('topic', true);
        $token = $this->input->post('token', true);
        $explode = explode("/", $topic);
        $emqx_ApiWebToken = $this->general_settings->emqx_ApiWebToken;
        if ($token == $emqx_ApiWebToken) {
            $user   = $this->Users_model->get_user_by_username($explode[0]);
            $device = $this->Devices_model->get_device_by_serial($explode[1]);
            if (!empty($device)) {
                // data para BD
                $data = array(
                    'deviceMqttId'       => $payload['deviceMqttId'],
                    'deviceSerial'       => $payload['deviceSerial'],
                    'deviceRelay1Status' => (float)$payload["data"]['deviceRelay1Status'],
                    'deviceRelay2Status' => (float)$payload["data"]['deviceRelay2Status'],
                    'deviceDimmer'       => (float)$payload["data"]['deviceDimmer'],
                    'deviceCpuTempC'     => (float)$payload["data"]['deviceCpuTempC'],
                    'deviceDS18B20TempC' => (float)$payload["data"]['deviceDS18B20TempC'],
                    'deviceDS18B20TempF' => (float)$payload["data"]['deviceDS18B20TempF'],
                    'deviceRestarts'     => (float)$payload["data"]['deviceRestarts'],
                    'wifiRssiStatus'     => intval($payload["data"]['wifiRssiStatus']),
                    'wifiQuality'        => (int)$payload["data"]['wifiQuality'],
                    'deviceId'           => (int)$device->id,
                    'deviceUserId'       => (int)$user->id
                );

                $resp = $this->Devices_model->device_store_data($data);
                // respuesta
                if ($resp) {
                    // Salvar el log en la base de datos
                    log_activity(
                        'Almacenamiento en BD [Device Id: ' . $explode[1] . ', Username: ' . $explode[0] . ']',
                        'store',
                        $explode[1],
                        $user->id
                    );
                    $response = array(
                        'status' => true,
                        'topic' => $topic,
                        'token' => $token,
                        'device' => $explode[1],
                        'messaje' => 'Datos almacenados',
                        'payload' => $payload
                    );
                    $this->output
                        ->set_status_header(200)
                        ->set_header('Access-Control-Allow-Origin: *')
                        ->set_header('Cache-Control: no-store, no-cache, must-revalidate')
                        ->set_header('Cache-Control: post-check=0, pre-check=0')
                        ->set_header('Pragma: no-cache')
                        ->set_content_type('application/json', 'utf-8')
                        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
                        ->_display();
                    exit;
                }
            }else{
                $response = array(
                    'status' => false,
                    'msg' => 'Device not found',
                );
                $this->output
                    ->set_status_header(400)
                    ->set_header('Access-Control-Allow-Origin: *')
                    ->set_header('Cache-Control: no-store, no-cache, must-revalidate')
                    ->set_header('Cache-Control: post-check=0, pre-check=0')
                    ->set_header('Pragma: no-cache')
                    ->set_content_type('application/json', 'utf-8')
                    ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
                    ->_display();
                exit;
            }
        }
        // NO
        $response = array(
            'status' => false,
            'msg' => 'Bad request',
        );
        $this->output
            ->set_status_header(400)
            ->set_header('Access-Control-Allow-Origin: *')
            ->set_header('Cache-Control: no-store, no-cache, must-revalidate')
            ->set_header('Cache-Control: post-check=0, pre-check=0')
            ->set_header('Pragma: no-cache')
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->_display();
        exit;
    }

}
