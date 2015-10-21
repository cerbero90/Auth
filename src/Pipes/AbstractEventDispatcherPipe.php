<?php namespace Cerbero\Auth\Pipes;

use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;

/**
 * Abstract implementation of a pipe that dispatches events.
 *
 * @author	Andrea Marco Sartori
 */
abstract class AbstractEventDispatcherPipe extends AbstractPipe {

	/**
	 * @author	Andrea Marco Sartori
	 * @var		Illuminate\Contracts\Events\Dispatcher	$dispatcher	Event dispatcher.
	 */
	protected $dispatcher;
	
	/**
	 * Set the dependencies.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	Illuminate\Contracts\Container\Container	$container
	 * @param	Illuminate\Contracts\Events\Dispatcher	$dispatcher
	 * @return	void
	 */
	public function __construct(Container $container, Dispatcher $dispatcher)
	{
		parent::__construct($container);

		$this->dispatcher = $dispatcher;
	}

	/**
	 * Run before the job is handled.
	 *
	 * @param	mixed	$job
	 * @return	mixed
	 */
	public function before($job)
	{
		$this->fireEventOn('start', $job);
	}

	/**
	 * Fire an event at some point.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$action
	 * @param	mixed	$payload
	 * @return	void
	 */
	private function fireEventOn($action, $payload)
	{
		$event = $this->getEventName();

		$this->dispatcher->fire("auth.{$event}.{$action}", $payload);
	}

	/**
	 * Retrieve the event name.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	string
	 */
	protected function getEventName()
	{
		$chunks = explode('\\', get_class($this));

		$name = $chunks[count($chunks) - 2];

		return strtolower($name);
	}

	/**
	 * Run after the handled job.
	 *
	 * @param	mixed	$handled
	 * @param	mixed	$job
	 * @return	mixed
	 */
	public function after($handled, $job)
	{
		$this->fireEventOn('end', [$handled, $job]);
	}

}
