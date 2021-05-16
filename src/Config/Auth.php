<?php 
namespace hamkamannan\adminigniter\Config;

class Auth extends \Myth\Auth\Config\Auth
{
	public $defaultUserGroup = 'user';

	public $views = [
		'login'           => 'hamkamannan\adminigniter\Views\auth\login',
		'register'        => 'hamkamannan\adminigniter\Views\auth\register',
		'forgot'          => 'hamkamannan\adminigniter\Views\auth\forgot',
		'reset'           => 'hamkamannan\adminigniter\Views\auth\reset',
		'emailForgot'     => 'hamkamannan\adminigniter\Views\auth\emails\forgot',
		'emailActivation' => 'hamkamannan\adminigniter\Views\auth\emails\activation',
	];

	public $allowRegistration = true;
	public $requireActivation = false; 
	public $activeResetter = false;
	public $allowRemembering = true;
	
	public $passwordValidators = [
		'Myth\Auth\Authentication\Passwords\CompositionValidator',
		'Myth\Auth\Authentication\Passwords\NothingPersonalValidator',
		'Myth\Auth\Authentication\Passwords\DictionaryValidator',
		'Myth\Auth\Authentication\Passwords\PwnedValidator',
	];
}
