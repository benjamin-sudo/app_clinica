<?php
use CodeIgniter\Router\RouteCollection;
/**
 * @var RouteCollection $routes
*/
$routes->get('/','Home::index');


$routes->get('/administrador', 'Home::administrador');
$routes->post('/administrador','Home::arr_login');

$routes->get('/auth/administrador', 'Home::administrador');
$routes->get('/auth/logout', 'Home::logout');
$routes->setAutoRoute(true);

