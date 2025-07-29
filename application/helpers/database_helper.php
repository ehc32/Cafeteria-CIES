<?php

defined('BASEPATH') or exit('No direct script access allowed');

// almacenar logs de actividad
function log_activity($description, $type = 'unknow', $userid = null)
{
    $CI = &get_instance();

    $log = [
        'description' => $description,
        'date'        => date('Y-m-d H:i:s'),
        'type'        => $type,
    ];

    if ($userid != null && is_numeric($userid)) {
        $log['userFullname'] = $CI->Users_model->get_user_fullname($userid);
        $log['userId'] = $userid;
    } else {
        $log['userFullname'] = $CI->Users_model->get_user_username();
        $log['userid'] = $CI->Users_model->get_user_id();
    }

    $CI->db->insert('activity_log', $log);
}

// ultimos eventos
function get_activity_logs($username, $fullname, $limit)
{
    $CI  = &get_instance();
    $CI->db->select('*');
    $CI->db->order_by('id', 'desc');
    // si es super admin mostrar todos
    if ($CI->session->userdata("is_superuser") !== "1") {
        $CI->db->like('userFullname', $username, 'before');
        $CI->db->or_like('userFullname', $fullname, 'before');
    }
    $CI->db->limit($limit);
    return $CI->db->get('activity_log')->result();
}


// realizar conteo
function get_total_by_type_table($type, $table)
{
    $CI  = &get_instance();
    $userid = $CI->session->userdata("id");

    $CI->db->select('*');
    // el Where primero a los LIKE
    $CI->db->where('type', $type);
    // si es super admin mostrar todos
    if ($CI->session->userdata("is_superuser") !== "1") {
        $CI->db->where('userid', $userid);
    }

    $query = $CI->db->get($table);

    if ($query->num_rows() > 0) {
        return $query->num_rows();
    }

    return 0;
}
// registro totales
function get_total_by_table($table, $type = 'all')
{
    $CI  = &get_instance();
    $userid = $CI->session->userdata("id");
    $CI->db->select('*');
    // si es diferente a all aplico el filtro
    if ($type !== 'all') $CI->db->where('type', $type);
    // si no es super usuario
    if ($CI->session->userdata("is_superuser") !== "1") {
        $CI->db->where('userid', $userid);
    }
    $query = $CI->db->get($table);
    if ($query->num_rows() > 0) {
        return $query->num_rows();
    }
    return 0;
}

// capturar los registros
function get_current_page_records_by_table($limit, $start, $table, $type = 'all')
{
    $CI  = &get_instance();
    $userid = $CI->session->userdata("id");

    $CI->db->select('*');
    // si es diferente a all aplico el filtro
    if ($type != 'all') $CI->db->where('type', $type);
    // si no es super admin
    if ($CI->session->userdata("is_superuser") !== "1") {
        $CI->db->where('userid', $userid);
    }

    $CI->db->order_by('id', 'desc');
    // paginación  10 0
    $CI->db->limit($limit, $start);

    $query = $CI->db->get($table);

    if ($query->num_rows() > 0) {
        foreach ($query->result() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    return false;
}

// eliminar un dato por id y por tabla
function delete_element_by_table($id, $table)
{
    $CI  = &get_instance();
    $CI->db->where('id', $id);
    return $CI->db->delete($table);
}
// limpiar la data de una tabla
function clear_data_by_table($table)
{
    $CI  = &get_instance();
    if ($CI->db->empty_table($table)) {
        return true;
    } else {
        return false;
    } 
}
