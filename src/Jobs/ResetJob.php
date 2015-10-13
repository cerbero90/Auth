<?php namespace Cerbero\Auth\Jobs;

use Cerbero\Auth\Exceptions\DisplayException;
use Cerbero\Auth\Repositories\UserRepositoryInterface;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Hashing\Hasher;

class ResetJob implements SelfHandling {

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
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct($password, $token)
	{
		$this->password = $password;

		$this->token = $token;
	}

	/**
	 * Execute the job.
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
