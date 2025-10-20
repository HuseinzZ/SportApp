<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ========================================
// 🔹 Public Routes
// ========================================
$routes->get('/', 'Home::index');

// Login Page (GET & POST)
$routes->match(['get', 'post'], 'admin', 'Auth::index');


// ========================================
// 🔹 Admin Routes (Protected by Auth Filter)
// ========================================
$routes->group('admin', ['filter' => 'auth'], static function ($routes) {

    // Authentication
    $routes->get('logout', 'Auth::logout');
    $routes->match(['get', 'post'], 'change-password', 'Auth::changePassword');

    // Dashboard
    $routes->get('dashboard', 'Dashboard::index');

    // ------------------------------------
    // 👤 Player Management
    // ------------------------------------
    $routes->get('players', 'Players::index');                      // List pemain
    $routes->get('players/a_players', 'Players::a_players');        // Tambah pemain (form)
    $routes->post('players/store', 'Players::store');               // Simpan pemain baru
    $routes->get('players/e_players/(:num)', 'Players::e_players/$1'); // Edit pemain
    $routes->post('players/update/(:num)', 'Players::update/$1');      // Update pemain
    $routes->get('players/d_players/(:num)', 'Players::d_players/$1'); // Hapus pemain
});
