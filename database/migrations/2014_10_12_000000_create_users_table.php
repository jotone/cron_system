<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('email')->unique();
			$table->string('password');
			$table->text('img');
			$table->text('addr');
			$table->string('phone');
			$table->string('org_caption');
			$table->string('org_tid');
			$table->text('address');
			$table->text('correspondence');
			$table->text('history');
			$table->string('role',32);
			$table->boolean('activated')->unsigned();
			$table->text('activation_code');
			$table->text('recovery_token');
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
		Schema::drop('users');
	}
}
