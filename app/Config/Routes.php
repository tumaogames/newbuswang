<?php

namespace Config;

use App\Controllers\MaintenanceMode;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('admin_login', 'ViewController::showLoginPage');
$routes->get('logout', 'AuthController::logout');
$routes->get('admin_register', 'ViewController::showRegistrationPage');
$routes->post('register_user', 'AuthController::register');
$routes->post('login_user', 'AuthController::login');
$routes->add('success_page', 'ViewController::showSuccessPage');
$routes->add('dashboard_page', 'ViewController::showDashboardPage', ['filter' => 'auth']);
$routes->add('set', 'Home::set');
$routes->post('excel', 'ExcelController::upload', ['filter' => 'auth']);
// Add the maintenance mode route
if (config('MaintenanceMode')->enabled) {
    $routes->setDefaultController(MaintenanceMode::class);
    $routes->get('/', 'MaintenanceMode::index');
    $routes->get('/print', 'MaintenanceMode::index');
} else {
    $routes->setDefaultController('Home');
    $routes->get('/', 'Home::index');
    $routes->add('/print', 'ViewController::print', ['filter' => 'auth']);
    $routes->add('/print_back', 'ViewController::print_back', ['filter' => 'auth']);
}

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
