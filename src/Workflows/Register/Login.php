<?php namespace Cerbero\Auth\Workflows\Register;

use Cerbero\Workflow\Pipes\AbstractPipe;
use Illuminate\Contracts\Auth\Guard;

class Login extends AbstractPipe {

	/**
	 * Run before the command is handled.
	 *
	 * @param	Cerbero\Auth\Commands\Command	$command
	 * @return	mixed
	 */
	public function before($command)
	{
		//
	}

	/**
	 * Run after the handled command.
	 *
	 * @param	Illuminate\Contracts\Auth\Guard	$auth
	 * @param	mixed	$handled
	 * @param	Cerbero\Auth\Commands\Command	$command
	 * @return	mixed
	 */
	public function after(Guard $auth, $handled, $command)
	{
		if(config('_auth.register.login_after_registering'))
		{
			$auth->login($handled);
		}
	}

}
