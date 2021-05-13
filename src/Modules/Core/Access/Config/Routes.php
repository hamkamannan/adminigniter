<?php if (!isset($routes)) {
	$routes = \Config\Services::routes(true);
}

$routes->group('access', ['namespace' => 'App\Modules\Core\Access\Controllers'], function ($subroutes) {
	/*** Route Update for Access ***/
	$subroutes->add('', 'Access::index');
	$subroutes->add('index', 'Access::index');
	$subroutes->add('index/(:any)', 'Access::index/$1');
	$subroutes->add('create', 'Access::create');
	$subroutes->add('detail/(:any)', 'Access::detail/$1');
	$subroutes->add('edit/(:any)', 'Access::edit/$1');
	$subroutes->add('delete/(:any)', 'Access::delete/$1');
});

$routes->group('api/access', ['namespace' => 'App\Modules\Core\Access\Controllers\Api'], function ($subroutes) {
	/*** Route Update for Access ***/
	$subroutes->add('add_to_group/(:any)', 'Access::add_to_group/$1');
});
