<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ventas_Register_Model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Ventas_Register_Model');
    }

    private $table = 'ventas_registradas';

    public function save($data)
    {

        if ($this->db->insert('ventas_registradas', $data)) {
            return true;
        } else {
            return false;
        }
    }

    public function actualizar_venta($id, $data)
    {
        $this->db->where('id', $id);
        if ($this->db->update('ventas_registradas', $data, array('id' => $id))) {
            return true;
        } else {
            return false;
        }
    }

    //get venta
    public function get_venta()
    {
        $query = $this->db->get('ventas_registradas');
        return $query->result();
    }

    // Obtener una venta por ID
    public function get_by_id($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);
        return $query->row();
    }

    public function obtener_ventas()
    {
        $this->db->select('id, productos_vendidos, descuento, valor_total, created, vendedor_username, num_referencia');
        $this->db->order_by('created', 'DESC');
        $this->db->limit(1000); // Limitar para mejor rendimiento
        $query = $this->db->get('ventas_registradas');
        return $query->result();
    }


    public function obtener_ventas_con_productos()
    {
        $query = $this->db->get('ventas_registradas');
        $ventas = $query->result();

        foreach ($ventas as $venta) {
            $productos_vendidos_json = $venta->productos_vendidos;

            // Depuración: Verifica el contenido del JSON
            log_message('debug', 'productos_vendidos_json: ' . $productos_vendidos_json);

            // Verifica si $productos_vendidos_json es una cadena válida JSON
            if (is_string($productos_vendidos_json) && !empty($productos_vendidos_json)) {
                $productos_decoded = json_decode($productos_vendidos_json, true);

                // Verifica si json_decode devolvió un array o un objeto
                if (json_last_error() === JSON_ERROR_NONE) {
                    $venta->productos_vendidos = $productos_decoded;
                    // Depuración adicional
                    log_message('debug', 'productos_decoded: ' . print_r($productos_decoded, true));
                } else {
                    // Maneja el error de decodificación JSON
                    $venta->productos_vendidos = [];
                    log_message('error', 'Error de decodificación JSON: ' . json_last_error_msg());
                }
            } else {
                $venta->productos_vendidos = [];
            }
        }

        return $ventas;
    }


    public function ventas_vendedor_dia($vendedor_username) {
        $this->db->select('*');
        $this->db->from('ventas_registradas');
        $this->db->where('vendedor_username', $vendedor_username);
        $this->db->where('DATE(created)', date('Y-m-d'));
        $query = $this->db->get();
        return $query->result();
    }

    // Eliminar
    public function delete($id)
    {
        $venta = $this->get_by_id($id);
        if (!empty($venta)) {
            $this->db->where('id', $id);
            return $this->db->delete('ventas_registradas');
        } else {
            return false;
        }
    }

    public function obtener_ventas_filtradas($fechaInicio, $fechaFinal)
    {
        // Convertir las fechas para incluir todo el día
        $fechaInicioCompleta = $fechaInicio . ' 00:00:00';
        $fechaFinalCompleta = $fechaFinal . ' 23:59:59';
        
        $this->db->select('id, productos_vendidos, descuento, valor_total, created, vendedor_username, num_referencia');
        $this->db->where('created >=', $fechaInicioCompleta);
        $this->db->where('created <=', $fechaFinalCompleta);
        $this->db->order_by('created', 'DESC');
        $this->db->limit(1000); // Limitar para mejor rendimiento
        $query = $this->db->get('ventas_registradas');
        return $query->result();
    }

    /**
     * Obtiene todas las ventas filtradas sin límite para exportación
     */
    public function obtener_ventas_filtradas_exportacion($fechaInicio, $fechaFinal)
    {
        // Convertir las fechas para incluir todo el día
        $fechaInicioCompleta = $fechaInicio . ' 00:00:00';
        $fechaFinalCompleta = $fechaFinal . ' 23:59:59';
        
        $this->db->select('id, productos_vendidos, descuento, valor_total, created, vendedor_username, num_referencia');
        $this->db->where('created >=', $fechaInicioCompleta);
        $this->db->where('created <=', $fechaFinalCompleta);
        $this->db->order_by('created', 'DESC');
        // Sin límite para exportación completa
        $query = $this->db->get('ventas_registradas');
        return $query->result();
    }

    // data de los input de fecha
    public function input_date_values()
    {
        $data = array(
            'fechaInicio' => $this->input->post('fechaInicio', true),
            'fechaFinal' => $this->input->post('fechaFinal', true),
        );
        return $data;
    }
    // selecciona toda la data por el id con filtro de fecha inicio - final
    public function get_data_by_id_date($ventasId, $fechainicio, $fechafin)
    {
        $this->db->select("*");
        $this->db->where('ventasId', $ventasId);
        $this->db->where("created >=", $fechainicio . ' 00:00:00');
        $this->db->where("created <=", $fechafin . ' ' . date('H:i:s'));
        $this->db->from("ventas_data")->order_by('created', 'desc');
        $resultado = $this->db->get();
        return $resultado->result();
    }

    // selecciona toda la data por el id de las ultimas 24 horas
    public function get_data_by_id($ventasId)
    {
        $year = date("Y"); //Sacamos el año actual
        $mes = date("m");  //Sacamos el mes actual
        $dia = date("d");  //Sacamos el día actual
        $this->db->select("*");
        $this->db->where('ventasId', $ventasId);
        $this->db->where("created >=", $year . "-" . $mes . "-" . $dia . ' 00:00:00');
        $this->db->where("created <=", $year . '-' . $mes . '-' . $dia . ' ' . date('H:i:s'));
        $this->db->from("ventas_data")->order_by('created', 'desc');
        $resultado = $this->db->get();
        return $resultado->result();
    }

    public function get_data_by_date_range($fechaInicio, $fechaFinal)
    {
        $this->db->select("*");
        $this->db->where("created >=", $fechaInicio . ' 00:00:00');
        $this->db->where("created <=", $fechaFinal . ' ' . date('H:i:s'));
        $this->db->from("ventas_registradas")->order_by('created', 'desc');
        $resultado = $this->db->get();
        return $resultado->result();
    }
    public function contar_todas_las_ventas()
{
    return $this->db->count_all('ventas_registradas');
}

