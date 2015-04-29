<?php namespace Cerbero\Auth\Commands;

use Cerbero\Auth\Commands\Command;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Bus\SelfHandling;

class LogoutCommand extends Command implements SelfHandling {

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle(Guard $auth)
	{
		$auth->logout();
	}

}
