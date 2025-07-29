<?php defined('BASEPATH') OR exit('No direct script access allowed');

$config['num_links'] = 5;
$config['use_page_numbers'] = TRUE;
$config['page_query_string'] = TRUE;
$config['query_string_segment'] = 'page';

// primero
$config['first_tag_open'] = '<li class="page-item">';
$config['first_link'] = 'Primera';
$config['first_tag_close'] = '</li>';
// ultimo
$config['last_tag_open'] = '<li class="page-item">';
$config['last_link'] = 'Última';
$config['last_tag_close'] = '</li>';
// Regresar
$config['prev_tag_open'] = '<li class="page-item">';
$config['prev_link'] = '<em class="icon ni ni-caret-left"></em>';
$config['prev_tag_close'] = '</li>';
// Siguiente
$config['next_tag_open'] = '<li class="page-item">';
$config['next_link'] = '<em class="icon ni ni-caret-right"></em>';
$config['next_tag_close'] = '</li>';
// enlace activo
$config['cur_tag_open'] = '<li class="page-item active">';
$config['cur_tag_close'] = '</li>';
// Digitos
$config['num_tag_open'] = '<li class="page-item">';
$config['num_tag_close'] = '</li>';

