<?php

Route::group(['prefix' => config('_auth.routes_prefix')], function()
{
	Route::group(['middleware' => ['guest', 'honeypot']], function()
	{
		Route::get(config('_auth.login.route'), ['as' => 'login.index', 'uses' => config('_auth.controller') . '@showLogin']);
		Route::post(config('_auth.login.route'), ['as' => 'login.store', 'uses' => config('_auth.controller') . '@login']);

		Route::get(config('_auth.register.route'), ['as' => 'register.index', 'uses' => config('_auth.controller') . '@showRegister']);
		Route::post(config('_auth.register.route'), ['as' => 'register.store', 'uses' => config('_auth.controller') . '@register']);

		Route::get(config('_auth.recover.route'), ['as' => 'recover.index', 'uses' => config('_auth.controller') . '@showRecover']);
		Route::post(config('_auth.recover.route'), ['as' => 'recover.store', 'uses' => config('_auth.controller') . '@recover']);

		Route::get(config('_auth.reset.route') . '/{token}', ['as' => 'reset.index', 'uses' => config('_auth.controller') . '@showReset']);
		Route::post(config('_auth.reset.route') . '/{token}', ['as' => 'reset.store', 'uses' => config('_auth.controller') . '@reset']);
	});


	Route::group(['middleware' => 'auth'], function()
	{
		Route::get(config('_auth.logout.route'), ['as' => 'logout', 'uses' => config('_auth.controller') . '@logout']);
	});
});
