<?php

namespace hamkamannan\adminigniter\Controllers;

class Home extends BaseController
{
	protected $auth;
    protected $authorize;
    protected $session;
    protected $config;

    function __construct()
    {
        $this->auth = \Myth\Auth\Config\Services::authentication();
        $this->authorize = \Myth\Auth\Config\Services::authorization();

        $this->session = service('session');
		$this->config = config('Auth');

        helper(['app','auth']);
    }

	public function index()
	{
		if (! $this->auth->check() )
		{
			$this->session->set('redirect_url', current_url() );
			return redirect()->route('login');
		} else {
			return redirect()->route('dashboard');
		}
	}
}
