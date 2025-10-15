<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/admin', 'Auth::index');
$routes->post('/admin', 'Auth::index');
$routes->get('/logout', 'Auth::logout');
