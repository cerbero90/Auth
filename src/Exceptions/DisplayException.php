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
	 * @param	array	$parameters
	 * @return	void
	 */
	public function __construct($message, array $parameters = [])
	{
		$translation = trans($message, $parameters);

		parent::__construct($translation);
	}

}
