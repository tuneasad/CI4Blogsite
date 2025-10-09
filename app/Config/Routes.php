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
$routes->get('category/(:segment)', 'Posts::category/$1');
$routes->get('search', 'Posts::search');
$routes->get('images/(:segment)', 'ImageController::show/$1');

// ===========================
// API Routes
// ===========================
$routes->group('api', ['namespace' => 'App\Controllers\Api'], static function ($routes) {
    // Public read-only routes
    $routes->get('posts', 'Posts::index');
    $routes->get('posts/(:segment)', 'Posts::show/$1');
    $routes->get('categories', 'Categories::index');

    // Protected write routes
    $routes->group('', ['filter' => 'auth:tokens'], static function ($routes) {
        $routes->post('posts', 'Posts::create');
        $routes->put('posts/(:segment)', 'Posts::update/$1');
        $routes->delete('posts/(:segment)', 'Posts::delete/$1');
    });
});

// ===========================
// Admin Panel (Protected)
// ===========================
$routes->group('admin', ['filter' => 'session'], static function ($routes) {
	$routes->get('dashboard', 'Admin\AdminController::admin_dashboard');
	// posts routes
	$routes->get('posts', 'Admin\Posts::index');
	$routes->get('posts/create', 'Admin\Posts::create');
	$routes->post('posts/create', 'Admin\Posts::store');
	$routes->get('posts/edit/(:num)', 'Admin\Posts::edit/$1');
	$routes->post('posts/edit/(:num)', 'Admin\Posts::update/$1');
	$routes->post('posts/delete/(:num)', 'Admin\Posts::delete/$1');
	$routes->get('posts/fetch-random-image', 'Admin\Posts::fetchRandomImage');

	// categories routes
	$routes->get('categories', 'Admin\Categories::index');
	$routes->get('categories/create', 'Admin\Categories::create');
	$routes->post('categories/store', 'Admin\Categories::store');
	$routes->get('categories/edit/(:num)', 'Admin\Categories::edit/$1');
	$routes->post('categories/update/(:num)', 'Admin\Categories::update/$1');
	$routes->post('categories/delete/(:num)', 'Admin\Categories::delete/$1');

	// tags routes
	$routes->get('tags', 'Admin\Tags::index');
	$routes->get('tags/create', 'Admin\Tags::create');
	$routes->post('tags/store', 'Admin\Tags::store');
	$routes->get('tags/edit/(:num)', 'Admin\Tags::edit/$1');
	$routes->post('tags/update/(:num)', 'Admin\Tags::update/$1');
	$routes->post('tags/delete/(:num)', 'Admin\Tags::delete/$1');

	// User Management (SuperAdmin only)
	$routes->group('users', ['filter' => 'role:SuperAdmin'], static function ($routes) {
		$routes->get('/', 'Admin\Users::index');
		$routes->get('create', 'Admin\Users::create');
		$routes->post('store', 'Admin\Users::store');
		$routes->get('edit/(:num)', 'Admin\Users::edit/$1');
		$routes->post('update/(:num)', 'Admin\Users::update/$1');
		$routes->post('delete/(:num)', 'Admin\Users::delete/$1');
	});
});

service('auth')->routes($routes);
