<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailResets extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('email_resets', function (Blueprint $table) {
			$table->increments('id');
			$table->string('old_email');
			$table->string('new_email');
			$table->string('password');
			$table->integer('user_id')->unsigned();
			$table->boolean('finished')->unsigned();
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
		Schema::drop('email_resets');
	}
}
