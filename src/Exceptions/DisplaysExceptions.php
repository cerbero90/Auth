<?php namespace Cerbero\Auth\Exceptions;

use \Exception;

/**
 * Trait to render the exceptions.
 *
 * @author	Andrea Marco Sartori
 */
trait DisplaysExceptions {

	/**
	 * @author	Andrea Marco Sartori
	 * @var		array	$display	Exceptions to display to the user.
	 */
	protected $display = array();

	/**
	 * Determine how to render the DisplayException.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	\Exception	$e
	 * @return	Illuminate\Http\RedirectResponse
	 */
	protected function displayExceptions(Exception $e)
	{
		$this->display[] = 'Cerbero\Auth\Exceptions\DisplayException';

		foreach ($this->display as $exception)
		{
			if($e instanceof $exception)
			{
				return back()->withInput()->withError($e->getMessage());
			}
		}
	}

}
