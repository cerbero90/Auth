<?php namespace Cerbero\Auth\Commands;

use Cerbero\Auth\Exceptions\DisplayException;
use Cerbero\Auth\Repositories\UserRepositoryInterface;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Hashing\Hasher;

class ResetCommand implements SelfHandling {

	/**
	 * @author	Andrea Marco Sartori
	 * @var		string	$password	Password input.
	 */
	public $password;

	/**
	 * @author	Andrea Marco Sartori
	 * @var		string	$token	Reset token.
	 */
	public $token;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($password, $token)
	{
		$this->password = $password;

		$this->token = $token;
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle(UserRepositoryInterface $users, Hasher $hasher)
	{
		if( ! $user = $users->findByResetToken($this->token))
		{
			throw new DisplayException('auth::reset.error');
		}

		$users->resetPassword($user, $hasher->make($this->password));
	}

}
