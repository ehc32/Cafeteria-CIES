<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inventario_comercio_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Inventario_comercio_model');
    }
    private $table = 'inventario_comercio';

    // Obtener todos los registros
    public function get_all()
    {
        $query = $this->db->get('inventario_comercio');
        return $query->result();
    }

    public function input_values()
    {
        $data = array(
            'nombre' => $this->input->post('nombre', true),
            'presentacion' => $this->input->post('presentacion', true),
            'cantidad' => $this->input->post('cantidad', true),
            'categoria' => $this->input->post('categoria', true),
            'valor_unitario' => $this->input->post('valor_unitario', true) ? floatval($this->input->post('valor_unitario', true)) : 0,
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
    public function add_product($valor_unitario = 0)
    {
        $data = array(
            'nombre' => $this->input->post('nombre', true),
            'presentacion' => $this->input->post('presentacion', true),
            'cantidad' => $this->input->post('cantidad', true),
            'categoria' => $this->input->post('categoria', true),
            'valor_unitario' => $this->input->post('valor_unitario', true) ? floatval($this->input->post('valor_unitario', true)) : 0,
        );

        // Insertar en la base de datos
        $result = $this->db->insert('inventario_comercio', $data);
        
        // Si la inserción fue exitosa, agregar el producto al JSON de ventas
        if ($result) {
            $this->load->model('Ventas_model');
            $this->Ventas_model->agregar_producto_a_ventas(
                $data['nombre'], 
                $data['categoria'],
                $data['valor_unitario']
            );
        }
        
        return $result;
    }

    public function update($id, $data)
    {
        // Obtener el producto actual antes de actualizarlo
        $producto_actual = $this->get_by_id($id);
        
        // Actualizar el registro con el ID especificado
        $this->db->where('id', $id);
        $result = $this->db->update('inventario_comercio', $data);
        
        // Si la actualización fue exitosa y el nombre o categoría cambió, actualizar en ventas
        if ($result && $producto_actual) {
            $nombre_cambio = ($producto_actual->nombre !== $data['nombre']);
            $categoria_cambio = ($producto_actual->categoria !== $data['categoria']);
            $valor_cambio = ($producto_actual->valor_unitario != $data['valor_unitario']);
            
            if ($nombre_cambio || $categoria_cambio || $valor_cambio) {
                $this->load->model('Ventas_model');
                $this->Ventas_model->actualizar_producto_en_ventas(
                    $producto_actual->nombre,
                    $data['nombre'],
                    $data['categoria'],
                    $data['valor_unitario']
                );
            }
        }
        
        return $result;
    }



    // Eliminar
    public function delete($id)
    {
        $producto = $this->get_by_id($id);
        if (!empty($producto)) {
            $this->db->where('id', $id);
            $result = $this->db->delete('inventario_comercio');
            
            // Si la eliminación fue exitosa, eliminar también de ventas
            if ($result) {
                $this->load->model('Ventas_model');
                $this->Ventas_model->eliminar_producto_de_ventas(
                    $producto->nombre,
                    $producto->categoria
                );
            }
            
            return $result;
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
