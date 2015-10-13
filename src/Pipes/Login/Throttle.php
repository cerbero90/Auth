<?php namespace Cerbero\Auth\Pipes\Login;

use Cerbero\Auth\Exceptions\DisplayException;
use Cerbero\Auth\Pipes\AbstractPipe;
use Cerbero\Auth\Services\Throttling\ThrottlerInterface;

class Throttle extends AbstractPipe {

	/**
	 * Run before the job is handled.
	 *
	 * @param	Cerbero\Auth\Services\Throttling\ThrottlerInterface	$throttler
	 * @param	Cerbero\Auth\Jobs\LoginJob	$job
	 * @return	mixed
	 */
	public function before(ThrottlerInterface $throttler, $job)
	{
		$throttler->setSource($this->getSourceByJob($job));

		$throttler->incrementAttempts();

		if($throttler->tooManyAttempts() || $throttler->lockedOut())
		{
			$throttler->lockOut();

			$seconds = $throttler->getRemainingSeconds();

			throw new DisplayException('auth::throttling.error', compact('seconds'));
		}
	}

	/**
	 * Create source by using the given job.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	type	$job
	 * @return	string
	 */
	private function getSourceByJob($job)
	{
		$login = head(array_except($job->credentials, 'password'));

		return $login . app('request')->ip();
	}

	/**
	 * Run after the handled job.
	 *
	 * @param	Cerbero\Auth\Services\Throttling\ThrottlerInterface	$throttler
	 * @param	mixed	$handled
	 * @param	Cerbero\Auth\Jobs\LoginJob	$job
	 * @return	mixed
	 */
	public function after(ThrottlerInterface $throttler, $handled, $job)
	{
		$throttler->resetAttempts();
	}

	/**
	 * Determine whether the whole pipe has to be processed.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	boolean
	 */
	protected function isEnabled()
	{
		return config('_auth.login.throttling.enabled');
	}

}
