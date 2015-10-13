<?php namespace Cerbero\Auth\Jobs;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Bus\SelfHandling;

class LogoutJob implements SelfHandling {

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle(Guard $auth)
	{
		$auth->logout();
	}

}
