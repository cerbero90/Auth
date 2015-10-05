<?php

namespace Cerbero\Auth\Services\Throttling;

/**
 * Interface for login throttlers.
 *
 * @author	Andrea Marco Sartori
 */
interface ThrottlerInterface
{

	/**
	 * Set univocal source where attempts come from.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	boolean
	 */
	public function setSource($source);

	/**
	 * Determine whether the user has been locked out.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	boolean
	 */
	public function lockedOut();

	/**
	 * Retrieve the number of remaining seconds before the next attempt.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	integer
	 */
	public function getRemainingSeconds();

	/**
	 * Increment the number of failed attempts.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	void
	 */
	public function incrementAttempts();

	/**
	 * Determine whether a user has performed too many attempts.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	boolean
	 */
	public function tooManyAttempts();

	/**
	 * Lock a user out.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	void
	 */
	public function lockOut();

	/**
	 * Reset the attempts counter.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	void
	 */
	public function resetAttempts();

}
