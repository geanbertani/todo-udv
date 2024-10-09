<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Routes - Users 
$routes->get('users', 'Users::list');
$routes->post('users', 'Users::create');
