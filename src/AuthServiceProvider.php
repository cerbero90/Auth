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
		$authViewsPath = __DIR__.'/../resources/views';

		$authConfigFile = __DIR__.'/../config/auth.php';

		$this->loadViewsFrom($authViewsPath, 'auth');

		$this->publishes([
			$authViewsPath => base_path('resources/views/vendor/auth'),
			$authConfigFile => config_path('vendor/auth/auth.php'),
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

		(new HtmlServiceProvider($this->app))->register();
	}

}
