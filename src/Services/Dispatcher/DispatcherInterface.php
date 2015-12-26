<?php

namespace Cerbero\Auth\Services\Dispatcher;

use ArrayAccess;

interface DispatcherInterface
{

    /**
     * Set the pipes commands should be piped through before dispatching.
     *
     * @param  array  $pipes
     * @return $this
     */
    public function pipeThrough(array $pipes);

    /**
     * Marshal a command and dispatch it.
     *
     * @param  mixed  $command
     * @param  \ArrayAccess  $source
     * @param  array  $extras
     * @return mixed
     */
    public function dispatchFrom($command, ArrayAccess $source, array $extras = []);

}
