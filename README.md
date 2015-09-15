![](http://s17.postimg.org/wh7x5m5m3/1430033673_lock_mini.jpg "Auth")
# Auth

[![Author](http://img.shields.io/badge/author-@cerbero90-blue.svg?style=flat-square)](https://twitter.com/cerbero90)
[![Build Status](https://img.shields.io/travis/cerbero90/Auth/master.svg?style=flat-square)](https://travis-ci.org/cerbero90/auth)
[![Latest Version](https://img.shields.io/packagist/v/cerbero/Auth.svg?style=flat-square&label=release)](https://packagist.org/packages/cerbero/auth)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Code Climate](https://img.shields.io/codeclimate/github/cerbero90/Auth.svg?style=flat-square)](https://codeclimate.com/github/cerbero90/auth)
[![Quality Score](https://img.shields.io/scrutinizer/g/cerbero90/auth.svg?style=flat-square)](https://scrutinizer-ci.com/g/cerbero90/auth)
[![Gratipay](https://img.shields.io/gratipay/cerbero.svg?style=flat-square)](https://gratipay.com/cerbero/)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/56fd0fb9-29d9-423a-9cc9-60f00a1b3367/big.png)](https://insight.sensiolabs.com/projects/56fd0fb9-29d9-423a-9cc9-60f00a1b3367)

Auth is a Laravel module to quickly implement the authentication system into your applications, so that you don't have to implement it every time you start a new projects.

By default Laravel has its own command to create an authentication scaffolding, but I don't find it very flexible. That's why I wrote my own authentication system to import it in all my projects and in yours as well if you like it :)

## Features

List of features included in this package:

+ Login
+ Registration
+ Password reset
+ Logout
+ High customization
+ CSRF protection 
+ Honeypot trap

## Install

Run this command in your application root:

```
composer require cerbero/auth
```

Add the service provider to the `providers` list in **config/app.php**:

```php
Cerbero\Auth\AuthServiceProvider::class,
```

Add the following route middleware in **app/Http/Kernel.php**:

```php
'honeypot' => \Cerbero\Auth\Http\Middleware\Honeypot::class,
```

And then run these two commands in your terminal:

```
php artisan vendor:publish --provider="Cerbero\Auth\AuthServiceProvider”
php artisan migrate
```

Now you have the database migrated with the **users** table and can customize the behavior of the authentication system by editing the file **config/_auth.php** as well as modify/translate the messages in **resources/lang/packages**.

Finally, in order to display custom messages to the users, add the `DisplaysExceptions` trait to your exceptions handler:
```
use Cerbero\Auth\Exceptions\DisplaysExceptions;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler {

	use DisplaysExceptions;

	public function render($request, Exception $e)
	{
		if($printable = $this->displayExceptions($e)) return $printable;

		return parent::render($request, $e);
	}

}
```
So now you can display the custom messages in your views:
```
@if ($error = session('error'))
	<div class="alert alert-danger">{{ $error }}</div>
@elseif ($success = session('success'))
	<div class="alert alert-success">{{ $success }}</div>
@endif
```