public function contar_ventas_filtradas($fechaInicio, $fechaFinal)
{
    // Convertir las fechas para incluir todo el día
    $fechaInicioCompleta = $fechaInicio . ' 00:00:00';
    $fechaFinalCompleta = $fechaFinal . ' 23:59:59';
    
    $this->db->where('created >=', $fechaInicioCompleta);
    $this->db->where('created <=', $fechaFinalCompleta);
    return $this->db->count_all_results('ventas_registradas');
}

public function obtener_ventas_paginadas($limit, $offset)
{
    $this->db->limit($limit, $offset);
    $this->db->order_by('created', 'DESC');
    return $this->db->get('ventas_registradas')->result();
}

public function obtener_ventas_filtradas_paginadas($fechaInicio, $fechaFinal, $limit, $offset)
{
    // Convertir las fechas para incluir todo el día
    $fechaInicioCompleta = $fechaInicio . ' 00:00:00';
    $fechaFinalCompleta = $fechaFinal . ' 23:59:59';
    
    $this->db->where('created >=', $fechaInicioCompleta);
    $this->db->where('created <=', $fechaFinalCompleta);
    $this->db->order_by('created', 'DESC');
    $this->db->limit($limit, $offset);
    return $this->db->get('ventas_registradas')->result();
}

    public function get_ventas_datatable($start, $length, $search, $order_column, $order_dir, $fechaInicio = null, $fechaFinal = null)
    {
        // Columnas para ordenamiento
        $columns = array(
            0 => 'productos_vendidos',
            1 => 'valor_unitario', 
            2 => 'cantidad',
            3 => 'valor_total',
            4 => 'descuento',
            5 => 'created',
            6 => 'vendedor_username',
            7 => 'num_referencia'
        );

        // Construir la consulta base
        $this->db->select('id, productos_vendidos, descuento, valor_total, created, vendedor_username, num_referencia');
        $this->db->from('ventas_registradas');

        // Aplicar filtros de fecha si existen
        if ($fechaInicio && $fechaFinal) {
            $fechaInicioCompleta = $fechaInicio . ' 00:00:00';
            $fechaFinalCompleta = $fechaFinal . ' 23:59:59';
            $this->db->where('created >=', $fechaInicioCompleta);
            $this->db->where('created <=', $fechaFinalCompleta);
        }

        // Aplicar búsqueda si existe
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('productos_vendidos', $search);
            $this->db->or_like('vendedor_username', $search);
            $this->db->or_like('num_referencia', $search);
            $this->db->or_like('created', $search);
            $this->db->group_end();
        }

        // Contar registros totales
        $total = $this->db->count_all_results('', false);

        // Aplicar ordenamiento
        if (isset($columns[$order_column])) {
            $this->db->order_by($columns[$order_column], $order_dir);
        } else {
            $this->db->order_by('created', 'DESC');
        }

        // Aplicar paginación
        $this->db->limit($length, $start);

        // Ejecutar consulta
        $query = $this->db->get();
        $data = $query->result();

        // Procesar datos para DataTable
        $processed_data = array();
        foreach ($data as $venta) {
            $productos_vendidos = json_decode($venta->productos_vendidos, true);
            if (!empty($productos_vendidos)) {
                foreach ($productos_vendidos as $producto) {
                    $nombreMostrar = isset($producto['receta_nombre']) && !empty($producto['receta_nombre'])
                        ? $producto['receta_nombre']
                        : (isset($producto['producto']) ? $producto['producto'] : '');
                    $processed_data[] = array(
                        $nombreMostrar,
                        '$' . $producto['valor_unitario'],
                        $producto['cantidad'],
                        '$' . $producto['subtotal'],
                        '$' . number_format($venta->descuento, 0),
                        $venta->created,
                        $venta->vendedor_username,
                        empty($venta->num_referencia) ? 'Efectivo' : $venta->num_referencia,
                        '<a class="btn btn-icon btn-lg btn-white btn-dim btn-outline-primary" href="' . base_url() . 'admin/ventas-detalles/' . $venta->id . '" target="_blank"><em class="icon ni ni-printer-fill"></em></a>'
                    );
                }
            }
        }

        return array(
            'total' => $total,
            'filtered' => $total,
            'data' => $processed_data
        );
    }


}
