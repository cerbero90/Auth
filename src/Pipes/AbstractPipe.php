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
	 * Handle the given job.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	mixed	$job
	 * @param	Closure	$next
	 * @return	mixed
	 */
	public function handle($job, Closure $next)
	{
		$this->callBefore($job);

		$handled = $next($job);

		$this->callAfter($handled, $job);

		return $handled;
	}

	/**
	 * Call the before method.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	Cerbero\Jobs\Job	$job
	 * @return	void
	 */
	protected function callBefore($job)
	{
		$this->callIfExistsAndEnabled('before', [$job]);
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
	 * @param	Cerbero\Jobs\Job	$job
	 * @return	void
	 */
	protected function callAfter($handled, $job)
	{
		$this->callIfExistsAndEnabled('after', [$handled, $job]);
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
