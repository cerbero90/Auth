<?php

namespace Cerbero\Auth\Services\Dispatcher;

use ArrayAccess;

interface DispatcherInterface
{

    /**
     * Set the pipes commands should be piped through before dispatching.
     *
     * @author Andrea Marco Sartori
     * @param  array  $pipes
     * @return $this
     */
    public function pipeThrough(array $pipes);

    /**
     * Dispatch a command to its appropriate handler.
     *
     * @author Andrea Marco Sartori
     * @param  mixed  $command
     * @param  \Closure|null  $afterResolving
     * @return mixed
     */
    public function dispatch($command);

    /**
     * Dispatch a command to its appropriate handler in the current process.
     *
     * @author Andrea Marco Sartori
     * @param  mixed  $command
     * @param  \Closure|null  $afterResolving
     * @return mixed
     */
    public function dispatchNow($command);

    /**
     * Marshal a command and dispatch it.
     *
     * @author Andrea Marco Sartori
     * @param  mixed  $command
     * @param  \ArrayAccess  $source
     * @param  array  $extras
     * @return mixed
     */
    public function dispatchFrom($command, ArrayAccess $source, array $extras = []);

}
