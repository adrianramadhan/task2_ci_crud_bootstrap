<?php

use App\Controllers\PostController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/post', [PostController::class, 'index']);
$routes->get('/post/create', [PostController::class, 'create']);
$routes->get('post/edit/(:segment)', 'PostController::edit/$1');

$routes->post('post/update/(:segment)', 'PostController::update/$1');
$routes->post('/post/store', [PostController::class, 'store']);

$routes->delete('post/delete/(:segment)', 'PostController::delete/$1');
