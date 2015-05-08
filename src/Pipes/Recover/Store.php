<?php namespace Cerbero\Auth\Pipes\Recover;

use Cerbero\Auth\Pipes\AbstractPipe;
use Cerbero\Auth\Repositories\UserRepositoryInterface;

class Store extends AbstractPipe {

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
	 * @param	Cerbero\Auth\Repositories\UserRepositoryInterface	$user
	 * @param	mixed	$handled
	 * @param	Cerbero\Auth\Commands\Command	$command
	 * @return	mixed
	 */
	public function after(UserRepositoryInterface $user, $handled, $command)
	{
		$user->assignResetToken($handled, $command->email);
	}

}
