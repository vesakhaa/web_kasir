<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Pelanggan;
use App\Controllers\Home;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', [Home::class, 'index']);

$routes->get('/pelanggan', [Pelanggan::class, 'index']);
$routes->post('/pelanggan/store', [Pelanggan::class, 'store']);
$routes->get('/pelanggan/(:num)', [Pelanggan::class, 'show/$1']);
$routes->put('/pelanggan/update/(:num)', [Pelanggan::class, 'update/$1']);
$routes->delete('/pelanggan/delete/(:num)', [Pelanggan::class, 'delete']);