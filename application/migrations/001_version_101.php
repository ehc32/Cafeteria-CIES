<?php

defined('BASEPATH') or exit('No direct script access allowed');
// Versión 1.0.1
class Migration_Version_101 extends CI_Migration
{

    public function up()
    {
        // Inicio tabla Usuario
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'username' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'unique' => TRUE,
                'null' => FALSE,
            ),
            'email' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'unique' => TRUE,
                'null' => FALSE,
            ),
            'fullname' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE,
            ),
            'photo' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE,
            ),
            'phone' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE,
            ),
            'password' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE,
            ),
            'token' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE,
            ),
            'salt' => array(
                'type' => 'VARCHAR',
                'constraint' => '35',
                'null' => TRUE,
            ),
            'is_superuser' => array(
                'type' => 'TINYINT',
                'constraint' => '1',
                'default' => 0
            ),
            'slug' => array(
                'type' => 'VARCHAR', 
                'constraint' => '255',
                'null' => TRUE,
            ),
            'status' => array(
                'type' => 'TINYINT',
                'constraint' => '1',
                'null' => FALSE,
                'default' => 1
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        // CREAR EL CAMPO CREATED LASTSEEN DEFAULT DATETIME
        $this->dbforge->add_field('last_seen datetime NOT NULL default current_timestamp');
        $this->dbforge->add_field('created datetime NOT NULL default current_timestamp');
        // creando la tabla
        $this->dbforge->create_table('users', TRUE);
        // Insertar datos
        $data = array(
            array(
                'username' => 'administrador',
                'email' => 'admin@gmail.com',
                'fullname' => 'Administrador',
                'photo' => NULL,
                'phone' => NULL,
                'password' => 'efa1f375d76194fa51a3556a97e641e61685f914d446979da50a551a4333ffd7', //public
                'token' => '64af7ac3e42589-09690413-51249864',
                'salt' => NULL,
                'is_superuser' => 1,
                'slug' => 'administrador',
                'status' => 1,
            ),
        );
        $this->db->insert_batch('users', $data);
        // Fin Tabla Usuarios


        // Tabla de configuraciones generales (general_settings)
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'dark_mode' => array(
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => FALSE,
                'default' => 0
            ),
            'timezone' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE,
                'default' => 'America/Bogota'
            ),
            'logo_path' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE
            ),
            'favicon_path' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE
            ),
            'mail_library' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE
            ),
            'mail_protocol' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE,
                'default' => 'smtp'
            ),
            'mail_host' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE,
            ),
            'mail_port' => array(
                'type' => 'VARCHAR',
                'constraint' => '10',
                'null' => FALSE,
                'default' => '587'
            ),
            'mail_username' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE,
            ),
            'mail_password' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE,
            ),
            'mail_title' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE,
            ),
            'send_email_messages' => array(
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => FALSE,
                'default' => 0
            ),
            'registration_system' => array(
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => FALSE,
                'default' => 1
            ),
            'recaptcha_site_key' => array(
                'type' => 'VARCHAR',
                'constraint' => '500',
                'null' => TRUE
            ),
            'recaptcha_secret_key' => array(
                'type' => 'VARCHAR',
                'constraint' => '500',
                'null' => TRUE
            ),
            'custom_css_codes' => array(
                'type' => 'MEDIUMTEXT',
                'null' => TRUE
            ),
            'custom_javascript_codes' => array(
                'type' => 'MEDIUMTEXT',
                'null' => TRUE
            ),
            'maintenance_mode_title' => array(
                'type' => 'TEXT',
                'null' => TRUE,
            ),
            'maintenance_mode_description' => array(
                'type' => 'MEDIUMTEXT',
                'null' => TRUE,
            ),
            'maintenance_mode_status' => array(
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => FALSE,
                'default' => 0
            ),
            'version' => array(
                'type' => 'VARCHAR',
                'constraint' => '10',
                'null' => FALSE,
                'default' => '1.0.1'
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('general_settings', TRUE);
        // Insertar data a la data
        $data = array(
            'dark_mode' => 0,
            'timezone' => 'America/Bogota',
            'logo_path' => NULL,
            'favicon_path' => NULL,
            'mail_library' => NULL,
            'mail_protocol' => 'smtp',
            'mail_host' => NULL,
            'mail_port' => '587',
            'mail_username' => NULL,
            'mail_password' => NULL,
            'mail_title' => NULL,
            'send_email_messages' => 0,
            'registration_system' => 1,
            'recaptcha_site_key' => NULL,
            'recaptcha_secret_key' => NULL,
            'custom_css_codes' => NULL,
            'custom_javascript_codes' => NULL,
            'maintenance_mode_title' => NULL,
            'maintenance_mode_description' => NULL,
            'maintenance_mode_status' => 0,
            'version' => '1.0.1',
        );
        $this->db->insert('general_settings', $data);
        // Fin tabla de configuraciones generales

  

        // Tabla de configuraciones (settings)
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'application_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE,
            ),
            'site_description' => array(
                'type' => 'VARCHAR',
                'constraint' => '500',
                'null' => TRUE,
            ),
            'keywords' => array(
                'type' => 'VARCHAR',
                'constraint' => '500',
                'null' => TRUE,
            ),
            'facebook_url' => array(
                'type' => 'VARCHAR',
                'constraint' => '500',
                'null' => TRUE,
            ),
            'twitter_url' => array(
                'type' => 'VARCHAR',
                'constraint' => '500',
                'null' => TRUE,
            ),
            'youtube_url' => array(
                'type' => 'VARCHAR',
                'constraint' => '500',
                'null' => TRUE,
            ),
            'contact_address' => array(
                'type' => 'VARCHAR',
                'constraint' => '500',
                'null' => TRUE,
            ),
            'contact_email' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE,
            ),
            'contact_phone' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE,
            ),
            'copyright' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE,
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('settings', TRUE);
        // Insertar data a la data
        $data = array(
            'application_name' => 'Cafeteria v1.0.1',
            'site_description' => 'Aplicación POS cafeteria',
            'keywords' => 'SENA, Servicios Tecnologicos, CIES',
            'facebook_url' => NULL,
            'twitter_url' => NULL,
            'youtube_url' => NULL,
            'contact_address' => NULL,
            'contact_email' => NULL,
            'contact_phone' => NULL,
            'copyright' => 'SENA. Todos los derechos reservados.'
        );
        $this->db->insert('settings', $data);
        // Fin de tabla de configuraciones


        // Tabla de sesiones (ci_sessions)
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'VARCHAR',
                'constraint' => '40',
                'null' => FALSE,
            ),
            'ip_address' => array(
                'type' => 'VARCHAR',
                'constraint' => '45',
                'null' => FALSE,
            ),
            'timestamp' => array(
                'type' => 'INT',
                'constraint' => '10',
                'unsigned' => TRUE,
                'null' => FALSE,
                'default' => 0
            ),
            'data' => array(
                'type' => 'BLOB',
                'null' => FALSE,
            )
        ));
        $this->dbforge->add_field('INDEX (timestamp)');
        $this->dbforge->create_table('ci_sessions', TRUE);
        // Fin de tabla sesiones

    }

    public function down() // MIGRACIÓN 0 
    {
        //  $this->dbforge->drop_table('nombre de tabla');
        $data = array(
            'general_settings',
            'settings',
            'users',
        );

        foreach ($data as $table) {
            $this->dbforge->drop_table($table);
        }
    }
}
