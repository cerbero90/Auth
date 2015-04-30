<?php namespace Cerbero\Auth\Pipes\Recover;

use Cerbero\Auth\Pipes\AbstractPipe;
use Illuminate\Contracts\Mail\Mailer;

class Notify extends AbstractPipe {

	/**
	 * Run before the command is handled.
	 *
	 * @param	Cerbero\Auth\Commands\Command	$command
	 * @return	mixed
	 */
	public function before($command)
	{
		//
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
		$email = $command->email;

		$mailer->send(config('_auth.recover.email_view'), ['token' => $handled], function($message) use($email)
		{
			$message->to($email)->subject(trans('auth::recover.email_subject'));
		});
	}

}
