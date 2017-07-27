<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('questions', function (Blueprint $table) {
			$table->increments('id');
			$table->string('user_name');
			$table->string('organisation');
			$table->string('city');
			$table->string('phone',31);
			$table->string('callback_type');
			$table->string('email');
			$table->text('question');
			$table->tinyInteger('status')->unsigned();
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
		Schema::drop('questions');
	}
}
