<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
//$routes->get('/', 'Home::index');
$routes->get('/test-db', 'TestController::index');

$routes->get('/', 'AuthController::login');
$routes->post('/login', 'AuthController::attemptLogin');
$routes->get('/logout', 'AuthController::logout');

$routes->get('/dashboard', function () {
    return 'Login berhasil';
});