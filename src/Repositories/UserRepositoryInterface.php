<?php namespace Cerbero\Auth\Repositories;

/**
 * Interface for user repositories.
 *
 * @author	Andrea Marco Sartori
 */
interface UserRepositoryInterface {

	/**
	 * Register a new user.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	array	$attributes
	 * @return	mixed
	 */
	public function register(array $attributes);

	/**
	 * Assign a token to reset the password of the user with the given email.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$token
	 * @param	string	$email
	 * @return	void
	 */
	public function assignResetToken($token, $email);

	/**
	 * Retrieve the user with the given reset token.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$token
	 * @return	mixed|null
	 */
	public function findByResetToken($token);

	/**
	 * Reset the password of the given user.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	mixed	$user
	 * @return	void
	 */
	public function resetPassword($user, $password);

}
