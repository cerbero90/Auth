<?php

namespace Cerbero\Auth\Http\Middleware;

use Closure;
use Cerbero\Auth\Exceptions\DisplayException;

/**
 * Protect from spam and bots.
 *
 * @author	Andrea Marco Sartori
 */
class Honeypot
{

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if(config('_auth.honeypot.enabled'))
		{
			$value = $request->input(config('_auth.honeypot.field'));

			$this->checkHoneypot($value);
		}

		return $next($request);
	}

	/**
	 * Throw an exception if the honeypot field is not empty.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$value
	 * @return	void
	 */
	protected function checkHoneypot($value)
	{
		if($value != null)
		{
			throw new DisplayException('auth::honeypot.error');
		}
	}

}
