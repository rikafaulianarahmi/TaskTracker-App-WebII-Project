<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
//$routes->get('/', 'Home::index');
$routes->get('/', 'AuthController::login');
$routes->post('/login', 'AuthController::attemptLogin');

$routes->get('/logout', 'AuthController::logout', ['filter' => 'auth']);
$routes->get('/dashboard', 'DashboardController::index', ['filter' => 'auth']);
$routes->get('/projects', 'ProjectController::index', ['filter' => 'auth']);