<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migrate extends CI_Controller
{
    public function index()
    {
        if ($_ENV['DB_MIGRATIONS'] == 'true') {

            $this->load->library('migration');

            if ($this->migration->current() === FALSE) {
                show_error($this->migration->error_string());
            }else{
                echo "Migrations executed - ";
                $this->env();
            }

        } else {
            echo "Migrations not permitted";
        }
    }

    public function env(){
        $fh = fopen(__DIR__ . "/../../.env", 'w') or die("An error occurred while creating the file .env");
        // Crear el nuevo archivo .env
        $texto = <<<_END
        # Database Configuration
        DB_HOSTNAME="localhost"
        DB_PORT="4002"
        DB_USERNAME="administrador"
        DB_PASSWORD="public"
        DB_DATABASE="app_cafeteria"
        DB_DRIVER="mysqli"
        
        DB_MIGRATIONS=false
        _END;

        fwrite($fh, $texto) or die("Could not write to file .env");

        fclose($fh);

        echo "The .env file has been written without problems";
    }


}
