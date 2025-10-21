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
    $routes->get('players', 'Players::index');                     // List pemain
    $routes->get('players/a_players', 'Players::a_players');       // Tambah pemain (form)
    $routes->post('players/store', 'Players::store');              // Simpan pemain baru
    $routes->get('players/e_players/(:num)', 'Players::e_players/$1'); // Edit pemain

    // DIPERBAIKI: Menggunakan match(['post', 'put']) untuk Update
    $routes->match(['post', 'put'], 'players/update/(:num)', 'Players::update/$1'); // Update pemain

    $routes->get('players/d_players/(:num)', 'Players::d_players/$1'); // Hapus pemain

    // ------------------------------------
    // 🏟️ GOR Management
    // ------------------------------------
    $routes->get('gors', 'Gors::index');                             // List GOR
    $routes->get('gors/a_gors', 'Gors::a_gors');                     // Tambah GOR (form)
    $routes->post('gors/store', 'Gors::store');                      // Simpan GOR baru
    $routes->get('gors/e_gors/(:num)', 'Gors::e_gors/$1');           // Edit GOR (form)

    // DIPERBAIKI: Menggunakan match(['post', 'put']) untuk Update
    $routes->match(['post', 'put'], 'gors/update/(:num)', 'Gors::update/$1'); // Update GOR

    // DIPERBAIKI: Mengganti 'd_gor' menjadi 'd_gors'
    $routes->get('gors/d_gors/(:num)', 'Gors::d_gors/$1');           // Hapus GOR
});
