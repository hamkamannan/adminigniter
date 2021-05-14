<?php
include 'ModulesRoutes.php';

if (!isset($routes)) {
	$routes = \Config\Services::routes(true);
}


