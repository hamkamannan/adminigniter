<?php 
namespace hamkamannan\adminigniter\Config;

class Auth extends \Myth\Auth\Config\Auth
{
	public $defaultAdminGroup = 'admin';
	public $defaultUserGroup = 'user';
	public $authenticationLibs = [
		'local' => 'Myth\Auth\Authentication\LocalAuthenticator',
	];
	public $views = [
		'login'           => 'hamkamannan\adminigniter\Views\auth\login',
		'register'        => 'hamkamannan\adminigniter\Views\auth\register',
		'forgot'          => 'hamkamannan\adminigniter\Views\auth\forgot',
		'reset'           => 'hamkamannan\adminigniter\Views\auth\reset',
		'emailForgot'     => 'hamkamannan\adminigniter\Views\auth\emails\forgot',
		'emailActivation' => 'hamkamannan\adminigniter\Views\auth\emails\activation',
	];
	public $viewLayout = 'App\Views\Auth\layout';
	public $validFields = [
		'email',
		'username',
	];
	public $personalFields = [
		'first_name',
		'last_name',
	];
	public $maxSimilarity = 50;
	public $allowRegistration = true;
	public $requireActivation = false; 
	public $activeResetter = false;
	public $allowRemembering = true;
	public $rememberLength = 30 * DAY;
	public $silent = false;
	public $hashAlgorithm = PASSWORD_DEFAULT;
	public $hashMemoryCost = 2048; // PASSWORD_ARGON2_DEFAULT_MEMORY_COST;
	public $hashTimeCost = 4; // PASSWORD_ARGON2_DEFAULT_TIME_COST;
	public $hashThreads = 4; // PASSWORD_ARGON2_DEFAULT_THREADS;
	public $hashCost = 10;
	public $minimumPasswordLength = 8;
	public $passwordValidators = [
		'Myth\Auth\Authentication\Passwords\CompositionValidator',
		'Myth\Auth\Authentication\Passwords\NothingPersonalValidator',
		'Myth\Auth\Authentication\Passwords\DictionaryValidator',
		'Myth\Auth\Authentication\Passwords\PwnedValidator',
	];
	public $userActivators = [
		'Myth\Auth\Authentication\Activators\EmailActivator' => [
			'fromEmail' => null,
			'fromName' => null,
		],
	];
	public $userResetters = [
		'Myth\Auth\Authentication\Resetters\EmailResetter' => [
			'fromEmail' => null,
			'fromName' => null,
		],
	];
	public $resetTime = 3600;
}