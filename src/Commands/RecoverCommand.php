<?php namespace Cerbero\Auth\Commands;

use Illuminate\Contracts\Bus\SelfHandling;

class RecoverCommand implements SelfHandling {

	/**
	 * @author	Andrea Marco Sartori
	 * @var		string	$email	Email input.
	 */
	public $email;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($email)
	{
		$this->email = $email;
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
		return str_random(10);
	}

}
