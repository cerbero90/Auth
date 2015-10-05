<?php namespace Cerbero\Auth\Pipes;

use \Closure;
use Illuminate\Contracts\Container\Container;

/**
 * Abstract implementation of a pipe.
 *
 * @author	Andrea Marco Sartori
 */
abstract class AbstractPipe {

	/**
	 * @author	Andrea Marco Sartori
	 * @var		Illuminate\Contracts\Container\Container	$container	Service container.
	 */
	protected $container;
	
	/**
	 * Set the dependencies.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	Illuminate\Contracts\Container\Container	$container
	 * @return	void
	 */
	public function __construct(Container $container)
	{
		$this->container = $container;
	}

	/**
	 * Handle the given command.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	mixed	$command
	 * @param	Closure	$next
	 * @return	mixed
	 */
	public function handle($command, Closure $next)
	{
		$this->callBefore($command);

		$handled = $next($command);

		$this->callAfter($handled, $command);

		return $handled;
	}

	/**
	 * Call the before method.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	Cerbero\Commands\Command	$command
	 * @return	void
	 */
	protected function callBefore($command)
	{
		$this->callIfExistsAndEnabled('before', [$command]);
	}

	/**
	 * Call and resolve depepndencies of a method if enabled.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$method
	 * @param	array	$parameters
	 * @return	void
	 */
	private function callIfExistsAndEnabled($method, array $parameters = [])
	{
		if( ! $this->isEnabled()) return;

		if(method_exists($this, $method) && $this->{"{$method}IsEnabled"}())
		{
			$this->container->call([$this, $method], $parameters);
		}
	}

	/**
	 * Determine whether the whole pipe has to be processed.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	boolean
	 */
	protected function isEnabled()
	{
		return true;
	}

	/**
	 * Call the after method.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	mixed	$handled
	 * @param	Cerbero\Commands\Command	$command
	 * @return	void
	 */
	protected function callAfter($handled, $command)
	{
		$this->callIfExistsAndEnabled('after', [$handled, $command]);
	}

	/**
	 * Determine whether the before method has to be processed.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	boolean
	 */
	protected function beforeIsEnabled()
	{
		return true;
	}

	/**
	 * Determine whether the after method has to be processed.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	boolean
	 */
	protected function afterIsEnabled()
	{
		return true;
	}

}
