<?php

Route::when('*', 'csrf', ['POST', 'PUT', 'PATCH', 'DELETE']);


Route::group(['prefix' => config('_auth.routes_prefix')], function()
{
	Route::group(['middleware' => 'guest'], function()
	{
		Route::get(config('_auth.login.route'), ['as' => 'login.index', 'uses' => 'Cerbero\Auth\Http\Controllers\AuthController@showLogin']);
		Route::post(config('_auth.login.route'), ['as' => 'login.store', 'uses' => 'Cerbero\Auth\Http\Controllers\AuthController@login']);

		Route::get(config('_auth.register.route'), ['as' => 'register.index', 'uses' => 'Cerbero\Auth\Http\Controllers\AuthController@showRegister']);
		Route::post(config('_auth.register.route'), ['as' => 'register.store', 'uses' => 'Cerbero\Auth\Http\Controllers\AuthController@register']);

		Route::get(config('_auth.recover.route'), ['as' => 'recover.index', 'uses' => 'Cerbero\Auth\Http\Controllers\AuthController@showRecover']);
		Route::post(config('_auth.recover.route'), ['as' => 'recover.store', 'uses' => 'Cerbero\Auth\Http\Controllers\AuthController@recover']);

		Route::get(config('_auth.reset.route') . '/{token}', ['as' => 'reset.index', 'uses' => 'Cerbero\Auth\Http\Controllers\AuthController@showReset']);
		Route::post(config('_auth.reset.route') . '/{token}', ['as' => 'reset.store', 'uses' => 'Cerbero\Auth\Http\Controllers\AuthController@reset']);
	});


	Route::group(['middleware' => 'auth'], function()
	{
		Route::get(config('_auth.logout.route'), ['as' => 'logout', 'uses' => 'Cerbero\Auth\Http\Controllers\AuthController@logout']);
	});
});
