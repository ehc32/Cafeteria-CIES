<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inventario_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Inventario_model');
        $this->load->model('inventario_comercio_model');
    }
    private $table = 'inventario';

    // Obtener todos los registros
    public function get_all()
    {
        $query = $this->db->get('inventario');
        return $query->result();
    }

    public function input_values()
    {
        $data = array(
            'nombre' => $this->input->post('nombre', true),
            'presentacion' => $this->input->post('presentacion', true),
            'cantidad' => $this->input->post('cantidad', true),
            'categoria' => $this->input->post('categoria', true),
        );
        return $data;
    }


    // Obtener un registro por ID
    public function get_by_id($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);
        return $query->row();
    }
    // add product


    public function add_product()
    {
        $data = array(
            'nombre' => $this->input->post('nombre', true),
            'presentacion' => $this->input->post('presentacion', true),
            'cantidad' => $this->input->post('cantidad', true),
            'categoria' => $this->input->post('categoria', true),
        );

        // Insertar en la base de datos
        return $this->db->insert('inventario', $data);
    }

    public function update($id, $data)
    {
        // Actualizar el registro con el ID especificado
        $this->db->where('id', $id);
        return $this->db->update('inventario', $data);
    }



    // Eliminar
    public function delete($id)
    {
        $producto = $this->get_by_id($id);
        if (!empty($producto)) {
            $this->db->where('id', $id);
            return $this->db->delete('inventario');
        } else {
            return false;
        }
    }

    // Validar los valores de presentación y categoría
    private function validate_enum($field, $value, $allowed_values)
    {
        if (!in_array($value, $allowed_values)) {
            throw new Exception("Invalid value for $field: $value");
        }
    }

    // Validar datos antes de insertar o actualizar
    public function validate_data($data)
    {
        // Validar presentación
        if (isset($data['presentacion'])) {
            $this->validate_enum('presentacion', $data['presentacion'], [
                'Unidad', 'Mililitros', 'Rollo', 'Paquete', 'Sobre', 'Gramos', 'Libras'
            ]);
        }
        // Validar categoría
        if (isset($data['categoria'])) {
            $this->validate_enum('categoria', $data['categoria'], [
                'Panaderia', 'Agroindustria', 'Materia prima', 'Insumos desechables', 'aseo y otros'
            ]);
        }
    }
}
