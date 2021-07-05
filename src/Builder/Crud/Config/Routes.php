<?php if (!isset($routes)) {
	$routes = \Config\Services::routes(true);
}
$routes->group('crud', ['namespace' => 'Crud\Controllers'], function ($subroutes) {
	/*** Route Update for Crud ***/
	$subroutes->add('', 'Crud::index');
	$subroutes->add('index', 'Crud::index');
	$subroutes->add('detail/(:any)', 'Crud::detail/$1');
	$subroutes->add('create', 'Crud::create');
	$subroutes->add('edit/(:any)', 'Crud::edit/$1');
	$subroutes->add('delete/(:any)', 'Crud::delete/$1');
	$subroutes->add('apply_status/(:any)', 'Crud::apply_status/$1');
	$subroutes->add('do_init', 'Crud::do_init');
	$subroutes->add('do_upload', 'Crud::do_upload');
	$subroutes->add('do_delete', 'Crud::do_delete');
	$subroutes->add('flip', 'Crud::flip');
});

$routes->group('api/crud', ['namespace' => 'Crud\Controllers\Api'], function ($subroutes) {
	/*** Route Update for Crud ***/
	$subroutes->add('detail/(:any)', 'Crud::detail/$1');
	$subroutes->add('create', 'Crud::create');
	$subroutes->add('edit/(:any)', 'Crud::edit/$1');
	$subroutes->add('delete/(:any)', 'Crud::delete/$1');
});