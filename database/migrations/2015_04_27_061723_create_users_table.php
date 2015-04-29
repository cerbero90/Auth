<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * @author	Andrea Marco Sartori
	 * @var		string	$table	The name of the users table.
	 */
	protected $table;

	/**
	 * Set the name of the users table.
	 *
	 * @author	Andrea Marco Sartori
	 * @return	void
	 */
	public function __construct()
	{
		$this->table = config('_auth.users.table');
	}

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create($this->table, function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('email')->unique();
			$table->string('password', 60);
			$table->string('reset_token', 10)->nullable();
			$table->rememberToken();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop($this->table);
	}

}
