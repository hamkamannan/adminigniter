<?php if (!isset($routes)) {
	$routes = \Config\Services::routes(true);
}

$routes->group('group', ['namespace' => 'App\Modules\Core\Group\Controllers'], function ($subroutes) {
	/*** Route Update for Group ***/
	$subroutes->add('', 'Group::index');
	$subroutes->add('index', 'Group::index');
	$subroutes->add('detail/(:any)', 'Group::detail/$1');
	$subroutes->add('create', 'Group::create');
	$subroutes->add('edit/(:any)', 'Group::edit/$1');
	$subroutes->add('delete/(:any)', 'Group::delete/$1');
	$subroutes->add('enable/(:any)', 'Group::enable/$1');
	$subroutes->add('disable/(:any)', 'Group::disable/$1');
	$subroutes->add('permission/(:any)', 'Group::permission/$1');
	$subroutes->add('permissions', 'Group::permissions');
});

$routes->group('api/group', ['namespace' => 'App\Modules\Core\Group\Controllers\Api'], function ($subroutes) {
	/*** Route Update for Group ***/
	$subroutes->add('detail/(:any)', 'Group::detail/$1');
	$subroutes->add('edit/(:any)', 'Group::edit/$1');
	$subroutes->add('create', 'Group::create');
	$subroutes->add('delete/(:any)', 'Group::delete/$1');
});
