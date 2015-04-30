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
		if(config('_auth.register.email.generate_password_for_user'))
		{
			$this->password = str_random(8);

			$command->attributes['password'] = $this->password;
		}
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
		if(config('_auth.register.email.send'))
		{
			$email = $handled->email;

			$payload = ['user' => $handled, 'password' => $this->password];

			$mailer->send(config('_auth.register.email.view'), $payload, function($message) use($email)
			{
				$message->to($email)->subject(trans('auth::register.email_subject'));
			});
		}
	}

}
