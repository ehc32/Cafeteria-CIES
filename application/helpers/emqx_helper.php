<?php

defined('BASEPATH') or exit('No direct script access allowed');

// Listar todos los recursos web hook API EMQX
if (!function_exists('list_web_hook_resource')) {
    function list_web_hook_resource()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://' . get_mqtt_host() . ':' . get_app_port() . '/api/v4/resources',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic ' . get_app_key()
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
}

// Crear un recurso web hook API EMQX
if (!function_exists('add_web_hook_resource')) {
    function add_web_hook_resource($url, $description)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://' . get_mqtt_host() . ':' . get_app_port() . '/api/v4/resources/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                                        "type": "web_hook",
                                        "config": {
                                            "url": "' . $url . '",
                                            "headers": {"token":"' . get_api_web_token() . '"},
                                            "method": "POST"
                                        },
                                        "description": "' . $description . '"
                                    }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Basic '. get_app_key()
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
}

// Crear una regla data_to_webserver API EMQX
if (!function_exists('add_web_hook_rule')) {
    function add_web_hook_rule($type, $userMqtt, $deviceId, $resource)
    {
        $data = "";

        if ($type === "status") {
            $data = '"SELECT payload, topic FROM \\"' . $userMqtt . '/' . $deviceId . '/status\\" WHERE username = payload.username"';
        } else {
            $data = '"SELECT payload, topic FROM \\"' . $userMqtt . '/' . $deviceId . '/device\\" WHERE clientid = payload.deviceMqttId"';
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://' . get_mqtt_host() . ':' . get_app_port() . '/api/v4/rules/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "rawsql": ' . $data . ',
                "actions": [
                    {
                        "name": "data_to_webserver",
                        "params": {
                                "path": "",
                                "method": "POST",
                                "headers": {
                                    "token": "' . get_api_web_token() . '",
                                    "content-type": "application/json"
                                },
                                "body": "{ \\"payload\\": ${payload}, \\"topic\\":\\"${topic}\\", \\"token\\":\\"' . get_api_web_token() . '\\", \\"code\\": 0 }",
                                "$resource": "' . $resource . '"
                            }
                    }
                ],
                "description": "save-device-status"
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Basic ' . get_app_key()
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
}

// Quitar el Baneo por el client ID de la API EMQX 
if (!function_exists('remove_ban_deviceID')) {
    function remove_ban_deviceID($DeviceID)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://' . get_mqtt_host() . ':' . get_app_port() . '/api/v4/banned/clientid/' . $DeviceID,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic ' . get_app_key()
            ),
        ));
        curl_exec($curl);
        curl_close($curl);
    }
}

// Add Baneo por el client ID de la API EMQX 
if (!function_exists('add_ban_deviceID')) {
    function add_ban_deviceID($DeviceID)
    {
        // Instanciar 
        $ci = &get_instance();
        $date = (new DateTime('now', new DateTimeZone($ci->general_settings->timezone)))->getTimestamp(); // milisegundos Zona Horaria de la app
        $timestampSeconds = floor($date / 1000) * 86400 * 365; // segundos de un dia * 365 días // tiempo en segundos UNIX
 
        $data = '{"who":"' . $DeviceID . '","as":"clientid","reason":"admin", "until": ' . $timestampSeconds . '}';

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://' . get_mqtt_host() . ':' . get_app_port() . '/api/v4/banned',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Basic ' . get_app_key()
            ),
        ));
        curl_exec($curl);
        curl_close($curl);
    }
}

// habilitar/Deshabilitar/eliminar regla data_to_webserver API EMQX PUT|DELETE
if (!function_exists('action_web_hook_rule')) {
    function action_web_hook_rule($ruleId, $status, $method)
    {
        $data = $status ? '{"enabled": true}' : '{"enabled": false}';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://' . get_mqtt_host() . ':' . get_app_port() . '/api/v4/rules/' . $ruleId,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Basic ' . get_app_key()
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
}




// Retorna el Host MQTT
if (!function_exists('get_mqtt_host')) {
    function get_mqtt_host()
    {
        // Instanciar 
        $ci = &get_instance();
        return $ci->general_settings->mqtt_host;
    }
}

// retorna el Puerto de la APP
if (!function_exists('get_app_port')) {
    function get_app_port()
    {
        // Instanciar 
        $ci = &get_instance();
        return $ci->general_settings->emqx_AppPort;
    }
}

// retorna el token para la API Web
if (!function_exists('get_api_web_token')) {
    function get_api_web_token()
    {
        // Instanciar 
        $ci = &get_instance();
        return $ci->general_settings->emqx_ApiWebToken;
    }
}

// retorna el APP KEY Base64
if (!function_exists('get_app_key')) {
    function get_app_key()
    {
        // Instanciar 
        $ci = &get_instance();
        $AppID = $ci->general_settings->emqx_AppID;
        $AppSecret = $ci->general_settings->emqx_AppSecret;
        return base64_encode($AppID . ':' . $AppSecret);
    }
}
