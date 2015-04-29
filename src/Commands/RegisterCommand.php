<?php namespace Cerbero\Auth\Commands;

use Cerbero\Auth\Commands\Command;
use Cerbero\Auth\Repositories\Users\UserRepositoryInterface;
use Illuminate\Contracts\Bus\SelfHandling;

class RegisterCommand extends Command implements SelfHandling {

	/**
	 * @author	Andrea Marco Sartori
	 * @var		array	$attributes	User attributes.
	 */
	public $attributes;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$fields = config('_auth.register.fields');

		$this->attributes = app('request')->only($fields);
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle(UserRepositoryInterface $user)
	{
		return $user->register($this->attributes);
	}

}