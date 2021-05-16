<?php if (!isset($routes)) {
	$routes = \Config\Services::routes(true);
}
$routes->group('sample', ['namespace' => 'App\Adminigniter\Modules\Backend\Sample\Controllers'], function ($subroutes) {
	/*** Route Update for Sample ***/
	$subroutes->add('', 'Sample::index');
	$subroutes->add('sample', 'Sample::index');
	$subroutes->add('index', 'Sample::index');
	$subroutes->add('detail/(:any)', 'Sample::detail/$1');
	$subroutes->add('edit/(:any)', 'Sample::edit/$1');
	$subroutes->add('create', 'Sample::create');
	$subroutes->add('delete/(:any)', 'Sample::delete/$1');
	$subroutes->add('enable/(:any)', 'Sample::enable/$1');
	$subroutes->add('disable/(:any)', 'Sample::disable/$1');
	$subroutes->add('do_init', 'Sample::do_init');
	$subroutes->add('do_upload', 'Sample::do_upload');
	$subroutes->add('do_delete', 'Sample::do_delete');
	$subroutes->add('flip', 'Sample::flip');
});

$routes->group('api/sample', ['namespace' => 'App\Adminigniter\Modules\Backend\Sample\Controllers\Api'], function ($subroutes) {
	/*** Route Update for Sample ***/
	$subroutes->add('detail/(:any)', 'Sample::detail/$1');
	$subroutes->add('edit/(:any)', 'Sample::edit/$1');
	$subroutes->add('create', 'Sample::create');
	$subroutes->add('delete/(:any)', 'Sample::delete/$1');
});