<?php if (!isset($routes)) {
	$routes = \Config\Services::routes(true);
}
$routes->group('dashboard', ['namespace' => 'hamkamannan\adminigniter\Modules\Backend\Dashboard\Controllers'], function ($subroutes) {
	/*** Route Update for Dashboard ***/
	$subroutes->add('', 'Dashboard::index');
	$subroutes->add('dashboard', 'Dashboard::index');
	$subroutes->add('index', 'Dashboard::index');
});
