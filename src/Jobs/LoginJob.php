<?php namespace Cerbero\Auth\Jobs;

use Cerbero\Auth\Exceptions\DisplayException;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Bus\SelfHandling;

class LoginJob implements SelfHandling {

	/**
	 * @author	Andrea Marco Sartori
	 * @var		array	$credentials	Credentials.
	 */
	public $credentials;

	/**
	 * @author	Andrea Marco Sartori
	 * @var		boolean	$remember	Whether to remember the session.
	 */
	public $remember;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->credentials = app('request')->only(config('_auth.login.fields'));

		$this->remember = app('request')->get(config('_auth.login.remember_me'), false);
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle(Guard $auth)
	{
		if( ! $auth->attempt($this->credentials, $this->remember))
		{
			throw new DisplayException('auth::login.error');
		}
	}

}
