<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Autentikasi
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attempt');
$routes->post('logout', 'Auth::logout');

// Area yang butuh login
$routes->group('', ['filter' => 'auth'], static function (RouteCollection $routes) {
    $routes->get('dashboard', 'Dashboard::index');

    // Modul pelaporan kerusakan
    $routes->get('laporan', 'LaporanKerusakan::index');
    $routes->get('laporan/buat', 'LaporanKerusakan::create');
    $routes->post('laporan/simpan', 'LaporanKerusakan::store');
    $routes->get('laporan/foto/(:num)', 'LaporanKerusakan::foto/$1');
    $routes->get('laporan/(:num)', 'LaporanKerusakan::show/$1');
});

// Area khusus admin
$routes->group('', ['filter' => 'auth:admin'], static function (RouteCollection $routes) {
    $routes->post('laporan/(:num)/status', 'LaporanKerusakan::updateStatus/$1');
});
