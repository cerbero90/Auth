<?php

namespace Cerbero\Auth\Services\Dispatcher;

use Exception;
use ArrayAccess;
use ReflectionClass;
use ReflectionParameter;
use Illuminate\Contracts\Bus\Dispatcher;

/**
 * Wrapper to marshal commands before dispatching them.
 *
 * @author	Andrea Marco Sartori
 */
class MarshalDispatcher implements DispatcherInterface
{

	/**
	 * @author	Andrea Marco Sartori
	 * @var		Illuminate\Contracts\Bus\Dispatcher	$dispatcher	Bus dispatcher.
	 */
	protected $dispatcher;

	/**
	 * @author	Andrea Marco Sartori
	 * @var		string  $command	Command to dispatch
	 */
	protected $command;

	/**
	 * @author	Andrea Marco Sartori
	 * @var		\ArrayAccess  $values	Parameters values
	 */
	protected $values;
	
	/**
	 * Set the dependencies.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	Illuminate\Contracts\Bus\Dispatcher	$dispatcher
	 * @return	void
	 */
	public function __construct(Dispatcher $dispatcher)
	{
		$this->dispatcher = $dispatcher;
	}

	/**
     * Set the pipes commands should be piped through before dispatching.
     *
	 * @author	Andrea Marco Sartori
     * @param  array  $pipes
     * @return $this
     */
    public function pipeThrough(array $pipes)
    {
    	$this->dispatcher->pipeThrough($pipes);

    	return $this;
    }

    /**
     * Dispatch a command to its appropriate handler.
     *
     * @author Andrea Marco Sartori
     * @param  mixed  $command
     * @param  \Closure|null  $afterResolving
     * @return mixed
     */
    public function dispatch($command)
    {
        $this->dispatcher->dispatch($command);
    }

    /**
     * Dispatch a command to its appropriate handler in the current process.
     *
     * @author Andrea Marco Sartori
     * @param  mixed  $command
     * @param  \Closure|null  $afterResolving
     * @return mixed
     */
    public function dispatchNow($command)
    {
        $this->dispatcher->dispatchNow($command);
    }

    /**
     * Marshal a command and dispatch it.
     *
	 * @author	Andrea Marco Sartori
     * @param  mixed  $command
     * @param  \ArrayAccess  $source
     * @param  array  $extras
     * @return mixed
     */
    public function dispatchFrom($command, ArrayAccess $source, array $extras = [])
    {
    	$this->command = $command;

    	$this->values = array_merge((array) $source, $extras);

    	return $this->dispatch($this->marshal());
    }

    /**
     * Marshal the command to dispatch.
     *
	 * @author	Andrea Marco Sartori
     * @return mixed
     */
    protected function marshal()
    {
        $reflection = new ReflectionClass($this->command);

        $constructor = $reflection->getConstructor();

        $params = $this->getParamsToInject($constructor->getParameters());

        return $reflection->newInstanceArgs($params);
    }

    /**
     * Retrieve the arguments to inject into the command constructor.
     *
     * @author	Andrea Marco Sartori
     * @param	array	$parameters
     * @return	array
     */
    protected function getParamsToInject(array $parameters)
    {
        return array_map(function ($parameter)
        {
            return $this->grabParameter($parameter);

        }, $parameters);
    }

    /**
     * Get a parameter value for a marshaled command.
     *
	 * @author	Andrea Marco Sartori
     * @param  \ReflectionParameter  $parameter
     * @return mixed
     */
    protected function grabParameter(ReflectionParameter $parameter)
    {
        if (isset($this->values[$parameter->name]))
        {
            return $this->values[$parameter->name];
        }

        if ($parameter->isDefaultValueAvailable())
        {
            return $parameter->getDefaultValue();
        }

        throw new Exception("Unable to map parameter [{$parameter->name}] to command [{$this->command}]");
    }

}
