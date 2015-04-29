<?php namespace Cerbero\Auth\Commands;

use Cerbero\Auth\Commands\Command;
use Cerbero\Auth\Exceptions\DisplayException;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Bus\SelfHandling;

class LoginCommand extends Command implements SelfHandling {

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
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		list($fields, $remember) = config('_auth.login');

		$this->credentials = app('request')->only($fields);

		$this->remember = app('request')->get($remember, false);
	}

	/**
	 * Execute the command.
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
