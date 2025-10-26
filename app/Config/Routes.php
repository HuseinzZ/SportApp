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
    $routes->get('players', 'Players::index');
    $routes->get('players/a_players', 'Players::a_players');
    $routes->post('players/store', 'Players::store');
    $routes->get('players/e_players/(:num)', 'Players::e_players/$1');
    $routes->match(['post', 'put'], 'players/update/(:num)', 'Players::update/$1');
    $routes->get('players/d_players/(:num)', 'Players::d_players/$1');

    // ------------------------------------
    // 🏟️ GOR Management
    // ------------------------------------
    $routes->get('gors', 'Gors::index');
    $routes->get('gors/a_gors', 'Gors::a_gors');
    $routes->post('gors/store', 'Gors::store');
    $routes->get('gors/e_gors/(:num)', 'Gors::e_gors/$1');
    $routes->match(['post', 'put'], 'gors/update/(:num)', 'Gors::update/$1');
    $routes->get('gors/d_gors/(:num)', 'Gors::d_gors/$1');

    // ------------------------------------
    // 📸 Gallery Management (BARU)
    // ------------------------------------
    $routes->get('gallery', 'Gallery::index');
    $routes->get('gallery/a_gallery', 'Gallery::a_gallery');
    $routes->post('gallery/store', 'Gallery::store');
    $routes->get('gallery/e_gallery/(:num)', 'Gallery::e_gallery/$1');
    $routes->match(['post', 'put'], 'gallery/update/(:num)', 'Gallery::update/$1');
    $routes->match(['post', 'delete'], 'gallery/d_gallery/(:num)', 'Gallery::d_gallery/$1');

    // ------------------------------------
    // 🏆 Tournament Points Management
    // ------------------------------------
    $routes->get('tournament-points', 'TournamentPoints::index');
    $routes->get('tournament-points/a_points', 'TournamentPoints::a_points');
    $routes->post('tournament-points/store', 'TournamentPoints::store');
    $routes->get('tournament-points/e_points/(:num)', 'TournamentPoints::e_points/$1');
    $routes->match(['post', 'put'], 'tournament-points/update/(:num)', 'TournamentPoints::update/$1');
    $routes->get('tournament-points/d_points/(:num)', 'TournamentPoints::d_points/$1');

    // ------------------------------------
    // 🗓️ Schedule Management (Jadwal)
    // ------------------------------------
    $routes->get('schedules', 'Schedules::index');
    $routes->get('schedules/a_schedules', 'Schedules::a_schedules');
    $routes->post('schedules/store', 'Schedules::store');
    $routes->get('schedules/e_schedules/(:num)', 'Schedules::e_schedules/$1');
    $routes->match(['post', 'put'], 'schedules/update/(:num)', 'Schedules::update/$1');
    $routes->get('schedules/d_schedules/(:num)', 'Schedules::d_schedules/$1');

    // ------------------------------------
    // ⚔️ Match Management (Tabel Matches)
    // ------------------------------------
    $routes->get('matches/(:num)', 'Matches::index/$1');
    $routes->get('matches/a_match/(:num)', 'Matches::a_match/$1');
    $routes->post('matches/store', 'Matches::store');
    $routes->get('matches/e_match/(:num)', 'Matches::e_match/$1');
    $routes->match(['post', 'put'], 'matches/update/(:num)', 'Matches::update/$1');
    $routes->get('matches/d_match/(:num)', 'Matches::d_match/$1');

    // ------------------------------------
    // 🏆 Player Ranking (GLOBAL REPORTS)
    // ------------------------------------
    $routes->get('ranking', 'PlayerRanking::index');
    $routes->get('players/history/(:num)', 'Players::matchHistory/$1');
});
