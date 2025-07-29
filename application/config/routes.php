<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller']   = 'auth_controller/cargar_login';
$route['404_override']         = 'admin_controller/error404';
$route['translate_uri_dashes'] = FALSE;
$route['error-404']            = 'admin_controller/error404';

//Auth
$route['inicio-sesion']         = 'auth_controller/cargar_login';
$route['login']['POST']         = 'auth_controller/login';
$route['logout']                = 'auth_controller/logout';
$route['register']              = 'auth_controller/register';
$route['forgot-password']       = 'auth_controller/forgot_password';
$route['reset-password']        = 'auth_controller/reset_password';

// Admin
$route['admin/inicio']                  = 'admin_controller/inicio';
$route['admin/inicio']                  = 'admin_controller';
$route['admin/activity-logs']['GET']       = 'admin_controller/activity_logs';

// Usuarios
$route['admin/user-profile/(:num)']   = 'users_controller/profile/$1';
$route['admin/user-add']['GET']       = 'users_controller/add_user';
$route['admin/users']['GET']          = 'users_controller/users';
$route['admin/users/delete/(:any)']['POST'] = 'users_controller/delete/$1';


//Settings
$route['admin/settings']['GET']           = 'settings_controller';
$route['admin/email-settings']['GET']     = 'email_controller';



// Inventario 
$route['admin/inventario']['GET']             = 'inventario_controller/inventario'; 
$route['admin/inventario-comercio']['GET']             = 'inventario__comercio_controller/inventario';
$route['admin/inventario/create']['GET']      = 'inventario_controller/create';    
$route['admin/inventario/create']['POST']     = 'inventario_controller/create';     
$route['admin/inventario/edit/(:num)']['GET'] = 'inventario_controller/edit/$id'; 
$route['admin/inventario/edit/(:num)']['POST'] = 'inventario_controller/edit/$id';  
$route['admin/inventario/delete/(:num)']['POST'] = 'inventario_controller/delete/$id';

$route['admin/inventario/create']['GET']      = 'inventario_comercio_controller/create';    
$route['admin/inventario/create']['POST']     = 'inventario_comercio_controller/create';     
$route['admin/inventario/edit/(:num)']['GET'] = 'inventario_comercio_controller/edit/$id'; 
$route['admin/inventario/edit/(:num)']['POST'] = 'inventario_comercio_controller/edit/$id';  
$route['admin/inventario/delete/(:num)']['POST'] = 'inventario_comercio_controller/delete/$id';




$route['admin/ventas']['GET']           = 'Ventas_register_controller/listar_ventas';
$route['admin/ventas/(:num)']['GET']      = 'Ventas_register_controller/listar_ventas/$1';
$route['admin/ventas/cargar_ventas_ajax']['GET'] = 'Ventas_register_controller/cargar_ventas_ajax';
$route['admin/ventas/get_ventas_ajax']['POST'] = 'Ventas_register_controller/get_ventas_ajax';
$route['admin/ventas-add']['GET']           = 'ventas_controller/ventas_add';
$route['admin/ventas-add/get_productos_por_categoria']['GET'] = 'ventas_controller/get_productos_por_categoria';
$route['admin/registrar']['POST'] = 'Ventas_Register_Controller/registerVenta';
$route['admin/ventas/delete/(:any)']['POST'] = 'Ventas_register_controller/delete/$1';
$route['admin/ventas-detalles/(:any)']['GET'] = 'Ventas_register_controller/detalle_venta/$1';
$route['admin/imprimir-factura/(:any)']['GET'] = 'Ventas_register_controller/imprimir_factura/$1';
$route['admin/ventas/ventasFiltro']['GET'] = 'ventas_controller/ventasFiltro';

$route['admin/entrega_turno']['GET']           = 'entrega_controller/vista_entrega_turno';
$route['entrega/entregar_turno'] = 'entrega_controller/entregar_turno';
$route['admin/historial_turnos']['GET']           = 'entrega_controller/listar_historico';


$route['admin/clientes-add']['GET']           = 'clientes_controller/clientes';
$route['clientes/registrar'] = 'clientes_controller/registrar_cliente';
$route['admin/clientes_list']['GET']          = 'clientes_controller/listar_clientes';
$route['admin/clientes_add/delete/(:any)']['POST'] = 'clientes_controller/delete/$1';



// API para respuestas desde los recursos de EMQX.
$route['api/v1/devices/status']['POST']      = 'api/apidevices_controller/status';
$route['api/v1/devices/store']['POST']       = 'api/apidevices_controller/store';
