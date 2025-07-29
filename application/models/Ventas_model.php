<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ventas_model extends CI_Model
{
    private $table = 'ventas';

    public function __construct()
    {
        parent::__construct();
    }

    // Obtener todos los productos de todas las categorías
    public function get_productos()
    {
        $this->db->select('JSON_UNQUOTE(JSON_EXTRACT(detalles, "$.productos[*].producto_vendido")) AS producto_vendido, JSON_UNQUOTE(JSON_EXTRACT(detalles, "$.categoria")) AS categoria');
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query->result();
    }

    // Obtener todas las categorías
    public function get_categorias()
    {
        $this->db->select('DISTINCT JSON_UNQUOTE(JSON_EXTRACT(detalles, "$.categoria")) AS categoria');
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query->result();
    }

    // Obtener productos por categoría
    public function get_productos_por_categoria($categoria)
    {
        $this->db->select('JSON_UNQUOTE(JSON_EXTRACT(detalles, "$.productos[*].producto_vendido")) AS producto_vendido');
        $this->db->from($this->table);
        $this->db->where("JSON_UNQUOTE(JSON_EXTRACT(detalles, '$.categoria')) = '$categoria'");
        $query = $this->db->get();
        return $query->result();
    }

    public function productos_por_categoria($categoria)
    {
        $this->db->where("JSON_UNQUOTE(JSON_EXTRACT(detalles, '$.categoria')) = ", $categoria);
        $query = $this->db->get('ventas');
        return $query->result();
    }

}
