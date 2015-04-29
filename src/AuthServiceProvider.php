<?php namespace Cerbero\Auth;

use Cerbero\Workflow\WorkflowServiceProvider;
use Collective\Html\HtmlServiceProvider;
use Illuminate\Support\ServiceProvider;

/**
 * Package service provider.
 *
 * @author	Andrea Marco Sartori
 */
class AuthServiceProvider extends ServiceProvider {

	/**
	 * Boot up the package.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'auth');

		$this->publishes([
			__DIR__.'/../config/_auth.php' => config_path('_auth.php'),
			__DIR__.'/../database/migrations/' => database_path('migrations'),
		]);

		include __DIR__.'/../routes.php';
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		(new WorkflowServiceProvider($this->app))->register();

		$userRepo = 'Cerbero\Auth\Repositories\EloquentUserRepository';

		$this->app->bind('Cerbero\Auth\Repositories\UserRepositoryInterface', $userRepo);
	}

}
