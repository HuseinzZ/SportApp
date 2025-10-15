<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');

$routes->group('admin', function ($routes) {

    $routes->match(['get', 'post'], '/', 'Auth::index');

    $routes->get('logout', 'Auth::logout');

    $routes->get('dashboard', 'Dashboard::index');
});
