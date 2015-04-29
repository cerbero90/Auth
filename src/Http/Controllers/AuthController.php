<?php namespace Cerbero\Auth\Http\Controllers;

use Cerbero\Workflow\Workflow;
use Illuminate\Routing\Controller;

class AuthController extends Controller {

	/**
	 * @author	Andrea Marco Sartori
	 * @var		Workflow	$workflow	The workflows container.
	 */
	protected $workflow;
	
	/**
	 * Set the dependencies.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	Workflow	$workflow
	 * @return	void
	 */
	public function __construct(Workflow $workflow)
	{
		$this->workflow = $workflow;
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
		$this->workflow->login();

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
		$this->workflow->logout();

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
		$this->workflow->register();

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
		$this->workflow->recover();

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
		$this->workflow->reset();

		return redirect()->route('login.index')->withSuccess(trans('reset.success'));
	}

}
