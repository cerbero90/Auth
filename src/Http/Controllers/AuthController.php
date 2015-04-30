<?php namespace Cerbero\Auth\Http\Controllers;

use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Routing\Controller;

class AuthController extends Controller {

	/**
	 * @author	Andrea Marco Sartori
	 * @var		Illuminate\Contracts\Bus\Dispatcher	$bus	Command bus dispatcher.
	 */
	protected $bus;
	
	/**
	 * Set the dependencies.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	Illuminate\Contracts\Bus\Dispatcher	$bus
	 * @return	void
	 */
	public function __construct(Dispatcher $bus)
	{
		$this->bus = $bus;
	}

	/**
	 * Display the login page.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	Illuminate\Http\Response
	 */
	public function showLogin()
	{
		$login = config('_auth.login.view');

		return view($login);
	}

	/**
	 * Log the user in.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	Illuminate\Http\RedirectResponse
	 */
	public function login()
	{
		$this->bus->dispatchFrom(
			'Cerbero\Auth\Commands\LoginCommand',
			'Cerbero\Auth\Http\Requests\LoginRequest'
		);

		return redirect('/');
	}

	/**
	 * Log the user out.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	Illuminate\Http\RedirectResponse
	 */
	public function logout()
	{
		$this->bus->dispatchNow('Cerbero\Auth\Commands\LogoutCommand');

		return redirect('/');
	}

	/**
	 * Display the registration page.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	Illuminate\Http\Response
	 */
	public function showRegister()
	{
		$register = config('_auth.register.view');

		return view($register);
	}

	/**
	 * Register the user.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	Illuminate\Http\RedirectResponse
	 */
	public function register()
	{
		$this->bus->pipeThrough([
			'Cerbero\Auth\Pipes\Register\Login',
			'Cerbero\Auth\Pipes\Register\Notify',
			'Cerbero\Auth\Pipes\Register\Hash',

		])->dispatchFrom(
			'Cerbero\Auth\Commands\RegisterCommand',
			'Cerbero\Auth\Http\Requests\RegisterRequest'
		);

		return redirect('/')->withSuccess(trans('auth::register.success'));
	}

	/**
	 * Display the recover page.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	Illuminate\Http\Response
	 */
	public function showRecover()
	{
		$recover = config('_auth.recover.view');

		return view($recover);
	}

	/**
	 * Remember the user password.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	Illuminate\Http\RedirectResponse
	 */
	public function recover()
	{
		$this->bus->pipeThrough([
			'Cerbero\Auth\Pipes\Recover\Notify',
			'Cerbero\Auth\Pipes\Recover\Store',

		])->dispatchFrom(
			'Cerbero\Auth\Commands\RecoverCommand',
			'Cerbero\Auth\Http\Requests\RecoverRequest'
		);

		return back()->withSuccess(trans('auth::recover.success'));
	}

	/**
	 * Display the reset page.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	Illuminate\Http\Response
	 */
	public function showReset($token)
	{
		$reset = config('_auth.reset.view');

		return view($reset);
	}

	/**
	 * Reset the user password.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	Illuminate\Http\RedirectResponse
	 */
	public function reset($token)
	{
		$this->bus->dispatchFrom(
			'Cerbero\Auth\Commands\ResetCommand',
			'Cerbero\Auth\Http\Requests\ResetRequest'
		);

		return redirect()->route('login.index')->withSuccess(trans('reset.success'));
	}

}
