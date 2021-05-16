<?php if (!isset($routes)) {
	$routes = \Config\Services::routes(true);
}
$routes->group('page', ['namespace' => 'App\Adminigniter\Modules\Backend\Page\Controllers'], function ($subroutes) {
	/*** Route Update for Page ***/
	$subroutes->add('', 'Page::index');
	$subroutes->add('index', 'Page::index');
	$subroutes->add('detail/(:any)', 'Page::detail/$1');
	$subroutes->add('edit/(:any)', 'Page::edit/$1');
	$subroutes->add('create', 'Page::create');
	$subroutes->add('delete/(:any)', 'Page::delete/$1');
	$subroutes->add('do_init', 'Page::do_init');
	$subroutes->add('do_upload', 'Page::do_upload');
	$subroutes->add('do_delete', 'Page::do_delete');
	$subroutes->add('flip', 'Page::flip');
});
