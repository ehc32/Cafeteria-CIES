<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Recetas_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private $table = 'recetas';
    private $table_ingredientes = 'ingredientes';

    // Obtener todas las recetas
    public function get_all()
    {
        $this->db->order_by('nombre', 'ASC');
        $query = $this->db->get($this->table);
        return $query->result();
    }

    // Obtener receta por ID
    public function get_by_id($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);
        return $query->row();
    }

    // Obtener receta por nombre (exacto)
    public function get_by_nombre($nombre)
    {
        $this->db->where('nombre', $nombre);
        $query = $this->db->get($this->table);
        return $query->row();
    }

    // Obtener receta completa por nombre (incluye ingredientes)
    public function get_receta_completa_por_nombre($nombre)
    {
        $receta = $this->get_by_nombre($nombre);
        if ($receta) {
            $receta->ingredientes = $this->get_ingredientes_by_receta($receta->id);
        }
        return $receta;
    }

    // Obtener recetas que usan un producto del inventario por su nombre
    public function get_recetas_by_producto_nombre($producto_nombre)
    {
        $this->db->distinct();
        $this->db->select('recetas.id, recetas.nombre, recetas.costo_por_porcion');
        $this->db->from($this->table_ingredientes);
        $this->db->join('inventario', 'inventario.id = ingredientes.producto_id');
        $this->db->join($this->table, 'recetas.id = ingredientes.receta_id');
        $this->db->where('inventario.nombre', $producto_nombre);
        $query = $this->db->get();
        return $query->result();
    }

    // Obtener recetas que usan un producto por ID de inventario
    public function get_recetas_by_producto_id($producto_id)
    {
        $this->db->distinct();
        $this->db->select('recetas.id, recetas.nombre, recetas.costo_por_porcion');
        $this->db->from($this->table_ingredientes);
        $this->db->join($this->table, 'recetas.id = ingredientes.receta_id');
        $this->db->where('ingredientes.producto_id', $producto_id);
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Verifica si hay stock suficiente para preparar una receta una cantidad dada
     */
    public function verificar_disponibilidad_receta($receta_id, $cantidad_preparada)
    {
        $ingredientes = $this->get_ingredientes_by_receta($receta_id);
        foreach ($ingredientes as $ingrediente) {
            // Leer stock actual del producto
            $this->db->select('cantidad');
            $this->db->where('id', $ingrediente->producto_id);
            $producto = $this->db->get('inventario')->row();
            $stock_actual = $producto ? (float)$producto->cantidad : 0;
            $requerido = (float)$ingrediente->cantidad * (float)$cantidad_preparada;
            if ($stock_actual < $requerido) {
                return false;
            }
        }
        return true;
    }

    /**
     * Descuenta del inventario los ingredientes para una receta y cantidad dadas.
     * Debe ejecutarse dentro de una transacción si se procesa junto a una venta.
     * Retorna true si todos los descuentos se aplicaron; false si alguno falla.
     */
    public function descontar_inventario_por_receta($receta_id, $cantidad_preparada)
    {
        $ingredientes = $this->get_ingredientes_by_receta($receta_id);
        foreach ($ingredientes as $ingrediente) {
            $cantidad_a_descontar = (float)$ingrediente->cantidad * (float)$cantidad_preparada;
            $this->db->set('cantidad', 'cantidad - ' . $cantidad_a_descontar, false);
            $this->db->where('id', $ingrediente->producto_id);
            $this->db->where('cantidad >=', $cantidad_a_descontar);
            $this->db->update('inventario');
            if ($this->db->affected_rows() == 0) {
                return false;
            }
        }
        return true;
    }

    // Obtener receta con ingredientes
    public function get_receta_completa($id)
    {
        $receta = $this->get_by_id($id);
        if ($receta) {
            $receta->ingredientes = $this->get_ingredientes_by_receta($id);
        }
        return $receta;
    }

    // Obtener ingredientes de una receta
    public function get_ingredientes_by_receta($receta_id)
    {
        $this->db->select('ingredientes.*, inventario.nombre as producto_nombre, inventario.presentacion');
        $this->db->from($this->table_ingredientes);
        // Usar LEFT JOIN para que ingredientes sin relación en inventario también aparezcan
        $this->db->join('inventario', 'inventario.id = ingredientes.producto_id', 'left');
        $this->db->where('ingredientes.receta_id', $receta_id);
        $query = $this->db->get();
        return $query->result();
    }

    // Agregar receta
    public function add_receta()
    {
        $data = array(
            'nombre' => $this->input->post('nombre', true),
            'descripcion' => $this->input->post('descripcion', true),
            'numero_receta' => $this->input->post('numero_receta', true),
            'numero_porciones' => $this->input->post('numero_porciones', true),
            // Margen por defecto 5%
            'margen_variacion' => $this->input->post('margen_variacion', true) !== null && $this->input->post('margen_variacion', true) !== ''
                ? $this->input->post('margen_variacion', true)
                : 5,
            'costo_total_ingredientes' => 0, // Se calculará después
            'costo_total_preparacion' => 0,
            'costo_por_porcion' => 0
        );

        $this->db->trans_start();
        
        // Insertar receta
        $this->db->insert($this->table, $data);
        $receta_id = $this->db->insert_id();

        // Insertar ingredientes si existen
        $ingredientes = $this->input->post('ingredientes', true);
        if (!empty($ingredientes)) {
            $this->add_ingredientes($receta_id, $ingredientes);
        }

        // Recalcular costos
        $this->recalcular_costos($receta_id);

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    // Actualizar receta
    public function update_receta($id)
    {
        $data = array(
            'nombre' => $this->input->post('nombre', true),
            'descripcion' => $this->input->post('descripcion', true),
            'numero_receta' => $this->input->post('numero_receta', true),
            'numero_porciones' => $this->input->post('numero_porciones', true),
            // Margen por defecto 5%
            'margen_variacion' => $this->input->post('margen_variacion', true) !== null && $this->input->post('margen_variacion', true) !== ''
                ? $this->input->post('margen_variacion', true)
                : 5
        );

        $this->db->trans_start();
        
        // Actualizar receta
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);

        // Eliminar ingredientes anteriores
        $this->db->where('receta_id', $id);
        $this->db->delete($this->table_ingredientes);

        // Insertar nuevos ingredientes
        $ingredientes = $this->input->post('ingredientes', true);
        if (!empty($ingredientes)) {
            $this->add_ingredientes($id, $ingredientes);
        }

        // Recalcular costos
        $this->recalcular_costos($id);

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    // Agregar ingredientes a una receta
    private function add_ingredientes($receta_id, $ingredientes)
    {
        foreach ($ingredientes as $ingrediente) {
            if (!empty($ingrediente['producto_id']) && !empty($ingrediente['cantidad'])) {
                // Preferir valor_unitario enviado desde el formulario (catálogo ventas) si existe
                $valor_unitario_form = isset($ingrediente['valor_unitario']) ? (float) $ingrediente['valor_unitario'] : null;
                if ($valor_unitario_form !== null && $valor_unitario_form > 0) {
                    $valor_unitario = $valor_unitario_form;
                } else {
                    // Obtener información del producto desde inventario como respaldo
                    $this->db->select('valor_unitario');
                    $this->db->from('inventario');
                    $this->db->where('id', $ingrediente['producto_id']);
                    $producto = $this->db->get()->row();
                    $valor_unitario = $producto ? (float) $producto->valor_unitario : 0;
                }
                $valor_total = $valor_unitario * $ingrediente['cantidad'];

                $data_ingrediente = array(
                    'receta_id' => $receta_id,
                    'producto_id' => $ingrediente['producto_id'],
                    'cantidad' => $ingrediente['cantidad'],
                    'unidad' => $ingrediente['unidad'] ?? '',
                    'valor_unitario' => $valor_unitario,
                    'valor_total' => $valor_total
                );
                
                $this->db->insert($this->table_ingredientes, $data_ingrediente);
            }
        }
    }

    // Recalcular costos de una receta
    public function recalcular_costos($receta_id)
    {
        // Obtener suma de valores totales de ingredientes
        $this->db->select_sum('valor_total');
        $this->db->where('receta_id', $receta_id);
        $query = $this->db->get($this->table_ingredientes);
        $result = $query->row();
        $costo_total_ingredientes = $result->valor_total ?: 0;

        // Obtener datos de la receta
        $receta = $this->get_by_id($receta_id);
        $margen_variacion = $receta->margen_variacion ?: 0;
        $numero_porciones = $receta->numero_porciones ?: 1;

        // Calcular costos (margen como monto y suma al costo de ingredientes)
        $monto_margen = $costo_total_ingredientes * ($margen_variacion / 100);
        $costo_total_preparacion = $costo_total_ingredientes + $monto_margen;
        $costo_por_porcion = $numero_porciones > 0 ? $costo_total_preparacion / $numero_porciones : 0;

        // Actualizar receta con costos calculados
        $data = array(
            'costo_total_ingredientes' => $costo_total_ingredientes,
            'costo_total_preparacion' => $costo_total_preparacion,
            'costo_por_porcion' => $costo_por_porcion
        );

        $this->db->where('id', $receta_id);
        $this->db->update($this->table, $data);
    }

    // Eliminar receta
    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    // Buscar recetas
    public function search($term)
    {
        $this->db->like('nombre', $term);
        $this->db->or_like('descripcion', $term);
        $this->db->or_like('numero_receta', $term);
        $query = $this->db->get($this->table);
        return $query->result();
    }

    // Obtener productos disponibles del inventario
    public function get_productos_inventario()
    {
        $this->db->select('id, nombre, presentacion, valor_unitario, categoria');
        $this->db->from('inventario');
        $this->db->where('cantidad >', 0);
        $this->db->order_by('nombre', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    // Verificar si un producto está siendo usado en alguna receta
    public function producto_en_uso($producto_id)
    {
        $this->db->where('producto_id', $producto_id);
        $query = $this->db->get($this->table_ingredientes);
        return $query->num_rows() > 0;
    }

    // Obtener recetas por categoría de producto
    public function get_recetas_by_categoria($categoria)
    {
        $this->db->distinct();
        $this->db->select('recetas.*');
        $this->db->from($this->table);
        $this->db->join($this->table_ingredientes, 'ingredientes.receta_id = recetas.id');
        $this->db->join('inventario', 'inventario.id = ingredientes.producto_id');
        $this->db->where('inventario.categoria', $categoria);
        $query = $this->db->get();
        return $query->result();
    }

    // Duplicar receta
    public function duplicar_receta($id)
    {
        $this->db->trans_start();
        
        // Obtener receta original
        $receta = $this->get_by_id($id);
        if (!$receta) {
            return false;
        }

        // Preparar datos para nueva receta
        $nueva_receta = (array) $receta;
        unset($nueva_receta['id']);
        $nueva_receta['nombre'] = $nueva_receta['nombre'] . ' (Copia)';
        $nueva_receta['numero_receta'] = $nueva_receta['numero_receta'] . '-COPIA';
        
        // Insertar nueva receta
        $this->db->insert($this->table, $nueva_receta);
        $nueva_receta_id = $this->db->insert_id();

        // Copiar ingredientes
        $ingredientes = $this->get_ingredientes_by_receta($id);
        foreach ($ingredientes as $ingrediente) {
            $nuevo_ingrediente = array(
                'receta_id' => $nueva_receta_id,
                'producto_id' => $ingrediente->producto_id,
                'cantidad' => $ingrediente->cantidad,
                'unidad' => $ingrediente->unidad,
                'valor_unitario' => $ingrediente->valor_unitario,
                'valor_total' => $ingrediente->valor_total
            );
            $this->db->insert($this->table_ingredientes, $nuevo_ingrediente);
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    // Actualizar costos cuando cambia el precio en inventario
    public function actualizar_costos_por_producto($producto_id, $nuevo_valor_unitario)
    {
        // Obtener todas las recetas que usan este producto
        $this->db->select('DISTINCT(receta_id)');
        $this->db->where('producto_id', $producto_id);
        $query = $this->db->get($this->table_ingredientes);
        $recetas = $query->result();

        foreach ($recetas as $receta) {
            // Actualizar valor unitario y total en ingredientes
            $this->db->select('cantidad');
            $this->db->where('receta_id', $receta->receta_id);
            $this->db->where('producto_id', $producto_id);
            $ing_query = $this->db->get($this->table_ingredientes);
            $ingrediente = $ing_query->row();

            if ($ingrediente) {
                $nuevo_valor_total = $ingrediente->cantidad * $nuevo_valor_unitario;
                
                $this->db->where('receta_id', $receta->receta_id);
                $this->db->where('producto_id', $producto_id);
                $this->db->update($this->table_ingredientes, array(
                    'valor_unitario' => $nuevo_valor_unitario,
                    'valor_total' => $nuevo_valor_total
                ));
            }

            // Recalcular costos de la receta
            $this->recalcular_costos($receta->receta_id);
        }
    }

    // Obtener estadísticas de recetas
    public function get_estadisticas()
    {
        $stats = array();
        
        // Total de recetas
        $stats['total_recetas'] = $this->db->count_all($this->table);
        
        // Promedio de ingredientes por receta
        $this->db->select('COUNT(*) / COUNT(DISTINCT receta_id) as promedio');
        $query = $this->db->get($this->table_ingredientes);
        $result = $query->row();
        $stats['promedio_ingredientes'] = round($result->promedio, 2);
        
        // Receta más costosa
        $this->db->select('nombre, costo_total_preparacion');
        $this->db->order_by('costo_total_preparacion', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        $stats['receta_mas_costosa'] = $query->row();
        
        // Receta más económica
        $this->db->select('nombre, costo_total_preparacion');
        $this->db->where('costo_total_preparacion >', 0);
        $this->db->order_by('costo_total_preparacion', 'ASC');
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        $stats['receta_mas_economica'] = $query->row();
        
        return $stats;
    }
}