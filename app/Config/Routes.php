<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setAutoRoute(false);

// ============================================
// PUBLIC ROUTES (No login required)
// ============================================
$routes->get('/', 'Auth::index');
$routes->get('/login', 'Auth::index');
$routes->post('/auth/login', 'Auth::login');
$routes->get('/register', 'Auth::register');
$routes->post('/auth/doRegister', 'Auth::doRegister');
$routes->get('/logout', 'Auth::logout');

// ============================================
// PROTECTED ROUTES (Login required - Both Admin & Staff)
// ============================================
$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'login']);
$routes->get('/products', 'Product::index', ['filter' => 'login']);

// ============================================
// ADMIN ONLY ROUTES (Only Admin can access)
// ============================================
$routes->get('/products/create', 'Product::create', ['filter' => 'role:admin']);
$routes->post('/products/store', 'Product::store', ['filter' => 'role:admin']);
$routes->get('/products/edit/(:num)', 'Product::edit/$1', ['filter' => 'role:admin']);
$routes->post('/products/update/(:num)', 'Product::update/$1', ['filter' => 'role:admin']);
$routes->get('/products/delete/(:num)', 'Product::delete/$1', ['filter' => 'role:admin']);

// POS Routes - Staff can access
$routes->get('/pos', 'Pos::index', ['filter' => 'login']);
$routes->post('/pos/addToCart', 'Pos::addToCart', ['filter' => 'login']);
$routes->post('/pos/updateCart', 'Pos::updateCart', ['filter' => 'login']);
$routes->get('/pos/removeFromCart/(:num)', 'Pos::removeFromCart/$1', ['filter' => 'login']);
$routes->get('/pos/clearCart', 'Pos::clearCart', ['filter' => 'login']);
$routes->post('/pos/checkout', 'Pos::checkout', ['filter' => 'login']);
$routes->get('/pos/receipt', 'Pos::receipt', ['filter' => 'login']);
$routes->get('/pos', 'Pos::index', ['filter' => 'login']);

// Product view route
$routes->get('/products/view/(:num)', 'Product::view/$1', ['filter' => 'login']);