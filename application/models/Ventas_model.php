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

    /**
     * Mapear categorías del inventario a categorías de ventas
     * @param string $categoria_inventario Categoría del inventario
     * @return string Categoría correspondiente en ventas
     */
    private function mapear_categoria_ventas($categoria_inventario)
    {
        $mapeo = array(
            'Panaderia' => 'Panaderia',
            'Agroindustria' => 'Desayunos y Almuerzos',
            'Materia prima' => 'Desayunos y Almuerzos',
            'Insumos desechables y aseo' => 'Bebidas',
            'Otros' => 'Bebidas'
        );
        
        return isset($mapeo[$categoria_inventario]) ? $mapeo[$categoria_inventario] : 'Bebidas';
    }

    /**
     * Agregar un nuevo producto al JSON de ventas según su categoría
     * @param string $nombre_producto Nombre del producto
     * @param string $categoria Categoría del producto
     * @param float $valor_unitario Valor unitario del producto (opcional, por defecto 0)
     * @param float $descuento Descuento del producto (opcional, por defecto 0)
     * @return bool True si se actualizó correctamente, False en caso contrario
     */
    public function agregar_producto_a_ventas($nombre_producto, $categoria, $valor_unitario = 0, $descuento = 0)
    {
        try {
            // Mapear la categoría del inventario a la categoría de ventas
            $categoria_ventas = $this->mapear_categoria_ventas($categoria);
            
            // Buscar el registro de ventas que corresponda a la categoría
            $this->db->where("JSON_UNQUOTE(JSON_EXTRACT(detalles, '$.categoria')) = ", $categoria_ventas);
            $query = $this->db->get($this->table);
            $registro = $query->row();

            if (!$registro) {
                log_message('error', 'No se encontró registro de ventas para la categoría: ' . $categoria_ventas . ' (mapeada desde: ' . $categoria . ')');
                return false;
            }

            // Decodificar el JSON actual
            $detalles = json_decode($registro->detalles, true);
            
            if (!$detalles) {
                log_message('error', 'Error al decodificar JSON de ventas para categoría: ' . $categoria_ventas);
                return false;
            }

            // Verificar si el producto ya existe en la lista
            $producto_existe = false;
            foreach ($detalles['productos'] as $producto) {
                if ($producto['producto_vendido'] === $nombre_producto) {
                    $producto_existe = true;
                    break;
                }
            }

            // Si el producto no existe, agregarlo
            if (!$producto_existe) {
                $nuevo_producto = array(
                    'producto_vendido' => $nombre_producto,
                    'valor_unitario' => $valor_unitario,
                    'descuento' => $descuento
                );
                
                $detalles['productos'][] = $nuevo_producto;
                
                // Actualizar el registro en la base de datos
                $this->db->where('id', $registro->id);
                $resultado = $this->db->update($this->table, array(
                    'detalles' => json_encode($detalles)
                ));

                if ($resultado) {
                    log_message('info', 'Producto agregado exitosamente a ventas: ' . $nombre_producto . ' en categoría: ' . $categoria_ventas . ' (mapeada desde: ' . $categoria . ')');
                    return true;
                } else {
                    log_message('error', 'Error al actualizar JSON de ventas para producto: ' . $nombre_producto);
                    return false;
                }
            } else {
                log_message('info', 'El producto ya existe en ventas: ' . $nombre_producto);
                return true; // El producto ya existe, consideramos esto como éxito
            }

        } catch (Exception $e) {
            log_message('error', 'Excepción al agregar producto a ventas: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Actualizar un producto existente en el JSON de ventas
     * @param string $nombre_producto_anterior Nombre anterior del producto
     * @param string $nombre_producto_nuevo Nuevo nombre del producto
     * @param string $categoria Categoría del producto
     * @param float $valor_unitario Valor unitario del producto
     * @param float $descuento Descuento del producto
     * @return bool True si se actualizó correctamente, False en caso contrario
     */
    public function actualizar_producto_en_ventas($nombre_producto_anterior, $nombre_producto_nuevo, $categoria, $valor_unitario = 0, $descuento = 0)
    {
        try {
            // Mapear la categoría del inventario a la categoría de ventas
            $categoria_ventas = $this->mapear_categoria_ventas($categoria);
            
            // Buscar el registro de ventas que corresponda a la categoría
            $this->db->where("JSON_UNQUOTE(JSON_EXTRACT(detalles, '$.categoria')) = ", $categoria_ventas);
            $query = $this->db->get($this->table);
            $registro = $query->row();

            if (!$registro) {
                log_message('error', 'No se encontró registro de ventas para la categoría: ' . $categoria_ventas);
                return false;
            }

            // Decodificar el JSON actual
            $detalles = json_decode($registro->detalles, true);
            
            if (!$detalles) {
                log_message('error', 'Error al decodificar JSON de ventas para categoría: ' . $categoria_ventas);
                return false;
            }

            // Buscar y actualizar el producto
            $producto_encontrado = false;
            foreach ($detalles['productos'] as &$producto) {
                if ($producto['producto_vendido'] === $nombre_producto_anterior) {
                    $producto['producto_vendido'] = $nombre_producto_nuevo;
                    $producto['valor_unitario'] = $valor_unitario;
                    $producto['descuento'] = $descuento;
                    $producto_encontrado = true;
                    break;
                }
            }

            if ($producto_encontrado) {
                // Actualizar el registro en la base de datos
                $this->db->where('id', $registro->id);
                $resultado = $this->db->update($this->table, array(
                    'detalles' => json_encode($detalles)
                ));

                if ($resultado) {
                    log_message('info', 'Producto actualizado exitosamente en ventas: ' . $nombre_producto_anterior . ' -> ' . $nombre_producto_nuevo);
                    return true;
                } else {
                    log_message('error', 'Error al actualizar JSON de ventas para producto: ' . $nombre_producto_anterior);
                    return false;
                }
            } else {
                log_message('warning', 'Producto no encontrado en ventas para actualizar: ' . $nombre_producto_anterior);
                return false;
            }

        } catch (Exception $e) {
            log_message('error', 'Excepción al actualizar producto en ventas: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Eliminar un producto del JSON de ventas
     * @param string $nombre_producto Nombre del producto a eliminar
     * @param string $categoria Categoría del producto
     * @return bool True si se eliminó correctamente, False en caso contrario
     */
    public function eliminar_producto_de_ventas($nombre_producto, $categoria)
    {
        try {
            // Mapear la categoría del inventario a la categoría de ventas
            $categoria_ventas = $this->mapear_categoria_ventas($categoria);
            
            // Buscar el registro de ventas que corresponda a la categoría
            $this->db->where("JSON_UNQUOTE(JSON_EXTRACT(detalles, '$.categoria')) = ", $categoria_ventas);
            $query = $this->db->get($this->table);
            $registro = $query->row();

            if (!$registro) {
                log_message('error', 'No se encontró registro de ventas para la categoría: ' . $categoria_ventas);
                return false;
            }

            // Decodificar el JSON actual
            $detalles = json_decode($registro->detalles, true);
            
            if (!$detalles) {
                log_message('error', 'Error al decodificar JSON de ventas para categoría: ' . $categoria_ventas);
                return false;
            }

            // Buscar y eliminar el producto
            $producto_encontrado = false;
            $productos_filtrados = array();
            
            foreach ($detalles['productos'] as $producto) {
                if ($producto['producto_vendido'] !== $nombre_producto) {
                    $productos_filtrados[] = $producto;
                } else {
                    $producto_encontrado = true;
                }
            }

            if ($producto_encontrado) {
                $detalles['productos'] = $productos_filtrados;
                
                // Actualizar el registro en la base de datos
                $this->db->where('id', $registro->id);
                $resultado = $this->db->update($this->table, array(
                    'detalles' => json_encode($detalles)
                ));

                if ($resultado) {
                    log_message('info', 'Producto eliminado exitosamente de ventas: ' . $nombre_producto);
                    return true;
                } else {
                    log_message('error', 'Error al eliminar producto de ventas: ' . $nombre_producto);
                    return false;
                }
            } else {
                log_message('warning', 'Producto no encontrado en ventas para eliminar: ' . $nombre_producto);
                return false;
            }

        } catch (Exception $e) {
            log_message('error', 'Excepción al eliminar producto de ventas: ' . $e->getMessage());
            return false;
        }
    }

}
