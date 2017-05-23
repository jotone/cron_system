<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserVacancy extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_vacancy', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('phone');
			$table->string('email');
			$table->string('file');
			$table->integer('refer_to_vacancy')->unsigned();
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
		Schema::drop('user_vacancy');
	}
}
