<?php if (!isset($routes)) {
	$routes = \Config\Services::routes(true);
}

$routes->group('parameter', ['namespace' => 'hamkamannan\adminigniter\Modules\Core\Parameter\Controllers'], function ($subroutes) {
	/*** Route Update for Parameter ***/
	$subroutes->add('', 'Parameter::index');
	$subroutes->add('index', 'Parameter::index');
	$subroutes->add('profile', 'Parameter::profile');
	$subroutes->add('detail/(:any)', 'Parameter::detail/$1');
	$subroutes->add('detail/(:any)/(:any)', 'Parameter::detail/$1/$1');
	$subroutes->add('create', 'Parameter::create');
	$subroutes->add('edit/(:any)', 'Parameter::edit/$1');
	$subroutes->add('delete/(:any)', 'Parameter::delete/$1');
	$subroutes->add('set_access/(:any)', 'Parameter::set_access/$1');
	$subroutes->add('json', 'Parameter::json');
});

$routes->group('api/parameter', ['namespace' => 'hamkamannan\adminigniter\Modules\Core\Parameter\Controllers\Api'], function ($subroutes) {
	/*** Route Update for Parameter ***/
	$subroutes->add('detail/(:any)', 'Parameter::detail/$1');
	$subroutes->add('edit/(:any)', 'Parameter::edit/$1');
	$subroutes->add('create', 'Parameter::create');
	$subroutes->add('delete/(:any)', 'Parameter::delete/$1');
});
