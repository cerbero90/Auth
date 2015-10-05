<?php namespace Cerbero\Auth\Pipes\Login;

use Cerbero\Auth\Exceptions\DisplayException;
use Cerbero\Auth\Pipes\AbstractPipe;
use Cerbero\Auth\Services\Throttling\ThrottlerInterface;

class Throttle extends AbstractPipe {

	/**
	 * Run before the command is handled.
	 *
	 * @param	Cerbero\Auth\Services\Throttling\ThrottlerInterface	$throttler
	 * @param	Cerbero\Auth\Commands\Command	$command
	 * @return	mixed
	 */
	public function before(ThrottlerInterface $throttler, $command)
	{
		$throttler->setSource($this->getSourceByCommand($command));

		$throttler->incrementAttempts();

		if($throttler->tooManyAttempts() || $throttler->lockedOut())
		{
			$throttler->lockOut();

			$seconds = $throttler->getRemainingSeconds();

			throw new DisplayException('auth::throttling.error', compact('seconds'));
		}
	}

	/**
	 * Create source by using the given command.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	type	$command
	 * @return	string
	 */
	private function getSourceByCommand($command)
	{
		$login = head(array_except($command->credentials, 'password'));

		return $login . app('request')->ip();
	}

	/**
	 * Run after the handled command.
	 *
	 * @param	Cerbero\Auth\Services\Throttling\ThrottlerInterface	$throttler
	 * @param	mixed	$handled
	 * @param	Cerbero\Auth\Commands\Command	$command
	 * @return	mixed
	 */
	public function after(ThrottlerInterface $throttler, $handled, $command)
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
