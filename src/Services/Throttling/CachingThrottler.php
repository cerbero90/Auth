<?php

namespace Cerbero\Auth\Services\Throttling;

use Illuminate\Contracts\Cache\Repository as Cache;

/**
 * Login throttler using cache.
 *
 * @author	Andrea Marco Sartori
 */
class CachingThrottler implements ThrottlerInterface
{

	/**
	 * @author	Andrea Marco Sartori
	 * @var		Illuminate\Contracts\Cache\Repository	$cache	Cache repository.
	 */
	protected $cache;

	/**
	 * @author	Andrea Marco Sartori
	 * @var		string	$key	Source where attempts come from.
	 */
	protected $key;

	/**
	 * @author	Andrea Marco Sartori
	 * @var		string	$lockOutKey	Key to store lock out time in.
	 */
	protected $lockOutKey;
	
	/**
	 * Set the dependencies.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	Illuminate\Contracts\Cache\Repository	$cache
	 * @return	void
	 */
	public function __construct(Cache $cache)
	{
		$this->cache = $cache;
	}

	/**
	 * Set univocal source where attempts come from.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	boolean
	 */
	public function setSource($source)
	{
		$this->key = $source;

		$this->lockOutKey = "{$source}:lockout";
	}

	/**
	 * Determine whether the user has been locked out.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	boolean
	 */
	public function lockedOut()
	{
		return $this->cache->has($this->lockOutKey);
	}

	/**
	 * Retrieve the number of remaining seconds before the next attempt.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	integer
	 */
	public function getRemainingSeconds()
	{
		return $this->cache->get($this->lockOutKey) - time();
	}

	/**
	 * Increment the number of failed attempts.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	void
	 */
	public function incrementAttempts()
	{
		$this->cache->add($this->key, 0, $this->getExpiry());

		$this->cache->increment($this->key);
	}

	/**
	 * Retrieve the minutes after which keys expire.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	integer
	 */
	private function getExpiry()
	{
		return (int) $this->getDelay() / 60;
	}

	/**
	 * Retrieve the seconds to wait before the next attempt.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	integer
	 */
	private function getDelay()
	{
		return config('_auth.login.throttling.delay');
	}

	/**
	 * Determine whether a user has performed too many attempts.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	boolean
	 */
	public function tooManyAttempts()
	{
		$maximum = config('_auth.login.throttling.max_attempts');

		return $this->cache->get($this->key, 0) > $maximum;
	}

	/**
	 * Lock a user out.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	void
	 */
	public function lockOut()
	{
		$this->resetAttempts();

		$this->cache->add($this->lockOutKey, $this->getDelay() + time(), $this->getExpiry());
	}

	/**
	 * Reset the attempts counter.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	void
	 */
	public function resetAttempts()
	{
		$this->cache->forget($this->key);
	}

}
