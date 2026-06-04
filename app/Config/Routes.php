<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'AuthController::login');

$routes->post('/login', 'AuthController::attemptLogin');
$routes->get('/logout', 'AuthController::logout', ['filter' => 'auth']);

$routes->get('/dashboard', 'DashboardController::index', ['filter' => 'auth']);

$routes->get('/projects/create', 'ProjectController::create', ['filter' => 'auth']);
$routes->post('/projects/store', 'ProjectController::store', ['filter' => 'auth']);

$routes->get('/projects', 'ProjectController::index', ['filter' => 'auth']);
$routes->get('/projects/(:num)', 'ProjectController::show/$1', ['filter' => 'auth']);