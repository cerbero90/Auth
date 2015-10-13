<?php namespace Cerbero\Auth\Pipes\Register;

use Cerbero\Auth\Pipes\AbstractPipe;
use Illuminate\Contracts\Hashing\Hasher;

class Hash extends AbstractPipe {

	/**
	 * Run before the job is handled.
	 *
	 * @param	Illuminate\Contracts\Hashing\Hasher
	 * @param	Cerbero\Auth\Jobs\RegisterJob	$job
	 * @return	mixed
	 */
	public function before(Hasher $hasher, $job)
	{
		if($hasher->needsRehash($password = $job->attributes['password']))
		{
			$job->attributes['password'] = $hasher->make($password);
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
