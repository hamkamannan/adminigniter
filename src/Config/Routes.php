<?php
// Core
include ROOTPATH . 'vendor/hamkamannan/adminigniter/src/Modules/Core/Access/Config/Routes.php';
include ROOTPATH . 'vendor/hamkamannan/adminigniter/src/Modules/Core/Group/Config/Routes.php';
include ROOTPATH . 'vendor/hamkamannan/adminigniter/src/Modules/Core/Menu/Config/Routes.php';
include ROOTPATH . 'vendor/hamkamannan/adminigniter/src/Modules/Core/Parameter/Config/Routes.php';
include ROOTPATH . 'vendor/hamkamannan/adminigniter/src/Modules/Core/Permission/Config/Routes.php';
include ROOTPATH . 'vendor/hamkamannan/adminigniter/src/Modules/Core/Reference/Config/Routes.php';
include ROOTPATH . 'vendor/hamkamannan/adminigniter/src/Modules/Core/User/Config/Routes.php';

// Backend 
include ROOTPATH . 'vendor/hamkamannan/adminigniter/src/Modules/Backend/Dashboard/Config/Routes.php';
include ROOTPATH . 'vendor/hamkamannan/adminigniter/src/Modules/Backend/Report/Config/Routes.php';

// Autoload Modules Config  
foreach (glob(APPPATH . 'Modules/*', GLOB_ONLYDIR) as $item_dir) {
	if (file_exists($item_dir . '/Config/Routes.php')) {
		require_once($item_dir . '/Config/Routes.php');
	}
}

foreach (glob(APPPATH . 'Modules/Backend/*', GLOB_ONLYDIR) as $item_dir) {
	if (file_exists($item_dir . '/Config/Routes.php')) {
		require_once($item_dir . '/Config/Routes.php');
	}
}

foreach (glob(APPPATH . 'Modules/Frontend/*', GLOB_ONLYDIR) as $item_dir) {
	if (file_exists($item_dir . '/Config/Routes.php')) {
		require_once($item_dir . '/Config/Routes.php');
	}
}


