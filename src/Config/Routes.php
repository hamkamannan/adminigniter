<?php
// Core
include ROOTPATH . 'vendor/hamkamannan/adminigniter/src/Modules/Core/Access/Config/Routes.php';
include ROOTPATH . 'vendor/hamkamannan/adminigniter/src/Modules/Core/Group/Config/Routes.php';
include ROOTPATH . 'vendor/hamkamannan/adminigniter/src/Modules/Core/Menu/Config/Routes.php';
include ROOTPATH . 'vendor/hamkamannan/adminigniter/src/Modules/Core/Param/Config/Routes.php';
include ROOTPATH . 'vendor/hamkamannan/adminigniter/src/Modules/Core/Permission/Config/Routes.php';
include ROOTPATH . 'vendor/hamkamannan/adminigniter/src/Modules/Core/Reference/Config/Routes.php';
include ROOTPATH . 'vendor/hamkamannan/adminigniter/src/Modules/Core/User/Config/Routes.php';

// Backend 
include ROOTPATH . 'vendor/hamkamannan/adminigniter/src/Modules/Backend/Dashboard/Config/Routes.php';
include ROOTPATH . 'vendor/hamkamannan/adminigniter/src/Modules/Backend/Report/Config/Routes.php';

if (!isset($routes)) {
	$routes = \Config\Services::routes(true);
}


