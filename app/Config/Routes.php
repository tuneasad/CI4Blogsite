<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ===========================
// Frontend Routes
// ===========================
$routes->get('/', 'Posts::index');
$routes->get('posts', 'Posts::index');
$routes->get('post/(:segment)', 'Posts::show/$1');

// ===========================
// API Routes
// ===========================
$routes->get('api/posts', 'Admin\Posts::apiPosts');

// ===========================
// Admin Authentication
// ===========================
$routes->get('admin/login', 'Admin\Dashboard::login');
$routes->post('admin/login', 'Admin\Dashboard::loginPost');
$routes->get('admin/logout', 'Admin\Dashboard::logout');

// ===========================
// Admin Panel (Protected)
// ===========================
$routes->group('admin', ['filter' => 'admin_auth'], static function ($routes) {
	$routes->get('dashboard', 'Admin\AdminController::admin_dashboard');
	// posts routes
	$routes->get('posts', 'Admin\Posts::index');
	$routes->get('posts/create', 'Admin\Posts::create');
	$routes->post('posts/create', 'Admin\Posts::store');
	$routes->get('posts/edit/(:num)', 'Admin\Posts::edit/$1');
	$routes->post('posts/edit/(:num)', 'Admin\Posts::update/$1');
	$routes->post('posts/delete/(:num)', 'Admin\Posts::delete/$1');
});

