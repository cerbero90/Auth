<?php namespace Cerbero\Auth;

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

		$this->publishes([__DIR__.'/../config/_auth.php' => config_path('_auth.php')], 'config');

		$this->publishes([__DIR__.'/../database/migrations/' => database_path('migrations')], 'migration');

		$this->publishes([__DIR__.'/../resources/lang/' => base_path('resources/lang/vendor/auth')], 'lang');

		include __DIR__.'/Http/routes.php';
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerUserRepository();

		$this->registerThrottler();
	}

	/**
	 * Register the user repository.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	void
	 */
	private function registerUserRepository()
	{
		$userRepo = 'Cerbero\Auth\Repositories\EloquentUserRepository';

		$this->app->bind('Cerbero\Auth\Repositories\UserRepositoryInterface', $userRepo);
	}

	/**
	 * Register the login throttling service.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	void
	 */
	private function registerThrottler()
	{
		$throttler = 'Cerbero\Auth\Services\Throttling\CachingThrottler';

		$this->app->bind('Cerbero\Auth\Services\Throttling\ThrottlerInterface', $throttler);
	}

}
