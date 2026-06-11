<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'AuthController::login');

$routes->post('/login', 'AuthController::attemptLogin');
$routes->get('/logout', 'AuthController::logout', ['filter' => 'auth']);

$routes->get('/dashboard', 'DashboardController::index', ['filter' => 'auth']);
$routes->get('/projects', 'ProjectController::index', ['filter' => 'auth']);

$routes->get('/projects/create', 'ProjectController::create', ['filter' => 'auth']);
$routes->post('/projects/store', 'ProjectController::store', ['filter' => 'auth']);
$routes->post('/projects/(:num)/archive', 'ProjectController::archive/$1', ['filter' => 'auth']);

$routes->get('/projects/(:num)', 'ProjectController::show/$1', ['filter' => 'auth']);
$routes->post('/projects/(:num)/members', 'ProjectMemberController::store/$1', ['filter' => 'auth']);
$routes->post('/projects/(:num)/members/(:num)/remove', 'ProjectMemberController::remove/$1/$2', ['filter' => 'auth']);

$routes->get('/projects/(:num)/tasks/create', 'TaskController::create/$1', ['filter' => 'auth']);
$routes->post('/projects/(:num)/tasks/store', 'TaskController::store/$1', ['filter' => 'auth']);
$routes->post('/tasks/(:num)/status', 'TaskController::updateStatus/$1', ['filter' => 'auth']);

$routes->post('/tasks/(:num)/comments', 'CommentController::store/$1', ['filter' => 'auth']);
