<?php if (!isset($routes)) {
	$routes = \Config\Services::routes(true);
}

$routes->group('param', ['namespace' => 'App\Modules\Core\Param\Controllers'], function ($subroutes) {
	/*** Route Update for Param ***/
	$subroutes->add('', 'Param::index');
	$subroutes->add('index', 'Param::index');
	$subroutes->add('profile', 'Param::profile');
	$subroutes->add('detail/(:any)', 'Param::detail/$1');
	$subroutes->add('detail/(:any)/(:any)', 'Param::detail/$1/$1');
	$subroutes->add('create', 'Param::create');
	$subroutes->add('edit/(:any)', 'Param::edit/$1');
	$subroutes->add('delete/(:any)', 'Param::delete/$1');
	$subroutes->add('set_access/(:any)', 'Param::set_access/$1');
	$subroutes->add('json', 'Param::json');
});

$routes->group('api/param', ['namespace' => 'App\Modules\Core\Param\Controllers\Api'], function ($subroutes) {
	/*** Route Update for Param ***/
	$subroutes->add('detail/(:any)', 'Param::detail/$1');
	$subroutes->add('edit/(:any)', 'Param::edit/$1');
	$subroutes->add('create', 'Param::create');
	$subroutes->add('delete/(:any)', 'Param::delete/$1');
});
