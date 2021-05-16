<?php if (!isset($routes)) {
	$routes = \Config\Services::routes(true);
}
$routes->group('banner', ['namespace' => 'App\Adminigniter\Modules\Backend\Banner\Controllers'], function ($subroutes) {
	/*** Route Update for Banner ***/
	$subroutes->add('', 'Banner::index');
	$subroutes->add('banner', 'Banner::index');
	$subroutes->add('index', 'Banner::index');
	$subroutes->add('detail/(:any)', 'Banner::detail/$1');
	$subroutes->add('edit/(:any)', 'Banner::edit/$1');
	$subroutes->add('create', 'Banner::create');
	$subroutes->add('delete/(:any)', 'Banner::delete/$1');
	$subroutes->add('enable/(:any)', 'Banner::enable/$1');
	$subroutes->add('disable/(:any)', 'Banner::disable/$1');
	$subroutes->add('do_init', 'Banner::do_init');
	$subroutes->add('do_upload', 'Banner::do_upload');
	$subroutes->add('do_delete', 'Banner::do_delete');
	$subroutes->add('flip', 'Banner::flip');
});

$routes->group('api/banner', ['namespace' => 'App\Adminigniter\Modules\Backend\Banner\Controllers\Api'], function ($subroutes) {
	/*** Route Update for Banner ***/
	$subroutes->add('detail/(:any)', 'Banner::detail/$1');
	$subroutes->add('edit/(:any)', 'Banner::edit/$1');
	$subroutes->add('create', 'Banner::create');
	$subroutes->add('delete/(:any)', 'Banner::delete/$1');
});