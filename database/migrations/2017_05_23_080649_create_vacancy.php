<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVacancy extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('vacancies', function (Blueprint $table) {
			$table->increments('id');
			$table->string('title');
			$table->string('slug');
			$table->text('text');
			$table->text('img_url');
			$table->integer('views')->unsigned();
			$table->boolean('enabled')->unsigned();
			$table->timestamp('published_at');
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
		Schema::drop('vacancies');
	}
}
