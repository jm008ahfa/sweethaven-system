<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setAutoRoute(false);

// Public routes
$routes->get('/', 'Auth::index');
$routes->get('/login', 'Auth::index');
$routes->post('/auth/login', 'Auth::login');
$routes->get('/register', 'Auth::register');
$routes->post('/auth/doRegister', 'Auth::doRegister');
$routes->get('/logout', 'Auth::logout');

// Protected routes
$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'login']);
$routes->get('/products', 'Product::index', ['filter' => 'login']);
$routes->get('/products/create', 'Product::create', ['filter' => 'login']);
$routes->post('/products/store', 'Product::store', ['filter' => 'login']);
$routes->get('/products/edit/(:num)', 'Product::edit/$1', ['filter' => 'login']);
$routes->post('/products/update/(:num)', 'Product::update/$1', ['filter' => 'login']);
$routes->get('/products/delete/(:num)', 'Product::delete/$1', ['filter' => 'login']);