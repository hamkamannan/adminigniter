<?php
$sourcePath = realpath(__DIR__.'/../');

// Core Routes
require_once "{$sourcePath}/Modules/Core/Access/Config/Routes.php";
require_once "{$sourcePath}/Modules/Core/Group/Config/Routes.php";
require_once "{$sourcePath}/Modules/Core/Menu/Config/Routes.php";
require_once "{$sourcePath}/Modules/Core/Parameter/Config/Routes.php";
require_once "{$sourcePath}/Modules/Core/Permission/Config/Routes.php";
require_once "{$sourcePath}/Modules/Core/Reference/Config/Routes.php";
require_once "{$sourcePath}/Modules/Core/User/Config/Routes.php";

// Modules Routes  
foreach (glob(APPPATH . 'Adminigniter/Modules/*', GLOB_ONLYDIR) as $item_dir) {
	if (file_exists($item_dir . '/Config/Routes.php')) {
		require_once($item_dir . '/Config/Routes.php');
	}
}

foreach (glob(APPPATH . 'Adminigniter/Modules/Backend/*', GLOB_ONLYDIR) as $item_dir) {
	if (file_exists($item_dir . '/Config/Routes.php')) {
		require_once($item_dir . '/Config/Routes.php');
	}
}

foreach (glob(APPPATH . 'Adminigniter/Modules/Frontend/*', GLOB_ONLYDIR) as $item_dir) {
	if (file_exists($item_dir . '/Config/Routes.php')) {
		require_once($item_dir . '/Config/Routes.php');
	}
}


