<?php namespace Cerbero\Auth\Jobs;

use Illuminate\Contracts\Bus\SelfHandling;

class RecoverJob implements SelfHandling {

	/**
	 * @author	Andrea Marco Sartori
	 * @var		string	$email	Email input.
	 */
	public $email;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct($email)
	{
		$this->email = $email;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		return str_random(10);
	}

}
