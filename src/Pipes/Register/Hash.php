<?php namespace Cerbero\Auth\Workflows\Register;

use Cerbero\Workflow\Pipes\AbstractPipe;
use Illuminate\Contracts\Hashing\Hasher;

class Hash extends AbstractPipe {

	/**
	 * Run before the command is handled.
	 *
	 * @param	Illuminate\Contracts\Hashing\Hasher
	 * @param	Cerbero\Auth\Commands\Command	$command
	 * @return	mixed
	 */
	public function before(Hasher $hasher, $command)
	{
		if($hasher->needsRehash($password = $command->attributes['password']))
		{
			$command->attributes['password'] = $hasher->make($password);
		}
	}

	/**
	 * Run after the handled command.
	 *
	 * @param	mixed	$handled
	 * @param	Cerbero\Auth\Commands\Command	$command
	 * @return	mixed
	 */
	public function after($handled, $command)
	{
		//
	}

}
