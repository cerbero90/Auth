<?php namespace Cerbero\Auth\Jobs;

use Cerbero\Auth\Repositories\UserRepositoryInterface;
use Illuminate\Contracts\Bus\SelfHandling;

class RegisterJob implements SelfHandling {

	/**
	 * @author	Andrea Marco Sartori
	 * @var		array	$attributes	User attributes.
	 */
	public $attributes;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$fields = config('_auth.register.fields');

		$this->attributes = app('request')->only($fields);
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle(UserRepositoryInterface $user)
	{
		return $user->register($this->attributes);
	}

}
