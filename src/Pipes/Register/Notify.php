<?php namespace Cerbero\Auth\Pipes\Register;

use Cerbero\Auth\Pipes\AbstractPipe;
use Illuminate\Contracts\Mail\Mailer;

class Notify extends AbstractPipe {

	/**
	 * @author	Andrea Marco Sartori
	 * @var		string	$password	Generated password.
	 */
	protected $password = null;

	/**
	 * Run before the command is handled.
	 *
	 * @param	Cerbero\Auth\Commands\Command	$command
	 * @return	mixed
	 */
	public function before($command)
	{
		$this->password = str_random(8);

		$command->attributes['password'] = $this->password;
	}

	/**
	 * Determine whether the before method has to be processed.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	boolean
	 */
	protected function beforeIsEnabled()
	{
		return config('_auth.register.email.generate_password_for_user');
	}

	/**
	 * Run after the handled command.
	 *
	 * @param	Illuminate\Contracts\Mail\Mailer	$mailer
	 * @param	mixed	$handled
	 * @param	Cerbero\Auth\Commands\Command	$command
	 * @return	mixed
	 */
	public function after(Mailer $mailer, $handled, $command)
	{
		$email = $handled->email;

		$payload = ['user' => $handled, 'password' => $this->password];

		$method = config('_auth.register.email.queue') ? 'queue' : 'send';

		$mailer->$method(config('_auth.register.email.view'), $payload, function($message) use($email)
		{
			$message->to($email)->subject(trans('auth::register.email_subject'));
		});
	}

	/**
	 * Determine whether the after method has to be processed.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	boolean
	 */
	protected function afterIsEnabled()
	{
		return config('_auth.register.email.send');
	}

}
