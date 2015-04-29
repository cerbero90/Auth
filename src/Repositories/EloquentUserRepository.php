<?php namespace Cerbero\Auth\Repositories;

/**
 * Eloquent repository for users.
 *
 * @author	Andrea Marco Sartori
 */
class EloquentUserRepository implements UserRepositoryInterface {

	/**
	 * @author	Andrea Marco Sartori
	 * @var		User	$user	User model.
	 */
	protected $user;
	
	/**
	 * Set the dependencies.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	void
	 */
	public function __construct()
	{
		$user = config('_auth.users.model');

		$this->user = new $user;
	}

	/**
	 * Register a new user.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	array	$attributes
	 * @return	User
	 */
	public function register(array $attributes)
	{
		return $this->user->create($attributes);
	}

	/**
	 * Assign a token to reset the password of the user with the given email.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$token
	 * @param	string	$email
	 * @return	void
	 */
	public function assignResetToken($token, $email)
	{
		$user = $this->user->whereEmail($email)->first();

		$user->reset_token = $token;

		$user->save();
	}

	/**
	 * Retrieve the user with the given reset token.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$token
	 * @return	User|null
	 */
	public function findByResetToken($token)
	{
		return $this->user->whereResetToken($token)->first();
	}

	/**
	 * Reset the password of the given user.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	User	$user
	 * @param	string	$password
	 * @return	boolean
	 */
	public function resetPassword($user, $password)
	{
		$user->password = $password;

		$user->reset_token = null;

		$user->save();
	}

}
