<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');

$routes->match(['get', 'post'], 'admin', 'Auth::index');

$routes->group('admin', ['filter' => 'auth'], static function ($routes) {
    $routes->get('logout', 'Auth::logout');
    $routes->get('dashboard', 'Dashboard::index');
    $routes->match(['get', 'post'], 'change-password', 'Auth::changePassword');
});
