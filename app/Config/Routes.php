<?php namespace Config;

// Create a new instance of our RouteCollection class.
use CodeIgniter\Router\RouteCollection;

$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'HomeController::index', ['as' => 'index']);
$routes->get('logout','LoginController::logout', ['as' => 'logout']);

$routes->get('login', 'LoginController::index', ['as' => 'login']);
$routes->post('login', 'LoginController::login', ['as' => 'login.store']);

$routes->group('accounts', function(RouteCollection $routes)
{
    $routes->get('', 'AccountController::index', ['as' => 'accounts.index']);
    $routes->post('store', 'AccountController::store', ['as' => 'accounts.store']);
//    $routes->add('blog', 'Admin\Blog::index');
});


/**
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
