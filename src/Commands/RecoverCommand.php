<?php namespace Cerbero\Auth\Commands;

use Cerbero\Auth\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Hashing\Hasher;

class RecoverCommand extends Command implements SelfHandling {

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
	public function handle(Hasher $hasher)
	{
		$hash = $hasher->make($this->email . microtime());

		return substr($hash, 50);
	}

}
