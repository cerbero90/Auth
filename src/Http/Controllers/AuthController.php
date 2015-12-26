<?php namespace Cerbero\Auth\Http\Controllers;

use Cerbero\Auth\Jobs\LoginJob;
use Cerbero\Auth\Jobs\LogoutJob;
use Cerbero\Auth\Jobs\RegisterJob;
use Cerbero\Auth\Jobs\RecoverJob;
use Cerbero\Auth\Jobs\ResetJob;
use Cerbero\Auth\Http\Requests\LoginRequest;
use Cerbero\Auth\Http\Requests\RecoverRequest;
use Cerbero\Auth\Http\Requests\RegisterRequest;
use Cerbero\Auth\Http\Requests\ResetRequest;
use Cerbero\Auth\Services\Dispatcher\DispatcherInterface;
use Illuminate\Routing\Controller;

class AuthController extends Controller {

	/**
	 * @author	Andrea Marco Sartori
	 * @var		Cerbero\Auth\Services\Dispatcher\DispatcherInterface	$bus	Bus dispatcher.
	 */
	protected $bus;

	/**
	 * @author	Andrea Marco Sartori
	 * @var		array	$loginPipes	List of pipes for the login process.
	 */
	protected $loginPipes = ['DispatchEvent', 'Throttle'];

	/**
	 * @author	Andrea Marco Sartori
	 * @var		array	$logoutPipes	List of pipes for the logout process.
	 */
	protected $logoutPipes = ['DispatchEvent'];

	/**
	 * @author	Andrea Marco Sartori
	 * @var		array	$registerPipes	List of pipes for the register process.
	 */
	protected $registerPipes = ['DispatchEvent', 'Login', 'Notify', 'Hash'];

	/**
	 * @author	Andrea Marco Sartori
	 * @var		array	$recoverPipes	List of pipes for the password recover process.
	 */
	protected $recoverPipes = ['DispatchEvent', 'Notify', 'Store'];

	/**
	 * @author	Andrea Marco Sartori
	 * @var		array	$resetPipes	List of pipes for the password reset process.
	 */
	protected $resetPipes = ['DispatchEvent'];
	
	/**
	 * Set the dependencies.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	Cerbero\Auth\Services\Dispatcher\DispatcherInterface	$bus
	 * @return	void
	 */
	public function __construct(DispatcherInterface $bus)
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
	public function login(LoginRequest $request)
	{
		$this->bus->pipeThrough($this->pipesOf('login'))->dispatchFrom(LoginJob::class, $request);

		return redirect()->route(config('_auth.login.redirect'));
	}

	/**
	 * Retrieve the pipes of a given process.
	 *
	 * @author	Andrea Marco Sartori
	 * @param	string	$process
	 * @return	array
	 */
	protected function pipesOf($process)
	{
		$Process = ucfirst($process);

		return array_map(function($pipe) use($Process)
		{
			return "Cerbero\Auth\Pipes\\{$Process}\\{$pipe}";

		}, $this->{"{$process}Pipes"});
	}

	/**
	 * Log the user out.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	Illuminate\Http\RedirectResponse
	 */
	public function logout()
	{
		$this->bus->pipeThrough($this->pipesOf('logout'))->dispatchNow(new LogoutJob);

		return redirect()->route(config('_auth.logout.redirect'));
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
	public function register(RegisterRequest $request)
	{
		$this->bus->pipeThrough($this->pipesOf('register'))->dispatchFrom(RegisterJob::class, $request);

		return redirect()->route(config('_auth.register.redirect'))->withSuccess(trans('auth::register.success'));
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
	public function recover(RecoverRequest $request)
	{
		$this->bus->pipeThrough($this->pipesOf('recover'))->dispatchFrom(RecoverJob::class, $request);

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
	public function reset(ResetRequest $request, $token)
	{
		$this->bus->pipeThrough($this->pipesOf('reset'))->dispatchFrom(ResetJob::class, $request, compact('token'));

		return redirect()->route('login.index')->withSuccess(trans('auth::reset.success'));
	}

}
