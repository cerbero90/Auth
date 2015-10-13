<?php namespace Cerbero\Auth\Pipes\Register;

use Cerbero\Auth\Pipes\AbstractPipe;
use Illuminate\Contracts\Auth\Guard;

class Login extends AbstractPipe {

	/**
	 * Run after the handled job.
	 *
	 * @param	Illuminate\Contracts\Auth\Guard	$auth
	 * @param	mixed	$handled
	 * @param	Cerbero\Auth\Jobs\LoginJob	$job
	 * @return	mixed
	 */
	public function after(Guard $auth, $handled, $job)
	{
		$auth->login($handled);
	}

	/**
	 * Determine whether the after method has to be processed.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	boolean
	 */
	protected function afterIsEnabled()
	{
		return config('_auth.register.login_after_registering');
	}

}
