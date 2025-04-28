<?php
use CodeIgniter\Router\RouteCollection;
/**
 * @var RouteCollection $routes
*/
$routes->get('/', 'Home::index');
$routes->post('/ruta_login', 'Home::arr_login'); 
$routes->post('Home/deslogarse', 'Home::deslogarse'); 
$routes->get('/administrador', 'Home::administrador'); 
$routes->get('/auth/logout', 'Home::logout');
$routes->setAutoRoute(true);
