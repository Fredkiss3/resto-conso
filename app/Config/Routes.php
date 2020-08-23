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
$routes->setDefaultController('HomeController');
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
    $routes->post('toggle', 'AccountController::toggle', ['as' => 'accounts.toggle']);
    $routes->post('reset', 'AccountController::reset', ['as' => 'accounts.reset']);
    $routes->post('delete', 'AccountController::delete', ['as' => 'accounts.delete']);
    $routes->post('edit', 'AccountController::edit', ['as' => 'accounts.edit']);
});

$routes->group('keys', function(RouteCollection $routes)
{
    $routes->get('', 'KeyController::index', ['as' => 'keys.index']);
    $routes->post('delete', 'KeyController::delete', ['as' => 'keys.delete']);
    $routes->post('toggle', 'KeyController::toggle', ['as' => 'keys.toggle']);
    $routes->post('store', 'KeyController::store', ['as' => 'keys.store']);
});

$routes->group('api', function(RouteCollection $routes)
{
    $routes->post('install', 'ApiController::install', ['as' => 'keys.index']);
    $routes->post('sync', 'ApiController::sync', ['as' => 'keys.delete']);
});


$routes->group('recharge', function(RouteCollection $routes)
{
    $routes->get('', 'RechargeController::index', ['as' => 'recharge.index']);
    $routes->get('show', 'RechargeController::show', ['as' => 'recharge.show']);
    $routes->post('submit', 'RechargeController::submit', ['as' => 'recharge.submit']);
    $routes->post('cancel', 'RechargeController::cancel', ['as' => 'recharge.cancel']);
    $routes->post('accept', 'RechargeController::accept', ['as' => 'recharge.accept']);
});

$routes->group('resto', function(RouteCollection $routes)
{
    $routes->group('summary', function (RouteCollection $routes) {
        $routes->get('', 'SummaryController::index', ['as' => 'summary.index']);
        $routes->get('show', 'SummaryController::show', ['as' => 'summary.show']);
    });

    $routes->group('facturations', function(RouteCollection $routes)
    {
        $routes->get('', 'FacturationController::index', ['as' => 'facturations.index']);
        $routes->post('store', 'FacturationController::store', ['as' => 'facturations.store']);
        $routes->post('edit', 'FacturationController::edit', ['as' => 'facturations.edit']);
        $routes->post('delete', 'FacturationController::delete', ['as' => 'facturations.delete']);
    });

    $routes->group('dishes', function(RouteCollection $routes)
    {
        $routes->get('', 'DishController::index', ['as' => 'dishes.index']);
        $routes->post('store', 'DishController::store', ['as' => 'dishes.store']);
        $routes->post('edit', 'DishController::edit', ['as' => 'dishes.edit']);
        $routes->post('delete', 'DishController::delete', ['as' => 'dishes.delete']);
    });
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
