<?php namespace Cerbero\Auth\Commands;

use Cerbero\Auth\Commands\Command;
use Cerbero\Auth\Exceptions\DisplayException;
use Cerbero\Auth\Repositories\Users\UserRepositoryInterface;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Routing\Router;

class ResetCommand extends Command implements SelfHandling {

	/**
	 * @author	Andrea Marco Sartori
	 * @var		string	$password	Password input.
	 */
	public $password;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($password)
	{
		$this->password = $password;
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle(Router $route, UserRepositoryInterface $users, Hasher $hasher)
	{
		$token = $route->input('token');

		if( ! $user = $users->findByResetToken($token))
		{
			throw new DisplayException('auth::reset.error');
		}

		$users->resetPassword($user, $hasher->make($this->password));
	}

}
