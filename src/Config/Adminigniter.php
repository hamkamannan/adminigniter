<?php 
namespace hamkamannan\adminigniter\Config;

use CodeIgniter\Config\BaseConfig;

class Adminigniter extends BaseConfig
{
	public $appName = 'Adminigniter';

	public $views = [
		'login'           => 'hamkamannan\adminigniter\Views\auth\login',
		'register'        => 'hamkamannan\adminigniter\Views\auth\register',
		'forgot'          => 'hamkamannan\adminigniter\Views\auth\forgot',
		'reset'           => 'hamkamannan\adminigniter\Views\auth\reset',
		'emailForgot'     => 'hamkamannan\adminigniter\Views\auth\emails\forgot',
		'emailActivation' => 'hamkamannan\adminigniter\Views\auth\emails\activation',
	];

	public $dashboard = [
        'namespace'  => 'hamkamannan\adminigniter\Modules\Backend\Dashboard\Controllers',
        'controller' => 'Dashboard::index',
        'filter'     => 'permission:backend',
    ];

	public $i18n = 'Indonesian';

	public $theme = [
        'sidebar-mode' => 'auto', //auto = from database | manual = from file
        'sidebar-file' => 'hamkamannan\adminigniter\layout\backend\partial\navigation', //if sidebar-mode = manual
        
		'topbar-mode' => 'auto', //auto = from database | manual = from file
        'topbar-file' => 'hamkamannan\adminigniter\layout\frontend\partial\navigation', //if sidebar-mode = manual

        'show'  => [
            'show-logo-login' => '1', //1 = show | 0 = hide
            'show-logo-sidebar' => '0', //1 = show | 0 = hide
            'show-top-checkbox' => '1', //1 = show | 0 = hide
            'show-layout-setting'   => '0', //1 = show | 0 = hide
            'show-banner-intro'   => '0' //1 = show | 0 = hide
        ],

		'class'  => [
            'header-cs-class' => 'bg-primary header-text-light', //background and text
            'sidebar-cs-class' => 'bg-night-sky sidebar-text-light', //background and text
            'container-header-class' => 'fixed-header', //fixed-header
            'container-sidebar-class' => 'fixed-sidebar', //fixed-sidebar
            'container-footer-class' => '', //fixed-footer
        ],
    ];
}
