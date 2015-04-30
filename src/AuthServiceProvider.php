<?php namespace Cerbero\Auth;

use Cerbero\Workflow\WorkflowServiceProvider;
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
			__DIR__.'/../database/migrations/' => base_path('database/migrations'),
		]);

		include __DIR__.'/Http/routes.php';
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$userRepo = 'Cerbero\Auth\Repositories\EloquentUserRepository';

		$this->app->bind('Cerbero\Auth\Repositories\UserRepositoryInterface', $userRepo);
	}

}
