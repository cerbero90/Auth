<?php namespace Cerbero\Auth\Exceptions;

/**
 * Display an error to the user.
 *
 * @author	Andrea Marco Sartori
 */
class DisplayException extends \Exception {
	
	/**
	 * Set the dependencies.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$message
	 * @return	void
	 */
	public function __construct($message)
	{
		$translation = trans($message);

		parent::__construct($translation);
	}

}
