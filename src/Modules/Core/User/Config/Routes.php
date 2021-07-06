<?php if (!isset($routes)) {
	$routes = \Config\Services::routes(true);
}

$routes->group('user', ['namespace' => 'hamkamannan\adminigniter\Modules\Core\User\Controllers'], function ($subroutes) {
	/*** Route Update for User ***/
	$subroutes->add('', 'User::index');
	$subroutes->add('index', 'User::index');
	$subroutes->add('profile', 'User::profile');
	$subroutes->add('change_password', 'User::change_password');
	$subroutes->add('change_avatar', 'User::change_avatar');
	$subroutes->add('detail/(:any)', 'User::detail/$1');
	$subroutes->add('detail/(:any)/(:any)', 'User::detail/$1/$1');
	$subroutes->add('create', 'User::create');
	$subroutes->add('edit/(:any)', 'User::edit/$1');
	$subroutes->add('delete/(:any)', 'User::delete/$1');
	$subroutes->add('enable/(:any)', 'User::enable/$1');
	$subroutes->add('enable/(:any)/(:any)', 'User::enable/$1/$1');
	$subroutes->add('disable/(:any)', 'User::disable/$1');
});

$routes->group('api/user', ['namespace' => 'hamkamannan\adminigniter\Modules\Core\User\Controllers\Api'], function ($subroutes) {
	/*** Route Update for User ***/
	$subroutes->add('detail/(:any)', 'User::detail/$1');
	$subroutes->add('edit/(:any)', 'User::edit/$1');
	$subroutes->add('create', 'User::create');
	$subroutes->add('delete/(:any)', 'User::delete/$1');
});
