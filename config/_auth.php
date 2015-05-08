<?php

return array(

	# prefix for your authentication routes e.g. auth/login
	'routes_prefix' => 'auth',

	'login' => [

		# route where the user logs in
		'route' => 'login',

		# the name of the route where the user is redirected after logging in
		'redirect' => 'dashboard',

		# the view used to display the login page
		'view' => 'auth.login',

		# the rules to validate the login fields
		'rules' => [
			'email' => 'required|email',
			'password' => 'required',
		],

		# the fields of the login form
		'fields' => ['email', 'password'],

		# the name of the "Remember me" checkbox, set null if not present
		'remember_me' => 'remember',
	],

	'register' => [

		# route where the user registers his account
		'route' => 'register',

		# the name of the route where the user is redirected after logging in
		'redirect' => 'login.index',

		# the view used to display the registration page
		'view' => 'auth.register',

		# the rules to validate the registration fields
		'rules' => [
			'email' => 'required|email|unique:users',
			'password' => 'required|min:6|confirmed',
		],

		# the fields of the registration form
		'fields' => ['email', 'password'],

		# do you want to log in the user after his registration?
		'login_after_registering' => false,

		'email' => [

			# do you want to send a welcome email?
			'send' => true,

			# do you want to enqueue email sending?
			'queue' => false,

			# the view used to display the welcome email
			'view' => 'emails.register',

			# do you want to generate a password for the user?
			# you can show it in the welcome email by using {{ $password }}
			'generate_password_for_user' => false,
		],
	],

	'recover' => [

		# route where the user recovers his password
		'route' => 'recover',

		# the view used to display the password recovery page
		'view' => 'auth.recover',

		# the rules to validate the recovery fields
		'rules' => [
			'email' => 'required|email|exists:users,email'
		],

		'email' => [

			# the view used to display the recovery email
			'view' => 'emails.recover',

			# do you want to enqueue email sending?
			'queue' => false,
		],
	],

	'reset' => [

		# route where the user resets his password
		'route' => 'reset',

		# the view used to display the password reset page
		'view' => 'auth.reset',

		# the rules to validate the reset fields
		'rules' => [
			'password' => 'required|min:6|confirmed'
		],
	],

	'logout' => [

		# route where the user logs out
		'route' => 'logout',

		# the name of the route where the user is redirected after logging in
		'redirect' => 'home',
	],

);
